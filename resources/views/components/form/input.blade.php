@props(['disabled' => false])

@php
    use Componist\Core\Support\Ui;
@endphp

<input
    @disabled($disabled)
    {!! $attributes->merge([
        'class' => Ui::FIELD,
    ]) !!}
>
