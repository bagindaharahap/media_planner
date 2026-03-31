@extends('layouts.app')

@section('title', 'Media Planner Dashboard - PlannerX')

@section('content')

<!-- Data from Database -->
<script id="plannings-data" type="application/json">
    {!! json_encode($plannings ?? []) !!}
</script>

<div class="space-y-8" x-data="dashboardData()">
    <!-- Primary Statistics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6">
        <!-- Instagram Engagement Rate -->
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm transition hover:-translate-y-1">
            <div class="flex justify-between items-start mb-4">
                <div class="w-10 h-10 bg-pink-50 rounded-xl flex items-center justify-center text-pink-600">
                    <i class="fa-solid fa-heart"></i>
                </div>
                <span class="text-green-500 text-[10px] font-bold bg-green-50 px-2 py-1 rounded-lg">+12.4%</span>
            </div>
            <p class="text-slate-500 text-[11px] font-semibold uppercase tracking-wider">IG Engagement</p>
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
            <p class="text-slate-500 text-[11px] font-semibold uppercase tracking-wider">TikTok Engagement</p>
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

        <!-- Scheduled Posts -->
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm transition hover:-translate-y-1">
            <div class="flex justify-between items-start mb-4">
                <div class="w-10 h-10 bg-orange-50 rounded-xl flex items-center justify-center text-orange-600">
                    <i class="fa-solid fa-calendar-plus"></i>
                </div>
            </div>
            <p class="text-slate-500 text-[11px] font-semibold uppercase tracking-wider">Scheduled Content</p>
            <h3 class="text-2xl font-black text-slate-900 mt-1" x-text="upcomingPosts.length + ' Posts'">0 Posts</h3>
        </div>
    </div>

    <!-- CONTENT BOARD STATUS CARDS -->
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

        <!-- Revision -->
        <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition hover:-translate-y-1">
            <div class="flex items-center gap-2 mb-3">
                <div class="w-2.5 h-2.5 rounded-full bg-amber-400 shadow-sm shadow-amber-400/50"></div>
                <p class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Revision</p>
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

    <!-- Dynamic Charts and AI Insights -->
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
        <!-- Main Chart (Chart.js) WITH FILTERS -->
        <div class="xl:col-span-3 bg-white p-8 rounded-[2rem] border border-slate-100 shadow-sm">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
                <div>
                    <h3 class="font-bold text-lg text-slate-800">Performance Statistics (<span class="capitalize" x-text="timeFilter"></span>)</h3>
                    
                    <!-- Dynamic Legend -->
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
                    <!-- Platform Filter Toggle -->
                    <div class="flex bg-slate-50 border border-slate-100 p-1 rounded-xl">
                        <button @click="platformFilter = 'semua'; renderPerformanceChart()" :class="platformFilter === 'semua' ? 'bg-white shadow-sm text-slate-800' : 'text-slate-400 hover:text-slate-600'" class="px-3 py-1.5 text-xs font-bold rounded-lg transition-all">All</button>
                        <button @click="platformFilter = 'ig'; renderPerformanceChart()" :class="platformFilter === 'ig' ? 'bg-white shadow-sm text-pink-600' : 'text-slate-400 hover:text-slate-600'" class="px-3 py-1.5 text-xs font-bold rounded-lg transition-all"><i class="fa-brands fa-instagram mr-1"></i> IG</button>
                        <button @click="platformFilter = 'tiktok'; renderPerformanceChart()" :class="platformFilter === 'tiktok' ? 'bg-white shadow-sm text-slate-900' : 'text-slate-400 hover:text-slate-600'" class="px-3 py-1.5 text-xs font-bold rounded-lg transition-all"><i class="fa-brands fa-tiktok mr-1"></i> TikTok</button>
                    </div>

                    <!-- Time Filter Select -->
                    <div class="relative">
                        <select x-model="timeFilter" @change="renderPerformanceChart()" class="bg-white border border-slate-200 text-slate-600 text-xs font-bold rounded-xl pl-4 pr-8 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 appearance-none transition-all cursor-pointer shadow-sm">
                            <option value="daily">Daily</option>
                            <option value="weekly">Weekly</option>
                            <option value="monthly">Monthly</option>
                            <option value="yearly">Yearly</option>
                        </select>
                        <i class="fa-solid fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-[10px] text-slate-400 pointer-events-none"></i>
                    </div>
                </div>
            </div>
            
            <div class="h-[350px] w-full relative">
                <canvas id="performanceChart"></canvas>
            </div>
        </div>
    </div>

    <!-- DEMOGRAPHICS & TRAFFIC SOURCE ANALYSIS -->
    <div>
        <h3 class="font-bold text-lg text-slate-800 mb-4 mt-8 flex items-center gap-2">
            <i class="fa-solid fa-users-viewfinder text-indigo-500"></i> Demographics & Traffic Sources
        </h3>
        
        <!-- Instagram (Meta API) -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
            <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm lg:col-span-2 hover:shadow-md transition">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h4 class="font-bold text-slate-800 text-sm">Age & Gender Distribution (IG)</h4>
                        <p class="text-[10px] text-slate-400 font-medium">Audience Demographic Data</p>
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
                        <p class="text-[10px] text-slate-400 font-medium">Where reach originates from?</p>
                    </div>
                    <span class="px-2 py-1 bg-pink-50 text-pink-600 border border-pink-100 text-[9px] font-black rounded-lg uppercase tracking-widest shadow-sm">
                        <i class="fa-brands fa-instagram mr-1"></i> Meta API
                    </span>
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

        <!-- TikTok API -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm lg:col-span-2 hover:shadow-md transition">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h4 class="font-bold text-slate-800 text-sm">Age & Gender Distribution (TikTok)</h4>
                        <p class="text-[10px] text-slate-400 font-medium">Audience Demographic Data</p>
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
                        <p class="text-[10px] text-slate-400 font-medium">Where views originate from?</p>
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
                    <div class="flex items-center gap-2"><div class="w-2 h-2 rounded-full bg-pink-500"></div> Profile (10%)</div>
                    <div class="flex items-center gap-2"><div class="w-2 h-2 rounded-full bg-amber-400"></div> Sound / others (5%)</div>
                </div>
            </div>
        </div>
    </div>

    <!-- DEEP CONTENT ANALYTICS -->
    <div>
        <h3 class="font-bold text-lg text-slate-800 mb-4 mt-8 flex items-center gap-2">
            <i class="fa-solid fa-photo-film text-indigo-500"></i> Deep Content Analytics & Retention
        </h3>
        
        <!-- TikTok Bar -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
            <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm flex flex-col justify-between hover:shadow-md transition relative overflow-hidden group">
                <div class="absolute -right-4 -top-4 w-20 h-20 bg-slate-50 rounded-full transition-transform group-hover:scale-150 z-0"></div>
                <div class="relative z-10">
                    <h4 class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-4">Video Completion Rate</h4>
                    <div class="flex items-end justify-between">
                        <div>
                            <h3 class="text-3xl font-black text-slate-800">34.2%</h3>
                            <p class="text-[10px] text-slate-400 mt-1 font-medium">Audience watched until end</p>
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
                            <p class="text-[10px] text-slate-400 mt-1 font-medium">New followers this week</p>
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
                        <h4 class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Specific Content Analytics</h4>
                        <p class="text-[10px] text-slate-400 font-medium mt-0.5">Average interaction metrics (last 24h)</p>
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
                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider mt-1">Comments</p>
                    </div>
                    <div class="p-3 bg-slate-50 border border-slate-100 rounded-2xl">
                        <p class="text-xl font-black text-slate-800">840</p>
                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider mt-1">Reposts</p>
                    </div>
                    <div class="p-3 bg-slate-50 border border-slate-100 rounded-2xl">
                        <p class="text-xl font-black text-slate-800">3.4K</p>
                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider mt-1">Saves</p>
                    </div>
                    <div class="p-3 bg-slate-50 border border-slate-100 rounded-2xl relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-8 h-8 bg-emerald-100 rounded-bl-full blur-md"></div>
                        <p class="text-xl font-black text-slate-800 relative z-10">1.8K</p>
                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider mt-1 relative z-10">Shares</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Instagram Bar -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm flex flex-col justify-between hover:shadow-md transition relative overflow-hidden group">
                <div class="absolute -right-4 -top-4 w-20 h-20 bg-pink-50 rounded-full transition-transform group-hover:scale-150 z-0"></div>
                <div class="relative z-10">
                    <h4 class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-4">Story Retention Rate</h4>
                    <div class="flex items-end justify-between">
                        <div>
                            <h3 class="text-3xl font-black text-slate-800">88.5%</h3>
                            <p class="text-[10px] text-slate-400 mt-1 font-medium">Audience watched until end</p>
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
                            <p class="text-[10px] text-slate-400 mt-1 font-medium">New followers this week</p>
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
                        <h4 class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Specific Content Analytics (IG)</h4>
                        <p class="text-[10px] text-slate-400 font-medium mt-0.5">Average Reels & Feed interaction metrics</p>
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
    </div>

    <!-- Upcoming Content List -->
    <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden mb-10 mt-8">
        <div class="p-8 border-b border-slate-50 flex justify-between items-center bg-slate-50/30">
            <h3 class="font-bold text-lg text-slate-800">Scheduled Content</h3>
            <a href="{{ route('board.index') }}" class="text-indigo-600 font-bold text-sm hover:underline">View Content Board <i class="fa-solid fa-chevron-right ml-1 text-[10px]"></i></a>
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
                                    <i class="fa-solid fa-clock text-[9px]"></i> <span x-text="post.due_date || post.start_date || 'Not set'"></span>
                                </span>
                                <span class="px-2 py-0.5 text-[9px] font-black rounded-md uppercase" :class="getPlatformColor(post.content_type)" x-text="post.content_type || 'Content'"></span>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-6">
                        <span class="px-3 py-1 text-[10px] font-bold uppercase rounded-lg" :class="getStatusStyle(post.status)" x-text="getStatusName(post.status)"></span>
                        <a href="{{ route('board.index') }}" class="text-slate-400 hover:text-indigo-600"><i class="fa-solid fa-arrow-up-right-from-square"></i></a>
                    </div>
                </div>
            </template>

            <!-- Empty State -->
            <template x-if="upcomingPosts.length === 0">
                <div class="p-10 text-center">
                    <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-3 text-slate-300">
                        <i class="fa-solid fa-folder-open text-2xl"></i>
                    </div>
                    <p class="text-slate-500 font-bold">No scheduled content yet</p>
                    <p class="text-xs text-slate-400 mt-1">Make sure you have created content in the Board Planning and linked the database correctly.</p>
                </div>
            </template>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>
