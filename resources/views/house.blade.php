@extends('layouts.app')

@section('content')

{{-- DATA FAKULTAS --}}
@php
    $houses = [
        ['name' => 'Bisnis dan Ekonomika', 'image' => 'bisnis.png', 'line_id' => 'christoper.eko', 'desc' => 'Strategi yang matang, presisi dalam membaca peluang, serta kemampuan mengambil keputusan cepat di bawah tekanan. House of Mercator mencerminkan jiwa pedagang dan pemimpin strategi yang mampu mengatur langkah dengan cermat, memanfaatkan setiap kesempatan, serta menyeimbangkan risiko dan keuntungan. Dalam kompetisi, mereka dikenal sebagai tim yang cerdas secara taktik, adaptif terhadap situasi permainan, dan mampu menentukan keputusan krusial pada momen penentu kemenangan.'],
        ['name' => 'Farmasi', 'image' => 'farmasi.png', 'line_id' => 'milkyoreooo', 'desc' => 'Mengutamakan akurasi, konsentrasi tinggi, serta pendekatan taktis dalam setiap langkah permainan. House of Elixir terinspirasi dari ketelitian seorang peracik yang memahami detail dan keseimbangan komponen untuk menghasilkan hasil terbaik. Dalam kompetisi, mereka tampil dengan fokus yang tajam, perhitungan yang presisi, serta strategi permainan yang terencana. Ketelitian dan kesabaran menjadi kekuatan utama dalam meraih kemenangan.'],
        ['name' => 'Hukum', 'image' => 'hukum.png', 'line_id' => 'jovanjet2006', 'desc' => 'MMenjunjung tinggi disiplin, keadilan, serta integritas dalam setiap tindakan. House of Justicia melambangkan semangat pembela kebenaran yang berpegang pada aturan dan sportivitas. Dalam pertandingan, mereka menunjukkan mental yang kuat, konsistensi dalam performa, serta komitmen terhadap permainan yang adil. Kekuatan mereka terletak pada keteguhan prinsip, ketahanan mental, dan kemampuan menjaga keseimbangan antara kompetisi dan etika.'],
        ['name' => 'Industri Kreatif', 'image' => 'indus kreatif.png', 'line_id' => 'shootingstars.', 'desc' => 'Mewakili kreativitas tanpa batas, keindahan estetika, serta inovasi dalam setiap penampilan. House of Creatio menonjolkan ekspresi artistik dan kemampuan menciptakan sesuatu yang unik dan memukau. Dalam kompetisi, mereka menghadirkan permainan yang dinamis, penuh gaya, serta formasi yang kreatif. Keunggulan mereka terletak pada kemampuan menggabungkan strategi dengan estetika sehingga menghasilkan performa yang menarik sekaligus efektif.'],
        ['name' => 'Kedokteran', 'image' => 'kedok.png', 'line_id' => 'alessandroo01', 'desc' => 'MMelambangkan kekuatan hidup, daya tahan, serta semangat untuk bangkit kembali dari setiap tantangan. House of Vitalis dikenal dengan ketahanan fisik dan mental yang tinggi, serta kemampuan untuk terus berjuang hingga akhir pertandingan. Dalam kompetisi, mereka menunjukkan resiliensi, semangat pantang menyerah, serta kemampuan pemulihan yang cepat. Tekad dan daya juang menjadi fondasi utama dalam meraih kemenangan.'],
        ['name' => 'Politeknik', 'image' => 'poltek.png', 'line_id' => 'yann.ryannn', 'desc' => 'Berfokus pada keterampilan praktis, kecepatan eksekusi, serta solusi nyata dalam setiap tantangan. House of Praxis mencerminkan semangat pembelajaran berbasis praktik dan penguasaan keterampilan langsung. Dalam kompetisi, mereka dikenal dengan tindakan cepat, strategi yang efisien, serta kemampuan menyelesaikan masalah secara praktis dan efektif. Keunggulan mereka terletak pada ketepatan tindakan dan kemampuan menerjemahkan rencana menjadi hasil nyata.'],
        ['name' => 'Psikologi', 'image' => 'psiko.png', 'line_id' => 'tiffany_2005', 'desc' => 'Menguasai permainan mental, analisis perilaku, serta kontrol emosi dalam situasi kompetitif. House of Arcana melambangkan pemahaman mendalam terhadap pikiran manusia dan dinamika tim. Dalam pertandingan, mereka mampu membaca situasi, memahami pola lawan, serta menjaga kestabilan emosi di bawah tekanan. Kombinasi antara kecerdasan strategi dan pengendalian diri membuat mereka unggul dalam permainan yang membutuhkan ketenangan dan ketajaman analisis.'],
        ['name' => 'Teknik', 'image' => 'teknik.png', 'line_id' => 'christo_albert', 'desc' => 'MMencerminkan kekuatan, struktur yang kokoh, serta kestabilan dalam setiap langkah. House of Fortis terinspirasi dari prinsip rekayasa dan perancangan yang terencana dengan baik. Dalam kompetisi, mereka dikenal sebagai tim yang solid, terorganisir, dan memiliki fondasi strategi yang kuat. Ketangguhan, koordinasi tim yang rapi, serta kestabilan performa menjadi kekuatan utama mereka dalam menghadapi berbagai tantangan.'],
        ['name' => 'Teknobiologi', 'image' => 'teknobio.png', 'line_id' => '10284618203982', 'desc' => 'Melambangkan kehidupan, pertumbuhan, serta kemampuan beradaptasi dengan lingkungan yang terus berubah. House of Vivens menggabungkan semangat eksplorasi ilmu kehidupan dengan pendekatan inovatif terhadap keberlanjutan. Dalam kompetisi, mereka menunjukkan fleksibilitas strategi, kemampuan berkembang dari pengalaman, serta sinergi yang kuat dengan dinamika permainan. Adaptabilitas dan perkembangan berkelanjutan menjadi ciri khas mereka.']
    ];
