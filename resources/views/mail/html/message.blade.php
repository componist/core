<x-mail::layout>
{{-- Header --}}
<x-slot:header>
<x-mail::header :url="rtrim((string) config('app.url'), '/')">
{{ config('componist_mail.brand_name') ?: config('app.name') }}
</x-mail::header>
</x-slot:header>

{{-- Body --}}
{!! $slot !!}

{{-- Subcopy --}}
@isset($subcopy)
<x-slot:subcopy>
<x-mail::subcopy>
{!! $subcopy !!}
</x-mail::subcopy>
</x-slot:subcopy>
@endisset

{{-- Footer — Soft Split wording --}}
<x-slot:footer>
<x-mail::footer>
@php
    $brand = config('componist_mail.brand_name') ?: config('app.name');
    $footer = config('componist_mail.footer_text');
    $supportUrl = config('componist_mail.support_url');
    $supportEmail = config('componist_mail.support_email');

    $supportLine = 'den Support';
    if (is_string($supportEmail) && $supportEmail !== '') {
        $supportLine = '['.$supportEmail.'](mailto:'.$supportEmail.')';
    } elseif (is_string($supportUrl) && $supportUrl !== '') {
        $supportLine = '[Support]('.$supportUrl.')';
    }
@endphp
**{{ $brand }}**

Fragen? Schreiben Sie uns an {!! $supportLine !!} — wir antworten in der Regel innerhalb eines Werktags.

Sie erhalten diese E-Mail, weil Sie ein Konto bei {{ $brand }} haben.
@if (is_string($footer) && $footer !== '')

{{ $footer }}
@endif
</x-mail::footer>
</x-slot:footer>
</x-mail::layout>
