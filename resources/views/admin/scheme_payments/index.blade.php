@extends('admin.layouts.app')

@section('title', 'Scheme Payments - Vijay Jewellers')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            transition: all 0.2s;
        }

        /* Moved icon styles from inline to CSS */
        .stat-icon-wrapper {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .stat-icon {
            font-size: 1.2rem;
        }

        table tbody tr:hover {
            background-color: rgba(0, 123, 255, 0.05);
        }

        table th,
        table td {
            padding: 0.6rem 0.75rem;
            font-size: 0.875rem;
            vertical-align: middle;
        }

        .btn-outline-danger:hover {
            color: #fff;
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .card-header-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            align-items: center;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">

        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0 fs-5 mt-3">Scheme Payments</h4>
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Scheme Payments</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="row g-3 mb-3">
            @php
                $cards = [
                    ['title' => 'Total Payments', 'count' => $summary['total'] ?? 0, 'icon' => 'bi-bag-fill', 'bg' => 'linear-gradient(135deg,#4e73df,#224abe)'],
                    ['title' => 'Successful', 'count' => $summary['successful'] ?? 0, 'icon' => 'bi-check-circle-fill', 'bg' => 'linear-gradient(135deg,#1cc88a,#17a673)'],
                    ['title' => 'Failed', 'count' => $summary['failed'] ?? 0, 'icon' => 'bi-x-circle-fill', 'bg' => 'linear-gradient(135deg,#e74a3b,#c82333)'],
                    ['title' => 'Pending', 'count' => $summary['pending'] ?? 0, 'icon' => 'bi-clock-fill', 'bg' => 'linear-gradient(135deg,#f6c23e,#dda20a)']
                ];
            @endphp

            @foreach($cards as $card)
                <div class="col-sm-6 col-md-3">
                    <div class="card shadow-sm text-white stat-card" style="background: {{ $card['bg'] }}; border-radius:12px;">
                        <div class="card-body text-center py-3">
                            {{-- Used CSS class instead of inline styles --}}
                            <div class="stat-icon-wrapper mb-2 mx-auto">
                                <i class="bi {{ $card['icon'] }} fs-5 stat-icon"></i>
                            </div>
                            <h4 class="mb-0 fs-3">{{ number_format($card['count']) }}</h4>
                            <p class="mb-0 small">{{ $card['title'] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="card shadow-sm">
            <div class="card-header bg-light py-3">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <h5 class="mb-0 card-title">All Payments</h5>
<a href="{{ route('admin.scheme_payments.create') }}" class="btn btn-outline-info btn-sm">
    Add Payments
</a>


                    {{-- Search & Export Actions --}}
                    <div class="card-header-actions">
                        {{-- Search Form --}}
                        <form action="" method="GET" class="d-inline-flex">
                            <input type="text" class="form-control form-control-sm me-2" name="search"
                                placeholder="Search customer, scheme..." value="{{ request('search') }}">
                            <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-search"></i></button>
                        </form>

                        {{-- Export Buttons --}}
                        <a href="{{ route('admin.scheme_payments.export', ['type' => 'csv']) }}"
                            class="btn btn-success btn-sm">
                            <i class="bi bi-file-earmark-spreadsheet-fill"></i> CSV
                        </a>
                        <a href="{{ route('admin.scheme_payments.export', ['type' => 'excel']) }}"
                            class="btn btn-warning btn-sm">
                            <i class="bi bi-file-earmark-excel-fill"></i> Excel
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body p-3">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover align-middle mb-0 text-center">
                        <thead class="bg-light text-dark">
                            <tr>
                                <th>ID</th>
                                <th>Customer</th>
                                <th>Scheme</th>
                                <th>Duration</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Method</th>
                                <th>Due_Date</th>
                                <th>Paid_At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($schemePayments as $payment)
                                <tr>
                                    <td>{{ $payment->id }}</td>
                                    <td>{{ optional($payment->customer)->name ?? '-' }}</td>
                                    <td>{{ optional($payment->scheme)->name ?? '-' }}</td>
                                    <td>{{ $payment->payment_duration ?? '-' }}</td>
                                    <td class="text-end">{{ $payment->amount ? number_format($payment->amount, 2) : '0.00' }}
                                    </td>
                                    <td>
                                        {{-- Cleaner @switch logic for badge class --}}
                                        @php
                                            $status = $payment->status ?? 'Unknown';
                                            switch ($status) {
                                                case 'success':
                                                    $badgeClass = 'bg-success';
                                                    break;
                                                case 'failed':
                                                    $badgeClass = 'bg-danger';
                                                    break;
                                                case 'pending':
                                                    $badgeClass = 'bg-warning text-dark';
                                                    break;
                                                default:
                                                    $badgeClass = 'bg-secondary';
                                            }
                                        @endphp
                                        <span class="badge {{ $badgeClass }}">{{ ucfirst($status) }}</span>
                                    </td>
                                    <td>{{ $payment->method ?? '-' }}</td>
                                    <td>{{ $payment->due_date ?? '-' }}</td>
                                    <td>{{ $payment->paid_at ?? '-' }}</td>
                                    <td>
                                        <form action="{{ route('admin.scheme_payments.destroy', $payment->id) }}" method="POST"
                                            class="delete-payment d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-muted text-center py-4">No scheme payments found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Card Footer for Pagination --}}
            @if ($schemePayments->hasPages())
                <div class="card-footer bg-light">
                    {{-- This ensures search queries are kept when changing pages --}}
                    {{ $schemePayments->appends(request()->query())->links() }}
                </div>
            @endif

        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Delete buttons confirmation
            document.querySelectorAll('.delete-payment').forEach(function (formBtn) {
                formBtn.addEventListener('submit', function (e) {
                    e.preventDefault(); // prevent default form submit

                    Swal.fire({
                        title: 'Are you sure?',
                        text: "Do you really want to delete this record?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc3545',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Yes, delete it!',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            formBtn.submit(); // submit form if confirmed
                        }
                    });
                });
            });

            // Show success message from session
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: '{{ session("success") }}',
                    timer: 2500,
                    showConfirmButton: false
                });
            @endif
                    });
    </script>
@endpush