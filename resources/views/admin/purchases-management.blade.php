@extends('layouts.app')

@section('title', 'Purchases Management')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-7xl">
    <h2 class="text-3xl font-extrabold text-center text-gray-800 mb-6">Manajemen Pembelian Pengguna</h2>

    @if(session('success'))
        <div class="mb-4 px-4 py-2 text-green-800 bg-green-100 rounded text-center">
            {{ session('success') }}
        </div>
    @endif

    <!-- Filter Form -->
    <div class="mb-6 max-w-4xl mx-auto">
        <form method="GET" action="{{ route('admin.purchases.management') }}" class="flex flex-wrap items-center justify-center gap-4">
            <input type="text" name="buyer" placeholder="Cari nama pembeli"
                value="{{ request('buyer') }}"
                class="px-4 py-2 rounded w-40 sm:w-64 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-300 ease-in-out" />
    
            <select name="status" class="px-4 py-2 rounded w-36 sm:w-40 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-300 ease-in-out">
                <option value="">Semua Status</option>
                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
    
            <button type="submit"
                class="bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white font-semibold px-6 py-2 rounded-md shadow transition duration-300 ease-in-out transform hover:scale-105">
                <i class="fas fa-filter"></i>⠀Filter
            </button>
    
            <a href="{{ route('admin.purchases.management') }}"
                class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold px-6 py-2 rounded-md shadow transition duration-300 ease-in-out transform hover:scale-105">
                <i class="fas fa-rotate-left"></i>⠀Reset
            </a>
        </form>
    </div>    

    @if($purchases->isEmpty())
        <p class="text-center text-lg text-gray-600">Tidak ada data pembelian untuk ditampilkan.</p>
    @else
        <div class="overflow-x-auto shadow rounded-lg bg-white bg-opacity-80 border">
            <table class="min-w-full table-auto text-sm text-gray-800">
                <thead class="bg-blue-100 text-xs uppercase font-semibold">
                    <tr>
                        <th class="px-4 py-3 text-center">Order ID</th>
                        <th class="px-4 py-3 text-center">Pembeli</th>
                        <th class="px-4 py-3 text-center">Produk</th>
                        <th class="px-4 py-3 text-center">Supplier</th>
                        <th class="px-4 py-3 text-center">Harga</th>
                        <th class="px-4 py-3 text-center">Jumlah</th>
                        <th class="px-4 py-3 text-center">Total</th>
                        <th class="px-4 py-3 text-center">Status</th>
                        <th class="px-4 py-3 text-center">Tanggal</th>
                        <th class="px-4 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($purchases as $purchase)
                        <tr class="border-t hover:bg-gray-50 bg-opacity-80">
                            <td class="px-4 py-3 text-center">{{ $purchase->id }}</td>
                            <td class="px-4 py-3 text-center">{{ $purchase->user->name ?? 'N/A' }}</td>
                            <td class="px-4 py-3 text-center">{{ $purchase->barang->nama_barang ?? 'N/A' }}</td>
                            <td class="px-4 py-3 text-center">{{ $purchase->barang->supplier->name ?? 'N/A' }}</td>
                            <td class="px-4 py-3 text-center">Rp {{ number_format($purchase->price, 2, ',', '.') }}</td>
                            <td class="px-4 py-3 text-center">{{ $purchase->jumlah }}</td>
                            <td class="px-4 py-3 text-center">Rp {{ number_format($purchase->total_amount, 2, ',', '.') }}</td>
                            <td class="px-4 py-3 text-center">
                                <span class="px-2 py-1 rounded text-xs font-medium
                                    {{ $purchase->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ ucfirst($purchase->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center">{{ $purchase->created_at->format('d-m-Y') }}</td>
                            <td class="px-4 py-3 text-center">
                                <form method="POST" action="{{ route('admin.purchase.updateStatus', $purchase->id) }}" class="flex items-center justify-center gap-2">
                                    @csrf
                                    <select name="status" class="border rounded px-2 py-1 text-sm">
                                        <option value="completed" {{ $purchase->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="cancelled" {{ $purchase->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm">Update</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <div class="text-center mt-6">
        <a href="{{ route('barangs.index') }}" class="inline-block bg-blue-500 text-white px-6 py-2 rounded-full hover:bg-blue-600 transition duration-300">
            Kembali ke Barang
        </a>
    </div>
</div>
@endsection