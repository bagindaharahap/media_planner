@extends('layouts.app')

@section('title', 'Instagram Monitoring - PlannerX')

@section('content')
<div class="space-y-8">
    
    <!-- HEADER -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 bg-white p-6 md:p-8 rounded-[2.5rem] border border-slate-100 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-pink-50 rounded-2xl flex items-center justify-center text-pink-600 shadow-inner">
                <i class="fa-brands fa-instagram text-2xl"></i>
            </div>
            <div>
                <h2 class="text-2xl font-black text-slate-800 tracking-tight">Instagram Monitoring</h2>
                <p class="text-sm text-slate-500 mt-1">Monitor performance, engagement, and growth of your Meta accounts.</p>
            </div>
        </div>
        
        <!-- ACTION BUTTONS -->
        <div class="flex items-center gap-3 w-full md:w-auto">
            <a href="#" class="flex-1 md:flex-none flex items-center justify-center gap-3 px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 hover:opacity-90 text-white rounded-2xl font-bold text-sm transition-all shadow-lg shadow-pink-200 active:scale-95">
                <i class="fa-brands fa-instagram text-lg"></i>
                Connect Official Account
            </a>
            
            @if(isset($apiError))
                <span class="hidden md:flex px-4 py-3 bg-red-50 text-red-600 font-bold text-xs rounded-2xl items-center gap-2 border border-red-100">
                    <span class="w-2 h-2 rounded-full bg-red-500"></span> Error API
                </span>
            @elseif(isset($profileData))
                <span class="hidden md:flex px-4 py-3 bg-green-50 text-green-600 font-bold text-xs rounded-2xl items-center gap-2 border border-green-100">
                    <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span> API Connected
                </span>
            @endif
        </div>
    </div>

    @if(isset($apiError))
    <div class="bg-red-50 border border-red-200 text-red-600 p-4 rounded-2xl mb-6">
        <strong>Gagal menghubungkan Instagram API:</strong> {{ $apiError }}
    </div>
    @endif

    <!-- 1. Account Profile & Core Metrics -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Instagram Profile Card -->
        <div class="bg-gradient-to-br from-pink-500 to-purple-600 p-8 rounded-[2rem] text-white shadow-lg shadow-pink-500/20 relative overflow-hidden flex flex-col justify-center">
            <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl transform translate-x-1/2 -translate-y-1/2 pointer-events-none"></div>
            
            <div class="relative z-10 flex items-center gap-5 mb-6">
                <!-- Profile Image -->
                <div class="w-20 h-20 rounded-full bg-white shadow-md shrink-0 flex items-center justify-center p-2.5">
                    <img src="https://i.ibb.co.com/7xhN2t3v/Logo-IBEKAMI.png" alt="Profile IG" class="w-full h-full object-contain">
                </div>
                <div>
                    <!-- Data Dinamis dari API Controller -->
                    <h3 class="text-xl font-black">{{ $profileData['username'] ?? '@memuat...' }}</h3>
                    <p class="text-pink-100 text-xs font-medium mt-1">
                        <i class="fa-solid fa-circle-check text-blue-400"></i> 
                        {{ isset($profileData['account_type']) && $profileData['account_type'] === 'BUSINESS' ? 'Official Business Account' : ($profileData['account_type'] ?? 'Personal Account') }}
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-4 border-t border-white/20 pt-6">
                <div class="text-center">
                    <p class="text-2xl font-black" title="Basic API tidak mendukung pengambilan data Followers">-</p>
                    <p class="text-[10px] uppercase tracking-widest text-pink-100 font-bold mt-1">Followers</p>
                </div>
                <div class="text-center border-l border-white/20">
                    <p class="text-2xl font-black" title="Basic API tidak mendukung pengambilan data Following">-</p>
                    <p class="text-[10px] uppercase tracking-widest text-pink-100 font-bold mt-1">Following</p>
                </div>
                <div class="text-center border-l border-white/20">
                    <!-- Data Dinamis dari API -->
                    <p class="text-2xl font-black">{{ isset($profileData['media_count']) ? number_format($profileData['media_count']) : 0 }}</p>
                    <p class="text-[10px] uppercase tracking-widest text-pink-100 font-bold mt-1">Posts</p>
                </div>
            </div>
        </div>

        <!-- Profile Detail Metrics (Insights - MOCKUP) -->
        <div class="lg:col-span-2 grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm flex flex-col justify-center">
                <div class="w-10 h-10 bg-blue-50 text-blue-500 rounded-xl flex items-center justify-center mb-4"><i class="fa-solid fa-eye"></i></div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Profile Views</p>
                <h4 class="text-2xl font-black text-slate-800 mt-1">45.2K</h4>
                <p class="text-xs text-emerald-500 font-bold mt-2"><i class="fa-solid fa-arrow-trend-up"></i> 12.5%</p>
            </div>
            <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm flex flex-col justify-center">
                <div class="w-10 h-10 bg-indigo-50 text-indigo-500 rounded-xl flex items-center justify-center mb-4"><i class="fa-solid fa-users"></i></div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Accounts Reached</p>
                <h4 class="text-2xl font-black text-slate-800 mt-1">812K</h4>
                <p class="text-xs text-emerald-500 font-bold mt-2"><i class="fa-solid fa-arrow-trend-up"></i> 8.2%</p>
            </div>
            <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm flex flex-col justify-center">
                <div class="w-10 h-10 bg-emerald-50 text-emerald-500 rounded-xl flex items-center justify-center mb-4"><i class="fa-solid fa-link"></i></div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Link Clicks</p>
                <h4 class="text-2xl font-black text-slate-800 mt-1">3,240</h4>
                <p class="text-xs text-emerald-500 font-bold mt-2"><i class="fa-solid fa-arrow-trend-up"></i> 2.1%</p>
            </div>
            <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm flex flex-col justify-center">
                <div class="w-10 h-10 bg-rose-50 text-rose-500 rounded-xl flex items-center justify-center mb-4"><i class="fa-solid fa-user-minus"></i></div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Unfollows</p>
                <h4 class="text-2xl font-black text-slate-800 mt-1">112</h4>
                <p class="text-xs text-rose-500 font-bold mt-2"><i class="fa-solid fa-arrow-trend-down"></i> 1.5%</p>
            </div>
        </div>
    </div>

    <!-- 2. Interaction & Growth Charts (MOCKUP) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm">
            <div class="flex justify-between items-center mb-6">
                <h3 class="font-bold text-lg text-slate-800">Engagement Trends</h3>
                <span class="text-xs font-bold text-slate-400 bg-slate-100 px-3 py-1 rounded-lg">Last 30 Days</span>
            </div>
            <div class="h-64 w-full">
                <canvas id="igEngagementChart"></canvas>
            </div>
        </div>
        
        <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm">
            <div class="flex justify-between items-center mb-6">
                <h3 class="font-bold text-lg text-slate-800">Top Cities & Countries</h3>
                <span class="text-xs font-bold text-slate-400 bg-slate-100 px-3 py-1 rounded-lg">Meta API</span>
            </div>
            <div class="space-y-5 mt-4">
                <div>
                    <div class="flex justify-between text-sm font-bold text-slate-700 mb-2"><span>1. Jakarta, Indonesia</span><span>45%</span></div>
                    <div class="w-full bg-slate-100 rounded-full h-2.5"><div class="bg-pink-500 h-2.5 rounded-full" style="width: 45%"></div></div>
                </div>
                <div>
                    <div class="flex justify-between text-sm font-bold text-slate-700 mb-2"><span>2. Bandung, Indonesia</span><span>20%</span></div>
                    <div class="w-full bg-slate-100 rounded-full h-2.5"><div class="bg-pink-400 h-2.5 rounded-full" style="width: 20%"></div></div>
                </div>
                <div>
                    <div class="flex justify-between text-sm font-bold text-slate-700 mb-2"><span>3. Surabaya, Indonesia</span><span>15%</span></div>
                    <div class="w-full bg-slate-100 rounded-full h-2.5"><div class="bg-pink-300 h-2.5 rounded-full" style="width: 15%"></div></div>
                </div>
                <div>
                    <div class="flex justify-between text-sm font-bold text-slate-700 mb-2"><span>4. Kuala Lumpur, Malaysia</span><span>8%</span></div>
                    <div class="w-full bg-slate-100 rounded-full h-2.5"><div class="bg-pink-200 h-2.5 rounded-full" style="width: 8%"></div></div>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. Demographics & Traffic Source (MOCKUP) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm lg:col-span-2">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h4 class="font-bold text-slate-800 text-sm">Age & Gender Distribution (IG)</h4>
                    <p class="text-[10px] text-slate-400 font-medium">Audience Demographic Data</p>
                </div>
            </div>
            <div class="h-[220px] w-full"><canvas id="demographicChart"></canvas></div>
        </div>

        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm flex flex-col justify-between">
            <div class="flex justify-between items-center mb-2">
                <div>
                    <h4 class="font-bold text-slate-800 text-sm">Traffic Source (IG)</h4>
                    <p class="text-[10px] text-slate-400 font-medium">Where is reach coming from?</p>
                </div>
            </div>
            <div class="h-[180px] w-full relative flex items-center justify-center my-2">
                <canvas id="trafficSourceIGChart"></canvas>
                <div class="absolute flex flex-col items-center justify-center pointer-events-none">
                    <span class="text-2xl font-black text-slate-800">55%</span>
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Home</span>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-y-2 gap-x-4 text-[11px] font-bold text-slate-600 mt-2">
                <div class="flex items-center gap-2"><div class="w-2 h-2 rounded-full bg-pink-500"></div> Home (55%)</div>
                <div class="flex items-center gap-2"><div class="w-2 h-2 rounded-full bg-purple-500"></div> Explore (25%)</div>
                <div class="flex items-center gap-2"><div class="w-2 h-2 rounded-full bg-orange-400"></div> Profile (15%)</div>
                <div class="flex items-center gap-2"><div class="w-2 h-2 rounded-full bg-slate-300"></div> Others (5%)</div>
            </div>
        </div>
    </div>

    <!-- 4. Specific Instagram Analysis (MOCKUP) -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm flex flex-col justify-between relative overflow-hidden group">
            <div class="absolute -right-4 -top-4 w-20 h-20 bg-pink-50 rounded-full transition-transform group-hover:scale-150 z-0"></div>
            <div class="relative z-10">
                <h4 class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-4">Story Retention Rate</h4>
                <div class="flex items-end justify-between">
                    <div>
                        <h3 class="text-3xl font-black text-slate-800">88.5%</h3>
                        <p class="text-[10px] text-slate-400 mt-1 font-medium">Audience watched until the end</p>
                    </div>
                    <div class="w-12 h-12 rounded-[1rem] bg-pink-50 flex items-center justify-center text-pink-600 text-lg shadow-inner">
                        <i class="fa-brands fa-instagram"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm flex flex-col justify-between relative overflow-hidden group">
            <div class="absolute -right-4 -top-4 w-20 h-20 bg-pink-50 rounded-full transition-transform group-hover:scale-150 z-0"></div>
            <div class="relative z-10">
                <h4 class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-4">Follower Growth (IG)</h4>
                <div class="flex items-end justify-between">
                    <div>
                        <h3 class="text-3xl font-black text-slate-900">+1,240</h3>
                        <p class="text-[10px] text-slate-400 mt-1 font-medium">New followers this week</p>
                    </div>
                    <div class="w-12 h-12 rounded-[1rem] bg-pink-50 flex items-center justify-center text-pink-600 text-lg shadow-inner">
                        <i class="fa-solid fa-user-plus"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm lg:col-span-2">
            <div class="flex justify-between items-center mb-5">
                <div>
                    <h4 class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Specific Content Analytics (IG)</h4>
                    <p class="text-[10px] text-slate-400 font-medium mt-0.5">Average interaction metrics for Reels & Feed</p>
                </div>
                <div class="w-8 h-8 rounded-full bg-pink-50 flex items-center justify-center text-pink-600">
                    <i class="fa-brands fa-instagram"></i>
                </div>
            </div>
            
            <div class="grid grid-cols-2 sm:grid-cols-5 gap-3 text-center">
                <div class="p-3 bg-slate-50 border border-slate-100 rounded-2xl">
                    <p class="text-xl font-black text-slate-800">18.4K</p>
                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider mt-1">Likes</p>
                </div>
                <div class="p-3 bg-slate-50 border border-slate-100 rounded-2xl">
                    <p class="text-xl font-black text-slate-800">842</p>
                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider mt-1">Comments</p>
                </div>
                <div class="p-3 bg-slate-50 border border-slate-100 rounded-2xl">
                    <p class="text-xl font-black text-slate-800">4.2K</p>
                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider mt-1">Shares</p>
                </div>
                <div class="p-3 bg-slate-50 border border-slate-100 rounded-2xl">
                    <p class="text-xl font-black text-slate-800">2.1K</p>
                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider mt-1">Saves</p>
                </div>
                <div class="p-3 bg-slate-50 border border-slate-100 rounded-2xl relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-8 h-8 bg-emerald-100 rounded-bl-full blur-md"></div>
                    <p class="text-xl font-black text-slate-800 relative z-10">112K</p>
                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider mt-1 relative z-10">Reach</p>
                </div>
            </div>
        </div>
    </div>

    <!-- 5. Top Performing Posts (DINAMIS DARI API) -->
    <div>
        <div class="flex items-center justify-between mb-6">
            <h3 class="font-bold text-xl text-slate-800 flex items-center gap-2">
                <i class="fa-solid fa-fire text-orange-500"></i> Latest Feed & Reels Posts
            </h3>
        </div>
        
        <!-- Container Galeri Dinamis Server-Side Rendering -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @if(isset($mediaData) && count($mediaData) > 0)
                @foreach($mediaData as $post)
                    <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden group hover:shadow-md transition">
                        <div class="h-48 bg-slate-200 relative">
                            @if(isset($post['media_type']) && $post['media_type'] === 'VIDEO')
                                <img src="{{ $post['thumbnail_url'] ?? '' }}" alt="Video" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                <div class="absolute top-3 right-3 bg-black/60 backdrop-blur-md text-white px-2 py-1 rounded-lg text-[10px] font-bold"><i class="fa-solid fa-play mr-1"></i> Reels</div>
                            @elseif(isset($post['media_type']) && $post['media_type'] === 'CAROUSEL_ALBUM')
                                <img src="{{ $post['media_url'] ?? '' }}" alt="Carousel" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                <div class="absolute top-3 right-3 bg-black/60 backdrop-blur-md text-white px-2 py-1 rounded-lg text-[10px] font-bold"><i class="fa-solid fa-images mr-1"></i> Carousel</div>
                            @else
                                <img src="{{ $post['media_url'] ?? '' }}" alt="Image" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            @endif
                        </div>
                        <div class="p-5 flex flex-col justify-between" style="min-height: 140px;">
                            <div>
                                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider mb-2">
                                    <i class="fa-regular fa-calendar mr-1"></i> 
                                    {{ isset($post['timestamp']) ? \Carbon\Carbon::parse($post['timestamp'])->format('d M Y') : '' }}
                                </p>
                                <p class="text-sm text-slate-700 font-medium line-clamp-2 mb-4 leading-snug">{{ $post['caption'] ?? 'Tanpa caption' }}</p>
                            </div>
                            <a href="{{ $post['permalink'] ?? '#' }}" target="_blank" class="text-[11px] font-black text-pink-500 hover:text-pink-600 transition flex items-center gap-1">
                                Buka di Instagram <i class="fa-solid fa-arrow-right-long"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-span-full bg-slate-50 border border-slate-100 text-center text-slate-500 p-8 rounded-[2rem]">
                    Belum ada postingan atau gagal memuat data media.
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Eksekusi Render Chart
    function renderIGCharts() {
        if (typeof Chart === 'undefined') {
            setTimeout(renderIGCharts, 100);
            return;
        }

        // Engagement Line Chart
        const ctxIG = document.getElementById('igEngagementChart')?.getContext('2d');
        if(ctxIG) {
            const gradientIg = ctxIG.createLinearGradient(0, 0, 0, 300);
            gradientIg.addColorStop(0, 'rgba(236, 72, 153, 0.2)');
            gradientIg.addColorStop(1, 'rgba(236, 72, 153, 0)');

            new Chart(ctxIG, {
                type: 'line',
                data: {
                    labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
                    datasets: [{
                        label: 'Interactions (Likes + Comments)', data: [12000, 15400, 14200, 18900],
                        borderColor: '#ec4899', borderWidth: 4, tension: 0.4, fill: true,
                        backgroundColor: gradientIg, pointBackgroundColor: '#ec4899', pointBorderColor: '#fff', pointBorderWidth: 2, pointRadius: 5, pointHoverRadius: 8,
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
        const ctxDemo = document.getElementById('demographicChart')?.getContext('2d');
        if(ctxDemo) {
            new Chart(ctxDemo, {
                type: 'bar',
                data: {
                    labels: ['13-17', '18-24', '25-34', '35-44', '45-54', '55+'],
                    datasets: [
                        { label: 'Female', data: [15, 35, 25, 10, 5, 2], backgroundColor: '#ec4899', borderRadius: 4, barPercentage: 0.6 },
                        { label: 'Male', data: [10, 45, 30, 15, 8, 3], backgroundColor: '#4f46e5', borderRadius: 4, barPercentage: 0.6 }
                    ]
                },
                options: {
                    responsive: true, maintainAspectRatio: false,
                    plugins: { legend: { position: 'top', align: 'end', labels: { boxWidth: 10, usePointStyle: true, font: { size: 10, weight: 'bold' } } } },
                    scales: { y: { display: false, grid: { display: false } }, x: { grid: { display: false }, ticks: { font: { size: 10, weight: 'bold' }, color: '#94a3b8' } } }
                }
            });
        }

        const ctxTrafficIG = document.getElementById('trafficSourceIGChart')?.getContext('2d');
        if(ctxTrafficIG) {
            new Chart(ctxTrafficIG, {
                type: 'doughnut',
                data: {
                    labels: ['Home', 'Explore', 'Profile', 'Others'],
                    datasets: [{ data: [55, 25, 15, 5], backgroundColor: ['#ec4899', '#a855f7', '#fb923c', '#cbd5e1'], borderWidth: 0, hoverOffset: 4 }]
                },
                options: { responsive: true, maintainAspectRatio: false, cutout: '75%', plugins: { legend: { display: false } } }
            });
        }
    }

    // Jalankan Chart saat halaman di-load
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', renderIGCharts);
    } else {
        renderIGCharts();
    }
</script>
@endpush
@endsection