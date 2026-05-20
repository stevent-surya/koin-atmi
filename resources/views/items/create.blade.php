<x-app-layout>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md sm:rounded-2xl">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h2 class="text-2xl font-bold mb-6">Tambah Alat Baru</h2>

                    @if($errors->any())
                        <div class="mb-4 p-4 bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300 rounded-xl shadow-sm font-medium">
                            <ul class="list-disc list-inside">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('items.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Alat</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" 
                                   class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 shadow-sm" 
                                   placeholder="Contoh: Bor Listrik" required>
                        </div>

                        <div class="mb-4">
                            <label for="code" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kode Alat</label>
                            <input type="text" name="code" id="code" value="{{ old('code') }}" 
                                   class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 shadow-sm" 
                                   placeholder="Contoh: BR-001" required>
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <div>
                                <label for="stock" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Stok</label>
                                <input type="number" name="stock" id="stock" value="{{ old('stock', 0) }}" min="0"
                                       class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 shadow-sm" 
                                       required>
                            </div>
                            <div>
                                <label for="coin_cost" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Biaya Koin (Per Unit)</label>
                                <input type="number" name="coin_cost" id="coin_cost" value="{{ old('coin_cost', 1) }}" min="1"
                                       class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 shadow-sm" 
                                       required>
                            </div>
                        </div>

                        <div class="flex items-center justify-end space-x-3">
                            <a href="{{ route('items.index') }}" class="px-5 py-2.5 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-lg font-medium hover:bg-gray-300 dark:hover:bg-gray-600 transition duration-150">
                                Batal
                            </a>
                            <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-semibold shadow-md transition duration-150">
                                Simpan Alat
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>