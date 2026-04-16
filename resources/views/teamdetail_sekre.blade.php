@extends('layouts.sidebar')

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
                                            class="inline-flex px-3 py-1 text-xs font-semibold rounded-lg
                                                 bg-white/10 hover:bg-white/20 transition text-sm text-white border border-white/10">
                                            <i data-feather="edit"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>                    
                </div>
            </div>
            @foreach (['playerCount','utamaCount', 'playerAccept', 'crewAccept', 'koorcab', 'coach', 'asstCoach', 'medic'] as $field)
                @error($field, 'updateStatus')
                    <div style="color:red; margin-top:6px; text-align:right; font-size:18px;">
                        {{ $message }}
                    </div>
                @enderror
            @endforeach  
            @if ($team->revision!==null)
                <h2 class="text-xl sm:text-l font-heading font-bold text-white uppercase tracking-widest"
                    style="margin-top:20px;">
                    Revision Note
                </h2> 
                <textarea 
                    class="bg-black/60 hover:bg-white/5 border-none text-white p-2 rounded-lg transition resize-none"  
                    style="height:120px; margin-top:20px; width: 100%; padding: 15px; border-radius: 8px;" 
                    readonly>{{ $team->revision }}</textarea>
            @endif
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
                                <th class="px-6 py-4 text-center">No</th>
                                <th class="px-6 py-4 text-left">Player</th>
                                <th class="px-6 py-4 text-Center">Role</th>
                                <th class="px-6 py-4 text-center">Detail</th>
                                <th class="px-6 py-4 text-center">Status</th>
                                <th class="px-6 py-4 text-center">Notes</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-white/10">
                            @forelse($players as $index => $player)
                                <tr>
                                    <td class="px-6 py-4 text-center">
                                        {{ $index+1 }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $player->name }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        {{ $player->pivot->role }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <button type="button" 
                                            class="openPlayerDetail inline-flex px-3 py-1 text-xs font-semibold rounded-lg
                                                bg-white/10 hover:bg-white/20 transition text-sm text-white border border-white/10"
                                                data-name="{{ $player->name }}"
                                                data-nrp="{{ $player->nrp }}"
                                                data-major="{{ $player->major }}"
                                                data-ktm="{{ $player->ktm_photo }}"
                                                data-whatsapp="{{ $player->whatsapp }}"
                                                data-status="{{ $player->pivot->status ?? '-' }}"
                                                data-mobilelegend="{{ $player->mobilelegend }}"
                                                data-revision="{{ $player->pivot->revision }}"   
                                                data-role="{{ $player->pivot->role }}"   
                                                data-backnumber="{{ $player->pivot->back_number ?? '-' }}">                   
                                            <i data-feather="info"></i>
                                        </button>
                                    </td>

                                    <td class="px-6 py-4 text-center">
                                        <form action="{{ route('participants.updateStatus', [$player->id, $team->id]) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <select name="status"
                                                    onchange="this.form.submit()"
                                                    class="bg-white text-black px-2 py-1 rounded">
                                                <option value="Menunggu" {{ $player->pivot->status=='Menunggu'?'selected':'' }}>
                                                    Menunggu
                                                </option>
                                                <option value="Ditolak" {{ $player->pivot->status=='Ditolak'?'selected':'' }}>
                                                    Ditolak
                                                </option>
                                                <option value="Diterima" {{ $player->pivot->status=='Diterima'?'selected':'' }}>
                                                    Diterima
                                                </option>
                                            </select>
                                        </form>
                                    </td>

                                    <td class="px-6 py-4 text-center">
                                        <div class="flex justify-center">
                                            <button
                                                onclick="openRevisionModal('player', {{ $player->id }}, '{{ $player->revision }}')"
                                                class="inline-flex px-3 py-1 text-xs font-semibold rounded-lg
                                            bg-white/10 hover:bg-white/20 transition text-sm text-white border border-white/10">
                                                <i data-feather="edit"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-6 text-white/50">
                                    Belum ada data pemain
                                </td>
                            </tr>
                            @endforelse
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
                                <th class="px-6 py-4 text-center">No</th>
                                <th class="px-6 py-4 text-left">Crew</th>
                                <th class="px-6 py-4 text-center">Role</th>
                                <th class="px-6 py-4 text-center">Detail</th>
                                <th class="px-6 py-4 text-center">Status</th>
                                <th class="px-6 py-4 text-center">Notes</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-white/10">
                            @forelse($crews as $index => $crew)
                                <tr>
                                    <td class="px-6 py-4 text-center">
                                        {{ $index+1 }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $crew->name }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        {{ $crew->pivot->role }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <button type="button" 
                                                class="openCrewDetail inline-flex px-3 py-1 text-xs font-semibold rounded-lg
                                                    bg-white/10 hover:bg-white/20 transition text-sm text-white border border-white/10"
                                                    data-id="{{ $crew->crew_id }}"
                                                    data-name="{{ $crew->name }}"
                                                    data-whatsapp="{{ $crew->whatsapp }}"
                                                    data-role="{{ $crew->pivot->role }}"
                                                    data-nrp="{{ $crew->nrp ?? '-' }}"
                                                    data-major="{{ $crew->major ?? '-' }}"
                                                    data-ktm="{{ $crew->ktm_photo }}"
                                                    data-status="{{ $crew->pivot->status }}"
                                                    data-revision="{{ $crew->pivot->revision ?? '-' }}">    
                                                <i data-feather="info"></i>
                                        </button>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <form action="{{ route('crew.updateStatus', [$crew->id, $team->id]) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <select name="status"
                                                    onchange="this.form.submit()"
                                                    class="bg-white text-black px-2 py-1 rounded">
                                                <option value="Menunggu" {{ $crew->pivot->status=='Menunggu'?'selected':'' }}>
                                                    Menunggu
                                                </option>
                                                <option value="Ditolak" {{ $crew->pivot->status=='Ditolak'?'selected':'' }}>
                                                    Ditolak
                                                </option>
                                                <option value="Diterima" {{ $crew->pivot->status=='Diterima'?'selected':'' }}>
                                                    Diterima
                                                </option>
                                            </select>
                                        </form>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex justify-center">
                                            <button
                                                onclick="openRevisionModal('crew', {{ $crew->id }}, `{{ $crew->pivot->revision }}`)"
                                                class="inline-flex px-3 py-1 text-xs font-semibold rounded-lg
                                                    bg-white/10 hover:bg-white/20 transition text-sm text-white border border-white/10">
                                                <i data-feather="edit"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-6 text-white/50">
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

{{-- ================= MODAL REVISION ================= --}}
<div id="revisionModal" class="modal-overlay">
    <div class="modal-card">
        <h2 class="modal-title">Revision Notes</h2>

        <form method="POST" action="" id="revisionForm">
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

{{-- ================= POP UP DETAIL PLAYER ================= --}}
<div id="playerDetailModal" class="modal-overlay" style="display:none;">

    <div class="modal-card">

        <!-- TITLE -->
        <h2 class="modal-title">Detail Player</h2>

        <div class="modal-body">
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
                <div style="margin-bottom:10px;">
                    <label style="font-size:16px;opacity:1;">
                        Status
                    </label><br>

                    <input type="text" id="modalStatus" 
                        class="form-input h35" 
                        readonly>
                </div>

                <!-- Role -->                    
                <div style="margin-bottom:10px;">
                    <label style="font-size:16px;opacity:1;">
                        Role
                    </label><br>
                    <input type="text" id="modalRole" 
                        class="form-input h35" 
                        readonly>
                </div>

                <!-- Back Number -->
                @if (in_array($team->competition, ['Futsal', 'Basket Putra', 'Basket Putri', 'Voli Putra', 'Voli Putri']))
                    <div style="margin-bottom:10px;">
                        <label style="font-size:16px;opacity:1;">
                            Back Number
                        </label><br>

                        <input type="text" id="modalBackNumber" 
                            class="form-input h35" 
                            readonly>
                    </div>
                @endif
                
                <!-- Mobile Legend -->
                @if ($team->competition === 'E-sport')
                    <div style="margin-bottom:10px;">
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
                @endif    
                
                <!-- Revision -->
                <div style="margin-bottom:10px;">
                    <label style="font-size:16px;opacity:1;">
                        Revision                    
                    </label><br>
                    <textarea name="revision" id="modalRevision" 
                            class="form-input" style="height:80px;"
                            readonly>
                    </textarea>
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
</div>

{{-- ================= POP UP DETAIL CREW (BARU) ================= --}}
<div id="crewDetailModal" class="modal-overlay" style="display:none;">
    <div class="modal-card">
        <h2 class="modal-title">Detail Crew</h2>
        <div class="modal-body">
            <form>
                <div style="margin-bottom:10px;">
                    <label style="font-size:16px;opacity:1;">Crew Name</label><br>
                    <input type="text" id="modalCrewName" class="form-input h35" readonly>
                </div>

                <div style="margin-bottom:10px;">
                    <label style="font-size:16px;opacity:1;">Whatsapp Number</label><br>
                    <input type="text" id="modalCrewWhatsapp" class="form-input h35" readonly>
                </div>

                <div style="margin-bottom:10px;">
                    <label style="font-size:16px;opacity:1;">Role</label><br>
                    <input type="text" id="modalCrewRole" class="form-input h35" readonly>
                </div>

                <div style="margin-bottom:10px;">
                    <label style="font-size:16px;opacity:1;">NRP</label><br>
                    <input type="text" id="modalCrewNRP" class="form-input h35" readonly>
                </div>

                <div style="margin-bottom:10px;">
                    <label style="font-size:16px;opacity:1;">Major</label><br>
                    <input type="text" id="modalCrewMajor" class="form-input h35" readonly>
                </div>

                <div style="margin-bottom:10px;">
                    <label style="font-size:16px;opacity:1;">
                        KTM:
                        <a href="#" target="_blank" id="modalCrewKTM" class="text-blue-400 underline">
                            View KTM
                        </a>
                    </label>
                </div>

                <div style="margin-bottom:16px;">
                    <label style="font-size:16px;opacity:1;">Status</label><br>
                    <input type="text" id="modalCrewStatus" class="form-input h35" readonly>
                </div>
                <!-- Revision -->
                <div style="margin-bottom:10px;">
                    <label style="font-size:16px;opacity:1;">
                        Revision                    
                    </label><br>
                    <textarea name="revision" id="modalCrewRevision" 
                            class="form-input" style="height:80px;"
                            readonly>
                    </textarea>
                </div>  
                <div style="display:flex; justify-content:flex-end; gap:8px;">
                    <button type="button" id="closeCrewModal" class="btn btn-cancel hover:bg-gray-500">
                        Close
                    </button>
                </div>
            </form>
        </div>        
    </div>
</div>

<script>
    function openRevisionModal(type, id, revision)
    {
        document.getElementById('revisionModal').style.display = "flex";

        let idInput = document.getElementById('revision_id');
        idInput.value = id;
        
        document.getElementById('revision_text').value = revision ?? '';
        
        const form = document.getElementById('revisionForm');

        if (type === 'team')
        {
            form.action = "{{ route('teams.updateRevision') }}";
            idInput.name = 'team_id'; 
        }
        else if(type === 'player')
        {
            form.action= `/participants/${id}/teams/{{ $team->id }}/status`;
            idInput.name = 'id'; 
        }
        else if(type === 'crew')
        {
            form.action = `/crew/${id}/teams/{{ $team->id }}/status`;
            idInput.name = 'id';
        }
    }

    function closeRevisionModal()
    {
        document.getElementById('revisionModal').style.display = "none";
    }

    //================= LOGIC DETAIL PLAYER =================
    const detailButtons = document.querySelectorAll('.openPlayerDetail');
    const modal = document.getElementById('playerDetailModal');
    const closeBtn = document.getElementById('closePlayerModal');
       
    detailButtons.forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();

            document.getElementById('modalName').value = btn.dataset.name || '-';
            document.getElementById('modalNRP').value = btn.dataset.nrp || '-';
            document.getElementById('modalMajor').value = btn.dataset.major || '-';
            document.getElementById('modalWhatsapp').value = btn.dataset.whatsapp || '-';
            document.getElementById('modalStatus').value = btn.dataset.status || '-';            
            document.getElementById('modalRevision').value = btn.dataset.revision || '-';
            document.getElementById('modalRole').value = btn.dataset.role || '-';
            const mobileLegendInput = document.getElementById('modalMobilelegend');
            if (mobileLegendInput) {
                mobileLegendInput.value = btn.dataset.mobilelegend || '-';
            }
            const backNumberInput = document.getElementById('modalBackNumber');
            if (backNumberInput) {
                backNumberInput.value = btn.dataset.backnumber || '-';
            }
            // KTM PATH (storage)
            let ktmPath = btn.dataset.ktm;

            if (ktmPath) {
                let fullPath = `/storage/app/public/${ktmPath}`;
                document.getElementById('modalKTM').href = fullPath;                
            }

            modal.style.display = 'flex';
        });
    });

    if (closeBtn) {
        closeBtn.addEventListener('click', () => {
            modal.style.display = 'none';
        });
    }

    //================= LOGIC DETAIL CREW (BARU) =================
    const crewDetailBtns = document.querySelectorAll('.openCrewDetail');
    const crewDetailModal = document.getElementById('crewDetailModal');
    const closeCrewDetailBtn = document.getElementById('closeCrewModal');

    crewDetailBtns.forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();

            document.getElementById('modalCrewName').value     = btn.dataset.name     || '-';
            document.getElementById('modalCrewWhatsapp').value = btn.dataset.whatsapp || '-';
            document.getElementById('modalCrewRole').value     = btn.dataset.role     || '-';
            document.getElementById('modalCrewNRP').value      = btn.dataset.nrp      || '-';
            document.getElementById('modalCrewMajor').value    = btn.dataset.major    || '-';
            document.getElementById('modalCrewStatus').value   = btn.dataset.status   || '-';
            document.getElementById('modalCrewRevision').value = btn.dataset.revision || '-';
            
            let ktmPath = btn.dataset.ktm;
            let modalLink = document.getElementById('modalCrewKTM');
            if (ktmPath) {
                modalLink.href = `/storage/app/public/${ktmPath}`;
                modalLink.textContent = "View KTM"; // optional, reset text if needed
                modalLink.style.pointerEvents = "auto";  // ensure link is clickable
                modalLink.style.color = ""; // reset any styling
            }
            else{
                modalLink.href = "#"; // prevent navigation
                modalLink.textContent = "Tidak ada KTM"; 
                modalLink.style.pointerEvents = "none"; 
                modalLink.style.color = "gray"; 
            }                

            crewDetailModal.style.display = 'flex';
        });
    });

    if (closeCrewDetailBtn) {
        closeCrewDetailBtn.addEventListener('click', () => {
            crewDetailModal.style.display = 'none';
        });
    }
</script>

<script src="https://unpkg.com/feather-icons"></script>
<script>
    feather.replace()
</script>

@endsection