@extends('layouts.app')

@section('title', 'Dasbor Media Planner - PlannerX')

@section('content')

<!-- Data dari Database -->
<script id="plannings-data" type="application/json">
    {!! json_encode($plannings ?? []) !!}
</script>

<div class="space-y-8" x-data="dashboardData()">
    <!-- Barisan Kartu Statistik (Stat Cards) Utama -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6">
        <!-- Instagram Engagement Rate -->
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm transition hover:-translate-y-1">
            <div class="flex justify-between items-start mb-4">
                <div class="w-10 h-10 bg-pink-50 rounded-xl flex items-center justify-center text-pink-600">
                    <i class="fa-solid fa-heart"></i>
                </div>
                <span class="text-green-500 text-[10px] font-bold bg-green-50 px-2 py-1 rounded-lg">+12.4%</span>
            </div>
            <p class="text-slate-500 text-[11px] font-semibold uppercase tracking-wider">Engagement IG</p>
            <h3 class="text-2xl font-black text-slate-900 mt-1">4.82%</h3>
        </div>

        <!-- Tiktok Engagement Rate -->
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm transition hover:-translate-y-1">
            <div class="flex justify-between items-start mb-4">
                <div class="w-10 h-10 bg-slate-100 rounded-xl flex items-center justify-center text-slate-900">
                    <i class="fa-solid fa-heart"></i>
                </div>
                <span class="text-green-500 text-[10px] font-bold bg-green-50 px-2 py-1 rounded-lg">+18.2%</span>
            </div>
            <p class="text-slate-500 text-[11px] font-semibold uppercase tracking-wider">Engagement TikTok</p>
            <h3 class="text-2xl font-black text-slate-900 mt-1">6.15%</h3>
        </div>

        <!-- Instagram Stats -->
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm transition hover:-translate-y-1">
            <div class="flex justify-between items-start mb-4">
                <div class="w-10 h-10 bg-pink-50 rounded-xl flex items-center justify-center text-pink-600">
                    <i class="fa-brands fa-instagram"></i>
                </div>
                <span class="text-green-500 text-[10px] font-bold bg-green-50 px-2 py-1 rounded-lg">+8.1%</span>
            </div>
            <p class="text-slate-500 text-[11px] font-semibold uppercase tracking-wider">IG Followers</p>
            <h3 class="text-2xl font-black text-slate-900 mt-1">128.4K</h3>
        </div>

        <!-- TikTok Stats -->
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm transition hover:-translate-y-1">
            <div class="flex justify-between items-start mb-4">
                <div class="w-10 h-10 bg-slate-900 rounded-xl flex items-center justify-center text-white">
                    <i class="fa-brands fa-tiktok"></i>
                </div>
                <span class="text-green-500 text-[10px] font-bold bg-green-50 px-2 py-1 rounded-lg">+22.5%</span>
            </div>
            <p class="text-slate-500 text-[11px] font-semibold uppercase tracking-wider">TikTok Followers</p>
            <h3 class="text-2xl font-black text-slate-900 mt-1">842.0K</h3>
        </div>

        <!-- Scheduled Posts (Terintegrasi) -->
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm transition hover:-translate-y-1">
            <div class="flex justify-between items-start mb-4">
                <div class="w-10 h-10 bg-orange-50 rounded-xl flex items-center justify-center text-orange-600">
                    <i class="fa-solid fa-calendar-plus"></i>
                </div>
            </div>
            <p class="text-slate-500 text-[11px] font-semibold uppercase tracking-wider">Konten Terjadwal</p>
            <h3 class="text-2xl font-black text-slate-900 mt-1" x-text="upcomingPosts.length + ' Post'">0 Post</h3>
        </div>
    </div>

    <!-- KARTU STATUS BOARD PLANNING -->
    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-4">
        <!-- Draft (Backlog) -->
        <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition hover:-translate-y-1">
            <div class="flex items-center gap-2 mb-3">
                <div class="w-2.5 h-2.5 rounded-full bg-slate-400"></div>
                <p class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Draft</p>
            </div>
            <h3 class="text-3xl font-black text-slate-800" x-text="String(statusCounts.backlog).padStart(2, '0')">00</h3>
        </div>

        <!-- In Progress -->
        <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition hover:-translate-y-1">
            <div class="flex items-center gap-2 mb-3">
                <div class="w-2.5 h-2.5 rounded-full bg-indigo-500 shadow-sm shadow-indigo-500/50"></div>
                <p class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">In Progress</p>
            </div>
            <h3 class="text-3xl font-black text-slate-800" x-text="String(statusCounts.progress).padStart(2, '0')">00</h3>
        </div>

        <!-- In Review -->
        <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition hover:-translate-y-1">
            <div class="flex items-center gap-2 mb-3">
                <div class="w-2.5 h-2.5 rounded-full bg-rose-500 shadow-sm shadow-rose-500/50"></div>
                <p class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">In Review</p>
            </div>
            <h3 class="text-3xl font-black text-slate-800" x-text="String(statusCounts.review).padStart(2, '0')">00</h3>
        </div>

        <!-- Revisi -->
        <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition hover:-translate-y-1">
            <div class="flex items-center gap-2 mb-3">
                <div class="w-2.5 h-2.5 rounded-full bg-amber-400 shadow-sm shadow-amber-400/50"></div>
                <p class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Revisi</p>
            </div>
            <h3 class="text-3xl font-black text-slate-800" x-text="String(statusCounts.revisi).padStart(2, '0')">00</h3>
        </div>

        <!-- Hold On -->
        <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition hover:-translate-y-1">
            <div class="flex items-center gap-2 mb-3">
                <div class="w-2.5 h-2.5 rounded-full bg-orange-500 shadow-sm shadow-orange-500/50"></div>
                <p class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Hold On</p>
            </div>
            <h3 class="text-3xl font-black text-slate-800" x-text="String(statusCounts.hold_on).padStart(2, '0')">00</h3>
        </div>

        <!-- Approved -->
        <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition hover:-translate-y-1">
            <div class="flex items-center gap-2 mb-3">
                <div class="w-2.5 h-2.5 rounded-full bg-blue-500 shadow-sm shadow-blue-500/50"></div>
                <p class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Approved</p>
            </div>
            <h3 class="text-3xl font-black text-slate-800" x-text="String(statusCounts.approved).padStart(2, '0')">00</h3>
        </div>

        <!-- Published -->
        <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition hover:-translate-y-1">
            <div class="flex items-center gap-2 mb-3">
                <div class="w-2.5 h-2.5 rounded-full bg-emerald-500 shadow-sm shadow-emerald-500/50"></div>
                <p class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Published</p>
            </div>
            <h3 class="text-3xl font-black text-slate-800" x-text="String(statusCounts.published).padStart(2, '0')">00</h3>
        </div>
    </div>

    <!-- Bagian Grafik Dinamis dan Insight AI -->
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
        <!-- Grafik Utama (Chart.js) DENGAN FILTER -->
        <div class="xl:col-span-3 bg-white p-8 rounded-[2rem] border border-slate-100 shadow-sm"> <!-- Diubah menjadi col-span-3 agar melebar penuh -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
                <div>
                    <h3 class="font-bold text-lg text-slate-800">Statistik Performa <span class="capitalize" x-text="timeFilter"></span></h3>
                    
                    <!-- Legend dinamis -->
                    <div class="flex items-center gap-3 mt-2">
                        <div class="flex items-center gap-1.5" x-show="platformFilter === 'semua' || platformFilter === 'ig'">
                            <div class="w-2 h-2 rounded-full bg-indigo-600"></div>
                            <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Instagram</span>
                        </div>
                        <div class="flex items-center gap-1.5" x-show="platformFilter === 'semua' || platformFilter === 'tiktok'">
                            <div class="w-2 h-2 rounded-full bg-slate-900"></div>
                            <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">TikTok</span>
                        </div>
                    </div>
                </div>

                <div class="flex flex-wrap items-center gap-3">
                    <!-- Filter Platform Toggle -->
                    <div class="flex bg-slate-50 border border-slate-100 p-1 rounded-xl">
                        <button @click="platformFilter = 'semua'; renderPerformanceChart()" :class="platformFilter === 'semua' ? 'bg-white shadow-sm text-slate-800' : 'text-slate-400 hover:text-slate-600'" class="px-3 py-1.5 text-xs font-bold rounded-lg transition-all">Semua</button>
                        <button @click="platformFilter = 'ig'; renderPerformanceChart()" :class="platformFilter === 'ig' ? 'bg-white shadow-sm text-pink-600' : 'text-slate-400 hover:text-slate-600'" class="px-3 py-1.5 text-xs font-bold rounded-lg transition-all"><i class="fa-brands fa-instagram mr-1"></i> IG</button>
                        <button @click="platformFilter = 'tiktok'; renderPerformanceChart()" :class="platformFilter === 'tiktok' ? 'bg-white shadow-sm text-slate-900' : 'text-slate-400 hover:text-slate-600'" class="px-3 py-1.5 text-xs font-bold rounded-lg transition-all"><i class="fa-brands fa-tiktok mr-1"></i> TikTok</button>
                    </div>

                    <!-- Filter Waktu Select -->
                    <div class="relative">
                        <select x-model="timeFilter" @change="renderPerformanceChart()" class="bg-white border border-slate-200 text-slate-600 text-xs font-bold rounded-xl pl-4 pr-8 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 appearance-none transition-all cursor-pointer shadow-sm">
                            <option value="harian">Harian</option>
                            <option value="mingguan">Mingguan</option>
                            <option value="bulanan">Bulanan</option>
                            <option value="tahunan">Tahunan</option>
                        </select>
                        <i class="fa-solid fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-[10px] text-slate-400 pointer-events-none"></i>
                    </div>
                </div>
            </div>
            
            <div class="h-[350px] w-full relative">
                <canvas id="performanceChart"></canvas>
            </div>
        </div>

        <!-- Panel Insight AI (DISEMBUNYIKAN SEMENTARA DENGAN KOMENTAR) -->
        <!-- 
        <div class="bg-slate-900 p-8 rounded-[2rem] text-white relative overflow-hidden flex flex-col justify-between shadow-xl">
            <div class="relative z-10">
                <h3 class="font-bold text-lg mb-6 flex items-center gap-2">
                    <i class="fa-solid fa-wand-magic-sparkles text-indigo-400"></i> Targeting AI
                </h3>
                
                <div class="space-y-6">
                    <div class="bg-white/5 border border-white/10 p-5 rounded-2xl">
                        <p class="text-[10px] font-bold text-indigo-300 uppercase tracking-widest mb-1">Waktu Posting Terbaik</p>
                        <p class="text-2xl font-bold mb-1">21:15 <span class="text-xs font-normal text-slate-400">WIB</span></p>
                        <p class="text-[10px] text-slate-400 italic">Analisis berdasarkan jam Online Followers (Meta API).</p>
                    </div>

                    <div class="space-y-3">
                        <p class="text-sm font-bold text-slate-300">Rekomendasi Hashtag:</p>
                        <div class="flex flex-wrap gap-2">
                            <span class="px-3 py-1 bg-white/10 rounded-lg text-[10px] font-bold text-indigo-200">#laravel_dev</span>
                            <span class="px-3 py-1 bg-white/10 rounded-lg text-[10px] font-bold text-indigo-200">#coding_id</span>
                            <span class="px-3 py-1 bg-white/10 rounded-lg text-[10px] font-bold text-indigo-200">#web_planner</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="relative z-10 mt-8 pt-6 border-t border-white/10">
                <a href="{{ route('board.index') }}?create=true" class="w-full flex items-center justify-center py-4 bg-indigo-600 rounded-xl font-bold text-sm hover:bg-indigo-500 transition-colors shadow-lg shadow-indigo-500/20">
                    <i class="fa-solid fa-plus mr-2 text-xs"></i> Buat Jadwal Baru
                </a>
            </div>
            
            <div class="absolute -right-8 -top-8 w-32 h-32 bg-indigo-600/20 rounded-full blur-3xl"></div>
        </div>
        -->
    </div>

    <!-- ========================================================================= -->
    <!-- DEMOGRAFI & ANALISIS SUMBER TRAFFIC (DARI META & TIKTOK API)              -->
    <!-- ========================================================================= -->
    <div>
        <h3 class="font-bold text-lg text-slate-800 mb-4 mt-8 flex items-center gap-2">
            <i class="fa-solid fa-users-viewfinder text-indigo-500"></i> Demografi & Sumber Traffic
        </h3>
        
        <!-- Baris 1: Instagram (Meta API) -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
            <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm lg:col-span-2 hover:shadow-md transition">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h4 class="font-bold text-slate-800 text-sm">Distribusi Umur & Gender (IG)</h4>
                        <p class="text-[10px] text-slate-400 font-medium">Data Demografi Audiens Akun</p>
                    </div>
                    <span class="px-2 py-1 bg-pink-50 text-pink-600 border border-pink-100 text-[9px] font-black rounded-lg uppercase tracking-widest shadow-sm">
                        <i class="fa-brands fa-instagram mr-1"></i> Meta API
                    </span>
                </div>
                <div class="h-[220px] w-full">
                    <canvas id="demographicChart"></canvas>
                </div>
            </div>

            <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-md transition flex flex-col justify-between">
                <div class="flex justify-between items-center mb-2">
                    <div>
                        <h4 class="font-bold text-slate-800 text-sm">Traffic Source (IG)</h4>
                        <p class="text-[10px] text-slate-400 font-medium">Darimana reach berasal?</p>
                    </div>
                    <span class="px-2 py-1 bg-pink-50 text-pink-600 border border-pink-100 text-[9px] font-black rounded-lg uppercase tracking-widest shadow-sm">
                        <i class="fa-brands fa-instagram mr-1"></i> Meta API
                    </span>
                </div>
                
                <div class="h-[180px] w-full relative flex items-center justify-center my-2">
                    <canvas id="trafficSourceIGChart"></canvas>
                    <div class="absolute flex flex-col items-center justify-center pointer-events-none">
                        <span class="text-2xl font-black text-slate-800">55%</span>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Beranda</span>
                    </div>
                </div>
                
                <div class="grid grid-cols-2 gap-y-2 gap-x-4 text-[11px] font-bold text-slate-600 mt-2">
                    <div class="flex items-center gap-2"><div class="w-2 h-2 rounded-full bg-pink-500"></div> Beranda (55%)</div>
                    <div class="flex items-center gap-2"><div class="w-2 h-2 rounded-full bg-purple-500"></div> Explore (25%)</div>
                    <div class="flex items-center gap-2"><div class="w-2 h-2 rounded-full bg-orange-400"></div> Profil (15%)</div>
                    <div class="flex items-center gap-2"><div class="w-2 h-2 rounded-full bg-slate-300"></div> Lainnya (5%)</div>
                </div>
            </div>
        </div>

        <!-- Baris 2: TikTok API -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm lg:col-span-2 hover:shadow-md transition">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h4 class="font-bold text-slate-800 text-sm">Distribusi Umur & Gender (TikTok)</h4>
                        <p class="text-[10px] text-slate-400 font-medium">Data Demografi Audiens Akun</p>
                    </div>
                    <span class="px-2 py-1 bg-slate-100 text-slate-700 border border-slate-200 text-[9px] font-black rounded-lg uppercase tracking-widest shadow-sm">
                        <i class="fa-brands fa-tiktok mr-1"></i> TikTok API
                    </span>
                </div>
                <div class="h-[220px] w-full">
                    <canvas id="demographicTikTokChart"></canvas>
                </div>
            </div>

            <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-md transition flex flex-col justify-between">
                <div class="flex justify-between items-center mb-2">
                    <div>
                        <h4 class="font-bold text-slate-800 text-sm">Traffic Source (TikTok)</h4>
                        <p class="text-[10px] text-slate-400 font-medium">Darimana views berasal?</p>
                    </div>
                    <span class="px-2 py-1 bg-slate-100 text-slate-700 border border-slate-200 text-[9px] font-black rounded-lg uppercase tracking-widest shadow-sm">
                        <i class="fa-brands fa-tiktok mr-1"></i> TikTok API
                    </span>
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
                    <div class="flex items-center gap-2"><div class="w-2 h-2 rounded-full bg-pink-500"></div> Profil (10%)</div>
                    <div class="flex items-center gap-2"><div class="w-2 h-2 rounded-full bg-amber-400"></div> Sound / lainnya (5%)</div>
                </div>
            </div>
        </div>
    </div>

    <!-- ========================================================================= -->
    <!-- ANALITIK KONTEN MENDALAM (DEEP DIVE)                                      -->
    <!-- ========================================================================= -->
    <div>
        <h3 class="font-bold text-lg text-slate-800 mb-4 mt-8 flex items-center gap-2">
            <i class="fa-solid fa-photo-film text-indigo-500"></i> Analitik Konten & Retensi Spesifik
        </h3>
        
        <!-- ======================= BARIS TIKTOK ======================= -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
            <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm flex flex-col justify-between hover:shadow-md transition relative overflow-hidden group">
                <div class="absolute -right-4 -top-4 w-20 h-20 bg-slate-50 rounded-full transition-transform group-hover:scale-150 z-0"></div>
                <div class="relative z-10">
                    <h4 class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-4">Video Completion Rate</h4>
                    <div class="flex items-end justify-between">
                        <div>
                            <h3 class="text-3xl font-black text-slate-800">34.2%</h3>
                            <p class="text-[10px] text-slate-400 mt-1 font-medium">Audiens nonton sampai habis</p>
                        </div>
                        <div class="w-12 h-12 rounded-[1rem] bg-slate-900 flex items-center justify-center text-white text-lg shadow-lg">
                            <i class="fa-brands fa-tiktok"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm flex flex-col justify-between hover:shadow-md transition relative overflow-hidden group">
                <div class="absolute -right-4 -top-4 w-20 h-20 bg-slate-50 rounded-full transition-transform group-hover:scale-150 z-0"></div>
                <div class="relative z-10">
                    <h4 class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-4">Follower Growth (TikTok)</h4>
                    <div class="flex items-end justify-between">
                        <div>
                            <h3 class="text-3xl font-black text-slate-900">+3,450</h3>
                            <p class="text-[10px] text-slate-400 mt-1 font-medium">Followers baru minggu ini</p>
                        </div>
                        <div class="w-12 h-12 rounded-[1rem] bg-slate-100 flex items-center justify-center text-slate-900 text-lg shadow-inner">
                            <i class="fa-solid fa-user-plus"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm lg:col-span-2 hover:shadow-md transition">
                <div class="flex justify-between items-center mb-5">
                    <div>
                        <h4 class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Analitik Konten Spesifik</h4>
                        <p class="text-[10px] text-slate-400 font-medium mt-0.5">Rata-rata metrik interaksi 24 jam terakhir</p>
                    </div>
                    <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-900">
                        <i class="fa-brands fa-tiktok"></i>
                    </div>
                </div>
                
                <div class="grid grid-cols-2 sm:grid-cols-5 gap-3 text-center">
                    <div class="p-3 bg-slate-50 border border-slate-100 rounded-2xl">
                        <p class="text-xl font-black text-slate-800">45.2K</p>
                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider mt-1">Likes</p>
                    </div>
                    <div class="p-3 bg-slate-50 border border-slate-100 rounded-2xl">
                        <p class="text-xl font-black text-slate-800">1.2K</p>
                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider mt-1">Comment</p>
                    </div>
                    <div class="p-3 bg-slate-50 border border-slate-100 rounded-2xl">
                        <p class="text-xl font-black text-slate-800">840</p>
                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider mt-1">Repost</p>
                    </div>
                    <div class="p-3 bg-slate-50 border border-slate-100 rounded-2xl">
                        <p class="text-xl font-black text-slate-800">3.4K</p>
                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider mt-1">Save</p>
                    </div>
                    <div class="p-3 bg-slate-50 border border-slate-100 rounded-2xl relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-8 h-8 bg-emerald-100 rounded-bl-full blur-md"></div>
                        <p class="text-xl font-black text-slate-800 relative z-10">1.8K</p>
                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider mt-1 relative z-10">Share</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- ======================= BARIS INSTAGRAM ======================= -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm flex flex-col justify-between hover:shadow-md transition relative overflow-hidden group">
                <div class="absolute -right-4 -top-4 w-20 h-20 bg-pink-50 rounded-full transition-transform group-hover:scale-150 z-0"></div>
                <div class="relative z-10">
                    <h4 class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-4">Story Retention Rate</h4>
                    <div class="flex items-end justify-between">
                        <div>
                            <h3 class="text-3xl font-black text-slate-800">88.5%</h3>
                            <p class="text-[10px] text-slate-400 mt-1 font-medium">Audiens melihat hingga akhir</p>
                        </div>
                        <div class="w-12 h-12 rounded-[1rem] bg-pink-50 flex items-center justify-center text-pink-600 text-lg shadow-inner">
                            <i class="fa-brands fa-instagram"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm flex flex-col justify-between hover:shadow-md transition relative overflow-hidden group">
                <div class="absolute -right-4 -top-4 w-20 h-20 bg-pink-50 rounded-full transition-transform group-hover:scale-150 z-0"></div>
                <div class="relative z-10">
                    <h4 class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-4">Follower Growth (IG)</h4>
                    <div class="flex items-end justify-between">
                        <div>
                            <h3 class="text-3xl font-black text-slate-900">+1,240</h3>
                            <p class="text-[10px] text-slate-400 mt-1 font-medium">Followers baru minggu ini</p>
                        </div>
                        <div class="w-12 h-12 rounded-[1rem] bg-pink-50 flex items-center justify-center text-pink-600 text-lg shadow-inner">
                            <i class="fa-solid fa-user-plus"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm lg:col-span-2 hover:shadow-md transition">
                <div class="flex justify-between items-center mb-5">
                    <div>
                        <h4 class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Analitik Konten Spesifik (IG)</h4>
                        <p class="text-[10px] text-slate-400 font-medium mt-0.5">Rata-rata metrik interaksi Reels & Feed</p>
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
                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider mt-1">Comment</p>
                    </div>
                    <div class="p-3 bg-slate-50 border border-slate-100 rounded-2xl">
                        <p class="text-xl font-black text-slate-800">4.2K</p>
                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider mt-1">Share</p>
                    </div>
                    <div class="p-3 bg-slate-50 border border-slate-100 rounded-2xl">
                        <p class="text-xl font-black text-slate-800">2.1K</p>
                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider mt-1">Save</p>
                    </div>
                    <div class="p-3 bg-slate-50 border border-slate-100 rounded-2xl relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-8 h-8 bg-emerald-100 rounded-bl-full blur-md"></div>
                        <p class="text-xl font-black text-slate-800 relative z-10">112K</p>
                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider mt-1 relative z-10">Share</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Daftar Konten Mendatang (Terintegrasi) -->
    <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden mb-10 mt-8">
        <div class="p-8 border-b border-slate-50 flex justify-between items-center bg-slate-50/30">
            <h3 class="font-bold text-lg text-slate-800">Konten Terjadwal</h3>
            <a href="{{ route('board.index') }}" class="text-indigo-600 font-bold text-sm hover:underline">Lihat Board Planning <i class="fa-solid fa-chevron-right ml-1 text-[10px]"></i></a>
        </div>
        
        <div class="divide-y divide-slate-50 text-sm">
            <template x-for="post in upcomingPosts" :key="post.id">
                <div class="p-6 flex flex-col sm:flex-row items-center justify-between gap-4 hover:bg-slate-50 transition-colors cursor-pointer group">
                    <div class="flex items-center gap-4 w-full sm:w-auto">
                        <div class="w-14 h-14 rounded-2xl overflow-hidden relative shrink-0 shadow-sm border border-slate-100 flex items-center justify-center" :class="getPlatformColor(post.content_type)">
                            <div class="absolute inset-0 opacity-10 bg-current"></div>
                            <i class="text-xl" :class="getPlatformIcon(post.content_type)"></i>
                        </div>
                        <div class="overflow-hidden">
                            <h4 class="font-bold text-slate-800 truncate" x-text="post.title"></h4>
                            <div class="flex items-center gap-3 mt-1">
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest flex items-center gap-1">
                                    <i class="fa-solid fa-clock text-[9px]"></i> <span x-text="post.due_date || post.start_date || 'Belum diatur'"></span>
                                </span>
                                <span class="px-2 py-0.5 text-[9px] font-black rounded-md uppercase" :class="getPlatformColor(post.content_type)" x-text="post.content_type || 'Konten'"></span>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-6">
                        <span class="px-3 py-1 text-[10px] font-bold uppercase rounded-lg" :class="getStatusStyle(post.status)" x-text="getStatusName(post.status)"></span>
                        <a href="{{ route('board.index') }}" class="text-slate-400 hover:text-indigo-600"><i class="fa-solid fa-arrow-up-right-from-square"></i></a>
                    </div>
                </div>
            </template>

            <!-- State Empty / Jika Kosong -->
            <template x-if="upcomingPosts.length === 0">
                <div class="p-10 text-center">
                    <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-3 text-slate-300">
                        <i class="fa-solid fa-folder-open text-2xl"></i>
                    </div>
                    <p class="text-slate-500 font-bold">Belum ada konten terjadwal</p>
                    <p class="text-xs text-slate-400 mt-1">Pastikan Anda sudah membuat konten di Board Planning dan menautkan database dengan benar.</p>
                </div>
            </template>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>
