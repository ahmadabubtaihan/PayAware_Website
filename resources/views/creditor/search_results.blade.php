@extends('layouts.creditorNItems')

@section('title', __('strings.search_results') . ' | PayAware')

@section('content')
<main class="pt-28 pb-12 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    
    <div class="mb-8">
        <a href="{{ route('creditor.dashboard') }}" class="text-slate-500 hover:text-slate-700 flex items-center gap-2 mb-4 transition">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> {{ __('strings.back_to_dashboard') }}
        </a>
        <h1 class="text-2xl font-extrabold text-slate-800">
            {{ __('strings.search_results_for') }}: <span class="text-teal-600">"{{ $query }}"</span>
        </h1>
    </div>

    @if($debtors->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($debtors as $debtor)
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition group">
                    <div class="flex items-center gap-4 mb-4">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($debtor->name) }}&background=random&color=fff" class="w-14 h-14 rounded-full bg-slate-100">
                        <div>
                            <h3 class="font-bold text-slate-800 text-lg">{{ $debtor->name }}</h3>
                            <p class="text-xs text-slate-500">ID: {{ $debtor->id }}</p>
                        </div>
                    </div>
                    
                    <div class="space-y-3 mb-6">
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-500">{{ __('strings.email') }}:</span>
                            <span class="font-semibold text-slate-700">{{ $debtor->email }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-500">{{ __('strings.phone') }}:</span>
                            <span class="font-semibold text-slate-700">{{ $debtor->phone ?? '-' }}</span>
                        </div>
                    </div>

                    <div class="flex gap-2">
                        {{-- أزرار إجراءات سريعة --}}
                        <button onclick="openAddDebtModal('{{ $debtor->id }}', '{{ $debtor->name }}')" class="flex-1 py-2.5 bg-red-50 text-red-600 font-bold text-xs rounded-xl hover:bg-red-100 transition flex items-center justify-center gap-2">
                            <i data-lucide="minus-circle" class="w-4 h-4"></i> {{ __('strings.add_debt') }}
                        </button>
                        <a href="#" class="flex-1 py-2.5 bg-slate-50 text-slate-600 font-bold text-xs rounded-xl hover:bg-slate-100 transition flex items-center justify-center gap-2">
                            <i data-lucide="user" class="w-4 h-4"></i> {{ __('strings.view_profile') }}
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-16 bg-white rounded-3xl border border-slate-100 border-dashed">
            <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-400">
                <i data-lucide="search-x" class="w-8 h-8"></i>
            </div>
            <h3 class="text-lg font-bold text-slate-800 mb-1">{{ __('strings.no_results_found') }}</h3>
            <p class="text-slate-500 text-sm">{{ __('strings.try_different_keywords') }}</p>
        </div>
    @endif
</main>

{{-- سنحتاج لإضافة المودال هنا أو استخدام Layout يحتوي عليه --}}
<script>
    function openAddDebtModal(id, name) {
        window.location.href = "{{ route('creditor.dashboard') }}?action=add_debt&debtor_id=" + id + "&debtor_name=" + encodeURIComponent(name);
    }
</script>
@endsection