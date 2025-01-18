<div>
    <div x-data="{ open: false }" class="relative">

        @if ($selectedColor)
            <button type="button" @click.prevent="open = ! open" class=" border-2 rounded-md shadow-sm w-9 h-9"
                style="background-color: {{ $selectedColor }}">
            </button>
        @else
            <button type="button" @click.prevent="open = ! open"
                class="flex items-center justify-center text-teal-500 border-2 border-teal-500 rounded-md shadow-sm hover:text-white w-9 h-9 hover:bg-dashboard-500 default-transition">
                <x:component::icon.colorize />
            </button>
        @endif

        <div x-clock x-show="open" x-cloak x-transition:enter="transition ease-out duration-100 transform"
            x-transition:enter-start="opacity-0 scale-30" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-75 transform"
            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
            class="fixed top-0 bottom-0 left-0 right-0 z-50 flex items-center justify-center px-5 bg-gray-500 backdrop-blur-sm bg-opacity-70">
            <div @click.outside="open=false" class="grid grid-cols-1 gap-0 overflow-y-auto w-[336px] max-h-96">
                @foreach ($colorListe as $tint)
                    <div class="flex gap-0">
                        @foreach ($tint as $color)
                            <button type="button" @click.prevent="open = false"
                                class="flex items-center justify-center text-white w-14 h-14"
                                wire:click="setColor('{{ $color }}')"
                                style="background-color: {{ $color }}">
                                @if (!empty($selectedColor) && $selectedColor == $color)
                                    <x:component::icon.check />
                                @endif
                            </button>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
