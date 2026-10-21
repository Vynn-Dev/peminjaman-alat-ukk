<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ajukan Peminjaman') }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-2xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm sm:rounded-lg p-6">
            <form action="{{ route('peminjaman.store') }}" method="POST" class="space-y-4">
                @csrf

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label for="tanggal_pinjam" class="block text-sm font-medium text-gray-700">
                            Tanggal Pinjam
                        </label>
                        <input id="tanggal_pinjam" type="date" name="tanggal_pinjam" value="{{ old('tanggal_pinjam') }}"
                               class="mt-1 block w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" />
                        @error('tanggal_pinjam') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="tanggal_kembali" class="block text-sm font-medium text-gray-700">
                            Tanggal Kembali
                        </label>
                        <input id="tanggal_kembali" type="date" name="tanggal_kembali" value="{{ old('tanggal_kembali') }}"
                               class="mt-1 block w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" />
                        @error('tanggal_kembali') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label for="alat_id" class="block text-sm font-medium text-gray-700">Alat</label>
                    <select id="alat_id" name="alat_id"
                            class="mt-1 block w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                        @foreach ($alat as $item)
                            <option value="{{ $item->id }}">
                                {{ $item->nama_alat }} ({{ $item->merk }}) — stok: {{ $item->stok }}
                            </option>
                        @endforeach
                    </select>
                    @error('alat_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="jumlah" class="block text-sm font-medium text-gray-700">Jumlah</label>
                    <input id="jumlah" type="number" name="jumlah" value="{{ old('jumlah') }}" min="1"
                           class="mt-1 block w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" />
                    @error('jumlah') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="flex justify-end gap-2 pt-2">
                    <a href="{{ route('peminjaman.index') }}"
                       class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md font-semibold text-xs uppercase tracking-widest text-gray-700 hover:bg-gray-50">
                        Batal
                    </a>

                    <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-gray-900 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                        Ajukan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
