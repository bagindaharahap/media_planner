<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Content Planner</title>
    
    <!-- Tailwind CSS & Font Awesome -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <!-- Alpine.js (Hanya untuk Toggle Password) -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 flex items-center justify-center min-h-screen p-4 relative overflow-hidden">

    <!-- Dekorasi Background -->
    <div class="absolute -top-[20%] -left-[10%] w-[50%] h-[50%] bg-indigo-500/20 rounded-full blur-[120px] pointer-events-none"></div>
    <div class="absolute -bottom-[20%] -right-[10%] w-[50%] h-[50%] bg-pink-500/20 rounded-full blur-[120px] pointer-events-none"></div>

    <!-- Container Utama -->
    <div class="w-full max-w-[1000px] bg-white rounded-[2.5rem] shadow-2xl border border-slate-100 flex flex-col md:flex-row overflow-hidden relative z-10 min-h-[600px]">
        
        <!-- BAGIAN KIRI: Visual / Branding -->
        <div class="w-full md:w-1/2 bg-indigo-600 p-12 text-white flex flex-col justify-between relative overflow-hidden hidden md:flex">
            <!-- Dekorasi Lingkaran Dalam -->
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

            <div class="relative z-10 mt-12">
                <div class="flex -space-x-3 mb-4">
                    <img class="w-10 h-10 rounded-full border-2 border-indigo-600" src="https://i.pravatar.cc/100?img=1" alt="User 1">
                    <img class="w-10 h-10 rounded-full border-2 border-indigo-600" src="https://i.pravatar.cc/100?img=2" alt="User 2">
                    <img class="w-10 h-10 rounded-full border-2 border-indigo-600" src="https://i.pravatar.cc/100?img=3" alt="User 3">
                    <div class="w-10 h-10 rounded-full border-2 border-indigo-600 bg-white text-indigo-600 flex items-center justify-center text-xs font-bold">+2k</div>
                </div>
                <p class="text-xs font-medium text-indigo-200">Dipercaya oleh kreator profesional.</p>
            </div>
        </div>

        <!-- BAGIAN KANAN: Area Form Login -->
        <div class="w-full md:w-1/2 p-8 md:p-12 relative flex flex-col justify-center">
            
            <!-- Mobile Branding (Tampil Hanya di HP) -->
            <div class="flex items-center gap-3 mb-10 md:hidden justify-center">
                <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center text-white shadow-lg">
                    <i class="fa-solid fa-rocket text-xl"></i>
                </div>
                <span class="text-2xl font-black tracking-tighter text-indigo-600">Content Planner</span>
            </div>

            <!-- Teks Header Form (Desktop) -->
            <div class="mb-8 text-center md:text-left hidden md:block">
                <h3 class="text-2xl font-bold text-slate-800">Masuk ke Akun</h3>
                <p class="text-slate-500 text-sm mt-1">Silakan masukkan kredensial yang diberikan oleh Admin.</p>
            </div>

            <!-- Tampilkan Error Validasi Laravel Jika Ada -->
            @if ($errors->any())
                <div class="bg-rose-50 border border-rose-200 text-rose-600 px-4 py-3 rounded-2xl mb-6 text-sm">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Tampilkan Sukses (Misal habis di-reset password) Jika Ada -->
            @if(session('status'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-600 px-4 py-3 rounded-2xl mb-6 text-sm font-bold flex items-center gap-2">
                    <i class="fa-solid fa-check-circle"></i>
                    {{ session('status') }}
                </div>
            @endif

            <!-- ======================= -->
            <!-- FORM LOGIN SAJA -->
            <!-- ======================= -->
            <form action="{{ route('login') }}" method="POST" class="space-y-5">
                @csrf
                
                <div class="space-y-2">
                    <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Alamat Email</label>
                    <div class="relative">
                        <i class="fa-solid fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                        <input type="email" name="email" required placeholder="nama@email.com" class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-11 pr-4 py-3.5 text-sm font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500 outline-none transition-all">
                    </div>
                </div>

                <div class="space-y-2">
                    <div class="flex items-center justify-between ml-1">
                        <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest">Kata Sandi</label>
                        <a href="#" onclick="alert('Silakan hubungi Administrator untuk mereset kata sandi Anda.')" class="text-[11px] font-bold text-indigo-600 hover:text-indigo-700">Lupa Sandi?</a>
                    </div>
                    <!-- Alpine.js untuk fitur Show/Hide Password -->
                    <div class="relative" x-data="{ show: false }">
                        <i class="fa-solid fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                        <input :type="show ? 'text' : 'password'" name="password" required placeholder="••••••••" class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-11 pr-12 py-3.5 text-sm font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500 outline-none transition-all">
                        <button type="button" @click="show = !show" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-indigo-600">
                            <i class="fa-solid" :class="show ? 'fa-eye-slash' : 'fa-eye'"></i>
                        </button>
                    </div>
                </div>

                <div class="flex items-center gap-2 mt-2">
                    <input type="checkbox" name="remember" id="remember" class="w-4 h-4 text-indigo-600 rounded border-slate-300 focus:ring-indigo-500">
                    <label for="remember" class="text-xs font-bold text-slate-600 cursor-pointer">Ingat Saya</label>
                </div>

                <button type="submit" class="w-full bg-indigo-600 text-white py-4 rounded-xl font-bold shadow-xl shadow-indigo-100 hover:bg-indigo-700 transform active:scale-95 transition-all mt-6">
                    Masuk ke Dasbor
                </button>
            </form>

            <div class="mt-8 text-center">
                <p class="text-xs font-bold text-slate-500">Butuh akses? <a href="#" class="text-indigo-600 hover:underline">Hubungi Admin Anda</a></p>
            </div>

        </div>
    </div>
</body>
</html>