<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="format-detection" content="telephone=no">

    @stack('meta')

    @if (! trim($__env->yieldPushContent('meta')))
        <title>{{ config('app.name', 'Laravel') }}</title>
        <meta name="robots" content="noindex, nofollow">
    @endif

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    @livewireStyles

    @vite(['resources/css/guest.css', 'resources/js/guest.js'])
</head>

<body class="min-h-screen bg-slate-950 font-sans text-slate-100 antialiased">
    @if (isset($slot))
        {{ $slot }}
    @endif

    @yield('content')

    @livewireScripts
</body>

</html>
