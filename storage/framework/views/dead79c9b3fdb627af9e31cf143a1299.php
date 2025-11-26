

<?php $__env->startSection('title', 'Add Scheme - Admin Dashboard'); ?>

<?php $__env->startSection('content'); ?>
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card shadow-sm">
                <div class="card-header  text-white">
                    <h4 class="card-title mb-0">Add New Scheme</h4>
                </div>
                <div class="card-body">
                    <form action="<?php echo e(route('admin.schemes.store')); ?>" method="POST">
                        <?php echo csrf_field(); ?>

                        <!-- Scheme Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Scheme Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" id="name" placeholder="Enter the name..." value="<?php echo e(old('name')); ?>"
                                required>
                            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <small class="text-danger"><?php echo e($message); ?></small>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" class="form-control" id="description" placeholder="Enter the description..."
                                rows="3"><?php echo e(old('description')); ?></textarea>
                            <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <small class="text-danger"><?php echo e($message); ?></small>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Duration -->
                        <div class="mb-3">
                            <label for="duration" class="form-label">Duration (Months) <span
                                    class="text-danger">*</span></label>
                            <input type="number" name="duration" class="form-control" id="duration"  placeholder="enter the duration Months..."
                                value="<?php echo e(old('duration')); ?>" min="1" required>
                            <?php $__errorArgs = ['duration'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <small class="text-danger"><?php echo e($message); ?></small>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Total Amount -->
                        <div class="mb-3">
                            <label for="total_amount" class="form-label">Total Amount <span
                                    class="text-danger">*</span></label>
                            <input type="number" name="total_amount" class="form-control" id="total_amount" placeholder="Enter the total amount..."
                                value="<?php echo e(old('total_amount')); ?>" step="0.01" min="0" required>
                            <?php $__errorArgs = ['total_amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <small class="text-danger"><?php echo e($message); ?></small>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex justify-content-end">
                            <a href="<?php echo e(route('admin.schemes.index')); ?>" class="btn btn-secondary me-2">Cancel</a>
                            <button type="submit" class="btn btn-primary">Add Scheme</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\LENOVO\Downloads\vijay_jwellers\resources\views/admin/schemes/create.blade.php ENDPATH**/ ?>