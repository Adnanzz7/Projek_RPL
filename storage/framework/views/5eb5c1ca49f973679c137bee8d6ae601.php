<?php $__env->startSection('title', 'Purchases Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8 max-w-7xl">
    <h2 class="text-3xl font-extrabold text-center text-gray-800 mb-6">Manajemen Pembelian Pengguna</h2>

    <?php if(session('success')): ?>
        <div class="mb-4 px-4 py-2 text-green-800 bg-green-100 rounded text-center">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <!-- Filter Form Gabungan -->
    <div class="mb-6 max-w-4xl mx-auto">
        <form id="filterForm" method="GET" action="<?php echo e(route('admin.purchases.management')); ?>" class="flex items-center justify-center gap-4 flex-wrap">
            <div class="flex rounded-md shadow-sm">
                <!-- Input Nama Pembeli -->
                <input type="text" name="buyer" id="buyerInput" placeholder="Cari nama pembeli"
                    value="<?php echo e(request('buyer')); ?>"
                    class="px-4 py-2 rounded-l-md w-40 sm:w-64 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition border border-r-0 border-gray-300" />
                
                <!-- Tombol Filter -->
                <div class="relative inline-block text-left">
                    <button type="button" id="filterBtn" aria-haspopup="true" aria-expanded="false"
                        class="bg-indigo-600 text-white px-4 py-2 rounded-r-md hover:bg-indigo-700 transition duration-200 inline-flex items-center">
                        <i class="fas fa-filter mr-2"></i> Filter
                        <svg class="ml-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <!-- Dropdown Status -->
                    <div id="filterDropdown" class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 hidden z-10">
                        <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="filterBtn">
                            <a href="#" data-value="" class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-100 cursor-pointer" role="menuitem">Semua Status</a>
                            <a href="#" data-value="completed" class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-100 cursor-pointer" role="menuitem">Completed</a>
                            <a href="#" data-value="pending" class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-100 cursor-pointer" role="menuitem">Pending</a>
                            <a href="#" data-value="cancelled" class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-100 cursor-pointer" role="menuitem">Cancelled</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Hidden input untuk status -->
            <input type="hidden" name="status" id="hiddenStatus" value="<?php echo e(request('status')); ?>">

            <button type="submit"
                class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition duration-200 flex items-center">
                <i class="fas fa-search mr-2"></i> Search
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

                            <td class="px-4 py-3 text-center"><?php echo e($purchase->created_at->format('d M Y')); ?></td>

                            <td class="px-4 py-3 text-center">
                                <form method="POST" action="<?php echo e(route('admin.purchase.updateStatus', $purchase->id)); ?>" class="flex items-center justify-center gap-2 status-update-form">
                                    <?php echo csrf_field(); ?>
                                    <select name="status" class="border rounded px-2 py-1 text-sm appearance-none bg-white cursor-pointer custom-select-no-arrow text-center">
                                        <option value="completed" <?php echo e($purchase->status === 'completed' ? 'selected' : ''); ?>>Completed</option>
                                        <option value="pending" <?php echo e($purchase->status === 'pending' ? 'selected' : ''); ?>>Pending</option>
                                        <option value="cancelled" <?php echo e($purchase->status === 'cancelled' ? 'selected' : ''); ?>>Cancelled</option>
                                    </select>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

    <div class="text-center mt-6">
        <a href="<?php echo e(route('barangs.index')); ?>" class="inline-block bg-blue-600 text-white px-6 py-2 rounded-full hover:bg-blue-700 transition duration-300"> Kembali ke Beranda</a>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const filterBtn = document.getElementById('filterBtn');
            const filterDropdown = document.getElementById('filterDropdown');
            const buyerInput = document.getElementById('buyerInput');
            const statusInput = document.getElementById('statusSelect');
            const searchBtn = document.getElementById('searchBtn');
            const resetBtn = document.getElementById('resetBtn');
            const hiddenStatus = document.getElementById('hiddenStatus');

            // Toggle dropdown
            filterBtn.addEventListener('click', () => {
                filterDropdown.classList.toggle('hidden');
            });

            // Klik di luar dropdown
            document.addEventListener('click', (e) => {
                if (!filterBtn.contains(e.target) && !filterDropdown.contains(e.target)) {
                    filterDropdown.classList.add('hidden');
                }
            });

            // Klik status di dropdown
            filterDropdown.querySelectorAll('a').forEach(item => {
                item.addEventListener('click', (e) => {
                    e.preventDefault();
                    const value = item.getAttribute('data-value');
                    hiddenStatus.value = value;
                    // Use AJAX fetch instead of form submit to prevent reload
                    updateQuery();
                });
            });
            
            // Intercept form submission to prevent reload and use AJAX fetch
            const filterForm = document.getElementById('filterForm');
            filterForm.addEventListener('submit', (e) => {
                e.preventDefault();
                updateQuery();
            });

            // Event filter manual
            if (statusInput) {
                statusInput.addEventListener('change', updateQuery);
            }

            if (searchBtn) {
                searchBtn.addEventListener('click', updateQuery);
            }

            if (resetBtn) {
                resetBtn.addEventListener('click', () => {
                    buyerInput.value = '';
                    statusInput.value = '';
                    updateQuery();
                });
            }

            async function updateQuery() {
                const buyer = buyerInput.value;
                const status = hiddenStatus.value;

                const params = new URLSearchParams(window.location.search);
                buyer ? params.set('buyer', buyer) : params.delete('buyer');
                status ? params.set('status', status) : params.delete('status');

                const newUrl = `${location.pathname}?${params.toString()}`;
                window.history.replaceState({}, '', newUrl);

                try {
                    const response = await fetch(newUrl, {
                        headers: { 'X-Requested-With': 'XMLHttpRequest' }
                    });
                    if (!response.ok) throw new Error('Network response was not ok');

                    const purchases = await response.json();
                    updateTable(purchases);
                } catch (error) {
                    console.error('Fetch error:', error);
                }
            }

            function formatDate(dateString) {
                const months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
                const date = new Date(dateString);
                const day = ("0" + date.getDate()).slice(-2);
                const month = months[date.getMonth()];
                const year = date.getFullYear();
                return `${day} ${month} ${year}`;
            }

            function updateTable(purchases) {
                const tbody = document.querySelector('table tbody');
                tbody.innerHTML = '';

                if (!purchases.length) {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `<td colspan="10" class="text-center text-lg text-gray-600">Tidak ada data pembelian untuk ditampilkan.</td>`;
                    tbody.appendChild(tr);
                    return;
                }

                purchases.forEach(purchase => {
                    const tr = document.createElement('tr');
                    tr.className = 'border-t hover:bg-gray-50 bg-opacity-80';

                    const statusClass = purchase.status === 'completed' ? 'bg-green-100 text-green-800' :
                                        purchase.status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                                        'bg-red-100 text-red-800';

                    const statusIcon = purchase.status === 'completed' ? '<i class="fas fa-check-circle text-green-600"></i>' :
                                        purchase.status === 'pending' ? '<i class="fas fa-clock text-yellow-600"></i>' :
                                        '<i class="fas fa-times-circle text-red-600"></i>';

                    tr.innerHTML = `
                        <td class="px-4 py-3 text-center">${purchase.id}</td>
                        <td class="px-4 py-3 text-center">${purchase.buyer}</td>
                        <td class="px-4 py-3 text-center">${purchase.product}</td>
                        <td class="px-4 py-3 text-center">${purchase.supplier}</td>
                        <td class="px-4 py-3 text-center">Rp ${purchase.price}</td>
                        <td class="px-4 py-3 text-center">${purchase.quantity}</td>
                        <td class="px-4 py-3 text-center">Rp ${purchase.total}</td>
                        <td class="px-4 py-3 text-center">
                            <span class="inline-flex items-center gap-1 px-2 py-1 rounded text-xs font-medium ${statusClass}">
                                ${statusIcon}
                                ${purchase.status_label}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-center">${formatDate(purchase.created_at)}</td>
                        <td class="px-4 py-3 text-center">
                            <form method="POST" action="/admin/purchase/${purchase.id}/update-status" class="flex items-center justify-center gap-2 status-update-form">
                                <?php echo csrf_field(); ?>
                                <select name="status" class="border rounded px-2 py-1 text-sm appearance-none bg-white cursor-pointer custom-select-no-arrow text-center">
                                    <option value="completed" ${purchase.status === 'completed' ? 'selected' : ''}>Completed</option>
                                    <option value="pending" ${purchase.status === 'pending' ? 'selected' : ''}>Pending</option>
                                    <option value="cancelled" ${purchase.status === 'cancelled' ? 'selected' : ''}>Cancelled</option>
                                </select>
                            </form>
                        </td>
                    `;
                    tbody.appendChild(tr);
                });
            }
        });

        // Add event listener for automatic status update on dropdown change
        document.querySelectorAll('.status-update-form select').forEach(select => {
            select.addEventListener('change', async (e) => {
                console.log('Status dropdown changed'); // Debug log
                const form = select.closest('form');
                const formData = new FormData(form);
                const action = form.getAttribute('action');

                try {
                    const response = await fetch(action, {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': formData.get('_token'),
                            'Accept': 'application/json',
                        },
                        body: formData,
                    });

                    if (!response.ok) {
                        const errorText = await response.text();
                        console.error('Network response was not ok:', errorText);
                        throw new Error('Network response was not ok');
                    }

                    // Update the status cell UI after successful update
                    const statusCell = form.closest('tr').querySelector('td:nth-child(8) span');
                    if (statusCell) {
                        const newStatus = select.value;
                        let statusClass = '';
                        let statusIcon = '';
                        let statusLabel = '';

                        if (newStatus === 'completed') {
                            statusClass = 'bg-green-100 text-green-800';
                            statusIcon = '<i class="fas fa-check-circle text-green-600"></i>';
                            statusLabel = 'Completed';
                        } else if (newStatus === 'pending') {
                            statusClass = 'bg-yellow-100 text-yellow-800';
                            statusIcon = '<i class="fas fa-clock text-yellow-600"></i>';
                            statusLabel = 'Pending';
                        } else if (newStatus === 'cancelled') {
                            statusClass = 'bg-red-100 text-red-800';
                            statusIcon = '<i class="fas fa-times-circle text-red-600"></i>';
                            statusLabel = 'Cancelled';
                        }

                        statusCell.className = `inline-flex items-center gap-1 px-2 py-1 rounded text-xs font-medium ${statusClass}`;
                        statusCell.innerHTML = `${statusIcon} ${statusLabel}`;
                    }

                    console.log('Status updated successfully');
                } catch (error) {
                    console.error('Error updating status:', error);
                }
            });
        });
    </script>

    <style>
        /* Remove default arrow in select for Webkit browsers */
        select.custom-select-no-arrow::-webkit-appearance {
            none;
        }
        /* Remove default arrow in select for Firefox */
        select.custom-select-no-arrow::-moz-appearance {
            none;
        }
        /* Remove default arrow in select for IE */
        select.custom-select-no-arrow {
            -ms-appearance: none;
            appearance: none;
            background-image: none !important;
        }
    </style>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\HP\Laravel\Projek_RPL\resources\views/admin/purchases-management.blade.php ENDPATH**/ ?>