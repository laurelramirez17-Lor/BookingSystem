@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border border-yellow-500/30 bg-black/30 text-white placeholder:text-gray-500 focus:border-yellow-300 focus:ring-yellow-300 rounded-md shadow-sm']) }}>
