<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Kategori') }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        @if (session('success'))
            <div class="mb-4 rounded-md bg-green-50 border border-green-200 p-4 text-sm text-green-700">
                {{ session('success') }}
            </div>
        @endif

        <x-page-header title="Data Kategori" subtitle="Kelola kategori alat musik.">
            <x-slot name="action">
                <a href="{{ route('kategori.create') }}"
                   class="inline-flex items-center px-4 py-2 bg-gray-900 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                    + Tambah Kategori
                </a>
            </x-slot>
        </x-page-header>

        <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-200 text-left text-xs uppercase text-gray-600">
                    <tr>
                        <th class="px-6 py-3">No</th>
                        <th class="px-6 py-3">Nama Kategori</th>
                        <th class="px-6 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($kategori as $item)
                        <tr>
                            <td class="px-6 py-3">{{ $loop->iteration }}</td>
                            <td class="px-6 py-3">{{ $item->nama_kategori }}</td>
                            <td class="px-6 py-3 text-right">
                                <a href="{{ route('kategori.edit', $item) }}"
                                   class="text-indigo-600 hover:text-indigo-900">Edit</a>

                                <form class="inline" action="{{ route('kategori.destroy', $item) }}"
                                      method="POST"
                                      onsubmit="return confirm('Hapus kategori ini?')">
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
                            <td class="px-6 py-6 text-center text-gray-500" colspan="3">
                                Belum ada kategori
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
