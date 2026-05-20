<x-app-layout>
    <div x-data="{ showResetModal: false }" class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <a href="{{ route('admin.students.index') }}" class="inline-flex items-center text-sm text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 mb-6">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Kembali ke Daftar Mahasiswa
            </a>

            @if(session('success'))
                <div class="mb-6 p-4 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 rounded-xl shadow-sm font-medium">✓ {{ session('success') }}</div>
            @endif

            <div class="bg-white dark:bg-gray-800 shadow-md sm:rounded-2xl p-6 mb-8">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                    <div>
                        <h2 class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $student->name }}</h2>
                        <div class="mt-2 flex flex-wrap items-center gap-x-4 gap-y-1 text-gray-600 dark:text-gray-400 text-sm">
                            <span>NIM: {{ $student->nim }}</span>
                            <span>Prodi: {{ $student->prodi }}</span>
                            <span>Angkatan: {{ $student->angkatan }}</span>
                            <span>Email: {{ $student->email }}</span>
                        </div>
                        
                        <!-- TAMPILAN ALASAN SUSPEND -->
                        @if($student->is_suspended && $student->suspend_reason)
                            <div class="mt-4 p-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
                                <h4 class="text-sm font-bold text-red-700 dark:text-red-400 mb-1">Alasan Suspend:</h4>
                                <p class="text-sm text-red-600 dark:text-red-300">{{ $student->suspend_reason }}</p>
                            </div>
                        @endif
                    </div>
                    
                    <div class="flex flex-col items-center md:items-end gap-3">
                        <div class="flex items-center space-x-2 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 px-5 py-2.5 rounded-xl shadow-sm">
                            <span class="text-sm font-semibold text-yellow-600 dark:text-yellow-400">Sisa Koin:</span>
                            <span class="text-2xl font-bold text-yellow-700 dark:text-yellow-300">{{ $student->coins }}</span>
                        </div>
                        
                        <div class="flex gap-2 w-full">
                            @if($student->is_suspended)
                                <span class="flex-1 text-center px-4 py-1.5 text-sm font-semibold rounded-full bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-400 border border-red-200">
                                    Disuspend
                                </span>
                            @else
                                <span class="flex-1 text-center px-4 py-1.5 text-sm font-semibold rounded-full bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-400 border border-green-200">
                                    Aktif
                                </span>
                            @endif

                            <button @click="showResetModal = true" class="px-4 py-1.5 bg-orange-600 hover:bg-orange-700 text-white rounded-full text-sm font-semibold shadow-sm transition">
                                Reset Password
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow-md sm:rounded-2xl overflow-hidden">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100">Riwayat Peminjaman Alat</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
                                <th class="py-3 px-4 font-semibold text-sm text-gray-600 dark:text-gray-400">Nama Alat</th>
                                <th class="py-3 px-4 font-semibold text-sm text-gray-600 dark:text-gray-400">Qty</th>
                                <th class="py-3 px-4 font-semibold text-sm text-gray-600 dark:text-gray-400">Biaya Koin</th>
                                <th class="py-3 px-4 font-semibold text-sm text-gray-600 dark:text-gray-400">Tanggal Pinjam</th>
                                <th class="py-3 px-4 font-semibold text-sm text-gray-600 dark:text-gray-400">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($borrowings as $borrowing)
                            <tr class="border-b border-gray-100 dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                <td class="py-3 px-4 font-medium text-gray-900 dark:text-gray-100">{{ $borrowing->item->name }}</td>
                                <td class="py-3 px-4">{{ $borrowing->qty }}</td>
                                <td class="py-3 px-4 text-yellow-600 dark:text-yellow-400 font-medium">{{ $borrowing->item->coin_cost * $borrowing->qty }} Koin</td>
                                <td class="py-3 px-4 text-gray-500 dark:text-gray-400 text-sm">{{ $borrowing->borrowed_at->format('d M Y, H:i') }}</td>
                                <td class="py-3 px-4">
                                    @if($borrowing->status === 'borrowed')
                                        <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-600 dark:bg-red-900/30 dark:text-red-400">Dipinjam</span>
                                    @else
                                        <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-600 dark:bg-green-900/30 dark:text-green-400">Dikembalikan</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                            @if($borrowings->isEmpty())
                            <tr>
                                <td colspan="5" class="py-10 text-center text-gray-500 dark:text-gray-400">Mahasiswa ini belum memiliki riwayat peminjaman.</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal Reset Password (Sama seperti sebelumnya) -->
        <div x-show="showResetModal" x-transition class="fixed inset-0 z-50 overflow-y-auto bg-black bg-opacity-50 flex items-center justify-center" style="display: none;">
            <div x-show="showResetModal" x-transition class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-6 mx-4 w-full max-w-md">
                <div class="text-center mb-4">
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-orange-100 dark:bg-orange-900/30 mb-4">
                        <svg class="h-6 w-6 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-1">Reset Password Mahasiswa</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Atur password baru untuk <span class="font-semibold">{{ $student->name }}</span></p>
                </div>
                <form action="{{ route('admin.students.reset-password', $student->id) }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Password Baru</label>
                            <input type="password" name="new_password" required class="block w-full px-4 py-2.5 rounded-lg border dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Konfirmasi Password</label>
                            <input type="password" name="new_password_confirmation" required class="block w-full px-4 py-2.5 rounded-lg border dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm">
                        </div>
                    </div>
                    <div class="flex space-x-3 mt-6">
                        <button type="button" @click="showResetModal = false" class="flex-1 px-4 py-2.5 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-lg font-medium hover:bg-gray-300 dark:hover:bg-gray-600 transition duration-150">Batal</button>
                        <button type="submit" class="flex-1 px-4 py-2.5 bg-orange-600 hover:bg-orange-700 text-white rounded-lg font-medium shadow-md transition duration-150">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>