@extends('layouts.sidebar')

@section('content')


<section class="w-full px-4 sm:px-6 mb-36">
    <div class="w-full max-w-6xl mx-auto">

        {{-- HEADER --}}
        <header class="mb-6 flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
            
            {{-- JUDUL KIRI --}}
            <h2 class="text-xl sm:text-2xl font-bold text-white font-heading uppercase tracking-widest">
                Team List
            </h2>

            {{-- BAGIAN KANAN --}}
            <div class="flex flex-col items-end gap-3">
                
                {{-- TEKS SELAMAT DATANG (Sudah benar) --}}
                <div class="text-[#CBDCC1] font-['Georgia'] text-sm sm:text-base text-right">
                    Haii, Selamat Datang 
                    <span class="text-white font-bold">
                        {{ Auth::user()->username ?? 'Admin' }}
                    </span>
                </div>

                {{-- TOMBOL ADD TEAM (Diperbaiki sesuai gambar 'tombol login.png') --}}
                <button id="openModal"
                    class="inline-flex items-center gap-2 px-5 py-2 text-white
                            bg-blue-600 hover:bg-blue-500 rounded-lg transition
                            shadow-lg shadow-blue-600/20 border border-blue-400/20">
                    
                    {{-- Teks menggunakan font Georgia agar sesuai tema --}}
                    <span class="font-bold font-['Georgia'] text-sm sm:text-base">Add Team</span>
                    
                    {{-- Icon Plus Square --}}
                    <i data-feather="plus-square" class="w-5 h-5"></i>
                </button>
            </div>

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
                        
                        @forelse ($teams as $team)
                        <tr class="hover:bg-white/5 transition" style="white-space: nowrap;">

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
                                {{ $team->status }}
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex justify-center gap-2">
                                    <!-- Detail Button -->
                                     <a 
                                     href="{{ route('teamdetail', ['id' => $team->id])}}" 
                                     class="shrink-0 px-3 py-1.5 rounded-lg bg-white/10 hover:bg-white/20 transition text-sm text-white border border-white/10" >
                                     <i data-feather="info"></i>
                                    </a>

                                    <!-- Delete Button -->
                                    <form action="{{ route('teams.destroy', $team->id) }}" 
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus team ini?')">
                                        @csrf
                                        @method('DELETE')

                                        <button 
                                            type="submit"
                                            class="shrink-0 px-3 py-1.5 rounded-lg bg-red-500/20 hover:bg-red-500/40 text-red-200 hover:text-white transition text-sm border border-red-500/20">
                                            <i data-feather="trash-2"></i>
                                        </button>
                                    </form>
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

<div id="teamModal" class="modal-overlay">
    <div class="modal-card">

        <h2 class="modal-title">Add Team</h2>

        <form method="POST" action="{{ route('teams.store') }}">
            @csrf

            <!-- Team Name -->
            <div style="margin-bottom:16px;">
                <label style="font-size:18px;">Team Name</label><br>
                <input type="text" name="name" class="form-input" required>
                @error('name')
                    <div style="color:red; margin-top:6px;">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Competition -->
            <div style="margin-bottom:20px;">
                <label style="font-size:18px;">Competition</label><br>
                <select name="competition" class="form-input h40" required>
                    <option style="color:black;" value="Basket Putra">Basket Putra</option>
                    <option style="color:black;" value="Basket Putri">Basket Putri</option>

                    <option style="color:black;" value="Futsal">Futsal</option>

                    <option style="color:black;" value="Voli Putra">Voli Putra</option>
                    <option style="color:black;" value="Voli Putri">Voli Putri</option>

                    <option style="color:black;" value="Badminton Ganda Putra">Badminton Ganda Putra</option>
                    <option style="color:black;" value="Badminton Ganda Putri">Badminton Ganda Putri</option>
                    <option style="color:black;" value="Badminton Ganda Campuran">Badminton Ganda Campuran</option>

                    <option style="color:black;" value="E-sport">E-sport</option>
                    <option style="color:black;" value="Poster">Poster</option>
                    <option style="color:black;" value="Lukis">Lukis</option>
                    <option style="color:black;" value="Dance">Dance</option>
                    <option style="color:black;" value="Fotografi">Fotografi</option>                    
                </select>

                @error('competition')
                    <div style="color:red; margin-top:6px;">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="modal-actions">
                <button type="button" id="closeModal" class="btn btn-cancel">
                    Cancel
                </button>
                <button type="submit" class="btn btn-primary">
                    Add Team
                </button>
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
<script src="https:unpkg.com/feather-icons"></script>
<script>
    feather.replace()
</script>
@if ($errors->any())
<script>
    document.getElementById('teamModal').style.display = 'flex';
</script>
@endif
@endsection