<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - PlannerX</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <link rel="icon" type="image/png" sizes="32x32" href="https://i.ibb.co.com/F4pWPd0q/Desain-tanpa-judul-2.png">
    <link rel="icon" type="image/png" sizes="16x16" href="https://i.ibb.co.com/F4pWPd0q/Desain-tanpa-judul-2.png">
    <link rel="apple-touch-icon" href="https://i.ibb.co.com/F4pWPd0q/Desain-tanpa-judul-2.png">
    
    <style> body { font-family: 'Plus Jakarta Sans', sans-serif; } </style>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center p-4">

    <div class="max-w-md w-full bg-white rounded-[2.5rem] shadow-xl p-8 border border-slate-100">
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-indigo-50 rounded-2xl flex items-center justify-center text-indigo-600 text-2xl mx-auto mb-4">
                <i class="fa-solid fa-key"></i>
            </div>
            <h2 class="text-2xl font-black text-slate-800 tracking-tight">Lupa Password?</h2>
            <p class="text-sm text-slate-500 mt-2 font-medium">Masukkan email Anda yang terdaftar, kami akan mengirimkan link untuk mereset password Anda.</p>
        </div>

        @if (session('status'))
            <div class="bg-emerald-50 text-emerald-600 p-4 rounded-2xl text-sm font-bold border border-emerald-100 mb-6 flex items-center gap-3">
                <i class="fa-solid fa-circle-check text-lg"></i>
                {{ session('status') }}
            </div>
        @endif

        <form action="{{ route('password.email') }}" method="POST" class="space-y-5">
            @csrf
            
            <div>
                <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-widest mb-2">Alamat Email</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fa-regular fa-envelope text-slate-400"></i>
                    </div>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm font-bold rounded-2xl pl-11 pr-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all" 
                        placeholder="contoh@email.com">
                </div>
                @error('email')
                    <p class="text-rose-500 text-xs font-bold mt-2"><i class="fa-solid fa-circle-exclamation mr-1"></i> {{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="w-full py-3.5 bg-slate-900 hover:bg-slate-800 text-white rounded-2xl font-bold text-sm transition-all shadow-lg active:scale-95 flex justify-center items-center gap-2">
                Kirim Link Reset <i class="fa-solid fa-paper-plane"></i>
            </button>

            <div class="text-center mt-6">
                <a href="{{ route('login') }}" class="text-sm font-bold text-slate-400 hover:text-indigo-600 transition-colors">
                    <i class="fa-solid fa-arrow-left mr-1 text-xs"></i> Kembali ke Login
                </a>
            </div>
        </form>
    </div>

</body>
</html>