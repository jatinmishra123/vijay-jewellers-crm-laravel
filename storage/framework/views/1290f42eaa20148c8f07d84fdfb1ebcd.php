<?php if($customers->hasPages()): ?>
    <div class="pagination-container">
        <?php echo e($customers->withQueryString()->links('pagination::bootstrap-5')); ?>

    </div>
<?php endif; ?><?php /**PATH C:\Users\LENOVO\Downloads\vijay_jwellers\resources\views/admin/customers/partials/pagination.blade.php ENDPATH**/ ?>