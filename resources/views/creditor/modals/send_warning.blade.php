<div id="warningModal" class="fixed inset-0 z-[100] hidden" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm transition-opacity" onclick="toggleModal('warningModal')"></div>
    <div class="flex min-h-full items-center justify-center p-4">
        <div class="relative transform overflow-hidden rounded-2xl bg-white text-left rtl:text-right shadow-xl transition-all sm:w-full sm:max-w-lg p-6">
            
            <div class="flex justify-between items-center mb-5 border-b border-slate-50 pb-4">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-orange-50 rounded-lg text-orange-500"><i data-lucide="bell-ring" class="w-6 h-6"></i></div>
                    <div>
                        <h3 class="text-lg font-bold text-slate-900">{{ __('strings.send_warning_title') }}</h3>
                        <p class="text-xs text-slate-500">{{ __('strings.send_nudge_desc') }}</p>
                    </div>
                </div>
                <button type="button" onclick="toggleModal('warningModal')">
                    <i data-lucide="x" class="w-5 h-5 text-slate-400 hover:text-red-500 transition"></i>
                </button>
            </div>

            <form action="{{ route('creditor.warnings.store') }}" method="POST">
                @csrf
                <div class="space-y-4">

                    {{-- 1. القائمة السريعة (المستخدمين المتأخرين مثلاً أو كلهم) --}}
                    @php
                        $debtors = \App\Models\User::whereHas('debtsAsDebtor', function($q) {
                            $q->where('creditor_id', auth()->id())->where('remaining_amount', '>', 0);
                        })->distinct()->get();
                    @endphp

                    @if($debtors->count() > 0)
                    <div class="bg-orange-50/50 p-3 rounded-xl border border-orange-100">
                        <label class="block text-xs font-bold text-orange-500 uppercase mb-2 flex items-center gap-1">
                            <i data-lucide="users" class="w-3 h-3"></i> {{ __('strings.quick_select_debtor') }}
                        </label>
                        <select onchange="document.getElementById('warningDebtorId').value = this.value" class="w-full bg-white border border-orange-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-orange-500/20 outline-none transition text-slate-700 font-medium">
                            <option value="">{{ __('strings.select_user_placeholder') }}</option>
                            @foreach($debtors as $pDebtor)
                                <option value="{{ $pDebtor->account_id }}">
                                    {{ $pDebtor->name }} (#{{ $pDebtor->account_id }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @endif

                    {{-- 2. إدخال ID --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">
                            {{ __('strings.debtor_id_label') }} <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="text" name="debtor_input" id="warningDebtorId" required 
                                   placeholder="{{ __('strings.debtor_id_example') }}" 
                                   class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 pl-10 rtl:pr-10 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-orange-500/20 transition">
                            <div class="absolute inset-y-0 left-0 rtl:right-0 rtl:left-auto pl-3 rtl:pr-3 flex items-center pointer-events-none">
                                <i data-lucide="hash" class="w-4 h-4 text-slate-400"></i>
                            </div>
                        </div>
                    </div>

                    {{-- 3. نص الرسالة --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">{{ __('strings.note_reason') }}</label>
                        <textarea name="message" required 
                                  placeholder="{{ __('strings.warning_message_placeholder') }}" 
                                  class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-orange-200 outline-none h-28 resize-none">{{ __('strings.reminder_msg_default') }}</textarea>
                        <p class="text-[10px] text-slate-400 mt-1 text-right rtl:text-left">{{ __('strings.message_will_be_sent_as_notification') }}</p>
                    </div>
                </div>

                <div class="mt-6 flex justify-end gap-2 pt-4 border-t border-slate-50">
                    <button type="button" onclick="toggleModal('warningModal')" class="px-4 py-2 bg-white border border-slate-200 text-slate-600 rounded-xl text-sm font-bold hover:bg-slate-50 transition">{{ __('strings.cancel') }}</button>
                    <button type="submit" class="px-6 py-2 bg-orange-500 text-white rounded-xl text-sm font-bold shadow-lg shadow-orange-200 hover:bg-orange-600 transition flex items-center gap-2">
                        <i data-lucide="send" class="w-4 h-4"></i> {{ __('strings.send_alert') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>