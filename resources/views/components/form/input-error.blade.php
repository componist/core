@props(['for' => null])

@php
    use Componist\Core\Support\Ui;
@endphp

@error($for)
    <p {{ $attributes->merge(['class' => Ui::ERROR]) }} role="alert">{{ $message }}</p>
@enderror
