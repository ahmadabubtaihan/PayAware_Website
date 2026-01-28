@extends('layouts.admin')

@section('title', __('strings.admin_dashboard') ?? 'لوحة التحكم')

@push('head-scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

@section('content')
<div class="flex-1 overflow-y-auto custom-scroll pr-2 rtl:pr-0 rtl:pl-2">
            
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-slate-800">{{ __('strings.admin_overview') ?? 'نظرة عامة' }}</h1>
        <p class="text-slate-500 mt-2">{{ __('strings.admin_welcome_msg') ?? 'أهلاً بك في لوحة تحكم المسؤول، إليك ملخص لما يحدث اليوم.' }}</p>
    </div>

    {{-- البطاقات الإحصائية --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        
        {{-- إجمالي الشركات --}}
        <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100 hover:-translate-y-1 transition duration-300 group">
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 bg-teal-50 text-teal-600 rounded-xl group-hover:bg-teal-600 group-hover:text-white transition"><i data-lucide="building" class="w-6 h-6"></i></div>
                <span class="text-xs font-bold text-green-600 bg-green-50 px-2 py-1 rounded-lg" dir="ltr">+12%</span>
            </div>
            <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">{{ __('strings.total_companies') ?? 'إجمالي الشركات' }}</p>
            <h3 class="text-2xl font-extrabold text-slate-800 mt-1">{{ number_format($totalCompanies) }}</h3>
        </div>
        
        {{-- المدينون النشطون --}}
        <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100 hover:-translate-y-1 transition duration-300 group">
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 bg-indigo-50 text-indigo-600 rounded-xl group-hover:bg-indigo-600 group-hover:text-white transition"><i data-lucide="users" class="w-6 h-6"></i></div>
                <span class="text-xs font-bold text-green-600 bg-green-50 px-2 py-1 rounded-lg" dir="ltr">+5%</span>
            </div>
            <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">{{ __('strings.active_debtors') ?? 'المدينون النشطون' }}</p>
            <h3 class="text-2xl font-extrabold text-slate-800 mt-1">{{ number_format($activeDebtors) }}</h3>
        </div>

        {{-- إجمالي الإيرادات --}}
        <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100 hover:-translate-y-1 transition duration-300 group">
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 bg-orange-50 text-orange-600 rounded-xl group-hover:bg-orange-600 group-hover:text-white transition"><i data-lucide="dollar-sign" class="w-6 h-6"></i></div>
                <span class="text-xs font-bold text-green-600 bg-green-50 px-2 py-1 rounded-lg" dir="ltr">+24%</span>
            </div>
            <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">{{ __('strings.total_revenue') ?? 'إجمالي الديون المسجلة' }}</p>
            <h3 class="text-2xl font-extrabold text-slate-800 mt-1">${{ number_format($totalRevenue) }}</h3>
        </div>

        {{-- التذاكر المعلقة --}}
        <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100 hover:-translate-y-1 transition duration-300 group">
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 bg-red-50 text-red-600 rounded-xl group-hover:bg-red-600 group-hover:text-white transition"><i data-lucide="alert-circle" class="w-6 h-6"></i></div>
                <span class="text-xs font-bold text-red-600 bg-red-50 px-2 py-1 rounded-lg">{{ __('strings.high_priority') ?? 'عالية الأولوية' }}</span>
            </div>
            <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">{{ __('strings.pending_tickets') ?? 'تذاكر الدعم' }}</p>
            <h3 class="text-2xl font-extrabold text-slate-800 mt-1">{{ $pendingTickets }}</h3>
        </div>
    </div>

    {{--الرسم البياني + قائمة الشركات الجديدة --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
        
        {{-- الرسم البياني --}}
        <div class="lg:col-span-2 bg-white p-8 rounded-[2rem] shadow-sm border border-slate-100">
            <div class="flex justify-between items-center mb-6">
                <h3 class="font-bold text-slate-800">{{ __('strings.platform_growth') ?? 'نمو المنصة (آخر 6 أشهر)' }}</h3>
                <select class="bg-slate-50 border-none text-xs font-bold text-slate-500 rounded-lg p-2 focus:ring-0"><option>{{ __('strings.this_year') ?? 'هذا العام' }}</option></select>
            </div>
            <div class="h-64 w-full">
                <canvas id="growthChart"></canvas>
            </div>
        </div>

        {{-- قائمة أحدث الشركات --}}
        <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100 flex flex-col">
            <h3 class="font-bold text-slate-800 mb-6">{{ __('strings.new_companies') ?? 'أحدث الشركات المنضمة' }}</h3>
            
            <div class="space-y-4 flex-1 overflow-y-auto custom-scroll pr-2 rtl:pr-0 rtl:pl-2" style="max-height: 250px;">
                @forelse($newCompanies as $company)
                    <div class="flex items-center justify-between p-3 bg-slate-50 rounded-xl hover:bg-slate-100 transition">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center font-bold text-indigo-600 shadow-sm border border-indigo-100 shrink-0">
                                {{ strtoupper(substr($company->name ?? 'C', 0, 1)) }}
                            </div>
                            <div>
                                <p class="text-sm font-bold text-slate-700 truncate w-32">{{ $company->name }}</p>
                                <p class="text-[10px] text-slate-400">{{ $company->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <button class="p-1.5 bg-white text-green-500 rounded-lg shadow-sm hover:bg-green-50 transition" title="Approve"><i data-lucide="check" class="w-4 h-4"></i></button>
                        </div>
                    </div>
                @empty
                    <div class="flex flex-col items-center justify-center h-full text-slate-400">
                        <i data-lucide="inbox" class="w-8 h-8 mb-2 opacity-50"></i>
                        <p class="text-xs">{{ __('strings.no_data') ?? 'لا توجد شركات جديدة' }}</p>
                    </div>
                @endforelse
            </div>
            
            <a href="{{ route('admin.companies') }}" class="w-full mt-4 text-xs font-bold text-teal-600 hover:text-teal-700 text-center block transition hover:underline">
                {{ __('strings.view_all_requests') ?? 'عرض كل الشركات' }}
            </a>
        </div>
    </div>

{{-- جدول التذاكر --}}
    <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-slate-100">
        <div class="flex justify-between items-center mb-6">
            <div class="flex items-center gap-3">
                <h3 class="font-bold text-slate-800 text-lg">{{ __('strings.recent_tickets') ?? 'آخر تذاكر الدعم' }}</h3>
                @if($pendingTickets > 0)
                    <span class="bg-red-100 text-red-600 text-xs font-bold px-2 py-1 rounded-full">{{ $pendingTickets }} new</span>
                @endif
            </div>
            <button class="text-sm font-bold text-teal-600 hover:underline">{{ __('strings.view_all') ?? 'عرض الكل' }}</button>
        </div>
        
        <div class="overflow-x-auto custom-scroll">
            <table class="w-full text-left rtl:text-right border-collapse">
                <thead>
                    <tr class="text-xs text-slate-400 uppercase border-b border-slate-100">
                        <th class="py-3 pl-2 rtl:pr-2 rtl:pl-0">{{ __('strings.user') ?? 'المستخدم' }}</th>
                        <th class="py-3">{{ __('strings.subject') ?? 'الموضوع' }}</th>
                        <th class="py-3">{{ __('strings.priority') ?? 'الأولوية' }}</th>
                        <th class="py-3">{{ __('strings.date') ?? 'التاريخ' }}</th>
                        <th class="py-3">{{ __('strings.status') ?? 'الحالة' }}</th>
                        <th class="py-3 text-right rtl:text-left">{{ __('strings.action') ?? 'إجراء' }}</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-slate-600">
                    @forelse($recentTickets as $ticket)
                    <tr class="border-b border-slate-50 hover:bg-slate-50 transition group">
                        {{-- المستخدم --}}
                        <td class="py-4 pl-2 rtl:pr-2 rtl:pl-0 flex items-center gap-3">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($ticket->user->name) }}&background=random" class="w-8 h-8 rounded-full bg-slate-100 border border-slate-200">
                            <div>
                                <p class="font-bold text-slate-800">{{ $ticket->user->name }}</p>
                                <p class="text-[10px] text-slate-400">{{ $ticket->user->role }}</p>
                            </div>
                        </td>
                        
                        {{-- الموضوع --}}
                        <td class="py-4 font-medium text-slate-700">{{ Str::limit($ticket->subject, 30) }}</td>
                        
                        {{-- الأولوية --}}
                        <td class="py-4">
                            @if($ticket->priority == 'high')
                                <span class="text-xs font-bold text-red-500 bg-red-50 px-2 py-1 rounded border border-red-100">High</span>
                            @elseif($ticket->priority == 'medium')
                                <span class="text-xs font-bold text-orange-500 bg-orange-50 px-2 py-1 rounded border border-orange-100">Medium</span>
                            @else
                                <span class="text-xs font-bold text-slate-500 bg-slate-100 px-2 py-1 rounded border border-slate-200">Low</span>
                            @endif
                        </td>

                        {{-- التاريخ --}}
                        <td class="py-4 text-slate-400 text-xs">{{ $ticket->created_at->diffForHumans() }}</td>
                        
                        {{-- الحالة --}}
                        <td class="py-4">
                            @if($ticket->status == 'pending')
                                <span class="bg-yellow-50 text-yellow-600 border border-yellow-100 py-1 px-3 rounded-full text-xs font-bold flex items-center w-fit gap-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-yellow-500"></span> {{ __('strings.status_pending') ?? 'قيد الانتظار' }}
                                </span>
                            @elseif($ticket->status == 'open')
                                <span class="bg-blue-50 text-blue-600 border border-blue-100 py-1 px-3 rounded-full text-xs font-bold flex items-center w-fit gap-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span> {{ __('strings.status_open') ?? 'مفتوحة' }}
                                </span>
                            @else
                                <span class="bg-green-50 text-green-600 border border-green-100 py-1 px-3 rounded-full text-xs font-bold flex items-center w-fit gap-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> {{ __('strings.status_closed') ?? 'مغلقة' }}
                                </span>
                            @endif
                        </td>
                        
                        {{-- زر الإجراء --}}
                        <td class="py-4 text-right rtl:text-left">
                            <button class="text-teal-600 hover:text-teal-800 hover:bg-teal-50 p-2 rounded-lg transition" title="Reply">
                                <i data-lucide="message-square" class="w-4 h-4"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-8 text-center text-slate-400">
                            <div class="flex flex-col items-center justify-center">
                                <i data-lucide="check-circle" class="w-8 h-8 mb-2 opacity-30 text-green-500"></i>
                                <p class="text-sm">{{ __('strings.no_tickets') ?? 'لا توجد تذاكر معلقة، كل شيء ممتاز!' }}</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/adminLog.js') }}"></script>
@endpush