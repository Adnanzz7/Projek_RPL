<?php $__env->startSection('title', 'Checkout'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-cover bg-center">
    <div class="container mx-auto py-12 px-6">
        <div class="max-w-4xl mx-auto bg-white bg-opacity-90 shadow-lg rounded-lg p-8">
            
            <!-- Header -->
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-8">Checkout</h2>

            <!-- Detail Pembelian -->
            <div class="mb-6 space-y-2">
                <h5 class="text-xl font-semibold text-gray-700">Detail Pembelian</h5>
                <p>Atas Nama: <span class="font-bold"><?php echo e(Auth::user()->name); ?></span></p>
                <p>ID Pelanggan: <span class="font-bold"><?php echo e(Auth::user()->id); ?></span></p>
                <p>ID Pesanan: <span class="font-bold"><?php echo e($order['id'] ?? 'N/A'); ?></span></p>
            </div>

            <!-- Tabel Belanja -->
            <table class="table-auto w-full text-left border-collapse mb-6">
                <thead>
                    <tr class="bg-gray-200 text-gray-700">
                        <th class="px-4 py-2">Nama Barang</th>
                        <th class="px-4 py-2">Harga Satuan</th>
                        <th class="px-4 py-2">Jumlah</th>
                        <th class="px-4 py-2">Total Harga</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $cartItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="border-b">
                        <td class="px-4 py-2"><?php echo e($item['name']); ?></td>
                        <td class="px-4 py-2">Rp. <?php echo e(number_format($item['price'], 2, ',', '.')); ?></td>
                        <td class="px-4 py-2"><?php echo e($item['quantity']); ?></td>
                        <td class="px-4 py-2">Rp. <?php echo e(number_format($item['price'] * $item['quantity'], 2, ',', '.')); ?></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>

            <div class="text-right mb-8">
                <h6 class="text-xl font-semibold text-gray-700">
                    Total Semua: <span class="text-green-500 font-bold">Rp. <?php echo e(number_format($totalHarga, 2, ',', '.')); ?></span>
                </h6>
            </div>

            <!-- Metode Pembayaran -->
            <div class="mt-8">
                <h5 class="text-xl font-semibold text-gray-700 mb-4">Pilih Metode Pembayaran</h5>
                <div class="flex gap-4">
                    <button id="qrisBtn" type="button" class="btn-payment bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded focus:outline-none">QRIS</button>
                    <button id="cashBtn" type="button" class="btn-payment bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded focus:outline-none">Cash</button>
                </div>
                <p id="cashMessage" class="mt-2 text-red-600 font-semibold hidden">Silahkan melakukan pembayaran di kasir</p>

                <!-- QRIS QRCode -->
                <div id="paymentDetails" class="hidden mt-6">
                    <h6 class="text-lg font-semibold text-gray-700">QRIS Pembayaran</h6>
                    <div class="flex justify-center">
                        <img src="<?php echo e(asset('storage/QRIS.jpg')); ?>" alt="QRIS" class="qr-image w-56 h-auto border-4 border-green-500 rounded-md shadow-md animate-pulse">
                    </div>
                </div>
            </div>

            <!-- Tombol -->
            <div class="mt-8 flex justify-between">
                <form action="<?php echo e(route('cart.cancel')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="btn-danger bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded focus:outline-none" onclick="return confirm('Batalkan pesanan ini?')">Batal</button>
                </form>

                <form id="checkoutForm" action="<?php echo e(route('cart.completeCheckout')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="payment_method" id="paymentMethodInput" value="">
                    <button type="submit" class="btn-success bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded focus:outline-none" onclick="return validatePaymentForm(event) && confirm('Apakah pembayaran sudah dilakukan?')">Selesai</button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .btn-payment, .btn-option {
        @apply px-6 py-2 text-white font-semibold rounded-lg transition-colors duration-300;
        @apply bg-blue-500 hover:bg-blue-600 active:bg-blue-700;
    }

    .btn-payment.active, .btn-option.active {
        @apply bg-green-500;
    }

    .btn-danger {
        @apply px-6 py-2 font-semibold text-white rounded-lg bg-red-500 hover:bg-red-600;
    }

    .btn-success {
        @apply px-6 py-2 font-semibold text-white rounded-lg bg-green-500 hover:bg-green-600;
    }

    .qr-image {
        @apply w-48 h-auto mx-auto mt-4 rounded-lg border-4 border-green-500 shadow-lg;
    }

    @keyframes pulse {
        0% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.05);
        }
        100% {
            transform: scale(1);
        }
    }
</style>

<script>
    // Fungsi untuk memilih metode pembayaran
    function selectPaymentMethod(method) {
        const paymentDetails = document.getElementById('paymentDetails');
        document.getElementById('qrisBtn').classList.toggle('active', method === 'qris');
        document.getElementById('cashBtn').classList.toggle('active', method === 'cash');
        paymentDetails.classList.toggle('hidden', method !== 'qris');

        // Set hidden input value for payment method
        document.getElementById('paymentMethodInput').value = method;

        // Show or hide cash payment message
        const cashMessage = document.getElementById('cashMessage');
        if (method === 'cash') {
            cashMessage.classList.remove('hidden');
        } else {
            cashMessage.classList.add('hidden');
        }
    }

    // Tambahkan event listener untuk tombol
    document.getElementById('qrisBtn').addEventListener('click', () => selectPaymentMethod('qris'));
    document.getElementById('cashBtn').addEventListener('click', () => selectPaymentMethod('cash'));

    function validatePaymentForm(event) {
        if (!document.querySelector('.btn-payment.active')) {
            event.preventDefault();
            alert('Pilih metode pembayaran terlebih dahulu.');
        }
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\HP\Laravel\Projek_RPL\resources\views/cart/checkout.blade.php ENDPATH**/ ?>