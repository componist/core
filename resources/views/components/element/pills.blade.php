@props(['value' => null])

<span {{ $attributes->merge(['class' => 'inline-flex items-center rounded-full px-3 py-1 text-sm font-medium shadow-sm shadow-black/5 dark:shadow-none']) }}>{{ $value }}</span>
