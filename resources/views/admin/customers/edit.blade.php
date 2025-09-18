@extends('admin.layouts.app')

@section('title', 'Edit Customer - Admin Dashboard')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white p-3">
                        <h5 class="mb-0 fs-6">Edit Customer</h5>
                    </div>
                    <div class="card-body p-3">
                        <form method="POST" action="{{ route('admin.customers.update', $customer->id) }}">
                            @csrf
                            @method('PUT')

                            <!-- Display success/error messages -->
                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show py-2">
                                    <small>{{ session('success') }}</small>
                                    <button type="button" class="btn-close p-2" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            @if(session('error'))
                                <div class="alert alert-danger alert-dismissible fade show py-2">
                                    <small>{{ session('error') }}</small>
                                    <button type="button" class="btn-close p-2" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            <div class="row g-2">
                                <!-- Name -->
                                <div class="col-md-6">
                                    <label for="name" class="form-label small">Full Name *</label>
                                    <input type="text" name="name" id="name"
                                        class="form-control form-control-sm @error('name') is-invalid @enderror"
                                        value="{{ old('name', $customer->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div class="col-md-6">
                                    <label for="email" class="form-label small">Email Address</label>
                                    <input type="email" name="email" id="email"
                                        class="form-control form-control-sm @error('email') is-invalid @enderror"
                                        value="{{ old('email', $customer->email) }}">
                                    @error('email')
                                        <div class="invalid-feedback small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Mobile -->
                                <div class="col-md-6">
                                    <label for="mobile" class="form-label small">Mobile Number *</label>
                                    <input type="text" name="mobile" id="mobile"
                                        class="form-control form-control-sm @error('mobile') is-invalid @enderror"
                                        value="{{ old('mobile', $customer->mobile) }}" required>
                                    @error('mobile')
                                        <div class="invalid-feedback small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Status -->
                                <div class="col-md-6">
                                    <label for="is_active" class="form-label small">Status *</label>
                                    <select name="is_active" id="is_active"
                                        class="form-select form-select-sm @error('is_active') is-invalid @enderror"
                                        required>
                                        <option value="1" {{ old('is_active', $customer->is_active) == 1 ? 'selected' : '' }}>
                                            Active
                                        </option>
                                        <option value="0" {{ old('is_active', $customer->is_active) == 0 ? 'selected' : '' }}>
                                            Inactive
                                        </option>
                                    </select>
                                    @error('is_active')
                                        <div class="invalid-feedback small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Verification Status -->
                                <div class="col-md-6">
                                    <label for="verification_status" class="form-label small">Verification Status *</label>
                                    <select name="verification_status" id="verification_status"
                                        class="form-select form-select-sm @error('verification_status') is-invalid @enderror"
                                        required>
                                        <option value="pending" {{ old('verification_status', $customer->verification_status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="approved" {{ old('verification_status', $customer->verification_status) == 'approved' ? 'selected' : '' }}>Approved
                                        </option>
                                        <option value="rejected" {{ old('verification_status', $customer->verification_status) == 'rejected' ? 'selected' : '' }}>Rejected
                                        </option>
                                    </select>
                                    @error('verification_status')
                                        <div class="invalid-feedback small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Agent Assignment (only for admin/manager) -->
                                @if(isset($agents) && count($agents) > 0 && auth()->user()->role_id != 3)
                                    <div class="col-md-6">
                                        <label for="agent_id" class="form-label small">Assign Agent</label>
                                        <select name="agent_id" id="agent_id"
                                            class="form-select form-select-sm @error('agent_id') is-invalid @enderror">
                                            <option value="">-- Select Agent --</option>
                                            @foreach($agents as $agent)
                                                <option value="{{ $agent->id }}" {{ old('agent_id', $customer->agent_id) == $agent->id ? 'selected' : '' }}>
                                                    {{ $agent->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('agent_id')
                                            <div class="invalid-feedback small">{{ $message }}</div>
                                        @enderror
                                    </div>
                                @endif

                                <!-- Token/QR Code -->
                                <div class="col-md-6">
                                    <label for="token" class="form-label small">Token / QR Code</label>
                                    <input type="text" name="token" id="token"
                                        class="form-control form-control-sm @error('token') is-invalid @enderror"
                                        value="{{ old('token', $customer->token) }}" placeholder="Auto-generated or manual">
                                    @error('token')
                                        <div class="invalid-feedback small">{{ $message }}</div>
                                    @enderror
                                </div>
                                <!-- Payment Status -->
                                <div class="col-md-6">
                                    <label for="payment_status" class="form-label small">Payment Status</label>
                                    <select name="payment_status" id="payment_status"
                                        class="form-select form-select-sm @error('payment_status') is-invalid @enderror">
                                        <option value="pending" {{ old('payment_status', $customer->payment_status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="success" {{ old('payment_status', $customer->payment_status) == 'success' ? 'selected' : '' }}>Success</option>
                                        <option value="failed" {{ old('payment_status', $customer->payment_status) == 'failed' ? 'selected' : '' }}>Failed</option>
                                    </select>
                                    @error('payment_status')
                                        <div class="invalid-feedback small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Payment Link -->
                                <div class="col-md-6">
                                    <label for="payment_link" class="form-label small">Payment Link</label>
                                    <input type="text" name="payment_link" id="payment_link"
                                        class="form-control form-control-sm @error('payment_link') is-invalid @enderror"
                                        value="{{ old('payment_link', $customer->payment_link) }}"
                                        placeholder="Enter payment link if any">
                                    @error('payment_link')
                                        <div class="invalid-feedback small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Address -->
                                <div class="col-12">
                                    <label for="address" class="form-label small">Address</label>
                                    <textarea name="address" id="address" rows="2"
                                        class="form-control form-control-sm @error('address') is-invalid @enderror">{{ old('address', $customer->address) }}</textarea>
                                    @error('address')
                                        <div class="invalid-feedback small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Verification Notes -->
                                <div class="col-12">
                                    <label for="verification_notes" class="form-label small">Verification Notes</label>
                                    <textarea name="verification_notes" id="verification_notes" rows="2"
                                        class="form-control form-control-sm @error('verification_notes') is-invalid @enderror"
                                        placeholder="Optional notes about verification">{{ old('verification_notes', $customer->verification_notes) }}</textarea>
                                    @error('verification_notes')
                                        <div class="invalid-feedback small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2 mt-3">
                                <a href="{{ route('admin.customers.index') }}" class="btn btn-secondary btn-sm">Cancel</a>
                                <button type="submit" class="btn btn-primary btn-sm">Update Customer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .form-control-sm,
        .form-select-sm {
            font-size: 0.875rem;
            padding: 0.25rem 0.5rem;
        }

        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }

        .invalid-feedback {
            font-size: 0.75rem;
        }

        .alert {
            font-size: 0.875rem;
            margin-bottom: 1rem;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Add form submission handling
            const form = document.querySelector('form');
            form.addEventListener('submit', function (e) {
                const submitBtn = form.querySelector('button[type="submit"]');
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Updating...';
            });
        });
    </script>
@endpush