<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NotifikasiAntrian extends Mailable
{
    use Queueable, SerializesModels;

    public $pasien;

    public function __construct($pasien)
    {
        $this->pasien = $pasien;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nomor Antrian Klinik',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.antrian',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}