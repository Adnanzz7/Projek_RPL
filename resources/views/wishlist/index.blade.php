<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Favorit') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Daftar Produk Favorit</h3>
                <ul class="list-disc pl-6">
                    @forelse ($wishlistItems as $item)
                        <li>{{ $item['nama'] }} - Rp{{ number_format($item['harga'], 0, ',', '.') }}</li>
                    @empty
                        <li>Tidak ada produk favorit.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>