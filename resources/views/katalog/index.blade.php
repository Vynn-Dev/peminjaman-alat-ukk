<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Katalog Alat') }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <x-page-header title="Katalog Alat Musik" subtitle="Lihat kondisi dan ketersediaan stok setiap alat." />

        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            @forelse ($alat as $item)
                <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                    <div class="h-40 bg-gray-100 flex items-center justify-center overflow-hidden">
                        @if ($item->foto)
                            <img src="{{ asset('foto_alat/' . $item->foto) }}"
                                 alt="{{ $item->nama_alat }}" class="h-40 w-full object-cover">
                        @else
                            <svg class="h-16 w-16 text-gray-300" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.073c0 1.06-.854 1.92-1.906 1.92H5.656c-1.052 0-1.906-.86-1.906-1.92v-4.073m17.5-1.185L21.75 10.5l1.5-1.5m-19.5 2.25L2.25 12l1.5 1.5M6 9.75V3.75h12v6M6 9.75l-1.5 1.5m15-1.5l1.5 1.5" />
                            </svg>
                        @endif
                    </div>

                    <div class="p-5">
                        <div class="flex items-start justify-between gap-2">
                            <h3 class="font-semibold text-gray-900 leading-snug">{{ $item->nama_alat }}</h3>
                            <x-status-badge :status="$item->kondisi" />
                        </div>

                        <p class="mt-1 text-sm text-gray-500">{{ $item->merk }} · {{ $item->kategori->nama_kategori ?? '-' }}</p>

                        <div class="mt-4 flex items-center justify-between">
                            <span class="text-sm font-medium text-gray-600">
                                Kode: {{ $item->kode_alat }}
                            </span>

                            <span class="text-sm font-bold {{ $item->stok > 0 ? 'text-green-600' : 'text-red-500' }}">
                                {{ $item->stok > 0 ? 'Stok ' . $item->stok : 'Habis' }}
                            </span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full">
                    <x-empty-state message="Belum ada alat musik dalam katalog." />
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
