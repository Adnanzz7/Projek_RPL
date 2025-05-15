@extends('layouts.app')

@section('title', 'Daftar Barang')

@section('content')
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>

<header id="showcase" class="fixed top-0 left-0 w-full h-full bg-gradient-to-br from-green-100 to-blue-200 z-50 flex flex-col justify-center items-center text-center px-4 transition-opacity duration-1000">   
    <!-- Logo -->
    <div class="absolute top-6 left-6 flex items-center space-x-3">
        <img src="{{ asset('storage/logo.png') }}" alt="PKK Market Logo" class="h-12 w-12 object-contain">
        <span class="text-xl font-bold text-red-300">PKK Market</span>
    </div>

    <!-- Animasi Latar -->
    <div class="absolute inset-0 z-0 pointer-events-none">
        <div class="absolute top-1/4 left-1/2 transform -translate-x-1/2 animate-pulse bg-orange-300 opacity-30 w-64 h-64 rounded-full filter blur-3xl"></div>
    </div>

    <!-- Konten Utama -->
    <div class="relative z-10">
        <h1 class="text-5xl md:text-6xl font-extrabold text-gray-800 mb-4 drop-shadow-md">
            Selamat Datang di <span class="text-red-600">PKK Market</span>!
        </h1>
        <p class="text-lg md:text-xl text-gray-700 max-w-2xl mx-auto mb-8">
            Temukan produk kreatif karya siswa: makanan, minuman, kerajinan tangan, dan lainnya.<br />
            Dukung semangat wirausaha lokal berkualitas!
        </p>

        <div class="flex justify-center items-center gap-8 mt-6">
            <img src="{{ asset('storage/SMKN_8_Jakarta.png') }}" alt="Logo Tambahan 1" class="h-20 w-20 object-contain hover:scale-110 transition-transform duration-300">
            <img src="{{ asset('storage/logo-adiwiyata.png') }}" alt="Logo Tambahan 2" class="h-20 w-20 object-contain hover:scale-110 transition-transform duration-300">
        </div>

        @guest
            <div class="flex flex-col sm:flex-row justify-center items-center gap-4 mt-4">
                <a href="{{ route('login') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-full shadow-md transition duration-300">
                    <i class="fas fa-sign-in-alt mr-2"></i> Masuk
                </a>
                <a href="{{ route('register') }}" class="bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-3 rounded-full shadow-md transition duration-300">
                    <i class="fas fa-user-plus mr-2"></i> Daftar
                </a>
            </div>
        @else
            <div class="mt-6">
                <a href="#daftar-produk" id="btnLihatProduk" class="bg-red-500 hover:bg-red-600 text-white font-semibold px-8 py-3 rounded-full shadow-md transition duration-300">
                    Lihat Produk
                </a>
            </div>
        @endguest
    </div>
</header>

<!-- Running Text -->
<div class="bg-center running-text text-black px-5 py-8 text-center text-xl font-bold whitespace-nowrap overflow-hidden relative mx-auto w-full max-w-xs sm:max-w-md md:max-w-lg">
    <span class="inline-block animate-scrollText">Jam Buka: 09.40 - 10.00 dan 12.30 - 13.00</span>
</div>

<h1 id="daftar-produk" class="text-4xl font-extrabold text-center text-gray-900 mt-8 mb-8">Daftar Produk Kreatif dan Kewirausahaan</h1>

@if (session('status'))
    <div class="bg-green-100 text-green-800 p-4 rounded-md mb-4">{{ session('status') }}</div>
@endif

<div id="productGridContainer">
<!-- Produk Grid -->
@php
    $categories = [
        'makanan' => 'Makanan dan Minuman',
        'kerajinan' => 'Seni dan Kerajinan',
    ];
@endphp

