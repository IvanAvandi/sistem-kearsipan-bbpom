<a {{ $attributes->class([
        'flex items-center px-4 py-2 rounded-md transition-colors duration-200',
        'text-white bg-indigo-600 shadow-lg' => $active, // <-- Gaya untuk link AKTIF
        'text-gray-400 hover:bg-gray-700 hover:text-gray-100' => !$active // <-- Gaya untuk link TIDAK AKTIF (dengan hover)
    ]) }}>
    {{ $slot }}
</a>