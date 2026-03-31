@extends('layouts.app')

@section('title', 'TikTok Monitoring - PlannerX')

@section('content')
<div class="space-y-8">
    
    <!-- HEADER & CONNECT BUTTON -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 bg-white p-6 md:p-8 rounded-[2.5rem] border border-slate-100 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-slate-900 rounded-2xl flex items-center justify-center text-white shadow-inner">
                <i class="fa-brands fa-tiktok text-2xl"></i>
            </div>
            <div>
                <h2 class="text-2xl font-black text-slate-800 tracking-tight">TikTok Account Monitoring</h2>
                <p class="text-sm text-slate-500 mt-1">Monitor FYP performance, views, and video growth in real-time.</p>
            </div>
        </div>

        <div class="flex items-center gap-3 w-full md:w-auto">
            <!-- TIKTOK OAUTH BUTTON (Connect Account) -->
            <!-- PERBAIKAN: Mengarahkan ke rute tiktok.connect -->
            <a href="{{ route('tiktok.connect') }}" class="flex-1 md:flex-none flex items-center justify-center gap-3 px-6 py-3 bg-slate-900 hover:bg-slate-800 text-white rounded-2xl font-bold text-sm transition-all shadow-lg shadow-slate-200 active:scale-95">
                <i class="fa-brands fa-tiktok text-lg"></i>
                Connect Official Account
            </a>
            
            <span class="hidden md:flex px-4 py-3 bg-green-50 text-green-600 font-bold text-xs rounded-2xl items-center gap-2 border border-green-100">
                <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span> API Connected
            </span>
        </div>
    </div>

    <!-- 1. ACCOUNT PROFILE & CORE METRICS -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- TikTok Profile Card -->
       <div class="bg-gradient-to-br from-slate-900 to-slate-800 p-8 rounded-[2rem] text-white shadow-lg shadow-slate-900/20 relative overflow-hidden flex flex-col justify-center">
            <div class="absolute -top-10 -right-10 w-32 h-32 bg-[#00f2fe]/40 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-[#fe004f]/40 rounded-full blur-3xl pointer-events-none"></div>
            
            <div class="relative z-10 flex items-center gap-5 mb-6">
                <!-- Logo Container with fixed padding -->
                <div class="w-20 h-20 rounded-full bg-white shadow-md shrink-0 flex items-center justify-center p-2.5">
                    <img src="https://i.ibb.co.com/7xhN2t3v/Logo-IBEKAMI.png" alt="Profile" class="w-full h-full object-contain">
                </div>

                <div>
                    <h3 class="text-xl font-black">@ibekami.id</h3>
                    <p class="text-slate-300 text-xs font-medium mt-1"><i class="fa-solid fa-circle-check text-sky-400"></i> Verified Account</p>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-4 border-t border-slate-700 pt-6 relative z-10">
                <div class="text-center">
                    <p class="text-2xl font-black">842K</p>
                    <p class="text-[10px] uppercase tracking-widest text-slate-400 font-bold mt-1">Followers</p>
                </div>
                <div class="text-center border-l border-slate-700">
                    <p class="text-2xl font-black">5.2M</p>
                    <p class="text-[10px] uppercase tracking-widest text-slate-400 font-bold mt-1">Likes</p>
                </div>
                <div class="text-center border-l border-slate-700">
                    <p class="text-2xl font-black">214</p>
                    <p class="text-[10px] uppercase tracking-widest text-slate-400 font-bold mt-1">Videos</p>
                </div>
            </div>
        </div>

        <!-- Detail Metrics (Analytics) -->
        <div class="lg:col-span-2 grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm flex flex-col justify-center">
                <div class="w-10 h-10 bg-sky-50 text-sky-500 rounded-xl flex items-center justify-center mb-4"><i class="fa-solid fa-play"></i></div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Total Video Views</p>
                <h4 class="text-2xl font-black text-slate-800 mt-1">2.4M</h4>
                <p class="text-xs text-emerald-500 font-bold mt-2"><i class="fa-solid fa-arrow-trend-up"></i> 32.5%</p>
            </div>
            <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm flex flex-col justify-center">
                <div class="w-10 h-10 bg-fuchsia-50 text-fuchsia-500 rounded-xl flex items-center justify-center mb-4"><i class="fa-solid fa-share-nodes"></i></div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Total Shares</p>
                <h4 class="text-2xl font-black text-slate-800 mt-1">82.1K</h4>
                <p class="text-xs text-emerald-500 font-bold mt-2"><i class="fa-solid fa-arrow-trend-up"></i> 18.2%</p>
            </div>
            <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm flex flex-col justify-center">
                <div class="w-10 h-10 bg-orange-50 text-orange-500 rounded-xl flex items-center justify-center mb-4"><i class="fa-solid fa-music"></i></div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Sound Clicks</p>
                <h4 class="text-2xl font-black text-slate-800 mt-1">14.2K</h4>
                <p class="text-xs text-emerald-500 font-bold mt-2"><i class="fa-solid fa-arrow-trend-up"></i> 5.4%</p>
            </div>
            <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm flex flex-col justify-center">
                <div class="w-10 h-10 bg-indigo-50 text-indigo-500 rounded-xl flex items-center justify-center mb-4"><i class="fa-solid fa-eye"></i></div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Profile Views</p>
                <h4 class="text-2xl font-black text-slate-800 mt-1">68.5K</h4>
                <p class="text-xs text-emerald-500 font-bold mt-2"><i class="fa-solid fa-arrow-trend-up"></i> 22.1%</p>
            </div>
        </div>
    </div>

    <!-- 2. VIEWS GROWTH & RETENTION CHARTS -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm">
            <div class="flex justify-between items-center mb-6">
                <h3 class="font-bold text-lg text-slate-800">Video Views Growth</h3>
                <span class="text-xs font-bold text-slate-400 bg-slate-100 px-3 py-1 rounded-lg">Last 7 Days</span>
            </div>
            <div class="h-64 w-full">
                <canvas id="ttViewsChart"></canvas>
            </div>
        </div>
        
        <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm flex flex-col">
            <div class="flex justify-between items-center mb-6">
                <h3 class="font-bold text-lg text-slate-800">Audience Retention Analytics</h3>
                <span class="text-[10px] font-black text-white bg-slate-900 px-2 py-1 rounded-md uppercase tracking-widest"><i class="fa-brands fa-tiktok"></i> API</span>
            </div>
            
            <div class="flex-1 bg-slate-50 rounded-3xl border border-slate-100 p-6 flex flex-col justify-center">
                <div class="flex justify-between items-end mb-2">
                    <span class="text-sm font-bold text-slate-500">Average Watch Time</span>
                    <span class="text-2xl font-black text-slate-800">14.5<span class="text-sm text-slate-400 font-bold"> sec</span></span>
                </div>
                <div class="w-full bg-slate-200 rounded-full h-3 mb-6"><div class="bg-indigo-500 h-3 rounded-full" style="width: 65%"></div></div>
                
                <div class="flex justify-between items-end mb-2">
                    <span class="text-sm font-bold text-slate-500">Video Completion Rate</span>
                    <span class="text-2xl font-black text-slate-800">34.2%</span>
                </div>
                <div class="w-full bg-slate-200 rounded-full h-3 mb-6"><div class="bg-emerald-500 h-3 rounded-full" style="width: 34.2%"></div></div>

                <div class="p-4 bg-white rounded-xl border border-slate-100 text-xs font-medium text-slate-600 leading-relaxed">
                    <i class="fa-solid fa-wand-magic-sparkles text-amber-500 mr-1"></i> <strong class="text-slate-800">AI Insights:</strong> Your retention rate is healthy, but most viewers drop at the <strong>3-second mark</strong>. Try to strengthen your "Hook" in future content.
                </div>
            </div>
        </div>
    </div>

    <!-- 3. DEMOGRAPHICS & TRAFFIC SOURCES -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm lg:col-span-2">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h4 class="font-bold text-slate-800 text-sm">Age & Gender Distribution</h4>
                    <p class="text-[10px] text-slate-400 font-medium">Audience Demographic Data</p>
                </div>
            </div>
            <div class="h-[220px] w-full">
                <canvas id="demographicTikTokChart"></canvas>
            </div>
        </div>

        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm flex flex-col justify-between">
            <div class="flex justify-between items-center mb-2">
                <div>
                    <h4 class="font-bold text-slate-800 text-sm">Traffic Source</h4>
                    <p class="text-[10px] text-slate-400 font-medium">Where do views originate from?</p>
                </div>
            </div>
            <div class="h-[180px] w-full relative flex items-center justify-center my-2">
                <canvas id="trafficSourceChart"></canvas>
                <div class="absolute flex flex-col items-center justify-center pointer-events-none">
                    <span class="text-2xl font-black text-slate-800">65%</span>
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">FYP</span>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-y-2 gap-x-4 text-[11px] font-bold text-slate-600 mt-2">
                <div class="flex items-center gap-2"><div class="w-2 h-2 rounded-full bg-slate-900"></div> FYP (65%)</div>
                <div class="flex items-center gap-2"><div class="w-2 h-2 rounded-full bg-indigo-500"></div> Following (20%)</div>
                <div class="flex items-center gap-2"><div class="w-2 h-2 rounded-full bg-pink-500"></div> Profile (10%)</div>
                <div class="flex items-center gap-2"><div class="w-2 h-2 rounded-full bg-amber-400"></div> Sound (5%)</div>
            </div>
        </div>
    </div>

    <!-- 4. TOP PERFORMING VIDEOS -->
    <div>
        <div class="flex items-center justify-between mb-6">
            <h3 class="font-bold text-xl text-slate-800 flex items-center gap-2">
                <i class="fa-solid fa-crown text-amber-400"></i> Top Performing Content
            </h3>
            <button class="text-sm font-bold text-indigo-600 hover:underline">View All Data</button>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6" x-data>
            <template x-for="i in [1,2,3,4]" :key="i">
                <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden group hover:shadow-md transition">
                    <div class="h-64 bg-slate-200 relative">
                        <img :src="'https://picsum.photos/300/500?random=' + (i+10)" alt="Video" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        <div class="absolute bottom-3 left-3 bg-black/60 backdrop-blur-md text-white px-2 py-1 rounded-lg text-xs font-bold flex items-center gap-1.5">
                            <i class="fa-solid fa-play"></i> <span x-text="Math.floor(Math.random() * 900 + 100) + 'K'"></span>
                        </div>
                    </div>
                    <div class="p-5">
                        <p class="text-xs text-slate-800 font-bold mb-3 line-clamp-2">How to easily integrate TikTok API with Laravel and Alpine JS...</p>
                        <div class="grid grid-cols-3 gap-2 text-center border-t border-slate-100 pt-3">
                            <div><i class="fa-solid fa-heart text-slate-400 text-xs mb-1"></i><p class="text-sm font-black text-slate-800" x-text="Math.floor(Math.random() * 50 + 10) + 'K'"></p></div>
                            <div class="border-l border-slate-100"><i class="fa-solid fa-comment-dots text-slate-400 text-xs mb-1"></i><p class="text-sm font-black text-slate-800" x-text="Math.floor(Math.random() * 900 + 100)"></p></div>
                            <div class="border-l border-slate-100"><i class="fa-solid fa-share text-slate-400 text-xs mb-1"></i><p class="text-sm font-black text-slate-800" x-text="Math.floor(Math.random() * 5 + 1) + 'K'"></p></div>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function renderTikTokCharts() {
        if (typeof Chart === 'undefined') {
            setTimeout(renderTikTokCharts, 100);
            return;
        }

        // Views Line Chart
        const canvasTT = document.getElementById('ttViewsChart')?.getContext('2d');
        if (canvasTT) {
            const gradientTt = canvasTT.createLinearGradient(0, 0, 0, 300);
            gradientTt.addColorStop(0, 'rgba(15, 23, 42, 0.2)');
            gradientTt.addColorStop(1, 'rgba(15, 23, 42, 0)');

            new Chart(canvasTT, {
                type: 'line',
                data: {
                    labels: ['Day-6', 'Day-5', 'Day-4', 'Day-3', 'Day-2', 'Yesterday', 'Today'],
                    datasets: [{
                        label: 'Video Views', data: [45000, 52000, 38000, 120000, 85000, 92000, 145000],
                        borderColor: '#0f172a', borderWidth: 4, tension: 0.4, fill: true,
                        backgroundColor: gradientTt, pointBackgroundColor: '#0f172a', pointBorderColor: '#fff', pointBorderWidth: 2, pointRadius: 5, pointHoverRadius: 8,
                    }]
                },
                options: {
                    responsive: true, maintainAspectRatio: false,
                    plugins: { legend: { display: false }, tooltip: { backgroundColor: '#1e293b', padding: 12, borderRadius: 8 } },
                    scales: { y: { beginAtZero: true, grid: { borderDash: [5, 5], color: '#f1f5f9' }, ticks: { color: '#94a3b8', font: {weight: 'bold'} } }, x: { grid: { display: false }, ticks: { color: '#94a3b8', font: {weight: 'bold'} } } }
                }
            });
        }

        // Demographics Bar Chart
        const canvasDemoTikTok = document.getElementById('demographicTikTokChart')?.getContext('2d');
        if(canvasDemoTikTok) {
            new Chart(canvasDemoTikTok, {
                type: 'bar',
                data: {
                    labels: ['13-17', '18-24', '25-34', '35-44', '45-54', '55+'],
                    datasets: [
                        { label: 'Female', data: [30, 45, 15, 5, 3, 2], backgroundColor: '#f43f5e', borderRadius: 4, barPercentage: 0.6 },
                        { label: 'Male', data: [20, 50, 20, 5, 3, 2], backgroundColor: '#06b6d4', borderRadius: 4, barPercentage: 0.6 }
                    ]
                },
                options: {
                    responsive: true, maintainAspectRatio: false,
                    plugins: { legend: { position: 'top', align: 'end', labels: { boxWidth: 10, usePointStyle: true, font: { size: 10, weight: 'bold', family: "'Plus Jakarta Sans', sans-serif" } } } },
                    scales: { y: { display: false, grid: { display: false } }, x: { grid: { display: false }, ticks: { font: { size: 10, weight: 'bold', family: "'Plus Jakarta Sans', sans-serif" }, color: '#94a3b8' } } }
                }
            });
        }

        // Traffic Source Doughnut
        const canvasTraffic = document.getElementById('trafficSourceChart')?.getContext('2d');
        if(canvasTraffic) {
            new Chart(canvasTraffic, {
                type: 'doughnut',
                data: {
                    labels: ['FYP', 'Following', 'Profile', 'Sound / Others'],
                    datasets: [{ data: [65, 20, 10, 5], backgroundColor: ['#0f172a', '#4f46e5', '#ec4899', '#fbbf24'], borderWidth: 0, hoverOffset: 4 }]
                },
                options: { responsive: true, maintainAspectRatio: false, cutout: '75%', plugins: { legend: { display: false } } }
            });
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', renderTikTokCharts);
    } else {
        renderTikTokCharts();
    }
</script>
@endpush
@endsection