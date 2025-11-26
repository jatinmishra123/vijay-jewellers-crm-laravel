<div class="card shadow-sm mt-4">
    <div class="card-header bg-light fw-bold">Existing Schemes</div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-sm table-fixed mb-0 align-middle">
                <thead class="bg-white">
                    <tr>
                        <th>Sr.N</th>
                        <th>Scheme Name</th>
                        <th>Scheme Plan</th>
                        <th>User Group</th>
                        <th>EMI Amt</th>
                        <th>No. Users</th>
                        <th>No. EMI</th>
                        <th>Bonus</th>
                        <th>Start Token</th>
                        <th>End Token</th>
                      <th>Start Date</th>

                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $settings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($settings->firstItem() + $i); ?></td>
<td><?php echo e($s->scheme->name ?? '—'); ?></td>
                            <td><?php echo e($s->scheme_plan); ?></td>
                            <td><?php echo e($s->user_group); ?></td>
                            <td><?php echo e($s->emi_amt); ?></td>
                            <td><?php echo e($s->no_of_users); ?></td>
                            <td><?php echo e($s->no_of_emi); ?></td>
                            <td><?php echo e($s->bonus_amount); ?></td>
                            <td><?php echo e($s->start_token_no); ?></td>
                            <td><?php echo e($s->end_token_no); ?></td>
                           
<td><?php echo e($s->created_at); ?></td>
                           <td class="text-center">

    <div class="d-flex justify-content-center align-items-center gap-2">

        <!-- Edit -->
        <a href="<?php echo e(route('admin.manage.settings.edit', $s->id)); ?>"
           class="btn btn-sm btn-warning"
           title="Edit">
            <i class="bi bi-pencil-square"></i>
        </a>





        <!-- Delete -->
        <form action="<?php echo e(route('admin.manage.settings.destroy', $s->id)); ?>"
              method="POST"
              class="d-inline delete-form">
            <?php echo csrf_field(); ?>
            <?php echo method_field('DELETE'); ?>

            <button type="button"
                    class="btn btn-sm btn-danger delete-btn"
                    title="Delete">
                <i class="bi bi-trash"></i>
            </button>
        </form>

    </div>

</td>

                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="11" class="text-center p-3 text-muted">
                                No scheme settings found.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        
        <div class="p-2">
            <?php echo e($settings->links()); ?>

        </div>
    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            let form = this.closest('form');

            Swal.fire({
                title: 'Delete this scheme?',
                text: 'This action cannot be undone.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete',
                cancelButtonText: 'Cancel'
            }).then(res => {
                if (res.isConfirmed) form.submit();
            });
        });
    });
});
</script>
<?php /**PATH C:\Users\LENOVO\Downloads\vijay_jwellers\resources\views/admin/manage/settings_list.blade.php ENDPATH**/ ?>