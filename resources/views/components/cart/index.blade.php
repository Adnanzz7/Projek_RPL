@extends('layouts.app')

@section('title', 'Keranjang')

@section('content')
<style>
    /* Gaya untuk tabel keranjang */
    .cart-table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
        font-size: 1rem;
        text-align: left;
    }

    .cart-table th, .cart-table td {
        border: 1px solid #ddd;
        padding: 12px;
    }

    .cart-table th {
        background-color: #f4f4f4;
        color: #333;
        font-weight: bold;
    }

    .cart-table tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .cart-table tr:hover {
        background-color: #f1f1f1;
    }

    /* Tombol di tabel */
    .btn {
        padding: 8px 15px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 0.9rem;
        text-align: center;
        text-decoration: none;
    }

    .btn-outline-secondary {
        background-color: #e9ecef;
        color: #333;
        border: 1px solid #ced4da;
    }

    .btn-outline-secondary:hover {
        background-color: #ced4da;
    }

    .btn-danger {
        background-color: #dc3545;
        color: #fff;
    }

    .btn-danger:hover {
        background-color: #c82333;
    }

    /* Tombol checkout */
    .checkout-container {
        margin-top: 20px;
        text-align: right;
    }

    .btn-checkout {
        background-color: #28a745;
        color: white;
        font-weight: bold;
        text-transform: uppercase;
        padding: 12px 20px;
        font-size: 1rem;
        border: none;
        border-radius: 5px;
        transition: background-color 0.3s ease, transform 0.3s ease;
    }

    .btn-checkout:hover {
        background-color: #218838;
        transform: translateY(-2px);
    }

    .total-price {
        font-size: 1.2rem;
        font-weight: bold;
        margin-right: 10px;
        color: #333;
    }

    /* Tombol Kembali */
    .btn-back {
        background-color: #007bff;
        color: white;
        padding: 10px 20px;
        border-radius: 5px;
        text-decoration: none;
        font-weight: bold;
        text-transform: uppercase;
    }

    .btn-back:hover {
        background-color: #0056b3;
    }

    .btn-container {
        text-align: left;
        margin-top: 20px;
    }
</style>

<table class="cart-table">
    <thead>
        <tr>
            <th>Nama Barang</th>
            <th>Harga</th>
            <th>Jumlah</th>
            <th>Total</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @if (count($cartItems) > 0)
            @foreach ($cartItems as $id => $item)
                <tr>
                    <td>{{ $item['name'] ?? 'Nama Tidak Tersedia' }}</td>
                    <td>Rp. {{ number_format($item['price'] ?? 0, 2) }}</td>
                    <td>
                        <form action="{{ route('cart.update', $id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('PATCH')
                            <input type="number" name="quantity" value="{{ $item['quantity'] ?? 1 }}" min="1" max="100">
                            <button type="submit" class="btn btn-outline-secondary">Ubah</button>
                        </form>
                    </td>
                    <td>Rp. {{ number_format(($item['price'] ?? 0) * ($item['quantity'] ?? 1), 2) }}</td>
                    <td>
                        <form action="{{ route('cart.remove') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $id }}">
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="5">Keranjang Anda kosong. Silakan tambahkan barang ke keranjang.</td>
            </tr>
        @endif
    </tbody>
</table>

@if (count($cartItems) > 0)
    <div class="checkout-container">
        <span class="total-price">Total Harga: Rp. {{ number_format($total, 2) }}</span>
        <a href="{{ route('cart.checkout') }}" class="btn btn-checkout">Checkout</a>
    </div>

@endif

    <div class="btn-container">
        <a href="{{ route('barangs.index') }}" class="btn btn-back">Kembali</a>
    </div>
@endsection