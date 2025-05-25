<section class="bg-white p-6 rounded-2xl shadow space-y-6">
    <h3 class="text-xl font-bold text-gray-800">Panel Admin</h3>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <a href="{{ route('suggestion-list.index') }}" class="bg-indigo-600 text-white p-6 rounded-xl shadow hover:bg-indigo-700 transition">
            <i class="bi bi-chat-dots-fill text-2xl"></i>
            <h4 class="mt-2 font-bold no-underline">Saran & Kritik</h4>
        </a>
        <a href="{{ route('barangs.index') }}" class="bg-pink-600 text-white p-6 rounded-xl shadow hover:bg-pink-700 transition">
            <i class="bi bi-box-seam text-2xl"></i>
            <h4 class="mt-2 font-bold no-underline">Kelola Produk</h4>
        </a>
        <a href="{{ route('admin.purchases.management') }}" class="bg-green-600 text-white p-6 rounded-xl shadow hover:bg-green-700 transition">
            <i class="bi bi-clock-history text-2xl"></i>
            <h4 class="mt-2 font-bold no-underline">Riwayat Pembelian</h4>
        </a>
    </div>
</section>