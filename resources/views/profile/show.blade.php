@extends('layouts.app')

@section('title', 'User Profile')

@section('content')
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>

<div class="py-12 max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-12">    
    {{-- Profile Section --}}
    <section class="relative bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 p-8 rounded-3xl shadow-xl overflow-hidden text-white">
        <div class="absolute inset-0 bg-black bg-opacity-20 backdrop-blur-md rounded-3xl z-0"></div>
        <div class="relative z-10 flex flex-col lg:flex-row items-center gap-8">
            <img src="{{ $user->foto ? Storage::url($user->foto) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=random&size=128' }}" 
                 alt="{{ $user->name }}" 
                 class="w-40 h-40 rounded-full object-cover ring-4 ring-white shadow-lg">

            <div class="text-center lg:text-left space-y-2">
                <h2 class="text-3xl font-bold">{{ $user->name }}</h2>
                <div class="space-y-1 text-sm">
                    <p class="flex items-center gap-2 justify-center lg:justify-start">
                        <i class="fas fa-envelope text-white/80"></i> {{ $user->email }}
                    </p>
                    @if($user->username)
                        <p class="flex items-center gap-2 justify-center lg:justify-start">
                            <i class="fas fa-user text-white/80"></i> {{ $user->username }}
                        </p>
                    @endif
                    @if($user->birth_date)
                        <p class="flex items-center gap-2 justify-center lg:justify-start">
                            <i class="fas fa-calendar-alt text-white/80"></i> {{ \Carbon\Carbon::parse($user->birth_date)->format('d M Y') }}
                        </p>
                    @endif
                    @if($user->phone)
                        <p class="flex items-center gap-2 justify-center lg:justify-start">
                            <i class="fas fa-phone-alt text-white/80"></i> {{ $user->phone }}
                        </p>
                    @endif
                    @if($user->alamat)
                        <p class="flex items-center gap-2 justify-center lg:justify-start">
                            <i class="fas fa-map-marker-alt text-white/80"></i> {{ $user->alamat }}
                        </p>
                    @endif
                </div>
                <p class="mt-2 text-sm">{{ $user->about }}</p>
                <p class="text-xs text-white/70 mt-1">Bergabung sejak {{ $user->created_at->translatedFormat('d F Y') }}</p>
            </div>
        </div>
    </section>

    {{-- Items for Sale --}}
    <section class="bg-white bg-opacity-90 p-8 rounded-2xl shadow">
        <header class="mb-6 text-center">
            <h2 class="text-2xl font-bold text-gray-800">Barang Dijual</h2>
        </header>

        @if($user->barangs->isEmpty())
            <p class="text-center text-gray-600">Belum ada barang yang dijual.</p>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($user->barangs as $barang)
                    <div class="relative bg-white border rounded-2xl shadow-md overflow-hidden hover:shadow-lg transition-all duration-300 flex flex-col">
                        
                        {{-- Image --}}
                        <div class="relative">
                            @if ($barang->foto_barang)
                                <img src="{{ Storage::url($barang->foto_barang) }}" class="w-full h-48 object-cover" alt="{{ $barang->nama_barang }}">
                            @else
                                <div class="w-full h-48 flex items-center justify-center bg-gray-200 text-gray-500 italic">Tidak ada gambar</div>
                            @endif
                            <div class="absolute top-2 left-2">
                                <span class="text-xs font-medium px-3 py-1 rounded-full 
                                    {{ $barang->jumlah_barang > 0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ $barang->jumlah_barang > 0 ? 'Tersedia' : 'Habis' }}
                                </span>
                            </div>
                        </div>

                        {{-- Details --}}
                        <div class="p-4 flex flex-col justify-between flex-1">
                            <div class="space-y-2">
                                <h3 class="text-lg font-bold text-gray-900">{{ $barang->nama_barang }}</h3>
                                <p class="text-sm text-gray-600">{{ Str::limit($barang->deskripsi, 80) }}</p>
                            </div>
                            <div class="mt-4 flex flex-col gap-2">
                                <span class="text-pink-600 font-semibold text-lg">Rp {{ number_format($barang->harga_barang, 2, ',', '.') }}</span>
                                <span class="text-sm text-gray-600">Sisa: {{ $barang->jumlah_barang }}</span>
                            </div>

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
                                
                                @if (Auth::user()->role === 'user')
                                    <button type="button" class="mt-4 bg-green-600 hover:bg-green-700 text-white py-2 rounded-lg text-sm font-semibold flex items-center justify-center transition duration-300">
                                        <i class="fas fa-cart-plus mr-2"></i> Tambah ke Keranjang
                                    </button>
                                @endif
                            @endauth
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </section>
</div>
@endsection