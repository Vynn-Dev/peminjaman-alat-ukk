<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Peminjaman') }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if (session('success'))
            <div class="mb-4 rounded-md bg-green-50 border border-green-200 p-4 text-sm text-green-700">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 rounded-md bg-red-50 border border-red-200 p-4 text-sm text-red-700">
                {{ session('error') }}
            </div>
        @endif

        <x-page-header
            title="{{ auth()->user()->role == 'peminjam' ? 'Peminjaman Saya' : 'Data Peminjaman' }}"
            subtitle="{{ auth()->user()->role == 'petugas' ? 'Proses approve, tolak, dan pengembalian alat.' : 'Riwayat peminjaman alat musik.' }}">
            <x-slot name="action">
                <a href="{{ route('peminjaman.create') }}"
                   class="inline-flex items-center px-4 py-2 bg-gray-900 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                    + Ajukan Peminjaman
                </a>
            </x-slot>
        </x-page-header>

        <div class="bg-white shadow-sm sm:rounded-lg overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-200 text-left text-xs uppercase text-gray-500">
                    <tr>
                        <th class="px-6 py-3">Peminjam</th>
                        <th class="px-6 py-3">Alat</th>
                        <th class="px-6 py-3">Tanggal Pinjam</th>
                        <th class="px-6 py-3">Tanggal Kembali</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($peminjaman as $item)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">{{ $item->user->name }}</td>
                            <td class="px-6 py-4">
                                @foreach ($item->details as $detail)
                                    {{ $detail->alat->nama_alat }} × {{ $detail->jumlah }}@if (!$loop->last), @endif
                                @endforeach
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $item->tanggal_pinjam }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $item->tanggal_kembali }}</td>
                            <td class="px-6 py-4"><x-status-badge :status="$item->status" /></td>
                            <td class="px-6 py-4 text-right space-x-3">
                                @if (auth()->user()->role == 'petugas')

                                    @if ($item->status == 'pending')
                                        <form class="inline" action="{{ route('peminjaman.approve', $item->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Setujui peminjaman ini?')">
                                            @csrf

                                            <button type="submit"
                                                    class="text-green-600 hover:text-green-900 font-medium">
                                                Approve
                                            </button>
                                        </form>

                                        <form class="inline" action="{{ route('peminjaman.tolak', $item->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Tolak peminjaman ini?')">
                                            @csrf

                                            <button type="submit"
                                                    class="text-red-600 hover:text-red-900 font-medium">
                                                Tolak
                                            </button>
                                        </form>
                                    @endif

                                    @if ($item->status == 'disetujui')
                                        <form class="flex flex-wrap justify-end items-center gap-2"
                                              action="{{ route('pengembalian.store', $item->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Catat pengembalian alat ini?')">
                                            @csrf

                                            <select name="kondisi_setelah_kembali"
                                                    class="rounded-md border-gray-300 text-xs">
                                                <option value="baik">Baik</option>
                                                <option value="rusak ringan">Rusak Ringan</option>
                                                <option value="rusak berat">Rusak Berat</option>
                                            </select>

                                            <input type="text"
                                                   name="catatan"
                                                   placeholder="Catatan (opsional)"
                                                   class="rounded-md border-gray-300 text-xs w-32" />

                                            <button type="submit"
                                                    class="text-indigo-600 hover:text-indigo-900 font-medium">
                                                Kembalikan
                                            </button>
                                        </form>
                                    @endif

                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="py-2">
                                    <x-empty-state message="Belum ada peminjaman"
                                                   :href="route('peminjaman.create')"
                                                   actionText="Ajukan Peminjaman" />
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
