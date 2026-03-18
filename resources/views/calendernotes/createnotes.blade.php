<!-- Modal Pilihan: Planning atau Notes (Komponen Partial) -->


<div
    x-show="showCreateChoiceModal"
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
        @click.outside="showCreateChoiceModal = false; isWritingNote = false"
        class="bg-white w-full max-w-2xl rounded-[2.5rem] shadow-2xl flex flex-col overflow-hidden border border-slate-200"
        x-transition:enter="transition ease-out duration-300 transform"
        x-transition:enter-start="opacity-0 scale-95 translate-y-8"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
    >
        <!-- Header -->
        <div class="px-8 py-6 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center text-white shadow-lg transition-colors" :class="isWritingNote ? 'bg-emerald-600' : 'bg-indigo-600'">
                    <i class="fa-solid fa-plus" x-show="!isWritingNote"></i>
                    <i class="fa-solid fa-note-sticky" x-show="isWritingNote" x-cloak></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-slate-800 tracking-tight" x-text="!isWritingNote ? 'Tambah Aktivitas' : 'Buat Catatan Baru'"></h3>
                    <p class="text-xs text-slate-500 font-medium uppercase tracking-widest">
                        <span x-show="!isWritingNote">Pilih jenis konten untuk <span class="text-indigo-600 font-black" x-text="selectedDate"></span></span>
                        <span x-show="isWritingNote" x-cloak>Tulis ide atau memo untuk <span class="text-emerald-600 font-black" x-text="selectedDate"></span></span>
                    </p>
                </div>
            </div>
            <button @click="showCreateChoiceModal = false; isWritingNote = false" class="w-10 h-10 rounded-full hover:bg-slate-200 flex items-center justify-center text-slate-400 transition-colors">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>

        <!-- Body: Pilihan (Muncul Saat isWritingNote == false) -->
        <div class="p-8 space-y-4" x-show="!isWritingNote">
            <p class="text-center text-slate-400 text-sm font-medium mb-4">Apa yang ingin Anda buat hari ini?</p>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Opsi 1: Planning -->
                <a 
                    :href="'{{ route('board.index') }}?create=true&date=' + selectedDate"
                    @click="showCreateChoiceModal = false"
                    class="block group p-6 bg-white border-2 border-slate-100 rounded-[2rem] text-left hover:border-indigo-600 hover:shadow-xl hover:shadow-indigo-50 transition-all duration-300"
                >
                    <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center mb-4 group-hover:bg-indigo-600 group-hover:text-white transition-colors shadow-sm">
                        <i class="fa-solid fa-rocket text-xl"></i>
                    </div>
                    <h4 class="font-bold text-slate-800 text-lg mb-1">Buat Planning</h4>
                    <p class="text-xs text-slate-500 leading-relaxed">Buat brief lengkap, tentukan tim, jobdesk, dan jadwal tayang konten.</p>
                </a>

                <!-- Opsi 2: Notes -->
                <button 
                    @click="isWritingNote = true"
                    class="group p-6 bg-white border-2 border-slate-100 rounded-[2rem] text-left hover:border-emerald-500 hover:shadow-xl hover:shadow-emerald-50 transition-all duration-300"
                >
                    <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center mb-4 group-hover:bg-emerald-500 group-hover:text-white transition-colors shadow-sm">
                        <i class="fa-solid fa-note-sticky text-xl"></i>
                    </div>
                    <h4 class="font-bold text-slate-800 text-lg mb-1">Buat Notes</h4>
                    <p class="text-xs text-slate-500 leading-relaxed">Catatan cepat untuk ide, pengingat, atau memo sederhana tanpa manajemen tim.</p>
                </button>
            </div>
        </div>

        <!-- Body: Input Notes (Muncul Saat isWritingNote == true) -->
        <div class="p-8 space-y-6" x-show="isWritingNote" x-transition x-cloak>
            <div class="space-y-4">
                <div class="space-y-2">
                    <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Judul Catatan</label>
                    <input type="text" x-model="noteData.title" placeholder="Misal: Ide Konten Ramadhan..." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-5 py-3 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-emerald-500 outline-none transition-all">
                </div>
                <div class="space-y-2">
                    <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Isi Catatan</label>
                    <textarea x-model="noteData.content" rows="4" placeholder="Tuliskan ide Anda di sini..." class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-3 text-sm text-slate-600 focus:ring-2 focus:ring-emerald-500 outline-none transition-all"></textarea>
                </div>
                <div class="space-y-2">
                    <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1 block text-center mb-2">Kategori Warna</label>
                    <div class="flex justify-center gap-3">
                        <template x-for="color in ['bg-indigo-500', 'bg-emerald-500', 'bg-amber-500', 'bg-rose-500', 'bg-purple-500']" :key="color">
                            <button 
                                type="button"
                                @click="noteData.color = color" 
                                :class="color" 
                                class="w-8 h-8 rounded-full border-4 transition-all" 
                                :class="noteData.color === color ? 'border-slate-200 scale-110 shadow-lg' : 'border-transparent opacity-60 hover:opacity-100'"
                            ></button>
                        </template>
                    </div>
                </div>
            </div>

            <div class="pt-6 border-t border-slate-100 flex gap-3">
                <button type="button" @click="isWritingNote = false" class="flex-1 py-3 text-sm font-bold text-slate-500 hover:bg-slate-50 rounded-2xl transition-all">Kembali</button>
                <button type="button" @click="saveNote()" class="flex-[2] bg-emerald-500 text-white py-3 rounded-2xl font-bold text-sm shadow-xl shadow-emerald-100 hover:bg-emerald-600 transition-all transform active:scale-95">Simpan Catatan</button>
            </div>
        </div>
    </div>
</div>