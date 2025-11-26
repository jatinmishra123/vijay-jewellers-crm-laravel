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
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* --- PREMIUM DASHBOARD STYLES --- */
        :root {
            --sidebar-width: 280px;
            --sidebar-width-collapsed: 80px;
            --topbar-height: 70px;
            --sidebar-bg: linear-gradient(180deg, #0f1a2e 0%, #1a2b45 100%);
            --sidebar-link-color: rgba(255, 255, 255, 0.85);
            --sidebar-link-hover-bg: rgba(255, 255, 255, 0.08);
            --sidebar-link-active-bg: rgba(255, 255, 255, 0.12);
            --sidebar-shadow: 0 8px 30px rgba(0, 0, 0, 0.25);
            --topbar-bg: #ffffff;
            --primary-color: #1a2b45;
            --accent-color: #d4af37;
            --accent-gradient: linear-gradient(135deg, #d4af37 0%, #f7ef8a 100%);
            --text-dark: #2d3748;
            --text-muted: #718096;
            --border-color: #e2e8f0;
            --card-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            box-sizing: border-box;
        }

        body {
            background-color: #f7fafc;
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--text-dark);
            line-height: 1.6;
            overflow-x: hidden;
        }

        #layout-wrapper {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .new-sidebar {
            width: var(--sidebar-width);
            background: var(--sidebar-bg);
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            display: flex;
            flex-direction: column;
            transition: var(--transition);
            z-index: 1005;
            box-shadow: var(--sidebar-shadow);
        }

        .new-sidebar .logo-box {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            height: var(--topbar-height);
            flex-shrink: 0;
            padding: 0 24px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(0, 0, 0, 0.2);
        }

        .new-sidebar .logo-box img {
            width: 60px;
            height: 42px;
            border-radius: 10px;
            object-fit: cover;
            margin-right: 12px;
            border: 2px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .new-sidebar .logo-box .brand-text {
            color: white;
            font-weight: 700;
            font-size: 1.3rem;
            white-space: nowrap;
            transition: var(--transition);
            letter-spacing: 0.5px;
            background: linear-gradient(45deg, #ffffff, #d4af37);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .new-sidebar .sidebar-nav {
            flex-grow: 1;
            overflow-y: auto;
            padding: 20px 0;
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
            margin-bottom: 8px;
        }

        .new-sidebar .nav-link {
            display: flex;
            align-items: center;
            padding: 14px 18px;
            color: var(--sidebar-link-color);
            border-radius: 10px;
            white-space: nowrap;
            overflow: hidden;
            transition: var(--transition);
            text-decoration: none;
            font-weight: 500;
            position: relative;
        }

        .new-sidebar .nav-link:hover {
            background-color: var(--sidebar-link-hover-bg);
            color: #fff;
            transform: translateX(5px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .new-sidebar .nav-link.active {
            background-color: var(--sidebar-link-active-bg);
            color: #fff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .new-sidebar .nav-link.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 24px;
            background: var(--accent-gradient);
            border-radius: 0 3px 3px 0;
        }

        .new-sidebar .nav-link i {
            font-size: 1.25rem;
            min-width: 32px;
            text-align: center;
            margin-right: 15px;
            transition: var(--transition);
        }

        .new-sidebar .nav-link.active i {
            color: #d4af37;
        }

        /* Collapsed State (Desktop) */
        body.sidebar-collapsed .new-sidebar {
            width: var(--sidebar-width-collapsed);
        }

        body.sidebar-collapsed .new-sidebar .nav-link span {
            opacity: 0;
            visibility: hidden;
        }

        body.sidebar-collapsed .new-sidebar .brand-text {
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
            transition: var(--transition);
        }

        .page-content {
            flex-grow: 1;
            padding: 30px;
            background-color: #f7fafc;
        }

        .topbar {
            height: var(--topbar-height);
            background-color: var(--topbar-bg);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            display: flex;
            align-items: center;
            padding: 0 30px;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 1002;
            backdrop-filter: blur(10px);
        }

        .hamburger-btn {
            font-size: 1.5rem;
            background: none;
            border: none;
            color: var(--text-dark);
            transition: var(--transition);
            border-radius: 50%;
            width: 42px;
            height: 42px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        .hamburger-btn:hover {
            background-color: #f1f5f9;
            transform: rotate(90deg);
        }

        .footer {
            background-color: #fff;
            padding: 24px 30px;
            text-align: center;
            border-top: 1px solid var(--border-color);
            color: var(--text-muted);
            font-size: 0.9rem;
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
            backdrop-filter: blur(4px);
        }

        /* User dropdown styles */
        .user-dropdown-btn {
            background: none;
            border: none;
            display: flex;
            align-items: center;
            padding: 6px 12px;
            border-radius: 30px;
            transition: var(--transition);
            cursor: pointer;
        }

        .user-dropdown-btn:hover {
            background-color: #f1f5f9;
        }

        .user-avatar {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--border-color);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .user-info {
            text-align: left;
            margin-left: 12px;
        }

        .user-name {
            font-weight: 600;
            color: var(--text-dark);
            font-size: 0.95rem;
        }

        .user-role {
            font-size: 0.8rem;
            color: var(--text-muted);
        }

        .dropdown-menu {
            border: none;
            box-shadow: var(--card-shadow);
            border-radius: 12px;
            padding: 12px 0;
            margin-top: 10px;
            border: 1px solid var(--border-color);
        }

        .dropdown-item {
            padding: 10px 20px;
            display: flex;
            align-items: center;
            transition: var(--transition);
        }

        .dropdown-item:hover {
            background-color: #f7fafc;
        }

        .dropdown-item i {
            margin-right: 10px;
            font-size: 1.1rem;
            width: 20px;
            text-align: center;
        }

        /* Card enhancements */
        .card {
            border: none;
            border-radius: 16px;
            box-shadow: var(--card-shadow);
            margin-bottom: 24px;
            transition: var(--transition);
            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
        }

        .card-header {
            background-color: white;
            border-bottom: 1px solid var(--border-color);
            padding: 20px 24px;
            border-radius: 16px 16px 0 0 !important;
            font-weight: 600;
            color: var(--text-dark);
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
            
            .user-info {
                display: none;
            }
            
            .page-content {
                padding: 20px;
            }
            
            .topbar {
                padding: 0 20px;
            }
        }

        /* Logout button styling */
        .logout-btn {
            width: 100%;
            text-align: left;
            background: none;
            border: none;
            color: var(--sidebar-link-color);
            padding: 14px 18px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            transition: var(--transition);
            cursor: pointer;
            font-weight: 500;
        }

        .logout-btn:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: #fff;
            transform: translateX(5px);
        }

        .logout-btn i {
            margin-right: 15px;
            font-size: 1.25rem;
        }

        /* Page title styling */
        .page-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 1.5rem;
            position: relative;
            padding-bottom: 10px;
        }

        .page-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 4px;
            background: var(--accent-gradient);
            border-radius: 2px;
        }

        /* Badge styling */
        .badge {
            font-weight: 500;
            padding: 6px 10px;
            border-radius: 8px;
        }

        /* Button enhancements */
        .btn {
            border-radius: 10px;
            font-weight: 500;
            padding: 10px 20px;
            transition: var(--transition);
        }

        .btn-primary {
            background: var(--accent-gradient);
            border: none;
            box-shadow: 0 4px 15px rgba(212, 175, 55, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(212, 175, 55, 0.4);
        }

        /* Table enhancements */
        .table {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 0 0 1px var(--border-color);
        }

        .table thead th {
            background-color: #f8fafc;
            border-bottom: 2px solid var(--border-color);
            font-weight: 600;
            color: var(--text-dark);
            padding: 15px;
        }

        .table tbody td {
            padding: 15px;
            vertical-align: middle;
        }

        /* Custom scrollbar for webkit browsers */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }
    </style>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>

<body>
    <?php
        $user = Auth::guard('admin')->user();
        $currentRoute = request()->route()->getName();
    ?>
    <!-- Begin page -->
    <div id="layout-wrapper">

        <!-- ========== Premium Sidebar Start ========== -->
        <aside class="new-sidebar">
            <div class="logo-box">
                <a href="<?php echo e(route('admin.dashboard')); ?>" class="d-flex align-items-center text-decoration-none">
                    <img src="<?php echo e(asset('assets/assets/images/logo.webp')); ?>" alt="Logo">
                    <span class="brand-text">Vijay Jewellers</span>
                </a>
            </div>

            <ul class="sidebar-nav">
                <li class="nav-item">
                    <a class="nav-link <?php echo e($currentRoute == 'admin.dashboard' ? 'active' : ''); ?>" href="<?php echo e(route('admin.dashboard')); ?>">
                        <i class="ri-home-3-line"></i> <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo e(str_contains($currentRoute, 'admin.roles') ? 'active' : ''); ?>" href="<?php echo e(route('admin.roles.index')); ?>">
                        <i class="ri-user-settings-line"></i> <span>Roles</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo e(str_contains($currentRoute, 'admin.customers') ? 'active' : ''); ?>" href="<?php echo e(route('admin.customers.index')); ?>">
                        <i class="ri-user-3-line"></i> <span>Customers</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo e(str_contains($currentRoute, 'admin.sales') ? 'active' : ''); ?>" href="<?php echo e(route('admin.sales.index')); ?>">
                        <i class="ri-bar-chart-2-line"></i> <span>Total Sales</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo e(str_contains($currentRoute, 'admin.schemes') ? 'active' : ''); ?>" href="<?php echo e(route('admin.schemes.index')); ?>">
                        <i class="ri-stack-fill"></i> <span>Total Scheme</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo e(str_contains($currentRoute, 'payments.index') ? 'active' : ''); ?>" href="<?php echo e(route('payments.index')); ?>">
                        <i class="ri-money-dollar-circle-line"></i> <span>Payment Report</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo e(str_contains($currentRoute, 'admin.scheme_payments') ? 'active' : ''); ?>" href="<?php echo e(route('admin.scheme_payments.index')); ?>">
                        <i class="ri-wallet-fill"></i> <span>Scheme Payment</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo e(str_contains($currentRoute, 'admin.schemes') ? 'active' : ''); ?>" href="<?php echo e(route('admin.schemes.index')); ?>">
                        <i class="ri-bar-chart-fill"></i> <span>Scheme Report</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo e(str_contains($currentRoute, 'admin.lucky_draws') ? 'active' : ''); ?>" href="<?php echo e(route('admin.lucky_draws.index')); ?>">
                        <i class="ri-gift-fill"></i> <span>Lucky Draws</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo e(str_contains($currentRoute, 'admin.exports') ? 'active' : ''); ?>" href="<?php echo e(route('admin.exports.dashboard')); ?>">
                        <i class="ri-file-download-line"></i> <span>Export Report</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo e(str_contains($currentRoute, 'admin.contacts') ? 'active' : ''); ?>" href="<?php echo e(route('admin.contacts.index')); ?>">
                        <i class="bi bi-chat-dots"></i> <span>Follow Up</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo e(str_contains($currentRoute, 'admin.manage') ? 'active' : ''); ?>" href="<?php echo e(route('admin.manage.index')); ?>">
                        <i class="bi bi-folder2-open"></i> <span>Scheme Management</span>
                    </a>
                </li>

                <li class="nav-item mt-auto mb-3"> <!-- Logout at the bottom -->
                    <form method="POST" action="<?php echo e(route('admin.logout')); ?>" style="width:100%;">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="logout-btn">
                            <i class="ri-logout-box-r-line"></i> <span>Logout</span>
                        </button>
                    </form>
                </li>
            </ul>
        </aside>
        <!-- Premium Sidebar End -->
        <!-- Main Content -->
        <main class="main-content">
            <!-- Topbar Start -->
            <header class="topbar">
                <button type="button" class="hamburger-btn" id="hamburger-icon">
                    <i class="ri-menu-line"></i>
                </button>
                <div class="d-flex align-items-center">
                    <div class="dropdown">
                        <button type="button" class="user-dropdown-btn" id="page-header-user-dropdown" data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <img class="user-avatar"
                                src="<?php echo e(asset('assets/assets/images/users/avatar-1.jpg')); ?>" alt="Header Avatar">
                            <div class="user-info d-none d-md-block">
                                <div class="user-name"><?php echo e($user->name ?? 'Admin'); ?></div>
                                <div class="user-role"><?php echo e($user && $user->role ? $user->role->name : 'Role'); ?></div>
                            </div>
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

    <!-- ==== PREMIUM SIDEBAR SCRIPT ==== -->
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

            // Set active page based on current URL
            const currentPath = window.location.pathname;
            const navLinks = document.querySelectorAll('.nav-link');
            
            navLinks.forEach(link => {
                if (link.getAttribute('href') === currentPath) {
                    link.classList.add('active');
                }
            });

            // Add subtle animation to cards on page load
            const cards = document.querySelectorAll('.card');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                
                setTimeout(() => {
                    card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });
    </script>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>

</html><?php /**PATH C:\Users\LENOVO\Downloads\vijay_jwellers\resources\views/admin/layouts/app.blade.php ENDPATH**/ ?>