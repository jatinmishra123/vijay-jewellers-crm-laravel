<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Product Type</th>
            <th>Product Name</th>
            <th>Amount</th>
            <th>Sale Date</th>
            <th>Sale Type</th>
            <th>Created At</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($sales as $sale)
            <tr>
                <td>{{ $sale->id }}</td>
                <td>{{ $sale->product_type }}</td>
                <td>{{ $sale->product_name }}</td>
                <td>{{ number_format($sale->amount, 2) }}</td>
                <td>{{ \Carbon\Carbon::parse($sale->sale_date)->format('M d, Y') }}</td>
                <td>{{ ucfirst($sale->sale_type) }}</td>
                <td>{{ $sale->created_at->format('M d, Y H:i') }}</td>
                <td>
                    <button class="btn btn-outline-danger btn-sm delete-sale" data-id="{{ $sale->id }}">
                        <i class="ri-delete-bin-line"></i>
                    </button>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8" class="text-center">No sales found.</td>
            </tr>
        @endforelse
    </tbody>
</table>

<!-- Pagination -->
@if($sales->hasPages())
    <div class="d-flex justify-content-between align-items-center mt-3">
        <div class="text-muted">
            Showing {{ $sales->firstItem() }} to {{ $sales->lastItem() }} of {{ $sales->total() }} entries
        </div>
        <div class="pagination-container">
            {{ $sales->appends(request()->query())->links() }}
        </div>
    </div>
@endif