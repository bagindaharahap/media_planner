<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'PlannerX')</title>
    <!-- Tailwind CSS & Font Awesome -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-[#f8fafc] text-slate-800">

    <div class="flex h-screen overflow-hidden">
        <!-- Memanggil Sidebar -->
        @include('layouts.sidebar')

        <div class="flex-1 flex flex-col overflow-y-auto">
            <!-- Memanggil Navbar -->
            @include('layouts.navbar')

            <!-- Area Konten Dinamis -->
            <main class="p-4 md:p-8">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Script tambahan per halaman -->
    @stack('scripts')
</body>
</html>