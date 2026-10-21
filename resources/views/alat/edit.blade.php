<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Alat') }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-2xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm sm:rounded-lg p-6">
            <form action="{{ route('alat.update', $alat) }}"
                  method="POST"
                  enctype="multipart/form-data"
                  class="space-y-4">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label for="kode_alat" class="block text-sm font-medium text-gray-700">Kode Alat</label>
                        <input id="kode_alat" type="text" name="kode_alat" value="{{ old('kode_alat', $alat->kode_alat) }}"
                               class="mt-1 block w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" />
                        @error('kode_alat') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="nama_alat" class="block text-sm font-medium text-gray-700">Nama Alat</label>
                        <input id="nama_alat" type="text" name="nama_alat" value="{{ old('nama_alat', $alat->nama_alat) }}"
                               class="mt-1 block w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" />
                        @error('nama_alat') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="merk" class="block text-sm font-medium text-gray-700">Merk</label>
                        <input id="merk" type="text" name="merk" value="{{ old('merk', $alat->merk) }}"
                               class="mt-1 block w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" />
                        @error('merk') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="stok" class="block text-sm font-medium text-gray-700">Stok</label>
                        <input id="stok" type="number" name="stok" value="{{ old('stok', $alat->stok) }}" min="0"
                               class="mt-1 block w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" />
                        @error('stok') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="kondisi" class="block text-sm font-medium text-gray-700">Kondisi</label>
                        <select id="kondisi" name="kondisi"
                                class="mt-1 block w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="baik" @selected(old('kondisi', $alat->kondisi) == 'baik')>Baik</option>
                            <option value="rusak ringan" @selected(old('kondisi', $alat->kondisi) == 'rusak ringan')>Rusak Ringan</option>
                            <option value="rusak berat" @selected(old('kondisi', $alat->kondisi) == 'rusak berat')>Rusak Berat</option>
                        </select>
                        @error('kondisi') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="kategori_id" class="block text-sm font-medium text-gray-700">Kategori</label>
                        <select id="kategori_id" name="kategori_id"
                                class="mt-1 block w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                            @foreach ($kategori as $item)
                                <option value="{{ $item->id }}" @selected(old('kategori_id', $alat->kategori_id) == $item->id)>
                                    {{ $item->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                        @error('kategori_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label for="foto" class="block text-sm font-medium text-gray-700">
                        Foto baru (opsional)
                    </label>
                    <input id="foto" type="file" name="foto" accept="image/jpeg,image/png"
                           class="mt-1 block w-full" />
                    @error('foto') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror

                    @if ($alat->foto)
                        <p class="mt-2 text-sm text-gray-500">Foto saat ini:</p>
                        <img src="{{ asset('foto_alat/' . $alat->foto) }}" class="mt-1 w-24 h-24 object-cover rounded">
                    @endif
                </div>

                <div class="flex justify-end gap-2 pt-2">
                    <a href="{{ route('alat.index') }}"
                       class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md font-semibold text-xs uppercase tracking-widest text-gray-700 hover:bg-gray-50">
                        Batal
                    </a>

                    <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-gray-900 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
