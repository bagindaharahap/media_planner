@extends('layouts.app')

@section('title', 'Board Planning - Content Planner')

@section('content')

<!-- Menyimpan data Laravel ke dalam tag script untuk mencegah masalah escaping tanda kutip -->
<script id="plannings-data" type="application/json">
    {!! json_encode($plannings ?? []) !!}
</script>

<!-- Wrapper utama dengan Alpine.js untuk manajemen state global -->
<div 
    x-data="{ 
        userRole: '{{ Auth::user()->role ?? 'Content Planner' }}',
        selectedTasks: [],
        showCreateModal: false,
        showEditModal: false,
        showLihatModal: false,
        showDeleteModal: false,
        
        // Modal State
        showMediaWarningModal: false,
        showRoleWarningModal: false,
        showPublishConfirmModal: false,

        deleteTarget: null,
        taskToDelete: null,
        taskNeedsMedia: null,
        taskToPublish: null,

        allStatuses: [
            { id: 'backlog', name: 'Draft' },
            { id: 'progress', name: 'In Progress' },
            { id: 'review', name: 'In Review' },
            { id: 'revisi', name: 'Revision' },
            { id: 'hold_on', name: 'Hold On' },
            { id: 'approved', name: 'Approved' },
            { id: 'published', name: 'Published' }
        ],

        tasks: [],

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

        viewingPlanning: { assigned: [], references: [] },

        userOptions: ['Dina', 'Adelsa', 'Lisa', 'Putri'],
        jobdeskOptions: ['Content Planner', 'Copywriting', 'Script writing', 'Documentation', 'Video Editor', 'Graphic Design', 'Upload Story', 'Content Ideas'],
        toolOptions: ['Gemini', 'ChatGPT', 'Spreadsheet', 'Camera', 'Mobile', 'Capcut', 'Canva', 'Figma', 'Instagram', 'WA', 'Adobe', 'TikTok'],
        contentTypeOptions: ['TikTok', 'Reels', 'Feed', 'Story'],
        priorityOrder: { urgent: 0, high: 1, normal: 2, low: 3 },

        getCsrfToken() {
            const meta = document.querySelector('meta[name=\'csrf-token\']');
            return meta ? meta.getAttribute('content') : '';
        },

        getTodayDate() {
            const today = new Date();
            const yyyy = today.getFullYear();
            const mm = String(today.getMonth() + 1).padStart(2, '0');
            const dd = String(today.getDate()).padStart(2, '0');
            return `${yyyy}-${mm}-${dd}`;
        },

        init() {
            try {
                let rawData = JSON.parse(document.getElementById('plannings-data').textContent);
                this.tasks = rawData.map(task => {
                    if (typeof task.assigned === 'string') {
                        try { task.assigned = JSON.parse(task.assigned); } catch(e) { task.assigned = []; }
                    }
                    if (!Array.isArray(task.assigned)) task.assigned = [];

                    if (typeof task.references === 'string') {
                        try { task.references = JSON.parse(task.references); } catch(e) { task.references = []; }
                    }
                    if (!Array.isArray(task.references)) task.references = [];

                    return task;
                });
                this.sortAllTasks();
            } catch(e) {
                console.error('Failed to load planning data:', e);
                this.tasks = [];
            }
        },

        openLihat(task) {
            this.viewingPlanning = JSON.parse(JSON.stringify(task));
            this.showLihatModal = true;
        },

        openEdit(task) {
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

        sortAllTasks() {
            const order = this.priorityOrder;
            this.tasks.sort((a, b) => {
                const pa = order[a.priority] ?? 99;
                const pb = order[b.priority] ?? 99;
                if (pa !== pb) return pa - pb;
                const da = new Date(a.due_date || a.start_date || '9999-12-31');
                const db = new Date(b.due_date || b.start_date || '9999-12-31');
                return da - db;
            });
        },

        async executeCreate() {
            try {
                let today = this.getTodayDate();
                if (!this.planning.start_date) this.planning.start_date = today;
                if (this.planning.start_date < today) {
                    alert('Start date cannot be earlier than today!');
                    return;
                }

                let response = await fetch('/board-planning', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': this.getCsrfToken() },
                    body: JSON.stringify(this.planning)
                });
                let result = await response.json();
                
                if(result.success) {
                    let newTask = result.data;
                    if(typeof newTask.assigned === 'string') newTask.assigned = JSON.parse(newTask.assigned);
                    if(typeof newTask.references === 'string') newTask.references = JSON.parse(newTask.references);
                    
                    this.tasks.push(newTask);
                    this.sortAllTasks();
                    this.showCreateModal = false;
                    this.planning = { 
                        status: 'backlog', title: '', content_type: 'TikTok', description: '',
                        start_date: '', due_date: '', priority: 'normal', media_link: '', revision_note: '',
                        assigned: [{ name: '', jobdesks: [], tools: [] }], references: [''] 
                    };
                }
            } catch (error) { console.error('Error saving:', error); }
        },

        async executeUpdate() {
            try {
                let response = await fetch(`/board-planning/${this.editingPlanning.id}`, {
                    method: 'PUT',
                    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': this.getCsrfToken() },
                    body: JSON.stringify(this.editingPlanning)
                });
                let result = await response.json();
                
                if(result.success) {
                    const index = this.tasks.findIndex(t => t.id === this.editingPlanning.id);
                    if (index !== -1) {
                        let updatedTask = result.data;
                        if(typeof updatedTask.assigned === 'string') updatedTask.assigned = JSON.parse(updatedTask.assigned);
                        if(typeof updatedTask.references === 'string') updatedTask.references = JSON.parse(updatedTask.references);
                        
                        this.tasks[index] = updatedTask;
                        this.sortAllTasks();
                    }
                    this.showEditModal = false;
                }
            } catch (error) { console.error('Error updating:', error); }
        },

        async executeDelete() {
            try {
                if (this.deleteTarget === 'single') {
                    let response = await fetch(`/board-planning/${this.taskToDelete}`, {
                        method: 'DELETE',
                        headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': this.getCsrfToken() }
                    });
                    let result = await response.json();
                    if(result.success) {
                        this.tasks = this.tasks.filter(t => t.id !== this.taskToDelete);
                        this.sortAllTasks();
                    }
                } else {
                    for(let id of this.selectedTasks) {
                        await fetch(`/board-planning/${id}`, {
                            method: 'DELETE',
                            headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': this.getCsrfToken() }
                        });
                    }
                    this.tasks = this.tasks.filter(t => !this.selectedTasks.includes(t.id));
                    this.sortAllTasks();
                    this.selectedTasks = [];
                }
            } catch (error) { console.error('Error deleting:', error); } 
            finally {
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

        revertDOM(task) {
            let originalStatus = task.status;
            task.status = 'refreshing';
            setTimeout(() => { task.status = originalStatus; }, 50);
        },

        executeMoveTask(task, newStatus) {
            task.status = newStatus;
            fetch(`/board-planning/${task.id}`, {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': this.getCsrfToken() },
                body: JSON.stringify({ status: newStatus })
            }).catch(err => console.error('Failed to move task:', err));
        },

        initSortable(el) {
            new Sortable(el, {
                group: 'kanban',
                animation: 200, 
                ghostClass: 'opacity-40', 
                dragClass: 'shadow-2xl',
                draggable: '.kanban-item',
                filter: 'button, input, a, .task-checkbox', 
                preventOnFilter: false, 
                
                onAdd: (evt) => {
                    const taskId = evt.item.getAttribute('data-id');
                    const newStatus = el.getAttribute('data-status');
                    
                    evt.item.remove();
                    const task = this.tasks.find(t => t.id == taskId);
                    
                    if (task && task.status !== newStatus) {
                        
                        // 1. MEDIA LINK VALIDATION
                        const requiresMediaStatuses = ['review', 'revisi', 'hold_on', 'approved', 'published'];
                        if (requiresMediaStatuses.includes(newStatus) && (!task.media_link || task.media_link.trim() === '')) {
                            this.taskNeedsMedia = task;
                            this.showMediaWarningModal = true;
                            this.revertDOM(task); 
                            return; 
                        }

                        // 2. ROLE ACCESS VALIDATION
                        if (this.userRole !== 'Admin') {
                            const forbiddenDestinations = ['hold_on', 'approved'];
                            if (forbiddenDestinations.includes(newStatus)) {
                                this.showRoleWarningModal = true;
                                this.revertDOM(task); 
                                return;
                            }
                        }

                        // 3. PUBLISH VALIDATION
                        if (newStatus === 'published') {
                            this.taskToPublish = task;
                            this.showPublishConfirmModal = true;
                            this.revertDOM(task); 
                            return;
                        }

                        // 4. EXECUTE SAVE
                        this.executeMoveTask(task, newStatus);
                    }
                }
            });
        }
    }"
    class="h-[calc(100vh-120px)] flex flex-col relative"
>
    <!-- Board Header -->
    <div class="flex items-center justify-between mb-6 px-2 text-slate-800">
        <div>
            <h1 class="text-2xl font-bold tracking-tight">Content Planning</h1>
            <p class="text-sm text-slate-500">Team workflow visualization and task management.</p>
        </div>
        <button type="button" @click="showCreateModal = true" class="bg-indigo-600 text-white px-6 py-2.5 rounded-2xl font-bold shadow-lg shadow-indigo-200 hover:bg-indigo-700 hover:-translate-y-0.5 transition-all flex items-center gap-2">
            <i class="fa-solid fa-plus text-xs"></i>
            Create Planning
        </button>
    </div>

    <!-- Board Container -->
    <div class="flex-1 overflow-x-auto pb-6 custom-scrollbar">
        <div class="flex gap-6 min-w-max h-full items-start">
            
            @php
                $columns = [
                    ['id' => 'backlog', 'name' => 'Draft', 'color' => 'slate', 'icon' => 'fa-circle-notch'],
                    ['id' => 'progress', 'name' => 'In Progress', 'color' => 'indigo', 'icon' => 'fa-play'],
                    ['id' => 'review', 'name' => 'In Review', 'color' => 'red', 'icon' => 'fa-eye'],
                    ['id' => 'revisi', 'name' => 'Revision', 'color' => 'amber', 'icon' => 'fa-rotate-left'],
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
                    <button type="button" @click="toggleGroup('{{ $col['id'] }}')" class="w-7 h-7 rounded-lg flex items-center justify-center transition-all border-2" :class="isGroupSelected('{{ $col['id'] }}') ? 'bg-indigo-600 border-indigo-600 text-white shadow-md' : 'bg-white border-slate-200 text-transparent shadow-sm'">
                        <i class="fa-solid fa-check text-[10px]"></i>
                    </button>
                </div>
                
                <div 
                    class="kanban-list flex-1 space-y-4 p-1 overflow-y-auto max-h-[calc(100vh-320px)] min-h-[150px] custom-scrollbar-v" 
                    data-status="{{ $col['id'] }}"
                    x-init="initSortable($el)"
                >
                    <template x-for="task in tasks.filter(t => t.status === '{{ $col['id'] }}')" :key="task.id">
                        <div 
                            @click="openLihat(task)"
                            :data-id="task.id"
                            class="kanban-item bg-white p-5 rounded-3xl shadow-sm border transition-colors transition-shadow duration-200 group relative hover:shadow-md cursor-grab active:cursor-grabbing" 
                            :class="selectedTasks.includes(task.id) ? 'border-indigo-600 ring-2 ring-indigo-100' : 'border-slate-100 hover:border-indigo-200'"
                        >
                            <!-- Action Buttons -->
                            <div class="flex items-center gap-2 absolute top-4 right-4 z-10">
                                <!-- TIKTOK DEMO BUTTON -->
                                <button 
                                    type="button" 
                                    @click.stop="window.dispatchEvent(new CustomEvent('open-tiktok-post', { 
                                        detail: { 
                                            title: task.title + ' #contentplanner', 
                                            videoUrl: 'https://www.w3schools.com/html/mov_bbb.mp4' 
                                        } 
                                    }))"
                                    class="text-slate-300 hover:text-slate-900 transition-colors"
                                    title="Simulasi Post TikTok"
                                >
                                    <i class="fa-brands fa-tiktok text-xs"></i>
                                </button>
                                
                                <button type="button" @click.stop="openEdit(task)" class="text-slate-300 hover:text-indigo-600 transition-colors"><i class="fa-solid fa-pen-to-square text-xs"></i></button>
                                <button type="button" @click.stop="confirmDelete(task.id)" class="text-slate-300 hover:text-red-500 transition-colors"><i class="fa-solid fa-trash text-xs"></i></button>
                                <input type="checkbox" @click.stop :value="task.id" x-model="selectedTasks" class="task-checkbox w-4 h-4 rounded-md border-slate-300 text-indigo-600 focus:ring-indigo-500 cursor-pointer">
                            </div>

                            <!-- Card Content -->
                            <div class="space-y-4">
                                <div class="flex flex-wrap gap-2 pr-12">
                                    <span class="px-2 py-0.5 bg-indigo-50 text-indigo-600 text-[9px] font-black rounded-lg uppercase tracking-tighter" x-text="task.content_type"></span>
                                    <span class="px-2 py-0.5 text-[9px] font-black rounded-lg uppercase tracking-tighter" :class="getPriorityClass(task.priority)" x-text="task.priority"></span>
                                </div>

                                <h4 class="font-bold text-[15px] text-slate-800 leading-tight group-hover:text-indigo-600 transition-colors" x-text="task.title"></h4>
                                
                                <div class="flex items-center justify-between mt-4">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <!-- Assigned Users -->
                                        <template x-if="task.assigned && task.assigned.length > 0 && task.assigned[0].name">
                                            <div class="flex items-center gap-2">
                                                <template x-for="(assignee, idx) in task.assigned.slice(0, 2)" :key="idx">
                                                    <div class="flex items-center gap-1.5 bg-slate-50 px-2 py-1 rounded-lg border border-slate-100">
                                                        <div class="w-5 h-5 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 text-[8px] font-black uppercase" 
                                                            x-text="assignee.name ? assignee.name.substring(0, 2) : '?'"></div>
                                                        <span class="text-[10px] font-bold text-slate-600" x-text="assignee.name ? assignee.name.split(' ')[0] : ''"></span>
                                                    </div>
                                                </template>
                                                <template x-if="task.assigned.length > 2">
                                                    <div class="w-6 h-6 rounded-full bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-500 text-[9px] font-bold" 
                                                        x-text="'+' + (task.assigned.length - 2)"></div>
                                                </template>
                                            </div>
                                        </template>

                                        <!-- Unassigned State -->
                                        <template x-if="!task.assigned || task.assigned.length === 0 || !task.assigned[0].name">
                                            <div class="flex items-center gap-1.5 text-slate-400">
                                                <i class="fa-solid fa-user-xmark text-[10px]"></i>
                                                <span class="text-[10px] font-bold italic">Unassigned</span>
                                            </div>
                                        </template>
                                    </div>
                                </div>

                                <div class="h-px bg-slate-50 w-full"></div>

                                <div class="grid grid-cols-2 gap-2 text-slate-600">
                                    <div>
                                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1">Start</p>
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
            <span class="text-slate-600 font-bold text-sm">Items Selected</span>
        </div>
        <div class="flex items-center gap-6">
            <button type="button" class="flex items-center gap-2 text-slate-600 hover:text-indigo-600 font-bold text-sm transition-colors">
                <i class="fa-solid fa-arrow-right-arrow-left"></i> Move
            </button>
            <button type="button" @click="confirmDelete()" class="flex items-center gap-2 text-red-500 hover:text-red-700 font-bold text-sm transition-colors">
                <i class="fa-solid fa-trash-can"></i> Bulk Delete
            </button>
        </div>
        <button type="button" @click="selectedTasks = []" class="ml-auto w-8 h-8 rounded-full bg-slate-50 flex items-center justify-center text-slate-400 hover:text-slate-600">
            <i class="fa-solid fa-xmark text-sm"></i>
        </button>
    </div>

    <!-- Delete Modal -->
    <div x-show="showDeleteModal" x-cloak class="fixed inset-0 z-[200] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
        <div @click.outside="showDeleteModal = false" class="bg-white w-full max-w-md rounded-[2.5rem] shadow-2xl p-8 border border-slate-100 text-center">
            <div class="w-20 h-20 bg-red-50 text-red-500 rounded-full flex items-center justify-center mx-auto mb-6 text-3xl shadow-inner"><i class="fa-solid fa-triangle-exclamation"></i></div>
            <h3 class="text-2xl font-bold text-slate-800 mb-2">Delete Planning?</h3>
            <p class="text-slate-500 text-sm leading-relaxed mb-8 px-4">This action is permanent. Are you sure?</p>
            <div class="flex gap-4">
                <button type="button" @click="showDeleteModal = false" class="flex-1 px-6 py-3.5 rounded-2xl text-sm font-bold text-slate-500 hover:bg-slate-50 border border-slate-100">Cancel</button>
                <button type="button" @click="executeDelete()" class="flex-1 px-6 py-3.5 bg-red-500 text-white rounded-2xl font-bold shadow-xl shadow-red-100 hover:bg-red-600 transform active:scale-95 transition-all">Delete</button>
            </div>
        </div>
    </div>

    <!-- Media Asset Warning Modal -->
    <div x-show="showMediaWarningModal" x-cloak class="fixed inset-0 z-[200] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
        <div @click.outside="showMediaWarningModal = false" class="bg-white w-full max-w-md rounded-[2.5rem] shadow-2xl p-8 border border-slate-100 text-center">
            <div class="w-20 h-20 bg-amber-50 text-amber-500 rounded-full flex items-center justify-center mx-auto mb-6 text-3xl shadow-inner"><i class="fa-solid fa-link-slash"></i></div>
            <h3 class="text-2xl font-bold text-slate-800 mb-2">Media Asset Empty!</h3>
            <p class="text-slate-500 text-sm leading-relaxed mb-8 px-4">This planning cannot be moved to <b>Review, Revision, Hold On, Approved, or Published</b> stages because the media asset link (Google Drive) has not been attached.</p>
            <div class="flex gap-4">
                <button type="button" @click="showMediaWarningModal = false" class="flex-1 px-6 py-3.5 rounded-2xl text-sm font-bold text-slate-500 hover:bg-slate-50 border border-slate-100">Later</button>
                <button type="button" @click="showMediaWarningModal = false; openEdit(taskNeedsMedia)" class="flex-1 px-6 py-3.5 bg-indigo-600 text-white rounded-2xl font-bold shadow-xl shadow-indigo-100 hover:bg-indigo-700 transform active:scale-95 transition-all flex items-center justify-center gap-2">
                    <i class="fa-solid fa-pen-to-square"></i> Fill Now
                </button>
            </div>
        </div>
    </div>

    <!-- Role Restriction Warning Modal -->
    <div x-show="showRoleWarningModal" x-cloak class="fixed inset-0 z-[200] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
        <div @click.outside="showRoleWarningModal = false" class="bg-white w-full max-w-md rounded-[2.5rem] shadow-2xl p-8 border border-slate-100 text-center">
            <div class="w-20 h-20 bg-rose-50 text-rose-500 rounded-full flex items-center justify-center mx-auto mb-6 text-3xl shadow-inner"><i class="fa-solid fa-hand"></i></div>
            <h3 class="text-2xl font-bold text-slate-800 mb-2">Access Restricted!</h3>
            <p class="text-slate-500 text-sm leading-relaxed mb-8 px-4">As a Content Planner, you are not authorized to move tasks to <b>Hold On</b> or <b>Approved</b> stages. Please contact an Admin.</p>
            <button type="button" @click="showRoleWarningModal = false" class="w-full px-6 py-3.5 bg-slate-100 text-slate-600 rounded-2xl font-bold hover:bg-slate-200 transition-all">Understood</button>
        </div>
    </div>

    <!-- Publish Confirmation Modal -->
    <div x-show="showPublishConfirmModal" x-cloak class="fixed inset-0 z-[200] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
        <div @click.outside="showPublishConfirmModal = false" class="bg-white w-full max-w-md rounded-[2.5rem] shadow-2xl p-8 border border-slate-100 text-center">
            <div class="w-20 h-20 bg-emerald-50 text-emerald-500 rounded-full flex items-center justify-center mx-auto mb-6 text-3xl shadow-inner"><i class="fa-solid fa-cloud-arrow-up"></i></div>
            <h3 class="text-2xl font-bold text-slate-800 mb-2">Archive Confirmation</h3>
            <p class="text-slate-500 text-sm leading-relaxed mb-8 px-4">Before publishing, has this content been uploaded to Google Drive as an archive?</p>
            <div class="flex gap-4">
                <button type="button" @click="showPublishConfirmModal = false" class="flex-1 px-6 py-3.5 rounded-2xl text-sm font-bold text-slate-500 hover:bg-slate-50 border border-slate-100 font-bold transition-all active:scale-95">Not yet</button>
                <button type="button" @click="executeMoveTask(taskToPublish, 'published'); showPublishConfirmModal = false" class="flex-[1.5] px-6 py-3.5 bg-emerald-600 text-white rounded-2xl font-bold shadow-xl shadow-emerald-200 hover:bg-emerald-700 transform active:scale-95 transition-all">
                    Yes, Publish
                </button>
            </div>
        </div>
    </div>

    @include('boardplanning.createplanning')
    @include('boardplanning.editplanning')
    @include('boardplanning.lihatplanning')
    
    <!-- INCLUDE TIKTOK POST MODAL HERE -->
    @include('akun.tiktokpostmodal')
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
.bg-indigo-50 {
    background-color: #eef2ff !important;
    border: 2px dashed #6366f1 !important;
}
</style>
@endpush