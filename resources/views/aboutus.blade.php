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


    {{-- HERO --}}
    <section class="w-full px-4 sm:px-6 mb-36">
        <div class="w-full max-w-6xl mx-auto flex flex-col items-center text-center">
            {{-- UBAH DISINI: Nilai lebarresponsif ditingkatkan untuk memperbesar logo --}}
            <img src="{{ asset('assets/homepage.png') }}" class="w-64 sm:w-80 md:w-96 mb-6">
        </div>
    </section>

    {{-- ABOUT --}}
    <section id="about" class="w-full px-4 sm:px-6 mb-32">
        <div class="w-full max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12">
            <div
                class="bg-black/30 backdrop-blur-md border border-white/10 p-6 md:p-8 rounded-2xl shadow-xl h-full flex flex-col justify-center reveal-left">
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
                <img src="{{ asset('assets/Foto1.png') }}"
                    class="w-full h-full object-cover hover:scale-105 transition duration-500">
            </div>
        </div>
    </section>

    {{-- WHISPER --}}
    <section class="w-full px-4 sm:px-6 mb-32">
        <div class="w-full max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12">
            <div class="w-full h-full min-h-[300px] rounded-2xl overflow-hidden shadow-xl border border-white/10">
                <img src="{{ asset('assets/foto2.png') }}"
                    class="w-full h-full object-cover hover:scale-105 transition duration-500">
            </div>
            <div
                class="bg-black/30 backdrop-blur-md border border-white/10 p-6 md:p-8 rounded-2xl shadow-xl h-full flex flex-col justify-center reveal-right">
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

    {{-- FOOTER / CONTACT & SPONSOR --}}
    <section class="w-full bg-black/30 py-16 px-4 sm:px-6">
        <div class="w-full max-w-6xl mx-auto flex flex-col">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-10 md:gap-0 text-xs sm:text-sm">
                {{-- KOLOM 1: CONTACT US --}}
                <div class="md:pr-8 md:border-r md:border-white/20 pb-12 flex flex-col items-center md:items-start">
                    <h3 class="mb-6 font-semibold text-yellow-500 tracking-widest uppercase">Contact Us</h3>
                    <ul class="space-y-4 text-gray-300">
                        <li class="flex items-center gap-3">
                            <img src="{{ asset('assets/icons/whatsapp.png') }}" alt="WhatsApp" class="w-5 h-5 object-contain">
                            <span>Tiara (083866142476)</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <img src="{{ asset('assets/icons/whatsapp.png') }}" alt="WhatsApp" class="w-5 h-5 object-contain">
                            <span>Jeje (081233508315)</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <img src="{{ asset('assets/icons/instagram.png') }}" alt="Instagram" class="w-5 h-5 object-contain">
                            <span>@ubayagames2026</span>
                        </li>
                    </ul>
                </div>

                {{-- KOLOM 2: SUPPORTED BY --}}
                <div class="md:col-span-2 md:border-r md:border-white/20 pb-12 flex flex-col items-center">
                    <h3 class="mb-6 font-semibold text-yellow-500 tracking-widest uppercase">Supported By</h3>
                    <div class="flex flex-col md:flex-row items-center justify-center gap-6 w-full">
                        <div class="h-14 sm:h-16 bg-white rounded-md flex items-center justify-center p-2">
                            <img src="{{ asset('assets/collab/Logo ubaya.jpg') }}" class="h-full w-auto object-contain" alt="Logo Ubaya">
                        </div>
                        <div class="flex flex-wrap items-center justify-center gap-4">
                            <div class="h-14 w-14 sm:h-16 sm:w-16 bg-white rounded-md flex items-center justify-center p-2">
                                <img src="{{ asset('assets/collab/Logo bem ubaya.jpg') }}" class="h-full w-full object-contain" alt="BEM Ubaya">
                            </div>
                            <div class="h-14 w-14 sm:h-16 sm:w-16 bg-white rounded-md flex items-center justify-center p-2">
                                <img src="{{ asset('assets/collab/Logo kabinet invictus.jpg') }}" class="h-full w-full object-contain" alt="Kabinet Invictus">
                            </div>
                            <div class="h-14 w-14 sm:h-16 sm:w-16 bg-white rounded-md flex items-center justify-center p-2">
                                <img src="{{ asset('assets/collab/Kementrian SeniBudaya.jpg') }}" class="h-full w-full object-contain" alt="Seni Budaya">
                            </div>
                            <div class="h-14 w-14 sm:h-16 sm:w-16 bg-white rounded-md flex items-center justify-center p-2">
                                <img src="{{ asset('assets/collab/Kementrian_Olahraga.jpg') }}" class="h-full w-full object-contain" alt="Olahraga">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- KOLOM 3: SPONSORED BY --}}
                <div class="md:pl-8 pb-12 flex flex-col items-center md:items-start">
                    <h3 class="mb-6 font-semibold text-yellow-500 tracking-widest uppercase">Sponsored By</h3>
                    <div class="flex flex-col gap-4">
                        <div class="h-12 w-32 sm:w-36 px-2 bg-white rounded-md flex items-center justify-center">
                            <img src="{{ asset('assets/sponsor/surken.png') }}" class="h-full w-full object-contain" alt="Surken Logo">
                        </div>
                    </div>
                </div>

            </div>
            <div class="w-full text-center mt-2">   
                <p class="text-[10px] text-gray-400">
                    &copy; Information Systems UBAYA GAMES 2026
                </p>
            </div>
        </div>
    </section>

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