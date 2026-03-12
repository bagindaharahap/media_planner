<!-- resources/views/layouts/navbar.blade.php -->
<header class="h-20 bg-white/80 backdrop-blur-md border-b border-slate-200 px-8 flex items-center justify-between sticky top-0 z-10">
    <div class="flex items-center gap-4">
        <h2 class="font-bold text-lg hidden sm:block">Selamat Datang, Admin</h2>
    </div>
    
    <div class="flex items-center gap-6">
        <div class="relative cursor-pointer">
            <i class="fa-solid fa-bell text-slate-400"></i>
            <span class="absolute -top-1 -right-1 w-2 h-2 bg-red-500 rounded-full"></span>
        </div>
        <div class="flex items-center gap-3 border-l border-slate-200 pl-6">
            <div class="text-right hidden sm:block">
                <p class="text-xs font-bold text-slate-800">Media Planner</p>
                <p class="text-[10px] text-green-500 font-medium">Aktif</p>
            </div>
            <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold">
                MP
            </div>
        </div>
    </div>
</header>