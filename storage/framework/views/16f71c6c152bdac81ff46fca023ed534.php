

<?php $__env->startSection('title', 'Purchases Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8 max-w-7xl">
    <h2 class="text-3xl font-extrabold text-center text-gray-800 mb-6">Manajemen Pembelian Pengguna</h2>

    <?php if(session('success')): ?>
        <div class="mb-4 px-4 py-2 text-green-800 bg-green-100 rounded text-center">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <!-- Filter Form -->
    <div class="mb-6 max-w-4xl mx-auto">
        <form id="filterForm" method="GET" action="<?php echo e(route('admin.purchases.management')); ?>" class="flex flex-wrap items-center justify-center gap-4">
            <input type="text" name="buyer" id="buyerInput" placeholder="Cari nama pembeli"
                value="<?php echo e(request('buyer')); ?>"
                class="px-4 py-2 rounded w-40 sm:w-64 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition" />
                
            <div class="relative">
                <select name="status" id="statusSelect"
                    class="appearance-none pl-10 pr-6 py-2 rounded-md bg-white border border-gray-300 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
                    <option value="">Semua Status</option>
                    <option value="completed" <?php echo e(request('status') == 'completed' ? 'selected' : ''); ?>>Completed</option>
                    <option value="pending" <?php echo e(request('status') == 'pending' ? 'selected' : ''); ?>>Pending</option>
                    <option value="cancelled" <?php echo e(request('status') == 'cancelled' ? 'selected' : ''); ?>>Cancelled</option>
                </select>
                <div class="absolute left-2 top-2.5 text-gray-400">
                    <i class="fas fa-filter"></i>
                </div>
            </div>

            <button type="button" id="searchBtn"
                class="flex items-center bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-4 py-2 rounded-md transition">
                <i class="fas fa-search mr-2"></i> Cari
            </button>
            
            <button id="resetBtn" type="button"
                class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold px-4 py-2 rounded-md transition">
                <i class="fas fa-rotate-left mr-1"></i> Reset
            </button>
        </form>
    </div>  

    <?php if($purchases->isEmpty()): ?>
        <p class="text-center text-lg text-gray-600">Tidak ada data pembelian untuk ditampilkan.</p>
    <?php else: ?>
        <div class="overflow-x-auto shadow rounded-lg bg-white bg-opacity-80 border">
            <table class="min-w-full table-auto text-sm text-gray-800">
                <thead class="bg-blue-100 text-xs uppercase font-semibold">
                    <tr>
                        <th class="px-4 py-3 text-center">Order ID</th>
                        <th class="px-4 py-3 text-center">Pembeli</th>
                        <th class="px-4 py-3 text-center">Produk</th>
                        <th class="px-4 py-3 text-center">Supplier</th>
                        <th class="px-4 py-3 text-center">Harga</th>
                        <th class="px-4 py-3 text-center">Jumlah</th>
                        <th class="px-4 py-3 text-center">Total</th>
                        <th class="px-4 py-3 text-center">Status</th>
                        <th class="px-4 py-3 text-center">Tanggal</th>
                        <th class="px-4 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $purchases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $purchase): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="border-t hover:bg-gray-50 bg-opacity-80">
                            <td class="px-4 py-3 text-center"><?php echo e($purchase->id); ?></td>
                            <td class="px-4 py-3 text-center"><?php echo e($purchase->user->name ?? 'N/A'); ?></td>
                            <td class="px-4 py-3 text-center"><?php echo e($purchase->barang->nama_barang ?? 'N/A'); ?></td>
                            <td class="px-4 py-3 text-center"><?php echo e($purchase->barang->supplier->name ?? 'N/A'); ?></td>
                            <td class="px-4 py-3 text-center">Rp <?php echo e(number_format($purchase->price, 2, ',', '.')); ?></td>
                            <td class="px-4 py-3 text-center"><?php echo e($purchase->jumlah); ?></td>
                            <td class="px-4 py-3 text-center">Rp <?php echo e(number_format($purchase->total_amount, 2, ',', '.')); ?></td>
                            <td class="px-4 py-3 text-center">
                                <span class="inline-flex items-center gap-1 px-2 py-1 rounded text-xs font-medium
                                    <?php echo e($purchase->status === 'completed' ? 'bg-green-100 text-green-800' :
                                    ($purchase->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800')); ?>">
                                    <?php if($purchase->status === 'completed'): ?>
                                        <i class="fas fa-check-circle text-green-600"></i>
                                    <?php elseif($purchase->status === 'pending'): ?>
                                        <i class="fas fa-clock text-yellow-600"></i>
                                    <?php else: ?>
                                        <i class="fas fa-times-circle text-red-600"></i>
                                    <?php endif; ?>
                                    <?php echo e(ucfirst($purchase->status)); ?>

                                </span>
                            </td>

                            <td class="px-4 py-3 text-center"><?php echo e($purchase->created_at->format('d-m-Y')); ?></td>

                            <td class="px-4 py-3 text-center">
                                <form method="POST" action="<?php echo e(route('admin.purchase.updateStatus', $purchase->id)); ?>" class="flex items-center justify-center gap-2">
                                    <?php echo csrf_field(); ?>
                                    <select name="status" class="border rounded px-2 py-1 text-sm appearance-none bg-white cursor-pointer">
                                        <option value="completed" <?php echo e($purchase->status === 'completed' ? 'selected' : ''); ?>>Completed</option>
                                        <option value="pending" <?php echo e($purchase->status === 'pending' ? 'selected' : ''); ?>>Pending</option>
                                        <option value="cancelled" <?php echo e($purchase->status === 'cancelled' ? 'selected' : ''); ?>>Cancelled</option>
                                    </select>
                                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm">
                                        Update
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

    <div class="text-center mt-6">
        <a href="<?php echo e(route('barangs.index')); ?>" class="inline-block bg-blue-500 text-white px-6 py-2 rounded-full hover:bg-blue-600 transition duration-300">
            Kembali ke Barang
        </a>
    </div>

    <script>
        document.getElementById('statusSelect').addEventListener('change', updateQuery);
        document.getElementById('searchBtn').addEventListener('click', updateQuery);
        document.getElementById('resetBtn').addEventListener('click', () => {
            document.getElementById('buyerInput').value = '';
            document.getElementById('statusSelect').value = '';
            updateQuery();
        });

        async function updateQuery() {
            const buyer = document.getElementById('buyerInput').value;
            const status = document.getElementById('statusSelect').value;

            const params = new URLSearchParams(window.location.search);
            if (buyer) params.set('buyer', buyer); else params.delete('buyer');
            if (status) params.set('status', status); else params.delete('status');

            window.history.replaceState({}, '', `${location.pathname}?${params.toString()}`);

            try {
                const response = await fetch(`${location.pathname}?${params.toString()}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                const purchases = await response.json();
                updateTable(purchases);
            } catch (error) {
                console.error('Fetch error:', error);
            }
        }

        function updateTable(purchases) {
            const tbody = document.querySelector('table tbody');
            tbody.innerHTML = '';

            if (purchases.length === 0) {
                const tr = document.createElement('tr');
                const td = document.createElement('td');
                td.colSpan = 10;
                td.className = 'text-center text-lg text-gray-600';
                td.textContent = 'Tidak ada data pembelian untuk ditampilkan.';
                tr.appendChild(td);
                tbody.appendChild(tr);
                return;
            }

            purchases.forEach(purchase => {
                const tr = document.createElement('tr');
                tr.className = 'border-t hover:bg-gray-50 bg-opacity-80';

                tr.innerHTML = `
                    <td class="px-4 py-3 text-center">${purchase.id}</td>
                    <td class="px-4 py-3 text-center">${purchase.buyer}</td>
                    <td class="px-4 py-3 text-center">${purchase.product}</td>
                    <td class="px-4 py-3 text-center">${purchase.supplier}</td>
                    <td class="px-4 py-3 text-center">Rp ${purchase.price}</td>
                    <td class="px-4 py-3 text-center">${purchase.quantity}</td>
                    <td class="px-4 py-3 text-center">Rp ${purchase.total}</td>
                    <td class="px-4 py-3 text-center">
                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded text-xs font-medium
                            ${purchase.status === 'completed' ? 'bg-green-100 text-green-800' :
                            (purchase.status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800')}">
                            ${purchase.status === 'completed' ? '<i class="fas fa-check-circle text-green-600"></i>' :
                            (purchase.status === 'pending' ? '<i class="fas fa-clock text-yellow-600"></i>' : '<i class="fas fa-times-circle text-red-600"></i>')}
                            ${purchase.status_label}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-center">${purchase.created_at}</td>
                    <td class="px-4 py-3 text-center">
                        <form method="POST" action="/admin/purchase/updateStatus/${purchase.id}" class="flex items-center justify-center gap-2">
                            <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                            <select name="status" class="border rounded px-2 py-1 text-sm appearance-none bg-white cursor-pointer">
                                <option value="completed" ${purchase.status === 'completed' ? 'selected' : ''}>Completed</option>
                                <option value="pending" ${purchase.status === 'pending' ? 'selected' : ''}>Pending</option>
                                <option value="cancelled" ${purchase.status === 'cancelled' ? 'selected' : ''}>Cancelled</option>
                            </select>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm">
                                Update
                            </button>
                        </form>
                    </td>
                `;
                tbody.appendChild(tr);
            });
        }
    </script>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\HP\laravel\Projek_RPL\resources\views/admin/purchases-management.blade.php ENDPATH**/ ?>