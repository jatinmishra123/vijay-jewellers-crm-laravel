

<?php $__env->startSection('title', 'Scheme Management - Admin Dashboard'); ?>

<?php $__env->startSection('head'); ?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>


<?php
    /**
     * Define all report tabs inside the 'ALL SCHEME REPORT' dropdown
     */
    $reportDropdownTabs = ['closed-report', 'current-report', 'due-date-report', 'today-closing-report'];

    /**
     * Checks if a specific tab (defined by 'tab' query param or route name) is active.
     */
    function is_active_tab($tabName = null) {
        // Check if the current route is the specific settings route
        if (Route::currentRouteName() === 'admin.manage.settings' && $tabName === 'settings') {
            return true;
        }

        $currentRoute = Route::currentRouteName();
        $currentTab = request()->query('tab');
        
        // Case 1: Check for the default view (ADD NEW SCHEME tab)
        $isDefaultIndex = empty($currentTab) && ($currentRoute === 'admin.manage.index' || $currentRoute === 'admin.manage.create');
        if (is_null($tabName)) {
            return $isDefaultIndex;
        }

        // Case 2: Check for a specific 'tab' query parameter (e.g., search, report)
        return $currentTab === $tabName;
    }

    /**
     * Checks if the dropdown tab or any of its children are active.
     */
    function is_active_dropdown($reportDropdownTabs) {
        $currentTab = request()->query('tab');
        return in_array($currentTab, $reportDropdownTabs);
    }
?>


<style>
/* --- TOP MENU STYLING --- */
.scheme-top-menu {
    background: #ffef8b;
    padding: 6px 10px;
    display: flex;
    gap: 14px;
    font-weight: 700;
    border-radius: 4px;
    overflow-x: auto; /* हॉरिजॉन्टल स्क्रॉलिंग के लिए */
    white-space: nowrap;
}
.scheme-top-menu a {
    color: #333; 
    text-decoration: none; 
    padding: 6px 14px; 
    border-radius: 3px;
    transition: background-color 0.2s; /* स्मूथ ट्रांजिशन */
}
.scheme-top-menu a.active, 
.scheme-top-menu a:hover {
    background: #f4d24a; 
    color: #000;
}


.row label.small {
    font-weight: 500;
    color: #555;
    margin-bottom: 0.2rem;
    display: block; 
}
.form-control, .form-select {
    height: 38px !important; /* थोड़ी बेहतर हाइट */
    font-size: 0.9rem;
}
#emiTable input.form-control {
    height: 35px; 
    padding: 0.375rem 0.75rem; 
    font-size: 0.875rem; 
}
.scheme-top-menu {
    background: #ffef8b;
    padding: 6px 10px;
    display:flex;
    gap:14px;
    font-weight:700;
    border-radius:4px;

    overflow: visible !important;   /* FIX */
    position: relative;             /* FIX */
    z-index: 10;                    /* FIX */
}

.scheme-dropdown .dropdown-menu {
    position: absolute !important;
    z-index: 9999;
    margin-top: 2px;
}


</style>

<div class="container-fluid mt-4">

    
    
    
    <div class="scheme-top-menu mb-4">

        
        <a href="<?php echo e(route('admin.manage.create')); ?>" class="<?php echo e(is_active_tab() ? 'active' : ''); ?>">
            ADD NEW SCHEME
        </a>
