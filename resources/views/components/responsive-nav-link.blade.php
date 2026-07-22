@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-yellow-300 text-start text-base font-medium text-yellow-200 bg-yellow-500/10 focus:outline-none focus:text-yellow-100 focus:bg-yellow-500/15 transition duration-150 ease-in-out'
            : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-yellow-100/80 hover:text-yellow-300 hover:bg-yellow-500/10 hover:border-yellow-500/50 focus:outline-none focus:text-yellow-300 focus:bg-yellow-500/10 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
