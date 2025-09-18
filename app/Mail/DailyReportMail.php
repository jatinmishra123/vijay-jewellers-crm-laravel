<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Barryvdh\DomPDF\Facade\Pdf;

class DailyReportMail extends Mailable
{
    use Queueable, SerializesModels;

    public $stats;
    public $recentCustomers;

    public function __construct($stats, $recentCustomers)
    {
        $this->stats = $stats;
        $this->recentCustomers = $recentCustomers;
    }

    public function build()
    {
        return $this->subject('Daily Customer Report - ' . now()->format('F j, Y'))
            ->view('emails.daily-report')
            ->attach($this->generatePdfReport(), [
                'as' => 'daily-report-' . now()->format('Y-m-d') . '.pdf',
                'mime' => 'application/pdf',
            ]);
    }

    private function generatePdfReport()
    {
        $pdf = Pdf::loadView('admin.exports.daily-report-pdf', [
            'stats' => $this->stats,
            'recentCustomers' => $this->recentCustomers
        ]);

        return $pdf->output();
    }
}