@props([
    'href' => null,
])

@php
    use Componist\Core\Support\Ui;

    $classes = Ui::BUTTON_SECONDARY;
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button {{ $attributes->merge(['type' => 'button', 'class' => $classes]) }}>
        {{ $slot }}
    </button>
@endif
