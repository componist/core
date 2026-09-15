@props(['target' => null])

<a {{ $attributes->merge(['class' => 'block w-full px-3 py-2 text-left text-sm text-slate-700 transition-colors duration-200 hover:bg-slate-100 focus:outline-none dark:text-slate-200 dark:hover:bg-slate-800']) }}
    @if ($target == '_blank') target="_blank" @endif>{{ $slot }}</a>
