@props([
    'padding' => 'default',
])

@php
    $pad = match ($padding) {
        'tight' => '20px 40px',
        'cta' => '28px 40px',
        'none' => '0 40px',
        default => '24px 40px',
    };
    $font = "ui-sans-serif,system-ui,-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif";
@endphp
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
    <tr>
        <td style="padding:{{ $pad }};font-family:{{ $font }};font-size:15px;line-height:1.6;color:#475569;">
            {{ $slot }}
        </td>
    </tr>
</table>
