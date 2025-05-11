@extends('layouts.app')

@section('title', 'Saran dan Kritik')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="{{ asset('css/custom-style.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="max-w-2xl mx-auto px-6 py-12">
    <div class="bg-white bg-opacity-80 shadow-md rounded-lg p-8">
        <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center">
            <i class="bi bi-chat-left-dots-fill text-indigo-600"></i> Saran & Kritik
        </h2>

        @if(session('success'))
            <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded mb-6" role="alert">
                <strong>Terima kasih!</strong> {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('suggestion.store') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                <input type="text" name="nama" id="nama" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" id="email" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
            </div>

            <div>
                <label for="pesan" class="block text-sm font-medium text-gray-700 mb-1">Saran atau Kritik</label>
                <textarea name="pesan" id="pesan" rows="5" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 resize-none" required></textarea>
            </div>

            <div class="flex justify-between items-center space-x-2">
                <div class="flex justify-start w-1/3">
                    <a href="{{ url()->previous() }}" class="inline-flex items-center bg-gray-600 text-white font-semibold px-6 py-2 rounded-lg hover:bg-gray-700 transition">
                        Kembali
                    </a>
                </div>
                <div class="flex justify-center w-1/3">
                    <a href="{{ route('suggestion-list.index') }}" class="inline-flex items-center bg-green-600 text-white font-semibold px-6 py-2 rounded-lg hover:bg-green-700 transition">
                        Lihat Saran
                    </a>
                </div>
                <div class="flex justify-end w-1/3">
                    <button type="submit" class="inline-flex items-center bg-indigo-600 text-white font-semibold px-6 py-2 rounded-lg hover:bg-indigo-700 transition">
                        Kirim
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection