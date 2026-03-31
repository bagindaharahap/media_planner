@extends('layouts.app')

@section('title', 'Content Calendar - PlannerX')

@section('content')

@if(session('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-2xl mb-6 flex items-center justify-between shadow-sm relative z-10 transition-all duration-500" x-transition:leave="opacity-0 translate-y-[-10px]">
        <div class="flex items-center gap-3">
            <i class="fa-solid fa-check-circle text-emerald-500 text-xl"></i>
            <span class="font-semibold">{{ session('success') }}</span>
        </div>
        <button @click="show = false" class="text-emerald-400 hover:text-emerald-600 transition-colors">
            <i class="fa-solid fa-xmark text-lg"></i>
        </button>
    </div>
@endif

@if($errors->any())
    <div class="bg-rose-50 border border-rose-200 text-rose-700 px-4 py-3 rounded-2xl mb-6 shadow-sm relative z-10">
        <div class="flex items-center gap-3 mb-2">
            <i class="fa-solid fa-exclamation-circle text-rose-500 text-xl"></i>
            <span class="font-semibold">An error occurred:</span>
        </div>
        <ul class="list-disc list-inside text-sm space-y-1">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<script id="plannings-data" type="application/json">
    {!! json_encode($plannings ?? []) !!}
</script>
<script id="notes-data" type="application/json">
    {!! json_encode($notes ?? []) !!}
</script>

<div
x-data="{
    openMonth: false,
    openYear: false,
    showLihatModal: false,
    showEditModal: false,
    showEditNoteModal: false,
    showLihatNoteModal: false,
    showCreateModal: false,
    showCreateChoiceModal: false,
    isWritingNote: false,
    selectedDate: '',
    csrfToken: document.querySelector('meta[name=csrf-token]').getAttribute('content'),
    currentYear: new Date().getFullYear(),
    currentMonth: new Date().getMonth(),
    viewingPlanning: {},
    editingPlanning: {},
    viewingNote: {},
    editingNote: {},
    loadingNotes: false,

    allNotes: [],

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

    noteData: {
        title: '',
        content: '',
        color: 'bg-indigo-500',
        date: ''
    },
    
    months: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
    years: [],
    days: [],
    
    allStatuses: [
        { id: 'backlog', name: 'Backlog' },
        { id: 'progress', name: 'In Progress' },
        { id: 'review', name: 'In Review' },
        { id: 'revisi', name: 'Revision' },
        { id: 'hold_on', name: 'Hold On' },
        { id: 'approved', name: 'Approved' },
        { id: 'published', name: 'Published' }
    ],

    userOptions: ['Dina', 'Adelsa', 'Lisa', 'Putri'],
    jobdeskOptions: ['Content Planner', 'Copywriting', 'Script writing', 'Video Editor', 'Graphic Design'],
    toolOptions: ['Capcut', 'Canva', 'Figma', 'Instagram', 'TikTok'],

    allTasks: [],
    priorityOrder: { urgent: 0, high: 1, normal: 2, low: 3 },

    async init() {
        try {
            let rawData = JSON.parse(document.getElementById('plannings-data').textContent);
            this.allTasks = rawData.map(task => {
                if (typeof task.assigned === 'string') {
                    try { task.assigned = JSON.parse(task.assigned); } catch(e) { task.assigned = []; }
                }
                if (!Array.isArray(task.assigned)) task.assigned = [];

                if (typeof task.references === 'string') {
                    try { task.references = JSON.parse(task.references); } catch(e) { task.references = []; }
                }
                if (!Array.isArray(task.references)) task.references = [];

                if (!task.due_date && task.start_date) task.due_date = task.start_date;
                if (!task.start_date && task.due_date) task.start_date = task.due_date;

                return task;
            });
        } catch(e) {
            console.error('Failed to load planning data:', e);
            this.allTasks = [];
        }

        await this.loadNotes();
        this.sortAllTasks();

        const startYear = this.currentYear - 10;
        for (let i = 0; i <= 20; i++) {
            this.years.push(startYear + i);
        }
        this.generateCalendar();

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

    async loadNotes() {
        this.loadingNotes = true;
        try {
            const res = await fetch('/notes', {
                headers: { 'Accept': 'application/json' }
            });
            if (!res.ok) throw new Error('Failed to fetch notes');
            const data = await res.json();
            this.allNotes = (data || []).map(n => ({
                color: 'bg-indigo-500',
                ...n,
                color: n.color || 'bg-indigo-500'
            }));
        } catch(e) {
            console.error('Failed to load notes:', e);
            this.allNotes = [];
        } finally {
            this.loadingNotes = false;
        }
    },

    sortAllTasks() {
        const order = this.priorityOrder;
        this.allTasks.sort((a, b) => {
            const pa = order[a.priority] ?? 99;
            const pb = order[b.priority] ?? 99;
            if (pa !== pb) return pa - pb;
            const da = new Date(a.due_date || a.start_date || '9999-12-31');
            const db = new Date(b.due_date || b.start_date || '9999-12-31');
            return da - db;
        });
    },

    getSortedTasksWithDates() {
        const withDates = this.allTasks.filter(t => t.start_date && t.due_date);
        const order = this.priorityOrder;
        return [...withDates].sort((a, b) => {
            const pa = order[a.priority] ?? 99;
            const pb = order[b.priority] ?? 99;
            if (pa !== pb) return pa - pb;
            const da = new Date(a.due_date || a.start_date || '9999-12-31');
            const db = new Date(b.due_date || b.start_date || '9999-12-31');
            return da - db;
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
            tempDays.push({ number: dayNum, date: dateStr, currentMonth: false, weekend: false });
        }
        
        for (let i = 1; i <= daysInMonth; i++) {
            const dateObj = new Date(this.currentYear, this.currentMonth, i);
            const dateStr = this.formatDateString(i, this.currentMonth, this.currentYear);
            tempDays.push({
                number: i,
                date: dateStr,
                currentMonth: true,
                today: todayStr === dateStr,
                weekend: dateObj.getDay() === 0 || dateObj.getDay() === 6
            });
        }
        
        const totalCells = tempDays.length > 35 ? 42 : 35;
        const remaining = totalCells - tempDays.length;
        for (let i = 1; i <= remaining; i++) {
            const dateStr = this.formatDateString(i, this.currentMonth + 1, this.currentYear);
            tempDays.push({ number: i, date: dateStr, currentMonth: false, weekend: false });
        }

        let daySlots = {};
        tempDays.forEach(day => {
            daySlots[day.date] = [];
        });

        let parseD = (dStr) => {
            let p = dStr.split('-');
            return new Date(p[0], p[1] - 1, p[2]);
        };

        let sortedTasks = this.getSortedTasksWithDates();

        sortedTasks.forEach(task => {
            let start = parseD(task.start_date);
            let end = parseD(task.due_date);
            let slotIndex = 0;
            let foundFreeSlot = false;
            
            while (!foundFreeSlot) {
                let isFree = true;
                let curr = new Date(start);
                while (curr <= end) {
                    let dStr = this.formatDateObj(curr);
                    if (daySlots[dStr] && daySlots[dStr][slotIndex] !== undefined) {
                        isFree = false;
                        break;
                    }
                    curr.setDate(curr.getDate() + 1);
                }
                if (isFree) foundFreeSlot = true;
                else slotIndex++;
            }
            
            let curr = new Date(start);
            while (curr <= end) {
                let dStr = this.formatDateObj(curr);
                if (daySlots[dStr]) {
                    daySlots[dStr][slotIndex] = task;
                }
                curr.setDate(curr.getDate() + 1);
            }
        });

        tempDays.forEach(day => {
            let slots = daySlots[day.date] || [];
            for(let i=0; i<slots.length; i++){
                if(!slots[i]) slots[i] = { is_placeholder: true, id: 'dummy-'+day.date+'-'+i };
            }
            day.tasks = slots;
        });

        this.days = tempDays;
    },

    formatDateString(d, m, y) {
        const date = new Date(y, m, d);
        return this.formatDateObj(date);
    },

    getNotesForDate(dateStr) {
        return this.allNotes.filter(n => n.date === dateStr);
    },

    async saveNote() {
        if(!this.noteData.title || !this.selectedDate) return;
        const payload = {
            ...this.noteData,
            date: this.selectedDate
        };

        try {
            const res = await fetch('/notes', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': this.csrfToken
                },
                body: JSON.stringify(payload)
            });

            if (!res.ok) throw new Error('Failed to save note');
            const data = await res.json();
            if (data.note) this.allNotes.push(data.note);
            
            AppPopup.success('Success', 'Note successfully created');
            this.showCreateChoiceModal = false;
            this.isWritingNote = false;
            this.noteData = { title: '', content: '', color: 'bg-indigo-500', date: '' };
        } catch(e) {
            console.error('Error saving note:', e);
            AppPopup.success('Error', 'Failed to create note');
        }
    },

    openLihatNote(note) {
        this.viewingNote = JSON.parse(JSON.stringify(note));
        this.showLihatNoteModal = true;
    },

    openEditNote(note) {
        this.editingNote = JSON.parse(JSON.stringify(note));
        this.showEditNoteModal = true;
        this.showLihatNoteModal = false;
    },

    async updateNote() {
        if (!this.editingNote?.id) return;
        try {
            const res = await fetch(`/notes/${this.editingNote.id}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': this.csrfToken
                },
                body: JSON.stringify(this.editingNote)
            });
            if (!res.ok) throw new Error('Failed to update note');
            const data = await res.json();
            let index = this.allNotes.findIndex(n => n.id === this.editingNote.id);
            if (index !== -1 && data.note) {
                this.allNotes[index] = data.note;
                this.viewingNote = JSON.parse(JSON.stringify(data.note));
            }
            AppPopup.success('Success', 'Note successfully updated');
            this.showEditNoteModal = false;
        } catch(e) {
            console.error('Error updating note:', e);
        }
    },

    async deleteNote(id) {
        if (!id) return;

        AppPopup.confirmDelete(
            'Delete Note',
            'Are you sure you want to delete this note?',
            async () => {
                this.showLihatNoteModal = false;
                try {
                    const res = await fetch(`/notes/${id}`, {
                        method: 'DELETE',
                        headers: { 
                            'Accept': 'application/json', 
                            'X-CSRF-TOKEN': this.csrfToken 
                        }
                    });

                    if (!res.ok) throw new Error('Failed to delete note');

                    this.allNotes = this.allNotes.filter(n => n.id !== id);
                    AppPopup.success('Success', 'Note successfully deleted');

                } catch(e) { 
                    console.error('Error deleting note:', e); 
                }
            }
        );
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
            status: 'backlog', title: '', content_type: 'TikTok', description: '',
            start_date: date, due_date: date, priority: 'normal', media_link: '',
            assigned: [{ name: '', jobdesks: [], tools: [] }], references: ['']
        };
        this.showCreateChoiceModal = true;
    },

    openCreatePlanning(date = '') {
        this.planning = {
            status: 'backlog', title: '', content_type: 'TikTok', description: '',
            start_date: date, due_date: date, priority: 'normal', media_link: '',
            assigned: [{ name: '', jobdesks: [], tools: [] }], references: ['']
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
        let target = mode === 'create' ? this.planning : this.editingPlanning;
        if (!target.assigned) target.assigned = [];
        target.assigned.push({ name: '', jobdesks: [], tools: [] });
    },
    removeAssigned(mode = 'edit', index) {
        let target = mode === 'create' ? this.planning : this.editingPlanning;
        if(target.assigned.length > 1) target.assigned.splice(index, 1);
    },
    addReference(mode = 'edit') {
        let target = mode === 'create' ? this.planning : this.editingPlanning;
        if (!target.references) target.references = [];
        target.references.push('');
    },
    removeReference(mode = 'edit', index) {
        let target = mode === 'create' ? this.planning : this.editingPlanning;
        if(target.references.length > 1) target.references.splice(index, 1);
    },

    getPriorityStyles(priority) {
        const styles = {
            'urgent': 'bg-rose-500 text-white border-rose-600 shadow-rose-100',
            'high': 'bg-yellow-400 text-slate-800 border-yellow-500 shadow-yellow-100',
            'normal': 'bg-blue-600 text-white border-blue-700 shadow-blue-100',
            'low': 'bg-slate-400 text-white border-slate-500 shadow-slate-100'
        };
        return styles[priority] || 'bg-slate-400 text-white border-slate-500';
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
class="min-h-[calc(100vh-120px)] h-auto flex flex-col bg-[#fcfdfe] rounded-[2.5rem] border border-slate-200 overflow-hidden shadow-2xl relative"
>

<!-- Decoration Effects -->
<div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-indigo-200/20 blur-[100px] pointer-events-none"></div>
<div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-purple-200/20 blur-[100px] pointer-events-none"></div>

<!-- Calendar Header -->
<div class="flex items-center justify-between px-8 py-6 border-b border-slate-200 bg-white/60 backdrop-blur-xl relative z-[3]">
    <div class="flex items-center gap-4">
        <button @click="goToToday()" class="px-5 py-2 bg-white border border-slate-200 text-slate-600 text-sm font-bold rounded-xl hover:bg-slate-50 transition-all shadow-sm">
            Today
        </button>

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
        Hover over a date to add a plan or note
    </div>
</div>

<!-- Days Name Header -->
<div class="grid grid-cols-7 border-b-2 border-slate-200 bg-slate-50/80 relative z-[2] text-slate-500 font-black uppercase tracking-[0.3em] text-[10px]">
    <template x-for="dayName in ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat']">
        <div class="py-4 text-center border-r border-slate-200" x-text="dayName"></div>
    </template>
</div>

<!-- Dynamic Calendar Grid -->
<div class="flex-1 grid grid-cols-7 bg-transparent relative z-[1]">
    <template x-for="(day, index) in days" :key="index">
        <div 
            class="min-h-[160px] border-r border-b border-slate-200 p-0 transition-all hover:bg-indigo-50/10 group cursor-pointer relative flex flex-col"
            :class="!day.currentMonth ? 'bg-slate-100/60 opacity-60' : (day.weekend ? 'bg-slate-50/80' : '')"
        >
            <div class="p-3 pb-1 flex justify-between items-start">
                <span 
                    class="text-xs font-black w-8 h-8 flex items-center justify-center rounded-xl transition-all"
                    :class="day.today ? 'bg-indigo-600 text-white shadow-lg' : (day.currentMonth ? 'text-slate-800' : 'text-slate-200')"
                    x-text="day.number"
                ></span>
            </div>

            <!-- Card Container -->
            <div class="flex-1 pb-10 space-y-1.5 flex flex-col pt-1">
                
                <!-- RENDER PLANNING -->
                <template x-for="task in day.tasks" :key="task.id || Math.random()">
                    <div class="w-full">
                        <template x-if="task.is_placeholder">
                            <div class="h-[42px] w-full invisible"></div>
                        </template>

                        <template x-if="!task.is_placeholder">
                            <div 
                                @click.stop="openLihat(task)"
                                class="flex items-stretch overflow-hidden transition-all relative h-[42px] cursor-pointer hover:opacity-90"
                                :class="[
                                    getPriorityStyles(task.priority),
                                    day.date === task.start_date && day.date === task.due_date ? 'rounded-lg mx-2 border shadow-sm' : 
                                    day.date === task.start_date ? 'rounded-l-lg ml-2 mr-0 border-y border-l border-r-0 shadow-sm z-10' : 
                                    day.date === task.due_date ? 'rounded-r-lg ml-0 mr-2 border-y border-r border-l-0 shadow-sm z-10' : 'mx-0 border-y border-x-0 rounded-none shadow-sm z-10'
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
                    </div>
                </template>

                <!-- RENDER NOTES -->
                <template x-for="note in getNotesForDate(day.date)" :key="note.id">
                    <div 
                        @click.stop="openLihatNote(note)"
                        class="p-2 mx-2 rounded-xl shadow-sm border border-black/5 flex flex-col gap-0.5 transition-all hover:scale-[1.02] cursor-pointer"
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

            <!-- CREATE BUTTON -->
            <button 
                @click.stop="openCreate(day.date)"
                class="absolute bottom-3 right-3 w-8 h-8 bg-indigo-600 text-white rounded-xl shadow-lg shadow-indigo-200 flex items-center justify-center hover:bg-indigo-700 hover:scale-110 active:scale-95 transition-all opacity-0 group-hover:opacity-100 z-20"
                title="Add plan or note on this date"
            >
                <i class="fa-solid fa-plus text-xs"></i>
            </button>
        </div>
    </template>
</div>

<!-- Modals -->
@include('boardplanning.lihatplanning')
@include('boardplanning.editplanning')
@include('calendernotes.createnotes')
@include('calendernotes.partials.lihatnotes')
@include('calendernotes.editnotes')

<!-- Modal Create Choice -->
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
                    <h3 class="text-xl font-bold text-slate-800 tracking-tight">Create New Planning</h3>
                    <p class="text-xs text-slate-500 font-medium uppercase tracking-widest">Set content details for date <span class="text-indigo-600 font-black" x-text="planning.start_date"></span></p>
                </div>
            </div>
            <button @click="showCreateModal = false" class="w-10 h-10 rounded-full hover:bg-slate-200 flex items-center justify-center text-slate-400">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>

        <div class="flex-1 overflow-y-auto p-8 space-y-8 custom-scrollbar text-slate-800 text-sm">
            <p class="text-center italic text-slate-400">You can link the planning creation form to the main Create modal here.</p>
        </div>

        <div class="px-8 py-6 border-t border-slate-100 bg-slate-50/50 flex items-center justify-end gap-4">
            <button @click="showCreateModal = false" class="px-8 py-3 rounded-2xl text-sm font-bold text-slate-500 hover:bg-slate-200 transition-all">Cancel</button>
            <button @click="showCreateModal = false; console.log('Create:', planning);" class="bg-indigo-600 text-white px-10 py-3 rounded-2xl font-bold text-sm shadow-xl shadow-indigo-200 hover:bg-indigo-700 transition-all">Create Planning</button>
        </div>
    </div>
</div>

</div>

<style>
.custom-scrollbar::-webkit-scrollbar { width: 6px; }
.custom-scrollbar-track { background: transparent; }
.custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
.custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #cbd5e1; }

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