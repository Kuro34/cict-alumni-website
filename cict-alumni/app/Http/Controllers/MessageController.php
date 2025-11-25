<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\Admin;
use App\Models\Alumni;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * List all conversations for the logged-in user (alumni or admin)
     */
    public function chatList(Request $request)
    {
        // Determine current user
        $user = auth('alumni')->check() ? auth('alumni')->user() : auth('admin')->user();
        $userType = auth('alumni')->check() ? 'alumni' : 'admin';
        $search = $request->input('search');

        $conversations = Conversation::whereHas('participants', function ($query) use ($user, $userType) {
            $query->where('participant_id', $user->alumniID ?? $user->adminID)
                  ->where('participant_type', $userType);
        })->with(['latestMessage', 'participants'])->get();

        $chatList = [];

        foreach ($conversations as $conversation) {
            // Get the other participant
            $other = $conversation->participants->first(function ($p) use ($user, $userType) {
                return !($p->participant_type === $userType && $p->participant_id == ($user->alumniID ?? $user->adminID));
            });

            if (!$other) continue;

            $otherName = $this->getParticipantName($other);

            if ($search && stripos($otherName, $search) === false) {
                continue;
            }

            $chatList[] = [
                'id' => $conversation->id,
                'recipient_name' => $otherName,
                'last_message' => $conversation->latestMessage->message ?? '',
            ];
        }

        return response()->json($chatList);
    }

    /**
     * Fetch messages of a conversation
     */
    public function fetchConversation($id)
    {
        $user = auth('alumni')->check() ? auth('alumni')->user() : auth('admin')->user();
        $userType = auth('alumni')->check() ? 'alumni' : 'admin';

        $conversation = Conversation::with(['messages', 'participants'])->findOrFail($id);

        // Find the other participant
        $other = $conversation->participants->first(function ($p) use ($user, $userType) {
            return !($p->participant_type === $userType && $p->participant_id == ($user->alumniID ?? $user->adminID));
        });

        if (!$other) {
            return response()->json([
                'recipient_name' => 'Unknown',
                'partner_id' => null,
                'partner_type' => null,
                'messages' => []
            ]);
        }

        return response()->json([
            'recipient_name' => $this->getParticipantName($other),
            'partner_id' => $other->participant_id,
            'partner_type' => $other->participant_type,
            'messages' => $conversation->messages->map(function($m) {
                return [
                    'id' => $m->id,
                    'message' => $m->message,
                    'sender_id' => $m->sender_id,
                    'sender_type' => $m->sender_type,
                    'created_at' => $m->created_at->toDateTimeString(),
                ];
            }),
        ]);
    }

    /**
     * Send a message in a conversation
     */
    public function sendMessage(Request $request, $id)
    {
        $user = auth('alumni')->check() ? auth('alumni')->user() : auth('admin')->user();
        $userType = auth('alumni')->check() ? 'alumni' : 'admin';

        $validated = $request->validate([
            'recipient_id' => 'required|integer',
            'recipient_type' => 'required|string',
            'message' => 'required|string',
        ]);

        $message = Message::create([
            'conversation_id' => $id,
            'sender_id' => $user->alumniID ?? $user->adminID,
            'sender_type' => $userType,
            'recipient_id' => $validated['recipient_id'],
            'recipient_type' => $validated['recipient_type'],
            'message' => $validated['message'],
        ]);

        return response()->json(['success' => true, 'message' => $message]);
    }

    /**
     * Search users (admins and alumni)
     */
    public function searchUsers(Request $request)
    {
        $q = $request->input('q');

        $alumniMatches = Alumni::where(function ($query) use ($q) {
            $query->where('first_name', 'like', "%$q%")
                  ->orWhere('last_name', 'like', "%$q%")
                  ->orWhere('email', 'like', "%$q%");
        })->get()->map(function ($alumni) {
            return [
                'id' => $alumni->alumniID,
                'name' => $alumni->first_name . ' ' . $alumni->last_name,
                'type' => 'alumni',
            ];
        });

        $adminMatches = Admin::where('name', 'like', "%$q%")
            ->orWhere('email', 'like', "%$q%")
            ->get()->map(function ($admin) {
                return [
                    'id' => $admin->adminID,
                    'name' => $admin->name,
                    'type' => 'admin',
                ];
            });

        return response()->json($alumniMatches->merge($adminMatches));
    }

    /**
     * Start a new conversation or return existing between two users
     */
    public function startConversation(Request $request)
    {
        $user = auth('alumni')->check() ? auth('alumni')->user() : auth('admin')->user();
        $userType = auth('alumni')->check() ? 'alumni' : 'admin';
        $recipientId = $request->input('recipient_id');
        $recipientType = $request->input('recipient_type');

        // Ensure recipient exists
        if ($recipientType === 'alumni') {
            $recipient = Alumni::find($recipientId);
        } else {
            $recipient = Admin::find($recipientId);
        }

        if (!$recipient) {
            return response()->json(['error' => 'Recipient not found'], 404);
        }

        // Find existing conversation
        $existing = Conversation::whereHas('participants', function ($q) use ($user, $userType) {
            $q->where('participant_id', $user->alumniID ?? $user->adminID)
              ->where('participant_type', $userType);
        })->whereHas('participants', function ($q) use ($recipientId, $recipientType) {
            $q->where('participant_id', $recipientId)
              ->where('participant_type', $recipientType);
        })->first();

        if ($existing) {
            return response()->json([
                'id' => $existing->id,
                'messages' => [],
            ]);
        }

        // Create new conversation
        $conversation = Conversation::create();

        $conversation->participants()->createMany([
            [
                'participant_id' => $user->alumniID ?? $user->adminID,
                'participant_type' => $userType,
            ],
            [
                'participant_id' => $recipientId,
                'participant_type' => $recipientType,
            ],
        ]);

        return response()->json([
            'id' => $conversation->id,
            'messages' => [],
        ]);
    }

    /**
     * Helper: Get participant's full name
     */
    private function getParticipantName($participant)
    {
        if ($participant->participant_type === 'admin') {
            $admin = Admin::find($participant->participant_id);
            return $admin ? $admin->name : 'Unknown Admin';
        } elseif ($participant->participant_type === 'alumni') {
            $alumni = Alumni::find($participant->participant_id);
            return $alumni ? $alumni->first_name . ' ' . $alumni->last_name : 'Unknown Alumni';
        }
        return 'Unknown';
    }
}
