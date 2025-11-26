

<?php $__env->startSection('title', 'Scheme Settings - Admin Dashboard'); ?>

<?php $__env->startSection('head'); ?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<style>
/* --- TOP MENU STYLING --- */
.scheme-top-menu {
    background: #ffef8b;
    padding: 6px 10px;
    display: flex;
    gap: 14px;
    font-weight: 700;
    border-radius: 4px;
    overflow-x: auto;
    white-space: nowrap;
}
.scheme-top-menu a {
    color: #333; 
    text-decoration: none; 
    padding: 6px 14px; 
    border-radius: 3px;
    transition: background-color 0.2s;
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
    height: 38px !important;
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
    overflow: visible !important;
    position: relative;
    z-index: 10;
}

.scheme-dropdown .dropdown-menu {
    position: absolute !important;
    z-index: 9999;
    margin-top: 2px;
}
</style>

<div class="scheme-top-menu mb-4">

    <a href="<?php echo e(route('admin.manage.create')); ?>">
        ADD NEW SCHEME
    </a>
<a href="<?php echo e(route('admin.manage.customers')); ?>">Customers</a>

    

    <a href="#" class="active">SCHEME SETTING</a>

</div>



<div class="card shadow-sm mb-4">
    <div class="card-body">

        <form action="<?php echo e(route('admin.manage.settings.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>

            <div class="row g-3"> 
                
                
                <div class="col-lg-2 col-md-4">
                    <label class="small">Scheme Plan</label>
                    <input name="scheme_plan" class="form-control" placeholder="Ex: 10 Months" required>
                </div>

                
                <div class="col-lg-3 col-md-4">
                    <label class="small">Scheme Name</label>
                    <select name="scheme_id" class="form-select" required>
                        <option value="">Select Scheme</option>
                        <?php $__currentLoopData = $schemes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $scheme): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($scheme->id); ?>"><?php echo e($scheme->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                
                <div class="col-lg-3 col-md-4">
                    <label class="small">Cash / Metal</label>
                    <select name="cash_metal" class="form-select" required>
                        <option value="">Select Type</option>
                        <option value="cash">Cash</option>
                        <option value="Online">Online</option>
                        <option value="gold">gold</option>
                    </select>
                </div>

                
                <div class="col-lg-2 col-md-4">
                    <label class="small">User Group</label>
                    <select name="user_group" class="form-select" required>
                        <option value="manual">Manual</option>
                        <option value="staff">Staff</option>
                    </select>
                </div>

                
                <div class="col-lg-1 col-md-2">
                    <label class="small">Users</label>
                    <input name="no_of_users" type="number" class="form-control" placeholder="10" required>
                </div>

                
                <div class="col-lg-1 col-md-2">
                    <label class="small">EMI Count</label>
                    <input name="no_of_emi" type="number" class="form-control" placeholder="12" required>
                </div>
            </div>

            <hr class="my-4">

            
            <div class="row g-3">
                
                
                <div class="col-lg-2 col-md-4">
                    <label class="small">EMI Amount</label>
                    <input name="emi_amt" type="number" class="form-control" placeholder="Ex: 2000">
                </div>

                
                <div class="col-lg-2 col-md-4">
                    <label class="small">Bonus Amount</label>
                    <input name="bonus_amount" type="number" class="form-control" placeholder="Ex: 500">
                </div>
                
                
                <div class="col-lg-2 col-md-5">
                    <label class="small">Interest Type</label>
                    <select name="interest_type" class="form-select">
                        <option value="%">Percentage (%)</option>
                        <option value="flat">Flat</option>
                    </select>
                </div>

                
                <div class="col-lg-2 col-md-3">
                    <label class="small fw-bold">Token Prefix</label>
                    <input name="token_prefix" type="text" class="form-control" value="SCH-" placeholder="SCH-">
                </div>

                
                <div class="col-lg-1 col-md-3">
                    <label class="small">S_Token</label>
                    <input name="start_token_no" type="number" class="form-control" placeholder="1">
                </div>

                
                <div class="col-lg-1 col-md-3">
                    <label class="small">End Token</label>
                    <input name="end_token_no" type="number" class="form-control" placeholder="100">
                </div>

            </div>

           

            <hr class="my-4">

            
            <div class="row g-3">
                
                
                <div class="col-lg-2 col-md-3">
                    <label class="small">Gold Bonus %</label>
                    <input name="gold_bonus_percent" type="number" step="0.01" class="form-control" placeholder="1">
                </div>

                
                <div class="col-lg-2 col-md-3">
                    <label class="small">Diamond Bonus %</label>
                    <input name="diamond_bonus_percent" type="number" step="0.01" class="form-control" placeholder="0.5">
                </div>

                
                <div class="col-lg-2 col-md-3">
                    <label class="small">Gold Mkg Discount %</label>
                    <input name="gold_mkg_discount" type="number" step="0.01" class="form-control" placeholder="20">
                </div>

                
                <div class="col-lg-2 col-md-3">
                    <label class="small"> D Mkg Discount %</label>
                    <input name="diamond_mkg_discount" type="number" step="0.01" class="form-control" placeholder="15">
                </div>

                
                <div class="col-lg-4 col-md-12 d-flex align-items-end">
                    <div class="form-check p-3 border rounded shadow-sm">
                        <input type="checkbox" class="form-check-input" id="convertBonus" name="convert_bonus_to_gold" value="1">
                        <label class="form-check-label small fw-bold" for="convertBonus">
                            Convert Bonus to Gold (Weight)
                        </label>
                    </div>
                </div>
            </div>

            
            
            <div class="card mt-5 border-primary">
                <div class="card-header fw-bold bg-primary text-white">
                    <i class="bi bi-table me-1"></i> EMI Rows (Discount + Bonus %)
                    <button type="button" class="btn btn-sm btn-light float-end text-primary" id="addEmiRow">
                        <i class="bi bi-plus-circle-fill me-1"></i> Add EMI Row
                    </button>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-sm align-middle" id="emiTable">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 15%;">EMI No</th>
                                    <th style="width: 30%;">Discount %</th>
                                    <th style="width: 30%;">Bonus %</th>
                                    <th style="width: 15%;">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr class="emi-row">
                                    <td><input name="emi_rows[0][emi_no]" type="number" class="form-control" placeholder="1"></td>
                                    <td><input name="emi_rows[0][discount]" type="number" step="0.01" class="form-control" placeholder="10"></td>
                                    <td><input name="emi_rows[0][bonus]" type="number" step="0.01" class="form-control" placeholder="2"></td>
                                    <td>
                                        <button type="button" class="btn btn-outline-danger btn-sm remove-row" title="Remove Row">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


            
            <div class="mt-4 pt-3 border-top">
                <button type="submit" class="btn btn-success btn-lg shadow-sm">
                    <i class="bi bi-save me-2"></i> Save Scheme Setting
                </button>
            </div>

        </form>

    </div>
