<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ubaya Games 2026</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/Logo_UG.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <style>
        @font-face {
            font-family: 'GameofThrones';
            src: url("{{ asset('assets/fonts/GameofThrones.ttf') }}") format('truetype');
            font-weight: normal;
            font-style: normal;
        }
        .font-heading {
            font-family: 'GameofThrones', serif !important;
        }
    </style>
</head>
<body 
    class="text-[#CBDCC1] font-['Georgia'] min-h-screen"
    style="
        background-image: url('{{ asset('assets/bg.jpg') }}');
        background-repeat: no-repeat;
        background-size: cover;
        background-position: center;"
>
    {{-- NAVBAR --}}
    <nav class="fixed top-0 left-0 w-full z-50 bg-black/40 backdrop-blur-md">
        <div class="w-full max-w-6xl mx-auto flex justify-center gap-10 py-4 text-xs sm:text-sm uppercase tracking-widest">
            <a href="{{ route('aboutus') }}" class="hover:text-yellow-400">About Us</a>
            <a href="{{ route('schedule') }}" class="hover:text-yellow-400">Schedule</a> {{-- Belum ada schedulenya --}}
            <a href="{{ route('house') }}" class="hover:text-yellow-400">House</a> {{-- Belum ada housenya --}}
        </div>
    </nav>

    {{-- CONTENT --}}
    <main class="pt-28">
        @yield('content')
    </main>
</body>
</html>