<div x-data="{ open: false }" class="relative">
    <button @click.prevent="open = ! open" type="button" class="flex items-center text-gray-500">
        <x:component::icon.more-horiz />
    </button>
    <div x-show="open" x-cloak @click.outside="open = false"
        class="absolute left-0 z-20 -ml-24 overflow-hidden transform -translate-x-1/2 -translate-y-1/2 bg-white border-t border-l border-gray-200 rounded-md shadow-md w-36 top-1/2">
        <ul class="list-reset">
            {{ $slot }}
        </ul>
    </div>
</div>
