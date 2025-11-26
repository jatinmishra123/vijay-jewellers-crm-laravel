

<?php $__env->startSection('title', 'View Scheme Details'); ?>

<?php $__env->startSection('content'); ?>

<style>
    /* Global Styles */
    .details-card {
        border-radius: 12px;
        border: 1px solid #ddd;
        background: #fff; /* Changed to white for better contrast */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05); /* Added subtle shadow */
    }
    
    /* Header Styles */
    .details-title {
        background: #007bff; /* Primary Blue for consistency */
        color: white;
        padding: 12px 18px;
        font-weight: 700;
        font-size: 1.15rem;
        border-radius: 12px 12px 0 0;
    }
    .details-body {
        padding: 20px;
    }
    
    /* Data Row Styles */
    .label {
        font-weight: 600;
        text-transform: uppercase;
        color: #6c757d; /* Muted gray for label */
        font-size: 0.8rem;
        display: block; /* Ensures label takes full width */
        margin-bottom: 2px;
    }
    .value {
        color: #212529;
        font-size: 1.0rem;
        font-weight: 500;
    }
    .info-row {
        margin-bottom: 18px; /* Increased margin for spacing */
    }

    /* Document/Image Styles */
    .doc-preview {
        padding: 15px;
        background: #f8f9fa;
        border-radius: 8px;
        border: 1px solid #eee;
    }
    .doc-img {
        max-width: 100%;
        height: 150px; /* Fixed height for consistency */
        object-fit: contain; /* Ensures the image fits without cropping */
        border-radius: 8px;
        border: 1px solid #ccc;
        margin-bottom: 10px;
    }
    .doc-icon {
        font-size: 3rem;
        color: #dc3545; /* Red for PDF/Document */
        margin-bottom: 10px;
    }
</style>

<div class="container-fluid pt-3">

    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-primary">Customer Scheme Details: <?php echo e($manage->first_name ?? ''); ?> <?php echo e($manage->last_name ?? ''); ?></h3>
        
        <div class="btn-group" role="group" aria-label="Record actions">
            
            <a href="<?php echo e(route('admin.manage.edit', $manage->id)); ?>" class="btn btn-warning me-2">
                <i class="fas fa-edit me-1"></i> Edit Record
            </a>
            
            
            <a href="<?php echo e(route('admin.manage.index')); ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back to List
            </a>
        </div>
    </div>
    
    <div class="row">
        
<div class="col-md-7">

    
    <div class="card mb-4">
        <div class="card-header bg-primary text-white fw-bold">
            Personal Information
        </div>

        <div class="card-body">

            <div class="row g-3">
<style>
    .info-box {
        background: #f8f9ff;
        border: 1px solid #e1e5f2;
        padding: 12px 15px;
        border-radius: 8px;
        margin-bottom: 12px;
        transition: .2s;
    }
    .info-box:hover {
        background: #eef2ff;
        border-color: #c7d2fe;
    }
    .info-label {
        font-size: 0.78rem;
        font-weight: 600;
        color: #5a5a5a;
        text-transform: uppercase;
        letter-spacing: .5px;
        margin-bottom: 2px;
    }
    .info-value {
        font-size: 1rem;
        font-weight: 600;
        color: #1f2d3d;
    }
</style>

<div class="row g-3">

    <div class="col-md-6">
        <div class="info-box">
            <div class="info-label">KIJ</div>
            <div class="info-value"><?php echo e($manage->kij ?? 'N/A'); ?></div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="info-box">
            <div class="info-label">Mobile Number</div>
            <div class="info-value"><?php echo e($manage->mobile_number ?? 'N/A'); ?></div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="info-box">
            <div class="info-label">Name</div>
            <div class="info-value"><?php echo e($manage->first_name); ?> <?php echo e($manage->last_name); ?></div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="info-box">
            <div class="info-label">Father Name</div>
            <div class="info-value"><?php echo e($manage->father_name ?? 'N/A'); ?></div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="info-box">
            <div class="info-label">Gender</div>
            <div class="info-value"><?php echo e($manage->gender ?? 'N/A'); ?></div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="info-box">
            <div class="info-label">Marital Status</div>
            <div class="info-value"><?php echo e($manage->marital_status ?? 'N/A'); ?></div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="info-box">
            <div class="info-label">Date of Birth</div>
            <div class="info-value">
                <?php echo e($manage->date_of_birth 
                    ? \Carbon\Carbon::parse($manage->date_of_birth)->format('d M, Y') 
                    : 'N/A'); ?>

            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="info-box">
            <div class="info-label">Country</div>
            <div class="info-value"><?php echo e($manage->country ?? 'N/A'); ?></div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="info-box">
            <div class="info-label">State</div>
            <div class="info-value"><?php echo e($manage->state ?? 'N/A'); ?></div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="info-box">
            <div class="info-label">City/Village</div>
            <div class="info-value"><?php echo e($manage->city_village ?? 'N/A'); ?></div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="info-box">
            <div class="info-label">Aadhar Number</div>
            <div class="info-value"><?php echo e($manage->aadhar_number ?? 'N/A'); ?></div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="info-box">
            <div class="info-label">PAN Number</div>
            <div class="info-value"><?php echo e($manage->pan_number ?? 'N/A'); ?></div>
        </div>
    </div>

