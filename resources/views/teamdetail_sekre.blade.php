@extends('layouts.app')

@section('content')

<section class="w-full px-4 sm:px-6 mb-36">
    <div class="w-full max-w-6xl mx-auto">

        {{-- ================= TEAM DETAIL ================= --}}
        <section class="mb-24">

            <header class="mb-6">
                <h2 class="text-xl sm:text-2xl font-heading font-bold text-white uppercase tracking-widest">
                    Team Detail
                </h2>

                <a href="{{ route('teamlist.sekre') }}"
                   class="inline-block mt-2 text-lg text-white/75 hover:text-white transition">
                    ← Back
                </a>
            </header>

            <div class="bg-black/60 backdrop-blur-md border border-white/10 rounded-2xl shadow-xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-base text-white whitespace-nowrap">
                        <thead class="bg-white/5 text-sm uppercase tracking-widest">
                            <tr>
                                <th class="px-6 py-4 text-center">ID</th>
                                <th class="px-6 py-4 text-left">Team Name</th>
                                <th class="px-6 py-4 text-center">House</th>
                                <th class="px-6 py-4 text-center">Competition</th>
                                <th class="px-6 py-4 text-center">Status</th>
                                <th class="px-6 py-4 text-center">Notes</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-white/10">
                            <tr>
                                <td class="px-6 py-4 text-center">
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
                                                class="bg-white text-black px-2 py-1 rounded">
                                            <option value="Menunggu" {{ $team->status=='Menunggu'?'selected':'' }}>
                                                Menunggu
                                            </option>
                                            <option value="Ditolak" {{ $team->status=='Ditolak'?'selected':'' }}>
                                                Ditolak
                                            </option>
                                            <option value="Diterima" {{ $team->status=='Diterima'?'selected':'' }}>
                                                Diterima
                                            </option>
                                        </select>
                                    </form>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex justify-center">
                                        <button
                                            onclick="openRevisionModal('team', {{ $team->id }}, `{{ $team->revision }}`)"
                                            class="px-3 py-1.5 rounded-lg bg-yellow-500/20 hover:bg-yellow-500/40 text-yellow-200 hover:text-white transition text-sm border border-yellow-500/20">
                                            <i data-feather="edit"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </section>

        <div class="my-24 border-t border-white/10"></div>

        {{-- ================= PLAYER LIST ================= --}}
        <section class="mb-24">

            <header class="mb-8">
                <h2 class="text-xl sm:text-2xl font-heading font-bold text-white uppercase tracking-widest">
                    Player List
                </h2>
            </header>

            <div class="bg-black/60 backdrop-blur-md border border-white/10 rounded-2xl shadow-xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-base text-white whitespace-nowrap">
                        <thead class="bg-white/5 text-sm uppercase tracking-widest">
                            <tr>
                                <th class="px-6 py-4 text-left">Player</th>
                                <th class="px-6 py-4 text-center">Detail</th>
                                <th class="px-6 py-4 text-center">Status</th>
                                <th class="px-6 py-4 text-center">Notes</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-white/10">
                            @foreach($players as $player)
                                <tr>
                                    <td class="px-6 py-4">
                                        {{ $player->name }}
                                    </td>

                                    <td class="px-6 py-4 text-center">
                                        <button
                                            class="openPlayerDetail bg-white/10 px-3 py-1 rounded"
                                            data-name="{{ $player->name }}"
                                            data-nrp="{{ $player->nrp }}"
                                            data-major="{{ $player->major }}"
                                            data-whatsapp="{{ $player->whatsapp }}"
                                            data-mobilelegend="{{ $player->mobilelegend }}"
                                            data-status="{{ $player->status }}"
                                            data-ktm="{{ $player->ktm_photo }}">
                                            <i data-feather="info"></i>
                                        </button>
                                    </td>

                                    <td class="px-6 py-4 text-center">
                                        <form action="{{ route('participants.updateStatus',$player->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <select name="status"
                                                    onchange="this.form.submit()"
                                                    class="bg-white text-black px-2 py-1 rounded">
                                                <option value="Menunggu" {{ $player->status=='Menunggu'?'selected':'' }}>
                                                    Menunggu
                                                </option>
                                                <option value="Ditolak" {{ $player->status=='Ditolak'?'selected':'' }}>
                                                    Ditolak
                                                </option>
                                                <option value="Diterima" {{ $player->status=='Diterima'?'selected':'' }}>
                                                    Diterima
                                                </option>
                                            </select>
                                        </form>
                                    </td>

                                    <td class="px-6 py-4 text-center">
                                        <div class="flex justify-center">
                                            <button
                                                onclick="openRevisionModal('player', {{ $player->id }}, '{{ $player->revision }}')"
                                                class="px-3 py-1.5 rounded-lg bg-yellow-500/20 hover:bg-yellow-500/40 text-yellow-200 hover:text-white transition text-sm border border-yellow-500/20">
                                                <i data-feather="edit"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </section>

        <div class="my-24 border-t border-white/10"></div>

        {{-- ================= CREW LIST ================= --}}
        <section>

            <header class="mb-8">
                <h2 class="text-xl sm:text-2xl font-heading font-bold text-white uppercase tracking-widest">
                    Crew List
                </h2>
            </header>

            <div class="bg-black/60 backdrop-blur-md border border-white/10 rounded-2xl shadow-xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-base text-white whitespace-nowrap">
                        <thead class="bg-white/5 text-sm uppercase tracking-widest">
                            <tr>
                                <th class="px-6 py-4 text-left">Crew</th>
                                <th class="px-6 py-4 text-center">Role</th>
                                <th class="px-6 py-4 text-center">Detail</th>
                                <th class="px-6 py-4 text-center">Status</th>
                                <th class="px-6 py-4 text-center">Notes</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-white/10">
                            @foreach($crews as $crew)
                                <tr>
                                    <td class="px-6 py-4">
                                        {{ $crew->crew->name }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        {{ $crew->crew->role }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <button class="openCrewDetail bg-white/10 px-3 py-1 rounded">
                                            Detail
                                        </button>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <form action="{{ route('crews.updateStatus',$crew->crew->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <select name="status"
                                                    onchange="this.form.submit()"
                                                    class="bg-white text-black px-2 py-1 rounded">
                                                <option value="Menunggu" {{ $crew->crew->status=='Menunggu'?'selected':'' }}>
                                                    Menunggu
                                                </option>
                                                <option value="Ditolak" {{ $crew->crew->status=='Ditolak'?'selected':'' }}>
                                                    Ditolak
                                                </option>
                                                <option value="Diterima" {{ $crew->crew->status=='Diterima'?'selected':'' }}>
                                                    Diterima
                                                </option>
                                            </select>
                                        </form>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex justify-center">
                                            <button
                                                onclick="openRevisionModal('crew', {{ $crew->crew->id }}, `{{ $crew->crew->revision }}`)"
                                                class="px-3 py-1.5 rounded-lg bg-yellow-500/20 hover:bg-yellow-500/40 text-yellow-200 hover:text-white transition text-sm border border-yellow-500/20">
                                                <i data-feather="edit"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </section>

    </div>
</section>

{{-- ================= MODAL REVISION ================= --}}
<div id="revisionModal" class="modal-overlay">
    <div class="modal-card">
        <h2 class="modal-title">Revision Notes</h2>

        <form method="POST" action="{{ route('teams.updateRevision') }}" id="revisionForm">
            @csrf
            <input type="hidden" name="id" id="revision_id">

            <div style="margin-bottom:20px;">
                <label style="font-size:18px;">Notes</label>
                <br>
                <textarea name="revision" id="revision_text" class="form-input" style="height:120px;"></textarea>
            </div>

            <div class="modal-actions">
                <button type="button" onclick="closeRevisionModal()" class="btn btn-cancel">Cancel</button>
                <button type="submit" class="btn btn-primary">Save Notes</button>
            </div>
        </form>
    </div>
</div>

{{-- POP UP DETAIL PLAYER --}}
<div id="playerDetailModal" class="modal-overlay" style="display:none;">

    <div class="modal-card">

        <!-- TITLE -->
        <h2 class="modal-title">Detail Player</h2>

        <!-- FORM (readonly) -->
        <form>

            <!-- Player Name -->
            <div style="margin-bottom:10px;">
                <label style="font-size:16px;opacity:1;">
                    Player Name
                </label><br>

                <input type="text" id="modalName" 
                       class="form-input h35" 
                       readonly>
            </div>

            <!-- NRP -->
            <div style="margin-bottom:10px;">
                <label style="font-size:16px;opacity:1;">
                    NRP
                </label><br>

                <input type="text" id="modalNRP" 
                       class="form-input h35" 
                       readonly>
            </div>

            <!-- Major -->
            <div style="margin-bottom:10px;">
                <label style="font-size:16px;opacity:1;">
                    Major
                </label><br>

                <input type="text" id="modalMajor" 
                       class="form-input h35" 
                       readonly>
            </div>

            <!-- KTM -->
            <div style="margin-bottom:10px;">
                <label style="font-size:16px;opacity:1;">
                    KTM:  
                    <a href="#" target="_blank" id="modalKTM"
                        class="text-blue-400 underline">
                        View KTM
                    </a>
                </label><br>               
            </div>

            <!-- WhatsApp -->
            <div style="margin-bottom:10px;">
                <label style="font-size:16px;opacity:1;">
                    Whatsapp Number
                </label><br>

                <input type="text" id="modalWhatsapp" 
                       class="form-input h35" 
                       readonly>
            </div>

            <!-- Status -->
            <div style="margin-bottom:16px;">
                <label style="font-size:16px;opacity:1;">
                    Status
                </label><br>

                <input type="text" id="modalStatus" 
                       class="form-input h35" 
                       readonly>
            </div>
            <!-- Mobile Legend -->
            <div style="margin-bottom:16px;">
                <label style="font-size:16px;opacity:1;">
                    ID Mobile Legend
                    @if ($team->competition !== 'E-sport')
                        <span style="opacity:0.5;">(optional)</span>
                    @endif
                </label><br>
                <input type="text" id="modalMobilelegend" 
                        class="form-input h35"
                        readonly>
            </div>    
            <!-- BUTTON -->
            <div style="display:flex; justify-content:flex-end; gap:8px;">
                <button type="button" 
                        id="closePlayerModal" 
                        class="btn btn-cancel hover:bg-gray-500">
                    Close
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openRevisionModal(type, id, revision)
    {
        document.getElementById('revisionModal').style.display = "flex";

        let idInput = document.getElementById('revision_id');
        idInput.value = id;
        
        document.getElementById('revision_text').value = revision ?? '';
        
        // BARIS INI DIHAPUS agar tidak error:
        // document.getElementById('revision_type').value = type;

        const form = document.getElementById('revisionForm');

        if(type === 'team')
        {
            form.action = "{{ route('teams.updateRevision') }}";
            idInput.name = 'team_id'; // Untuk TeamController
        }
        else if(type === 'player')
        {
            form.action = "{{ route('participants.updateRevision') }}";
            idInput.name = 'id'; // Untuk ParticipantController
        }
        else if(type === 'crew')
        {
            form.action = "{{ route('crews.updateRevision', 0) }}".replace('/0', '/' + id);
            idInput.name = 'id';
        }
    }

    function closeRevisionModal()
    {
        document.getElementById('revisionModal').style.display = "none";
    }

    //Detail Player
    const detailButtons = document.querySelectorAll('.openPlayerDetail');
    const modal = document.getElementById('playerDetailModal');
    const closeBtn = document.getElementById('closePlayerModal');

    detailButtons.forEach(btn => {
        btn.addEventListener('click', () => {

            document.getElementById('modalName').value = btn.dataset.name || '-';
            document.getElementById('modalNRP').value = btn.dataset.nrp || '-';
            document.getElementById('modalMajor').value = btn.dataset.major || '-';
            document.getElementById('modalWhatsapp').value = btn.dataset.whatsapp || '-';
            document.getElementById('modalStatus').value = btn.dataset.status || '-';
            document.getElementById('modalMobilelegend').value = btn.dataset.mobilelegend || '-';

            // KTM PATH (storage)
            let ktmPath = btn.dataset.ktm;

            if (ktmPath) {
                let fullPath = `/storage/${ktmPath}`;
                document.getElementById('modalKTM').href = fullPath;                
            }

            modal.style.display = 'flex';
        });
    });

    closeBtn.addEventListener('click', () => {
        modal.style.display = 'none';
    });
</script>

<script src="https://unpkg.com/feather-icons"></script>
<script>
    feather.replace()
</script>

@endsection