<?php $__env->startSection('title', 'Wishlist Saya'); ?>

<?php $__env->startSection('content'); ?>
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>

<div class="py-12 max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-12"> 
    <?php if(session('success')): ?>
        <div class="bg-green-100 border border-green-300 text-green-800 px-6 py-4 rounded mb-8 max-w-3xl mx-auto">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <section class="bg-white bg-opacity-80 p-8 rounded-2xl shadow">
        <h2 class="text-4xl font-bold text-center text-black-700 mb-10">Wishlist Saya</h2>

        <div class="flex justify-end mb-6">
            <a href="<?php echo e(route('barangs.index')); ?>" class="w-10 h-10 rounded-full bg-blue-500 hover:bg-blue-600 text-white font-semibold text-sm flex justify-center items-center">
                <i class="fas fa-plus"></i>
            </a>
        </div>

        <?php if($wishlists->isEmpty()): ?>
            <p class="text-center text-gray-600">Wishlist Kosong.</p>
        <?php else: ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php $__currentLoopData = $wishlists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $wishlist): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="relative bg-white border rounded-2xl shadow-md overflow-hidden hover:shadow-lg transition-all duration-300 flex flex-col transform ease-in-out cursor-pointer">
                        
                        <div class="relative">
                            <?php if($wishlist->barang->foto_barang): ?>
                                <img src="<?php echo e(Storage::url($wishlist->barang->foto_barang)); ?>" class="w-full h-48 object-cover" alt="<?php echo e($wishlist->barang->nama_barang); ?>">
                            <?php else: ?>
                                <div class="w-full h-48 flex items-center justify-center bg-gray-200 text-gray-500 italic">Tidak ada gambar</div>
                            <?php endif; ?>
                            <div class="absolute top-2 left-2">
                                <span class="text-xs font-medium px-3 py-1 rounded-full 
                                    <?php echo e($wishlist->barang->jumlah_barang > 0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'); ?>">
                                    <?php echo e($wishlist->barang->jumlah_barang > 0 ? 'Tersedia' : 'Habis'); ?>

                                </span>
                            </div>
                        </div>

                        
                        <div class="p-4 flex flex-col justify-between flex-1">
                            <h3 class="text-2xl font-bold text-gray-900 mb-2 truncate" title="<?php echo e($wishlist->barang->nama_barang ?? 'Produk tidak ditemukan'); ?>">
                                <?php echo e($wishlist->barang->nama_barang ?? 'Produk tidak ditemukan'); ?>

                            </h3>
                            <p class="text-pink-600 font-semibold text-xl mb-1">Rp <?php echo e(number_format($wishlist->barang->harga_barang ?? 0, 0, ',', '.')); ?></p>
                            <p class="text-gray-600 text-sm mb-1">Stok: <?php echo e($wishlist->barang->jumlah_barang ?? 0); ?></p>
                            <p class="text-gray-500 text-sm mb-4">Pengirim: 
                                <a href="<?php echo e(route('profile.show', $wishlist->barang->user->id)); ?>" class="text-gray-500 hover:underline">
                                    <?php echo e($wishlist->barang->user->name ?? '-'); ?>

                                </a>
                            </p>
                            <div class="mt-auto flex space-x-4 items-center">
                                <?php if($wishlist->barang && $wishlist->barang->jumlah_barang > 0): ?>
                                    <form action="<?php echo e(route('wishlist.destroy', $wishlist->id)); ?>" class="mr-auto ml-0 flex justify-start" method="POST" onsubmit="return confirm('Yakin ingin menghapus item ini dari wishlist?')">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="text-red-500 hover:text-red-600 transition-transform duration-300 relative hover:scale-110">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>

                                    <?php
                                        $now = \Carbon\Carbon::now('Asia/Jakarta');
                                        $open1 = \Carbon\Carbon::createFromTime(9, 30, 0, 'Asia/Jakarta');
                                        $close1 = \Carbon\Carbon::createFromTime(10, 0, 0, 'Asia/Jakarta');
                                        $open2 = \Carbon\Carbon::createFromTime(11, 30, 0, 'Asia/Jakarta');
                                        $close2 = \Carbon\Carbon::createFromTime(22, 0, 0, 'Asia/Jakarta');
                                        $isTimeAllowed = $now->between($open1, $close1) || $now->between($open2, $close2);
                                    ?>

                                    <?php if($isTimeAllowed): ?>
                                        <form action="<?php echo e(route('cart.add.form', $wishlist->barang->id)); ?>" method="GET">
                                            <?php echo csrf_field(); ?>
                                            <input type="hidden" name="id" value="<?php echo e($wishlist->barang->id); ?>">
                                            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-1 rounded-md font-medium">
                                                <i class="bi bi-cart-plus"></i> Tambah
                                            </button>
                                        </form>
                                    <?php else: ?>
                                        <span class="text-red-500 text-xs font-semibold">Buka pukul 09:40-10:00 & 12:30-13:00</span>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <span class="text-red-600 text-sm font-semibold flex-grow flex items-center justify-center">Stok habis</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>
    </section>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\HP\Laravel\Projek_RPL\resources\views/barangs/wishlist.blade.php ENDPATH**/ ?>