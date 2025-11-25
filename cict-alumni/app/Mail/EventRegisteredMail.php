<?php

namespace App\Mail;

use App\Models\Event;
use App\Models\Alumni;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EventRegisteredMail extends Mailable
{
    use Queueable, SerializesModels;

    public $event;
    public $alumni;

    public function __construct(Event $event, Alumni $alumni)
    {
        $this->event = $event;
        $this->alumni = $alumni;
    }

    public function build()
    {
        return $this->subject('Event Registration Confirmation')
                    ->markdown('emails.event.registered');
    }
}
