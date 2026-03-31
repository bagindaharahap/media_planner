<!-- ============================================== -->
<!-- ADD USER MODAL -->
<!-- ============================================== -->
<div x-show="showCreateModal" x-cloak class="fixed inset-0 z-[150] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm" x-transition.opacity>
    <div @click.outside="showCreateModal = false" class="bg-white w-full max-w-lg rounded-[2.5rem] shadow-2xl flex flex-col overflow-hidden border border-slate-200" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 scale-95 translate-y-4" x-transition:enter-end="opacity-100 scale-100 translate-y-0">
        <!-- Header -->
        <div class="px-8 py-6 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center text-white shadow-lg">
                    <i class="fa-solid fa-user-plus"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-slate-800 tracking-tight">Add New User</h3>
                </div>
            </div>
            <button @click="showCreateModal = false; resetPasswordVisibility()" class="w-8 h-8 rounded-full hover:bg-slate-200 flex items-center justify-center text-slate-400 transition-colors">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <!-- Form Wrapper for Database Endpoint -->
        <form action="{{ route('users.store') }}" method="POST">
            @csrf
            <!-- Form Body -->
            <div class="p-8 space-y-5">
                <div class="space-y-2">
                    <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Full Name</label>
                    <input type="text" name="name" required placeholder="Full Name" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500 outline-none transition-all">
                </div>
                <div class="space-y-2">
                    <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Email Address</label>
                    <input type="email" name="email" required placeholder="email@company.com" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500 outline-none transition-all">
                </div>
                <div class="space-y-2">
                    <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Access Role</label>
                    <select name="role" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500 outline-none transition-all cursor-pointer">
                        <option value="">Select Role...</option>
                        <template x-for="role in roles">
                            <option :value="role" x-text="role"></option>
                        </template>
                    </select>
                </div>
                <div class="space-y-2">
                    <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Temporary Password</label>
                    <div class="relative">
                        <input :type="showPassword ? 'text' : 'password'" name="password" required autocomplete="new-password" placeholder="Min. 8 Characters" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 pr-12 text-sm font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500 outline-none transition-all">
                        <button type="button" @click="showPassword = !showPassword" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition-colors">
                            <i :class="showPassword ? 'fa-solid fa-eye-slash' : 'fa-solid fa-eye'" class="text-sm"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="px-8 py-5 border-t border-slate-100 bg-slate-50/50 flex gap-3">
                <button type="button" @click="showCreateModal = false; resetPasswordVisibility()" class="flex-1 py-3 text-sm font-bold text-slate-500 hover:bg-slate-200 rounded-2xl transition-all">Cancel</button>
                <button type="submit" class="flex-[2] bg-indigo-600 text-white py-3 rounded-2xl font-bold text-sm shadow-xl shadow-indigo-200 hover:bg-indigo-700 transition-all transform active:scale-95">Save User</button>
            </div>
        </form>
    </div>
</div>