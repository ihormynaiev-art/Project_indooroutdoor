<?php

namespace App\Mail;

use App\Models\RequestQuote;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RequestQuoteInformation extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(private RequestQuote $requestQuote)
    {
        $requestQuote->load('category', 'subCategory');
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Request Quote',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.messages.requestQuoteInformation',
            with: [
                'homeownerName' => $this->requestQuote->full_name,
                'email' => $this->requestQuote->email,
                'contactNumber' => $this->requestQuote->contact_number,
                'city' => $this->requestQuote->city,
                'state' => $this->requestQuote->state,
                'details' => $this->requestQuote->details,
                'category' => $this->requestQuote->category->name,
                'subCategory' => $this->requestQuote->subCategory->name,
            ],
        );
    }
}
