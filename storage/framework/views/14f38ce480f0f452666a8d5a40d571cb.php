<?php $__env->startSection('title', 'Pembayaran Berhasil'); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-cover bg-center bg-no-repeat">
    <div class="container mx-auto py-12 px-6">
        <div class="max-w-5xl mx-auto bg-white bg-opacity-80 shadow-lg rounded-lg p-8 relative">

            <!-- Header -->
            <h5 class="text-center text-2xl font-semibold mb-6"><strong>Detail Pembayaran</strong></h5>
            
            <!-- Detail Pembayaran -->
            <div class="text-lg text-gray-700 mb-4">
                <p>Atas Nama: <strong><?php echo e(Auth::user()->name); ?></strong></p>
                <p>ID Pelanggan: <strong><?php echo e(Auth::user()->id); ?></strong></p>
                <p>ID Pesanan: <strong><?php echo e($order->id ?? 'N/A'); ?></strong></p>
            </div>

            <!-- Detail Pesanan -->
            <div class="mb-6">
                <p class="font-semibold text-lg">Detail Pesanan:</p>
                <table class="min-w-full table-auto border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-gray-700">
                            <th class="px-4 py-2 mt-1">Nama Barang</th>
                            <th class="px-4 py-2 mt-1">Harga</th>
                            <th class="px-4 py-2 mt-1">Jumlah</th>
                            <th class="px-4 py-2 mt-1">Deskripsi</th> <!-- Menambahkan Kolom Deskripsi -->
                            <th class="px-4 py-2 mt-1">Total Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if(empty($cartItems)): ?>
                        <tr>
                            <td colspan="5" class="text-center text-red-500 mt-4 mb-4">Item pesanan tidak ditemukan.</td>
                        </tr>
                    <?php else: ?>
                        <?php $__currentLoopData = $cartItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="border-b">
                                <td class="px-4 py-2"><?php echo e($item['name']); ?></td>
                                <td class="px-4 py-2">Rp. <?php echo e(number_format($item['price'], 2, ',', '.')); ?></td>
                                <td class="px-4 py-2"><?php echo e($item['quantity']); ?></td>
                                <td class="px-4 py-2"><?php echo e($item['description'] ?? 'Tidak ada deskripsi'); ?></td> <!-- Menampilkan Deskripsi -->
                                <td class="px-4 py-2">Rp. <?php echo e(number_format($item['price'] * $item['quantity'], 2, ',', '.')); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                    </tbody>
                </table>
                
                <h6 class="text-right text-xl font-bold text-green-600 mt-6">Total Semua: <span class="font-bold">Rp. <?php echo e(number_format($totalHarga, 2, ',', '.')); ?></span></h6><br>
            </div>
            
            <!-- Tombol di bagian kanan bawah dengan margin tambahan -->
            <div class="absolute bottom-5 right-5 flex gap-4 mt-8"> <!-- Menambahkan margin top (mt-8) -->
                <!-- Tombol Download PDF -->
                <a href="<?php echo e(route('cart.downloadPdf', ['id' => $order->id ?? 0])); ?>" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg shadow-lg transform transition-all duration-300 ease-in-out hover:translate-y-1">
                    Download PDF
                </a>
                
                <!-- Tombol Selesai -->
                <a href="<?php echo e(route('cart.finish')); ?>" class="bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded-lg shadow-lg transform transition-all duration-300 ease-in-out hover:translate-y-1">
                    Selesai
                </a>
            </div>            

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\HP\laravel\Projek_RPL\resources\views/cart/success.blade.php ENDPATH**/ ?>