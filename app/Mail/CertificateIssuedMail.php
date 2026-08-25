<?php

namespace App\Mail;

use App\Models\Certificate;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CertificateIssuedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $certificate;

    public function __construct(Certificate $certificate)
    {
        $this->certificate = $certificate;
    }

    public function build()
    {
        return $this->subject('Your Umera Business School Certificate is Ready')
                    ->view('emails.certificate_issued');
    }
}
