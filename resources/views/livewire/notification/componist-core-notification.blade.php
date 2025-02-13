<div>
    <x-slot name="header">
        <div class="flex items-center gap-1">
            <h2 class="font-semibold leading-tight">
                Benachrichtigung
            </h2>
        </div>
    </x-slot>

    <div wire:poll.90s class="py-12">

        <div class="container px-3 mx-auto pb-14">

            <div class="flex justify-end gap-5 my-12">
                <x:component::element.search wire:model.live.debounce="search" placeholder="Suche" />
            </div>


            <div class="overflow-x-auto bg-white shadow md:rounded-lg">
                <x:component::table.wrapper>
                    <x-slot:head>
                        <x:component::table.row>
                            <x:component::table.cell class="font-semibold text-left text-gray-700">Title
                            </x:component::table.cell>

                            <x:component::table.cell class="font-semibold text-left text-gray-700">Erhalten
                            </x:component::table.cell>


                            <x:component::table.cell></x:component::table.cell>
                        </x:component::table.row>
                    </x-slot:head>

                    <x-slot:body>
                        @foreach ($content as $value)
                            <x:component::table.row class="hover:bg-gray-50">

                                <x:component::table.cell class="text-left text-gray-500">
                                    <a href="{{ route('componist.core.notification.show', $value->id) }}"
                                        class="hover:text-teal-500">
                                        @if ($value->read)
                                            <span class="font-bold text-gray-400">{{ $value->title }}</span>
                                        @else
                                            <span class="font-bold text-teal-500">{{ $value->title }}</span>
                                        @endif
                                    </a>
                                </x:component::table.cell>

                                <x:component::table.cell class="text-left text-gray-500">
                                    {{ $value->created_at->format('d.m.Y H:i:s') }}
                                </x:component::table.cell>


                                <x:component::table.cell class="flex justify-end gap-2">

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
                                                    Eintrag unwiderruflich löschen?</h3>
                                            </div>
                                        </x-slot:content>

                                        <x-slot:controller>
                                            <button @click.prevent="modal=false" type="button"
                                                class="flex justify-center w-full px-4 py-2 mr-2 font-medium text-center text-white bg-gray-300 border border-transparent rounded-md shadow-sm hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">Abbrechen</button>

                                            <button wire:click='delete({{ $value->id }})'
                                                @click.prevent="modal=false" type="button"
                                                class="flex justify-center w-full px-4 py-2 font-medium text-center text-white bg-red-500 border border-transparent rounded-md shadow-sm hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">löschen</button>
                                        </x-slot:controller>
                                    </x:component::element.modal>

                                </x:component::table.cell>

                            </x:component::table.row>
                        @endforeach
                    </x-slot:body>

                </x:component::table.wrapper>
            </div>

        </div>

        @if ($content->hasPages())
            <div class="container mx-auto mt-10">
                {{ $content->links('livewire::tailwind') }}
            </div>
        @endif


    </div>
</div>
