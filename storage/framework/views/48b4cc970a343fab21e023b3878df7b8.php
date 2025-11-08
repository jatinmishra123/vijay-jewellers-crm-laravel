<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Sr.n</th>
            <th>Customer Name</th>
            <th>Product Type</th>
            <th>Product Name</th>
            <th>Amount</th>
            <th>Sale Date</th>
            <th>Sale Type</th>
            <th>Created At</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $sales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $sale): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td><?php echo e($key + 1); ?></td>
                <td><?php echo e($sale->customer->name ?? 'No Scheme'); ?></td>

                <td><?php echo e($sale->product_type); ?></td>
                <td><?php echo e($sale->product_name); ?></td>
                <td><?php echo e(number_format($sale->amount, 2)); ?></td>
                <td><?php echo e(\Carbon\Carbon::parse($sale->sale_date)->format('M d, Y')); ?></td>
                <td><?php echo e(ucfirst($sale->sale_type)); ?></td>
                <td><?php echo e($sale->created_at->format('M d, Y H:i')); ?></td>
                <td>
                    <button class="btn btn-outline-danger btn-sm delete-sale" data-id="<?php echo e($sale->id); ?>">
                        <i class="ri-delete-bin-line"></i>
                    </button>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="8" class="text-center">No sales found.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<!-- Pagination -->
<?php if($sales->hasPages()): ?>
    <div class="d-flex justify-content-between align-items-center mt-3">
        <div class="text-muted">
            Showing <?php echo e($sales->firstItem()); ?> to <?php echo e($sales->lastItem()); ?> of <?php echo e($sales->total()); ?> entries
        </div>
        <div class="pagination-container">
            <?php echo e($sales->appends(request()->query())->links()); ?>

        </div>
    </div>
<?php endif; ?><?php /**PATH C:\Users\LENOVO\Downloads\vijay_jwellers\resources\views/admin/sales/partials/table.blade.php ENDPATH**/ ?>