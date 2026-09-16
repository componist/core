@props([
    'variant' => 'neutral',
    'href' => null,
])

@php
    use Componist\Core\Support\Ui;

    $classes = match ($variant) {
        'teal' => Ui::BUTTON_ICON_TEAL,
        'danger' => Ui::BUTTON_ICON_DANGER,
        default => Ui::BUTTON_ICON_NEUTRAL,
    };
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button type="button" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </button>
@endif
