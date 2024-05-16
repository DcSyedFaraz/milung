<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PriceInquiryNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new messages instance.
     */
    public $messages;
    public $sub;

    public function __construct(string $messages,$sub)
    {
        $this->messages = (string) $messages;
        $this->sub = $sub;
    }

    public function build()
    {
        return $this->view('emails.price-inquiry-notification')
                    ->subject($this->sub);
    }
}
