@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1 border-b-2 border-bovi-green-600 text-sm font-medium leading-5 text-bovi-green-800 focus:outline-none focus:border-bovi-green-800 transition duration-150 ease-in-out'
            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-bovi-green-700 hover:border-bovi-green-200 focus:outline-none focus:text-bovi-green-700 focus:border-bovi-green-200 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
