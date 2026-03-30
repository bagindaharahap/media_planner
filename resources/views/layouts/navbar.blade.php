<!-- resources/views/layouts/navbar.blade.php -->
<header class="h-100 bg-white/80 backdrop-blur-md border-b border-slate-200 px-8 lg:px-10 flex items-center justify-between sticky top-0 z-30 transition-all">
    
    <!-- Bagian Kiri: Greeting & Tanggal -->
    <div class="flex flex-col justify-center gap-1">
        <!-- Teks 'Admin' diganti dengan pemanggilan nama dari database -->
        <h2 class="font-extrabold text-xl text-slate-800 hidden sm:block leading-tight">Selamat Datang, {{ Auth::user()->name ?? 'User' }} 👋</h2>
        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest hidden md:block">
            <i class="fa-regular fa-calendar text-[10px] mr-1"></i> {{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y') }}
        </p>
    </div>

    <!-- Bagian Kanan: Aksi & Profil User (Lebih lega) -->
    <div class="flex items-center gap-5 sm:gap-8 shrink-0">

        <!-- Tombol Notifikasi (Letakkan di Navbar kanan) -->
        <div class="relative" x-data="{ openNotif: false }" @click.outside="openNotif = false">
            <button @click="openNotif = !openNotif" class="relative w-10 h-10 bg-white rounded-full flex items-center justify-center text-slate-500 hover:text-indigo-600 hover:bg-indigo-50 transition-all border border-slate-200 shadow-sm">
                <i class="fa-regular fa-bell text-lg"></i>
                <!-- Badge Titik Merah (Jika ada notif baru) -->
                <span class="absolute top-2 right-2 w-2.5 h-2.5 bg-rose-500 rounded-full border-2 border-white animate-pulse"></span>
            </button>

            <!-- Dropdown Isi Notifikasi -->
            <div x-show="openNotif" x-cloak x-transition class="absolute right-0 mt-3 w-80 bg-white rounded-2xl shadow-xl border border-slate-100 overflow-hidden z-50">
                <div class="px-5 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                    <h3 class="font-bold text-slate-800 text-sm">Notifikasi</h3>
                    <button class="text-[10px] text-indigo-600 font-bold hover:underline">Tandai semua dibaca</button>
                </div>
                
                <div class="max-h-[300px] overflow-y-auto divide-y divide-slate-50 custom-scrollbar">
                    <!-- Item Notif 1 (Action Needed) -->
                    <a href="#" class="p-4 flex items-start gap-4 hover:bg-slate-50 transition-colors cursor-pointer bg-indigo-50/30">
                        <div class="w-8 h-8 rounded-full bg-amber-100 flex items-center justify-center text-amber-500 shrink-0 mt-1">
                            <i class="fa-solid fa-clipboard-check text-[10px]"></i>
                        </div>
                        <div>
                            <p class="text-xs text-slate-800 font-bold mb-1">Konten Menunggu Review</p>
                            <p class="text-[11px] text-slate-500 line-clamp-2">Lisa memindahkan "Promo Ramadhan TikTok" ke status In Review.</p>
                            <p class="text-[9px] text-slate-400 font-semibold mt-2">10 Menit yang lalu</p>
                        </div>
                    </a>

                    <!-- Item Notif 2 (Error API) -->
                    <a href="#" class="p-4 flex items-start gap-4 hover:bg-slate-50 transition-colors cursor-pointer">
                        <div class="w-8 h-8 rounded-full bg-rose-100 flex items-center justify-center text-rose-500 shrink-0 mt-1">
                            <i class="fa-solid fa-triangle-exclamation text-[10px]"></i>
                        </div>
                        <div>
                            <p class="text-xs text-slate-800 font-bold mb-1">Koneksi Instagram Terputus</p>
                            <p class="text-[11px] text-slate-500 line-clamp-2">Token API kedaluwarsa. Silakan login ulang Meta API.</p>
                            <p class="text-[9px] text-slate-400 font-semibold mt-2">1 Jam yang lalu</p>
                        </div>
                    </a>
                </div>
                <a href="#" class="block px-5 py-3 text-center text-xs font-bold text-slate-500 bg-slate-50 hover:text-indigo-600 hover:bg-indigo-50 transition-all border-t border-slate-100">
                    Lihat Semua Notifikasi
                </a>
            </div>
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