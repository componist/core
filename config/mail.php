<?php

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Brand (Soft Split E-Mail)
    |--------------------------------------------------------------------------
    |
    | Einheitliches Soft-Split-Layout für Markdown-Mails und HTML-Mailables.
    | Visuelle Referenz: 21st.dev „Soft Split“ (linke Teal-Schiene, Blocktrenner).
    |
    */

    'brand_name' => env('COMPONIST_MAIL_BRAND_NAME'),

    /** Untertitel unter dem Brand-Namen (z. B. „SaaS Platform“) */
    'brand_tagline' => env('COMPONIST_MAIL_BRAND_TAGLINE'),

    /*
    | Logo relativ zu public/ oder absolute http(s)-URL.
    | Leer = Teal-Markenzeichen (Soft-Split Logo-Platzhalter).
    */
    'logo_path' => env('COMPONIST_MAIL_LOGO_PATH'),

    'primary' => env('COMPONIST_MAIL_PRIMARY', '#14b8a6'),

    /** Freitext unter dem Footer (z. B. Adresse / HRB) */
    'footer_text' => env('COMPONIST_MAIL_FOOTER_TEXT'),

    'support_url' => env('COMPONIST_MAIL_SUPPORT_URL'),

    'support_email' => env('COMPONIST_MAIL_SUPPORT_EMAIL'),

    'settings_url' => env('COMPONIST_MAIL_SETTINGS_URL'),

    'unsubscribe_url' => env('COMPONIST_MAIL_UNSUBSCRIBE_URL'),

    /*
    | Laravel Markdown-Theme-Name (CSS unter resources/views/mail/html/themes/).
    */
    'theme' => env('COMPONIST_MAIL_THEME', 'componist'),
];
