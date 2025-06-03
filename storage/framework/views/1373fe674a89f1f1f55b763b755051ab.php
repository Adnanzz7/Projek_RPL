<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Register | PKK Market</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="min-h-screen flex items-center justify-center bg-cover bg-center" style="background-image: url('<?php echo e(asset('storage/bg.jpg')); ?>')">
    <div class="bg-white shadow-xl rounded-2xl max-w-5xl w-full p-10 md:flex md:items-start">
        <!-- Left Side -->
        <div class="hidden md:block md:w-1/2 pr-8">
            <img src="<?php echo e(asset('storage/logo.png')); ?>" alt="Logo" class="w-12 mb-6">
            <h1 class="text-3xl font-medium mb-2">Selamat Datang</h1>
            <p class="text-sm text-gray-600">Buat akun untuk mulai berbelanja.</p>
        </div>

        <!-- Right Side -->
        <div class="md:w-1/2 w-full">
            <form method="POST" action="<?php echo e(route('register')); ?>" enctype="multipart/form-data" class="space-y-4">
                <?php echo csrf_field(); ?>

                <input type="text" name="name" placeholder="Full Name" value="<?php echo e(old('name')); ?>" required
                    class="w-full px-4 py-3 bg-white border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none placeholder-gray-400 text-gray-900">
                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="text-red-600 text-sm"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                <input type="text" name="username" placeholder="Username" value="<?php echo e(old('username')); ?>" required
                    class="w-full px-4 py-3 bg-white border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none placeholder-gray-400 text-gray-900">
                <?php $__errorArgs = ['username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="text-red-600 text-sm"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                <input type="email" name="email" placeholder="Email Address" value="<?php echo e(old('email')); ?>" required
                    class="w-full px-4 py-3 bg-white border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none placeholder-gray-400 text-gray-900">
                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="text-red-600 text-sm"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                <div class="relative">
                    <input type="password" name="password" id="password" placeholder="Password" required
                        class="w-full px-4 py-3 pr-10 bg-white border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none placeholder-gray-400 text-gray-900">
                    <button type="button"
                            class="absolute top-1/2 right-3 -translate-y-1/2 text-gray-500 hover:text-gray-800"
                            onclick="togglePasswordVisibility('password')">
                        <i class="bi bi-eye" id="icon-password"></i>
                    </button>
                </div>
                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="text-red-600 text-sm"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                <div class="relative">
                    <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password" required
                        class="w-full px-4 py-3 pr-10 bg-white border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none placeholder-gray-400 text-gray-900">
                    <button type="button"
                            class="absolute top-1/2 right-3 -translate-y-1/2 text-gray-500 hover:text-gray-800"
                            onclick="togglePasswordVisibility('password_confirmation')">
                        <i class="bi bi-eye" id="icon-password_confirmation"></i>
                    </button>
                </div>
                <?php $__errorArgs = ['password_confirmation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="text-red-600 text-sm"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                <select name="role" required
                    class="w-full px-4 py-3 bg-white border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none text-gray-900">
                    <option value="" disabled <?php echo e(old('role') ? '' : 'selected'); ?>>Select Role</option>
                    <option value="user" <?php echo e(old('role') === 'user' ? 'selected' : ''); ?>>User</option>
                    <option value="supplier" <?php echo e(old('role') === 'supplier' ? 'selected' : ''); ?>>Supplier</option>
                    <option value="admin" <?php echo e(old('role') === 'admin' ? 'selected' : ''); ?>>Admin</option>
                </select>
                <?php $__errorArgs = ['role'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="text-red-600 text-sm"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                <input type="text" name="kode_pendaftaran" placeholder="Registration Code" required
                    class="w-full px-4 py-3 bg-white border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none placeholder-gray-400 text-gray-900">
                <?php $__errorArgs = ['kode_pendaftaran'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="text-red-600 text-sm"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                
                <div class="flex justify-end items-center mt-6">
                    <button type="button"
                        onclick="window.location.href='<?php echo e(route('login')); ?>'"
                        class="text-blue-600 text-sm font-medium px-6 py-2 hover:bg-blue-50 bg-opacity-0 rounded-full border-none border-blue-600">
                        Log in
                    </button>
                    <button type="submit"
                        class="ml-4 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-6 py-2 rounded-full">
                        Register
                    </button>
                </div>                 
            </form>
        </div>
    </div>

    <!-- Toggle Password Script -->
    <script>
        function togglePasswordVisibility(id) {
            const input = document.getElementById(id);
            const icon = document.getElementById(`icon-${id}`);

            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                input.type = "password";
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        }
    </script>
</body>
</html><?php /**PATH C:\Users\HP\Laravel\Projek_RPL\resources\views/auth/register.blade.php ENDPATH**/ ?>