@props([
    'link' => null,
    'title' => null,
])

@if (isset($link) && !empty($link))
    <li>
        <a href="{{ $link }}"
            class="flex px-3 py-2 text-sm text-slate-700 no-underline transition-colors duration-150 hover:bg-slate-100 hover:text-teal-600 hover:no-underline dark:text-slate-200 dark:hover:bg-slate-800 dark:hover:text-teal-400"
            @click.prevent="open=false">{{ $title }}</a>
    </li>
@else
    <li>
        <button type="button" @click.prevent="open=false" {{ $attributes }}
            class="flex w-full px-3 py-2 text-left text-sm text-slate-700 no-underline transition-colors duration-150 hover:bg-slate-100 hover:text-teal-600 hover:no-underline dark:text-slate-200 dark:hover:bg-slate-800 dark:hover:text-teal-400">{{ $title }}</button>
    </li>
@endif
