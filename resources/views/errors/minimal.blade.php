<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title')</title>

    @vite(['resources/css/guest.css', 'resources/js/guest.js'])
</head>

<body class="bg-gradient-to-r from-gray-200 to-gray-300">

    <main class="flex items-center justify-center h-screen p-7">
        <div class="container px-5 mx-auto text-center">
            <div class="grid grid-cols-1 gap-1">
                <h1 class="font-bold text-app-500 text-8xl md:text-[8rem] xl:text-[13rem] drop-shadow-sm">
                    @yield('code')
                </h1>
                <p class="text-lg text-gray-600 uppercase">@yield('message')</p>
            </div>
        </div>

    </main>
</body>

</html>
