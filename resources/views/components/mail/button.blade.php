@props([
    'url',
    'align' => 'left',
])

@php
    $primary = (string) config('componist_mail.primary', '#14b8a6');
    $alignCss = match ($align) {
        'center' => 'center',
        'right' => 'right',
        default => 'left',
    };
    $font = "ui-sans-serif,system-ui,-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif";
@endphp
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="margin:0;">
    <tr>
        <td align="{{ $alignCss }}">
            <a href="{{ $url }}" target="_blank" rel="noopener"
               style="display:inline-block;background-color:{{ $primary }};color:#ffffff;font-family:{{ $font }};font-size:15px;font-weight:600;letter-spacing:-0.01em;text-decoration:none;border-radius:8px;padding:12px 24px;">
                {{ $slot }}
            </a>
        </td>
    </tr>
</table>
