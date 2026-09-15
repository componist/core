@props([
    'href' => null,
])

@php
    $classes =
        'inline-flex cursor-pointer items-center justify-center gap-2 whitespace-nowrap rounded-md bg-teal-500 px-4 py-2 text-sm font-medium text-white transition-colors duration-200 hover:bg-teal-600 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 dark:focus:ring-offset-slate-900';
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button type="button" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </button>
@endif
