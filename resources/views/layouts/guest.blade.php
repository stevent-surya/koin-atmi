<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }} - @yield('title', 'Masuk')</title>
    
    <link rel="icon" type="image/png" href="{{ asset('images/atmi-logo.png') }}">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<!-- AUTO-REDIRECT 10 DETIK JIKA TIDAK ADA AKTIVITAS -->
<body class="font-sans antialiased bg-gradient-to-br from-indigo-50 via-white to-purple-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 text-gray-900 dark:text-gray-100"
      x-data="{
          timer: null,
          init() {
              this.startTimer();
              const events = ['mousemove', 'mousedown', 'keypress', 'scroll', 'touchstart'];
              events.forEach((event) => {
                  window.addEventListener(event, () => this.resetTimer());
              });
          },
          startTimer() {
              this.timer = setTimeout(() => {
                  window.location.href = '/';
              }, 10000);
          },
          resetTimer() {
              clearTimeout(this.timer);
              this.startTimer();
          }
      }">

    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
        
        <!-- TOMBOL BACK KE HOME -->
        <div class="mb-6 text-center">
            <a href="{{ url('/') }}" class="inline-flex items-center gap-2 text-gray-600 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 text-sm font-medium transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Kembali ke Beranda
            </a>
        </div>

        <div class="w-full sm:max-w-md mt-2 px-6 py-8 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-2xl">
            @yield('content')
        </div>
    </div>
</body>
</html>