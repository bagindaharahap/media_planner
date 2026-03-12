<!-- resources/views/layouts/sidebar.blade.php -->
<aside class="w-20 md:w-72 bg-white border-r border-slate-200 flex flex-col transition-all duration-300">
    <div class="p-4 md:p-8">
        <div class="flex items-center gap-2 text-indigo-600">
            <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center text-white shrink-0 shadow-lg shadow-indigo-200">
                <i class="fa-solid fa-chart-line text-lg"></i>
            </div>
            <span class="text-xl font-black tracking-tighter hidden md:block">PlannerX</span>
        </div>
    </div>

    <nav class="flex-1 px-3 md:px-6 space-y-2 mt-4">
        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-4 mb-2 hidden md:block">Utama</p>
        
        <a href="#" class="flex items-center justify-center md:justify-start gap-3 px-4 py-3 bg-indigo-600 text-white rounded-xl shadow-md transition-all">
            <i class="fa-solid fa-layer-group"></i>
            <span class="font-semibold text-sm hidden md:block">Dasbor</span>
        </a>
        
        <a href="#" class="flex items-center justify-center md:justify-start gap-3 px-4 py-3 text-slate-500 hover:bg-slate-50 rounded-xl transition-all">
            <i class="fa-solid fa-calendar-check"></i>
            <span class="font-semibold text-sm hidden md:block">Jadwal Konten</span>
        </a>
        
        <div class="pt-8 hidden md:block">
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-4 mb-2">Akun</p>
            <a href="#" class="flex items-center justify-between px-4 py-3 text-slate-500 hover:bg-slate-50 rounded-xl transition-all">
                <div class="flex items-center gap-3">
                    <i class="fa-brands fa-instagram text-pink-500"></i>
                    <span class="font-semibold text-sm">Instagram</span>
                </div>
                <span class="w-2 h-2 bg-green-500 rounded-full"></span>
            </a>
        </div>
    </nav>
</aside>