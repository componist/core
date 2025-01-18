<div>
    <x-slot name="header">
        <div class="flex items-center gap-1">
            <h2 class="font-semibold leading-tight">
                {{ __('bearbeiten') }}
            </h2>
        </div>
    </x-slot>

    <div class="container px-5 mx-auto">
        <div class="flex justify-end gap-4 my-12">
            <button type="button" wire:click="cancel"
                class="flex items-center justify-center w-56 px-5 py-2 text-gray-500 bg-gray-300 border-0 rounded-md shadow-sm hover:text-white hover:bg-gray-500 default-transition">
                Abbrechen
            </button>

            <button type="button" wire:click="updateAndNew"
                class="flex items-center justify-center w-56 px-5 py-2 text-white border-0 rounded-md shadow-sm whitespace-nowrap bg-dashboard-500 hover:text-white hover:bg-dashboard-600 default-transition ">
                speichern & Neu
            </button>

            <button type="button" wire:click="updateAndIndex"
                class="flex items-center justify-center w-56 px-5 py-2 text-white border-0 rounded-md shadow-sm whitespace-nowrap bg-dashboard-500 hover:text-white hover:bg-dashboard-600 default-transition ">
                speichern
            </button>
        </div>

        <div class="w-full md:w-9/12">
            <div class="grid grid-cols-1 gap-5 p-5 my-12 bg-white rounded-md shadow-sm">
                <div>
                    <x:component::form.label value="Title" />
                    <x:component::form.input wire:model.live='title' type="text" />
                    <x:component::form.input-error :for="$title" />
                </div>

                <div wire:ignore>
                    <x:component::form.label value="Content" />
                    <x:component::form.textarea wire:model.live='content' />
                    <x:component::form.input-error :for="$content" />
                </div>

            </div>


        </div>
    </div>
</div>
