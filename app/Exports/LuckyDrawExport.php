<?php

namespace App\Exports;

use App\Models\LuckyDraw;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LuckyDrawExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return LuckyDraw::with(['customer', 'scheme', 'schemePayment'])->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Customer',
            'Scheme',
            'Payment ID',
            'Coupon Code',
            'Lucky Draw Amount',
            'Status',
            'Created At',
            'Updated At'
        ];
    }

    public function map($luckyDraw): array
    {
        return [
            $luckyDraw->id,
            $luckyDraw->customer?->name ?? '-',
            $luckyDraw->scheme?->name ?? '-',
            $luckyDraw->scheme_payment_id ?? '-',
            $luckyDraw->coupon_code,
            $luckyDraw->lucky_draw_amount,
            ucfirst($luckyDraw->status),
            $luckyDraw->created_at->format('d-M-Y H:i'),
            $luckyDraw->updated_at->format('d-M-Y H:i')
        ];
    }
}
