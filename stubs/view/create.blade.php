<x:component::page.form title="{{ __('Eintrag anlegen') }}">
    <x-slot:actions>
        <x:component::button.secondary wire:click="cancel">
            Abbrechen
        </x:component::button.secondary>

        <x:component::button.secondary wire:click="storeAndNew">
            Speichern & Neu
        </x:component::button.secondary>

        <x:component::button.primary wire:click="storeAndIndex">
            Speichern
        </x:component::button.primary>
    </x-slot:actions>

    <div>
        <x:component::form.label value="Titel" />
        <x:component::form.input wire:model.live="title" type="text" />
        <x:component::form.input-error for="title" />
    </div>

    <div>
        <x:component::form.label value="Inhalt" />
        <x:component::form.textarea wire:model.live="content" />
        <x:component::form.input-error for="content" />
    </div>
</x:component::page.form>
