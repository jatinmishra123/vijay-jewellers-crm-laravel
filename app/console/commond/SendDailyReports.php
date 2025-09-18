<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\ExportController;

class SendDailyReports extends Command
{
    protected $signature = 'reports:daily';
    protected $description = 'Send daily reports via email and WhatsApp';

    public function handle()
    {
        $exportController = new ExportController();

        // Send reports for each type
        $types = ['customers', 'sales', 'payments'];

        foreach ($types as $type) {
            // Send email report
            $exportController->sendEmailReport($type);
            $this->info("Daily {$type} email report sent.");

            // Send WhatsApp report
            $exportController->sendWhatsAppReport($type);
            $this->info("Daily {$type} WhatsApp report sent.");
        }

        $this->info('All daily reports sent successfully.');
        return 0;
    }
}