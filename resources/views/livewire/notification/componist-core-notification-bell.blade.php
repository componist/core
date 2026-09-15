<div wire:poll.90s>
    <div class="relative h-5 w-5 text-current">
        <x:component::icon.notification class="h-5 w-5 {{ $content > 0 ? 'bell-ring-animation' : '' }}" />
        @if ($content > 0)
            <div
                class="absolute -right-1.5 -top-1.5 flex h-4 min-w-4 items-center justify-center rounded-full bg-red-500 px-1 text-[10px] font-semibold text-white">
                <span>{{ $content }}</span>
            </div>
        @endif
    </div>
</div>
