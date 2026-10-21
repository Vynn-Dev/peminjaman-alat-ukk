@props(['message', 'href' => null, 'actionText' => null])

<div class="bg-white shadow-sm sm:rounded-lg flex flex-col items-center justify-center py-16 px-6 text-center">
    <svg class="w-12 h-12 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
    </svg>

    <p class="mt-4 text-sm text-gray-500">{{ $message }}</p>

    @if ($href && $actionText)
        <a href="{{ $href }}"
           class="mt-4 inline-flex items-center px-4 py-2 bg-gray-900 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
            {{ $actionText }}
        </a>
    @endif
</div>
