<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $fillable = [];

    public function messages()
    {
        return $this->hasMany(Message::class, 'conversation_id');
    }

    public function participants()
    {
        return $this->hasMany(ConversationParticipant::class);
    }

    public function latestMessage()
    {
        return $this->hasOne(Message::class, 'conversation_id')
                    ->orderByDesc('messageID')
                    ->latestOfMany('messageID');
    }


}
