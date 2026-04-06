<!-- ============================================== -->
<!-- EDIT USER MODAL -->
<!-- ============================================== -->
<div x-show="showEditModal" x-cloak class="fixed inset-0 z-[150] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm" x-transition.opacity>
    <div @click.outside="showEditModal = false" class="bg-white w-full max-w-lg rounded-[2.5rem] shadow-2xl flex flex-col overflow-hidden border border-slate-200" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 scale-95 translate-y-4" x-transition:enter-end="opacity-100 scale-100 translate-y-0">
        <!-- Modal Header -->
        <div class="px-8 py-6 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center shadow-sm border border-indigo-100">
                    <i class="fa-solid fa-pen"></i>
                </div>
                <h3 class="text-lg font-bold text-slate-800 tracking-tight">Edit User Data</h3>
            </div>
            <button @click="showEditModal = false; resetPasswordVisibility()" class="w-8 h-8 rounded-full hover:bg-slate-200 flex items-center justify-center text-slate-400 transition-colors">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <!-- Wrapped in Form to Submit Data to Laravel -->
        <form :action="`{{ url('/management-akun') }}/${selectedUser?.id}`" method="POST" x-show="selectedUser" autocomplete="off">
            @csrf
            @method('PUT') <!-- Method Spoofing for Laravel UPDATE -->
            
            <div class="p-8 space-y-5">
                <div class="space-y-2">
                    <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Full Name</label>
                    <input type="text" name="name" x-model="selectedUser.name" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-bold text-slate-700 outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div class="space-y-2">
                    <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Email Address</label>
                    <input type="email" name="email" x-model="selectedUser.email" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-bold text-slate-700 outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div class="space-y-2">
                    <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Access Role</label>
                    <select name="role" x-model="selectedUser.role" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-bold text-slate-700 outline-none focus:ring-2 focus:ring-indigo-500">
                        <template x-for="role in roles">
                            <option :value="role" x-text="role"></option>
                        </template>
                    </select>
                </div>
                <div class="space-y-2">
                    <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Account Status</label>
                    <select name="status" x-model="selectedUser.status" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-bold text-slate-700 outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="Aktif">Active</option>
                        <option value="Nonaktif">Inactive</option>
                    </select>
                </div>
                <div class="space-y-2">
                    <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">New Password</label>
                    <div class="relative">
                        <input :type="showPassword ? 'text' : 'password'" name="password" autocomplete="new-password" placeholder="Leave blank if you do not want to change" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 pr-12 text-sm font-bold text-slate-700 outline-none focus:ring-2 focus:ring-indigo-500" value="">
                        <button type="button" @click="showPassword = !showPassword" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition-colors">
                            <i :class="showPassword ? 'fa-solid fa-eye-slash' : 'fa-solid fa-eye'" class="text-sm"></i>
                        </button>
                    </div>
                    <p class="text-[10px] text-slate-400 ml-1">Minimum 8 characters. Leave blank if you do not want to change password.</p>
                </div>
            </div>

            <!-- Footer -->
            <div class="px-8 py-5 border-t border-slate-100 bg-slate-50/50 flex gap-3">
                <button type="button" @click="showEditModal = false; resetPasswordVisibility()" class="flex-1 py-3 text-sm font-bold text-slate-500 hover:bg-slate-200 rounded-2xl transition-all">Cancel</button>
                <button type="submit" class="flex-[2] bg-indigo-600 text-white py-3 rounded-2xl font-bold text-sm hover:bg-indigo-700 transition-all">Save Changes</button>
            </div>
        </form>
    </div>
</div>