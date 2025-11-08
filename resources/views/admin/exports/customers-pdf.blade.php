<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customers Report</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td {
            padding: 6px;
            text-align: left;
            border: 1px solid #dee2e6;
            word-wrap: break-word;
            white-space: normal;
            font-size: 11px;
        }
        th { background-color: #f8f9fa; }
        .badge { padding: 4px 8px; font-size: 11px; }
    </style>
</head>
<body>

<div class="container">

   <div class="header mb-3">
        <h2>Customers Report</h2>
        <p>Generated on: {{ now()->format('F j, Y') }}</p>
   </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-light">
                <tr>
                    <th>Sr.n</th>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Role</th>
                    <th>Scheme</th>
                    <th>Duration</th>
                    <th>Total Amount</th>
                    <th>Payment</th>
                    <th>Status</th>
                    <th>Verification</th>
                    <th>Registered Date</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                @forelse($customers as $key => $customer)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $customer->id }}</td>
                        <td>{{ $customer->name ?? ($customer->first_name.' '.$customer->last_name) }}</td>
                        <td>{{ $customer->username ?? 'N/A' }}</td>
                        <td>{{ $customer->email ?? 'N/A' }}</td>
                        <td>{{ $customer->mobile ?? 'N/A' }}</td>
                        <td>{{ $customer->role ?? 'N/A' }}</td>
                        <td>{{ $customer->scheme?->name ?? 'Not Provided' }}</td>
                        <td>{{ $customer->scheme_duration ?? '-' }}</td>
                        <td>{{ $customer->scheme_total_amount ?? '-' }}</td>
                        <td>{{ $customer->payment_status ?? 'N/A' }}</td>
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
                        <td>{{ $customer->registered_date ?? '-' }}</td>
                        <td>{{ optional($customer->created_at)->format('M d, Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="15" class="text-center">No customers found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

</body>
</html>
