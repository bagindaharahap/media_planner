@extends('layouts.app')

@section('title', 'Management Akun - PlannerX')

@section('content')

@if(session('success'))
    <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-2xl mb-6 flex items-center gap-3">
        <i class="fa-solid fa-check-circle text-emerald-500"></i>
        <span class="font-semibold">{{ session('success') }}</span>
    </div>
@endif

@if($errors->any())
    <div class="bg-rose-50 border border-rose-200 text-rose-700 px-4 py-3 rounded-2xl mb-6">
        <div class="flex items-center gap-3 mb-2">
            <i class="fa-solid fa-exclamation-circle text-rose-500"></i>
            <span class="font-semibold">Terjadi kesalahan:</span>
        </div>
        <ul class="list-disc list-inside text-sm space-y-1">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<script id="users-data" type="application/json">
    {!! json_encode($users ?? []) !!}
</script>

<div 
    x-data="{
        searchQuery: '',
        roleFilter: 'Semua',
        showCreateModal: false,
        showEditModal: false,
        showDeleteModal: false,
        showPassword: false,
        selectedUser: null,
        
        // Data pengguna akan diisi dari script tag di atas saat init() dipanggil
        users: [],

        roles: ['Admin', 'Content Planner'],

        init() {
            try {
                // Mengambil data secara aman
                this.users = JSON.parse(document.getElementById('users-data').textContent);
            } catch(e) {
                console.error('Gagal memuat data users:', e);
                this.users = [];
            }
        },

        get filteredUsers() {
            return this.users.filter(user => {
                const matchesSearch = user.name.toLowerCase().includes(this.searchQuery.toLowerCase()) || 
                                      user.email.toLowerCase().includes(this.searchQuery.toLowerCase());
                const matchesRole = this.roleFilter === 'Semua' || user.role === this.roleFilter;
                return matchesSearch && matchesRole;
            });
        },

        getRoleColor(role) {
            const colors = {
                'Admin': 'bg-purple-100 text-purple-700 border-purple-200',
                'Content Planner': 'bg-blue-100 text-blue-700 border-blue-200',
            };
            return colors[role] || 'bg-slate-100 text-slate-700 border-slate-200';
        },

        openEdit(user) {
            this.selectedUser = JSON.parse(JSON.stringify(user));
            this.showPassword = false; // Reset password visibility
            this.showEditModal = true;
        },

        confirmDelete(user) {
            this.selectedUser = user;
            this.showDeleteModal = true;
        },

        // Reset password visibility when modals are closed
        resetPasswordVisibility() {
            this.showPassword = false;
        }
    }"
    class="space-y-6"
