<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Customer;

class GenerateCustomerQRCodes extends Command
{
    protected $signature = 'customers:generate-qr';
    protected $description = 'Generate QR codes for customers who do not have one';

    public function handle()
    {
        $customers = Customer::whereNull('qr_code')->get();
        $count = 0;

        foreach ($customers as $customer) {
            // QR में save होने वाला data
            $qrData = [
                'name' => $customer->name,
                'mobile' => $customer->mobile,
                'email' => $customer->email ?? 'Not Provided',
                'token' => $customer->token,
                'scheme' => $customer->scheme,
                'mtoken' => $customer->mtoken,
                'use' => 'Verification / Check-in / Order Reference',
                'payment_status' => $customer->payment_status,
                'payment_link' => $customer->payment_link,
            ];

            // QuickChart QR
            $qrUrl = "https://quickchart.io/qr?text=" . urlencode(json_encode($qrData)) . "&size=200";

            $customer->qr_code = $qrUrl;
            $customer->save();

            $this->info("✅ QR generated for Customer ID: {$customer->id}");
            $count++;
        }

        $this->info("🎉 Total {$count} QR codes generated.");
    }
}
