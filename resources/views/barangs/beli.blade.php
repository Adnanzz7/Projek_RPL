@extends('layouts.app')

@section('title', 'Konfirmasi Pembelian')

@section('content')
<style>
        body {
        background-image: url('storage/bg.jpg');
        background-size: cover;
        background-repeat: repeat;
        background-position: center;
    }

    /* Styling untuk kontainer utama */
    .container {
        margin-top: 50px;
        font-family: 'Arial', sans-serif;
    }

    /* Styling untuk card yang berisi informasi konfirmasi pembelian */
    .card {
        border-radius: 10px; /* Membuat sudut card lebih melengkung */
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); /* Menambahkan bayangan lebih halus */
        padding: 30px;
        background-color: #fff;
        animation: fadeIn 1s ease-in-out; /* Animasi fadeIn untuk card */
    }

    /* Animasi untuk card */
    @keyframes fadeIn {
        0% { opacity: 0; transform: translateY(20px); }
        100% { opacity: 1; transform: translateY(0); }
    }

    /* Styling untuk gambar QR Code */
    .card img {
        border: 3px solid #4CAF50; /* Menambahkan border hijau di sekitar QR Code */
        border-radius: 10px; /* Sudut border QR Code melengkung */
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Shadow untuk gambar QR Code */
        max-width: 300px;
        height: auto;
        margin: 20px auto; /* Menempatkan gambar di tengah */
        display: block;
        animation: zoomIn 1s ease-in-out; /* Animasi zoomIn untuk QR Code */
    }

    /* Animasi untuk gambar QR Code */
    @keyframes zoomIn {
        0% { transform: scale(0.8); opacity: 0; }
        100% { transform: scale(1); opacity: 1; }
    }

    /* Styling untuk tombol selesai */
    .btn-secondary {
        background-color: #4CAF50; /* Mengubah warna tombol menjadi hijau */
        color: white;
        border-radius: 5px;
        padding: 10px 20px;
        text-decoration: none;
        text-align: center;
        font-weight: bold;
        transition: background-color 0.3s ease, transform 0.3s ease; /* Tambahkan efek transisi */
    }

    /* Hover effect untuk tombol */
    .btn-secondary:hover {
        background-color: #45a049; /* Warna hijau sedikit lebih gelap saat di-hover */
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        transform: translateY(-3px); /* Efek tombol terangkat sedikit */
    }

    /* Styling untuk judul dan elemen lainnya */
    .card-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: #333;
    }

    .card p {
        font-size: 1.1rem;
        color: #555;
        margin-bottom: 15px;
    }

    h6 {
        font-size: 1rem;
        font-weight: 500;
        color: #333;
        margin-bottom: 20px;
    }
</style>

<div class="container">
    <h2 class="text-center mb-4">Konfirmasi Pembelian</h2>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Nama Barang: {{ $barang->nama_barang }}</h5>
            <p>Jumlah yang Dibeli: {{ $jumlah }}</p>
            <p>Total Harga: Rp. {{ number_format($totalHarga, 2) }}</p>

            <!-- Slot untuk memasukkan QR code -->
            <div class="mt-4">
                <h6 class="text-center">QR Code Pembayaran</h6>
                <!-- Tempat untuk gambar QR code yang akan Anda masukkan -->
                <img src="{{ asset('storage/QR.png') }}" alt="QR Code">
                <!-- Jika Anda ingin menggunakan slot QR khusus, sesuaikan dengan penyimpanan gambar QR Anda -->
            </div>
            <div class="mt-4 text-center">
                <a href="{{ route('barangs.index') }}" class="btn btn-secondary">Selesai</a>
            </div>
        </div>
    </div>
</div>
@endsection
