@props(['value' => false])

<textarea rows="5" cols="5" {!! $attributes->merge([
    'class' =>
        'w-full rounded-lg border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-900 shadow-sm outline-none transition-colors duration-200 placeholder:text-slate-400 focus:border-teal-500 focus:ring-2 focus:ring-teal-500/30 dark:border-slate-600 dark:bg-slate-800 dark:text-white dark:placeholder:text-slate-400 dark:focus:border-teal-500',
]) !!}>{{ $value }}</textarea>
