<x-mail::layout>
    {{-- Header --}}
    <x-slot:header>
        <x-mail::header :url="rtrim((string) config('app.url'), '/')">
            {{ config('componist_mail.brand_name') ?: config('app.name') }}
        </x-mail::header>
    </x-slot:header>

    {{-- Body --}}
    {{ $slot }}

    {{-- Subcopy --}}
    @isset($subcopy)
        <x-slot:subcopy>
            <x-mail::subcopy>
                {{ $subcopy }}
            </x-mail::subcopy>
        </x-slot:subcopy>
    @endisset

    {{-- Footer --}}
    <x-slot:footer>
        <x-mail::footer>
@php
    $brand = config('componist_mail.brand_name') ?: config('app.name');
    $footer = config('componist_mail.footer_text');
@endphp
© {{ date('Y') }} {{ $brand }}. Alle Rechte vorbehalten.
@if (is_string($footer) && $footer !== '')
{{ "\n\n".$footer }}
@endif
        </x-mail::footer>
    </x-slot:footer>
</x-mail::layout>
