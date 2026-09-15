<div class="relative w-full" x-data="{ show: false }">
    <x:component::icon.lock class="material-symbols-outlined absolute left-2 top-1/4 text-slate-400 dark:text-slate-400" />

    <x:component::form.input {{ $attributes->merge(['class' => 'w-full py-2 pl-10 pr-5']) }} type="password"
        x-bind:type="show ? 'text' : 'password'" />

    <button type="button" @click.prevent="show = ! show"
        class="material-symbols-outlined absolute right-2 top-1/4 flex items-center justify-center text-slate-400 hover:text-slate-600 dark:text-slate-400 dark:hover:text-slate-200">

        <template x-if="show">
            <x:component::icon.visibility-off />
        </template>

        <template x-if="!show">
            <x:component::icon.show />
        </template>

    </button>
</div>
