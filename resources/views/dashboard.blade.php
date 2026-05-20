<x-app-layout>
    <div x-data="{ showReturnModal: false, borrowId: null, itemName: '' }" class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 rounded-xl shadow-sm font-medium">✓ {{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="mb-6 p-4 bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300 rounded-xl shadow-sm font-medium">✕ {{ session('error') }}</div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md sm:rounded-2xl mb-8">
                <div class="p-6 text-gray-900 dark:text-gray-100 flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                    <div>
                        <h2 class="text-2xl font-bold">Selamat datang, {{ auth()->user()->name }}!</h2>
                        <p class="text-gray-500 dark:text-gray-400 mt-1">Ini adalah dashboard peminjaman alat Anda.</p>

                        <!-- ALERT BOX JIKA AKUN DI SUSPEND -->
                        @if(auth()->user()->is_suspended)
                            <div class="mt-4 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
                                <h4 class="text-sm font-bold text-red-700 dark:text-red-400 mb-1">⚠ Akun Anda Dalam Status Suspend!</h4>
                                <p class="text-sm text-red-600 dark:text-red-300">{{ auth()->user()->suspend_reason ?? 'Akun Anda ditangguhkan oleh Admin. Anda tidak dapat meminjam alat.' }}</p>
                            </div>
                        @endif
                    </div>

                    <div class="flex items-center space-x-2 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 px-6 py-3 rounded-xl shadow-sm">
                        <svg class="w-8 h-8 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.736 6.979C9.208 6.193 9.696 6 10 6c.304 0 .792.193 1.264.979a1 1 0 001.715-1.029C12.279 4.784 11.232 4 10 4s-2.279.784-2.979 1.95c-.285.475-.507 1-.67 1.55H6a1 1 0 000 2h.013a9.358 9.358 0 000 1H6a1 1 0 100 2h.351c.163.55.385 1.075.67 1.55C7.721 15.216 8.768 16 10 16s2.279-.784 2.979-1.95a1 1 0 10-1.715-1.029C10.792 13.807 10.304 14 10 14c-.304 0-.792-.193-1.264-.979a5.393 5.393 0 01-.402-.821H10a1 1 0 100-2H8.028a7.414 7.414 0 010-1H10a1 1 0 100-2H8.334c.12-.293.256-.571.402-.821z"/></svg>
                        <div class="text-right">
                            <p class="text-xs text-yellow-600 dark:text-yellow-400 font-medium">Sisa Koin Anda</p>
                            <p class="text-3xl font-bold text-yellow-700 dark:text-yellow-300">{{ auth()->user()->coins }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md sm:rounded-2xl">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-xl font-semibold mb-6">Peminjaman Aktif & Riwayat</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b border-gray-200 dark:border-gray-700">
                                    <th class="py-3 px-4 font-semibold text-sm text-gray-600 dark:text-gray-400">Nama Alat</th>
                                    <th class="py-3 px-4 font-semibold text-sm text-gray-600 dark:text-gray-400">Qty</th>
                                    <th class="py-3 px-4 font-semibold text-sm text-gray-600 dark:text-gray-400">Biaya Koin</th>
                                    <th class="py-3 px-4 font-semibold text-sm text-gray-600 dark:text-gray-400">Tanggal Pinjam</th>
                                    <th class="py-3 px-4 font-semibold text-sm text-gray-600 dark:text-gray-400">Status</th>
                                    <th class="py-3 px-4 font-semibold text-sm text-gray-600 dark:text-gray-400">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($borrowings as $borrowing)
                                <tr class="border-b border-gray-100 dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                    <td class="py-3 px-4 font-medium">{{ $borrowing->item->name }}</td>
                                    <td class="py-3 px-4">{{ $borrowing->qty }}</td>
                                    <td class="py-3 px-4 text-yellow-600 dark:text-yellow-400 font-medium">{{ $borrowing->item->coin_cost * $borrowing->qty }} Koin</td>
                                    <td class="py-3 px-4 text-gray-500 dark:text-gray-400">{{ $borrowing->borrowed_at->format('d M Y, H:i') }}</td>
                                    <td class="py-3 px-4">
                                        @if($borrowing->status === 'borrowed')
                                            <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-600 dark:bg-red-900/30 dark:text-red-400">Dipinjam</span>
                                        @else
                                            <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-600 dark:bg-green-900/30 dark:text-green-400">Dikembalikan</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4">
                                        @if($borrowing->status === 'borrowed')
                                            <button @click="showReturnModal = true; borrowId = {{ $borrowing->id }}; itemName = '{{ $borrowing->item->name }}'" 
                                                    class="px-4 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-medium transition duration-150 shadow-sm">
                                                Kembalikan
                                            </button>
                                        @else
                                            <span class="text-gray-400 text-sm">-</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                                @if($borrowings->isEmpty())
                                <tr>
                                    <td colspan="6" class="py-10 text-center text-gray-500 dark:text-gray-400">Belum ada riwayat peminjaman.</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div x-show="showReturnModal" x-transition class="fixed inset-0 z-50 overflow-y-auto bg-black bg-opacity-50 flex items-center justify-center" style="display: none;">
            <div x-show="showReturnModal" x-transition class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-6 mx-4 w-full max-w-md">
                <div class="text-center">
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100 dark:bg-green-900/30 mb-4">
                        <svg class="h-6 w-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-2">Konfirmasi Pengembalian</h3>
                    <p class="text-sm text-gray-200 dark:text-gray-300 mb-6">
                        Apakah Anda yakin ingin mengembalikan alat <span class="font-semibold text-white" x-text="itemName"></span>? Koin akan dikembalikan (maks 10 koin).
                    </p>
                    
                    <div class="flex space-x-3">
                        <button @click="showReturnModal = false" class="flex-1 px-4 py-2.5 bg-gray-600 hover:bg-gray-500 text-white rounded-lg font-medium transition duration-150">
                            Batal
                        </button>
                        <form :action="'/kembalikan/' + borrowId" method="POST" class="flex-1">
                            @csrf
                            <button type="submit" class="w-full px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium shadow-md transition duration-150">
                                Ya, Kembalikan
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>