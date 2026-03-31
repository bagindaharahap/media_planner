<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- TikTok Verification Meta Tag -->
    <meta name="tiktok-developers-site-verification" content="wgOSUWXk7QS0o0uTkNAYHtBW9JnlovQI">
    <title>Content Planner - Multi-Platform Internal CMS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .gradient-text {
            background: linear-gradient(135deg, #4f46e5 0%, #ec4899 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 scroll-smooth">

    <!-- Simple Navigation -->
    <nav class="p-6 flex justify-between items-center max-w-7xl mx-auto border-b border-slate-100">
        <div class="flex items-center gap-2 font-black text-2xl text-indigo-600 tracking-tighter">
            <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center text-white shadow-lg shadow-indigo-200">
                <i class="fa-solid fa-calendar-check"></i>
            </div>
            Content Planner
        </div>
        <div class="flex gap-8">
            <a href="#features" class="text-sm font-bold text-slate-500 hover:text-indigo-600 transition-colors">Features</a>
            <a href="{{ route('terms') }}" class="text-sm font-bold text-slate-500 hover:text-indigo-600 transition-colors">Terms</a>
            <a href="{{ route('privacy') }}" class="text-sm font-bold text-slate-500 hover:text-indigo-600 transition-colors">Privacy</a>
        </div>
    </nav>

    <!-- HERO SECTION (Updated for TikTok & Meta Reviewers) -->
    <section class="max-w-7xl mx-auto px-6 py-16 md:py-24 grid lg:grid-cols-2 gap-16 items-center">
        <div class="space-y-8">
            <div class="flex flex-wrap gap-2">
                <span class="bg-indigo-100 text-indigo-700 text-[10px] font-black px-4 py-1.5 rounded-full uppercase tracking-[0.2em] shadow-sm">
                    Internal Operations
                </span>
                <span class="bg-pink-100 text-pink-700 text-[10px] font-black px-4 py-1.5 rounded-full uppercase tracking-[0.2em] shadow-sm">
                    Official API Partner
                </span>
            </div>
            <h1 class="text-5xl md:text-6xl font-black text-slate-900 leading-[1.1] tracking-tight">
                Unified <span class="gradient-text">Social Intelligence</span> for Enterprise.
            </h1>
            <p class="text-slate-500 text-lg md:text-xl leading-relaxed max-w-lg font-medium">
                Content Planner empowers our creative teams with professional tools to manage production, automate scheduling for <strong>TikTok & Instagram</strong>, and monitor unified performance metrics via official Graph & Business APIs.
            </p>

            <div class="flex items-center gap-6 pt-4">
                <div class="flex items-center gap-3">
                    <i class="fa-brands fa-tiktok text-slate-400 text-xl"></i>
                    <i class="fa-brands fa-instagram text-slate-400 text-xl"></i>
                    <i class="fa-brands fa-facebook text-slate-400 text-xl"></i>
                </div>
                <div class="w-px h-10 bg-slate-200"></div>
                <div class="flex flex-col">
                    <span class="text-lg font-black text-slate-800">Secure Vault</span>
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Encrypted OAuth Storage</span>
                </div>
            </div>
        </div>

        <!-- Login Gate -->
        <div id="login-gate" class="bg-white p-10 rounded-[3rem] shadow-[0_30px_100px_-20px_rgba(79,70,229,0.15)] border border-slate-100 relative">
            <div class="absolute -top-10 -right-10 w-32 h-32 bg-indigo-500/10 rounded-full blur-3xl"></div>
            
            <div class="text-center mb-10">
                <div class="inline-flex items-center justify-center w-12 h-12 bg-slate-50 rounded-2xl mb-4">
                    <i class="fa-solid fa-shield-halved text-indigo-600"></i>
                </div>
                <h3 class="text-2xl font-black text-slate-800 tracking-tight">Authorized Login</h3>
                <p class="text-sm text-slate-400 mt-2 font-medium">Restricted access for internal employees.</p>
            </div>

            <!-- Error Handling -->
            @if ($errors->any())
                <div class="bg-rose-50 border border-rose-200 text-rose-600 px-4 py-3 rounded-2xl mb-8 text-xs">
                    <ul class="list-disc list-inside font-bold">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-2">Corporate Email</label>
                    <div class="relative">
                        <i class="fa-solid fa-envelope absolute left-5 top-1/2 -translate-y-1/2 text-slate-300"></i>
                        <input type="email" name="email" required class="w-full pl-12 pr-6 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none font-bold text-slate-700" placeholder="user@company.id">
                    </div>
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-2">Password</label>
                    <div class="relative">
                        <i class="fa-solid fa-lock absolute left-5 top-1/2 -translate-y-1/2 text-slate-300"></i>
                        <input type="password" name="password" required class="w-full pl-12 pr-6 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none font-bold text-slate-700" placeholder="••••••••">
                    </div>
                </div>
                <button type="submit" class="w-full bg-indigo-600 text-white font-black py-4 rounded-2xl shadow-xl shadow-indigo-200 hover:bg-indigo-700 hover:-translate-y-1 active:scale-95 transition-all">
                    Enter Dashboard
                </button>
            </form>
        </div>
    </section>

    <!-- MULTI-PLATFORM FEATURES SHOWCASE -->
    <section id="features" class="bg-white py-24 border-y border-slate-100">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-20">
                <h2 class="text-3xl md:text-4xl font-black text-slate-900 tracking-tight mb-4">API Integrated Interface</h2>
                <p class="text-slate-500 font-medium max-w-2xl mx-auto">Providing a safe environment for our marketing team to interact with Meta and TikTok APIs for operational planning.</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-10">
                <!-- Multi-Platform Analytics -->
                <div class="group bg-slate-50 p-8 rounded-[2.5rem] border border-slate-100 hover:border-indigo-500 hover:bg-white hover:shadow-2xl transition-all duration-500">
                    <div class="flex justify-between items-start mb-8">
                        <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center text-indigo-600 shadow-sm group-hover:bg-indigo-600 group-hover:text-white transition-all">
                            <i class="fa-solid fa-chart-pie text-2xl"></i>
                        </div>
                        <div class="flex gap-2">
                            <i class="fa-brands fa-instagram text-pink-500 opacity-60"></i>
                            <i class="fa-brands fa-tiktok text-slate-900 opacity-60"></i>
                        </div>
                    </div>
                    <h4 class="text-xl font-bold text-slate-800 mb-3">Unified Analytics</h4>
                    <p class="text-sm text-slate-500 leading-relaxed font-medium mb-6">Cross-platform synchronization using <strong>TikTok Business API</strong> and <strong>Meta Graph API</strong> to monitor follower growth and content reach in one place.</p>
                    <div class="bg-slate-200/50 h-32 rounded-2xl overflow-hidden border border-slate-200 flex items-end px-4 gap-2 pt-4">
                        <div class="bg-indigo-500 w-full rounded-t-lg" style="height: 60%"></div>
                        <div class="bg-pink-500 w-full rounded-t-lg" style="height: 85%"></div>
                        <div class="bg-indigo-600 w-full rounded-t-lg" style="height: 45%"></div>
                        <div class="bg-pink-600 w-full rounded-t-lg" style="height: 95%"></div>
                    </div>
                </div>

                <!-- Strategic Scheduling -->
                <div class="group bg-slate-50 p-8 rounded-[2.5rem] border border-slate-100 hover:border-indigo-500 hover:bg-white hover:shadow-2xl transition-all duration-500">
                    <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center text-indigo-600 shadow-sm mb-8 group-hover:bg-indigo-600 group-hover:text-white transition-all">
                        <i class="fa-solid fa-calendar-check text-2xl"></i>
                    </div>
                    <h4 class="text-xl font-bold text-slate-800 mb-3">Content Board</h4>
                    <p class="text-sm text-slate-500 leading-relaxed font-medium mb-6">Internal approval workflow for Reels and TikTok videos. Schedule publication times based on real-time audience peak-hours data from the APIs.</p>
                    <div class="bg-slate-200/50 p-4 rounded-2xl border border-slate-200">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex gap-2"><div class="w-2 h-2 bg-pink-500 rounded-full"></div><div class="h-2 w-16 bg-slate-300 rounded-full"></div></div>
                            <span class="text-[8px] font-black text-slate-400">INSTAGRAM</span>
                        </div>
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex gap-2"><div class="w-2 h-2 bg-slate-900 rounded-full"></div><div class="h-2 w-20 bg-slate-300 rounded-full"></div></div>
                            <span class="text-[8px] font-black text-slate-400">TIKTOK</span>
                        </div>
                    </div>
                </div>

                <!-- Secure API Vault -->
                <div class="group bg-slate-50 p-8 rounded-[2.5rem] border border-slate-100 hover:border-indigo-500 hover:bg-white hover:shadow-2xl transition-all duration-500">
                    <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center text-indigo-600 shadow-sm mb-8 group-hover:bg-indigo-600 group-hover:text-white transition-all">
                        <i class="fa-solid fa-key text-2xl"></i>
                    </div>
                    <h4 class="text-xl font-bold text-slate-800 mb-3">Secure API Access</h4>
                    <p class="text-sm text-slate-500 leading-relaxed font-medium mb-6">Centralized management for authorized <strong>Meta App Secret</strong> and <strong>TikTok Client Key</strong>. No user passwords stored, strictly token-based access.</p>
                    <div class="flex items-center justify-center gap-4 py-6 bg-slate-200/50 rounded-2xl border border-slate-200">
                        <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center text-indigo-600 text-lg shadow-sm"><i class="fa-solid fa-lock"></i></div>
                        <div class="flex gap-1">
                            <div class="w-8 h-8 bg-slate-900 rounded-full flex items-center justify-center text-white text-xs"><i class="fa-brands fa-tiktok"></i></div>
                            <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center text-white text-xs"><i class="fa-brands fa-facebook-f"></i></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="max-w-7xl mx-auto px-6 py-12">
        <div class="flex flex-col md:flex-row justify-between items-center gap-6 border-t border-slate-100 pt-12">
            <div class="flex flex-col items-center md:items-start gap-2">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                    &copy; 2026 Content Planner Internal System - Multi-Platform Content Solutions
                </p>
                <p class="text-[9px] text-slate-300 font-medium italic">Powered by Meta Graph API & TikTok Business API</p>
            </div>
            <div class="flex items-center gap-6 text-[10px] font-black uppercase tracking-widest text-slate-400">
                <a href="{{ route('terms') }}" class="hover:text-indigo-600 transition-colors">Terms of Service</a>
                <a href="{{ route('privacy') }}" class="hover:text-indigo-600 transition-colors">Privacy Policy</a>
            </div>
        </div>
    </footer>

</body>
</html>