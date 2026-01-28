@extends('layouts.admin')

@section('title', __('strings.system_backups'))

@section('sidebar')
<nav class="space-y-1">
    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 hover:text-teal-600 rounded-xl font-medium transition">
        <i data-lucide="layout-dashboard" class="w-5 h-5"></i> {{ __('strings.dashboard') }}
    </a>
    <a href="{{ route('admin.logs') }}" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 hover:text-teal-600 rounded-xl font-medium transition">
        <i data-lucide="activity" class="w-5 h-5"></i> {{ __('strings.system_logs') }}
    </a>
    <a href="{{ route('admin.backups') }}" class="flex items-center gap-3 px-4 py-3 bg-teal-50 text-teal-700 rounded-xl font-bold transition">
        <i data-lucide="database" class="w-5 h-5"></i> {{ __('strings.backups') }}
    </a>
    <a href="#" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 hover:text-teal-600 rounded-xl font-medium transition">
        <i data-lucide="shield-alert" class="w-5 h-5"></i> {{ __('strings.security_audit') }}
    </a>
</nav>
@endsection

@section('sidebar-footer')
<p class="text-xs font-bold text-slate-500">{{ __('strings.last_backup') }}: <span class="text-green-600">2h ago</span></p>
@endsection

@section('content')
<div class="flex-1 flex flex-col h-full overflow-hidden">
            
    <div class="mb-6 flex justify-between items-end">
        <div>
            <h1 class="text-3xl font-bold text-slate-800">{{ __('strings.system_backups') }}</h1>
            <p class="text-slate-500 mt-1">{{ __('strings.backups_desc') }}</p>
        </div>
        <button onclick="alert('Starting manual backup...')" class="flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2.5 rounded-xl text-sm font-bold shadow-lg shadow-indigo-200 transition transform active:scale-95">
            <i data-lucide="save" class="w-4 h-4"></i> {{ __('strings.create_manual_backup') }}
        </button>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100 lg:col-span-2">
            <h3 class="text-lg font-bold text-slate-800 mb-4">{{ __('strings.backup_schedule') }}</h3>
            <div class="flex items-center justify-between p-4 bg-slate-50 rounded-xl mb-4">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-white rounded-lg shadow-sm text-teal-600"><i data-lucide="clock" class="w-6 h-6"></i></div>
                    <div>
                        <h4 class="font-bold text-slate-700">{{ __('strings.daily_auto_backup') }}</h4>
                        <p class="text-xs text-slate-500">{{ __('strings.runs_every_day') }}</p>
                    </div>
                </div>
                <div class="relative inline-block w-12 mr-2 rtl:ml-2 rtl:mr-0 align-middle select-none transition duration-200 ease-in">
                    <input type="checkbox" name="toggle" id="toggle-backup" class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer border-slate-300 transition-all duration-300" checked/>
                    <label for="toggle-backup" class="toggle-label block overflow-hidden h-6 rounded-full bg-slate-300 cursor-pointer checked:bg-teal-500 transition-colors duration-300"></label>
                </div>
            </div>
            <div class="flex gap-4">
                <div class="flex-1 p-4 bg-slate-50 rounded-xl border border-slate-100">
                    <p class="text-xs font-bold text-slate-400 uppercase mb-1">{{ __('strings.storage_location') }}</p>
                    <div class="flex items-center gap-2 font-bold text-slate-700"><i data-lucide="cloud" class="w-4 h-4 text-indigo-500"></i> AWS S3 Bucket</div>
                </div>
                <div class="flex-1 p-4 bg-slate-50 rounded-xl border border-slate-100">
                    <p class="text-xs font-bold text-slate-400 uppercase mb-1">{{ __('strings.retention_policy') }}</p>
                    <div class="flex items-center gap-2 font-bold text-slate-700"><i data-lucide="calendar" class="w-4 h-4 text-orange-500"></i> {{ __('strings.days_30') }}</div>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-slate-800 to-slate-900 p-6 rounded-[2rem] shadow-lg text-white flex flex-col justify-between relative overflow-hidden">
            <div class="absolute top-0 right-0 rtl:left-0 rtl:right-auto w-32 h-32 bg-teal-500 rounded-full blur-3xl opacity-20 -mr-10 rtl:-ml-10 rtl:-mr-0 -mt-10"></div>
            <div>
                <h3 class="font-bold text-lg mb-1">{{ __('strings.storage_usage') }}</h3>
                <p class="text-slate-400 text-xs">{{ __('strings.storage_usage_desc') }}</p>
            </div>
            <div class="mt-6">
                <div class="flex justify-between items-end mb-2">
                    <span class="text-3xl font-extrabold">45.2 GB</span>
                    <span class="text-xs text-slate-400 font-bold">{{ __('strings.of_100gb') }}</span>
                </div>
                <div class="w-full h-2 bg-slate-700 rounded-full overflow-hidden">
                    <div class="h-full bg-teal-500 w-[45%]"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 flex-1 overflow-hidden flex flex-col">
        <div class="p-6 border-b border-slate-100 flex justify-between items-center">
            <h3 class="font-bold text-slate-800">{{ __('strings.backup_history') }}</h3>
            <div class="relative">
                <input type="text" placeholder="{{ __('strings.search_backups') }}" class="pl-9 pr-4 rtl:pr-9 rtl:pl-4 py-2 bg-slate-50 border-none rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-teal-500/20 w-64 transition">
                <i data-lucide="search" class="absolute left-3 rtl:right-3 rtl:left-auto top-2.5 w-3.5 h-3.5 text-slate-400"></i>
            </div>
        </div>
        
        <div class="overflow-x-auto custom-scroll flex-1">
            <table class="w-full text-left rtl:text-right border-collapse">
                <thead class="bg-slate-50/80 sticky top-0 z-10 backdrop-blur-sm">
                    <tr class="text-xs text-slate-400 uppercase border-b border-slate-100">
                        <th class="py-4 pl-6 rtl:pr-6 rtl:pl-0 font-bold">{{ __('strings.filename') }}</th>
                        <th class="py-4 font-bold">{{ __('strings.date_created') }}</th>
                        <th class="py-4 font-bold">{{ __('strings.size') }}</th>
                        <th class="py-4 font-bold">{{ __('strings.type') }}</th>
                        <th class="py-4 font-bold">{{ __('strings.status') }}</th>
                        <th class="py-4 pr-6 rtl:pl-6 rtl:pr-0 text-right rtl:text-left font-bold">{{ __('strings.actions') }}</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-slate-600">
                    <tr class="border-b border-slate-50 hover:bg-slate-50/50 transition">
                        <td class="py-4 pl-6 rtl:pr-6 rtl:pl-0 font-mono text-xs font-bold text-slate-700 flex items-center gap-2">
                            <i data-lucide="database" class="w-4 h-4 text-teal-500"></i>
                            backup_2023_10_24_0300.sql.gz
                        </td>
                        <td class="py-4">Oct 24, 2023 - 03:00 AM</td>
                        <td class="py-4">2.4 GB</td>
                        <td class="py-4"><span class="bg-slate-100 text-slate-500 px-2 py-1 rounded text-[10px] font-bold uppercase">Auto</span></td>
                        <td class="py-4"><span class="bg-green-50 text-green-600 px-2 py-1 rounded-full text-[10px] font-bold flex items-center w-fit gap-1"><div class="w-1.5 h-1.5 rounded-full bg-green-500"></div> {{ __('strings.level_success') }}</span></td>
                        <td class="py-4 pr-6 rtl:pl-6 rtl:pr-0 text-right rtl:text-left flex justify-end rtl:justify-start gap-2">
                            <button class="text-slate-400 hover:text-indigo-600 transition" title="{{ __('strings.download') }}"><i data-lucide="download" class="w-4 h-4"></i></button>
                            <button class="text-slate-400 hover:text-red-500 transition" title="{{ __('strings.delete') }}"><i data-lucide="trash-2" class="w-4 h-4"></i></button>
                            <button class="text-slate-400 hover:text-orange-500 transition" title="{{ __('strings.restore') }}"><i data-lucide="rotate-ccw" class="w-4 h-4"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection