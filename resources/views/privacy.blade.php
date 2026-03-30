<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kebijakan Privasi - Content Planner</title>
    
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
                <!-- PERBAIKAN IKON DI SINI -->
                <i class="fa-solid fa-shield"></i>
            </div>
            <h1 class="text-3xl md:text-4xl font-black text-slate-900 mb-3 tracking-tight">Kebijakan Privasi (Privacy Policy)</h1>
            <p class="text-slate-500 font-medium text-sm">Terakhir Diperbarui: <span class="text-slate-700 font-bold">30 Maret 2026</span></p>
        </div>

        <!-- Konten Privasi (Versi Internal Perusahaan) -->
        <div class="space-y-8 text-slate-600 leading-relaxed text-sm md:text-base">
            <p>Sistem internal <strong>Content Planner</strong> dikelola secara eksklusif untuk kebutuhan operasional perusahaan. Kebijakan Privasi internal ini menjelaskan bagaimana data Anda sebagai karyawan ("Pengguna") dan data aset perusahaan diproses di dalam sistem, termasuk saat terhubung dengan layanan API pihak ketiga (TikTok & Facebook).</p>

            <div>
                <h2 class="text-lg font-bold text-slate-800 mb-3 flex items-center gap-2"><i class="fa-solid fa-database text-indigo-500"></i> 1. Informasi yang Kami Kelola</h2>
                <p class="mb-2">Sistem ini mengelola informasi berikut untuk memfasilitasi pekerjaan Anda:</p>
                <ul class="list-disc list-outside pl-5 space-y-2">
                    <li><strong class="text-slate-700">Data Karyawan (Akun):</strong> Nama, alamat email perusahaan, kata sandi terenkripsi, dan hak akses (role) yang diberikan oleh Administrator/Tim IT.</li>
                    <li><strong class="text-slate-700">Data Operasional:</strong> Draf konten, jadwal kalender kerja, dan <em>Prompt Notes</em> yang Anda kerjakan di dalam sistem ini adalah sepenuhnya milik perusahaan.</li>
                    <li><strong class="text-slate-700">Akses API Pihak Ketiga:</strong> <em>OAuth Access Tokens</em> dari media sosial resmi perusahaan untuk keperluan penjadwalan konten dan penarikan analitik secara otomatis.</li>
                </ul>
            </div>

            <div>
                <h2 class="text-lg font-bold text-slate-800 mb-3 flex items-center gap-2"><i class="fa-solid fa-cloud-arrow-down text-indigo-500"></i> 2. Penggunaan Data API (TikTok & Meta)</h2>
                <p class="mb-2">Sistem mematuhi kebijakan pengembang dari platform TikTok dan Meta (Facebook) demi keamanan aset digital perusahaan:</p>
                <ul class="list-disc list-outside pl-5 space-y-2">
                    <li><strong class="text-slate-700">Akses Terbatas:</strong> Sistem hanya menggunakan token Anda (saat menautkan akun media sosial perusahaan) untuk menjalankan fungsi otomatisasi posting dan merekap data statistik audiens.</li>
                    <li><strong class="text-slate-700">Penyimpanan Aman:</strong> Token akses dan *cookies* integrasi disimpan secara aman di dalam database internal. Tidak ada informasi pribadi yang tidak terkait operasional yang ditarik dari platform sosial media tersebut.</li>
                </ul>
            </div>

            <div>
                <h2 class="text-lg font-bold text-slate-800 mb-3 flex items-center gap-2"><i class="fa-solid fa-lock text-indigo-500"></i> 3. Perlindungan & Kerahasiaan Data</h2>
                <ul class="list-disc list-outside pl-5 space-y-2">
                    <li><strong class="text-slate-700">Infrastruktur Aman:</strong> Seluruh identitas login karyawan diamankan menggunakan standar enkripsi dan sistem berada di lingkungan jaringan yang terkendali.</li>
                    <li><strong class="text-slate-700">Non-Disclosure Agreement (NDA):</strong> Sesuai dengan kontrak kerja, segala bentuk analitik performa akun, strategi marketing, maupun informasi sensitif lain yang tampil di dalam sistem ini bersifat rahasia dan dilarang untuk disebarluaskan ke pihak eksternal/kompetitor.</li>
                </ul>
            </div>

            <div>
                <h2 class="text-lg font-bold text-slate-800 mb-3 flex items-center gap-2"><i class="fa-solid fa-user-gear text-indigo-500"></i> 4. Kontrol dan Retensi Data Karyawan</h2>
                <ul class="list-disc list-outside pl-5 space-y-2">
                    <li><strong class="text-slate-700">Manajemen Hak Akses:</strong> Sebagai pengguna internal, Anda tidak dapat secara sepihak meminta sistem untuk menghapus akun (<em>Self-Deletion</em>). Hak tersebut ada pada Tim IT dan HR menyesuaikan dengan status kepegawaian Anda.</li>
                    <li><strong class="text-slate-700">Pengalihan Data:</strong> Jika status Anda sebagai anggota tim dinonaktifkan (mutasi atau *resign*), seluruh rencana kerja dan *Board Planning* yang sudah Anda susun akan tetap tersimpan dalam sistem agar dapat dilanjutkan oleh karyawan penerus.</li>
                </ul>
            </div>

            <div>
                <h2 class="text-lg font-bold text-slate-800 mb-3 flex items-center gap-2"><i class="fa-solid fa-envelope text-indigo-500"></i> 5. Dukungan Teknis Internal</h2>
                <p class="mb-2">Jika Anda memiliki kendala teknis terkait akun atau mengidentifikasi aktivitas mencurigakan pada akses API, segera hubungi tim terkait melalui:</p>
                <div class="bg-slate-50 p-4 rounded-xl inline-block border border-slate-100 mt-2">
                    <p><strong class="text-slate-700">Email IT/Admin:</strong> <a href="ikhtiarberkah1010@gmail.com" class="text-indigo-600 hover:underline">ikhtiarberkah1010@gmail.com</a></p>
                    <p><strong class="text-slate-700">Bantuan Karyawan:</strong> <a href="https://wa.link/ede8ni" class="text-indigo-600 hover:underline">Whatsapp Admin</a></p>
                </div>
            </div>
        </div>

        <div class="mt-12 pt-8 border-t border-slate-100 text-center">
            <p class="text-xs text-slate-400 font-medium">&copy; {{ date('Y') }} Content Planner (Internal System). Hak Cipta Dilindungi Undang-Undang.</p>
        </div>
    </div>
</body>
</html>