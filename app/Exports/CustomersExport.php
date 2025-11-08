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
        // आज बनाए गए customers लाने हैं
        return Customer::with(['sales', 'scheme'])->whereDate('created_at', today())->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Scheme',
            'Phone',
            'Email',
            'Status',
            'Total Sales',
            'Created Date',
        ];
    }

    public function map($customer): array
    {
        return [
            $customer->id,
            $customer->name ?? 'N/A',
            $customer->scheme?->name ?? '-',
            $customer->mobile ?? 'N/A',
            $customer->email ?? 'N/A',
            $customer->is_active ? 'Active' : 'Inactive',
            $customer->sales->count(),
            $customer->created_at ? $customer->created_at->format('d-M-Y') : 'N/A',
        ];
    }
}
