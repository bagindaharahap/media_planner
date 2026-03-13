@extends('layouts.app')

@section('title', 'Buat Catatan Baru - PlannerX')

@section('content')

<div class="h-[calc(100vh-120px)] flex items-center justify-center bg-[#fcfdfe] p-4">
    <div class="bg-white w-full max-w-2xl rounded-[2.5rem] shadow-2xl border border-slate-200 overflow-hidden">
        <!-- Header -->
        <div class="px-8 py-6 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-emerald-600 rounded-xl flex items-center justify-center text-white shadow-lg">
                    <i class="fa-solid fa-note-sticky"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-slate-800 tracking-tight">Buat Catatan Baru</h3>
                    <p class="text-xs text-slate-500 font-medium uppercase tracking-widest">Tulis ide atau memo Anda</p>
                </div>
            </div>
            <a href="{{ route('calendar.index') }}" class="w-10 h-10 rounded-full hover:bg-slate-200 flex items-center justify-center text-slate-400 transition-colors">
                <i class="fa-solid fa-xmark text-xl"></i>
            </a>
        </div>

        <!-- Form -->
        <form action="#" method="POST" class="p-8 space-y-6">
            @csrf
            <div class="space-y-4">
                <div class="space-y-2">
                    <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Judul Catatan</label>
                    <input type="text" name="title" placeholder="Judul ide..." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-5 py-3 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-emerald-500 outline-none transition-all" required>
                </div>
                <div class="space-y-2">
                    <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Isi Catatan</label>
                    <textarea name="content" rows="4" placeholder="Tulis sesuatu..." class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-3 text-sm text-slate-600 focus:ring-2 focus:ring-emerald-500 outline-none transition-all"></textarea>
                </div>
                <div class="space-y-2">
                    <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1 block text-center">Warna Kategori</label>
                    <div class="flex justify-center gap-3">
                        <input type="radio" name="color" value="bg-indigo-500" id="color1" class="hidden" checked>
                        <label for="color1" class="w-8 h-8 rounded-full bg-indigo-500 border-4 border-slate-200 cursor-pointer transition-all hover:scale-110"></label>
                        
                        <input type="radio" name="color" value="bg-emerald-500" id="color2" class="hidden">
                        <label for="color2" class="w-8 h-8 rounded-full bg-emerald-500 border-4 border-transparent opacity-60 hover:opacity-100 cursor-pointer transition-all hover:scale-110"></label>
                        
                        <input type="radio" name="color" value="bg-amber-500" id="color3" class="hidden">
                        <label for="color3" class="w-8 h-8 rounded-full bg-amber-500 border-4 border-transparent opacity-60 hover:opacity-100 cursor-pointer transition-all hover:scale-110"></label>
                        
                        <input type="radio" name="color" value="bg-rose-500" id="color4" class="hidden">
                        <label for="color4" class="w-8 h-8 rounded-full bg-rose-500 border-4 border-transparent opacity-60 hover:opacity-100 cursor-pointer transition-all hover:scale-110"></label>
                        
                        <input type="radio" name="color" value="bg-purple-500" id="color5" class="hidden">
                        <label for="color5" class="w-8 h-8 rounded-full bg-purple-500 border-4 border-transparent opacity-60 hover:opacity-100 cursor-pointer transition-all hover:scale-110"></label>
                    </div>
                </div>
                <input type="hidden" name="date" value="{{ request('date', date('Y-m-d')) }}">
            </div>

            <div class="pt-6 border-t border-slate-100 flex gap-3">
                <a href="{{ route('calendar.index') }}" class="flex-1 py-3 text-sm font-bold text-slate-500 hover:bg-slate-50 rounded-2xl transition-all text-center">Kembali</a>
                <button type="submit" class="flex-[2] bg-emerald-500 text-white py-3 rounded-2xl font-bold text-sm shadow-xl shadow-emerald-100 hover:bg-emerald-600 transition-all transform active:scale-95">Simpan Catatan</button>
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