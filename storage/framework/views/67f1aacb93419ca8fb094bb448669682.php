

<?php $__env->startSection('title', 'Edit Role - Vijay Jewellers'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">Edit Role</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Home</a></li>
                            <li class="breadcrumb-item"><a href="<?php echo e(route('admin.roles.index')); ?>">Roles</a></li>
                            <li class="breadcrumb-item active">Edit Role</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-lg-14 mx-auto">
                <div class="card shadow-sm">
                    <div class="card-header text-white bg-primary">
                        <h5 class="mb-0">Role Details</h5>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo e(route('admin.roles.update', $role->id)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PUT'); ?>

                            <!-- Role Name (readonly) -->
                            <div class="mb-3">
                                <label for="name" class="form-label">Role Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="<?php echo e($role->name); ?>" readonly>
                            </div>

                            <!-- Permissions -->
                            <div class="mb-3">
                                <label class="form-label">Permissions</label>
                                <div class="row">
                                    <?php $__currentLoopData = $permissionOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="col-md-6 mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" 
                                                    name="permissions[<?php echo e($key); ?>]" 
                                                    value="true" 
                                                    id="perm-<?php echo e($key); ?>"
                                                    <?php echo e(isset($role->permissions[$key]) && $role->permissions[$key] ? 'checked' : ''); ?>>
                                                <label class="form-check-label" for="perm-<?php echo e($key); ?>">
                                                    <?php echo e($label); ?>

                                                </label>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                                <?php $__errorArgs = ['permissions'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="text-danger"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <a href="<?php echo e(route('admin.roles.index')); ?>" class="btn btn-secondary">Cancel</a>
                                <button type="submit" class="btn btn-success">Update Role</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\LENOVO\Downloads\vijay_jwellers\resources\views/admin/roles/edit.blade.php ENDPATH**/ ?>