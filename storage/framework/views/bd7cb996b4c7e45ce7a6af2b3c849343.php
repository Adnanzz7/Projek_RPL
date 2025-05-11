<?php $__env->startSection('title', 'Profile'); ?>

<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="<?php echo e(asset('css/custom-style.css')); ?>" rel="stylesheet">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 sm:rounded-lg">
            <div>
                <?php echo $__env->make('profile.partials.update-profile-information-form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>
        </div>

        <div class="p-4 sm:p-8 sm:rounded-lg">
            <div>
                <?php echo $__env->make('profile.partials.update-password-form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>
        </div>

        <div class="p-4 sm:p-8 sm:rounded-lg">
            <div>
                <?php echo $__env->make('profile.partials.delete-user-form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>
        </div>
    </div>
</div>

<!-- Back to Home Button -->
<div class="text-center mt-1 mb-6">
    <a href="<?php echo e(route('barangs.index')); ?>" 
       class="inline-flex items-center px-8 py-3 text-white text-sm font-medium bg-blue-700 hover:bg-blue-800 rounded-full shadow-md hover:shadow-lg transition-transform transform hover:-translate-y-1">
        <i class="bi bi-house-door mr-2"></i> Back to Home
    </a>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\HP\laravel\Projek_RPL\resources\views/profile/edit.blade.php ENDPATH**/ ?>