</div>


<?php echo $__env->make('admin.manage.settings_list', ['settings'=>$settings], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

</div>



<script>
let emiIndex = 1;

// Add EMI row
document.getElementById('addEmiRow').addEventListener('click', function () {
    let tbody = document.querySelector('#emiTable tbody');
    let row = `
    <tr class="emi-row">
        <td><input name="emi_rows[${emiIndex}][emi_no]" type="number" class="form-control" placeholder="${emiIndex + 1}"></td>
        <td><input name="emi_rows[${emiIndex}][discount]" type="number" step="0.01" class="form-control" placeholder="0"></td>
        <td><input name="emi_rows[${emiIndex}][bonus]" type="number" step="0.01" class="form-control" placeholder="0"></td>
        <td>
            <button type="button" class="btn btn-outline-danger btn-sm remove-row">
                <i class="bi bi-trash"></i>
            </button>
        </td>
    </tr>
    `;
    emiIndex++;
    tbody.insertAdjacentHTML('beforeend', row);
});

// Remove EMI row
document.addEventListener('click', function (e) {
    let removeButton = e.target.closest('.remove-row');
    if (removeButton) {
        removeButton.closest('tr').remove();
    }
});


/* ---------------------------------------------------------
   AUTO CALCULATE END TOKEN + PREFIX TOKEN LIST (SCH-1 ...)
------------------------------------------------------------*/

// add listeners
document.querySelector('input[name="start_token_no"]').addEventListener('input', generateTokens);
document.querySelector('input[name="no_of_users"]').addEventListener('input', generateTokens);
document.querySelector('input[name="token_prefix"]').addEventListener('input', generateTokens);

function generateTokens() {
    let start = parseInt(document.querySelector('input[name="start_token_no"]').value);
    let users = parseInt(document.querySelector('input[name="no_of_users"]').value);
    let prefix = document.querySelector('input[name="token_prefix"]').value || "";

    if (isNaN(start) || isNaN(users) || users <= 0) {
        document.getElementById("token_list").value = "";
        return;
    }

    // Auto calculate END TOKEN
    let endValue = start + users - 1;
    document.querySelector('input[name="end_token_no"]').value = endValue;

    // Build token list
    let tokens = [];
    for (let i = start; i <= endValue; i++) {
        tokens.push(prefix + i);
    }

    // Show in textarea
    document.getElementById("token_list").value = tokens.join("\n");
}
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\LENOVO\Downloads\vijay_jwellers\resources\views/admin/manage/settings.blade.php ENDPATH**/ ?>