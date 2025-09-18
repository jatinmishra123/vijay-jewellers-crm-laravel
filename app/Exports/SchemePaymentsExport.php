<?php

namespace App\Exports;

use App\Models\SchemePayment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SchemePaymentsExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return SchemePayment::with(['customer', 'scheme'])->latest()->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Customer Name',
            'Scheme Name',
            'Duration',
            'Amount',
            'Status',
            'Method',
            'Due Date',
            'Paid At',
            'Created At',
        ];
    }

    public function map($payment): array
    {
        return [
            $payment->id,
            $payment->customer?->name ?? '-',
            $payment->scheme?->name ?? '-',
            $payment->payment_duration,
            $payment->amount ? number_format($payment->amount, 2) : '0.00',
            ucfirst($payment->status),
            $payment->method ?? '-',
            $payment->due_date ?? '-',
            $payment->paid_at ?? '-',
            $payment->created_at->format('d-m-Y H:i'),
        ];
    }
}
