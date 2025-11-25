<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Alumni;
use App\Models\Raffle;

class RaffleWinnerMail extends Mailable
{
    use Queueable, SerializesModels;

    public $alumni;
    public $raffle;

    /**
     * Create a new message instance.
     */
    public function __construct(Alumni $alumni, Raffle $raffle)
    {
        $this->alumni = $alumni;
        $this->raffle = $raffle;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('🎉 You Won the Raffle!')
                    ->view('emails.raffle_winner');
    }
}
