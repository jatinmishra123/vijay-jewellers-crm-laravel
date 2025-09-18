@extends('admin.layouts.app')

@section('title', 'Add Customer - Admin Dashboard')

@section('content')
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card border-0 shadow-sm">
                                        <div class="card-header bg-white p-3">
                                            <h5 class="mb-0 fs-6">Add New Customer</h5>
                                        </div>
                                        <div class="card-body p-3">
                                            <form id="customer-form" method="POST" action="{{ route('admin.customers.store') }}">
                                                @csrf

                                                <div id="form-message"></div>

                                                <div class="row g-2">
                                                    <!-- Name -->
                                                    <div class="col-md-6">
                                                        <label for="name" class="form-label small">Full Name *</label>
                                                        <input type="text" name="name" id="name" value="{{ old('name') }}"
                                                            placeholder="Enter full name" class="form-control form-control-sm" required>
                                                    </div>
                                            <div class="col-md-6">
                                                <label for="scheme_id" class="form-label small">Scheme *</label>
                                            <select name="scheme_id" id="scheme_id" class="form-select form-select-sm" required>
                                                <option value="">-- Select Scheme --</option>
                                                @foreach($schemes as $scheme)
                                                    <option value="{{ $scheme->id }}" data-duration="{{ $scheme->duration }}" data-total="{{ $scheme->total_amount }}"
                                                        {{ old('scheme_id', $customer->scheme_id ?? '') == $scheme->id ? 'selected' : '' }}>
                                                        {{ $scheme->name }}
                                                    </option>
                                                @endforeach
                                            </select>

                                            </div>

        <!-- time and duration and amount  -->
      <div class="col-md-6">
        <label for="scheme_duration" class="form-label small">Scheme Duration</label>
        <input type="text" id="scheme_duration" name="scheme_duration" 
               class="form-control form-control-sm" 
               value="{{ old('scheme_duration') }}" readonly>
    </div>

    <div class="col-md-6">
        <label for="scheme_total_amount" class="form-label small">Scheme Total Amount (₹)</label>
        <input type="text" id="scheme_total_amount" name="scheme_total_amount" 
               class="form-control form-control-sm" 
               value="{{ old('scheme_total_amount') }}" readonly>
    </div>


        <!-- end  -->
                                                    <!-- Email -->
                                                    <div class="col-md-6">
                                                        <label for="email" class="form-label small">Email</label>
                                                        <input type="email" name="email" id="email" value="{{ old('email') }}"
                                                            placeholder="Enter email" class="form-control form-control-sm">
                                                    </div>

                                                    <!-- Mobile -->
                                                    <div class="col-md-6">
                                                        <label for="mobile" class="form-label small">Mobile *</label>
                                                        <input type="text" name="mobile" id="mobile" value="{{ old('mobile') }}"
                                                            placeholder="Enter mobile number" class="form-control form-control-sm" required>
                                                    </div>
               <div class="col-6">
                                            <label for="mtoken" class="form-label small">Token</label>
                                            <input type="text" 
                                                name="mtoken" 
                                                id="mtoken" 
                                                placeholder="Enter mtoken..." 
                                                value="{{ old('mtoken') }}" 
                                                class="form-control form-control-sm">
                                                        </div>
                                                    <!-- Status -->
                                                    <div class="col-md-6">
                                                        <label for="is_active" class="form-label small">Status *</label>
                                                        <select name="is_active" id="is_active" class="form-select form-select-sm" required>
                                                            <option value="1" {{ old('is_active', 1) == 1 ? 'selected' : '' }}>Active</option>
                                                            <option value="0" {{ old('is_active') == 0 ? 'selected' : '' }}>Inactive</option>
                                                        </select>
                                                    </div>

                                                    <!-- Address -->
                                                    <div class="col-12">
                                                        <label for="address" class="form-label small">Address</label>
                                                        <textarea name="address" id="address" rows="2" placeholder="Enter address"
                                                            class="form-control form-control-sm">{{ old('address') }}</textarea>
                                                    </div>




                                                    <!-- Assigned Agent -->
                                                    @if(auth()->user()->role_id != 3)
                                                        <div class="col-md-6">
                                                            <label for="agent_id" class="form-label small">Assign to Agent</label>
                                                            <select name="agent_id" id="agent_id" class="form-select form-select-sm">
                                                                <option value="">-- Select Agent --</option>
                                                                @foreach($agents as $agent)
                                                                    <option value="{{ $agent->id }}" {{ old('agent_id') == $agent->id ? 'selected' : '' }}>
                                                                        {{ $agent->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    @endif



                                                    <!-- Payment Link -->
                                                    <div class="col-md-6">
                                                        <label for="payment_link" class="form-label small">Payment Link</label>
                                                        <input type="text" name="payment_link" id="payment_link"
                                                            value="{{ old('payment_link') }}" placeholder="Enter payment link (optional)"
                                                            class="form-control form-control-sm">
                                                    </div>


                                                </div>

                                                <div class="d-flex justify-content-end gap-2 mt-3">
                                                    <a href="{{ route('admin.customers.index') }}" class="btn btn-secondary btn-sm">Cancel</a>
                                                    <button type="submit" class="btn btn-primary btn-sm">Create Customer</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
@endsection

@push('scripts')
   <script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('customer-form');
    const submitBtn = form.querySelector('button[type="submit"]');
    const messageDiv = document.getElementById('form-message');
    const schemeSelect = document.getElementById('scheme_id');
    const durationInput = document.getElementById('scheme_duration');
    const totalInput = document.getElementById('scheme_total_amount');

    // 🔹 Scheme select karne par autofill
    schemeSelect.addEventListener('change', function () {
        let selected = this.options[this.selectedIndex];
        durationInput.value = selected.getAttribute('data-duration') || '';
        totalInput.value = selected.getAttribute('data-total') || '';
    });

    // 🔹 Page load hone par agar pehle se scheme selected hai to autofill
    if (schemeSelect.value) {
        let selected = schemeSelect.options[schemeSelect.selectedIndex];
        durationInput.value = selected.getAttribute('data-duration') || '';
        totalInput.value = selected.getAttribute('data-total') || '';
    }

    // 🔹 Form submit via AJAX
    form.addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(form);
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Creating...';
        messageDiv.innerHTML = '';

        fetch(form.action, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Accept": "application/json",
                "X-Requested-With": "XMLHttpRequest"
            },
            body: formData,
            credentials: "same-origin"
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                messageDiv.innerHTML = '<div class="alert alert-success">' + data.message + '</div>';
                form.reset();
                setTimeout(() => {
                    window.location.href = "{{ route('admin.customers.index') }}";
                }, 1500);
            } else if (data.errors) {
                let errors = '<div class="alert alert-danger"><ul class="mb-0">';
                for (let key in data.errors) {
                    errors += '<li>' + data.errors[key][0] + '</li>';
                }
                errors += '</ul></div>';
                messageDiv.innerHTML = errors;
            } else if (data.message) {
                messageDiv.innerHTML = '<div class="alert alert-danger">' + data.message + '</div>';
            }
        })
        .catch(err => {
            messageDiv.innerHTML = '<div class="alert alert-danger">An error occurred. Please try again.</div>';
            console.error(err);
        })
        .finally(() => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = 'Create Customer';
        });
    });
});
</script>

@endpush