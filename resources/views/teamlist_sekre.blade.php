@extends('layouts.sidebar')

@section('content')

<section class="w-full px-4 sm:px-6 mb-36">

    <div class="w-full max-w-6xl mx-auto">

        {{-- HEADER --}}
        <header class="mb-6 flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">

            {{-- JUDUL --}}
            <h2 class="text-xl sm:text-2xl font-bold text-white font-heading uppercase tracking-widest">
                Team List
            </h2>

            {{-- WELCOME --}}
            <div class="flex flex-col items-end gap-3">
                <div class="text-[#CBDCC1] font-['Georgia'] text-sm sm:text-base text-right">
                    Haii, Selamat Datang
                    <span class="text-white font-bold">
                        {{ Auth::user()->username ?? 'Sekretaris' }}
                    </span>
                </div>
            </div>

        </header>


        {{-- FILTER --}}
        <form method="GET" action="{{ route('teamlist.sekre') }}" class="mb-6 flex flex-col sm:flex-row gap-3">

            {{-- COMBO BOX 1: Filter By --}}
            <select id="filter_by" name="filter_by"
                    class="bg-black/60 border border-white/10 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-1 focus:ring-white/30">
                <option value="" disabled {{ !request('filter_by') ? 'selected' : '' }}>-- Filter By --</option>
                <option value="status"      {{ request('filter_by') === 'status'      ? 'selected' : '' }}>Status</option>
                <option value="competition" {{ request('filter_by') === 'competition' ? 'selected' : '' }}>Cabang Lomba</option>
                <option value="house"       {{ request('filter_by') === 'house'       ? 'selected' : '' }}>House</option>
            </select>

            {{-- COMBO BOX 2: Search Value --}}
            <select id="search" name="search"
                    class="flex-1 bg-black/60 border border-white/10 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-1 focus:ring-white/30">
            </select>

            {{-- BUTTON SEARCH --}}
            <button type="submit"
                    class="px-5 py-2 rounded-lg bg-white/10 hover:bg-white/20 border border-white/10 text-white text-sm font-semibold transition">
                Search
            </button>

            {{-- BUTTON RESET --}}
            @if(request('search'))
                <a href="{{ route('teamlist.sekre') }}"
                class="px-5 py-2 rounded-lg bg-white/5 hover:bg-white/10 border border-white/10 text-white/60 text-sm font-semibold transition">
                    Clear
                </a>
            @endif

        </form>


        {{-- TABLE --}}
        <div class="bg-black/60 backdrop-blur-md border border-white/10 rounded-2xl shadow-xl overflow-hidden w-full">

            <div class="overflow-x-auto">

                <table class="w-full text-base text-white" style="min-width: max-content;">

                    {{-- HEAD --}}
                    <thead class="bg-white/5 uppercase tracking-widest text-sm">
                        <tr>
                            <th class="px-6 py-4 text-center font-bold">ID</th>
                            <th class="px-6 py-4 text-left font-bold">Team Name</th>
                            <th class="px-6 py-4 text-center font-bold">House</th>
                            <th class="px-6 py-4 text-center font-bold">Competition</th>
                            <th class="px-6 py-4 text-center font-bold">Status</th>
                            <th class="px-6 py-4 text-center font-bold">Action</th>
                        </tr>
                    </thead>

                    {{-- BODY --}}
                    <tbody class="divide-y divide-white/10 text-base">

                        @forelse ($teams as $team)

                            <tr class="hover:bg-white/5 transition" style="white-space: nowrap;">

                                {{-- ID --}}
                                <td class="px-6 py-4 text-center text-white/70">
                                    {{ $team->id }}
                                </td>

                                {{-- TEAM NAME --}}
                                <td class="px-6 py-4">
                                    {{ $team->name }}
                                </td>

                                {{-- HOUSE --}}
                                <td class="px-6 py-4 text-center">
                                    {{ $team->house->name ?? '-' }}
                                </td>

                                {{-- COMPETITION --}}
                                <td class="px-6 py-4 text-center">
                                    {{ $team->competition }}
                                </td>

                                {{-- STATUS --}}
                                <td class="px-6 py-4 text-center">                                   
                                    {{ $team->status }}
                                </td>

                                {{-- ACTION --}}
                                <td class="px-6 py-4">

                                    <div class="flex justify-center gap-2">

                                        {{-- DETAIL --}}
                                        <a
                                            href="{{ route('teamdetail.sekre', ['id' => $team->id]) }}"
                                            class="shrink-0 px-3 py-1.5 rounded-lg bg-white/10 hover:bg-white/20 transition text-sm text-white border border-white/10"
                                        >
                                            <i data-feather="alert-circle"></i>
                                        </a>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="6" class="text-center py-6 text-white/50">
                                    Belum ada data team
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>
        </div>

    </div>
</section>


<script>

const options = {
        status: [
            'Menunggu',
            'Ditolak',
            'Diterima'
        ],
        competition: [
            'Basket Putra',
            'Basket Putri',
            'Futsal',
            'Voli Putra',
            'Voli Putri',
            'Badminton Ganda Putra',
            'Badminton Ganda Putri',
            'Badminton Ganda Campuran',
            'E-sport',
            'Poster',
            'Lukis',
            'Dance',
            'Fotografi'
        ],
        house: [
            'House of Elixir',
            'House of Justicia',
            'House of Mercator',
            'House of Praxis',
            'House of Arcana',
            'House of Fortis',
            'House of Vivens',
            'House of Creatio',
            'House of Vitalis'
        ]
    };

    const filterBy  = document.getElementById('filter_by');
    const searchBox = document.getElementById('search');
    const currentSearch = "{{ request('search') }}";

    function updateOptions(selectedFilter, selectedValue = null) {
        searchBox.innerHTML = '';

        // Tambah placeholder dulu
        const placeholder = document.createElement('option');
        placeholder.value = '';
        placeholder.textContent = '-- Pilih --';
        placeholder.disabled = true;
        placeholder.selected = !selectedValue;
        searchBox.appendChild(placeholder);

        (options[selectedFilter] || []).forEach(opt => {
            const el = document.createElement('option');
            el.value = opt;
            el.textContent = opt;
            if (selectedValue && opt === selectedValue) {
                el.selected = true;
            }
            searchBox.appendChild(el);
        });
    }

    // Inisialisasi saat halaman load
    updateOptions(filterBy.value, currentSearch || null);

    // Update saat combo box 1 berubah
    filterBy.addEventListener('change', function () {
        updateOptions(this.value);
    });

</script>


<script src="https://unpkg.com/feather-icons"></script>

<script>
    feather.replace()
</script>

@endsection