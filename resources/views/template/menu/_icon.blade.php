@php
    $icon = $item->icon ?? null;
    $isLocalIcon = !empty($icon) && ! str_contains($icon, ':') && ! str_starts_with($icon, 'heroicon-');
    $localIconView = $isLocalIcon ? 'component::components.icon.' . $icon : null;
@endphp

@if ($isLocalIcon && $localIconView && \Illuminate\Support\Facades\View::exists($localIconView))
    <x-dynamic-component :component="'component::icon.' . $icon" class="w-5 h-5 shrink-0" />
@elseif (! empty($icon))
    {{-- Supports Blade Icons / Heroicons (e.g. "heroicon-o-home") --}}
    <x-dynamic-component :component="$icon" class="w-5 h-5 shrink-0" />
@endif

