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
                    Selamat Datang, 
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
                            <th class="px-6 py-4 text-center font-bold">No</th>
                            <th class="px-6 py-4 text-center font-bold">Competition</th>
                            <th class="px-6 py-4 text-center font-bold">Status</th>
                            <th class="px-6 py-4 text-center font-bold">Detail</th>
                            <th class="px-6 py-4 text-center font-bold">Delete</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-white/10 text-base">
                        
                        @forelse ($teams as $index => $team)
                        <tr class="hover:bg-white/5 transition" style="white-space: nowrap;">

                            <td class="px-6 py-4 text-center text-white/70">
                                {{ $index+1 }}
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
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center gap-2">
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
                            <td colspan="7" class="text-center py-6 text-white/50">
                                <i>Belum ada data team</i>
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

            <div style="margin-bottom:20px;">
                <label style="font-size:18px;">Competition</label><br>
                
                <select name="competition" id="kategori" class="form-input h40" required>
                    <option value="" disabled selected>Pilih cabang lomba</option>
                </select>
            
                <script>
                // Potong kata "House of " langsung dari Blade PHP
                const houseName = "{{ trim(str_replace('House of ', '', Auth::user()->house->name ?? 'Tim')) }}";

                const data = [
                    { val: "Basket Putra", label: "Basket Putra" },
                    { val: "Basket Putri", label: "Basket Putri" },
                    { val: "Futsal Putra", label: "Futsal Putra" },
                    { val: "Voli Putra", label: "Voli Putra" },
                    { val: "Badminton Ganda Putra", label: "Badminton Ganda Putra" },
                    { val: "Badminton Tunggal Putra", label: "Badminton Tunggal Putra" },
                    { val: "Badminton Ganda Campuran", label: "Badminton Ganda Campuran" },
                    
                    // Label otomatis ikut nama House yang sudah dipotong
                    { val: "E-sport 1", label: "E-sport 1" }, 
                    { val: "E-sport 2", label: "E-sport 2" },
                    
                    { val: "Poster", label: "Poster" },
                    { val: "Lukis", label: "Lukis" },
                    { val: "Dance", label: "Dance" },
                    { val: "Fotografi", label: "Fotografi" }
                ];

                const select = document.getElementById("kategori");

                select.insertAdjacentHTML(
                    "beforeend",
                    data.map(item => `<option value="${item.val}" style="color:black;">${item.label}</option>`).join("")
                );
                </script>

                @error('competition')
                    <div style="color:red; margin-top:6px;">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="modal-actions mt-4">
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