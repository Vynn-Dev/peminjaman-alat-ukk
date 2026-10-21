<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Admin') }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <x-page-header title="Selamat datang, Admin 👋" subtitle="Ringkasan data peminjaman alat musik hari ini." />

        <!-- Stat cards -->
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4 mb-6">
            <x-stat-card title="Total Kategori" :value="$stats['kategori']" color="purple">
                <x-slot name="icon">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" />
                    </svg>
                </x-slot>
            </x-stat-card>

            <x-stat-card title="Total Alat" :value="$stats['alat']" color="indigo">
                <x-slot name="icon">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.073c0 1.06-.854 1.92-1.906 1.92H5.656c-1.052 0-1.906-.86-1.906-1.92v-4.073m17.5-1.185L21.75 10.5l1.5-1.5m-19.5 2.25L2.25 12l1.5 1.5M6 9.75V3.75h12v6M6 9.75l-1.5 1.5m15-1.5l1.5 1.5" />
                    </svg>
                </x-slot>
            </x-stat-card>

            <x-stat-card title="Total Stok" :value="$stats['stok']" color="green">
                <x-slot name="icon">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6l9.75 5.25L21.75 6m-18 0c0-.621.504-1.125 1.125-1.125h15.75c.621 0 1.125.504 1.125 1.125m-18 0v12c0 .621.504 1.125 1.125 1.125h15.75c.621 0 1.125-.504 1.125-1.125v-12m0 0l-9.75 5.25-9.75-5.25z" />
                    </svg>
                </x-slot>
            </x-stat-card>

            <x-stat-card title="Pengajuan Menunggu" :value="$stats['pending']" color="yellow">
                <x-slot name="icon">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </x-slot>
            </x-stat-card>
        </div>

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <!-- Peminjaman terbaru -->
            <div class="lg:col-span-2">
                <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                        <h3 class="font-semibold text-gray-900">Peminjaman Terbaru</h3>
                        <a href="{{ route('peminjaman.index') }}" class="text-sm text-indigo-600 hover:text-indigo-900">Lihat semua →</a>
                    </div>

                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 text-left text-xs uppercase text-gray-500">
                            <tr>
                                <th class="px-6 py-3">Peminjam</th>
                                <th class="px-6 py-3">Alat</th>
                                <th class="px-6 py-3">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($peminjamanTerbaru as $item)
                                <tr>
                                    <td class="px-6 py-3 whitespace-nowrap">{{ $item->user->name }}</td>
                                    <td class="px-6 py-3">
                                        @foreach ($item->details as $detail)
                                            {{ $detail->alat->nama_alat }} × {{ $detail->jumlah }}@if (!$loop->last), @endif
                                        @endforeach
                                    </td>
                                    <td class="px-6 py-3"><x-status-badge :status="$item->status" /></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-6 text-center text-gray-400">Belum ada peminjaman</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Log aktivitas -->
            <div>
                <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="font-semibold text-gray-900">Log Aktivitas</h3>
                    </div>

                    <ul class="divide-y divide-gray-200">
                        @forelse ($logTerbaru as $log)
                            <li class="px-6 py-4">
                                <p class="text-sm text-gray-800">{{ $log->aktivitas }}</p>
                                <p class="mt-1 text-xs text-gray-400">
                                    {{ $log->user->name }} · {{ $log->created_at->diffForHumans() }}
                                </p>
                            </li>
                        @empty
                            <li class="px-6 py-6 text-center text-sm text-gray-400">Belum ada aktivitas</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
