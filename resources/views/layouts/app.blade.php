    <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title', 'PlannerX')</title>
        
        <!-- Tailwind CSS & Font Awesome -->
        <script src="https://cdn.tailwindcss.com"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
        
        <!-- Alpine.js (Diperlukan untuk Dropdown Sidebar) -->
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');
            
            body { 
                font-family: 'Plus Jakarta Sans', sans-serif; 
            }

            /* x-cloak mencegah elemen Alpine muncul sebelum script dimuat sepenuhnya */
            [x-cloak] { 
                display: none !important; 
            }

            /* Kustomisasi Scrollbar untuk tampilan lebih bersih */
            ::-webkit-scrollbar { width: 5px; }
            ::-webkit-scrollbar-track { background: #f1f5f9; }
            ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        </style>
    </head>
    <body class="bg-[#f8fafc] text-slate-800">

        <div class="flex h-screen overflow-hidden">
            <!-- Memanggil komponen Sidebar -->
            @include('layouts.sidebar')

            <div class="flex-1 flex flex-col overflow-y-auto">
                <!-- Memanggil komponen Navbar -->
                @include('layouts.navbar')

                <!-- Area Konten Dinamis yang diisi oleh child views -->
                <main class="p-4 md:p-8">
                    @yield('content')
                </main>
            </div>
        </div>

        <!-- Tempat script tambahan khusus untuk halaman tertentu -->
        @stack('scripts')
    </body>
    </html>