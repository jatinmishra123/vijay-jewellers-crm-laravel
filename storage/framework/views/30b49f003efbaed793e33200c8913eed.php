

<?php $__env->startSection('title', 'Create Customer'); ?>

<?php $__env->startSection('content'); ?>

<style>
    /* Light casual feel */
    .form-label {
        font-weight: 600;
        color: #444;
    }
    .form-control, .form-select {
        border-radius: 10px;
        padding: 10px 12px;
        border: 1px solid #cfcfcf;
        transition: 0.2s ease-in-out;
    }
    .form-control:focus, .form-select:focus {
        border-color: #6c63ff;
        box-shadow: 0 0 0 0.15rem rgba(108, 99, 255, 0.3);
    }
    .card {
        border-radius: 15px;
    }
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
    }
    .page-title {
        font-size: 22px;
        font-weight: 700;
        color: #333;
    }
    .back-btn {
        padding: 7px 15px;
        border-radius: 10px;
        background: #eee;
        color: #333;
        text-decoration: none;
        transition: 0.2s;
    }
    .back-btn:hover {
        background: #ddd;
    }
</style>

<div class="container py-4">

    <!-- Top Heading with Back Button -->
    <div class="page-header">
        <div class="page-title">Create New Customer</div>

        <a href="<?php echo e(route('admin.manage.index')); ?>" class="back-btn">
            ← Back
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">

            <form action="<?php echo e(route('admin.manage.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>

                <div class="row g-3">

                    <!-- First Name -->
                    <div class="col-md-6">
                        <label class="form-label">First Name</label>
                        <input type="text" name="first_name" class="form-control"
                               placeholder="Enter first name" required>
                    </div>

                    <!-- Last Name -->
                    <div class="col-md-6">
                        <label class="form-label">Last Name</label>
                        <input type="text" name="last_name" class="form-control"
                               placeholder="Enter last name" required>
                    </div>

                    <!-- Father Name -->
                    <div class="col-md-6">
                        <label class="form-label">Father Name</label>
                        <input type="text" name="father_name" class="form-control"
                               placeholder="Enter father's name">
                    </div>

                    <!-- Mobile Number -->
                    <div class="col-md-6">
                        <label class="form-label">Mobile Number</label>
                        <input type="text" name="mobile_number" class="form-control"
                               placeholder="Enter mobile number" required>
                    </div>

                    <!-- Aadhar -->
                    <div class="col-md-6">
                        <label class="form-label">Aadhar Number</label>
                        <input type="text" name="aadhar_number" class="form-control"
                               placeholder="Enter Aadhar number">
                    </div>

                    <!-- PAN -->
                    <div class="col-md-6">
                        <label class="form-label">PAN Card Number</label>
                        <input type="text" name="pan_number" class="form-control"
                               placeholder="Enter PAN number">
                    </div>

                    <!-- City -->
                    <div class="col-md-4">
                        <label class="form-label">City / Village</label>
                        <input type="text" name="city_village" class="form-control"
                               placeholder="Enter city or village name">
                    </div>

                    <!-- State -->
                    <div class="col-md-4">
                        <label class="form-label">State</label>
                        <input type="text" name="state" class="form-control"
                               placeholder="Enter state name">
                    </div>

                    <!-- Country -->
                    <div class="col-md-4">
                        <label class="form-label">Country</label>
                        <input type="text" name="country" class="form-control"
                               placeholder="Enter country name">
                    </div>

                    <!-- User Group -->
                    <div class="col-md-6">
                        <label class="form-label">User Group</label>
                        <select name="user_group" class="form-select">
                            <option value="customer">Customer</option>
                        </select>
                    </div>

                </div>

                <div class="mt-4 text-end">
                    <button class="btn btn-primary px-4" style="border-radius: 10px;">
                        Save Customer
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\LENOVO\Downloads\vijay_jwellers\resources\views/admin/manage/customers.blade.php ENDPATH**/ ?>