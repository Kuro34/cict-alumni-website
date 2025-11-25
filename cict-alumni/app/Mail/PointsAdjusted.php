<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PointsAdjusted extends Mailable
{
    use Queueable, SerializesModels;

    public $alumni;
    public $pointsChanged;
    public $reason;
    public $newTotal;

    public function __construct($alumni, $pointsChanged, $reason, $newTotal)
    {
        $this->alumni = $alumni;
        $this->pointsChanged = $pointsChanged;
        $this->reason = $reason;
        $this->newTotal = $newTotal;
    }

    public function build()
    {
        return $this->subject('Your Alumni Points Have Been Adjusted')
                    ->view('emails.points-adjusted');
    }
}
