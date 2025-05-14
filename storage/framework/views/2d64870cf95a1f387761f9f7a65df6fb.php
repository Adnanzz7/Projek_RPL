

<?php $__env->startSection('title', 'User Profile'); ?>

<?php $__env->startSection('content'); ?>
<div class="py-12 max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
    <section class="bg-white bg-opacity-80 p-6 rounded-xl shadow-md max-w-md mx-auto">
        <header class="mb-6 text-center">
            <h2 class="text-2xl font-semibold text-gray-800"><?php echo e(__('User Profile')); ?></h2>
        </header>

        <div class="text-center">
            <img src="<?php echo e($user->foto ? Storage::url($user->foto) : 'https://static.vecteezy.com/system/resources/previews/005/129/844/non_2x/profile-user-icon-isolated-on-white-background-eps10-free-vector.jpg'); ?>" alt="<?php echo e($user->name); ?>" class="w-32 h-32 rounded-full mx-auto mb-4 object-cover">
            <h3 class="text-xl font-semibold"><?php echo e($user->name); ?></h3>
            <p class="text-gray-600"><?php echo e($user->email); ?></p>
            <p class="mt-2 text-gray-700"><?php echo e($user->about); ?></p>
            <?php if($user->birth_date): ?>
                <p class="mt-2 text-gray-600"><?php echo e(__('Birth Date:')); ?> <?php echo e(\Carbon\Carbon::parse($user->birth_date)->format('d M Y')); ?></p>
            <?php endif; ?>
        </div>
    </section>

    <section class="bg-white bg-opacity-80 p-6 rounded-xl shadow-md max-w-4xl mx-auto">
        <header class="mb-6 text-center">
            <h2 class="text-2xl font-semibold text-gray-800"><?php echo e(__('Items for Sale')); ?></h2>
        </header>

        <?php if($user->barangs->isEmpty()): ?>
            <p class="text-center text-gray-600"><?php echo e(__('This user has no items for sale.')); ?></p>
        <?php else: ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                <?php $__currentLoopData = $user->barangs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $barang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="border rounded-lg p-4 shadow hover:shadow-lg transition-shadow">
                        <img src="<?php echo e($barang->foto_barang ? Storage::url($barang->foto_barang) : 'https://via.placeholder.com/150'); ?>" alt="<?php echo e($barang->nama_barang); ?>" class="w-full h-40 object-cover rounded-md mb-4">
                        <h3 class="text-lg font-semibold"><?php echo e($barang->nama_barang); ?></h3>
                        <p class="text-gray-600"><?php echo e(Str::limit($barang->deskripsi ?? '', 100)); ?></p>
                        <p class="mt-2 font-bold text-indigo-600">Rp <?php echo e(number_format($barang->harga_barang, 0, ',', '.')); ?></p>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>
    </section>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\HP\laravel\Projek_RPL\resources\views/profile/show.blade.php ENDPATH**/ ?>