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
                @if ($item->type == 'route' or $item->type == 'page')
                    @if (Route::has($item->name))
                        <x:component::menu.account-link href="{{ route($item->name) }}">
                            <span class="flex items-center gap-2">
                                @include('component::template.menu._icon', ['item' => $item])
                                <span>{{ $item->title }}</span>
                            </span>
                        </x:component::menu.account-link>
                    @elseif(Route::has($item->view_path))
                        <x:component::menu.account-link href="{{ route($item->view_path) }}">
                            <span class="flex items-center gap-2">
                                @include('component::template.menu._icon', ['item' => $item])
                                <span>{{ $item->title }}</span>
                            </span>
                        </x:component::menu.account-link>
                    @endif
                @else
                    <x:component::menu.account-link href="{{ url($item->name) }}">
                        <span class="flex items-center gap-2">
                            @include('component::template.menu._icon', ['item' => $item])
                            <span>{{ $item->title }}</span>
                        </span>
                    </x:component::menu.account-link>
                @endif
            @else
                @if ($item->type == 'route' or $item->type == 'page')
                    @if (Route::has($item->name))
                        <x:component::menu.account-link href="{{ route($item->name) }}" target="{{ $item->target }}"
                            active="{{ request()->routeIs($item->name) }}">
                            <span class="flex items-center gap-2">
                                @include('component::template.menu._icon', ['item' => $item])
                                <span>{{ $item->title }}</span>
                            </span>
                        </x:component::menu.account-link>
                    @elseif(Route::has($item->view_path))
                        <x:component::menu.account-link href="{{ route($item->view_path) }}"
                            target="{{ $item->target }}" active="{{ request()->routeIs($item->name) }}">
                            <span class="flex items-center gap-2">
                                @include('component::template.menu._icon', ['item' => $item])
                                <span>{{ $item->title }}</span>
                            </span>
                        </x:component::menu.account-link>
                    @endif
                @else
                    <x:component::menu.account-link href="{{ url($item->name) }}" target="{{ $item->target }}"
                        active="{{ request()->url() == url($item->name) ? true : false }}">
                        <span class="flex items-center gap-2">
                            @include('component::template.menu._icon', ['item' => $item])
                            <span>{{ $item->title }}</span>
                        </span>
                    </x:component::menu.account-link>
                @endif
            @endif
        @endif
    @endforeach
</div>
