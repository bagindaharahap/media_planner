@extends('layouts.app')

@section('title', 'Dasbor Media Planner - PlannerX')

@section('content')

<!-- Data dari Database -->
<script id="plannings-data" type="application/json">
    {!! json_encode($plannings ?? []) !!}
</script>

<div class="space-y-8" x-data="dashboardData()">
    <!-- Barisan Kartu Statistik (Stat Cards) Utama -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Engagement Rate -->
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm transition hover:-translate-y-1">
            <div class="flex justify-between items-start mb-4">
                <div class="w-10 h-10 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-600">
                    <i class="fa-solid fa-heart"></i>
                </div>
                <span class="text-green-500 text-[10px] font-bold bg-green-50 px-2 py-1 rounded-lg">+12.4%</span>
            </div>
            <p class="text-slate-500 text-xs font-semibold uppercase tracking-wider">Engagement Rate</p>
            <h3 class="text-2xl font-black text-slate-900 mt-1">4.82%</h3>
        </div>

        <!-- Instagram Stats -->
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm transition hover:-translate-y-1">
            <div class="flex justify-between items-start mb-4">
                <div class="w-10 h-10 bg-pink-50 rounded-xl flex items-center justify-center text-pink-600">
                    <i class="fa-brands fa-instagram"></i>
                </div>
                <span class="text-green-500 text-[10px] font-bold bg-green-50 px-2 py-1 rounded-lg">+8.1%</span>
            </div>
            <p class="text-slate-500 text-xs font-semibold uppercase tracking-wider">IG Impressions</p>
            <h3 class="text-2xl font-black text-slate-900 mt-1">128.4K</h3>
        </div>

        <!-- TikTok Stats -->
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm transition hover:-translate-y-1">
            <div class="flex justify-between items-start mb-4">
                <div class="w-10 h-10 bg-slate-900 rounded-xl flex items-center justify-center text-white text-sm">
                    <i class="fa-brands fa-tiktok"></i>
                </div>
                <span class="text-green-500 text-[10px] font-bold bg-green-50 px-2 py-1 rounded-lg">+22.5%</span>
            </div>
            <p class="text-slate-500 text-xs font-semibold uppercase tracking-wider">TikTok Views</p>
            <h3 class="text-2xl font-black text-slate-900 mt-1">842.0K</h3>
        </div>

        <!-- Scheduled Posts (Terintegrasi) -->
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm transition hover:-translate-y-1">
            <div class="flex justify-between items-start mb-4">
                <div class="w-10 h-10 bg-orange-50 rounded-xl flex items-center justify-center text-orange-600">
                    <i class="fa-solid fa-calendar-plus"></i>
                </div>
            </div>
            <p class="text-slate-500 text-xs font-semibold uppercase tracking-wider">Konten Terjadwal</p>
            <h3 class="text-2xl font-black text-slate-900 mt-1" x-text="upcomingPosts.length + ' Post'">0 Post</h3>
        </div>
    </div>

    <!-- KARTU STATUS BOARD PLANNING BARU -->
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

    <!-- Bagian Grafik dan Insight AI -->
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
        <!-- Grafik Utama (Chart.js) -->
        <div class="xl:col-span-2 bg-white p-8 rounded-[2rem] border border-slate-100 shadow-sm">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
                <h3 class="font-bold text-lg text-slate-800">Statistik Performa Mingguan</h3>
                <div class="flex gap-4">
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded-full bg-indigo-600"></div>
                        <span class="text-[10px] font-bold text-slate-400 uppercase">Instagram</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded-full bg-slate-900"></div>
                        <span class="text-[10px] font-bold text-slate-400 uppercase">TikTok</span>
                    </div>
                </div>
            </div>
            <div class="h-[350px] w-full">
                <canvas id="performanceChart"></canvas>
            </div>
        </div>

        <!-- Panel Insight AI -->
        <div class="bg-slate-900 p-8 rounded-[2rem] text-white relative overflow-hidden flex flex-col justify-between">
            <div class="relative z-10">
                <h3 class="font-bold text-lg mb-6 flex items-center gap-2">
                    <i class="fa-solid fa-wand-magic-sparkles text-indigo-400"></i> Targeting AI
                </h3>
                
                <div class="space-y-6">
                    <div class="bg-white/5 border border-white/10 p-5 rounded-2xl">
                        <p class="text-[10px] font-bold text-indigo-300 uppercase tracking-widest mb-1">Waktu Posting Terbaik</p>
                        <p class="text-2xl font-bold mb-1">21:15 <span class="text-xs font-normal text-slate-400">WIB</span></p>
                        <p class="text-[10px] text-slate-400 italic">Analisis berdasarkan data interaksi akun Anda.</p>
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
            
            <!-- Dekorasi Blur -->
            <div class="absolute -right-8 -top-8 w-32 h-32 bg-indigo-600/20 rounded-full blur-3xl"></div>
        </div>
    </div>

    <!-- Daftar Konten Mendatang (Terintegrasi) -->
    <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden mb-10">
        <div class="p-8 border-b border-slate-50 flex justify-between items-center bg-slate-50/30">
            <h3 class="font-bold text-lg text-slate-800">Konten Terjadwal</h3>
            <a href="{{ route('board.index') }}" class="text-indigo-600 font-bold text-sm hover:underline">Lihat Board Planning <i class="fa-solid fa-chevron-right ml-1 text-[10px]"></i></a>
        </div>
        
        <div class="divide-y divide-slate-50 text-sm">
            <template x-for="post in upcomingPosts" :key="post.id">
                <!-- Item Dynamic -->
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
@endsection

