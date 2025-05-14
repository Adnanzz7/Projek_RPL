@extends('layouts.app')

@section('title', 'Profile')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="{{ asset('css/custom-style.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <!-- Profile Information Section -->
        <div class="bg-white bg-opacity-80 p-6 rounded-xl shadow-md">
            <header class="text-center mb-6">
                <h2 class="text-xl font-semibold text-gray-800">{{ __('Profile Information') }}</h2>
                <h5 class="mt-2 text-sm text-gray-600">{{ __("Update your account's profile information, email address, and profile picture.") }}</h5>
            </header>

            <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                @csrf
            </form>

            <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PATCH')
                <input type="hidden" name="action" value="update_profile">

                <!-- Role -->
                <div>
                    <label for="role" class="block font-medium text-gray-700">{{ __('Role') }}</label>
                    <input id="role" name="role" type="text" 
                        class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" 
                        value="{{ $user->role }}" readonly />
                    <input type="hidden" name="role" value="{{ $user->role }}">
                    @error('role')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>        

                <!-- Name -->
                <div>
                    <label for="name" class="block font-medium text-gray-700">{{ __('Display Name') }}</label>
                    <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required 
                        class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                    
                <!-- Username -->
                <div>
                    <label for="username" class="block font-medium text-gray-700">{{ __('Username') }}</label>
                    <input id="username" name="username" type="text" value="{{ old('username', $user->username) }}" required 
                        class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    @error('username')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                    
                <!-- Email -->
                <div>
                    <label for="email" class="block font-medium text-gray-700">{{ __('Email') }}</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required autocomplete="username" 
                        class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    @error('email') 
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                        <div class="mt-4 text-sm text-gray-600">
                            <p>{{ __('Your email address is unverified.') }}</p>
                            <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                                @csrf
                                <button type="submit" class="underline text-indigo-600 hover:text-indigo-900">
                                    {{ __('Click here to re-send the verification email.') }}
                                </button>
                            </form>
                            @if (session('status') === 'verification-link-sent')
                                <p class="mt-2 text-sm text-green-600">{{ __('A new verification link has been sent to your email address.') }}</p>
                            @endif
                        </div>
                    @endif
                </div>

                <!-- Birth Date -->
                <div>
                    <label for="birth_date" class="block font-medium text-gray-700">{{ __('Birth Date') }}</label>
                    <input type="date" id="birth_date" name="birth_date" value="{{ old('birth_date', $user->birth_date) }}" 
                        class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    @error('birth_date')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- About -->
                <div>
                    <label for="about" class="block font-medium text-gray-700">{{ __('About') }}</label>
                    <textarea id="about" name="about" class="block w-full mt-1 pl-2.5 pt-1.5 border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 resize-none" rows="4">{{ old('about', $user->about) }}</textarea>
                    @error('about')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>    
            
                <!-- Photo -->
                <div class="relative group">
                    <label class="block font-medium text-gray-700">{{ __('Profile Photo') }}</label>
                    
                    <label for="foto" class="block mt-2 relative cursor-pointer w-24 h-24 overflow-hidden">
                        <img src="{{ $user->foto ? Storage::url($user->foto) : 'https://static.vecteezy.com/system/resources/previews/005/129/844/non_2x/profile-user-icon-isolated-on-white-background-eps10-free-vector.jpg' }}" 
                            class="rounded-full w-full h-full object-cover transition-all duration-300 ease-in-out group-hover:brightness-75" 
                            alt="{{ $user->name }}">
                        
                        <div class="absolute inset-0 flex items-center justify-center rounded-full bg-gray-900 bg-opacity-50 opacity-0 pointer-events-none group-hover:opacity-90 transition-opacity duration-200 ease-in-out">
                            <span class="text-white text-sm font-semibold opacity-60 group-hover:opacity-100 transition-opacity duration-100 ease-in-out">Ubah</span>
                        </div>
                    </label>
                    
                    <input type="file" name="foto" id="foto" accept="image/*" class="w-full hidden" />
                    
                    @error('foto')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            
                <!-- Save Button -->
                <div class="flex justify-center mt-6">
                    <button type="submit" class="px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors">
                        {{ __('Save') }}
                    </button>
                </div>

                @if (session('status') === 'profile-updated')
                    <p x-data="{ show: true }"
                        x-show="show"
                        x-transition
                        x-init="setTimeout(() => show = false, 2000)"
                        class="text-sm text-green-600 text-center mt-4">
                        {{ __('Saved.') }}
                    </p>
                @endif
            </form>
        </div>

        <!-- Update Password Section -->
        <div class="bg-white bg-opacity-80 p-6 rounded-xl shadow-md">
            <header class="mb-6 text-center">
                <h2 class="text-xl font-semibold text-gray-800">
                    {{ __('Update Password') }}
                </h2>
                <p class="mt-2 text-sm text-gray-600">
                    {{ __('Ensure your account is using a long, random password to stay secure.') }}
                </p>
            </header>

            <form method="post" action="{{ route('password.update') }}" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Current Password -->
                <div class="relative">
                    <label for="update_password_current_password" class="block font-medium text-gray-700">{{ __('Current Password') }}</label>
                    <div class="relative mt-1">
                        <input id="update_password_current_password" name="current_password" type="password" 
                            class="w-full py-3 pl-4 pr-12 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" 
                            autocomplete="current-password" />
                        <button type="button" class="absolute right-3 top-3 text-gray-500 focus:outline-none" onclick="togglePassword('update_password_current_password')">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                    @error('current_password', 'updatePassword')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- New Password -->
                <div class="relative">
                    <label for="update_password_password" class="block font-medium text-gray-700">{{ __('New Password') }}</label>
                    <div class="relative mt-1">
                        <input id="update_password_password" name="password" type="password" 
                            class="w-full py-3 pl-4 pr-12 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" 
                            autocomplete="new-password" />
                        <button type="button" class="absolute right-3 top-3 text-gray-500 focus:outline-none" onclick="togglePassword('update_password_password')">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                    @error('password', 'updatePassword')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="relative">
                    <label for="update_password_password_confirmation" class="block font-medium text-gray-700">{{ __('Confirm Password') }}</label>
                    <div class="relative mt-1">
                        <input id="update_password_password_confirmation" name="password_confirmation" type="password" 
                            class="w-full py-3 pl-4 pr-12 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" 
                            autocomplete="new-password" />
                        <button type="button" class="absolute right-3 top-3 text-gray-500 focus:outline-none" onclick="togglePassword('update_password_password_confirmation')">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                    @error('password_confirmation', 'updatePassword')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Save Button -->
                <div class="flex justify-center mt-6">
                    <button type="submit" class="px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors">
                        {{ __('Save') }}
                    </button>
                </div>

                @if (session('status') === 'password-updated')
                    <p x-data="{ show: true }" x-show="show" x-transition
                        x-init="setTimeout(() => show = false, 2000)" class="text-sm text-green-600 text-center mt-4">
                        {{ __('Saved.') }}
                    </p>
                @endif
            </form>
        </div>

        <!-- Delete Account Section -->
        <div class="bg-white bg-opacity-80 p-6 rounded-xl shadow-md">
            <header class="mb-6 text-center">
                <h2 class="text-xl font-semibold text-gray-800">
                    {{ __('Delete Account') }}
                </h2>
                <p class="mt-2 text-sm text-gray-600">
                    {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
                </p>
            </header>

            <div class="text-center mt-6">
                <button x-data="{}"
                    class="px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-colors"
                    x-on:click="$dispatch('open-modal', 'confirm-user-deletion')">
                    {{ __('Delete Account') }}
                </button>
            </div>

            <div x-data="{ show: false }" 
                 x-show="show" 
                 x-on:open-modal.window="show = true"
                 x-on:close-modal.window="show = false"
                 x-transition
                 class="fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-50">
                <div class="fixed inset-0 transform transition-all" x-on:click="$dispatch('close')">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>

                <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full sm:max-w-lg sm:mx-auto" 
                     x-show="show"
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                    <form method="post" action="{{ route('profile.destroy') }}" class="p-6 space-y-6">
                        @csrf
                        @method('delete')

                        <h2 class="text-lg font-medium text-gray-900 text-center">
                            {{ __('Are you sure you want to delete your account?') }}
                        </h2>

                        <p class="mt-2 text-sm text-gray-600 text-center">
                            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                        </p>

                        <div class="mt-6">
                            <label for="password" class="sr-only">{{ __('Password') }}</label>

                            <input id="password" name="password" type="password" 
                                   class="block w-full sm:w-3/4 mx-auto border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                   placeholder="{{ __('Password') }}">

                            @error('password', 'userDeletion')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-center gap-4 mt-6">
                            <button type="button" x-on:click="$dispatch('close')"
                                class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors">
                                {{ __('Cancel') }}
                            </button>

                            <button type="submit"
                                class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-colors">
                                {{ __('Delete Account') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Back to Home Button -->
<div class="text-center mt-1 mb-6">
    <a href="{{ route('barangs.index') }}" 
       class="inline-flex items-center px-8 py-3 text-white text-sm font-medium bg-blue-700 hover:bg-blue-800 rounded-full shadow-md hover:shadow-lg transition-transform transform hover:-translate-y-1">
        <i class="bi bi-house-door mr-2"></i> Back to Home
    </a>
</div>

<script>
    function togglePassword(id) {
        const input = document.getElementById(id);
        const icon = input.nextElementSibling.querySelector('i');

        if (input.type === "password") {
            input.type = "text";
            icon.classList.replace("bi-eye", "bi-eye-slash");
        } else {
            input.type = "password";
            icon.classList.replace("bi-eye-slash", "bi-eye");
        }
    }
</script>
@endsection