@endphp

<div class="flex flex-col min-h-screen w-full">

    {{-- LOGO UTAMA --}}
    <section class="w-full px-4 sm:px-6 mb-36 shrink-0 z-10">
        <div class="w-full max-w-6xl mx-auto flex flex-col items-center text-center">
            <img src="{{ asset('assets/homepage.png') }}" class="w-64 sm:w-80 md:w-96 mb-6">
        </div>
    </section>

    {{-- GRID HOUSE --}}
    <section class="w-full px-4 sm:px-6 mb-32 relative z-10 grow flex flex-col items-center">
        <div class="grid grid-cols-2 md:grid-cols-3 gap-6 sm:gap-8 w-full max-w-4xl shrink-0">
            @foreach($houses as $house)
                <div onclick="openModal('{{ $house['name'] }}', '{{ asset('assets/fakultas/' . $house['image']) }}', '{{ $house['desc'] }}', '{{ $house['line_id'] }}')" 
                     class="aspect-square bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl flex flex-col p-4 sm:p-6 cursor-pointer hover:bg-white/10 hover:-translate-y-2 transition-all duration-300 group">
                    <div class="relative w-full flex-1 mb-4">
                        <img src="{{ asset('assets/fakultas/' . $house['image']) }}" alt="{{ $house['name'] }}" class="absolute inset-0 w-full h-full object-contain object-center group-hover:scale-110 transition duration-300">
                    </div>
                    <h3 class="w-full text-white text-center text-[10px] sm:text-xs font-semibold tracking-wider uppercase transition shrink-0">
                        {{ $house['name'] }}
                    </h3>
                </div>
            @endforeach
        </div>
    </section>

    <div class="w-full mt-auto shrink-0 z-20 relative">
        @include('layouts.footer')
    </div>

</div>

{{-- POP-UP --}}
<div id="houseModal" class="fixed inset-0 z-[100] hidden items-center justify-center p-4">
    <div onclick="closeModal()" class="absolute inset-0 bg-black/80 backdrop-blur-sm"></div>
    
    <div class="relative bg-gray-900 border border-white/20 rounded-2xl w-full max-w-lg p-8 flex flex-col items-center text-center transform scale-95 opacity-0 transition-all duration-300" id="modalContent">
        <button onclick="closeModal()" class="absolute top-4 right-4 text-gray-400 hover:text-white transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <div class="w-24 h-24 sm:w-32 sm:h-32 mb-6">
            <img id="modalImage" src="" alt="House Logo" class="w-full h-full object-contain">
        </div>
        <h2 id="modalTitle" class="text-2xl font-bold text-yellow-500 uppercase tracking-widest mb-4">Nama House</h2>
        
        <div class="w-16 h-1 bg-yellow-500/50 mb-6 rounded-full"></div>
        
        {{-- DESKRIPSI --}}
        <p id="modalDesc" class="text-sm sm:text-base text-gray-300 leading-relaxed text-justify mb-8"></p>

        {{-- LINE CONTACT AREA (Di bawah penjelasan) --}}
        <div class="flex items-center gap-3 bg-white/5 px-4 py-2 rounded-lg border border-white/10">
            <img src="{{ asset('assets/icons/line.png') }}" class="w-6 h-6 object-contain" alt="Line Icon">
            <div class="text-left">
                <p class="text-[10px] uppercase text-gray-500 font-bold leading-none mb-1">Contact Person</p>
                <p id="modalLineInfo" class="text-sm text-white font-semibold leading-none"></p>
            </div>
        </div>
    </div>
</div>

<script>
    const modal = document.getElementById('houseModal');
    const modalContent = document.getElementById('modalContent');
    const modalImage = document.getElementById('modalImage');
    const modalTitle = document.getElementById('modalTitle');
    const modalDesc = document.getElementById('modalDesc');
    const modalLineInfo = document.getElementById('modalLineInfo');

    function openModal(name, imageSrc, desc, cp, lineId) {
        modalTitle.innerText = name;
        modalImage.src = imageSrc;
        modalDesc.innerText = desc;
        modalLineInfo.innerText = cp;

        modal.classList.remove('hidden');
        modal.classList.add('flex');
        
        setTimeout(() => {
            modalContent.classList.remove('scale-95', 'opacity-0');
            modalContent.classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    function closeModal() {
        modalContent.classList.remove('scale-100', 'opacity-100');
        modalContent.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }, 300);
    }
</script>
@endsection