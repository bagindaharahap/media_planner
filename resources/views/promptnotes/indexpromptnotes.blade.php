@extends('layouts.app')

@section('title', 'Prompt Notes - PlannerX')

@section('content')

<!-- Tangkap pesan sukses/error dari session jika ada (fallback) -->
@if(session('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-2xl mb-6 flex items-center justify-between shadow-sm relative z-10 transition-all duration-500" x-transition:leave="opacity-0 translate-y-[-10px]">
        <div class="flex items-center gap-3">
            <i class="fa-solid fa-check-circle text-emerald-500 text-xl"></i>
            <span class="font-semibold">{{ session('success') }}</span>
        </div>
        <button @click="show = false" class="text-emerald-400 hover:text-emerald-600 transition-colors">
            <i class="fa-solid fa-xmark text-lg"></i>
        </button>
    </div>
@endif

@if($errors->any())
    <div class="bg-rose-50 border border-rose-200 text-rose-700 px-4 py-3 rounded-2xl mb-6 shadow-sm relative z-10">
        <div class="flex items-center gap-3 mb-2">
            <i class="fa-solid fa-exclamation-circle text-rose-500 text-xl"></i>
            <span class="font-semibold">Terjadi kesalahan:</span>
        </div>
        <ul class="list-disc list-inside text-sm space-y-1">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<!-- Ambil data asli dari Controller Database -->
<script id="prompts-data" type="application/json">
    {!! json_encode($prompts ?? []) !!}
</script>

<div x-data="promptNotesData()" class="space-y-6 min-h-[calc(100vh-120px)] relative">
    
    <!-- Header & Tools Bar -->
    <div class="bg-white p-6 rounded-[2rem] border border-slate-200 shadow-sm flex flex-col md:flex-row items-center justify-between gap-4 relative z-10">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 bg-indigo-50 rounded-2xl flex items-center justify-center text-indigo-600 shadow-inner">
                <i class="fa-solid fa-pen-to-square text-xl"></i>
            </div>
            <div>
                <h2 class="text-xl font-black text-slate-800 tracking-tight">Prompt Notes</h2>
                <p class="text-xs text-slate-500 font-medium">Kelola dan simpan template prompt Anda</p>
            </div>
        </div>

        <div class="flex flex-col md:flex-row items-center gap-3 w-full md:w-auto">
            <!-- Search Bar -->
            <div class="relative w-full md:w-64">
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                <input 
                    type="text" 
                    x-model="search" 
                    placeholder="Cari prompt..." 
                    class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all"
                >
            </div>

            <!-- Filter Kategori -->
            <div class="relative w-full md:w-48">
                <i class="fa-solid fa-filter absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                <select 
                    x-model="filterCategory" 
                    class="w-full pl-10 pr-8 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-indigo-500 appearance-none transition-all cursor-pointer text-slate-600 font-semibold"
                >
                    <option value="">Semua Kategori</option>
                    <template x-for="cat in uniqueCategories" :key="cat">
                        <option :value="cat" x-text="cat"></option>
                    </template>
                </select>
                <i class="fa-solid fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 text-[10px] pointer-events-none"></i>
            </div>

            <!-- Tombol Tambah -->
            <button 
                @click="openCreate()" 
                class="w-full md:w-auto flex items-center justify-center gap-2 px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-xl shadow-lg shadow-indigo-200 transition-all active:scale-95"
            >
                <i class="fa-solid fa-plus text-xs"></i> Tambah Prompt
            </button>
        </div>
    </div>

    <!-- Area Tabel -->
    <div class="bg-white rounded-[2rem] border border-slate-200 shadow-sm overflow-hidden relative z-[1]">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-200 text-[10px] font-black uppercase tracking-widest text-slate-400">
                        <th class="p-5 pl-8 rounded-tl-[2rem]">Judul Prompt</th>
                        <th class="p-5">Kategori</th>
                        <th class="p-5">Log Terakhir</th>
                        <th class="p-5 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    <!-- Menggunakan paginatedPrompts agar data dilimit sesuai pagination -->
                    <template x-for="prompt in paginatedPrompts" :key="prompt.id">
                        <tr class="hover:bg-indigo-50/30 transition-colors group">
                            <td class="p-5 pl-8">
                                <p class="font-bold text-slate-800" x-text="prompt.title"></p>
                                <p class="text-xs text-slate-500 truncate max-w-md line-clamp-1" x-text="stripHtml(prompt.description)"></p>
                            </td>
                            <td class="p-5">
                                <span class="px-3 py-1 bg-slate-100 text-slate-600 border border-slate-200 font-bold text-[10px] rounded-lg uppercase tracking-wider shadow-sm" x-text="prompt.category"></span>
                            </td>
                            <td class="p-5">
                                <div class="flex flex-col gap-0.5">
                                    <span class="text-[11px] font-bold text-slate-700">
                                        <span x-text="prompt.log_action || 'Dibuat'"></span> oleh 
                                        <span class="text-indigo-600" x-text="prompt.log_user || '{{ Auth::user()->name ?? 'User' }}'"></span>
                                    </span>
                                    <span class="text-[10px] text-slate-400 font-medium flex items-center gap-1">
                                        <i class="fa-regular fa-clock"></i>
                                        <span x-text="formatDate(prompt.updated_at || prompt.created_at || new Date())"></span>
                                    </span>
                                </div>
                            </td>
                            <td class="p-5 text-center">
                                <!-- Opacity diatur terlihat penuh (tanpa transisi hover) -->
                                <div class="flex items-center justify-center gap-2">
                                    <button @click="openView(prompt)" class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 hover:bg-indigo-600 hover:text-white flex items-center justify-center transition-colors shadow-sm" title="Lihat">
                                        <i class="fa-solid fa-eye text-xs"></i>
                                    </button>
                                    <button @click="openEdit(prompt)" class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 hover:bg-amber-500 hover:text-white flex items-center justify-center transition-colors shadow-sm" title="Edit">
                                        <i class="fa-solid fa-pen text-xs"></i>
                                    </button>
                                    <button @click="deletePrompt(prompt.id)" class="w-8 h-8 rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-500 hover:text-white flex items-center justify-center transition-colors shadow-sm" title="Hapus">
                                        <i class="fa-solid fa-trash text-xs"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </template>
                    
                    <template x-if="paginatedPrompts.length === 0">
                        <tr>
                            <td colspan="4" class="p-10 text-center">
                                <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-3 text-slate-300">
                                    <i class="fa-solid fa-folder-open text-2xl"></i>
                                </div>
                                <p class="text-slate-500 font-bold">Tidak ada data prompt ditemukan.</p>
                                <p class="text-xs text-slate-400 mt-1">Coba gunakan kata kunci lain atau tambah prompt baru.</p>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>

        <!-- Komponen Pagination -->
        <template x-if="totalPages > 0">
            <div class="px-6 py-4 bg-slate-50/50 border-t border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-4">
                <p class="text-xs text-slate-500 font-medium">
                    Menampilkan <span class="font-bold text-slate-700" x-text="(currentPage - 1) * itemsPerPage + 1"></span> - 
                    <span class="font-bold text-slate-700" x-text="Math.min(currentPage * itemsPerPage, filteredPrompts.length)"></span> 
                    dari <span class="font-bold text-slate-700" x-text="filteredPrompts.length"></span> data
                </p>
                <div class="flex items-center gap-1.5">
                    <button @click="currentPage--" :disabled="currentPage === 1" class="w-8 h-8 flex items-center justify-center rounded-lg border border-slate-200 text-slate-500 hover:bg-slate-100 disabled:opacity-50 disabled:cursor-not-allowed transition-all shadow-sm bg-white">
                        <i class="fa-solid fa-chevron-left text-[10px]"></i>
                    </button>
                    
                    <div class="flex items-center gap-1">
                        <template x-for="page in totalPages" :key="page">
                            <button 
                                @click="currentPage = page" 
                                class="w-8 h-8 flex items-center justify-center rounded-lg text-xs font-bold transition-all shadow-sm border"
                                :class="currentPage === page ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-white text-slate-600 border-slate-200 hover:bg-slate-50'"
                                x-text="page"
                            ></button>
                        </template>
                    </div>

                    <button @click="currentPage++" :disabled="currentPage === totalPages" class="w-8 h-8 flex items-center justify-center rounded-lg border border-slate-200 text-slate-500 hover:bg-slate-100 disabled:opacity-50 disabled:cursor-not-allowed transition-all shadow-sm bg-white">
                        <i class="fa-solid fa-chevron-right text-[10px]"></i>
                    </button>
                </div>
            </div>
        </template>
    </div>

    <!-- Panggil File Modal Eksternal -->
    @include('promptnotes.createpromptnotes')
    @include('promptnotes.editpromptnotes')
    @include('promptnotes.lihatpromptnotes')

</div>

@push('scripts')
<script>
function promptNotesData() {
    return {
        // State Log & Auth
        currentUser: '{{ Auth::user()->name ?? 'User' }}',

        // State Filter & Search
        search: '',
        filterCategory: '',
        
        // State Pagination
        currentPage: 1,
        itemsPerPage: 5, 
        
        // State Modals
        showCreateModal: false,
        showEditModal: false,
        showViewModal: false,
        prompts: [],
        form: { id: '', title: '', category: '', description: '', log_action: '', log_user: '' },
        csrfToken: document.querySelector('meta[name="csrf-token"]')?.getAttribute('content'),

        init() {
            try {
                // Mengambil data dari database yang dilempar oleh Controller
                let rawData = JSON.parse(document.getElementById('prompts-data').textContent);
                this.prompts = rawData;
            } catch(e) {
                console.error('Gagal memuat data prompts:', e);
            }

            // Mereset ke halaman pertama saat melakukan filter/pencarian
            this.$watch('search', () => { this.currentPage = 1; });
            this.$watch('filterCategory', () => { this.currentPage = 1; });
        },

        get uniqueCategories() {
            let categories = this.prompts.map(p => p.category);
            return [...new Set(categories)].filter(Boolean).sort();
        },

        get filteredPrompts() {
            return this.prompts.filter(p => {
                let matchSearch = p.title.toLowerCase().includes(this.search.toLowerCase()) || 
                                  p.category.toLowerCase().includes(this.search.toLowerCase());
                let matchCategory = this.filterCategory === '' || p.category === this.filterCategory;
                return matchSearch && matchCategory;
            });
        },

        get totalPages() {
            return Math.ceil(this.filteredPrompts.length / this.itemsPerPage);
        },
        
        get paginatedPrompts() {
            let start = (this.currentPage - 1) * this.itemsPerPage;
            let end = start + this.itemsPerPage;
            return this.filteredPrompts.slice(start, end);
        },

        // Format Tanggal untuk Kolom Log
        formatDate(dateString) {
            if(!dateString) return '-';
            const date = new Date(dateString);
            const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'];
            const d = date.getDate().toString().padStart(2, '0');
            const m = months[date.getMonth()];
            const y = date.getFullYear();
            const hr = date.getHours().toString().padStart(2, '0');
            const min = date.getMinutes().toString().padStart(2, '0');
            return `${d} ${m} ${y}, ${hr}:${min} WIB`;
        },

        stripHtml(html) {
            if(!html) return '';
            let tmp = document.createElement("DIV");
            tmp.innerHTML = html;
            return tmp.textContent || tmp.innerText || "";
        },

        openCreate() {
            this.form = { id: '', title: '', category: '', description: '', log_action: '', log_user: '' };
            this.showCreateModal = true;
        },
        openEdit(prompt) {
            this.form = JSON.parse(JSON.stringify(prompt));
            this.showEditModal = true;
        },
        openView(prompt) {
            this.form = JSON.parse(JSON.stringify(prompt));
            this.showViewModal = true;
        },

        async savePrompt() {
            try {
                if(!this.form.title || !this.form.category) throw new Error("Judul dan Kategori wajib diisi!");
                
                // Set data Log secara otomatis
                this.form.log_action = 'Dibuat';
                this.form.log_user = this.currentUser;

                const res = await fetch('/prompt-notes', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': this.csrfToken
                    },
                    body: JSON.stringify(this.form)
                });
                
                if (!res.ok) throw new Error("Gagal menyimpan data ke database.");
                const data = await res.json();
                
                // Masukkan data balasan dari server ke tabel frontend
                this.prompts.unshift(data.prompt); 
                
                this.showCreateModal = false;
                AppPopup.success('Berhasil', 'Prompt catatan baru telah dibuat.');
            } catch (error) {
                AppPopup.success('Gagal', error.message);
            }
        },

        async updatePrompt() {
            try {
                if(!this.form.title || !this.form.category) throw new Error("Judul dan Kategori wajib diisi!");
                
                // Set data Log secara otomatis
                this.form.log_action = 'Diperbarui';
                this.form.log_user = this.currentUser;

                const res = await fetch(`/prompt-notes/${this.form.id}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': this.csrfToken
                    },
                    body: JSON.stringify({
                        ...this.form,
                        _method: 'PUT'
                    })
                });

                if (!res.ok) throw new Error("Gagal memperbarui data.");
                const data = await res.json();

                let index = this.prompts.findIndex(p => p.id === this.form.id);
                if(index !== -1) {
                    this.prompts[index] = data.prompt;
                }

                this.showEditModal = false;
                AppPopup.success('Berhasil Diedit', 'Perubahan prompt berhasil disimpan.');
            } catch (error) {
                AppPopup.success('Gagal Update', error.message);
            }
        },

        async deletePrompt(id) {
            AppPopup.confirmDelete(
                'Hapus Prompt?',
                'Yakin ingin menghapus catatan prompt ini? Anda tidak akan bisa mengembalikannya.',
                async () => {
                    try {
                        const res = await fetch(`/prompt-notes/${id}`, {
                            method: 'POST',
                            headers: { 
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': this.csrfToken 
                            },
                            body: JSON.stringify({
                                _method: 'DELETE'
                            })
                        });

                        if (!res.ok) throw new Error("Gagal menghapus dari server.");

                        this.prompts = this.prompts.filter(p => p.id !== id);
                        
                        // Cek jika halaman saat ini kosong setelah dihapus, pindah ke hal sebelumnya
                        if (this.paginatedPrompts.length === 0 && this.currentPage > 1) {
                            this.currentPage--;
                        }

                        AppPopup.success('Berhasil Dihapus', 'Catatan prompt telah dihapus dari sistem.');
                    } catch (error) {
                        AppPopup.success('Gagal Hapus', error.message);
                    }
                }
            );
        }
    }
}
</script>
@endpush
@endsection