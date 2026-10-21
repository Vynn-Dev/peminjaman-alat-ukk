@props(['href', 'active' => false])

<a href="{{ $href }}"
   class="{{ $active ? 'bg-white/10 text-white' : 'text-gray-300 hover:bg-white/10 hover:text-white' }}
          group flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition">
    {{ $slot }}
</a>
