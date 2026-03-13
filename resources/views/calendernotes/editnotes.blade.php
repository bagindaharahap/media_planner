@extends('layouts.app')

@section('title', 'Edit Catatan - PlannerX')

@section('content')

<div class="h-[calc(100vh-120px)] flex items-center justify-center bg-[#fcfdfe] p-4">
    <div class="bg-white w-full max-w-xl rounded-[2.5rem] shadow-2xl border border-slate-200 overflow-hidden">
        <!-- Header -->
        <div class="px-8 py-6 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center text-white shadow-lg">
                    <i class="fa-solid fa-pen-to-square"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-slate-800 tracking-tight">Perbarui Catatan</h3>
                    <p class="text-xs text-slate-500 font-medium uppercase tracking-widest">Edit ide atau memo Anda</p>
                </div>
            </div>
            <a href="{{ route('calendar.index') }}" class="w-10 h-10 rounded-full hover:bg-slate-200 flex items-center justify-center text-slate-400 transition-colors">
                <i class="fa-solid fa-xmark text-xl"></i>
            </a>
        </div>

        <!-- Form -->
        <form action="#" method="POST" class="p-8 space-y-6">
            @csrf
            @method('PUT')
            <div class="space-y-4">
                <!-- Judul -->
                <div class="space-y-2">
                    <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Judul Catatan</label>
                    <input 
                        type="text" 
                        name="title"
                        value="Ide Konten Ramadhan"
                        placeholder="Judul ide..." 
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-5 py-3 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-indigo-500 outline-none transition-all"
                        required
                    >
                </div>

                <!-- Isi -->
                <div class="space-y-2">
                    <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Isi Catatan</label>
                    <textarea 
                        name="content"
                        rows="5" 
                        placeholder="Tulis sesuatu..." 
                        class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-3 text-sm text-slate-600 focus:ring-2 focus:ring-indigo-500 outline-none transition-all"
                    >Buat konten tentang tips puasa sehat dan produktif selama bulan ramadhan. Fokus pada aspek kesehatan dan spiritual.</textarea>
                </div>

                <!-- Warna -->
                <div class="space-y-3">
                    <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1 block text-center">Ganti Warna Kategori</label>
                    <div class="flex justify-center gap-3">
                        <input type="radio" name="color" value="bg-indigo-500" id="color1" class="hidden">
                        <label for="color1" class="w-8 h-8 rounded-full bg-indigo-500 border-4 border-transparent opacity-60 hover:opacity-100 cursor-pointer transition-all hover:scale-110"></label>
                        
                        <input type="radio" name="color" value="bg-emerald-500" id="color2" class="hidden" checked>
                        <label for="color2" class="w-8 h-8 rounded-full bg-emerald-500 border-4 border-slate-200 scale-110 cursor-pointer transition-all"></label>
                        
                        <input type="radio" name="color" value="bg-amber-500" id="color3" class="hidden">
                        <label for="color3" class="w-8 h-8 rounded-full bg-amber-500 border-4 border-transparent opacity-60 hover:opacity-100 cursor-pointer transition-all hover:scale-110"></label>
                        
                        <input type="radio" name="color" value="bg-rose-500" id="color4" class="hidden">
                        <label for="color4" class="w-8 h-8 rounded-full bg-rose-500 border-4 border-transparent opacity-60 hover:opacity-100 cursor-pointer transition-all hover:scale-110"></label>
                        
                        <input type="radio" name="color" value="bg-purple-500" id="color5" class="hidden">
                        <label for="color5" class="w-8 h-8 rounded-full bg-purple-500 border-4 border-transparent opacity-60 hover:opacity-100 cursor-pointer transition-all hover:scale-110"></label>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="pt-6 border-t border-slate-100 flex gap-3">
                <a href="{{ route('calendar.index') }}" class="flex-1 py-3 text-sm font-bold text-slate-500 hover:bg-slate-200 rounded-2xl transition-all text-center">Batal</a>
                <button type="submit" class="flex-[2] bg-indigo-600 text-white py-3 rounded-2xl font-bold text-sm shadow-xl shadow-indigo-100 hover:bg-indigo-700 transition-all transform active:scale-95">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<script>
// Handle color selection
document.querySelectorAll('input[name="color"]').forEach(input => {
    input.addEventListener('change', function() {
        document.querySelectorAll('label[for^="color"]').forEach(label => {
            label.classList.remove('border-slate-200', 'scale-110');
            label.classList.add('border-transparent', 'opacity-60');
        });
        
        const label = document.querySelector(`label[for="${this.id}"]`);
        label.classList.add('border-slate-200', 'scale-110');
        label.classList.remove('border-transparent', 'opacity-60');
    });
});
</script>

@endsection