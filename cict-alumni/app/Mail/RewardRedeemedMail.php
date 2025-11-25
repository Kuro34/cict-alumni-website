<?php

namespace App\Mail;

use App\Models\Reward;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RewardRedeemedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $reward;

    /**
     * Create a new message instance.
     */
    public function __construct(Reward $reward)
    {
        $this->reward = $reward;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Reward Redemption Confirmation')
                    ->markdown('emails.rewards.redeemed');
    }
}
