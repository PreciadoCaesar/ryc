<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PurchaseConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $contactName,
        public string $contactEmail,
        public $items,
        public float $total,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '¡Confirmación de compra - R&C Consulting',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.purchase-confirmation',
        );
    }
}
