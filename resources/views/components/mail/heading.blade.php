@props([
    'title',
    'greeting' => null,
])

@php
    $font = "ui-sans-serif,system-ui,-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif";
@endphp
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
    <tr>
        <td style="padding:28px 40px 20px;font-family:{{ $font }};">
            <h1 style="margin:0;font-size:22px;font-weight:600;letter-spacing:-0.02em;line-height:1.3;color:#0f172a;">
                {{ $title }}
            </h1>
            @if (is_string($greeting) && $greeting !== '')
                <p style="margin:12px 0 0;font-size:15px;line-height:1.6;color:#475569;">{{ $greeting }}</p>
            @endif
        </td>
    </tr>
</table>
