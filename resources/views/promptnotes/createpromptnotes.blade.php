<!-- Modal Create Prompt -->
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
        class="bg-white w-full max-w-3xl max-h-[90vh] rounded-[2.5rem] shadow-2xl flex flex-col overflow-hidden border border-slate-200"
        x-transition:enter="transition ease-out duration-300 transform"
        x-transition:enter-start="opacity-0 scale-95 translate-y-8"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
    >
        <div class="px-8 py-6 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center text-white shadow-lg">
                    <i class="fa-solid fa-pen-to-square"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-slate-800 tracking-tight">Create New Prompt</h3>
                    <p class="text-xs text-slate-500 font-medium">Add an instruction template for AI requirements.</p>
                </div>
            </div>
            <button @click="showCreateModal = false" class="w-10 h-10 rounded-full hover:bg-slate-200 flex items-center justify-center text-slate-400 transition-colors">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>

        <div class="flex-1 overflow-y-auto p-8 space-y-6 custom-scrollbar">
            <!-- Title & Category Input -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Prompt Title</label>
                    <input type="text" x-model="form.title" placeholder="e.g., SEO Writing Prompt" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-semibold text-slate-700 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all">
                </div>
                <div class="space-y-2">
                    <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Category / Tag</label>
                    <input type="text" x-model="form.category" placeholder="e.g., Marketing, SEO, Social Media" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-semibold text-slate-700 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all">
                </div>
            </div>

            <!-- Custom Rich Text Editor -->
            <div class="space-y-3" x-data="{ 
                format(cmd, val = null) { 
                    document.execCommand(cmd, false, val); 
                    $refs.createEditor.focus();
                    form.description = $refs.createEditor.innerHTML;
                }
            }" x-init="$watch('showCreateModal', value => { if(!value) { $refs.createEditor.innerHTML = ''; } })">
                <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Description / Prompt Content</label>
                <div class="border border-slate-200 rounded-3xl overflow-hidden shadow-sm bg-white focus-within:ring-2 focus-within:ring-indigo-500/20">
                    <div class="bg-slate-50 border-b border-slate-200 px-4 py-2 flex items-center gap-4 text-slate-400">
                        <button type="button" @click="format('bold')" class="hover:text-indigo-600 p-1.5 transition-colors"><i class="fa-solid fa-bold"></i></button>
                        <button type="button" @click="format('italic')" class="hover:text-indigo-600 p-1.5 transition-colors"><i class="fa-solid fa-italic"></i></button>
                        <button type="button" @click="format('underline')" class="hover:text-indigo-600 p-1.5 transition-colors"><i class="fa-solid fa-underline"></i></button>
                        <button type="button" @click="format('insertUnorderedList')" class="hover:text-indigo-600 p-1.5 transition-colors"><i class="fa-solid fa-list-ul"></i></button>
                    </div>
                    <!-- Editor Area -->
                    <div x-ref="createEditor" contenteditable="true" @input="form.description = $el.innerHTML" class="editor-content w-full p-6 min-h-[180px] text-sm text-slate-600 focus:outline-none bg-white" data-placeholder="Write the prompt details or desired format here..."></div>
                </div>
            </div>
        </div>

        <div class="px-8 py-6 border-t border-slate-100 bg-slate-50/50 flex items-center justify-end gap-4">
            <button @click="showCreateModal = false" class="px-8 py-3 rounded-2xl text-sm font-bold text-slate-500 hover:bg-slate-200 transition-all">Cancel</button>
            <button @click="savePrompt()" class="bg-indigo-600 text-white px-10 py-3 rounded-2xl font-bold text-sm shadow-xl shadow-indigo-200 hover:bg-indigo-700 transition-all active:scale-95">Save Prompt</button>
        </div>
    </div>
</div>