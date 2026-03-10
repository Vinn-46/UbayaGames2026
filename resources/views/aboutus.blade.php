@extends('layouts.app')
@section('content')
    <style>
    .reveal-left {
        opacity: 0;
        transform: translateX(-80px);
        transition: all 0.8s ease;
    }

    .reveal-right {
        opacity: 0;
        transform: translateX(80px);
        transition: all 0.8s ease;
    }

    .reveal-left.show,
    .reveal-right.show {
        opacity: 1;
        transform: translateY(0);
    }
    </style>

    {{-- Bungkus semua konten agar bisa menggunakan flex col --}}
    <div class="flex flex-col min-h-[calc(100vh-112px)]"> 
        
        <div class="flex-grow">
            {{-- HERO --}}
            <section class="w-full px-4 sm:px-6 mb-36">
                <div class="w-full max-w-6xl mx-auto flex flex-col items-center text-center">
                    <img src="{{ asset('assets/homepage.png') }}" class="w-64 sm:w-80 md:w-96 mb-6">
                </div>
            </section>

            {{-- ABOUT --}}
            <section id="about" class="w-full px-4 sm:px-6 mb-32">
                <div class="w-full max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12">
                    <div class="bg-black/30 backdrop-blur-md border border-white/10 p-6 md:p-8 rounded-2xl shadow-xl h-full flex flex-col justify-center reveal-left">
                        <h2 class="mb-4 text-sm sm:text-lg font-bold text-white uppercase tracking-wide font-heading">
                            About Ubaya Games 2026
                        </h2>
                        <p class="text-xs sm:text-sm leading-relaxed text-gray-200 text-justify">
                            Ubaya Games merupakan ajang kompetisi olahraga dan seni bergengsi dua tahunan yang diselenggarakan oleh
                            BEM Universitas Surabaya melalui Kementerian Olahraga sebagai wadah utama bagi talenta mahasiswa lintas
                            fakultas dan politeknik. Pada tahun 2026, event ini bertransformasi dengan konsep House System yang
                            lebih profesional, di mana setiap fakultas hadir sebagai satu entitas kolektif dengan karakter dan
                            semangat juang yang khas. Melalui standar kompetisi yang terstruktur, Ubaya Games berkomitmen
                            meningkatkan sportivitas serta solidaritas, sekaligus menjadi platform pembinaan berkelanjutan untuk
                            mencetak atlet dan seniman berbakat dari lingkungan kampus.
                        </p>
                    </div>
                    <div class="w-full h-full min-h-[300px] rounded-2xl overflow-hidden shadow-xl border border-white/10">
                        <img src="{{ asset('assets/Foto1.png') }}" class="w-full h-full object-cover hover:scale-105 transition duration-500">
                    </div>
                </div>
            </section>

            {{-- WHISPER --}}
            <section class="w-full px-4 sm:px-6 mb-32">
                <div class="w-full max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12">
                    <div class="w-full h-full min-h-[300px] rounded-2xl overflow-hidden shadow-xl border border-white/10">
                        <img src="{{ asset('assets/foto2.png') }}" class="w-full h-full object-cover hover:scale-105 transition duration-500">
                    </div>
                    <div class="bg-black/30 backdrop-blur-md border border-white/10 p-6 md:p-8 rounded-2xl shadow-xl h-full flex flex-col justify-center reveal-right">
                        <h2 class="mb-4 text-sm sm:text-lg font-bold text-white uppercase tracking-wide font-heading">
                            Song Of The Fallen Crowns
                        </h2>
                        <p class="text-xs sm:text-sm text-gray-200 leading-relaxed text-justify">
                            Terinspirasi dari series Game Of Thrones yang memiliki 9 dynasty dan saling berperang, UBAYA juga
                            memiliki 9 fakultas dengan ciri khas sekaligus warnanya masing-masing. Maskot UG memakai mahkota dan
                            setiap diamond di mahkota tersebut mewakili setiap fakultas (9 diamonds). Tema ini menggambarkan sebuah
                            kisah kejayaan masa lalu yang kini jatuh, namun bangkit kembali melalui perjuangan baru. “Fallen Crowns”
                            melambangkan mahkota-mahkota yang pernah berjaya, sedangkan “Song” adalah simbol narasi perjalanan,
                            harapan, dan kebangkitan. Dengan demikian, Perlombaan adalah ajang di mana para peserta menulis ulang
                            kisah kejayaan mereka dengan membangkitkan kembali mahkota yang sempat jatuh dan menegakkan kembali
                            kehormatan masing-masing.
                        </p>
                    </div>
                </div>
            </section>

            {{-- MASKOT --}}
            <section class="w-full px-4 sm:px-6 mb-32">
                <div class="w-full max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12 items-center">
                    <div class="bg-black/30 backdrop-blur-md border border-white/10 p-6 md:p-8 rounded-2xl shadow-xl reveal-left">
                        <h2 class="mb-4 text-sm sm:text-lg font-bold text-white uppercase tracking-wide font-heading">
                            Penjelasan Maskot
                        </h2>
                        <p class="text-xs sm:text-sm text-gray-200 leading-relaxed text-justify">
                            Sebagai simbol supremasi, Kaiser hadir sebagai maskot Ubaya Games dalam wujud Manticore berzirah yang
                            merepresentasikan kekuatan multidimensi, keberanian, serta ketegasan pemimpin dalam menegakkan Novera’s
                            Laws. Kaiser memastikan bahwa seluruh konflik antar house diselesaikan tanpa pertumpahan darah,
                            melainkan melalui strategi dan ketangkasan dalam peristiwa agung dua tahunan ini. Setiap elemen pada
                            Kaiser memiliki makna mendalam: baju zirah sebagai pelindung kehormatan, pedang di dalam kantong
                            (pocket) sebagai simbol kekuatan yang terkendali dan sah, serta The Nine-Fold Crown—mahkota yang bukan
                            merupakan warisan, melainkan sebuah totem yang wajib direbut kembali oleh house terbaik melalui
                            pembuktian nyata di arena Ubaya Games.
                        </p>
                    </div>
                    <div class="flex justify-center w-full">
                        <img src="{{ asset('assets/Maskot_UG.png') }}" style="max-width: 400px; width: 100%;"
                            class="w-48 sm:w-64 md:w-80 drop-shadow-2xl hover:scale-105 transition duration-300">
                    </div>
                </div>
            </section>
        </div>

        {{-- CABANG LOMBA --}}
        <section class="w-full px-4 sm:px-6 mb-32">
            <h2 class="text-center text-sm sm:text-xl mb-10 font-bold text-white font-heading">Cabang Lomba</h2>
        
            <div class="relative w-full">
            <div class="w-full overflow-x-auto scrollbar-hide"
                style="scroll-padding-left: 50%;">
                <div class="flex flex-nowrap gap-4 md:gap-6 w-max mx-auto justify-center pb-4">
                    @php
                    $cabangs = [
                        ['name' => 'Basket',      'icon' => 'assets/icons/Basket.png'],
                        ['name' => 'Futsal',      'icon' => 'assets/icons/Futsal.png'],
                        ['name' => 'Voli',        'icon' => 'assets/icons/Volley.png'],
                        ['name' => 'Badminton',   'icon' => 'assets/icons/Badminton.png'],
                        ['name' => 'E-Sport',     'icon' => 'assets/icons/Esport.png'],
                        ['name' => 'Dance',       'icon' => 'assets/icons/Dance.png'],
                        ['name' => 'Fotografi',   'icon' => 'assets/icons/Fotografi.png'],
                        ['name' => 'Lukis',       'icon' => 'assets/icons/Melukis.png'],
                        ['name' => 'Poster',      'icon' => 'assets/icons/Poster.png'],
                    ];
                    @endphp          
                    @foreach ($cabangs as $namacabang)
                    <div class="w-[200px] sm:w-[240px] md:w-[280px]
                                flex-shrink-0 
                                bg-black/20 backdrop-blur-md border border-white/30 shadow-lg
                                rounded-2xl p-2 flex items-center justify-center aspect-square"> 
                                <img src="{{ asset($namacabang['icon']) }}"
                                    class="w-full h-full object-contain drop-shadow-md"
                                    style="width: 100% !important; height: 100% !important;" 
                                    alt="{{ $namacabang['name'] }}">
                    </div>
                    @endforeach  
                </div>
            </div>
            </div>
        </section>

        {{-- COLLABORATION --}}
        <section class="w-full px-4 sm:px-6 mb-24">
            <h2 class="text-center text-xs sm:text-sm tracking-widest mb-8 text-gray-300">
                In collaboration with
            </h2>
            <img src="{{ asset('assets/Collaboration.png') }}"
                alt="Collaboration Partners"
                class="mx-auto h-10 sm:h-14 md:h-18 object-contain">
        </section>

        {{-- 3. FOOTER (Pindahkan ke luar div konten) --}}
    <div class="w-full mt-auto">
        @include('layouts.footer')
    </div>

    </div>

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const elements = document.querySelectorAll('.reveal-left, .reveal-right');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('show');
                }
            });
        }, {
            threshold: 0.2
        });
        elements.forEach(el => observer.observe(el));
    });
    </script>
@endsection