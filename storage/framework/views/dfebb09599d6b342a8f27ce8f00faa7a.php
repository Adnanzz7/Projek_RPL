<?php $__env->startSection('title', 'Tambah Barang di Keranjang'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-6 py-12 flex justify-center items-center min-h-screen">
    <div class="bg-white p-10 rounded-xl shadow-lg w-full max-w-2xl space-y-8">
        <h2 class="text-4xl font-bold text-center text-gray-800">Tambah Barang ke Keranjang</h2>

        <form action="<?php echo e(route('cart.addFromForm')); ?>" method="POST" class="space-y-8" id="addToCartForm">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="id" value="<?php echo e($barang->id); ?>">

            <!-- Foto Barang -->
            <div class="flex justify-center">
                <img src="<?php echo e(asset('storage/' . $barang->foto_barang)); ?>" alt="<?php echo e($barang->nama_barang); ?>" 
                     class="w-48 h-48 object-cover rounded-lg shadow-md border-2 border-gray-200">
            </div>

            <!-- Detail Barang -->
            <div class="space-y-2 text-center">
                <h3 class="text-2xl font-bold text-gray-800"><?php echo e($barang->nama_barang); ?></h3>
                <p class="text-gray-600">Pengirim: <span class="font-medium"><?php echo e($barang->user->name ?? 'Tidak Diketahui'); ?></span></p>
                <p class="text-gray-600">Stok Tersedia: <span class="font-medium"><?php echo e($barang->jumlah_barang); ?></span></p>
                <p class="text-2xl font-bold text-blue-600">Rp <?php echo e(number_format($barang->harga_barang, 2, ',', '.')); ?></p>
            </div>

            <!-- Keterangan Barang -->
            <div class="bg-gray-100 p-6 rounded-md shadow-sm">
                <h4 class="text-lg font-semibold text-gray-700">Keterangan Barang</h4>
                <p class="text-gray-600 mt-2"><?php echo e($barang->keterangan_barang ?? 'Tidak ada keterangan'); ?></p>
            </div>

            <!-- Jumlah Barang -->
            <div class="text-center">
                <label for="quantity" class="block text-lg font-semibold text-gray-800 mb-2">Jumlah</label>
                <div class="flex items-center justify-center space-x-4 mt-2">
                    <button type="button" id="decreaseQty" 
                            class="w-12 h-12 bg-gray-500 text-white rounded-full flex justify-center items-center text-2xl font-bold hover:bg-gray-600 transition">
                        <i class="fas fa-minus"></i>
                    </button>

                    <input type="number" name="quantity" id="quantity" 
                        class="w-24 text-center p-3 text-lg font-semibold border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                        value="1" min="1" max="<?php echo e($barang->jumlah_barang); ?>" readonly>

                    <button type="button" id="increaseQty" 
                            class="w-12 h-12 bg-gray-500 text-white rounded-full flex justify-center items-center text-2xl font-bold hover:bg-gray-600 transition">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            </div>

            <!-- Deskripsi Tambahan -->
            <div>
                <label for="description" class="block text-lg font-medium text-gray-800">Deskripsi Tambahan</label>
                <textarea name="description" id="description" rows="3" 
                          class="w-full mt-2 p-4 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none" 
                          placeholder="Contoh: Warna merah, ukuran XL, bahan katun, dll."></textarea>
            </div>

            <!-- Tombol Tambahkan -->
            <button type="submit" class="w-full py-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-md transition text-lg">
                Tambahkan ke Keranjang
            </button>
        </form>

        <!-- Tombol Kembali -->
        <div class="text-center mt-6">
            <a href="<?php echo e(route('barangs.index')); ?>" class="text-blue-600 hover:text-blue-800 font-medium text-lg">
                Kembali ke Daftar Barang
            </a>
        </div>
    </div>
</div>

<!-- Script untuk Tombol -->
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const qtyInput = document.getElementById("quantity");
        const decreaseBtn = document.getElementById("decreaseQty");
        const increaseBtn = document.getElementById("increaseQty");
        const maxQty = parseInt(qtyInput.getAttribute("max"));

        decreaseBtn.addEventListener("click", () => {
            let currentValue = parseInt(qtyInput.value);
            if (currentValue > 1) {
                qtyInput.value = currentValue - 1;
            }
        });

        increaseBtn.addEventListener("click", () => {
            let currentValue = parseInt(qtyInput.value);
            if (currentValue < maxQty) {
                qtyInput.value = currentValue + 1;
            }
        });
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\HP\Laravel\Projek_RPL\resources\views/cart/add.blade.php ENDPATH**/ ?>