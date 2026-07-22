@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'font-medium text-sm text-yellow-200 bg-yellow-500/10 border border-yellow-500/25 rounded-md px-3 py-2']) }}>
        {{ $status }}
    </div>
@endif
