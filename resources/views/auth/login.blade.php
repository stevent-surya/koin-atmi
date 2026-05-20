@extends('layouts.guest', ['title' => 'Masuk'])

@section('content')
<div class="mb-6 text-center">
    <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Masuk ke Akun</h2>
    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Gunakan akun mahasiswa yang sudah terdaftar.</p>
</div>

<form method="POST" action="{{ route('login') }}">
    @csrf

    <div>
        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
               class="block w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm">
        @error('email')
            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>

    <div class="mt-4">
        <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Password</label>
        <div class="relative" x-data="{ show: false }">
            <input :type="show ? 'text' : 'password'" id="password" name="password" required autocomplete="current-password"
                   class="block w-full px-4 py-2.5 pr-10 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm">
            <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-200">
                <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                <svg x-show="show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path></svg>
            </button>
        </div>
        @error('password')
            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex items-center justify-end mt-6 flex-col sm:flex-row gap-3">
        <a class="text-sm text-gray-600 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400" href="{{ route('password.request') }}">
            Lupa password?
        </a>

        <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-semibold shadow-md transition duration-150">
            Masuk
        </button>
    </div>

    <div class="mt-6 text-center">
        <p class="text-sm text-gray-500 dark:text-gray-400">Belum punya akun? 
            <a href="{{ route('register') }}" class="font-semibold text-indigo-600 hover:text-indigo-800 dark:text-indigo-400">Daftar di sini</a>
        </p>
    </div>
</form>
@endsection