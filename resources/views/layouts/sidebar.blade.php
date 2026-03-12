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

    <!-- Gunakan x-data Alpine.js untuk mengatur state dropdown -->
    <nav class="flex-1 px-3 md:px-6 space-y-2 mt-4" x-data="{ openPosts: false }">
        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-4 mb-2 hidden md:block">Utama</p>
        
        <a href="#" class="flex items-center justify-center md:justify-start gap-3 px-4 py-3 text-slate-500 hover:bg-slate-50 rounded-xl transition-all">
            <i class="fa-solid fa-layer-group text-lg md:text-sm"></i>
            <span class="font-semibold text-sm hidden md:block">Dasbor</span>
        </a>
        
        <!-- Dropdown Menu Jadwal Konten -->
        <div class="relative" @click.outside="openPosts = false">
            <button 
                @click="openPosts = !openPosts" 
                class="w-full flex items-center justify-center md:justify-start gap-3 px-4 py-3 rounded-xl transition-all focus:outline-none group"
                :class="openPosts ? 'bg-indigo-50 text-indigo-600' : 'text-slate-500 hover:bg-slate-50'"
            >
                <i class="fa-solid fa-calendar-check text-lg md:text-sm"></i>
                <span class="font-semibold text-sm hidden md:block flex-1 text-left text-sm">Jadwal Konten</span>
                <i 
                    class="fa-solid fa-chevron-down text-[10px] transition-transform duration-300 hidden md:block" 
                    :class="openPosts ? 'rotate-180' : ''"
                ></i>
            </button>
            
            <!-- Sub Menu Items -->
            <div 
                x-show="openPosts" 
                x-cloak
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 -translate-y-2 scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                x-transition:leave-end="opacity-0 -translate-y-2 scale-95"
                class="md:pl-10 mt-1 space-y-1"
            >
                <a href="{{ route('board.index') }}" class="block px-4 py-2 text-xs font-bold text-slate-500 hover:text-indigo-600 rounded-lg hover:bg-indigo-50 transition-all border-l-2 border-transparent hover:border-indigo-400">
                    Board Content Planning
                </a>
                <a href="{{ route('calendar.index') }}" class="block px-4 py-2 text-xs font-bold text-slate-500 hover:text-indigo-600 rounded-lg hover:bg-indigo-50 transition-all border-l-2 border-transparent hover:border-indigo-400">
                    Calender Note
                </a>
            </div>
        </div>
        
        <div class="pt-8 hidden md:block">
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-4 mb-2">Akun</p>
            <a href="#" class="flex items-center justify-between px-4 py-3 text-slate-500 hover:bg-slate-50 rounded-xl transition-all">
                <div class="flex items-center gap-3">
                    <i class="fa-brands fa-instagram text-pink-500"></i>
                    <span class="font-semibold text-sm">Instagram</span>
                </div>
                <span class="w-2 h-2 bg-green-500 rounded-full"></span>
            </a>
            <a href="#" class="flex items-center justify-between px-4 py-3 text-slate-500 hover:bg-slate-50 rounded-xl transition-all mt-1">
                <div class="flex items-center gap-3">
                    <i class="fa-brands fa-tiktok text-slate-900"></i>
                    <span class="font-semibold text-sm">TikTok</span>
                </div>
                <span class="w-2 h-2 bg-green-500 rounded-full"></span>
            </a>
        </div>
    </nav>
</aside>