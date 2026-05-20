<x-app-layout>
    <!-- Inisialisasi tab dari URL agar saat pagination/search, tab tidak reset -->
    <div x-data="{ activeTab: '{{ $activeTab }}' }" class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <h2 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-6">Log Aktivitas</h2>

            <!-- TAB BUTTONS (TANPA RELOAD HALAMAN) -->
            <div class="flex space-x-2 mb-8 overflow-x-auto">
                <button @click="activeTab = 'borrow'" :class="activeTab === 'borrow' ? 'bg-indigo-600 text-white shadow-md' : 'bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200'" class="px-5 py-2.5 rounded-lg font-semibold transition duration-150 whitespace-nowrap">
                    Log Peminjaman Alat
                </button>
                <button @click="activeTab = 'maintenance'" :class="activeTab === 'maintenance' ? 'bg-indigo-600 text-white shadow-md' : 'bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200'" class="px-5 py-2.5 rounded-lg font-semibold transition duration-150 whitespace-nowrap">
                    Log Maintenance
                </button>
                <button @click="activeTab = 'suspend'" :class="activeTab === 'suspend' ? 'bg-indigo-600 text-white shadow-md' : 'bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200'" class="px-5 py-2.5 rounded-lg font-semibold transition duration-150 whitespace-nowrap">
                    Log Suspend Akun
                </button>
            </div>

            <!-- TAB 1: LOG PEMINJAMAN ALAT -->
            <!-- Hapus x-transition agar perpindahan lebih stabil tanpa animasi yang bikin kedip -->
            <div x-show="activeTab === 'borrow'">
                <form action="{{ route('logs.index') }}" method="GET" class="mb-4 flex gap-2">
                    <input type="hidden" name="tab" value="borrow">
                    <input type="text" name="borrow_search" value="{{ request('borrow_search') }}" placeholder="Cari NIM, Nama Mahasiswa, atau Nama Alat..." class="flex-1 px-4 py-2.5 rounded-lg border dark:border-gray-600 dark:bg-gray-700 text-white shadow-sm">
                    <button type="submit" class="px-4 py-2.5 bg-indigo-600 text-white rounded-lg font-medium shadow-sm">Cari</button>
                </form>
                <div class="bg-white dark:bg-gray-800 shadow-md sm:rounded-2xl overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
                                    <th class="py-3 px-4 font-semibold text-sm text-gray-600 dark:text-gray-400">Nama Alat</th>
                                    <th class="py-3 px-4 font-semibold text-sm text-gray-600 dark:text-gray-400">Peminjam</th>
                                    <th class="py-3 px-4 font-semibold text-sm text-gray-600 dark:text-gray-400">Qty</th>
                                    <th class="py-3 px-4 font-semibold text-sm text-gray-600 dark:text-gray-400">Tgl Pinjam</th>
                                    <th class="py-3 px-4 font-semibold text-sm text-gray-600 dark:text-gray-400">Tgl Kembali</th>
                                    <th class="py-3 px-4 font-semibold text-sm text-gray-600 dark:text-gray-400">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($borrowingLogs as $log)
                                <tr class="border-b border-gray-100 dark:border-gray-800">
                                    <td class="py-3 px-4 font-medium text-white">{{ $log->item->name }}</td>
                                    <td class="py-3 px-4 text-gray-300">{{ $log->user->name }} ({{ $log->user->nim }})</td>
                                    <td class="py-3 px-4 text-gray-300">{{ $log->qty }}</td>
                                    <td class="py-3 px-4 text-gray-300 text-sm">{{ $log->borrowed_at->format('d M Y, H:i') }}</td>
                                    <td class="py-3 px-4 text-gray-300 text-sm">{{ $log->returned_at ? $log->returned_at->format('d M Y, H:i') : '-' }}</td>
                                    <td class="py-3 px-4">
                                        @if($log->status === 'borrowed')
                                            <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-600 dark:bg-red-900/30 dark:text-red-400">Dipinjam</span>
                                        @else
                                            <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-600 dark:bg-green-900/30 dark:text-green-400">Dikembalikan</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                                @if($borrowingLogs->isEmpty())
                                <tr>
                                    <td colspan="6" class="py-10 text-center text-gray-500 dark:text-gray-400">Tidak ditemukan.</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="p-4 border-t border-gray-200 dark:border-gray-700">{{ $borrowingLogs->appends(request()->query())->links() }}</div>
                </div>
            </div>

            <!-- TAB 2: LOG MAINTENANCE -->
            <div x-show="activeTab === 'maintenance'">
                <form action="{{ route('logs.index') }}" method="GET" class="mb-4 flex gap-2">
                    <input type="hidden" name="tab" value="maintenance">
                    <input type="text" name="maint_search" value="{{ request('maint_search') }}" placeholder="Cari Nama Alat..." class="flex-1 px-4 py-2.5 rounded-lg border dark:border-gray-600 dark:bg-gray-700 text-white shadow-sm">
                    <button type="submit" class="px-4 py-2.5 bg-indigo-600 text-white rounded-lg font-medium shadow-sm">Cari</button>
                </form>
                <div class="bg-white dark:bg-gray-800 shadow-md sm:rounded-2xl overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
                                    <th class="py-3 px-4 font-semibold text-sm text-gray-600 dark:text-gray-400">Nama Alat</th>
                                    <th class="py-3 px-4 font-semibold text-sm text-gray-600 dark:text-gray-400">Qty</th>
                                    <th class="py-3 px-4 font-semibold text-sm text-gray-600 dark:text-gray-400">Alasan</th>
                                    <th class="py-3 px-4 font-semibold text-sm text-gray-600 dark:text-gray-400">Lokasi</th>
                                    <th class="py-3 px-4 font-semibold text-sm text-gray-600 dark:text-gray-400">Tgl Mulai</th>
                                    <th class="py-3 px-4 font-semibold text-sm text-gray-600 dark:text-gray-400">Tgl Selesai</th>
                                    <th class="py-3 px-4 font-semibold text-sm text-gray-600 dark:text-gray-400">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($maintenanceLogs as $log)
                                <tr class="border-b border-gray-100 dark:border-gray-800">
                                    <td class="py-3 px-4 font-medium text-white">{{ $log->item->name }}</td>
                                    <td class="py-3 px-4 text-gray-300">{{ $log->qty }}</td>
                                    <td class="py-3 px-4 text-gray-300">{{ $log->reason }}</td>
                                    <td class="py-3 px-4 text-gray-300">{{ $log->location }}</td>
                                    <td class="py-3 px-4 text-gray-300 text-sm">{{ $log->created_at->format('d M Y, H:i') }}</td>
                                    <td class="py-3 px-4 text-gray-300 text-sm">{{ $log->status === 'completed' ? $log->updated_at->format('d M Y, H:i') : '-' }}</td>
                                    <td class="py-3 px-4">
                                        @if($log->status === 'ongoing')
                                            <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-orange-100 text-orange-600 dark:bg-orange-900/30 dark:text-orange-400">Ongoing</span>
                                        @else
                                            <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-600 dark:bg-green-900/30 dark:text-green-400">Selesai</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                                @if($maintenanceLogs->isEmpty())
                                <tr>
                                    <td colspan="7" class="py-10 text-center text-gray-500 dark:text-gray-400">Tidak ditemukan.</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="p-4 border-t border-gray-200 dark:border-gray-700">{{ $maintenanceLogs->appends(request()->query())->links() }}</div>
                </div>
            </div>

            <!-- TAB 3: LOG SUSPEND AKUN -->
            <div x-show="activeTab === 'suspend'">
                <form action="{{ route('logs.index') }}" method="GET" class="mb-4 flex gap-2">
                    <input type="hidden" name="tab" value="suspend">
                    <input type="text" name="suspend_search" value="{{ request('suspend_search') }}" placeholder="Cari NIM atau Nama Mahasiswa..." class="flex-1 px-4 py-2.5 rounded-lg border dark:border-gray-600 dark:bg-gray-700 text-white shadow-sm">
                    <button type="submit" class="px-4 py-2.5 bg-indigo-600 text-white rounded-lg font-medium shadow-sm">Cari</button>
                </form>
                <div class="bg-white dark:bg-gray-800 shadow-md sm:rounded-2xl overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
                                    <th class="py-3 px-4 font-semibold text-sm text-gray-600 dark:text-gray-400">Mahasiswa</th>
                                    <th class="py-3 px-4 font-semibold text-sm text-gray-600 dark:text-gray-400">NIM</th>
                                    <th class="py-3 px-4 font-semibold text-sm text-gray-600 dark:text-gray-400">Aksi</th>
                                    <th class="py-3 px-4 font-semibold text-sm text-gray-600 dark:text-gray-400">Alasan</th>
                                    <th class="py-3 px-4 font-semibold text-sm text-gray-600 dark:text-gray-400">Oleh Admin</th>
                                    <th class="py-3 px-4 font-semibold text-sm text-gray-600 dark:text-gray-400">Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($suspendLogs as $log)
                                <tr class="border-b border-gray-100 dark:border-gray-800">
                                    <td class="py-3 px-4 font-medium text-white">{{ $log->user->name }}</td>
                                    <td class="py-3 px-4 text-gray-300">{{ $log->user->nim }}</td>
                                    <td class="py-3 px-4">
                                        @if($log->action === 'suspended')
                                            <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-600 dark:bg-red-900/30 dark:text-red-400">Suspended</span>
                                        @else
                                            <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-600 dark:bg-green-900/30 dark:text-green-400">Unsuspended</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4 text-gray-300">{{ $log->reason ?? '-' }}</td>
                                    <td class="py-3 px-4 text-gray-300">{{ $log->admin->name }}</td>
                                    <td class="py-3 px-4 text-gray-300 text-sm">{{ $log->created_at->format('d M Y, H:i') }}</td>
                                </tr>
                                @endforeach
                                @if($suspendLogs->isEmpty())
                                <tr>
                                    <td colspan="6" class="py-10 text-center text-gray-500 dark:text-gray-400">Tidak ditemukan.</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="p-4 border-t border-gray-200 dark:border-gray-700">{{ $suspendLogs->appends(request()->query())->links() }}</div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>