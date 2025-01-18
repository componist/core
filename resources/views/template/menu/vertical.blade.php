@if (!isset($start))
    <ul class="grid items-center grid-cols-1">
@endif

@foreach ($items as $item)
    @if (count($item->children) > 0)
        <li x-data="{ open: false }" class="relative">
            <button @click.prevent="open = ! open"
                class="flex items-center gap-3 px-4 py-2 text-gray-600 hover:text-dashboard-500">{{ $item->title }}
                <x:component::icon.arrow-down />
            </button>
            <ul x-cloak x-show="open" click.outside="open = false"
                x-transition:enter="transition ease-out duration-100 transform"
                x-transition:enter-start="opacity-0 scale-30" x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-75 transform"
                x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                class="relative z-10 flex flex-col font-normal divide-y divide-gray-100 rounded shadow bg-gray-50 md:absolute w-44 dark:bg-gray-700 dark:divide-gray-600">
                @include('component::template.menu.vertical', [
                    'items' => $item->children,
                    'type' => 'children',
                    'start' => true,
                ])
            </ul>
        </li>
    @else
        @if (isset($type) && $type == 'children')
            @if ($item->type == 'route' or $item->type == 'page')
                @if (Route::has($item->name))
                    <li>
                        <a href="{{ route($item->name) }}" target="{{ $item->target }}"
                            class="block px-4 py-2 text-gray-600 hover:text-dashboard-500">{{ $item->title }}</a>
                    </li>
                @endif
            @else
                <li>
                    <a href="{{ url($item->name) }}" target="{{ $item->target }}"
                        class="block px-4 py-2 text-gray-600 hover:text-dashboard-500">{{ $item->title }}</a>
                </li>
            @endif
        @else
            @if ($item->type == 'route' or $item->type == 'page')
                @if (Route::has($item->name))
                    <li>
                        <a href="{{ route($item->name) }}" target="{{ $item->target }}"
                            class="block px-4 py-2 text-gray-600 hover:text-dashboard-500">{{ $item->title }}</a>
                    </li>
                @endif
            @else
                <li>
                    <a href="{{ url($item->url) }}" target="{{ $item->target }}"
                        class="block px-4 py-2 text-gray-600 hover:text-dashboard-500">{{ $item->title }}</a>
                </li>
            @endif
        @endif
    @endif
@endforeach

@if (!isset($start))
    </ul>
@endif
