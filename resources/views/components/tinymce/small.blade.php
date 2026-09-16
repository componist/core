@props(['value' => null])

@php
    use Componist\Core\Support\Ui;
@endphp

<div wire:ignore>
    <textarea
        rows="5"
        {{ $attributes->merge(['class' => 'tinymceEditorSmall '.Ui::TEXTAREA]) }}
    >{{ $value }}</textarea>
</div>

@once
    @vite('resources/js/tinymce.js')
@endonce
