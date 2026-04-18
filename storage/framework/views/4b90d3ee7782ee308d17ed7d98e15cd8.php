

<?php $__env->startSection('title', 'Add New Ticket'); ?>
<?php $__env->startSection('page-title', 'Add New Ticket'); ?>

<?php $__env->startSection('content'); ?>
<div class="card" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08); border-radius: 14px; padding: 30px;">
    <form method="POST" action="<?php echo e(route('admin.tickets.store')); ?>">
        <?php echo csrf_field(); ?>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label style="color: #c9a84c;">Title</label>
                <input type="text" name="title" class="form-control" placeholder="Karachi → Dubai" required>
            </div>
            <div class="col-md-6 mb-3">
                <label style="color: #c9a84c;">Category</label>
                <select name="category" class="form-control" required>
                    <option value="UAE">UAE</option>
                    <option value="KSA">KSA</option>
                    <option value="Umrah">Umrah</option>
                    <option value="Tour">Tour</option>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label style="color: #c9a84c;">Price (PKR)</label>
                <input type="number" name="price" class="form-control" placeholder="28000" required>
            </div>
            <div class="col-md-6 mb-3">
                <label style="color: #c9a84c;">Available Seats</label>
                <input type="number" name="seats" class="form-control" placeholder="10" required>
            </div>
            <div class="col-md-6 mb-3">
                <label style="color: #c9a84c;">Departure Date</label>
                <input type="date" name="departure_date" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label style="color: #c9a84c;">Status</label>
                <select name="status" class="form-control" required>
                    <option value="available">Available</option>
                    <option value="booked">Booked</option>
                    <option value="hold">Hold</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>
            <div class="col-md-12 mb-3">
                <label style="color: #c9a84c;">Description</label>
                <textarea name="description" class="form-control" rows="3" placeholder="Ticket details..."></textarea>
            </div>
        </div>
        <button type="submit" class="btn" style="background: #c9a84c; color: #000; font-weight: 600; padding: 10px 30px;">
            <i class="fas fa-save me-2"></i>Save Ticket
        </button>
        <a href="<?php echo e(route('admin.tickets.index')); ?>" class="btn btn-secondary ms-2">Cancel</a>
    </form>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\muneeb ahmed\Desktop\Travel_Portal\resources\views/admin/tickets/create.blade.php ENDPATH**/ ?>