<section class="bg-white bg-opacity-80 p-6 rounded-2xl shadow space-y-4">
    <h3 class="text-xl font-bold text-gray-800 mb-4">Wishlist Saya</h3>
    @if ($user->wishlist->isEmpty())
        <p class="text-gray-500">Belum ada produk di wishlist.</p>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach ($user->wishlist as $item)
                <div class="relative bg-white border rounded-2xl shadow-md overflow-hidden hover:shadow-lg transition-all duration-300 flex flex-col transform ease-in-out">
                    <div class="relative">
                        @if ($item->foto_barang)
                            <img src="{{ Storage::url($item->foto_barang) }}" class="w-full h-48 object-cover" alt="{{ $item->nama_barang }}">
                        @else
                            <div class="w-full h-48 flex items-center justify-center bg-gray-200 text-gray-500 italic">Tidak ada gambar</div>
                        @endif
                        <div class="absolute top-2 left-2">
                            <span class="text-xs font-medium px-3 py-1 rounded-full 
                                {{ $item->jumlah_barang > 0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ $item->jumlah_barang > 0 ? 'Tersedia' : 'Habis' }}
                            </span>
                        </div>
                    </div>

                    <div class="p-4 flex flex-col justify-between flex-1">
                        <h4 class="text-2xl font-bold text-gray-900 mb-2 truncate" title="{{ $item->nama_barang ?? 'Produk tidak ditemukan' }}">
                            {{ $item->nama_barang ?? 'Produk tidak ditemukan' }}
                        </h4>
                        <p class="text-pink-600 font-semibold text-xl mb-1">Rp {{ number_format($item->harga_barang ?? 0, 0, ',', '.') }}</p>
                        <p class="text-gray-500 text-sm mb-4">
                            <a href="{{ route('wishlist.index', $item->id) }}" class="text-gray-500 no-underline hover:underline">Lihat Detail</a>
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</section>