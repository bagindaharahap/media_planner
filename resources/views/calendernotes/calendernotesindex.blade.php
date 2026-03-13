@extends('layouts.app')

@section('title', 'Kalender Konten - PlannerX')

@section('content')

<div
x-data="{
    openMonth: false,
    openYear: false,
    showLihatModal: false,
    showEditModal: false,
    showCreateModal: false,
    showCreateChoiceModal: false,
    isWritingNote: false,
    selectedDate: '',
    currentYear: new Date().getFullYear(),
    currentMonth: new Date().getMonth(),
    viewingPlanning: {},
    editingPlanning: {},

    // Array penampung data Notes
    allNotes: [
        { id: 'n1', title: 'Ide Konten Ramadhan', content: 'Video resep takjil 30 detik.', color: 'bg-emerald-500', date: '2026-03-12' },
        { id: 'n2', title: 'Reminder Live', content: 'Jam 19:00 WIB di TikTok.', color: 'bg-rose-500', date: '2026-03-12' }
    ],

    // Objek untuk planning baru
    planning: {
        status: 'backlog',
        title: '',
        content_type: 'TikTok',
        description: '',
        start_date: '',
        due_date: '',
        priority: 'normal',
        media_link: '',
        assigned: [
            { name: '', jobdesks: [], tools: [] }
        ],
        references: ['']
    },

    // Objek untuk notes baru
    noteData: {
        title: '',
        content: '',
        color: 'bg-indigo-500',
        date: ''
    },
    
    months: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
    years: [],
    days: [],
    
    allStatuses: [
        { id: 'backlog', name: 'Backlog' },
        { id: 'progress', name: 'In Progress' },
        { id: 'review', name: 'In Review' },
        { id: 'revisi', name: 'Revisi' },
        { id: 'hold_on', name: 'Hold On' },
        { id: 'approved', name: 'Approved' },
        { id: 'published', name: 'Published' }
    ],

    userOptions: ['Dina', 'Adelsa', 'Lisa', 'Putri'],
    jobdeskOptions: ['Content Planner', 'Copywriting', 'Script writing', 'Editor Video', 'Desain Grafis'],
    toolOptions: ['Capcut', 'Canva', 'Figma', 'Instagram', 'Tiktok'],

    allTasks: [
        { id: '1', title: 'Tips Optimasi Laravel 11', content_type: 'TikTok', status: 'progress', start_date: '', due_date: '', priority: 'urgent', assigned: [{name: 'Adelsa', jobdesks: ['Editor Video'], tools: ['Capcut']}], description: '<b>Brief konten:</b> Fokus pada optimasi database.', references: ['https://laravel.com'], media_link: 'https://google.com' },
        { id: '2', title: 'Vlog Setup Workspace', content_type: 'Reels', status: 'review', start_date: '', due_date: '', priority: 'high', assigned: [{name: 'Dina', jobdesks: ['Desain Grafis'], tools: ['Kamera']}], description: 'Review setup minimalis 2024.', references: [], media_link: '' },
        { id: '3', title: 'Update News Laravel', content_type: 'Story', status: 'published', start_date: '', due_date: '', priority: 'normal', assigned: [{name: 'Lisa', jobdesks: ['Copywriting'], tools: ['Chatgpt']}], description: 'News mingguan seputar ekosistem PHP.', references: ['https://twitter.com/laravel'], media_link: 'https://google.com' }
    ],

    init() {
        const today = new Date();
        const t1Start = new Date(); t1Start.setDate(today.getDate() - 1);
        const t1End = new Date(); t1End.setDate(today.getDate() + 1);
        this.allTasks[0].start_date = this.formatDateObj(t1Start);
        this.allTasks[0].due_date = this.formatDateObj(t1End);
        
        const t2Start = new Date(); t2Start.setDate(today.getDate() + 2);
        const t2End = new Date(); t2End.setDate(today.getDate() + 3);
        this.allTasks[1].start_date = this.formatDateObj(t2Start);
        this.allTasks[1].due_date = this.formatDateObj(t2End);
        
        const t3Date = new Date(); t3Date.setDate(today.getDate() - 3);
        this.allTasks[2].start_date = this.formatDateObj(t3Date);
        this.allTasks[2].due_date = this.formatDateObj(t3Date);

        const startYear = this.currentYear - 10;
        for (let i = 0; i <= 20; i++) {
            this.years.push(startYear + i);
        }
        this.generateCalendar();

        // Watcher untuk reset form notes ketika modal ditutup
        this.$watch('showCreateChoiceModal', value => {
            if (!value) {
                this.isWritingNote = false;
                this.noteData = {
                    title: '',
                    content: '',
                    color: 'bg-indigo-500',
                    date: ''
                };
            }
        });
    },

    getTodayLocal() {
        return this.formatDateObj(new Date());
    },

    formatDateObj(date) {
        const y = date.getFullYear();
        const m = String(date.getMonth() + 1).padStart(2, '0');
        const d = String(date.getDate()).padStart(2, '0');
        return `${y}-${m}-${d}`;
    },

    generateCalendar() {
        const firstDay = new Date(this.currentYear, this.currentMonth, 1).getDay();
        const daysInMonth = new Date(this.currentYear, this.currentMonth + 1, 0).getDate();
        const prevDaysInMonth = new Date(this.currentYear, this.currentMonth, 0).getDate();
        
        let tempDays = [];
        const todayStr = this.getTodayLocal();
        
        for (let i = firstDay - 1; i >= 0; i--) {
            const dayNum = prevDaysInMonth - i;
            const dateStr = this.formatDateString(dayNum, this.currentMonth - 1, this.currentYear);
            tempDays.push({ number: dayNum, date: dateStr, currentMonth: false, weekend: false, tasks: this.getTasksForDate(dateStr) });
        }
        
        for (let i = 1; i <= daysInMonth; i++) {
            const dateObj = new Date(this.currentYear, this.currentMonth, i);
            const dateStr = this.formatDateString(i, this.currentMonth, this.currentYear);
            tempDays.push({
                number: i,
                date: dateStr,
                currentMonth: true,
                today: todayStr === dateStr,
                weekend: dateObj.getDay() === 0 || dateObj.getDay() === 6,
                tasks: this.getTasksForDate(dateStr)
            });
        }
        
        const totalCells = tempDays.length > 35 ? 42 : 35;
        const remaining = totalCells - tempDays.length;
        for (let i = 1; i <= remaining; i++) {
            const dateStr = this.formatDateString(i, this.currentMonth + 1, this.currentYear);
            tempDays.push({ number: i, date: dateStr, currentMonth: false, weekend: false, tasks: this.getTasksForDate(dateStr) });
        }
        this.days = tempDays;
    },

    formatDateString(d, m, y) {
        const date = new Date(y, m, d);
        return this.formatDateObj(date);
    },

    getTasksForDate(dateStr) {
        return this.allTasks.filter(t => dateStr >= t.start_date && dateStr <= t.due_date);
    },

    getNotesForDate(dateStr) {
        return this.allNotes.filter(n => n.date === dateStr);
    },

    saveNote() {
        if(!this.noteData.title) return;
        this.allNotes.push({
            id: 'n' + Date.now(),
            title: this.noteData.title,
            content: this.noteData.content,
            color: this.noteData.color,
            date: this.selectedDate
        });
        this.showCreateChoiceModal = false;
        this.isWritingNote = false;
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
    },

    openCreate(date = '') {
        this.selectedDate = date;
        this.noteData.date = date;
        this.planning = {
            status: 'backlog',
            title: '',
            content_type: 'TikTok',
            description: '',
            start_date: date,
            due_date: date,
            priority: 'normal',
            media_link: '',
            assigned: [{ name: '', jobdesks: [], tools: [] }],
            references: ['']
        };
        this.showCreateChoiceModal = true;
    },

    openCreatePlanning(date = '') {
        this.planning = {
            status: 'backlog',
            title: '',
            content_type: 'TikTok',
            description: '',
            start_date: date,
            due_date: date,
            priority: 'normal',
            media_link: '',
            assigned: [{ name: '', jobdesks: [], tools: [] }],
            references: ['']
        };
        this.showCreateModal = true;
    },

    openLihat(task) {
        this.viewingPlanning = JSON.parse(JSON.stringify(task));
        this.showLihatModal = true;
    },

    openEdit(task) {
        this.editingPlanning = JSON.parse(JSON.stringify(task));
        this.showEditModal = true;
    },

    addAssigned(mode = 'edit') {
        let target;
        if (mode === 'create') target = this.planning;
        else if (mode === 'edit') target = this.editingPlanning;
        else target = this.viewingPlanning;
        
        if (!target.assigned) target.assigned = [];
        target.assigned.push({ name: '', jobdesks: [], tools: [] });
    },
    removeAssigned(mode = 'edit', index) {
        let target;
        if (mode === 'create') target = this.planning;
        else if (mode === 'edit') target = this.editingPlanning;
        else target = this.viewingPlanning;

        if(target.assigned.length > 1) target.assigned.splice(index, 1);
    },
    addReference(mode = 'edit') {
        let target;
        if (mode === 'create') target = this.planning;
        else if (mode === 'edit') target = this.editingPlanning;
        else target = this.viewingPlanning;

        if (!target.references) target.references = [];
        target.references.push('');
    },
    removeReference(mode = 'edit', index) {
        let target;
        if (mode === 'create') target = this.planning;
        else if (mode === 'edit') target = this.editingPlanning;
        else target = this.viewingPlanning;

        if(target.references.length > 1) target.references.splice(index, 1);
    },

    getPriorityStyles(priority) {
        const styles = {
            'urgent': 'bg-rose-500 text-white border-rose-600 shadow-rose-100',
            'high': 'bg-yellow-400 text-slate-800 border-yellow-500 shadow-yellow-100',
            'normal': 'bg-blue-600 text-white border-blue-700 shadow-blue-100',
            'low': 'bg-slate-400 text-white border-slate-500 shadow-slate-100'
        };
        return styles[priority] || 'bg-slate-400 text-white';
    },

    getStatusColor(status) {
        const colors = {
            'backlog': 'bg-slate-600',
            'progress': 'bg-indigo-400',
            'review': 'bg-rose-400',
            'revisi': 'bg-amber-400',
            'hold_on': 'bg-orange-400',
            'approved': 'bg-blue-400',
            'published': 'bg-emerald-400'
        };
        return colors[status] || 'bg-slate-500';
    }
}"
class="h-[calc(100vh-120px)] flex flex-col bg-[#fcfdfe] rounded-[2.5rem] border border-slate-200 overflow-hidden shadow-2xl relative"
>


