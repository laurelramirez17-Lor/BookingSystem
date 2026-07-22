@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-semibold text-xs uppercase tracking-widest text-yellow-300']) }}>
    {{ $value ?? $slot }}
</label>
