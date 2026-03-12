@extends('layouts.app')

@section('title', 'Kalender Konten - PlannerX')

@section('content')

<div
x-data="{
openMonth: false,
openYear: false,
currentYear: new Date().getFullYear(),
currentMonth: new Date().getMonth(),
months: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
years: [],
days: [],

    init() {
        // Generate daftar tahun (10 tahun ke belakang dan 10 tahun ke depan)
        const startYear = this.currentYear - 10;
        for (let i = 0; i <= 20; i++) {
            this.years.push(startYear + i);
        }
        this.generateCalendar();
    },

    generateCalendar() {
        const firstDay = new Date(this.currentYear, this.currentMonth, 1).getDay();
        const daysInMonth = new Date(this.currentYear, this.currentMonth + 1, 0).getDate();
        const prevDaysInMonth = new Date(this.currentYear, this.currentMonth, 0).getDate();
        
        let tempDays = [];
        
        // Padding hari dari bulan sebelumnya
        for (let i = firstDay - 1; i >= 0; i--) {
            tempDays.push({
                number: prevDaysInMonth - i,
                currentMonth: false,
                weekend: false
            });
        }
        
        // Hari di bulan sekarang
        const today = new Date();
        for (let i = 1; i <= daysInMonth; i++) {
            const dateObj = new Date(this.currentYear, this.currentMonth, i);
            tempDays.push({
                number: i,
                currentMonth: true,
                today: today.getDate() === i && today.getMonth() === this.currentMonth && today.getFullYear() === this.currentYear,
                weekend: dateObj.getDay() === 0 || dateObj.getDay() === 6
            });
        }
        
        // Padding hari bulan berikutnya agar genap 35 atau 42 sel
        const totalCells = tempDays.length > 35 ? 42 : 35;
        const remaining = totalCells - tempDays.length;
        for (let i = 1; i <= remaining; i++) {
            tempDays.push({
                number: i,
                currentMonth: false,
                weekend: false
            });
        }
        
        this.days = tempDays;
    },

    changeMonth(index) {
        this.currentMonth = index;
        this.generateCalendar();
        this.openMonth = false;
    },

    changeYear(year) {
        this.currentYear = year;
        this.generateCalendar();
        this.openYear = false;
    },

    prevMonth() {
        if (this.currentMonth === 0) {
            this.currentMonth = 11;
            this.currentYear--;
        } else {
            this.currentMonth--;
        }
        this.generateCalendar();
    },

    nextMonth() {
        if (this.currentMonth === 11) {
            this.currentMonth = 0;
            this.currentYear++;
        } else {
            this.currentMonth++;
        }
        this.generateCalendar();
    },

    goToToday() {
        const now = new Date();
        this.currentYear = now.getFullYear();
        this.currentMonth = now.getMonth();
        this.generateCalendar();
    }
}"
class="h-[calc(100vh-120px)] flex flex-col bg-white rounded-[2.5rem] border border-slate-200 overflow-hidden shadow-xl shadow-slate-200/50"