<script>
    // FUNGSI UNTUK ALPINE JS TERINTEGRASI DB & FILTER CHART
    function dashboardData() {
        return {
            plannings: [],
            upcomingPosts: [],
            statusCounts: { backlog: 0, progress: 0, review: 0, revisi: 0, hold_on: 0, approved: 0, published: 0 },
            
            // State untuk Filter Chart
            timeFilter: 'mingguan',
            platformFilter: 'semua',
            mainChartObj: null,

            init() {
                try {
                    let rawDataText = document.getElementById('plannings-data').textContent;
                    let rawData = JSON.parse(rawDataText);
                    
                    this.plannings = rawData;
                    
                    this.plannings.forEach(p => {
                        if(this.statusCounts[p.status] !== undefined) {
                            this.statusCounts[p.status]++;
                        }
                    });

                    const priorityOrder = { urgent: 0, high: 1, normal: 2, low: 3 };
                    this.upcomingPosts = this.plannings
                        .filter(p => p.status !== 'published')
                        .sort((a, b) => {
                            const pa = priorityOrder[a.priority] ?? 99;
                            const pb = priorityOrder[b.priority] ?? 99;
                            if (pa !== pb) return pa - pb;
                            let dateA = new Date(a.due_date || a.start_date || '9999-12-31');
                            let dateB = new Date(b.due_date || b.start_date || '9999-12-31');
                            return dateA - dateB;
                        });

                } catch(e) {
                    console.error('Data plannings tidak ditemukan atau error parsing.', e);
                }

                // Inisialisasi Chart Utama
                this.initPerformanceChart();
            },

            // Polling untuk memastikan Chart.js dimuat sebelum dirender
            initPerformanceChart() {
                if (typeof Chart === 'undefined') {
                    setTimeout(() => this.initPerformanceChart(), 100);
                    return;
                }
                this.renderPerformanceChart();
            },

            // Mengambil Mock Data berdasarkan filter Waktu
            getChartData() {
                const dataSets = {
                    harian: {
                        labels: ['00:00', '04:00', '08:00', '12:00', '16:00', '20:00', '23:59'],
                        ig: [120, 80, 450, 600, 320, 890, 400],
                        tiktok: [50, 40, 200, 850, 500, 1200, 600]
                    },
                    mingguan: {
                        labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
                        ig: [450, 520, 480, 610, 580, 720, 850],
                        tiktok: [300, 450, 890, 420, 650, 950, 1100]
                    },
                    bulanan: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'],
                        ig: [4.5, 5.1, 4.8, 6.2, 5.9, 7.1, 8.4, 9.2, 8.8, 10.1, 11.5, 12.8],
                        tiktok: [3.2, 4.8, 8.1, 5.5, 7.2, 9.5, 11.0, 14.5, 12.1, 16.8, 19.5, 22.4]
                    },
                    tahunan: {
                        labels: ['2023', '2024', '2025', '2026'],
                        ig: [45.2, 68.4, 89.1, 128.4],
                        tiktok: [12.5, 145.2, 450.8, 842.0]
                    }
                };
                return dataSets[this.timeFilter];
            },

            // Fungsi Utama Rendering Grafik Dinamis
            renderPerformanceChart() {
                const canvas = document.getElementById('performanceChart');
                if (!canvas) return;
                const ctx = canvas.getContext('2d');

                // Hancurkan objek chart yang lama jika sudah ada
                if (this.mainChartObj) {
                    this.mainChartObj.destroy();
                }

                const data = this.getChartData();
                
                const gradientIg = ctx.createLinearGradient(0, 0, 0, 350);
                gradientIg.addColorStop(0, 'rgba(79, 70, 229, 0.2)');
                gradientIg.addColorStop(1, 'rgba(79, 70, 229, 0)');

                let activeDatasets = [];

                // Filter logika platform
                if (this.platformFilter === 'semua' || this.platformFilter === 'ig') {
                    activeDatasets.push({
                        label: 'Instagram',
                        data: data.ig,
                        borderColor: '#4f46e5',
                        borderWidth: 4,
                        tension: 0.4,
                        fill: true,
                        backgroundColor: gradientIg,
                        pointRadius: 0,
                        pointHoverRadius: 6,
                    });
                }

                if (this.platformFilter === 'semua' || this.platformFilter === 'tiktok') {
                    activeDatasets.push({
                        label: 'TikTok',
                        data: data.tiktok,
                        borderColor: '#0f172a',
                        borderWidth: 4,
                        tension: 0.4,
                        pointRadius: 0,
                        pointHoverRadius: 6,
                    });
                }

                // Buat Chart Baru
                this.mainChartObj = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: data.labels,
                        datasets: activeDatasets
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: { backgroundColor: '#1e293b', padding: 12, titleFont: { size: 14, weight: 'bold' }, bodyFont: { size: 13 }, displayColors: false, borderRadius: 8 }
                        },
                        scales: {
                            y: { beginAtZero: true, grid: { borderDash: [5, 5], color: '#f1f5f9', drawBorder: false }, ticks: { font: { weight: 'bold', size: 10 }, color: '#94a3b8' } },
                            x: { grid: { display: false }, ticks: { font: { weight: 'bold', size: 10 }, color: '#94a3b8' } }
                        }
                    }
                });
            },

            getStatusStyle(status) {
                const styles = {
                    'backlog': 'bg-slate-100 text-slate-700',
                    'progress': 'bg-indigo-100 text-indigo-700',
                    'review': 'bg-rose-100 text-rose-700',
                    'revisi': 'bg-amber-100 text-amber-700',
                    'hold_on': 'bg-orange-100 text-orange-700',
                    'approved': 'bg-blue-100 text-blue-700'
                };
                return styles[status] || 'bg-slate-100 text-slate-700';
            },
            getStatusName(status) {
                const names = {
                    'backlog': 'Draft',
                    'progress': 'In Progress',
                    'review': 'In Review',
                    'revisi': 'Revisi',
                    'hold_on': 'Hold On',
                    'approved': 'Approved'
                };
                return names[status] || status;
            },
            getPlatformIcon(type) {
                if(!type) return 'fa-solid fa-image';
                const t = type.toLowerCase();
                if(t.includes('tiktok')) return 'fa-brands fa-tiktok';
                if(t.includes('instagram') || t.includes('reels') || t.includes('feed') || t.includes('story')) return 'fa-brands fa-instagram';
                return 'fa-solid fa-image';
            },
            getPlatformColor(type) {
                if(!type) return 'text-indigo-600 bg-indigo-50';
                const t = type.toLowerCase();
                if(t.includes('tiktok')) return 'text-slate-900 bg-slate-100';
                if(t.includes('instagram') || t.includes('reels') || t.includes('feed') || t.includes('story')) return 'text-pink-600 bg-pink-50';
                return 'text-indigo-600 bg-indigo-50';
            }
        };
    }

    // FUNGSI UNTUK MERENDER GRAFIK STATIS (Demografi & Traffic Source)
    function renderStaticCharts() {
        if (typeof Chart === 'undefined') {
            console.warn("Menunggu library Chart.js dimuat untuk grafik statis...");
            setTimeout(renderStaticCharts, 100);
            return;
        }

        // Grafik Demografi (Umur & Gender IG API)
        const canvasDemo = document.getElementById('demographicChart');
        if (canvasDemo) {
            new Chart(canvasDemo.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: ['13-17', '18-24', '25-34', '35-44', '45-54', '55+'],
                    datasets: [
                        { label: 'Perempuan', data: [15, 35, 25, 10, 5, 2], backgroundColor: '#ec4899', borderRadius: 4, barPercentage: 0.6 },
                        { label: 'Laki-laki', data: [10, 45, 30, 15, 8, 3], backgroundColor: '#4f46e5', borderRadius: 4, barPercentage: 0.6 }
                    ]
                },
                options: {
                    responsive: true, maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'top', align: 'end', labels: { boxWidth: 10, usePointStyle: true, font: { size: 10, weight: 'bold', family: "'Plus Jakarta Sans', sans-serif" } } },
                        tooltip: { backgroundColor: '#1e293b', padding: 10, borderRadius: 8 }
                    },
                    scales: { y: { display: false, grid: { display: false } }, x: { grid: { display: false }, ticks: { font: { size: 10, weight: 'bold', family: "'Plus Jakarta Sans', sans-serif" }, color: '#94a3b8' } } }
                }
            });
        }

        // Grafik Traffic Source (Instagram)
        const canvasTrafficIG = document.getElementById('trafficSourceIGChart');
        if (canvasTrafficIG) {
            new Chart(canvasTrafficIG.getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: ['Beranda', 'Explore', 'Profil', 'Lainnya'],
                    datasets: [{ data: [55, 25, 15, 5], backgroundColor: ['#ec4899', '#a855f7', '#fb923c', '#cbd5e1'], borderWidth: 0, hoverOffset: 4 }]
                },
                options: {
                    responsive: true, maintainAspectRatio: false, cutout: '75%', 
                    plugins: { legend: { display: false }, tooltip: { backgroundColor: '#1e293b', bodyFont: { size: 12, weight: 'bold', family: "'Plus Jakarta Sans', sans-serif" }, padding: 10, cornerRadius: 8 } }
                }
            });
        }

        // Grafik Demografi (Umur & Gender TikTok API)
        const canvasDemoTikTok = document.getElementById('demographicTikTokChart');
        if (canvasDemoTikTok) {
            new Chart(canvasDemoTikTok.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: ['13-17', '18-24', '25-34', '35-44', '45-54', '55+'],
                    datasets: [
                        { label: 'Perempuan', data: [30, 45, 15, 5, 3, 2], backgroundColor: '#f43f5e', borderRadius: 4, barPercentage: 0.6 },
                        { label: 'Laki-laki', data: [20, 50, 20, 5, 3, 2], backgroundColor: '#06b6d4', borderRadius: 4, barPercentage: 0.6 }
                    ]
                },
                options: {
                    responsive: true, maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'top', align: 'end', labels: { boxWidth: 10, usePointStyle: true, font: { size: 10, weight: 'bold', family: "'Plus Jakarta Sans', sans-serif" } } },
                        tooltip: { backgroundColor: '#1e293b', padding: 10, borderRadius: 8 }
                    },
                    scales: { y: { display: false, grid: { display: false } }, x: { grid: { display: false }, ticks: { font: { size: 10, weight: 'bold', family: "'Plus Jakarta Sans', sans-serif" }, color: '#94a3b8' } } }
                }
            });
        }

        // Grafik Traffic Source (TikTok API)
        const canvasTraffic = document.getElementById('trafficSourceChart');
        if (canvasTraffic) {
            new Chart(canvasTraffic.getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: ['FYP', 'Following', 'Profil', 'Sound / lainnya'],
                    datasets: [{ data: [65, 20, 10, 5], backgroundColor: ['#0f172a', '#4f46e5', '#ec4899', '#fbbf24'], borderWidth: 0, hoverOffset: 4 }]
                },
                options: {
                    responsive: true, maintainAspectRatio: false, cutout: '75%', 
                    plugins: { legend: { display: false }, tooltip: { backgroundColor: '#1e293b', bodyFont: { size: 12, weight: 'bold', family: "'Plus Jakarta Sans', sans-serif" }, padding: 10, cornerRadius: 8 } }
                }
            });
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', renderStaticCharts);
    } else {
        renderStaticCharts();
    }
</script>
@endpush
@endsection