<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $primaryKey = 'messageID';
    protected $fillable = [
        'conversation_id',
        'sender_id',
        'sender_type',
        'recipient_id',
        'recipient_type',
        'message',
        'read_at',
    ];

    public function sender()
    {
        return $this->morphTo();
    }

    public function recipient()
    {
        return $this->morphTo('recipient', 'recipient_type', 'recipient_id');
    }

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }
}
