<div class="relative w-full min-w-52 sm:w-64">
    <x:component::form.input {{ $attributes->merge(['class' => 'pl-10 pr-4']) }} />
    <x:component::icon.search
        class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400 dark:text-slate-500"
    />
</div>
