<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PriceInquiryQuoteMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $messages;

    public function __construct(string $messages)
    {
        $this->messages = (string) $messages;
    }

    /**
     * Get the message envelope.
     */
    public function build()
    {
        return $this->view('emails.price-inquiry-quote-mail')
                    ->subject('Price Inquiry Quote');
    }
}
