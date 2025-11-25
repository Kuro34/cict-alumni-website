let chatData = [];
let messagePollingInterval = null;


function loadChatList(searchQuery = "") {
    axios
        .get("/messages/list", {
            params: { search: searchQuery },
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
            },
        })
        .then((response) => {
            const chatList = document.getElementById("chatList");
            chatList.innerHTML = "";

            if (!response.data.length) {
                chatList.innerHTML = "<p>No conversations found</p>";
                return;
            }

            chatData = response.data;

            chatData.forEach((conversation) => {
                const chatItem = document.createElement("div");
                chatItem.className = "chat-list-item";
                chatItem.innerHTML = `
                    <div>${conversation.recipient_name}</div>
                    <small>${conversation.last_message || "No messages yet"}</small>
                `;
                chatItem.addEventListener("click", () => {
                    openConversation(conversation.id);
                });
                chatList.appendChild(chatItem);
            });

            setupSearch();
        })
        .catch(() => {
            document.getElementById("chatList").innerHTML = "<p>Error loading conversations</p>";
        });
}

function setupSearch() {
    const searchInput = document.getElementById("chatSearchInput");

    searchInput.addEventListener("input", function () {
        const term = this.value.toLowerCase();
        const filtered = chatData.filter((c) =>
            c.recipient_name.toLowerCase().includes(term)
        );
        renderChatList(filtered);
    });
}

function renderChatList(filtered) {
    const chatList = document.getElementById("chatList");
    chatList.innerHTML = "";

    if (!filtered.length) {
        chatList.innerHTML = "<p>No conversations found</p>";
        return;
    }

    filtered.forEach((conversation) => {
        const chatItem = document.createElement("div");
        chatItem.className = "chat-list-item";
        chatItem.innerHTML = `
            <div>${conversation.recipient_name}</div>
            <small>${conversation.last_message || "No messages yet"}</small>
        `;
        chatItem.addEventListener("click", () => {
            openConversation(conversation.id);
        });
        chatList.appendChild(chatItem);
    });
}

function openConversation(conversationId) {
    document.getElementById("chatPopup").style.display = "none";
    document.getElementById("newChatPopup").style.display = "none";
    document.getElementById("conversationPopup").style.display = "flex";

    axios
        .get(`/messages/conversation/${conversationId}`, {
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
            },
        })
        .then((response) => {
            window.currentConversationId = conversationId;

            const conversationBody = document.getElementById("conversationBody");
            const conversationTitle = document.getElementById("conversationTitle");
            conversationTitle.textContent = response.data.recipient_name || "Chat";
            conversationBody.innerHTML = "";

            // ✅ Set attributes for sending message
            conversationBody.setAttribute("data-partner-id", response.data.partner_id);
            conversationBody.setAttribute("data-partner-type", response.data.partner_type);

            if (!response.data.messages?.length) {
                conversationBody.innerHTML = "<p>No messages yet. Say hi!</p>";
                return;
            }

            response.data.messages.forEach((message) => {
                const messageDiv = document.createElement("div");
                messageDiv.className = message.sender_id === CURRENT_USER_ID ? "message-sent" : "message-received";
                messageDiv.innerHTML = `
                    <p>${message.message}</p>
                    <small>${new Date(message.created_at).toLocaleString()}</small>
                `;
                conversationBody.appendChild(messageDiv);
            });

            conversationBody.scrollTop = conversationBody.scrollHeight;
        if (messagePollingInterval) clearInterval(messagePollingInterval);

        messagePollingInterval = setInterval(() => {
            refreshMessages(conversationId);
        }, 5000);

        })
        .catch(() => {
            document.getElementById("conversationBody").innerHTML = "<p>Error loading messages</p>";
        });
}
    function refreshMessages(conversationId) {
        axios
            .get(`/messages/conversation/${conversationId}`, {
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                },
            })
            .then((response) => {
                const conversationBody = document.getElementById("conversationBody");
                if (!response.data.messages?.length) return;

                conversationBody.innerHTML = "";

                response.data.messages.forEach((message) => {
                    const messageDiv = document.createElement("div");
                    messageDiv.className = message.sender_id === CURRENT_USER_ID ? "message-sent" : "message-received";
                    messageDiv.innerHTML = `
                        <p>${message.message}</p>
                        <small>${new Date(message.created_at).toLocaleString()}</small>
                    `;
                    conversationBody.appendChild(messageDiv);
                });

                conversationBody.scrollTop = conversationBody.scrollHeight;
            })
            .catch(() => {
                console.warn("Message refresh failed");
            });
    }


