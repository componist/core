<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="apple-touch-icon" sizes="57x57" href="{{ url('favicon/apple-icon-57x57.png') }}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ url('favicon/apple-icon-60x60.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ url('favicon/apple-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ url('favicon/apple-icon-76x76.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ url('favicon/apple-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ url('favicon/apple-icon-120x120.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ url('favicon/apple-icon-144x144.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ url('favicon/apple-icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ url('favicon/apple-icon-180x180.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ url('favicon/android-icon-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ url('favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ url('favicon/favicon-96x96.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ url('favicon/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ url('favicon/manifest.json') }}">
    <meta name="msapplication-TileColor" content="#18306a">
    <meta name="msapplication-TileImage" content="{{ url('favicon/ms-icon-144x144.png') }}">
    <meta name="theme-color" content="#18306a">

    <title>{{ $title ?? null }} @yield('title') - {{ config('app.name', 'Laravel') }}</title>

    @livewireStyles

    @vite(['resources/css/dashboard.css', 'resources/js/dashboard.js'])
</head>

<body class="bg-gray-200">
    <x:component::flash-message on="saved" />

    <div x-data="{ isOpen: true }" class="flex h-screen">
        <div x-cloak :class="isOpen ? '-left-96' : 'left-0'"
            class="fixed top-0 bottom-0 px-5 overflow-y-auto transition-all duration-300 ease-linear bg-white w-96 py-7">

            <div class="pb-3 border-b border-gray-200">
                <a href="#" class="block">
                    <h1 class="mb-3 text-3xl font-bold text-center">Company</h1>
                </a>
            </div>

            <div class="pl-1 pr-3">

                <div class="mt-7">
                    <span class="mb-5 ml-1 text-sm font-bold uppercase text-dashboard-500">Administrator</span>
                    {{ menu('admin', 'admin') }}
                </div>

                <div class="mt-7">
                    {{ menu('auth', 'admin') }}
                </div>

            </div>

        </div>
        <div :class="isOpen ? 'left-0' : 'left-96'" class="relative w-full transition-all duration-300 ease-linear">
            <div class="shadow-sm bg-dashboard-900 backend-background-image">
                <div class="bg-gray-900 bg-opacity-50">
                    <div class="flex justify-between pl-5 pr-10 py-7">
                        <button x-on:click="isOpen = ! isOpen" type="button"
                            class="text-white hover:text-dashboard-500">
                            <x:component::icon.hamburger />
                        </button>

                        @if (Auth::user())
                            <div class="flex items-center gap-5">

                                <a href="{{ route('componist.core.notification') }}">
                                    @livewire('notification.componist-core-notification-bell')
                                </a>

                                <div class="relative ml-3" x-data="{ open: false }" @click.away="open = false"
                                    @close.stop="open = false">
                                    <div @click.prevent="open = ! open">
                                        @if (!empty(Auth::user()->profile_photo_url))
                                            <button
                                                class="flex items-center gap-2 pr-3 text-sm transition border-2 border-transparent rounded-full focus:outline-none ">
                                                <img class="object-cover w-8 h-8 rounded-full"
                                                    src="{{ asset(Auth::user()->profile_photo_url) }}"
                                                    alt="{{ Auth::user()->name }}" />
                                                <span
                                                    class="text-gray-400 hover:text-dashboard-500 default-transition">{{ Auth::user()->name }}</span>
                                            </button>
                                        @else
                                            <span class="inline-flex rounded-md">
                                                <button type="button"
                                                    class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition bg-white border border-transparent rounded-md hover:text-dashboard-500 focus:outline-none">
                                                    {{ Auth::user()->name }}

                                                    <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd"
                                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </span>
                                        @endif
                                    </div>

                                    <div x-cloak x-show="open" x-transition:enter="transition ease-out duration-200"
                                        x-transition:enter-start="transform opacity-0 scale-95"
                                        x-transition:enter-end="transform opacity-100 scale-100"
                                        x-transition:leave="transition ease-in duration-75"
                                        x-transition:leave-start="transform opacity-100 scale-100"
                                        x-transition:leave-end="transform opacity-0 scale-95"
                                        class="absolute right-0 z-50 mt-2 origin-top-right bg-white rounded-md shadow-lg w-44">

                                        <div
                                            class="overflow-hidden text-sm text-left rounded-md shadow-sm ring-1 ring-black ring-opacity-5">
                                            <div class="block px-4 py-2 text-xs text-gray-400">
                                                {{ __('Manage Account') }}
                                            </div>

                                            {{ menu('account-manager', 'account') }}


                                            {{-- <div class="border-t border-gray-100"></div> --}}

                                            <!-- Authentication -->
                                            {{-- <form method="POST" action="{{ route('logout') }}" x-data>
                                                @csrf
                                                <x:component::menu.account-link href="{{ route('logout') }}"
                                                    class="flex items-center gap-2" @click.prevent="$root.submit();">
                                                    {{ __('Log Out') }}
                                                    <x:component::icon.logout class="h-5 text-red-500" />
                                                </x:component::menu.account-link>
                                            </form> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    @if (isset($header))
                        <header class="container mx-auto text-3xl text-white px-7 pt-7 pb-14">
                            {{ $header }}
                        </header>
                    @endif
                </div>
            </div>
            <main class="">
                {{ $slot }}
            </main>
        </div>
    </div>

    @livewireScripts

</body>

</html>
