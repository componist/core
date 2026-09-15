@props(['target' => null])

<a {{ $attributes->merge(['class' => 'block rounded-lg px-3 py-2 text-sm text-slate-600 transition-colors duration-200 hover:bg-slate-100 hover:text-teal-600 dark:text-slate-300 dark:hover:bg-slate-800 dark:hover:text-teal-400']) }}
    @if ($target == '_blank') target="_blank" @endif>{{ $slot }}</a>
