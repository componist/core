@props([
    'id' => uniqid(),
    'status' => false,
])
<label for="{{ $id }}" class="relative inline-flex items-center cursor-pointer">
    <input
        @if (isset($attributes['wire:change'])) {{ $attributes->wire('change') }}
    @else
    
        {{ $attributes->wire('model.live') }} @endif
        type="checkbox" id="{{ $id }}" class="sr-only peer" @if ($status) checked @endif>
    <div
        class="w-16 h-8 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-transparent dark:peer-focus:ring-transparent rounded-full peer dark:bg-gray-700 after:left-[2px] peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] peer-checked:after:left-[5px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-7 after:w-7 after:transition-all dark:border-gray-600 peer-checked:bg-dashboard-500">
    </div>
</label>
