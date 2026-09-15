<div x-data="{ open: false }" class="px-1">
    <button x-on:click="open = ! open" type="button"
        class="flex w-full cursor-pointer items-center justify-between rounded-lg px-3 py-2 text-sm text-slate-600 transition-colors duration-200 hover:bg-slate-100 hover:text-teal-600 dark:text-slate-300 dark:hover:bg-slate-800 dark:hover:text-teal-400">
        {{ $trigger }}
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
            class="shrink-0 transition-transform duration-200" :class="open ? 'rotate-180' : ''">
            <path d="M6 9l6 6 6-6" />
        </svg>
    </button>
    <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" class="mt-1 space-y-0.5 border-l border-slate-200 pl-3 dark:border-slate-700">
        {{ $content }}
    </div>
</div>
