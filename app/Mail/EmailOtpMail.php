<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailOtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public string $name, public string $otp)
    {
    }

    public function build(): self
    {
        return $this->subject('Your ARAUM Hotel verification code')
            ->view('emails.email-otp');
    }
}
