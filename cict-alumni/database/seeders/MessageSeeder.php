<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Conversation;
use App\Models\Message;

class MessageSeeder extends Seeder
{
    public function run(): void
    {
        $conversation = Conversation::create();

        for ($i = 1; $i <= 5; $i++) {
            Message::create([
                'conversation_id' => $conversation->id,
                'sender_id' => 1,
                'sender_type' => 'App\Models\Admin',
                'recipient_id' => 1,
                'recipient_type' => 'App\Models\Alumni',
                'message' => 'Hello, this is message #' . $i,
            ]);
        }
    }
}
