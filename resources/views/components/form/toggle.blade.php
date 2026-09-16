@props([
    'id' => null,
    'status' => false,
])

@php
    $toggleId = $id ?? 'toggle-'.uniqid();
    $isChecked = filter_var($status, FILTER_VALIDATE_BOOLEAN);
@endphp

<label for="{{ $toggleId }}" class="relative inline-flex cursor-pointer items-center">
    <input
        @if (isset($attributes['wire:change']))
            {{ $attributes->wire('change') }}
        @else
            {{ $attributes->wire('model.live') }}
        @endif
        type="checkbox"
        id="{{ $toggleId }}"
        class="peer sr-only"
        @checked($isChecked)
    >
    <div
        class="h-6 w-11 rounded-full bg-slate-300 transition-colors duration-200 after:absolute after:left-0.5 after:top-0.5 after:h-5 after:w-5 after:rounded-full after:border after:border-slate-200 after:bg-white after:shadow-sm after:transition-all after:content-[''] peer-checked:bg-teal-500 peer-checked:after:translate-x-5 peer-focus-visible:outline-none peer-focus-visible:ring-2 peer-focus-visible:ring-teal-500/40 peer-focus-visible:ring-offset-2 peer-disabled:cursor-not-allowed peer-disabled:opacity-60 dark:bg-slate-600 dark:after:border-slate-500 dark:peer-focus-visible:ring-offset-slate-900"
        aria-hidden="true"
    ></div>
</label>
