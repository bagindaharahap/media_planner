<!-- Modal Lihat Planning -->

<div
x-show="showLihatModal"
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
        
        <!-- Quick Info Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-slate-50 p-4 rounded-3xl border border-slate-100">
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2">Status</p>
                <div class="flex items-center gap-2">
                    <div class="w-2 h-2 rounded-full animate-pulse" :class="{
                        'bg-slate-400': viewingPlanning.status === 'draft',
                        'bg-indigo-600': viewingPlanning.status === 'progress',
                        'bg-rose-500': viewingPlanning.status === 'review',
                        'bg-amber-500': viewingPlanning.status === 'revisi',
                        'bg-blue-500': viewingPlanning.status === 'approved',
                        'bg-emerald-500': viewingPlanning.status === 'published'
                    }"></div>
                    <span class="text-sm font-bold text-slate-700 capitalize" x-text="allStatuses.find(s => s.id === viewingPlanning.status)?.name || viewingPlanning.status"></span>
                </div>
            </div>
            <div class="bg-slate-50 p-4 rounded-3xl border border-slate-100">
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2">Prioritas</p>
                <span 
                    class="px-3 py-1 text-[10px] font-black rounded-xl uppercase tracking-tighter"
                    :class="{
                        'bg-red-100 text-red-600': viewingPlanning.priority === 'urgent',
                        'bg-yellow-100 text-yellow-700': viewingPlanning.priority === 'high',
                        'bg-blue-100 text-blue-600': viewingPlanning.priority === 'normal',
                        'bg-slate-100 text-slate-500': viewingPlanning.priority === 'low'
                    }"
                    x-text="viewingPlanning.priority"
                ></span>
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
                <div class="prose prose-slate prose-sm max-w-none text-slate-600 leading-relaxed view-editor-content" x-html="viewingPlanning.description || '<p class=\'italic text-slate-400\'>Tidak ada deskripsi.</p>'">
                </div>
            </div>
        </div>

        <!-- Tim Pelaksana -->
        <div class="space-y-4">
            <div class="flex items-center gap-2 px-1">
                <i class="fa-solid fa-users text-indigo-500 text-xs"></i>
                <h4 class="text-[11px] font-black text-slate-400 uppercase tracking-widest">Tim Penanggung Jawab</h4>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <template x-for="(assign, index) in viewingPlanning.assigned" :key="index">
                    <div class="flex items-center gap-4 p-5 bg-slate-50 border border-slate-100 rounded-3xl">
                        <div class="w-12 h-12 bg-indigo-600 rounded-2xl flex items-center justify-center text-white font-black shadow-lg shadow-indigo-100" x-text="assign.name ? assign.name.substring(0, 2).toUpperCase() : '?'"></div>
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

        <!-- Referensi -->
        <div class="space-y-4">
            <div class="flex items-center gap-2 px-1">
                <i class="fa-solid fa-link text-indigo-500 text-xs"></i>
                <h4 class="text-[11px] font-black text-slate-400 uppercase tracking-widest">Referensi & Moodboard</h4>
            </div>
            <div class="bg-white border border-slate-100 rounded-3xl p-6 space-y-3 shadow-sm">
                <template x-for="(ref, rIndex) in viewingPlanning.references" :key="rIndex">
                    <a :href="ref" target="_blank" class="flex items-center justify-between p-3 bg-slate-50 rounded-2xl group hover:bg-indigo-50 transition-all border border-transparent hover:border-indigo-100" x-show="ref">
                        <div class="flex items-center gap-3 overflow-hidden">
                            <i class="fa-solid fa-link text-slate-300 group-hover:text-indigo-400"></i>
                            <span class="text-xs font-bold text-slate-600 truncate" x-text="ref"></span>
                        </div>
                        <i class="fa-solid fa-arrow-up-right-from-square text-[10px] text-slate-300 group-hover:text-indigo-400"></i>
                    </a>
                </template>
                <template x-if="!viewingPlanning.references || viewingPlanning.references.filter(r => r).length === 0">
                    <p class="text-[10px] text-slate-400 italic text-center py-4">Tidak ada referensi link.</p>
                </template>
            </div>
        </div>

        <!-- Aset Media & Catatan Revisi (Bagian Bawah) -->
        <div class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Kolom Kiri: Aset Media -->
                <div class="space-y-4">
                    <div class="flex items-center gap-2 px-1">
                        <i class="fa-solid fa-photo-film text-indigo-500 text-xs"></i>
                        <h4 class="text-[11px] font-black text-slate-400 uppercase tracking-widest">Aset Media Konten</h4>
                    </div>
                    <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm min-h-[160px] flex flex-col justify-center">
                        <template x-if="viewingPlanning.media_link && ['review', 'revisi', 'hold_on', 'approved', 'published'].includes(viewingPlanning.status)">
                            <div class="space-y-4">
                                <a :href="viewingPlanning.media_link" target="_blank" class="w-full flex items-center justify-center gap-3 py-4 bg-indigo-600 text-white rounded-2xl font-bold text-sm shadow-xl shadow-indigo-100 hover:bg-indigo-700 transition-all">
                                    <i class="fa-solid fa-download"></i>
                                    Download Aset Media
                                </a>
                                <div class="p-4 bg-slate-50 border border-dashed border-slate-200 rounded-2xl flex flex-col items-center text-center">
                                    <i class="fa-solid fa-cloud-check text-2xl text-slate-300 mb-2"></i>
                                    <p class="text-[10px] font-bold text-slate-400 italic">Tautan aset media siap digunakan.</p>
                                </div>
                            </div>
                        </template>
                        
                        <template x-if="viewingPlanning.media_link && !['review', 'revisi', 'hold_on', 'approved', 'published'].includes(viewingPlanning.status)">
                            <div class="py-8 flex flex-col items-center justify-center text-center border-2 border-dashed border-slate-100 rounded-3xl bg-slate-50/50">
                                <div class="w-12 h-12 bg-slate-200 rounded-full flex items-center justify-center text-slate-400 mb-4">
                                    <i class="fa-solid fa-lock text-lg"></i>
                                </div>
                                <h5 class="text-xs font-bold text-slate-600">Unduhan Belum Tersedia</h5>
                                <p class="text-[10px] text-slate-400 mt-2 px-6 leading-relaxed">Aset media hanya dapat diunduh setelah status beralih ke tahap <span class="text-indigo-500 font-black">Review</span>.</p>
                            </div>
                        </template>

                        <template x-if="!viewingPlanning.media_link">
                            <div class="py-8 flex flex-col items-center justify-center text-center border-2 border-dashed border-slate-50 rounded-3xl">
                                <i class="fa-solid fa-circle-info text-slate-200 text-3xl mb-3"></i>
                                <p class="text-xs font-bold text-slate-400">Belum ada aset media yang diunggah.</p>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Kolom Kanan: Catatan Revisi (Hanya tampil di Review ke atas) -->
                <div class="space-y-4" x-show="!['draft', 'progress'].includes(viewingPlanning.status)" x-transition>
                    <div class="flex items-center gap-2 px-1">
                        <i class="fa-solid fa-clipboard-check text-rose-500 text-xs"></i>
                        <h4 class="text-[11px] font-black text-slate-400 uppercase tracking-widest">Catatan Revisi / Feedback</h4>
                    </div>
                    <div class="bg-rose-50/30 border border-rose-100 rounded-[2rem] p-8 shadow-sm relative min-h-[160px]">
                        <!-- Dekorasi Ikon Feedback -->
                        <i class="fa-solid fa-comment-dots absolute top-6 right-8 text-rose-200 text-3xl opacity-20"></i>
                        
                        <div class="relative z-10">
                            <p class="text-slate-600 leading-relaxed text-sm whitespace-pre-wrap italic" x-text="viewingPlanning.revision_note || 'Belum ada catatan revisi untuk konten ini.'"></p>
                        </div>

                        <template x-if="viewingPlanning.status === 'revisi'">
                            <div class="mt-6 flex items-center gap-2 px-3 py-2 bg-rose-100/50 rounded-xl border border-rose-200 w-fit">
                                <i class="fa-solid fa-circle-exclamation text-rose-500 text-[10px]"></i>
                                <span class="text-[10px] font-black text-rose-600 uppercase tracking-tighter">Sedang Tahap Perbaikan</span>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="px-8 py-6 border-t border-slate-100 bg-slate-50/50 flex items-center justify-between">
        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Content Planner Content Management System</p>
        <button @click="showLihatModal = false" class="px-8 py-3 bg-white border border-slate-200 rounded-2xl text-sm font-bold text-slate-600 hover:bg-slate-50 transition-all shadow-sm">
            Tutup Detail
        </button>
    </div>
</div>


</div>

<style>
.view-editor-content b, .view-editor-content strong { font-weight: bold !important; }
.view-editor-content i, .view-editor-content em { font-style: italic !important; }
.view-editor-content u { text-decoration: underline !important; }
.view-editor-content ul { list-style-type: disc !important; padding-left: 1.5rem !important; }
.view-editor-content ol { list-style-type: decimal !important; padding-left: 1.5rem !important; }
</style>