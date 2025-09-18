<?php
namespace App\Exports;

use App\Models\Payment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PaymentsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Payment::with(['customer', 'sale'])->get()->map(function ($p) {
            return [
                'ID' => $p->id,
                'Customer Name' => $p->customer->name ?? '-',
                'Customer Email' => $p->customer->email ?? '-',
                'Sale Product' => $p->sale->product_name ?? '-',
                'Sale Amount' => $p->sale->amount ?? 0,
                'Payment Amount' => $p->amount,
                'Payment Date' => $p->payment_date,
                'Method' => $p->method,
                'Status' => $p->status,
                'Created At' => $p->created_at,
                'Updated At' => $p->updated_at,
            ];
        });
    }

    public function headings(): array
    {
        return ['ID', 'Customer Name', 'Customer Email', 'Sale Product', 'Sale Amount', 'Payment Amount', 'Payment Date', 'Method', 'Status', 'Created At', 'Updated At'];
    }
}
