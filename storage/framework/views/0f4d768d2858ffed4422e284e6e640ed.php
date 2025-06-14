<?php $__env->startSection('title', 'Edit Profil'); ?>

<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto mt-10">
    <!-- Profile Card Header -->
    <div class="bg-white rounded-xl shadow p-6 flex flex-col items-center text-center">
        <div class="relative w-32 h-32 mb-4">
            <img id="previewFoto" src="<?php echo e($user->foto ? Storage::url($user->foto) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=random&size=128'); ?>" 
                alt="<?php echo e($user->name); ?>" class="w-full h-full object-cover rounded-full border-4 border-indigo-500">
            
            <label for="foto" class="absolute bottom-1 right-1 w-8 h-8 bg-white border border-gray-300 rounded-full flex items-center justify-center shadow cursor-pointer hover:bg-gray-100">
                <i class="bi bi-camera-fill text-indigo-600 text-sm"></i>
            </label>
            <input type="file" name="foto" id="foto" class="hidden" />
        </div>

        <h2 class="text-xl font-semibold text-gray-800"><?php echo e($user->name); ?></h2>
        <p class="text-sm text-gray-500"><?php echo e('@' . $user->username); ?> • <?php echo e(ucfirst($user->role)); ?></p>
    </div>

    <!-- Tab Navigation -->
    <div class="mt-8 bg-white shadow rounded-xl">
        <div class="border-b border-gray-200 px-6 py-4">
            <nav class="flex space-x-4">
                <button data-tab-button="profile"class="text-gray-600 hover:text-indigo-600 font-semibold">Informasi Profil</button>
                <button data-tab-button="password" class="text-gray-600 hover:text-indigo-600 font-semibold">Ubah Password</button>
                <button data-tab-button="delete" class="text-gray-600 hover:text-red-600 font-semibold">Hapus Akun</button>
            </nav>
        </div>

        <div class="p-6 relative z-10">
            <!-- Profile Form -->
            <div data-tab-content="profile">
                <form method="post" action="<?php echo e(route('profile.update')); ?>" enctype="multipart/form-data" class="space-y-4">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PATCH'); ?>
                    <input type="hidden" name="action" value="update_profile">

                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                        <input id="name" name="name" type="text" value="<?php echo e(old('name', $user->name)); ?>" required
                               class="text-black mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
                    </div>

                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                        <input id="username" name="username" type="text" value="<?php echo e(old('username', $user->username)); ?>" required
                               class="text-black mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
                    </div>

                    <div>
                        <label for="email" class="block font-medium text-gray-700"><?php echo e(__('Email')); ?></label>
                        <input type="email" id="email" name="email" value="<?php echo e(old('email', $user->email)); ?>" required autocomplete="username" 
                           class="text-black mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">

                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                            <p class="mt-2 text-sm text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                        <?php if($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail()): ?>
                            <div class="mt-4 text-sm text-gray-600">
                                <p><?php echo e(__('Alamat email Anda belum diverifikasi.')); ?></p>
                                <form id="send-verification" method="post" action="<?php echo e(route('verification.send')); ?>">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="underline text-indigo-600 hover:text-indigo-900">
                                        <?php echo e(__('Klik di sini untuk mengirim ulang email verifikasi.')); ?>

                                    </button>
                                </form>
                                <?php if(session('status') === 'verification-link-sent'): ?>
                                    <p class="mt-2 text-sm text-green-600">
                                        <?php echo e(__('Link verifikasi baru telah dikirim ke alamat email Anda.')); ?>

                                    </p>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div>
                        <label for="birth_date" class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                        <input id="birth_date" name="birth_date" type="date" value="<?php echo e(old('birth_date', $user->birth_date)); ?>"
                               class="text-black mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
                    </div>

                    <div>
                        <label for="about" class="block text-sm font-medium text-gray-700">Tentang Saya</label>
                        <textarea id="about" name="about" rows="3"
                                  class="text-black mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 resize-none"><?php echo e(old('about', $user->about)); ?></textarea>
                    </div>

                    <div class="pt-4 flex justify-end text-right mt-6">
                        <button type="button" onclick="window.location.href='<?php echo e(route('barangs.index')); ?>'" class="text-blue-600 font-medium px-6 py-2 hover:bg-blue-50 bg-opacity-0 rounded-md border-none border-blue-600">
                            Kembali ke Beranda
                        </button>
                                      
                        <button type="submit" class="ml-4 font-medium inline-flex items-center px-6 py-2 bg-indigo-600 text-white rounded-md shadow focus:ring focus:ring-indigo-300 hover:bg-indigo-700">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

            <!-- Change Password -->
            <div data-tab-content="password" class="hidden">
                <form method="post" action="<?php echo e(route('password.update')); ?>" class="space-y-4">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>

                    <div>
                        <label for="current_password" class="block text-sm font-medium text-gray-700">Password Saat Ini</label>
                        <div class="relative">
                            <input id="current_password" name="current_password" type="password"
                                oninput="toggleIconVisibility('current_password')"
                                class="text-black mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 pr-10" />
                            <button type="button" id="toggle-btn-current_password"
                                    class="absolute inset-y-0 right-0 px-3 items-center text-gray-500 hover:text-gray-700 focus:outline-none hidden"
                                    onclick="togglePasswordVisibility('current_password')">
                                <i class="bi bi-eye-fill" id="icon-current_password"></i>
                            </button>
                        </div>
                        <?php $__errorArgs = ['current_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                            <p class="mt-2 text-sm text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Password Baru</label>
                        <div class="relative">
                            <input id="password" name="password" type="password"
                                oninput="toggleIconVisibility('password')"
                                class="text-black mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 pr-10" />
                            <button type="button" id="toggle-btn-password"
                                    class="absolute inset-y-0 right-0 px-3 items-center text-gray-500 hover:text-gray-700 focus:outline-none hidden"
                                    onclick="togglePasswordVisibility('password')">
                                <i class="bi bi-eye-fill" id="icon-password"></i>
                            </button>
                        </div>
                        <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-2 text-sm text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                        <div class="relative">
                            <input id="password_confirmation" name="password_confirmation" type="password"
                                oninput="toggleIconVisibility('password_confirmation')"
                                class="text-black mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 pr-10" />
                            <button type="button" id="toggle-btn-password_confirmation"
                                    class="absolute inset-y-0 right-0 px-3 items-center text-gray-500 hover:text-gray-700 focus:outline-none hidden"
                                    onclick="togglePasswordVisibility('password_confirmation')">
                                <i class="bi bi-eye-fill" id="icon-password_confirmation"></i>
                            </button>
                        </div>
                    </div>

                    <div class="pt-4 flex justify-end text-right mt-6">
                        <button type="button" onclick="window.location.href='<?php echo e(route('barangs.index')); ?>'"
                            class="text-blue-600 font-medium px-6 py-2 hover:bg-blue-50 bg-opacity-0 rounded-md border-none border-blue-600">
                            Kembali ke Beranda
                        </button>
                        <button type="submit"
                            class="ml-4 font-medium inline-flex items-center px-6 py-2 bg-indigo-600 text-white rounded-md shadow focus:ring focus:ring-indigo-300 hover:bg-indigo-700">
                            Ubah Password
                        </button>
                    </div>
                </form>
            </div>

            <!-- Delete Account -->
            <div data-tab-content="delete" class="hidden">
                <form method="post" action="<?php echo e(route('profile.destroy')); ?>" class="space-y-4">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>

                    <h4 class="text-base text-gray-600">
                        Setelah akun Anda dihapus, semua data akan dihapus secara permanen. Harap masukkan password Anda untuk melanjutkan.
                    </h4>

                    <div>
                        <label for="delete_password" class="block text-sm font-medium text-gray-700">Password</label>
                        <input id="delete_password" name="password" type="password"
                            class="text-black mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-rose-500 focus:border-rose-500" />
                        
                        <?php $__errorArgs = ['password', 'userDeletion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-2 text-sm text-rose-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="pt-4 flex justify-end text-right mt-6">
                        <button type="button" onclick="window.location.href='<?php echo e(route('barangs.index')); ?>'" class="text-red-600 font-medium px-6 py-2 hover:bg-red-50 bg-opacity-0 rounded-md border-none border-red-600">
                            Kembali ke Beranda
                        </button>
                                      
                        <button type="submit" class="ml-4 font-medium inline-flex items-center px-6 py-2 bg-rose-600 text-white rounded-md shadow focus:ring focus:ring-rose-300 hover:bg-rose-700">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const tabButtons = document.querySelectorAll("[data-tab-button]");
        const tabContents = document.querySelectorAll("[data-tab-content]");

        tabButtons.forEach(button => {
            button.addEventListener("click", () => {
                const target = button.getAttribute("data-tab-button");

                tabButtons.forEach(btn => btn.classList.remove("text-indigo-600", "font-semibold", "text-red-600"));
                button.classList.add(target === "delete" ? "text-red-600" : "text-indigo-600", "font-semibold");

                tabContents.forEach(content => {
                    content.classList.add("hidden");
                });

                document.querySelector(`[data-tab-content="${target}"]`).classList.remove("hidden");
            });
        });
    });

    document.addEventListener('DOMContentLoaded', () => {
        const defaultTab = document.querySelector('[data-tab-button="profile"]');
        defaultTab.classList.add('text-indigo-600');
    });

    function togglePasswordVisibility(id) {
        const input = document.getElementById(id);
        const icon = document.getElementById('icon-' + id);
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('bi-eye-fill');
            icon.classList.add('bi-eye-slash-fill');
        } else {
            input.type = 'password';
            icon.classList.remove('bi-eye-slash-fill');
            icon.classList.add('bi-eye-fill');
        }
    }

    function toggleIconVisibility(id) {
        const input = document.getElementById(id);
        const button = document.getElementById('toggle-btn-' + id);
        if (input.value.trim() !== '') {
            button.classList.remove('hidden');
        } else {
            button.classList.add('hidden');
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        ['current_password', 'password', 'password_confirmation'].forEach(id => {
            toggleIconVisibility(id);
        });
    });

    <?php if($errors->has('current_password') || $errors->has('password') || $errors->has('password_confirmation')): ?>
    document.addEventListener('DOMContentLoaded', () => {
        const passwordTab = document.querySelector('[data-tab-button="password"]');
        if (passwordTab) passwordTab.click();
    });
    <?php endif; ?>

    document.addEventListener("DOMContentLoaded", function () {
        const tabButtons = document.querySelectorAll("[data-tab-button]");
        const tabContents = document.querySelectorAll("[data-tab-content]");

        tabButtons.forEach(button => {
            button.addEventListener("click", () => {
                const target = button.getAttribute("data-tab-button");

                tabButtons.forEach(btn => btn.classList.remove("text-indigo-600", "font-semibold", "text-red-600"));
                button.classList.add(target === "delete" ? "text-red-600" : "text-indigo-600", "font-semibold");

                tabContents.forEach(content => {
                    content.classList.add("hidden");
                });

                document.querySelector(`[data-tab-content="${target}"]`).classList.remove("hidden");
            });
        });

        const defaultTab = document.querySelector('[data-tab-button="profile"]');
        defaultTab.classList.add('text-indigo-600');
    });

    <?php if($errors->has('current_password') || $errors->has('password') || $errors->has('password_confirmation')): ?>
        document.addEventListener('DOMContentLoaded', () => {
            const tabButtons = document.querySelectorAll("[data-tab-button]");
            tabButtons.forEach(button => {
                if(button.getAttribute("data-tab-button") === 'password') {
                    button.click();
                }
            });
        });
    <?php endif; ?>

    document.getElementById('foto').addEventListener('change', async function () {
    const file = this.files[0];
        if (!file) return;

        const formData = new FormData();
        formData.append('foto', file);

        try {
            const response = await fetch("<?php echo e(route('profile.uploadFoto')); ?>", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                },
                body: formData
            });

            const data = await response.json();
            if (data.status === 'success') {
                document.getElementById('previewFoto').src = data.foto_url;
            } else {
                alert('Gagal upload foto.');
            }
        } catch (err) {
            console.error(err);
            alert('Terjadi kesalahan saat upload.');
        }
    });
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.profile', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\HP\Laravel\Projek_RPL\resources\views/profile/edit.blade.php ENDPATH**/ ?>