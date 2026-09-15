<div x-data="{ modal: false }">

    {{ $trigger }}

    <div x-show="modal" x-cloak x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 px-5 backdrop-blur-sm">
        <div @click.outside="modal=false"
            class="w-full max-w-md overflow-hidden rounded-lg border border-slate-200 bg-white shadow-lg dark:border-slate-700 dark:bg-slate-900">
            <div class="px-5 py-6">
                {{ $content }}
            </div>

            <div class="grid grid-cols-2 gap-3 border-t border-slate-200 bg-slate-50 px-4 py-4 dark:border-slate-700 dark:bg-slate-800/60">
                {{ $controller }}
            </div>
        </div>
    </div>
</div>
