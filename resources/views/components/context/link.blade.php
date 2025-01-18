@props([
    'link' => null,
    'title' => null,
])

@if (isset($link) && !empty($link))
    <li>
        <a href="{{ $link }}"
            class="flex px-4 py-2 text-gray-600 no-underline transition-colors duration-100 hover:text-dashboard-500 hover:no-underline"
            @click.prevent="open=false">{{ $title }}</a>

    </li>
@else
    <li>
        <button type="button" @click.prevent="open=false" {{ $attributes }}
            class="flex px-4 py-2 text-gray-600 no-underline transition-colors duration-100 hover:text-dashboard-500 hover:no-underline">{{ $title }}</button>
    </li>
@endif
