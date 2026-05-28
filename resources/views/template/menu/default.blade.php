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
            @php($href = componist_menu_href($item))
        @if ($href)
            <a href="{{ $href }}" target="{{ $item->target }}" class="inline-flex items-center gap-2">
                    @include('component::template.menu._icon', ['item' => $item])
                        <span>{{ $item->title }}</span>
                    </a>
        @endif
            @endif
        </li>
    @endforeach
</ul>
