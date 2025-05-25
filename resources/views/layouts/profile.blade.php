<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'PKK Market')</title>

    {{-- Assets --}}
    @vite(['resources/ts/app.ts', 'resources/css/app.css'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link href="/src/styles.css" rel="stylesheet" />
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet" />
</head>

<body class="flex flex-col min-h-screen font-['Roboto'] bg-white bg-opacity-80 text-white bg-cover bg-center bg-no-repeat" style="background-image: url('{{ asset('storage/bg.jpg') }}');">    
    {{-- Navbar --}}
    <nav class="bg-indigo-700 shadow-lg px-6 py-4">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <img src="{{ asset('storage/logo.png') }}" alt="PKK Market Logo" class="h-12 w-12 object-contain">
                <a href="{{ route('barangs.index') }}" class="text-white text-2xl font-bold leading-tight">PKK Market</a>
            </div>
            <div class="flex items-center space-x-6">
                <a href="{{ route('profile.edit') }}" class="text-white hover:text-amber-400 transition flex items-center space-x-1 no-underline">
                    <i class="fas fa-user-edit"></i>
                    <span>Edit Profil</span>
                </a>
                <a href="{{ route('logout') }}"
                   class="text-white hover:text-red-400 transition flex items-center space-x-1 no-underline"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
            </div>
        </div>
    </nav>

    {{-- Main Content --}}
    <main class="flex-grow container mx-auto px-4 py-6 text-white">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-indigo-700 text-white py-6 mt-auto">
        <div class="container mx-auto text-center">
            <p class="text-sm">&copy; {{ date('Y') }} PKK Market. All rights reserved.</p>
            <div class="mt-4 flex justify-center space-x-4">
                <a href="mailto:info@smkn8jakarta.sch.id" title="Contact" class="text-white hover:text-blue-400 text-2xl">
                    <i class="fas fa-envelope"></i>
                </a>
                <a href="https://www.youtube.com/@Smkn8jkt" target="_blank" title="Youtube" class="text-white hover:text-red-600 text-2xl">
                    <i class="fab fa-youtube"></i>
                </a>
                <a href="https://www.facebook.com/smkn8jktofficial" target="_blank" title="Facebook" class="text-white hover:text-blue-600 text-2xl">
                    <i class="fab fa-facebook"></i>
                </a>
                <a href="https://www.instagram.com/delapanjkt" target="_blank" title="Instagram" class="text-white hover:text-pink-500 text-2xl">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="https://x.com/smkn8jkt" target="_blank" title="X (Formerly Twitter)" class="text-white hover:text-black text-2xl">
                    <i class="fab fa-x-twitter"></i>
                </a>
                <a href="https://wa.me/6285717281174" target="_blank" title="WhatsApp" class="text-white hover:text-green-500 text-2xl">
                    <i class="fab fa-whatsapp"></i>
                </a>
            </div>
        </div>
    </footer>
    @stack('scripts')
</body>
</html>