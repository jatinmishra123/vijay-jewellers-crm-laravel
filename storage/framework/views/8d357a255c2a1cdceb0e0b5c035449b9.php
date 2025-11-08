

<?php $__env->startSection('title', ' Payment'); ?>

<?php $__env->startSection('content'); ?>
    <div class="payment-wrapper d-flex justify-content-center align-items-center">
        <div class="payment-card text-center shadow-lg animate-float">
            <div class="mb-4">
                <h3 class="fw-bold text-primary">💳 Secure Payment</h3>
                <p class="text-muted">Enter your details to proceed with payment</p>
            </div>

            <?php if($errors->any()): ?>
                <div class="alert alert-danger text-start">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <p class="mb-0"><?php echo e($error); ?></p>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>

            <form action="<?php echo e(route('payphi.initiate')); ?>" method="POST" id="checkoutForm">
                <?php echo csrf_field(); ?>

                <div class="mb-3 text-start">
                    <label class="form-label fw-semibold">Amount (₹)</label>
                    <input type="number" name="amount" id="amount" step="0.01" min="1" class="form-control shadow-sm"
                        required>
                </div>

                <div class="mb-3 text-start">
                    <label class="form-label fw-semibold">Email</label>
                    <input type="email" name="customer_email" id="customer_email" class="form-control shadow-sm" required>
                </div>

                <div class="mb-3 text-start">
                    <label class="form-label fw-semibold">Mobile</label>
                    <input type="text" name="customer_mobile" id="customer_mobile" class="form-control shadow-sm" required
                        maxlength="10">
                </div>

                <input type="hidden" name="customer_id" id="customer_id">

                <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold mt-3">
                    <i class="bi bi-cash-coin me-2"></i>Pay Now
                </button>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('head'); ?>
    <style>
        /* 🎨 Background gradient with smooth animation */
        body {
            background: linear-gradient(-45deg, #386d93ff, #3779afff, #3b7eb5ff, #42a5f5);
            background-size: 400% 400%;
            animation: gradientMove 10s ease infinite;
            font-family: 'Poppins', sans-serif;
        }

        @keyframes gradientMove {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        /* Center card container */
        .payment-wrapper {
            min-height: 100vh;
            padding: 20px;
        }

        /* Card styling */
        .payment-card {
            background: #fff;
            border-radius: 20px;
            max-width: 420px;
            width: 100%;
            padding: 2rem 2.5rem;
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
        }

        /* Floating movement animation */
        .animate-float {
            animation: float 4s ease-in-out infinite;
        }

        @keyframes float {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        /* Input fields */
        .form-control {
            border-radius: 10px;
            transition: all 0.3s ease;
            border: 1px solid #cfd8dc;
        }

        .form-control:focus {
            border-color: #42a5f5;
            box-shadow: 0 0 8px rgba(33, 150, 243, 0.3);
        }

        /* Button hover animation */
        .btn-primary {
            background: linear-gradient(45deg, #42a5f5, #1e88e5);
            border: none;
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: scale(1.05);
            background: linear-gradient(45deg, #1e88e5, #42a5f5);
            box-shadow: 0 4px 15px rgba(33, 150, 243, 0.4);
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const params = new URLSearchParams(window.location.search);

            if (params.has('amount')) document.getElementById('amount').value = params.get('amount');
            if (params.has('customer_email')) document.getElementById('customer_email').value = params.get('customer_email');
            if (params.has('customer_mobile')) document.getElementById('customer_mobile').value = params.get('customer_mobile');
            if (params.has('customer_id')) document.getElementById('customer_id').value = params.get('customer_id');
        });
    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('admin.layouts.plain', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\LENOVO\Downloads\vijay_jwellers\resources\views/payphi_checkout.blade.php ENDPATH**/ ?>