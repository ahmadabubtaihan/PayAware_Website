@extends('layouts.admin')

@section('title', __('strings.manage_companies'))

@section('content')
<div class="flex-1 flex flex-col h-full overflow-hidden">
    
    {{-- رسائل النجاح --}}
    @if(session('success'))
        <div class="mb-4 bg-emerald-50 text-emerald-600 px-4 py-3 rounded-xl border border-emerald-100 flex items-center gap-2">
            <i data-lucide="check-circle" class="w-5 h-5"></i>
            {{ session('success') }}
        </div>
    @endif

    {{-- رسائل الخطأ --}}
    @if($errors->any())
        <div class="mb-4 bg-red-50 text-red-600 px-4 py-3 rounded-xl border border-red-100">
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <div class="mb-6 flex justify-between items-end flex-shrink-0">
        <div>
            <h1 class="text-3xl font-bold text-slate-800">{{ __('strings.manage_companies') }}</h1>
            <p class="text-slate-500 mt-1">{{ __('strings.manage_companies_desc') }}</p>
        </div>
        <div class="flex gap-3">
            <button onclick="document.getElementById('addCompanyModal').classList.remove('hidden')" class="flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-xl text-sm font-bold shadow-lg shadow-indigo-200 transition transform active:scale-95">
                <i data-lucide="plus" class="w-4 h-4"></i> {{ __('strings.add_company') }}
            </button>
        </div>
    </div>

    {{-- الإحصائيات السريعة --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6 flex-shrink-0">
        <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-3">
            <div class="p-2 bg-teal-50 text-teal-600 rounded-lg"><i data-lucide="building" class="w-5 h-5"></i></div>
            <div>
                <p class="text-xs text-slate-400 font-bold uppercase">{{ __('strings.total') }}</p>
                <h3 class="text-lg font-extrabold text-slate-800">{{ $companies->total() }}</h3>
            </div>
        </div>
    </div>

    {{-- جدول الشركات --}}
    <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 flex-1 overflow-hidden flex flex-col min-h-0">
        <div class="overflow-auto custom-scroll flex-1 relative">
            <table class="w-full text-left rtl:text-right border-collapse">
                <thead class="bg-slate-50/90 sticky top-0 z-10 backdrop-blur-sm shadow-sm">
                    <tr class="text-xs text-slate-400 uppercase border-b border-slate-100">
                        <th class="py-4 pl-6 rtl:pr-6 rtl:pl-0 font-bold">{{ __('strings.company_name') }}</th>
                        <th class="py-4 font-bold">{{ __('strings.email_address') }}</th>
                        <th class="py-4 font-bold">{{ __('strings.location') }}</th>
                        <th class="py-4 font-bold">{{ __('strings.plan') }}</th>
                        <th class="py-4 font-bold text-center">{{ __('strings.status') }}</th>
                        <th class="py-4 pr-6 rtl:pl-6 rtl:pr-0 text-right rtl:text-left font-bold">{{ __('strings.actions') }}</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-slate-600 divide-y divide-slate-50">
                    @forelse($companies as $company)
                    <tr class="hover:bg-slate-50/50 transition">
                        <td class="py-4 pl-6 rtl:pr-6 rtl:pl-0 font-bold text-slate-700 flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-indigo-50 border border-slate-200 flex items-center justify-center font-bold text-indigo-600">
                                {{ strtoupper(substr($company->name, 0, 1)) }}
                            </div>
                            {{ $company->name }}
                        </td>
                        <td class="py-4">{{ $company->email }}</td>
                        <td class="py-4">{{ $company->location ?? '-' }}</td>
                        <td class="py-4">
                            <span class="bg-indigo-50 text-indigo-600 px-2 py-1 rounded text-[10px] font-bold uppercase">{{ $company->plan }}</span>
                        </td>
                        <td class="py-4 text-center">
                            @if($company->status == 'active')
                                <span class="bg-green-100 text-green-700 px-2 py-1 rounded-full text-[10px] font-bold">{{ __('strings.status_active') }}</span>
                            @elseif($company->status == 'pending')
                                <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full text-[10px] font-bold">{{ __('strings.status_pending') }}</span>
                            @else
                                <span class="bg-red-100 text-red-700 px-2 py-1 rounded-full text-[10px] font-bold">{{ __('strings.status_suspended') }}</span>
                            @endif
                        </td>
                        <td class="py-4 pr-6 rtl:pl-6 rtl:pr-0 text-right rtl:text-left flex justify-end rtl:justify-start gap-2">
                            
                            {{-- زر التفعيل --}}
                            @if($company->status === 'pending')
                                <form action="{{ route('admin.companies.status', $company->id) }}" method="POST" class="inline">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="status" value="active">
                                    <button class="text-green-500 hover:text-green-700 transition" title="{{ __('strings.activate') }}">
                                        <i data-lucide="check" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            @endif

                            {{-- زر الحذف --}}
                            <form action="{{ route('admin.companies.delete', $company->id) }}" method="POST" class="inline" onsubmit="return confirm('{{ __('strings.confirm_delete_company') }}');">
                                @csrf @method('DELETE')
                                <button class="text-slate-400 hover:text-red-500 transition" title="{{ __('strings.delete') }}">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-8 text-slate-400">
                            {{ __('strings.no_companies') }}
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="p-4 border-t border-slate-100 flex items-center justify-between bg-white flex-shrink-0 rounded-b-[2rem]">
            {{ $companies->links() }} 
        </div>
    </div>
</div>

{{-- ========================================== --}}
{{-- نافذة إضافة شركة (Modal) --}}
{{-- ========================================== --}}
<div id="addCompanyModal" class="hidden fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm transition-opacity"></div>

    <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
        <div class="relative transform overflow-hidden rounded-2xl bg-white text-left rtl:text-right shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
            
            <form action="{{ route('admin.companies.store') }}" method="POST" class="p-6">
                @csrf
                
                <div class="flex justify-between items-center mb-5">
                    <h3 class="text-lg font-bold text-slate-900" id="modal-title">{{ __('strings.add_new_company') }}</h3>
                    <button type="button" onclick="document.getElementById('addCompanyModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-500">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">{{ __('strings.company_name') }}</label>
                        <input type="text" name="name" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/20">
                    </div>
                    
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">{{ __('strings.email_address') }}</label>
                        <input type="email" name="email" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/20">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">{{ __('strings.location') }}</label>
                        <input type="text" name="location" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/20">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">{{ __('strings.plan_type') }}</label>
                            <select name="plan" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/20">
                                <option value="basic">Basic</option>
                                <option value="pro">Pro</option>
                                <option value="enterprise">Enterprise</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">{{ __('strings.status') }}</label>
                            <select name="status" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/20">
                                <option value="active">{{ __('strings.status_active') }}</option>
                                <option value="pending">{{ __('strings.status_pending') }}</option>
                                <option value="suspended">{{ __('strings.status_suspended') }}</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mt-8 flex justify-end gap-3">
                    <button type="button" onclick="document.getElementById('addCompanyModal').classList.add('hidden')" class="px-4 py-2 bg-white border border-slate-200 text-slate-600 rounded-xl text-sm font-bold hover:bg-slate-50">{{ __('strings.cancel') }}</button>
                    <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-xl text-sm font-bold hover:bg-indigo-700 shadow-lg shadow-indigo-200">{{ __('strings.save_company') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection