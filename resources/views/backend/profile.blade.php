<x:component::layouts.dashboard>
    <x:component::page.shell title="Profil" description="Deine Kontodaten in diesem Arbeitsbereich.">
        <div class="dash-enter overflow-hidden rounded-lg border border-slate-200 bg-white dark:border-slate-700 dark:bg-slate-900">
            <div class="border-b border-slate-200 bg-gradient-to-r from-teal-500/10 via-transparent to-transparent px-6 py-5 dark:border-slate-800">
                <div class="flex items-center gap-4">
                    <span class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-teal-500 text-base font-semibold text-white">
                        {{ mb_substr(auth()->user()?->name ?? 'U', 0, 1) }}
                    </span>
                    <div class="min-w-0">
                        <p class="truncate text-lg font-semibold tracking-tight text-slate-900 dark:text-white">
                            {{ auth()->user()?->name }}
                        </p>
                        <p class="truncate text-sm text-slate-600 dark:text-slate-300">
                            {{ auth()->user()?->email }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="space-y-2 p-6 text-sm text-slate-600 dark:text-slate-300">
                <p>Angemeldet als <span class="font-medium text-slate-900 dark:text-white">{{ auth()->user()?->name }}</span>.</p>
                <p>Änderungen am Konto erfolgen über den User-Manager, sofern freigeschaltet.</p>
            </div>
        </div>
    </x:component::page.shell>
</x:component::layouts.dashboard>