@push('scripts')
<!-- Tambahkan CDN Chart.js agar objek Chart dapat dikenali -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // FUNGSI UNTUK ALPINE JS TERINTEGRASI DB
    function dashboardData() {
        return {
            plannings: [],
            upcomingPosts: [],
            // Menambahkan state penampung jumlah status
            statusCounts: { backlog: 0, progress: 0, review: 0, revisi: 0, hold_on: 0, approved: 0, published: 0 },
            
            init() {
                try {
                    // Ambil raw text dari Laravel
                    let rawDataText = document.getElementById('plannings-data').textContent;
                    let rawData = JSON.parse(rawDataText);
                    
                    this.plannings = rawData;
                    
                    // Hitung jumlah untuk masing-masing status
                    this.plannings.forEach(p => {
                        if(this.statusCounts[p.status] !== undefined) {
                            this.statusCounts[p.status]++;
                        }
                    });
                    
                    // DEBUGGING: Cek apakah data masuk dari database
                    console.log("🔥 Data dari Database:", this.plannings);
                    console.log("📊 Status Counts:", this.statusCounts);

                    // Filter yang bukan published, lalu urutkan berdasarkan due_date terdekat
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
                        
                    console.log("📌 Data Konten Terjadwal:", this.upcomingPosts);

                } catch(e) {
                    console.error('Data plannings tidak ditemukan atau error parsing.', e);
                }
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

    // Inisialisasi Grafik Performa
    const ctx = document.getElementById('performanceChart').getContext('2d');
    
    // Gradient untuk Instagram
    const gradientIg = ctx.createLinearGradient(0, 0, 0, 350);
    gradientIg.addColorStop(0, 'rgba(79, 70, 229, 0.2)');
    gradientIg.addColorStop(1, 'rgba(79, 70, 229, 0)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
            datasets: [
                {
                    label: 'Instagram',
                    data: [450, 520, 480, 610, 580, 720, 850],
                    borderColor: '#4f46e5',
                    borderWidth: 4,
                    tension: 0.4,
                    fill: true,
                    backgroundColor: gradientIg,
                    pointRadius: 0,
                    pointHoverRadius: 6,
                },
                {
                    label: 'TikTok',
                    data: [300, 450, 890, 420, 650, 950, 1100],
                    borderColor: '#0f172a',
                    borderWidth: 4,
                    tension: 0.4,
                    pointRadius: 0,
                    pointHoverRadius: 6,
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1e293b',
                    padding: 12,
                    titleFont: { size: 14, weight: 'bold' },
                    bodyFont: { size: 13 },
                    displayColors: false,
                    borderRadius: 8
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { borderDash: [5, 5], color: '#f1f5f9', drawBorder: false },
                    ticks: { font: { weight: 'bold', size: 10 }, color: '#94a3b8' }
                },
                x: {
                    grid: { display: false },
                    ticks: { font: { weight: 'bold', size: 10 }, color: '#94a3b8' }
                }
            }
        }
    });
</script>
@endpush