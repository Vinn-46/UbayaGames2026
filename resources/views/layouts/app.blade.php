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

        /* Setting Khusus HP */
        .custom-bg-responsive {
            background-image: url("{{ asset('assets/bgvertical.png') }}");
            background-attachment: fixed; 
            background-size: cover;
            background-position: center; 
            background-repeat: no-repeat;
        }

        /* Setting Khusus Laptop */
        @media (min-width: 768px) {
            .custom-bg-responsive {
                background-image: url("{{ asset('assets/bghorizontal.png') }}");
                background-position: center bottom !important;
            }
        }
    </style>
</head>

<body class="text-[#CBDCC1] font-['Georgia'] min-h-screen custom-bg-responsive">
    
    {{-- NAVBAR --}}
    <nav class="fixed top-0 left-0 w-full z-50 bg-black/40 backdrop-blur-md px-4 sm:px-6"> 
        <div class="relative w-full max-w-6xl mx-auto h-20 grid grid-cols-3 items-center text-xs sm:text-sm uppercase tracking-widest">

            {{-- Schedule --}}
            <div class="flex justify-end pr-4 sm:pr-8">
                <a href="{{ route('schedule') }}" class="hover:text-yellow-400 transition">
                    Schedule
                </a>
            </div>

            {{-- CENTER (Placeholder) --}}
            <div></div>

            {{-- House & LOGOUT --}}
            <div class="flex justify-between items-center w-full pl-4 sm:pl-8">
                
                <a href="{{ route('house') }}" class="hover:text-yellow-400 transition">
                    House
                </a>

                @if(request()->routeIs('teamlist'))
                    <form action="{{ route('logout') }}" method="POST" class="inline-flex">
                        @csrf
                        <button type="submit"
                            class="flex items-center gap-2 px-3 py-2 text-xs sm:text-sm font-bold text-white
                                   bg-red-600 hover:bg-red-500 rounded-lg transition
                                   shadow-lg shadow-red-600/20 border border-red-400/20">
                            <span class="hidden sm:inline">LOGOUT</span>
                            <i data-feather="log-out" class="w-4 h-4"></i>
                        </button>
                    </form>
                @else
                    <div></div> 
                @endif
            </div>

            {{-- LOGO ABSOLUTE CENTER --}}
            <a href="/" class="absolute left-1/2 -translate-x-1/2 top-1/2 -translate-y-1/2">
                <img src="{{ asset('assets/Logo_UG.png') }}" class="h-10 sm:h-12 object-contain">
            </a>
        </div>
    </nav>

    {{-- CONTENT --}}
    <main class="pt-28">
        {{-- FLASH MESSAGE --}}
        @if(session('success'))
            <div id="flashMessage"
                class="max-w-6xl mx-auto mb-6 px-4">
                <div class="bg-green-600 text-white px-6 py-3 rounded-xl shadow-lg">
                    {{ session('success') }}
                </div>
            </div>

            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    setTimeout(function () {
                        const flash = document.getElementById("flashMessage");
                        if (flash) {
                            flash.style.transition = "opacity 0.5s ease";
                            flash.style.opacity = "0";
                            setTimeout(() => flash.remove(), 500);
                        }
                    }, 3000);
                });
            </script>
        @endif

        @yield('content')
    </main>
</body>

</html>