<!-- Efek Dekorasi Soft Cosmic -->
<div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-indigo-200/20 blur-[100px] pointer-events-none"></div>
<div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-purple-200/20 blur-[100px] pointer-events-none"></div>

<!-- Header Kalender -->
<div class="flex items-center justify-between px-8 py-6 border-b border-slate-100 bg-white/60 backdrop-blur-xl relative z-30">
    <div class="flex items-center gap-4">
        <button @click="goToToday()" class="px-5 py-2 bg-white border border-slate-200 text-slate-600 text-sm font-bold rounded-xl hover:bg-slate-50 transition-all shadow-sm">
            Hari Ini
        </button>

        <!-- Dropdown Bulan -->
        <div class="relative" @click.outside="openMonth = false">
            <button @click="openMonth = !openMonth" class="flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 text-slate-700 text-sm font-bold rounded-xl hover:bg-slate-50 transition-all shadow-sm relative z-10">
                <span x-text="months[currentMonth]"></span>
                <i class="fa-solid fa-chevron-down text-[10px] text-slate-400 transition-transform duration-200" :class="openMonth ? 'rotate-180' : ''"></i>
            </button>
            <div x-show="openMonth" x-cloak x-transition class="absolute left-0 mt-2 w-56 bg-white border border-slate-100 rounded-2xl shadow-xl z-[50] py-2 overflow-hidden">
                <div class="max-h-64 overflow-y-auto custom-scrollbar">
                    <template x-for="(month, index) in months" :key="index">
                        <button @click="changeMonth(index)" class="w-full text-left px-5 py-3 text-sm font-semibold text-slate-600 hover:bg-indigo-50 hover:text-indigo-600 transition-colors border-b border-slate-50 last:border-0" :class="currentMonth === index ? 'bg-indigo-50 text-indigo-600' : ''">
                            <span x-text="month"></span>
                        </button>
                    </template>
                </div>
            </div>
        </div>

        <!-- Dropdown Tahun -->
        <div class="relative" @click.outside="openYear = false">
            <button @click="openYear = !openYear" class="flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 text-slate-700 text-sm font-bold rounded-xl hover:bg-slate-50 transition-all shadow-sm relative z-10">
                <span x-text="currentYear"></span>
                <i class="fa-solid fa-chevron-down text-[10px] text-slate-400 transition-transform duration-200" :class="openYear ? 'rotate-180' : ''"></i>
            </button>
            <div x-show="openYear" x-cloak x-transition class="absolute left-0 mt-2 w-32 bg-white border border-slate-100 rounded-2xl shadow-xl z-[50] py-2 overflow-hidden">
                <div class="max-h-64 overflow-y-auto custom-scrollbar">
                    <template x-for="year in years" :key="year">
                        <button @click="changeYear(year)" class="w-full text-left px-5 py-3 text-sm font-semibold text-slate-600 hover:bg-indigo-50 hover:text-indigo-600 transition-colors border-b border-slate-50 last:border-0" :class="currentYear === year ? 'bg-indigo-50 text-indigo-600' : ''">
                            <span x-text="year"></span>
                        </button>
                    </template>
                </div>
            </div>
        </div>

        <h2 class="text-2xl font-black text-slate-800 ml-4 tracking-tight">
            <span x-text="months[currentMonth]"></span> <span class="text-indigo-600" x-text="currentYear"></span>
        </h2>
    </div>
    
    <div class="flex items-center gap-2 px-4 py-2 bg-indigo-50 text-indigo-600 rounded-2xl text-[10px] font-black uppercase tracking-widest border border-indigo-100 shadow-sm">
        <i class="fa-solid fa-circle-info"></i>
        Arahkan kursor ke tanggal untuk menambah rencana
    </div>
