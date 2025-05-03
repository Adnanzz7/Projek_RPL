

<?php $__env->startSection('title', 'Tambah Barang'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-cover bg-center">
    <div class="flex justify-center items-center h-full py-5">
        <div class="bg-white bg-opacity-80 p-8 rounded-xl shadow-lg max-w-2xl w-full">
            <h1 class="text-3xl font-semibold text-center text-gray-800 mb-8">Tambah Barang</h1>
            <form action="<?php echo e(route('barangs.store')); ?>" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
                <?php echo csrf_field(); ?>

                <!-- Nama Barang -->
                <div class="mb-4">
                    <label for="nama_barang" class="block text-lg font-semibold text-gray-700">Nama Barang</label>
                    <input type="text" name="nama_barang" id="nama_barang" class="w-full px-4 py-3 border border-gray-300 rounded-full shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" value="<?php echo e(old('nama_barang')); ?>" required>
                </div>

                <!-- Kategori -->
                <div class="mb-4">
                    <label for="kategori_barang" class="block text-lg font-semibold text-gray-700">Kategori</label>
                    <select id="kategori_barang" name="kategori_barang" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-full shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="" disabled <?php echo e(old('kategori_barang') ? '' : 'selected'); ?>>Pilih Kategori</option>
                        <option value="makanan" <?php echo e(old('kategori_barang') === 'makanan' ? 'selected' : ''); ?>>Makanan</option>
                        <option value="kerajinan" <?php echo e(old('kategori_barang') === 'kerajinan' ? 'selected' : ''); ?>>Kerajinan</option>
                    </select>
                    <?php $__errorArgs = ['kategori'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="text-red-600 text-sm"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Harga Barang -->
                <div class="mb-4">
                    <label for="harga_barang" class="block text-lg font-semibold text-gray-700">Harga Barang</label>
                    <input type="number" name="harga_barang" id="harga_barang" class="w-full px-4 py-3 border border-gray-300 rounded-full shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" value="<?php echo e(old('harga_barang')); ?>" required oninput="updateHarga()">
                    <small class="text-sm text-gray-500">Belum termasuk retribusi sebesar Rp. 1000</small>
                </div>

                <!-- Harga Setelah Retribusi -->
                <div class="mb-4">
                    <label for="harga_dengan_retribusi" class="block text-lg font-semibold text-gray-700">Harga Setelah Retribusi</label>
                    <input type="text" id="harga_dengan_retribusi" class="w-full px-4 py-3 border border-gray-300 rounded-full shadow-sm bg-gray-100 text-gray-600" readonly value="<?php echo e(old('harga_barang')); ?>">
                </div>

                <!-- Harga Setelah Jasa Web -->
                <div class="mb-4">
                    <label for="harga_dengan_web" class="block text-lg font-semibold text-gray-700">Harga Setelah Jasa Web</label>
                    <input type="text" id="harga_dengan_web" class="w-full px-4 py-3 border border-gray-300 rounded-full shadow-sm bg-gray-100 text-gray-600" readonly value="<?php echo e(old('harga_barang')); ?>">
                </div>

                <!-- Jumlah Barang -->
                <div class="mb-4">
                    <label for="jumlah_barang" class="block text-lg font-semibold text-gray-700">Jumlah Barang</label>
                    <input type="number" name="jumlah_barang" id="jumlah_barang" class="w-full px-4 py-3 border border-gray-300 rounded-full shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" value="<?php echo e(old('jumlah_barang')); ?>" required>
                </div>

                <!-- Foto Barang -->
                <div class="mb-4">
                    <label for="foto_barang" class="block text-lg font-semibold text-gray-700">Foto Barang</label>
                    <input type="file" name="foto_barang" id="foto_barang" class="w-full px-4 py-3 border bg-white border-gray-300 rounded-full shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>

                <!-- Keterangan (Opsional) -->
                <div class="mb-4">
                    <label for="keterangan_barang" class="block text-lg font-semibold text-gray-700">Keterangan (Opsional)</label>
                    <textarea name="keterangan_barang" id="keterangan_barang" rows="4" class="w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none" placeholder="Tambahkan keterangan tentang barang"><?php echo e(old('keterangan_barang')); ?></textarea>
                </div>

                <!-- Tombol Kembali dan Simpan -->
                <div class="flex justify-between mt-6 space-x-4">
                    <button type="button" class="bg-gray-600 text-white px-6 py-3 rounded-full text-lg font-semibold hover:bg-gray-700 focus:ring-2 focus:ring-blue-500 transition transform hover:scale-105" onclick="history.back()">Kembali</button>
                    <button type="submit" class="bg-green-600 text-white px-6 py-3 rounded-full text-lg font-semibold hover:bg-green-700 focus:ring-2 focus:ring-blue-500 transition transform hover:scale-105">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function updateHarga() {
        var hargaBarang = document.getElementById('harga_barang').value;
        var retribusi = 1000;  
        var jasaWeb = 500;  
        
        var hargaDenganRetribusi = parseFloat(hargaBarang) + retribusi;
        document.getElementById('harga_dengan_retribusi').value = hargaDenganRetribusi;

        var hargaDenganJasaWeb = hargaDenganRetribusi + jasaWeb;
        document.getElementById('harga_dengan_web').value = hargaDenganJasaWeb;
    }

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

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\HP\laravel\Projek_RPL\resources\views/barangs/create.blade.php ENDPATH**/ ?>