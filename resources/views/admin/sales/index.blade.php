@extends('admin.layouts.app')

@section('title', 'Sales - Admin Dashboard')

@section('content')
    <div class="row">
        <!-- Daily Total Jewellery Sales -->
        <div class="col-md-6 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <p class="text-muted fw-medium mb-2">Daily Total Sales</p>
                            <h4 class="mb-0">${{ number_format($dailySales->total_sales ?? 0, 2) }}</h4>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="bg-primary-subtle p-3 rounded-3">
                                <i class="ri-shopping-bag-line text-primary fs-2"></i>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3">
                        @php
                            $change = $percentageChanges['total_sales'] ?? 0;
                            $badgeClass = $change >= 0 ? 'bg-success' : 'bg-danger';
                            $changeText = $change >= 0 ? '+' . number_format($change, 0) . '%' : number_format($change, 0) . '%';
                        @endphp
                        <p class="mb-0"><span class="badge {{ $badgeClass }} me-1">{{ $changeText }}</span> vs. yesterday
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Online Sales -->
        <div class="col-md-6 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <p class="text-muted fw-medium mb-2">Online Sales</p>
                            <h4 class="mb-0">${{ number_format($dailySales->online_sales ?? 0, 2) }}</h4>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="bg-success-subtle p-3 rounded-3">
                                <i class="ri-global-line text-success fs-2"></i>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3">
                        @php
                            $change = $percentageChanges['online_sales'] ?? 0;
                            $badgeClass = $change >= 0 ? 'bg-success' : 'bg-danger';
                            $changeText = $change >= 0 ? '+' . number_format($change, 0) . '%' : number_format($change, 0) . '%';
                        @endphp
                        <p class="mb-0"><span class="badge {{ $badgeClass }} me-1">{{ $changeText }}</span> vs. yesterday
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Offline Sales -->
        <div class="col-md-6 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <p class="text-muted fw-medium mb-2">Offline Sales</p>
                            <h4 class="mb-0">${{ number_format($dailySales->offline_sales ?? 0, 2) }}</h4>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="bg-info-subtle p-3 rounded-3">
                                <i class="ri-store-2-line text-info fs-2"></i>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3">
                        @php
                            $change = $percentageChanges['offline_sales'] ?? 0;
                            $badgeClass = $change >= 0 ? 'bg-success' : 'bg-danger';
                            $changeText = $change >= 0 ? '+' . number_format($change, 0) . '%' : number_format($change, 0) . '%';
                        @endphp
                        <p class="mb-0"><span class="badge {{ $badgeClass }} me-1">{{ $changeText }}</span> vs. yesterday
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Average Order Value -->
        <div class="col-md-6 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <p class="text-muted fw-medium mb-2">Avg. Order Value</p>
                            <h4 class="mb-0">${{ number_format($dailySales->avg_order_value ?? 0, 2) }}</h4>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="bg-warning-subtle p-3 rounded-3">
                                <i class="ri-money-dollar-circle-line text-warning fs-2"></i>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3">
                        @php
                            $change = $percentageChanges['avg_order_value'] ?? 0;
                            $badgeClass = $change >= 0 ? 'bg-success' : 'bg-danger';
                            $changeText = $change >= 0 ? '+' . number_format($change, 0) . '%' : number_format($change, 0) . '%';
                        @endphp
                        <p class="mb-0"><span class="badge {{ $badgeClass }} me-1">{{ $changeText }}</span> vs. yesterday
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Product-wise Sales -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Product-wise Sales</h4>
                </div>
                <div class="card-body">
                    @php
                        $totalSales = $productWiseSales->sum('total_amount');
                        $productTypes = ['Gold', 'Diamond', 'Silver', 'Plated'];
                        $colors = ['bg-primary', 'bg-success', 'bg-info', 'bg-warning'];
                    @endphp

                    <div class="table-responsive mt-3">
                        <table class="table table-sm table-centered table-nowrap table-borderless mb-0">
                            <tbody>
                                @foreach($productTypes as $index => $type)
                                    @php
                                        $productSales = $productWiseSales->firstWhere('product_type', $type);
                                        $amount = $productSales->total_amount ?? 0;
                                        $percentage = $totalSales > 0 ? ($amount / $totalSales) * 100 : 0;
                                    @endphp
                                    <tr>
                                        <td style="width: 30%">
                                            <p class="mb-0">{{ $type }}</p>
                                        </td>
                                        <td style="width: 25%">
                                            <h5 class="mb-0">${{ number_format($amount, 2) }}</h5>
                                        </td>
                                        <td style="width: 25%">
                                            <div class="progress progress-sm">
                                                <div class="progress-bar {{ $colors[$index] }}" role="progressbar"
                                                    style="width: {{ $percentage }}%" aria-valuenow="{{ $percentage }}"
                                                    aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </td>
                                        <td style="width: 20%">
                                            <p class="text-muted mb-0">{{ number_format($percentage, 1) }}%</p>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Selling Products -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Top 5 Selling Products</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-borderless table-centered table-nowrap">
                            <thead class="text-muted border-dashed border-bottom">
                                <tr>
                                    <th scope="col">Product</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col" colspan="2">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($topSellingProducts as $product)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0 me-2">
                                                    <img src="https://via.placeholder.com/40" alt="{{ $product->product_name }}"
                                                        class="avatar-sm rounded-circle">
                                                </div>
                                                <div class="flex-grow-1">{{ $product->product_name }}</div>
                                            </div>
                                        </td>
                                        <td>${{ number_format($product->avg_price, 2) }}</td>
                                        <td>{{ $product->total_quantity }}</td>
                                        <td>${{ number_format($product->total_amount, 2) }}</td>
                                        <td><span class="badge bg-success-subtle text-success">In Stock</span></td>
                                        <td>
                                            <div class="dropdown">
                                                <a href="#" class="btn btn-soft-secondary btn-sm dropdown"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="ri-more-2-fill"></i>
                                                </a>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li><a class="dropdown-item" href="#"><i
                                                                class="ri-pencil-fill align-bottom me-2 text-muted"></i>
                                                            Edit</a></li>
                                                    <li><a class="dropdown-item" href="#"><i
                                                                class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>
                                                            Delete</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No products sold today</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Sales List</h4>
                </div>
                <div class="card-body">

                    <!-- Live Search -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <input type="text" id="searchInput" class="form-control"
                                placeholder="Search by product name or type...">
                        </div>
                    </div>

                    <!-- Sales Table -->
                    <div id="sales-table" class="table-responsive">
                        @include('admin.sales.partials.table', ['sales' => $sales])
                    </div>

                    <!-- Delete Confirmation Modal -->
                    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to delete this sale?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary btn-sm"
                                        data-bs-dismiss="modal">Cancel</button>
                                    <button type="button" id="confirmDeleteBtn"
                                        class="btn btn-danger btn-sm">Delete</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            let searchTimeout;
            let saleIdToDelete = null;
            let deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));

            // AJAX setup with CSRF token
            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            });

            // 🔄 Load sales (live search + pagination)
            function loadSales(query = '', page = 1) {
                $.ajax({
                    url: '{{ route('admin.sales.index') }}',
                    method: 'GET',
                    data: { search: query, page: page },
                    success: function (response) {
                        $('#sales-table').html(response);

                        // Update URL without reload
                        const url = new URL(window.location);
                        if (query) url.searchParams.set('search', query);
                        else url.searchParams.delete('search');
                        url.searchParams.set('page', page);
                        window.history.pushState({}, '', url);
                    },
                    error: function () { console.log('Failed to load sales.'); }
                });
            }

            // 🔍 Live search
            $('#searchInput').on('input', function () {
                const query = $(this).val();
                clearTimeout(searchTimeout);

                searchTimeout = setTimeout(function () {
                    loadSales(query);
                }, 300);
            });

            // 🔁 Pagination click
            $(document).on('click', '#sales-table .pagination a', function (e) {
                e.preventDefault();
                const href = $(this).attr('href');
                const url = new URL(href);
                const query = url.searchParams.get('search') || '';
                const page = url.searchParams.get('page') || 1;
                loadSales(query, page);
            });

            // ❌ Open delete modal
            $(document).on('click', '.delete-sale', function () {
                saleIdToDelete = $(this).data('id');
                deleteModal.show();
            });

            $('#confirmDeleteBtn').on('click', function () {
                if (!saleIdToDelete) return;

                // Generate URL from Laravel named route
                let url = '{{ route("admin.sales.destroy", ":id") }}';
                url = url.replace(':id', saleIdToDelete);

                // Disable button to prevent multiple clicks
                $(this).prop('disabled', true).text('Deleting...');

                $.ajax({
                    url: url,
                    type: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    success: function (response) {
                        if (response.success) {
                            // Remove the row
                            $(`button[data-id="${saleIdToDelete}"]`).closest('tr').fadeOut(300, function () {
                                $(this).remove();
                            });

                            // Show success inside modal
                            $('#deleteModal .modal-body').html('<div class="text-success">' + response.message + '</div>');

                            // Close modal after 1 second
                            setTimeout(function () {
                                deleteModal.hide();

                                // Reset modal body and button text
                                $('#deleteModal .modal-body').text('Are you sure you want to delete this sale?');
                                $('#confirmDeleteBtn').prop('disabled', false).text('Delete');
                                saleIdToDelete = null;
                            }, 1000);
                        } else {
                            $('#deleteModal .modal-body').html('<div class="text-danger">' + response.message + '</div>');
                            $('#confirmDeleteBtn').prop('disabled', false).text('Delete');
                        }
                    },
                    error: function () {
                        $('#deleteModal .modal-body').html('<div class="text-danger">Failed to delete sale.</div>');
                        $('#confirmDeleteBtn').prop('disabled', false).text('Delete');
                    }
                });
            });
        }); 
    </script>
@endpush