<?php $__env->startSection('title', 'Manage Tickets — Admin'); ?>
<?php $__env->startSection('page-title', 'Tickets'); ?>

<?php $__env->startSection('content'); ?>

<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
    <h4 class="mb-0 fw-bold">All Tickets</h4>
    <a href="<?php echo e(route('admin.tickets.create')); ?>" class="btn-admin-primary">
        <i class="fas fa-plus me-2"></i>Add New Ticket
    </a>
</div>

<!-- Filters -->
<div class="filter-bar mb-4">
    <form action="<?php echo e(route('admin.tickets.index')); ?>" method="GET" class="row g-2 align-items-end">
        <div class="col-md-4">
            <input type="text" name="search" class="form-control custom-input" placeholder="Search tickets..." value="<?php echo e(request('search')); ?>">
        </div>
        <div class="col-md-3">
            <select name="category" class="form-control custom-input">
                <option value="">All Categories</option>
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($cat); ?>" <?php echo e(request('category') === $cat ? 'selected' : ''); ?>><?php echo e($cat); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="col-md-3">
            <select name="status" class="form-control custom-input">
                <option value="">All Statuses</option>
                <option value="available" <?php echo e(request('status') === 'available' ? 'selected' : ''); ?>>Available</option>
                <option value="booked" <?php echo e(request('status') === 'booked' ? 'selected' : ''); ?>>Booked</option>
                <option value="hold" <?php echo e(request('status') === 'hold' ? 'selected' : ''); ?>>On Hold</option>
                <option value="cancelled" <?php echo e(request('status') === 'cancelled' ? 'selected' : ''); ?>>Cancelled</option>
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn-admin-secondary w-100"><i class="fas fa-filter me-1"></i>Filter</button>
        </div>
    </form>
</div>

<!-- Tickets Table -->
<div class="admin-table-card">
    <div class="table-responsive">
        <table class="table admin-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Ticket</th>
                    <th>Category</th>
                    <th>Route</th>
                    <th>Price</th>
                    <th>Seats</th>
                    <th>Departure</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $tickets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($ticket->id); ?></td>
                    <td>
                        <div class="fw-semibold"><?php echo e($ticket->title); ?></div>
                        <small class="text-muted"><?php echo e($ticket->airline); ?></small>
                    </td>
                    <td><span class="category-pill category-<?php echo e(strtolower($ticket->category)); ?>"><?php echo e($ticket->category); ?></span></td>
                    <td><?php echo e($ticket->origin); ?> → <?php echo e($ticket->destination); ?></td>
                    <td class="fw-semibold gold-text">PKR <?php echo e(number_format($ticket->price)); ?></td>
                    <td>
                        <span class="<?php echo e($ticket->seats_available > 0 ? 'text-success' : 'text-danger'); ?>">
                            <?php echo e($ticket->seats_available); ?>

                        </span>
                    </td>
                    <td><?php echo e($ticket->departure_date->format('d M Y')); ?></td>
                    <td>
                        <span class="status-badge status-<?php echo e($ticket->status); ?>"><?php echo e(ucfirst($ticket->status)); ?></span>
                    </td>
                    <td>
                        <div class="action-btns">
                            <a href="<?php echo e(route('admin.tickets.edit', $ticket)); ?>" class="action-btn action-edit" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form method="POST" action="<?php echo e(route('admin.tickets.toggle-status', $ticket)); ?>" class="d-inline">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="action-btn action-toggle" title="Toggle Status">
                                    <i class="fas fa-<?php echo e($ticket->status === 'available' ? 'ban' : 'check-circle'); ?>"></i>
                                </button>
                            </form>
                            <form method="POST" action="<?php echo e(route('admin.tickets.destroy', $ticket)); ?>"
                                  onsubmit="return confirm('Delete this ticket permanently?')" class="d-inline">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="action-btn action-delete" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="9" class="text-center py-4 text-muted">
                        <i class="fas fa-ticket-alt fa-2x mb-2 d-block"></i>No tickets found. <a href="<?php echo e(route('admin.tickets.create')); ?>">Add the first one</a>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="p-3"><?php echo e($tickets->withQueryString()->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\muneeb ahmed\Desktop\Travel_Portal\resources\views/admin/tickets/index.blade.php ENDPATH**/ ?>