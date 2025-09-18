@extends('admin.layouts.app')

@section('title', 'Customers - Admin Dashboard')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

@section('content')
    <div class="container-fluid">
        <!-- Statistics Cards - Compact Design -->
        <div class="row g-2 mb-4">
            <div class="col-xl-4 col-md-4 col-sm-6">
                <div class="card stat-card bg-primary bg-opacity-10 border-0">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <p class="text-muted mb-0 small">New Today</p>
                                <h4 class="mb-0 fw-semibold fs-6">{{ $stats['today_new'] }}</h4>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="avatar-xs">
                                    <span class="avatar-title bg-primary rounded-circle fs-6">
                                        <i class="bi bi-person-plus"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-md-4 col-sm-6">
                <div class="card stat-card bg-success bg-opacity-10 border-0">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <p class="text-muted mb-0 small">Active Members</p>
                                <h4 class="mb-0 fw-semibold fs-6">{{ $stats['active_count'] }}</h4>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="avatar-xs">
                                    <span class="avatar-title bg-success rounded-circle fs-6">
                                        <i class="bi bi-people-fill"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-md-4 col-sm-6">
                <div class="card stat-card bg-warning bg-opacity-10 border-0">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <p class="text-muted mb-0 small">Inactive/Pending</p>
                                <h4 class="mb-0 fw-semibold fs-6">{{ $stats['inactive_pending_count'] }}</h4>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="avatar-xs">
                                    <span class="avatar-title bg-warning rounded-circle fs-6">
                                        <i class="bi bi-exclamation-triangle"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customers List -->
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 p-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 fw-semibold">Customers List</h5>
                            <div class="d-flex gap-2">
                                <!-- Export Dropdown -->
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button"
                                        data-bs-toggle="dropdown">
                                        <i class="bi bi-download me-1"></i>Export
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item small"
                                                href="{{ route('exports.pdf', 'customers') }}">PDF</a></li>
                                        <li><a class="dropdown-item small"
                                                href="{{ route('exports.excel', 'customers') }}">Excel</a></li>
                                        <li><a class="dropdown-item small"
                                                href="{{ route('exports.csv', 'customers') }}">CSV</a></li>
                                    </ul>
                                </div>
                                <a href="{{ route('admin.customers.create') }}" class="btn btn-sm btn-primary">
                                    <i class="bi bi-plus-circle me-1"></i>Add Customer
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-3">

                        <!-- Filters and Search -->
                        <div class="row g-2 mb-3">
                            <div class="col-md-4">
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                                    <input type="text" id="searchInput" class="form-control form-control-sm"
                                        placeholder="Search customers..." value="{{ request('search') }}"
                                        autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <select id="statusFilter" class="form-select form-select-sm">
                                    <option value="">All Status</option>
                                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active
                                    </option>
                                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive
                                    </option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending
                                        Verification</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select id="schemeFilter" class="form-select form-select-sm">
                                    <option value="">All Schemes</option>
                                    @foreach($schemes as $scheme)
                                        <option value="{{ $scheme->id }}" {{ request('scheme_id') == $scheme->id ? 'selected' : '' }}>
                                            {{ $scheme->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-2">
                                <button class="btn btn-sm btn-outline-secondary w-100" onclick="resetFilters()">
                                    <i class="bi bi-arrow-clockwise"></i> Reset
                                </button>
                            </div>
                        </div>

                        <!-- Customers Table -->
                        <div class="table-responsive">
                            <table class="table table-sm table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-nowrap small">#</th>
                                        <th class="text-nowrap small">Name</th>
                                        <th class="text-nowrap small">Scheme</th>
                                        <th class="text-nowrap small">Duration</th>
                                        <th class="text-nowrap small">Total Amount</th>
                                        <th class="text-nowrap small">Email</th>
                                        <th class="text-nowrap small">Phone</th>
                                        <th class="text-nowrap small">Address</th>
                                        <th class="text-nowrap small">M Token</th>
                                        <th class="text-nowrap small">Status</th>

                                        <th class="text-nowrap small">Verification</th>
                                        <th class="text-nowrap small">Payment</th> <!-- New -->
                                        <th class="text-nowrap small">Payment Link</th> <!-- New -->
                                        <th class="text-nowrap small">Lucky Draw Coupon</th> <!-- New -->
                                        <th class="text-nowrap small">QR Code</th>
                                        <th class="text-nowrap small text-end">Contact Us</th>
                                        <th class="text-nowrap small">Created Time</th>

                                        <th class="text-nowrap small text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="customersTableBody">
                                    @include('admin.customers.partials.table')
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-3">
                            @include('admin.customers.partials.pagination')
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .stat-card {
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .avatar-xs {
            width: 30px;
            height: 30px;
        }

        .avatar-title {
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.875rem;
        }

        .table th,
        .table td {
            padding: 0.5rem;
            font-size: 0.875rem;
        }

        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }

        .form-control-sm,
        .form-select-sm {
            font-size: 0.875rem;
            padding: 0.25rem 0.5rem;
        }

        .card-header {
            padding: 0.75rem 1rem;
        }

        .card-body {
            padding: 1rem;
        }

        .badge {
            font-size: 0.75rem;
            padding: 0.35em 0.65em;
        }

        .dropdown-menu {
            font-size: 0.875rem;
        }

        .input-group-text {
            font-size: 0.875rem;
            padding: 0.25rem 0.5rem;
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(document).ready(function () {
            let searchTimeout;

            // 🔍 Search customers
            $('#searchInput').on('input', function () {
                const query = $(this).val();
                clearTimeout(searchTimeout);

                searchTimeout = setTimeout(function () {
                    loadCustomers(query, $('#statusFilter').val());
                }, 300);
            });

            // 📊 Filter by status
            $('#statusFilter').on('change', function () {
                loadCustomers($('#searchInput').val(), $(this).val());
            });

            // 🔄 Load customers (Search + Filter + Pagination)
            function loadCustomers(query = '', status = '', page = 1) {
                $.ajax({
                    url: '{{ route('admin.customers.index') }}',
                    method: 'GET',
                    data: {
                        search: query,
                        status: status,
                        page: page
                    },
                    headers: { 'X-Requested-With': 'XMLHttpRequest' },
                    success: function (response) {
                        $('#customersTableBody').html(response.table);
                        $('.pagination-container').html(response.pagination || '');

                        // Update URL without reload
                        updateUrl(query, status, page);
                    },
                    error: function () {
                        console.log('Failed to load customers.');
                    }
                });
            }

            // 📄 Handle pagination click
            $(document).on('click', '.pagination a', function (e) {
                e.preventDefault();
                const href = $(this).attr('href');
                const url = new URL(href);
                const searchQuery = url.searchParams.get('search') || '';
                const status = url.searchParams.get('status') || '';
                const page = url.searchParams.get('page') || 1;

                loadCustomers(searchQuery, status, page);
            });

            // 🔁 Update URL
            function updateUrl(search, status, page) {
                const url = new URL(window.location);
                if (search) {
                    url.searchParams.set('search', search);
                } else {
                    url.searchParams.delete('search');
                }
                if (status) {
                    url.searchParams.set('status', status);
                } else {
                    url.searchParams.delete('status');
                }
                url.searchParams.set('page', page);
                window.history.pushState({}, '', url);
            }

            // 🎯 Quick verification update
            $(document).on('click', '.btn-verify', function () {
                const customerId = $(this).data('id');
                const status = $(this).data('status');
                const notes = prompt('Enter verification notes (optional):');

                if (notes !== null) {
                    $.ajax({
                        url: '{{ url('admin/customers') }}/' + customerId + '/verify',
                        method: 'POST',
                        data: {
                            verification_status: status,
                            verification_notes: notes,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (response) {
                            if (response.success) {
                                loadCustomers($('#searchInput').val(), $('#statusFilter').val());
                            }
                        },
                        error: function () {
                            alert('Failed to update verification status.');
                        }
                    });
                }
            });

            // 🔄 Reset filters
            window.resetFilters = function () {
                $('#searchInput').val('');
                $('#statusFilter').val('');
                loadCustomers('', '', 1);
            }
        });
         document.getElementById('schemeFilter').addEventListener('change', function () {
                let schemeId = this.value;
                let url = new URL(window.location.href);

                // scheme_id param set/update
                if (schemeId) {
                    url.searchParams.set('scheme_id', schemeId);
                } else {
                    url.searchParams.delete('scheme_id');
                }

                window.location.href = url.toString();
            });
    </script>
@endpush