</div>

<!-- Header Nama Hari -->
<div class="grid grid-cols-7 border-b border-slate-100 bg-slate-50/50 relative z-20 text-slate-400 font-black uppercase tracking-[0.3em] text-[10px]">
    <template x-for="dayName in ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu']">
        <div class="py-4 text-center" x-text="dayName"></div>
    </template>
</div>

<!-- Grid Kalender Dinamis -->
<div class="flex-1 grid grid-cols-7 overflow-y-auto custom-scrollbar bg-transparent relative z-10">
    <template x-for="(day, index) in days" :key="index">
        <div 
            class="min-h-[160px] border-r border-b border-slate-100 p-0 transition-all hover:bg-indigo-50/10 group cursor-pointer relative flex flex-col"
            :class="!day.currentMonth ? 'bg-slate-50/40 opacity-40' : (day.weekend ? 'bg-slate-50/30' : '')"
        >
            <div class="p-3 pb-1 flex justify-between items-start">
                <span 
                    class="text-xs font-black w-8 h-8 flex items-center justify-center rounded-xl transition-all"
                    :class="day.today ? 'bg-indigo-600 text-white shadow-lg' : (day.currentMonth ? 'text-slate-800' : 'text-slate-200')"
                    x-text="day.number"
                ></span>
            </div>

            <!-- Kontainer Kartu (Scrollable Internal) -->
            <div class="flex-1 overflow-y-auto custom-scrollbar-inner px-2 pb-10 space-y-1.5">
                <!-- RENDER PLANNING -->
                <template x-for="task in day.tasks" :key="task.id">
                    <div 
                        @click.stop="openLihat(task)"
                        class="flex items-stretch overflow-hidden shadow-sm transition-all border-y relative min-h-[42px]"
                        :class="[
                            getPriorityStyles(task.priority),
                            day.date === task.start_date && day.date === task.due_date ? 'rounded-lg mx-2 border-x' : 
                            day.date === task.start_date ? 'rounded-l-lg ml-2 border-l' : 
                            day.date === task.due_date ? 'rounded-r-lg mr-2 border-r' : 'mx-0 border-x-0'
                        ]"
                    >
                        <template x-if="day.date === task.start_date">
                            <div class="w-3 shrink-0" :class="getStatusColor(task.status)"></div>
                        </template>

                        <div class="flex-1 flex flex-col justify-center px-2 py-1.5 truncate leading-tight">
                            <span class="truncate text-[10px] font-bold" x-text="day.date === task.start_date ? task.title : '•••'"></span>
                            <template x-if="day.date === task.start_date">
                                <div class="flex items-center gap-1.5 mt-0.5 opacity-85 text-[8px] font-medium uppercase truncate">
                                    <span x-text="task.content_type"></span>
                                    <span class="opacity-50">•</span>
                                    <span x-text="allStatuses.find(s => s.id === task.status)?.name || task.status"></span>
                                </div>
                            </template>
                        </div>
                    </div>
                </template>

                <!-- RENDER NOTES -->
                <template x-for="note in getNotesForDate(day.date)" :key="note.id">
                    <div 
                        class="p-2 rounded-xl shadow-sm border border-black/5 flex flex-col gap-0.5 transition-all hover:scale-[1.02]"
                        :class="note.color"
                    >
                        <div class="flex items-center gap-1.5 text-white/95">
                            <i class="fa-solid fa-note-sticky text-[8px]"></i>
                            <span class="text-[9px] font-black uppercase tracking-tighter truncate" x-text="note.title"></span>
                        </div>
                        <p class="text-[8px] text-white/80 line-clamp-2 italic font-medium leading-[1.1]" x-text="note.content"></p>
                    </div>
                </template>
            </div>

            <!-- TOMBOL BUAT PLANNING / NOTES -->
            <button 
                @click.stop="openCreate(day.date)"
                class="absolute bottom-3 right-3 w-8 h-8 bg-indigo-600 text-white rounded-xl shadow-lg shadow-indigo-200 flex items-center justify-center hover:bg-indigo-700 hover:scale-110 active:scale-95 transition-all opacity-0 group-hover:opacity-100 z-20"
                title="Tambah Rencana / Catatan di Tanggal Ini"
            >
                <i class="fa-solid fa-plus text-xs"></i>
            </button>
        </div>
    </template>
