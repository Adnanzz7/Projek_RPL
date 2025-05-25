@extends('layouts.profile')

@section('title', 'Edit Profil')

<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>

@section('content')
<div class="max-w-4xl mx-auto mt-10">
    <!-- Profile Card Header -->
    <div class="bg-white rounded-xl shadow p-6 flex flex-col items-center text-center">
        <div class="relative w-32 h-32 mb-4">
            <!-- Foto Profil -->
            <img src="{{ $user->foto ? Storage::url($user->foto) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=random&size=128' }}" 
                alt="{{ $user->name }}"
                class="w-full h-full object-cover rounded-full border-4 border-indigo-500">

            <!-- Tombol Kecil untuk Upload -->
            <label for="foto"
                class="absolute bottom-1 right-1 w-8 h-8 bg-white border border-gray-300 rounded-full flex items-center justify-center shadow cursor-pointer hover:bg-gray-100">
                <i class="fas fa-camera text-indigo-600 text-sm"></i>
            </label>

            <!-- Input File Hidden -->
            <input type="file" name="foto" id="foto" class="hidden" onchange="this.form.submit()" />
        </div>

        <h2 class="text-xl font-semibold text-gray-800">{{ $user->name }}</h2>
        <p class="text-sm text-gray-500">{{ '@' . $user->username }} • {{ ucfirst($user->role) }}</p>
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
                <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="action" value="update_profile">

                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                        <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required
                               class="text-black mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
                    </div>

                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                        <input id="username" name="username" type="text" value="{{ old('username', $user->username) }}" required
                               class="text-black mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
                    </div>

                    <div>
                        <label for="email" class="block font-medium text-gray-700">{{ __('Email') }}</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required autocomplete="username" 
                           class="text-black mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">

                        @error('email') 
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror

                        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                            <div class="mt-4 text-sm text-gray-600">
                                <p>{{ __('Alamat email Anda belum diverifikasi.') }}</p>
                                <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                                    @csrf
                                    <button type="submit" class="underline text-indigo-600 hover:text-indigo-900">
                                        {{ __('Klik di sini untuk mengirim ulang email verifikasi.') }}
                                    </button>
                                </form>
                                @if (session('status') === 'verification-link-sent')
                                    <p class="mt-2 text-sm text-green-600">
                                        {{ __('Link verifikasi baru telah dikirim ke alamat email Anda.') }}
                                    </p>
                                @endif
                            </div>
                        @endif
                    </div>

                    <div>
                        <label for="birth_date" class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                        <input id="birth_date" name="birth_date" type="date" value="{{ old('birth_date', $user->birth_date) }}"
                               class="text-black mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
                    </div>

                    <div>
                        <label for="about" class="block text-sm font-medium text-gray-700">Tentang Saya</label>
                        <textarea id="about" name="about" rows="3"
                                  class="text-black mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 resize-none">{{ old('about', $user->about) }}</textarea>
                    </div>

                    <div class="pt-4 text-right">
                        <button type="submit"
                                class="px-6 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:ring focus:ring-indigo-300">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

            <!-- Change Password -->
            <div data-tab-content="password" class="hidden">
                <form method="post" action="{{ route('password.update') }}" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="current_password" class="block text-sm font-medium text-gray-700">Password Saat Ini</label>
                        <div class="relative">
                            <input id="current_password" name="current_password" type="password"
                                class="text-black mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 pr-10" />
                            <button type="button" 
                                    class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-500 hover:text-gray-700 focus:outline-none" 
                                    onclick="togglePasswordVisibility('current_password')">
                                <i class="bi bi-eye" id="icon-current_password"></i>
                            </button>
                        </div>
                        @error('current_password') 
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Password Baru</label>
                        <div class="relative">
                            <input id="password" name="password" type="password"
                                class="text-black mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 pr-10" />
                            <button type="button" 
                                    class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-500 hover:text-gray-700 focus:outline-none" 
                                    onclick="togglePasswordVisibility('password')">
                                <i class="bi bi-eye" id="icon-password"></i>
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                        <div class="relative">
                            <input id="password_confirmation" name="password_confirmation" type="password"
                                class="text-black mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 pr-10" />
                            <button type="button" 
                                    class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-500 hover:text-gray-700 focus:outline-none" 
                                    onclick="togglePasswordVisibility('password_confirmation')">
                                <i class="bi bi-eye" id="icon-password_confirmation"></i>
                            </button>
                        </div>
                    </div>

                    <div class="pt-4 text-right">
                        <button type="submit"
                                class="px-6 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:ring focus:ring-indigo-300">
                            Ubah Password
                        </button>
                    </div>
                </form>
            </div>

            <!-- Delete Account -->
            <div data-tab-content="delete" class="hidden">
                <form method="post" action="{{ route('profile.destroy') }}" class="space-y-4">
                    @csrf
                    @method('DELETE')

                    <h4 class="text-base text-gray-600">
                        Setelah akun Anda dihapus, semua data akan dihapus secara permanen. Harap masukkan password Anda untuk melanjutkan.
                    </h4>

                    <div>
                        <label for="delete_password" class="block text-sm font-medium text-gray-700">Password</label>
                        <input id="delete_password" name="password" type="password"
                            class="text-black mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-red-500 focus:border-red-500" />
                        
                        @error('password', 'userDeletion')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="pt-4 text-right">
                        <button type="submit"
                                class="px-6 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:ring focus:ring-red-300">
                            Hapus Akun
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Back to Home -->
    <div class="text-center mt-6">
        <a href="{{ route('barangs.index') }}"
           class="inline-flex items-center px-6 py-2 bg-blue-600 text-white rounded-full shadow hover:bg-blue-700">
            <i class="bi bi-house-door mr-2"></i> Kembali ke Beranda
        </a>
    </div>
</div>

@push('scripts')
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

    function togglePasswordVisibility(inputId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById('icon-' + inputId);
        if (input.type === "password") {
            input.type = "text";
            icon.classList.remove("bi-eye");
            icon.classList.add("bi-eye-slash");
        } else {
            input.type = "password";
            icon.classList.remove("bi-eye-slash");
            icon.classList.add("bi-eye");
        }
    }

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

    // Jika ada error di tab password, otomatis switch ke tab password
    @if ($errors->has('current_password') || $errors->has('password') || $errors->has('password_confirmation'))
        document.addEventListener('DOMContentLoaded', () => {
            const tabButtons = document.querySelectorAll("[data-tab-button]");
            tabButtons.forEach(button => {
                if(button.getAttribute("data-tab-button") === 'password') {
                    button.click();
                }
            });
        });
    @endif
</script>
@endpush
@endsection