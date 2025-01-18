@props(['value' => null])

<span {{ $attributes->merge(['class' => 'py-1 px-3 rounded-full shadow-sm']) }}>{{ $value }}</span>
