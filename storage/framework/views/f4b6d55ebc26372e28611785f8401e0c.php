<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Forgot Password | PKK Market</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="min-h-screen flex items-center justify-center bg-cover bg-center" style="background-image: url('<?php echo e(asset('storage/bg.jpg')); ?>')">
    <div class="bg-white shadow-xl rounded-2xl max-w-5xl w-full p-10 md:flex md:items-start">
        <div class="hidden md:block md:w-1/2 pr-8">
            <img src="<?php echo e(asset('storage/logo.png')); ?>" alt="Logo" class="w-12 mb-6">
            <h1 class="text-3xl font-medium mb-2">Lupa Kata Sandi?</h1>
            <p class="text-sm text-gray-600">Masukkan email Anda dan kami akan mengirimkan link untuk reset kata sandi Anda.</p>
        </div>

        <div class="md:w-1/2 w-full">
            <div class="text-center mb-6 md:hidden">
                <img src="<?php echo e(asset('storage/logo.png')); ?>" alt="Logo" class="w-16 mx-auto mb-2">
                <h2 class="text-2xl font-semibold text-gray-800">Forgot Password</h2>
            </div>

            <form method="POST" action="<?php echo e(route('password.email')); ?>">
                <?php echo csrf_field(); ?>

                <div class="mb-16">
                    <input type="email" id="email" name="email" placeholder="Enter your email" value="<?php echo e(old('email')); ?>" required autofocus
                        class="w-full px-4 py-3 bg-white border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none placeholder-gray-400 text-gray-800">
                    <?php if($errors->has('email')): ?>
                        <span class="text-red-600 text-sm"><?php echo e($errors->first('email')); ?></span>
                    <?php endif; ?>
                </div>

                <div class="flex justify-end items-center mt-6">
                    <button type="button"
                        onclick="window.location.href='<?php echo e(route('login')); ?>'"
                        class="text-blue-600 text-sm font-medium px-6 py-2 hover:bg-blue-50 bg-opacity-0 rounded-full border-none border-blue-600">
                        Back to Login
                    </button>
                    <button type="submit"
                        class="ml-4 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-6 py-2 rounded-full">
                        Send Reset Link
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html><?php /**PATH C:\Users\HP\Laravel\Projek_RPL\resources\views/auth/forgot-password.blade.php ENDPATH**/ ?>