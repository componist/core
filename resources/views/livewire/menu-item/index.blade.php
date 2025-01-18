<div>
    <x-slot name="header">
        <div class="flex items-center gap-1">
            <h2 class="font-semibold leading-tight">
                {{ $menu['name'] }} {{ __('Menu Items') }}
            </h2>
        </div>
    </x-slot>


    <div class="py-12">

        <div class="container px-3 mx-auto pb-14">

            <div class="flex justify-end gap-5 pb-12">
                <button wire:click="create" type="button"
                    class="flex items-center justify-center w-56 px-5 py-3 text-white border-0 rounded-md shadow-sm bg-dashboard-500 hover:text-white hover:bg-dashboard-600 default-transition">
                    Menu Item erstellen
                </button>
            </div>

            <div class="overflow-x-auto bg-white shadow md:rounded-lg">
                <div class="flex gap-3 text-sm bg-gray-100">
                    <div class="w-[50px] p-2"></div>
                    <div class="w-[350px] p-4 font-semibold text-left text-gray-700">
                        <p class="">Title</p>
                    </div>
                    <div class="p-4 font-semibold text-center text-gray-700">
                        <p>Type</p>
                    </div>
                    <div class="p-4 font-semibold text-left text-gray-700">
                        <p>Name</p>
                    </div>
                </div>


                <ul wire:sortable="reorder" wire:sortable-group="reorderChildes" class="divide-y divide-gray-200">
                    @foreach ($content as $value)
                        <li x-data="{ open: false }" class="text-gray-500 hover:bg-gray-50"
                            wire:key="group-{{ $value->id }}" wire:sortable.item="{{ $value->id }}">
                            <div class="flex items-center justify-between ">
                                <div class="flex items-center gap-3">
                                    <div class="w-[50px] flex items-center justify-center text-gray-300 cursor-pointer hover:text-dashboard-500 p-4"
                                        wire:sortable.handle>
                                        <x:component::icon.drag-indicator />
                                    </div>
                                    <div class="w-[350px] p-4">
                                        @if (count($value['children']) > 0)
                                            <button @click.prevent="open = ! open" class="flex gap-1">
                                                <span>{{ $value->title }}</span>

                                                <template x-if="open">
                                                    <x:component::icon.arrow-up class="text-dashboard-500" />
                                                </template>

                                                <template x-if="!open">
                                                    <x:component::icon.arrow-down class="text-dashboard-500" />
                                                </template>
                                            </button>
                                        @else
                                            {{ $value->title }}
                                        @endif
                                    </div>

                                    <div class="text-center">
                                        {{ $value->type }}
                                    </div>

                                    <div class="text-left">
                                        @if ($value->type == 'route' or $value->type == 'page')
                                            @if (Route::has($value->name))
                                                <a href="{{ route($value->name) }}" target="_blank"
                                                    class="hover:text-dashboard-500">{{ $value->name }}</a>
                                            @else
                                                <span class="text-sm font-bold text-red-500">Route wurde nicht
                                                    gefunden</span>
                                            @endif
                                        @endif

                                        @if ($value->type == 'url')
                                            <a href="{{ url($value->name) }}" target="_blank"
                                                class="hover:text-dashboard-500">{{ $value->name }}</a>
                                        @endif
                                    </div>

                                </div>

                                <div class="flex justify-end gap-2 p-4">

                                    <x:component::button.edit wire:click.prevent="edit({{ $value->id }})"
                                        type="button" />


                                    <x:component::element.modal>
                                        <x-slot:trigger>

                                            <x:component::button.delete @click.prevent="modal=true" />

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
                                                    {{ $value->title }} <br />unwiderruflich löschen?</h3>
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

                            @if (count($value['children']) > 0)
                                <div x-cloak x-show="open" class="border-t border-gray-200">
                                    <ul class="border-l-8 divide-y border-dashboard-500 divide-primary-300"
                                        wire:sortable-group.item-group="{{ $value->id }}">

                                        @foreach ($value->children->sortBy('order') as $children)
                                            <li class="text-gray-500 bg-dashboard-100 hover:bg-dashboard-500 hover:text-white"
                                                wire:key="children-{{ $children['id'] }}"
                                                wire:sortable-group.item="{{ $children['id'] }}">
                                                <div class="flex items-center justify-between ">
                                                    <div class="flex items-center">
                                                        <div class="w-[50px] flex items-center justify-center  cursor-pointer p-4 text-dashboard-200 hover:text-dashboard-900"
                                                            wire:sortable-group.handle>
                                                            <x:component::icon.drag-indicator />
                                                        </div>
                                                        <div class="w-[350px]  p-4">
                                                            {{ $children['title'] }}
                                                        </div>
                                                        <div class="p-4">
                                                            {{ $children['type'] }}
                                                        </div>
                                                        <div class="">
                                                            @if ($children['type'] == 'route' or $children['type'] == 'page')
                                                                @if (Route::has($children['name']))
                                                                    <a href="{{ route($children['name']) }}"
                                                                        target="_blank"
                                                                        class="hover:text-dashboard-900">{{ $children['name'] }}</a>
                                                                @else
                                                                    <span class="text-sm font-bold text-red-500">Route
                                                                        wurde
                                                                        nicht
                                                                        gefunden</span>
                                                                @endif
                                                            @endif

                                                            @if ($children['url'] == 'url')
                                                                <a href="{{ $children['name'] }}" target="_blank"
                                                                    class="hover:text-dashboard-900">{{ $children['name'] }}</a>
                                                            @endif
                                                        </div>

                                                    </div>

                                                    <div class="flex justify-end gap-2 p-4">

                                                        <x:component::button.edit
                                                            wire:click.prevent="edit({{ $children['id'] }})"
                                                            type="button" />


                                                        <x:component::element.modal>
                                                            <x-slot:trigger>

                                                                <x:component::button.delete
                                                                    @click.prevent="modal=true" />

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
                                                                        {{ $children['title'] }} <br />unwiderruflich
                                                                        löschen?</h3>
                                                                </div>
                                                            </x-slot:content>

                                                            <x-slot:controller>
                                                                <button @click.prevent="modal=false" type="button"
                                                                    class="flex justify-center w-full px-4 py-2 mr-2 font-medium text-center text-white bg-gray-300 border border-transparent rounded-md shadow-sm hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">Abbrechen</button>

                                                                <button wire:click='deleteEntry({{ $children['id'] }})'
                                                                    @click.prevent="modal=false" type="button"
                                                                    class="flex justify-center w-full px-4 py-2 font-medium text-center text-white bg-red-500 border border-transparent rounded-md shadow-sm hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">löschen</button>
                                                            </x-slot:controller>
                                                        </x:component::element.modal>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </li>
                    @endforeach
                </ul>


            </div>
        </div>

        @include('component::livewire.menu-item.edit')

    </div>
</div>
