<x:component::page.shell title="{{ __('Überschrift') }}">
    <x-slot:actions>
        <x:component::element.search wire:model.live.debounce.400ms="search" placeholder="Suche" />

        <x:component::button.primary href="{{ route('[name].create') }}">
            Anlegen
        </x:component::button.primary>
    </x-slot:actions>

    <x:component::table.wrapper>
        <x-slot:head>
            <x:component::table.row>
                <x:component::table.cell class="text-left font-semibold text-slate-700 dark:text-slate-200">
                    Titel
                </x:component::table.cell>
                <x:component::table.cell class="text-left font-semibold text-slate-700 dark:text-slate-200">
                    Datum
                </x:component::table.cell>
                <x:component::table.cell></x:component::table.cell>
            </x:component::table.row>
        </x-slot:head>

        <x-slot:body>
            @forelse ($content as $value)
                <x:component::table.row>
                    <x:component::table.cell class="whitespace-nowrap">
                        {{ $value->title }}
                    </x:component::table.cell>

                    <x:component::table.cell class="whitespace-nowrap">
                        {{ Carbon\Carbon::parse($value->created_at)->format('d.m.Y H:i') }}
                    </x:component::table.cell>

                    <x:component::table.cell class="text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('[name].edit', $value->id) }}">
                                <x:component::button.edit />
                            </a>

                            <x:component::element.confirm-delete wire:click="delete('{{ $value->id }}')" />
                        </div>
                    </x:component::table.cell>
                </x:component::table.row>
            @empty
                <x:component::table.row>
                    <x:component::table.cell colspan="3">
                        <x:component::page.empty title="Keine Einträge vorhanden" />
                    </x:component::table.cell>
                </x:component::table.row>
            @endforelse
        </x-slot:body>
    </x:component::table.wrapper>

    @if ($content->hasPages())
        <div class="mt-6">
            {{ $content->links('livewire::tailwind') }}
        </div>
    @endif
</x:component::page.shell>
