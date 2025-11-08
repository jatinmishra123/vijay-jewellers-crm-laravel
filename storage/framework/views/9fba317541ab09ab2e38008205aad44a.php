

<?php $__env->startSection('title', 'Customer Contacts'); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">Customer Contacts</h4>
                </div>

                <div class="card-body">
                    <form method="GET" class="mb-3">
                        <div class="input-group w-50">
                            <input type="text" name="search" class="form-control" placeholder="Search name or mobile..."
                                value="<?php echo e(request('search')); ?>">
                            <button class="btn btn-primary" type="submit">Search</button>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-bordered align-middle">
                            <thead>
                                <tr class="text-center">
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th>Contact</th>
                                    <th>Conversation</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td class="text-center"><?php echo e($customers->firstItem() + $i); ?></td>
                                        <td><?php echo e($customer->name); ?></td>
                                        <td><?php echo e($customer->email); ?></td>
                                        <td><?php echo e($customer->mobile); ?></td>
                                        <td class="text-center">
                                            <a href="tel:<?php echo e($customer->mobile); ?>" class="btn btn-sm btn-outline-success"
                                                title="Call"><i class="bi bi-telephone-fill"></i></a>
                                            <a href="https://wa.me/<?php echo e(preg_replace('/[^0-9]/', '', $customer->mobile)); ?>"
                                                target="_blank" class="btn btn-sm btn-outline-success" title="WhatsApp"><i
                                                    class="bi bi-whatsapp"></i></a>
                                        </td>
                                        <td>
                                            <!-- Conversation Button to trigger modal -->
                                            <button type="button" class="btn btn-sm btn-outline-info" data-bs-toggle="modal"
                                                data-bs-target="#convModal<?php echo e($customer->id); ?>">
                                                <i class="bi bi-chat-dots"></i> Conversation
                                            </button>

                                            <!-- Modal -->
                                            <div class="modal fade" id="convModal<?php echo e($customer->id); ?>" tabindex="-1"
                                                aria-labelledby="convModalLabel<?php echo e($customer->id); ?>" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="convModalLabel<?php echo e($customer->id); ?>">
                                                                Conversation — <?php echo e($customer->name); ?></h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>

                                                        <div class="modal-body">
                                                            <!-- flash message -->
                                                            <?php if(session('success')): ?>
                                                                <div class="alert alert-success"><?php echo e(session('success')); ?></div>
                                                            <?php endif; ?>

                                                            <!-- History -->
                                                            <h6>History</h6>
                                                            <div class="border rounded p-2 mb-3"
                                                                style="max-height:300px; overflow-y:auto;">
                                                                <?php if($customer->conversations && $customer->conversations->count()): ?>
                                                                    <?php $__currentLoopData = $customer->conversations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $conv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <div class="mb-2">
                                                                            <small
                                                                                class="text-muted"><?php echo e($conv->created_at->format('d M Y, h:i A')); ?></small>
                                                                            <div class="mt-1"><?php echo e($conv->message); ?></div>

                                                                            <!-- optional delete single conversation -->
                                                                            <form method="POST"
                                                                                action="<?php echo e(route('admin.contacts.deleteConversation', $conv->id)); ?>"
                                                                                onsubmit="return confirm('Delete this message?')"
                                                                                class="d-inline-block mt-1">
                                                                                <?php echo csrf_field(); ?>
                                                                                <?php echo method_field('DELETE'); ?>
                                                                                <button
                                                                                    class="btn btn-sm btn-outline-danger">Delete</button>
                                                                            </form>
                                                                        </div>
                                                                        <hr class="my-2">
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                <?php else: ?>
                                                                    <p class="text-muted mb-0">No conversations yet.</p>
                                                                <?php endif; ?>
                                                            </div>

                                                            <!-- Add new message -->
                                                            <form method="POST"
                                                                action="<?php echo e(route('admin.contacts.saveConversation', $customer->id)); ?>">
                                                                <?php echo csrf_field(); ?>
                                                                <?php echo method_field('PUT'); ?>
                                                                <div class="input-group">
                                                                    <input type="text" name="message" class="form-control"
                                                                        placeholder="Enter conversation details..." required>
                                                                    <button class="btn btn-primary" type="submit"><i
                                                                            class="bi bi-send-fill"></i> Save</button>
                                                                </div>
                                                            </form>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end modal -->
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">No customers found.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        <?php echo e($customers->withQueryString()->links()); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ✅ Bootstrap Icons CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\LENOVO\Downloads\vijay_jwellers\resources\views/admin/contacts/index.blade.php ENDPATH**/ ?>