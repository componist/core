<x:component::page.shell title="Benachrichtigung">
    <x-slot:actions>
        <x:component::element.search wire:model.live.debounce.400ms="search" placeholder="Suche" />
    </x-slot:actions>

    <div wire:poll.90s>
        <x:component::table.wrapper>
            <x-slot:head>
                <x:component::table.row>
                    <x:component::table.cell class="text-left font-semibold text-slate-700 dark:text-slate-200">
                        Titel
                    </x:component::table.cell>
                    <x:component::table.cell class="text-left font-semibold text-slate-700 dark:text-slate-200">
                        Erhalten
                    </x:component::table.cell>
                    <x:component::table.cell></x:component::table.cell>
                </x:component::table.row>
            </x-slot:head>

            <x-slot:body>
                @foreach ($content as $value)
                    <x:component::table.row class="hover:bg-slate-50 dark:hover:bg-slate-800/60">
                        <x:component::table.cell class="text-left text-slate-500 dark:text-slate-300">
                            <a href="{{ route('componist.core.notification.show', $value->id) }}"
                                class="hover:text-teal-500">
                                @if ($value->read)
                                    <span class="font-bold text-slate-400 dark:text-slate-500">{{ $value->title }}</span>
                                @else
                                    <span class="font-bold text-teal-500">{{ $value->title }}</span>
                                @endif
                            </a>
                        </x:component::table.cell>

                        <x:component::table.cell class="text-left text-slate-500 dark:text-slate-300">
                            {{ $value->created_at->format('d.m.Y H:i:s') }}
                        </x:component::table.cell>

                        <x:component::table.cell>
                            <div class="flex justify-end gap-2">
                                <x:component::element.confirm-delete wire:click="delete({{ $value->id }})" />
                            </div>
                        </x:component::table.cell>
                    </x:component::table.row>
                @endforeach
            </x-slot:body>
        </x:component::table.wrapper>

        @if ($content->hasPages())
            <div class="mt-6">
                {{ $content->links('livewire::tailwind') }}
            </div>
        @endif
    </div>
</x:component::page.shell>
