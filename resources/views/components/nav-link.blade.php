@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1 border-b-2 border-yellow-300 text-sm font-medium leading-5 text-yellow-200 focus:outline-none focus:border-yellow-200 transition duration-150 ease-in-out'
            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-yellow-100/80 hover:text-yellow-300 hover:border-yellow-500/50 focus:outline-none focus:text-yellow-300 focus:border-yellow-500/50 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
