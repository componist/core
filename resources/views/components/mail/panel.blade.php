@props([
    'title' => null,
])

@php
    $font = "ui-sans-serif,system-ui,-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif";
    $panelTitle = is_string($title) && $title !== '' ? $title : null;
@endphp
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="margin:0;">
    <tr>
        <td style="border:1px solid #e2e8f0;border-radius:8px;background-color:#f4f5f3;padding:16px 20px;font-family:{{ $font }};font-size:13px;line-height:1.55;color:#475569;">
            @if ($panelTitle)
                <p style="margin:0 0 6px;font-size:12px;font-weight:600;letter-spacing:0.06em;text-transform:uppercase;color:#64748b;">{{ $panelTitle }}</p>
            @endif
            {{ $slot }}
        </td>
    </tr>
</table>
