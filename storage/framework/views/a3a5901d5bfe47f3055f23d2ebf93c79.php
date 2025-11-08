<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title><?php echo $__env->yieldContent('title', 'Admin Dashboard - Vijay Jewellers'); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?php echo e(asset('assets/assets/images/logo.webp')); ?>">

    <!-- jsvectormap css -->
    <link href="<?php echo e(asset('assets/assets/libs/jsvectormap/jsvectormap.min.css')); ?>" rel="stylesheet" type="text/css" />

    <!--Swiper slider css-->
    <link href="<?php echo e(asset('assets/assets/libs/swiper/swiper-bundle.min.css')); ?>" rel="stylesheet" type="text/css" />

    <!-- Layout config Js -->
    <script src="<?php echo e(asset('assets/assets/js/layout.js')); ?>"></script>
    <!-- Bootstrap Css -->
    <link href="<?php echo e(asset('assets/assets/css/bootstrap.min.css')); ?>" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="<?php echo e(asset('assets/assets/css/icons.min.css')); ?>" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="<?php echo e(asset('assets/assets/css/app.min.css')); ?>" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="<?php echo e(asset('assets/assets/css/custom.min.css')); ?>" rel="stylesheet" type="text/css" />
    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet" />

    <style>
        /* --- NEW MODERN SIDEBAR STYLES --- */
        :root {
            --sidebar-width: 250px;
            --sidebar-width-collapsed: 80px;
            --topbar-height: 70px;
            --sidebar-bg: #41c9e8ff;
            --sidebar-link-color: #adb5bd;
            --sidebar-link-hover-bg: #3c4c5aff;
            --sidebar-link-active-bg: #dae7ebff;
        }

        body {
            background-color: #f8f9fa;
        }

        #layout-wrapper {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .new-sidebar {
            width: var(--sidebar-width);
            background-color: var(--sidebar-bg);
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            display: flex;
            flex-direction: column;
            transition: width 0.3s ease, transform 0.3s ease;
            z-index: 1005;
        }

        .new-sidebar .logo-box {
            display: flex;
            align-items: center;
            justify-content: center;
            height: var(--topbar-height);
            flex-shrink: 0;
        }

        .new-sidebar .logo-box img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
        }

        .new-sidebar .sidebar-nav {
            flex-grow: 1;
            overflow-y: auto;
            padding: 0;
            margin: 0;
            list-style: none;
        }

        /* Hide scrollbar visually */
        .sidebar-nav::-webkit-scrollbar {
            display: none;
        }

        .sidebar-nav {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .new-sidebar .nav-item {
            padding: 0 15px;
        }

        .new-sidebar .nav-link {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            color: white;
            border-radius: 6px;
            white-space: nowrap;
            overflow: hidden;
            transition: background-color 0.2s ease;
        }

        .new-sidebar .nav-link:hover {
            background-color: var(--sidebar-link-hover-bg);
            color: #fff;
        }

        .new-sidebar .nav-link i {
            font-size: 1.2rem;
            min-width: 30px;
            text-align: center;
            margin-right: 15px;
            transition: margin 0.3s ease;
        }

        /* Collapsed State (Desktop) */
        body.sidebar-collapsed .new-sidebar {
            width: var(--sidebar-width-collapsed);
        }

        body.sidebar-collapsed .new-sidebar .nav-link span {
            opacity: 0;
            visibility: hidden;
        }

        body.sidebar-collapsed .main-content {
            margin-left: var(--sidebar-width-collapsed);
        }

        .main-content {
            margin-left: var(--sidebar-width);
            width: calc(100% - var(--sidebar-width));
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            transition: margin-left 0.3s ease, width 0.3s ease;
        }

        .page-content {
            flex-grow: 1;
            padding: 24px;
        }

        .topbar {
            height: var(--topbar-height);
            background-color: #fff;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            padding: 0 24px;
            justify-content: space-between;
        }

        .hamburger-btn {
            font-size: 1.5rem;
            background: none;
            border: none;
            color: #333;
        }

        .footer {
            background-color: #fff;
            padding: 20px 24px;
            text-align: center;
            border-top: 1px solid #e9ecef;
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1004;
        }

        /* Mobile Responsive */
        @media (max-width: 991.98px) {
            .new-sidebar {
                transform: translateX(-100%);
            }

            body.sidebar-open .new-sidebar {
                transform: translateX(0);
            }

            body.sidebar-open .sidebar-overlay {
                display: block;
            }

            .main-content {
                margin-left: 0;
                width: 100%;
            }
        }
    </style>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>

<body>
    <?php
        $user = Auth::guard('admin')->user();
    ?>
    <!-- Begin page -->
    <div id="layout-wrapper">

        <!-- ========== New Sidebar Start ========== -->
        <aside class="new-sidebar">
            <div class="logo-box">
                <a href="<?php echo e(route('admin.dashboard')); ?>">
                    <img src="<?php echo e(asset('assets/assets/images/logo.webp')); ?>" alt="Logo">
                </a>
            </div>

            <ul class="sidebar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('admin.dashboard')); ?>">
                        <i class="ri-home-3-line"></i> <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('admin.roles.index')); ?>">
                        <i class="ri-user-settings-line"></i> <span>Roles</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('admin.customers.index')); ?>">
                        <i class="ri-user-3-line"></i> <span>Customers</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('admin.sales.index')); ?>">
                        <i class="ri-bar-chart-2-line"></i> <span>Total Sales</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('admin.schemes.index')); ?>">
                        <i class="ri-stack-fill"></i> <span>Total Scheme</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('payments.index')); ?>">
                        <i class="ri-money-dollar-circle-line"></i> <span>Payment Report</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('admin.scheme_payments.index')); ?>">
                        <i class="ri-wallet-fill"></i> <span>Scheme Payment</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('admin.schemes.index')); ?>">
                        <i class="ri-bar-chart-fill"></i> <span>Scheme Report</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('admin.lucky_draws.index')); ?>">
                        <i class="ri-gift-fill"></i> <span>Lucky Draws</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('admin.exports.dashboard')); ?>">
                        <i class="ri-file-download-line"></i> <span>Export Report</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('admin.contacts.index')); ?>">
                        <i class="bi bi-chat-dots"></i> <span>Follow Up</span>
                    </a>
                </li>

                <li class="nav-item mt-auto mb-3"> <!-- Logout at the bottom -->
                    <form method="POST" action="<?php echo e(route('admin.logout')); ?>" style="width:100%;">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="nav-link btn btn-link w-100 p-0"
                            style="border: none; background: none; text-align: left;">
                            <i class="ri-logout-box-r-line"></i> <span>Logout</span>
                        </button>
                    </form>
                </li>
            </ul>
        </aside>
        <!-- New Sidebar End -->
        <!-- Main Content -->
        <main class="main-content">
            <!-- Topbar Start -->
            <header class="topbar">
                <button type="button" class="hamburger-btn" id="hamburger-icon">
                    <i class="ri-menu-line"></i>
                </button>
                <div class="d-flex align-items-center">
                    <div class="dropdown">
                        <button type="button" class="btn" id="page-header-user-dropdown" data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <span class="d-flex align-items-center">
                                <img class="rounded-circle header-profile-user"
                                    src="<?php echo e(asset('assets/assets/images/users/avatar-1.jpg')); ?>" alt="Header Avatar"
                                    style="width: 40px; height: 40px;">
                                <span class="text-start ms-2">
                                    <span class="d-none d-xl-inline-block fw-medium"><?php echo e($user->name ?? 'Admin'); ?></span>
                                    <span
                                        class="d-none d-xl-block fs-12 text-muted"><?php echo e($user && $user->role ? $user->role->name : 'Role'); ?></span>
                                </span>
                            </span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <h6 class="dropdown-header">Welcome <?php echo e($user->name ?? 'Admin'); ?>!</h6>
                            <a class="dropdown-item" href="<?php echo e(route('admin.dashboard')); ?>"><i
                                    class="ri-dashboard-line align-middle me-1"></i> Dashboard</a>
                            <div class="dropdown-divider"></div>
                            <form method="POST" action="<?php echo e(route('admin.logout')); ?>" class="d-inline">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="dropdown-item text-danger"><i
                                        class="ri-logout-box-line align-middle me-1"></i> Logout</button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>
            <!-- Topbar End -->

            <div class="page-content">
                <div class="container-fluid">
                    <?php echo $__env->yieldContent('content'); ?>
                </div>
            </div>

            <!-- Footer -->
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <script>document.write(new Date().getFullYear())</script> © Vijay Jewellers.
                            <span class="d-none d-sm-inline-block"> - Crafted with <i
                                    class="mdi mdi-heart text-danger"></i> by Wayone IT Solutions</span>
                        </div>
                    </div>
                </div>
            </footer>
        </main>

        <div class="sidebar-overlay"></div>
    </div>
    <!-- END layout-wrapper -->
    <script src="<?php echo e(asset('assets/assets/libs/bootstrap/js/bootstrap.bundle.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/assets/libs/simplebar/simplebar.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/assets/libs/node-waves/waves.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/assets/libs/feather-icons/feather.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/assets/js/plugins.js')); ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="<?php echo e(asset('assets/js/admin-delete.js')); ?>"></script>
    <!-- JAVASCRIPT -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- ==== NEW SIDEBAR SCRIPT ==== -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const hamburgerBtn = document.getElementById('hamburger-icon');
            const sidebarOverlay = document.querySelector('.sidebar-overlay');
            const body = document.body;

            hamburgerBtn.addEventListener('click', () => {
                if (window.innerWidth <= 992) {
                    body.classList.toggle('sidebar-open');
                } else {
                    body.classList.toggle('sidebar-collapsed');
                }
            });

            sidebarOverlay.addEventListener('click', () => {
                body.classList.remove('sidebar-open');
            });
        });
    </script>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>

</html><?php /**PATH C:\Users\LENOVO\Downloads\vijay_jwellers\resources\views/admin/layouts/app.blade.php ENDPATH**/ ?>