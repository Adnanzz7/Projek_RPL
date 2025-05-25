@extends('layouts.app')

@section('title', 'Edit Barang')

@section('content')
<div class="min-h-screen bg-cover bg-center">
    <div class="flex justify-center items-center h-full py-5">
        <div class="bg-white bg-opacity-80 p-8 rounded-xl shadow-lg max-w-2xl w-full">
            <div class="text-center py-4 mb-6">
                <h2 class="text-3xl font-bold text-primary">Edit Barang</h2>
            </div>
            
            <form action="{{ route('barangs.update', $barang) }}" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
                @csrf
                @method('PUT')

                <!-- Nama Barang -->
                <div class="mb-4">
                    <label for="nama_barang" class="block text-lg font-semibold text-gray-700">Nama Barang</label>
                    <input type="text" name="nama_barang" id="nama_barang" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-full shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" 
                           value="{{ old('nama_barang', $barang->nama_barang) }}" required>
                </div>

                <!-- Kategori -->
                <div class="mb-4">
                    <label for="kategori_barang" class="block text-lg font-semibold text-gray-700">Kategori</label>
                    <select id="kategori_barang" name="kategori_barang" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-full shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="" disabled {{ old('kategori_barang') ? '' : 'selected' }}>Pilih Kategori</option>
                        <option value="makanan" {{ old('kategori_barang') === 'makanan' ? 'selected' : '' }}>Makanan</option>
                        <option value="kerajinan" {{ old('kategori_barang') === 'kerajinan' ? 'selected' : '' }}>Kerajinan</option>
                    </select>
                    @error('kategori')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
                </div>

                <!-- Harga Barang -->
                <div class="mb-4">
                    <label for="harga_barang" class="block text-lg font-semibold text-gray-700">Harga Barang</label>
                    <input type="number" name="harga_barang" id="harga_barang" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-full shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" 
                           value="{{ old('harga_barang', $barang->harga_pokok + 1500) }}" required oninput="updateHarga(); updateHargaWeb();">
                    {{-- <small class="text-sm text-gray-500">Harga sebelum retribusi</small> --}}
                </div>

                <!-- Harga Setelah Retribusi -->
                {{-- <div class="mb-4">
                    <label for="harga_dengan_retribusi" class="block text-lg font-semibold text-gray-700">Harga Setelah Retribusi</label>
                    <input type="text" id="harga_dengan_retribusi" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-full shadow-sm bg-gray-100 text-gray-600" 
                           readonly value="{{ old('harga_dengan_retribusi', $barang->harga_pokok + 2000) }}">
                    <small class="text-sm text-gray-500">Harga setelah retribusi (Rp. 1000)</small>
                </div> --}}

                <!-- Harga Setelah Jasa Web -->
                {{-- <div class="mb-4">
                    <label for="harga_dengan_web" class="block text-lg font-semibold text-gray-700">Harga Setelah Jasa Web</label>
                    <input type="text" id="harga_dengan_web" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-full shadow-sm bg-gray-100 text-gray-600" 
                           readonly value="{{ old('harga_dengan_web', $barang->harga_pokok + 2500) }}">
                    <small class="text-sm text-gray-500">Harga setelah jasa web (Rp. 1500)</small>
                </div> --}}

                <!-- Jumlah Barang -->
                <div class="mb-4">
                    <label for="jumlah_barang" class="block text-lg font-semibold text-gray-700">Jumlah Barang</label>
                    <input type="number" name="jumlah_barang" id="jumlah_barang" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-full shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" 
                           value="{{ old('jumlah_barang', $barang->jumlah_barang) }}" required>
                </div>

                <!-- Upload Foto Barang dengan Drag & Drop & Preview Samping -->
                <div x-data="{ isDragging: false, fileName: '', previewUrl: '{{ asset('storage/' . $barang->foto_barang) }}' }" class="mb-6">
                    <label for="foto_barang" class="block text-lg font-semibold text-gray-700 mb-2">Foto Barang</label>

                    <div class="flex flex-col md:flex-row gap-6 items-start">
                        <!-- Drop Area -->
                        <div class="flex-1 w-full p-6 border-2 border-dashed rounded-xl bg-white transition-all text-center"
                            :class="isDragging ? 'border-blue-500 bg-blue-50' : 'border-gray-300'"
                            @dragover.prevent="isDragging = true"
                            @dragleave.prevent="isDragging = false"
                            @drop.prevent="isDragging = false"
                            @drop="previewUrl = URL.createObjectURL($event.dataTransfer.files[0]); $refs.foto_barang.files = $event.dataTransfer.files">

                            <input type="file" name="foto_barang" id="foto_barang" x-ref="foto_barang" accept="image/*"
                                class="hidden"
                                @change="fileName = $event.target.files[0]?.name; previewUrl = URL.createObjectURL($event.target.files[0])" />

                            <label for="foto_barang" class="flex flex-col items-center justify-center h-40 cursor-pointer">
                                <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-2"></i>
                                <span class="text-sm text-gray-600" x-text="fileName || 'Seret file ke sini atau klik untuk unggah'"></span>
                            </label>
                        </div>

                        <!-- Preview -->
                        <div class="w-50 h-50 overflow-hidden">
                            <p class="text-base font-semibold text-gray-800 mb-1">Pratinjau Foto:</p>
                            <img :src="previewUrl" alt="Preview" class="w-40 h-40 object-cover rounded-lg">
                        </div>
                    </div>
                </div>

                <!-- Keterangan (Opsional) -->
                <div class="mb-4">
                    <label for="keterangan_barang" class="block text-lg font-semibold text-gray-700">Keterangan (Opsional)</label>
                    <textarea name="keterangan_barang" id="keterangan_barang" rows="4" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none" 
                            placeholder="Tambahkan informasi tambahan tentang barang">{{ old('keterangan_barang', $barang->keterangan_barang) }}</textarea>
                </div>

                <!-- Tombol Kembali dan Update -->
                <div class="flex justify-between mt-6 space-x-4">
                    <a href="{{ route('barangs.index') }}" class="bg-gray-600 text-white px-6 py-3 rounded-full text-lg font-semibold hover:bg-gray-700 focus:ring-2 focus:ring-blue-500 transition transform hover:scale-105">
                        <i class="bi bi-arrow-left-circle"></i> Kembali
                    </a>
                    <button type="submit" class="bg-green-600 text-white px-6 py-3 rounded-full text-lg font-semibold hover:bg-green-700 focus:ring-2 focus:ring-blue-500 transition transform hover:scale-105">
                        <i class="bi bi-save"></i> Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // function updateHarga() {
    //     var hargaBarang = parseFloat(document.getElementById('harga_barang').value);
    //     var retribusi = 1000;
    //     var hargaDenganRetribusi = hargaBarang + retribusi;
    //     document.getElementById('harga_dengan_retribusi').value = hargaDenganRetribusi.toFixed(0);
    // }

    // function updateHargaWeb() {
    //     var hargaDenganRetribusi = parseFloat(document.getElementById('harga_dengan_retribusi').value);
    //     var jasaWeb = 500;
    //     var hargaDenganJasaWeb = hargaDenganRetribusi + jasaWeb;
    //     document.getElementById('harga_dengan_web').value = hargaDenganJasaWeb.toFixed(0);
    // }

    function validateForm() {
        var hargaBarang = parseFloat(document.getElementById('harga_barang').value);
        var jumlahBarang = parseInt(document.getElementById('jumlah_barang').value);

        if (hargaBarang < 0) {
            alert("Harga barang tidak boleh kurang dari 0");
            return false;
        }

        if (jumlahBarang < 1) {
            alert("Jumlah barang tidak boleh kurang dari 1");
            return false;
        }

        return true;
    }
</script>

@endsection