

<?php $__env->startSection('content'); ?>
<div class="container py-4">

    <div class="card shadow-sm border-0">
        <div class="card-header bg-info text-white">
            <h4 class="mb-0">Add Scheme Payment</h4>
        </div>

        <div class="card-body">

            <form action="<?php echo e(route('admin.scheme_payments.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Customer</label>
                        <select name="customer_id" class="form-select select2" required>
                            <option value="">Search Customer...</option>
                            <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($c->id); ?>"><?php echo e($c->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Scheme</label>
                        <select name="scheme_id" class="form-select select2" required>
                            <option value="">Search Scheme...</option>
                            <?php $__currentLoopData = $schemes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($s->id); ?>"><?php echo e($s->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Amount</label>
                        <input type="number" name="amount" class="form-control" required placeholder="Enter Payment Amount">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Payment Duration</label>
                        <input type="text" name="payment_duration" class="form-control" required placeholder="e.g. 12 Months">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Payment Status</label>
                        <select name="status" class="form-select" required>
                            <option value="pending">Pending</option>
                            <option value="success">Success</option>
                            <option value="failed">Failed</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Payment Method</label>
                        <input type="text" name="method" class="form-control" placeholder="UPI / Cash / Bank Transfer">
                    </div>

                    <div class="col-12 mb-3 " >
                        <label class="form-label">Notes</label>
                        <textarea name="notes" class="form-control" rows="3" placeholder="Any additional information"></textarea>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Due Date</label>
                        <input type="date" name="due_date" class="form-control" required>
                    </div>

                    <div class="col-md-6 mb-4">
                        <label class="form-label">Paid At (If Paid)</label>
                        <input type="date" name="paid_at" class="form-control">
                    </div>
                </div>

                <div class="text-end">
                    <button class="btn btn-primary px-4">Save Payment</button>
                </div>

            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: "Search here...",
            allowClear: true,
            width: '100%'
        });
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\LENOVO\Downloads\vijay_jwellers\resources\views/admin/scheme_payments/create.blade.php ENDPATH**/ ?>