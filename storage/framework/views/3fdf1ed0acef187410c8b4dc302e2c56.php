

<?php $__env->startSection('title', 'Add Customer - Admin Dashboard'); ?>

<?php $__env->startSection('content'); ?>
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card border-0 shadow-sm">
                                        <div class="card-header bg-white p-3">
                                            <h5 class="mb-0 fs-6">Add New Customer</h5>
                                        </div>
                                        <div class="card-body p-3">
                                            <form id="customer-form" method="POST" action="<?php echo e(route('admin.customers.store')); ?>">
                                                <?php echo csrf_field(); ?>

                                                <div id="form-message"></div>

                                                <div class="row g-2">
                                                    <!-- Name -->
                                                    <div class="col-md-6">
                                                        <label for="name" class="form-label small">Full Name *</label>
                                                        <input type="text" name="name" id="name" value="<?php echo e(old('name')); ?>"
                                                            placeholder="Enter full name" class="form-control form-control-sm" required>
                                                    </div>
                                            <div class="col-md-6">
                                                <label for="scheme_id" class="form-label small">Scheme *</label>
                                            <select name="scheme_id" id="scheme_id" class="form-select form-select-sm" required>
                                                <option value="">-- Select Scheme --</option>
                                                <?php $__currentLoopData = $schemes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $scheme): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($scheme->id); ?>" data-duration="<?php echo e($scheme->duration); ?>" data-total="<?php echo e($scheme->total_amount); ?>"
                                                        <?php echo e(old('scheme_id', $customer->scheme_id ?? '') == $scheme->id ? 'selected' : ''); ?>>
                                                        <?php echo e($scheme->name); ?>

                                                    </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>

                                            </div>

        <!-- time and duration and amount  -->
      <div class="col-md-6">
        <label for="scheme_duration" class="form-label small">Scheme Duration</label>
        <input type="text" id="scheme_duration" name="scheme_duration" 
               class="form-control form-control-sm" 
               value="<?php echo e(old('scheme_duration')); ?>" readonly>
    </div>

    <div class="col-md-6">
        <label for="scheme_total_amount" class="form-label small">Scheme Total Amount (₹)</label>
        <input type="text" id="scheme_total_amount" name="scheme_total_amount" 
               class="form-control form-control-sm" 
               value="<?php echo e(old('scheme_total_amount')); ?>" readonly>
    </div>


        <!-- end  -->
                                                    <!-- Email -->
                                                    <div class="col-md-6">
                                                        <label for="email" class="form-label small">Email</label>
                                                        <input type="email" name="email" id="email" value="<?php echo e(old('email')); ?>"
                                                            placeholder="Enter email" class="form-control form-control-sm">
                                                    </div>

                                                    <!-- Mobile -->
                                                    <div class="col-md-6">
                                                        <label for="mobile" class="form-label small">Mobile *</label>
                                                        <input type="text" name="mobile" id="mobile" value="<?php echo e(old('mobile')); ?>"
                                                            placeholder="Enter mobile number" class="form-control form-control-sm" required>
                                                    </div>
               <div class="col-6">
                                            <label for="mtoken" class="form-label small">Token</label>
                                            <input type="text" 
                                                name="mtoken" 
                                                id="mtoken" 
                                                placeholder="Enter mtoken..." 
                                                value="<?php echo e(old('mtoken')); ?>" 
                                                class="form-control form-control-sm">
                                                        </div>
                                                    <!-- Status -->
                                                    <div class="col-md-6">
                                                        <label for="is_active" class="form-label small">Status *</label>
                                                        <select name="is_active" id="is_active" class="form-select form-select-sm" required>
                                                            <option value="1" <?php echo e(old('is_active', 1) == 1 ? 'selected' : ''); ?>>Active</option>
                                                            <option value="0" <?php echo e(old('is_active') == 0 ? 'selected' : ''); ?>>Inactive</option>
                                                        </select>
                                                    </div>

                                                    <!-- Address -->
                                                    <div class="col-12">
                                                        <label for="address" class="form-label small">Address</label>
                                                        <textarea name="address" id="address" rows="2" placeholder="Enter address"
                                                            class="form-control form-control-sm"><?php echo e(old('address')); ?></textarea>
                                                    </div>




                                                    <!-- Assigned Agent -->
                                                    <?php if(auth()->user()->role_id != 3): ?>
                                                        <div class="col-md-6">
                                                            <label for="agent_id" class="form-label small">Assign to Agent</label>
                                                            <select name="agent_id" id="agent_id" class="form-select form-select-sm">
                                                                <option value="">-- Select Agent --</option>
                                                                <?php $__currentLoopData = $agents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $agent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <option value="<?php echo e($agent->id); ?>" <?php echo e(old('agent_id') == $agent->id ? 'selected' : ''); ?>>
                                                                        <?php echo e($agent->name); ?>

                                                                    </option>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            </select>
                                                        </div>
                                                    <?php endif; ?>



                                                   <!-- Payment Link -->
<div class="col-md-6">
    <label for="payment_link" class="form-label small">Payment Link</label>
    <input type="text" name="payment_link" id="payment_link"
        value="<?php echo e(old('payment_link')); ?>"
        placeholder="Auto generated after save"
        class="form-control form-control-sm"
        readonly>
</div>



                                                </div>

                                                <div class="d-flex justify-content-end gap-2 mt-3">
                                                    <a href="<?php echo e(route('admin.customers.index')); ?>" class="btn btn-secondary btn-sm">Cancel</a>
                                                    <button type="submit" class="btn btn-primary btn-sm">Create Customer</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
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
        submitBtn.innerHTML = `
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> 
            Creating...
        `;
        messageDiv.innerHTML = '';

        fetch(form.action, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "<?php echo e(csrf_token()); ?>",
                "Accept": "application/json",
                "X-Requested-With": "XMLHttpRequest"
            },
            body: formData,
            credentials: "same-origin"
        })
        .then(response => response.json())
        .then(data => {
            console.log("Server Response:", data);

            if (data.success) {
                // ✅ Success message
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

                // ✅ Copy button functionality
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

                // ✅ Reset & Redirect (optional delay)
                form.reset();
                submitBtn.innerHTML = 'Create Customer';
                submitBtn.disabled = false;

                // 3 सेकंड बाद redirect
                setTimeout(() => {
                    window.location.href = "<?php echo e(route('admin.customers.index')); ?>";
                }, 3000);
            } 
            else if (data.errors) {
                // ❌ Validation errors
                let errors = '<div class="alert alert-danger"><ul class="mb-0">';
                for (let key in data.errors) {
                    errors += `<li>${data.errors[key][0]}</li>`;
                }
                errors += '</ul></div>';
                messageDiv.innerHTML = errors;
            } 
            else {
                // ❌ General error message
                messageDiv.innerHTML = `
                    <div class="alert alert-danger">
                        ${data.message || 'Something went wrong. Please try again.'}
                    </div>`;
            }
        })
        .catch(err => {
            console.error('Fetch Error:', err);
            messageDiv.innerHTML = `
                <div class="alert alert-danger">
                    <strong>Error:</strong> Server not responding. Please try again.
                </div>`;
        })
        .finally(() => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = 'Create Customer';
        });
    });
});
</script>


<?php $__env->stopPush(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\LENOVO\Downloads\vijay_jwellers\resources\views/admin/customers/create.blade.php ENDPATH**/ ?>