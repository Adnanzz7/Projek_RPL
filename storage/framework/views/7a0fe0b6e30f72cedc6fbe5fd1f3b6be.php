

<?php $__env->startSection('title', 'Profile'); ?>

<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="<?php echo e(asset('css/custom-style.css')); ?>" rel="stylesheet">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="py-12 min-h-screen">
    <div class="max-w-4xl mx-auto px-6 sm:px-8 lg:px-10 space-y-8">

        <div class="bg-white p-10 rounded-2xl shadow-lg border border-gray-200">
            <header class="text-center mb-10">
                <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight"><?php echo e(__('Profile Information')); ?></h2>
                <p class="mt-4 text-lg text-gray-600">
                    <?php echo e(__("Here is your profile information.")); ?>

                </p>
            </header>

            <?php if(session('success')): ?>
                <div class="mb-8 text-green-800 bg-green-100 border border-green-300 rounded-lg p-5 text-center font-semibold shadow-sm">
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-8 items-center">
                <div class="flex justify-center">
                    <img src="<?php echo e($user->foto ? Storage::url($user->foto) : 'https://static.vecteezy.com/system/resources/previews/005/129/844/non_2x/profile-user-icon-isolated-on-white-background-eps10-free-vector.jpg'); ?>" 
                        alt="User Photo" class="w-36 h-36 rounded-full object-cover shadow-xl border-4 border-indigo-500">
                </div>

                <div class="sm:col-span-2 space-y-6">
                    <div>
                        <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wide"><?php echo e(__('Role')); ?></h3>
                        <p class="mt-1 text-xl font-semibold text-gray-900"><?php echo e($user->role); ?></p>
                    </div>

                    <div>
                        <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wide"><?php echo e(__('Display Name')); ?></h3>
                        <p class="mt-1 text-xl font-semibold text-gray-900"><?php echo e($user->name); ?></p>
                    </div>

                    <div>
                        <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wide"><?php echo e(__('Username')); ?></h3>
                        <p class="mt-1 text-xl font-semibold text-gray-900"><?php echo e($user->username); ?></p>
                    </div>

                    <div>
                        <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wide"><?php echo e(__('Email')); ?></h3>
                        <p class="mt-1 text-xl font-semibold text-gray-900"><?php echo e($user->email); ?></p>
                    </div>

                    <div>
                        <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wide"><?php echo e(__('Birth Date')); ?></h3>
                        <p class="mt-1 text-xl font-semibold text-gray-900"><?php echo e($user->birth_date ? \Carbon\Carbon::parse($user->birth_date)->format('F j, Y') : '-'); ?></p>
                    </div>

                    <div>
                        <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wide"><?php echo e(__('About')); ?></h3>
                        <p class="mt-1 text-gray-700 whitespace-pre-line text-lg"><?php echo e($user->about ?? '-'); ?></p>
                    </div>
                </div>
            </div>

            <div class="mt-12 text-center">
                <a href="<?php echo e(route('profile.edit')); ?>" 
                   class="inline-block px-10 py-4 bg-indigo-600 text-white font-semibold rounded-full shadow-lg hover:bg-indigo-700 transition duration-300 ease-in-out">
                    <?php echo e(__('Edit Profile')); ?>

                </a>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\HP\laravel\Projek_RPL\resources\views/profile/index.blade.php ENDPATH**/ ?>