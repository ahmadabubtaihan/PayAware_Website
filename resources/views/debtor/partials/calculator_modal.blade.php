<div id="calculatorModal" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" onclick="closeCalculator()"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-lg p-4">
        <div class="bg-white rounded-[2rem] shadow-2xl overflow-hidden modal-enter transform transition-all">
            <div class="bg-slate-50 p-6 border-b border-slate-100 flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center"><i data-lucide="calculator" class="w-5 h-5"></i></div>
                    <div><h3 class="text-lg font-bold text-slate-800">Installment Calculator</h3><p class="text-xs text-slate-500">Plan your payments</p></div>
                </div>
                <button onclick="closeCalculator()" class="text-slate-400 hover:text-red-500"><i data-lucide="x" class="w-6 h-6"></i></button>
            </div>
            <div class="p-6 space-y-5">
                <div><label class="text-xs font-bold text-slate-500 uppercase ml-1 mb-1 block">Total Amount ($)</label><input type="number" id="totalAmount" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none font-bold text-slate-700" placeholder="1000"></div>
                <div class="grid grid-cols-2 gap-4">
                    <div><label class="text-xs font-bold text-slate-500 uppercase ml-1 mb-1 block">Down Payment</label><input type="number" id="downPayment" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-indigo-500/20 outline-none" placeholder="200"></div>
                    <div><label class="text-xs font-bold text-slate-500 uppercase ml-1 mb-1 block">Months</label><input type="number" id="months" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-indigo-500/20 outline-none" placeholder="12"></div>
                </div>
                <div id="calcResult" class="hidden bg-indigo-50 rounded-2xl p-5 border border-indigo-100 text-center">
                    <p class="text-xs text-indigo-400 font-bold uppercase mb-1">Monthly Payment</p>
                    <h2 class="text-3xl font-extrabold text-indigo-600" id="monthlyResult">$0.00</h2>
                </div>
            </div>
            <div class="p-4 bg-slate-50 border-t border-slate-100 flex gap-3">
                <button onclick="calculateInstallment()" class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 rounded-xl shadow-lg">Calculate</button>
            </div>
        </div>
    </div>
</div>