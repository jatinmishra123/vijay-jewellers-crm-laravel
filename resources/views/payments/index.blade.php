@extends('admin.layouts.app')

@section('title', 'Dashboard - Vijay Jewellers')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

@section('content')
    <div class="container-fluid">
        <!-- Page Title -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0 fs-5 mt-3">Payment Management</h4>
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>

            </div>

        </div>

        <!-- Statistics Cards -->
        <div class="row g-3 mb-3">
            @php
                $cards = [
                    ['title' => 'Transactions', 'count' => $summary['total_today'], 'icon' => 'bi-bag-fill', 'bg' => 'linear-gradient(135deg,#4e73df,#224abe)'],
                    ['title' => 'Successful', 'count' => $summary['successful'], 'icon' => 'bi-check-circle-fill', 'bg' => 'linear-gradient(135deg,#1cc88a,#17a673)'],
                    ['title' => 'Failed', 'count' => $summary['failed'], 'icon' => 'bi-x-circle-fill', 'bg' => 'linear-gradient(135deg,#e74a3b,#c82333)'],
                    ['title' => 'Pending', 'count' => $summary['pending'], 'icon' => 'bi-clock-fill', 'bg' => 'linear-gradient(135deg,#f6c23e,#dda20a)']
                ];
            @endphp

            @foreach($cards as $card)
                <div class="col-sm-6 col-md-3">
                    <div class="card shadow-sm text-white" style="background: {{ $card['bg'] }}; border-radius:12px;">
                        <div class="card-body text-center py-3">
                            <div class="stat-icon mb-2 mx-auto"
                                style="width:40px;height:40px;background:rgba(255,255,255,0.2);border-radius:50%;display:flex;align-items:center;justify-content:center;">
                                <i class="bi {{ $card['icon'] }} fs-5"></i>
                            </div>
                            <h4 class="mb-0 fs-3">{{ number_format($card['count'] ?? 0) }}</h4>
                            <p class="mb-0 small">{{ $card['title'] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Export / Print Buttons -->
        <div class="d-flex flex-wrap gap-2 mb-4">

            <a href="{{ route('payments.export', ['type' => 'csv']) }}" class="btn btn-success btn-sm">
                <i class="bi bi-file-earmark-spreadsheet-fill"></i> CSV
            </a>
            <a href="{{ route('payments.export', ['type' => 'excel']) }}" class="btn btn-warning btn-sm">
                <i class="bi bi-file-earmark-excel-fill"></i> Excel
            </a>
        </div>

        <!-- Payment Method Chart -->


        <!-- Payments Table -->
        <div class="card shadow-sm">
            <div class="card-body p-3">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover align-middle mb-0">
                        <thead class="table-dark text-center">
                            <tr>
                                <th>ID</th>
                                <th>Customer</th>
                                <th>Email</th>
                                <th>Product</th>
                                <th>Sale Amount</th>
                                <th>Payment Amount</th>
                                <th>Date</th>
                                <th>Method</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @forelse($payments as $payment)
                                <tr>
                                    <td>{{ $payment->id }}</td>
                                    <td>{{ optional($payment->customer)->name ?? '-' }}</td>
                                    <td>{{ optional($payment->customer)->email ?? '-' }}</td>
                                    <td>{{ optional($payment->sale)->product_name ?? '-' }}</td>
                                    <td class="text-end">
                                        {{ optional($payment->sale)->amount ? number_format($payment->sale->amount, 2) : '0.00' }}
                                    </td>
                                    <td class="text-end">{{ number_format($payment->amount, 2) }}</td>
                                    <td>{{ optional($payment->payment_date)->format('d-m-Y') ?? '-' }}</td>
                                    <td>{{ $payment->method ?? '-' }}</td>
                                    <td>
                                        @php $status = $payment->status ?? 'Unknown'; @endphp
                                        <span
                                            class="badge {{ $status == 'Successful' ? 'bg-success' : ($status == 'Failed' ? 'bg-danger' : ($status == 'Pending' ? 'bg-warning text-dark' : 'bg-secondary')) }}">
                                            {{ $status }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-muted">No payments found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('styles')
    <style>
        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            transition: all 0.2s;
        }

        .stat-icon {
            font-size: 1.2rem;
        }

        .table th,
        .table td {
            padding: 0.5rem;
            font-size: 0.875rem;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('paymentChart').getContext('2d');
        const paymentData = {
            labels: @json(array_keys($summary['by_method'])),
            datasets: [{
                label: 'Payments',
                data: @json(array_values($summary['by_method'])),
                backgroundColor: ['#4e73df', '#1cc88a', '#f6c23e', '#858796'],
                borderColor: '#fff', borderWidth: 2
            }]
        };
        new Chart(ctx, {
            type: 'doughnut',
            data: paymentData,
            options: { responsive: true, plugins: { legend: { position: 'bottom' }, tooltip: { callbacks: { label: function (context) { return context.label + ': ' + context.raw + ' payments'; } } } } }
        });
    </script>
@endpush