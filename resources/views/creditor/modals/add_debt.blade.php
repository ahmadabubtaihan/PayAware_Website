<div id="addDebtModal" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm transition-opacity" onclick="document.getElementById('addDebtModal').classList.add('hidden')"></div>
    <div class="flex min-h-full items-center justify-center p-4">
        <div class="relative transform overflow-hidden rounded-2xl bg-white text-left rtl:text-right shadow-xl transition-all sm:w-full sm:max-w-lg p-6">
            
            <div class="flex justify-between items-center mb-5">
                <h3 class="text-lg font-bold text-slate-900">{{ __('strings.add_new_debt') }}</h3>
                <button type="button" onclick="document.getElementById('addDebtModal').classList.add('hidden')">
                    <i data-lucide="x" class="w-5 h-5 text-slate-400"></i>
                </button>
            </div>

            <form action="{{ route('creditor.debts.store') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    
                    {{--  قائمة اختيار سريعة (للمدينين السابقين) --}}
                    @php
                        $previousDebtors = \App\Models\User::whereHas('debtsAsDebtor', function($q) {
                            $q->where('creditor_id', auth()->id());
                        })->distinct()->get();
                    @endphp

                    @if($previousDebtors->count() > 0)
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">{{ __('strings.quick_select_debtor') }}</label>
                        <select onchange="document.getElementById('debtorInput').value = this.value" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-teal-500/20">
                            <option value="">{{ __('strings.select_user_placeholder') }}</option>
                            @foreach($previousDebtors as $pDebtor)
                                <option value="{{ $pDebtor->account_id }}">
                                    {{ $pDebtor->name }} (#{{ $pDebtor->account_id }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @endif

                    {{-- حقل إدخال ID --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">
                            {{ __('strings.debtor_id_label') }} <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="text" id="debtorInput" name="debtor_input" required 
                                   placeholder="{{ __('strings.debtor_id_example') }}" 
                                   class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 pl-10 rtl:pr-10 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-teal-500/20">
                            <div class="absolute inset-y-0 left-0 rtl:right-0 rtl:left-auto pl-3 rtl:pr-3 flex items-center pointer-events-none">
                                <i data-lucide="hash" class="w-4 h-4 text-slate-400"></i>
                            </div>
                        </div>
                        <p class="text-[10px] text-slate-400 mt-1">{{ __('strings.debtor_id_help') }}</p>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">{{ __('strings.amount') }} <span class="text-red-500">*</span></label>
                        <input type="number" step="0.01" name="amount" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-teal-500/20">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">{{ __('strings.due_date') }}</label>
                        <input type="date" name="due_date" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-teal-500/20">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">{{ __('strings.description') }}</label>
                        <textarea name="description" rows="2" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-teal-500/20"></textarea>
                    </div>
                </div>

                <div class="mt-6 flex justify-end gap-2">
                    <button type="button" onclick="document.getElementById('addDebtModal').classList.add('hidden')" class="px-4 py-2 bg-slate-100 text-slate-600 rounded-xl text-sm font-bold hover:bg-slate-200 transition">{{ __('strings.cancel') }}</button>
                    <button type="submit" class="px-6 py-2 bg-teal-600 text-white rounded-xl text-sm font-bold shadow-lg shadow-teal-200 hover:bg-teal-700 transition">{{ __('strings.save') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>