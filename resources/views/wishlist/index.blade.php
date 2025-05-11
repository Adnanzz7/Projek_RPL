@extends('layouts.app')

@section('title', 'Wishlist Saya')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-10">
    <h2 class="text-4xl font-extrabold text-center text-indigo-700 mb-10">
        <i class="fas fa-heart"></i> Wishlist Saya
    </h2>

    @if (session('success'))
        <div class="bg-green-100 border border-green-300 text-green-800 px-6 py-4 rounded mb-8 max-w-3xl mx-auto">
            {{ session('success') }}
        </div>
    @endif

    @if($wishlists->isEmpty())
        <p class="text-center text-gray-500 text-lg">Wishlist Anda kosong.</p>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">
            @foreach ($wishlists as $wishlist)
                <div class="bg-white shadow-xl rounded-lg overflow-hidden flex flex-col transition-transform transform hover:scale-105 hover:shadow-2xl duration-300">
                    <div class="h-56 bg-gray-100 flex items-center justify-center p-4">
                        @if ($wishlist->barang && $wishlist->barang->foto_barang)
                            <img src="{{ Storage::url('public/' . $wishlist->barang->foto_barang) }}" alt="{{ $wishlist->barang->nama_barang }}" class="object-cover object-center h-full w-full rounded-md">
                        @else
                            <span class="text-gray-400 italic">Tidak ada gambar</span>
                        @endif
                    </div>
                    <div class="p-6 flex flex-col flex-grow">
                        <h3 class="text-xl font-semibold text-gray-900 mb-3 truncate" title="{{ $wishlist->barang->nama_barang ?? 'Produk tidak ditemukan' }}">
                            {{ $wishlist->barang->nama_barang ?? 'Produk tidak ditemukan' }}
                        </h3>
                        <p class="text-indigo-600 font-extrabold text-2xl mb-2">Rp {{ number_format($wishlist->barang->harga_barang ?? 0, 0, ',', '.') }}</p>
                        <p class="text-gray-600 text-sm mb-3">Stok: {{ $wishlist->barang->jumlah_barang ?? 0 }}</p>
                        <p class="text-gray-500 text-xs mb-5">Dari: {{ $wishlist->barang->user->name ?? '-' }}</p>
                        <div class="mt-auto flex space-x-4">
                            @if ($wishlist->barang && $wishlist->barang->jumlah_barang > 0)
                                <form action="{{ route('wishlist.moveToCart', $wishlist->id) }}" method="POST" class="flex-grow">
                                    @csrf
                                    <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white py-3 rounded-lg text-sm font-semibold flex items-center justify-center space-x-2 transition duration-300">
                                        <i class="fas fa-cart-plus text-lg"></i>
                                        <span>Tambah ke Keranjang</span>
                                    </button>
                                </form>
                            @else
                                <span class="text-red-600 text-sm font-semibold flex-grow flex items-center justify-center">Stok habis</span>
                            @endif
                            <form action="{{ route('wishlist.destroy', $wishlist->id) }}" method="POST" class="flex-grow">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white py-3 rounded-lg text-sm font-semibold flex items-center justify-center space-x-2 transition duration-300">
                                    <i class="fas fa-trash-alt text-lg"></i>
                                    <span>Hapus</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
