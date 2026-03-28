<!-- resources/views/layouts/navbar.blade.php -->
<header class="h-100 bg-white/80 backdrop-blur-md border-b border-slate-200 px-8 lg:px-10 flex items-center justify-between sticky top-0 z-30 transition-all">
    
    <!-- Bagian Kiri: Greeting & Tanggal -->
    <div class="flex flex-col justify-center gap-1">
        <h2 class="font-extrabold text-xl text-slate-800 hidden sm:block leading-tight">Selamat Datang, Admin 👋</h2>
        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest hidden md:block">
            <i class="fa-regular fa-calendar text-[10px] mr-1"></i> {{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y') }}
        </p>
    </div>


    <!-- Bagian Kanan: Aksi & Profil User (Lebih lega) -->
    <div class="flex items-center gap-5 sm:gap-8 shrink-0">

        <!-- Notifikasi -->
        <div class="relative cursor-pointer w-11 h-11 flex items-center justify-center rounded-full hover:bg-slate-50 transition-colors text-slate-400 hover:text-indigo-600">
            <i class="fa-solid fa-bell text-xl transition-transform hover:rotate-12"></i>
            <span class="absolute top-2 right-2.5 w-2.5 h-2.5 bg-rose-500 rounded-full border-2 border-white"></span>
        </div>
        
        <!-- Area Profil -->
        <!-- <div class="flex items-center gap-4 pl-5 sm:pl-8 border-l border-slate-200 cursor-pointer group">
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
        </div> -->
    </div>
</header>