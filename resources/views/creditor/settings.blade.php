@extends('layouts.creditorNItems')

@section('title', __('strings.company_settings') . ' | PayAware')

@section('content')
    <main class="pt-28 pb-12 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
        <h1 class="text-3xl font-bold text-slate-800 mb-8">{{ __('strings.company_settings') }}</h1>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            
            <div class="lg:col-span-1 space-y-2">
                <button onclick="showSection('general')" id="btn-general" class="w-full flex items-center gap-3 px-4 py-3 bg-white rounded-xl shadow-sm border border-slate-100 text-teal-600 font-bold transition hover:bg-teal-50 active-tab">
                    <i data-lucide="building-2" class="w-5 h-5 rtl:ml-3"></i> {{ __('strings.general_info') }}
                </button>
                <button onclick="showSection('billing')" id="btn-billing" class="w-full flex items-center gap-3 px-4 py-3 bg-white rounded-xl shadow-sm border border-slate-100 text-slate-600 font-medium transition hover:bg-slate-50 hover:text-teal-600">
                    <i data-lucide="credit-card" class="w-5 h-5 rtl:ml-3"></i> {{ __('strings.billing_taxes') }}
                </button>
                <button onclick="showSection('team')" id="btn-team" class="w-full flex items-center gap-3 px-4 py-3 bg-white rounded-xl shadow-sm border border-slate-100 text-slate-600 font-medium transition hover:bg-slate-50 hover:text-teal-600">
                    <i data-lucide="users" class="w-5 h-5 rtl:ml-3"></i> {{ __('strings.team_members') }}
                </button>
                <button onclick="showSection('security')" id="btn-security" class="w-full flex items-center gap-3 px-4 py-3 bg-white rounded-xl shadow-sm border border-slate-100 text-slate-600 font-medium transition hover:bg-slate-50 hover:text-teal-600">
                    <i data-lucide="lock" class="w-5 h-5 rtl:ml-3"></i> {{ __('strings.security') }}
                </button>
            </div>

            <div class="lg:col-span-3 space-y-8">
                
                @if(session('success'))
                    <div class="mb-4 p-4 bg-teal-50 border border-teal-100 text-teal-700 rounded-xl flex items-center gap-2">
                        <i data-lucide="check-circle" class="w-5 h-5"></i>
                        {{ session('success') }}
                    </div>
                @endif
                @if($errors->any())
                    <div class="mb-4 p-4 bg-red-50 border border-red-100 text-red-700 rounded-xl">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div id="general-section" class="bg-white p-8 rounded-[2rem] shadow-sm border border-slate-100">
                    <h2 class="text-xl font-bold text-slate-800 mb-6">{{ __('strings.company_information') }}</h2>
                    
                    <form action="{{ route('creditor.settings.update.general') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="flex items-center gap-6 mb-8">
                            <div class="relative group">
                                <div class="w-24 h-24 rounded-2xl border-4 border-slate-50 shadow-md bg-indigo-50 p-2 overflow-hidden relative">
                                    <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : 'https://api.dicebear.com/7.x/identicon/svg?seed=' . urlencode($user->company_name ?? 'default') }}" class="w-full h-full object-cover">
                                    <div class="absolute inset-0 bg-black/30 hidden group-hover:flex items-center justify-center transition">
                                        <i data-lucide="camera" class="text-white w-6 h-6"></i>
                                    </div>
                                </div>
                                <label for="avatar-upload" class="absolute bottom-0 right-0 rtl:right-auto rtl:left-0 bg-teal-500 text-white p-2 rounded-full hover:bg-teal-600 transition shadow-lg cursor-pointer">
                                    <i data-lucide="upload" class="w-4 h-4"></i>
                                </label>
                                <input type="file" id="avatar-upload" name="avatar" class="hidden" accept="image/*" onchange="document.getElementById('avatar-preview-text').classList.remove('hidden')">
                            </div>
                            <div>
                                <h3 class="font-bold text-slate-800 text-lg">{{ $user->company_name ?? $user->name }}</h3>
                                <p class="text-slate-400 text-sm">{{ $user->role ?? __('strings.business_account') }}</p>
                                <p id="avatar-preview-text" class="text-xs text-teal-600 mt-1 hidden font-bold">{{ __('strings.image_selected_save_to_apply') }}</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <label class="text-xs font-bold text-slate-500 uppercase ml-1 rtl:ml-0 rtl:mr-1 mb-2 block">{{ __('strings.company_name') }}</label>
                                <input type="text" name="company_name" value="{{ old('company_name', $user->company_name) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 outline-none text-slate-700">
                            </div>
                            <div>
                                <label class="text-xs font-bold text-slate-500 uppercase ml-1 rtl:ml-0 rtl:mr-1 mb-2 block">{{ __('strings.business_email') }}</label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 outline-none text-slate-700 text-left" dir="ltr">
                            </div>
                            <div>
                                <label class="text-xs font-bold text-slate-500 uppercase ml-1 rtl:ml-0 rtl:mr-1 mb-2 block">{{ __('strings.phone_number') }}</label>
                                <input type="tel" name="phone" value="{{ old('phone', $user->phone) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 outline-none text-slate-700 text-left" dir="ltr">
                            </div>
                            <div class="md:col-span-2">
                                <label class="text-xs font-bold text-slate-500 uppercase ml-1 rtl:ml-0 rtl:mr-1 mb-2 block">{{ __('strings.headquarters_address') }}</label>
                                <textarea name="address" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 outline-none text-slate-700 resize-none h-24">{{ old('address', $user->address) }}</textarea>
                            </div>
                        </div>

                        <div class="mt-8 flex justify-end rtl:justify-end">
                            <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg shadow-teal-200 transition">{{ __('strings.save_changes') }}</button>
                        </div>
                    </form>
                </div>

                <div id="billing-section" class="hidden bg-white p-8 rounded-[2rem] shadow-sm border border-slate-100">
                    <h2 class="text-xl font-bold text-slate-800 mb-6">{{ __('strings.billing_invoice_settings') }}</h2>
                    
                    <form action="{{ route('creditor.settings.update.billing') }}" method="POST">
                        @csrf
                        <div class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="text-xs font-bold text-slate-500 uppercase ml-1 rtl:ml-0 rtl:mr-1 mb-2 block">{{ __('strings.default_currency') }}</label>
                                    <select name="currency" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 outline-none text-slate-700">
                                        <option value="USD" {{ old('currency', $user->currency) == 'USD' ? 'selected' : '' }}>USD ($)</option>
                                        <option value="ILS" {{ old('currency', $user->currency) == 'ILS' ? 'selected' : '' }}>ILS (₪)</option>
                                        <option value="JOD" {{ old('currency', $user->currency) == 'JOD' ? 'selected' : '' }}>JOD (JD)</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="text-xs font-bold text-slate-500 uppercase ml-1 rtl:ml-0 rtl:mr-1 mb-2 block">{{ __('strings.tax_rate') }} (%)</label>
                                    <input type="number" name="tax_rate" step="0.01" value="{{ old('tax_rate', $user->tax_rate) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 outline-none text-slate-700">
                                </div>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-slate-500 uppercase ml-1 rtl:ml-0 rtl:mr-1 mb-2 block">{{ __('strings.invoice_footer_note') }}</label>
                                <textarea name="invoice_footer_note" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 outline-none text-slate-700 resize-none h-24">{{ old('invoice_footer_note', $user->invoice_footer_note) }}</textarea>
                            </div>
                        </div>

                        <div class="mt-8 flex justify-end rtl:justify-end">
                            <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg shadow-teal-200 transition">{{ __('strings.update_billing') }}</button>
                        </div>
                    </form>
                </div>

                <div id="team-section" class="hidden bg-white p-8 rounded-[2rem] shadow-sm border border-slate-100">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-bold text-slate-800">{{ __('strings.team_management') }}</h2>
                        <button class="bg-indigo-50 text-indigo-600 hover:bg-indigo-100 px-4 py-2 rounded-lg text-sm font-bold transition flex items-center gap-2">
                            <i data-lucide="plus" class="w-4 h-4"></i> {{ __('strings.add_member') }}
                        </button>
                    </div>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-4 bg-slate-50 rounded-xl border border-slate-100">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-full bg-teal-100 text-teal-700 flex items-center justify-center font-bold">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-slate-800">{{ $user->name }}</h4>
                                    <p class="text-xs text-slate-500">{{ $user->role ?? __('strings.owner') }}</p>
                                </div>
                            </div>
                            <span class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded-full font-bold">{{ __('strings.active') }}</span>
                        </div>
                    </div>
                </div>

                <div id="security-section" class="hidden bg-white p-8 rounded-[2rem] shadow-sm border border-slate-100">
                    <h2 class="text-xl font-bold text-slate-800 mb-6">{{ __('strings.security_settings') }}</h2>
                    
                    <form action="{{ route('creditor.settings.update.security') }}" method="POST">
                        @csrf
                        <div class="space-y-6">
                            <div>
                                <label class="text-xs font-bold text-slate-500 uppercase ml-1 rtl:ml-0 rtl:mr-1 mb-2 block">{{ __('strings.current_password') }}</label>
                                <input type="password" name="current_password" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 outline-none">
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="text-xs font-bold text-slate-500 uppercase ml-1 rtl:ml-0 rtl:mr-1 mb-2 block">{{ __('strings.new_password') }}</label>
                                    <input type="password" name="new_password" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 outline-none">
                                </div>
                                <div>
                                    <label class="text-xs font-bold text-slate-500 uppercase ml-1 rtl:ml-0 rtl:mr-1 mb-2 block">{{ __('strings.confirm_new_password') }}</label>
                                    <input type="password" name="new_password_confirmation" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 outline-none">
                                </div>
                            </div>
                        </div>

                        <div class="mt-8 pt-8 border-t border-slate-100">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="font-bold text-slate-800">{{ __('strings.two_factor_auth') }}</h3>
                                    <p class="text-xs text-slate-500 mt-1">{{ __('strings.secure_2fa_desc') }}</p>
                                </div>
                                <div class="relative inline-block w-12 mr-2 rtl:mr-0 rtl:ml-2 align-middle select-none transition duration-200 ease-in">
                                    <input type="checkbox" name="two_factor_enabled" id="toggle-2fa" class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer border-slate-300 transition-all duration-300" {{ $user->two_factor_enabled ? 'checked' : '' }}/>
                                    <label for="toggle-2fa" class="toggle-label block overflow-hidden h-6 rounded-full bg-slate-300 cursor-pointer transition-colors duration-300"></label>
                                </div>
                            </div>
                        </div>

                        <div class="mt-8 flex justify-end rtl:justify-end">
                            <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg shadow-teal-200 transition">{{ __('strings.update_security') }}</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </main>
@endsection

@push('scripts')
<script src="{{ asset('js/creditorLog.js') }}"></script>
@endpush

@push('styles')
<link rel="stylesheet" href="{{ asset('css/creditorStyle.css') }}">
@endpush