<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomTestMail extends Mailable
{
    use Queueable, SerializesModels;

    public $customMessage;

    public function __construct($customMessage)
    {
        $this->customMessage = $customMessage;
    }

    public function build()
    {
        return $this->subject('Test Email')
            ->view('emails.passwordReset')
            ->with(['customMessage' => $this->customMessage]);
    }
}
