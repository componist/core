@php
    use Componist\Core\Support\Ui;
@endphp

<button
    {{ $attributes->merge(['type' => 'button', 'class' => Ui::BUTTON_ICON_TEAL]) }}
>
    <x:component::icon.show class="h-4 w-4" />
</button>
