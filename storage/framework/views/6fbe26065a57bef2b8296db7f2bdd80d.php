<?php $__env->startSection('title', 'Admin Dashboard'); ?>
<?php $__env->startSection('content'); ?>
<div class="admin-page-head">
    <div><h1>Admin Dashboard</h1><p>Manage your HomeStay Finder platform from one place.</p></div>
    <div class="d-flex gap-2 flex-wrap">
        <a class="admin-btn admin-btn-light" href="<?php echo e(route('admin.users')); ?>"><i class="ti ti-users"></i> Users</a>
        <a class="admin-btn admin-btn-primary" href="<?php echo e(route('admin.reviews')); ?>"><i class="ti ti-star"></i> Reviews</a>
    </div>
</div>
<div class="row g-3 mb-4">
    <?php $__currentLoopData = [['users','Total Users','Registered accounts','ti-users'],['hosts','Hosts','Host accounts','ti-home'],['homestays','Homestays','Listed properties','ti-building'],['reviews','Reviews','Guest feedback','ti-star']]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="col-sm-6 col-xl-3"><div class="admin-card admin-stat h-100"><div class="admin-stat-icon"><i class="ti <?php echo e($stat[3]); ?>"></i></div><div class="admin-stat-label"><?php echo e($stat[1]); ?></div><div class="admin-stat-value"><?php echo e($stats[$stat[0]]); ?></div><div class="admin-stat-note"><?php echo e($stat[2]); ?></div></div></div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<div class="row g-3">
    <div class="col-xl-8">
        <div class="admin-card">
            <div class="admin-card-header"><h2>Recent Reviews</h2><a class="admin-btn admin-btn-light" href="<?php echo e(route('admin.reviews')); ?>">View all</a></div>
            <div class="table-responsive"><table class="admin-table"><thead><tr><th>Guest</th><th>Homestay</th><th>Rating</th><th>Comment</th></tr></thead><tbody>
            <?php $__empty_1 = true; $__currentLoopData = $recentReviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><tr><td><strong><?php echo e($review->user_name); ?></strong></td><td><?php echo e($review->hotel_name); ?></td><td><span class="admin-badge badge-yellow"><i class="ti ti-star-filled"></i><?php echo e($review->rating); ?>/5</span></td><td><?php echo e($review->comment ?: 'No comment'); ?></td></tr><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><tr><td colspan="4"><div class="admin-empty"><i class="ti ti-message-off"></i>No reviews yet.</div></td></tr><?php endif; ?>
            </tbody></table></div>
        </div>
    </div>
    <div class="col-xl-4">
        <div class="admin-card h-100"><div class="admin-card-header"><h2>Admin Tools</h2></div><div class="admin-card-body">
            <div class="d-grid gap-2">
                <a class="admin-btn admin-btn-light" href="<?php echo e(route('admin.homestays')); ?>"><i class="ti ti-building"></i> Manage Homestays</a>
                <a class="admin-btn admin-btn-light" href="<?php echo e(route('admin.reviews')); ?>"><i class="ti ti-star"></i> Manage Reviews</a>
                <a class="admin-btn admin-btn-light" href="<?php echo e(route('admin.users')); ?>"><i class="ti ti-users"></i> Manage Users</a>
                <a class="admin-btn admin-btn-light" href="<?php echo e(route('admin.hosts')); ?>"><i class="ti ti-home"></i> Manage Hosts</a>
            </div>
            <div class="mt-4 p-3 rounded" style="background:#f8fafc"><div class="admin-muted" style="font-size:12px">Average rating</div><strong style="font-size:24px"><?php echo e($averageRating ? number_format($averageRating, 1) : '0.0'); ?> / 5</strong></div>
        </div></div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\nana2\OneDrive\Documents\Vs Code\HomeStay_Finder_Role5_modified_source\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>