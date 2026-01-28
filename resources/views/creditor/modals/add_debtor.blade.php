<div id="addUserModal" class="fixed inset-0 z-[100] hidden" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm transition-opacity" onclick="toggleModal('addUserModal')"></div>
    <div class="fixed inset-0 z-10 overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-2xl bg-white text-left rtl:text-right shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                
                <form action="{{ route('creditor.debtors.store') }}" method="POST">
                    @csrf
                    <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                        <h3 class="text-lg font-bold text-slate-900 mb-4 flex items-center gap-2">
                            <div class="p-2 bg-indigo-50 rounded-lg text-indigo-500"><i data-lucide="user-plus" class="w-5 h-5"></i></div>
                            {{ __('strings.create_new_record_title') }}
                        </h3>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-500 mb-1">{{ __('strings.full_name') }}</label>
                                <input type="text" name="name" required placeholder="Ahmed Ali" 
                                       class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-indigo-200 outline-none">
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 mb-1">{{ __('strings.email') }}</label>
                                    <input type="email" name="email" required placeholder="user@example.com" 
                                           class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-indigo-200 outline-none">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 mb-1">{{ __('strings.phone') }}</label>
                                    <input type="text" name="phone" required placeholder="059xxxxxxx" 
                                           class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-indigo-200 outline-none">
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-500 mb-1">{{ __('strings.password_label') }}</label>
                                <input type="text" name="password" required placeholder="******" 
                                       class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-indigo-200 outline-none">
                                <p class="text-[10px] text-slate-400 mt-1">{{ __('strings.password_hint') }}</p>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-500 mb-1">{{ __('strings.address') }}</label>
                                <input type="text" name="address" placeholder="Nablus, Palestine" 
                                       class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-indigo-200 outline-none">
                            </div>
                        </div>
                    </div>

                    <div class="bg-slate-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 gap-2">
                        <button type="submit" class="inline-flex w-full justify-center rounded-xl bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 sm:ml-3 sm:w-auto transition">
                            {{ __('strings.create_account') }}
                        </button>
                        <button type="button" class="mt-3 inline-flex w-full justify-center rounded-xl bg-white px-3 py-2 text-sm font-semibold text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 hover:bg-slate-50 sm:mt-0 sm:w-auto transition" onclick="toggleModal('addUserModal')">
                            {{ __('strings.cancel') }}
                        </button>
                    </div>
                </form>
                
            </div>
        </div>
    </div>
</div>