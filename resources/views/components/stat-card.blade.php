@props(['title', 'value', 'color' => 'indigo'])

@php
$colors = [
    'indigo' => 'bg-indigo-50 text-indigo-600',
    'green' => 'bg-green-50 text-green-600',
    'yellow' => 'bg-yellow-50 text-yellow-600',
    'red' => 'bg-red-50 text-red-600',
    'blue' => 'bg-blue-50 text-blue-600',
    'purple' => 'bg-purple-50 text-purple-600',
];
@endphp

<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
    <div class="flex items-center">
        <div class="rounded-lg p-3 {{ $colors[$color] }}">
            {{ $icon }}
        </div>

        <div class="ms-4">
            <p class="text-sm font-medium text-gray-500">{{ $title }}</p>
            <p class="text-2xl font-bold text-gray-900">{{ $value }}</p>
        </div>
    </div>
</div>
