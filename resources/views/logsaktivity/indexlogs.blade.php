@extends('layouts.app')

@section('title', 'Activity Logs - Content Planner')

@section('content')
<div class="space-y-6">

    <!-- HEADER -->
    <div class="bg-white p-6 rounded-[2rem] border border-slate-200 shadow-sm flex flex-col md:flex-row items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 bg-indigo-50 rounded-2xl flex items-center justify-center text-indigo-600">
                <i class="fa-solid fa-clock-rotate-left text-xl"></i>
            </div>
            <div>
                <h2 class="text-xl font-black text-slate-800 tracking-tight">Activity Logs</h2>
                <p class="text-xs text-slate-500 font-medium">History of all activities within the system</p>
            </div>
        </div>

        <!-- FILTER FORM -->
        <form method="GET" action="{{ route('logs.index') }}" class="flex flex-wrap items-center gap-3">
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Search user, activity..."
                class="px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 w-52">

            <select name="module" class="px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-indigo-500 text-slate-600 font-semibold">
                <option value="">All Modules</option>
                @foreach(['Auth','Planning','Notes','Prompt','User'] as $mod)
                    <option value="{{ $mod }}" {{ request('module') == $mod ? 'selected' : '' }}>{{ $mod }}</option>
                @endforeach
            </select>

            <input type="date" name="start_date" value="{{ request('start_date') }}"
                class="px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-indigo-500">
            <span class="text-slate-400 text-sm">—</span>
            <input type="date" name="end_date" value="{{ request('end_date') }}"
                class="px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-indigo-500">

            <button type="submit" class="px-5 py-2.5 bg-indigo-600 text-white text-sm font-bold rounded-xl hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-200">
                <i class="fa-solid fa-magnifying-glass mr-1"></i> Filter
            </button>
            @if(request()->hasAny(['search','module','start_date','end_date']))
                <a href="{{ route('logs.index') }}" class="px-4 py-2.5 bg-slate-100 text-slate-600 text-sm font-bold rounded-xl hover:bg-slate-200 transition-all">Reset</a>
            @endif
        </form>
    </div>

    <!-- TABLE -->
    <div class="bg-white rounded-[2rem] border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-200 text-[10px] font-black uppercase tracking-widest text-slate-400">
                        <th class="p-5 pl-8">User</th>
                        <th class="p-5">Activity</th>
                        <th class="p-5">Module</th>
                        <th class="p-5">Action</th>
                        <th class="p-5">Time</th>
                        <th class="p-5 text-center">Detail</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse($logs as $log)
                    <tr class="hover:bg-indigo-50/20 transition-colors">

                        <!-- USER -->
                        <td class="p-5 pl-8">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center text-white text-xs font-black uppercase shrink-0">
                                    {{ substr($log->user->name ?? 'U', 0, 2) }}
                                </div>
                                <div>
                                    <p class="font-bold text-slate-700">{{ $log->user->name ?? '-' }}</p>
                                    <p class="text-[10px] text-slate-400">{{ $log->user->role ?? '' }}</p>
                                </div>
                            </div>
                        </td>

                        <!-- ACTIVITY -->
                        <td class="p-5 text-slate-500 max-w-xs">
                            <p class="truncate">{{ $log->activity }}</p>
                        </td>

                        <!-- MODULE -->
                        <td class="p-5">
                            @php
                                $moduleColors = [
                                    'Auth'     => 'bg-purple-50 text-purple-600',
                                    'Planning' => 'bg-indigo-50 text-indigo-600',
                                    'Notes'    => 'bg-sky-50 text-sky-600',
                                    'Prompt'   => 'bg-amber-50 text-amber-600',
                                    'User'     => 'bg-rose-50 text-rose-600',
                                ];
                                $mc = $moduleColors[$log->module] ?? 'bg-slate-100 text-slate-600';
                            @endphp
                            <span class="px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider {{ $mc }}">
                                {{ $log->module }}
                            </span>
                        </td>

                        <!-- ACTION -->
                        <td class="p-5">
                            @php
                                $actionColors = [
                                    'create' => 'bg-emerald-50 text-emerald-600',
                                    'update' => 'bg-amber-50 text-amber-600',
                                    'delete' => 'bg-rose-50 text-rose-600',
                                    'login'  => 'bg-blue-50 text-blue-600',
                                    'logout' => 'bg-slate-100 text-slate-500',
                                ];
                                $ac = $actionColors[$log->action] ?? 'bg-slate-100 text-slate-500';
                            @endphp
                            <span class="px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider {{ $ac }}">
                                {{ $log->action }}
                            </span>
                        </td>

                        <!-- DATE -->
                        <td class="p-5 text-slate-500 text-xs font-medium whitespace-nowrap">
                            <i class="fa-regular fa-clock mr-1 text-slate-300"></i>
                            {{ $log->created_at->format('d M Y, H:i') }}
                        </td>

                        <!-- VIEW BUTTON -->
                        <td class="p-5 text-center">
                            <button
                                onclick="openLogDetail(this)"
                                data-log="{{ json_encode([
                                    'activity' => $log->activity,
                                    'user'     => $log->user->name ?? '-',
                                    'module'   => $log->module,
                                    'action'   => $log->action,
                                    'date'     => $log->created_at->format('d M Y, H:i'),
                                    'before'   => $log->before,
                                    'after'    => $log->after,
                                ], JSON_HEX_QUOT | JSON_HEX_APOS) }}"
                                class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 hover:bg-indigo-600 hover:text-white flex items-center justify-center transition-colors shadow-sm mx-auto"
                                title="View Details"
                            >
                                <i class="fa-solid fa-eye text-xs"></i>
                            </button>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="p-10 text-center">
                            <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-3 text-slate-300">
                                <i class="fa-solid fa-folder-open text-2xl"></i>
                            </div>
                            <p class="text-slate-500 font-bold">No activity logs found.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- PAGINATION -->
        @if($logs->hasPages())
        <div class="px-6 py-4 bg-slate-50/50 border-t border-slate-200 flex items-center justify-between">
            <p class="text-xs text-slate-500 font-medium">
                Showing {{ $logs->firstItem() }}–{{ $logs->lastItem() }} of {{ $logs->total() }} entries
            </p>
            <div class="flex items-center gap-1.5">
                @if($logs->onFirstPage())
                    <span class="w-8 h-8 flex items-center justify-center rounded-lg border border-slate-200 text-slate-300 bg-white"><i class="fa-solid fa-chevron-left text-[10px]"></i></span>
                @else
                    <a href="{{ $logs->previousPageUrl() }}" class="w-8 h-8 flex items-center justify-center rounded-lg border border-slate-200 text-slate-500 hover:bg-slate-100 bg-white"><i class="fa-solid fa-chevron-left text-[10px]"></i></a>
                @endif

                @foreach($logs->getUrlRange(1, $logs->lastPage()) as $page => $url)
                    <a href="{{ $url }}" class="w-8 h-8 flex items-center justify-center rounded-lg text-xs font-bold border transition-all {{ $logs->currentPage() == $page ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-white text-slate-600 border-slate-200 hover:bg-slate-50' }}">{{ $page }}</a>
                @endforeach

                @if($logs->hasMorePages())
                    <a href="{{ $logs->nextPageUrl() }}" class="w-8 h-8 flex items-center justify-center rounded-lg border border-slate-200 text-slate-500 hover:bg-slate-100 bg-white"><i class="fa-solid fa-chevron-right text-[10px]"></i></a>
                @else
                    <span class="w-8 h-8 flex items-center justify-center rounded-lg border border-slate-200 text-slate-300 bg-white"><i class="fa-solid fa-chevron-right text-[10px]"></i></span>
                @endif
            </div>
        </div>
        @endif
    </div>

</div>

<!-- Modal Before/After -->
@include('logsaktivity.beforeafter')

@push('scripts')
<script>
function openLogDetail(btn) {
    const data = JSON.parse(btn.getAttribute('data-log'));
    window.dispatchEvent(new CustomEvent('show-log-detail', { detail: data }));
}
</script>
@endpush

@endsection