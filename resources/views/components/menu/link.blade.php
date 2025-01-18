@props([
    'target' => null,
    'active' => false,
])

@php
    $classes = $active ?? false ? 'block my-3 py-2 px-4 transition-all duration-200 ease-linear bg-dashboard-500 text-white rounded-full' : 'block mx-4 py-2 text-gray-600 transition-all duration-200 ease-linear hover:text-dashboard-500';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}
    @if ($target == '_blank') target="_blank" @endif>{{ $slot }}</a>
