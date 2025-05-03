@extends('layouts.app')

@section('title', 'Purchase History')

@section('content')
<div class="container mx-auto p-8">
    <h2 class="text-4xl font-extrabold text-center text-gray-800 mb-6">Purchase History</h2>

    <!-- Tombol Kembali -->
    <div class="text-center mb-6">
        <a href="{{ route('dashboard') }}" class="inline-block bg-blue-500 text-white px-6 py-2 rounded-full hover:bg-blue-600 transition duration-300">Back to Dashboard</a>
    </div>

    {{-- USER VIEW --}}
    @if (auth()->user()->role === 'user')
        @if ($purchases->isEmpty())
            <p class="text-center text-lg text-gray-600">You have not made any purchases yet.</p>
        @else
            <div class="overflow-x-auto bg-white shadow-lg rounded-lg border-t-4 border-indigo-500 max-w-6xl mx-auto">
                <table class="min-w-full table-auto text-sm text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-indigo-100">
                        <tr>
                            <th class="px-6 py-3 border-b text-center">Order ID</th>
                            <th class="px-6 py-3 border-b text-center">Date</th>
                            <th class="px-6 py-3 border-b text-center">Product Name</th>
                            <th class="px-6 py-3 border-b text-center">Quantity</th>
                            <th class="px-6 py-3 border-b text-center">Price</th>
                            <th class="px-6 py-3 border-b text-center">Total Amount</th>
                            <th class="px-6 py-3 border-b text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($purchases as $purchase)
                            <tr class="border-b hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 text-center">{{ $purchase->id }}</td>
                                <td class="px-6 py-4 text-center">{{ $purchase->created_at->format('d-m-Y') }}</td>
                                <td class="px-6 py-4 text-center">{{ $purchase->barang->nama_barang ?? 'N/A' }}</td>
                                <td class="px-6 py-4 text-center">{{ $purchase->jumlah }}</td>
                                <td class="px-6 py-4 text-center">Rp. {{ number_format($purchase->price, 2, ',', '.') }}</td>
                                <td class="px-6 py-4 text-center">Rp. {{ number_format($purchase->total_amount, 2, ',', '.') }}</td>
                                <td class="px-6 py-4 text-center capitalize">{{ $purchase->status }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

    {{-- SUPPLIER VIEW --}}
    @elseif (auth()->user()->role === 'supplier')
        @if ($supplierPurchases->isEmpty())
            <p class="text-center text-lg text-gray-600">No purchases related to your products yet.</p>
        @else
            <div class="overflow-x-auto bg-white shadow-lg rounded-lg border-t-4 border-green-500 max-w-6xl mx-auto">
                <table class="min-w-full table-auto text-sm text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-green-100">
                        <tr>
                            <th class="px-6 py-3 border-b text-center">Order ID</th>
                            <th class="px-6 py-3 border-b text-center">Buyer</th>
                            <th class="px-6 py-3 border-b text-center">Product Name</th>
                            <th class="px-6 py-3 border-b text-center">Quantity</th>
                            <th class="px-6 py-3 border-b text-center">Total</th>
                            <th class="px-6 py-3 border-b text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($supplierPurchases as $purchase)
                            <tr class="border-b hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 text-center">{{ $purchase->id }}</td>
                                <td class="px-6 py-4 text-center">{{ $purchase->user->name ?? 'N/A' }}</td>
                                <td class="px-6 py-4 text-center">{{ $purchase->barang->nama_barang ?? 'N/A' }}</td>
                                <td class="px-6 py-4 text-center">{{ $purchase->jumlah }}</td>
                                <td class="px-6 py-4 text-center">Rp. {{ number_format($purchase->total_amount, 2, ',', '.') }}</td>
                                <td class="px-6 py-4 text-center capitalize">{{ $purchase->status }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

    {{-- ADMIN VIEW --}}
    @elseif (auth()->user()->role === 'admin')
        @if ($allPurchases->isEmpty())
            <p class="text-center text-lg text-gray-600">No purchase data available.</p>
        @else
            <div class="overflow-x-auto bg-white shadow-lg rounded-lg border-t-4 border-blue-500 max-w-6xl mx-auto">
                <table class="min-w-full table-auto text-sm text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-blue-100">
                        <tr>
                            <th class="px-6 py-3 border-b text-center">Order ID</th>
                            <th class="px-6 py-3 border-b text-center">Buyer</th>
                            <th class="px-6 py-3 border-b text-center">Product</th>
                            <th class="px-6 py-3 border-b text-center">Supplier</th>
                            <th class="px-6 py-3 border-b text-center">Price</th>
                            <th class="px-6 py-3 border-b text-center">Quantity</th>
                            <th class="px-6 py-3 border-b text-center">Total</th>
                            <th class="px-6 py-3 border-b text-center">Status</th>
                            <th class="px-6 py-3 border-b text-center">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($allPurchases as $purchase)
                            <tr class="border-b hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 text-center">{{ $purchase->id }}</td>
                                <td class="px-6 py-4 text-center">{{ $purchase->user->name ?? 'N/A' }}</td>
                                <td class="px-6 py-4 text-center">{{ $purchase->barang->nama_barang ?? 'N/A' }}</td>
                                <td class="px-6 py-4 text-center">{{ $purchase->barang->supplier->name ?? 'N/A' }}</td>
                                <td class="px-6 py-4 text-center">Rp. {{ number_format($purchase->price, 2, ',', '.') }}</td>
                                <td class="px-6 py-4 text-center">{{ $purchase->jumlah }}</td>
                                <td class="px-6 py-4 text-center">Rp. {{ number_format($purchase->total_amount, 2, ',', '.') }}</td>
                                <td class="px-6 py-4 text-center capitalize">{{ $purchase->status }}</td>
                                <td class="px-6 py-4 text-center">{{ $purchase->created_at->format('d-m-Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    @endif
</div>
@endsection