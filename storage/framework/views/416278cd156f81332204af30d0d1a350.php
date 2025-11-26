

<?php $__env->startSection('title', 'Add Scheme - Admin Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
    /* ... (Your existing custom styles remain here) ... */
    .custom-card {
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid #e6e6e6;
    }

    .custom-card .card-header {
        padding: 12px 18px;
        font-size: 16px;
        letter-spacing: .5px;
    }

    .custom-card .card-body {
        padding: 18px;
        background: #fafafa;
    }

    .form-control, .form-select, textarea {
        border-radius: 8px !important;
        padding: 12px !important; 
        border: 1px solid #cfcfcf !important;
    }

    label {
        font-weight: 600;
        font-size: 14px; 
        margin-bottom: 5px;
        text-transform: uppercase;
        color: #444;
    }
    
    .casual-header {
        background-color: #f8f9fa; 
        border-bottom: 3px solid #007bff;
        padding: 15px 0;
        margin-bottom: 30px;
        border-radius: 8px;
    }

    /* New style for error box emphasis */
    .error-box {
        font-weight: 700;
        color: #dc3545; /* Bootstrap danger color */
        border-left: 3px solid #dc3545;
        padding-left: 8px;
        margin-top: 5px;
        font-size: 0.85rem;
    }
</style>

<div class="container-fluid">

    
    <div class="casual-header mb-4">
        <div class="row align-items-center">
            
            
            <div class="col-md-9">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-1">
                        <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Add New Scheme</li>
                    </ol>
                </nav>
                <h1 class="h3 fw-bold text-primary">👋 Enroll a New Customer Scheme</h1>
                <p class="text-muted mb-0">Please fill out all the necessary details below to officially register a new customer and their selected investment scheme.</p>
            </div>

            
            <div class="col-md-3 text-end">
                <a href="<?php echo e(route('admin.manage.index')); ?>" class="btn btn-outline-secondary d-inline-flex align-items-center">
                    <i class="fas fa-arrow-left me-2"></i> 
                    Go Back
                </a>
            </div>
        </div>
    </div>
    

    
    <form action="<?php echo e(route('admin.manage.store')); ?>" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>

        
        <div class="row g-3">
            
            <div class="col-md-6">
                <div class="card custom-card shadow-sm">

                    <div class="card-header bg-danger text-white fw-bold">
                        PERSONAL INFORMATION
                    </div>

                    <div class="card-body">
                        
                        
                        <div class="mb-3">
                            <label for="kij">KIJ</label>
                            <input type="text" class="form-control <?php $__errorArgs = ['kij'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="kij" name="kij" placeholder="Enter KIJ Number" value="<?php echo e(old('kij')); ?>">
                            <?php $__errorArgs = ['kij'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                                <div class="invalid-feedback">
                                    <?php echo e($message); ?>

                                </div> 
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        
                        <div class="mb-3">
                            <label for="mobile_number">Mobile Number <span class="text-danger">*</span></label>
                            <input type="tel" 
                                   class="form-control <?php $__errorArgs = ['mobile_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="mobile_number" 
                                   name="mobile_number" 
                                   placeholder="e.g., 9876543210"
                                   required 
                                   pattern="[0-9]*" 
                                   maxlength="12"
                                   title="Only digits (0-9) are allowed."
                                   value="<?php echo e(old('mobile_number')); ?>">
                            
                            <?php $__errorArgs = ['mobile_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="error-box">
                                    <i class="fas fa-exclamation-triangle me-1"></i> **Error:** <?php echo e($message); ?>

                                </div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label for="first_name">First Name</label>
                                <input type="text" class="form-control <?php $__errorArgs = ['first_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="first_name" name="first_name" placeholder="Enter First Name" value="<?php echo e(old('first_name')); ?>">
                                <?php $__errorArgs = ['first_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="col-6 mb-3">
                                <label for="last_name">Last Name</label>
                                <input type="text" class="form-control <?php $__errorArgs = ['last_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="last_name" name="last_name" placeholder="Enter Last Name" value="<?php echo e(old('last_name')); ?>">
                                <?php $__errorArgs = ['last_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="father_name">Father Name (S/o)</label>
                            <input type="text" class="form-control <?php $__errorArgs = ['father_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="father_name" name="father_name" placeholder="Enter Father's Name" value="<?php echo e(old('father_name')); ?>">
                            <?php $__errorArgs = ['father_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label for="country">Country</label>
                                <input type="text" class="form-control <?php $__errorArgs = ['country'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="country" name="country" value="<?php echo e(old('country')); ?>" placeholder="Enter Country..">
                                <?php $__errorArgs = ['country'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="col-6 mb-3">
                                <label for="state">State</label>
                                <input type="text" class="form-control <?php $__errorArgs = ['state'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="state" name="state" value="<?php echo e(old('state')); ?>" placeholder="Enter State..">
                                <?php $__errorArgs = ['state'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="city_village">City / Village</label>
                            <input type="text" class="form-control <?php $__errorArgs = ['city_village'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="city_village" name="city_village" placeholder="Enter City or Village" value="<?php echo e(old('city_village')); ?>">
                            <?php $__errorArgs = ['city_village'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                       
<div class="mb-3 d-flex align-items-center">
    <label class="me-3 fw-semibold">Gender:</label>

    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="gender" id="gender_male"
               value="Male" <?php echo e(old('gender') == 'Male' ? 'checked' : ''); ?>>
        <label class="form-check-label" for="gender_male">Male</label>
    </div>

    <div class="form-check form-check-inline ms-3">
        <input class="form-check-input" type="radio" name="gender" id="gender_female"
               value="Female" <?php echo e(old('gender') == 'Female' ? 'checked' : ''); ?>>
        <label class="form-check-label" for="gender_female">Female</label>
    </div>
</div>
<?php $__errorArgs = ['gender'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
<div class="text-danger small mt-1"><?php echo e($message); ?></div>
<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>



<div class="mb-3 d-flex align-items-center">
    <label class="me-3 fw-semibold">Marital Status:</label>

    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="marital_status" id="marital_single"
               value="Single" <?php echo e(old('marital_status') == 'Single' ? 'checked' : ''); ?>>
        <label class="form-check-label" for="marital_single">Single</label>
    </div>

    <div class="form-check form-check-inline ms-3">
        <input class="form-check-input" type="radio" name="marital_status" id="marital_married"
               value="Married" <?php echo e(old('marital_status') == 'Married' ? 'checked' : ''); ?>>
        <label class="form-check-label" for="marital_married">Married</label>
    </div>
</div>
<?php $__errorArgs = ['marital_status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
<div class="text-danger small mt-1"><?php echo e($message); ?></div>
<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>


                        <div class="mb-3">
                            <label for="date_of_birth">Date of Birth</label>
                            <input type="date" class="form-control <?php $__errorArgs = ['date_of_birth'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="date_of_birth" name="date_of_birth" value="<?php echo e(old('date_of_birth')); ?>">
                            <?php $__errorArgs = ['date_of_birth'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        
                        
                        <div class="mb-3">
                            <label for="aadhar_number">Aadhar Number</label>
                            <input type="text" class="form-control <?php $__errorArgs = ['aadhar_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="aadhar_number" name="aadhar_number" placeholder="Enter Aadhar Number" pattern="[0-9]{12}" maxlength="12" title="Aadhar must be 12 digits." value="<?php echo e(old('aadhar_number')); ?>">
                            
                            <?php $__errorArgs = ['aadhar_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                                <div class="error-box">
                                    <i class="fas fa-exclamation-triangle me-1"></i> **Error:** <?php echo e($message); ?>

                                </div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        
                        <div class="mb-3">
                            <label for="pan_number">PAN Number</label>
                            <input type="text" class="form-control <?php $__errorArgs = ['pan_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="pan_number" name="pan_number" placeholder="Enter PAN Number" pattern="[A-Z]{5}[0-9]{4}[A-Z]{1}" maxlength="10" title="PAN must be 10 characters (e.g., ABCDE1234F)" value="<?php echo e(old('pan_number')); ?>">
                            
                            <?php $__errorArgs = ['pan_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                                <div class="error-box">
                                    <i class="fas fa-exclamation-triangle me-1"></i> **Error:** <?php echo e($message); ?>

                                </div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card custom-card shadow-sm">

                    <div class="card-header bg-primary text-white fw-bold">
                        SCHEME DETAILS
                    </div>

                    <div class="card-body">

                        
                        <div class="mb-3">
                            <label for="scheme_name">Scheme Name</label>
                            <input type="text" class="form-control <?php $__errorArgs = ['scheme_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="scheme_name" name="scheme_name" placeholder="e.g., Gold Investment Plan" value="<?php echo e(old('scheme_name')); ?>">
                            <?php $__errorArgs = ['scheme_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        
                        <div class="mb-3">
                            <label for="scheme_emi_amount">Scheme EMI Amount</label>
                            <input type="number" step="1" class="form-control <?php $__errorArgs = ['scheme_emi_amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="scheme_emi_amount" name="scheme_emi_amount" placeholder="e.g., 5000" value="<?php echo e(old('scheme_emi_amount')); ?>">
                            <?php $__errorArgs = ['scheme_emi_amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                                <div class="invalid-feedback">
                                    <?php echo e($message); ?>

                                </div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                       
<div class="mb-3">
    <label for="scheme_emi_plan">Scheme EMI Month Plan</label>
    <input type="number" step="1" class="form-control" id="scheme_emi_plan" name="scheme_emi_plan" placeholder="How many months" value="<?php echo e(old('scheme_emi_plan')); ?>">
</div>

<div class="mb-3">
    <label for="start_date">Start Date</label>
    <input type="date" class="form-control" id="start_date" name="start_date" value="<?php echo e(old('start_date')); ?>">
</div>

<div class="mb-3">
    <label for="end_date">End Date</label>
    <input type="date" class="form-control" id="end_date" name="end_date" readonly>
</div>

                        
                        <div class="mb-3">
                            <label for="nominee_name">Nominee Name</label>
                            <input type="text" class="form-control <?php $__errorArgs = ['nominee_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="nominee_name" name="nominee_name" placeholder="Enter Nominee's Name" value="<?php echo e(old('nominee_name')); ?>">
                            <?php $__errorArgs = ['nominee_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        
                        <div class="mb-3">
                            <label for="nominee_relation">Nominee Relation</label>
                            <input type="text" class="form-control <?php $__errorArgs = ['nominee_relation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="nominee_relation" name="nominee_relation" placeholder="e.g., Wife, Son, Father" value="<?php echo e(old('nominee_relation')); ?>">
                            <?php $__errorArgs = ['nominee_relation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        
                        <div class="mb-3">
                            <label for="user_group">User Group</label>
                            <input type="text" class="form-control <?php $__errorArgs = ['user_group'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="user_group" name="user_group" placeholder="e.g., Group A" value="<?php echo e(old('user_group')); ?>">
                            <?php $__errorArgs = ['user_group'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        
                        <div class="mb-3">
                            <label for="select_staff">Select Staff</label>
                            <select class="form-select <?php $__errorArgs = ['staff_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="select_staff" name="staff_id">
                                <option value="" <?php echo e(old('staff_id') == '' ? 'selected' : ''); ?>>Select Staff</option>
                                
                                <option value="1" <?php echo e(old('staff_id') == '1' ? 'selected' : ''); ?>>Manager</option>
                                <option value="2" <?php echo e(old('staff_id') == '2' ? 'selected' : ''); ?>>Incharge</option>
                                <option value="3" <?php echo e(old('staff_id') == '3' ? 'selected' : ''); ?>>Agent</option>
                            </select>
                            <?php $__errorArgs = ['staff_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

<script>
function calculateEndDate() {
    let start = document.getElementById("start_date").value;
    let months = document.getElementById("scheme_emi_plan").value;

    if (!start || !months) return;

    let startDate = new Date(start);

    // Add months to date
    let endDate = new Date(startDate);
    endDate.setMonth(startDate.getMonth() + parseInt(months));

    // Format YYYY-MM-DD
    document.getElementById("end_date").value = endDate.toISOString().split("T")[0];
}

// Trigger on changing start date OR emi plan
document.getElementById("start_date").addEventListener("change", calculateEndDate);
document.getElementById("scheme_emi_plan").addEventListener("input", calculateEndDate);
</script>


                        
                        <div class="mb-3">
                            <label for="other_information">Other Information</label>
                            <textarea class="form-control <?php $__errorArgs = ['other_information'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="other_information" name="other_information" rows="4" placeholder="Any additional notes or details..."><?php echo e(old('other_information')); ?></textarea>
                            <?php $__errorArgs = ['other_information'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                    </div>
                </div>
            </div>

        </div>

       
<div class="row g-3 mt-3">

    <div class="col-md-4">
        <div class="card custom-card shadow-sm">

            <div class="card-header bg-warning fw-bold">
                CUSTOMER IMAGE & DOCUMENTS
            </div>

            <div class="card-body text-center">

                
                <img id="profilePreview"
                     src="https://via.placeholder.com/130"
                     class="rounded-profile mb-3"
                     width="130" height="130"
                     style="object-fit: cover;"
                     alt="">

                <h6 class="fw-bold mt-3">Upload Options (Profile Image)</h6>

                <div class="d-flex gap-2 mt-2">
                    
                    <label class="file-input-wrapper w-50">
                        <button type="button" class="btn btn-outline-secondary w-100">
                            From Computer
                        </button>
                        <input type="file"
                               name="profile_image_upload"
                               id="profileInput"
                               accept="image/*"
                               style="display:none;">
                    </label>

                    <button type="button" class="btn btn-outline-secondary w-50">
                        From Webcam
                    </button>
                </div>

                <?php $__errorArgs = ['profile_image_upload'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="alert alert-danger mt-2 py-1">
                        <i class="bi bi-exclamation-triangle-fill"></i> <?php echo e($message); ?>

                    </div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>



                
                <h6 class="fw-bold mt-4">PAN CARD (Document Upload)</h6>

                <img id="panPreview" src="" class="rounded mb-2" style="width:120px; display:none;" />

                <div class="d-flex gap-2 mt-2">
                    <label class="file-input-wrapper w-50">
                        <button type="button" class="btn btn-outline-secondary w-100">
                            Computer
                        </button>
                        <input type="file"
                               name="pan_card_upload"
                               id="panInput"
                               accept="image/*,application/pdf"
                               style="display:none;">
                    </label>

                    <button type="button" class="btn btn-outline-secondary w-50">Webcam</button>
                </div>

                <?php $__errorArgs = ['pan_card_upload'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="alert alert-danger mt-2 py-1">
                        <i class="bi bi-exclamation-triangle-fill"></i> <?php echo e($message); ?>

                    </div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>



                
                <h6 class="fw-bold mt-4">Aadhaar Card (Document Upload)</h6>

                <img id="aadharPreview" src="" class="rounded mb-2" style="width:120px; display:none;" />

                <div class="d-flex gap-2 mt-2">
                    <label class="file-input-wrapper w-50">
                        <button type="button" class="btn btn-outline-secondary w-100">
                            Computer
                        </button>
                        <input type="file"
                               name="aadhar_card_upload"
                               id="aadharInput"
                               accept="image/*,application/pdf"
                               style="display:none;">
                    </label>

                    <button type="button" class="btn btn-outline-secondary w-50">Webcam</button>
                </div>

                <?php $__errorArgs = ['aadhar_card_upload'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="alert alert-danger mt-2 py-1">
                        <i class="bi bi-exclamation-triangle-fill"></i> <?php echo e($message); ?>

                    </div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

            </div>

        </div>
    </div>

</div>


<script>
    // Click on button → open file picker
    document.querySelectorAll('.file-input-wrapper button').forEach(btn => {
        btn.addEventListener('click', function () {
            this.nextElementSibling.click();
        });
    });

    // Show preview for image files
    function previewImage(input, previewId) {
        const file = input.files[0];
        const preview = document.getElementById(previewId);

        if (!file) return;

        if (file.type.includes("image")) {
            const reader = new FileReader();
            reader.onload = e => {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            preview.src = "<?php echo e(asset('pdf-icon.png')); ?>"; // Add your PDF icon here
            preview.style.display = 'block';
        }
    }

    // Bind inputs
    document.getElementById('profileInput').addEventListener('change', function () {
        previewImage(this, 'profilePreview');
    });

    document.getElementById('panInput').addEventListener('change', function () {
        previewImage(this, 'panPreview');
    });

    document.getElementById('aadharInput').addEventListener('change', function () {
        previewImage(this, 'aadharPreview');
    });
</script>

        
        <div class="row mt-4 mb-5">
            <div class="col-12 text-center">
                
                <button type="submit" class="btn btn-success btn-lg px-5">
                    <i class="fas fa-check-circle me-2"></i> Submit Scheme Details
                </button>
            </div>
        </div>

    </form>
    
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mobileInput = document.getElementById('mobile_number');
        if (mobileInput) {
            mobileInput.addEventListener('keypress', function (e) {
                // Check if the key pressed is not a digit (0-9)
                if (e.key < '0' || e.key > '9') {
                    // Prevent input unless it's a control key like backspace, delete, or arrow keys (which are not caught by e.key)
                    if (e.key.length === 1) { // Only stop single character inputs
                        e.preventDefault();
                    }
                }
            });
            
            // Also listen for pasting to remove non-digit characters
            mobileInput.addEventListener('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '');
            });
        }
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\LENOVO\Downloads\vijay_jwellers\resources\views/admin/manage/create.blade.php ENDPATH**/ ?>