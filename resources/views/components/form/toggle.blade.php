@props([
    'id' => uniqid(),
    'status' => false,
])

@php
    $isChecked = filter_var($status, FILTER_VALIDATE_BOOLEAN);
@endphp

<label for="{{ $id }}" class="relative inline-flex cursor-pointer items-center">
    <input
        @if (isset($attributes['wire:change'])) {{ $attributes->wire('change') }}
    @else
        {{ $attributes->wire('model.live') }} @endif
        type="checkbox" id="{{ $id }}" class="peer sr-only" @checked($isChecked)>
    <div
        class="h-7 w-12 rounded-full bg-slate-300 after:absolute after:left-[2px] after:top-[2px] after:h-6 after:w-6 after:rounded-full after:border after:border-slate-200 after:bg-white after:transition-all after:content-[''] peer-checked:bg-teal-500 peer-checked:after:translate-x-full peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-teal-500/40 dark:bg-slate-700 dark:after:border-slate-600">
    </div>
</label>