>
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Management Akun</h1>
            <p class="text-sm text-slate-500 font-medium">Kelola hak akses, role, dan anggota tim PlannerX.</p>
        </div>
        <button @click="showCreateModal = true; resetPasswordVisibility()" class="bg-indigo-600 text-white px-6 py-3 rounded-2xl font-bold shadow-lg shadow-indigo-100 hover:bg-indigo-700 transition-all flex items-center justify-center gap-2">
            <i class="fa-solid fa-user-plus text-xs"></i>
            Tambah Pengguna
        </button>
    </div>

    <div class="bg-white p-4 rounded-3xl border border-slate-100 shadow-sm flex flex-wrap items-center gap-4">
        <div class="flex-1 min-w-[250px] relative">
            <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
            <input x-model="searchQuery" type="text" placeholder="Cari nama atau email pengguna..." class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm font-semibold text-slate-700 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 transition-all">
        </div>
        
        <div class="flex items-center gap-3">
            <div class="flex items-center gap-2 px-3 border-r border-slate-200">
                <i class="fa-solid fa-filter text-slate-400 text-xs"></i>
                <span class="text-xs font-bold text-slate-500 uppercase tracking-widest">Filter:</span>
            </div>
            <select x-model="roleFilter" class="px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm font-semibold text-slate-600 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 cursor-pointer transition-all min-w-[160px]">
                <option value="Semua">Semua Role</option>
                <template x-for="role in roles">
                    <option :value="role" x-text="role"></option>
                </template>
            </select>
        </div>
    </div>

    <div class="bg-white border border-slate-100 rounded-[2rem] shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100">
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Pengguna</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Akses & Role</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Status</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    <template x-for="user in filteredUsers" :key="user.id">
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            <td class="px-8 py-4">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-xl flex items-center justify-center font-black text-sm shadow-sm"
                                         :class="user.role === 'Admin' ? 'bg-indigo-600 text-white shadow-indigo-200' : 'bg-slate-100 text-slate-600 border border-slate-200'">
                                        <span x-text="user.name ? user.name.substring(0, 2).toUpperCase() : 'US'"></span>
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-800 text-sm" x-text="user.name"></p>
                                        <p class="text-xs text-slate-500 font-medium" x-text="user.email"></p>
                                    </div>
                                </div>
                            </td>
                            
                            <td class="px-8 py-4">
                                <span class="px-3 py-1.5 text-[10px] font-bold uppercase tracking-widest rounded-lg border"
                                      :class="getRoleColor(user.role)"
                                      x-text="user.role">
                                </span>
                            </td>

                            <td class="px-8 py-4">
                                <div class="flex items-center gap-2">
                                    <div class="w-2 h-2 rounded-full" :class="user.status === 'Aktif' ? 'bg-emerald-500' : 'bg-slate-300'"></div>
                                    <span class="text-xs font-bold" :class="user.status === 'Aktif' ? 'text-slate-700' : 'text-slate-400'" x-text="user.status"></span>
                                </div>
                            </td>

                            <td class="px-8 py-4 text-right">
                                <div class="flex items-center justify-end gap-2 transition-opacity">
                                    <button @click="openEdit(user)" class="w-8 h-8 rounded-lg border border-slate-200 flex items-center justify-center text-slate-400 hover:bg-indigo-50 hover:text-indigo-600 hover:border-indigo-200 transition-all" title="Edit Pengguna">
                                        <i class="fa-solid fa-pen text-[10px]"></i>
                                    </button>
                                    <button @click="confirmDelete(user)" class="w-8 h-8 rounded-lg border border-slate-200 flex items-center justify-center text-slate-400 hover:bg-rose-50 hover:text-rose-600 hover:border-rose-200 transition-all" title="Hapus Pengguna">
                                        <i class="fa-solid fa-trash text-[10px]"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </template>
                    
                    <tr x-show="filteredUsers.length === 0">
                        <td colspan="4" class="px-8 py-12 text-center">
                            <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-3 text-slate-300">
                                <i class="fa-solid fa-users-slash text-2xl"></i>
                            </div>
                            <p class="text-slate-500 font-bold">Pengguna tidak ditemukan</p>
                            <p class="text-xs text-slate-400 mt-1">Coba gunakan kata kunci pencarian yang lain atau data database masih kosong.</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <div class="px-8 py-4 border-t border-slate-100 bg-slate-50/50 flex items-center justify-between">
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Menampilkan <span x-text="filteredUsers.length"></span> Pengguna</p>
        </div>
    </div>


    @include('management_akun.tambahuser')

    @include('management_akun.edituser')

    <div x-show="showDeleteModal" x-cloak class="fixed inset-0 z-[200] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm" x-transition.opacity>
        <div @click.outside="showDeleteModal = false" class="bg-white w-full max-w-md rounded-[2.5rem] shadow-2xl p-8 border border-slate-100 text-center" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 scale-95 translate-y-4" x-transition:enter-end="opacity-100 scale-100 translate-y-0">
            <div class="w-20 h-20 bg-rose-50 text-rose-500 rounded-full flex items-center justify-center mx-auto mb-6 text-3xl shadow-inner"><i class="fa-solid fa-user-xmark"></i></div>
            <h3 class="text-2xl font-bold text-slate-800 mb-2">Hapus Pengguna?</h3>
            <p class="text-slate-500 text-sm leading-relaxed mb-8 px-4" x-text="selectedUser ? `Apakah Anda yakin ingin menghapus akses untuk ${selectedUser.name}?` : ''"></p>
            <div class="flex gap-4">
                <button type="button" @click="showDeleteModal = false" class="flex-1 px-6 py-3.5 rounded-2xl text-sm font-bold text-slate-500 hover:bg-slate-50 border border-slate-100 transition-all">Batal</button>
                
                <form x-show="selectedUser" :action="`{{ url('/management-akun') }}/${selectedUser?.id}`" method="POST" class="flex-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full px-6 py-3.5 bg-rose-500 text-white rounded-2xl font-bold shadow-xl shadow-rose-100 hover:bg-rose-600 transform active:scale-95 transition-all">Ya, Hapus</button>
                </form>
            </div>
        </div>
    </div>

</div>

@endsection