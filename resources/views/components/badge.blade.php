@props([
    'color' => 'slate',
])

@php
    use Componist\Core\Support\Ui;

    $classes = match ($color) {
        'teal' => Ui::BADGE_TEAL,
        'amber' => Ui::BADGE_AMBER,
        'green' => Ui::BADGE_GREEN,
        'red' => Ui::BADGE_RED,
        default => Ui::BADGE_SLATE,
    };
@endphp

<span {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</span>
