<div x-data="{ open: false }" class="mx-4">
    <button x-on:click="open = ! open"
        class="flex items-center justify-between w-full py-3 text-gray-600 transition-all duration-200 ease-linear hover:text-dashboard-500">

        {{ $trigger }}
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M6 9l6 6 6-6" />
        </svg>
    </button>
    <div x-show="open" @click.outside="open = false" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95" class="px-5 py-3 my-3 rounded-md shadow bg-dashboard-500">
        {{ $content }}
    </div>
</div>
