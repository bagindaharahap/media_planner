<!-- Modal Post to TikTok (Simulasi API untuk Demo) -->
<div 
    x-data="tiktokPostModal()" 
    x-show="isOpen" 
    x-cloak
    class="fixed inset-0 z-[200] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
    x-on:open-tiktok-post.window="open($event.detail)"
>
    <div 
        @click.outside="if(!isPosting) close()"
        class="bg-white w-full max-w-4xl rounded-[2.5rem] shadow-2xl flex flex-col md:flex-row overflow-hidden border border-slate-200"
        x-transition:enter="transition ease-out duration-300 transform"
        x-transition:enter-start="opacity-0 scale-95 translate-y-8"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
    >
        <!-- PRATINJAU VIDEO -->
        <div class="w-full md:w-[320px] bg-black relative flex items-center justify-center min-h-[400px]">
            <template x-if="videoUrl">
                <video :src="videoUrl" class="h-full w-full object-contain" controls></video>
            </template>
            <template x-if="!videoUrl">
                <div class="text-white/40 text-center p-8">
                    <i class="fa-solid fa-video text-4xl mb-4"></i>
                    <p class="text-xs font-bold uppercase tracking-widest">Video Preview</p>
                </div>
            </template>
            <div class="absolute top-6 left-6 text-white/50 text-xl italic font-black">
                <i class="fa-brands fa-tiktok"></i>
            </div>
        </div>

        <!-- FORM POSTING -->
        <div class="flex-1 p-8 md:p-10 flex flex-col bg-white">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h3 class="text-xl font-black text-slate-800 tracking-tight">Post to TikTok</h3>
                    <p class="text-xs text-slate-500 font-medium mt-1">Official Content Posting API Integration</p>
                </div>
                <button @click="close()" x-show="!isPosting" class="text-slate-400 hover:text-slate-600">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>

            <div class="space-y-6 flex-1">
                <div class="space-y-2">
                    <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Caption / Description</label>
                    <textarea x-model="form.caption" rows="3" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm font-semibold text-slate-700 focus:ring-2 focus:ring-indigo-500 outline-none transition-all"></textarea>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Privacy Level</label>
                        <select x-model="form.privacy" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs font-bold text-slate-600 outline-none">
                            <option value="PUBLIC_TO_EVERYONE">Public</option>
                            <option value="SELF_ONLY">Private</option>
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Interactions</label>
                        <div class="flex items-center gap-3 mt-2 font-bold text-[10px] text-slate-500">
                            <label class="flex items-center gap-1"><input type="checkbox" x-model="form.allow_comments"> Comments</label>
                            <label class="flex items-center gap-1"><input type="checkbox" x-model="form.allow_duet"> Duet</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-10 pt-6 border-t border-slate-100 flex items-center justify-end">
                <button @click="submitPost()" :disabled="isPosting" class="bg-indigo-600 text-white px-10 py-3 rounded-2xl font-black text-sm shadow-xl shadow-indigo-100 hover:bg-indigo-700 transition-all">
                    <span x-show="!isPosting"><i class="fa-solid fa-paper-plane mr-2"></i> Post Now</span>
                    <span x-show="isPosting" class="flex items-center gap-2">
                        <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        Processing...
                    </span>
                </button>
            </div>
        </div>
    </div>

    <!-- SUCCESS NOTIFICATION -->
    <div x-show="showSuccess" class="fixed inset-0 z-[210] flex items-center justify-center p-4 bg-indigo-900/40 backdrop-blur-md">
        <div class="bg-white rounded-[3rem] p-10 text-center max-w-sm shadow-2xl">
            <div class="w-20 h-20 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-6 text-4xl">
                <i class="fa-solid fa-check"></i>
            </div>
            <h4 class="text-2xl font-black text-slate-800 mb-2">Success!</h4>
            <p class="text-sm text-slate-500 font-medium mb-8">Video has been posted to TikTok official account.</p>
            <button @click="resetAll()" class="w-full py-4 bg-slate-900 text-white rounded-2xl font-bold text-sm hover:bg-slate-800 transition-all">Done</button>
        </div>
    </div>
</div>

<script>
function tiktokPostModal() {
    return {
        isOpen: false,
        isPosting: false,
        showSuccess: false,
        videoUrl: null,
        form: { caption: '', privacy: 'PUBLIC_TO_EVERYONE', allow_comments: true, allow_duet: true },
        open(detail) {
            this.isOpen = true;
            this.videoUrl = detail.videoUrl;
            this.form.caption = detail.title;
        },
        close() { this.isOpen = false; },
        submitPost() {
            this.isPosting = true;
            setTimeout(() => {
                this.isPosting = false;
                this.showSuccess = true;
            }, 3000);
        },
        resetAll() {
            this.isOpen = false;
            this.showSuccess = false;
            this.isPosting = false;
        }
    }
}
</script>