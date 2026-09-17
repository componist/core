@props([
    'code',
])

@php
    $primary = (string) config('componist_mail.primary', '#14b8a6');
    $display = is_string($code) ? $code : (string) $code;
@endphp
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="margin:0 0 24px;">
    <tr>
        <td align="center" style="padding:16px 20px;background-color:#f0fdfa;border:1px solid #99f6e4;border-radius:12px;font-family:ui-sans-serif,system-ui,-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif;font-size:28px;font-weight:700;letter-spacing:0.2em;line-height:1.3;color:#0f766e;">
            {{ $display }}
        </td>
    </tr>
</table>