</div>

<!-- Modal Lihat Planning -->
<div
    x-show="showLihatModal"
    x-cloak
    class="fixed inset-0 z-[150] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200"
>
    <div
        @click.outside="showLihatModal = false"
        class="bg-white w-full max-w-5xl max-h-[90vh] rounded-[2.5rem] shadow-2xl flex flex-col overflow-hidden border border-slate-200"
        x-transition:enter="transition ease-out duration-300 transform"
        x-transition:enter-start="opacity-0 scale-95 translate-y-8"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
    >
        <!-- Header -->
        <div class="px-8 py-6 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-indigo-50 rounded-2xl flex items-center justify-center text-indigo-600 shadow-sm border border-indigo-100">
                    <i class="fa-solid fa-eye text-xl"></i>
                </div>
                <div>
                    <div class="flex items-center gap-2 mb-0.5">
                        <span class="px-2 py-0.5 bg-indigo-600 text-white text-[9px] font-black rounded-lg uppercase tracking-tighter" x-text="viewingPlanning.content_type"></span>
                        <h3 class="text-xl font-extrabold text-slate-800 tracking-tight" x-text="viewingPlanning.title"></h3>
                    </div>
                    <p class="text-xs text-slate-500 font-medium uppercase tracking-widest">Detail Perencanaan Konten</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <button @click="showLihatModal = false; openEdit(viewingPlanning)" class="w-10 h-10 rounded-full hover:bg-indigo-50 flex items-center justify-center text-indigo-600 transition-colors" title="Edit Rencana">
                    <i class="fa-solid fa-pen-to-square"></i>
                </button>
                <button @click="showLihatModal = false" class="w-10 h-10 rounded-full hover:bg-slate-200 flex items-center justify-center text-slate-400 transition-colors">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>
        </div>

        <!-- Body -->
        <div class="flex-1 overflow-y-auto p-8 space-y-10 custom-scrollbar text-slate-800">
            <!-- Info Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-slate-50 p-4 rounded-3xl border border-slate-100">
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2">Status</p>
                    <div class="flex items-center gap-2">
                        <div class="w-2 h-2 rounded-full animate-pulse" :class="getStatusColor(viewingPlanning.status)"></div>
                        <span class="text-sm font-bold text-slate-700 capitalize" x-text="allStatuses.find(s => s.id === viewingPlanning.status)?.name || viewingPlanning.status"></span>
                    </div>
                </div>
                <div class="bg-slate-50 p-4 rounded-3xl border border-slate-100">
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2">Prioritas</p>
                    <span class="px-3 py-1 bg-red-100 text-red-600 text-[10px] font-black rounded-xl uppercase tracking-tighter" x-text="viewingPlanning.priority"></span>
                </div>
                <div class="bg-slate-50 p-4 rounded-3xl border border-slate-100">
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2">Mulai</p>
                    <div class="flex items-center gap-2 text-slate-700 font-bold text-sm">
                        <i class="fa-solid fa-calendar text-indigo-400 text-xs"></i>
                        <span x-text="viewingPlanning.start_date || '-'"></span>
                    </div>
                </div>
                <div class="bg-slate-50 p-4 rounded-3xl border border-slate-100">
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2">Deadline</p>
                    <div class="flex items-center gap-2 text-red-500 font-bold text-sm">
                        <i class="fa-solid fa-calendar-check text-xs"></i>
                        <span x-text="viewingPlanning.due_date || '-'"></span>
                    </div>
                </div>
            </div>

            <!-- Deskripsi -->
            <div class="space-y-4">
                <div class="flex items-center gap-2 px-1">
                    <i class="fa-solid fa-align-left text-indigo-500 text-xs"></i>
                    <h4 class="text-[11px] font-black text-slate-400 uppercase tracking-widest">Deskripsi & Brief Konten</h4>
                </div>
                <div class="bg-white border border-slate-100 rounded-[2rem] p-8 shadow-sm">
                    <div class="prose prose-slate prose-sm max-w-none text-slate-600 leading-relaxed view-editor-content" x-html="viewingPlanning.description || '<p class=\'italic text-slate-400\'>Tidak ada deskripsi.</p>'"></div>
                </div>
            </div>

            <!-- Tim -->
            <div class="space-y-4">
                <div class="flex items-center gap-2 px-1">
                    <i class="fa-solid fa-users text-indigo-500 text-xs"></i>
                    <h4 class="text-[11px] font-black text-slate-400 uppercase tracking-widest">Tim Penanggung Jawab</h4>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <template x-for="(assign, index) in viewingPlanning.assigned" :key="index">
                        <div class="flex items-center gap-4 p-5 bg-slate-50 border border-slate-100 rounded-3xl">
                            <div class="w-12 h-12 bg-indigo-600 rounded-2xl flex items-center justify-center text-white font-black" x-text="assign.name ? assign.name.substring(0, 2).toUpperCase() : '?'"></div>
                            <div>
                                <h5 class="font-extrabold text-slate-800" x-text="assign.name || 'Belum Ditentukan'"></h5>
                                <div class="flex flex-wrap gap-1.5 mt-1">
                                    <template x-for="job in assign.jobdesks" :key="job">
                                        <span class="text-[9px] font-bold bg-white text-slate-500 px-2 py-0.5 rounded-lg border border-slate-200" x-text="job"></span>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
            
            <!-- Referensi & Media -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-4">
                    <div class="flex items-center gap-2 px-1">
                        <i class="fa-solid fa-link text-indigo-500 text-xs"></i>
                        <h4 class="text-[11px] font-black text-slate-400 uppercase tracking-widest">Referensi</h4>
                    </div>
                    <div class="bg-white border border-slate-100 rounded-3xl p-6 space-y-3 shadow-sm min-h-[100px]">
                        <template x-for="(ref, rIndex) in viewingPlanning.references" :key="rIndex">
                            <a :href="ref" target="_blank" class="flex items-center justify-between p-3 bg-slate-50 rounded-2xl hover:bg-indigo-50 transition-all group" x-show="ref">
                                <span class="text-xs font-bold text-slate-600 truncate" x-text="ref"></span>
                                <i class="fa-solid fa-external-link text-slate-300"></i>
                            </a>
                        </template>
                    </div>
                </div>
                <div class="space-y-4">
                    <div class="flex items-center gap-2 px-1">
                        <i class="fa-solid fa-photo-film text-indigo-500 text-xs"></i>
                        <h4 class="text-[11px] font-black text-slate-400 uppercase tracking-widest">Aset Media</h4>
                    </div>
                    <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm min-h-[100px]">
                        <template x-if="viewingPlanning.media_link">
                            <a :href="viewingPlanning.media_link" target="_blank" class="w-full flex items-center justify-center gap-3 py-4 bg-indigo-600 text-white rounded-2xl font-bold text-sm shadow-xl shadow-indigo-100 hover:bg-indigo-700 transition-all">
                                <i class="fa-solid fa-download"></i> Download Aset
                            </a>
                        </template>
                    </div>
                </div>
            </div>
        </div>

        <div class="px-8 py-6 border-t border-slate-100 bg-slate-50/50 flex items-center justify-between">
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">PlannerX CMS</p>
            <button @click="showLihatModal = false" class="px-8 py-3 bg-white border border-slate-200 rounded-2xl text-sm font-bold text-slate-600 hover:bg-slate-50 transition-all shadow-sm">Tutup Detail</button>
        </div>
    </div>
