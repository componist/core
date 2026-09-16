@php
    use Componist\Core\Support\Ui;
@endphp

<input
    type="checkbox"
    {!! $attributes->merge([
        'class' => Ui::CHECKBOX,
    ]) !!}
>
