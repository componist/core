@props(['disabled' => false])

@php
    use Componist\Core\Support\Ui;
@endphp

<select
    @disabled($disabled)
    {!! $attributes->merge([
        'class' => Ui::FIELD,
    ]) !!}
>
    {{ $slot }}
</select>
