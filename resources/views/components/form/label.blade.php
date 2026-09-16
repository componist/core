@props(['value' => null])

@php
    use Componist\Core\Support\Ui;
@endphp

<label {{ $attributes->merge(['class' => Ui::LABEL]) }}>{{ $value ?? $slot }}</label>
