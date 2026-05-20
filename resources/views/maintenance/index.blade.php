<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 rounded-xl shadow-sm font-medium">✓ {{ session('success') }}</div>
            @endif

            <h2 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-8">Tracking Maintenance Alat</h2>

            <div class="bg-white dark:bg-gray-800 shadow-md sm:rounded-2xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
                                <th class="py-3 px-4 font-semibold text-sm text-gray-600 dark:text-gray-400">Nama Alat</th>
                                <th class="py-3 px-4 font-semibold text-sm text-gray-600 dark:text-gray-400">Jumlah</th>
                                <th class="py-3 px-4 font-semibold text-sm text-gray-600 dark:text-gray-400">Alasan</th>
                                <th class="py-3 px-4 font-semibold text-sm text-gray-600 dark:text-gray-400">Lokasi</th>
                                <th class="py-3 px-4 font-semibold text-sm text-gray-600 dark:text-gray-400">Tgl Mulai</th>
                                <th class="py-3 px-4 font-semibold text-sm text-gray-600 dark:text-gray-400">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ongoingMaintenances as $log)
                            <tr class="border-b border-gray-100 dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                <td class="py-3 px-4 font-medium text-white">{{ $log->item->name }}</td>
                                <td class="py-3 px-4 text-white">{{ $log->qty }} Unit</td>
                                <td class="py-3 px-4 text-gray-300">{{ $log->reason }}</td>
                                <td class="py-3 px-4 text-gray-300">{{ $log->location }}</td>
                                <td class="py-3 px-4 text-gray-300 text-sm">{{ $log->created_at->format('d M Y, H:i') }}</td>
                                <td class="py-3 px-4">
                                    <form action="{{ route('maintenance.finish', $log->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="px-4 py-1.5 bg-green-600 hover:bg-green-700 text-white rounded-lg text-xs font-medium transition shadow-sm">
                                            Selesai Maintenance
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                            @if($ongoingMaintenances->isEmpty())
                            <tr>
                                <td colspan="6" class="py-10 text-center text-gray-500 dark:text-gray-400">Tidak ada alat yang sedang maintenance.</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>