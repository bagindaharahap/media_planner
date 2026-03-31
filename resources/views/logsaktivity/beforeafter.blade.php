<!-- Log Detail Modal (Partial Component) -->
<div 
    x-data="logDetailModal()"
    x-on:show-log-detail.window="open($event.detail)"
    x-show="isOpen"
    x-cloak
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-[200] flex items-center justify-center bg-black/50 backdrop-blur-sm p-4"
>
    <div 
        class="bg-white w-full max-w-4xl rounded-[2rem] shadow-2xl flex flex-col overflow-hidden border border-slate-200"
        x-transition:enter="transition ease-out duration-200 transform"
        x-transition:enter-start="opacity-0 scale-95 translate-y-4"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
        @click.outside="close()"
    >
        <!-- HEADER -->
        <div class="px-8 py-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center text-white">
                    <i class="fa-solid fa-code-compare"></i>
                </div>
                <div>
                    <h2 class="text-lg font-black text-slate-800">Change Details</h2>
                    <p class="text-xs text-slate-500 font-medium" x-text="meta.activity || 'Activity log'"></p>
                </div>
            </div>
            <button @click="close()" class="w-9 h-9 rounded-full hover:bg-slate-200 flex items-center justify-center text-slate-400 transition-colors">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <!-- META INFO -->
        <div class="px-8 py-3 bg-slate-50 border-b border-slate-100 flex flex-wrap gap-4 text-xs font-semibold text-slate-500">
            <span><i class="fa-solid fa-user mr-1 text-indigo-400"></i><span x-text="meta.user || '-'"></span></span>
            <span><i class="fa-solid fa-layer-group mr-1 text-indigo-400"></i><span x-text="meta.module || '-'"></span></span>
            <span><i class="fa-solid fa-bolt mr-1 text-indigo-400"></i><span x-text="meta.action || '-'"></span></span>
            <span><i class="fa-regular fa-clock mr-1 text-indigo-400"></i><span x-text="meta.date || '-'"></span></span>
        </div>

        <!-- BODY -->
        <div class="flex-1 overflow-y-auto p-8 max-h-[60vh]">

            <!-- If action = create: only show After -->
            <template x-if="meta.action === 'create'">
                <div>
                    <p class="text-xs font-black text-slate-400 uppercase tracking-widest mb-3">Data Created</p>
                    <div class="space-y-2">
                        <template x-for="item in diffs" :key="item.key">
                            <div class="flex items-start gap-3 p-3 bg-emerald-50 border border-emerald-100 rounded-xl">
                                <span class="text-xs font-black text-slate-500 w-32 shrink-0 pt-0.5 uppercase" x-text="formatKey(item.key)"></span>
                                <span class="text-sm text-emerald-700 font-semibold flex-1" x-text="item.after ?? '-'"></span>
                            </div>
                        </template>
                    </div>
                </div>
            </template>

            <!-- If action = delete: only show Before -->
            <template x-if="meta.action === 'delete'">
                <div>
                    <p class="text-xs font-black text-slate-400 uppercase tracking-widest mb-3">Data Deleted</p>
                    <div class="space-y-2">
                        <template x-for="item in diffs" :key="item.key">
                            <div class="flex items-start gap-3 p-3 bg-rose-50 border border-rose-100 rounded-xl">
                                <span class="text-xs font-black text-slate-500 w-32 shrink-0 pt-0.5 uppercase" x-text="formatKey(item.key)"></span>
                                <span class="text-sm text-rose-600 font-semibold flex-1 line-through" x-text="item.before ?? '-'"></span>
                            </div>
                        </template>
                    </div>
                </div>
            </template>

            <!-- If action = update: show Before vs After with highlighting -->
            <template x-if="meta.action === 'update'">
                <div>
                    <!-- Legend -->
                    <div class="flex items-center gap-4 mb-4">
                        <span class="flex items-center gap-1.5 text-xs font-bold text-rose-500"><span class="w-3 h-3 rounded bg-rose-200 inline-block"></span> Old Data</span>
                        <span class="flex items-center gap-1.5 text-xs font-bold text-emerald-600"><span class="w-3 h-3 rounded bg-emerald-200 inline-block"></span> New Data</span>
                        <span class="flex items-center gap-1.5 text-xs font-bold text-amber-600"><span class="w-3 h-3 rounded bg-amber-200 inline-block"></span> Changed Text</span>
                    </div>

                    <div class="space-y-3">
                        <template x-for="item in diffs" :key="item.key">
                            <div class="border border-slate-200 rounded-2xl overflow-hidden">
                                <!-- Field Label -->
                                <div class="px-4 py-2 bg-slate-50 border-b border-slate-200">
                                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest" x-text="formatKey(item.key)"></span>
                                </div>
                                <div class="grid grid-cols-2 divide-x divide-slate-200">
                                    <!-- BEFORE -->
                                    <div class="p-4 bg-rose-50/40">
                                        <p class="text-[10px] font-black text-rose-400 uppercase tracking-widest mb-2">Before</p>
                                        <p class="text-sm leading-relaxed" x-html="highlightDiff(String(item.before ?? ''), String(item.after ?? ''), 'before')"></p>
                                    </div>
                                    <!-- AFTER -->
                                    <div class="p-4 bg-emerald-50/40">
                                        <p class="text-[10px] font-black text-emerald-500 uppercase tracking-widest mb-2">After</p>
                                        <p class="text-sm leading-relaxed" x-html="highlightDiff(String(item.before ?? ''), String(item.after ?? ''), 'after')"></p>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>

                    <!-- Empty state if no changes -->
                    <div x-show="diffs.length === 0" class="text-center py-10 text-slate-400">
                        <i class="fa-solid fa-check-circle text-3xl text-emerald-400 mb-2"></i>
                        <p class="font-semibold">No data changes detected.</p>
                    </div>
                </div>
            </template>

            <!-- If other actions (login/logout): show simple info -->
            <template x-if="meta.action !== 'create' && meta.action !== 'delete' && meta.action !== 'update'">
                <div class="text-center py-10 text-slate-400">
                    <i class="fa-solid fa-circle-info text-3xl text-indigo-300 mb-3"></i>
                    <p class="font-semibold text-slate-500" x-text="meta.activity"></p>
                    <p class="text-xs mt-1">This activity has no associated data changes.</p>
                </div>
            </template>
        </div>

        <!-- FOOTER -->
        <div class="px-8 py-4 border-t border-slate-100 bg-slate-50/50 flex justify-end">
            <button @click="close()" class="px-6 py-2.5 bg-slate-200 hover:bg-slate-300 text-slate-600 font-bold text-sm rounded-xl transition-all">
                Close
            </button>
        </div>
    </div>
