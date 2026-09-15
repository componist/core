<x:component::page.shell title="Einstellungen">
    @if (!empty($content))
        <div x-data="{ tab: '{{ array_key_first($content) }}' }">
            <div class="flex overflow-x-auto flex-nowrap">
                <ul class="flex gap-2">
                    @foreach ($content as $key => $value)
                        <li @click.prevent="tab = '{{ $key }}'"
                            class="block w-52 cursor-pointer rounded-t-md py-3 text-center font-semibold hover:bg-slate-50 dark:hover:bg-slate-800"
                            :class="{
                                'bg-slate-100 text-teal-500 dark:bg-slate-800': tab === '{{ $key }}',
                                'bg-slate-300 text-slate-500 dark:bg-slate-700 dark:text-slate-300': tab != '{{ $key }}'
                            }">
                            {{ $key }}
                        </li>
                    @endforeach
                </ul>
            </div>

            <div
                class="mb-12 rounded-tr-md rounded-br-md rounded-bl-md bg-slate-100 px-7 py-7 dark:bg-slate-800">
                @foreach ($content as $key => $setting)
                    <div x-show="tab === '{{ $key }}'">
                        <div class="grid grid-cols-1 gap-7">
                            @if (!empty($setting))
                                @foreach ($setting as $value)
                                    <div
                                        class="rounded-md border border-slate-200 bg-white p-7 shadow-sm dark:border-slate-700 dark:bg-slate-900">
                                        <div class="mb-5 flex items-center justify-between gap-5 px-2">
                                            <div class="items-center gap-5 md:flex">
                                                <h3 class="font-bold text-slate-900 dark:text-white">
                                                    {{ $value['display_name'] }}</h3>
                                                <code
                                                    class="cursor-pointer rounded-full bg-teal-500 px-3 py-1 text-sm text-white hover:bg-teal-600">setting('{{ $value['key'] }}')</code>
                                            </div>
                                            <div class="flex justify-end gap-5">
                                                <x:component::element.confirm-delete
                                                    wire:click="deleteEntry({{ $value['id'] }})" />
                                            </div>
                                        </div>
                                        <div>
                                            @if ($value['type'] == 'text')
                                                <x:component::form.input
                                                    wire:keydown.debounce.500ms="input($event.target.value, {{ $value['id'] }})"
                                                    type="text" value="{{ $value['value'] }}" />

                                                <x:component::action-message class="mr-3"
                                                    on="saved{{ $value['id'] }}">
                                                    Gespeichert.
                                                </x:component::action-message>
                                            @endif

                                            @if ($value['type'] == 'text_area')
                                                <x:component::form.textarea
                                                    wire:keydown.debounce.500ms="input($event.target.value, {{ $value['id'] }})"
                                                    value="{{ $value['value'] }}" />

                                                <x:component::action-message class="mr-3"
                                                    on="saved{{ $value['id'] }}">
                                                    Gespeichert.
                                                </x:component::action-message>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <p class="text-slate-500 dark:text-slate-400">Noch kein Eintrag vorhanden.</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <p class="mb-10 text-center text-slate-500 dark:text-slate-400">
            Noch keine Einstellungen vorhanden. Lege unten die erste Einstellung an.
        </p>
    @endif

    <div>
        <h3 class="mb-7 text-center font-bold text-slate-500 dark:text-slate-300">Neue Einstellung</h3>
        <div
            class="grid grid-cols-1 gap-4 rounded-md border border-slate-200 bg-white p-7 dark:border-slate-700 dark:bg-slate-900 md:grid-cols-4">
            <div>
                <x:component::form.label value="Name" />
                <x:component::form.input wire:model.live="display_name" type="text" name="display_name"
                    placeholder="Einstellungs-Name z.B. Site Titel" required />
                <x:component::form.input-error :for="$display_name" />
            </div>

            <div>
                <x:component::form.label value="Key" />
                <x:component::form.input wire:model.live="key" type="text" name="key"
                    placeholder="Einstellungs-Schlüssel z.B. title" required />
                <x:component::form.input-error :for="$key" />
            </div>

            <div>
                <x:component::form.label value="Type" />
                <x:component::form.select wire:model.live="type" name="type" required>
                    <x:component::form.select-option name="" value="Typ auswählen" />
                    <x:component::form.select-option name="text" value="Text Input" />
                    <x:component::form.select-option name="text_area" value="Text Area" />
                </x:component::form.select>
                <x:component::form.input-error :for="$type" />
            </div>

            <div>
                <x:component::form.label value="Gruppe" />
                <x:component::form.select wire:model.live="group" name="group" required>
                    <x:component::form.select-option name="" value="Bestehende Gruppe auswählen" />
                    <x:component::form.select-option name="Site" value="Site" />
                    <x:component::form.select-option name="Admin" value="Admin" />
                </x:component::form.select>
                <x:component::form.input-error :for="$group" />
            </div>
        </div>
        <div class="mt-7 flex justify-center gap-4 md:justify-end">
            <x:component::button.primary wire:click="createNewSettingEntry" type="button" class="w-56">
                Erstellen
            </x:component::button.primary>
        </div>
    </div>

    <div class="mt-14">
        @livewire('setting.test-mail-notification')
    </div>
</x:component::page.shell>
