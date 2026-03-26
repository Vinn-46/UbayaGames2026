<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubaya Games 2026</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/Logo_UG.png') }}">
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

        .custom-bg-responsive {
            background-color: #000000;
            background-image: url("{{ asset('assets/bgvertical.png') }}");
            background-attachment: fixed !important;
            background-size: cover !important;
            background-position: center !important; 
            background-repeat: no-repeat !important;
        }

        @media (min-width: 768px) {
            .custom-bg-responsive {
                background-image: url("{{ asset('assets/bghorizontal.png') }}");
                background-position: center bottom !important;
            }
        }

        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.2); border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: rgba(255, 255, 255, 0.4); }
    </style>
</head>
<body class="text-[#CBDCC1] font-['Georgia'] antialiased overflow-hidden custom-bg-responsive relative">
    <div class="fixed inset-0 bg-black/40 z-0"></div>
    <div class="flex h-screen w-full relative z-10">
        <div id="mobileOverlay" class="fixed inset-0 bg-black/80 z-40 hidden md:hidden backdrop-blur-sm transition-opacity"></div>
        <aside id="sidebar" class="fixed z-50 w-64 h-full bg-black/80 backdrop-blur-2xl border-r border-white/10 flex flex-col transition-transform transform -translate-x-full md:translate-x-0 duration-300">
            <div class="p-6 flex items-center justify-center border-b border-white/10 shrink-0 relative">
                <img src="{{ asset('assets/homepage.png') }}" alt="Logo UG" class="w-32 md:w-40 object-contain drop-shadow-[0_0_15px_rgba(255,255,255,0.2)]">
                <button id="closeSidebar" class="md:hidden absolute top-4 right-4 text-white/50 hover:text-white transition p-2">
                    <i data-feather="x"></i>
                </button>
            </div>

            <nav class="flex-1 px-4 py-8 space-y-2 overflow-y-auto">                
                @if(Auth::check() && Auth::user()->role === 'Sekretariat')
                    {{-- POV SEKRETARIAT --}}
                    <a href="{{ route('teamlist.sekre') }}" 
                       class="flex items-center gap-3 px-4 py-3 rounded-xl transition text-[#CBDCC1] hover:bg-white/10 hover:text-white border border-transparent">
                        <i data-feather="users" class="w-5 h-5"></i>
                        <span class="font-heading font-semibold tracking-wide">Team List</span>
                    </a>
                @elseif(Auth::check() && Auth::user()->role === 'Kontingen')

                    {{-- POV KONTINGEN --}}
                    <a href="{{ route('teamlist') }}" 
                       class="flex items-center gap-3 px-4 py-3 rounded-xl transition text-[#CBDCC1] hover:bg-white/10 hover:text-white border border-transparent">
                        <i data-feather="users" class="w-5 h-5"></i>
                        <span class="font-heading font-semibold tracking-wide">Team List</span>
                    </a>
                    <a href="{{ route('allplayer') }}" 
                       class="flex items-center gap-3 px-4 py-3 rounded-xl transition text-[#CBDCC1] hover:bg-white/10 hover:text-white border border-transparent">
                        <i data-feather="user" class="w-5 h-5"></i>
                        <span class="font-heading font-semibold tracking-wide">All Players</span>
                    </a>
                    <a href="{{ route('allcrews') }}" 
                       class="flex items-center gap-3 px-4 py-3 rounded-xl transition text-[#CBDCC1] hover:bg-white/10 hover:text-white border border-transparent">
                        <i data-feather="user" class="w-5 h-5"></i>
                        <span class="font-heading font-semibold tracking-wide">All Crews</span>
                    </a>                   
                @endif
                <a href="{{ route('schedule') }}" 
                       class="flex items-center gap-3 px-4 py-3 rounded-xl transition text-[#CBDCC1] hover:bg-white/10 hover:text-white border border-transparent">
                        <i data-feather="calendar" class="w-5 h-5"></i>
                        <span class="font-heading font-semibold tracking-wide">Schedule</span>
                    </a>
            </nav>

            <div class="p-6 border-t border-white/10 shrink-0">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-3 rounded-xl bg-red-600/20 text-red-400 border border-red-600/30 hover:bg-red-600 hover:text-white transition shadow-lg group">
                        <i data-feather="log-out" class="w-5 h-5 group-hover:-translate-x-1 transition-transform"></i>
                        <span class="font-bold tracking-wide uppercase text-sm">Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        {{-- MAIN CONTENT --}}
        <main class="flex-1 flex flex-col h-screen overflow-hidden relative w-full md:ml-64">
            
            <header class="md:hidden w-full bg-black/60 backdrop-blur-md border-b border-white/10 flex items-center justify-between p-4 z-30 shrink-0">
                <button id="openSidebar" class="text-white hover:text-yellow-400 transition p-2 bg-white/5 rounded-lg border border-white/10">
                    <i data-feather="menu"></i>
                </button>

                <div class="flex items-center gap-3">
                    <img src="{{ asset('assets/Logo_UG.png') }}" alt="UG" class="w-10 h-10 object-contain">
                </div>

            </header>

            <div class="flex-1 overflow-y-auto p-4 md:p-8 scroll-smooth relative z-10 w-full">
                
                {{-- FLASH MESSAGE --}}
                @if(session('success'))
                    <div id="flashMessage" class="w-full max-w-6xl mx-auto mb-6">
                        <div class="bg-green-600 text-white px-6 py-3 rounded-xl shadow-lg border border-green-400/20">
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
            </div>
        </main>
    </div>

    {{-- SCRIPT UNTUK MENU MOBILE --}}
    <script>
        feather.replace();

        const sidebar = document.getElementById('sidebar');
        const mobileOverlay = document.getElementById('mobileOverlay');
        const openSidebar = document.getElementById('openSidebar');
        const closeSidebar = document.getElementById('closeSidebar');

        function toggleMenu() {
            sidebar.classList.toggle('-translate-x-full');
            mobileOverlay.classList.toggle('hidden');
        }

        if(openSidebar) openSidebar.addEventListener('click', toggleMenu);
        if(closeSidebar) closeSidebar.addEventListener('click', toggleMenu);
        if(mobileOverlay) mobileOverlay.addEventListener('click', toggleMenu);
    </script>
</body>
</html>