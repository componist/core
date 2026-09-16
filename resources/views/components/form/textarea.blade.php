@props([
    'value' => null,
    'disabled' => false,
])

@php
    use Componist\Core\Support\Ui;
@endphp

<textarea
    rows="5"
    @disabled($disabled)
    {!! $attributes->merge([
        'class' => Ui::TEXTAREA,
    ]) !!}
>{{ $value ?? $slot }}</textarea>
