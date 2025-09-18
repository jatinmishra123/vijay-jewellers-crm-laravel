@if ($customers->hasPages())
    <div class="pagination-container">
        {{ $customers->withQueryString()->links('pagination::bootstrap-5') }}
    </div>
@endif