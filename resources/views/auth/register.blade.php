<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Register | PKK Market</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="min-h-screen flex items-center justify-center bg-cover bg-center" style="background-image: url('{{ asset('storage/bg.jpg') }}')">
    <div class="bg-white shadow-xl rounded-2xl max-w-5xl w-full p-10 md:flex md:items-start">
        <!-- Left Side -->
        <div class="hidden md:block md:w-1/2 pr-8">
            <img src="{{ asset('storage/logo.png') }}" alt="Logo" class="w-12 mb-6">
            <h1 class="text-3xl font-medium mb-2">Selamat Datang</h1>
            <p class="text-sm text-gray-600">Buat akun untuk mulai berbelanja.</p>
        </div>

        <!-- Right Side -->
        <div class="md:w-1/2 w-full">
            <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" class="space-y-4">
                @csrf

                <input type="text" name="name" placeholder="Full Name" value="{{ old('name') }}" required
                    class="w-full px-4 py-3 bg-white border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none placeholder-gray-400 text-gray-900">
                @error('name')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror

                <input type="text" name="username" placeholder="Username" value="{{ old('username') }}" required
                    class="w-full px-4 py-3 bg-white border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none placeholder-gray-400 text-gray-900">
                @error('username')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror

                <input type="email" name="email" placeholder="Email Address" value="{{ old('email') }}" required
                    class="w-full px-4 py-3 bg-white border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none placeholder-gray-400 text-gray-900">
                @error('email')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror

                <div class="relative">
                    <input type="password" name="password" id="password" placeholder="Password" required
                        class="w-full px-4 py-3 pr-10 bg-white border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none placeholder-gray-400 text-gray-900"
                        oninput="toggleIconVisibility('password')">
                    <button type="button" id="toggle-btn-password"
                        class="absolute inset-y-0 right-0 px-3 items-center text-gray-500 hover:text-gray-700 focus:outline-none hidden"
                        onclick="togglePasswordVisibility('password')">
                        <i class="bi bi-eye-fill" id="icon-password"></i>
                    </button>
                </div>
                @error('password')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror

                <div class="relative">
                    <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password" required
                        class="w-full px-4 py-3 pr-10 bg-white border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none placeholder-gray-400 text-gray-900"
                        oninput="toggleIconVisibility('password_confirmation')">
                    <button type="button" id="toggle-btn-password_confirmation"
                        class="absolute inset-y-0 right-0 px-3 items-center text-gray-500 hover:text-gray-700 focus:outline-none hidden"
                        onclick="togglePasswordVisibility('password_confirmation')">
                        <i class="bi bi-eye-fill" id="icon-password_confirmation"></i>
                    </button>
                </div>
                @error('password_confirmation')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror

                <div class="relative">
                    <select name="role" required
                        class="appearance-none w-full px-4 py-3 bg-white border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none text-gray-900">
                        <option value="" disabled {{ old('role') ? '' : 'selected' }}>Select Role</option>
                        <option value="user" {{ old('role') === 'user' ? 'selected' : '' }}>User</option>
                        <option value="supplier" {{ old('role') === 'supplier' ? 'selected' : '' }}>Supplier</option>
                        <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>

                <input type="text" name="kode_pendaftaran" placeholder="Kode Pendaftaran"
                    class="w-full px-4 py-3 bg-white border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none text-gray-900"
                    value="{{ old('kode_pendaftaran') }}">
                @error('kode_pendaftaran')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
                
                <div class="flex justify-end items-center mt-6">
                    <button type="button"
                        onclick="window.location.href='{{ route('login') }}'"
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
            if (input.value.length > 0) {
                button.classList.remove('hidden');
            } else {
                button.classList.add('hidden');
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            toggleIconVisibility('password');
            toggleIconVisibility('password_confirmation');
        });

        document.getElementById('toggle-btn').classList.remove('hidden');
        document.getElementById('toggle-btn').classList.add('flex');
    </script>
</body>
</html>