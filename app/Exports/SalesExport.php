<?php

namespace App\Exports;

use App\Models\Sale;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SalesExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Sale::with('customer')->whereDate('sale_date', today())->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Customer',
            'Product',
            'Amount',
            'Sale Date',
            'Status'
        ];
    }

    public function map($sale): array
    {
        return [
            $sale->id,
            $sale->customer->name,
            $sale->product_name,
            '₹' . $sale->amount,
            $sale->sale_date->format('d-M-Y'),
            ucfirst($sale->status),
        ];
    }
}