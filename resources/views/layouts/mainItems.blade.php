<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>payAware - @yield('title')</title>
    
    <!-- مكتباتي الخارجية -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <!-- ملف ال css -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
    </style>
</head>
<body class="min-h-screen text-slate-800 selection:bg-teal-100 overflow-x-hidden relative">
        <!--------------استدعاء الناف بار للصفحة الرئيسية
  --------------->

      @include('layouts.navbar')
    <!---------------------------->
    <!------------- // محتوى الصفحة --------------->
   
    @yield('content')
    <!---------------------------->
    <!-------------- // محتوى الفوتر -------------->

  
    @include('layouts.footer')
    
    <script src="{{asset('js/main.js')}}"></script>
</body>
</html>