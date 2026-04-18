<?php $__env->startSection('title', 'Vendors — Admin'); ?>
<?php $__env->startSection('page-title', 'Vendors'); ?>
<?php $__env->startSection('content'); ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0 fw-bold">Vendor Applications</h4>
    <div class="d-flex gap-2">
        <span class="mini-stat-card">Pending: <strong class="text-warning"><?php echo e(\App\Models\Vendor::where('status','pending')->count()); ?></strong></span>
        <span class="mini-stat-card">Approved: <strong class="text-success"><?php echo e(\App\Models\Vendor::where('status','approved')->count()); ?></strong></span>
    </div>
</div>

<div class="filter-bar mb-4">
    <form action="<?php echo e(route('admin.vendors.index')); ?>" method="GET" class="row g-2 align-items-end">
        <div class="col-md-5">
            <input type="text" name="search" class="form-control custom-input" placeholder="Search by company or email..." value="<?php echo e(request('search')); ?>">
        </div>
        <div class="col-md-4">
            <select name="status" class="form-control custom-input">
                <option value="">All Statuses</option>
                <option value="pending" <?php echo e(request('status') === 'pending' ? 'selected' : ''); ?>>Pending</option>
                <option value="approved" <?php echo e(request('status') === 'approved' ? 'selected' : ''); ?>>Approved</option>
                <option value="rejected" <?php echo e(request('status') === 'rejected' ? 'selected' : ''); ?>>Rejected</option>
            </select>
        </div>
        <div class="col-md-3">
            <button type="submit" class="btn-admin-secondary w-100"><i class="fas fa-filter me-1"></i>Filter</button>
        </div>
    </form>
</div>

<div class="admin-table-card">
    <div class="table-responsive">
        <table class="table admin-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Company</th>
                    <th>Contact</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Applied</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $vendors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vendor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($vendor->id); ?></td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="table-avatar"><i class="fas fa-building"></i></div>
                            <div>
                                <div class="fw-semibold"><?php echo e($vendor->company_name); ?></div>
                                <?php if($vendor->address): ?><small class="text-muted"><?php echo e($vendor->address); ?></small><?php endif; ?>
                            </div>
                        </div>
                    </td>
                    <td><?php echo e($vendor->phone); ?></td>
                    <td><?php echo e($vendor->email); ?></td>
                    <td>
                        <span class="status-badge status-<?php echo e($vendor->status); ?>"><?php echo e(ucfirst($vendor->status)); ?></span>
                    </td>
                    <td><?php echo e($vendor->created_at->format('d M Y')); ?></td>
                    <td>
                        <div class="action-btns">
                            <a href="<?php echo e(route('admin.vendors.show', $vendor)); ?>" class="action-btn action-view" title="View Details">
                                <i class="fas fa-eye"></i>
                            </a>
                            <?php if($vendor->isPending()): ?>
                            <form method="POST" action="<?php echo e(route('admin.vendors.approve', $vendor)); ?>" class="d-inline">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="action-btn action-approve" title="Approve">
                                    <i class="fas fa-check"></i>
                                </button>
                            </form>
                            <form method="POST" action="<?php echo e(route('admin.vendors.reject', $vendor)); ?>" class="d-inline">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="action-btn action-delete" title="Reject" onclick="return confirm('Reject this vendor?')">
                                    <i class="fas fa-times"></i>
                                </button>
                            </form>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="7" class="text-center py-4 text-muted">No vendors found</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="p-3"><?php echo e($vendors->withQueryString()->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\muneeb ahmed\Desktop\Travel_Portal\resources\views/admin/vendors/index.blade.php ENDPATH**/ ?>