@php
    use Componist\Core\Support\Ui;
@endphp

<button
    {{ $attributes->merge(['type' => 'button', 'class' => Ui::BUTTON_ICON_DANGER]) }}
>
    <x:component::icon.delete class="h-4 w-4" />
</button>
