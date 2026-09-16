@php
    use Componist\Core\Support\Ui;
@endphp

<div x-data="{ isOpen: false }" class="relative w-full">

    <div @click.outside="isOpen = false">
        <div @click.prevent="isOpen = ! isOpen" class="relative">
            <div class="{{ Ui::FIELD }} flex cursor-pointer items-center gap-1.5 pr-10">
                <span class="truncate" @class(['text-slate-400 dark:text-slate-500' => empty($name)])>
                    {{ $name ?: 'Auswählen…' }}
                </span>
                @if (!empty($name))
                    <button wire:click.prevent="clear" type="button"
                        class="relative z-10 flex h-6 w-6 shrink-0 items-center justify-center rounded-md text-slate-400 transition-colors hover:bg-slate-100 hover:text-slate-700 dark:text-slate-500 dark:hover:bg-slate-700 dark:hover:text-slate-200">
                        <x:component::icon.close class="h-4 w-4" />
                    </button>
                @endif
            </div>

            <button type="button"
                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3"
                tabindex="-1"
                aria-hidden="true">
                <svg class="h-5 w-5 text-slate-400 dark:text-slate-500" xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                        clip-rule="evenodd"></path>
                </svg>
            </button>
        </div>

        <div x-show="isOpen" x-trap="isOpen" x-cloak x-transition:enter="transition ease-out duration-100 transform"
            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-75 transform"
            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
            class="{{ Ui::DROPDOWN }} absolute z-20 mt-2 max-h-56 w-full overflow-auto text-sm focus:outline-none"
            id="options" role="listbox">
            <div class="sticky top-0 z-10 border-b border-slate-200 bg-white px-3 py-3 dark:border-slate-700 dark:bg-slate-800">
                <div class="relative">
                    <x:component::icon.search
                        class="pointer-events-none absolute left-3 top-1/2 z-10 h-4 w-4 -translate-y-1/2 text-slate-400 dark:text-slate-500" />
                    <x:component::form.input
                        wire:model.live.debounce.400ms="search"
                        wire:keydown.enter.prevent="add"
                        @keyup.enter.prevent="isOpen=false"
                        name="search"
                        class="pl-10"
                        autofocus
                        placeholder="Suchen…"
                    />
                </div>
            </div>
            <ul>
                @foreach ($list as $value)
                    <li wire:click.prevent="select(@js($value['id']),@js($value[$column]))" @click.prevent="isOpen=false"
                        class="relative flex cursor-pointer items-center justify-between border-t border-slate-200 px-4 py-2.5 text-slate-900 first:border-t-0 hover:bg-slate-50 dark:border-slate-700 dark:text-slate-100 dark:hover:bg-slate-700/80">
                        <span class="truncate">{{ $value[$column] }}</span>

                        @if ($selected == $value['id'])
                            <x:component::icon.check class="h-5 w-5 shrink-0 text-teal-500" />
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
