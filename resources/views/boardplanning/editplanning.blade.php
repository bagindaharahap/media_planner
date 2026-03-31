<!-- Modal Edit Planning -->
<div
    x-show="showEditModal"
    x-cloak
    class="fixed inset-0 z-[150] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
>
    <div
        @click.outside="showEditModal = false"
        class="bg-white w-full max-w-5xl max-h-[90vh] rounded-[2.5rem] shadow-2xl flex flex-col overflow-hidden border border-slate-200"
        x-transition:enter="transition ease-out duration-300 transform"
        x-transition:enter-start="opacity-0 scale-95 translate-y-8"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
    >
        <!-- Header -->
        <div class="px-8 py-6 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center text-white shadow-lg shadow-indigo-200">
                    <i class="fa-solid fa-pen-to-square"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-slate-800 tracking-tight">Edit Planning</h3>
                    <p class="text-xs text-slate-500 font-medium uppercase tracking-widest">Update details of an existing plan</p>
                </div>
            </div>
            <button type="button" @click="showEditModal = false" class="w-10 h-10 rounded-full hover:bg-slate-200 flex items-center justify-center text-slate-400 transition-colors">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>

        <!-- Body -->
        <div class="flex-1 overflow-y-auto p-8 space-y-8 custom-scrollbar">
            
            <!-- Top Grid: Status & Title -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="space-y-2">
                    <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Status</label>
                    <select x-model="editingPlanning.status" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500 transition-all outline-none">
                        <template x-for="status in allStatuses" :key="status.id">
                            <option :value="status.id" x-text="status.name" :selected="status.id === editingPlanning.status"></option>
                        </template>
                    </select>
                </div>
                <div class="md:col-span-3 space-y-2">
                    <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Planning Title</label>
                    <input type="text" x-model="editingPlanning.title" placeholder="Enter planning title..." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-5 py-3 text-lg font-bold text-slate-800 focus:ring-2 focus:ring-indigo-500 outline-none transition-all">
                </div>
            </div>

            <!-- Content Type Selection -->
            <div class="space-y-2">
                <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Content Type</label>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <template x-for="type in ['TikTok', 'Reels', 'Feed', 'Story']" :key="type">
                        <button 
                            @click="editingPlanning.content_type = type"
                            type="button"
                            class="flex items-center justify-center gap-3 px-4 py-3 rounded-2xl border-2 font-bold text-sm transition-all"
                            :class="editingPlanning.content_type === type 
                                ? 'bg-indigo-600 border-indigo-600 text-white shadow-lg shadow-indigo-100' 
                                : 'bg-white border-slate-100 text-slate-500 hover:border-indigo-200'"
                        >
                            <i class="fa-brands" :class="{
                                'fa-tiktok': type === 'TikTok',
                                'fa-instagram': type !== 'TikTok'
                            }"></i>
                            <span x-text="type"></span>
                        </button>
                    </template>
                </div>
            </div>

            <!-- Description (Rich Text Editor) -->
            <div class="space-y-3" x-data="{ 
                format(cmd, val = null) { 
                    document.execCommand(cmd, false, val); 
                    $refs.editEditor.focus();
                    this.updateContent();
                },
                updateContent() { 
                    editingPlanning.description = $refs.editEditor.innerHTML; 
                }
            }" x-init="$watch('showEditModal', value => { if(value) { setTimeout(() => { $refs.editEditor.innerHTML = editingPlanning.description || ''; }, 100); } })">
                <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Content Description</label>
                <div class="border border-slate-200 rounded-3xl overflow-hidden shadow-sm focus-within:ring-2 focus-within:ring-indigo-500/20 transition-all bg-white">
                    <div class="bg-slate-50 border-b border-slate-200 px-4 py-2 flex items-center gap-4 text-slate-400">
                        <div class="flex items-center gap-3 pr-4 border-r border-slate-200">
                            <button type="button" onmousedown="event.preventDefault()" @click="format('bold')" class="hover:text-indigo-600 p-1.5 transition-colors"><i class="fa-solid fa-bold"></i></button>
                            <button type="button" onmousedown="event.preventDefault()" @click="format('italic')" class="hover:text-indigo-600 p-1.5 transition-colors"><i class="fa-solid fa-italic"></i></button>
                            <button type="button" onmousedown="event.preventDefault()" @click="format('underline')" class="hover:text-indigo-600 p-1.5 transition-colors"><i class="fa-solid fa-underline"></i></button>
                        </div>
                        <div class="flex items-center gap-3">
                            <button type="button" onmousedown="event.preventDefault()" @click="format('insertUnorderedList')" class="hover:text-indigo-600 p-1.5 transition-colors"><i class="fa-solid fa-list-ul"></i></button>
                            <button type="button" onmousedown="event.preventDefault()" @click="let url = prompt('URL:'); if(url) format('createLink', url)" class="hover:text-indigo-600 p-1.5 transition-colors"><i class="fa-solid fa-link"></i></button>
                        </div>
                    </div>
                    <div 
                        x-ref="editEditor"
                        contenteditable="true" 
                        @input="updateContent()"
                        class="editor-content w-full p-6 min-h-[180px] text-sm text-slate-600 focus:outline-none bg-white"
                        data-placeholder="Write content details here..."
                    ></div>
                </div>
            </div>

            <!-- Date & Priority -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 p-6 bg-slate-50 rounded-3xl border border-slate-100">
                <div class="space-y-2">
                    <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Start Date</label>
                    <input type="date" x-model="editingPlanning.start_date" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm font-bold text-slate-700">
                </div>
                <div class="space-y-2">
                    <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Deadline (Due Date)</label>
                    <input type="date" x-model="editingPlanning.due_date" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm font-bold text-red-500">
                </div>
                <div class="space-y-2">
                    <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Priority</label>
                    <select x-model="editingPlanning.priority" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm font-bold text-slate-700 outline-none">
                        <option value="urgent">Urgent</option>
                        <option value="high">High</option>
                        <option value="normal">Normal</option>
                        <option value="low">Low</option>
                    </select>
                </div>
            </div>

            <!-- Team & Jobdesk Management -->
            <div class="space-y-4">
                <div class="flex items-center justify-between px-1">
                    <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest">Team & Jobdesk</label>
                    <button type="button" @click="if(!editingPlanning.assigned) editingPlanning.assigned = []; editingPlanning.assigned.push({ name: '', jobdesks: [], tools: [], customJob: '', customTool: '' })" class="text-indigo-600 text-xs font-black uppercase tracking-widest flex items-center gap-2 hover:text-indigo-700 transition-all">
                        <i class="fa-solid fa-user-plus"></i> Add Member
                    </button>
                </div>
                <div class="space-y-4">
                    <template x-for="(assign, index) in editingPlanning.assigned" :key="index">
                        <div class="p-6 bg-white border border-slate-200 rounded-3xl relative group/item hover:border-indigo-200 transition-all shadow-sm">
                            <button type="button" @click="editingPlanning.assigned.splice(index, 1)" x-show="editingPlanning.assigned.length > 1" class="absolute -top-2 -right-2 w-6 h-6 bg-red-500 text-white rounded-full text-[10px] flex items-center justify-center shadow-lg opacity-0 group-hover/item:opacity-100 transition-all">
                                <i class="fa-solid fa-times"></i>
                            </button>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <!-- Name Input -->
                                <div class="space-y-2">
                                    <label class="text-[10px] font-bold text-slate-400 uppercase">Name</label>
                                    <input type="text" x-model="assign.name" placeholder="Enter member name..." class="w-full bg-slate-50 border border-slate-100 rounded-xl px-3 py-2 text-sm font-bold text-slate-700 outline-none focus:ring-2 focus:ring-indigo-500 transition-all">
                                </div>
                                
                                <!-- Multi Select Jobdesk -->
                                <div class="space-y-2" x-data="{ open: false }">
                                    <label class="text-[10px] font-bold text-slate-400 uppercase">Jobdesk</label>
                                    <div class="relative">
                                        <button type="button" @click="open = !open; if(!assign.jobdesks) assign.jobdesks = []" class="w-full bg-slate-50 border border-slate-100 rounded-xl px-3 py-2 text-left text-sm font-bold text-slate-600 flex justify-between items-center transition-all">
                                            <span x-text="(assign.jobdesks || []).length ? (assign.jobdesks || []).length + ' Selected' : 'Select...'"></span>
                                            <i class="fa-solid fa-chevron-down text-[10px]"></i>
                                        </button>
                                        <div x-show="open" @click.outside="open = false" x-cloak class="absolute z-20 top-full mt-2 w-full bg-white border border-slate-200 rounded-2xl shadow-xl py-2 max-h-60 overflow-y-auto custom-scrollbar">
                                            <template x-for="job in jobdeskOptions" :key="job">
                                                <label class="flex items-center gap-3 px-4 py-2 hover:bg-slate-50 cursor-pointer">
                                                    <input type="checkbox" :value="job" x-model="assign.jobdesks" class="w-4 h-4 rounded text-indigo-600">
                                                    <span class="text-xs font-bold text-slate-600" x-text="job"></span>
                                                </label>
                                            </template>
                                            
                                            <!-- Custom Selected Tags (Jobdesk) -->
                                            <div x-show="(assign.jobdesks || []).filter(j => !jobdeskOptions.includes(j)).length > 0" class="px-4 py-2 border-t border-slate-100 flex flex-wrap gap-1.5 mt-1">
                                                <template x-for="cJob in (assign.jobdesks || []).filter(j => !jobdeskOptions.includes(j))" :key="cJob">
                                                    <span class="flex items-center gap-1.5 bg-indigo-50 text-indigo-600 text-[10px] font-bold px-2 py-1 rounded-lg">
                                                        <span x-text="cJob"></span>
                                                        <button type="button" @click="assign.jobdesks = assign.jobdesks.filter(j => j !== cJob)" class="hover:text-red-500"><i class="fa-solid fa-xmark"></i></button>
                                                    </span>
                                                </template>
                                            </div>

                                            <!-- Toggle Custom Input (Jobdesk) -->
                                            <div class="px-4 py-2 border-t border-slate-100 mt-1" x-data="{ showInput: false }">
                                                <button type="button" x-show="!showInput" @click="showInput = true" class="text-[10px] font-bold text-indigo-600 flex items-center gap-1.5 w-full hover:text-indigo-700 mt-1">
                                                    <i class="fa-solid fa-plus"></i> Add Custom Jobdesk
                                                </button>
                                                <div x-show="showInput" class="flex items-center gap-2 mt-1">
                                                    <input type="text" x-model="assign.customJob" @keydown.enter.prevent="if(assign.customJob.trim() !== '') { if(!assign.jobdesks) assign.jobdesks = []; assign.jobdesks.push(assign.customJob.trim()); assign.customJob = ''; showInput = false; }" placeholder="Type & Enter..." class="w-full text-xs font-bold p-2 border border-slate-200 rounded-lg outline-none focus:border-indigo-400">
                                                    <button type="button" @click.prevent="if(assign.customJob.trim() !== '') { if(!assign.jobdesks) assign.jobdesks = []; assign.jobdesks.push(assign.customJob.trim()); assign.customJob = ''; showInput = false; }" class="w-8 h-8 shrink-0 bg-indigo-50 text-indigo-600 rounded-lg flex items-center justify-center hover:bg-indigo-100"><i class="fa-solid fa-check text-xs"></i></button>
                                                    <button type="button" @click="showInput = false; assign.customJob = ''" class="w-8 h-8 shrink-0 bg-slate-50 text-slate-400 rounded-lg flex items-center justify-center hover:bg-slate-100 hover:text-red-500"><i class="fa-solid fa-xmark text-xs"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Multi Select Tools -->
                                <div class="space-y-2" x-data="{ open: false }">
                                    <label class="text-[10px] font-bold text-slate-400 uppercase">Tools</label>
                                    <div class="relative">
                                        <button type="button" @click="open = !open; if(!assign.tools) assign.tools = []" class="w-full bg-slate-50 border border-slate-100 rounded-xl px-3 py-2 text-left text-sm font-bold text-slate-600 flex justify-between items-center transition-all">
                                            <span x-text="(assign.tools || []).length ? (assign.tools || []).length + ' Selected' : 'Select...'"></span>
                                            <i class="fa-solid fa-chevron-down text-[10px]"></i>
                                        </button>
                                        <div x-show="open" @click.outside="open = false" x-cloak class="absolute z-20 top-full mt-2 w-full bg-white border border-slate-200 rounded-2xl shadow-xl py-2 max-h-60 overflow-y-auto custom-scrollbar">
                                            <template x-for="tool in toolOptions" :key="tool">
                                                <label class="flex items-center gap-3 px-4 py-2 hover:bg-slate-50 cursor-pointer">
                                                    <input type="checkbox" :value="tool" x-model="assign.tools" class="w-4 h-4 rounded text-indigo-600">
                                                    <span class="text-xs font-bold text-slate-600" x-text="tool"></span>
                                                </label>
                                            </template>
                                            
                                            <!-- Custom Selected Tags (Tools) -->
                                            <div x-show="(assign.tools || []).filter(t => !toolOptions.includes(t)).length > 0" class="px-4 py-2 border-t border-slate-100 flex flex-wrap gap-1.5 mt-1">
                                                <template x-for="cTool in (assign.tools || []).filter(t => !toolOptions.includes(t))" :key="cTool">
                                                    <span class="flex items-center gap-1.5 bg-indigo-50 text-indigo-600 text-[10px] font-bold px-2 py-1 rounded-lg">
                                                        <span x-text="cTool"></span>
                                                        <button type="button" @click="assign.tools = assign.tools.filter(t => t !== cTool)" class="hover:text-red-500"><i class="fa-solid fa-xmark"></i></button>
                                                    </span>
                                                </template>
                                            </div>

                                            <!-- Toggle Custom Input (Tools) -->
                                            <div class="px-4 py-2 border-t border-slate-100 mt-1" x-data="{ showInput: false }">
                                                <button type="button" x-show="!showInput" @click="showInput = true" class="text-[10px] font-bold text-indigo-600 flex items-center gap-1.5 w-full hover:text-indigo-700 mt-1">
                                                    <i class="fa-solid fa-plus"></i> Add Custom Tool
                                                </button>
                                                <div x-show="showInput" class="flex items-center gap-2 mt-1">
                                                    <input type="text" x-model="assign.customTool" @keydown.enter.prevent="if(assign.customTool.trim() !== '') { if(!assign.tools) assign.tools = []; assign.tools.push(assign.customTool.trim()); assign.customTool = ''; showInput = false; }" placeholder="Type & Enter..." class="w-full text-xs font-bold p-2 border border-slate-200 rounded-lg outline-none focus:border-indigo-400">
                                                    <button type="button" @click.prevent="if(assign.customTool.trim() !== '') { if(!assign.tools) assign.tools = []; assign.tools.push(assign.customTool.trim()); assign.customTool = ''; showInput = false; }" class="w-8 h-8 shrink-0 bg-indigo-50 text-indigo-600 rounded-lg flex items-center justify-center hover:bg-indigo-100"><i class="fa-solid fa-check text-xs"></i></button>
                                                    <button type="button" @click="showInput = false; assign.customTool = ''" class="w-8 h-8 shrink-0 bg-slate-50 text-slate-400 rounded-lg flex items-center justify-center hover:bg-slate-100 hover:text-red-500"><i class="fa-solid fa-xmark text-xs"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <!-- References -->
            <div class="space-y-4">
                <div class="flex items-center justify-between px-1">
                    <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest">References / Links</label>
                    <button type="button" @click="if(!editingPlanning.references) editingPlanning.references = []; editingPlanning.references.push('')" class="text-indigo-600 text-[10px] font-black uppercase tracking-widest hover:text-indigo-700 transition-all">+ Add Link</button>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <template x-for="(ref, rIndex) in editingPlanning.references" :key="rIndex">
                        <div class="flex gap-2 group/ref">
                            <div class="flex-1 bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 flex items-center gap-3 transition-all focus-within:ring-2 focus-within:ring-indigo-100">
                                <i class="fa-solid fa-link text-slate-300 text-xs"></i>
                                <input type="text" x-model="editingPlanning.references[rIndex]" placeholder="https://..." class="bg-transparent w-full text-sm font-bold text-slate-600 outline-none">
                            </div>
                            <button type="button" @click="editingPlanning.references.splice(rIndex, 1)" x-show="editingPlanning.references.length > 1" class="w-10 h-10 bg-red-50 text-red-500 rounded-xl flex items-center justify-center opacity-0 group-hover/ref:opacity-100 transition-all"><i class="fa-solid fa-trash text-xs"></i></button>
                        </div>
                    </template>
                </div>
            </div>

            <!-- Media Assets & Revision Notes -->
            <div class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Media Assets (CONNECTED TO GOOGLE DRIVE) -->
                    <div class="space-y-4" x-data="{
                        getGDriveId() {
                            let url = editingPlanning.media_link;
                            if (!url) return null;
                            let match = url.match(/\/file\/d\/([a-zA-Z0-9_-]+)/) || 
                                        url.match(/id=([a-zA-Z0-9_-]+)/) ||
                                        url.match(/\/d\/([a-zA-Z0-9_-]+)/);
                            return match ? match[1] : null;
                        },
                        isGDriveLink() {
                            return this.getGDriveId() !== null;
                        }
                    }">
                        <div class="flex items-center gap-2 px-1">
                            <i class="fa-brands fa-google-drive text-blue-500 text-xs"></i>
                            <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest">Media Assets (Google Drive)</label>
                        </div>
                        
                        <div class="space-y-4">
                            <!-- Shortcuts to Drive Folders -->
                            <div class="grid grid-cols-2 gap-3">
                                <a href="https://drive.google.com/drive/folders/1zPAEPDgKfMOp8i2AvslnoE9xd3y4YdoZ?usp=sharing" target="_blank" class="flex flex-col items-center justify-center p-3 bg-blue-50/50 border border-blue-100 rounded-xl hover:bg-blue-100 hover:border-blue-300 transition-all group shadow-sm">
                                    <i class="fa-solid fa-image text-blue-500 mb-1.5 text-lg group-hover:scale-110 transition-transform"></i>
                                    <span class="text-[10px] font-bold text-blue-700">Upload Image</span>
                                </a>
                                <a href="https://drive.google.com/drive/folders/1h4EaSVwsAE1tdVba-Wak2Xg0L8NHxOa_?usp=sharing" target="_blank" class="flex flex-col items-center justify-center p-3 bg-red-50/50 border border-red-100 rounded-xl hover:bg-red-100 hover:border-red-300 transition-all group shadow-sm">
                                    <i class="fa-solid fa-film text-red-500 mb-1.5 text-lg group-hover:scale-110 transition-transform"></i>
                                    <span class="text-[10px] font-bold text-red-700">Upload Video</span>
                                </a>
                            </div>

                            <!-- Input Paste Drive Link -->
                            <div class="bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 flex items-center gap-3 transition-all focus-within:ring-2 focus-within:ring-blue-100 focus-within:bg-white focus-within:border-blue-300">
                                <i class="fa-solid fa-link" :class="isGDriveLink() ? 'text-blue-500' : 'text-slate-300'"></i>
                                <input 
                                    type="text" 
                                    x-model="editingPlanning.media_link" 
                                    placeholder="Paste Google Drive file link here..." 
                                    class="bg-transparent w-full text-sm font-bold text-slate-700 outline-none"
                                >
                            </div>
                            
                            <!-- Google Drive Live Preview Area -->
                            <div class="border border-slate-200 rounded-2xl flex flex-col items-center justify-center transition-all group relative overflow-hidden bg-slate-50 shadow-inner"
                                 :class="isGDriveLink() ? 'p-0 min-h-[250px]' : 'p-6 border-dashed min-h-[160px]'">
                                
                                <template x-if="!editingPlanning.media_link">
                                    <div class="flex flex-col items-center text-center">
                                        <i class="fa-brands fa-google-drive text-slate-300 mb-2 text-3xl group-hover:text-blue-400 transition-colors"></i>
                                        <p class="text-[10px] font-bold text-slate-400">Your file preview will appear here</p>
                                    </div>
                                </template>

                                <template x-if="editingPlanning.media_link && !isGDriveLink()">
                                    <div class="flex flex-col items-center text-center">
                                        <i class="fa-solid fa-globe text-slate-300 mb-2 text-3xl"></i>
                                        <p class="text-[10px] font-bold text-slate-500">Link Attached (Not a valid GDrive URL)</p>
                                        <a :href="editingPlanning.media_link" target="_blank" class="text-xs text-blue-500 mt-2 font-bold hover:underline">Open Link</a>
                                    </div>
                                </template>

                                <template x-if="isGDriveLink()">
                                    <div class="w-full h-full absolute inset-0 bg-slate-900 flex items-center justify-center">
                                        <iframe 
                                            :src="'https://drive.google.com/file/d/' + getGDriveId() + '/preview'" 
                                            class="w-full h-full border-0" 
                                            allow="autoplay"
                                            title="Google Drive Preview">
                                        </iframe>
                                    </div>
                                </template>
                            </div>
                            <p class="text-[9px] text-slate-400 italic px-1">*External storage ensures your system server remains light.</p>
                        </div>
                    </div>

                    <!-- Revision Notes (Only visible from Review stage onwards) -->
                    <div class="space-y-4" x-show="!['backlog', 'progress'].includes(editingPlanning.status)" x-transition>
                        <div class="flex items-center gap-2 ml-1">
                            <i class="fa-solid fa-clipboard-check text-rose-500 text-xs"></i>
                            <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest">Revision Notes / Feedback</label>
                        </div>
                        <div class="relative">
                            <textarea 
                                x-model="editingPlanning.revision_note" 
                                rows="6" 
                                placeholder="Write the points that need to be improved by the team here..." 
                                class="w-full bg-rose-50/30 border border-rose-100 rounded-[2rem] p-6 text-sm text-slate-600 focus:ring-2 focus:ring-rose-500/20 focus:bg-white outline-none transition-all placeholder:text-slate-300 italic"
                            ></textarea>
                            <div class="absolute bottom-4 right-6 text-rose-200 pointer-events-none">
                                <i class="fa-solid fa-comment-dots text-2xl opacity-20"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="px-8 py-6 border-t border-slate-100 bg-slate-50/50 flex items-center justify-end gap-4">
            <button type="button" @click="showEditModal = false" class="px-8 py-3 rounded-2xl text-sm font-bold text-slate-500 hover:bg-slate-200 transition-all">Cancel</button>
            <button type="button" @click="executeUpdate()" class="bg-indigo-600 text-white px-10 py-3 rounded-2xl font-bold text-sm shadow-xl shadow-indigo-200 hover:bg-indigo-700 transform active:scale-95 transition-all">Save Changes</button>
        </div>
    </div>
</div>

<style>
    .editor-content b, .editor-content strong { font-weight: bold !important; }
    .editor-content i, .editor-content em { font-style: italic !important; }
    .editor-content u { text-decoration: underline !important; }
    .editor-content ul { list-style-type: disc !important; padding-left: 1.5rem !important; }
    .editor-content:empty:before { content: attr(data-placeholder); color: #cbd5e1; }
</style>