

<?php $__env->startSection('title', 'Keranjang'); ?>

<?php $__env->startSection('content'); ?>

<div class="container mx-auto mt-12 max-w-7xl">
    <div class="bg-white bg-opacity-90 rounded-lg shadow-lg p-8">
        <h2 class="text-center text-gray-800 font-bold text-2xl mb-8">Keranjang Belanja</h2>
        
        <?php if(count($cartItems) > 0): ?>
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gradient-to-r from-blue-500 to-blue-400 text-white text-center">
                        <th class="px-4 py-3">Nama Barang</th>
                        <th class="px-4 py-3">Harga</th>
                        <th class="px-4 py-3">Jumlah</th>
                        <th class="px-4 py-3">Deskripsi</th>
                        <th class="px-4 py-3">Total</th>
                        <th class="px-4 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $cartItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="hover:bg-gray-100 text-center">
                        <td class="border px-4 py-3"><?php echo e($item['name'] ?? 'Nama Tidak Tersedia'); ?></td>
                        <td class="border px-4 py-3">Rp. <?php echo e(number_format($item['price'] ?? 0, 2, ',', '.')); ?></td>
                        
                        <!-- Kolom Jumlah (Tidak dapat diedit) -->
                        <td class="border px-4 py-3">
                            <?php echo e($item['quantity']); ?>

                        </td>
                        
                        <!-- Kolom Keterangan Barang -->
                        <td class="border px-4 py-3">
                            <?php echo e($item['description'] ?? 'Tidak ada deskripsi'); ?>

                        </td>
                        
                        <td class="border px-4 py-3">Rp. <?php echo e(number_format($item['price'] * $item['quantity'], 2, ',', '.')); ?></td>
                        
                        <td class="border px-4 py-3">
                            <!-- Tombol Aksi: Ubah Barang (Arahkan ke add.form) -->
                            <a href="<?php echo e(route('cart.edit', $id)); ?>" 
                                class="px-4 py-2 text-white bg-blue-500 rounded-md hover:bg-blue-600">
                                Ubah
                            </a>
                            
                            <!-- Tombol Hapus -->
                            <form action="<?php echo e(route('cart.remove')); ?>" method="POST" class="inline">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <input type="hidden" name="id" value="<?php echo e($id); ?>">
                                <button type="submit" 
                                    class="ml-2 px-4 py-2 text-white bg-red-500 rounded-md hover:bg-red-600">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>

            <div class="flex justify-between items-center mt-8">
                <span class="text-xl font-bold text-gray-800">Total Harga: Rp. <?php echo e(number_format($total, 2, ',', '.')); ?></span>
                <a href="<?php echo e(route('cart.checkout')); ?>" 
                    class="px-6 py-3 text-white bg-green-500 rounded-md font-bold text-lg hover:bg-green-600">Checkout</a>
            </div>
        <?php else: ?>
            <p class="text-center text-gray-500 font-semibold py-6">Keranjang Anda kosong. Silakan tambahkan barang.</p>
        <?php endif; ?>

        <div class="flex justify-between items-center mt-8">
            <a href="<?php echo e(route('barangs.index')); ?>" 
                class="px-6 py-3 text-white bg-blue-500 rounded-md hover:bg-blue-600">Lanjut Belanja</a>
            <a href="<?php echo e(route('cart.clear')); ?>" 
                class="px-6 py-3 text-white bg-red-500 rounded-md hover:bg-red-600">Bersihkan Keranjang</a>
        </div>
    </div>
</div>

<?php if(session('warning')): ?>
<div class="mt-8 p-4 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700" role="alert">
    <p><?php echo e(session('warning')); ?></p>
</div>
<?php endif; ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\HP\laravel\Projek_RPL\resources\views/cart/index.blade.php ENDPATH**/ ?>