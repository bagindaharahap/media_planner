<!-- Modal Edit Planning -->

<div
x-show="showEditModal"
x-cloak
class="fixed inset-0 z-[150] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
x-transition:enter="transition ease-out duration-300"
x-transition:enter-start="opacity-0"
x-transition:enter-end="opacity-100"
x-transition:leave="transition ease-in duration-200"
x-transition:leave-start="opacity-100"
x-transition:leave-end="opacity-0"
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
        
        <!-- Grid Atas: Status & Judul -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="space-y-2">
                <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Status</label>
                <select x-model="editingPlanning.status" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500 transition-all outline-none">
                    <template x-for="status in allStatuses" :key="status.id">
                        <option :value="status.id" x-text="status.name" :selected="status.id === editingPlanning.status"></option>
                    </template>
                </select>
            </div>
            <div class="md:col-span-3 space-y-2">
                <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Judul Rencana</label>
                <input type="text" x-model="editingPlanning.title" placeholder="Masukan judul rencana..." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-5 py-3 text-lg font-bold text-slate-800 focus:ring-2 focus:ring-indigo-500 outline-none transition-all">
            </div>
        </div>

        <!-- Dropdown Jenis Konten -->
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
                        <i class="fa-brands" :class="{
                            'fa-tiktok': type === 'TikTok',
                            'fa-instagram': type !== 'TikTok'
                        }"></i>
                        <span x-text="type"></span>
                    </button>
                </template>
            </div>
        </div>

        <!-- Deskripsi (Rich Text Editor) -->
        <div class="space-y-3" x-data="{ 
            format(cmd, val = null) { 
                document.execCommand(cmd, false, val); 
                $refs.editEditor.focus();
                this.updateContent();
            },
            updateContent() { 
                editingPlanning.description = $refs.editEditor.innerHTML; 
            }
        }" x-init="$watch('showEditModal', value => { if(value) { setTimeout(() => { $refs.editEditor.innerHTML = editingPlanning.description || ''; }, 100); } })">
            <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Deskripsi Konten</label>
            <div class="border border-slate-200 rounded-3xl overflow-hidden shadow-sm focus-within:ring-2 focus-within:ring-indigo-500/20 transition-all bg-white">
                <div class="bg-slate-50 border-b border-slate-200 px-4 py-2 flex items-center gap-4 text-slate-400">
                    <div class="flex items-center gap-3 pr-4 border-r border-slate-200">
                        <button type="button" onmousedown="event.preventDefault()" @click="format('bold')" class="hover:text-indigo-600 p-1.5 transition-colors"><i class="fa-solid fa-bold"></i></button>
                        <button type="button" onmousedown="event.preventDefault()" @click="format('italic')" class="hover:text-indigo-600 p-1.5 transition-colors"><i class="fa-solid fa-italic"></i></button>
                        <button type="button" onmousedown="event.preventDefault()" @click="format('underline')" class="hover:text-indigo-600 p-1.5 transition-colors"><i class="fa-solid fa-underline"></i></button>
                    </div>
                    <div class="flex items-center gap-3">
                        <button type="button" onmousedown="event.preventDefault()" @click="format('insertUnorderedList')" class="hover:text-indigo-600 p-1.5 transition-colors"><i class="fa-solid fa-list-ul"></i></button>
                        <button type="button" onmousedown="event.preventDefault()" @click="let url = prompt('URL:'); if(url) format('createLink', url)" class="hover:text-indigo-600 p-1.5 transition-colors"><i class="fa-solid fa-link"></i></button>
                    </div>
                </div>
                <div 
                    x-ref="editEditor"
                    contenteditable="true" 
                    @input="updateContent()"
                    class="editor-content w-full p-6 min-h-[180px] text-sm text-slate-600 focus:outline-none bg-white"
                    data-placeholder="Tuliskan detail konten di sini..."
                ></div>
            </div>
        </div>

        <!-- Tanggal & Prioritas -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 p-6 bg-slate-50 rounded-3xl border border-slate-100">
            <div class="space-y-2">
                <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Tanggal Mulai</label>
                <input type="date" x-model="editingPlanning.start_date" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm font-bold text-slate-700">
            </div>
            <div class="space-y-2">
                <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Deadline (Due Date)</label>
                <input type="date" x-model="editingPlanning.due_date" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm font-bold text-red-500">
            </div>
            <div class="space-y-2">
                <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Prioritas</label>
                <select x-model="editingPlanning.priority" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm font-bold text-slate-700 outline-none">
                    <option value="urgent">Urgent</option>
                    <option value="high">High</option>
                    <option value="normal">Normal</option>
                    <option value="low">Low</option>
                </select>
            </div>
        </div>

        <!-- Tim & Jobdesk -->
        <div class="space-y-4">
            <div class="flex items-center justify-between px-1">
                <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest">Tim & Jobdesk</label>
                <button @click="addAssigned('edit')" class="text-indigo-600 text-[10px] font-black uppercase tracking-widest flex items-center gap-2">
                    <i class="fa-solid fa-user-plus"></i> Tambah Anggota
                </button>
            </div>
            <div class="space-y-4">
                <template x-for="(assign, index) in editingPlanning.assigned" :key="index">
                    <div class="p-6 bg-white border border-slate-200 rounded-3xl relative group/item hover:border-indigo-200 transition-all">
                        <button @click="removeAssigned('edit', index)" x-show="editingPlanning.assigned.length > 1" class="absolute -top-2 -right-2 w-6 h-6 bg-red-500 text-white rounded-full text-[10px] flex items-center justify-center shadow-lg opacity-0 group-hover/item:opacity-100 transition-all">
                            <i class="fa-solid fa-times"></i>
                        </button>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="space-y-2">
                                <label class="text-[10px] font-bold text-slate-400 uppercase">Nama</label>
                                <select x-model="assign.name" class="w-full bg-slate-50 border border-slate-100 rounded-xl px-3 py-2 text-sm font-bold text-slate-700">
                                    <option value="">Pilih...</option>
                                    <template x-for="name in userOptions" :key="name">
                                        <option :value="name" x-text="name"></option>
                                    </template>
                                </select>
                            </div>
                            <div class="space-y-2" x-data="{ open: false }">
                                <label class="text-[10px] font-bold text-slate-400 uppercase">Jobdesk</label>
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
                                <label class="text-[10px] font-bold text-slate-400 uppercase">Tools</label>
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

        <!-- Referensi -->
        <div class="space-y-4">
            <div class="flex items-center justify-between px-1">
                <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest">Referensi / Link</label>
                <button @click="addReference('edit')" class="text-indigo-600 text-[10px] font-black uppercase tracking-widest hover:text-indigo-700 transition-all">+ Link</button>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <template x-for="(ref, rIndex) in editingPlanning.references" :key="rIndex">
                    <div class="flex gap-2 group/ref">
                        <div class="flex-1 bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 flex items-center gap-3">
                            <i class="fa-solid fa-link text-slate-300 text-xs"></i>
                            <input type="text" x-model="editingPlanning.references[rIndex]" class="bg-transparent w-full text-sm font-bold text-slate-600 outline-none">
                        </div>
                        <button @click="removeReference('edit', rIndex)" x-show="editingPlanning.references.length > 1" class="w-10 h-10 bg-red-50 text-red-500 rounded-xl flex items-center justify-center opacity-0 group-hover/ref:opacity-100 transition-all"><i class="fa-solid fa-trash text-xs"></i></button>
                    </div>
                </template>
            </div>
        </div>

        <!-- Aset Media (Tautan & Drop File) -->
        <div class="space-y-4">
            <div class="flex items-center justify-between ml-1">
                <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest">Aset Media (Hasil Konten)</label>
                <!-- Label Kunci jika di Backlog -->
                <div x-show="editingPlanning.status === 'backlog'" class="flex items-center gap-2 px-2 py-1 bg-amber-50 rounded-lg border border-amber-100">
                    <i class="fa-solid fa-lock text-[9px] text-amber-500"></i>
                    <span class="text-[9px] font-bold text-amber-600 uppercase tracking-tighter">Buka di In Progress</span>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 relative">
                <!-- Tautan Media -->
                <div class="space-y-3 transition-all" :class="editingPlanning.status === 'backlog' ? 'opacity-40 grayscale' : ''">
                    <div class="flex items-center gap-2 px-1">
                        <i class="fa-solid fa-cloud-arrow-up text-indigo-500 text-xs"></i>
                        <span class="text-[10px] font-bold text-slate-500 uppercase">Link Konten (G-Drive / Dropbox)</span>
                    </div>
                    <div 
                        class="bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 flex items-center gap-3 transition-all"
                        :class="editingPlanning.status !== 'backlog' ? 'focus-within:ring-2 focus-within:ring-indigo-100 focus-within:bg-white' : 'cursor-not-allowed bg-slate-100'"
                    >
                        <i class="fa-solid fa-link text-slate-300"></i>
                        <input 
                            type="text" 
                            x-model="editingPlanning.media_link" 
                            :disabled="editingPlanning.status === 'backlog'"
                            placeholder="https://drive.google.com/..." 
                            class="bg-transparent w-full text-sm font-bold text-slate-600 outline-none"
                            :class="editingPlanning.status === 'backlog' ? 'cursor-not-allowed' : ''"
                        >
                    </div>
                </div>

                <!-- Upload Placeholder -->
                <div class="space-y-3 transition-all" :class="editingPlanning.status === 'backlog' ? 'opacity-40 grayscale' : ''">
                    <div class="flex items-center gap-2 px-1">
                        <i class="fa-solid fa-file-video text-indigo-500 text-xs"></i>
                        <span class="text-[10px] font-bold text-slate-500 uppercase">Upload Preview (Foto/Video)</span>
                    </div>
                    <div 
                        class="border-2 border-dashed rounded-2xl p-4 flex flex-col items-center justify-center transition-all group relative"
                        :class="editingPlanning.status === 'backlog' 
                            ? 'border-slate-200 bg-slate-100 cursor-not-allowed' 
                            : 'border-slate-200 bg-slate-50 hover:bg-white hover:border-indigo-300 cursor-pointer'"
                        @click="editingPlanning.status !== 'backlog' ? $refs.fileInputEdit.click() : null"
                    >
                        <input type="file" x-ref="fileInputEdit" class="hidden" :disabled="editingPlanning.status === 'backlog'">
                        <i class="fa-solid fa-photo-film text-slate-300 mb-2 transition-colors" :class="editingPlanning.status !== 'backlog' ? 'group-hover:text-indigo-400' : ''"></i>
                        <p class="text-[10px] font-bold text-slate-400 transition-colors" :class="editingPlanning.status !== 'backlog' ? 'group-hover:text-indigo-600' : ''">
                            <span x-text="editingPlanning.status === 'backlog' ? 'Terkunci (Masih Backlog)' : 'Klik untuk upload file'"></span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="px-8 py-6 border-t border-slate-100 bg-slate-50/50 flex items-center justify-end gap-4">
        <button @click="showEditModal = false" class="px-8 py-3 rounded-2xl text-sm font-bold text-slate-500 hover:bg-slate-200 transition-all">Batal</button>
        <button @click="console.log('Update:', editingPlanning); showEditModal = false;" class="bg-indigo-600 text-white px-10 py-3 rounded-2xl font-bold text-sm shadow-xl shadow-indigo-200 hover:bg-indigo-700 transform active:scale-95 transition-all">Simpan Perubahan</button>
    </div>
</div>
<style>
    .editor-content b, .editor-content strong { font-weight: bold !important; }
    .editor-content i, .editor-content em { font-style: italic !important; }
    .editor-content u { text-decoration: underline !important; }
    .editor-content ul { list-style-type: disc !important; padding-left: 1.5rem !important; }
    .editor-content:empty:before { content: attr(data-placeholder); color: #cbd5e1; }
</style>


</div>