<a href="<?php echo e(route('admin.manage.customers')); ?>">Customers</a>

          
        <a href="<?php echo e(route('admin.manage.index', ['tab'=>'search'])); ?>" class="<?php echo e(is_active_tab('search') ? 'active' : ''); ?>">
            Total SCHEME
        </a>

        
        <a href="<?php echo e(route('admin.manage.index', ['tab'=>'report'])); ?>" class="<?php echo e(is_active_tab('report') ? 'active' : ''); ?>">
            REPORT
        </a>

        
        <div class="dropdown dropdown-fix">
            
            <a class="<?php echo e(is_active_dropdown($reportDropdownTabs) ? 'active-dropdown' : ''); ?> dropdown-toggle" data-bs-toggle="dropdown" href="#">
                ALL SCHEME REPORT 
            </a>
            <ul class="dropdown-menu">
                
                <li><a class="dropdown-item <?php echo e(is_active_tab('closed-report') ? 'active' : ''); ?>" 
                       href="<?php echo e(route('admin.manage.index',['tab'=>'closed-report'])); ?>">Closed Scheme Report</a></li>
                
                <li><a class="dropdown-item <?php echo e(is_active_tab('current-report') ? 'active' : ''); ?>" 
                       href="<?php echo e(route('admin.manage.index',['tab'=>'current-report'])); ?>">Current Scheme Report</a></li>
                       
                <li><a class="dropdown-item <?php echo e(is_active_tab('due-date-report') ? 'active' : ''); ?>" 
                       href="<?php echo e(route('admin.manage.index',['tab'=>'due-date-report'])); ?>">Due Date Scheme Report</a></li>
                       
                <li><a class="dropdown-item <?php echo e(is_active_tab('today-closing-report') ? 'active' : ''); ?>" 
                       href="<?php echo e(route('admin.manage.index',['tab'=>'today-closing-report'])); ?>">Today Closing Scheme Report</a></li>
            </ul>
        </div>
        
        <a href="<?php echo e(route('admin.manage.settings')); ?>" class="<?php echo e(request()->routeIs('admin.manage.settings') ? 'active' : ''); ?>">
            SCHEME SETTING
        </a>
    </div>

    
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body d-flex justify-content-between align-items-center">
            <div>
                <h2 class="fw-bold text-primary mb-1">
                    <i class="bi bi-folder2-open me-2"></i> Scheme Management
                </h2>
                <p class="text-muted small mb-0">View, search, create, and manage customer scheme records.</p>
            </div>

            <a href="<?php echo e(route('admin.manage.create')); ?>" class="btn btn-primary shadow-sm">
                <i class="bi bi-plus-circle me-1"></i> Add New Scheme
            </a>
        </div>
    </div>

    
    <div class="card shadow-sm mb-4">
        <div class="card-header fw-bold bg-light">
            <i class="bi bi-funnel me-1"></i> Search & Filter Options
        </div>

        <div class="card-body">
            <form method="GET" class="row g-3">
                <input type="hidden" name="tab" value="<?php echo e(request('tab')); ?>">

                <div class="col-lg-4">
                    <label class="small">Search (KIJ, Name, Mobile, Scheme)</label>
                    <input type="text" name="search" class="form-control filter-input" 
                           placeholder="Enter Keyword, Name, or Mobile..." value="<?php echo e(request('search')); ?>">
                </div>

                <div class="col-lg-2">
                    <label class="small">City</label>
                    <input type="text" name="city" class="form-control filter-input" 
                           placeholder="Ex: Mumbai" value="<?php echo e(request('city')); ?>">
                </div>

                <div class="col-lg-2">
                    <label class="small">State</label>
                    <input type="text" name="state" class="form-control filter-input" 
                           placeholder="Ex: Maharashtra" value="<?php echo e(request('state')); ?>">
                </div>

                <div class="col-lg-4">
                    <label class="small">Address</label>
                    <input type="text" name="address" class="form-control filter-input" 
                           placeholder="Full or partial address" value="<?php echo e(request('address')); ?>">
                </div>

                <div class="col-12 d-flex gap-2 pt-2">
                    <button class="btn btn-primary">
                        <i class="bi bi-search me-1"></i> Apply
                    </button>

                    <?php if(request()->query()): ?>
                        <a href="<?php echo e(route('admin.manage.index', ['tab' => request('tab')])); ?>" class="btn btn-outline-danger">
                            Clear Filters
                        </a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white fw-bold">
            All Schemes (Total: <?php echo e($manages->total()); ?>)
        </div>

        <div class="table-responsive">
