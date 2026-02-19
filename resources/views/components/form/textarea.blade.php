@props(['value' => false])

<textarea rows="5" cols="5"
    {{ $attributes->merge(['class' => 'outline-dashboard-300 py-3 px-5 w-full border border-dashboard-300 focus:border-dashboard-300 focus:ring focus:ring-dashboard-500/70 rounded-md focus:outline-none bg-white']) }}>{{ $value }}</textarea>
