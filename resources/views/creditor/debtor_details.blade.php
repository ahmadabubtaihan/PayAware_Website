@extends('layouts.creditorNItems')

@section('title', $debtor->name . ' | PayAware')

@section('content')

    <main class="pt-28 pb-12 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
        <div class="flex items-center gap-2 text-sm text-slate-400 mb-6 font-medium">
            <a href="{{ route('creditor.debtors') }}" class="hover:text-teal-600 transition flex items-center gap-1"><i data-lucide="users" class="w-3 h-3"></i> {{ __('strings.debtors') }}</a>
            <i data-lucide="chevron-right" class="w-4 h-4 rtl:rotate-180"></i>
            <span class="font-bold text-slate-800">{{ $debtor->name }}</span>
        </div>

        <div class="bg-white rounded-[2.5rem] p-8 shadow-sm border border-slate-100 mb-8 relative overflow-hidden">
            <div class="absolute top-0 right-0 rtl:right-auto rtl:left-0 w-64 h-64 bg-teal-50 rounded-bl-[10rem] rtl:rounded-bl-none rtl:rounded-br-[10rem] -z-0 opacity-50 pointer-events-none"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row items-start md:items-center gap-6">
                <div class="relative group">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($debtor->name) }}&background=random&color=fff&size=128" class="w-24 h-24 rounded-2xl bg-slate-50 border-4 border-white shadow-lg group-hover:scale-105 transition duration-300">
                    
                    {{-- شارة المخاطرة  --}}
                    @php
                        $badgeColor = match($debtor->risk_status) {
                            'high' => 'bg-red-500',
                            'medium' => 'bg-yellow-400',
                            default => 'bg-green-500',
                        };
                        $badgeText = match($debtor->risk_status) {
                            'high' => __('strings.high_risk'),
                            'medium' => __('strings.medium_risk'),
                            default => __('strings.low_risk'),
                        };
                    @endphp
                    <span class="absolute -bottom-2 -right-2 rtl:right-auto rtl:-left-2 text-white text-[10px] font-bold px-2 py-1 rounded-full border-2 border-white shadow-sm uppercase tracking-wide {{ $badgeColor }}">
                        {{ $badgeText }}
                    </span>
                </div>
                
                <div class="flex-1">
                    <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">{{ $debtor->name }}</h1>
                    <div class="flex flex-wrap gap-4 mt-3 text-sm text-slate-500 font-bold">
                        <span class="flex items-center gap-1.5 bg-slate-50 px-3 py-1.5 rounded-lg border border-slate-100"><i data-lucide="hash" class="w-4 h-4 text-teal-500"></i> ID: {{ $debtor->id }}</span>
                        <span class="flex items-center gap-1.5 bg-slate-50 px-3 py-1.5 rounded-lg border border-slate-100"><i data-lucide="phone" class="w-4 h-4 text-teal-500"></i> {{ $debtor->phone }}</span>
                        @if($debtor->address)
                            <span class="flex items-center gap-1.5 bg-slate-50 px-3 py-1.5 rounded-lg border border-slate-100"><i data-lucide="map-pin" class="w-4 h-4 text-teal-500"></i> {{ $debtor->address }}</span>
                        @endif
                    </div>
                </div>

                <div class="flex gap-3 mt-4 md:mt-0 w-full md:w-auto">
                    <button onclick="openReminderModal('{{ $debtor->name }}', '{{ $debtor->id }}')" class="flex-1 md:flex-initial flex items-center justify-center gap-2 bg-orange-50 text-orange-600 hover:bg-orange-500 hover:text-white px-6 py-3 rounded-xl font-bold text-sm transition border border-orange-100 shadow-sm active:scale-95">
                        <i data-lucide="alert-triangle" class="w-4 h-4"></i> {{ __('strings.add_warning') }}
                    </button>
                    <button onclick="openPaymentModal({{ $debtor->id }})" class="flex-1 md:flex-initial flex items-center justify-center gap-2 bg-[#10B981] hover:bg-teal-600 text-white px-6 py-3 rounded-xl font-bold text-sm shadow-md shadow-teal-200 transition active:scale-95">
                        <i data-lucide="plus" class="w-4 h-4"></i> {{ __('strings.add_transaction') }}
                    </button>
                </div>
            </div>

            {{-- بطاقة الحالة --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-10">
                <div class="bg-[#F8FAFC] p-5 rounded-2xl border border-slate-100 relative group overflow-hidden">
                    <div class="relative z-10">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">{{ __('strings.total_debt') }}</p>
                        <h3 class="text-3xl font-black text-slate-800 mt-1">${{ number_format($totalDebt, 2) }}</h3>
                    </div>
                    <div class="absolute right-0 rtl:right-auto rtl:left-0 top-0 h-full w-1 bg-slate-200 group-hover:bg-slate-400 transition-colors"></div>
                </div>
                <div class="bg-teal-50/50 p-5 rounded-2xl border border-teal-100 relative group overflow-hidden">
                    <div class="relative z-10">
                        <p class="text-xs font-bold text-teal-600/70 uppercase tracking-wider">{{ __('strings.repayment') }}</p>
                        <h3 class="text-3xl font-black text-teal-600 mt-1">${{ number_format($totalPaid, 2) }}</h3>
                    </div>
                    <div class="absolute right-0 rtl:right-auto rtl:left-0 top-0 h-full w-1 bg-teal-200 group-hover:bg-teal-400 transition-colors"></div>
                </div>
                <div class="bg-red-50/50 p-5 rounded-2xl border border-red-100 relative group overflow-hidden">
                    <div class="relative z-10">
                        <p class="text-xs font-bold text-red-500/70 uppercase tracking-wider">{{ __('strings.residual') }}</p>
                        <h3 class="text-3xl font-black text-red-500 mt-1">${{ number_format($remainingDebt, 2) }}</h3>
                    </div>
                    <div class="absolute right-0 rtl:right-auto rtl:left-0 top-0 h-full w-1 bg-red-200 group-hover:bg-red-400 transition-colors"></div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            {{-- Payment History  --}}
            <div class="lg:col-span-8 space-y-8">
                <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-slate-100 min-h-[400px]">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="font-bold text-slate-800 text-lg flex items-center gap-2">
                            <span class="w-1.5 h-6 bg-indigo-500 rounded-full"></span>
                            {{ __('strings.payment_history') }}
                        </h3>
                        <div class="flex gap-2">
                            <button class="text-xs font-bold text-slate-500 hover:text-teal-600 hover:bg-teal-50 bg-slate-50 px-3 py-2 rounded-lg transition border border-slate-100"><i data-lucide="download" class="w-3 h-3 inline mr-1 rtl:mr-0 rtl:ml-1"></i> PDF</button>
                            <button class="text-xs font-bold text-slate-500 hover:text-indigo-600 hover:bg-indigo-50 bg-slate-50 px-3 py-2 rounded-lg transition border border-slate-100"><i data-lucide="printer" class="w-3 h-3 inline mr-1 rtl:mr-0 rtl:ml-1"></i> {{ __('strings.print') }}</button>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left rtl:text-right border-collapse">
                            <thead>
                                <tr class="text-xs text-slate-400 border-b border-slate-100">
                                    <th class="py-3 font-bold uppercase tracking-wider">{{ __('strings.date') }}</th>
                                    <th class="py-3 font-bold uppercase tracking-wider">{{ __('strings.time') }}</th>
                                    <th class="py-3 font-bold uppercase tracking-wider">{{ __('strings.amount') }}</th>
                                    <th class="py-3 font-bold uppercase tracking-wider">{{ __('strings.bank_method') }}</th>
                                    <th class="py-3 font-bold uppercase tracking-wider text-right rtl:text-left">{{ __('strings.check_no') }}</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm">
                                @forelse($payments as $payment)
                                    <tr class="border-b border-slate-50 hover:bg-slate-50 transition group">
                                        <td class="py-4 font-bold text-slate-700">{{ $payment->created_at->format('Y/m/d') }}</td>
                                        <td class="py-4 text-slate-500 font-mono text-xs">{{ $payment->created_at->format('h:i A') }}</td>
                                        <td class="py-4 font-bold text-teal-600 group-hover:scale-105 transition-transform origin-left rtl:origin-right">${{ number_format($payment->amount, 2) }}</td>
                                        <td class="py-4 text-slate-600">{{ __('strings.' . $payment->method) }}</td>
                                        <td class="py-4 text-slate-400 text-right rtl:text-left font-mono">{{ $payment->reference_number ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-8 text-center text-slate-400">{{ __('strings.no_records_found') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- السايد بار  --}}
            <div class="lg:col-span-4 space-y-8">
                
                {{-- نقاط الثقة --}}
                <div class="bg-white rounded-[2rem] p-6 shadow-sm border border-slate-100">
                    <h3 class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-4 border-l-4 rtl:border-l-0 rtl:border-r-4 border-teal-500 pl-3 rtl:pl-0 rtl:pr-3">{{ __('strings.credit_trust_score') }}</h3>
                    <div class="flex flex-col items-center justify-center py-4 relative">
                        <div class="w-40 h-40 rounded-full border-[12px] border-slate-50 border-t-teal-500 border-r-teal-400 border-l-teal-500 flex items-center justify-center relative shadow-inner">
                            <div class="text-center">
                                @php
                                    $score = $totalDebt > 0 ? round(($totalPaid / $totalDebt) * 100) : 0;
                                @endphp
                                <span class="block text-4xl font-black text-slate-800">{{ $score }}</span>
                                <span class="text-[10px] text-teal-600 font-bold uppercase tracking-widest bg-teal-50 px-2 py-0.5 rounded-md mt-1">{{ __('strings.rating_excellent') }}</span>
                            </div>
                        </div>
                        <p class="text-center text-xs text-slate-400 mt-4 px-4 font-medium">
                            {{ __('strings.score_desc') }}
                        </p>
                    </div>
                </div>

                {{-- التواصل السريع --}}
                <div class="bg-white rounded-[2rem] p-6 shadow-sm border border-slate-100">
                    <h3 class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-4 border-l-4 rtl:border-l-0 rtl:border-r-4 border-indigo-500 pl-3 rtl:pl-0 rtl:pr-3">{{ __('strings.quick_contact') }}</h3>
                    <div class="grid grid-cols-3 gap-3">
                        <a href="tel:{{ $debtor->phone }}" class="flex flex-col items-center justify-center bg-slate-50 hover:bg-teal-50 hover:text-teal-600 text-slate-500 p-4 rounded-2xl transition border border-slate-100 hover:border-teal-200 group">
                            <div class="bg-white p-2 rounded-full shadow-sm mb-2 group-hover:scale-110 transition"><i data-lucide="phone" class="w-5 h-5"></i></div>
                            <span class="text-[10px] font-bold">{{ __('strings.call') }}</span>
                        </a>
                        <a href="https://wa.me/{{ $debtor->phone }}" target="_blank" class="flex flex-col items-center justify-center bg-slate-50 hover:bg-green-50 hover:text-green-600 text-slate-500 p-4 rounded-2xl transition border border-slate-100 hover:border-green-200 group">
                            <div class="bg-white p-2 rounded-full shadow-sm mb-2 group-hover:scale-110 transition"><i data-lucide="message-circle" class="w-5 h-5"></i></div>
                            <span class="text-[10px] font-bold">{{ __('strings.whatsapp') }}</span>
                        </a>
                        <a href="mailto:{{ $debtor->email }}" class="flex flex-col items-center justify-center bg-slate-50 hover:bg-indigo-50 hover:text-indigo-600 text-slate-500 p-4 rounded-2xl transition border border-slate-100 hover:border-indigo-200 group">
                            <div class="bg-white p-2 rounded-full shadow-sm mb-2 group-hover:scale-110 transition"><i data-lucide="mail" class="w-5 h-5"></i></div>
                            <span class="text-[10px] font-bold">{{ __('strings.email') }}</span>
                        </a>
                    </div>
                </div>

                {{-- الملاحظات --}}
                <div class="bg-white rounded-[2rem] p-6 shadow-sm border border-slate-100">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-sm font-bold text-slate-400 uppercase tracking-wider border-l-4 rtl:border-l-0 rtl:border-r-4 border-yellow-400 pl-3 rtl:pl-0 rtl:pr-3">{{ __('strings.notes') }}</h3>
                        <button class="text-xs text-teal-600 font-bold hover:bg-teal-50 px-2 py-1 rounded transition">+ {{ __('strings.add') }}</button>
                    </div>
                    
                    <div class="bg-[#FEFCE8] p-4 rounded-xl border border-yellow-100 relative group shadow-sm">
                        <div class="absolute top-2 right-2 rtl:right-auto rtl:left-2 opacity-0 group-hover:opacity-100 transition">
                            <button class="text-yellow-600 hover:text-red-500 p-1 hover:bg-red-50 rounded"><i data-lucide="trash-2" class="w-3 h-3"></i></button>
                        </div>
                        <p class="text-sm text-slate-700 font-medium leading-relaxed italic">
                            "No notes available yet."
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </main>

    @include('creditor.modals.add_payment')
    @include('creditor.modals.send_warning')

@endsection

@push('scripts')
<script src="{{ asset('js/creditorLog.js') }}"></script>
@endpush