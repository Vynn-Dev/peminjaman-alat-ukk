@props(['title', 'subtitle' => null])

<div class="mb-6 sm:flex sm:items-center sm:justify-between">
    <div>
        <h2 class="text-2xl font-bold text-gray-900">{{ $title }}</h2>

        @if ($subtitle)
            <p class="mt-1 text-sm text-gray-500">{{ $subtitle }}</p>
        @endif
    </div>

    @isset($action)
        {{ $action }}
    @endisset
</div>
