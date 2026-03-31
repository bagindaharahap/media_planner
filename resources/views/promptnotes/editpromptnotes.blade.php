<!-- Modal Edit Prompt -->
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
        class="bg-white w-full max-w-3xl max-h-[90vh] rounded-[2.5rem] shadow-2xl flex flex-col overflow-hidden border border-slate-200"
        x-transition:enter="transition ease-out duration-300 transform"
        x-transition:enter-start="opacity-0 scale-95 translate-y-8"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
    >
        <div class="px-8 py-6 border-b border-slate-100 flex items-center justify-between bg-amber-50/30">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-amber-500 rounded-xl flex items-center justify-center text-white shadow-lg shadow-amber-200">
                    <i class="fa-solid fa-pen"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-slate-800 tracking-tight">Edit Prompt</h3>
                    <p class="text-xs text-slate-500 font-medium">Update the instructions or tags for this note.</p>
                </div>
            </div>
            <button @click="showEditModal = false" class="w-10 h-10 rounded-full hover:bg-slate-200 flex items-center justify-center text-slate-400 transition-colors">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>

        <div class="flex-1 overflow-y-auto p-8 space-y-6 custom-scrollbar">
            <!-- Title & Category Input -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Prompt Title</label>
                    <input type="text" x-model="form.title" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-semibold text-slate-700 focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition-all">
                </div>
                <div class="space-y-2">
                    <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Category / Tag</label>
                    <input type="text" x-model="form.category" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-semibold text-slate-700 focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition-all">
                </div>
            </div>

            <!-- Custom Rich Text Editor -->
            <div class="space-y-3" x-data="{ 
                format(cmd, val = null) { 
                    document.execCommand(cmd, false, val); 
                    $refs.editEditor.focus();
                    form.description = $refs.editEditor.innerHTML;
                }
            }" 
            x-init="$watch('showEditModal', value => { 
                if(value) { 
                    $refs.editEditor.innerHTML = form.description || ''; 
                } else { 
                    $refs.editEditor.innerHTML = ''; 
                } 
            })">
                <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Description / Prompt Content</label>
                <div class="border border-slate-200 rounded-3xl overflow-hidden shadow-sm bg-white focus-within:ring-2 focus-within:ring-amber-500/20">
                    <div class="bg-slate-50 border-b border-slate-200 px-4 py-2 flex items-center gap-4 text-slate-400">
                        <button type="button" @click="format('bold')" class="hover:text-amber-600 p-1.5 transition-colors"><i class="fa-solid fa-bold"></i></button>
                        <button type="button" @click="format('italic')" class="hover:text-amber-600 p-1.5 transition-colors"><i class="fa-solid fa-italic"></i></button>
                        <button type="button" @click="format('underline')" class="hover:text-amber-600 p-1.5 transition-colors"><i class="fa-solid fa-underline"></i></button>
                        <button type="button" @click="format('insertUnorderedList')" class="hover:text-amber-600 p-1.5 transition-colors"><i class="fa-solid fa-list-ul"></i></button>
                    </div>
                    <!-- Editor Area for Editing -->
                    <div x-ref="editEditor" contenteditable="true" @input="form.description = $el.innerHTML" class="editor-content w-full p-6 min-h-[180px] text-sm text-slate-600 focus:outline-none bg-white" data-placeholder="Write prompt details here..."></div>
                </div>
            </div>
        </div>

        <div class="px-8 py-6 border-t border-slate-100 bg-slate-50/50 flex items-center justify-end gap-4">
            <button @click="showEditModal = false" class="px-8 py-3 rounded-2xl text-sm font-bold text-slate-500 hover:bg-slate-200 transition-all">Cancel</button>
            <button @click="updatePrompt()" class="bg-amber-500 text-white px-10 py-3 rounded-2xl font-bold text-sm shadow-xl shadow-amber-200 hover:bg-amber-600 transition-all active:scale-95">Save Changes</button>
        </div>
    </div>
</div>