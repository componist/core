<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @include('component::components.layouts.partials.theme-boot')

    <title>Seite nicht gefunden</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body
    class="flex h-screen items-center justify-center bg-slate-200 text-slate-900 dark:bg-slate-950 dark:text-slate-100">

    <h1 class="text-7xl font-bold text-slate-900 dark:text-white">404</h1>

</body>

</html>