@foreach ($categories as $key => $categoryName)
        <div class="flex flex-col items-center">
            <h2 class="text-2xl font-semibold mt-4 mb-6 px-6 py-2 bg-gradient-to-r from-blue-500 to-green-500 text-white rounded-lg shadow-lg">{{ $categoryName }}</h2>
        <div id="productGrid" class="grid grid-cols-1 items-center sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-8 px-2 sm:px-4 mt-4 mb-12 justify-center">
            @foreach ($barangs->where('kategori_barang', $key) as $barang)
                <div class="bg-white shadow-lg rounded-lg overflow-hidden transform hover:scale-105 hover:shadow-2xl transition-all duration-300 ease-in-out cursor-pointer">
                    <div class="relative">
                        @if ($barang->foto_barang)
                            <img src="{{ Storage::url('public/' . $barang->foto_barang) }}" class="w-full h-48 object-cover rounded-t-lg" alt="{{ $barang->nama_barang }}"/>
                            <div class="absolute top-2 left-1 px-2 py-1 rounded-full text-white text-sm">
                                @if($barang->jumlah_barang > 0)
                                    <span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full">Tersedia</span>
                                @else
                                    <span class="bg-red-100 text-red-700 text-xs px-2 py-1 rounded-full">Habis</span>
                                @endif
                            </div>
                        @else
                            <div class="w-full h-48 flex items-center justify-center bg-gray-200 text-gray-500 italic rounded-t-lg">Tidak ada gambar</div>
                        @endif
                    </div>

                    <div class="p-4">
                        <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $barang->nama_barang }}</h3>
                        <p class="text-pink-600 font-semibold text-lg mb-1">Rp {{ number_format($barang->harga_barang, 2, ',', '.') }}</p>
                        <p class="text-gray-600 text-sm mb-1">Sisa: {{ $barang->jumlah_barang }}</p>
                        <p class="text-gray-500 text-sm italic">Pengirim: <a href="{{ route('profile.show', $barang->user->id) }}" class="text-gray-500 hover:underline">{{ $barang->user->name }}</a></p>

                        @auth
                            @if (Auth::user()->role === 'user')
                                <div class="absolute right-2 top-[210px]">
                                    <form action="{{ route('wishlist.add', $barang->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" 
                                            class="text-red-500 hover:text-red-600 transition-transform duration-300 relative hover:scale-110 shadow-none rounded px-3 py-1">
                                            <i class="bi bi-heart"></i>
                                        </button>
                                    </form>
                                </div>
                            @endif
                            
                            @if (Auth::user()->role === 'admin' || (Auth::user()->role === 'supplier' && Auth::id() === $barang->user_id))
                                <div class="flex justify-between items-center mt-4">
                                    <a href="{{ route('barangs.edit', $barang->id) }}" 
                                        class="text-yellow-500 hover:text-yellow-600 transition-transform duration-300 relative hover:scale-105">
                                        <i class="bi bi-pencil-square"></i>⠀Edit
                                    </a>
                                    
                                    @if (Auth::user()->role === 'admin')
                                        <a href="{{ route('barangs.show', $barang->id) }}" 
                                            class="btn flex items-center justify-center px-4 py-2 text-base rounded-full cursor-pointer transition-transform duration-300 relative hover:scale-105 hover:text-[#138496] text-[#17a2b8]">
                                            <i class="icon-class transition-transform duration-300 bi bi-info-circle"></i>⠀Detail
                                        </a>
                                    @endif
                                    
                                    <form action="{{ route('barangs.destroy', $barang->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus barang ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                            class="text-red-500 hover:text-red-600 transition-transform duration-300 relative hover:scale-105">
                                            <i class="bi bi-trash"></i>⠀Delete
                                        </button>
                                    </form>                                
                                </div>
                            @endif
                        @endauth            

                    @auth
                        @if (Auth::user()->role === 'user')
                            @php
                                $currentTime = \Carbon\Carbon::now('Asia/Jakarta');
                                $isTimeAllowed = ($currentTime->between(
                                    \Carbon\Carbon::createFromTime(9, 30, 0, 'Asia/Jakarta'),
                                    \Carbon\Carbon::createFromTime(10, 0, 0, 'Asia/Jakarta')
                                ) || $currentTime->between(
                                    \Carbon\Carbon::createFromTime(11,30, 0, 'Asia/Jakarta'),
                                    \Carbon\Carbon::createFromTime(22, 0, 0, 'Asia/Jakarta')
                                ));
                            @endphp
                            
                            @if ($isTimeAllowed)
                                <form action="{{ route('cart.add.form', $barang->id) }}" method="GET">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $barang->id }}">
                                    <input type="hidden" name="name" value="{{ $barang->nama_barang }}">
                                    <input type="hidden" name="price" value="{{ $barang->harga_barang }}">
                                    <input type="hidden" name="jumlah_barang" value="{{ $barang->jumlah_barang }}">

                                    <div class="flex justify-center mt-4">
                                        <button type="submit" 
                                            class="btn bg-green-500 text-white px-6 py-3 rounded-lg hover:bg-green-600 transition-transform duration-300 transform hover:scale-105">
                                            Tambah
                                        </button>
                                    </div>                        
                                </form>                        
                            @else
                                <button type="button" class="btn flex items-center justify-center px-4 py-2 text-base rounded-lg cursor-pointer transition-transform duration-300 relative hover:scale-105 hover:text-white btn-disable" disabled>
                                    <p class="text-red-500 text-sm font-bold text-center mt-2 bg-red-100 border border-red-500 rounded-md px-4 py-2">Hanya tersedia pada pukul 09:40-10:00 dan 12:30-13:00 WIB.</p>
                                </button>
                            @endif
                        @endif
                    @endauth
                </div>
    </div>
