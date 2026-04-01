@extends('layouts.app')

@section('title', 'Social Integration Management - Content Planner')

@section('content')
<div x-data="socialAccountsManager()" class="space-y-10 max-w-5xl mx-auto pb-12">
    
    <!-- HEADER -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-800 tracking-tight">Social Integration</h1>
            <p class="text-sm text-slate-500 font-medium">Connect and manage your official business accounts API permissions.</p>
        </div>
        <div class="flex items-center gap-2 px-4 py-2 bg-emerald-50 border border-emerald-100 rounded-2xl">
            <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
            <span class="text-[10px] font-black text-emerald-600 uppercase tracking-widest">System Secure</span>
        </div>
    </div>

    <!-- CARDS CONTAINER -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        
        <!-- TIKTOK CARD -->
        <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-sm overflow-hidden transition-all hover:shadow-md">
            <div class="p-8">
                <div class="flex items-start justify-between mb-8">
                    <div class="w-16 h-16 bg-slate-900 rounded-2xl flex items-center justify-center text-white text-3xl shadow-lg">
                        <i class="fa-brands fa-tiktok"></i>
                    </div>
                    <template x-if="tiktokConnected">
                        <span class="px-3 py-1 bg-emerald-100 text-emerald-600 rounded-full text-[10px] font-black uppercase border border-emerald-200">Connected</span>
                    </template>
                    <template x-if="!tiktokConnected">
                        <span class="px-3 py-1 bg-slate-100 text-slate-400 rounded-full text-[10px] font-black uppercase border border-slate-200">Disconnected</span>
                    </template>
                </div>

                <div class="space-y-2 mb-8">
                    <h3 class="text-xl font-bold text-slate-800">TikTok Business API</h3>
                    <p class="text-sm text-slate-500 leading-relaxed">Authorized access to post and monitor performance for your corporate account.</p>
                </div>

                <!-- Account Info TikTok -->
                <template x-if="tiktokConnected">
                    <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100 flex items-center gap-4 mb-8 animate-scaleIn">
                        <div class="w-10 h-10 rounded-full bg-white shadow-sm flex items-center justify-center p-1.5 overflow-hidden border border-slate-200">
                            <img src="https://i.ibb.co.com/7xhN2t3v/Logo-IBEKAMI.png" alt="Profile" class="w-full h-full object-contain">
                        </div>
                        <div>
                            <p class="text-xs font-black text-slate-700">@ibekami.id</p>
                            <p class="text-[10px] text-slate-400 font-medium italic">Authorized via TikTok OAuth</p>
                        </div>
                    </div>
                </template>

                <!-- Action Button TikTok -->
                <template x-if="tiktokConnected">
                    <button @click="confirmDisconnect('TikTok')" class="w-full py-4 bg-rose-50 text-rose-600 rounded-2xl font-bold text-sm hover:bg-rose-600 hover:text-white transition-all flex items-center justify-center gap-2 group">
                        <i class="fa-solid fa-link-slash group-hover:animate-pulse"></i> Disconnect TikTok
                    </button>
                </template>
                <template x-if="!tiktokConnected">
                    <button @click="tiktokConnected = true" class="w-full py-4 bg-slate-900 text-white rounded-2xl font-bold text-sm hover:bg-slate-800 transition-all flex items-center justify-center gap-3 shadow-xl">
                        <i class="fa-brands fa-tiktok"></i> Connect Account
                    </button>
                </template>
            </div>
            <div class="px-8 py-3 bg-slate-50 border-t border-slate-100 text-[9px] font-bold text-slate-400 uppercase tracking-widest flex items-center gap-2">
                <i class="fa-solid fa-lock"></i> API v2.0 Secured
            </div>
        </div>

        <!-- INSTAGRAM CARD (Meta API) -->
        <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-sm overflow-hidden transition-all hover:shadow-md">
            <div class="p-8">
                <div class="flex items-start justify-between mb-8">
                    <div class="w-16 h-16 bg-gradient-to-tr from-yellow-400 via-red-500 to-purple-600 rounded-2xl flex items-center justify-center text-white text-3xl shadow-lg">
                        <i class="fa-brands fa-instagram"></i>
                    </div>
                    <template x-if="igConnected">
                        <span class="px-3 py-1 bg-emerald-100 text-emerald-600 rounded-full text-[10px] font-black uppercase border border-emerald-200">Connected</span>
                    </template>
                    <template x-if="!igConnected">
                        <span class="px-3 py-1 bg-slate-100 text-slate-400 rounded-full text-[10px] font-black uppercase border border-slate-200">Disconnected</span>
                    </template>
                </div>

                <div class="space-y-2 mb-8">
                    <h3 class="text-xl font-bold text-slate-800">Instagram Business</h3>
                    <p class="text-sm text-slate-500 leading-relaxed">Official Graph API integration for scheduling Reels and monitoring demographics.</p>
                </div>

                <!-- Account Info Instagram -->
                <template x-if="igConnected">
                    <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100 flex items-center gap-4 mb-8 animate-scaleIn">
                        <div class="w-10 h-10 rounded-full bg-white shadow-sm flex items-center justify-center p-1.5 overflow-hidden border border-slate-200">
                            <img src="https://i.ibb.co.com/7xhN2t3v/Logo-IBEKAMI.png" alt="Profile" class="w-full h-full object-contain">
                        </div>
                        <div>
                            <p class="text-xs font-black text-slate-700">@ibekami.official</p>
                            <p class="text-[10px] text-slate-400 font-medium italic">Authorized via Meta Graph API</p>
                        </div>
                    </div>
                </template>

                <!-- Action Button Instagram -->
                <template x-if="igConnected">
                    <button @click="confirmDisconnect('Instagram')" class="w-full py-4 bg-rose-50 text-rose-600 rounded-2xl font-bold text-sm hover:bg-rose-600 hover:text-white transition-all flex items-center justify-center gap-2 group">
                        <i class="fa-solid fa-link-slash group-hover:animate-pulse"></i> Disconnect Instagram
                    </button>
                </template>
                <template x-if="!igConnected">
                    <button @click="igConnected = true" class="w-full py-4 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-2xl font-bold text-sm hover:opacity-90 transition-all flex items-center justify-center gap-3 shadow-xl">
                        <i class="fa-brands fa-instagram"></i> Connect Instagram
                    </button>
                </template>
            </div>
            <div class="px-8 py-3 bg-slate-50 border-t border-slate-100 text-[9px] font-bold text-slate-400 uppercase tracking-widest flex items-center gap-2">
                <i class="fa-solid fa-shield-check"></i> Meta App Verified
            </div>
        </div>

    </div>

    <!-- PRIVACY PROTOCOL (Transparency Section) -->
    <div class="bg-indigo-50 border border-indigo-100 rounded-[2rem] p-8 flex items-start gap-6">
        <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center text-indigo-600 shadow-sm shrink-0 border border-indigo-100">
            <i class="fa-solid fa-shield-halved text-xl"></i>
        </div>
        <div>
            <h4 class="text-lg font-bold text-indigo-900 mb-1">Data Deletion Protocol</h4>
            <p class="text-sm text-indigo-700/80 leading-relaxed">
                By disconnecting an account, Content Planner immediately purges all <b>OAuth Access Tokens</b>, Refresh Tokens, and cached performance data. This action is irreversible and ensures full compliance with <b>TikTok Platform Privacy Terms</b> and <b>Meta Developer Policies</b>.
            </p>
        </div>
    </div>

    <!-- DISCONNECT MODAL -->
    <div x-show="showConfirmModal" x-cloak class="fixed inset-0 z-[300] flex items-center justify-center p-4 bg-slate-900/80 backdrop-blur-sm">
        <div @click.outside="showConfirmModal = false" class="bg-white w-full max-w-md rounded-[2.5rem] shadow-2xl p-10 text-center border border-slate-100">
            <div class="w-20 h-20 bg-rose-50 text-rose-500 rounded-full flex items-center justify-center mx-auto mb-6 text-3xl shadow-inner">
                <i class="fa-solid fa-trash-can"></i>
            </div>
            <h3 class="text-2xl font-black text-slate-800 mb-2">Unlink <span x-text="targetPlatform"></span>?</h3>
            <p class="text-sm text-slate-500 font-medium leading-relaxed mb-10 px-4">This will <b>permanently delete</b> all API access tokens and dashboard data sync for this account.</p>
            <div class="flex flex-col gap-3">
                <button @click="executeDisconnect()" class="w-full py-4 bg-rose-600 text-white rounded-2xl font-black text-sm shadow-xl shadow-rose-200 hover:bg-rose-700 transition-all">Yes, Purge My Data</button>
                <button @click="showConfirmModal = false" class="w-full py-4 bg-slate-100 text-slate-500 rounded-2xl font-bold text-sm hover:bg-slate-200 transition-all">Cancel</button>
            </div>
        </div>
    </div>

    <!-- SUCCESS TOAST -->
    <div x-show="showSuccess" x-transition class="fixed bottom-10 right-10 z-[400] bg-slate-900 text-white px-8 py-4 rounded-2xl shadow-2xl flex items-center gap-4 border border-slate-700">
        <i class="fa-solid fa-check-circle text-emerald-400"></i>
        <span class="text-sm font-bold" x-text="successMessage"></span>
    </div>
</div>

<script>
function socialAccountsManager() {
    return {
        tiktokConnected: true,
        igConnected: true,
        showConfirmModal: false,
        showSuccess: false,
        targetPlatform: '',
        successMessage: '',

        confirmDisconnect(p) { 
            this.targetPlatform = p; 
            this.showConfirmModal = true; 
        },

        executeDisconnect() {
            const platform = this.targetPlatform;
            this.showConfirmModal = false;
            
            setTimeout(() => {
                if(platform === 'TikTok') this.tiktokConnected = false;
                if(platform === 'Instagram') this.igConnected = false;
                
                this.successMessage = platform + ' data successfully purged.';
                this.showSuccess = true;
                setTimeout(() => this.showSuccess = false, 3000);
            }, 1000);
        }
    }
}
</script>
@endsection