</div>

<!-- Modal Edit Planning -->
<div
    x-show="showEditModal"
    x-cloak
    class="fixed inset-0 z-[150] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200"
>
    <div
        @click.outside="showEditModal = false"
        class="bg-white w-full max-w-5xl max-h-[90vh] rounded-[2.5rem] shadow-2xl flex flex-col overflow-hidden border border-slate-200"
        x-transition:enter="transition ease-out duration-300 transform"
        x-transition:enter-start="opacity-0 scale-95 translate-y-8"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
    >
        <!-- Header -->
        <div class="px-8 py-6 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center text-white shadow-lg shadow-indigo-200">
                    <i class="fa-solid fa-pen-to-square"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-slate-800 tracking-tight">Edit Perencanaan</h3>
                    <p class="text-xs text-slate-500 font-medium uppercase tracking-widest">Perbarui detail rencana yang sudah ada</p>
                </div>
            </div>
            <button @click="showEditModal = false" class="w-10 h-10 rounded-full hover:bg-slate-200 flex items-center justify-center text-slate-400 transition-colors">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>

        <!-- Body -->
        <div class="flex-1 overflow-y-auto p-8 space-y-8 custom-scrollbar">
            <!-- Status & Judul -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="space-y-2">
                    <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Status</label>
                    <select x-model="editingPlanning.status" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-bold text-slate-700 outline-none focus:ring-2 focus:ring-indigo-500">
                        <template x-for="status in allStatuses" :key="status.id">
                            <option :value="status.id" x-text="status.name" :selected="status.id === editingPlanning.status"></option>
                        </template>
                    </select>
                </div>
                <div class="md:col-span-3 space-y-2">
                    <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Judul Rencana</label>
                    <input type="text" x-model="editingPlanning.title" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-5 py-3 text-lg font-bold text-slate-800 outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
            </div>

            <!-- Jenis Konten -->
            <div class="space-y-2">
                <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Jenis Konten</label>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <template x-for="type in ['TikTok', 'Reels', 'Feed', 'Story']" :key="type">
                        <button 
                            @click="editingPlanning.content_type = type"
                            type="button"
                            class="flex items-center justify-center gap-3 px-4 py-3 rounded-2xl border-2 font-bold text-sm transition-all"
                            :class="editingPlanning.content_type === type 
                                ? 'bg-indigo-600 border-indigo-600 text-white shadow-lg shadow-indigo-100' 
                                : 'bg-white border-slate-100 text-slate-500 hover:border-indigo-200'"
                        >
                            <i class="fa-brands" :class="type === 'TikTok' ? 'fa-tiktok' : 'fa-instagram'"></i>
                            <span x-text="type"></span>
                        </button>
                    </template>
                </div>
            </div>

            <!-- Editor -->
            <div class="space-y-3" x-data="{ 
                format(cmd, val = null) { 
                    document.execCommand(cmd, false, val); 
                    $refs.editEditor.focus();
                    editingPlanning.description = $refs.editEditor.innerHTML;
                }
            }" x-init="$watch('showEditModal', value => { if(value) { setTimeout(() => { $refs.editEditor.innerHTML = editingPlanning.description || ''; }, 100); } })">
                <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Deskripsi Konten</label>
                <div class="border border-slate-200 rounded-3xl overflow-hidden shadow-sm bg-white focus-within:ring-2 focus-within:ring-indigo-500/20">
                    <div class="bg-slate-50 border-b border-slate-200 px-4 py-2 flex items-center gap-4 text-slate-400">
                        <button type="button" @click="format('bold')" class="hover:text-indigo-600 p-1.5"><i class="fa-solid fa-bold"></i></button>
                        <button type="button" @click="format('italic')" class="hover:text-indigo-600 p-1.5"><i class="fa-solid fa-italic"></i></button>
                        <button type="button" @click="format('underline')" class="hover:text-indigo-600 p-1.5"><i class="fa-solid fa-underline"></i></button>
                        <button type="button" @click="format('insertUnorderedList')" class="hover:text-indigo-600 p-1.5"><i class="fa-solid fa-list-ul"></i></button>
                    </div>
                    <div x-ref="editEditor" contenteditable="true" @input="editingPlanning.description = $el.innerHTML" class="editor-content w-full p-6 min-h-[180px] text-sm text-slate-600 focus:outline-none bg-white"></div>
                </div>
            </div>

            <!-- Tim -->
            <div class="space-y-4">
                <div class="flex items-center justify-between px-1">
                    <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest">Tim & Jobdesk</label>
                    <button @click="addAssigned('edit')" class="text-indigo-600 text-[10px] font-black uppercase tracking-widest flex items-center gap-2">
                        <i class="fa-solid fa-user-plus"></i> Tambah Anggota
                    </button>
                </div>
                <div class="space-y-4">
                    <template x-for="(assign, index) in editingPlanning.assigned" :key="index">
                        <div class="p-6 bg-white border border-slate-200 rounded-3xl relative group/item hover:border-indigo-200">
                            <button @click="removeAssigned('edit', index)" x-show="editingPlanning.assigned.length > 1" class="absolute -top-2 -right-2 w-6 h-6 bg-red-500 text-white rounded-full text-[10px] flex items-center justify-center opacity-0 group-hover/item:opacity-100 transition-all z-10"><i class="fa-solid fa-times"></i></button>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div class="space-y-2">
                                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Nama</label>
                                    <select x-model="assign.name" class="w-full bg-slate-50 border border-slate-100 rounded-xl px-3 py-2 text-sm font-bold text-slate-700">
                                        <option value="">Pilih...</option>
                                        <template x-for="name in userOptions" :key="name"><option :value="name" x-text="name"></option></template>
                                    </select>
                                </div>
                                <div class="space-y-2" x-data="{ open: false }">
                                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Jobdesk</label>
                                    <button @click="open = !open" class="w-full bg-slate-50 border border-slate-100 rounded-xl px-3 py-2 text-left text-sm font-bold text-slate-600 flex justify-between items-center transition-all">
                                        <span x-text="assign.jobdesks.length ? assign.jobdesks.length + ' Dipilih' : 'Pilih...'"></span>
                                        <i class="fa-solid fa-chevron-down text-[10px]"></i>
                                    </button>
                                    <div x-show="open" @click.outside="open = false" x-cloak class="absolute z-20 top-full mt-2 w-full bg-white border border-slate-200 rounded-2xl shadow-xl py-2 max-h-40 overflow-y-auto custom-scrollbar">
                                        <template x-for="job in jobdeskOptions" :key="job">
                                            <label class="flex items-center gap-3 px-4 py-2 hover:bg-slate-50 cursor-pointer">
                                                <input type="checkbox" :value="job" x-model="assign.jobdesks" class="w-4 h-4 rounded text-indigo-600">
                                                <span class="text-xs font-bold text-slate-600" x-text="job"></span>
                                            </label>
                                        </template>
                                    </div>
                                </div>
                                <div class="space-y-2" x-data="{ open: false }">
                                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Tools</label>
                                    <button @click="open = !open" class="w-full bg-slate-50 border border-slate-100 rounded-xl px-3 py-2 text-left text-sm font-bold text-slate-600 flex justify-between items-center transition-all">
                                        <span x-text="assign.tools.length ? assign.tools.length + ' Dipilih' : 'Pilih...'"></span>
                                        <i class="fa-solid fa-chevron-down text-[10px]"></i>
                                    </button>
                                    <div x-show="open" @click.outside="open = false" x-cloak class="absolute z-20 top-full mt-2 w-full bg-white border border-slate-200 rounded-2xl shadow-xl py-2 max-h-40 overflow-y-auto custom-scrollbar">
                                        <template x-for="tool in toolOptions" :key="tool">
                                            <label class="flex items-center gap-3 px-4 py-2 hover:bg-slate-50 cursor-pointer">
                                                <input type="checkbox" :value="tool" x-model="assign.tools" class="w-4 h-4 rounded text-indigo-600">
                                                <span class="text-xs font-bold text-slate-600" x-text="tool"></span>
                                            </label>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <!-- Aset & Referensi -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest">Referensi</label>
                        <button @click="addReference('edit')" class="text-indigo-600 text-[10px] font-black uppercase tracking-widest">+ Link</button>
                    </div>
                    <template x-for="(ref, rIndex) in editingPlanning.references" :key="rIndex">
                        <div class="flex gap-2">
                            <input type="text" x-model="editingPlanning.references[rIndex]" class="flex-1 bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-sm font-bold text-slate-600">
                            <button @click="removeReference('edit', rIndex)" x-show="editingPlanning.references.length > 1" class="w-10 h-10 rounded-xl text-red-500 hover:bg-red-50 transition-all"><i class="fa-solid fa-trash text-xs"></i></button>
                        </div>
                    </template>
                </div>
                <div class="space-y-4">
                    <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest">Tautan Aset Media</label>
                    <div class="bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 flex items-center gap-3" :class="editingPlanning.status === 'backlog' ? 'opacity-40 grayscale pointer-events-none' : ''">
                        <i class="fa-solid fa-link text-slate-300"></i>
                        <input type="text" x-model="editingPlanning.media_link" placeholder="G-Drive Link..." class="bg-transparent w-full text-sm font-bold text-slate-600 outline-none">
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="px-8 py-6 border-t border-slate-100 bg-slate-50/50 flex items-center justify-end gap-4">
            <button @click="showEditModal = false" class="px-8 py-3 rounded-2xl text-sm font-bold text-slate-500 hover:bg-slate-200 transition-all">Batal</button>
            <button @click="showEditModal = false; console.log('Update:', editingPlanning);" class="bg-indigo-600 text-white px-10 py-3 rounded-2xl font-bold text-sm shadow-xl shadow-indigo-200 hover:bg-indigo-700 transition-all">Simpan Perubahan</button>
        </div>
    </div>
