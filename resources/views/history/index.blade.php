@extends('layouts.app')

@section('title', 'Purchase History')

@section('content')
<div class="container mx-auto p-8">
    <h2 class="text-4xl font-extrabold text-center text-gray-800 mb-6">Purchase History</h2>

    <!-- Form Pencarian -->
    <div class="max-w-md mx-auto mb-6">
        <form id="searchForm" method="GET" action="{{ route('purchases.history') }}" class="flex items-center">
            <input type="text" name="search" id="searchInput" placeholder="Search by product, date, status..." value="{{ request('search') }}"
                class="flex-grow px-4 py-2 border rounded-l-md focus:outline-none focus:ring focus:border-blue-300">
            <button type="submit" id="searchBtn"
                class="bg-indigo-600 text-white px-4 py-2 rounded-r-md hover:bg-indigo-700 transition duration-200"><i class="fas fa-search"></i>⠀Search</button>
        </form>
        <div class="mt-4 flex justify-center space-x-4">
            <a href="{{ route('history.exportPdf') }}" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 transition duration-200">Download PDF</a>
            <a href="{{ route('history.exportExcel') }}" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition duration-200">Download Excel</a>
        </div>
    </div>

    {{-- USER VIEW --}}
    @if (auth()->user()->role === 'user')
        @if ($purchases->isEmpty())
            <p class="text-center text-lg text-gray-600">You have not made any purchases yet.</p>
        @else
            <div class="overflow-x-auto bg-white bg-opacity-80 shadow-lg rounded-lg border-t-4 border-indigo-500 max-w-6xl mx-auto">
                <table class="min-w-full table-auto text-sm text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-indigo-100 bg-opacity-80">
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
                            <tr class="border-b hover:bg-gray-50 bg-opacity-80 transition-colors">
                                <td class="px-6 py-4 text-center">{{ $purchase->id }}</td>
                                <td class="px-6 py-4 text-center">{{ $purchase->created_at->format('d M Y') }}</td>
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
            <div class="overflow-x-auto bg-white bg-opacity-80 shadow-lg rounded-lg border-t-4 border-green-500 max-w-6xl mx-auto">
                <table class="min-w-full table-auto text-sm text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-green-100 bg-opacity-80">
                        <tr>
                            <th class="px-6 py-3 border-b text-center">Order ID</th>
                            <th class="px-6 py-3 border-b text-center">Date</th>
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
                                <td class="px-6 py-4 text-center">{{ $purchase->created_at->format('d M Y') }}</td>
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
            <div class="overflow-x-auto bg-white bg-opacity-80 shadow-lg rounded-lg border-t-4 border-red-500 max-w-6xl mx-auto">
                <table class="min-w-full table-auto text-sm text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-red-100 bg-opacity-80">
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
                                <td class="px-6 py-4 text-center">{{ $purchase->created_at->format('d M Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    @endif

    <!-- Tombol Kembali -->
    <div class="text-center mt-6">
        <a href="{{ route('barangs.index') }}" class="inline-block bg-blue-600 text-white px-6 py-2 rounded-full hover:bg-blue-700 transition duration-300">Kembali ke Beranda</a>
    </div>
   
    <script>
        window.userRole = "{{ auth()->user()->role }}";
        document.getElementById('searchForm').addEventListener('submit', async function(event) {
            event.preventDefault();
            const searchValue = document.getElementById('searchInput').value;
            const params = new URLSearchParams();
            if (searchValue) {
                params.set('search', searchValue);
            } else {
                params.delete('search');
            }
            try {
                const response = await fetch(`{{ route('purchases.history') }}?${params.toString()}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                const purchases = await response.json();
                updateTable(purchases);
            } catch (error) {
                console.error('Fetch error:', error);
            }
        });

        function updateTable(purchases) {
            const tbody = document.querySelector('table tbody');
            tbody.innerHTML = '';

            if (purchases.length === 0) {
                const tr = document.createElement('tr');
                const td = document.createElement('td');
                td.colSpan = 9;
                td.className = 'text-center text-lg text-gray-600';
                td.textContent = 'No purchase history found.';
                tr.appendChild(td);
                tbody.appendChild(tr);
                return;
            }

            purchases.forEach(purchase => {
                const tr = document.createElement('tr');
                tr.className = 'border-b hover:bg-gray-50 bg-opacity-80 transition-colors';

                const date = new Date(purchase.created_at).toLocaleDateString('en-GB');
                const price = `Rp. ${Number(purchase.price).toFixed(2).replace('.', ',')}`;
                const total = `Rp. ${Number(purchase.total_amount).toFixed(2).replace('.', ',')}`;
                const product = purchase.barang?.nama_barang ?? 'N/A';
                const status = purchase.status.charAt(0).toUpperCase() + purchase.status.slice(1);

                let row = '';

                if (window.userRole === 'user') {
                    row = `
                        <td class="px-6 py-4 text-center">${purchase.id}</td>
                        <td class="px-6 py-4 text-center">${date}</td>
                        <td class="px-6 py-4 text-center">${product}</td>
                        <td class="px-6 py-4 text-center">${purchase.jumlah}</td>
                        <td class="px-6 py-4 text-center">${price}</td>
                        <td class="px-6 py-4 text-center">${total}</td>
                        <td class="px-6 py-4 text-center">${status}</td>
                    `;
                } else if (window.userRole === 'supplier') {
                    const buyer = purchase.user?.name ?? 'N/A';
                    row = `
                        <td class="px-6 py-4 text-center">${purchase.id}</td>
                        <td class="px-6 py-4 text-center">${date}</td>
                        <td class="px-6 py-4 text-center">${buyer}</td>
                        <td class="px-6 py-4 text-center">${product}</td>
                        <td class="px-6 py-4 text-center">${purchase.jumlah}</td>
                        <td class="px-6 py-4 text-center">${total}</td>
                        <td class="px-6 py-4 text-center">${status}</td>
                    `;
                } else if (window.userRole === 'admin') {
                    const buyer = purchase.user?.name ?? 'N/A';
                    const supplier = purchase.barang?.supplier?.name ?? 'N/A';
                    row = `
                        <td class="px-6 py-4 text-center">${purchase.id}</td>
                        <td class="px-6 py-4 text-center">${buyer}</td>
                        <td class="px-6 py-4 text-center">${product}</td>
                        <td class="px-6 py-4 text-center">${supplier}</td>
                        <td class="px-6 py-4 text-center">${price}</td>
                        <td class="px-6 py-4 text-center">${purchase.jumlah}</td>
                        <td class="px-6 py-4 text-center">${total}</td>
                        <td class="px-6 py-4 text-center">${status}</td>
                        <td class="px-6 py-4 text-center">${date}</td>
                    `;
                }

                tr.innerHTML = row;
                tbody.appendChild(tr);
            });
        }
    </script>
</div>
@endsection
