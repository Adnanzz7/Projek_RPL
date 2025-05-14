@extends('layouts.app')

@section('title', 'User Profile')

@section('content')
<div class="py-12 max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
    <section class="bg-white bg-opacity-80 p-6 rounded-xl shadow-md max-w-md mx-auto">
        <header class="mb-6 text-center">
            <h2 class="text-2xl font-semibold text-gray-800">{{ __('User Profile') }}</h2>
        </header>

        <div class="text-center">
            <img src="{{ $user->foto ? Storage::url($user->foto) : 'https://static.vecteezy.com/system/resources/previews/005/129/844/non_2x/profile-user-icon-isolated-on-white-background-eps10-free-vector.jpg' }}" alt="{{ $user->name }}" class="w-32 h-32 rounded-full mx-auto mb-4 object-cover">
            <h3 class="text-xl font-semibold">{{ $user->name }}</h3>
            <p class="text-gray-600">{{ $user->email }}</p>
            <p class="mt-2 text-gray-700">{{ $user->about }}</p>
            @if($user->birth_date)
                <p class="mt-2 text-gray-600">{{ __('Birth Date:') }} {{ \Carbon\Carbon::parse($user->birth_date)->format('d M Y') }}</p>
            @endif
        </div>
    </section>

    <section class="bg-white bg-opacity-80 p-6 rounded-xl shadow-md max-w-4xl mx-auto">
        <header class="mb-6 text-center">
            <h2 class="text-2xl font-semibold text-gray-800">{{ __('Items for Sale') }}</h2>
        </header>

        @if($user->barangs->isEmpty())
            <p class="text-center text-gray-600">{{ __('This user has no items for sale.') }}</p>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                @foreach($user->barangs as $barang)
                    <div class="border rounded-lg p-4 shadow hover:shadow-lg transition-shadow">
                        <img src="{{ $barang->foto_barang ? Storage::url($barang->foto_barang) : 'https://via.placeholder.com/150' }}" alt="{{ $barang->nama_barang }}" class="w-full h-40 object-cover rounded-md mb-4">
                        <h3 class="text-lg font-semibold">{{ $barang->nama_barang }}</h3>
                        <p class="text-gray-600">{{ Str::limit($barang->deskripsi ?? '', 100) }}</p>
                        <p class="mt-2 font-bold text-indigo-600">Rp {{ number_format($barang->harga_barang, 0, ',', '.') }}</p>
                    </div>
                @endforeach
            </div>
        @endif
    </section>
</div>
@endsection