@endforeach
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const productGrid = document.getElementById('productGrid');
        const items = productGrid.children;
        const maxItemsPerRow = 5;

        function updateGridAlignment() {
            // Reset justify-content
            productGrid.style.justifyContent = 'center';

            // Count items in the first row
            let firstRowCount = 0;
            let firstRowTop = null;
            for (let i = 0; i < items.length; i++) {
                const item = items[i];
                const rect = item.getBoundingClientRect();
                if (firstRowTop === null) {
                    firstRowTop = rect.top;
                }
                if (Math.abs(rect.top - firstRowTop) < 5) {
                    firstRowCount++;
                } else {
                    break;
                }
            }

            if (firstRowCount >= maxItemsPerRow) {
                // Align first row to left
                productGrid.style.justifyContent = 'flex-start';
            }
        }

        updateGridAlignment();

        window.addEventListener('resize', updateGridAlignment);
    });
</script>
@endforeach
</div>

<!-- Tutorial Button -->
<div class="tutorial-btn absolute top-24 mt-3 right-5 sm:right-10 md:right-16">
    <a href="javascript:void(0)" id="tutorialModalTrigger" class="text-white bg-gradient-to-r from-blue-600 to-blue-400 hover:bg-gradient-to-r hover:from-blue-700 hover:to-blue-500 px-6 py-3 rounded-full shadow-lg text-lg font-bold tracking-wider transition duration-300 transform hover:scale-105">
        <i class="icon-class transition-transform duration-300 mr-2 fas fa-question-circle"></i> Tutorial
    </a>
</div>

<!-- Modal -->
<div id="tutorialModal" class="modal fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50 opacity-0 pointer-events-none transition-opacity duration-300">
    <div class="modal-dialog w-full max-w-sm md:max-w-md lg:max-w-lg opacity-0 transform scale-95 transition-all duration-300">
        <div class="modal-content bg-gradient-to-b from-white to-gray-100 rounded-xl shadow-lg p-5">
            <div class="modal-header bg-gradient-to-r from-blue-600 to-blue-400 text-white text-center py-5 border-b-4 border-blue-700 uppercase text-lg font-bold tracking-wider">
                <h5 class="modal-title" id="tutorialModalLabel">Panduan Penggunaan</h5>
                <button type="button" class="btn-close" id="closeModal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-gray-700 text-base leading-7 text-justify my-4">
                <ol class="list-decimal pl-5">
                    @guest
                        <li><strong>Register:</strong> Klik tombol <b><i class="fas fa-user-plus"></i>⠀Register</b> untuk membuat akun, lalu pilih role <b>Admin</b>, <b>Suplier</b>, Atau, <b>User</b>.</li>
                        <li><strong>Login:</strong> Klik tombol <b><i class="fas fa-sign-in-alt"></i>⠀Login</b> untuk masuk menggunakan akun yang telah didaftarkan</li>
                        <li><strong>Info:</strong> Anda harus <b><i class="fas fa-sign-in-alt"></i>⠀Login</a></b> atau <b><i class="fas fa-user-plus"></i>⠀Register</b> untuk memulai.</li>
                    @endguest

                    @if(Auth::check())
                        @if(Auth::user()->role === 'admin')
                            <li><strong>Detail:</strong> Cari barang yang ingin Anda lihat, lalu klik tombol <b><i class="icon-class transition-transform duration-300 bi bi-info-circle"></i>⠀Detail</b>.</li>
                            <li><strong>Tambah Barang:</strong> Klik tombol <b><i class="fas fa-plus-circle"></i></b> di atas untuk menambahkan barang yang Anda inginkan.</li>
                            <li><strong>Edit Barang:</strong> Cari barang yang ingin Anda ubah, lalu klik tombol <b><i class="bi bi-pencil-square"></i>⠀Edit</b>.</li>
                            <li><strong>Hapus Barang:</strong> Cari barang yang ingin Anda hapus, klik tombol <b><i class="bi bi-trash"></i>⠀Delete</b>, lalu konfirmasi penghapusan.</li>
                        @elseif(Auth::user()->role === 'supplier')
                            <li><strong>Tambah Barang:</strong> Klik tombol <b>Tambah Barang</b> di atas untuk menambahkan barang yang Anda inginkan.</li>
                            <li><strong>Edit Barang:</strong> Cari barang yang telah Anda buat sebelumnya, lalu klik tombol <b><i class="bi bi-pencil-square"></i>⠀Edit</b>.</li>
                            <li><strong>Hapus Barang:</strong> Cari barang yang telah Anda buat sebelumnya, klik tombol <b><i class="bi bi-trash"></i>⠀Delete</b>, lalu konfirmasi penghapusan.</li>
                        @elseif(Auth::user()->role === 'user')
                            <li><strong>Pilih Barang:</strong> Cari barang yang ingin Anda beli, isi jumlahnya, lalu klik tombol <b><i class="fas fa-plus"></i></b>.</li>
                            <li><strong>Keranjang:</strong> Klik tombol <b><i class="fas fa-shopping-cart"></i></b> di posisi atas untuk melihat barang yang telah Anda pilih.</li>
                            <li><strong>Checkout:</strong> Setelah memeriksa barang di keranjang, lanjutkan ke proses <b>Checkout</b>.</li>
                            <li><strong>Pembayaran:</strong> Pilih metode <b>QRIS</b> atau <b>Cash</b> untuk menyelesaikan pembayaran.</li>
                        @endif
                    @endif
                </ol>
            </div>
            <div class="modal-footer flex justify-between items-center px-5 py-2 border-t border-gray-300 bg-gray-50">
                <button type="button" class="btn flex items-center justify-center text-base cursor-pointer relative hover:scale-100 hover:text-white btn-secondary px-5 py-2 rounded-full text-white bg-gradient-to-r outline-none from-red-500 to-red-600 hover:from-red-600 hover:to-red-500 transform hover:-translate-y-1 focus:outline-none transition duration-300" 
                id="closeModalBtn">Tutup</button>
            </div>
        </div>
    </div>
