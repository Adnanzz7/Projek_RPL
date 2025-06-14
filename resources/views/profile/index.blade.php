@extends('layouts.profile')

@section('title', 'Profil Pengguna')

@section('content')

<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>

<div class="py-12 max-w-7xl mx-auto px-6 space-y-12">
    <section class="bg-white p-6 rounded-2xl shadow-md space-y-6">
        <div class="flex flex-col lg:flex-row items-center gap-8">
            <!-- Foto Profil -->
            <div class="relative">
                <img src="{{ $user->foto ? Storage::url($user->foto) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=random&size=128' }}"
                    alt="{{ $user->name }}"
                    class="w-40 h-40 rounded-full object-cover ring-4 ring-indigo-500 shadow-md">
            </div>

            <div class="flex-1 text-gray-800 w-full space-y-6">
                <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">
                    @if (Auth::id() === $user->user_id)
                    <div class="mt-2 md:mt-0">
                        <a href="{{ route('profile.edit') }}"
                            class="inline-flex items-center gap-2 px-5 py-2 bg-indigo-600 text-white font-semibold rounded-full shadow hover:bg-indigo-700 transition">
                            <i class="bi bi-pencil-square text-base"></i> Edit Profil
                        </a>
                    </div>
                    @endif
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-4 text-sm text-gray-700">
                    <div class="space-y-3 self-end">
                        <h2 class="text-4xl font-bold text-indigo-600">{{ $user->name }}</h2>
                        <div class="flex items-center text-gray-600 gap-2">
                            <i class="bi bi-person-circle text-indigo-500"></i>
                            <span>{{ ucfirst($user->role) ?? '-' }}</span>
                        </div>
                        <div class="flex items-center text-gray-600 gap-2">
                            <i class="bi bi-person-fill-check text-indigo-500"></i>
                            <span>{{ '@' . $user->username }}</span>
                        </div>
                        <div class="flex items-center text-gray-600 gap-2">
                            <i class="bi bi-envelope-fill text-indigo-500"></i>
                            <span>{{ $user->email }}</span>
                        </div>                        
                        <div class="flex items-center text-gray-600 gap-2">
                            <i class="bi bi-cake2-fill text-indigo-500"></i>
                            <span>{{ $user->birth_date ? \Carbon\Carbon::parse($user->birth_date)->translatedFormat('d F Y') : '-' }}</span>
                        </div>
                    </div>

                    <div class="space-y-3 self-end">
                        <div class="flex items-center text-gray-600 gap-2">
                            <i class="bi bi-telephone-fill text-indigo-500"></i>
                            <span>{{ $user->phone ?? '-' }}</span>
                        </div>
                        <div class="flex items-center text-gray-600 gap-2">
                            <i class="bi bi-geo-alt-fill text-indigo-500"></i>
                            <span>{{ $user->alamat ?? '-' }}</span>
                        </div>
                        <div class="flex items-center text-gray-600 gap-2">
                            <i class="bi bi-info-circle-fill text-indigo-500 mt-0.5"></i>
                            <span>{{ $user->about ?? '-' }}</span>
                        </div>
                        <div class="flex items-center text-gray-600 gap-2">
                            <i class="bi bi-calendar-check-fill text-indigo-500"></i>
                            <span>Bergabung sejak {{ $user->created_at->translatedFormat('d F Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Dashboard Section --}}
    @if($user->role === 'user')
        @include('profile.partials.user-dashboard')
    @elseif($user->role === 'supplier')
        @include('profile.partials.supplier-dashboard', ['barangs' => $user->barangs])
    @elseif($user->role === 'admin')
        @include('profile.partials.admin-dashboard')
    @endif

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@endsection