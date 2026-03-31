<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Privacy Policy - Content Planner</title>
    
    <!-- Favicon -->
    <link rel="icon" href="https://i.ibb.co.com/F4pWPd0q/Desain-tanpa-judul-2.png">
    
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
            <i class="fa-solid fa-arrow-left"></i> Kembali / Back
        </a>

        <!-- Header -->
        <div class="mb-10 pb-8 border-b border-slate-100">
            <div class="w-12 h-12 bg-indigo-600 rounded-xl flex items-center justify-center text-white text-xl shadow-lg mb-6">
                <i class="fa-solid fa-shield"></i>
            </div>
            <h1 class="text-3xl md:text-4xl font-black text-slate-900 mb-3 tracking-tight">Kebijakan Privasi (Privacy Policy)</h1>
            <p class="text-slate-500 font-medium text-sm">Terakhir Diperbarui / Last Updated: <span class="text-slate-700 font-bold">30 Maret 2026</span></p>
        </div>

        <!-- Konten Privasi Bilingual -->
        <div class="space-y-10 text-slate-600 leading-relaxed text-sm md:text-base">
            
            <!-- Pengantar -->
            <div class="bg-slate-50 p-6 rounded-2xl border border-slate-100">
                <p class="mb-4"><strong>[ID]</strong> Sistem internal <strong>Content Planner</strong> dikelola secara eksklusif untuk kebutuhan operasional perusahaan. Kebijakan Privasi internal ini menjelaskan bagaimana data Anda sebagai karyawan ("Pengguna") dan data aset perusahaan diproses di dalam sistem, termasuk saat terhubung dengan layanan API pihak ketiga (TikTok & Meta).</p>
                <p class="text-slate-500 italic"><strong>[EN]</strong> The <strong>Content Planner</strong> internal system is managed exclusively for the company's operational needs. This internal Privacy Policy explains how your data as an employee ("User") and company asset data are processed within the system, including when connected to third-party API services (TikTok & Meta).</p>
            </div>

            <!-- Bagian 1 -->
            <div>
                <h2 class="text-lg font-bold text-slate-800 mb-3 flex items-center gap-2"><i class="fa-solid fa-database text-indigo-500"></i> 1. Informasi yang Kami Kelola / Information We Manage</h2>
                <ul class="list-disc list-outside pl-5 space-y-4">
                    <li>
                        <strong class="text-slate-700">[ID] Akses API Pihak Ketiga:</strong> <em>OAuth Access Tokens</em> dari media sosial resmi perusahaan untuk keperluan penjadwalan konten dan penarikan analitik secara otomatis.<br>
                        <span class="text-slate-500 italic"><strong>[EN] Third-Party API Access:</strong> OAuth Access Tokens from the company's official social media for the purpose of automated content scheduling and analytics retrieval.</span>
                    </li>
                    <li>
                        <strong class="text-slate-700">[ID] Data Operasional:</strong> Draf konten dan jadwal kalender kerja yang sepenuhnya milik perusahaan.<br>
                        <span class="text-slate-500 italic"><strong>[EN] Operational Data:</strong> Content drafts and work calendar schedules which are solely owned by the company.</span>
                    </li>
                </ul>
            </div>

            <!-- Bagian 2 -->
            <div>
                <h2 class="text-lg font-bold text-slate-800 mb-3 flex items-center gap-2"><i class="fa-solid fa-cloud-arrow-down text-indigo-500"></i> 2. Penggunaan Data API (API Data Usage)</h2>
                <p class="mb-4"><strong>[ID]</strong> Sistem mematuhi kebijakan pengembang dari platform TikTok dan Meta demi keamanan aset digital perusahaan. Sistem hanya menggunakan token untuk menjalankan fungsi otomatisasi posting dan merekap data statistik audiens. Tidak ada informasi pribadi yang ditarik secara ilegal.</p>
                <p class="text-slate-500 italic"><strong>[EN]</strong> The system complies with the developer policies of the TikTok and Meta platforms for the security of the company's digital assets. The system only uses tokens to execute automated posting functions and recap audience statistical data. No personal information is extracted illegally.</p>
            </div>

            <!-- Bagian 3 -->
            <div>
                <h2 class="text-lg font-bold text-slate-800 mb-3 flex items-center gap-2"><i class="fa-solid fa-lock text-indigo-500"></i> 3. Perlindungan Data / Data Protection</h2>
                <p class="mb-4"><strong>[ID]</strong> Token akses dan cookies integrasi disimpan secara aman di dalam database internal menggunakan standar enkripsi. Seluruh data bersifat rahasia di bawah aturan Non-Disclosure Agreement (NDA) perusahaan.</p>
                <p class="text-slate-500 italic"><strong>[EN]</strong> Access tokens and integration cookies are stored securely in internal databases using encryption standards. All data is highly confidential under the company's Non-Disclosure Agreement (NDA) rules.</p>
            </div>

            <!-- Bagian 4 -->
            <div>
                <h2 class="text-lg font-bold text-slate-800 mb-3 flex items-center gap-2"><i class="fa-solid fa-envelope text-indigo-500"></i> 4. Hubungi Kami / Contact Us</h2>
                <p class="mb-2"><strong>[ID]</strong> Jika Anda memiliki kendala teknis terkait aktivitas mencurigakan pada akses API, segera hubungi tim IT:<br>
                <span class="text-slate-500 italic"><strong>[EN]</strong> If you have technical issues regarding suspicious activity on API access, immediately contact the IT team:</span></p>
                
                <div class="bg-indigo-50 p-4 rounded-xl inline-block border border-indigo-100 mt-2">
                    <p><strong class="text-slate-700">Email:</strong> <a href="mailto:ikhtiarberkah1010@gmail.com" class="text-indigo-600 hover:underline font-bold">ikhtiarberkah1010@gmail.com</a></p>
                </div>
            </div>
        </div>

        <div class="mt-12 pt-8 border-t border-slate-100 text-center">
            <p class="text-xs text-slate-400 font-medium">&copy; {{ date('Y') }} Content Planner (Internal System). All Rights Reserved.</p>
        </div>
    </div>
</body>
</html>