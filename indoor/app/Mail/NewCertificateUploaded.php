<?php

namespace App\Mail;

use App\Models\File;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewCertificateUploaded extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $user;

    public $file;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, File $file)
    {
        $this->user = $user;
        $this->file = $file;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Certificate Uploaded',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.provider.newCertificateUploaded',
            with: [
                'user' => $this->user,
                'file' => $this->file,
                'url' => url('storage/'.$this->file->path),
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
