<x-app-layout>
    <div x-data="{ 
            showBorrowModal: false, itemId: null, itemName: '', itemStock: 0, qty: 1, errorCoin: '',
            showAddModal: false,
            showEditModal: false, editId: null, editName: '', editCode: '', editStock: 0
         }" class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-6 p-4 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 rounded-xl shadow-sm font-medium">✓ {{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="mb-6 p-4 bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300 rounded-xl shadow-sm font-medium">✕ {{ session('error') }}</div>
            @endif

            <div class="flex justify-between items-center mb-8">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-gray-100">Katalog Alat</h2>
                @auth
                    @if(auth()->user()->isAdmin())
                        <button @click="showAddModal = true" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-semibold transition duration-150 shadow-md flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                            <span>Tambah Alat Baru</span>
                        </button>
                    @endif
                @endauth
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($items as $item)
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md hover:shadow-lg transition duration-200 overflow-hidden border border-gray-100 dark:border-gray-700">
                        <div class="p-5">
                            <div class="flex justify-between items-start mb-3">
                                <h3 class="font-bold text-lg text-gray-900 dark:text-gray-100">{{ $item->name }}</h3>
                                <span class="bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 text-xs font-semibold px-2.5 py-0.5 rounded-full">
                                    {{ $item->code }}
                                </span>
                            </div>
                            
                            <div class="space-y-2 text-sm text-gray-600 dark:text-gray-400 mb-5">
                                <div class="flex justify-between">
                                    <span>Stok Tersedia:</span>
                                    <span class="font-semibold {{ $item->stock > 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">{{ $item->stock }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span>Biaya Koin:</span>
                                    <span class="font-semibold text-yellow-600 dark:text-yellow-400 flex items-center">
                                        1 Koin / Unit
                                    </span>
                                </div>
                            </div>

                            @if($item->is_maintenance)
                                <div class="w-full text-center px-4 py-2.5 bg-orange-100 dark:bg-orange-900/30 text-orange-600 dark:text-orange-400 rounded-lg font-semibold text-sm border border-orange-200 dark:border-orange-800">
                                    ⚠ Dalam Maintenance
                                </div>
                            @else
                                @auth
                                    @if(auth()->user()->isAdmin())
                                        <div class="flex gap-2">
                                            <button @click="showEditModal = true; editId = {{ $item->id }}; editName = '{{ $item->name }}'; editCode = '{{ $item->code }}'; editStock = {{ $item->stock }}" 
                                                    class="flex-1 px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition shadow-sm text-center">
                                                Edit
                                            </button>
                                            <form action="{{ route('items.maintenance', $item->id) }}" method="POST" class="flex-1">
                                                @csrf
                                                <button type="submit" class="w-full px-3 py-2 bg-orange-600 hover:bg-orange-700 text-white rounded-lg text-sm font-medium transition shadow-sm">
                                                    Maintenance
                                                </button>
                                            </form>
                                        </div>
                                    @else
                                        @if($item->stock > 0)
                                            <button @click="showBorrowModal = true; itemId = {{ $item->id }}; itemName = '{{ $item->name }}'; itemStock = {{ $item->stock }}; qty = 1; errorCoin = ''" 
                                                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2.5 rounded-lg font-semibold transition duration-150 text-center block shadow-md">
                                                Pinjam Alat
                                            </button>
                                        @else
                                            <button disabled class="w-full bg-gray-300 dark:bg-gray-700 text-gray-500 dark:text-gray-400 px-4 py-2.5 rounded-lg font-medium cursor-not-allowed">
                                                Stok Habis
                                            </button>
                                        @endif
                                    @endif
                                @endauth
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- 1. MODAL PINJAM (MAHASISWA) -->
        <div x-show="showBorrowModal" x-transition class="fixed inset-0 z-50 overflow-y-auto bg-black bg-opacity-50 flex items-center justify-center" style="display: none;">
            <div x-show="showBorrowModal" x-transition class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-6 mx-4 w-full max-w-md">
                <div class="text-center mb-4">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-1">Konfirmasi Peminjaman</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Anda akan meminjam alat: <span class="font-semibold text-gray-700 dark:text-gray-200" x-text="itemName"></span></p>
                </div>
                <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-xl mb-4 space-y-3">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500 dark:text-gray-400">Koin Anda saat ini:</span>
                        <span class="font-bold text-yellow-600 dark:text-yellow-400">{{ auth()->user()->coins }} Koin</span>
                    </div>
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-500 dark:text-gray-400">Jumlah Pinjam (Qty):</span>
                        <input type="number" x-model.number="qty" min="1" :max="itemStock" class="w-16 text-center bg-white dark:bg-gray-800 border dark:border-gray-600 rounded-lg py-1 text-gray-900 dark:text-gray-100 shadow-sm">
                    </div>
                    <div class="flex justify-between text-sm font-semibold border-t border-gray-200 dark:border-gray-600 pt-3">
                        <span class="text-gray-700 dark:text-gray-300">Total Koin Dibutuhkan:</span>
                        <span class="text-red-600 dark:text-red-400" x-text="qty * 1 + ' Koin'"></span>
                    </div>
                </div>
                <div x-show="errorCoin" x-text="errorCoin" class="mb-4 p-3 bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300 rounded-lg text-sm font-medium"></div>
                <div class="flex space-x-3">
                    <button @click="showBorrowModal = false" class="flex-1 px-4 py-2.5 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-lg font-medium hover:bg-gray-300 dark:hover:bg-gray-600 transition duration-150">Batal</button>
                    <form action="{{ route('borrowings.store') }}" method="POST" class="flex-1">
                        @csrf <input type="hidden" name="item_id" :value="itemId"> <input type="hidden" name="qty" :value="qty">
                        <button type="submit" @click="if({{ auth()->user()->coins }} < (qty * 1)) { errorCoin = 'Koin Anda tidak cukup!'; $event.preventDefault(); }" class="w-full px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium shadow-md transition duration-150">Ya, Pinjam</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- 2. MODAL TAMBAH ALAT (ADMIN) -->
        <div x-show="showAddModal" x-transition class="fixed inset-0 z-50 overflow-y-auto bg-black bg-opacity-50 flex items-center justify-center" style="display: none;">
            <div x-show="showAddModal" x-transition class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-6 mx-4 w-full max-w-md">
                <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4">Tambah Alat Baru</h3>
                <form action="{{ route('items.store') }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Alat</label>
                            <input type="text" name="name" required class="w-full px-4 py-2.5 rounded-lg border dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm" placeholder="Contoh: Bor Listrik">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kode Alat</label>
                            <input type="text" name="code" required class="w-full px-4 py-2.5 rounded-lg border dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm" placeholder="Contoh: BR-001">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Stok</label>
                            <input type="number" name="stock" required min="0" class="w-full px-4 py-2.5 rounded-lg border dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm" value="0">
                        </div>
                    </div>
                    <div class="flex space-x-3 mt-6">
                        <button type="button" @click="showAddModal = false" class="flex-1 px-4 py-2.5 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-lg font-medium hover:bg-gray-300 dark:hover:bg-gray-600 transition duration-150">Batal</button>
                        <button type="submit" class="flex-1 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium shadow-md transition duration-150">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- 3. MODAL EDIT ALAT (ADMIN) -->
        <div x-show="showEditModal" x-transition class="fixed inset-0 z-50 overflow-y-auto bg-black bg-opacity-50 flex items-center justify-center" style="display: none;">
            <div x-show="showEditModal" x-transition class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-6 mx-4 w-full max-w-md">
                <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4">Edit Alat</h3>
                <form :action="'/alat/' + editId" method="POST">
                    @csrf @method('PUT')
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Alat</label>
                            <input type="text" name="name" x-model="editName" required class="w-full px-4 py-2.5 rounded-lg border dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kode Alat</label>
                            <input type="text" name="code" x-model="editCode" required class="w-full px-4 py-2.5 rounded-lg border dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Stok</label>
                            <input type="number" name="stock" x-model="editStock" required min="0" class="w-full px-4 py-2.5 rounded-lg border dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm">
                        </div>
                    </div>
                    <div class="flex space-x-3 mt-6">
                        <button type="button" @click="showEditModal = false" class="flex-1 px-4 py-2.5 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-lg font-medium hover:bg-gray-300 dark:hover:bg-gray-600 transition duration-150">Batal</button>
                        <button type="submit" class="flex-1 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium shadow-md transition duration-150">Update</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-app-layout>