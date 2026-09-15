<x:component::page.shell title="Menüs">
    <x-slot:actions>
        <x:component::button.primary wire:click="create" type="button">
            Menü erstellen
        </x:component::button.primary>
    </x-slot:actions>

    <x:component::table.wrapper>
        <x-slot:head>
            <x:component::table.row>
                <x:component::table.cell class="w-3/12 text-left font-semibold text-slate-700 dark:text-slate-200">
                    Name
                </x:component::table.cell>
                <x:component::table.cell class="w-3/12 text-left font-semibold text-slate-700 dark:text-slate-200">
                    Snippet
                </x:component::table.cell>
                <x:component::table.cell></x:component::table.cell>
            </x:component::table.row>
        </x-slot:head>

        <x-slot:body>
            @forelse ($content as $value)
                <x:component::table.row class="hover:bg-slate-50 dark:hover:bg-slate-800/60">
                    <x:component::table.cell class="text-slate-500 dark:text-slate-300">
                        {{ $value->name }}
                    </x:component::table.cell>

                    <x:component::table.cell>
                        <code
                            class="cursor-pointer rounded-full bg-teal-500 px-3 py-1 text-sm text-white hover:bg-teal-600">menu('{{ $value->name }}')</code>
                    </x:component::table.cell>

                    <x:component::table.cell>
                        <div class="flex justify-end gap-2">
                            <a href="{{ route('componist.core.menu.items', $value->id) }}"
                                class="flex h-9 w-9 items-center justify-center rounded-md border-2 border-teal-500 text-teal-500 shadow-sm transition hover:bg-teal-500 hover:text-white">
                                <x:component::icon.list />
                            </a>

                            <x:component::button.edit wire:click.prevent="edit({{ $value->id }})" type="button" />

                            <x:component::element.confirm-delete wire:click="deleteEntry({{ $value->id }})" />
                        </div>
                    </x:component::table.cell>
                </x:component::table.row>
            @empty
                <x:component::table.row>
                    <x:component::table.cell colspan="3" class="py-10 text-center text-slate-500 dark:text-slate-400">
                        Noch keine Menüs vorhanden. Erstelle das erste Menü oben rechts.
                    </x:component::table.cell>
                </x:component::table.row>
            @endforelse
        </x-slot:body>
    </x:component::table.wrapper>

    @include('component::livewire.menu.edit')
</x:component::page.shell>
