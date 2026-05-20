<nav x-data="{ open: false }" class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-md border-b border-gray-200 dark:border-gray-700 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="font-bold text-xl text-indigo-600 dark:text-indigo-400 flex items-center gap-2">
                        <img src="{{ asset('images/atmi-logo.png') }}" alt="Logo" class="w-8 h-8">
                        ATMI Koin
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    @auth
                        @if(!auth()->user()->isAdmin())
                            <a href="{{ route('dashboard') }}" class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium {{ request()->routeIs('dashboard') ? 'border-indigo-400 text-gray-900 dark:text-gray-100' : 'border-transparent text-gray-500 dark:text-gray-400' }}">Dashboard</a>
                        @endif
                    @endauth
                    <a href="{{ route('items.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium {{ request()->routeIs('items.index') ? 'border-indigo-400 text-gray-900 dark:text-gray-100' : 'border-transparent text-gray-500 dark:text-gray-400' }}">Katalog Alat</a>
                    @auth
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.students.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium {{ request()->routeIs('admin.students.*') ? 'border-indigo-400 text-gray-900 dark:text-gray-100' : 'border-transparent text-gray-500 dark:text-gray-400' }}">Kelola Mahasiswa</a>
                        @endif
                    @endauth
                </div>
            </div>

            <div class="flex items-center gap-4">
                @auth
                    @if(!auth()->user()->isAdmin())
                        <div class="hidden sm:flex items-center space-x-1 bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-300 px-3 py-1.5 rounded-full font-medium text-sm">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.736 6.979C9.208 6.193 9.696 6 10 6c.304 0 .792.193 1.264.979a1 1 0 001.715-1.029C12.279 4.784 11.232 4 10 4s-2.279.784-2.979 1.95c-.285.475-.507 1-.67 1.55H6a1 1 0 000 2h.013a9.358 9.358 0 000 1H6a1 1 0 100 2h.351c.163.55.385 1.075.67 1.55C7.721 15.216 8.768 16 10 16s2.279-.784 2.979-1.95a1 1 0 10-1.715-1.029C10.792 13.807 10.304 14 10 14c-.304 0-.792-.193-1.264-.979a5.393 5.393 0 01-.402-.821H10a1 1 0 100-2H8.028a7.414 7.414 0 010-1H10a1 1 0 100-2H8.334c.12-.293.256-.571.402-.821z"/></svg>
                            <span>Sisa Koin: {{ auth()->user()->coins }}</span>
                        </div>
                    @endif
                @endauth

                <div class="relative">
                    <button @click="open = !open" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 transition">
                        <div>{{ auth()->check() ? auth()->user()->name : '' }}</div>
                        <svg class="ms-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 z-50 mt-2 w-48 rounded-md shadow-lg py-1 bg-white dark:bg-gray-800 ring-1 ring-black ring-opacity-5" style="display: none;">
                        <a href="{{ route('settings.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">Pengaturan</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100 dark:hover:bg-gray-700">Log Out</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>