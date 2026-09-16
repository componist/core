<div class="relative w-full" x-data="{ show: false }">
    <x:component::icon.lock
        class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400 dark:text-slate-500"
    />

    <x:component::form.input
        {{ $attributes->merge(['class' => 'pl-10 pr-10']) }}
        type="password"
        x-bind:type="show ? 'text' : 'password'"
        autocomplete="current-password"
    />

    <button
        type="button"
        @click.prevent="show = ! show"
        class="absolute right-2 top-1/2 flex h-7 w-7 -translate-y-1/2 items-center justify-center rounded-md text-slate-400 transition-colors hover:bg-slate-100 hover:text-slate-600 focus:outline-none focus:ring-2 focus:ring-teal-500/30 dark:text-slate-500 dark:hover:bg-slate-700 dark:hover:text-slate-200"
        :aria-label="show ? 'Passwort verbergen' : 'Passwort anzeigen'"
    >
        <template x-if="show">
            <x:component::icon.visibility-off class="h-4 w-4" />
        </template>

        <template x-if="!show">
            <x:component::icon.show class="h-4 w-4" />
        </template>
    </button>
</div>
