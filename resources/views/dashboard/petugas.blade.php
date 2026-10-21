<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Petugas') }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <x-page-header title="Selamat datang, Petugas 👋" subtitle="Proses pengajuan peminjaman dan pengembalian alat.">
            <x-slot name="action">
                <a href="{{ route('peminjaman.index') }}"
                   class="inline-flex items-center px-4 py-2 bg-gray-900 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                    Buka Halaman Peminjaman
                </a>
            </x-slot>
        </x-page-header>

        <!-- Stat cards -->
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3 mb-6">
            <x-stat-card title="Menunggu Persetujuan" :value="$stats['pending']" color="yellow">
                <x-slot name="icon">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-12.27 0z" />
                    </svg>
                </x-slot>
            </x-stat-card>

            <x-stat-card title="Sedang Dipinjam" :value="$stats['dipinjam']" color="blue">
                <x-slot name="icon">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                    </svg>
                </x-slot>
            </x-stat-card>

            <x-stat-card title="Peminjaman Selesai" :value="$stats['selesai']" color="green">
                <x-slot name="icon">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </x-slot>
            </x-stat-card>
        </div>

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
            <!-- Antrian approval -->
            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="font-semibold text-gray-900">Menunggu Persetujuan</h3>
                </div>

                <ul class="divide-y divide-gray-200">
                    @forelse ($pendingQueue as $item)
                        <li class="px-6 py-4">
                            <div class="sm:flex sm:items-center sm:justify-between gap-4">
                                <div class="min-w-0">
                                    <p class="text-sm font-medium text-gray-900">{{ $item->user->name }}</p>
                                    <p class="text-xs text-gray-500 truncate">
                                        @foreach ($item->details as $detail)
                                            {{ $detail->alat->nama_alat }} × {{ $detail->jumlah }}@if (!$loop->last), @endif
                                        @endforeach
                                        · {{ $item->tanggal_pinjam }}
                                    </p>
                                </div>

                                <div class="mt-3 sm:mt-0 flex gap-2 shrink-0">
                                    <form action="{{ route('peminjaman.approve', $item->id) }}" method="POST">
                                        @csrf
                                        <button class="inline-flex items-center px-3 py-2 bg-green-600 rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700">
                                            Approve
                                        </button>
                                    </form>

                                    <form action="{{ route('peminjaman.tolak', $item->id) }}" method="POST">
                                        @csrf
                                        <button class="inline-flex items-center px-3 py-2 bg-red-600 rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700">
                                            Tolak
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </li>
                    @empty
                        <li class="px-6 py-6 text-center text-sm text-gray-400">Tidak ada pengajuan menunggu 🎉</li>
                    @endforelse
                </ul>
            </div>

            <!-- Sedang dipinjam -->
            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="font-semibold text-gray-900">Alat Sedang Dipinjam</h3>
                </div>

                <ul class="divide-y divide-gray-200">
                    @forelse ($dipinjam as $item)
                        <li class="px-6 py-4">
                            <div class="sm:flex sm:items-center sm:justify-between gap-4">
                                <div class="min-w-0">
                                    <p class="text-sm font-medium text-gray-900">{{ $item->user->name }}</p>
                                    <p class="text-xs text-gray-500 truncate">
                                        @foreach ($item->details as $detail)
                                            {{ $detail->alat->nama_alat }} × {{ $detail->jumlah }}@if (!$loop->last), @endif
                                        @endforeach
                                    </p>
                                </div>

                                <div class="mt-2 sm:mt-0">
                                    @php
                                        $terlambat = \Carbon\Carbon::parse($item->tanggal_kembali)->endOfDay()->isPast();
                                    @endphp
                                    <span class="text-xs {{ $terlambat ? 'text-red-600 font-semibold' : 'text-gray-500' }}">
                                        Kembali: {{ $item->tanggal_kembali }}{{ $terlambat ? ' (terlambat)' : '' }}
                                    </span>
                                </div>
                            </div>
                        </li>
                    @empty
                        <li class="px-6 py-6 text-center text-sm text-gray-400">Tidak ada alat yang sedang dipinjam</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>
