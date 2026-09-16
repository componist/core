@props([
    'title' => null,
    'description' => null,
])

<div {{ $attributes->merge(['class' => 'mx-auto w-full max-w-7xl px-4 py-6 sm:px-6 lg:px-8']) }}>
    @if ($title || $description || isset($actions))
        <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
            <div class="min-w-0">
                @if ($title)
                    <h1 class="text-2xl font-semibold tracking-tight text-slate-900 dark:text-white">{{ $title }}</h1>
                @endif
                @if ($description)
                    <p class="mt-1 text-sm text-slate-600 dark:text-slate-300">{{ $description }}</p>
                @endif
            </div>
            @isset($actions)
                <div class="flex flex-shrink-0 flex-wrap items-center justify-end gap-3">
                    {{ $actions }}
                </div>
            @endisset
        </div>
    @endif

    <div class="{{ \Componist\Core\Support\Ui::SURFACE }}">
        <div class="grid grid-cols-1 gap-5 p-5 sm:p-6">
            {{ $slot }}
        </div>
    </div>
</div>
