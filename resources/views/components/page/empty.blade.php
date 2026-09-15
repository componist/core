@props([
    'title' => 'Keine Einträge vorhanden',
    'description' => null,
])

<div {{ $attributes->merge(['class' => 'overflow-hidden rounded-lg border border-dashed border-slate-300 bg-white px-6 py-12 text-center dark:border-slate-700 dark:bg-slate-900']) }}>
    <p class="text-sm font-medium text-slate-800 dark:text-slate-100">{{ $title }}</p>
    @if ($description || ! $slot->isEmpty())
        <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">
            {{ $description ?? $slot }}
        </p>
    @endif
</div>
