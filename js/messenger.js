let chatData = [];
let conversationCache = {}; // { conversationId: { messages: [], lastMessageId: 0, scrollAtBottom: true } }
window.currentConversationId = null;
let currentEchoChannel = null;

// ------------------- Laravel Echo -------------------
import Echo from 'laravel-echo';
window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    encrypted: true,
});

// ------------------- Chat List -------------------
function loadChatList(searchQuery = "") {
    axios.get("/messages/list", {
        params: { search: searchQuery },
        headers: { "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content }
    }).then(response => {
        chatData = response.data || [];
        renderChatList(chatData);
    }).catch(() => {
        document.getElementById("chatList").innerHTML = "<p>Error loading conversations</p>";
    });
}

function renderChatList(list) {
    const chatList = document.getElementById("chatList");
    chatList.innerHTML = "";
    if (!list || list.length === 0) {
        chatList.innerHTML = "<p>No conversations found</p>";
        return;
    }

    const fragment = document.createDocumentFragment();
    list.forEach(conversation => {
        const chatItem = document.createElement("div");
        chatItem.className = "chat-list-item";
        chatItem.innerHTML = `
            <div>${conversation.recipient_name}</div>
            <small>${conversation.last_message || "No messages yet"}</small>
        `;
        chatItem.addEventListener("click", () => openConversation(conversation.id, conversation.recipient_type, conversation.recipient_id));
        fragment.appendChild(chatItem);
    });
    chatList.appendChild(fragment);
}

function setupChatSearch() {
    const searchInput = document.getElementById("chatSearchInput");
    if (!searchInput) return;

    searchInput.addEventListener("input", function () {
        const term = this.value.toLowerCase();
        const filtered = chatData.filter(c => c.recipient_name.toLowerCase().includes(term));
        renderChatList(filtered);
    });
}

// ------------------- Conversation -------------------
function openConversation(conversationId, partnerType, partnerID) {
    document.getElementById("chatPopup").style.display = "none";
    document.getElementById("newChatPopup").style.display = "none";
    document.getElementById("conversationPopup").style.display = "flex";

    window.currentConversationId = conversationId;

    if (!conversationCache[conversationId]) {
        conversationCache[conversationId] = { messages: [], lastMessageId: 0, scrollAtBottom: true };
    }

    unsubscribeAllChannels();

    const state = conversationCache[conversationId];

    // Render cached messages immediately to prevent flicker
    renderConversationFromCache(conversationId, partnerType, partnerID);

    // Fetch new messages in the background
    fetchMessages(conversationId, partnerType, partnerID);

    subscribeToConversation(conversationId, partnerType, partnerID);
}

function renderConversationFromCache(conversationId, partnerType, partnerID) {
    const state = conversationCache[conversationId];
    const conversationBody = document.getElementById("conversationBody");
    conversationBody.innerHTML = "";
    conversationBody.setAttribute("data-partner-id", partnerID);
    conversationBody.setAttribute("data-partner-type", partnerType);

    const title = chatData.find(c => c.id === conversationId)?.recipient_name || "Chat";
    document.getElementById("conversationTitle").textContent = title;

    state.messages.forEach(msg => appendMessageToDOM(msg, conversationBody, conversationId, false));

    if (state.scrollAtBottom) conversationBody.scrollTop = conversationBody.scrollHeight;
}

function fetchMessages(conversationId, partnerType, partnerID) {
    const state = conversationCache[conversationId];

    axios.get(`/messages/conversation/${conversationId}`, {
        headers: { "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content }
    }).then(response => {
        const data = response.data;
        const conversationBody = document.getElementById("conversationBody");
        conversationBody.setAttribute("data-partner-id", partnerID);
        conversationBody.setAttribute("data-partner-type", partnerType);
        document.getElementById("conversationTitle").textContent = data.recipient_name || "Chat";

        if (!data.messages || data.messages.length === 0) return;

        // Only append new messages that are not in cache
        data.messages.forEach(message => {
            if (!state.messages.some(m => m.id === message.id)) {
                appendMessageToDOM(message, conversationBody, conversationId, state.scrollAtBottom);
                state.lastMessageId = Math.max(state.lastMessageId, message.id);
            }
        });

        state.messages = Array.from(new Set([...state.messages, ...data.messages])); // update cache
    }).catch(() => {
        console.error("Error fetching messages");
    });
}

function appendMessageToDOM(message, container, conversationId, scroll = true) {
    requestAnimationFrame(() => {
        const messageDiv = document.createElement("div");
        messageDiv.className = message.sender_id === CURRENT_USER_ID ? "message-sent" : "message-received";
        messageDiv.innerHTML = `
            <p>${message.message}</p>
            <small>${new Date(message.created_at).toLocaleString()}</small>
        `;
        container.appendChild(messageDiv);

        const state = conversationCache[conversationId];
        if (!state.messages.some(m => m.id === message.id)) state.messages.push(message);

        if (scroll && window.currentConversationId === conversationId && state.scrollAtBottom) {
            container.scrollTop = container.scrollHeight;
        }
    });
}

// ------------------- Send Message -------------------
function sendMessage() {
    const messageInput = document.getElementById("messageInput");
    const content = messageInput.value.trim();
    if (!content) return;

    const conversationBody = document.getElementById("conversationBody");
    const conversationId = window.currentConversationId;
    const partnerID = conversationBody.getAttribute("data-partner-id");
    const partnerType = conversationBody.getAttribute("data-partner-type");

    axios.post(`/messages/conversation/${conversationId}/send`, {
        recipient_id: partnerID,
        recipient_type: partnerType,
        message: content
    }, {
        headers: { "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content }
    }).then(response => {
        const messageData = {
            id: response.data.message.id || Date.now(),
            sender_id: CURRENT_USER_ID,
            message: content,
            created_at: new Date()
        };
        appendMessageToDOM(messageData, conversationBody, conversationId);
        conversationCache[conversationId].lastMessageId = Math.max(conversationCache[conversationId].lastMessageId, messageData.id);
        messageInput.value = "";
    }).catch(err => {
        console.error("Error sending message:", err);
        alert("Failed to send message");
    });
}

// ------------------- Real-time Subscription -------------------
function subscribeToConversation(conversationId, partnerType, partnerID) {
    if (!window.Echo) return;

    const channelName = partnerType === 'admin' ? `chat.admin.${partnerID}` : `chat.alumni.${partnerID}`;

    if (currentEchoChannel) window.Echo.leaveChannel(currentEchoChannel);
    currentEchoChannel = `private-${channelName}`;

    window.Echo.private(channelName).listen('.message.sent', (e) => {
        const convId = e.message.conversation_id;
        if (!conversationCache[convId]) return;

        const state = conversationCache[convId];
        if (!state.messages.some(m => m.id === e.message.id)) {
            state.messages.push(e.message);

            if (window.currentConversationId === convId) {
                const container = document.getElementById("conversationBody");
                appendMessageToDOM(e.message, container, convId, true);
                state.lastMessageId = Math.max(state.lastMessageId, e.message.id);
            }
        }
    });
}

function unsubscribeAllChannels() {
    if (!window.Echo || !window.Echo.connector.channels) return;
    Object.keys(window.Echo.connector.channels).forEach(channel => window.Echo.leave(channel));
}

// ------------------- New Chat -------------------
function openConversationWithUser(user) {
    closeNewChat();
    window.currentConversationId = null;

    axios.post("/messages/start-conversation", {
        recipient_id: user.id,
        recipient_type: user.type,
    }, {
        headers: { "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content }
    }).then(response => {
        const conversationId = response.data.id;
        window.currentConversationId = conversationId;

        if (!conversationCache[conversationId]) {
            conversationCache[conversationId] = { lastMessageId: 0, scrollAtBottom: true, messages: [] };
        }

        const conversationBody = document.getElementById("conversationBody");
        conversationBody.innerHTML = "<p>Loading messages...</p>";
        document.getElementById("conversationPopup").style.display = "flex";

        fetchMessages(conversationId, user.type, user.id);
        document.getElementById("conversationTitle").textContent = user.name;
    }).catch(err => {
        console.error("Error creating/fetching conversation", err);
        alert("Failed to start conversation");
    });
}

// ------------------- Search Users for New Chat -------------------
document.getElementById("newChatSearchInput").addEventListener("input", function () {
    clearTimeout(window.newChatSearchTimeout);
    const query = this.value.trim();

    window.newChatSearchTimeout = setTimeout(() => {
        if (query.length < 2) {
            document.getElementById("newChatResults").innerHTML = "<p>Type at least 2 characters to search</p>";
            return;
        }

        axios.get("/messages/search-users", {
            params: { q: query },
            headers: { "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content },
        }).then(response => {
            const container = document.getElementById("newChatResults");
            container.innerHTML = "";

            if (!response.data || response.data.length === 0) {
                container.innerHTML = "<p>No users found</p>";
                return;
            }

            const fragment = document.createDocumentFragment();
            response.data.forEach(user => {
                const userDiv = document.createElement("div");
                userDiv.className = "chat-list-item";
                userDiv.textContent = `${user.name} (${user.type})`;
                userDiv.style.cursor = "pointer";
                userDiv.addEventListener("click", () => openConversationWithUser(user));
                fragment.appendChild(userDiv);
            });
            container.appendChild(fragment);
        }).catch(() => {
            document.getElementById("newChatResults").innerHTML = "<p>Error searching users</p>";
        });
    }, 300);
});

// ------------------- Initialize -------------------
document.addEventListener("DOMContentLoaded", () => {
    loadChatList();
    setupChatSearch();
});
