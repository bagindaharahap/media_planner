@extends('layouts.app')

    @section('title', 'Board Planning - PlannerX')

    @section('content')

    <!-- Menyimpan data dari Laravel ke dalam tag script agar aman dari error tanda kutip (quotes) di atribut HTML -->
    <script id="plannings-data" type="application/json">
        {!! json_encode($plannings ?? []) !!}
    </script>

    <!-- Wrapper utama dengan Alpine.js untuk state Global -->
    <div 
        x-data="{ 
            selectedTasks: [],
            showCreateModal: false,
            showEditModal: false,
            showLihatModal: false,
            showDeleteModal: false,
            deleteTarget: null,
            taskToDelete: null,

            allStatuses: [
                { id: 'backlog', name: 'Backlog' },
                { id: 'progress', name: 'In Progress' },
                { id: 'review', name: 'In Review' },
                { id: 'revisi', name: 'Revisi' },
                { id: 'hold_on', name: 'Hold On' },
                { id: 'approved', name: 'Approved' },
                { id: 'published', name: 'Published' }
            ],

            /* Mengambil data secara aman dari tag script JSON di atas */
            tasks: JSON.parse(document.getElementById('plannings-data').textContent),

            planning: {
                status: 'backlog', title: '', content_type: 'TikTok', description: '',
                start_date: '', due_date: '', priority: 'normal', media_link: '', revision_note: '',
                assigned: [{ name: '', jobdesks: [], tools: [] }],
                references: ['']
            },

            editingPlanning: {
                id: '', status: '', title: '', content_type: '', description: '',
                start_date: '', due_date: '', priority: '', media_link: '', revision_note: '', 
                assigned: [], references: []
            },

            viewingPlanning: {},

            userOptions: ['Dina', 'Adelsa', 'Lisa', 'Putri'],
            jobdeskOptions: ['Content Planner', 'Copywriting', 'Script writing', 'Dokumentasi', 'Editor Video', 'Desain Grafis', 'Upload Story', 'Ide content'],
            toolOptions: ['Gemini', 'Chatgpt', 'Spreedsheet', 'Kamera', 'HP', 'Capcut', 'Canva', 'Figma', 'Instagram', 'WA', 'Adobe', 'Tiktok'],
            contentTypeOptions: ['TikTok', 'Reels', 'Feed', 'Story'],

            /* Helper untuk mengambil Token CSRF Laravel */
            getCsrfToken() {
                const meta = document.querySelector('meta[name=\'csrf-token\']');
                return meta ? meta.getAttribute('content') : '';
            },

            init() {
                /* Kosongkan karena tasks sudah diisi otomatis melalui JSON.parse saat halaman diload */
            },

            openLihat(task) {
                this.viewingPlanning = task;
                this.showLihatModal = true;
            },

            openEdit(task) {
                /* Pastikan data diformat dengan benar terutama JSON array */
                this.editingPlanning = JSON.parse(JSON.stringify(task));
                if(!this.editingPlanning.assigned || this.editingPlanning.assigned.length === 0) {
                    this.editingPlanning.assigned = [{ name: '', jobdesks: [], tools: [] }];
                }
                if(!this.editingPlanning.references || this.editingPlanning.references.length === 0) {
                    this.editingPlanning.references = [''];
                }
                this.showEditModal = true;
            },

            confirmDelete(id = null) {
                if (id) {
                    this.taskToDelete = id;
                    this.deleteTarget = 'single';
                } else {
                    this.deleteTarget = 'bulk';
                }
                this.showDeleteModal = true;
            },

            /* --- FUNGSI CREATE (POST KE DATABASE) --- */
            async executeCreate() {
                try {
                    let response = await fetch('/board-planning', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': this.getCsrfToken()
                        },
                        body: JSON.stringify(this.planning)
                    });
                    let result = await response.json();
                    
                    if(result.success) {
                        this.tasks.push(result.data);
                        this.showCreateModal = false;
                        /* Reset form */
                        this.planning = { 
                            status: 'backlog', title: '', content_type: 'TikTok', description: '',
                            start_date: '', due_date: '', priority: 'normal', media_link: '', revision_note: '',
                            assigned: [{ name: '', jobdesks: [], tools: [] }], references: [''] 
                        };
                    }
                } catch (error) {
                    console.error('Error saving:', error);
                }
            },

            /* --- FUNGSI UPDATE (PUT KE DATABASE) --- */
            async executeUpdate() {
                try {
                    let response = await fetch(`/board-planning/${this.editingPlanning.id}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': this.getCsrfToken()
                        },
                        body: JSON.stringify(this.editingPlanning)
                    });
                    let result = await response.json();
                    
                    if(result.success) {
                        const index = this.tasks.findIndex(t => t.id === this.editingPlanning.id);
                        if (index !== -1) {
                            this.tasks[index] = result.data;
                        }
                        this.showEditModal = false;
                    }
                } catch (error) {
                    console.error('Error updating:', error);
                }
            },

            /* --- FUNGSI DELETE (DELETE KE DATABASE) --- */
            async executeDelete() {
                try {
                    if (this.deleteTarget === 'single') {
                        let response = await fetch(`/board-planning/${this.taskToDelete}`, {
                            method: 'DELETE',
                            headers: {
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': this.getCsrfToken()
                            }
                        });
                        let result = await response.json();
                        
                        if(result.success) {
                            this.tasks = this.tasks.filter(t => t.id !== this.taskToDelete);
                        }
                    } else {
                        /* Logika Hapus Massal (Bulk Delete) */
                        for(let id of this.selectedTasks) {
                            await fetch(`/board-planning/${id}`, {
                                method: 'DELETE',
                                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': this.getCsrfToken() }
                            });
                        }
                        this.tasks = this.tasks.filter(t => !this.selectedTasks.includes(t.id));
                        this.selectedTasks = [];
                    }
                } catch (error) {
                    console.error('Error deleting:', error);
                } finally {
                    this.showDeleteModal = false;
                    this.taskToDelete = null;
                }
            },

            toggleGroup(status) {
                let columnTasks = this.tasks.filter(t => t.status === status).map(t => t.id);
                if (columnTasks.length === 0) return;
                let allSelected = columnTasks.every(id => this.selectedTasks.includes(id));
                if (allSelected) {
                    this.selectedTasks = this.selectedTasks.filter(id => !columnTasks.includes(id));
                } else {
                    this.selectedTasks = [...new Set([...this.selectedTasks, ...columnTasks])];
                }
            },

            isGroupSelected(status) {
                let columnTasks = this.tasks.filter(t => t.status === status).map(t => t.id);
                if (columnTasks.length === 0) return false;
                return columnTasks.every(id => this.selectedTasks.includes(id));
            },

            getPriorityClass(priority) {
                const priorityBadges = {
                    'urgent': 'bg-red-100 text-red-600',
                    'high': 'bg-yellow-100 text-yellow-700',
                    'normal': 'bg-blue-100 text-blue-600',
                    'low': 'bg-slate-100 text-slate-500',
                };
                return priorityBadges[priority] || 'bg-slate-100 text-slate-500';
            },

            /* --- Inisialisasi Sortable dan UPDATE DATABASE Saat Drag & Drop --- */
            initSortable(el) {
                new Sortable(el, {
                    group: 'kanban',
                    animation: 200, // Animasi saat menggeser card (lebih mulus)
                    ghostClass: 'opacity-40', // Class saat card ditinggalkan di posisi asal
                    dragClass: 'shadow-2xl', // Memberi efek melayang tinggi saat di-drag
                    forceFallback: true, // Bypass HTML5 Drag Drop default browser agar lebih mulus
                    fallbackClass: 'sortable-fallback',
                    draggable: '.kanban-item',
                    onAdd: (evt) => {
                        const taskId = evt.item.getAttribute('data-id');
                        const newStatus = el.getAttribute('data-status');
                        
                        /* AlpineJS harus tetap mengatur DOM-nya sendiri */
                        evt.item.remove();
                        
                        const task = this.tasks.find(t => t.id == taskId);
                        if (task && task.status !== newStatus) {
                            task.status = newStatus;

                            /* API Update Status di Database */
                            fetch(`/board-planning/${taskId}`, {
                                method: 'PUT',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/json',
                                    'X-CSRF-TOKEN': this.getCsrfToken()
                                },
                                body: JSON.stringify({ status: newStatus })
                            }).catch(err => console.error('Gagal memindahkan task:', err));
                        }
                    }
                });
            }
        }"
        class="h-[calc(100vh-120px)] flex flex-col relative"
    >
        <!-- Header Board -->
        <div class="flex items-center justify-between mb-6 px-2 text-slate-800">
            <div>
                <h1 class="text-2xl font-bold tracking-tight">Perencanaan Konten</h1>
                <p class="text-sm text-slate-500">Visualisasi alur kerja tim dan manajemen tugas.</p>
            </div>
            <button @click="showCreateModal = true" class="bg-indigo-600 text-white px-6 py-2.5 rounded-2xl font-bold shadow-lg shadow-indigo-200 hover:bg-indigo-700 hover:-translate-y-0.5 transition-all flex items-center gap-2">
                <i class="fa-solid fa-plus text-xs"></i>
                Buat Planning
            </button>
        </div>

        <!-- Container Board -->
        <div class="flex-1 overflow-x-auto pb-6 custom-scrollbar">
            <div class="flex gap-6 min-w-max h-full items-start">
                
                @php
                    $columns = [
                        ['id' => 'backlog', 'name' => 'Backlog', 'color' => 'slate', 'icon' => 'fa-circle-notch'],
                        ['id' => 'progress', 'name' => 'In Progress', 'color' => 'indigo', 'icon' => 'fa-play'],
                        ['id' => 'review', 'name' => 'In Review', 'color' => 'red', 'icon' => 'fa-eye'],
                        ['id' => 'revisi', 'name' => 'Revisi', 'color' => 'amber', 'icon' => 'fa-rotate-left'],
                        ['id' => 'hold_on', 'name' => 'Hold On', 'color' => 'orange', 'icon' => 'fa-pause'],
                        ['id' => 'approved', 'name' => 'Approved', 'color' => 'blue', 'icon' => 'fa-check-double'],
                        ['id' => 'published', 'name' => 'Published', 'color' => 'emerald', 'icon' => 'fa-paper-plane'],
                    ];
                @endphp

                @foreach($columns as $col)
                <div class="w-80 flex flex-col bg-{{ $col['color'] }}-50/50 rounded-[2.5rem] p-4 border border-{{ $col['color'] }}-200 shadow-sm transition-all duration-300 max-h-full">
                    <div class="flex items-center justify-between mb-5 px-2 shrink-0">
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 bg-{{ $col['color'] === 'slate' ? 'slate-800' : ($col['color'] . '-600') }} rounded-lg flex items-center justify-center text-[10px] text-white shadow-sm">
                                <i class="fa-solid {{ $col['icon'] }}"></i>
                            </div>
                            <span class="font-bold text-xs uppercase tracking-widest text-{{ $col['color'] === 'slate' ? 'slate-700' : ($col['color'] . '-900') }}">{{ $col['name'] }}</span>
                        </div>
                        <button @click="toggleGroup('{{ $col['id'] }}')" class="w-7 h-7 rounded-lg flex items-center justify-center transition-all border-2" :class="isGroupSelected('{{ $col['id'] }}') ? 'bg-indigo-600 border-indigo-600 text-white shadow-md' : 'bg-white border-slate-200 text-transparent shadow-sm'">
                            <i class="fa-solid fa-check text-[10px]"></i>
                        </button>
                    </div>
                    
                    <!-- Kanban List: Menambahkan min-h-[150px] agar mudah menaruh di area yang kosong -->
                    <div 
                        class="kanban-list flex-1 space-y-4 p-1 overflow-y-auto max-h-[calc(100vh-320px)] min-h-[150px] custom-scrollbar-v" 
                        data-status="{{ $col['id'] }}"
                        x-init="initSortable($el)"
                    >
                        <template x-for="task in tasks.filter(t => t.status === '{{ $col['id'] }}')" :key="task.id">
                            <!-- PENTING: Class transition-all DIGANTI menjadi transition-colors transition-shadow untuk mengatasi issue Lengket/Glitch Sortable -->
                            <div 
                                @click="openLihat(task)"
                                :data-id="task.id"
                                class="kanban-item bg-white p-5 rounded-3xl shadow-sm border transition-colors transition-shadow duration-200 group relative hover:shadow-md cursor-grab active:cursor-grabbing" 
                                :class="selectedTasks.includes(task.id) ? 'border-indigo-600 ring-2 ring-indigo-100' : 'border-slate-100 hover:border-indigo-200'"
                            >
                                <!-- Tombol Aksi -->
                                <div class="flex items-center gap-2 absolute top-4 right-4 z-10">
                                    <button @click.stop="openEdit(task)" class="text-slate-300 hover:text-indigo-600 transition-colors"><i class="fa-solid fa-pen-to-square text-xs"></i></button>
                                    <button @click.stop="confirmDelete(task.id)" class="text-slate-300 hover:text-red-500 transition-colors"><i class="fa-solid fa-trash text-xs"></i></button>
                                    <input type="checkbox" @click.stop :value="task.id" x-model="selectedTasks" class="task-checkbox w-4 h-4 rounded-md border-slate-300 text-indigo-600 focus:ring-indigo-500 cursor-pointer">
                                </div>

                                <!-- Konten Kartu -->
                                <div class="space-y-4">
                                    <div class="flex flex-wrap gap-2 pr-12">
                                        <span class="px-2 py-0.5 bg-indigo-50 text-indigo-600 text-[9px] font-black rounded-lg uppercase tracking-tighter" x-text="task.content_type"></span>
                                        <span class="px-2 py-0.5 text-[9px] font-black rounded-lg uppercase tracking-tighter" :class="getPriorityClass(task.priority)" x-text="task.priority"></span>
                                    </div>

                                    <h4 class="font-bold text-[15px] text-slate-800 leading-tight group-hover:text-indigo-600 transition-colors" x-text="task.title"></h4>
                                    
                                    <!-- Integrasi PENJAB Database Dinamis -->
                                    <div class="flex items-center justify-between mt-4">
                                        <div class="flex flex-wrap items-center gap-2">
                                            <!-- Jika ada Penjab (Minimal 1) -->
                                            <template x-if="task.assigned && task.assigned.length > 0 && task.assigned[0].name !== ''">
                                                <div class="flex items-center gap-2">
                                                    <template x-for="(assignee, idx) in task.assigned.slice(0, 2)" :key="idx">
                                                        <div class="flex items-center gap-1.5 bg-slate-50 px-2 py-1 rounded-lg border border-slate-100">
                                                            <div class="w-5 h-5 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 text-[8px] font-black uppercase" 
                                                                x-text="assignee.name.substring(0, 2)"></div>
                                                            <span class="text-[10px] font-bold text-slate-600" x-text="assignee.name.split(' ')[0]"></span>
                                                        </div>
                                                    </template>
                                                    <!-- Jika ada lebih dari 2 penjab -->
                                                    <template x-if="task.assigned.length > 2">
                                                        <div class="w-6 h-6 rounded-full bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-500 text-[9px] font-bold" 
                                                            x-text="'+' + (task.assigned.length - 2)"></div>
                                                    </template>
                                                </div>
                                            </template>

                                            <!-- Jika belum ada penjab yang ditentukan -->
                                            <template x-if="!task.assigned || task.assigned.length === 0 || task.assigned[0].name === ''">
                                                <div class="flex items-center gap-1.5 text-slate-400">
                                                    <i class="fa-solid fa-user-xmark text-[10px]"></i>
                                                    <span class="text-[10px] font-bold italic">Belum diassign</span>
                                                </div>
                                            </template>
                                        </div>
                                    </div>

                                    <div class="h-px bg-slate-50 w-full"></div>

                                    <div class="grid grid-cols-2 gap-2 text-slate-600">
                                        <div>
                                            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1">Mulai</p>
                                            <span class="text-[10px] font-bold text-slate-500 italic" x-text="task.start_date || '-'"></span>
                                        </div>
                                        <div>
                                            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1 text-red-500">Deadline</p>
                                            <span class="text-[10px] font-bold text-red-500 italic" x-text="task.due_date || '-'"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Bulk Action Bar -->
        <div x-show="selectedTasks.length > 0" x-cloak class="fixed bottom-10 left-1/2 -translate-x-1/2 bg-white shadow-2xl border border-slate-200 rounded-full px-8 py-4 flex items-center gap-8 z-[100] min-w-[550px]">
            <div class="flex items-center gap-3 pr-6 border-r border-slate-200">
                <span class="bg-indigo-600 text-white w-8 h-8 rounded-full flex items-center justify-center font-bold text-sm shadow-md" x-text="selectedTasks.length"></span>
                <span class="text-slate-600 font-bold text-sm">Item Terpilih</span>
            </div>
            <div class="flex items-center gap-6">
                <button class="flex items-center gap-2 text-slate-600 hover:text-indigo-600 font-bold text-sm transition-colors">
                    <i class="fa-solid fa-arrow-right-arrow-left"></i> Pindahkan
                </button>
                <button @click="confirmDelete()" class="flex items-center gap-2 text-red-500 hover:text-red-700 font-bold text-sm transition-colors">
                    <i class="fa-solid fa-trash-can"></i> Hapus Massal
                </button>
            </div>
            <button @click="selectedTasks = []" class="ml-auto w-8 h-8 rounded-full bg-slate-50 flex items-center justify-center text-slate-400 hover:text-slate-600">
                <i class="fa-solid fa-xmark text-sm"></i>
            </button>
        </div>

        <!-- Modal Delete -->
        <div x-show="showDeleteModal" x-cloak class="fixed inset-0 z-[200] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
            <div @click.outside="showDeleteModal = false" class="bg-white w-full max-w-md rounded-[2.5rem] shadow-2xl p-8 border border-slate-100 text-center">
                <div class="w-20 h-20 bg-red-50 text-red-500 rounded-full flex items-center justify-center mx-auto mb-6 text-3xl shadow-inner"><i class="fa-solid fa-triangle-exclamation"></i></div>
                <h3 class="text-2xl font-bold text-slate-800 mb-2">Hapus Perencanaan?</h3>
                <p class="text-slate-500 text-sm leading-relaxed mb-8 px-4">Tindakan ini permanen. Apakah Anda yakin?</p>
                <div class="flex gap-4">
                    <button @click="showDeleteModal = false" class="flex-1 px-6 py-3.5 rounded-2xl text-sm font-bold text-slate-500 hover:bg-slate-50 border border-slate-100">Batal</button>
                    <button @click="executeDelete()" class="flex-1 px-6 py-3.5 bg-red-500 text-white rounded-2xl font-bold shadow-xl shadow-red-100 hover:bg-red-600 transform active:scale-95 transition-all">Hapus</button>
                </div>
            </div>
        </div>

        @include('boardplanning.createplanning')
        @include('boardplanning.editplanning')
        @include('boardplanning.lihatplanning')
    </div>

    @endsection

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <style>
    .custom-scrollbar::-webkit-scrollbar { height: 8px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
    .custom-scrollbar-v::-webkit-scrollbar { width: 5px; }
    .custom-scrollbar-v::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 20px; }
    [x-cloak] { display: none !important; }
    /* Class khusus untuk item yang sedang ditarik oleh fitur Sortable forceFallback */
    .sortable-fallback {
        opacity: 1 !important;
        cursor: grabbing !important;
    }
    .bg-indigo-50 {
        background-color: #eef2ff !important;
        border: 2px dashed #6366f1 !important;
    }
    </style>
    @endpush