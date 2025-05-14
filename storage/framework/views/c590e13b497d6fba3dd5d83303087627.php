<?php $__env->startSection('title', 'Pembayaran Berhasil'); ?>

<?php $__env->startSection('content'); ?>
<div class="flex justify-center items-center bg-cover bg-center">
    <div class="relative w-full h-full flex justify-center items-center">
        <div class="bg-white bg-opacity-80 p-8 rounded-lg shadow-lg max-w-md w-full text-center z-10">
            <h2 class="text-4xl text-green-600 font-semibold mb-4">Pembayaran Berhasil!</h2>
            <p class="text-xl text-gray-700 mb-6">Terima kasih telah berbelanja dengan kami. Pembayaran Anda telah diproses.</p>
            <div class="text-center">
                <a href="<?php echo e(route('barangs.index')); ?>" class="bg-green-500 text-white py-2 px-6 rounded-lg text-xl uppercase transition duration-300 ease-in-out transform hover:bg-green-600 hover:scale-105">
                    Lanjut Belanja
                </a>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\HP\laravel\Projek_RPL\resources\views/cart/finish.blade.php ENDPATH**/ ?>