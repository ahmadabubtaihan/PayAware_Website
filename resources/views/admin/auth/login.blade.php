<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - payAware</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #0f172a; }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-md bg-white rounded-[2rem] shadow-2xl overflow-hidden relative">
        <div class="h-32 bg-gradient-to-r from-slate-800 to-slate-900 flex items-center justify-center relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-full bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
            <div class="z-10 text-center">
                <h1 class="text-3xl font-bold text-white font-cursive">payAware</h1>
                <p class="text-teal-400 text-xs font-bold uppercase tracking-widest mt-1">Admin Panel</p>
            </div>
        </div>

        <div class="p-8">
            <h2 class="text-xl font-bold text-slate-800 mb-6 text-center">Secure Login</h2>

            @if(session('error'))
                <div class="mb-4 p-3 bg-red-50 border border-red-100 text-red-600 text-sm rounded-xl flex items-center gap-2">
                    <i data-lucide="alert-circle" class="w-4 h-4"></i>
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login.submit') }}">
                @csrf

                <div class="space-y-4">
                    {{-- الايميل --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Email Address</label>
                        <div class="relative">
                            <input type="email" name="email" value="{{ old('email') }}" required autofocus class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-teal-500/50 transition text-sm font-bold text-slate-700">
                            <i data-lucide="mail" class="absolute left-3 top-3 w-5 h-5 text-slate-400"></i>
                        </div>
                    </div>

                    {{-- الباسوورد --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Password</label>
                        <div class="relative">
                            <input type="password" name="password" required class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-teal-500/50 transition text-sm font-bold text-slate-700">
                            <i data-lucide="lock" class="absolute left-3 top-3 w-5 h-5 text-slate-400"></i>
                        </div>
                    </div>

                    {{-- تذكرني --}}
                    <div class="flex items-center justify-between">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="remember" class="w-4 h-4 rounded text-teal-600 focus:ring-teal-500 border-gray-300">
                            <span class="text-xs font-bold text-slate-500">Remember me</span>
                        </label>
                    </div>

                    <button type="submit" class="w-full bg-slate-800 hover:bg-slate-900 text-white font-bold py-3.5 rounded-xl shadow-lg shadow-slate-300/50 transition flex items-center justify-center gap-2">
                        <span>Access Dashboard</span>
                        <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </button>
                </div>
            </form>
        </div>
        
        <div class="bg-slate-50 p-4 text-center border-t border-slate-100">
            <p class="text-xs text-slate-400 font-medium">Restricted Area &copy; {{ date('Y') }}</p>
        </div>
    </div>

    <script>lucide.createIcons();</script>
</body>
</html>