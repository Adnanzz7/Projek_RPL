@extends('layouts.app')

@section('title', 'Keranjang')

@section('content')
<div class="container mx-auto max-w-7xl py-10 px-4">
    <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-2">
            <i class="fas fa-shopping-cart text-blue-500"></i> Keranjang Belanja
        </h2>

        <div class="flex justify-end mb-6">
    <a href="{{ route('barangs.index') }}" class="inline-block bg-indigo-500 hover:bg-indigo-600 text-white px-6 py-2 rounded font-semibold text-sm">
        <i class="fas fa-plus mr-2"></i> Tambah Barang
    </a>
</div>

        @if (count($cartItems) > 0)
            <div class="divide-y">
                @foreach ($cartItems as $id => $item)
                <div class="flex flex-col sm:flex-row items-center justify-between py-5 gap-4">
                    {{-- Gambar produk --}}
                    <div class="w-full sm:w-32 h-32 flex-shrink-0 overflow-hidden bg-gray-100 rounded">
                        @if (!empty($item['foto_barang']))
                            <img src="{{ Storage::url('public/' . $item['foto_barang']) }}" alt="{{ $item['name'] }}" class="object-cover w-full h-full">
                        @else
                            <div class="flex items-center justify-center h-full text-gray-400 italic">Tidak ada gambar</div>
                        @endif
                    </div>

                    {{-- Informasi produk --}}
                    <div class="flex-1 sm:ml-4">
                        <h3 class="text-lg font-semibold text-gray-800">{{ $item['name'] ?? 'Nama Tidak Tersedia' }}</h3>
                        <p class="text-sm text-gray-500 mt-1">{{ $item['description'] ?? 'Tidak ada deskripsi' }}</p>
                        <p class="text-pink-600 mt-1 font-bold">Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
                        <p class="text-sm text-gray-600 mt-1">Jumlah: {{ $item['quantity'] }}</p>
                        <p class="text-sm text-green-600 font-medium mt-1">Subtotal: Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</p>
                    </div>

                    {{-- Aksi --}}
                    <div class="flex flex-col items-end gap-2">
                        <a href="{{ route('cart.edit', $id) }}" class="text-sm bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                            <i class="fas fa-edit mr-1"></i> Ubah
                        </a>
                        <form action="{{ route('cart.remove') }}" method="POST" class="w-full">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="id" value="{{ $id }}">
                            <button type="submit" class="w-full text-sm bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">
                                <i class="fas fa-trash-alt mr-1"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Ringkasan dan tombol checkout --}}
            <div class="flex flex-col sm:flex-row justify-between items-center mt-8 border-t pt-6">
                <div class="text-lg font-semibold text-gray-800">
                    Total Harga: <span class="text-green-600">Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>
                <a href="{{ route('cart.checkout') }}" class="mt-4 sm:mt-0 px-6 py-3 bg-green-500 hover:bg-green-600 text-white font-bold rounded">
                    <i class="fas fa-credit-card mr-2"></i> Checkout Sekarang
                </a>
            </div>
        @else
            <div class="text-center py-16 text-gray-500">
                <i class="fas fa-shopping-basket text-5xl mb-4"></i>
                <p class="text-lg font-medium">Keranjang Anda kosong.</p>
                <a href="{{ route('barangs.index') }}" class="mt-4 inline-block px-6 py-3 bg-blue-500 text-white rounded hover:bg-blue-600">
                    <i class="fas fa-shopping-bag mr-2"></i> Mulai Belanja
                </a>
            </div>
        @endif

        {{-- Tombol hapus semua --}}
        @if (count($cartItems) > 0)
            <div class="flex justify-end mt-6">
                <a href="{{ route('cart.clear') }}" class="px-6 py-3 bg-red-500 hover:bg-red-600 text-white rounded">
                    <i class="fas fa-trash mr-2"></i> Hapus Semua
                </a>
            </div>
        @endif
    </div>

    {{-- Peringatan --}}
    @if (session('warning'))
        <div class="mt-6 p-4 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700">
            {{ session('warning') }}
        </div>
    @endif
</div>
@endsection