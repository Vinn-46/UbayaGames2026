@extends('layouts.app')

@section('content')

<style>
    @font-face {
        font-family: 'GameofThrones';
        src: url("{{ asset('assets/fonts/GameofThrones.ttf') }}") format('truetype');
        font-weight: normal;
        font-style: normal;
    }
    .font-heading {
        font-family: 'GameofThrones', serif !important;
    }
</style>


<section class="w-full px-4 sm:px-6 mb-36">
    <div class="w-full max-w-6xl mx-auto">

        {{-- HEADER --}}
        <header class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <h2 class="text-xl sm:text-2xl font-bold text-white font-heading uppercase tracking-widest">
                Team List
            </h2>

            {{-- ADD TEAM --}}
            <button id="openModal"
                class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white
                       bg-blue-600 hover:bg-blue-500 rounded-lg transition
                       shadow-lg shadow-blue-600/20 border border-blue-400/20">
                +
                Add Team
            </button>

        </header>

        {{-- TABLE --}}
        <div class="bg-black/60 backdrop-blur-md border border-white/10 rounded-2xl shadow-xl overflow-hidden w-full">
            <div class="overflow-x-auto">
                <table class="w-full text-base text-white" style="min-width: max-content;">
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

                    <tbody class="divide-y divide-white/10 text-base">
                        @php
                            $teams = [
                                ['id'=>1,'name'=>'Hahahhaha','house'=>'House of Arcana', 'competition'=>'Basket', 'status'=>'Menunggu'],
                                ['id'=>2,'name'=>'Beta Team','house'=>'House of Arcana', 'competition'=>'Dance', 'status'=>'Ditolak'],
                                ['id'=>3,'name'=>'Gamma Team','house'=>'House of Arcana', 'competition'=>'Basket','status'=>'Diterima'],
                                ['id'=>4,'name'=>'Delta Team','house'=>'House of Arcana', 'competition'=>'Badminton','status'=>'Diterima'],
                            ];
                        @endphp

                        @foreach ($teams as $team)
                        <tr class="hover:bg-white/5 transition" style="white-space: nowrap;">
                            <td class="px-6 py-4 text-center text-white/70">
                                {{ $team['id'] }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $team['name'] }}
                            </td>

                            <td class="px-6 py-4 text-center">
                                {{ $team['house'] }}
                            </td>

                            <td class="px-6 py-4 text-center">
                                {{ $team['competition'] }}
                            </td>

                            <td class="px-6 py-4 text-center">
                                {{ $team['status'] }}
                            </td>

                            {{-- ACTION --}}
                            <td class="px-6 py-4">
                                <div class="flex justify-center gap-2">
                                    <a href="{{ route('teamdetail') }}"
                                        class="shrink-0 px-3 py-1.5 rounded-lg
                                        bg-white/10 hover:bg-white/20
                                        transition text-sm text-white
                                        border border-white/10">
                                      Detail
                                    </a>


                                    <button
                                        class="shrink-0 px-3 py-1.5 rounded-lg
                                               bg-red-500/20 hover:bg-red-500/40
                                               text-red-200 hover:text-white
                                               transition text-sm
                                               border border-red-500/20">
                                        Delete Team
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</section>

<div id="teamModal" class="modal-overlay">
    <div class="modal-card">

        <!-- TITLE -->
        <h2 class="modal-title">Add Team</h2>

        <!-- FORM -->
        <form>

            <!-- Team Name -->
            <div style="margin-bottom:16px;">
                <label style="font-size:18px;opacity:1;">
                    Team Name
                </label><br>

                <input type="text" class="form-input">
            </div>

            <!-- Competition -->
            <div style="margin-bottom:20px;">
                <label style="font-size:18px;opacity:1;">
                    Competition
                </label><br>

                <select class="form-input h40">
                    <option style="color:black;">Basket</option>
                    <option style="color:black;">Dance</option>
                    <option style="color:black;">Badminton</option>
                </select>
            </div>

            <!-- BUTTONS -->
            <div class="modal-actions">
                <button id="closeModal" class="btn btn-cancel">Cancel</button>
                <button class="btn btn-primary">Add Team</button>
            </div>
        </form>
    </div>
</div>


<script>
document.addEventListener("DOMContentLoaded", function () {

    const openBtn = document.getElementById('openModal');
    const modal = document.getElementById('teamModal');
    const closeBtn = document.getElementById('closeModal');

    if(openBtn && modal){
        openBtn.onclick = () => modal.style.display = "flex";
    }

    if(closeBtn && modal){
        closeBtn.onclick = () => modal.style.display = "none";
    }

});
</script>
@endsection