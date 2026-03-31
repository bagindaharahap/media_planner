<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terms and Conditions - Content Planner</title>
    
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

    <!-- Decoration Background -->
    <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-indigo-500/10 rounded-full blur-[100px] pointer-events-none"></div>
    <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-pink-500/10 rounded-full blur-[100px] pointer-events-none"></div>

    <div class="max-w-4xl mx-auto bg-white rounded-[2.5rem] shadow-xl border border-slate-100 p-8 md:p-14 relative z-10">
        
        <!-- Back Button -->
        <a href="{{ route('login') }}" class="inline-flex items-center gap-2 text-sm font-bold text-indigo-600 bg-indigo-50 px-4 py-2 rounded-xl hover:bg-indigo-100 transition-colors mb-8">
            <i class="fa-solid fa-arrow-left"></i> Kembali / Back
        </a>

        <!-- Header -->
        <div class="mb-10 pb-8 border-b border-slate-100">
            <div class="w-12 h-12 bg-indigo-600 rounded-xl flex items-center justify-center text-white text-xl shadow-lg mb-6">
                <i class="fa-solid fa-file-contract"></i>
            </div>
            <h1 class="text-3xl md:text-4xl font-black text-slate-900 mb-3 tracking-tight">Syarat dan Ketentuan (Terms and Conditions)</h1>
            <p class="text-slate-500 font-medium text-sm">Terakhir Diperbarui / Last Updated: <span class="text-slate-700 font-bold">31 Maret 2026</span></p>
        </div>

        <!-- Main Content -->
        <div class="space-y-10 text-slate-600 leading-relaxed text-sm md:text-base">
            
            <!-- Introduction -->
            <div class="bg-slate-50 p-6 rounded-2xl border border-slate-100">
                <p class="mb-4"><strong>[ID]</strong> Platform <strong>Content Planner</strong> adalah sistem manajemen operasional tertutup yang dirancang secara eksklusif untuk penggunaan internal perusahaan. Dengan mengakses platform ini, Anda menyetujui pedoman penggunaan aset digital perusahaan dan kepatuhan terhadap platform pihak ketiga.</p>
                <p class="text-slate-500 italic"><strong>[EN]</strong> The <strong>Content Planner</strong> platform is a closed operational management system designed exclusively for internal company use. By accessing this platform, you agree to the company's digital asset usage guidelines and third-party platform compliance.</p>
            </div>

            <!-- Section 1 -->
            <div>
                <h2 class="text-lg font-bold text-slate-800 mb-3 flex items-center gap-2"><i class="fa-solid fa-layer-group text-indigo-500"></i> 1. Lingkup Penggunaan / Scope of Use</h2>
                <p class="mb-2"><strong>[ID]</strong> Sistem ini dikategorikan sebagai <strong>Alamat Manajemen Bisnis Internal</strong>. Penggunaannya terbatas pada karyawan resmi untuk:</p>
                <ul class="list-disc list-outside pl-5 space-y-2 mb-4">
                    <li>Pengelolaan jadwal konten resmi perusahaan di platform sosial.</li>
                    <li>Monitoring metrik performa publik dari akun bisnis perusahaan melalui API resmi.</li>
                    <li>Kolaborasi internal antar tim kreatif dan administrator.</li>
                </ul>

                <p class="text-slate-500 italic mb-2"><strong>[EN]</strong> This system is categorized as an <strong>Internal Business Management Tool</strong>. Its use is restricted to authorized employees for:</p>
                <ul class="list-disc list-outside pl-5 space-y-2 text-slate-500 italic">
                    <li>Managing official company content schedules on social platforms.</li>
                    <li>Monitoring public performance metrics of company business accounts via official APIs.</li>
                    <li>Internal collaboration between creative teams and administrators.</li>
                </ul>
            </div>

            <!-- Section 2 -->
            <div>
                <h2 class="text-lg font-bold text-slate-800 mb-3 flex items-center gap-2"><i class="fa-solid fa-user-shield text-indigo-500"></i> 2. Keamanan Akses Terpusat / Centralized Access Security</h2>
                <ul class="list-disc list-outside pl-5 space-y-4">
                    <li>
                        <strong class="text-slate-700">[ID]</strong> Untuk menjamin keamanan data korporasi, registrasi akun hanya dapat dilakukan melalui Administrator sistem. Kebijakan "Hubungi Admin" adalah protokol keamanan standar kami untuk mencegah akses tidak sah dari pihak luar perusahaan.<br>
                        <span class="text-slate-500 italic mt-1 block"><strong>[EN]</strong> To ensure corporate data security, account registration can only be performed by the system Administrator. The "Contact Admin" policy is our standard security protocol to prevent unauthorized access from parties outside the company.</span>
                    </li>
                </ul>
            </div>

            <!-- Section 3 -->
            <div>
                <h2 class="text-lg font-bold text-slate-800 mb-3 flex items-center gap-2"><i class="fa-solid fa-plug-circle-check text-indigo-500"></i> 3. Kepatuhan Platform Pihak Ketiga / Third-Party Platform Compliance</h2>
                <p class="mb-2"><strong>[ID]</strong> Integrasi API TikTok dan Meta digunakan sesuai dengan kebijakan penggunaan komersial internal:</p>
                <ul class="list-disc list-outside pl-5 space-y-2 mb-4 font-medium text-slate-700">
                    <li><strong>TikTok Terms:</strong> Kami mematuhi <a href="https://www.tiktok.com/legal/page/global/terms-of-service/en" class="text-indigo-600 underline">TikTok Terms of Service</a> dan Kebijakan Pengembang untuk tujuan manajemen akun bisnis.</li>
                    <li><strong>Meta Terms:</strong> Kami mematuhi <a href="https://developers.facebook.com/terms/" class="text-indigo-600 underline">Meta Platform Policy</a> dalam pengelolaan akun Instagram Bisnis.</li>
                </ul>

                <p class="text-slate-500 italic mb-2"><strong>[EN]</strong> TikTok and Meta API integrations are used in accordance with internal commercial usage policies:</p>
                <ul class="list-disc list-outside pl-5 space-y-2 text-slate-500 italic">
                    <li><strong>TikTok Terms:</strong> We comply with <a href="https://www.tiktok.com/legal/page/global/terms-of-service/en" class="underline">TikTok Terms of Service</a> and Developer Policies for business account management purposes.</li>
                    <li><strong>Meta Terms:</strong> We comply with the <a href="https://developers.facebook.com/terms/" class="underline">Meta Platform Policy</a> regarding the management of Instagram Business accounts.</li>
                </ul>
            </div>

            <!-- Section 4 -->
            <div>
                <h2 class="text-lg font-bold text-slate-800 mb-3 flex items-center gap-2"><i class="fa-solid fa-database text-indigo-500"></i> 4. Perlindungan Data Korporasi / Corporate Data Protection</h2>
                <p class="mb-2"><strong>[ID]</strong> Seluruh <em>access token</em> yang diperoleh melalui proses OAuth disimpan secara terenkripsi (AES-256) dan hanya digunakan untuk keperluan internal divisi pemasaran perusahaan.</p>
                <p class="text-slate-500 italic"><strong>[EN]</strong> All <em>access tokens</em> obtained via the OAuth process are stored encrypted (AES-256) and used solely for the internal needs of the company's marketing division.</p>
            </div>

            <!-- Section 5 -->
            <div>
                <h2 class="text-lg font-bold text-slate-800 mb-3 flex items-center gap-2"><i class="fa-solid fa-gavel text-indigo-500"></i> 5. Sanksi & Kebijakan Internal / Sanctions & Internal Policy</h2>
                <p class="mb-2"><strong>[ID]</strong> Pelanggaran terhadap kerahasiaan data atau penyalahgunaan fitur API yang merugikan perusahaan akan ditindaklanjuti sesuai dengan SOP ketenagakerjaan perusahaan.</p>
                <p class="text-slate-500 italic"><strong>[EN]</strong> Any breach of data confidentiality or abuse of API features detrimental to the company will be handled according to the company's employment SOP.</p>
            </div>

        </div>

        <!-- Footer -->
        <div class="mt-12 pt-8 border-t border-slate-100 text-center">
            <p class="text-xs text-slate-400 font-medium">&copy; {{ date('Y') }} Content Planner (Enterprise Internal System). Hak Cipta Dilindungi.</p>
        </div>
    </div>
</body>
</html>