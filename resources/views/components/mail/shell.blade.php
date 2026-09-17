@props([
    'title' => null,
    'preheader' => null,
    'label' => null,
])

@php
    $brand = config('componist_mail.brand_name') ?: config('app.name', 'App');
    $tagline = config('componist_mail.brand_tagline');
    $appUrl = rtrim((string) config('app.url'), '/');
    $primary = (string) config('componist_mail.primary', '#14b8a6');
    $logoPath = config('componist_mail.logo_path');
    $logoUrl = null;
    if (is_string($logoPath) && $logoPath !== '') {
        $logoUrl = str_starts_with($logoPath, 'http://') || str_starts_with($logoPath, 'https://')
            ? $logoPath
            : $appUrl.'/'.ltrim($logoPath, '/');
    }
    $footerText = config('componist_mail.footer_text');
    $supportUrl = config('componist_mail.support_url');
    $supportEmail = config('componist_mail.support_email');
    $settingsUrl = config('componist_mail.settings_url');
    $unsubscribeUrl = config('componist_mail.unsubscribe_url');
    $pageTitle = is_string($title) && $title !== '' ? $title : $brand;
    $font = "system-ui,ui-sans-serif,-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,'Helvetica Neue',Arial,sans-serif";
@endphp
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="color-scheme" content="light" />
    <meta name="supported-color-schemes" content="light" />
    <title>{{ $pageTitle }}</title>
    @if (is_string($preheader) && $preheader !== '')
    <span style="display:none!important;visibility:hidden;mso-hide:all;font-size:1px;line-height:1px;max-height:0;max-width:0;opacity:0;overflow:hidden;">{{ $preheader }}</span>
    @endif
