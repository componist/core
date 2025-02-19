<div wire:poll.90s>
    <div class="relative w-8 h-8 text-gray-300 hover:text-teal-500">
        <x:component::icon.notification class="w-8 h-8 {{ $content > 0 ? 'bell-ring-animation' : '' }}" />
        @if ($content > 0)
            <div
                class="absolute flex items-center justify-center w-6 h-6 text-xs bg-red-500 rounded-full shadow-sm -top-2 -right-2">
                <span class="items-center text-center text-white -ml-[1px] -mt-[1px]">{{ $content }}</span>
            </div>
        @endif

    </div>
</div>
