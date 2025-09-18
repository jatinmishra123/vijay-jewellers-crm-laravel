<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customers Report</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .stats .card { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 8px; text-align: left; border: 1px solid #dee2e6; }
        th { background-color: #f8f9fa; }
        .badge { padding: 5px 10px; font-size: 12px; }
    </style>
</head>
<body>

<div class="container">

   <div class="header mb-3">
    <h2>Customers Report</h2>
    <p>Generated on: {{ now()->format('F j, Y') }}</p>

    <!-- Stats as vertical text -->
    <p>New Today: {{ $stats['today_new'] ?? 0 }}</p>
    <p>Active Customers: {{ $stats['active_count'] ?? 0 }}</p>
    <p>Needs Attention: {{ $stats['inactive_pending_count'] ?? 0 }}</p>
</div>



    <!-- Customers Table -->
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-light">
                <tr>
                    <th>sr.n</th>
                    <th>Name</th>
                    <th>Scheme</th>
                    <th>Email</th>
                    <th>Phone</th>
                 <th>Payment</th>
                    <th>Status</th>
                    <th>Verification</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                @forelse($customers as $key=> $customer)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $customer->name }}</td>
                        <td>{{ $customer->scheme?->name ?? 'Not Provided' }}</td>

                        <td>{{ $customer->email ?? 'N/A' }}</td>
                        <td>{{ $customer->mobile }}</td>
                        <td>{{ $customer->payment_status }}</td>

                        <td>
                            @if($customer->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-danger">Inactive</span>
                            @endif
                        </td>
                        <td>
                            @switch($customer->verification_status)
                                @case('approved')
                                    <span class="badge bg-success">Verified</span>
                                    @break
                                @case('rejected')
                                    <span class="badge bg-danger">Rejected</span>
                                    @break
                                @default
                                    <span class="badge bg-warning text-dark">Pending</span>
                            @endswitch
                        </td>
                        <td>{{ $customer->created_at->format('M d, Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No customers found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

</body>
</html>
