@extends('layouts.app')

@section('title', 'Profile')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="{{ asset('css/custom-style.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="py-12 min-h-screen">
    <div class="max-w-4xl mx-auto px-6 sm:px-8 lg:px-10 space-y-8">

        <div class="bg-white p-10 rounded-2xl shadow-lg border border-gray-200">
            <header class="text-center mb-10">
                <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">{{ __('Profile Information') }}</h2>
                <p class="mt-4 text-lg text-gray-600">
                    {{ __("Here is your profile information.") }}
                </p>
            </header>

            @if (session('success'))
                <div class="mb-8 text-green-800 bg-green-100 border border-green-300 rounded-lg p-5 text-center font-semibold shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-8 items-center">
                <div class="flex justify-center">
                    <img src="{{ $user->foto ? Storage::url($user->foto) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=random&size=128' }}" 
                        alt="{{ $user->name }}" class="w-36 h-36 rounded-full object-cover shadow-xl border-4 border-indigo-500">
                </div>

                <div class="sm:col-span-2 space-y-6">
                    <div>
                        <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wide">{{ __('Role') }}</h3>
                        <p class="mt-1 text-xl font-semibold text-gray-900">{{ $user->role }}</p>
                    </div>

                    <div>
                        <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wide">{{ __('Display Name') }}</h3>
                        <p class="mt-1 text-xl font-semibold text-gray-900">{{ $user->name }}</p>
                    </div>

                    <div>
                        <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wide">{{ __('Username') }}</h3>
                        <p class="mt-1 text-xl font-semibold text-gray-900">{{ $user->username }}</p>
                    </div>

                    <div>
                        <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wide">{{ __('Email') }}</h3>
                        <p class="mt-1 text-xl font-semibold text-gray-900">{{ $user->email }}</p>
                    </div>

                    <div>
                        <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wide">{{ __('Birth Date') }}</h3>
                        <p class="mt-1 text-xl font-semibold text-gray-900">{{ $user->birth_date ? \Carbon\Carbon::parse($user->birth_date)->format('F j, Y') : '-' }}</p>
                    </div>

                    <div>
                        <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wide">{{ __('About') }}</h3>
                        <p class="mt-1 text-gray-700 whitespace-pre-line text-lg">{{ $user->about ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <div class="mt-12 text-center">
                <a href="{{ route('profile.edit') }}" 
                   class="inline-block px-10 py-4 bg-indigo-600 text-white font-semibold rounded-full shadow-lg hover:bg-indigo-700 transition duration-300 ease-in-out">
                    {{ __('Edit Profile') }}
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
