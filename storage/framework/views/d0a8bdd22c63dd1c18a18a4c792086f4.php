<?php $__empty_1 = true; $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
<tr class="small">
    <!-- Serial -->
    <td class="text-end"><?php echo e($customers->firstItem() + $index); ?></td>

    <!-- Name + Agent -->
    <td style="max-width: 180px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
        <span class="fw-semibold"><?php echo e(Str::limit($customer->name, 40, '...')); ?></span>
        <?php if($customer->agent): ?>
            <small class="text-muted d-block" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                Agent: <?php echo e(Str::limit($customer->agent->name, 25, '...')); ?>

            </small>
        <?php endif; ?>
    </td>

    <!-- Scheme -->
    <td class="text-end"><?php echo e($customer->scheme?->name ?? '-'); ?></td>
   <td class="text-end"><?php echo e($customer->scheme_duration ?? '-'); ?></td>
      <td class="text-end"><?php echo e($customer->scheme_total_amount ?? 'Not Provided'); ?></td>
    <!-- Email -->
    <td style="max-width: 180px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
        <?php echo e($customer->email ?? 'N/A'); ?>

    </td>

    <!-- Mobile -->
    <td class="text-end"><?php echo e($customer->mobile); ?></td>

    <!-- Address -->
    <td style="max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
        <?php echo e(Str::limit($customer->address, 30) ?? 'N/A'); ?>

    </td>

 

    <!-- Status -->
    <td class="text-center">
        <span class="badge <?php echo e($customer->is_active ? 'bg-success' : 'bg-danger'); ?> small">
            <?php echo e($customer->is_active ? 'Active' : 'Inactive'); ?>

        </span>
    </td>

    <!-- Verification -->
    <td class="text-center">
        <?php switch($customer->verification_status):
            case ('approved'): ?>
                <span class="badge bg-success small">Verified</span>
                <?php if($customer->verified_at): ?>
                    <small class="text-muted d-block"><?php echo e($customer->verified_at->format('M d, Y')); ?></small>
                <?php endif; ?>
                <?php break; ?>
            <?php case ('rejected'): ?>
                <span class="badge bg-danger small">Rejected</span>
                <?php break; ?>
            <?php default: ?>
                <span class="badge bg-warning small">Pending</span>
        <?php endswitch; ?>
    </td>

    <!-- Payment Status -->
    <td class="text-center">
        <?php switch($customer->payment_status):
            case ('pending'): ?>
                <span class="badge bg-warning small">Pending</span>
                <?php break; ?>
            <?php case ('success'): ?>
                <span class="badge bg-success small">Success</span>
                <?php break; ?>
            <?php case ('failed'): ?>
                <span class="badge bg-danger small">Failed</span>
                <?php break; ?>
            <?php default: ?>
                <span class="badge bg-secondary small">N/A</span>
        <?php endswitch; ?>
    </td>

    <!-- Payment Link -->
    <td style="max-width: 120px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
        <?php if($customer->payment_link): ?>
            <a href="<?php echo e($customer->payment_link); ?>" target="_blank" class="text-decoration-none">Link</a>
        <?php else: ?>
            -
        <?php endif; ?>
    </td>

    <!-- Lucky Draw Coupon -->
    <td class="text-center"><?php echo e($customer->coupon->coupon_code ?? '-'); ?></td>

    <!-- QR Code -->
    <td>
        <?php if($customer->qr_code): ?>
            <img src="<?php echo e($customer->qr_code); ?>" alt="QR Code" width="100">
        <?php endif; ?>
    </td>

    <!-- Call & WhatsApp -->
   <td class="text-center">
    <?php $customerPhone = $customer->mobile ?? ''; ?>

    <?php if($customerPhone): ?>
        <!-- Call Icon -->
        <a href="tel:<?php echo e(preg_replace('/\D/', '', $customerPhone)); ?>" 
           class="me-2" 
           title="Call Customer">
            <i class="bi bi-telephone-fill text-success fs-5"></i>
        </a>

        <!-- WhatsApp Icon -->
        <a href="https://wa.me/<?php echo e(preg_replace('/\D/', '', $customerPhone)); ?>" 
           target="_blank" 
           title="WhatsApp Customer">
            <i class="bi bi-whatsapp text-success fs-5"></i>
        </a>
    <?php else: ?>
        <span class="text-muted">No contact</span>
    <?php endif; ?>
</td>


    <!-- Created Date -->
    <td class="text-end small"><?php echo e($customer->created_at->format('M d, Y')); ?></td>

    <!-- Actions -->
    <td class="text-center">
        <div class="d-inline-flex">
            <!-- Edit -->
            <a href="<?php echo e(route('admin.customers.edit', $customer->id)); ?>" class="btn btn-sm btn-outline-primary me-1" title="Edit">
                <i class="bi bi-pencil fs-6"></i>
            </a>

            <?php if($customer->verification_status === 'pending'): ?>
                <!-- Approve -->
                <button class="btn btn-sm btn-outline-success btn-verify me-1" data-id="<?php echo e($customer->id); ?>" data-status="approved" title="Approve Verification">
                    <i class="bi bi-check-lg fs-6"></i>
                </button>

                <!-- Reject -->
                <button class="btn btn-sm btn-outline-danger btn-verify me-1" data-id="<?php echo e($customer->id); ?>" data-status="rejected" title="Reject Verification">
                    <i class="bi bi-x-lg fs-6"></i>
                </button>
            <?php endif; ?>

            <!-- Delete -->
            <form action="<?php echo e(route('admin.customers.destroy', $customer->id)); ?>" method="POST" class="d-inline delete-form" id="delete-form-<?php echo e($customer->id); ?>">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <button type="button" class="btn btn-sm btn-outline-danger delete-btn" data-id="<?php echo e($customer->id); ?>" title="Delete">
                    <i class="bi bi-trash fs-6"></i>
                </button>
            </form>
        </div>
    </td>
</tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
<tr>
    <td colspan="13" class="text-center py-4 small">No customers found.</td>
</tr>
<?php endif; ?>

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
<?php /**PATH C:\Users\LENOVO\Downloads\vijay_jwellers\resources\views/admin/customers/partials/table.blade.php ENDPATH**/ ?>