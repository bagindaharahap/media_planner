<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Content Planner</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 flex items-center justify-center min-h-screen py-12 px-4 relative overflow-x-hidden">

    <!-- Dekorasi Background -->
    <div class="absolute -top-[20%] -left-[10%] w-[50%] h-[50%] bg-indigo-500/20 rounded-full blur-[120px] pointer-events-none"></div>
    <div class="absolute -bottom-[20%] -right-[10%] w-[50%] h-[50%] bg-pink-500/20 rounded-full blur-[120px] pointer-events-none"></div>

    <div class="w-full max-w-[1000px] bg-white rounded-[2.5rem] shadow-2xl border border-slate-100 flex flex-col md:flex-row overflow-hidden relative z-10 min-h-[600px]">
        
        <div class="w-full md:w-1/2 bg-indigo-600 p-12 text-white flex flex-col justify-between relative overflow-hidden hidden md:flex">
            <div class="absolute -top-24 -right-24 w-64 h-64 bg-white/10 rounded-full blur-2xl"></div>
            <div class="absolute -bottom-24 -left-24 w-64 h-64 bg-black/10 rounded-full blur-2xl"></div>

            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-16">
                    <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-indigo-600 shadow-lg">
                        <i class="fa-solid fa-rocket text-xl"></i>
                    </div>
                    <span class="text-2xl font-black tracking-tighter">Content Planner</span>
                </div>

                <div>
                    <h2 class="text-4xl font-extrabold leading-tight mb-4">Selamat Datang <br>Kembali!</h2>
                    <p class="text-indigo-200 text-sm leading-relaxed">Akses dasbor Anda untuk mulai mengatur jadwal dan melihat performa konten terbaru tim Anda.</p>
                </div>
            </div>

            <!--<div class="relative z-10 mt-12">-->
            <!--    <div class="flex -space-x-3 mb-4">-->
            <!--        <img class="w-10 h-10 rounded-full border-2 border-indigo-600" src="https://i.pravatar.cc/100?img=1" alt="User 1">-->
            <!--        <img class="w-10 h-10 rounded-full border-2 border-indigo-600" src="https://i.pravatar.cc/100?img=2" alt="User 2">-->
            <!--        <img class="w-10 h-10 rounded-full border-2 border-indigo-600" src="https://i.pravatar.cc/100?img=3" alt="User 3">-->
            <!--        <div class="w-10 h-10 rounded-full border-2 border-indigo-600 bg-white text-indigo-600 flex items-center justify-center text-xs font-bold">+2k</div>-->
            <!--    </div>-->
            <!--    <p class="text-xs font-medium text-indigo-200">Dipercaya oleh kreator profesional.</p>-->
            <!--</div>-->
        </div>

        <div class="w-full md:w-1/2 p-8 md:p-12 relative flex flex-col justify-center">
            
            <div class="flex items-center gap-3 mb-10 md:hidden justify-center">
                <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center text-white shadow-lg">
                    <i class="fa-solid fa-rocket text-xl"></i>
                </div>
                <span class="text-2xl font-black tracking-tighter text-indigo-600">Content Planner</span>
            </div>

            <div class="mb-8 text-center md:text-left">
                <h3 class="text-2xl font-bold text-slate-800">Pilih Akun</h3>
                <p class="text-slate-500 text-sm mt-1">Pilih akun Anda untuk masuk secara otomatis.</p>
            </div>

            <!-- Tampilkan error jika ada masalah saat login -->
            @if ($errors->any())
                <div class="bg-rose-50 border border-rose-200 text-rose-600 px-4 py-3 rounded-2xl mb-6 text-sm">
                    <ul class="list-disc list-inside font-semibold">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="space-y-3">
                @php
                    // Mengambil user langsung dari DB untuk tampilan ini
                    $users = \App\Models\User::where('status', 'Aktif')->get();
                @endphp

                @foreach($users as $user)
                <a href="{{ route('login.as', $user->id) }}" 
                   class="flex items-center justify-between p-4 bg-white border border-slate-200 rounded-2xl hover:border-indigo-500 hover:shadow-md transition-all group">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 font-bold group-hover:bg-indigo-50 group-hover:text-indigo-600 transition-colors">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="text-sm font-bold text-slate-800">{{ $user->name }}</p>
                            <span class="text-[10px] px-2 py-0.5 rounded-md uppercase font-black tracking-wider 
                                {{ $user->role === 'admin' || $user->role === 'Admin' ? 'bg-rose-50 text-rose-600' : 'bg-blue-50 text-blue-600' }}">
                                {{ $user->role }}
                            </span>
                        </div>
                    </div>
                    <i class="fa-solid fa-chevron-right text-slate-300 group-hover:text-indigo-500 transition-colors"></i>
                </a>
                @endforeach
            </div>

            <div class="mt-8 text-center mb-8">
                <p class="text-xs font-bold text-slate-500">Butuh akses baru? <a href="https://wa.link/ede8ni" class="text-indigo-600 hover:underline">Hubungi Admin Anda</a></p>
            </div>

            <div class="mt-auto text-center space-y-4 pt-4 border-t border-slate-100">
                <div class="flex items-center justify-center gap-4 text-xs font-bold text-slate-400">
                    <a href="{{ route('terms') }}" class="hover:text-indigo-600 transition-colors uppercase tracking-widest">Terms & Conditions</a>
                    <span class="w-1 h-1 bg-slate-300 rounded-full"></span>
                    <a href="{{ route('privacy') }}" class="hover:text-indigo-600 transition-colors uppercase tracking-widest">Privacy Policy</a>
                </div>
                <p class="text-[10px] text-slate-400 font-medium italic">
                    Aplikasi ini sedang dalam tahap pengajuan API TikTok & Facebook.
                </p>
            </div>

        </div>
    </div>
</body>
</html>