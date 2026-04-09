<!-- resources/views/layouts/navbar.blade.php -->
@php
    $user = Auth::user();
    $notifications = $user ? $user->notifications()->latest()->take(10)->get() : collect();
    $unreadCount = $user ? $user->unreadNotifications()->count() : 0;
@endphp

<header class="h-100 bg-white/80 backdrop-blur-md border-b border-slate-200 px-8 lg:px-10 flex items-center justify-between sticky top-0 z-30 transition-all">
    
    <!-- Left Side: Greeting & Date -->
    <div class="flex flex-col justify-center gap-1">
        <h2 class="font-extrabold text-xl text-slate-800 hidden sm:block leading-tight">Welcome, {{ $user->name ?? 'User' }} 👋</h2>
        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest hidden md:block">
            <i class="fa-regular fa-calendar text-[10px] mr-1"></i> {{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y') }}
        </p>
    </div>

    <!-- Right Side: Actions & User Profile -->
    <div class="flex items-center gap-5 sm:gap-8 shrink-0">

        <!-- Notification Button -->
        <div class="relative" x-data="{ openNotif: false }" @click.outside="openNotif = false">
            <button @click="openNotif = !openNotif" class="relative w-10 h-10 bg-white rounded-full flex items-center justify-center text-slate-500 hover:text-indigo-600 hover:bg-indigo-50 transition-all border border-slate-200 shadow-sm">
                <i class="fa-regular fa-bell text-lg"></i>
                @if($unreadCount > 0)
                    <span class="absolute top-2 right-2 w-2.5 h-2.5 bg-rose-500 rounded-full border-2 border-white animate-pulse"></span>
                @endif
            </button>

            <!-- Notification Dropdown -->
            <div x-show="openNotif" x-cloak x-transition class="absolute right-0 mt-3 w-80 bg-white rounded-2xl shadow-xl border border-slate-100 overflow-hidden z-50">
                <div class="px-5 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                    <h3 class="font-bold text-slate-800 text-sm">Notifications</h3>
                    <form method="POST" action="{{ route('notifications.readAll') }}">
                        @csrf
                        <button type="submit" class="text-[10px] text-indigo-600 font-bold hover:underline">Mark all as read</button>
                    </form>
                </div>
                
                <div class="max-h-[300px] overflow-y-auto divide-y divide-slate-50 custom-scrollbar">
                    @forelse($notifications as $notification)
                        @php
                            $data = $notification->data ?? [];
                            $type = $data['type'] ?? 'info';
                            $title = $data['title'] ?? 'Notification';
                            $message = $data['message'] ?? '';
                            $url = $data['url'] ?? '#';
                            $color = match($type) {
                                'success' => 'bg-emerald-100 text-emerald-600',
                                'warning' => 'bg-amber-100 text-amber-600',
                                'error' => 'bg-rose-100 text-rose-600',
                                default => 'bg-blue-100 text-blue-600',
                            };
                        @endphp
                        <a href="{{ $url }}" class="p-4 flex items-start gap-4 hover:bg-slate-50 transition-colors cursor-pointer {{ $notification->read_at ? '' : 'bg-indigo-50/30' }}">
                            <div class="w-8 h-8 rounded-full {{ $color }} flex items-center justify-center shrink-0 mt-1">
                                <i class="fa-solid fa-bell text-[10px]"></i>
                            </div>
                            <div>
                                <p class="text-xs text-slate-800 font-bold mb-1">{{ $title }}</p>
                                <p class="text-[11px] text-slate-500 line-clamp-2">{{ $message }}</p>
                                <p class="text-[9px] text-slate-400 font-semibold mt-2">{{ $notification->created_at->diffForHumans() }}</p>
                            </div>
                        </a>
                    @empty
                        <div class="p-4 text-sm text-slate-500">Belum ada notifikasi.</div>
                    @endforelse
                </div>
                <a href="{{ route('notifications.index') }}" class="block px-5 py-3 text-center text-xs font-bold text-slate-500 bg-slate-50 hover:text-indigo-600 hover:bg-indigo-50 transition-all border-t border-slate-100">
                    View All Notifications
                </a>
            </div>
        </div>
        
        <!-- Profile Area (Optional/Commented) -->
        <!-- <div class="flex items-center gap-4 pl-5 sm:pl-8 border-l border-slate-200 cursor-pointer group">
            <div class="text-right hidden sm:block">
                <p class="text-sm font-bold text-slate-800 group-hover:text-indigo-600 transition-colors">Media Planner</p>
                <p class="text-[10px] text-emerald-500 font-black uppercase tracking-widest mt-0.5 flex items-center justify-end gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span> Active
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
