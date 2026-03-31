<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- TikTok Verification Meta Tag -->
    <meta name="tiktok-developers-site-verification" content="wgOSUWXk7QS0o0uTkNAYHtBW9JnlovQI">
    <title>Content Planner - Internal Content Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-900">

    <!-- Navigation -->
    <nav class="p-6 flex justify-between items-center max-w-7xl mx-auto">
        <div class="flex items-center gap-2 font-bold text-xl text-indigo-600">
            <div class="w-10 h-10 bg-indigo-600 rounded-lg flex items-center justify-center text-white">
                <i class="fa-solid fa-calendar-check"></i>
            </div>
            Content Planner
        </div>
        <div class="flex gap-4">
            <a href="{{ route('terms') }}" class="text-sm font-medium text-slate-500 hover:text-indigo-600">Terms of Service</a>
            <a href="{{ route('privacy') }}" class="text-sm font-medium text-slate-500 hover:text-indigo-600">Privacy Policy</a>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-6 grid lg:grid-cols-2 gap-12 items-center py-12">
        <!-- Left Side: Product Information (For Reviewers) -->
        <div>
            <span class="bg-indigo-100 text-indigo-700 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-widest">Internal Corporate Tool</span>
            <h1 class="text-5xl font-black text-slate-900 mt-4 leading-tight">
                Streamline Your <span class="text-indigo-600">Social Media</span> Workflow.
            </h1>
            <p class="text-slate-500 mt-6 text-lg leading-relaxed">
                Content Planner assists our internal content team in managing publication schedules, monitoring real-time performance analytics, and automating posts to TikTok and Meta platforms using official API integrations.
            </p>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-10">
                <div class="flex gap-4">
                    <div class="text-indigo-600 mt-1"><i class="fa-solid fa-circle-check"></i></div>
                    <div>
                        <h4 class="font-bold text-sm">Auto-Scheduling</h4>
                        <p class="text-xs text-slate-400">Efficiently plan and publish videos at peak engagement hours.</p>
                    </div>
                </div>
                <div class="flex gap-4">
                    <div class="text-indigo-600 mt-1"><i class="fa-solid fa-circle-check"></i></div>
                    <div>
                        <h4 class="font-bold text-sm">Real-time Analytics</h4>
                        <p class="text-xs text-slate-400">Track views, likes, shares, and follower growth trends.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side: Login Gate -->
        <div class="bg-white p-10 rounded-[2.5rem] shadow-2xl shadow-indigo-200/50 border border-slate-100">
            <div class="text-center mb-8">
                <h3 class="text-2xl font-bold text-slate-800">Authorized Access</h3>
                <p class="text-sm text-slate-400 mt-1">Please log in with your internal credentials</p>
            </div>

            <!-- Error Handling -->
            @if ($errors->any())
                <div class="bg-rose-50 border border-rose-200 text-rose-600 px-4 py-3 rounded-2xl mb-6 text-xs">
                    <ul class="list-disc list-inside font-semibold">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Email Address</label>
                    <input type="email" name="email" required class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition-all outline-none" placeholder="work@company.com">
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Password</label>
                    <input type="password" name="password" required class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition-all outline-none" placeholder="••••••••">
                </div>
                <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-4 rounded-2xl shadow-lg shadow-indigo-200 hover:bg-indigo-700 hover:-translate-y-0.5 transition-all">
                    Login to Dashboard
                </button>
            </form>
            
            <div class="mt-8 pt-8 border-t border-slate-50 text-center">
                <p class="text-[10px] text-slate-400 font-medium italic leading-relaxed">
                    By accessing this system, you agree to our usage of authorized TikTok & Meta APIs for content management as outlined in our 
                    <a href="{{ route('terms') }}" class="text-indigo-500 underline">Terms</a> and 
                    <a href="{{ route('privacy') }}" class="text-indigo-500 underline">Privacy Policy</a>.
                </p>
            </div>
        </div>
    </main>

    <footer class="text-center py-10 text-slate-400 text-[10px] font-medium uppercase tracking-[0.2em]">
        &copy; 2026 Content Planner Internal System - Built for Content Excellence
    </footer>

</body>
</html>