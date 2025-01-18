<div x-data="{ isOpen: false }" class="relative w-full">

    <div @click.outside="isOpen = false">
        <div @click.prevent="isOpen = ! isOpen">
            <div
                class="flex items-center w-full gap-1 py-2 h-[42px] pl-3 pr-12 bg-white border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 sm:text-sm">
                <span>{{ $name }}</span>
                @if (!empty($name))
                    <button wire:click.prevent="clear" type="button"
                        class="relative z-10 w-5 h-5 text-gray-300 hover:text-gray-700">
                        <x:component::icon.close />
                    </button>
                @endif
            </div>

            <button type="button"
                class="absolute inset-y-0 right-0 flex items-center px-2 rounded-r-md focus:outline-none">
                <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                    fill="currentColor" aria-hidden="true">
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
            class="absolute z-20 w-full mt-2 overflow-auto text-base bg-gray-200 rounded-md shadow-lg max-h-56 ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm"
            id="options" role="listbox">
            <div class="sticky top-0 z-10 px-5 py-5 bg-gray-200">
                <x:component::icon.search class="absolute z-10 h-5 my-3 mx-2 text-gray-400" />
                <x:component::form.input wire:model.live="search" wire:keydown.enter.prevent="add"
                    @keyup.enter.prevent="isOpen=false" name="search" class="py-2 pl-10 pr-5 bg-white" autofocus />
            </div>
            <ul>
                @foreach ($list as $value)
                    <li wire:click.prevent="select({{ $value['id'] }},'{{ $value[$column] }}')"
                        @click.prevent="isOpen=false"
                        class="relative flex items-center justify-between px-5 py-3 text-gray-900 border-t border-gray-300 cursor-pointer hover:bg-gray-300">
                        <div class="flex items-center">
                            <span class="ml-3 truncate">{{ $value[$column] }}</span>
                        </div>

                        @if ($selected == $value['id'])
                            <x:component::icon.check class="text-green-500 h-7" />
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
