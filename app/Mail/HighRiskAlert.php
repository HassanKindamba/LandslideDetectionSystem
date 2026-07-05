<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class HighRiskAlert extends Mailable
{
    use Queueable, SerializesModels;

    public $sensorData;

    public function __construct($sensorData)
    {
        $this->sensorData = $sensorData;
    }

    public function build()
    {
        return $this->subject('🚨 ALERT: High Landslide Risk Detected')
                    ->view('emails.high-risk-alert');
    }
}