@extends('layouts.debtor')

@section('title', __('strings.settings_title'))

@section('content')
<main class="pt-28 pb-12 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    <h1 class="text-3xl font-bold text-slate-800 mb-8">{{ __('strings.settings_title') }}</h1>

    @if (session('success'))
        <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl relative flex items-center gap-2 shadow-sm">
            <i data-lucide="check-circle" class="w-5 h-5"></i>
            <span class="block sm:inline font-bold">{{ session('success') }}</span>
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl relative shadow-sm">
            <ul class="list-disc list-inside text-sm font-bold">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        
        <div class="lg:col-span-1 space-y-2">
            <button onclick="showSection('profile')" id="btn-profile" class="w-full flex items-center gap-3 px-4 py-3 bg-white rounded-xl shadow-sm border border-slate-100 text-teal-600 font-bold transition hover:bg-teal-50 text-left rtl:text-right ring-2 ring-teal-500 ring-opacity-0 focus:ring-opacity-100">
                <i data-lucide="user" class="w-5 h-5"></i> {{ __('strings.profile_info') }}
            </button>
            <button onclick="showSection('security')" id="btn-security" class="w-full flex items-center gap-3 px-4 py-3 bg-white rounded-xl shadow-sm border border-slate-100 text-slate-600 font-medium transition hover:bg-slate-50 hover:text-teal-600 text-left rtl:text-right">
                <i data-lucide="lock" class="w-5 h-5"></i> {{ __('strings.security') }}
            </button>
            <button onclick="showSection('notifications')" id="btn-notifications" class="w-full flex items-center gap-3 px-4 py-3 bg-white rounded-xl shadow-sm border border-slate-100 text-slate-600 font-medium transition hover:bg-slate-50 hover:text-teal-600 text-left rtl:text-right">
                <i data-lucide="bell" class="w-5 h-5"></i> {{ __('strings.notifications') }}
            </button>
        </div>

        <div class="lg:col-span-3 space-y-8">
            
            <div id="profile-section" class="bg-white p-8 rounded-[2rem] shadow-sm border border-slate-100">
                <h2 class="text-xl font-bold text-slate-800 mb-6">{{ __('strings.profile_info') }}</h2>
                
                <div class="flex items-center gap-6 mb-8">
                    <div class="relative group">
                        <img src="{{ Auth::user()->avatar ? asset('storage/'.Auth::user()->avatar) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=random' }}" class="w-24 h-24 rounded-full border-4 border-slate-50 shadow-md object-cover">
                        <a href="{{ route('debtor.profile') }}" class="absolute bottom-0 right-0 rtl:right-auto rtl:left-0 bg-teal-500 text-white p-2 rounded-full hover:bg-teal-600 transition shadow-lg" title="Change Avatar">
                            <i data-lucide="camera" class="w-4 h-4"></i>
                        </a>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-800 text-lg">{{ Auth::user()->name }}</h3>
                        <p class="text-slate-400 text-sm">{{ __('strings.debtor_account') }}</p>
                    </div>
                </div>

                <form action="{{ route('debtor.settings.update_profile') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="text-xs font-bold text-slate-500 uppercase ml-1 rtl:ml-0 rtl:mr-1 mb-2 block">{{ __('strings.full_name') ?? 'Full Name' }}</label>
                            <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 outline-none text-slate-700">
                        </div>
                        <div>
                            <label class="text-xs font-bold text-slate-500 uppercase ml-1 rtl:ml-0 rtl:mr-1 mb-2 block">{{ __('strings.email_address') }}</label>
                            <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 outline-none text-slate-700">
                        </div>
                        <div>
                            <label class="text-xs font-bold text-slate-500 uppercase ml-1 rtl:ml-0 rtl:mr-1 mb-2 block">{{ __('strings.phone_number') }}</label>
                            <input type="tel" name="phone" value="{{ old('phone', Auth::user()->phone) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 outline-none text-slate-700 text-left rtl:text-right" dir="ltr">
                        </div>
                        <div class="md:col-span-2">
                            <label class="text-xs font-bold text-slate-500 uppercase ml-1 rtl:ml-0 rtl:mr-1 mb-2 block">{{ __('strings.address') }}</label>
                            <textarea name="address" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 outline-none text-slate-700 resize-none h-24">{{ old('address', Auth::user()->address) }}</textarea>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end rtl:justify-end">
                        <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg shadow-teal-200 transition">{{ __('strings.save_changes') }}</button>
                    </div>
                </form>
            </div>

            {{-- سيكشن الامان --}}
            <div id="security-section" class="hidden bg-white p-8 rounded-[2rem] shadow-sm border border-slate-100">
                <h2 class="text-xl font-bold text-slate-800 mb-6">{{ __('strings.security_settings') }}</h2>
                
                <form action="{{ route('debtor.settings.update_password') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="space-y-6">
                        <div>
                            <label class="text-xs font-bold text-slate-500 uppercase ml-1 rtl:ml-0 rtl:mr-1 mb-2 block">{{ __('strings.current_password') }}</label>
                            <input type="password" name="current_password" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 outline-none">
                            @error('current_password') <span class="text-red-500 text-xs font-bold mt-1">{{ $message }}</span> @enderror
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="text-xs font-bold text-slate-500 uppercase ml-1 rtl:ml-0 rtl:mr-1 mb-2 block">{{ __('strings.new_password') }}</label>
                                <input type="password" name="password" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 outline-none">
                                @error('password') <span class="text-red-500 text-xs font-bold mt-1">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="text-xs font-bold text-slate-500 uppercase ml-1 rtl:ml-0 rtl:mr-1 mb-2 block">{{ __('strings.confirm_new_password') }}</label>
                                <input type="password" name="password_confirmation" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 outline-none">
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end">
                        <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg shadow-teal-200 transition">{{ __('strings.update_security') }}</button>
                    </div>
                </form>
            </div>

            {{-- سيكشن الإشعارات --}}
            <div id="notifications-section" class="hidden bg-white p-8 rounded-[2rem] shadow-sm border border-slate-100">
                <h2 class="text-xl font-bold text-slate-800 mb-6">{{ __('strings.notification_prefs') }}</h2>
                
                <form action="{{ route('debtor.settings.update_notifications') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="space-y-6">
                        @php
                            $prefs = Auth::user()->notification_preferences ?? [];
                        @endphp

                        <div class="flex items-center justify-between p-4 bg-slate-50 rounded-xl border border-slate-100">
                            <div class="flex items-center gap-4">
                                <div class="p-2 bg-white rounded-lg shadow-sm text-teal-600"><i data-lucide="mail" class="w-5 h-5"></i></div>
                                <div>
                                    <h4 class="text-sm font-bold text-slate-800">{{ __('strings.email_notifs') }}</h4>
                                    <p class="text-xs text-slate-500">{{ __('strings.email_notifs_desc') }}</p>
                                </div>
                            </div>
                            <input type="checkbox" name="email_notifs" class="w-5 h-5 text-teal-600 rounded focus:ring-teal-500" {{ ($prefs['email'] ?? false) ? 'checked' : '' }}>
                        </div>

                        <div class="flex items-center justify-between p-4 bg-slate-50 rounded-xl border border-slate-100">
                            <div class="flex items-center gap-4">
                                <div class="p-2 bg-white rounded-lg shadow-sm text-indigo-600"><i data-lucide="bell" class="w-5 h-5"></i></div>
                                <div>
                                    <h4 class="text-sm font-bold text-slate-800">{{ __('strings.push_notifs') }}</h4>
                                    <p class="text-xs text-slate-500">{{ __('strings.push_notifs_desc') }}</p>
                                </div>
                            </div>
                            <input type="checkbox" name="push_notifs" class="w-5 h-5 text-teal-600 rounded focus:ring-teal-500" {{ ($prefs['push'] ?? true) ? 'checked' : '' }}>
                        </div>

                        <div class="flex items-center justify-between p-4 bg-slate-50 rounded-xl border border-slate-100">
                            <div class="flex items-center gap-4">
                                <div class="p-2 bg-white rounded-lg shadow-sm text-green-600"><i data-lucide="message-circle" class="w-5 h-5"></i></div>
                                <div>
                                    <h4 class="text-sm font-bold text-slate-800">{{ __('strings.whatsapp_alerts') }}</h4>
                                    <p class="text-xs text-slate-500">{{ __('strings.whatsapp_alerts_desc') }}</p>
                                </div>
                            </div>
                            <input type="checkbox" name="whatsapp_alerts" class="w-5 h-5 text-teal-600 rounded focus:ring-teal-500" {{ ($prefs['whatsapp'] ?? false) ? 'checked' : '' }}>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end">
                        <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg shadow-teal-200 transition">{{ __('strings.save_changes') }}</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</main>
@endsection

@push('scripts')
<script src="{{ asset('js/debtorLog.js') }}"></script>
@endpush