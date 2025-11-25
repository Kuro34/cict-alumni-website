<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Reward;

class RaffleEntryMail extends Mailable
{
    use Queueable, SerializesModels;

    public $reward;
    public $raffleTitle;

    /**
     * Create a new message instance.
     *
     * @param Reward $reward
     */
    public function __construct(Reward $reward)
    {
        $this->reward = $reward;

        // Automatically get the raffle title from the related raffle
        $this->raffleTitle = $reward->raffle ? $reward->raffle->title : 'Unknown Raffle';
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("Raffle Entry Confirmation: {$this->raffleTitle}")
                    ->view('emails.raffle_entry');
    }
}
