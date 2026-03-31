<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Syarat dan Ketentuan - Content Planner</title>
    
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
                <i class="fa-solid fa-file-contract"></i>
            </div>
            <h1 class="text-3xl md:text-4xl font-black text-slate-900 mb-3 tracking-tight">Syarat dan Ketentuan (Terms and Conditions)</h1>
            <p class="text-slate-500 font-medium text-sm">Terakhir Diperbarui / Last Updated: <span class="text-slate-700 font-bold">30 Maret 2026</span></p>
        </div>

        <!-- Konten Utama (Disatukan langsung di sini dengan space-y-10 agar jaraknya rapi) -->
        <div class="space-y-10 text-slate-600 leading-relaxed text-sm md:text-base">
            
            <!-- Pengantar -->
            <div class="bg-slate-50 p-6 rounded-2xl border border-slate-100">
                <p class="mb-4"><strong>[ID]</strong> Selamat datang di sistem internal <strong>Content Planner</strong>. Dengan mengakses dan menggunakan platform ini, Anda sebagai karyawan atau anggota tim dianggap telah membaca, memahami, dan menyetujui pedoman penggunaan internal perusahaan berikut.</p>
                <p class="text-slate-500 italic"><strong>[EN]</strong> Welcome to the <strong>Content Planner</strong> internal system. By accessing and using this platform, you as an employee or team member are deemed to have read, understood, and agreed to the following internal company usage guidelines.</p>
            </div>

            <!-- Bagian 1 -->
            <div>
                <h2 class="text-lg font-bold text-slate-800 mb-3 flex items-center gap-2"><i class="fa-solid fa-layer-group text-indigo-500"></i> 1. Deskripsi Layanan / Service Description</h2>
                <p class="mb-2"><strong>[ID]</strong> Sistem ini adalah platform produktivitas internal yang dirancang untuk mendukung operasional divisi Content dan Digital Marketing perusahaan melalui fitur:</p>
                <ul class="list-disc list-outside pl-5 space-y-2 mb-4">
                    <li><strong class="text-slate-700">Board Planning:</strong> Pengaturan jadwal, kolaborasi tim, dan visualisasi aset konten perusahaan.</li>
                    <li><strong class="text-slate-700">Prompt Notes:</strong> Penyimpanan instruksi AI standar operasi (SOP) untuk kreasi konten.</li>
                    <li><strong class="text-slate-700">Calendar & Notes:</strong> Kalender editorial, integrasi jadwal kerja, dan catatan harian.</li>
                </ul>

                <p class="text-slate-500 italic mb-2"><strong>[EN]</strong> This system is an internal productivity platform designed to support the operations of the company's Content and Digital Marketing division through features:</p>
                <ul class="list-disc list-outside pl-5 space-y-2 text-slate-500 italic">
                    <li><strong>Board Planning:</strong> Schedule management, team collaboration, and visualization of company content assets.</li>
                    <li><strong>Prompt Notes:</strong> Storage of standard operating AI instructions (SOP) for content creation.</li>
                    <li><strong>Calendar & Notes:</strong> Editorial calendar, work schedule integration, and daily notes.</li>
                </ul>
            </div>

            <!-- Bagian 2 -->
            <div>
                <h2 class="text-lg font-bold text-slate-800 mb-3 flex items-center gap-2"><i class="fa-solid fa-user-shield text-indigo-500"></i> 2. Akses dan Penggunaan Akun / Account Access and Usage</h2>
                <ul class="list-disc list-outside pl-5 space-y-4">
                    <li>
                        <strong class="text-slate-700">[ID]</strong> Akun akses dibuat dan diberikan secara eksklusif oleh pihak Administrator atau Tim IT Perusahaan. Anda diwajibkan untuk menjaga kerahasiaan data login Anda dan <strong>dilarang keras membagikan akses</strong> kepada pihak eksternal. Hak akses ke sistem ini akan ditutup atau dicabut saat Anda tidak lagi bertugas di divisi terkait atau telah berhenti menjadi karyawan perusahaan.<br>
                        <span class="text-slate-500 italic mt-1 block"><strong>[EN]</strong> Access accounts are created and granted exclusively by the Administrator or the Company's IT Team. You are required to maintain the confidentiality of your login data and are <strong>strictly prohibited from sharing access</strong> with external parties. Access rights to this system will be suspended or revoked when you are no longer assigned to the relevant division or have ceased to be an employee of the company.</span>
                    </li>
                </ul>
            </div>

            <!-- Bagian 3 -->
            <div>
                <h2 class="text-lg font-bold text-slate-800 mb-3 flex items-center gap-2"><i class="fa-solid fa-plug-circle-check text-indigo-500"></i> 3. Integrasi API (TikTok & Facebook) / API Integration</h2>
                <p class="mb-2"><strong>[ID]</strong> Guna mempercepat proses publikasi dan penarikan data analisis aset digital perusahaan, sistem ini terhubung dengan API resmi dari TikTok (TikTok for Developers) dan Meta (Facebook for Developers). Oleh karena itu:</p>
                <ul class="list-disc list-outside pl-5 space-y-2 mb-4">
                    <li>Pemberian akses <em>OAuth token</em> hanya boleh dilakukan menggunakan akun media sosial resmi milik perusahaan atau entitas yang dinaunginya.</li>
                    <li>Penggunaan fungsi dari integrasi ini sepenuhnya tunduk pada Kebijakan Pengembang (Developer Policies) dan Syarat Layanan masing-masing platform (Meta & TikTok).</li>
                    <li>Token akses dijaga oleh sistem internal kami, namun Anda bertanggung jawab untuk tidak melakukan aktivitas spam atau pelanggaran komunitas yang bisa membahayakan reputasi akun sosial media perusahaan.</li>
                </ul>

                <p class="text-slate-500 italic mb-2"><strong>[EN]</strong> To accelerate the publication process and data retrieval of the company's digital assets, this system connects with official APIs from TikTok (TikTok for Developers) and Meta (Facebook for Developers). Therefore:</p>
                <ul class="list-disc list-outside pl-5 space-y-2 text-slate-500 italic">
                    <li>Granting <em>OAuth token</em> access must only be done using official social media accounts belonging to the company or its affiliated entities.</li>
                    <li>The use of functions from this integration is fully subject to the Developer Policies and Terms of Service of each platform (Meta & TikTok).</li>
                    <li>Access tokens are secured by our internal system, but you are responsible for not engaging in spam activities or community violations that could endanger the reputation of the company's social media accounts.</li>
                </ul>
            </div>

            <!-- Bagian 4 -->
            <div>
                <h2 class="text-lg font-bold text-slate-800 mb-3 flex items-center gap-2"><i class="fa-solid fa-file-shield text-indigo-500"></i> 4. Kepemilikan Data & Kerahasiaan / Data Ownership & Confidentiality</h2>
                <ul class="list-disc list-outside pl-5 space-y-4">
                    <li>
                        <strong class="text-slate-700">[ID] Hak Milik Perusahaan:</strong> Segala bentuk data, draf konten, jadwal promosi, strategi pemasaran, dan template prompt yang dimasukkan atau dihasilkan di dalam platform ini adalah kekayaan intelektual (IP) milik perusahaan secara eksklusif.<br>
                        <span class="text-slate-500 italic mt-1 block"><strong>[EN] Company Ownership:</strong> All forms of data, content drafts, promotional schedules, marketing strategies, and prompt templates entered or generated within this platform are the exclusive intellectual property (IP) of the company.</span>
                    </li>
                    <li>
                        <strong class="text-slate-700">[ID] Kerahasiaan (NDA):</strong> Anda tidak diperkenankan mengunduh, menyebarkan, atau membocorkan data perencanaan operasional apa pun yang terdapat di platform ini kepada kompetitor, media luar, atau pihak lain di luar perusahaan.<br>
                        <span class="text-slate-500 italic mt-1 block"><strong>[EN] Confidentiality (NDA):</strong> You are not permitted to download, distribute, or leak any operational planning data contained in this platform to competitors, external media, or other parties outside the company.</span>
                    </li>
                </ul>
            </div>

            <!-- Bagian 5 -->
            <div>
                <h2 class="text-lg font-bold text-slate-800 mb-3 flex items-center gap-2"><i class="fa-solid fa-gavel text-indigo-500"></i> 5. Sanksi Pelanggaran / Violation Sanctions</h2>
                <p class="mb-2"><strong>[ID]</strong> Sistem ini memantau aktivitas pengguna melalui riwayat log (activity logging). Setiap bentuk penyalahgunaan sistem, pembocoran data, atau penggunaan fitur yang merugikan perusahaan dapat mengakibatkan:</p>
                <ul class="list-disc list-outside pl-5 space-y-2 mb-4">
                    <li>Pemblokiran akun secara langsung.</li>
                    <li>Pemberian sanksi indisipliner sesuai dengan peraturan dan kebijakan (SOP) HR perusahaan.</li>
                    <li>Tindakan hukum lebih lanjut jika pelanggaran berdampak material pada perusahaan.</li>
                </ul>

                <p class="text-slate-500 italic mb-2"><strong>[EN]</strong> This system monitors user activity through activity logging. Any form of system abuse, data leakage, or use of features detrimental to the company may result in:</p>
                <ul class="list-disc list-outside pl-5 space-y-2 text-slate-500 italic">
                    <li>Immediate account suspension.</li>
                    <li>Disciplinary sanctions in accordance with the company's HR regulations and policies (SOP).</li>
                    <li>Further legal action if the violation has a material impact on the company.</li>
                </ul>
            </div>

        </div>

        <!-- Footer -->
        <div class="mt-12 pt-8 border-t border-slate-100 text-center">
            <p class="text-xs text-slate-400 font-medium">&copy; {{ date('Y') }} Content Planner (Internal System). Hak Cipta Dilindungi Undang-Undang.</p>
        </div>
    </div>
</body>
</html>