<!-- resources/views/layouts/navbar.blade.php -->
<header class="h-100 bg-white/80 backdrop-blur-md border-b border-slate-200 px-8 lg:px-10 flex items-center justify-between sticky top-0 z-30 transition-all">
    
    <!-- Bagian Kiri: Greeting & Tanggal -->
    <div class="flex flex-col justify-center gap-1">
        <h2 class="font-extrabold text-xl text-slate-800 hidden sm:block leading-tight">Selamat Datang, Admin 👋</h2>
        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest hidden md:block">
            <i class="fa-regular fa-calendar text-[10px] mr-1"></i> {{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y') }}
        </p>
    </div>
    
    <!-- Bagian Tengah: Search Bar (Lebih besar dan proporsional) -->
    <div class="hidden lg:flex flex-1 max-w-lg mx-10 xl:mx-16">
        <div class="relative w-full group">
            <i class="fa-solid fa-magnifying-glass absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-indigo-500 transition-colors text-lg"></i>
            <input 
                type="text" 
                placeholder="Cari konten, jadwal, atau tugas..." 
                class="w-full bg-slate-50 border border-slate-200 text-sm font-semibold rounded-full pl-14 pr-6 py-3.5 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 focus:bg-white transition-all shadow-sm placeholder:font-normal"
            >
            <div class="absolute right-4 top-1/2 -translate-y-1/2 flex items-center gap-1.5">
                <kbd class="hidden xl:inline-block text-[11px] font-bold text-slate-400 bg-white border border-slate-200 px-2 py-1 rounded-md shadow-sm">Ctrl</kbd>
                <kbd class="hidden xl:inline-block text-[11px] font-bold text-slate-400 bg-white border border-slate-200 px-2 py-1 rounded-md shadow-sm">K</kbd>
            </div>
        </div>
    </div>

    <!-- Bagian Kanan: Aksi & Profil User (Lebih lega) -->
    <div class="flex items-center gap-5 sm:gap-8 shrink-0">
        <!-- Tombol Quick Action -->
        <button class="hidden sm:flex items-center justify-center w-11 h-11 bg-indigo-50 text-indigo-600 rounded-full hover:bg-indigo-600 hover:text-white transition-all shadow-sm" title="Buat Cepat">
            <i class="fa-solid fa-plus text-lg"></i>
        </button>

        <!-- Notifikasi -->
        <div class="relative cursor-pointer w-11 h-11 flex items-center justify-center rounded-full hover:bg-slate-50 transition-colors text-slate-400 hover:text-indigo-600">
            <i class="fa-solid fa-bell text-xl transition-transform hover:rotate-12"></i>
            <span class="absolute top-2 right-2.5 w-2.5 h-2.5 bg-rose-500 rounded-full border-2 border-white"></span>
        </div>
        
        <!-- Area Profil -->
        <div class="flex items-center gap-4 pl-5 sm:pl-8 border-l border-slate-200 cursor-pointer group">
            <div class="text-right hidden sm:block">
                <p class="text-sm font-bold text-slate-800 group-hover:text-indigo-600 transition-colors">Media Planner</p>
                <p class="text-[10px] text-emerald-500 font-black uppercase tracking-widest mt-0.5 flex items-center justify-end gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span> Aktif
                </p>
            </div>
            
            <div class="flex items-center gap-2">
                <div class="w-12 h-12 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold border-2 border-white shadow-md group-hover:shadow-xl transition-all transform group-hover:-translate-y-0.5 relative overflow-hidden">
                    <img src="https://ui-avatars.com/api/?name=Media+Planner&background=4f46e5&color=fff&bold=true" alt="Avatar" class="w-full h-full object-cover">
                </div>
                <i class="fa-solid fa-chevron-down text-[10px] text-slate-400 group-hover:text-indigo-600 transition-colors hidden sm:block ml-2"></i>
            </div>
        </div>
    </div>
</header>