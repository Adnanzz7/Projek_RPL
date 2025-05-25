<?php $__env->startSection('title', 'Profile'); ?>

<?php $__env->startSection('content'); ?>

<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>

<div class="py-12 max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-12">
    
    <section class="bg-white p-6 rounded-2xl shadow-md space-y-6 relative">
        <div class="flex flex-col lg:flex-row items-center gap-8">
            <!-- Foto Profil -->
            <div class="relative">
                <img src="<?php echo e($user->foto ? Storage::url($user->foto) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=random&size=128'); ?>"
                    alt="<?php echo e($user->name); ?>"
                    class="w-40 h-40 rounded-full object-cover ring-4 ring-indigo-500 shadow-md">
            </div>

            <!-- Informasi User -->
            <div class="flex-1 text-gray-800 w-full space-y-6 flex flex-col justify-between">
                <!-- Grid Informasi Detail -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-4 text-sm text-gray-700">
                    <div class="space-y-3">
                        <h2 class="text-4xl font-bold text-indigo-600"><?php echo e($user->name); ?></h2>
                        <div class="flex items-center text-sm text-gray-600 gap-2">
                            <i class="bi bi-person-circle text-indigo-500"></i>
                            <span><?php echo e('@' . $user->username); ?></span>
                        </div>
                        <div class="flex items-center text-sm text-gray-600 gap-2">
                            <i class="bi bi-envelope-fill text-indigo-500"></i>
                            <span><?php echo e($user->email); ?></span>
                        </div>
                        <div class="flex items-start gap-2">
                            <i class="bi bi-info-circle-fill text-indigo-500 mt-0.5"></i>
                            <span><?php echo e($user->about ?? '-'); ?></span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="bi bi-calendar-check text-indigo-500"></i>
                            <span>Bergabung sejak <?php echo e($user->created_at->translatedFormat('d F Y')); ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php if(Auth::id() === $user->id): ?>
            <a href="<?php echo e(route('profile.edit')); ?>"
                class="absolute right-6 bottom-6 inline-flex items-center gap-2 px-5 py-2 bg-indigo-600 text-white font-semibold rounded-full shadow hover:bg-indigo-700 transition">
                <i class="bi bi-pencil-square text-base"></i> Edit Profil
            </a>
        <?php endif; ?>
    </section>

    
    <section class="bg-white bg-opacity-90 p-8 rounded-2xl shadow">
        <header class="mb-6 text-center">
            <h2 class="text-2xl font-bold text-gray-800">Barang Dijual</h2>
        </header>

        <?php if($user->barangs->isEmpty()): ?>
            <p class="text-center text-gray-600">Belum ada barang yang dijual.</p>
        <?php else: ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php $__currentLoopData = $user->barangs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $barang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="bg-white border rounded-2xl shadow-md overflow-hidden hover:shadow-lg transition-all duration-300 flex flex-col">
                        <div class="relative">
                            <?php if($barang->foto_barang): ?>
                                <img src="<?php echo e(Storage::url($barang->foto_barang)); ?>" class="w-full h-48 object-cover" alt="<?php echo e($barang->nama_barang); ?>">
                            <?php else: ?>
                                <div class="w-full h-48 flex items-center justify-center bg-gray-200 text-gray-500 italic">Tidak ada gambar</div>
                            <?php endif; ?>
                            <span class="absolute top-2 left-2 text-xs font-medium px-3 py-1 rounded-full
                                <?php echo e($barang->jumlah_barang > 0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'); ?>">
                                <?php echo e($barang->jumlah_barang > 0 ? 'Tersedia' : 'Habis'); ?>

                            </span>
                        </div>

                        <div class="p-4 flex flex-col flex-1">
                            <h3 class="text-xl font-semibold text-gray-800 truncate"><?php echo e($barang->nama_barang ?? 'Produk tidak ditemukan'); ?></h3>
                            <p class="text-pink-600 font-semibold mt-1">Rp <?php echo e(number_format($barang->harga_barang ?? 0, 0, ',', '.')); ?></p>
                            <p class="text-sm text-gray-500 mt-1">Stok: <?php echo e($barang->jumlah_barang); ?></p>
                            <p class="text-sm text-gray-400">Pengirim: 
                                <a href="<?php echo e(route('profile.show', $barang->user->id)); ?>" class="hover:underline"><?php echo e($barang->user->name ?? '-'); ?></a>
                            </p>

                            <?php if(auth()->guard()->check()): ?>
                                <div class="mt-4 flex justify-between text-sm">
                                    <?php if(Auth::user()->role === 'admin' || Auth::id() === $barang->user_id): ?>
                                        <a href="<?php echo e(route('barangs.edit', $barang->id)); ?>" class="text-yellow-500 hover:text-yellow-600 transition-transform duration-300 relative hover:scale-105 cursor-pointer">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </a>
                                        <?php if(Auth::user()->role === 'admin'): ?>
                                        <a href="<?php echo e(route('barangs.show', $barang->id)); ?>" class="hover:text-[#138496] text-[#17a2b8] transition-transform duration-300 relative hover:scale-105 cursor-pointer">
                                            <i class="bi bi-info-circle"></i> Detail
                                        </a>
                                        <?php endif; ?>
                                        <form action="<?php echo e(route('barangs.destroy', $barang->id)); ?>" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')">
                                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="text-red-500 hover:text-red-600 transition-transform duration-300 relative hover:scale-105 cursor-pointer">
                                                <i class="bi bi-trash"></i> Hapus
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </div>

                                <?php if(Auth::user()->role === 'user'): ?>
                                    <div class="mt-4 flex justify-between items-center">
                                        
                                        <form action="<?php echo e(route('wishlist.toggle', $barang->id)); ?>" method="POST">
                                            <?php echo csrf_field(); ?>
                                            <?php
                                                $inWishlist = Auth::user()->wishlist->contains($barang->id);
                                            ?>
                                            <button type="submit" class="text-red-500 hover:scale-110 transition">
                                                <i class="<?php echo e($inWishlist ? 'bi bi-heart-fill' : 'bi bi-heart'); ?>"></i>
                                            </button>
                                        </form>

                                        
                                        <?php
                                            $now = \Carbon\Carbon::now('Asia/Jakarta');
                                            $open1 = \Carbon\Carbon::createFromTime(9, 30, 0, 'Asia/Jakarta');
                                            $close1 = \Carbon\Carbon::createFromTime(10, 0, 0, 'Asia/Jakarta');
                                            $open2 = \Carbon\Carbon::createFromTime(10, 30, 0, 'Asia/Jakarta');
                                            $close2 = \Carbon\Carbon::createFromTime(22, 0, 0, 'Asia/Jakarta');
                                            $isTimeAllowed = $now->between($open1, $close1) || $now->between($open2, $close2);
                                        ?>

                                        <?php if($isTimeAllowed): ?>
                                            <form action="<?php echo e(route('cart.add.form', $barang->id)); ?>" method="GET">
                                                <?php echo csrf_field(); ?>
                                                <input type="hidden" name="id" value="<?php echo e($barang->id); ?>">
                                                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-1 rounded-md font-medium">
                                                    <i class="bi bi-cart-plus"></i> Tambah
                                                </button>
                                            </form>
                                        <?php else: ?>
                                            <span class="text-red-500 text-xs font-semibold">Buka pukul 09:40-10:00 & 12:30-13:00</span>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>
    </section>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\HP\Laravel\Projek_RPL\resources\views/profile/show.blade.php ENDPATH**/ ?>