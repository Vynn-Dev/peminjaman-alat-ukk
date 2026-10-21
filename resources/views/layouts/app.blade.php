<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Peminjaman Alat') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-100">
        <div x-data="{ sidebarOpen: false }" class="min-h-screen">

            <!-- Mobile sidebar backdrop -->
            <div x-cloak x-show="sidebarOpen" x-transition.opacity
                 class="fixed inset-0 z-30 bg-gray-900/50 lg:hidden"
                 @click="sidebarOpen = false">
            </div>

            <!-- Sidebar -->
            <aside class="fixed inset-y-0 left-0 z-40 flex w-64 flex-col bg-gray-900 transition-transform
                          lg:translate-x-0"
                   :class="{ '-translate-x-full': ! sidebarOpen, 'translate-x-0': sidebarOpen }">
                <div class="flex h-16 items-center gap-3 border-b border-white/10 px-5 shrink-0">
                    <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-indigo-600 shrink-0">
                        <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9.5 21.25a.75.75 0 01-.75.75H7.5a.75.75 0 01-.75-.75l-.05-5.148a48.16 48.16 0 011.655-.493M15.188 15.29l-.023 5.96a.75.75 0 01-.75.75h-1.125a.75.75 0 01-.75-.75l-.044-4.877m4.725-1.083a48.25 48.25 0 016.055-.871" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 10.375a9 9 0 019 0" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 7.25a14.25 14.25 0 0113.5 0" />
                        </svg>
                    </div>

                    <div class="min-w-0">
                        <p class="text-sm font-bold text-white truncate">Peminjaman Alat UKK</p>
                        <p class="text-[11px] text-gray-400 truncate">{{ Auth::user()->roleName() }}</p>
                    </div>
                </div>

                <!-- Menu -->
                <nav class="flex-1 space-y-1 px-3 py-4 overflow-y-auto">
                    <x-sidebar-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                        </svg>
                        Dashboard
                    </x-sidebar-link>

                    @if (Auth::user()->role == 'admin')
                        <x-sidebar-link :href="route('kategori.index')" :active="request()->routeIs('kategori.*')">
                            <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" />
                            </svg>
                            Kategori
                        </x-sidebar-link>

                        <x-sidebar-link :href="route('alat.index')" :active="request()->routeIs('alat.*')">
                            <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.073c0 1.06-.854 1.92-1.906 1.92H5.656c-1.052 0-1.906-.86-1.906-1.92v-4.073m17.5-1.185L21.75 10.5l1.5-1.5m-19.5 2.25L2.25 12l1.5 1.5M6 9.75V3.75h12v6M6 9.75l-1.5 1.5m15-1.5l1.5 1.5m-15 0h.008v.008H6v-.008zm.375 0h.008v.008h-.008V9.75zm13.5 0h.008v.008h-.008V9.75zm.375 0h.008v.008h-.008V9.75z" />
                            </svg>
                            Data Alat
                        </x-sidebar-link>
                    @endif

                    @if (Auth::user()->role == 'admin')
                        <x-sidebar-link :href="route('logaktivitas.index')" :active="request()->routeIs('logaktivitas.*')">
                            <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Log Aktivitas
                        </x-sidebar-link>
                    @endif

                    <x-sidebar-link :href="route('peminjaman.index')" :active="request()->routeIs('peminjaman.*')">
                        <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                        </svg>
                        @if (Auth::user()->role == 'peminjam')
                            Peminjaman Saya
                        @else
                            Peminjaman
                        @endif
                    </x-sidebar-link>

                    @if (Auth::user()->role != 'admin')
                        <x-sidebar-link :href="route('katalog.index')" :active="request()->routeIs('katalog.*')">
                            <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.782M12 3a8.997 8.997 0 00-7.843 4.782m15.654 10.555a4.5 4.5 0 01-6.25-6.25m-4.412 6.25a4.5 4.5 0 006.25-6.25" />
                            </svg>
                            Katalog Alat
                        </x-sidebar-link>
                    @endif
                </nav>

                <!-- User -->
                <div class="border-t border-white/10 p-4">
                    <div class="flex items-center gap-3">
                        <div class="flex h-9 w-9 items-center justify-center rounded-full bg-indigo-600 text-sm font-bold text-white shrink-0">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>

                        <div class="min-w-0 flex-1">
                            <p class="text-sm font-medium text-white truncate">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-400 truncate">{{ Auth::user()->email }}</p>
                        </div>
                    </div>

                    <div class="mt-3 space-y-1">
                        <x-sidebar-link :href="route('profile.edit')" :active="request()->routeIs('profile.*')">
                            <svg class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                            </svg>
                            Profil
                        </x-sidebar-link>

                        <form method="POST" action="{{ route('logout') }}"
                              onclick="event.preventDefault(); this.submit();">
                            @csrf

                            <x-sidebar-link :href="route('logout')" :active="false">
                                <svg class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                                </svg>
                                Keluar
                            </x-sidebar-link>
                        </form>
                    </div>
                </div>
            </aside>

            <!-- Main area -->
            <div class="lg:ps-64 flex min-h-screen flex-col">
                <!-- Mobile top bar -->
                <header class="sticky top-0 z-20 flex h-16 items-center gap-4 border-b border-gray-200 bg-white px-4 lg:hidden">
                    <button @click="sidebarOpen = true" class="rounded-md p-2 text-gray-500 hover:bg-gray-100">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                    </button>

                    <p class="font-semibold text-gray-900">Peminjaman Alat UKK</p>
                </header>

                <!-- Page header -->
                @isset($header)
                    <header class="bg-white border-b border-gray-200">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <!-- Page content -->
                <main class="flex-1">
                    {{ $slot }}
                </main>
            </div>
        </div>

        @style([
              'x-cloak' => '[x-cloak] { display: none !important; }',
        ])
    </body>
</html>
