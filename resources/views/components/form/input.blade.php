@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
    'class' =>
        'outline-primary-300 py-3 px-5 w-full border border-dashboard-300 focus:border-dashboard-300 focus:ring focus:ring-dashboard-500 focus:ring-opacity-70 rounded-md focus:outline-none',
]) !!}>