</div>

<!-- Modal Pilihan: Planning atau Notes -->
<div
    x-show="showCreateChoiceModal"
    x-cloak
    class="fixed inset-0 z-[160] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200"
>
    <div
        @click.outside="showCreateChoiceModal = false; isWritingNote = false"
        class="bg-white w-full max-w-2xl rounded-[2.5rem] shadow-2xl flex flex-col overflow-hidden border border-slate-200"
        x-transition:enter="transition ease-out duration-300 transform"
        x-transition:enter-start="opacity-0 scale-95 translate-y-8"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
    >
        <!-- Header -->
        <div class="px-8 py-6 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center text-white shadow-lg">
                    <i class="fa-solid fa-plus"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-slate-800 tracking-tight">Tambah Aktivitas</h3>
                    <p class="text-xs text-slate-500 font-medium uppercase tracking-widest">Pilih jenis konten untuk <span class="text-indigo-600 font-black" x-text="selectedDate"></span></p>
                </div>
            </div>
            <button @click="showCreateChoiceModal = false; isWritingNote = false" class="w-10 h-10 rounded-full hover:bg-slate-200 flex items-center justify-center text-slate-400 transition-colors">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>

        <!-- Body: Pilihan -->
        <div class="p-8 space-y-4" x-show="!isWritingNote">
            <p class="text-center text-slate-400 text-sm font-medium mb-4">Apa yang ingin Anda buat hari ini?</p>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Opsi 1: Planning -->
                <button 
                    @click="showCreateChoiceModal = false; openCreatePlanning(selectedDate)"
                    class="group p-6 bg-white border-2 border-slate-100 rounded-[2rem] text-left hover:border-indigo-600 hover:shadow-xl hover:shadow-indigo-50 transition-all duration-300"
                >
                    <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center mb-4 group-hover:bg-indigo-600 group-hover:text-white transition-colors shadow-sm">
                        <i class="fa-solid fa-rocket text-xl"></i>
                    </div>
                    <h4 class="font-bold text-slate-800 text-lg mb-1">Buat Planning</h4>
                    <p class="text-xs text-slate-500 leading-relaxed">Buat brief lengkap, tentukan tim, jobdesk, dan jadwal tayang konten.</p>
                </button>

                <!-- Opsi 2: Notes -->
                <button 
                    @click="isWritingNote = true"
                    class="group p-6 bg-white border-2 border-slate-100 rounded-[2rem] text-left hover:border-emerald-500 hover:shadow-xl hover:shadow-emerald-50 transition-all duration-300"
                >
                    <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center mb-4 group-hover:bg-emerald-500 group-hover:text-white transition-colors shadow-sm">
                        <i class="fa-solid fa-note-sticky text-xl"></i>
                    </div>
                    <h4 class="font-bold text-slate-800 text-lg mb-1">Buat Notes</h4>
                    <p class="text-xs text-slate-500 leading-relaxed">Catatan cepat untuk ide, pengingat, atau memo sederhana tanpa manajemen tim.</p>
                </button>
            </div>
        </div>

        <!-- Body: Input Notes (Jika user memilih Notes) -->
        <div class="p-8 space-y-6" x-show="isWritingNote" x-transition>
            <div class="space-y-4">
                <div class="space-y-2">
                    <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Judul Catatan</label>
                    <input type="text" x-model="noteData.title" placeholder="Misal: Ide Konten Ramadhan..." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-5 py-3 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-emerald-500 outline-none transition-all">
                </div>
                <div class="space-y-2">
                    <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Isi Catatan</label>
                    <textarea x-model="noteData.content" rows="4" placeholder="Tuliskan ide Anda di sini..." class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-3 text-sm text-slate-600 focus:ring-2 focus:ring-emerald-500 outline-none transition-all"></textarea>
                </div>
                <div class="flex items-center gap-4">
                    <div class="flex-1 space-y-2">
                        <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Kategori Warna</label>
                        <div class="flex gap-2">
                            <template x-for="color in ['bg-indigo-500', 'bg-emerald-500', 'bg-amber-500', 'bg-rose-500']">
                                <button @click="noteData.color = color" :class="color" class="w-8 h-8 rounded-full border-4 transition-all" :class="noteData.color === color ? 'border-slate-200 scale-110 shadow-lg' : 'border-transparent opacity-60 hover:opacity-100'"></button>
                            </template>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pt-6 border-t border-slate-100 flex gap-3">
                <button @click="isWritingNote = false" class="flex-1 py-3 text-sm font-bold text-slate-500 hover:bg-slate-50 rounded-2xl transition-all">Kembali</button>
                <button @click="saveNote()" class="flex-[2] bg-emerald-500 text-white py-3 rounded-2xl font-bold text-sm shadow-xl shadow-emerald-100 hover:bg-emerald-600 transition-all transform active:scale-95">Simpan Catatan</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Buat Planning -->
