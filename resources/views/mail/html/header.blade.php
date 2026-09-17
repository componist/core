@props(['url'])
@php
    $logoPath = config('componist_mail.logo_path');
    $brand = config('componist_mail.brand_name') ?: config('app.name', 'App');
    $tagline = config('componist_mail.brand_tagline');
    $primary = (string) config('componist_mail.primary', '#14b8a6');
    $logoUrl = null;
    if (is_string($logoPath) && $logoPath !== '') {
        $logoUrl = str_starts_with($logoPath, 'http://') || str_starts_with($logoPath, 'https://')
            ? $logoPath
            : rtrim((string) config('app.url'), '/').'/'.ltrim($logoPath, '/');
    }
@endphp
<tr>
<td class="header">
<table width="100%" cellpadding="0" cellspacing="0" role="presentation">
<tr>
<td align="left" style="vertical-align: middle;">
<a href="{{ $url }}" style="display: inline-block; text-decoration: none;">
<table cellpadding="0" cellspacing="0" role="presentation">
<tr>
<td style="vertical-align: middle; padding-right: 12px;">
@if ($logoUrl)
<img src="{{ $logoUrl }}" class="logo" alt="{{ $brand }}" style="height: 36px; width: 36px; border-radius: 8px;">
@else
<span style="display: inline-block; width: 36px; height: 36px; border-radius: 8px; background-color: {{ $primary }};"></span>
@endif
</td>
<td style="vertical-align: middle;">
<span style="display: block; color: #0f172a; font-size: 15px; font-weight: 600; letter-spacing: -0.01em; line-height: 1.15;">{{ $brand }}</span>
@if (is_string($tagline) && $tagline !== '')
<span style="display: block; color: #94a3b8; font-size: 11px; margin-top: 2px; letter-spacing: 0.04em;">{{ $tagline }}</span>
@endif
</td>
</tr>
</table>
</a>
</td>
</tr>
</table>
</td>
</tr>
<tr>
<td class="block-sep" style="padding: 0 40px;">
<div style="border-top: 1px solid #e2e8f0; font-size: 0; line-height: 0;">&nbsp;</div>
</td>
</tr>
