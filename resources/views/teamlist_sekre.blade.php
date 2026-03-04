@extends('layouts.app')

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


                                {{-- STATUS DROPDOWN --}}
                                <td class="px-6 py-4 text-center">

                                    <form
                                        action="{{ route('teams.updateStatus', $team->id) }}"
                                        method="POST"
                                    >
                                        @csrf
                                        @method('PUT')

                                        <select
                                            name="status"
                                            onchange="this.form.submit()"
                                            class="bg-white text-black border border-white/20 rounded px-2 py-1">
                                        >

                                            <option value="Menunggu"
                                                {{ $team->status == 'Menunggu' ? 'selected' : '' }}>
                                                Menunggu
                                            </option>

                                            <option value="Ditolak"
                                                {{ $team->status == 'Ditolak' ? 'selected' : '' }}>
                                                Ditolak
                                            </option>

                                            <option value="Diterima"
                                                {{ $team->status == 'Diterima' ? 'selected' : '' }}>
                                                Diterima
                                            </option>

                                        </select>

                                    </form>

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


                                        {{-- NOTES --}}
                                        <button
                                            onclick="openRevisionModal({{ $team->id }}, `{{ $team->revision }}`)"
                                            class="shrink-0 px-3 py-1.5 rounded-lg bg-yellow-500/20 hover:bg-yellow-500/40 text-yellow-200 hover:text-white transition text-sm border border-yellow-500/20"
                                        >
                                            <i data-feather="edit"></i>
                                        </button>

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



{{-- MODAL REVISION --}}
<div id="revisionModal" class="modal-overlay">

    <div class="modal-card">

        <h2 class="modal-title">
            Revision Notes
        </h2>

        <form method="POST" action="{{ route('teams.updateRevision') }}">

            @csrf

            <input
                type="hidden"
                name="team_id"
                id="team_id"
            >

            <div style="margin-bottom:20px;">

                <label style="font-size:18px;">
                    Notes
                </label>
                <br>

                <textarea
                    name="revision"
                    id="revision_text"
                    class="form-input"
                    style="height:120px;"
                ></textarea>

            </div>

            <div class="modal-actions">

                <button
                    type="button"
                    onclick="closeRevisionModal()"
                    class="btn btn-cancel"
                >
                    Cancel
                </button>

                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    Save Notes
                </button>

            </div>

        </form>

    </div>

</div>



<script>

function openRevisionModal(id, revision)
{
    document.getElementById('revisionModal').style.display = "flex";
    document.getElementById('team_id').value = id;
    document.getElementById('revision_text').value = revision ?? '';
}

function closeRevisionModal()
{
    document.getElementById('revisionModal').style.display = "none";
}

</script>


<script src="https://unpkg.com/feather-icons"></script>

<script>
    feather.replace()
</script>

@endsection