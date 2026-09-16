@php
    use Componist\Core\Support\Ui;
@endphp

<button type="button" {{ $attributes->merge(['class' => Ui::BUTTON_FAB]) }}>
    {{ $slot }}
</button>
