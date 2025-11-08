

<?php $__env->startSection('title', 'Scheme Payments - Vijay Jewellers'); ?>

<?php $__env->startPush('styles'); ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            transition: all 0.2s;
        }

        /* Moved icon styles from inline to CSS */
        .stat-icon-wrapper {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .stat-icon {
            font-size: 1.2rem;
        }

        table tbody tr:hover {
            background-color: rgba(0, 123, 255, 0.05);
        }

        table th,
        table td {
            padding: 0.6rem 0.75rem;
            font-size: 0.875rem;
            vertical-align: middle;
        }

        .btn-outline-danger:hover {
            color: #fff;
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .card-header-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            align-items: center;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid">

        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0 fs-5 mt-3">Scheme Payments</h4>
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Home</a></li>
                        <li class="breadcrumb-item active">Scheme Payments</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="row g-3 mb-3">
            <?php
                $cards = [
                    ['title' => 'Total Payments', 'count' => $summary['total'] ?? 0, 'icon' => 'bi-bag-fill', 'bg' => 'linear-gradient(135deg,#4e73df,#224abe)'],
                    ['title' => 'Successful', 'count' => $summary['successful'] ?? 0, 'icon' => 'bi-check-circle-fill', 'bg' => 'linear-gradient(135deg,#1cc88a,#17a673)'],
                    ['title' => 'Failed', 'count' => $summary['failed'] ?? 0, 'icon' => 'bi-x-circle-fill', 'bg' => 'linear-gradient(135deg,#e74a3b,#c82333)'],
                    ['title' => 'Pending', 'count' => $summary['pending'] ?? 0, 'icon' => 'bi-clock-fill', 'bg' => 'linear-gradient(135deg,#f6c23e,#dda20a)']
                ];
            ?>

            <?php $__currentLoopData = $cards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-sm-6 col-md-3">
                    <div class="card shadow-sm text-white stat-card" style="background: <?php echo e($card['bg']); ?>; border-radius:12px;">
                        <div class="card-body text-center py-3">
                            
                            <div class="stat-icon-wrapper mb-2 mx-auto">
                                <i class="bi <?php echo e($card['icon']); ?> fs-5 stat-icon"></i>
                            </div>
                            <h4 class="mb-0 fs-3"><?php echo e(number_format($card['count'])); ?></h4>
                            <p class="mb-0 small"><?php echo e($card['title']); ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <div class="card shadow-sm">
            <div class="card-header bg-light py-3">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <h5 class="mb-0 card-title">All Payments</h5>
<a href="<?php echo e(route('admin.scheme_payments.create')); ?>" class="btn btn-outline-info btn-sm">
    Add Payments
</a>


                    
                    <div class="card-header-actions">
                        
                        <form action="" method="GET" class="d-inline-flex">
                            <input type="text" class="form-control form-control-sm me-2" name="search"
                                placeholder="Search customer, scheme..." value="<?php echo e(request('search')); ?>">
                            <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-search"></i></button>
                        </form>

                        
                        <a href="<?php echo e(route('admin.scheme_payments.export', ['type' => 'csv'])); ?>"
                            class="btn btn-success btn-sm">
                            <i class="bi bi-file-earmark-spreadsheet-fill"></i> CSV
                        </a>
                        <a href="<?php echo e(route('admin.scheme_payments.export', ['type' => 'excel'])); ?>"
                            class="btn btn-warning btn-sm">
                            <i class="bi bi-file-earmark-excel-fill"></i> Excel
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body p-3">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover align-middle mb-0 text-center">
                        <thead class="bg-light text-dark">
                            <tr>
                                <th>ID</th>
                                <th>Customer</th>
                                <th>Scheme</th>
                                <th>Duration</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Method</th>
                                <th>Due_Date</th>
                                <th>Paid_At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $schemePayments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e($payment->id); ?></td>
                                    <td><?php echo e(optional($payment->customer)->name ?? '-'); ?></td>
                                    <td><?php echo e(optional($payment->scheme)->name ?? '-'); ?></td>
                                    <td><?php echo e($payment->payment_duration ?? '-'); ?></td>
                                    <td class="text-end"><?php echo e($payment->amount ? number_format($payment->amount, 2) : '0.00'); ?>

                                    </td>
                                    <td>
                                        
                                        <?php
                                            $status = $payment->status ?? 'Unknown';
                                            switch ($status) {
                                                case 'success':
                                                    $badgeClass = 'bg-success';
                                                    break;
                                                case 'failed':
                                                    $badgeClass = 'bg-danger';
                                                    break;
                                                case 'pending':
                                                    $badgeClass = 'bg-warning text-dark';
                                                    break;
                                                default:
                                                    $badgeClass = 'bg-secondary';
                                            }
                                        ?>
                                        <span class="badge <?php echo e($badgeClass); ?>"><?php echo e(ucfirst($status)); ?></span>
                                    </td>
                                    <td><?php echo e($payment->method ?? '-'); ?></td>
                                    <td><?php echo e($payment->due_date ?? '-'); ?></td>
                                    <td><?php echo e($payment->paid_at ?? '-'); ?></td>
                                    <td>
                                        <form action="<?php echo e(route('admin.scheme_payments.destroy', $payment->id)); ?>" method="POST"
                                            class="delete-payment d-inline">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="10" class="text-muted text-center py-4">No scheme payments found</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            
            <?php if($schemePayments->hasPages()): ?>
                <div class="card-footer bg-light">
                    
                    <?php echo e($schemePayments->appends(request()->query())->links()); ?>

                </div>
            <?php endif; ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Delete buttons confirmation
            document.querySelectorAll('.delete-payment').forEach(function (formBtn) {
                formBtn.addEventListener('submit', function (e) {
                    e.preventDefault(); // prevent default form submit

                    Swal.fire({
                        title: 'Are you sure?',
                        text: "Do you really want to delete this record?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc3545',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Yes, delete it!',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            formBtn.submit(); // submit form if confirmed
                        }
                    });
                });
            });

            // Show success message from session
            <?php if(session('success')): ?>
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: '<?php echo e(session("success")); ?>',
                    timer: 2500,
                    showConfirmButton: false
                });
            <?php endif; ?>
                    });
    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\LENOVO\Downloads\vijay_jwellers\resources\views/admin/scheme_payments/index.blade.php ENDPATH**/ ?>