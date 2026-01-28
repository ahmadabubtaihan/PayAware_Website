<div id="addPaymentModal" class="hidden fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm transition-opacity" onclick="toggleModal('addPaymentModal')"></div>
    <div class="flex min-h-full items-center justify-center p-4">
        <div class="relative transform overflow-hidden rounded-2xl bg-white text-left rtl:text-right shadow-xl transition-all sm:w-full sm:max-w-lg p-6">
            
            <div class="flex justify-between items-center mb-5">
                <h3 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                    <div class="p-2 bg-teal-50 rounded-lg text-teal-600"><i data-lucide="wallet" class="w-5 h-5"></i></div>
                    {{ __('strings.record_payment_title') }}
                </h3>
                <button type="button" onclick="toggleModal('addPaymentModal')">
                    <i data-lucide="x" class="w-5 h-5 text-slate-400 hover:text-red-500 transition"></i>
                </button>
            </div>

            <form action="{{ route('creditor.payments.store') }}" method="POST">
                @csrf
                <div class="space-y-4">

                    {{--  القائمة السريعة --}}
                    @php
                        $debtorsWithDebt = \App\Models\User::whereHas('debtsAsDebtor', function($q) {
                            $q->where('creditor_id', auth()->id())->where('remaining_amount', '>', 0);
                        })->distinct()->get();
                    @endphp

                    @if($debtorsWithDebt->count() > 0)
                    <div class="bg-slate-50 p-3 rounded-xl border border-slate-100">
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-2 flex items-center gap-1">
                            <i data-lucide="history" class="w-3 h-3"></i> {{ __('strings.quick_select_debtor') }}
                        </label>
                        <select onchange="document.getElementById('paymentDebtorId').value = this.value" class="w-full bg-white border border-slate-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-teal-500/20 outline-none transition">
                            <option value="">{{ __('strings.select_user_placeholder') }}</option>
                            @foreach($debtorsWithDebt as $pDebtor)
                                <option value="{{ $pDebtor->account_id }}">
                                    {{ $pDebtor->name }} (#{{ $pDebtor->account_id }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @endif

                    {{--  إدخال ID --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">
                            {{ __('strings.debtor_id_label') }} <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="text" name="debtor_input" id="paymentDebtorId" required 
                                   placeholder="{{ __('strings.debtor_id_example') }}" 
                                   class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 pl-10 rtl:pr-10 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-teal-500/20 transition">
                            <div class="absolute inset-y-0 left-0 rtl:right-0 rtl:left-auto pl-3 rtl:pr-3 flex items-center pointer-events-none">
                                <i data-lucide="hash" class="w-4 h-4 text-slate-400"></i>
                            </div>
                        </div>
                        <p class="text-[10px] text-slate-400 mt-1">{{ __('strings.debtor_id_help') }}</p>
                    </div>

                    {{-- المبلغ وطريقة الدفع --}}
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">{{ __('strings.amount') }} <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <input type="number" name="amount" step="0.01" required placeholder="0.00" 
                                       class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm font-bold text-teal-600 focus:outline-none focus:ring-2 focus:ring-teal-500/20">
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">{{ __('strings.payment_method') }}</label>
                            <select name="payment_method" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500/20">
                                <option value="cash">{{ __('strings.cash') }}</option>
                                <option value="bank_transfer">{{ __('strings.bank_transfer') }}</option>
                                <option value="check">{{ __('strings.check') }}</option>
                            </select>
                        </div>
                    </div>

                    {{-- 4. ملاحظات --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">{{ __('strings.notes') }}</label>
                        <textarea name="notes" rows="2" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500/20"></textarea>
                    </div>
                </div>

                <div class="mt-6 flex justify-end gap-2 pt-4 border-t border-slate-50">
                    <button type="button" onclick="toggleModal('addPaymentModal')" class="px-4 py-2 bg-white border border-slate-200 text-slate-600 rounded-xl text-sm font-bold hover:bg-slate-50 transition">{{ __('strings.cancel') }}</button>
                    <button type="submit" class="px-6 py-2 bg-teal-600 text-white rounded-xl text-sm font-bold shadow-lg shadow-teal-200 hover:bg-teal-700 transition flex items-center gap-2">
                        <i data-lucide="check" class="w-4 h-4"></i> {{ __('strings.confirm_payment') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>