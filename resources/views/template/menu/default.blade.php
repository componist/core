<ul>
    @foreach ($items as $item)
        <li>
            @if (count($item->children) > 0)
                {{ trim($item->title) }}

                @include('component::template.menu.default', [
                    'items' => $item->children,
                    'type' => 'children',
                ])
            @else
                @if ($item->type == 'route' or $item->type == 'page')
                    @if (Route::has($item->name))
                        <a href="{{ route($item->name) }}" target="{{ $item->target }}">{{ $item->title }}</a>
                    @elseif(Route::has($item->view_path))
                        <a href="{{ route($item->view_path) }}" target="{{ $item->target }}">{{ $item->title }}</a>
                    @endif
                @else
                    <a href="{{ url($item->name) }}" target="{{ $item->target }}">{{ $item->title }}</a>
                @endif
            @endif
        </li>
    @endforeach
</ul>
