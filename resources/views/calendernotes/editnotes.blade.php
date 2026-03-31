<!-- Modal Edit Note (Partial Component) -->
<div
    x-show="showEditNoteModal"
    x-cloak
    class="fixed inset-0 z-[160] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
>
    <div
        @click.outside="showEditNoteModal = false"
        class="bg-white w-full max-w-xl rounded-[2.5rem] shadow-2xl flex flex-col overflow-hidden border border-slate-200"
        x-transition:enter="transition ease-out duration-300 transform"
        x-transition:enter-start="opacity-0 scale-95 translate-y-8"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
    >
        <!-- Header -->
        <div class="px-8 py-6 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center text-white shadow-lg transition-colors" :class="editingNote.color || 'bg-indigo-500'">
                    <i class="fa-solid fa-pen-to-square"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-slate-800 tracking-tight">Update Note</h3>
                    <p class="text-xs text-slate-500 font-medium uppercase tracking-widest">Edit your ideas or memos</p>
                </div>
            </div>
            <button @click="showEditNoteModal = false" class="w-10 h-10 rounded-full hover:bg-slate-200 flex items-center justify-center text-slate-400 transition-colors">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>

        <!-- Edit Form -->
        <div class="p-8 space-y-6">
            <div class="space-y-2">
                <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Note Title</label>
                <input type="text" x-model="editingNote.title" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-4 text-sm font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500 outline-none transition-all">
            </div>

            <div class="space-y-2">
                <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Note Content</label>
                <textarea x-model="editingNote.content" rows="4" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-4 text-sm font-medium text-slate-700 focus:ring-2 focus:ring-indigo-500 outline-none transition-all resize-none"></textarea>
            </div>

            <div class="space-y-2">
                <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1 block text-center mb-2">Change Category Color</label>
                <div class="flex justify-center gap-3">
                    <template x-for="color in ['bg-indigo-500', 'bg-emerald-500', 'bg-amber-500', 'bg-rose-500', 'bg-purple-500']" :key="color">
                        <button 
                            type="button"
                            @click="editingNote.color = color" 
                            class="w-8 h-8 rounded-full border-4 transition-all" 
                            :class="[color, editingNote.color === color ? 'border-slate-200 scale-110 shadow-lg' : 'border-transparent opacity-60 hover:opacity-100 hover:scale-110']"
                        ></button>
                    </template>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="pt-6 border-t border-slate-100 flex gap-3 px-8 pb-6">
            <button type="button" @click="showEditNoteModal = false; showLihatNoteModal = true" class="flex-1 py-3 text-sm font-bold text-slate-500 hover:bg-slate-50 rounded-2xl transition-all border border-slate-100">Cancel</button>
            <button type="button" @click="updateNote()" class="flex-[2] bg-indigo-600 text-white py-3 rounded-2xl font-bold text-sm shadow-xl shadow-indigo-100 hover:bg-indigo-700 transform active:scale-95 transition-all">Save Changes</button>
        </div>
    </div>
</div>