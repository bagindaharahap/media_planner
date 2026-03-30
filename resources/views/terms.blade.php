<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Syarat dan Ketentuan - Content Planner</title>
    
    <!-- Favicon (sama dengan layout utama) -->
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><rect width='100' height='100' rx='20' fill='%234f46e5'/><text y='.9em' font-size='65' x='50%' dominant-baseline='middle' text-anchor='middle'>✏️</text></svg>">
    
    <!-- Tailwind CSS & Font Awesome -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen p-4 md:p-10 relative overflow-x-hidden">

    <!-- Dekorasi Background -->
    <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-indigo-500/10 rounded-full blur-[100px] pointer-events-none"></div>
    <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-pink-500/10 rounded-full blur-[100px] pointer-events-none"></div>

    <div class="max-w-4xl mx-auto bg-white rounded-[2.5rem] shadow-xl border border-slate-100 p-8 md:p-14 relative z-10">
        
        <!-- Tombol Kembali -->
        <a href="{{ route('login') }}" class="inline-flex items-center gap-2 text-sm font-bold text-indigo-600 bg-indigo-50 px-4 py-2 rounded-xl hover:bg-indigo-100 transition-colors mb-8">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>

        <!-- Header -->
        <div class="mb-10 pb-8 border-b border-slate-100">
            <div class="w-12 h-12 bg-indigo-600 rounded-xl flex items-center justify-center text-white text-xl shadow-lg mb-6">
                <i class="fa-solid fa-file-contract"></i>
            </div>
            <h1 class="text-3xl md:text-4xl font-black text-slate-900 mb-3 tracking-tight">Syarat dan Ketentuan (Terms and Conditions)</h1>
            <p class="text-slate-500 font-medium text-sm">Terakhir Diperbarui: <span class="text-slate-700 font-bold">30 Maret 2026</span></p>
        </div>

        <!-- Konten Terms (Disesuaikan untuk Internal Perusahaan) -->
        <div class="space-y-8 text-slate-600 leading-relaxed text-sm md:text-base">
            <p>Selamat datang di sistem internal <strong>Content Planner</strong>. Dengan mengakses dan menggunakan platform ini, Anda sebagai karyawan atau anggota tim dianggap telah membaca, memahami, dan menyetujui pedoman penggunaan internal perusahaan berikut.</p>

            <div>
                <h2 class="text-lg font-bold text-slate-800 mb-3">1. Deskripsi Layanan</h2>
                <p class="mb-2">Sistem ini adalah platform produktivitas internal yang dirancang untuk mendukung operasional divisi Content dan Digital Marketing perusahaan melalui fitur:</p>
                <ul class="list-disc list-outside pl-5 space-y-2">
                    <li><strong class="text-slate-700">Board Planning:</strong> Pengaturan jadwal, kolaborasi tim, dan visualisasi aset konten perusahaan.</li>
                    <li><strong class="text-slate-700">Prompt Notes:</strong> Penyimpanan instruksi AI standar operasi (SOP) untuk kreasi konten.</li>
                    <li><strong class="text-slate-700">Calendar & Notes:</strong> Kalender editorial, integrasi jadwal kerja, dan catatan harian.</li>
                </ul>
            </div>

            <div>
                <h2 class="text-lg font-bold text-slate-800 mb-3">2. Akses dan Penggunaan Akun</h2>
                <ul class="list-disc list-outside pl-5 space-y-2">
                    <li>Akun akses dibuat dan diberikan secara eksklusif oleh pihak Administrator atau Tim IT Perusahaan.</li>
                    <li>Anda diwajibkan untuk menjaga kerahasiaan data login Anda dan <strong>dilarang keras membagikan akses</strong> kepada pihak eksternal.</li>
                    <li>Hak akses ke sistem ini akan ditutup atau dicabut saat Anda tidak lagi bertugas di divisi terkait atau telah berhenti menjadi karyawan perusahaan.</li>
                </ul>
            </div>

            <div>
                <h2 class="text-lg font-bold text-slate-800 mb-3">3. Penggunaan Integrasi API (TikTok & Facebook)</h2>
                <p class="mb-2">Guna mempercepat proses publikasi dan penarikan data analisis aset digital perusahaan, sistem ini terhubung dengan API resmi dari TikTok (TikTok for Developers) dan Meta (Facebook for Developers). Oleh karena itu:</p>
                <ul class="list-disc list-outside pl-5 space-y-2">
                    <li>Pemberian akses *OAuth token* hanya boleh dilakukan menggunakan akun media sosial resmi milik perusahaan atau entitas yang dinaunginya.</li>
                    <li>Penggunaan fungsi dari integrasi ini sepenuhnya tunduk pada Kebijakan Pengembang (Developer Policies) dan Syarat Layanan masing-masing platform (Meta & TikTok).</li>
                    <li>Token akses dijaga oleh sistem internal kami, namun Anda bertanggung jawab untuk tidak melakukan aktivitas spam atau pelanggaran komunitas yang bisa membahayakan reputasi akun sosial media perusahaan.</li>
                </ul>
            </div>

            <div>
                <h2 class="text-lg font-bold text-slate-800 mb-3">4. Kepemilikan Data & Kerahasiaan Informasi (Confidentiality)</h2>
                <ul class="list-disc list-outside pl-5 space-y-2">
                    <li><strong>Hak Milik Perusahaan:</strong> Segala bentuk data, draf konten, jadwal promosi, strategi pemasaran, dan template prompt yang dimasukkan atau dihasilkan di dalam platform ini adalah kekayaan intelektual (IP) milik perusahaan secara eksklusif.</li>
                    <li><strong>Kerahasiaan (NDA):</strong> Anda tidak diperkenankan mengunduh, menyebarkan, atau membocorkan data perencanaan operasional apa pun yang terdapat di platform ini kepada kompetitor, media luar, atau pihak lain di luar perusahaan.</li>
                </ul>
            </div>

            <div>
                <h2 class="text-lg font-bold text-slate-800 mb-3">5. Sanksi Pelanggaran</h2>
                <p class="mb-2">Sistem ini memantau aktivitas pengguna melalui riwayat log (activity logging). Setiap bentuk penyalahgunaan sistem, pembocoran data, atau penggunaan fitur yang merugikan perusahaan dapat mengakibatkan:</p>
                <ul class="list-disc list-outside pl-5 space-y-2">
                    <li>Pemblokiran akun secara langsung.</li>
                    <li>Pemberian sanksi indisipliner sesuai dengan peraturan dan kebijakan (SOP) HR perusahaan.</li>
                    <li>Tindakan hukum lebih lanjut jika pelanggaran berdampak material pada perusahaan.</li>
                </ul>
            </div>
        </div>

        <div class="mt-12 pt-8 border-t border-slate-100 text-center">
            <p class="text-xs text-slate-400 font-medium">&copy; {{ date('Y') }} Content Planner (Internal System). Hak Cipta Dilindungi Undang-Undang.</p>
        </div>
    </div>
</body>
</html>