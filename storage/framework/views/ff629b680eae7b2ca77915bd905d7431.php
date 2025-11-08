<?php $__env->startSection('title', 'Dashboard - Vijay Jewellers'); ?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
        <!-- Page title -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 fs-5 mt-3">Dashboard</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0 p-0">
                            <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards - Compact Design -->
        <div class="row g-3">
            <?php
                $user = auth()->user();
                $userRole = $user && $user->role ? $user->role->name : 'No Role';
            ?>

            <?php if(in_array($userRole, ['Admin', 'Manager', 'Executive'])): ?>
                <div class="col-xl-2 col-md-4 col-sm-6">
                    <div class="card stat-card customers border-0 shadow-sm">
                        <div class="card-body p-3 text-center">
                            <div class="stat-icon mb-2 mx-auto">
                                <i class="bi bi-people-fill text-white fs-5"></i>
                            </div>
                            <h4 class="mb-0 text-black fs-1 "><?php echo e(number_format($stats['total_customers'] ?? 0)); ?></h4>
                            <p class="mb-0 text-black-50 small">Customers</p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if(in_array($userRole, ['Admin', 'Accounts'])): ?>
                <div class="col-xl-4 col-md-4 col-sm-6">
                    <div class="card stat-card sales border-0 shadow-sm">
                        <div class="card-body p-3 text-center">
                            <div class="stat-icon mb-2 mx-auto">
                                <i class="bi bi-currency-rupee text-white fs-5"></i>
                            </div>
                            <h4 class="mb-3 text-blackfs-1 "><?php echo e(number_format($stats['total_sales'] ?? 0)); ?></h4>
                            <p class="mb-0 text-black-50 small">Sales</p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if(in_array($userRole, ['Admin', 'Manager'])): ?>
                <div class="col-xl-2 col-md-4 col-sm-6">
                    <div class="card stat-card schemes border-0 shadow-sm">
                        <div class="card-body p-3 text-center">
                            <div class="stat-icon mb-2 mx-auto">
                                <i class="bi bi-gift text-white fs-5"></i>
                            </div>
                            <h4 class="mb-0 text-black fs-1 "><?php echo e(number_format($stats['total_schemes'] ?? 0)); ?></h4>
                            <p class="mb-0 text-black-50 small">Schemes</p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if(in_array($userRole, ['Admin', 'Accounts'])): ?>
                <div class="col-xl-2 col-md-4 col-sm-6">
                    <div class="card stat-card payments border-0 shadow-sm">
                        <div class="card-body p-3 text-center">
                            <div class="stat-icon mb-2 mx-auto">
                                <i class="bi bi-wallet2 text-white fs-5"></i>
                            </div>
                            <h4 class="mb-0 text-black fs-1 "><?php echo e(number_format($stats['total_payments'] ?? 0)); ?></h4>
                            <p class="mb-0 text-black-50 small">Payments</p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if($userRole === 'Admin'): ?>
                <div class="col-xl-2 col-md-4 col-sm-6">
                    <div class="card stat-card profit border-0 shadow-sm">
                        <div class="card-body p-3 text-center">
                            <div class="stat-icon mb-2 mx-auto">
                                <i class="bi bi-bar-chart-line text-white fs-5"></i>
                            </div>
                            <h4 class="mb-0 text-black fs-1"><?php echo e(number_format($stats['profit'] ?? 0)); ?></h4>
                            <p class="mb-0 text-black-50 small">Profit</p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if($userRole === 'Executive'): ?>
                <div class="col-xl-2 col-md-4 col-sm-6">
                    <div class="card stat-card executive border-0 shadow-sm">
                        <div class="card-body p-3 text-center">
                            <div class="stat-icon mb-2 mx-auto">
                                <i class="bi bi-person-check text-white fs-5"></i>
                            </div>
                            <h4 class="mb-0 text-white fs-6 fw-bold"><?php echo e(number_format($stats['my_customers'] ?? 0)); ?></h4>
                            <p class="mb-0 text-white-50 small">My Customers</p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Quick Actions Row -->
        <div class="row mt-4 g-3">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-3">
                        <h6 class="card-title mb-3 fw-semibold">Quick Actions</h6>
                        <div class="d-flex flex-wrap gap-2">
                            <a href="<?php echo e(route('admin.customers.create')); ?>" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-person-plus me-1"></i>Add Customer
                            </a>
                            <a href="<?php echo e(route('admin.customers.index')); ?>" class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-list-ul me-1"></i>View Customers
                            </a>
                            <a href="<?php echo e(route('exports.pdf', 'customers')); ?>" class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-file-earmark-pdf me-1"></i>Export PDF
                            </a>
                            <a href="<?php echo e(route('exports.excel', 'sales')); ?>" class="btn btn-sm btn-outline-success">
                                <i class="bi bi-file-earmark-excel me-1"></i>Export Excel
                            </a>
                            <button class="btn btn-sm btn-outline-info" onclick="sendWhatsAppReport()">
                                <i class="bi bi-whatsapp me-1"></i>Send WhatsApp
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity & Charts Row -->
        <div class="row mt-4 g-3">
            <!-- Recent Customers -->
            <?php if(isset($recentCustomers) && $recentCustomers->count() > 0): ?>
                <div class="col-xl-6 col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-transparent border-0 p-3">
                            <h6 class="mb-0 fw-semibold">Recent Customers</h6>
                        </div>
                        <div class="card-body p-3">
                            <div class="table-responsive">
                                <table class="table table-sm table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="small">Name</th>
                                            <th scope="col" class="small">Phone</th>
                                            <th scope="col" class="small">Joined</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $recentCustomers->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td class="small"><?php echo e($customer->name); ?></td>
                                                <td class="small"><?php echo e($customer->mobile); ?></td>
                                                <td class="small"><?php echo e($customer->created_at->format('d/m/Y')); ?></td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Recent Payments -->
            <?php if(isset($recentPayments) && $recentPayments->count() > 0): ?>
                <div class="col-xl-6 col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-transparent border-0 p-3">
                            <h6 class="mb-0 fw-semibold">Recent Payments</h6>
                        </div>
                        <div class="card-body p-3">
                            <div class="table-responsive">
                                <table class="table table-sm table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="small">Customer</th>
                                            <th scope="col" class="small">Amount</th>
                                            <th scope="col" class="small">Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $recentPayments->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td class="small"><?php echo e($payment->customer->name ?? 'N/A'); ?></td>
                                                <td class="small">₹<?php echo e(number_format($payment->amount, 2)); ?></td>
                                                <td class="small"><?php echo e($payment->payment_date->format('d/m/Y')); ?></td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Admin Role Management Section -->
        <?php if($userRole === 'Admin' && isset($roles)): ?>
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-info text-white p-3">
                            <h6 class="mb-0">Role Management</h6>
                        </div>
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="small text-muted">Manage user roles and permissions</span>
                                <a href="<?php echo e(route('admin.roles.create')); ?>" class="btn btn-sm btn-primary">
                                    <i class="bi bi-plus-circle me-1"></i>Add Role
                                </a>
                            </div>

                            <?php if($roles->count() > 0): ?>
                                <div class="table-responsive">
                                    <table class="table table-sm table-hover">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="small">Role</th>
                                                <th scope="col" class="small">Permissions</th>
                                                <th scope="col" class="small">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php if($role): ?>
                                                    <tr>
                                                        <td class="small fw-semibold"><?php echo e($role->name ?? 'N/A'); ?></td>
                                                        <td>
                                                            <?php if(isset($role->permissions) && is_array($role->permissions)): ?>
                                                                <div class="d-flex flex-wrap gap-1">
                                                                    <?php $__currentLoopData = array_slice($role->permissions, 0, 3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <?php if($value === true): ?>
                                                                            <span class="badge bg-info text-dark small"><?php echo e($key); ?></span>
                                                                        <?php endif; ?>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                    <?php if(count($role->permissions) > 3): ?>
                                                                        <span class="badge bg-secondary small">+<?php echo e(count($role->permissions) - 3); ?>

                                                                            more</span>
                                                                    <?php endif; ?>
                                                                </div>
                                                            <?php else: ?>
                                                                <span class="text-muted small">No permissions</span>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td>
                                                            <a href="<?php echo e(route('admin.roles.edit', $role->id)); ?>"
                                                                class="btn btn-sm btn-outline-warning">
                                                                <i class="bi bi-pencil"></i>
                                                            </a>
                                                            <button type="button" class="btn btn-sm btn-outline-danger delete-role"
                                                                data-role-id="<?php echo e($role->id); ?>" data-role-name="<?php echo e($role->name); ?>">
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                            <form id="delete-role-form-<?php echo e($role->id); ?>"
                                                                action="<?php echo e(route('admin.roles.destroy', $role->id)); ?>" method="POST"
                                                                class="d-none">
                                                                <?php echo csrf_field(); ?>
                                                                <?php echo method_field('DELETE'); ?>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else: ?>
                                <div class="alert alert-info small mb-0">
                                    No roles found. <a href="<?php echo e(route('admin.roles.create')); ?>">Create your first role</a>.
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
    <style>
        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 12px;
            overflow: hidden;
            position: relative;
            border: none;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15) !important;
        }

        .stat-card.customers {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        }

        .stat-card.sales {
            background: linear-gradient(135deg, #f6d365 0%, #fda085 100%);
        }

        .stat-card.schemes {
            background: linear-gradient(135deg, #ff9a9e 0%, #fad0c4 100%);
        }

        .stat-card.payments {
            background: linear-gradient(135deg, #a1c4fd 0%, #c2e9fb 100%);
        }

        .stat-card.profit {
            background: linear-gradient(135deg, #84fab0 0%, #8fd3f4 100%);
        }

        .stat-card.executive {
            background: linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%);
        }

        .stat-icon {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            margin: 0 auto;
        }

        .card {
            border-radius: 12px;
        }

        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
            border-radius: 6px;
        }

        .badge {
            font-size: 0.65rem;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
        }

        .table th,
        .table td {
            padding: 0.5rem;
            font-size: 0.875rem;
        }

        .page-title-box {
            padding: 0;
        }

        .breadcrumb {
            font-size: 15px;
            margin-bottom: 0;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function sendWhatsAppReport() {
            fetch("<?php echo e(route('exports.whatsapp', 'customers')); ?>", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                    'Content-Type': 'application/json'
                }
            })
                .then(response => response.json())
                .then(data => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: data.message,
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true

                    });
                })
                .catch(error => {
                    Swal.fire({
                        text: 'Failed to send WhatsApp report',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        customClass: {
                            popup: 'my-toast'
                        },
                        didOpen: () => {
                            document.querySelector('.my-toast .swal2-html-container').style.color = 'red';
                        }
                    });

                });
        }

        document.addEventListener('DOMContentLoaded', function () {
            // Success message handling
            <?php if(session('success')): ?>
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: '<?php echo e(session('success')); ?>',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 1    000,
                    timerProgressBar: true
                });
            <?php endif; ?>

            <?php if(session('error')): ?>
                Swal.fire({
                    text: '<?php echo e(session('error')); ?>',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    customClass: {
                        popup: 'swal-text-error'
                    }
                });
            <?php endif; ?>


            // Delete role confirmation
            document.querySelectorAll('.delete-role').forEach(button => {
                button.addEventListener('click', function () {
                    const roleId = this.dataset.roleId;
                    const roleName = this.dataset.roleName;

                    Swal.fire({
                        title: 'Are you sure?',
                        text: `Delete role "${roleName}"?`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Yes, delete it!',
                        cancelButtonText: 'Cancel',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById(`delete-role-form-${roleId}`).submit();
                        }
                    });
                });
            });
        });
    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\LENOVO\Downloads\vijay_jwellers\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>