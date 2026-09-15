<x:component::page.shell title="Menüpunkte" description="{{ $menu['name'] }}">
    <x-slot:actions>
        <x:component::button.primary wire:click="create" type="button">
            Menüpunkt erstellen
        </x:component::button.primary>
    </x-slot:actions>

    <div
        class="overflow-x-auto rounded-lg border border-slate-200 bg-white shadow-sm dark:border-slate-700 dark:bg-slate-900 md:rounded-lg">
        <div class="flex gap-3 bg-slate-100 text-sm dark:bg-slate-800">
            <div class="w-[50px] p-4"></div>
            <div class="w-[350px] p-4 text-left font-semibold text-slate-700 dark:text-slate-200">
                <p>Titel</p>
            </div>
            <div class="p-4 text-center font-semibold text-slate-700 dark:text-slate-200">
                <p>Status</p>
            </div>
            <div class="p-4 text-center font-semibold text-slate-700 dark:text-slate-200">
                <p>Typ</p>
            </div>
            <div class="p-4 text-left font-semibold text-slate-700 dark:text-slate-200">
                <p>Name / Dateipfad</p>
            </div>
        </div>

        <ul wire:sortable="reorder" wire:sortable-group="reorderChildes"
            class="divide-y divide-slate-200 dark:divide-slate-700">
            @forelse ($content as $value)
                <li x-data="{ open: false }"
                    class="text-slate-500 hover:bg-slate-50 dark:text-slate-300 dark:hover:bg-slate-800/60"
                    wire:key="group-{{ $value['id'] }}" wire:sortable.item="{{ $value['id'] }}">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="flex w-[50px] cursor-pointer items-center justify-center p-4 text-slate-300 hover:text-teal-500 dark:text-slate-500"
                                wire:sortable.handle>
                                <x:component::icon.drag-indicator />
                            </div>
                            <div class="w-[350px] p-4">
                                @if (count($value['children']) > 0)
                                    <button @click.prevent="open = ! open" class="flex gap-1" type="button">
                                        <span>{{ $value['title'] }}</span>

                                        <template x-if="open">
                                            <x:component::icon.arrow-up class="text-teal-500" />
                                        </template>

                                        <template x-if="!open">
                                            <x:component::icon.arrow-down class="text-teal-500" />
                                        </template>
                                    </button>
                                @else
                                    {{ $value['title'] }}
                                @endif
                            </div>
                            <div class="p-4 text-center font-semibold text-slate-700 dark:text-slate-200">
                                <x:component::form.toggle wire:change="toggle({{ $value['id'] }},'status')"
                                    status="{{ $value['status'] }}" />
                            </div>

                            <div class="text-center">
                                @switch($value['type'])
                                    @case('page')
                                        <span
                                            class="inline-block w-16 rounded-full bg-yellow-500 py-1 text-center text-xs text-white">{{ $value['type'] }}</span>
                                    @break

                                    @case('parent')
                                        <span
                                            class="inline-block w-16 rounded-full bg-green-500 py-1 text-center text-xs text-white">{{ $value['type'] }}</span>
                                    @break

                                    @case('route')
                                        <span
                                            class="inline-block w-16 rounded-full bg-blue-500 py-1 text-center text-xs text-white">{{ $value['type'] }}</span>
                                    @break

                                    @case('url')
                                        <span
                                            class="inline-block w-16 rounded-full bg-orange-500 py-1 text-center text-xs text-white">{{ $value['type'] }}</span>
                                    @break

                                    @default
                                        <span
                                            class="inline-block w-16 rounded-full bg-red-500 py-1 text-center text-xs text-white">{{ $value['type'] }}</span>
                                @endswitch
                            </div>

                            <div class="p-4 text-left">
                                @php($href = componist_menu_href($value))
                                @if ($href)
                                    <a href="{{ $href }}" target="_blank"
                                        class="hover:text-teal-500">{{ $value['type'] === 'url' ? $value['name'] : ($value['name'] ?? $value['view_path']) }}</a>
                                @else
                                    @if ($value['type'] == 'route' or $value['type'] == 'page')
                                        <span class="text-sm font-bold text-red-500">Route wurde nicht
                                            gefunden</span>
                                    @endif
                                @endif
                            </div>
                        </div>

                        <div class="flex justify-end gap-2 p-4">
                            <x:component::button.edit wire:click.prevent="edit({{ $value['id'] }})"
                                type="button" />
                            <x:component::element.confirm-delete wire:click="deleteEntry({{ $value['id'] }})" />
                        </div>
                    </div>

                    @if (count($value['children']) > 0)
                        <div x-cloak x-show="open" class="border-t border-slate-200 dark:border-slate-700">
                            <ul class="divide-y divide-slate-200 border-l-8 border-teal-500 dark:divide-slate-700"
                                wire:sortable-group.item-group="{{ $value['id'] }}">
                                @foreach ($value->children->sortBy('order') as $children)
                                    <li class="bg-teal-50 text-slate-600 hover:bg-teal-500 hover:text-white dark:bg-teal-950/40 dark:text-slate-300 dark:hover:bg-teal-600 dark:hover:text-white"
                                        wire:key="children-{{ $children['id'] }}"
                                        wire:sortable-group.item="{{ $children['id'] }}">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center">
                                                <div class="flex w-[50px] cursor-pointer items-center justify-center p-4 text-teal-300 hover:text-teal-900 dark:text-teal-400 dark:hover:text-white"
                                                    wire:sortable-group.handle>
                                                    <x:component::icon.drag-indicator />
                                                </div>
                                                <div class="w-[350px] p-4">
                                                    {{ $children['title'] }}
                                                </div>
                                                <div class="p-4">
                                                    @switch($children['type'])
                                                        @case('page')
                                                            <span
                                                                class="inline-block w-16 rounded-full bg-yellow-500 py-1 text-center text-xs text-white">{{ $children['type'] }}</span>
                                                        @break

                                                        @case('parent')
                                                            <span
                                                                class="inline-block w-16 rounded-full bg-green-500 py-1 text-center text-xs text-white">{{ $children['type'] }}</span>
                                                        @break

                                                        @case('route')
                                                            <span
                                                                class="inline-block w-16 rounded-full bg-blue-500 py-1 text-center text-xs text-white">{{ $children['type'] }}</span>
                                                        @break

                                                        @case('url')
                                                            <span
                                                                class="inline-block w-16 rounded-full bg-orange-500 py-1 text-center text-xs text-white">{{ $children['type'] }}</span>
                                                        @break

                                                        @default
                                                            <span
                                                                class="inline-block w-16 rounded-full bg-red-500 py-1 text-center text-xs text-white">{{ $children['type'] }}</span>
                                                    @endswitch
                                                </div>
                                                <div class="p-4">
                                                    @php($childHref = componist_menu_href($children))
                                                    @if ($childHref)
                                                        <a href="{{ $childHref }}" target="_blank"
                                                            class="hover:text-teal-900 dark:hover:text-white">{{ $children['type'] === 'url' ? $children['name'] : ($children['name'] ?? $children['view_path']) }}</a>
                                                    @else
                                                        @if ($children['type'] == 'route' or $children['type'] == 'page')
                                                            <span class="text-sm font-bold text-red-500">Route
                                                                wurde nicht gefunden</span>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="flex justify-end gap-2 p-4">
                                                <x:component::button.edit
                                                    wire:click.prevent="edit({{ $children['id'] }})"
                                                    type="button" />
                                                <x:component::element.confirm-delete
                                                    wire:click="deleteEntry({{ $children['id'] }})" />
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </li>
            @empty
                <li class="px-6 py-10 text-center text-slate-500 dark:text-slate-400">
                    Noch keine Menüpunkte vorhanden. Erstelle den ersten Eintrag oben rechts.
                </li>
            @endforelse
        </ul>
    </div>

    @include('component::livewire.menu-item.edit')
</x:component::page.shell>
