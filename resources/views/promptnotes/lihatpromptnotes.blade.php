<!-- Modal View Prompt -->
<div
    x-show="showViewModal"
    x-cloak
    class="fixed inset-0 z-[150] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200"
>
    <div
        @click.outside="showViewModal = false"
        class="bg-white w-full max-w-2xl max-h-[85vh] rounded-[2.5rem] shadow-2xl flex flex-col overflow-hidden border border-slate-200 relative"
        x-transition:enter="transition ease-out duration-300 transform"
        x-transition:enter-start="opacity-0 scale-95 translate-y-8"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
    >
        <!-- Close Button in Corner -->
        <button @click="showViewModal = false" class="absolute top-6 right-6 w-10 h-10 rounded-full bg-slate-100/50 hover:bg-slate-200 flex items-center justify-center text-slate-400 transition-colors z-10">
            <i class="fa-solid fa-xmark text-xl"></i>
        </button>

        <div class="flex-1 overflow-y-auto p-10 custom-scrollbar">
            <!-- Content Header -->
            <div class="mb-8 border-b border-slate-100 pb-6">
                <span class="px-3 py-1 bg-indigo-50 text-indigo-600 border border-indigo-100 font-black text-[10px] rounded-lg uppercase tracking-wider shadow-sm mb-4 inline-block" x-text="form.category"></span>
                <h2 class="text-3xl font-black text-slate-800 leading-tight tracking-tight mt-1" x-text="form.title"></h2>
            </div>
            
            <!-- Description Content (Renders HTML from Editor) -->
            <div class="bg-slate-50 border border-slate-200 rounded-3xl p-8 relative">
                <!-- Decorative quote icon -->
                <i class="fa-solid fa-quote-left absolute -top-4 -left-3 text-4xl text-slate-200"></i>
                
                <div class="view-editor-content text-slate-700 text-sm leading-relaxed whitespace-pre-line" x-html="form.description">
                    <!-- HTML is rendered here via Alpine.js -->
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="px-8 py-5 border-t border-slate-100 bg-slate-50 flex items-center justify-between">
            <p class="text-xs font-semibold text-slate-400">Note Preview Mode</p>
            <button @click="showViewModal = false" class="px-6 py-2.5 bg-slate-200 text-slate-600 hover:bg-slate-300 rounded-xl font-bold text-sm transition-all">
                Close
            </button>
        </div>
    </div>
</div>