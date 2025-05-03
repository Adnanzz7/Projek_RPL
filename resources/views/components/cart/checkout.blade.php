@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<style>
    /* Tambahkan gaya sesuai kebutuhan */
    .qr-code {
        width: 200px;
        height: auto;
        margin: 0 auto;
        display: block;
        border: 3px solid #4CAF50;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .container {
        margin-top: 50px;
    }

    .card {
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        padding: 20px;
        background-color: #fff;
    }

    .btn-secondary {
        background-color: #4CAF50;
        color: white;
        border-radius: 5px;
        padding: 10px 20px;
        text-decoration: none;
        transition: background-color 0.3s ease, transform 0.3s ease;
    }

    .btn-secondary:hover {
        background-color: #45a049;
        transform: translateY(-3px);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    .btn-danger {
        background-color: #f44336;
        color: white;
        border-radius: 5px;
        padding: 10px 20px;
        text-decoration: none;
        transition: background-color 0.3s ease, transform 0.3s ease;
    }

    .btn-danger:hover {
        background-color: #e53935;
        transform: translateY(-3px);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }
</style>

<div class="container">
    <h2 class="text-center mb-4">Checkout</h2>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Detail Pembelian</h5>

            <table class="table">
                <thead>
                    <tr>
                        <th>Nama Barang</th>
                        <th>Harga Satuan</th>
                        <th>Jumlah</th>
                        <th>Total Harga</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cartItems as $item)
                        <tr>
                            <td>{{ $item['name'] }}</td>
                            <td>Rp. {{ number_format($item['price'], 2) }}</td>
                            <td>{{ $item['quantity'] }}</td>
                            <td>Rp. {{ number_format($item['price'] * $item['quantity'], 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <h6 class="text-right">Total Semua: <b>Rp. {{ number_format($totalHarga, 2) }}</b></h6>

            <div class="mt-4 text-center">
                <h6 class="text-center">QR Code Pembayaran</h6>
                <img src="{{ asset('storage/QR.png') }}" alt="QR Code" class="qr-code">
            </div>
            <div class="mt-4 text-center">
                <form action="{{ route('cart.complete') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-secondary">Selesai</button>
                </form>

                <!-- Tombol Batal -->
                <form action="{{ route('cart.cancel') }}" method="POST" class="mt-3">
                    @csrf
                    <button type="submit" class="btn btn-danger">Batal</button>
                </form>
            </div> 
        </div>
    </div>
</div>

@endsection
