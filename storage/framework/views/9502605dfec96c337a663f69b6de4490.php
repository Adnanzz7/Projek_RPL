<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Login | PKK Market</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body class="min-h-screen flex items-center justify-center bg-cover bg-center" style="background-image: url('<?php echo e(asset('storage/bg.jpg')); ?>')">
    <div class="bg-white shadow-xl rounded-2xl max-w-5xl w-full p-10 md:flex md:items-start">
        <!-- Left Side Branding -->
        <div class="hidden md:block md:w-1/2 pr-8">
            <img src="<?php echo e(asset('storage/logo.png')); ?>" alt="Logo" class="w-12 mb-6">
            <h1 class="text-3xl font-medium mb-2">Selamat Datang</h1>
            <p class="text-sm text-gray-600">Masuk ke akun Anda untuk melanjutkan belanja.</p>
        </div>
        
        <!-- Right Side Form -->
        <div class="md:w-1/2 w-full">
        <form method="POST" action="<?php echo e(route('login')); ?>">
            <?php echo csrf_field(); ?>
            <div class="mb-4">
                <input type="text" id="login" name="login" value="<?php echo e(old('login')); ?>" placeholder="Email atau Username"
                class="w-full px-4 py-3 bg-white border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none placeholder-gray-400" required autofocus>
                <?php if($errors->has('login')): ?>
                <span class="text-red-500 text-sm"><?php echo e($errors->first('login')); ?></span>
                <?php endif; ?>
            </div>
            
            <div class="mb-2">
                <div class="relative">
                    <input type="password" id="password" name="password" placeholder="Password"
                    class="w-full px-4 py-3 bg-white border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none placeholder-gray-400"
                    required oninput="toggleIconVisibility('password')">
                    
                    <button type="button" id="toggle-btn-password"
                    class="absolute inset-y-0 right-0 px-3 items-center text-gray-500 hover:text-gray-700 focus:outline-none hidden"
                    onclick="togglePasswordVisibility('password')">
                        <i class="bi bi-eye-fill" id="icon-password"></i>
                    </button>
                </div>
                <?php if($errors->has('password')): ?>
                <span class="text-red-500 text-sm"><?php echo e($errors->first('password')); ?></span>
                <?php endif; ?>
            </div>
            
            <!-- Remember Me & Forgot -->
            <div class="flex items-center justify-between mb-6">
                <label class="flex items-center text-sm text-gray-600">
                    <input type="checkbox" name="remember" class="mr-2">
                    Remember me
                </label>
                <a href="<?php echo e(route('password.request')); ?>" class="text-sm text-blue-600 font-semibold hover:underline">
                    Forgot password?
                </a>
            </div>

            
            
            <div class="flex justify-end items-center mt-6">
                <button type="button"
                onclick="window.location.href='<?php echo e(route('register')); ?>'"
                class="text-blue-600 text-sm font-medium px-6 py-2 hover:bg-blue-50 bg-opacity-0 rounded-full border-none border-blue-600">
                    Create account
                </button>
                <button type="submit"
                class="ml-4 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-6 py-2 rounded-full">
                    Log in
                </button>
            </div>              
        </form>
    </div>



<script>
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
        button.classList.toggle('hidden', input.value === '');
    }
    
    document.addEventListener('DOMContentLoaded', () => {
        toggleIconVisibility('password');
    });

    document.getElementById('dropdownMenu').classList.remove('hidden');
    document.getElementById('dropdownMenu').classList.add('flex');      
</script>
<script src="https://cdn.tailwindcss.com"></script>
</body>
</html><?php /**PATH C:\Users\HP\Laravel\Projek_RPL\resources\views/auth/login.blade.php ENDPATH**/ ?>