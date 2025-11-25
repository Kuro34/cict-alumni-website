<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcastNow
{
    use InteractsWithSockets, SerializesModels;

    public $message;
    public $recipientType;
    public $recipientID;

    public function __construct(Message $message, $recipientType, $recipientID)
    {
        $this->message = $message;
        $this->recipientType = $recipientType;
        $this->recipientID = $recipientID;
    }

    public function broadcastOn()
    {
        if ($this->recipientType === 'admin') {
            return new PrivateChannel('chat.admin.' . $this->recipientID);
        } else {
            return new PrivateChannel('chat.alumni.' . $this->recipientID);
        }
    }

    public function broadcastAs()
    {
        return 'message.sent';
    }
}