<div
    x-show="showCreateModal"
    x-cloak
    class="fixed inset-0 z-[150] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200"
>
    <div
        @click.outside="showCreateModal = false"
        class="bg-white w-full max-w-5xl max-h-[90vh] rounded-[2.5rem] shadow-2xl flex flex-col overflow-hidden border border-slate-200"
        x-transition:enter="transition ease-out duration-300 transform"
        x-transition:enter-start="opacity-0 scale-95 translate-y-8"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
    >
        <div class="px-8 py-6 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center text-white shadow-lg">
                    <i class="fa-solid fa-file-circle-plus"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-slate-800 tracking-tight">Buat Perencanaan Baru</h3>
                    <p class="text-xs text-slate-500 font-medium uppercase tracking-widest">Tentukan detail konten untuk tanggal <span class="text-indigo-600 font-black" x-text="planning.start_date"></span></p>
                </div>
            </div>
            <button @click="showCreateModal = false" class="w-10 h-10 rounded-full hover:bg-slate-200 flex items-center justify-center text-slate-400">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>

        <div class="flex-1 overflow-y-auto p-8 space-y-8 custom-scrollbar text-slate-800 text-sm">
            <p class="text-center italic text-slate-400">Formulir pembuatan rencana baru disinkronkan di sini.</p>
        </div>

        <div class="px-8 py-6 border-t border-slate-100 bg-slate-50/50 flex items-center justify-end gap-4">
            <button @click="showCreateModal = false" class="px-8 py-3 rounded-2xl text-sm font-bold text-slate-500 hover:bg-slate-200 transition-all">Batal</button>
            <button @click="showCreateModal = false; console.log('Create:', planning);" class="bg-indigo-600 text-white px-10 py-3 rounded-2xl font-bold text-sm shadow-xl shadow-indigo-200 hover:bg-indigo-700 transition-all">Buat Perencanaan</button>
        </div>
    </div>
