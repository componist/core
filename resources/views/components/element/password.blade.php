<div class="relative w-full" x-data="{ show: false }">
    <x:component::icon.lock class="absolute text-gray-400 material-symbols-outlined left-2 top-1/4" />

    <x:component::form.input {{ $attributes->merge(['class' => 'w-full py-2 pl-10 pr-5']) }} type="password"
        x-bind:type="show ? 'text' : 'password'" />

    <button type="button" @click.prevent="show = ! show"
        class="absolute flex items-center justify-center text-gray-400 material-symbols-outlined right-2 top-1/4">

        <template x-if="show">
            <x:component::icon.visibility-off />
        </template>

        <template x-if="!show">
            <x:component::icon.show />
        </template>

    </button>
</div>
