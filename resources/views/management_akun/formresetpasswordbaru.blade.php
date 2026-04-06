<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Password Baru - PlannerX</title>
    
    <!-- HANYA MENGGUNAKAN CDN TAILWIND (TANPA VITE) -->
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
            <div class="w-16 h-16 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-600 text-2xl mx-auto mb-4">
                <i class="fa-solid fa-unlock-keyhole"></i>
            </div>
            <h2 class="text-2xl font-black text-slate-800 tracking-tight">Buat Password Baru</h2>
            <p class="text-sm text-slate-500 mt-2 font-medium">Silakan buat password baru untuk akun Anda.</p>
        </div>

        <form action="{{ route('password.update') }}" method="POST" class="space-y-5">
            @csrf
            <!-- Token dari email -->
            <input type="hidden" name="token" value="{{ $token }}">

            <!-- Email (readonly) -->
            <div>
                <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-widest mb-2">Alamat Email</label>
                <input type="email" name="email" value="{{ $email ?? old('email') }}" readonly
                    class="w-full bg-slate-100 border border-slate-200 text-slate-500 text-sm font-bold rounded-2xl px-4 py-3 cursor-not-allowed">
                @error('email') <p class="text-rose-500 text-xs font-bold mt-2">{{ $message }}</p> @enderror
            </div>

            <!-- Password Baru -->
            <div>
                <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-widest mb-2">Password Baru</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fa-solid fa-lock text-slate-400"></i>
                    </div>
                    <input type="password" name="password" required autofocus
                        class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm font-bold rounded-2xl pl-11 pr-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all" 
                        placeholder="Minimal 6 karakter">
                </div>
                @error('password') <p class="text-rose-500 text-xs font-bold mt-2">{{ $message }}</p> @enderror
            </div>

            <!-- Konfirmasi Password -->
            <div>
                <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-widest mb-2">Ulangi Password</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fa-solid fa-lock text-slate-400"></i>
                    </div>
                    <input type="password" name="password_confirmation" required
                        class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm font-bold rounded-2xl pl-11 pr-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all" 
                        placeholder="Ketik ulang password">
                </div>
            </div>

            <button type="submit" class="w-full mt-4 py-3.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl font-bold text-sm transition-all shadow-lg shadow-indigo-500/30 active:scale-95 flex justify-center items-center gap-2">
                Simpan Password Baru <i class="fa-solid fa-check"></i>
            </button>
        </form>
    </div>

</body>
</html>