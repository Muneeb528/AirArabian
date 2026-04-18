

<?php $__env->startSection('title', 'Bookings'); ?>

<?php $__env->startSection('content'); ?>
<div class="content-header">
    <h1>All Bookings</h1>
</div>

<div class="card">
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Customer</th>
                <th>Ticket</th>
                <th>Vendor</th>
                <th>Status</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td><?php echo e($booking->id); ?></td>
                <td><?php echo e($booking->customer_name); ?></td>
                <td><?php echo e($booking->ticket->title ?? 'N/A'); ?></td>
                <td><?php echo e($booking->vendor->user->name ?? 'N/A'); ?></td>
                <td><?php echo e($booking->status); ?></td>
                <td><?php echo e($booking->created_at->format('d M Y')); ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr><td colspan="6" class="text-center">No bookings found</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\muneeb ahmed\Desktop\Travel_Portal\resources\views/admin/bookings/index.blade.php ENDPATH**/ ?>