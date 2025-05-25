<section class="bg-white bg-opacity-90 p-8 rounded-2xl shadow">
    <div class="flex items-center justify-between">
        <h3 class="text-xl font-bold text-gray-800">Produk Saya</h3>
        <a href="<?php echo e(route('barangs.create')); ?>" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 no-underline">
            <i class="bi bi-plus-lg"></i> Tambah Produk
        </a>
    </div>

    <?php if($barangs->isEmpty()): ?>
        <p class="text-gray-500">Anda belum memiliki produk.</p>
    <?php else: ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            <?php $__currentLoopData = $barangs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $barang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="relative bg-white border rounded-2xl shadow-md overflow-hidden hover:shadow-lg transition-all duration-300 flex flex-col transform ease-in-out">
                    <div class="relative">
                        <?php if($barang->foto_barang): ?>
                            <img src="<?php echo e(Storage::url($barang->foto_barang)); ?>" class="w-full h-48 object-cover" alt="<?php echo e($barang->nama_barang); ?>">
                        <?php else: ?>
                            <div class="w-full h-48 flex items-center justify-center bg-gray-200 text-gray-500 italic">Tidak ada gambar</div>
                        <?php endif; ?>
                        <div class="absolute top-2 left-2">
                            <span class="text-xs font-medium px-3 py-1 rounded-full 
                                <?php echo e($barang->jumlah_barang > 0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'); ?>">
                                <?php echo e($barang->jumlah_barang > 0 ? 'Tersedia' : 'Habis'); ?>

                            </span>
                        </div>
                    </div>

                    <div class="p-4 flex flex-col flex-1">
                        <h3 class="text-xl font-semibold text-gray-800 truncate mb-0.5"><?php echo e($barang->nama_barang ?? 'Produk tidak ditemukan'); ?></h3>
                        <p class="text-pink-600 font-semibold mt-1 mb-0.5">Rp <?php echo e(number_format($barang->harga_barang ?? 0, 0, ',', '.')); ?></p>
                        <p class="text-sm text-gray-500 mt-1 mb-0.5">Stok: <?php echo e($barang->jumlah_barang); ?></p>

                        <?php if(auth()->guard()->check()): ?>
                            <div class="mt-4 flex justify-between text-sm">
                                <?php if(Auth::id() === $barang->user_id): ?>
                                    <a href="<?php echo e(route('barangs.edit', $barang->id)); ?>" class="text-yellow-500 hover:text-yellow-600 no-underline transition-transform duration-300 relative hover:scale-105 cursor-pointer">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </a>
                                    <form action="<?php echo e(route('barangs.destroy', $barang->id)); ?>" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')">
                                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="text-red-500 hover:text-red-600 transition-transform duration-300 relative hover:scale-105 cursor-pointer">
                                            <i class="bi bi-trash"></i> Hapus
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php endif; ?>
</section><?php /**PATH C:\Users\HP\Laravel\Projek_RPL\resources\views/profile/partials/supplier-dashboard.blade.php ENDPATH**/ ?>