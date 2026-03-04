@extends('layouts.app')

@section('content')
<section class="w-full px-4 sm:px-6 mb-36">
    <div class="w-full max-w-6xl mx-auto">

        {{-- TEAM DETAIL --}}
        <section class="mb-24">
            <header class="mb-6">
                <h2 class="text-xl sm:text-2xl font-heading font-bold text-white uppercase tracking-widest">
                    Team Detail
                </h2> 
                <a href="{{ route('teamlist.sekre')}}" 
                   class="inline-block mt-2 text-lg text-white/75 hover:text-white transition">
                    ← Back
                </a>
            </header>

            <div class="bg-black/60 backdrop-blur-md border border-white/10 rounded-2xl shadow-xl overflow-hidden w-full">
                <div class="overflow-x-auto">
                    <table class="w-full text-base text-white whitespace-nowrap" style="min-width: max-content;">
                        <thead class="bg-white/5 text-sm uppercase tracking-widest">
                            <tr>
                                <th class="px-6 py-4 text-center font-semibold">ID</th>
                                <th class="px-6 py-4 text-left font-semibold">Team Name</th>
                                <th class="px-6 py-4 text-center font-semibold">House</th>
                                <th class="px-6 py-4 text-center font-semibold">Competition</th>
                                <th class="px-6 py-4 text-center font-semibold">Status</th>
                                <th class="px-6 py-4 text-center font-semibold">Notes</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-white/10">
                            <tr class="hover:bg-white/5 transition">
                                <td class="px-6 py-4 text-center text-white/70">
                                    {{ $team->id }}
                                </td>

                                <td class="px-6 py-4">
                                    {{ $team->name }}
                                </td>

                                <td class="px-6 py-4 text-center">
                                    {{ $team->house->name ?? '-' }}
                                </td>

                                <td class="px-6 py-4 text-center">
                                    {{ $team->competition }}
                                </td>

                                <td class="px-6 py-4 text-center">
                                    <form action="{{ route('teams.updateStatus',$team->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')

                                        <select name="status"
                                                onchange="this.form.submit()"
                                                class="bg-white text-black px-3 py-1 rounded">

                                            <option value="Menunggu"
                                                {{ $team->status=='Menunggu'?'selected':'' }}>
                                                Menunggu
                                            </option>

                                            <option value="Ditolak"
                                                {{ $team->status=='Ditolak'?'selected':'' }}>
                                                Ditolak
                                            </option>

                                            <option value="Diterima"
                                                {{ $team->status=='Diterima'?'selected':'' }}>
                                                Diterima
                                            </option>

                                        </select>
                                    </form>
                                </td>

                                <td class="px-6 py-4 text-center">
                                    {{ $team->revision ?? '-' }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>


        {{-- DIVIDER --}}
        <div class="my-24 border-t border-white/10"></div>


        {{-- PLAYER LIST --}}
        <section class="mb-24">
            <header class="mb-8">
                <h2 class="text-xl sm:text-2xl font-heading font-bold text-white uppercase tracking-widest">
                    Player List
                </h2>
            </header>

            <div class="bg-black/60 backdrop-blur-md border border-white/10 rounded-2xl shadow-xl overflow-hidden w-full">
                <div class="overflow-x-auto">
                    <table class="w-full text-base text-white whitespace-nowrap" style="min-width: max-content;">
                        <thead class="bg-white/5 text-sm uppercase tracking-widest">
                            <tr>
                                <th class="px-6 py-4 text-left font-semibold">Player Name</th>
                                <th class="px-6 py-4 text-center font-semibold">Details</th>
                                <th class="px-6 py-4 text-center font-semibold">Status</th>
                                <th class="px-6 py-4 text-center font-semibold">Notes</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-white/10">
                            @forelse ($players as $player)
                            <tr class="hover:bg-white/5 transition">

                                <td class="px-6 py-4">
                                    {{ $player->name }}
                                </td>

                                <td class="px-6 py-4 text-center">
                                    <a 
                                        class="openPlayerDetail inline-flex px-3 py-1 text-xs font-semibold rounded-lg
                                              bg-white/10 hover:bg-white/20 transition text-sm text-white border border-white/10"
                                              data-name="{{ $player->name }}"
                                              data-nrp="{{ $player->nrp }}"
                                              data-major="{{ $player->major }}"
                                              data-ktm="{{ $player->ktm_photo }}"
                                              data-whatsapp="{{ $player->whatsapp }}"
                                              data-status="{{ $player->status }}"
                                              data-mobilelegend="{{ $player->mobilelegend }}">
                                        <i data-feather="info"></i>
                                    </a>
                                </td>

                                <td class="px-6 py-4 text-center">
                                    {{ $player->status }}
                                </td>

                                <td class="px-6 py-4 text-center">
                                    {{ $player->revision ?? '-' }}
                                </td>

                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-6 text-white/50">
                                    Belum ada data pemain
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </section>


        {{-- DIVIDER --}}
        <div class="my-24 border-t border-white/10"></div>


        {{-- CREW LIST --}}
        <section>
            <header class="mb-8">
                <h2 class="text-xl sm:text-2xl font-heading font-bold text-white uppercase tracking-widest">
                    Crew List
                </h2>
            </header>

            <div class="bg-black/60 backdrop-blur-md border border-white/10 rounded-2xl shadow-xl overflow-hidden w-full">
                <div class="overflow-x-auto">
                    <table class="w-full text-base text-white whitespace-nowrap" style="min-width: max-content;">
                        <thead class="bg-white/5 text-sm uppercase tracking-widest">
                            <tr>
                                <th class="px-6 py-4 text-left font-semibold">Crew Name</th>
                                <th class="px-6 py-4 text-center font-semibold">Role</th>
                                <th class="px-6 py-4 text-center font-semibold">Details</th>
                                <th class="px-6 py-4 text-center font-semibold">Status</th>
                                <th class="px-6 py-4 text-center font-semibold">Notes</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-white/10">

                            @forelse ($crews as $crew)
                            <tr class="hover:bg-white/5 transition">

                                <td class="px-6 py-4">
                                    {{ $crew->crew->name }}
                                </td>

                                <td class="px-6 py-4 text-center">
                                    {{ $crew->crew->role }}
                                </td>

                                <td class="px-6 py-4 text-center">
                                    <a href="#"
                                    class="openCrewDetail inline-flex px-3 py-1 text-xs font-semibold rounded-lg
                                            bg-cyan-500/20 text-cyan-300 border border-cyan-500/20
                                            hover:bg-cyan-500/30 transition">
                                        Details
                                    </a>
                                </td>

                                <td class="px-6 py-4 text-center">
                                    {{ $crew->crew->status }}
                                </td>

                                <td class="px-6 py-4 text-center">
                                    {{ $crew->crew->revision ?? '-' }}
                                </td>

                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-6 text-white/50">
                                    Belum ada data crew
                                </td>
                            </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
            </div>
        </section>

    </div>
</section>
@endsection