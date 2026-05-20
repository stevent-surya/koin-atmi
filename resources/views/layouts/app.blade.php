<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'ATMI Koin') }}</title>
    
    <!-- TAMBAHKAN BARIS INI UNTUK FAVICON -->
    <link rel="icon" type="image/png" href="{{ asset('images/atmi-logo.png') }}">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gradient-to-br from-indigo-50 via-white to-purple-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900"
      x-data="{
          timer: null,
          init() {
              @auth
              this.startTimer();
              const events = ['mousemove', 'mousedown', 'keypress', 'scroll', 'touchstart'];
              events.forEach((event) => {
                  window.addEventListener(event, () => this.resetTimer());
              });
              @endauth
          },
          startTimer() {
              this.timer = setTimeout(() => {
                  this.logout();
              }, 30000);
          },
          resetTimer() {
              clearTimeout(this.timer);
              this.startTimer();
          },
          logout() {
              document.getElementById('auto-logout-form').submit();
          }
      }">

    <div class="min-h-screen">
        @include('layouts.navigation')
        {{ $slot }}
    </div>

    <form id="auto-logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
        @csrf
    </form>

</body>
</html>