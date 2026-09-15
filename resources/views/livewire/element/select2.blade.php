<div x-data="{ isOpen: false }" class="relative w-full">

    <div @click.outside="isOpen = false">
        <div @click.prevent="isOpen = ! isOpen">
            <div
                class="flex h-[42px] w-full items-center gap-1 rounded-md border border-slate-300 bg-white py-2 pl-3 pr-12 text-slate-900 shadow-sm focus:border-teal-500 focus:outline-none focus:ring-1 focus:ring-teal-500 sm:text-sm dark:border-slate-600 dark:bg-slate-800 dark:text-white">
                <span>{{ $name }}</span>
                @if (!empty($name))
                    <button wire:click.prevent="clear" type="button"
                        class="relative z-10 h-5 w-5 text-slate-300 hover:text-slate-700 dark:text-slate-500 dark:hover:text-slate-200">
                        <x:component::icon.close />
                    </button>
                @endif
            </div>

            <button type="button"
                class="absolute inset-y-0 right-0 flex items-center rounded-r-md px-2 focus:outline-none">
                <svg class="h-5 w-5 text-slate-400 dark:text-slate-400" xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
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
            class="absolute z-20 mt-2 max-h-56 w-full overflow-auto rounded-md border border-slate-200 bg-slate-100 text-base shadow-lg ring-1 ring-black/5 focus:outline-none sm:text-sm dark:border-slate-700 dark:bg-slate-800"
            id="options" role="listbox">
            <div class="sticky top-0 z-10 bg-slate-100 px-5 py-5 dark:bg-slate-800">
                <x:component::icon.search class="absolute z-10 mx-2 my-3 h-5 text-slate-400 dark:text-slate-400" />
                <x:component::form.input wire:model.live.debounce.400ms="search" wire:keydown.enter.prevent="add"
                    @keyup.enter.prevent="isOpen=false" name="search" class="bg-white py-2 pl-10 pr-5 dark:bg-slate-900"
                    autofocus />
            </div>
            <ul>
                @foreach ($list as $value)
                    <li wire:click.prevent="select(@js($value['id']),@js($value[$column]))" @click.prevent="isOpen=false"
                        class="relative flex cursor-pointer items-center justify-between border-t border-slate-300 px-5 py-3 text-slate-900 hover:bg-slate-200 dark:border-slate-600 dark:text-slate-100 dark:hover:bg-slate-700">
                        <div class="flex items-center">
                            <span class="ml-3 truncate">{{ $value[$column] }}</span>
                        </div>

                        @if ($selected == $value['id'])
                            <x:component::icon.check class="h-7 text-green-500" />
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
