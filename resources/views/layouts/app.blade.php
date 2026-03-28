<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Content Planner')</title>
    
    <!-- Favicon -->
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><rect width='100' height='100' rx='20' fill='%234f46e5'/><text y='.9em' font-size='65' x='50%' dominant-baseline='middle' text-anchor='middle'>✏️</text></svg>">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');
        
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        [x-cloak] { display: none !important; }

        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }

        @keyframes scaleIn {
            from { opacity: 0; transform: scale(0.9); }
            to { opacity: 1; transform: scale(1); }
        }
        .animate-scaleIn {
            animation: scaleIn 0.2s ease-out;
        }
    </style>
</head>
<body class="bg-[#f8fafc] text-slate-800">

<div class="flex h-screen overflow-hidden">
    @include('layouts.sidebar')

    <div class="flex-1 flex flex-col overflow-y-auto">
        @include('layouts.navbar')

        <main class="p-4 md:p-8">
            @yield('content')
        </main>
    </div>
</div>

<!-- GLOBAL POPUP SYSTEM -->
<script>
const AppPopup = {
    createOverlay() {
        const overlay = document.createElement('div');
        overlay.className = 'fixed inset-0 z-[999] bg-black/40 backdrop-blur-sm flex items-center justify-center p-4';
        return overlay;
    },

    confirmDelete(title, message, onConfirm) {
        const overlay = this.createOverlay();

        overlay.innerHTML = `
            <div class="bg-white w-full max-w-sm rounded-2xl p-6 shadow-2xl text-center animate-scaleIn">
                <h2 class="text-lg font-bold text-slate-800 mb-2">${title}</h2>
                <p class="text-sm text-slate-500 mb-6">${message}</p>

                <div class="flex gap-3 justify-center">
                    <button id="cancelBtn" class="px-4 py-2 rounded-xl bg-slate-100 text-slate-600 font-semibold hover:bg-slate-200">
                        Batal
                    </button>
                    <button id="confirmBtn" class="px-4 py-2 rounded-xl bg-rose-500 text-white font-semibold hover:bg-rose-600">
                        Hapus
                    </button>
                </div>
            </div>
        `;

        document.body.appendChild(overlay);

        overlay.querySelector('#cancelBtn').onclick = () => overlay.remove();
        overlay.querySelector('#confirmBtn').onclick = () => {
            overlay.remove();
            onConfirm();
        };
    },

    success(title, message) {
        const overlay = this.createOverlay();

        overlay.innerHTML = `
            <div class="bg-white w-full max-w-sm rounded-2xl p-6 shadow-2xl text-center animate-scaleIn">
                <div class="text-emerald-500 text-3xl mb-2">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
                <h2 class="text-lg font-bold text-slate-800 mb-1">${title}</h2>
                <p class="text-sm text-slate-500">${message}</p>
            </div>
        `;

        document.body.appendChild(overlay);

        setTimeout(() => overlay.remove(), 1500);
    }
};
</script>

@stack('scripts')
</body>
</html>