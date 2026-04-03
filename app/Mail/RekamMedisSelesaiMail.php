<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

use Barryvdh\DomPDF\Facade\Pdf;

class RekamMedisSelesaiMail extends Mailable
{
    public $rekam;

    public function __construct($rekam)
    {
        $this->rekam = $rekam;
    }

    public function build()
    {
        // ✅ Generate PDF
        $pdf = Pdf::loadView('rekam_medis.export_pasien_pdf', [
            'rekam' => $this->rekam
        ]);

        return $this->subject('Hasil Rekam Medis Anda')
            ->view('emails.rekam_medis_selesai')
            ->attachData(
                $pdf->output(),
                'rekam-medis-' . $this->rekam->kode_rekam_medis . '.pdf'
            );
    }
}
