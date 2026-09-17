<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="color-scheme" content="light dark">

        <title>@yield('title')</title>

        @include('component::components.layouts.partials.theme-boot')

        <style>
            :root {
                color-scheme: light dark;
                --error-bg: #f8fafc;
                --error-fg: #475569;
                --error-accent: #14b8a6;
            }

            html.dark {
                --error-bg: #0f172a;
                --error-fg: #cbd5e1;
                --error-accent: #2dd4bf;
            }

            html, body {
                background-color: var(--error-bg);
                color: var(--error-fg);
                font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif;
                font-weight: 400;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 1.25rem;
                padding: 1.25rem;
            }

            .code {
                color: var(--error-accent);
                font-size: 4rem;
                font-weight: 700;
                margin: 0;
            }

            .home-link {
                color: #fff;
                background: #14b8a6;
                display: inline-block;
                margin-top: 1.5rem;
                padding: 0.5rem 1.25rem;
                border-radius: 0.375rem;
                text-decoration: none;
            }

            .home-link:hover {
                background: #0d9488;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="content">
                @hasSection('code')
                    <p class="code">@yield('code')</p>
                @endhasSection
                <div class="title">
                    @yield('message')
                </div>
                <a class="home-link" href="{{ url('/') }}">{{ __('Zur Startseite') }}</a>
            </div>
        </div>
    </body>
</html>
