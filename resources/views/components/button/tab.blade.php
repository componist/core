@props([
    'active' => null,
])

@php
    use Componist\Core\Support\Ui;

    $classes = Ui::TAB;
    if ($active === true) {
        $classes .= ' '.Ui::TAB_ACTIVE;
    } elseif ($active === false) {
        $classes .= ' '.Ui::TAB_INACTIVE;
    }
@endphp

<button type="button" {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</button>