<!-- Header Kalender - FIX: Ditambahkan z-30 agar dropdown berada di atas grid -->
<div class="flex items-center justify-between px-8 py-6 border-b border-slate-100 bg-white/80 backdrop-blur-md relative z-30">
    <div class="flex items-center gap-4">
        <!-- Tombol Hari Ini -->
        <button @click="goToToday()" class="px-5 py-2 bg-white border border-slate-200 text-slate-600 text-sm font-bold rounded-xl hover:bg-slate-50 hover:border-slate-300 transition-all shadow-sm">
            Hari Ini
        </button>

        <!-- Dropdown Bulan -->
        <div class="relative" @click.outside="openMonth = false">
            <button @click="openMonth = !openMonth" class="flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 text-slate-700 text-sm font-bold rounded-xl hover:bg-slate-50 transition-all shadow-sm focus:outline-none relative z-10">
                <span x-text="months[currentMonth]"></span>
                <i class="fa-solid fa-chevron-down text-[10px] text-slate-400 transition-transform duration-200" :class="openMonth ? 'rotate-180' : ''"></i>
            </button>

            <!-- Menu Dropdown Bulan - FIX: Background putih solid agar tidak tembus pandang -->
            <div 
                x-show="openMonth" 
                x-cloak
                x-transition:enter="transition ease-out duration-100"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-75"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="absolute left-0 mt-2 w-56 bg-white border border-slate-200 rounded-2xl shadow-2xl z-[50] py-2 overflow-hidden"
            >
                <div class="max-h-64 overflow-y-auto custom-scrollbar bg-white">
                    <template x-for="(month, index) in months" :key="index">
                        <button 
                            @click="changeMonth(index)"
                            class="w-full text-left px-5 py-3 text-sm font-semibold text-slate-600 hover:bg-indigo-50 hover:text-indigo-600 transition-colors border-b border-slate-50 last:border-0"
                            :class="currentMonth === index ? 'bg-indigo-50 text-indigo-600' : ''"
                        >
                            <span x-text="month"></span>
                        </button>
                    </template>
                </div>
            </div>
        </div>

        <!-- Dropdown Tahun -->
        <div class="relative" @click.outside="openYear = false">
            <button @click="openYear = !openYear" class="flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 text-slate-700 text-sm font-bold rounded-xl hover:bg-slate-50 transition-all shadow-sm focus:outline-none relative z-10">
                <span x-text="currentYear"></span>
                <i class="fa-solid fa-chevron-down text-[10px] text-slate-400 transition-transform duration-200" :class="openYear ? 'rotate-180' : ''"></i>
            </button>

            <!-- Menu Dropdown Tahun - FIX: Background putih solid -->
            <div 
                x-show="openYear" 
                x-cloak
                x-transition:enter="transition ease-out duration-100"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-75"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="absolute left-0 mt-2 w-32 bg-white border border-slate-200 rounded-2xl shadow-2xl z-[50] py-2 overflow-hidden"
            >
                <div class="max-h-64 overflow-y-auto custom-scrollbar bg-white">
                    <template x-for="year in years" :key="year">
                        <button 
                            @click="changeYear(year)"
                            class="w-full text-left px-5 py-3 text-sm font-semibold text-slate-600 hover:bg-indigo-50 hover:text-indigo-600 transition-colors border-b border-slate-50 last:border-0"
                            :class="currentYear === year ? 'bg-indigo-50 text-indigo-600' : ''"
                        >
                            <span x-text="year"></span>
                        </button>
                    </template>
                </div>
            </div>
        </div>

        <!-- Panah Navigasi -->
        <div class="flex items-center gap-1 ml-2">
            <button @click="prevMonth()" class="w-10 h-10 flex items-center justify-center text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-xl transition-all">
                <i class="fa-solid fa-chevron-left text-sm"></i>
            </button>
            <button @click="nextMonth()" class="w-10 h-10 flex items-center justify-center text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-xl transition-all">
                <i class="fa-solid fa-chevron-right text-sm"></i>
            </button>
        </div>

        <!-- Judul Bulan & Tahun -->
        <h2 class="text-2xl font-black text-slate-900 ml-4 tracking-tight">
            <span x-text="months[currentMonth]"></span> <span class="text-indigo-600" x-text="currentYear"></span>
        </h2>
    </div>
</div>

<!-- Header Nama Hari -->
<div class="grid grid-cols-7 border-b border-slate-100 bg-slate-50/50 relative z-20">
    <template x-for="dayName in ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu']">
        <div class="py-4 text-center text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]" x-text="dayName"></div>
    </template>
</div>

<!-- Grid Kalender Dinamis -->
<div class="flex-1 grid grid-cols-7 overflow-y-auto custom-scrollbar bg-white relative z-10">
    <template x-for="(day, index) in days" :key="index">
        <div 
            class="min-h-[150px] border-r border-b border-slate-100 p-4 transition-all hover:bg-indigo-50/30 group cursor-pointer relative"
            :class="day.weekend ? 'bg-slate-50/20' : ''"
        >
            <!-- Nomor Tanggal -->
            <div class="flex justify-start mb-3">
                <span 
                    class="text-sm font-bold w-8 h-8 flex items-center justify-center rounded-2xl transition-all"
                    :class="day.currentMonth 
                        ? (day.today ? 'text-white bg-indigo-600 shadow-lg shadow-indigo-200' : 'text-slate-900') 
                        : 'text-slate-200'"
                    x-text="day.number"
                ></span>
            </div>

            <!-- Area Tugas -->
            <div class="mt-1 space-y-2" x-show="day.today">
                <div class="px-3 py-1.5 bg-white border border-indigo-100 rounded-xl shadow-sm text-[10px] font-bold text-indigo-600 flex items-center gap-2">
                    <div class="w-1.5 h-1.5 bg-indigo-600 rounded-full animate-pulse"></div>
                    Sinkronisasi Proyek
                </div>
            </div>

            <!-- Tombol Tambah Cepat -->
            <button class="absolute bottom-4 right-4 translate-y-2 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all p-2 bg-white border border-slate-200 rounded-xl text-indigo-600 shadow-sm hover:bg-indigo-600 hover:text-white">
                <i class="fa-solid fa-plus text-[10px]"></i>
            </button>
        </div>
    </template>
</div>


</div>

<style>
/* Scrollbar minimalis */
.custom-scrollbar::-webkit-scrollbar {
width: 6px;
}
.custom-scrollbar::-webkit-scrollbar-track {
background: transparent;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
background: #e2e8f0;
border-radius: 10px;
}

/* Fix untuk grid lines */
.grid-cols-7 > div:nth-child(7n) {
border-right: none;
}

[x-cloak] { display: none !important; }
</style>

@endsection