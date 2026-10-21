<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Log Aktivitas') }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-200 text-left text-xs uppercase text-gray-600">
                    <tr>
                        <th class="px-6 py-3">Waktu</th>
                        <th class="px-6 py-3">Pengguna</th>
                        <th class="px-6 py-3">Aktivitas</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($log as $item)
                        <tr>
                            <td class="px-6 py-3 whitespace-nowrap">{{ $item->created_at->format('d-m-Y H:i') }}</td>
                            <td class="px-6 py-3">{{ $item->user->name }}</td>
                            <td class="px-6 py-3">{{ $item->aktivitas }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td class="px-6 py-6 text-center text-gray-500" colspan="3">
                                Belum ada aktivitas
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
