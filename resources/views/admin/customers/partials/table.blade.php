@forelse($customers as $index => $customer)
<tr class="small">
    <!-- Serial -->
    <td class="text-end">{{ $customers->firstItem() + $index }}</td>

    <!-- Name + Agent -->
    <td style="max-width: 180px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
        <span class="fw-semibold">{{ Str::limit($customer->name, 40, '...') }}</span>
        @if($customer->agent)
            <small class="text-muted d-block" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                Agent: {{ Str::limit($customer->agent->name, 25, '...') }}
            </small>
        @endif
    </td>

    <!-- Scheme -->
    <td class="text-end">{{ $customer->scheme?->name ?? 'Not Provided' }}</td>
   <td class="text-end">{{ $customer->scheme_duration ?? 'Not Provided' }}</td>
      <td class="text-end">{{ $customer->scheme_total_amount ?? 'Not Provided' }}</td>
    <!-- Email -->
    <td style="max-width: 180px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
        {{ $customer->email ?? 'N/A' }}
    </td>

    <!-- Mobile -->
    <td class="text-end">{{ $customer->mobile }}</td>

    <!-- Address -->
    <td style="max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
        {{ Str::limit($customer->address, 30) ?? 'N/A' }}
    </td>

    <!-- Mtoken -->
    <td>{{ $customer->mtoken }}</td>

    <!-- Status -->
    <td class="text-center">
        <span class="badge {{ $customer->is_active ? 'bg-success' : 'bg-danger' }} small">
            {{ $customer->is_active ? 'Active' : 'Inactive' }}
        </span>
    </td>

    <!-- Verification -->
    <td class="text-center">
        @switch($customer->verification_status)
            @case('approved')
                <span class="badge bg-success small">Verified</span>
                @if($customer->verified_at)
                    <small class="text-muted d-block">{{ $customer->verified_at->format('M d, Y') }}</small>
                @endif
                @break
            @case('rejected')
                <span class="badge bg-danger small">Rejected</span>
                @break
            @default
                <span class="badge bg-warning small">Pending</span>
        @endswitch
    </td>

    <!-- Payment Status -->
    <td class="text-center">
        @switch($customer->payment_status)
            @case('pending')
                <span class="badge bg-warning small">Pending</span>
                @break
            @case('success')
                <span class="badge bg-success small">Success</span>
                @break
            @case('failed')
                <span class="badge bg-danger small">Failed</span>
                @break
            @default
                <span class="badge bg-secondary small">N/A</span>
        @endswitch
    </td>

    <!-- Payment Link -->
    <td style="max-width: 120px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
        @if($customer->payment_link)
            <a href="{{ $customer->payment_link }}" target="_blank" class="text-decoration-none">Link</a>
        @else
            -
        @endif
    </td>

    <!-- Lucky Draw Coupon -->
    <td class="text-center">{{ $customer->coupon->coupon_code ?? '-' }}</td>

    <!-- QR Code -->
    <td>
        @if($customer->qr_code)
            <img src="{{ $customer->qr_code }}" alt="QR Code" width="100">
        @endif
    </td>

    <!-- Call & WhatsApp -->
   <td class="text-center">
    @php $customerPhone = $customer->mobile ?? ''; @endphp

    @if($customerPhone)
        <!-- Call Icon -->
        <a href="tel:{{ preg_replace('/\D/', '', $customerPhone) }}" 
           class="me-2" 
           title="Call Customer">
            <i class="bi bi-telephone-fill text-success fs-5"></i>
        </a>

        <!-- WhatsApp Icon -->
        <a href="https://wa.me/{{ preg_replace('/\D/', '', $customerPhone) }}" 
           target="_blank" 
           title="WhatsApp Customer">
            <i class="bi bi-whatsapp text-success fs-5"></i>
        </a>
    @else
        <span class="text-muted">No contact</span>
    @endif
</td>


    <!-- Created Date -->
    <td class="text-end small">{{ $customer->created_at->format('M d, Y') }}</td>

    <!-- Actions -->
    <td class="text-center">
        <div class="d-inline-flex">
            <!-- Edit -->
            <a href="{{ route('admin.customers.edit', $customer->id) }}" class="btn btn-sm btn-outline-primary me-1" title="Edit">
                <i class="bi bi-pencil fs-6"></i>
            </a>

            @if($customer->verification_status === 'pending')
                <!-- Approve -->
                <button class="btn btn-sm btn-outline-success btn-verify me-1" data-id="{{ $customer->id }}" data-status="approved" title="Approve Verification">
                    <i class="bi bi-check-lg fs-6"></i>
                </button>

                <!-- Reject -->
                <button class="btn btn-sm btn-outline-danger btn-verify me-1" data-id="{{ $customer->id }}" data-status="rejected" title="Reject Verification">
                    <i class="bi bi-x-lg fs-6"></i>
                </button>
            @endif

            <!-- Delete -->
            <form action="{{ route('admin.customers.destroy', $customer->id) }}" method="POST" class="d-inline delete-form" id="delete-form-{{ $customer->id }}">
                @csrf
                @method('DELETE')
                <button type="button" class="btn btn-sm btn-outline-danger delete-btn" data-id="{{ $customer->id }}" title="Delete">
                    <i class="bi bi-trash fs-6"></i>
                </button>
            </form>
        </div>
    </td>
</tr>
@empty
<tr>
    <td colspan="13" class="text-center py-4 small">No customers found.</td>
</tr>
@endforelse

<script>
document.querySelectorAll('.delete-btn').forEach(button => {
    button.addEventListener('click', function () {
        const customerId = this.getAttribute('data-id');
        const form = document.getElementById('delete-form-' + customerId);

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});
</script>
