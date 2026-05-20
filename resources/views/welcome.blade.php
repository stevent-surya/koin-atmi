<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ATMI Koin - Sistem Peminjaman Alat</title>
    
    <!-- Favicon di Tab Browser -->
    <link rel="icon" type="image/png" href="{{ asset('images/atmi-logo.png') }}">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="antialiased bg-gradient-to-br from-indigo-50 via-white to-purple-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 min-h-screen flex flex-col">

    <nav class="p-6 flex justify-between items-center max-w-7xl mx-auto w-full">
        <h1 class="text-2xl font-bold text-indigo-600 dark:text-indigo-400 flex items-center gap-2">
            <img src="{{ asset('images/atmi-logo.png') }}" alt="ATMI Logo" class="w-8 h-8">
            ATMI Koin
        </h1>
        <div class="space-x-4">
            @auth
                <a href="{{ route('dashboard') }}" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium transition duration-150">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="px-5 py-2 text-indigo-600 dark:text-indigo-400 font-medium hover:text-indigo-800 transition duration-150">Masuk</a>
                <a href="{{ route('register') }}" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium transition duration-150">Daftar</a>
            @endauth
        </div>
    </nav>

    <main class="flex-grow flex items-center justify-center px-6">
        <div class="max-w-3xl text-center space-y-8 mb-20">
            
            <!-- LOGO DI-SCALE UP DAN BACKGROUND DIHAPUS -->
            <div class="mb-4 flex justify-center">
                <img src="{{ asset('images/atmi-logo.png') }}" alt="Logo ATMI" class="w-36 h-36 object-contain drop-shadow-md">
            </div>
            
            <h2 class="text-4xl md:text-5xl font-extrabold text-gray-900 dark:text-gray-100 leading-tight">
                Sistem Peminjaman Alat<br>
                <span class="text-indigo-600 dark:text-indigo-400">Berbasis Koin Digital</span>
            </h2>
            
            <p class="text-lg text-gray-600 dark:text-gray-400 max-w-xl mx-auto">
                Setiap mahasiswa akan mendapatkan <span class="font-bold text-yellow-600 dark:text-yellow-400">10 Koin</span> untuk meminjam alat di workshop. Kembalikan alat tepat waktu agar koin Anda dikembalikan!
            </p>

            <div class="flex flex-col sm:flex-row justify-center gap-4 pt-4">
                @guest
                    <a href="{{ route('register') }}" class="px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white text-lg rounded-xl font-semibold shadow-lg hover:shadow-xl transition duration-300 transform hover:-translate-y-0.5">
                        Daftar Akun Mahasiswa
                    </a>
                    <a href="{{ route('login') }}" class="px-8 py-3 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200 text-lg rounded-xl font-semibold shadow hover:shadow-md border border-gray-200 dark:border-gray-700 transition duration-150">
                        Masuk
                    </a>
                @endguest
            </div>
        </div>
    </main>

    <footer class="py-6 text-center text-gray-500 dark:text-gray-400 text-sm">
        &copy; {{ date('Y') }} ATMI Koin. All rights reserved.
    </footer>
</body>
</html>