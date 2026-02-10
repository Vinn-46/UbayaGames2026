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
            font-weight: normal ;
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
    >{{-- NAVBAR --}}
    <nav class="fixed top-0 left-0 w-full z-50 bg-black/40 backdrop-blur-md">

        <div class="relative w-full max-w-6xl mx-auto h-20 grid grid-cols-3 items-center text-xs sm:text-sm uppercase tracking-widest">

            {{-- LEFT --}}
            <div class="flex justify-end pr-0">
                <a href="{{ route('schedule') }}" class="hover:text-yellow-400 transition">
                    Schedule
                </a>
            </div>

            {{-- CENTER (empty, logo overlay) --}}
            <div></div>

            {{-- RIGHT --}}
            <div class="flex justify-start pl-0">
                <a href="{{ route('house') }}" class="hover:text-yellow-400 transition">
                    House
                </a>
            </div>

            {{-- LOGO ABSOLUTE CENTER --}}
            <a href="/" class="absolute left-1/2 -translate-x-1/2">
                <img src="{{ asset('assets/Logo_UG.png') }}" class="h-12 object-contain">
            </a>

        </div>

    </nav>






    {{-- CONTENT --}}
    <main class="pt-28">
        @yield('content')
    </main>
</body>
</html>