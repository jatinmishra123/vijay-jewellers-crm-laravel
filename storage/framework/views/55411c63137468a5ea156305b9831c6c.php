

<?php $__env->startSection('title', 'Role Management - Vijay Jewellers'); ?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
        <!-- Page title -->
        <div class="row mb-3">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between py-2">
                    <h4 class="mb-0 fs-5">Role Management</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0 p-0">
                            <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>" class="small">Home</a></li>
                            <li class="breadcrumb-item active small">Role Management</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header  text-white p-3">
                        <h5 class="mb-0 fs-">Roles List</h5>
                    </div>
                    <div class="card-body p-3">
                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-between align-items-right mb-3">
                            <a href="<?php echo e(route('admin.roles.create')); ?>" class="btn btn-primary btn-sm small">
                                <i class="bi bi-plus-circle me-1 fs-6"></i> Add New Role
                            </a>

                        </div>

                        <!-- Success/Error Messages -->
                        <?php if(session('success')): ?>
                            <div class="alert alert-success alert-dismissible fade show py-2" role="alert">
                                <small><?php echo e(session('success')); ?></small>
                                <button type="button" class="btn-close p-2" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <?php if(session('error')): ?>
                            <div class="alert alert-danger alert-dismissible fade show py-2" role="alert">
                                <small><?php echo e(session('error')); ?></small>
                                <button type="button" class="btn-close p-2" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <!-- Roles Table -->
                        <div class="table-responsive">
                            <table class="table table-sm table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th class="small">#</th>
                                        <th class="small">Role Name</th>
                                        <th class="small">Permissions</th>
                                        <th class="small text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td class="small"><?php echo e($index + 1); ?></td>
                                            <td class="small fw-semibold"><?php echo e($role->name); ?></td>
                                            <td>
                                                <?php if(isset($role->permissions) && is_array($role->permissions)): ?>
                                                    <div class="d-flex flex-wrap gap-1">
                                                        <?php $__currentLoopData = $role->permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php if($value === true): ?>
                                                                <span class="badge bg-info text-dark small"><?php echo e($key); ?></span>
                                                            <?php endif; ?>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </div>
                                                <?php else: ?>
                                                    <span class="text-muted small">No permissions</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <a href="<?php echo e(route('admin.roles.edit', $role->id)); ?>"
                                                    class="btn btn-sm btn-outline-warning mb-2">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form action="<?php echo e(route('admin.roles.destroy', $role->id)); ?>" method="POST"
                                                    class="d-inline">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                                        onclick="return confirm('Are you sure you want to delete this role?')">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
    <style>
        .card {
            border-radius: 8px;
        }

        .table {
            font-size: 0.875rem;
        }

        .table th,
        .table td {
            padding: 0.5rem;
            vertical-align: middle;
        }

        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }

        .badge {
            font-size: 0.75rem;
            padding: 0.35em 0.65em;
        }

        .alert {
            font-size: 0.875rem;
            margin-bottom: 1rem;
        }

        .breadcrumb {
            font-size: 0.875rem;
            margin-bottom: 0;
        }

        .card-header {
            padding: 0.75rem 1rem;
        }

        .card-body {
            padding: 1rem;
        }
    </style>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\LENOVO\Downloads\vijay_jwellers\resources\views/admin/roles/index.blade.php ENDPATH**/ ?>