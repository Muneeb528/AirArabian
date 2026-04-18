<?php $__env->startSection('title', 'Dashboard — Admin'); ?>
<?php $__env->startSection('page-title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>

<!-- Stats Cards -->
<div class="row g-4 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="stat-card stat-card-blue">
            <div class="stat-card-icon"><i class="fas fa-ticket-alt"></i></div>
            <div class="stat-card-info">
                <div class="stat-card-number"><?php echo e($stats['total_tickets']); ?></div>
                <div class="stat-card-label">Total Tickets</div>
            </div>
            <div class="stat-card-sub">
                <span class="text-success"><?php echo e($stats['available_tickets']); ?> available</span>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card stat-card-gold">
            <div class="stat-card-icon"><i class="fas fa-users-cog"></i></div>
            <div class="stat-card-info">
                <div class="stat-card-number"><?php echo e($stats['total_vendors']); ?></div>
                <div class="stat-card-label">Total Vendors</div>
            </div>
            <div class="stat-card-sub">
                <?php if($stats['pending_vendors'] > 0): ?>
                    <span class="text-warning"><?php echo e($stats['pending_vendors']); ?> pending review</span>
                <?php else: ?>
                    <span class="text-success">All reviewed</span>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card stat-card-green">
            <div class="stat-card-icon"><i class="fas fa-book-open"></i></div>
            <div class="stat-card-info">
                <div class="stat-card-number"><?php echo e($stats['total_bookings']); ?></div>
                <div class="stat-card-label">Total Bookings</div>
            </div>
            <div class="stat-card-sub">
                <span class="text-warning"><?php echo e($stats['pending_bookings']); ?> pending</span>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card stat-card-purple">
            <div class="stat-card-icon"><i class="fas fa-money-bill-wave"></i></div>
            <div class="stat-card-info">
                <div class="stat-card-number">PKR <?php echo e(number_format($stats['total_revenue'])); ?></div>
                <div class="stat-card-label">Total Revenue</div>
            </div>
            <div class="stat-card-sub">
                <?php if($stats['pending_payments'] > 0): ?>
                    <span class="text-warning"><?php echo e($stats['pending_payments']); ?> payment(s) pending</span>
                <?php else: ?>
                    <span class="text-success">All payments verified</span>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Secondary Stats -->
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="mini-stat-card">
            <i class="fas fa-pause-circle text-warning me-2"></i>
            <span><?php echo e($stats['hold_tickets']); ?> tickets on hold</span>
        </div>
    </div>
    <div class="col-md-4">
        <div class="mini-stat-card">
            <i class="fas fa-check-circle text-success me-2"></i>
            <span><?php echo e($stats['approved_vendors']); ?> approved vendors</span>
        </div>
    </div>
    <div class="col-md-4">
        <div class="mini-stat-card">
            <i class="fas fa-ban text-danger me-2"></i>
            <span><?php echo e($stats['booked_tickets']); ?> tickets booked</span>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Recent Bookings -->
    <div class="col-lg-7">
        <div class="admin-table-card">
            <div class="admin-table-header">
                <h5 class="mb-0"><i class="fas fa-book-open me-2 gold-text"></i>Recent Bookings</h5>
                <a href="<?php echo e(route('admin.bookings.index')); ?>" class="btn-view-all">View All</a>
            </div>
            <div class="table-responsive">
                <table class="table admin-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Customer</th>
                            <th>Ticket</th>
                            <th>Vendor</th>
                            <th>Amount</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $recentBookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($booking->id); ?></td>
                            <td>
                                <div class="fw-semibold"><?php echo e($booking->customer_name); ?></div>
                                <small class="text-muted"><?php echo e($booking->customer_phone); ?></small>
                            </td>
                            <td class="text-truncate" style="max-width:150px"><?php echo e($booking->ticket->title ?? '—'); ?></td>
                            <td><?php echo e($booking->vendor->company_name ?? '—'); ?></td>
                            <td>PKR <?php echo e(number_format($booking->total_amount)); ?></td>
                            <td>
                                <span class="status-badge status-<?php echo e($booking->status); ?>">
                                    <?php echo e(ucfirst($booking->status)); ?>

                                </span>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr><td colspan="6" class="text-center text-muted py-3">No bookings yet</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pending Vendors & Payments -->
    <div class="col-lg-5">
        <!-- Pending Vendors -->
        <div class="admin-table-card mb-4">
            <div class="admin-table-header">
                <h5 class="mb-0"><i class="fas fa-user-clock me-2 gold-text"></i>Pending Vendors</h5>
                <a href="<?php echo e(route('admin.vendors.index')); ?>?status=pending" class="btn-view-all">View All</a>
            </div>
            <?php $__empty_1 = true; $__currentLoopData = $pendingVendors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vendor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="pending-item">
                <div class="pending-avatar"><i class="fas fa-building"></i></div>
                <div class="flex-grow-1 min-w-0">
                    <div class="fw-semibold text-truncate"><?php echo e($vendor->company_name); ?></div>
                    <small class="text-muted"><?php echo e($vendor->email); ?></small>
                </div>
                <a href="<?php echo e(route('admin.vendors.show', $vendor)); ?>" class="btn-mini-action">Review</a>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="text-center text-muted py-3 small">No pending vendors</div>
            <?php endif; ?>
        </div>

        <!-- Pending Payments -->
        <div class="admin-table-card">
            <div class="admin-table-header">
                <h5 class="mb-0"><i class="fas fa-clock me-2 gold-text"></i>Pending Payments</h5>
                <a href="<?php echo e(route('admin.payments.index')); ?>?status=pending" class="btn-view-all">View All</a>
            </div>
            <?php $__empty_1 = true; $__currentLoopData = $recentPayments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="pending-item">
                <div class="pending-avatar payment-avatar"><i class="fas fa-credit-card"></i></div>
                <div class="flex-grow-1 min-w-0">
                    <div class="fw-semibold">PKR <?php echo e(number_format($payment->amount)); ?></div>
                    <small class="text-muted"><?php echo e(ucfirst($payment->method)); ?> · <?php echo e($payment->created_at->diffForHumans()); ?></small>
                </div>
                <a href="<?php echo e(route('admin.payments.show', $payment)); ?>" class="btn-mini-action">Verify</a>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="text-center text-muted py-3 small">No pending payments</div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\muneeb ahmed\Desktop\Travel_Portal\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>