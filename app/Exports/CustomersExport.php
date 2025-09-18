<?php

namespace App\Exports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CustomersExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Customer::with('sales', 'scheme')->whereDate('created_at', today())->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Phone',
            'Email',
            'Status',
            'Total Sales',
            'Created Date'
        ];
    }

    public function map($customer): array
    {
        return [
            $customer->id,
            $customer->name,
            $customer->scheme?->name ?? 'Not Provided',
            $customer->phone,
            $customer->email,
            ucfirst($customer->status),
            $customer->sales->count(),
            $customer->created_at->format('d-M-Y'),
        ];
    }
}