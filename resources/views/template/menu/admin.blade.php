<div>
    @foreach ($items as $item)
        @if (count($item->children) > 0)
            <x:component::menu.dropdown>
                <x-slot:trigger>
                    <span class="flex items-center gap-2">
                        @include('component::template.menu._icon', ['item' => $item])
                        <span>{{ $item->title }}</span>
                    </span>
                </x-slot:trigger>

                <x-slot:content>
                    @include('component::template.menu.admin', [
                        'items' => $item->children,
                        'type' => 'children',
                    ])
                </x-slot:content>
            </x:component::menu.dropdown>
        @else
            @if (isset($type) && $type == 'children')
                @php($menuRoute = componist_menu_resolve_route_name($item->name ?? null))
                @if ($menuRoute !== null && componist_menu_requires_post($item->name ?? null))
                    <form method="POST" action="{{ route($menuRoute) }}" class="w-full">
                        @csrf
                        <button type="submit"
                            class="flex w-full items-center gap-2 rounded-lg px-3 py-2 text-left text-sm text-slate-600 transition-colors duration-200 hover:bg-slate-100 hover:text-teal-600 dark:text-slate-300 dark:hover:bg-slate-800 dark:hover:text-teal-400">
                            @include('component::template.menu._icon', ['item' => $item])
                            <span>{{ $item->title }}</span>
                        </button>
                    </form>
                @else
                    @php($href = componist_menu_href($item))
                    @if ($href)
                        <x:component::menu.dropdown-link href="{{ $href }}">
                            <span class="flex items-center gap-2">
                                @include('component::template.menu._icon', ['item' => $item])
                                <span>{{ $item->title }}</span>
                            </span>
                        </x:component::menu.dropdown-link>
                    @endif
                @endif
            @else
                @php($menuRoute = componist_menu_resolve_route_name($item->name ?? null))
                @if ($menuRoute !== null && componist_menu_requires_post($item->name ?? null))
                    <form method="POST" action="{{ route($menuRoute) }}" class="w-full">
                        @csrf
                        <button type="submit"
                            class="flex w-full items-center gap-2 rounded-lg px-3 py-2 text-left text-sm text-slate-600 transition-colors duration-200 hover:bg-slate-100 hover:text-teal-600 dark:text-slate-300 dark:hover:bg-slate-800 dark:hover:text-teal-400">
                            @include('component::template.menu._icon', ['item' => $item])
                            <span>{{ $item->title }}</span>
                        </button>
                    </form>
                @else
                    @php($href = componist_menu_href($item))
                    @if ($href)
                        <x:component::menu.link href="{{ $href }}" target="{{ $item->target }}"
                            active="{{ $item->type === 'url' ? (request()->url() == $href ? true : false) : request()->routeIs($item->name ?? '') }}">
                            <span class="flex items-center gap-2">
                                @include('component::template.menu._icon', ['item' => $item])
                                <span>{{ $item->title }}</span>
                            </span>
                        </x:component::menu.link>
                    @endif
                @endif
            @endif
        @endif
    @endforeach
</div>
