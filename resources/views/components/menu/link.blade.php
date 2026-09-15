@props([
    'target' => null,
    'active' => false,
])

@php
    $classes = $active
        ? 'group relative block rounded-xl bg-teal-50 px-3 py-2 text-sm font-medium text-teal-800 transition duration-200 dark:bg-teal-950/40 dark:text-teal-200'
        : 'group relative block rounded-xl px-3 py-2 text-sm text-slate-600 transition duration-200 hover:bg-slate-100 hover:text-teal-700 dark:text-slate-300 dark:hover:bg-slate-800 dark:hover:text-teal-300';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}
    @if ($target == '_blank') target="_blank" @endif>
    @if ($active)
        <span class="absolute inset-y-2 left-0 w-0.5 rounded-full bg-teal-500" aria-hidden="true"></span>
    @endif
    {{ $slot }}
</a>
