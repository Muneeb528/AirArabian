<?php $__env->startSection('title', 'Payments — Admin'); ?>
<?php $__env->startSection('page-title', 'Payments'); ?>
<?php $__env->startSection('content'); ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0 fw-bold">Payment Verifications</h4>
</div>

<div class="filter-bar mb-4">
    <form action="<?php echo e(route('admin.payments.index')); ?>" method="GET" class="row g-2 align-items-end">
        <div class="col-md-4">
            <select name="status" class="form-control custom-input">
                <option value="">All Statuses</option>
                <option value="pending" <?php echo e(request('status')==='pending'?'selected':''); ?>>Pending</option>
                <option value="approved" <?php echo e(request('status')==='approved'?'selected':''); ?>>Approved</option>
                <option value="rejected" <?php echo e(request('status')==='rejected'?'selected':''); ?>>Rejected</option>
            </select>
        </div>
        <div class="col-md-4">
            <select name="method" class="form-control custom-input">
                <option value="">All Methods</option>
                <option value="jazzcash" <?php echo e(request('method')==='jazzcash'?'selected':''); ?>>JazzCash</option>
                <option value="easypaisa" <?php echo e(request('method')==='easypaisa'?'selected':''); ?>>EasyPaisa</option>
            </select>
        </div>
        <div class="col-md-4">
            <button type="submit" class="btn-admin-secondary w-100"><i class="fas fa-filter me-1"></i>Filter</button>
        </div>
    </form>
</div>

<div class="admin-table-card">
    <div class="table-responsive">
        <table class="table admin-table">
            <thead>
                <tr><th>#</th><th>Vendor</th><th>Booking #</th><th>Method</th><th>Amount</th><th>Proof</th><th>Submitted</th><th>Status</th><th>Actions</th></tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($payment->id); ?></td>
                    <td><?php echo e($payment->booking->vendor->company_name ?? '—'); ?></td>
                    <td>#<?php echo e($payment->booking_id); ?></td>
                    <td>
                        <span class="method-badge method-<?php echo e($payment->method); ?>">
                            <i class="fas fa-mobile-alt me-1"></i><?php echo e(ucfirst($payment->method)); ?>

                        </span>
                    </td>
                    <td class="fw-semibold gold-text">PKR <?php echo e(number_format($payment->amount)); ?></td>
                    <td>
                        <?php if($payment->proof_image): ?>
                            <a href="<?php echo e(Storage::url($payment->proof_image)); ?>" target="_blank" class="proof-thumb">
                                <img src="<?php echo e(Storage::url($payment->proof_image)); ?>" alt="Proof">
                                <span>View</span>
                            </a>
                        <?php else: ?>
                            <span class="text-muted small">No proof</span>
                        <?php endif; ?>
                    </td>
                    <td><?php echo e($payment->created_at->format('d M Y')); ?><br><small class="text-muted"><?php echo e($payment->created_at->diffForHumans()); ?></small></td>
                    <td><span class="status-badge status-<?php echo e($payment->status); ?>"><?php echo e(ucfirst($payment->status)); ?></span></td>
                    <td>
                        <div class="action-btns">
                            <a href="<?php echo e(route('admin.payments.show', $payment)); ?>" class="action-btn action-view"><i class="fas fa-eye"></i></a>
                            <?php if($payment->isPending()): ?>
                            <form method="POST" action="<?php echo e(route('admin.payments.approve', $payment)); ?>" class="d-inline">
                                <?php echo csrf_field(); ?>
                                <button class="action-btn action-approve" title="Approve" onclick="return confirm('Approve this payment?')"><i class="fas fa-check"></i></button>
                            </form>
                            <form method="POST" action="<?php echo e(route('admin.payments.reject', $payment)); ?>" class="d-inline">
                                <?php echo csrf_field(); ?>
                                <button class="action-btn action-delete" title="Reject" onclick="return confirm('Reject this payment?')"><i class="fas fa-times"></i></button>
                            </form>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="9" class="text-center py-4 text-muted">No payments found</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="p-3"><?php echo e($payments->withQueryString()->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\muneeb ahmed\Desktop\Travel_Portal\resources\views/admin/payments/index.blade.php ENDPATH**/ ?>