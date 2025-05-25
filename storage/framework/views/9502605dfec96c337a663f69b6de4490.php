<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="/src/styles.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex items-center justify-center bg-cover bg-center" style="background-image: url('<?php echo e(asset('storage/bg.jpg')); ?>')">
    <div class="bg-white bg-opacity-80 p-8 rounded-lg shadow-lg max-w-md w-full text-center">
        <div class="w-36 h-36 mx-auto mb-6 rounded-full">
            <img src="<?php echo e(asset('storage/logo.png')); ?>" alt="Logo" class="w-full h-full object-contain">
        </div>
        <h2 class="text-2xl font-semibold text-gray-800 mb-2">Welcome Back</h2>
        <p class="text-sm text-gray-600 mb-6">Please log in to your account</p>
        
        <form method="POST" action="<?php echo e(route('login')); ?>">
            <?php echo csrf_field(); ?>
            
            <div class="mb-4">
                <label for="login" class="block text-left font-medium text-gray-700 mb-1">Email or Username</label>
                <input type="text" id="login" name="login" value="<?php echo e(old('login')); ?>" placeholder="Enter email or username" required autofocus 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <?php if($errors->has('login')): ?>
                    <span class="text-red-600 text-sm"><?php echo e($errors->first('login')); ?></span>
                <?php endif; ?>
            </div>

            <div class="mb-6 relative">
                <label for="password" class="block text-left font-medium text-gray-700 mb-1">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 pr-10">
                <button type="button" id="togglePassword" class="absolute bottom-3 right-0 pr-3 flex items-center text-gray-500">
                    <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </button>
                <?php if($errors->has('password')): ?>
                    <span class="text-red-600 text-sm"><?php echo e($errors->first('password')); ?></span>
                <?php endif; ?>
            </div>

            <!-- Forgot Password Link -->
            <div class="text-left -mt-3 mb-4 flex items-center">
                <input type="checkbox" id="remember" name="remember" class="mr-2">
                <label for="remember" class="text-sm text-gray-700 font-medium select-none">Remember me</label>
            </div>

            <div class="text-left mb-6">
                <a href="<?php echo e(route('password.request')); ?>" class="text-sm text-indigo-600 font-medium">
                    Forgot your password?
                </a>
            </div>

            <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded-lg font-medium hover:bg-indigo-700 transition">
                Log in
            </button>
        </form>

        <div class="mt-4">
            <p class="text-sm text-gray-600">Don't have an account? 
                <a href="<?php echo e(route('register')); ?>" class="text-indigo-600 font-medium">Register</a>
            </p>
        </div>

        <script>
            const togglePassword = document.querySelector('#togglePassword');
            const password = document.querySelector('#password');
            const eyeIcon = document.querySelector('#eyeIcon');

            togglePassword.addEventListener('click', function () {
                // toggle the type attribute
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);

                // toggle the eye / eye-off icon
                if (type === 'password') {
                    eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />';
                } else {
                    eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.956 9.956 0 012.223-3.434m1.766-1.766A9.956 9.956 0 0112 5c4.477 0 8.268 2.943 9.542 7a10.05 10.05 0 01-4.457 5.072M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18" />';
                }
            });
        </script>
    </div>
</body>
</html>
<?php /**PATH C:\Users\HP\Laravel\Projek_RPL\resources\views/auth/login.blade.php ENDPATH**/ ?>