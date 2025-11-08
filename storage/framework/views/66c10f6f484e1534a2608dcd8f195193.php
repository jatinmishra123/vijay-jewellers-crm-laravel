

<?php $__env->startSection('title', 'Edit Customer - Admin Dashboard'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white p-3">
                        <h5 class="mb-0 fs-6">Edit Customer</h5>
                    </div>
                    <div class="card-body p-3">
                        <form method="POST" action="<?php echo e(route('admin.customers.update', $customer->id)); ?>">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PUT'); ?>

                            <!-- Display success/error messages -->
                            <?php if(session('success')): ?>
                                <div class="alert alert-success alert-dismissible fade show py-2">
                                    <small><?php echo e(session('success')); ?></small>
                                    <button type="button" class="btn-close p-2" data-bs-dismiss="alert"></button>
                                </div>
                            <?php endif; ?>

                            <?php if(session('error')): ?>
                                <div class="alert alert-danger alert-dismissible fade show py-2">
                                    <small><?php echo e(session('error')); ?></small>
                                    <button type="button" class="btn-close p-2" data-bs-dismiss="alert"></button>
                                </div>
                            <?php endif; ?>

                            <div class="row g-2">
                                <!-- Name -->
                                <div class="col-md-6">
                                    <label for="name" class="form-label small">Full Name *</label>
                                    <input type="text" name="name" id="name"
                                        class="form-control form-control-sm <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        value="<?php echo e(old('name', $customer->name)); ?>" required>
                                    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback small"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <!-- Email -->
                                <div class="col-md-6">
                                    <label for="email" class="form-label small">Email Address</label>
                                    <input type="email" name="email" id="email"
                                        class="form-control form-control-sm <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        value="<?php echo e(old('email', $customer->email)); ?>">
                                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback small"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <!-- Mobile -->
                                <div class="col-md-6">
                                    <label for="mobile" class="form-label small">Mobile Number *</label>
                                    <input type="text" name="mobile" id="mobile"
                                        class="form-control form-control-sm <?php $__errorArgs = ['mobile'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        value="<?php echo e(old('mobile', $customer->mobile)); ?>" required>
                                    <?php $__errorArgs = ['mobile'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback small"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <!-- Status -->
                                <div class="col-md-6">
                                    <label for="is_active" class="form-label small">Status *</label>
                                    <select name="is_active" id="is_active"
                                        class="form-select form-select-sm <?php $__errorArgs = ['is_active'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        required>
                                        <option value="1" <?php echo e(old('is_active', $customer->is_active) == 1 ? 'selected' : ''); ?>>
                                            Active
                                        </option>
                                        <option value="0" <?php echo e(old('is_active', $customer->is_active) == 0 ? 'selected' : ''); ?>>
                                            Inactive
                                        </option>
                                    </select>
                                    <?php $__errorArgs = ['is_active'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback small"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <!-- Verification Status -->
                                <div class="col-md-6">
                                    <label for="verification_status" class="form-label small">Verification Status *</label>
                                    <select name="verification_status" id="verification_status"
                                        class="form-select form-select-sm <?php $__errorArgs = ['verification_status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        required>
                                        <option value="pending" <?php echo e(old('verification_status', $customer->verification_status) == 'pending' ? 'selected' : ''); ?>>Pending</option>
                                        <option value="approved" <?php echo e(old('verification_status', $customer->verification_status) == 'approved' ? 'selected' : ''); ?>>Approved
                                        </option>
                                        <option value="rejected" <?php echo e(old('verification_status', $customer->verification_status) == 'rejected' ? 'selected' : ''); ?>>Rejected
                                        </option>
                                    </select>
                                    <?php $__errorArgs = ['verification_status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback small"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <!-- Agent Assignment (only for admin/manager) -->
                                <?php if(isset($agents) && count($agents) > 0 && auth()->user()->role_id != 3): ?>
                                    <div class="col-md-6">
                                        <label for="agent_id" class="form-label small">Assign Agent</label>
                                        <select name="agent_id" id="agent_id"
                                            class="form-select form-select-sm <?php $__errorArgs = ['agent_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                            <option value="">-- Select Agent --</option>
                                            <?php $__currentLoopData = $agents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $agent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($agent->id); ?>" <?php echo e(old('agent_id', $customer->agent_id) == $agent->id ? 'selected' : ''); ?>>
                                                    <?php echo e($agent->name); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                        <?php $__errorArgs = ['agent_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback small"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                <?php endif; ?>

                                <!-- Token/QR Code -->
                                <div class="col-md-6">
                                    <label for="token" class="form-label small">Token / QR Code</label>
                                    <input type="text" name="token" id="token"
                                        class="form-control form-control-sm <?php $__errorArgs = ['token'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        value="<?php echo e(old('token', $customer->token)); ?>" placeholder="Auto-generated or manual">
                                    <?php $__errorArgs = ['token'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback small"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <!-- Payment Status -->
                                <div class="col-md-6">
                                    <label for="payment_status" class="form-label small">Payment Status</label>
                                    <select name="payment_status" id="payment_status"
                                        class="form-select form-select-sm <?php $__errorArgs = ['payment_status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                        <option value="pending" <?php echo e(old('payment_status', $customer->payment_status) == 'pending' ? 'selected' : ''); ?>>Pending</option>
                                        <option value="success" <?php echo e(old('payment_status', $customer->payment_status) == 'success' ? 'selected' : ''); ?>>Success</option>
                                        <option value="failed" <?php echo e(old('payment_status', $customer->payment_status) == 'failed' ? 'selected' : ''); ?>>Failed</option>
                                    </select>
                                    <?php $__errorArgs = ['payment_status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback small"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <!-- Payment Link -->
                                <div class="col-md-6">
                                    <label for="payment_link" class="form-label small">Payment Link</label>
                                    <input type="text" name="payment_link" id="payment_link"
                                        class="form-control form-control-sm <?php $__errorArgs = ['payment_link'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        value="<?php echo e(old('payment_link', $customer->payment_link)); ?>"
                                        placeholder="Enter payment link if any">
                                    <?php $__errorArgs = ['payment_link'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback small"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <!-- Address -->
                                <div class="col-12">
                                    <label for="address" class="form-label small">Address</label>
                                    <textarea name="address" id="address" rows="2"
                                        class="form-control form-control-sm <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"><?php echo e(old('address', $customer->address)); ?></textarea>
                                    <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback small"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <!-- Verification Notes -->
                                <div class="col-12">
                                    <label for="verification_notes" class="form-label small">Verification Notes</label>
                                    <textarea name="verification_notes" id="verification_notes" rows="2"
                                        class="form-control form-control-sm <?php $__errorArgs = ['verification_notes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        placeholder="Optional notes about verification"><?php echo e(old('verification_notes', $customer->verification_notes)); ?></textarea>
                                    <?php $__errorArgs = ['verification_notes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback small"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2 mt-3">
                                <a href="<?php echo e(route('admin.customers.index')); ?>" class="btn btn-secondary btn-sm">Cancel</a>
                                <button type="submit" class="btn btn-primary btn-sm">Update Customer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
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
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
 <?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form');
    const messageDiv = document.createElement('div');
    form.prepend(messageDiv);

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        const submitBtn = form.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.innerHTML = `<span class="spinner-border spinner-border-sm"></span> Updating...`;

        const formData = new FormData(form);

        fetch(form.action, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "<?php echo e(csrf_token()); ?>",
                "Accept": "application/json",
                "X-Requested-With": "XMLHttpRequest"
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                messageDiv.innerHTML = `
                    <div class="alert alert-success">${data.message}</div>
                    ${data.payment_link ? `
                        <div class="mt-3 border rounded p-2 bg-light">
                            <label class="small fw-bold mb-1">Payment Link:</label>
                            <input type="text" id="generatedPaymentLink" 
                                   class="form-control form-control-sm mb-2" 
                                   value="${data.payment_link}" readonly>

                            <div class="d-flex gap-2">
                                <button id="copyLinkBtn" class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-clipboard"></i> Copy Link
                                </button>
                                <a href="${data.payment_link}" target="_blank" 
                                   class="btn btn-sm btn-success">
                                   <i class="bi bi-box-arrow-up-right"></i> Open Link
                                </a>
                            </div>
                        </div>
                    ` : ''}
                `;

                const copyBtn = document.getElementById('copyLinkBtn');
                if (copyBtn) {
                    copyBtn.addEventListener('click', function () {
                        const linkField = document.getElementById('generatedPaymentLink');
                        navigator.clipboard.writeText(linkField.value);
                        this.innerHTML = '<i class="bi bi-check2-circle text-success"></i> Copied!';
                        setTimeout(() => {
                            this.innerHTML = '<i class="bi bi-clipboard"></i> Copy Link';
                        }, 2000);
                    });
                }

                submitBtn.innerHTML = 'Update Customer';
                submitBtn.disabled = false;
            } else {
                messageDiv.innerHTML = `<div class="alert alert-danger">Error: ${data.message || 'Something went wrong.'}</div>`;
                submitBtn.disabled = false;
                submitBtn.innerHTML = 'Update Customer';
            }
        })
        .catch(err => {
            messageDiv.innerHTML = `<div class="alert alert-danger">Server not responding. Please try again.</div>`;
            submitBtn.disabled = false;
            submitBtn.innerHTML = 'Update Customer';
        });
    });
});
</script>
<?php $__env->stopPush(); ?>

<?php $__env->stopPush(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\LENOVO\Downloads\vijay_jwellers\resources\views/admin/customers/edit.blade.php ENDPATH**/ ?>