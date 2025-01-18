<div>
    <x-slot name="header">
        <div class="flex items-center gap-1">
            <x:component::icon.setting class="h-12" />
            <h2 class="font-semibold leading-tight">
                {{ __('Settings') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="container px-3 mx-auto pb-14">

            @if (!empty($content))

                <div class="" x-data="{ tab: '{{ array_key_first($content->toArray()) }}' }">
                    <div class="flex overflow-x-auto flex-nowrap">
                        <ul class="flex gap-2">
                            @foreach ($content as $key => $value)
                                <li @click.prevent="tab = '{{ $key }}'"
                                    class="block py-3 font-semibold text-center  cursor-pointer w-52 rounded-t-md hover:bg-gray-50"
                                    :class="{
                                    
                                    
                                        'bg-gray-100 text-teal-500': tab === '{{ $key }}',
                                        'text-gray-500 bg-gray-300': tab != '{{ $key }}'
                                    
                                    }">
                                    {{ $key }}
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="px-7 mb-12 bg-gray-100 rounded-tr-md rounded-br-md rounded-bl-md py-7">

                        @foreach ($content as $key => $setting)
                            <div x-show="tab === '{{ $key }}'">
                                <div class="grid grid-cols-1 gap-7">
                                    @if (!empty($setting))
                                        @foreach ($setting as $value)
                                            <div class="bg-white rounded-md shadow-sm p-7">
                                                <div class="flex items-center justify-between gap-5 px-2 mb-5">
                                                    <div class="flex items-center gap-5 ">
                                                        <h3 class="font-bold">{{ $value->display_name }}</h3>
                                                        <code
                                                            class="px-3 py-1 text-sm text-white bg-dashboard-500 rounded-full cursor-pointer hover:bg-dashboard-600">setting('{{ $value->key }}')</code>
                                                    </div>
                                                    <div class="flex justify-end gap-5">
                                                        <x:component::element.modal>
                                                            <x-slot:trigger>

                                                                <button @click.prevent="modal=true" type="button">
                                                                    <x:component::icon.delete
                                                                        class="text-gray-300 hover:text-gray-700" />
                                                                </button>

                                                            </x-slot:trigger>

                                                            <x-slot:content>
                                                                <div class="flex justify-center ">
                                                                    <div
                                                                        class="flex items-center justify-center text-red-500 bg-red-200 rounded-full shadow-sm w-28 h-28">
                                                                        <x:component::icon.delete class="h-16" />
                                                                    </div>
                                                                </div>
                                                                <div class="flex justify-center mt-7">
                                                                    <h3
                                                                        class="text-lg font-bold text-center text-gray-700">
                                                                        {{ $value->display_name }} <br />unwiderruflich
                                                                        löschen?
                                                                    </h3>
                                                                </div>
                                                            </x-slot:content>

                                                            <x-slot:controller>
                                                                <button @click.prevent="modal=false" type="button"
                                                                    class="flex justify-center w-full px-4 py-2 mr-2 font-medium text-center text-white bg-gray-300 border border-transparent rounded-md shadow-sm hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">Abbrechen</button>

                                                                <button wire:click='deleteEntry({{ $value->id }})'
                                                                    @click.prevent="modal=false" type="button"
                                                                    class="flex justify-center w-full px-4 py-2 font-medium text-center text-white bg-red-500 border border-transparent rounded-md shadow-sm hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">löschen</button>
                                                            </x-slot:controller>
                                                        </x:component::element.modal>
                                                    </div>
                                                </div>
                                                <div class="">
                                                    @if ($value->type == 'text')
                                                        <x:component::form.input
                                                            wire:keydown.debounce.500ms="input($event.target.value, {{ $value->id }})"
                                                            type="text" value="{{ $value->value }}" />

                                                        <x:component::action-message class="mr-3"
                                                            on="saved{{ $value->id }}">
                                                            {{ __('Saved.') }}
                                                        </x:component::action-message>
                                                    @endif

                                                    @if ($value->type == 'text_area')
                                                        <x:component::form.textarea
                                                            wire:keydown.debounce.500ms="input($event.target.value, {{ $value->id }})"
                                                            value="{{ $value->value }}" />

                                                        <x:component::action-message class="mr-3"
                                                            on="saved{{ $value->id }}">
                                                            {{ __('Saved.') }}
                                                        </x:component::action-message>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <p>Noch kein Eintrag vorhanden.</p>
                                    @endif

                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
                {{-- <div class="grid grid-cols-1 mb-12 gap-7">
                    @foreach ($content as $value)


                        <div class="bg-white rounded-md shadow-sm p-7">
                            <div class="flex items-center justify-between gap-5 px-2 mb-5">
                                <div class="flex items-center gap-5 ">
                                    <h3 class="font-bold">{{ $value->display_name }}</h3>
                                    <code
                                        class="px-3 py-1 text-sm text-white bg-dashboard-500 rounded-full cursor-pointer hover:bg-dashboard-600">setting('{{ $value->key }}')</code>
                                </div>
                                <div class="flex justify-end gap-5">
                                    <x:component::element.modal>
                                        <x-slot:trigger>

                                            <button @click.prevent="modal=true" type="button">
                                                <x:component::icon.delete class="text-gray-300 hover:text-gray-700" />
                                            </button>

                                        </x-slot:trigger>

                                        <x-slot:content>
                                            <div class="flex justify-center ">
                                                <div
                                                    class="flex items-center justify-center text-red-500 bg-red-200 rounded-full shadow-sm w-28 h-28">
                                                    <x:component::icon.delete class="h-16" />
                                                </div>
                                            </div>
                                            <div class="flex justify-center mt-7">
                                                <h3 class="text-lg font-bold text-center text-gray-700">
                                                    {{ $value->display_name }} <br />unwiderruflich löschen?</h3>
                                            </div>
                                        </x-slot:content>

                                        <x-slot:controller>
                                            <button @click.prevent="modal=false" type="button"
                                                class="flex justify-center w-full px-4 py-2 mr-2 font-medium text-center text-white bg-gray-300 border border-transparent rounded-md shadow-sm hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">Abbrechen</button>

                                            <button wire:click='deleteEntry({{ $value->id }})'
                                                @click.prevent="modal=false" type="button"
                                                class="flex justify-center w-full px-4 py-2 font-medium text-center text-white bg-red-500 border border-transparent rounded-md shadow-sm hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">löschen</button>
                                        </x-slot:controller>
                                    </x:component::element.modal>
                                </div>
                            </div>
                            <div class="">
                                @if ($value->type == 'text')
                                    <x:component::form.input
                                        wire:keydown.debounce.500ms="input($event.target.value, {{ $value->id }})"
                                        type="text" value="{{ $value->value }}" />

                                    <x:component::action-message class="mr-3" on="saved{{ $value->id }}">
                                        {{ __('Saved.') }}
                                    </x:component::action-message>
                                @endif

                                @if ($value->type == 'text_area')
                                    <x:component::form.textarea
                                        wire:keydown.debounce.500ms="input($event.target.value, {{ $value->id }})"
                                        value="{{ $value->value }}" />

                                    <x:component::action-message class="mr-3" on="saved{{ $value->id }}">
                                        {{ __('Saved.') }}
                                    </x:component::action-message>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div> --}}
            @endif


            <div class="">
                <h3 class="font-bold text-center text-gray-500 mb-7">Neue Einstellung</h3>
                <div class="grid grid-cols-4 gap-4 bg-white rounded-md p-7">
                    <div class="">
                        <x:component::form.label value="Name" />
                        <x:component::form.input wire:model.live="display_name" type="text" name="display_name"
                            placeholder="Einstellungs-Name z.B. Site Titel" required />
                        <x:component::form.input-error :for="$display_name" />
                    </div>

                    <div class="">
                        <x:component::form.label value="Key" />
                        <x:component::form.input wire:model.live="key" type="text" name="key"
                            placeholder="Einstellungs-Schlüssel z.B. title" required />
                        <x:component::form.input-error :for="$key" />
                    </div>

                    <div class="">
                        <x:component::form.label value="Type" />
                        <x:component::form.select wire:model.live="type" name="type" required>
                            <x:component::form.select-option name="" value="Typ auswählen" />
                            <x:component::form.select-option name="text" value="Text Input" />
                            <x:component::form.select-option name="text_area" value="Text Area" />
                        </x:component::form.select>
                        <x:component::form.input-error :for="$type" />
                    </div>

                    <div class="">
                        <x:component::form.label value="Gruppe" />
                        <x:component::form.select wire:model.live="group" name="group" required>
                            <x:component::form.select-option name="" value="Bestehende Gruppe auswählen" />
                            <x:component::form.select-option name="site" value="Site" />
                            <x:component::form.select-option name="admin" value="Admin" />
                        </x:component::form.select>
                        <x:component::form.input-error :for="$group" />
                    </div>
                </div>
                <div class="flex justify-end gap-4 mt-7">
                    <button wire:click="createNewSettingEntry" type="button"
                        class="w-56 px-5 py-2 text-center text-white bg-dashboard-500 rounded-md hover:bg-dashboard-600">Erstellen</button>
                </div>
            </div>

        </div>
    </div>
</div>
