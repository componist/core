<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="color-scheme" content="light dark">

    <script>
        (function () {
            try {
                var theme = localStorage.getItem('theme');
                var prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                if (theme === 'dark' || (!theme && prefersDark)) {
                    document.documentElement.classList.add('dark');
                }
            } catch (e) {}
        })();
    </script>

    <title>@yield('title')</title>

    @vite(['resources/css/guest.css', 'resources/js/guest.js'])
</head>

<body
    class="min-h-screen bg-gradient-to-br from-slate-100 via-slate-50 to-slate-200 text-slate-900 dark:from-slate-950 dark:via-slate-900 dark:to-slate-950 dark:text-white">

    <main class="flex items-center justify-center min-h-screen p-7">
        <div class="container px-5 mx-auto text-center">
            <div class="grid grid-cols-1 gap-3">
                <h1
                    class="font-bold text-teal-500 dark:text-teal-400 text-8xl md:text-[8rem] xl:text-[13rem] drop-shadow-sm">
                    @yield('code')
                </h1>
                <p class="text-lg uppercase tracking-wide text-slate-600 dark:text-slate-300">
                    @yield('message')
                </p>
                <p class="mt-6">
                    <a href="{{ url('/') }}"
                        class="inline-flex items-center justify-center px-5 py-2 text-sm font-medium text-white rounded-md bg-teal-500 hover:bg-teal-600 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 focus:ring-offset-slate-50 dark:focus:ring-offset-slate-900">
                        {{ __('Zur Startseite') }}
                    </a>
                </p>
            </div>
        </div>
    </main>
</body>

</html>
