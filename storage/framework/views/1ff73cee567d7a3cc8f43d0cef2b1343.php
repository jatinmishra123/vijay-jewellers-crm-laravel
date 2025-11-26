

<?php $__env->startSection('title', 'Edit Scheme Setting'); ?>

<?php $__env->startSection('head'); ?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<style>
    #emiTable input.form-control {
        height: 35px; 
        padding: 0.375rem 0.75rem; /* पैडिंग को थोड़ा कम करें */
        font-size: 0.875rem; /* फ़ॉन्ट साइज छोटा करें */
    }
    /* छोटे लेबल को थोड़ा और स्पष्ट करें */
    .form-group label.small, .row label.small {
        font-weight: 500;
        color: #555;
        margin-bottom: 0.2rem;
        display: block; 
    }
</style>

<div class="container-fluid mt-3">

    <div class="card shadow-sm">
        <div class="card-header fw-bold bg-primary text-white"> 
            <i class="bi bi-pencil-square me-2"></i> Edit Scheme Setting
        </div>

        <div class="card-body">

            <form action="<?php echo e(route('admin.manage.settings.update', $setting->id)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                
                <div class="row g-3"> 
                    
                    <div class="col-md-2">
                        <label class="small">Scheme Plan</label>
                        <input type="text" name="scheme_plan" class="form-control <?php $__errorArgs = ['scheme_plan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               value="<?php echo e(old('scheme_plan', $setting->scheme_plan)); ?>">
                        <?php $__errorArgs = ['scheme_plan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    
                    <div class="col-md-3">
                        <label class="small">Scheme Name</label>
                        
                        <select name="scheme_id" class="form-select <?php $__errorArgs = ['scheme_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <option value="">Select Scheme</option>
                            <?php $__currentLoopData = $schemes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $scheme): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($scheme->id); ?>"
                                    <?php echo e($scheme->id == old('scheme_id', $setting->scheme_id) ? 'selected' : ''); ?>>
                                    <?php echo e($scheme->name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['scheme_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    
                    <div class="col-md-2">
                        <label class="small">Cash / Metal</label>
                        <input name="cash_metal" type="text" class="form-control <?php $__errorArgs = ['cash_metal'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               value="<?php echo e(old('cash_metal', $setting->cash_metal)); ?>">
                        <?php $__errorArgs = ['cash_metal'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    
                    <div class="col-md-2">
                        <label class="small">User Group</label>
                        <input name="user_group" type="text" class="form-control <?php $__errorArgs = ['user_group'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               value="<?php echo e(old('user_group', $setting->user_group)); ?>">
                        <?php $__errorArgs = ['user_group'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    
                    <div class="col-md-1">
                        <label class="small">Users</label>
                        <input name="no_of_users" type="number" class="form-control <?php $__errorArgs = ['no_of_users'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               value="<?php echo e(old('no_of_users', $setting->no_of_users)); ?>">
                        <?php $__errorArgs = ['no_of_users'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="col-md-1">
                        <label class="small">EMI Count</label>
                        <input name="no_of_emi" type="number" class="form-control <?php $__errorArgs = ['no_of_emi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               value="<?php echo e(old('no_of_emi', $setting->no_of_emi)); ?>">
                        <?php $__errorArgs = ['no_of_emi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>


                <h5 class="mt-4 mb-3 text-secondary">Financial & Token Settings</h5> 
                <div class="row g-3">
                    <div class="col-md-2">
                        <label class="small">EMI Amount</label>
                        <input name="emi_amt" type="number" class="form-control <?php $__errorArgs = ['emi_amt'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               value="<?php echo e(old('emi_amt', $setting->emi_amt)); ?>">
                        <?php $__errorArgs = ['emi_amt'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="col-md-2">
                        <label class="small">Bonus Amount</label>
                        <input name="bonus_amount" type="number" class="form-control <?php $__errorArgs = ['bonus_amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               value="<?php echo e(old('bonus_amount', $setting->bonus_amount)); ?>">
                        <?php $__errorArgs = ['bonus_amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="col-md-2">
                        <label class="small">Interest Type</label>
                        <input name="interest_type" type="text" class="form-control <?php $__errorArgs = ['interest_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               value="<?php echo e(old('interest_type', $setting->interest_type)); ?>">
                        <?php $__errorArgs = ['interest_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="col-md-2">
                        <label class="small">Start Token</label>
                        <input name="start_token_no" class="form-control <?php $__errorArgs = ['start_token_no'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               value="<?php echo e(old('start_token_no', $setting->start_token_no)); ?>">
                        <?php $__errorArgs = ['start_token_no'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="col-md-2">
                        <label class="small">End Token</label>
                        <input name="end_token_no" class="form-control <?php $__errorArgs = ['end_token_no'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               value="<?php echo e(old('end_token_no', $setting->end_token_no)); ?>">
                        <?php $__errorArgs = ['end_token_no'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>


                <h5 class="mt-4 mb-3 text-secondary">Fees and Discount Settings</h5> 
                <div class="row g-3">
                    <div class="col-md-2">
                        <label class="small">EMI Late Fee %</label>
                        <input name="emi_late_fee" class="form-control <?php $__errorArgs = ['emi_late_fee'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               value="<?php echo e(old('emi_late_fee', $setting->emi_late_fee)); ?>">
                        <?php $__errorArgs = ['emi_late_fee'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="col-md-2">
                        <label class="small">Late Fee Days</label>
                        <input name="late_fee_days" class="form-control <?php $__errorArgs = ['late_fee_days'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               value="<?php echo e(old('late_fee_days', $setting->late_fee_days)); ?>">
                        <?php $__errorArgs = ['late_fee_days'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="col-md-2">
                        <label class="small">Gold Bonus %</label>
                        <input name="gold_bonus_percent" class="form-control <?php $__errorArgs = ['gold_bonus_percent'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               value="<?php echo e(old('gold_bonus_percent', $setting->gold_bonus_percent)); ?>">
                        <?php $__errorArgs = ['gold_bonus_percent'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="col-md-2">
                        <label class="small">Diamond Bonus %</label>
                        <input name="diamond_bonus_percent" class="form-control <?php $__errorArgs = ['diamond_bonus_percent'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               value="<?php echo e(old('diamond_bonus_percent', $setting->diamond_bonus_percent)); ?>">
                        <?php $__errorArgs = ['diamond_bonus_percent'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="col-md-2">
                        <label class="small">Gold Mkg Discount</label>
                        <input name="gold_mkg_discount" class="form-control <?php $__errorArgs = ['gold_mkg_discount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               value="<?php echo e(old('gold_mkg_discount', $setting->gold_mkg_discount)); ?>">
                        <?php $__errorArgs = ['gold_mkg_discount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="col-md-2">
                        <label class="small">Diamond Mkg Discount</label>
                        <input name="diamond_mkg_discount" class="form-control <?php $__errorArgs = ['diamond_mkg_discount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               value="<?php echo e(old('diamond_mkg_discount', $setting->diamond_mkg_discount)); ?>">
                        <?php $__errorArgs = ['diamond_mkg_discount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>


                
                <div class="row mt-4">
                    <div class="col-md-3">
                        <div class="form-check pt-2"> 
                            <input type="checkbox" class="form-check-input"
                                   name="convert_bonus_to_gold"
                                   value="1"
                                   id="convertBonusCheck" 
                                   <?php echo e($setting->convert_bonus_to_gold ? 'checked' : ''); ?>>
                            <label class="form-check-label small" for="convertBonusCheck">Convert Bonus to Gold</label>
                        </div>
                    </div>
                </div>

                <div class="card mt-4 border-info"> 
                    <div class="card-header bg-info text-white fw-bold"> 
                        <i class="bi bi-list-ol me-1"></i> EMI Rows
                        <button type="button" class="btn btn-dark btn-sm float-end" id="addEmiRow">
                            <i class="bi bi-plus-circle-fill me-1"></i> Add Row
                        </button>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover table-sm align-middle" id="emiTable">
                                <thead class="table-light">
                                    <tr>
                                        <th>EMI No</th>
                                        <th>Discount%</th>
                                        <th>Bonus%</th>
                                        <th style="width: 100px;">Action</th> 
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php $__currentLoopData = $setting->emi_rows ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        
                                        <td><input name="emi_rows[<?php echo e($i); ?>][emi_no]" type="number" class="form-control"
                                                   value="<?php echo e(old("emi_rows.$i.emi_no", $row['emi_no'] ?? '')); ?>"></td>

                                        <td><input name="emi_rows[<?php echo e($i); ?>][discount]" type="number" step="0.01" class="form-control"
                                                   value="<?php echo e(old("emi_rows.$i.discount", $row['discount'] ?? '')); ?>"></td>

                                        <td><input name="emi_rows[<?php echo e($i); ?>][bonus]" type="number" step="0.01" class="form-control"
                                                   value="<?php echo e(old("emi_rows.$i.bonus", $row['bonus'] ?? '')); ?>"></td>

                                        <td>
                                            <button type="button" class="btn btn-outline-danger btn-sm remove-row" title="Remove Row">
                                                <i class="bi bi-x-circle"></i> 
                                            </button>
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>


                
                <div class="mt-4 border-top pt-3">
                    <button type="submit" class="btn btn-success btn-lg shadow-sm"> 
                        <i class="bi bi-check-circle-fill me-2"></i> Update Scheme Settings
                    </button>
                    <a href="<?php echo e(route('admin.manage.settings')); ?>" class="btn btn-secondary btn-lg ms-2"> 
                        <i class="bi bi-arrow-left-circle me-2"></i> Back
                    </a>
                </div>

            </form>

        </div>
    </div>

</div>


<script>
    // Laravel के पुराने डेटा को ध्यान में रखते हुए, हम index को सही ढंग से सेट करते हैं
    let emiIndex = <?php echo e(count(old('emi_rows', $setting->emi_rows ?? []))); ?>;

    document.getElementById('addEmiRow').addEventListener('click', function() {
        let tbody = document.querySelector('#emiTable tbody');
        let newRow = tbody.insertRow(); // नया row इन्सर्ट करें

        // EMI No
        let cell1 = newRow.insertCell();
        cell1.innerHTML = `<input name="emi_rows[${emiIndex}][emi_no]" type="number" class="form-control" value="">`;

        // Discount
        let cell2 = newRow.insertCell();
        cell2.innerHTML = `<input name="emi_rows[${emiIndex}][discount]" type="number" step="0.01" class="form-control" value="">`;

        // Bonus
        let cell3 = newRow.insertCell();
        cell3.innerHTML = `<input name="emi_rows[${emiIndex}][bonus]" type="number" step="0.01" class="form-control" value="">`;

        // Action Button
        let cell4 = newRow.insertCell();
        cell4.innerHTML = `<button type="button" class="btn btn-outline-danger btn-sm remove-row" title="Remove Row"><i class="bi bi-x-circle"></i></button>`;
        cell4.style.width = '100px'; // एक्शन सेल की चौड़ाई सेट करें

        emiIndex++;
    });

    // रिमूव बटन पर क्लिक हैंडलर
    document.addEventListener('click', function(e){
        if (e.target.classList.contains('remove-row') || e.target.closest('.remove-row')) {
            e.target.closest('tr').remove();
        }
    });
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\LENOVO\Downloads\vijay_jwellers\resources\views/admin/manage/settings_edit.blade.php ENDPATH**/ ?>