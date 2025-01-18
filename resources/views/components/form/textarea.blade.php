@props(['value' => false])

<textarea rows="5" cols="5"
    {{ $attributes->merge(['class' => 'outline-primary-300 py-3 px-5 w-full border-dashboard-300 rounded-md focus:border-dashboard-300 focus:ring focus:ring-primary-200 focus:ring-opacity-70']) }}>{{ $value }}</textarea>
