<?php $__env->startSection('title', 'Daftar Saran dan Kritik'); ?>

<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-3xl mx-auto px-6 py-10">
    <h2 class="text-3xl font-bold text-gray-800 mb-8 text-center">
        <i class="bi bi-chat-dots text-indigo-600"></i> Saran & Kritik
    </h2>

    <?php if($suggestions->isEmpty()): ?>
        <div class="text-center text-gray-600">Belum ada saran atau kritik yang masuk.</div>
    <?php endif; ?>

    <div class="space-y-6">
        <?php $__currentLoopData = $suggestions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $suggestion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="flex items-start space-x-4 bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
                <div class="flex-shrink-0">
                    <img src="https://ui-avatars.com/api/?name=<?php echo e(urlencode($suggestion->nama)); ?>&background=4f46e5&color=fff" alt="<?php echo e($suggestion->nama); ?>" class="w-12 h-12 rounded-full">
                </div>
                <div class="flex-1">
                    <div class="flex justify-between items-center mb-1">
                        <h4 class="font-semibold text-gray-800"><?php echo e($suggestion->nama); ?></h4>
                        <span class="text-sm text-gray-500"><?php echo e($suggestion->created_at->format('d M Y')); ?></span>
                    </div>
                    <p class="text-gray-700"><?php echo e($suggestion->pesan); ?></p>
                    <p class="text-sm text-gray-400 mt-1"><?php echo e($suggestion->email); ?></p>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <div class="mt-8">
        <?php echo e($suggestions->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\HP\laravel\Projek_RPL\resources\views/suggestion-list.blade.php ENDPATH**/ ?>