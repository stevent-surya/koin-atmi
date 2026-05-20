<x-app-layout>
    <!-- Modal Suspend Alpine.js -->
    <div x-data="{ showSuspendModal: false, suspendStudentId: null, suspendStudentName: '' }" class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white dark:bg-gray-800 shadow-md sm:rounded-2xl p-6 mb-6">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-4">Filter Mahasiswa</h2>
                <form method="GET" action="{{ route('admin.students.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Cari Nama/NIM</label>
                        <input type="text" name="search" value="{{ request('search') }}" class="w-full px-4 py-2 rounded-lg border dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm" placeholder="Masukkan kata kunci...">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Angkatan</label>
                        <select name="angkatan" class="w-full px-4 py-2 rounded-lg border dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm">
                            <option value="">Semua Angkatan</option>
                            @foreach($angkatanList as $a)
                                <option value="{{ $a }}" {{ request('angkatan') == $a ? 'selected' : '' }}>{{ $a }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Program Studi</label>
                        <select name="prodi" class="w-full px-4 py-2 rounded-lg border dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm">
                            <option value="">Semua Prodi</option>
                            @foreach($prodiList as $code => $name)
                                <option value="{{ $name }}" {{ request('prodi') == $name ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="w-full px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium shadow-sm transition">Filter</button>
                    </div>
                </form>
            </div>

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 rounded-xl shadow-sm font-medium">✓ {{ session('success') }}</div>
            @endif

            <div class="bg-white dark:bg-gray-800 shadow-md sm:rounded-2xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
                                <th class="py-3 px-4 font-semibold text-sm text-gray-600 dark:text-gray-400">NIM</th>
                                <th class="py-3 px-4 font-semibold text-sm text-gray-600 dark:text-gray-400">Nama</th>
                                <th class="py-3 px-4 font-semibold text-sm text-gray-600 dark:text-gray-400">Prodi</th>
                                <th class="py-3 px-4 font-semibold text-sm text-gray-600 dark:text-gray-400">Angkatan</th>
                                <th class="py-3 px-4 font-semibold text-sm text-gray-600 dark:text-gray-400">Koin</th>
                                <th class="py-3 px-4 font-semibold text-sm text-gray-600 dark:text-gray-400">Status</th>
                                <th class="py-3 px-4 font-semibold text-sm text-gray-600 dark:text-gray-400">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($students as $student)
                            <tr class="border-b border-gray-100 dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                <td class="py-3 px-4 font-mono font-medium text-white">{{ $student->nim }}</td>
                                <td class="py-3 px-4 font-medium {{ $student->is_suspended ? 'text-red-400' : 'text-white' }}">{{ $student->name }}</td>
                                <td class="py-3 px-4 text-sm text-gray-300">{{ $student->prodi }}</td>
                                <td class="py-3 px-4 text-sm text-gray-300">{{ $student->angkatan }}</td>
                                <td class="py-3 px-4 font-medium {{ $student->coins == 0 ? 'text-yellow-400' : 'text-white' }}">{{ $student->coins }} Koin</td>
                                <td class="py-3 px-4">
                                    @if($student->is_suspended)
                                        <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-600 dark:bg-red-900/30 dark:text-red-400">Suspended</span>
                                    @else
                                        <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-600 dark:bg-green-900/30 dark:text-green-400">Aktif</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 space-x-2">
                                    <a href="{{ route('admin.students.show', $student->id) }}" class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs font-medium transition shadow-sm">Detail</a>
                                    
                                    @if($student->is_suspended)
                                        <form action="{{ route('admin.students.suspend', $student->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="px-3 py-1.5 bg-green-600 hover:bg-green-700 text-white rounded-lg text-xs font-medium transition shadow-sm">Unsuspend</button>
                                        </form>
                                    @else
                                        <!-- Tombol Pemicu Modal Suspend -->
                                        <button @click="showSuspendModal = true; suspendStudentId = {{ $student->id }}; suspendStudentName = '{{ $student->name }}'" 
                                                class="px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white rounded-lg text-xs font-medium transition shadow-sm">
                                            Suspend
                                        </button>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="p-4 border-t border-gray-200 dark:border-gray-700">
                    {{ $students->appends(request()->query())->links() }}
                </div>
            </div>
        </div>

        <!-- UI Modal Suspend dengan Alasan -->
        <div x-show="showSuspendModal" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-50 overflow-y-auto bg-black bg-opacity-50 flex items-center justify-center" 
             style="display: none;">
            
            <div x-show="showSuspendModal" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-6 mx-4 w-full max-w-md">
                
                <div class="text-center mb-4">
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 dark:bg-red-900/30 mb-4">
                        <svg class="h-6 w-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">Suspend Akun Mahasiswa</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
 Anda yakin ingin men-suspend <span class="font-semibold text-red-500" x-text="suspendStudentName"></span>?
                    </p>
                </div>

                <form :action="'/admin/mahasiswa/' + suspendStudentId + '/suspend'" method="POST">
                    @csrf
                    <div>
                        <label for="suspend_reason" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Alasan Suspend <span class="text-red-500">*</span></label>
                        <textarea id="suspend_reason" name="suspend_reason" rows="3" required
                                  class="block w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:ring-red-500 focus:border-red-500 shadow-sm" placeholder="Tulis alasan pelanggaran mahasiswa..."></textarea>
                    </div>

                    <div class="flex space-x-3 mt-6">
                        <button type="button" @click="showSuspendModal = false" class="flex-1 px-4 py-2.5 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-lg font-medium hover:bg-gray-300 dark:hover:bg-gray-600 transition duration-150">
                            Batal
                        </button>
                        <button type="submit" class="flex-1 px-4 py-2.5 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium shadow-md transition duration-150">
                            Ya, Suspend
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>