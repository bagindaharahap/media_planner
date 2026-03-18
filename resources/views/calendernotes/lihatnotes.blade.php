@extends('layouts.app')

@section('title', 'Detail Catatan - PlannerX')

@section('content')

@php
    $colorClass = $note->color ?? 'bg-emerald-500';
@endphp

<div class="h-[calc(100vh-120px)] flex items-center justify-center bg-[#fcfdfe] p-4">
    <div class="bg-white w-full max-w-xl rounded-[2.5rem] shadow-2xl border border-slate-200 overflow-hidden relative">
        <div class="h-3 w-full {{ $colorClass }}"></div>

        <div class="px-8 py-6 border-b border-slate-100 flex items-center justify-between bg-white">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl flex items-center justify-center text-white shadow-lg {{ $colorClass }}">
                    <i class="fa-solid fa-note-sticky text-xl"></i>
                </div>
                <div>
                    <h3 class="text-xl font-black text-slate-800 tracking-tight">{{ $note->title }}</h3>
                    <div class="flex items-center gap-2 mt-0.5">
                        <i class="fa-solid fa-calendar-day text-[10px] text-slate-400"></i>
                        <p class="text-[10px] text-slate-500 font-bold uppercase tracking-widest">{{ $note->date }}</p>
                    </div>
                </div>
            </div>
            <a href="{{ route('calendar.index') }}" class="w-10 h-10 rounded-full hover:bg-slate-100 flex items-center justify-center text-slate-400 transition-all">
                <i class="fa-solid fa-xmark text-lg"></i>
            </a>
        </div>

        <div class="p-8 space-y-6">
            <div class="flex items-center gap-3">
                <span class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Isi Catatan</span>
                <div class="h-px flex-1 bg-slate-100"></div>
                <div class="px-3 py-1 rounded-full text-[9px] font-black text-white uppercase tracking-tighter {{ $colorClass }}">
                    Memo
                </div>
            </div>

            <div class="relative group">
                <i class="fa-solid fa-quote-left absolute -top-4 -left-2 text-slate-100 text-4xl -z-10"></i>
                
                <div class="bg-slate-50/50 border border-slate-100 rounded-[2rem] p-6 min-h-[150px] relative overflow-hidden">
                    <div class="absolute inset-0 opacity-[0.03] pointer-events-none" style="background-image: radial-gradient(#475569 0.5px, transparent 0.5px); background-size: 10px 10px;"></div>
                    
                    <p class="text-slate-600 leading-relaxed text-sm whitespace-pre-wrap relative z-10">{{ $note->content }}</p>
                </div>
            </div>

            <div class="flex items-center justify-between px-2">
                <div class="flex -space-x-2">
                    <div class="w-6 h-6 rounded-full bg-slate-200 border-2 border-white flex items-center justify-center text-[8px] font-black text-slate-400">Me</div>
                </div>
                <p class="text-[9px] font-medium text-slate-400 italic">Terakhir diperbarui: {{ optional($note->updated_at)->format('d/m/Y') }}</p>
            </div>
        </div>

        <div class="px-8 py-6 border-t border-slate-100 bg-slate-50/50 flex items-center justify-between">
            <form action="{{ route('notes.destroy', $note) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button 
                    type="submit"
                    onclick="return confirm('Yakin ingin menghapus catatan ini?')"
                    class="flex items-center gap-2 text-rose-500 hover:text-rose-600 text-xs font-bold transition-colors group"
                >
                    <div class="w-8 h-8 rounded-xl bg-rose-50 flex items-center justify-center group-hover:bg-rose-100 transition-colors">
                        <i class="fa-solid fa-trash-can"></i>
                    </div>
                    Hapus
                </button>
            </form>

            <div class="flex gap-3">
                <a href="{{ route('calendar.index') }}" class="px-6 py-2.5 rounded-xl text-xs font-bold text-slate-500 hover:bg-slate-200 transition-all">
                    Tutup
                </a>
                <a href="{{ route('calendar.notes.edit', $note) }}" class="px-8 py-2.5 bg-indigo-600 text-white rounded-xl text-xs font-bold shadow-lg shadow-indigo-100 hover:bg-indigo-700 transition-all flex items-center gap-2">
                    <i class="fa-solid fa-pen"></i>
                    Edit Catatan
                </a>
            </div>
        </div>
    </div>
</div>

@endsection
