@extends('layouts.admin')

@section('title', __('strings.system_logs'))

@section('sidebar')
<nav class="space-y-1">
    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 hover:text-teal-600 rounded-xl font-medium transition">
        <i data-lucide="layout-dashboard" class="w-5 h-5"></i> {{ __('strings.dashboard') }}
    </a>
    <a href="{{ route('admin.logs') }}" class="flex items-center gap-3 px-4 py-3 bg-teal-50 text-teal-700 rounded-xl font-bold transition">
        <i data-lucide="activity" class="w-5 h-5"></i> {{ __('strings.system_logs') }}
    </a>
    <a href="{{ route('admin.backups') }}" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 hover:text-teal-600 rounded-xl font-medium transition">
        <i data-lucide="database" class="w-5 h-5"></i> {{ __('strings.backups') }}
    </a>
    <a href="#" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 hover:text-teal-600 rounded-xl font-medium transition">
        <i data-lucide="shield-alert" class="w-5 h-5"></i> {{ __('strings.security_audit') }}
    </a>
</nav>
@endsection

@section('sidebar-footer')
<p class="text-xs font-bold text-slate-500">{{ __('strings.last_sync') }}: <span class="text-green-600">{{ __('strings.just_now') }}</span></p>
@endsection

@section('content')
<div class="flex-1 flex flex-col h-full overflow-hidden">
            
    <div class="mb-6 flex justify-between items-end">
        <div>
            <h1 class="text-3xl font-bold text-slate-800">{{ __('strings.system_logs') }}</h1>
            <p class="text-slate-500 mt-1">{{ __('strings.logs_desc') }}</p>
        </div>
        <div class="flex gap-3">
            <button class="flex items-center gap-2 bg-white border border-slate-200 text-slate-600 px-4 py-2 rounded-xl text-sm font-bold hover:bg-slate-50 transition">
                <i data-lucide="download" class="w-4 h-4"></i> {{ __('strings.export_logs') }}
            </button>
            <button class="flex items-center gap-2 bg-white border border-slate-200 text-slate-600 px-4 py-2 rounded-xl text-sm font-bold hover:bg-slate-50 transition">
                <i data-lucide="refresh-cw" class="w-4 h-4"></i> {{ __('strings.refresh') }}
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-3">
            <div class="p-2 bg-blue-50 text-blue-600 rounded-lg"><i data-lucide="info" class="w-5 h-5"></i></div>
            <div>
                <p class="text-xs text-slate-400 font-bold uppercase">{{ __('strings.level_info') }}</p>
                <h3 class="text-lg font-extrabold text-slate-800">1,240</h3>
            </div>
        </div>
        <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-3">
            <div class="p-2 bg-green-50 text-green-600 rounded-lg"><i data-lucide="check-circle" class="w-5 h-5"></i></div>
            <div>
                <p class="text-xs text-slate-400 font-bold uppercase">{{ __('strings.level_success') }}</p>
                <h3 class="text-lg font-extrabold text-slate-800">856</h3>
            </div>
        </div>
        <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-3">
            <div class="p-2 bg-yellow-50 text-yellow-600 rounded-lg"><i data-lucide="alert-triangle" class="w-5 h-5"></i></div>
            <div>
                <p class="text-xs text-slate-400 font-bold uppercase">{{ __('strings.level_warning') }}</p>
                <h3 class="text-lg font-extrabold text-slate-800">42</h3>
            </div>
        </div>
        <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-3">
            <div class="p-2 bg-red-50 text-red-600 rounded-lg"><i data-lucide="x-circle" class="w-5 h-5"></i></div>
            <div>
                <p class="text-xs text-slate-400 font-bold uppercase">{{ __('strings.level_error') }}</p>
                <h3 class="text-lg font-extrabold text-slate-800">5</h3>
            </div>
        </div>
    </div>

    <div class="bg-white p-3 rounded-2xl border border-slate-100 shadow-sm mb-6 flex flex-col md:flex-row gap-4 items-center">
        <div class="relative flex-1 w-full">
            <input type="text" placeholder="{{ __('strings.search_logs') }}" class="w-full pl-10 pr-4 rtl:pr-10 rtl:pl-4 py-2 bg-slate-50 border-none rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-teal-500/20 transition">
            <i data-lucide="search" class="absolute left-3 rtl:right-3 rtl:left-auto top-2.5 w-4 h-4 text-slate-400"></i>
        </div>
        <div class="flex gap-2 w-full md:w-auto">
            <select class="bg-slate-50 border-none text-slate-600 text-xs font-bold rounded-xl px-4 py-2 focus:outline-none cursor-pointer hover:bg-slate-100">
                <option>{{ __('strings.all_levels') }}</option>
                <option>Info</option>
                <option>Warning</option>
                <option>Error</option>
            </select>
            <select class="bg-slate-50 border-none text-slate-600 text-xs font-bold rounded-xl px-4 py-2 focus:outline-none cursor-pointer hover:bg-slate-100">
                <option>{{ __('strings.last_24h') }}</option>
                <option>{{ __('strings.last_7d') }}</option>
                <option>{{ __('strings.last_30d') }}</option>
            </select>
        </div>
    </div>

    <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 flex-1 overflow-hidden flex flex-col">
        <div class="overflow-x-auto custom-scroll flex-1">
            <table class="w-full text-left rtl:text-right border-collapse">
                <thead class="bg-slate-50/80 sticky top-0 z-10 backdrop-blur-sm">
                    <tr class="text-xs text-slate-400 uppercase border-b border-slate-100">
                        <th class="py-4 pl-6 rtl:pr-6 rtl:pl-0 font-bold w-48">{{ __('strings.timestamp') }}</th>
                        <th class="py-4 font-bold w-32">{{ __('strings.level') }}</th>
                        <th class="py-4 font-bold w-48">{{ __('strings.source') }}</th>
                        <th class="py-4 font-bold">{{ __('strings.message') }}</th>
                        <th class="py-4 pr-6 rtl:pl-6 rtl:pr-0 text-right rtl:text-left font-bold w-24">{{ __('strings.action') }}</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-slate-600 font-mono">
                    <tr class="border-b border-slate-50 hover:bg-slate-50/50 transition">
                        <td class="py-3 pl-6 rtl:pr-6 rtl:pl-0 text-xs text-slate-500">2023-10-24 14:30:22</td>
                        <td class="py-3"><span class="log-error px-2 py-1 rounded text-[10px] font-bold uppercase">Error</span></td>
                        <td class="py-3 text-xs font-bold">PaymentGateway</td>
                        <td class="py-3">Failed to process transaction #TXN-9982: Timeout</td>
                        <td class="py-3 pr-6 rtl:pl-6 rtl:pr-0 text-right rtl:text-left"><button class="text-slate-400 hover:text-slate-600"><i data-lucide="eye" class="w-4 h-4"></i></button></td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <div class="p-4 border-t border-slate-100 flex items-center justify-between bg-white">
            <p class="text-xs text-slate-400">{{ __('strings.showing_results', ['start' => 1, 'end' => 50, 'total' => '2,340']) }}</p>
            <div class="flex gap-2">
                <button class="p-2 border border-slate-200 rounded-lg text-slate-400 hover:bg-slate-50 disabled:opacity-50"><i data-lucide="chevron-left" class="w-4 h-4 rtl:rotate-180"></i></button>
                <button class="p-2 border border-slate-200 rounded-lg text-slate-400 hover:bg-slate-50"><i data-lucide="chevron-right" class="w-4 h-4 rtl:rotate-180"></i></button>
            </div>
        </div>
    </div>

</div>
@endsection