</div>

<script>
function logDetailModal() {
    return {
        isOpen: false,
        diffs: [],
        meta: {},

        open(data) {
            this.isOpen = true;
            this.meta = {
                activity: data.activity || '',
                user:     data.user || '-',
                module:   data.module || '-',
                action:   data.action || '-',
                date:     data.date || '-',
            };

            const before = data.before || {};
            const after  = data.after  || {};
            const action = data.action || '';

            // Fields to exclude from display
            const skip = ['id', 'user_id', 'updated_at', 'created_at', 'remember_token'];

            if (action === 'create') {
                this.diffs = Object.keys(after)
                    .filter(k => !skip.includes(k) && after[k] !== null && after[k] !== '')
                    .map(k => ({ key: k, before: null, after: this.stringify(after[k]) }));

            } else if (action === 'delete') {
                this.diffs = Object.keys(before)
                    .filter(k => !skip.includes(k) && before[k] !== null && before[k] !== '')
                    .map(k => ({ key: k, before: this.stringify(before[k]), after: null }));

            } else if (action === 'update') {
                const keys = new Set([...Object.keys(before), ...Object.keys(after)]);
                this.diffs = [];
                keys.forEach(k => {
                    if (skip.includes(k)) return;
                    const b = this.stringify(before[k]);
                    const a = this.stringify(after[k]);
                    if (b !== a) {
                        this.diffs.push({ key: k, before: b, after: a });
                    }
                });
            } else {
                this.diffs = [];
            }
        },

        close() {
            this.isOpen = false;
            this.diffs = [];
            this.meta  = {};
        },

        stringify(val) {
            if (val === null || val === undefined) return '';
            if (typeof val === 'object') return JSON.stringify(val);
            return String(val);
        },

        formatKey(key) {
            return key.replace(/_/g, ' ');
        },

        // Word-level diff highlighting
        highlightDiff(before, after, side) {
            const bWords = before.split(/(\s+)/);
            const aWords = after.split(/(\s+)/);

            if (side === 'before') {
                return bWords.map(word => {
                    if (word.trim() === '') return word;
                    return aWords.includes(word)
                        ? `<span>${this.escapeHtml(word)}</span>`
                        : `<span class="bg-rose-200 text-rose-800 rounded px-0.5 font-semibold">${this.escapeHtml(word)}</span>`;
                }).join('');
            } else {
                return aWords.map(word => {
                    if (word.trim() === '') return word;
                    return bWords.includes(word)
                        ? `<span>${this.escapeHtml(word)}</span>`
                        : `<span class="bg-amber-200 text-amber-800 rounded px-0.5 font-semibold">${this.escapeHtml(word)}</span>`;
                }).join('');
            }
        },

        escapeHtml(text) {
            return text
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;');
        }
    }
}
</script>