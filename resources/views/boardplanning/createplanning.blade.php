<!-- Modal Buat Planning -->

<div
x-show="showCreateModal"
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
@click.outside="showCreateModal = false"
class="bg-white w-full max-w-5xl max-h-[90vh] rounded-[2.5rem] shadow-2xl flex flex-col overflow-hidden border border-slate-200"
x-transition:enter="transition ease-out duration-300 transform"
x-transition:enter-start="opacity-0 scale-95 translate-y-8"
x-transition:enter-end="opacity-100 scale-100 translate-y-0"
>
<!-- Header -->
<div class="px-8 py-6 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
<div class="flex items-center gap-3">
<div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center text-white shadow-lg shadow-indigo-200">
<i class="fa-solid fa-file-circle-plus"></i>
</div>
<div>
<h3 class="text-xl font-bold text-slate-800 tracking-tight">Buat Perencanaan Baru</h3>
<p class="text-xs text-slate-500 font-medium uppercase tracking-widest">Detail Konten & Manajemen Tim</p>
</div>
</div>
<button @click="showCreateModal = false" class="w-10 h-10 rounded-full hover:bg-slate-200 flex items-center justify-center text-slate-400 transition-colors">
<i class="fa-solid fa-xmark text-xl"></i>
</button>
</div>

    <!-- Body -->
    <div class="flex-1 overflow-y-auto p-8 space-y-8 custom-scrollbar">
        
        <!-- Grid Atas: Status & Judul -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="space-y-2">
                <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Status</label>
                <select x-model="planning.status" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500 transition-all outline-none">
                    <template x-for="status in allStatuses" :key="status.id">
                        <option :value="status.id" x-text="status.name"></option>
                    </template>
                </select>
            </div>
            <div class="md:col-span-3 space-y-2">
                <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Judul Rencana</label>
                <input type="text" x-model="planning.title" placeholder="Masukan judul konten yang menarik..." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-5 py-3 text-lg font-bold text-slate-800 placeholder:text-slate-300 focus:ring-2 focus:ring-indigo-500 outline-none transition-all">
            </div>
        </div>

        <!-- Dropdown Jenis Konten -->
        <div class="space-y-2">
            <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Jenis Konten</label>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <template x-for="type in ['TikTok', 'Reels', 'Feed', 'Story']" :key="type">
                    <button 
                        @click="planning.content_type = type"
                        type="button"
                        class="flex items-center justify-center gap-3 px-4 py-3 rounded-2xl border-2 font-bold text-sm transition-all"
                        :class="planning.content_type === type 
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

        <!-- Deskripsi (Editor Teks Kaya) -->
        <div class="space-y-3" x-data="{ 
            format(cmd, val = null) { 
                document.execCommand(cmd, false, val); 
                $refs.editor.focus();
                this.updateContent();
            },
            updateContent() { 
                planning.description = $refs.editor.innerHTML; 
            }
        }">
            <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Deskripsi Konten</label>
            <div class="border border-slate-200 rounded-3xl overflow-hidden shadow-sm focus-within:ring-2 focus-within:ring-indigo-500/20 transition-all bg-white">
                <!-- Toolbar -->
                <div class="bg-slate-50 border-b border-slate-200 px-4 py-2 flex items-center gap-4 text-slate-400">
                    <div class="flex items-center gap-3 pr-4 border-r border-slate-200">
                        <!-- onmousedown preventDefault penting agar seleksi teks tidak hilang saat klik tombol -->
                        <button type="button" onmousedown="event.preventDefault()" @click="format('bold')" class="hover:text-indigo-600 p-1.5 transition-colors" title="Tebal"><i class="fa-solid fa-bold"></i></button>
                        <button type="button" onmousedown="event.preventDefault()" @click="format('italic')" class="hover:text-indigo-600 p-1.5 transition-colors" title="Miring"><i class="fa-solid fa-italic"></i></button>
                        <button type="button" onmousedown="event.preventDefault()" @click="format('underline')" class="hover:text-indigo-600 p-1.5 transition-colors" title="Garis Bawah"><i class="fa-solid fa-underline"></i></button>
                    </div>
                    <div class="flex items-center gap-3 pr-4 border-r border-slate-200">
                        <button type="button" onmousedown="event.preventDefault()" @click="format('insertUnorderedList')" class="hover:text-indigo-600 p-1.5 transition-colors" title="Daftar Simbol"><i class="fa-solid fa-list-ul"></i></button>
                        <button type="button" onmousedown="event.preventDefault()" @click="format('insertOrderedList')" class="hover:text-indigo-600 p-1.5 transition-colors" title="Daftar Angka"><i class="fa-solid fa-list-ol"></i></button>
                    </div>
                    <div class="flex items-center gap-3">
                        <button type="button" onmousedown="event.preventDefault()" @click="let url = prompt('Masukkan URL Link:'); if(url) format('createLink', url)" class="hover:text-indigo-600 p-1.5 transition-colors" title="Tautan Link"><i class="fa-solid fa-link"></i></button>
                        <button type="button" onmousedown="event.preventDefault()" @click="format('removeFormat')" class="hover:text-red-500 p-1.5 transition-colors" title="Hapus Format"><i class="fa-solid fa-eraser"></i></button>
                    </div>
                </div>
                <!-- Editor Area -->
                <div 
                    x-ref="editor"
                    contenteditable="true" 
                    @input="updateContent()"
                    @blur="updateContent()"
                    class="editor-content w-full p-6 min-h-[200px] text-sm text-slate-600 focus:outline-none bg-white"
                    data-placeholder="Tuliskan detail konten, script, atau poin-poin utama di sini..."
                ></div>
            </div>

            <!-- CSS Internal untuk Memperbaiki Tailwind Reset -->
            <style>
                .editor-content:empty:before {
                    content: attr(data-placeholder);
                    color: #cbd5e1;
                    pointer-events: none;
                    display: block; 
                }
                /* Memaksa gaya teks muncul meskipun di-reset oleh Tailwind */
                .editor-content b, .editor-content strong { font-weight: bold !important; }
                .editor-content i, .editor-content em { font-style: italic !important; }
                .editor-content u { text-decoration: underline !important; }
                .editor-content ul { list-style-type: disc !important; padding-left: 1.5rem !important; margin: 0.5rem 0 !important; }
                .editor-content ol { list-style-type: decimal !important; padding-left: 1.5rem !important; margin: 0.5rem 0 !important; }
                .editor-content li { display: list-item !important; }
                .editor-content a { color: #4f46e5 !important; text-decoration: underline !important; }
            </style>
        </div>

        <!-- Tanggal & Prioritas -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 p-6 bg-slate-50 rounded-3xl border border-slate-100">
            <div class="space-y-2">
                <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Tanggal Mulai</label>
                <input type="date" x-model="planning.start_date" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm font-bold text-slate-700">
            </div>
            <div class="space-y-2">
                <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Deadline (Due Date)</label>
                <input type="date" x-model="planning.due_date" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm font-bold text-red-500">
            </div>
            <div class="space-y-2">
                <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Skala Prioritas</label>
                <select x-model="planning.priority" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm font-bold text-slate-700 outline-none">
                    <option value="urgent">Urgent (Mendesak)</option>
                    <option value="high">High (Tinggi)</option>
                    <option value="normal" selected>Normal</option>
                    <option value="low">Low (Rendah)</option>
                </select>
            </div>
        </div>

        <!-- Manajemen Tim -->
        <div class="space-y-4">
            <div class="flex items-center justify-between px-1">
                <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest">Penanggung Jawab & Jobdesk</label>
                <button @click="addAssigned('create')" class="text-indigo-600 text-xs font-black uppercase tracking-widest hover:text-indigo-700 transition-all flex items-center gap-2">
                    <i class="fa-solid fa-user-plus"></i> Tambah Penjab
                </button>
            </div>
            
            <div class="space-y-6">
                <template x-for="(assign, index) in planning.assigned" :key="index">
                    <div class="p-6 bg-white border border-slate-200 rounded-3xl shadow-sm relative group/item">
                        <button @click="removeAssigned('create', index)" x-show="planning.assigned.length > 1" class="absolute -top-2 -right-2 w-6 h-6 bg-red-500 text-white rounded-full text-[10px] flex items-center justify-center shadow-lg opacity-0 group-hover/item:opacity-100 transition-all z-10">
                            <i class="fa-solid fa-times"></i>
                        </button>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="space-y-2">
                                <label class="text-[10px] font-bold text-slate-400 uppercase">Nama Penjab</label>
                                <select x-model="assign.name" class="w-full bg-slate-50 border border-slate-100 rounded-xl px-3 py-2 text-sm font-bold text-slate-700">
                                    <option value="">Pilih Anggota...</option>
                                    <template x-for="name in userOptions" :key="name">
                                        <option :value="name" x-text="name"></option>
                                    </template>
                                </select>
                            </div>

                            <div class="space-y-2" x-data="{ open: false }">
                                <label class="text-[10px] font-bold text-slate-400 uppercase">Jobdesk</label>
                                <div class="relative">
                                    <button @click="open = !open" class="w-full bg-slate-50 border border-slate-100 rounded-xl px-3 py-2 text-left text-sm font-bold text-slate-600 flex justify-between items-center">
                                        <span x-text="assign.jobdesks.length ? assign.jobdesks.length + ' Dipilih' : 'Pilih Jobdesk...'"></span>
                                        <i class="fa-solid fa-chevron-down text-[10px]"></i>
                                    </button>
                                    <div x-show="open" @click.outside="open = false" x-cloak class="absolute z-20 top-full mt-2 w-full bg-white border border-slate-200 rounded-2xl shadow-xl py-2 max-h-48 overflow-y-auto custom-scrollbar">
                                        <template x-for="job in jobdeskOptions" :key="job">
                                            <label class="flex items-center gap-3 px-4 py-2 hover:bg-slate-50 cursor-pointer">
                                                <input type="checkbox" :value="job" x-model="assign.jobdesks" class="w-4 h-4 rounded text-indigo-600">
                                                <span class="text-xs font-bold text-slate-600" x-text="job"></span>
                                            </label>
                                        </template>
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-2" x-data="{ open: false }">
                                <label class="text-[10px] font-bold text-slate-400 uppercase">Tools</label>
                                <div class="relative">
                                    <button @click="open = !open" class="w-full bg-slate-50 border border-slate-100 rounded-xl px-3 py-2 text-left text-sm font-bold text-slate-600 flex justify-between items-center">
                                        <span x-text="assign.tools.length ? assign.tools.length + ' Dipilih' : 'Pilih Tools...'"></span>
                                        <i class="fa-solid fa-chevron-down text-[10px]"></i>
                                    </button>
                                    <div x-show="open" @click.outside="open = false" x-cloak class="absolute z-20 top-full mt-2 w-full bg-white border border-slate-200 rounded-2xl shadow-xl py-2 max-h-48 overflow-y-auto custom-scrollbar">
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
                    </div>
                </template>
            </div>
        </div>

        <!-- Referensi -->
        <div class="space-y-4">
            <div class="flex items-center justify-between px-1">
                <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest">Link Referensi</label>
                <button @click="addReference('create')" class="text-indigo-600 text-[10px] font-black uppercase tracking-widest hover:text-indigo-700 transition-all">
                    + Tambah Link
                </button>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <template x-for="(ref, rIndex) in planning.references" :key="rIndex">
                    <div class="flex gap-2 group/ref">
                        <div class="flex-1 bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 flex items-center gap-3 transition-all focus-within:ring-2 focus-within:ring-indigo-100">
                            <i class="fa-solid fa-link text-slate-300 text-xs"></i>
                            <input type="text" x-model="planning.references[rIndex]" placeholder="https://..." class="bg-transparent w-full text-sm font-bold text-slate-600 outline-none">
                        </div>
                        <button @click="removeReference('create', rIndex)" x-show="planning.references.length > 1" class="w-10 h-10 rounded-xl bg-red-50 text-red-500 hover:bg-red-100 flex items-center justify-center opacity-0 group-hover/ref:opacity-100 transition-all">
                            <i class="fa-solid fa-trash text-xs"></i>
                        </button>
                    </div>
                </template>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="px-8 py-6 border-t border-slate-100 bg-slate-50/50 flex items-center justify-end gap-4">
        <button @click="showCreateModal = false" class="px-8 py-3 rounded-2xl text-sm font-bold text-slate-500 hover:bg-slate-200 transition-all">
            Cancel
        </button>
        <button @click="console.log(planning); showCreateModal = false;" class="bg-indigo-600 text-white px-10 py-3 rounded-2xl font-bold text-sm shadow-xl shadow-indigo-200 hover:bg-indigo-700 transform active:scale-95 transition-all">
            Create Planning
        </button>
    </div>
</div>


</div>