@props(['target' => null])

<a {{ $attributes->merge(['class' => 'block py-3 text-slate-200 transition-all duration-200 ease-linear hover:text-white']) }}
    @if ($target == '_blank') target="_blank" @endif>{{ $slot }}</a>
