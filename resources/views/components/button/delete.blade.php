<button
    {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex h-9 w-9 cursor-pointer items-center justify-center rounded-lg border border-red-500 text-red-500 shadow-sm transition-colors duration-200 hover:bg-red-500 hover:text-white focus:outline-none focus:ring-2 focus:ring-red-500']) }}>
    <x:component::icon.delete class="h-4 w-4" />
</button>
