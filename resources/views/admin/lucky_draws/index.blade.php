@extends('admin.layouts.app')

@section('title', 'Lucky Draw - Vijay Jewellers')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

@section('content')
        <div class="container-fluid">

            <!-- Page Title & Breadcrumb -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0 fs-5 mt-3"><i class="bi bi-gift-fill me-2"></i>Lucky Draw Dashboard</h4>
                        <ol class="breadcrumb m-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Lucky Draw</li>
                        </ol>
                    </div>
                </div>
            </div>

            <!-- Summary Cards -->
            <div class="row g-3 mb-4">
                @php
    $cards = [
        ['title' => 'Total Coupons', 'count' => $summary['total'] ?? 0, 'icon' => 'bi-gift', 'bg' => 'linear-gradient(135deg,#4e73df,#224abe)', 'text' => 'text-white'],
        ['title' => 'Pending', 'count' => $summary['pending'] ?? 0, 'icon' => 'bi-clock-fill', 'bg' => 'linear-gradient(135deg,#f6c23e,#dda20a)', 'text' => 'text-dark'],
        ['title' => 'Used', 'count' => $summary['used'] ?? 0, 'icon' => 'bi-check-circle-fill', 'bg' => 'linear-gradient(135deg,#1cc88a,#17a673)', 'text' => 'text-white'],
        ['title' => 'Cancelled', 'count' => $summary['cancelled'] ?? 0, 'icon' => 'bi-x-circle-fill', 'bg' => 'linear-gradient(135deg,#e74a3b,#c82333)', 'text' => 'text-white'],
        ['title' => 'Reward Sent', 'count' => $summary['reward_sent'] ?? 0, 'icon' => 'bi-gift-fill', 'bg' => 'linear-gradient(135deg,#6f42c1,#5a2d91)', 'text' => 'text-white'],
    ];
                @endphp

                @foreach($cards as $card)
                    <div class="col-sm-6 col-md-3">
                        <div class="card shadow-sm {{ $card['text'] }}"
                            style="background: {{ $card['bg'] }}; border-radius:12px; border: none;">
                            <div class="card-body text-center py-3">
                                <div class="stat-icon mb-2 mx-auto"
                                    style="width:40px;height:40px;background:rgba(255,255,255,0.2);border-radius:50%;display:flex;align-items:center;justify-content:center;">
                                    <i class="bi {{ $card['icon'] }} fs-5"></i>
                                </div>
                                <h4 class="mb-0 fs-3 fw-bold">{{ number_format($card['count']) }}</h4>
                                <p class="mb-0 small">{{ $card['title'] }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Filters and Export Section -->
            <div class="row mb-4">
                <div class="col-lg-12">
                    <div class="card shadow-sm h-100">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0"><i class="bi bi-funnel-fill me-2"></i>Filters & Export</h5>
                        </div>
                        <div class="card-body">
                            <form class="row g-3 align-items-center" method="GET"
                                action="{{ route('admin.lucky_draws.index') }}">
                                <div class="col-md-4">
                                    <label for="search" class="form-label small text-muted">Search</label>
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                                        <input type="text" name="search" class="form-control"
                                            placeholder="Customer, coupon code..." value="{{ request('search') }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="status" class="form-label small text-muted">Status</label>
                                    <select name="status" class="form-select form-select-sm">
                                        <option value="">All Status</option>
                                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending
                                        </option>
                                        <option value="used" {{ request('status') == 'used' ? 'selected' : '' }}>Used</option>
                                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>
                                            Cancelled</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="reward_status" class="form-label small text-muted">Reward Status</label>
                                    <select name="reward_status" class="form-select form-select-sm">
                                        <option value="">All Reward Status</option>
                                        <option value="pending" {{ request('reward_status') == 'pending' ? 'selected' : '' }}>
                                            Pending</option>
                                        <option value="sent" {{ request('reward_status') == 'sent' ? 'selected' : '' }}>Sent
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="date_from" class="form-label small text-muted">Date From</label>
                                    <input type="date" name="date_from" class="form-control form-control-sm"
                                        value="{{ request('date_from') }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="date_to" class="form-label small text-muted">Date To</label>
                                    <input type="date" name="date_to" class="form-control form-control-sm"
                                        value="{{ request('date_to') }}">
                                </div>
                                <div class="col-12 mt-3">
                                    <div class="d-flex flex-wrap justify-content-between align-items-center">
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="bi bi-funnel me-1"></i> Apply Filters
                                        </button>
                                        <div class="mt-2 mt-md-0">
                                            <a href="{{ route('admin.lucky_draws.export', array_merge(['type' => 'csv'], request()->all())) }}"
                                                class="btn btn-success btn-sm me-2">
                                                <i class="bi bi-file-earmark-spreadsheet-fill me-1"></i> CSV
                                            </a>
                                            <a href="{{ route('admin.lucky_draws.export', array_merge(['type' => 'excel'], request()->all())) }}"
                                                class="btn btn-warning btn-sm">
                                                <i class="bi bi-file-earmark-excel-fill me-1"></i> Excel
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Lucky Draw Table -->
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bi bi-table me-2"></i>Lucky Draw Coupons</h5>
                    <span class="badge bg-primary">{{ $luckyDraws->total() }} records</span>
                </div>

                <div class="card-body p-3">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center">ID</th>
                                    <th>Customer</th>
                                    <th>Scheme</th>
                                    <th>Payment_ID</th>
                                    <th>Coupon_Code</th>
                                    <th class="text-end">Amount_(₹)</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Reward_Type</th>
                                    <th class="text-center">Reward_Value</th>
                                    <th class="text-center">Reward_Message</th>
                                    <th class="text-center">Reward_Status</th>
                                    <th class="text-center">Rewarded_At</th>
                                    <th class="text-center">Created_At</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($luckyDraws as $draw)
                                                    <tr class="align-middle">
                                                        <td class="text-center">{{ $draw->id }}</td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-2"
                                                                    style="width: 32px; height: 32px;">
                                                                    <i class="bi bi-person-fill text-primary"></i>
                                                                </div>
                                                                <div>{{ optional($draw->customer)->name ?? '-' }}</div>
                                                            </div>
                                                        </td>
                                                        <td>{{ optional($draw->scheme)->name ?? '-' }}</td>
                                                        <td>{{ optional($draw->schemePayment)->id ?? '-' }}</td>
                                                        <td>
                                                            <span
                                                                class="badge bg-light text-dark font-monospace p-2">{{ $draw->coupon_code }}</span>
                                                        </td>
                                                        <td class="text-end fw-bold">
                                                            ₹{{ $draw->lucky_draw_amount ? number_format($draw->lucky_draw_amount, 2) : '0.00' }}
                                                        </td>
                                                        <td class="text-center">
                                                            <span class="badge py-2 px-3 
                                                                                                                                                            {{ $draw->status == 'pending' ? 'bg-warning text-dark' :
            ($draw->status == 'used' ? 'bg-success' :
                ($draw->status == 'cancelled' ? 'bg-danger' : 'bg-secondary')) }}">
                                                                <i class="bi 
                                                                                                                                                                {{ $draw->status == 'pending' ? 'bi-clock-history' :
            ($draw->status == 'used' ? 'bi-check-circle' :
                ($draw->status == 'cancelled' ? 'bi-x-circle' : 'bi-question-circle')) }} me-1">
                                                                </i>
                                                                {{ ucfirst($draw->status) }}
                                                            </span>
                                                        </td>
                                                        <!-- New Reward Columns -->
                                                        <td class="text-center">{{ $draw->reward_type ?? '-' }}</td>
                                                        <td class="text-center">{{ $draw->reward_value ?? '-' }}</td>
                                                        <td class="text-center" style="max-width:200px; word-break:break-word;">
                                                            @php
        $words = explode(' ', $draw->reward_message);
        $shortMessage = implode(' ', array_slice($words, 0, 10));
                                                            @endphp
                                                            {{ count($words) > 10 ? $shortMessage . '...' : $draw->reward_message }}
                                                            @if(count($words) > 10)
                                                                <a href="#" class="ms-1 view-full-message" data-bs-toggle="modal"
                                                                    data-bs-target="#rewardMessageModal" data-message="{{ $draw->reward_message }}">Read
                                                                    More</a>
                                                            @endif
                                                        </td>
                                                        </td>
                                                        <td class="text-center">
                                                            @if($draw->reward_status === 'sent')
                                                                <span class="badge bg-success">
                                                                    <i class="bi bi-check-circle me-1"></i> Sent
                                                                </span>
                                                            @else
                                                                <span class="badge bg-secondary">
                                                                    <i class="bi bi-clock me-1"></i> Pending
                                                                </span>
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            {{ $draw->rewarded_at ? \Carbon\Carbon::parse($draw->rewarded_at)->format('d M Y H:i') : '-' }}
                                                        </td>

                                                        <td class="text-center">{{ $draw->created_at->format('d M Y') }}</td>
                                                        <td class="text-center">
                                                            <div class="d-flex justify-content-center">
                                                                <button class="btn btn-sm btn-outline-info me-1 view-btn" data-bs-toggle="modal"
                                                                    data-bs-target="#viewModal" data-id="{{ $draw->id }}"
                                                                    data-customer="{{ optional($draw->customer)->name ?? 'N/A' }}"
                                                                    data-scheme="{{ optional($draw->scheme)->name ?? 'N/A' }}"
                                                                    data-amount="{{ $draw->lucky_draw_amount ? number_format($draw->lucky_draw_amount, 2) : '0.00' }}"
                                                                    data-code="{{ $draw->coupon_code }}"
                                                                    data-created="{{ $draw->created_at->format('d M Y') }}"
                                                                    data-status="{{ $draw->status }}"
                                                                    data-reward-status="{{ $draw->reward_status }}"
                                                                    data-reward-type="{{ $draw->reward_type }}"
                                                                    data-reward-value="{{ $draw->reward_value }}"
                                                                    data-reward-message="{{ $draw->reward_message }}"
                                                                    title="View Details & Add Reward">
                                                                    <i class="bi bi-eye"></i>
                                                                </button>
                                                                <form action="{{ route('admin.lucky_draws.destroy', $draw->id) }}" method="POST"
                                                                    class="delete-form d-inline">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="button" class="btn btn-sm btn-outline-danger delete-btn"
                                                                        title="Delete">
                                                                        <i class="bi bi-trash"></i>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </td>
                                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="14" class="text-muted py-4 text-center">
                                            <i class="bi bi-inbox display-4 d-block mb-1"></i>
                                            No lucky draw coupons found
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                    </div>
    <!-- modal -->
    <div class="modal fade" id="rewardMessageModal" tabindex="-1" aria-labelledby="rewardMessageModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="rewardMessageModalLabel">Full Reward Message</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="fullRewardMessageContent">
                    <!-- Message will be injected via JS -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

                    <!-- Pagination -->
                    @if($luckyDraws->hasPages())
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <div class="text-muted small">
                                Showing {{ $luckyDraws->firstItem() }} to {{ $luckyDraws->lastItem() }} of
                                {{ $luckyDraws->total() }} entries
                            </div>
                            <nav>
                                {{ $luckyDraws->withQueryString()->links() }}
                            </nav>
                        </div>
                    @endif
                </div>
            </div>

        </div>

        <!-- View Details Modal with Cashback Reward -->
        <div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="viewModalLabel">Coupon Details & Reward</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="viewModalBody">
                        <form id="rewardForm">
                            @csrf
                            <input type="hidden" name="coupon_id" id="coupon_id">

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label small text-muted">Coupon ID</label>
                                    <p class="fw-bold" id="modal_coupon_id">#</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small text-muted">Status</label>
                                    <p id="modal_status"><span class="badge bg-success">Active</span></p>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small text-muted">Customer</label>
                                    <p class="fw-bold" id="modal_customer">John Doe</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small text-muted">Scheme</label>
                                    <p class="fw-bold" id="modal_scheme">Diwali Special</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small text-muted">Amount</label>
                                    <p class="fw-bold" id="modal_amount">₹0.00</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small text-muted">Created On</label>
                                    <p class="fw-bold" id="modal_created">15 Nov 2023</p>
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label small text-muted">Coupon Code</label>
                                    <div class="bg-light p-3 rounded text-center">
                                        <code class="fs-5 fw-bold" id="modal_code">VJDL2023001</code>
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <h6 class="mb-3"><i class="bi bi-gift-fill me-2"></i>Reward Information</h6>

                            <div class="mb-3">
                                <label for="reward_type" class="form-label">Reward Type</label>
                                <select class="form-select" id="reward_type" name="reward_type" required>
                                    <option value="">Select Reward Type</option>
                                    <option value="cashback">Cashback</option>
                                    <option value="discount">Discount Coupon</option>
                                    <option value="gift">Gift Voucher</option>
                                    <option value="product">Free Product</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="reward_value" class="form-label">Reward Value</label>
                                <input type="text" class="form-control" id="reward_value" name="reward_value"
                                    placeholder="Enter reward amount or description" required>
                            </div>

                            <div class="mb-3">
                                <label for="reward_message" class="form-label">Reward Message (SMS Content)</label>
                                <textarea class="form-control" id="reward_message" name="reward_message" rows="3"
                                    placeholder="Message that will be sent to customer" required></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-success" id="saveReward">
                            <i class="bi bi-check-circle me-1"></i> Save & Send Reward
                        </button>
                    </div>
                </div>
            </div>
        </div>
@endsection

@push('styles')
    <style>
        .card {
            border: none;
            border-radius: 12px;
        }

        .table th {
            font-weight: 600;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-top: none;
        }

        .table td {
            vertical-align: middle;
            padding: 0.75rem;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(0, 123, 255, 0.05);
        }

        .badge {
            font-size: 0.75em;
            font-weight: 500;
        }

        .pagination {
            margin-bottom: 0;
        }

        .page-item.active .page-link {
            background-color: #4e73df;
            border-color: #4e73df;
        }

        .stat-icon {
            transition: transform 0.3s;
        }

        .card:hover .stat-icon {
            transform: scale(1.1);
        }

        .view-btn,
        .delete-btn {
            transition: all 0.2s;
            border-radius: 6px;
        }

        .view-btn:hover {
            background-color: #0dcaf0;
            color: white;
        }

        .delete-btn:hover {
            background-color: #dc3545;
            color: white;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #4e73df;
            box-shadow: 0 0 0 0.25rem rgba(78, 115, 223, 0.25);
        }

        #reward_message {
            resize: vertical;
            min-height: 80px;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // View details modal
            const viewModal = new bootstrap.Modal(document.getElementById('viewModal'));
            const viewModalBody = document.getElementById('viewModalBody');

            // Set up view buttons
            document.querySelectorAll('.view-btn').forEach(button => {
                button.addEventListener('click', function () {
                    const id = this.getAttribute('data-id');
                    const customer = this.getAttribute('data-customer');
                    const scheme = this.getAttribute('data-scheme');
                    const amount = this.getAttribute('data-amount');
                    const code = this.getAttribute('data-code');
                    const created = this.getAttribute('data-created');
                    const status = this.getAttribute('data-status');
                    const rewardStatus = this.getAttribute('data-reward-status');
                    const rewardType = this.getAttribute('data-reward-type');
                    const rewardValue = this.getAttribute('data-reward-value');
                    const rewardMessage = this.getAttribute('data-reward-message');

                    // Set modal values
                    document.getElementById('coupon_id').value = id;
                    document.getElementById('modal_coupon_id').textContent = '#' + id;
                    document.getElementById('modal_customer').textContent = customer;
                    document.getElementById('modal_scheme').textContent = scheme;
                    document.getElementById('modal_amount').textContent = '₹' + amount;
                    document.getElementById('modal_code').textContent = code;
                    document.getElementById('modal_created').textContent = created;

                    // Set status badge
                    let statusBadge = '';
                    if (status === 'pending') {
                        statusBadge = '<span class="badge bg-warning text-dark">Pending</span>';
                    } else if (status === 'used') {
                        statusBadge = '<span class="badge bg-success">Used</span>';
                    } else if (status === 'cancelled') {
                        statusBadge = '<span class="badge bg-danger">Cancelled</span>';
                    } else {
                        statusBadge = '<span class="badge bg-secondary">' + status + '</span>';
                    }
                    document.getElementById('modal_status').innerHTML = statusBadge;

                    // Set reward values if they exist
                    if (rewardType) {
                        document.getElementById('reward_type').value = rewardType;
                    }
                    if (rewardValue) {
                        document.getElementById('reward_value').value = rewardValue;
                    }
                    if (rewardMessage) {
                        document.getElementById('reward_message').value = rewardMessage;
                    } else {
                        // Set default reward message
                        document.getElementById('reward_message').value =
                            `Dear Customer, you have won a reward of ₹${amount} from Vijay Jewellers Lucky Draw. Your coupon code: ${code}. Visit our store to claim your reward.`;
                    }

                    // Disable form if reward already sent
                    if (rewardStatus === 'sent') {
                        document.getElementById('reward_type').disabled = true;
                        document.getElementById('reward_value').disabled = true;
                        document.getElementById('reward_message').disabled = true;
                        document.getElementById('saveReward').disabled = true;
                        document.getElementById('saveReward').textContent = 'Reward Already Sent';
                        document.getElementById('saveReward').classList.remove('btn-success');
                        document.getElementById('saveReward').classList.add('btn-secondary');
                    } else {
                        document.getElementById('reward_type').disabled = false;
                        document.getElementById('reward_value').disabled = false;
                        document.getElementById('reward_message').disabled = false;
                        document.getElementById('saveReward').disabled = false;
                        document.getElementById('saveReward').textContent = 'Save & Send Reward';
                        document.getElementById('saveReward').classList.remove('btn-secondary');
                        document.getElementById('saveReward').classList.add('btn-success');
                    }
                });
            });

            // Save reward button
            document.getElementById('saveReward').addEventListener('click', function () {
                const form = document.getElementById('rewardForm');
                const rewardType = document.getElementById('reward_type').value;
                const rewardValue = document.getElementById('reward_value').value;
                const couponId = document.getElementById('coupon_id').value;

                if (!rewardType || !rewardValue) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Incomplete Form',
                        text: 'Please fill in all required fields',
                    });
                    return;
                }

                // Show loading
                Swal.fire({
                    title: 'Processing Reward',
                    text: 'Please wait...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Prepare form data
                const formData = new FormData(form);

                // Send AJAX request
                fetch(`/admin/admin/lucky-draws/${couponId}/add-reward`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                    },
                    body: formData
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Reward Sent Successfully!',
                                html: `
                                            <div class="text-start">
                                                <p><strong>Reward Type:</strong> ${rewardType}</p>
                                                <p><strong>Reward Value:</strong> ${rewardValue}</p>
                                                <p class="mb-0">SMS has been sent to the customer with reward details.</p>
                                            </div>
                                        `,
                                confirmButtonText: 'OK'
                            }).then(() => {
                                viewModal.hide();
                                // Reset form
                                form.reset();
                                // Reload page to see updated reward status
                                window.location.reload();
                            });
                        } else {
                            throw new Error(data.message || 'Failed to send reward');
                        }
                    })
                    .catch(error => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: error.message || 'Failed to send reward. Please try again.',
                        });
                    });
            });

            // Delete confirmation with SweetAlert
            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', function () {
                    const form = this.closest('form');

                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Show loading
                            Swal.fire({
                                title: 'Deleting...',
                                text: 'Please wait while we delete the coupon',
                                allowOutsideClick: false,
                                didOpen: () => {
                                    Swal.showLoading();
                                }
                            });

                            // Submit the form
                            form.submit();
                        }
                    });
                });
            });

            // Auto-format reward value based on type
            document.getElementById('reward_type').addEventListener('change', function () {
                const rewardValue = document.getElementById('reward_value');
                if (this.value === 'cashback') {
                    rewardValue.placeholder = 'Enter cashback amount (e.g., 500)';
                } else if (this.value === 'discount') {
                    rewardValue.placeholder = 'Enter discount percentage (e.g., 15%)';
                } else {
                    rewardValue.placeholder = 'Enter reward details';
                }
            });
        });
        document.addEventListener('DOMContentLoaded', function () {
            const rewardModal = document.getElementById('rewardMessageModal');
            const messageContent = document.getElementById('fullRewardMessageContent');

            document.querySelectorAll('.view-full-message').forEach(link => {
                link.addEventListener('click', function () {
                    const fullMessage = this.getAttribute('data-message');
                    messageContent.textContent = fullMessage;
                });
            });
        });
    </script>
@endpush