</div>

<style>
    .animate-scrollText {
        position: relative;
        animation: scrollText 8s linear infinite;
    }

    @keyframes scrollText {
        0% {
            left: 100%;
        }
        100% {
            left: -100%;
        }
    }

    #showcase {
        opacity: 1;
    }

    #showcase.fade-out {
        opacity: 0;
        pointer-events: none;
    }

    body.no-scroll {
        overflow: hidden;
    }

    html {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>

<script>
    const modal = document.getElementById('tutorialModal');
    const trigger = document.getElementById('tutorialModalTrigger');
    const closeModal = document.getElementById('closeModal');
    const closeModalBtn = document.getElementById('closeModalBtn');

    // Function to show modal
    trigger.addEventListener('click', () => {
        modal.classList.remove('opacity-0', 'pointer-events-none');
        modal.classList.add('opacity-100', 'pointer-events-auto');
        setTimeout(() => {
            modal.querySelector('.modal-dialog').classList.add('opacity-100', 'scale-100');
        }, 50); // Slight delay to trigger smooth transition
    });

    // Close the modal when close button is clicked
    closeModal.addEventListener('click', () => {
        modal.classList.remove('opacity-100', 'pointer-events-auto');
        modal.classList.add('opacity-0', 'pointer-events-none');
        modal.querySelector('.modal-dialog').classList.remove('opacity-100', 'scale-100');
    });

    // Close the modal when clicking outside of it
    window.addEventListener('click', (event) => {
        if (event.target === modal) {
            modal.classList.remove('opacity-100', 'pointer-events-auto');
            modal.classList.add('opacity-0', 'pointer-events-none');
            modal.querySelector('.modal-dialog').classList.remove('opacity-100', 'scale-100');
        }
    });

    // Ensure close button is clickable
    closeModalBtn.addEventListener('click', () => {
        modal.classList.remove('opacity-100', 'pointer-events-auto');
        modal.classList.add('opacity-0', 'pointer-events-none');
        modal.querySelector('.modal-dialog').classList.remove('opacity-100', 'scale-100');
    });

    document.addEventListener('DOMContentLoaded', function () {
        const button = document.getElementById('btnLihatProduk');
        const showcase = document.getElementById('showcase');
        const target = document.getElementById('daftar-produk');

        // Tambahkan kelas no-scroll saat showcase muncul
        document.body.classList.add('no-scroll');

        if (button && showcase && target) {
            button.addEventListener('click', function (e) {
                e.preventDefault();

                // Fade out showcase
                showcase.classList.add('fade-out');

                // Setelah efek selesai, hilangkan elemen showcase dan izinkan scroll
                setTimeout(() => {
                    showcase.style.display = 'none'; // sembunyikan sepenuhnya
                    document.body.classList.remove('no-scroll');
                    target.scrollIntoView({ behavior: 'smooth' });
                }, 1000); // sesuai durasi animasi CSS
            });
        }
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.tailwindcss.com"></script>
@endsection
