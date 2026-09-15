@props([
    'title' => 'Eintrag unwiderruflich löschen?',
    'confirm' => 'Löschen',
    'cancel' => 'Abbrechen',
])

<div x-data="{ modal: false }">
    @isset($trigger)
        {{ $trigger }}
    @else
        <x:component::button.delete @click.prevent="modal = true" />
    @endisset

    <div x-show="modal" x-cloak x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 px-5 backdrop-blur-sm">
        <div @click.outside="modal = false"
            class="w-full max-w-sm overflow-hidden rounded-lg border border-slate-200 bg-white shadow-lg dark:border-slate-700 dark:bg-slate-900">
            <div class="px-5 py-6">
                <div class="flex justify-center">
                    <div
                        class="flex h-16 w-16 items-center justify-center rounded-full bg-red-100 text-red-500 dark:bg-red-900/40">
                        <x:component::icon.delete class="h-8 w-8" />
                    </div>
                </div>
                <h3 class="mt-5 text-center text-base font-semibold text-slate-800 dark:text-slate-100">
                    {{ $title }}
                </h3>
            </div>
            <div class="grid grid-cols-2 gap-3 border-t border-slate-200 bg-slate-50 px-4 py-4 dark:border-slate-700 dark:bg-slate-800/60">
                <button @click.prevent="modal = false" type="button"
                    class="inline-flex cursor-pointer items-center justify-center rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 transition-colors duration-200 hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-slate-400 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-200 dark:hover:bg-slate-700">
                    {{ $cancel }}
                </button>
                <button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex cursor-pointer items-center justify-center rounded-lg bg-red-500 px-4 py-2 text-sm font-medium text-white transition-colors duration-200 hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500']) }}
                    @click.prevent="modal = false">
                    {{ $confirm }}
                </button>
            </div>
        </div>
    </div>
</div>
