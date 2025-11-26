

<?php $__env->startSection('title', 'Edit Scheme - Admin Dashboard'); ?>

<?php $__env->startSection('content'); ?>

<style>
    .custom-card {
        border-radius: 12px;
        overflow: hidden;
        border: none;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    .custom-card .card-header {
        padding: 15px;
        font-weight: 700;
        text-transform: uppercase;
    }
    .form-control, .form-select, textarea {
        border-radius: 8px !important;
        padding: 12px !important;
        border: 1px solid #dcdcdc !important;
    }
    label {
        font-weight: 700;
        font-size: 0.75rem;
        text-transform: uppercase;
        margin-bottom: 5px;
    }
    .rounded-profile {
        border-radius: 50%;
        border: 4px solid #007bff;
        object-fit: cover;
    }
    .file-input-wrapper {
        position: relative;
        overflow: hidden;
        border: 1px dashed #ced4da;
        border-radius: 8px;
        padding: 10px;
        cursor: pointer;
    }
    .file-input-wrapper:hover {
        border-color: #007bff;
        background: #f8f9fa;
    }
    .file-input-wrapper input[type=file] {
        position: absolute;
        left: 0; top: 0;
        opacity: 0;
        width: 100%; height: 100%;
        cursor: pointer;
    }
    .file-info {
        font-size: 0.9rem;
        color: #333;
        display: block;
        margin-top: 5px;
    }
</style>

<div class="container-fluid pt-3">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-primary">Name:<?php echo e($manage->first_name); ?> <?php echo e($manage->last_name); ?></h3>
        <a href="<?php echo e(route('admin.manage.index')); ?>" class="btn btn-secondary">Back</a>
    </div>

    <form action="<?php echo e(route('admin.manage.update', $manage->id)); ?>" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <div class="row g-4">

            
            <div class="col-md-4">
                <div class="card custom-card">
                    <div class="card-header bg-danger text-white">PERSONAL INFORMATION</div>

                    <div class="card-body">

                        <div class="mb-3">
                            <label>KIJ</label>
                            <input type="text" name="kij" class="form-control" value="<?php echo e(old('kij', $manage->kij)); ?>">
                        </div>

                        <div class="mb-3">
                            <label>Mobile Number</label>
                            <input type="text" name="mobile_number" class="form-control" value="<?php echo e(old('mobile_number', $manage->mobile_number)); ?>">
                        </div>

                        <div class="row">
                            <div class="col-6 mb-3">
                                <label>First Name</label>
                                <input type="text" name="first_name" class="form-control"
                                    value="<?php echo e(old('first_name', $manage->first_name)); ?>">
                            </div>
                            <div class="col-6 mb-3">
                                <label>Last Name</label>
                                <input type="text" name="last_name" class="form-control"
                                    value="<?php echo e(old('last_name', $manage->last_name)); ?>">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label>Father Name</label>
                            <input type="text" name="father_name" class="form-control"
                                value="<?php echo e(old('father_name', $manage->father_name)); ?>">
                        </div>

                        <div class="row">
                            <div class="col-6 mb-3">
                                <label>Country</label>
                                <input type="text" name="country" class="form-control"
                                    value="<?php echo e(old('country', $manage->country)); ?>">
                            </div>
                            <div class="col-6 mb-3">
                                <label>State</label>
                                <input type="text" name="state" class="form-control"
                                    value="<?php echo e(old('state', $manage->state)); ?>">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label>City / Village</label>
                            <input type="text" name="city_village" class="form-control"
                                value="<?php echo e(old('city_village', $manage->city_village)); ?>">
                        </div>

                        <div class="mb-3">
                            <label>Gender</label><br>
                            <input type="radio" name="gender" value="Male" <?php echo e($manage->gender=='Male'?'checked':''); ?>> Male
                            &nbsp;&nbsp;
                            <input type="radio" name="gender" value="Female" <?php echo e($manage->gender=='Female'?'checked':''); ?>> Female
                        </div>

                        <div class="mb-3">
                            <label>Marital Status</label><br>
                            <input type="radio" name="marital_status" value="Single" <?php echo e($manage->marital_status=='Single'?'checked':''); ?>> Single
                            &nbsp;&nbsp;
                            <input type="radio" name="marital_status" value="Married" <?php echo e($manage->marital_status=='Married'?'checked':''); ?>> Married
                        </div>

                        <div class="mb-3">
                            <label>Date of Birth</label>
                            <input type="date" name="date_of_birth" class="form-control"
                                value="<?php echo e(old('date_of_birth', $manage->date_of_birth)); ?>">
                        </div>

                        <div class="mb-3">
                            <label>Aadhaar Number</label>
                            <input type="text" name="aadhar_number" class="form-control"
                                value="<?php echo e(old('aadhar_number', $manage->aadhar_number)); ?>">
                        </div>

                        <div class="mb-3">
                            <label>PAN Number</label>
                            <input type="text" name="pan_number" class="form-control"
                                value="<?php echo e(old('pan_number', $manage->pan_number)); ?>">
                        </div>

                    </div>
                </div>
            </div>

            
            <div class="col-md-4">
                <div class="card custom-card">
                    <div class="card-header bg-primary text-white">SCHEME DETAILS</div>

                    <div class="card-body">

                        <div class="mb-3">
                            <label>Scheme Name</label>
                            <input type="text" name="scheme_name" class="form-control"
                                value="<?php echo e(old('scheme_name', $manage->scheme_name)); ?>">
                        </div>

                        <div class="mb-3">
                            <label>Scheme EMI Amount</label>
                            <input type="number" name="scheme_emi_amount" class="form-control"
                                value="<?php echo e(old('scheme_emi_amount', $manage->scheme_emi_amount)); ?>">
                        </div>
 <div class="mb-3">
                            <label>Scheme EMI plan</label>
                            <input type="number" name="scheme_emi_plan" class="form-control"
                                value="<?php echo e(old('scheme_emi_plan', $manage->scheme_emi_plan)); ?>">
                        </div>
                        <div class="mb-3">
                            <label>Nominee Name</label>
                            <input type="text" name="nominee_name" class="form-control"
                                value="<?php echo e(old('nominee_name', $manage->nominee_name)); ?>">
                        </div>

                        <div class="mb-3">
                            <label>Nominee Relation</label>
                            <input type="text" name="nominee_relation" class="form-control"
                                value="<?php echo e(old('nominee_relation', $manage->nominee_relation)); ?>">
                        </div>

                        <div class="mb-3">
                            <label>User Group</label>
                            <input type="text" name="user_group" class="form-control"
                                value="<?php echo e(old('user_group', $manage->user_group)); ?>">
                        </div>

                        <div class="mb-3">
                            <label>Select Staff</label>
                            <select name="staff_id" class="form-select">
                                <option value="">Select Staff</option>
                                <option value="1" <?php echo e($manage->staff_id==1?'selected':''); ?>>Manager</option>
                                <option value="2" <?php echo e($manage->staff_id==2?'selected':''); ?>>Incharge</option>
                                <option value="3" <?php echo e($manage->staff_id==3?'selected':''); ?>>Agent</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label>Other Information</label>
                            <textarea name="other_information" class="form-control" rows="4"><?php echo e(old('other_information', $manage->other_information)); ?></textarea>
                        </div>

                    </div>
                </div>
            </div>

         
<div class="col-md-4">
    <div class="card custom-card">
        <div class="card-header bg-warning">DOCUMENTS</div>

        <div class="card-body text-center">

            
            <div class="mb-4">
                <img src="<?php echo e(asset('storage/'.$manage->profile_image)); ?>"
                     width="130" height="130" id="profile_preview"
                     class="rounded-profile">

                <div class="file-input-wrapper mt-2">
                    <strong>Change Profile Image</strong>
                    
                    <input type="file" name="profile_image_upload" id="profile_image_upload" accept="image/*">
                </div>
            </div>

            
            <h6>PAN Card</h6>
            <div class="mb-4">
                
                <?php if(pathinfo($manage->pan_card, PATHINFO_EXTENSION) == 'pdf'): ?>
                    <iframe src="<?php echo e(asset('storage/'.$manage->pan_card)); ?>" width="100%" height="120"></iframe>
                <?php else: ?>
                    <img src="<?php echo e(asset('storage/'.$manage->pan_card)); ?>"
                         width="130" height="130" id="pan_preview"
                         class="rounded mb-2" style="object-fit:cover;">
                <?php endif; ?>

                <div class="file-input-wrapper">
                    <strong>Change PAN Card</strong>
                    
                    <input type="file" name="pan_card_upload" id="pan_card_upload" accept="image/*,application/pdf">
                </div>
            </div>

            
            <h6>Aadhaar Card</h6>
            <div class="mb-3">

                
                <?php if(pathinfo($manage->aadhar_card, PATHINFO_EXTENSION) == 'pdf'): ?>
                    <iframe src="<?php echo e(asset('storage/'.$manage->aadhar_card)); ?>" width="100%" height="120"></iframe>
                <?php else: ?>
                    <img src="<?php echo e(asset('storage/'.$manage->aadhar_card)); ?>"
                         width="130" height="130" id="aadhar_preview"
                         class="rounded mb-2" style="object-fit:cover;">
                <?php endif; ?>

                <div class="file-input-wrapper">
                    <strong>Change Aadhaar Card</strong>
                    
                    <input type="file" name="aadhar_card_upload" id="aadhar_card_upload" accept="image/*,application/pdf">
                </div>
            </div>

        </div>
    </div>
</div>

        <div class="text-center mt-5 mb-5">
            <button class="btn btn-success btn-lg px-5">Update Scheme</button>
        </div>

    </form>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function () {

    function previewImage(input, previewId, filenameBoxId) {
        input.addEventListener('change', function () {
            let file = this.files[0];
            document.getElementById(filenameBoxId).textContent = file.name;

            if (file.type.includes("image")) {
                let reader = new FileReader();
                reader.onload = (e) => document.getElementById(previewId).src = e.target.result;
                reader.readAsDataURL(file);
            }
        });
    }

    previewImage(document.getElementById('profile_image_upload'), 'profile_preview', 'profile_filename');
    previewImage(document.getElementById('pan_card_upload'), 'pan_preview', 'pan_filename');
    previewImage(document.getElementById('aadhar_card_upload'), 'aadhar_preview', 'aadhar_filename');

});
</script>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\LENOVO\Downloads\vijay_jwellers\resources\views/admin/manage/edit.blade.php ENDPATH**/ ?>