</div>

            </div>

        </div>
    </div>
  
            <div class="details-card mb-4">
                <div class="details-title" style="background: #6c757d;">Other Information</div>
                <div class="details-body">
                    <div class="col-md-12 info-row">
                        <div class="value fst-italic"><?php echo e($manage->other_information ?? 'No additional information provided.'); ?></div>
                    </div>
                </div>
            </div>
</div>

        
        <div class="col-md-5">
            
            <div class="details-card mb-4">
                <div class="details-title" style="background: #198754;">Scheme Details</div>
                <div class="details-body">
                    <div class="row">
                        <div class="col-12 info-row">
                            <span class="label">Scheme Name</span>
                            <div class="value"><?php echo e($manage->scheme_name ?? 'N/A'); ?></div>
                        </div>

                        <div class="col-12 info-row">
                            <span class="label">EMI Amount</span>
                            <div class="value">
                                <?php if($manage->scheme_emi_amount): ?>
                                    <span class="badge bg-success fs-6">₹ <?php echo e(number_format($manage->scheme_emi_amount, 2)); ?></span>
                                <?php else: ?>
                                    N/A
                                <?php endif; ?>
                            </div>
                        </div>
 <div class="col-12 info-row">
    <span class="label">EMI Plan (in Months)</span>
    <div class="value">
        <?php if(!empty($manage->scheme_emi_plan)): ?>
            <span class="badge bg-success fs-6">
                Months: <?php echo e($manage->scheme_emi_plan); ?>

            </span>
        <?php else: ?>
            <span class="text-muted">N/A</span>
        <?php endif; ?>
    </div>
</div>

                        <hr class="mt-2 mb-3">

                        <div class="col-12 info-row">
                            <span class="label">Nominee Name</span>
                            <div class="value"><?php echo e($manage->nominee_name ?? 'N/A'); ?></div>
                        </div>

                        <div class="col-12 info-row">
                            <span class="label">Nominee Relation</span>
                            <div class="value"><?php echo e($manage->nominee_relation ?? 'N/A'); ?></div>
                        </div>

                        <hr class="mt-2 mb-3">

                        <div class="col-12 info-row">
                            <span class="label">Assigned Staff ID</span>
                            <div class="value"><?php echo e($manage->staff_id ?? 'N/A'); ?></div>
                        </div>

                        <div class="col-12 info-row">
                            <span class="label">User Group</span>
                            <div class="value"><?php echo e($manage->user_group ?? 'N/A'); ?></div>
                        </div>
  <div class="col-12 info-row">
                            <span class="label">Start Date</span>
                            <div class="value"><?php echo e($manage->start_date ?? 'N/A'); ?></div>
                        </div>
                         <div class="col-12 info-row">
                            <span class="label">End date</span>
                            <div class="value"><?php echo e($manage->end_date ?? 'N/A'); ?></div>
                        </div>
                    </div>
                </div>
            </div>
            
          
            
        </div> 
        
    </div> 
    
    
    <div class="row">
        <div class="col-12">
            <div class="details-card mb-4">
                <div class="details-title bg-warning text-dark">Document Uploads 📁</div>
                <div class="details-body">

                    <div class="row text-center">

                        
                        <?php
                            $documents = [
                                'Profile Image' => $manage->profile_image,
                                'PAN Card' => $manage->pan_card,
                                'Aadhaar Card' => $manage->aadhar_card,
                            ];
                        ?>

                        <?php $__currentLoopData = $documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $docName => $docPath): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-md-4 mb-4">
                                <h6 class="fw-bold"><?php echo e($docName); ?></h6>
                                <div class="doc-preview">
                                    <?php if($docPath): ?>
                                        <?php
                                            $fullPath = asset('storage/' . $docPath);
                                            $extension = pathinfo($docPath, PATHINFO_EXTENSION);
                                            $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                                        ?>

                                        <?php if($isImage): ?>
                                            <a href="<?php echo e($fullPath); ?>" target="_blank">
                                                <img src="<?php echo e($fullPath); ?>" class="doc-img" alt="<?php echo e($docName); ?>">
                                            </a>
                                            <a href="<?php echo e($fullPath); ?>" target="_blank" class="btn btn-sm btn-outline-primary mt-1">
                                                <i class="fas fa-eye"></i> View Image
                                            </a>
                                        <?php else: ?>
                                            
                                            <i class="fas fa-file-pdf doc-icon"></i>
                                            <p class="text-muted mb-2">File Type: **.<?php echo e(strtoupper($extension)); ?>**</p>
                                            <a href="<?php echo e($fullPath); ?>" target="_blank" class="btn btn-danger btn-sm">
                                                <i class="fas fa-download"></i> Download/View File
                                            </a>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <p class="text-muted fst-italic pt-4 pb-3">Not Uploaded</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>

<?php $__env->stopPush(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\LENOVO\Downloads\vijay_jwellers\resources\views/admin/manage/show.blade.php ENDPATH**/ ?>