function sendMessage() {
    const messageInput = document.getElementById("messageInput");
    const content = messageInput.value.trim();
    if (content === "") return;

    const conversationId = window.currentConversationId;
    const partnerID = document.getElementById("conversationBody").getAttribute("data-partner-id");
    const partnerType = document.getElementById("conversationBody").getAttribute("data-partner-type");

    axios
        .post(`/messages/conversation/${conversationId}/send`, {
            recipient_id: partnerID,
            recipient_type: partnerType,
            message: content,
        }, {
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
            },
        })
        .then(() => {
            const conversationBody = document.getElementById("conversationBody");
            const messageDiv = document.createElement("div");
            messageDiv.className = "message-sent";
            messageDiv.innerHTML = `
                <p>${content}</p>
                <small>${new Date().toLocaleString()}</small>
            `;
            conversationBody.appendChild(messageDiv);
            conversationBody.scrollTop = conversationBody.scrollHeight;
            messageInput.value = "";
        })
        .catch((error) => {
            console.error("Error sending message:", error);
            alert("Failed to send message");
        });
}

function openConversationWithUser(user) {
    closeNewChat(); // Hide the new chat popup

    axios.post("/messages/start-conversation", {
        recipient_id: user.id,
        recipient_type: user.type,
    }, {
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then((response) => {
        const conversationId = response.data.id;
        window.currentConversationId = conversationId;

        document.getElementById("conversationTitle").textContent = user.name;
        const conversationBody = document.getElementById("conversationBody");
        conversationBody.innerHTML = "<p>Loading messages...</p>";
        document.getElementById("conversationPopup").style.display = "flex";

        loadConversationById(conversationId);
    })
    .catch((err) => {
        console.error("Error creating/fetching conversation", err);
        alert("Failed to start conversation");
    });
}

function loadConversationById(conversationId) {
    window.currentConversationId = conversationId;

    axios
        .get(`/messages/conversation/${conversationId}`, {
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then((response) => {
            const conversationBody = document.getElementById("conversationBody");
            const conversationTitle = document.getElementById("conversationTitle");
            conversationTitle.textContent = response.data.recipient_name || "Chat";
            conversationBody.innerHTML = "";

            // ✅ Set attributes for sending message
            conversationBody.setAttribute("data-partner-id", response.data.partner_id);
            conversationBody.setAttribute("data-partner-type", response.data.partner_type);

            if (!response.data.messages || response.data.messages.length === 0) {
                conversationBody.innerHTML = "<p>No messages yet. Say hi!</p>";
                return;
            }

            response.data.messages.forEach((message) => {
                const messageDiv = document.createElement("div");
                messageDiv.className = message.sender_id === CURRENT_USER_ID ? "message-sent" : "message-received";
                messageDiv.innerHTML = `
                    <p>${message.message}</p>
                    <small>${new Date(message.created_at).toLocaleString()}</small>
                `;
                conversationBody.appendChild(messageDiv);
            });

            conversationBody.scrollTop = conversationBody.scrollHeight;
        })
        .catch((error) => {
            console.error("Error loading conversation:", error);
            document.getElementById("conversationBody").innerHTML =
                "<p>Error loading messages</p>";
        });
}

// Search in new chat popup
document.getElementById("newChatSearchInput").addEventListener("input", function (e) {
    clearTimeout(window.newChatSearchTimeout);
    const query = e.target.value.trim();

    window.newChatSearchTimeout = setTimeout(() => {
        if (query.length < 2) {
            document.getElementById("newChatResults").innerHTML = "<p>Type at least 2 characters to search</p>";
            return;
        }

        axios
            .get("/messages/search-users", {
                params: { q: query },
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                },
            })
            .then((response) => {
                const container = document.getElementById("newChatResults");
                container.innerHTML = "";

                if (!response.data.length) {
                    container.innerHTML = "<p>No users found</p>";
                    return;
                }

                response.data.forEach((user) => {
                    const userDiv = document.createElement("div");
                    userDiv.className = "chat-list-item";
                    userDiv.textContent = `${user.name} (${user.type})`;
                    userDiv.style.cursor = "pointer";
                    userDiv.addEventListener("click", () => openConversationWithUser(user));
                    container.appendChild(userDiv);
                });
            })
            .catch(() => {
                document.getElementById("newChatResults").innerHTML = "<p>Error searching users</p>";
            });
    }, 300);
});

document.addEventListener("DOMContentLoaded", () => {
    loadChatList();
});


