<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Alat Musik') }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        @if (session('success'))
            <div class="mb-4 rounded-md bg-green-50 border border-green-200 p-4 text-sm text-green-700">
                {{ session('success') }}
            </div>
        @endif

        <x-page-header title="Data Alat Musik" subtitle="Kelola data, stok, dan kondisi alat musik.">
            <x-slot name="action">
                <a href="{{ route('alat.create') }}"
                   class="inline-flex items-center px-4 py-2 bg-gray-900 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                    + Tambah Alat
                </a>
            </x-slot>
        </x-page-header>

        <div class="bg-white shadow-sm sm:rounded-lg overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-200 text-left text-xs uppercase text-gray-600">
                    <tr>
                        <th class="px-6 py-3">Foto</th>
                        <th class="px-6 py-3">Kode</th>
                        <th class="px-6 py-3">Nama Alat</th>
                        <th class="px-6 py-3">Merk</th>
                        <th class="px-6 py-3">Kategori</th>
                        <th class="px-6 py-3">Stok</th>
                        <th class="px-6 py-3">Kondisi</th>
                        <th class="px-6 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($alat as $item)
                        <tr>
                            <td class="px-6 py-3">
                                @if ($item->foto)
                                    <img src="{{ asset('foto_alat/' . $item->foto) }}" class="w-12 h-12 object-cover rounded">
                                @else
                                    <span class="text-gray-400">—</span>
                                @endif
                            </td>
                            <td class="px-6 py-3">{{ $item->kode_alat }}</td>
                            <td class="px-6 py-3">{{ $item->nama_alat }}</td>
                            <td class="px-6 py-3">{{ $item->merk }}</td>
                            <td class="px-6 py-3">{{ $item->kategori->nama_kategori ?? '-' }}</td>
                            <td class="px-6 py-3">{{ $item->stok }}</td>
                            <td class="px-6 py-3">
                                <x-status-badge :status="$item->kondisi" />
                            </td>
                            <td class="px-6 py-3 text-right">
                                <a href="{{ route('alat.edit', $item) }}"
                                   class="text-indigo-600 hover:text-indigo-900">Edit</a>

                                <form class="inline" action="{{ route('alat.destroy', $item) }}"
                                      method="POST"
                                      onsubmit="return confirm('Hapus alat ini?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="text-red-600 hover:text-red-900">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="px-6 py-6 text-center text-gray-500" colspan="8">
                                Belum ada alat
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
