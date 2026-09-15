@props(['value' => false])

<div wire:ignore>
    <textarea rows="5" cols="5"
        {{ $attributes->merge(['class' => 'tinymceEditorSmall w-full rounded-md border border-slate-300 bg-white px-5 py-3 text-slate-900 outline-none focus:border-teal-500 focus:ring focus:ring-teal-500/30 dark:border-slate-600 dark:bg-slate-800 dark:text-white dark:focus:border-teal-500']) }}>{{ $value }}</textarea>
</div>

@once
    @vite('resources/js/tinymce.js')
@endonce
