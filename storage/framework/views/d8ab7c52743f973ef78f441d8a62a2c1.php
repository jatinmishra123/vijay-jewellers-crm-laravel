

<?php $__env->startSection('title', 'Schemes - Admin Dashboard'); ?>

<?php $__env->startSection('content'); ?>
    <!-- Icons Css -->
    <link href="<?php echo e(asset('assets/assets/css/icons.min.css')); ?>" rel="stylesheet" type="text/css" />
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">Schemes List</h4>
                    <a href="<?php echo e(route('admin.schemes.create')); ?>" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-circle"></i> Add Scheme
                    </a>
                </div>
                <div class="card-body">
                    <!-- Search -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <form method="GET" action="<?php echo e(route('admin.schemes.index')); ?>" class="d-flex">
                                <input type="text" name="search" class="form-control me-2"
                                    placeholder="Search by scheme name..." value="<?php echo e(request('search')); ?>">
                                <button type="submit" class="btn btn-primary">Search</button>
                            </form>
                        </div>
                    </div>

                    <!-- Schemes Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Scheme Name</th>
                                    <th>Description</th>
                                    <th>Duration (Months)</th>
                                    <th>Total Amount</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $schemes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $scheme): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><?php echo e($key + 1); ?></td>
                                        <td><?php echo e($scheme->name); ?></td>
                                        <td>
                                            <?php echo e(\Illuminate\Support\Str::words(strip_tags($scheme->description ?? 'N/A'), 20, '...')); ?>


                                            <?php if(strlen(strip_tags($scheme->description)) > 0): ?>
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#schemeModal<?php echo e($scheme->id); ?>">
                                                    View More
                                                </a>
                                            <?php endif; ?>
                                        </td>
                                        <!-- Scheme Description Modal -->
                                        <div class="modal fade" id="schemeModal<?php echo e($scheme->id); ?>" tabindex="-1"
                                            aria-labelledby="schemeModalLabel<?php echo e($scheme->id); ?>" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="schemeModalLabel<?php echo e($scheme->id); ?>">
                                                            <?php echo e($scheme->name); ?>

                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p><?php echo e(strip_tags($scheme->description)); ?></p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <td><?php echo e($scheme->duration); ?></td>
                                        <td><?php echo e(number_format($scheme->total_amount, 2)); ?></td>
                                        <td><?php echo e($scheme->created_at->format('M d, Y H:i')); ?></td>
                                        <td>
                                            <div class="btn-group" role="group">

                                                <a href="<?php echo e(route('admin.schemes.edit', $scheme->id)); ?>"
                                                    class="btn btn-sm btn-outline-warning me-1">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form action="<?php echo e(route('admin.schemes.destroy', $scheme->id)); ?>" method="POST"
                                                    class="d-inline delete-scheme-form">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-danger btn-delete-scheme">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>

                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="7" class="text-center">No schemes found.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <?php if($schemes->hasPages()): ?>
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div class="text-muted">
                                Showing <?php echo e($schemes->firstItem()); ?> to <?php echo e($schemes->lastItem()); ?> of <?php echo e($schemes->total()); ?>

                                entries
                            </div>
                            <div class="pagination-container">
                                <?php echo e($schemes->appends(request()->query())->links()); ?>

                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Delete Scheme Confirmation
            const deleteButtons = document.querySelectorAll('.btn-delete-scheme');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const form = this.closest('.delete-scheme-form');

                    Swal.fire({
                        title: 'Are you sure?',
                        text: "This scheme will be permanently deleted!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!',
                        reverseButtons: true,
                        focusCancel: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\LENOVO\Downloads\vijay_jwellers\resources\views/admin/schemes/index.blade.php ENDPATH**/ ?>