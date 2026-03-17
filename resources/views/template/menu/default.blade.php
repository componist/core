<ul>
    @foreach ($items as $item)
        <li>
            @if (count($item->children) > 0)
                <span class="inline-flex items-center gap-2">
                    @include('component::template.menu._icon', ['item' => $item])
                    <span>{{ trim($item->title) }}</span>
                </span>

                @include('component::template.menu.default', [
                    'items' => $item->children,
                    'type' => 'children',
                ])
            @else
                @if ($item->type == 'route' or $item->type == 'page')
                    @if (Route::has($item->name))
                        <a href="{{ route($item->name) }}" target="{{ $item->target }}"
                            class="inline-flex items-center gap-2">
                            @include('component::template.menu._icon', ['item' => $item])
                            <span>{{ $item->title }}</span>
                        </a>
                    @elseif(Route::has($item->view_path))
                        <a href="{{ route($item->view_path) }}" target="{{ $item->target }}"
                            class="inline-flex items-center gap-2">
                            @include('component::template.menu._icon', ['item' => $item])
                            <span>{{ $item->title }}</span>
                        </a>
                    @endif
                @else
                    <a href="{{ url($item->name) }}" target="{{ $item->target }}"
                        class="inline-flex items-center gap-2">
                        @include('component::template.menu._icon', ['item' => $item])
                        <span>{{ $item->title }}</span>
                    </a>
                @endif
            @endif
        </li>
    @endforeach
</ul>
