@props(['status'])

@php
$badges = [
    'pending' => 'bg-yellow-100 text-yellow-700',
    'menunggu' => 'bg-yellow-100 text-yellow-700',
    'disetujui' => 'bg-blue-100 text-blue-700',
    'ditolak' => 'bg-red-100 text-red-700',
    'selesai' => 'bg-green-100 text-green-700',
    'dikembalikan' => 'bg-green-100 text-green-700',
    'baik' => 'bg-green-100 text-green-700',
    'rusak ringan' => 'bg-yellow-100 text-yellow-700',
    'rusak berat' => 'bg-red-100 text-red-700',
    'belum selesai' => 'bg-yellow-100 text-yellow-700',
];

// Label yang lebih ramah untuk peminjaman
$labels = [
    'pending' => 'Menunggu',
    'disetujui' => 'Dipinjam',
    'ditolak' => 'Ditolak',
    'selesai' => 'Selesai',
    'belum selesai' => 'Belum Selesai',
];

$label = $labels[$status] ?? ucfirst($status);
$bg = $badges[$status] ?? 'bg-gray-100 text-gray-700';
@endphp

<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $bg }}">
    {{ $label }}
</span>
