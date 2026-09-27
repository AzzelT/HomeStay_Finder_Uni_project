<?php $__env->startSection('title', 'Manage Reviews'); ?>
<?php $__env->startSection('content'); ?>
<div class="admin-page-head"><div><h1>Manage Reviews</h1><p>Review and moderate guest feedback.</p></div><span class="admin-badge badge-blue"><?php echo e($reviews->total()); ?> total reviews</span></div>
<div class="admin-card">
    <div class="admin-card-header"><h2>All Reviews</h2></div>
    <div class="table-responsive"><table class="admin-table"><thead><tr><th>#</th><th>Guest</th><th>Homestay</th><th>Rating</th><th>Comment</th><th>Date</th><th class="text-end">Action</th></tr></thead><tbody>
    <?php $__empty_1 = true; $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><tr><td><?php echo e($review->id); ?></td><td><strong><?php echo e($review->user_name); ?></strong></td><td><?php echo e($review->hotel_name); ?></td><td><span class="admin-badge badge-yellow"><i class="ti ti-star-filled"></i><?php echo e($review->rating); ?>/5</span></td><td style="min-width:220px"><?php echo e($review->comment ?: 'No comment'); ?></td><td><?php echo e(\Carbon\Carbon::parse($review->created_at)->format('d M Y')); ?></td><td class="text-end"><form action="<?php echo e(route('admin.reviews.destroy',$review->id)); ?>" method="POST" onsubmit="return confirm('Delete this review?')"><?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?><button class="admin-btn admin-btn-danger" type="submit"><i class="ti ti-trash"></i> Delete</button></form></td></tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><tr><td colspan="7"><div class="admin-empty"><i class="ti ti-message-off"></i>No reviews found.</div></td></tr><?php endif; ?>
    </tbody></table></div>
    <?php if($reviews->hasPages()): ?><div class="admin-pagination"><?php echo e($reviews->links()); ?></div><?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\nana2\OneDrive\Documents\Vs Code\HomeStay_Finder_Role5_modified_source\resources\views/admin/reviews.blade.php ENDPATH**/ ?>