</head>
<body style="margin:0;padding:0;background-color:#f4f5f3;width:100% !important;-webkit-text-size-adjust:none;font-family:{{ $font }};">
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#f4f5f3;margin:0;padding:0;width:100%;">
    <tr>
        <td align="center" style="padding:40px 16px;">
            {{-- Soft Split Card: linke Teal-Schiene, rechts gerundet --}}
            <table role="presentation" width="600" cellpadding="0" cellspacing="0" border="0" style="width:600px;max-width:100%;background-color:#ffffff;border:1px solid #e2e8f0;border-left:4px solid {{ $primary }};border-radius:2px 12px 12px 2px;overflow:hidden;box-shadow:0 1px 2px rgba(15,23,42,0.04),0 8px 24px rgba(15,23,42,0.06);">

                {{-- Top brand bar (Sketch) --}}
                <tr>
                    <td style="padding:32px 40px 24px;font-family:{{ $font }};">
                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td align="left" style="vertical-align:middle;">
                                    <a href="{{ $appUrl }}" style="text-decoration:none;color:#0f172a;">
                                        <table role="presentation" cellpadding="0" cellspacing="0" border="0">
                                            <tr>
                                                <td style="vertical-align:middle;padding-right:12px;">
                                                    @if ($logoUrl)
                                                        <img src="{{ $logoUrl }}" alt="{{ $brand }}" width="36" height="36" style="display:block;width:36px;height:36px;border:0;border-radius:8px;" />
                                                    @else
                                                        {{-- Soft-Split Logo-Platzhalter --}}
                                                        <div style="width:36px;height:36px;border-radius:8px;background-color:{{ $primary }};text-align:center;line-height:36px;">
                                                            <img src="data:image/svg+xml,{{ rawurlencode('<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"18\" height=\"18\" viewBox=\"0 0 24 24\" fill=\"none\"><path d=\"M12 3L20 7.5V16.5L12 21L4 16.5V7.5L12 3Z\" stroke=\"white\" stroke-width=\"2\" stroke-linejoin=\"round\"/><path d=\"M12 12L20 7.5M12 12V21M12 12L4 7.5\" stroke=\"white\" stroke-width=\"2\" stroke-linejoin=\"round\"/></svg>') }}" alt="" width="18" height="18" style="display:inline-block;vertical-align:middle;border:0;" />
                                                        </div>
                                                    @endif
                                                </td>
                                                <td style="vertical-align:middle;">
                                                    <span style="display:block;font-size:15px;font-weight:600;letter-spacing:-0.01em;color:#0f172a;line-height:1.15;">{{ $brand }}</span>
                                                    @if (is_string($tagline) && $tagline !== '')
                                                        <span style="display:block;font-size:11px;color:#94a3b8;margin-top:2px;letter-spacing:0.04em;">{{ $tagline }}</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        </table>
                                    </a>
                                </td>
                                @if (is_string($label) && $label !== '')
                                    <td align="right" style="vertical-align:middle;">
                                        <span style="display:inline-block;font-size:11px;font-weight:500;letter-spacing:0.06em;text-transform:uppercase;color:#475569;padding:4px 8px;border-radius:4px;border:1px solid #e2e8f0;background-color:#f4f5f3;">{{ $label }}</span>
                                    </td>
                                @endif
                            </tr>
                        </table>
                    </td>
                </tr>

                {{-- Soft slate separator after brand --}}
                <tr>
                    <td style="padding:0 40px;">
                        <div style="border-top:1px solid #e2e8f0;font-size:0;line-height:0;height:1px;">&nbsp;</div>
                    </td>
                </tr>

                {{-- Content blocks (heading / sep / body / cta / panel via slot) --}}
                <tr>
                    <td style="font-family:{{ $font }};padding:0;">
                        {{ $slot }}
                    </td>
                </tr>

                {{-- Footer (Sketch) --}}
                <tr>
                    <td style="border-top:1px solid #e2e8f0;background-color:#f8f9f8;padding:28px 40px;font-family:{{ $font }};">
                        <p style="margin:0;font-size:13px;font-weight:500;color:#0f172a;">{{ $brand }}</p>
                        <p style="margin:8px 0 0;font-size:12px;line-height:1.55;color:#475569;">
                            Fragen? Schreiben Sie uns an
                            @if (is_string($supportEmail) && $supportEmail !== '')
                                <a href="mailto:{{ $supportEmail }}" style="color:#475569;text-decoration:underline;text-underline-offset:3px;text-decoration-color:#cbd5e1;">{{ $supportEmail }}</a>
                            @elseif (is_string($supportUrl) && $supportUrl !== '')
                                <a href="{{ $supportUrl }}" style="color:#475569;text-decoration:underline;text-underline-offset:3px;text-decoration-color:#cbd5e1;">Support</a>
                            @else
                                den Support
                            @endif
                            — wir antworten in der Regel innerhalb eines Werktags.
                        </p>
                        <p style="margin:20px 0 0;font-size:11px;line-height:1.55;color:#94a3b8;">
                            Sie erhalten diese E-Mail, weil Sie ein Konto bei {{ $brand }} haben.
                            @if (is_string($settingsUrl) && $settingsUrl !== '')
                                <a href="{{ $settingsUrl }}" style="color:#94a3b8;text-decoration:underline;text-underline-offset:3px;text-decoration-color:#cbd5e1;">E-Mail-Einstellungen</a>
                            @endif
                            @if (is_string($unsubscribeUrl) && $unsubscribeUrl !== '')
                                · <a href="{{ $unsubscribeUrl }}" style="color:#94a3b8;text-decoration:underline;text-underline-offset:3px;text-decoration-color:#cbd5e1;">Abmelden</a>
                            @endif
                            @if (is_string($footerText) && $footerText !== '')
                                <br />{{ $footerText }}
                            @endif
                        </p>
                    </td>
                </tr>
            </table>

            <p style="margin:24px 0 0;text-align:center;font-family:{{ $font }};font-size:11px;line-height:1.5;color:#94a3b8;padding:0 16px;">
                Diese Nachricht wurde automatisch versendet. Bitte antworten Sie nicht direkt auf diese E-Mail.
            </p>
        </td>
    </tr>
</table>
</body>
</html>
