<!-- resources/views/layouts/sidebar.blade.php -->
<aside class="w-20 md:w-72 bg-white border-r border-slate-200 flex flex-col transition-all duration-300">
    <div class="p-4 md:p-8">
        <div class="flex items-center gap-2 text-indigo-600">
            <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center shrink-0 shadow-lg shadow-indigo-200 overflow-hidden">
                <img 
                    src="https://i.ibb.co.com/F4pWPd0q/Desain-tanpa-judul-2.png" 
                    alt="Logo" 
                    class="w-full h-full object-contain"
                >
            </div>
            <span class="text-xl font-black tracking-tighter hidden md:block">Content Planner</span>
        </div>
    </div>

    <!-- x-data ADDED: openPosts, showTerms, and showPrivacy -->
    <nav class="flex-1 px-3 md:px-6 space-y-2 mt-4 custom-scrollbar overflow-y-auto pb-4" x-data="{ openPosts: false, showTerms: false, showPrivacy: false }">
        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-4 mb-2 hidden md:block">Main</p>
        
        <a href="{{ route('dashboard') }}" class="flex items-center justify-center md:justify-start gap-3 px-4 py-3 {{ request()->routeIs('dashboard') ? 'bg-indigo-600 text-white shadow-md' : 'text-slate-500 hover:bg-slate-50' }} rounded-xl transition-all">
            <i class="fa-solid fa-layer-group text-lg md:text-sm"></i>
            <span class="font-semibold text-sm hidden md:block">Dashboard</span>
        </a>
        
        <!-- Content Schedule Dropdown Menu -->
        <div class="relative" @click.outside="openPosts = false">
            <button 
                @click="openPosts = !openPosts" 
                class="w-full flex items-center justify-center md:justify-start gap-3 px-4 py-3 rounded-xl transition-all focus:outline-none group"
                :class="openPosts ? 'bg-indigo-50 text-indigo-600' : 'text-slate-500 hover:bg-slate-50'"
            >
                <i class="fa-solid fa-calendar-check text-lg md:text-sm"></i>
                <span class="font-semibold text-sm hidden md:block flex-1 text-left">Content Schedule</span>
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
                    Calendar Notes
                </a>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- MENU: PROMPT NOTE                          -->
        <!-- ========================================== -->
        <a href="{{ route('prompt.index') }}" class="flex items-center justify-center md:justify-start gap-3 px-4 py-3 {{ request()->routeIs('prompt.index') ? 'bg-indigo-600 text-white shadow-md' : 'text-slate-500 hover:bg-slate-50' }} rounded-xl transition-all">
            <i class="fa-solid fa-pen-to-square text-lg md:text-sm"></i>
            <span class="font-semibold text-sm hidden md:block">Prompt Note</span>
        </a>

        <!-- ========================================== -->
        <!-- MENU: ACCOUNT MANAGEMENT (Admin Only)      -->
        <!-- ========================================== -->
        @if(Auth::check() && strtolower(Auth::user()->role) === 'admin')
            <a href="{{ route('users.index') }}" class="flex items-center justify-center md:justify-start gap-3 px-4 py-3 {{ request()->routeIs('users.index') ? 'bg-indigo-600 text-white shadow-md' : 'text-slate-500 hover:bg-slate-50' }} rounded-xl transition-all">
                <i class="fa-solid fa-users-gear text-lg md:text-sm"></i>
                <span class="font-semibold text-sm hidden md:block">Account Management</span>
            </a>
        @endif

        <!-- ========================================== -->
        <!-- MENU: ACTIVITY LOGS                        -->
        <!-- ========================================== -->
        <a href="{{ route('logs.index') }}" 
            class="flex items-center justify-center md:justify-start gap-3 px-4 py-3 
            {{ request()->routeIs('logs.index') ? 'bg-indigo-600 text-white shadow-md' : 'text-slate-500 hover:bg-slate-50' }} 
            rounded-xl transition-all">
                <i class="fa-solid fa-clock-rotate-left text-lg md:text-sm"></i>
                <span class="font-semibold text-sm hidden md:block">Activity Logs</span>
        </a>
        
        <!-- ========================================== -->
        <!-- MENU: SOCIAL MEDIA ACCOUNTS                -->
        <!-- ========================================== -->
        <div class="pt-6 hidden md:block">
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-4 mb-2">Social Accounts</p>
            <a href="{{ route('instagram.index') }}" class="flex items-center justify-between px-4 py-3 {{ request()->routeIs('instagram.index') ? 'bg-indigo-50 text-indigo-600 shadow-sm' : 'text-slate-500 hover:bg-slate-50' }} rounded-xl transition-all">
                <div class="flex items-center gap-3">
                    <i class="fa-brands fa-instagram text-pink-500"></i>
                    <span class="font-semibold text-sm">Instagram</span>
                </div>
                <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse shadow-sm" title="API Connected"></span>
            </a>
            <a href="{{ route('tiktok.index') }}" class="flex items-center justify-between px-4 py-3 {{ request()->routeIs('tiktok.index') ? 'bg-indigo-50 text-indigo-600 shadow-sm' : 'text-slate-500 hover:bg-slate-50' }} rounded-xl transition-all mt-1">
                <div class="flex items-center gap-3">
                    <i class="fa-brands fa-tiktok text-slate-900"></i>
                    <span class="font-semibold text-sm">TikTok</span>
                </div>
                <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse shadow-sm" title="API Connected"></span>
            </a>
        </div>

        <!-- ========================================== -->
        <!-- MENU: LEGAL & PRIVACY                      -->
        <!-- ========================================== -->
        <div class="pt-6">
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-4 mb-2 hidden md:block">Legal</p>
            
            <!-- Terms Modal Trigger Button -->
            <button type="button" @click="showTerms = true" class="w-full flex items-center justify-center md:justify-start gap-3 px-4 py-3 text-slate-500 hover:bg-slate-50 rounded-xl transition-all">
                <i class="fa-solid fa-file-contract text-lg md:text-sm"></i>
                <span class="font-semibold text-sm hidden md:block text-left">Terms & Conditions</span>
            </button>
            
            <!-- Privacy Modal Trigger Button -->
            <button type="button" @click="showPrivacy = true" class="w-full flex items-center justify-center md:justify-start gap-3 px-4 py-3 text-slate-500 hover:bg-slate-50 rounded-xl transition-all mt-1">
                <i class="fa-solid fa-shield text-lg md:text-sm"></i>
                <span class="font-semibold text-sm hidden md:block text-left">Privacy Policy</span>
            </button>

            <!-- Terms & Conditions Modal -->
            <template x-teleport="body">
                <div x-show="showTerms" x-cloak class="fixed inset-0 z-[9999] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
                     x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                     x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                    <div @click.outside="showTerms = false" class="bg-white w-full max-w-4xl max-h-[90vh] rounded-[2.5rem] shadow-2xl flex flex-col overflow-hidden border border-slate-200"
                         x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 scale-95 translate-y-8" x-transition:enter-end="opacity-100 scale-100 translate-y-0">
                        
                        <div class="px-8 py-6 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center text-white shadow-lg">
                                    <i class="fa-solid fa-file-contract"></i>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-slate-800 tracking-tight">Terms & Conditions</h3>
                                    <p class="text-xs text-slate-500 font-medium">Internal Company Policy</p>
                                </div>
                            </div>
                            <button @click="showTerms = false" class="w-10 h-10 rounded-full hover:bg-slate-200 flex items-center justify-center text-slate-400 transition-colors">
                                <i class="fa-solid fa-xmark text-xl"></i>
                            </button>
                        </div>

                        <div class="flex-1 overflow-y-auto p-8 text-sm text-slate-600 leading-relaxed custom-scrollbar">
                            <!-- Including content components -->
                            @include('terms')
                        </div>
                    </div>
                </div>
            </template>

            <!-- Privacy Policy Modal -->
            <template x-teleport="body">
                <div x-show="showPrivacy" x-cloak class="fixed inset-0 z-[9999] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
                     x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                     x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                    <div @click.outside="showPrivacy = false" class="bg-white w-full max-w-4xl max-h-[90vh] rounded-[2.5rem] shadow-2xl flex flex-col overflow-hidden border border-slate-200"
                         x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 scale-95 translate-y-8" x-transition:enter-end="opacity-100 scale-100 translate-y-0">
                        
                        <div class="px-8 py-6 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center text-white shadow-lg">
                                    <i class="fa-solid fa-shield text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-slate-800 tracking-tight">Privacy Policy</h3>
                                    <p class="text-xs text-slate-500 font-medium">Internal Company Policy</p>
                                </div>
                            </div>
                            <button @click="showPrivacy = false" class="w-10 h-10 rounded-full hover:bg-slate-200 flex items-center justify-center text-slate-400 transition-colors">
                                <i class="fa-solid fa-xmark text-xl"></i>
                            </button>
                        </div>

                        <div class="flex-1 overflow-y-auto p-8 text-sm text-slate-600 leading-relaxed custom-scrollbar">
                            <!-- Including content components -->
                            @include('privacy')
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </nav>

    <!-- User Info & Logout Section -->
    <div class="p-3 md:p-6 border-t border-slate-200 mt-auto shrink-0">
        <div class="hidden md:block">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center text-white font-bold text-sm uppercase">
                    {{ substr(Auth::user()->name ?? 'U', 0, 2) }}
                </div>
                <div class="flex-1">
                    <p class="font-bold text-sm text-slate-800">{{ Auth::user()->name ?? 'User' }}</p>
                    <p class="text-xs text-slate-500">{{ Auth::user()->role ?? 'Role' }}</p>
                </div>
            </div>
        </div>
        
        <!-- Logout Button -->
        <form action="{{ route('logout') }}" method="POST" class="w-full">
            @csrf
            <button type="submit" class="w-full flex items-center justify-center md:justify-start gap-3 px-4 py-3 text-red-500 hover:bg-red-50 rounded-xl transition-all">
                <i class="fa-solid fa-arrow-right-from-bracket text-lg md:text-sm"></i>
                <span class="font-semibold text-sm hidden md:block">Logout</span>
            </button>
        </form>
    </div>
</aside>