@extends('layouts.app')

@section('title', 'Edit Catatan - PlannerX')

@section('content')

@php
    $color = $note->color ?? 'bg-indigo-500';
@endphp

<div class="h-[calc(100vh-120px)] flex items-center justify-center bg-[#fcfdfe] p-4">
    <div class="bg-white w-full max-w-xl rounded-[2.5rem] shadow-2xl border border-slate-200 overflow-hidden">
        <!-- Header -->
        <div class="px-8 py-6 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 {{ $color }} rounded-xl flex items-center justify-center text-white shadow-lg">
                    <i class="fa-solid fa-pen-to-square"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-slate-800 tracking-tight">Perbarui Catatan</h3>
                    <p class="text-xs text-slate-500 font-medium uppercase tracking-widest">Edit ide atau memo Anda</p>
                </div>
            </div>
            <a href="{{ route('calendar.notes.show', $note) }}" class="w-10 h-10 rounded-full hover:bg-slate-200 flex items-center justify-center text-slate-400 transition-colors">
                <i class="fa-solid fa-xmark text-xl"></i>
            </a>
        </div>

        <!-- Form -->
        <form action="{{ route('notes.update', $note) }}" method="POST" class="p-8 space-y-6">
            @csrf
            @method('PUT')
            <div class="space-y-4">
                <!-- Judul -->
                <div class="space-y-2">
                    <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Judul Catatan</label>
                    <input 
                        type="text" 
                        name="title"
                        value="{{ old('title', $note->title) }}"
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
                    >{{ old('content', $note->content) }}</textarea>
                </div>

                <!-- Tanggal -->
                <div class="space-y-2">
                    <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Tanggal</label>
                    <input 
                        type="date" 
                        name="date"
                        value="{{ old('date', $note->date) }}"
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-5 py-3 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-indigo-500 outline-none transition-all"
                        required
                    >
                </div>

                <!-- Warna -->
                <div class="space-y-3">
                    <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1 block text-center">Ganti Warna Kategori</label>
                    <div class="flex justify-center gap-3">
                        @foreach (['bg-indigo-500','bg-emerald-500','bg-amber-500','bg-rose-500','bg-purple-500'] as $idx => $c)
                            @php $id = 'color'.($idx+1); @endphp
                            <input type="radio" name="color" value="{{ $c }}" id="{{ $id }}" class="hidden" {{ old('color', $note->color) === $c ? 'checked' : '' }}>
                            <label for="{{ $id }}" class="w-8 h-8 rounded-full {{ $c }} border-4 cursor-pointer transition-all {{ old('color', $note->color) === $c ? 'border-slate-200 scale-110' : 'border-transparent opacity-60 hover:opacity-100 hover:scale-110' }}"></label>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="pt-6 border-t border-slate-100 flex gap-3">
                <a href="{{ route('calendar.notes.show', $note) }}" class="flex-1 py-3 text-sm font-bold text-slate-500 hover:bg-slate-200 rounded-2xl transition-all text-center">Batal</a>
                <button type="submit" class="flex-[2] bg-indigo-600 text-white py-3 rounded-2xl font-bold text-sm shadow-xl shadow-indigo-100 hover:bg-indigo-700 transition-all transform active:scale-95">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

@endsection
