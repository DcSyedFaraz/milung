<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ProductNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $productDetails;
    public $action;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($productDetails, $action)
    {
        $this->productDetails = $productDetails;
        $this->action = $action;
    }

    /**
     * Get the message envelope.
     */
    public function build()
    {
        $subject = $this->action === 'create' ? 'New Product Created' : 'Product Updated';

        return $this->view('emails.product-notification')
                    ->subject($subject);
    }
}
