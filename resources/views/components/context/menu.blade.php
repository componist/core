<div x-data="{ open: false }" class="relative">
    <button @click.prevent="open = ! open" type="button"
        class="inline-flex items-center rounded-lg p-1 text-slate-500 transition hover:bg-slate-100 hover:text-teal-600 focus:outline-none focus:ring-2 focus:ring-teal-500 dark:text-slate-400 dark:hover:bg-slate-800 dark:hover:text-teal-400">
        <x:component::icon.more-horiz />
    </button>
    <div x-show="open" x-cloak @click.outside="open = false"
        class="absolute right-0 z-20 mt-1 w-40 overflow-hidden rounded-lg border border-slate-200 bg-white py-1 shadow-lg dark:border-slate-700 dark:bg-slate-900">
        <ul>
            {{ $slot }}
        </ul>
    </div>
</div>