</div>


</div>

<style>
.custom-scrollbar::-webkit-scrollbar { width: 6px; }
.custom-scrollbar-track { background: transparent; }
.custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
.custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #cbd5e1; }

/* Scrollbar tipis untuk bagian dalam tanggal */
.custom-scrollbar-inner::-webkit-scrollbar { width: 3px; }
.custom-scrollbar-inner::-webkit-scrollbar-track { background: transparent; }
.custom-scrollbar-inner::-webkit-scrollbar-thumb { background: rgba(0,0,0,0.05); border-radius: 10px; }
.custom-scrollbar-inner:hover::-webkit-scrollbar-thumb { background: rgba(0,0,0,0.1); }

.grid-cols-7 > div:nth-child(7n) { border-right: none; }
[x-cloak] { display: none !important; }
.view-editor-content b, .view-editor-content strong, .editor-content b, .editor-content strong { font-weight: bold !important; }
.view-editor-content i, .view-editor-content em, .editor-content i, .editor-content em { font-style: italic !important; }
.view-editor-content ul, .editor-content ul { list-style-type: disc !important; padding-left: 1.5rem !important; }
.view-editor-content ol, .editor-content ol { list-style-type: decimal !important; padding-left: 1.5rem !important; }
.editor-content:focus { outline: none; }
.editor-content:empty:before { content: attr(data-placeholder); color: #cbd5e1; }
</style>

@endsection