<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'PKK Market'); ?></title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/ts/app.ts', 'resources/css/app.css']); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="/src/styles.css" rel="stylesheet">
    <link rel="public/favicon.ico" href="<?php echo e(asset('favicon.ico')); ?>" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body class="flex flex-col min-h-screen bg-cover bg-center bg-no-repeat" style="background-image: url('<?php echo e(asset('storage/bg.jpg')); ?>');">
    <nav class="bg-gray-800 py-4">
        <div class="container mx-auto px-6 flex flex-col md:flex-row items-center justify-between">
            <div class="flex items-center space-x-3 w-full md:w-auto justify-between md:justify-start">
                <div class="flex items-center space-x-3">
                    <img src="<?php echo e(asset('storage/logo.png')); ?>" alt="PKK Market Logo" class="h-12 w-12 object-contain">
                    <a href="<?php echo e(route('barangs.index')); ?>" class="text-white text-2xl font-bold leading-tight">PKK Market</a>
                </div>
            <button id="mobileMenuButton" class="md:hidden text-white focus:outline-none" aria-label="Toggle menu">
                <i class="fas fa-bars text-2xl"></i>
            </button>
            </div>

            <form id="searchForm" method="GET" action="<?php echo e(route('barangs.index')); ?>" class="mb-4 md:mb-0 flex w-full md:w-auto">
                <input type="text" id="searchInput" name="search" value="<?php echo e(request('search')); ?>"
                    placeholder="Cari nama barang..."
                    class="border px-4 py-2 rounded-l-md w-full md:w-64 focus:outline-none focus:ring focus:ring-indigo-500">
                <button type="submit"
                    class="bg-indigo-600 text-white px-4 py-2 rounded-r-md hover:bg-indigo-700 transition">
                    <i class="fas fa-search"></i>
                </button>
            </form>

            <!-- Navbar Content -->
            <div id="navContent" class="hidden md:flex flex-col md:flex-row items-center space-x-0 md:space-x-8 w-full md:w-auto mt-4 md:mt-0">
                <?php if(auth()->guard()->check()): ?>
                <ul class="flex flex-col md:flex-row items-center space-x-0 md:space-x-8 list-none w-full md:w-auto">
                    <li class="nav-item relative md:relative right-0 md:right-10 mb-2 md:mb-0 w-full md:w-auto">
                        <a href="<?php echo e(route('suggestion.create')); ?>" class="nav-link flex items-center justify-center md:justify-start">
                            <i class="fas fa-comment-dots text-gray-500 text-2xl transition-all duration-300 transform hover:text-blue-500 hover:scale-110"></i>
                        </a>
                    </li>
                    <li class="nav-item relative md:relative right-0 md:right-10 mb-2 md:mb-0 w-full md:w-auto">
                        <a href="<?php echo e(route('history.index')); ?>" class="nav-link flex items-center justify-center md:justify-start">
                            <i class="fas fa-history text-gray-500 text-2xl transition-all duration-300 transform hover:text-blue-500 hover:scale-110"></i>
                        </a>
                    </li>
                    <?php if(auth()->guard()->check()): ?>
                    <?php if(Auth::user()->role === 'admin'): ?>
                        <li class="nav-item relative md:relative right-0 md:right-10 mb-2 md:mb-0 w-full md:w-auto">
                            <a href="<?php echo e(route('admin.purchases.management')); ?>" class="nav-link flex items-center justify-center md:justify-start">
                                <i class="fas fa-tasks text-gray-500 text-2xl transition-all duration-300 transform hover:text-blue-500 hover:scale-110"></i>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if(Auth::user()->role === 'admin' || Auth::user()->role === 'supplier'): ?>
                            <li class="nav-item relative md:relative right-0 md:right-10 mb-2 md:mb-0 w-full md:w-auto">
                                <a href="<?php echo e(route('barangs.create')); ?>" class="nav-link flex items-center justify-center md:justify-start">
                                    <i class="fas fa-plus-circle text-gray-500 text-2xl transition-all duration-300 transform hover:text-blue-500 hover:scale-110"></i>
                                </a>
                            </li>
                        <?php endif; ?>
                    <?php endif; ?>
                    <?php if(Auth::user()->role === 'user'): ?>
                    <li class="nav-item relative md:relative right-0 md:right-10 mb-2 md:mb-0 w-full md:w-auto">
                        <a href="<?php echo e(route('cart.index')); ?>" class="nav-link flex items-center relative justify-center md:justify-start">
                            <i class="fas fa-shopping-cart text-gray-500 text-2xl transition-all duration-300 transform hover:text-blue-500 hover:scale-110"></i>
                            <?php
                                $cartCount = session('cart.count', 0);
                                $displayCount = $cartCount > 99 ? '99+' : ($cartCount > 0 ? $cartCount : null);
                            ?>
                            <?php if($displayCount): ?>
                            <span class="absolute -right-6 translate-x-1/2 -translate-y-1/2 text-xs font-bold text-white bg-red-600 py-0.5 px-2 rounded-full min-w-[30px] text-center truncate max-w-[50px] ai-style-change-1 -top-2">
                                <?php echo e($displayCount); ?>

                            </span>                            
                            <?php endif; ?>
                        </a>
                    </li>                    
                    <?php endif; ?>
                </ul>
                <div class="relative md:relative right-0 md:right-10 z-60 mt-2 md:mt-0 flex justify-center md:justify-start">
                    <button id="dropdownButton" class="flex items-center space-x-3 text-white hover:text-blue-400 focus:outline-none">
                        <?php if(Auth::user()->foto): ?>
                        <img src="<?php echo e(asset('storage/' . Auth::user()->foto)); ?>" alt="Profile Photo"
                            class="w-12 h-12 rounded-full object-cover">
                        <?php else: ?>
                        <img src="https://static.vecteezy.com/system/resources/previews/005/129/844/non_2x/profile-user-icon-isolated-on-white-background-eps10-free-vector.jpg"
                            alt="Default Photo" class="w-12 h-12 rounded-full object-cover">
                        <?php endif; ?>
                    </button>
                    <ul id="dropdownMenu" class="hidden absolute right-0 mt-12 w-56 bg-gray-800 text-white rounded shadow-lg z-30">
                        <li class="px-4 py-2 hover:bg-gray-600 flex items-center space-x-2">
                            <i class="fas fa-user-circle"></i>⠀
                            <span><?php echo e(Auth::user()->name); ?>: <?php echo e(auth()->user()->role); ?></span>
                        </li>
                        <li class="px-4 py-2 hover:bg-gray-600 flex items-center space-x-2">
                            <i class="fas fa-user"></i>
                            <a href="<?php echo e(route('profile.edit')); ?>">⠀Profile</a>
                        </li>
                        <?php if(Auth::user()->role === 'user'): ?>
                            <li class="px-4 py-2 hover:bg-gray-600 flex items-center space-x-2">
                                <i class="fas fa-heart"></i>
                                <a href="<?php echo e(route('wishlist.index')); ?>">⠀Lihat Wishlist</a>
                            </li>
                        <?php endif; ?>
                        <li>
                            <hr class="border-gray-600">
                        </li>
                        <li class="px-4 py-2 hover:bg-gray-600 flex items-center space-x-2">
                            <i class="fas fa-sign-out-alt"></i>
                            <a href="<?php echo e(route('logout')); ?>" 
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">⠀Logout</a>
                            <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="hidden">
                                <?php echo csrf_field(); ?>
                            </form>
                        </li>                        
                    </ul>
                </div>
                <?php else: ?>
                <a href="<?php echo e(route('login')); ?>" class="text-white hover:text-blue-400 text-lg"><i class="fas fa-sign-in-alt"></i>⠀Login</a>
                <a href="<?php echo e(route('register')); ?>" class="text-white hover:text-blue-400 text-lg"><i class="fas fa-user-plus"></i>⠀Register</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Kontainer Utama -->
    <main class="flex-grow container mx-auto mt-6 px-6">
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-6 mt-auto">
        <div class="container mx-auto text-center">
            <p class="text-sm">&copy; <?php echo e(date('Y')); ?> PKK Market. All rights reserved.</p>
            <div class="mt-4 flex justify-center space-x-4">
                <a href="mailto:info@smkn8jakarta.sch.id" title="Contact" class="text-white hover:text-blue-400 text-2xl">
                    <i class="fas fa-envelope"></i>
                </a>
                <a href="https://www.youtube.com/@Smkn8jkt" target="_blank" title="Youtube" class="text-white hover:text-red-600 text-2xl">
                    <i class="fab fa-youtube"></i>
                </a>
                <a href="https://www.facebook.com/smkn8jktofficial" target="_blank" title="Facebook" class="text-white hover:text-blue-600 text-2xl">
                    <i class="fab fa-facebook"></i>
                </a>
                <a href="https://www.instagram.com/delapanjkt" target="_blank" title="Instagram" class="text-white hover:text-pink-500 text-2xl">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="https://x.com/smkn8jkt" target="_blank" title="X (Formerly Twitter)" class="text-white hover:text-black text-2xl">
                    <i class="fab fa-x-twitter"></i>
                </a>
                <a href="https://wa.me/6285717281174" target="_blank" title="WhatsApp" class="text-white hover:text-green-500 text-2xl">
                    <i class="fab fa-whatsapp"></i>
                </a>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script>
        const dropdownButton = document.getElementById('dropdownButton');
        const dropdownMenu = document.getElementById('dropdownMenu');

        dropdownButton.addEventListener('click', (e) => {
            e.stopPropagation();
            dropdownMenu.classList.toggle('hidden');
        });

        window.addEventListener('click', (e) => {
            if (!dropdownButton.contains(e.target) && !dropdownMenu.contains(e.target)) {
                dropdownMenu.classList.add('hidden');
            }
        });
        
        document.getElementById('searchForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const query = document.getElementById('searchInput').value;
            fetch(`<?php echo e(route('barangs.index')); ?>?search=${encodeURIComponent(query)}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                const barangs = data.barangs;
                const container = document.getElementById('productGridContainer');
                if (!container) return;
                let html = '';
                const categories = {
                    'makanan': 'Makanan dan Minuman',
                    'kerajinan': 'Seni dan Kerajinan'
                };
                for (const [key, categoryName] of Object.entries(categories)) {
                    html += `<div class="flex flex-col items-center">
                                <h2 class="text-2xl font-semibold mt-4 mb-6 px-6 py-2 bg-gradient-to-r from-blue-500 to-green-500 text-white rounded-lg shadow-lg">${categoryName}</h2>
                                <div class="grid grid-cols-1 items-center sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-8 px-4 mt-4 mb-12">`;
                    barangs.filter(b => b.kategori_barang === key).forEach(barang => {
                        html += `
                            <div class="bg-white shadow-lg rounded-lg overflow-hidden transform hover:scale-105 transition-all">
                                <div class="relative">
                                    ${barang.foto_barang ? `<img src="/storage/${barang.foto_barang}" class="w-full h-48 object-cover" alt="${barang.nama_barang}"/>` : `<div class="w-full h-48 flex items-center justify-center bg-gray-200 text-gray-500 italic">Tidak ada gambar</div>`}
                                    <div class="absolute top-2 left-2 px-2 py-1 rounded-full text-white text-sm ${barang.jumlah_barang == 0 ? 'bg-red-500' : 'bg-green-500'}">
                                        ${barang.jumlah_barang == 0 ? 'Habis' : 'Tersedia'}
                                    </div>
                                </div>
                                <div class="p-4">
                                    <h3 class="text-lg font-bold text-gray-800">${barang.nama_barang}</h3>
                                    <p class="text-pink-600 font-semibold">Rp ${Number(barang.harga_barang).toLocaleString('id-ID', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</p>
                                    <p class="text-gray-500 text-sm">Sisa: ${barang.jumlah_barang}</p>
                                </div>
                            </div>`;
                    });
                    html += `</div></div>`;
                }
                container.innerHTML = html;
            })
            .catch(error => {
                console.error('Error fetching search results:', error);
            });
        });
    </script>
    <script>
        // Mobile menu toggle
        const mobileMenuButton = document.getElementById('mobileMenuButton');
        const navContent = document.getElementById('navContent');

        mobileMenuButton.addEventListener('click', () => {
            navContent.classList.toggle('hidden');
        });
    </script>
</body>
</html>
<?php /**PATH C:\Users\HP\laravel\Projek_RPL\resources\views/layouts/app.blade.php ENDPATH**/ ?>