<script>
    function dashboardData() {
        return {
            plannings: [],
            upcomingPosts: [],
            statusCounts: { backlog: 0, progress: 0, review: 0, revisi: 0, hold_on: 0, approved: 0, published: 0 },
            
            // Chart Filter States
            timeFilter: 'weekly',
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
                    console.error('Plannings data not found or parsing error.', e);
                }

                this.initPerformanceChart();
            },

            initPerformanceChart() {
                if (typeof Chart === 'undefined') {
                    setTimeout(() => this.initPerformanceChart(), 100);
                    return;
                }
                this.renderPerformanceChart();
            },

            getChartData() {
                const dataSets = {
                    daily: {
                        labels: ['00:00', '04:00', '08:00', '12:00', '16:00', '20:00', '23:59'],
                        ig: [120, 80, 450, 600, 320, 890, 400],
                        tiktok: [50, 40, 200, 850, 500, 1200, 600]
                    },
                    weekly: {
                        labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                        ig: [450, 520, 480, 610, 580, 720, 850],
                        tiktok: [300, 450, 890, 420, 650, 950, 1100]
                    },
                    monthly: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                        ig: [4.5, 5.1, 4.8, 6.2, 5.9, 7.1, 8.4, 9.2, 8.8, 10.1, 11.5, 12.8],
                        tiktok: [3.2, 4.8, 8.1, 5.5, 7.2, 9.5, 11.0, 14.5, 12.1, 16.8, 19.5, 22.4]
                    },
                    yearly: {
                        labels: ['2023', '2024', '2025', '2026'],
                        ig: [45.2, 68.4, 89.1, 128.4],
                        tiktok: [12.5, 145.2, 450.8, 842.0]
                    }
                };
                return dataSets[this.timeFilter];
            },

            renderPerformanceChart() {
                const canvas = document.getElementById('performanceChart');
                if (!canvas) return;
                const ctx = canvas.getContext('2d');

                if (this.mainChartObj) {
                    this.mainChartObj.destroy();
                }

                const data = this.getChartData();
                const gradientIg = ctx.createLinearGradient(0, 0, 0, 350);
                gradientIg.addColorStop(0, 'rgba(79, 70, 229, 0.2)');
                gradientIg.addColorStop(1, 'rgba(79, 70, 229, 0)');

                let activeDatasets = [];

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
                    'revisi': 'Revision',
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

    function renderStaticCharts() {
        if (typeof Chart === 'undefined') {
            setTimeout(renderStaticCharts, 100);
            return;
        }

        const canvasDemo = document.getElementById('demographicChart');
        if (canvasDemo) {
            new Chart(canvasDemo.getContext('2d'), {
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
                    plugins: {
                        legend: { position: 'top', align: 'end', labels: { boxWidth: 10, usePointStyle: true, font: { size: 10, weight: 'bold', family: "'Plus Jakarta Sans', sans-serif" } } },
                        tooltip: { backgroundColor: '#1e293b', padding: 10, borderRadius: 8 }
                    },
                    scales: { y: { display: false, grid: { display: false } }, x: { grid: { display: false }, ticks: { font: { size: 10, weight: 'bold', family: "'Plus Jakarta Sans', sans-serif" }, color: '#94a3b8' } } }
                }
            });
        }

        const canvasTrafficIG = document.getElementById('trafficSourceIGChart');
        if (canvasTrafficIG) {
            new Chart(canvasTrafficIG.getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: ['Home', 'Explore', 'Profile', 'Others'],
                    datasets: [{ data: [55, 25, 15, 5], backgroundColor: ['#ec4899', '#a855f7', '#fb923c', '#cbd5e1'], borderWidth: 0, hoverOffset: 4 }]
                },
                options: {
                    responsive: true, maintainAspectRatio: false, cutout: '75%', 
                    plugins: { legend: { display: false }, tooltip: { backgroundColor: '#1e293b', bodyFont: { size: 12, weight: 'bold', family: "'Plus Jakarta Sans', sans-serif" }, padding: 10, cornerRadius: 8 } }
                }
            });
        }

        const canvasDemoTikTok = document.getElementById('demographicTikTokChart');
        if (canvasDemoTikTok) {
            new Chart(canvasDemoTikTok.getContext('2d'), {
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
                    plugins: {
                        legend: { position: 'top', align: 'end', labels: { boxWidth: 10, usePointStyle: true, font: { size: 10, weight: 'bold', family: "'Plus Jakarta Sans', sans-serif" } } },
                        tooltip: { backgroundColor: '#1e293b', padding: 10, borderRadius: 8 }
                    },
                    scales: { y: { display: false, grid: { display: false } }, x: { grid: { display: false }, ticks: { font: { size: 10, weight: 'bold', family: "'Plus Jakarta Sans', sans-serif" }, color: '#94a3b8' } } }
                }
            });
        }

        const canvasTraffic = document.getElementById('trafficSourceChart');
        if (canvasTraffic) {
            new Chart(canvasTraffic.getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: ['FYP', 'Following', 'Profile', 'Sound / others'],
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