<table class="table table-bordered table-striped align-middle mb-0 table-fixed">
                <thead class="bg-light">
                    <tr>
                        <th>Sr</th>
                        <th>Profile</th>
                        <th>Name</th>
                        <th>Mobile</th>
                        <th>Scheme</th>
                        <th>EMI</th>
                        <th>months_in_Emi</th>
                        <th>Nominee</th>
                          <th>State</th>
                        <th>City</th>
                                                <th> Start_Date</th>

                                                <th>End_date</th>

                        <th width="140">Action</th>
                    </tr>
                </thead>

                <tbody>
                    
                    <?php $__currentLoopData = $manages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($manages->firstItem() + $loop->index); ?></td>

                        <td>
                            <img src="<?php echo e($item->profile_image ? asset('storage/'.$item->profile_image) : 'https://via.placeholder.com/50'); ?>"
                                 width="50" height="50" class="rounded-circle" style="object-fit:cover;">
                        </td>

                        <td><?php echo e($item->first_name); ?> <?php echo e($item->last_name); ?></td>
                        <td><?php echo e($item->mobile_number); ?></td>
                        <td><?php echo e($item->scheme_name ?? 'N/A'); ?></td>
                        <td><?php echo e($item->scheme_emi_amount ?? 'N/A'); ?></td>
                        <td><?php echo e($item->scheme_emi_plan ?? 'N/A'); ?></td>
                        <td><?php echo e($item->nominee_name ?? 'N/A'); ?></td>
                        <td><?php echo e($item->state); ?></td>
                            <td><?php echo e($item->city_village); ?></td>
                            <td><?php echo e($item->start_date ?? '-'); ?></td>
                            <td><?php echo e($item->end_date ?? '_'); ?></td>
                        <td class="d-flex gap-1">
                            <a href="<?php echo e(route('admin.manage.show',$item->id)); ?>" class="btn btn-info btn-sm" title="View">
                                <i class="bi bi-eye"></i>
                            </a>
   <a href="<?php echo e(route('admin.manage.pdf', $item->id)); ?>" class="btn btn-primary btn-sm">
        <i class="bi bi-download"></i>
    </a>


                            <a href="<?php echo e(route('admin.manage.edit',$item->id)); ?>" class="btn btn-warning btn-sm" title="Edit">
                                <i class="bi bi-pencil-square"></i>
                            </a>

                            <form action="<?php echo e(route('admin.manage.delete',$item->id)); ?>" method="POST" class="d-inline delete-form">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button type="button" class="btn btn-danger btn-sm delete-btn" title="Delete">
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

    
    <div class="mt-3 d-flex justify-content-between">
        <div class="text-muted">
            Showing <?php echo e($manages->firstItem()); ?> to <?php echo e($manages->lastItem()); ?> of <?php echo e($manages->total()); ?>

        </div>

        <?php echo e($manages->appends(request()->query())->links()); ?>

    </div>

</div>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.querySelectorAll(".delete-btn").forEach(btn => {
    btn.onclick = function () {
        let form = this.closest("form");
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: "Yes, delete it!"
        }).then(res => { 
            if (res.isConfirmed) {
                form.submit();
            }
        });
    };
});
</script>
<style>
.table-wrapper {
    width: 100%;
    overflow-x: auto;     /* Full table scroll */
    overflow-y: hidden;   /* No vertical scroll */
    white-space: nowrap;  /* No wrap – one line */
}

.table-wrapper table {
    width: max-content;   /* Auto expand as per column */
    min-width: 100%;      /* At least full screen */
}

.table-wrapper th,
.table-wrapper td {
    padding: 8px 12px;
    white-space: nowrap;  /* No row break */
    vertical-align: middle;
}
</style>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\LENOVO\Downloads\vijay_jwellers\resources\views/admin/manage/index.blade.php ENDPATH**/ ?>