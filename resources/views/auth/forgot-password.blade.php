<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Lupa Password?</h2>
    </div>

    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 p-6 rounded-xl text-center">
        <div class="flex justify-center mb-4">
            <div class="bg-blue-100 dark:bg-blue-900/40 p-3 rounded-full">
                <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </div>
        </div>
        <h3 class="text-lg font-semibold text-blue-800 dark:text-blue-300 mb-2">Hubungi Admin</h3>
        <p class="text-sm text-blue-700 dark:text-blue-400 mb-4">
            Jika Anda lupa password, silakan hubungi <span class="font-bold">Admin ATMI</span> secara langsung untuk melakukan reset password akun Anda. Sistem tidak mendukung reset otomatis via email saat ini.
        </p>
    </div>

    <div class="mt-6 flex justify-center">
        <a href="{{ route('login') }}" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-semibold shadow-md transition duration-150">
            Kembali ke Halaman Login
        </a>
    </div>
</x-guest-layout>