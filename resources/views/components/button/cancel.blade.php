@php
    use Componist\Core\Support\Ui;
@endphp

<button
    {{ $attributes->merge(['type' => 'button', 'class' => Ui::BUTTON_SECONDARY]) }}
>
    {{ __('Abbrechen') }}
</button>
