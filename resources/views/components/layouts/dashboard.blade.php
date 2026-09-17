<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

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
    <style>[x-cloak]{display:none!important}</style>

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
    <meta name="msapplication-TileColor" content="#14b8a6">
    <meta name="msapplication-TileImage" content="{{ url('favicon/ms-icon-144x144.png') }}">
    <meta name="theme-color" content="#14b8a6">

    <title>{{ $title ?? null }} @yield('title') - {{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700|sora:500,600,700&display=swap" rel="stylesheet" />

    @livewireStyles

    @vite(['resources/css/dashboard.css', 'resources/js/dashboard.js'])
</head>

<body class="h-full bg-slate-100 font-sans text-slate-900 antialiased dark:bg-slate-950 dark:text-slate-100">
    <x:component::toast-message />

    <div x-data="{
            sidebarOpen: window.innerWidth >= 1024 && localStorage.getItem('sidebarOpen') !== '0',
            dark: document.documentElement.classList.contains('dark'),
            toggleSidebar() {
                this.sidebarOpen = !this.sidebarOpen;
                if (window.innerWidth >= 1024) {
                    localStorage.setItem('sidebarOpen', this.sidebarOpen ? '1' : '0');
                }
            },
            toggleDark() {
                this.dark = !this.dark;
                document.documentElement.classList.toggle('dark', this.dark);
                localStorage.setItem('theme', this.dark ? 'dark' : 'light');
                window.dispatchEvent(new CustomEvent('theme-changed', { detail: { dark: this.dark } }));
            }
        }"
        class="flex h-screen overflow-hidden"
        @resize.window="if (window.innerWidth >= 1024 && localStorage.getItem('sidebarOpen') !== '0') { sidebarOpen = true }"
    >
        <div
            x-cloak
            x-show="sidebarOpen"
            x-transition:enter="transition-opacity duration-300 ease-out"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity duration-200 ease-in"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-40 bg-slate-950/40 backdrop-blur-[2px] lg:hidden"
            @click="sidebarOpen = false"
        ></div>

        <aside
            class="fixed inset-y-0 left-0 z-50 flex w-[17rem] flex-col border-r border-slate-200/80 bg-white/95 shadow-xl shadow-slate-900/5 backdrop-blur-md transition-transform duration-300 ease-[cubic-bezier(0.22,1,0.36,1)] dark:border-slate-800 dark:bg-slate-900/95 dark:shadow-black/30 lg:static lg:translate-x-0 lg:shadow-none"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:!hidden'"
        >
            <div class="flex h-16 items-center gap-2.5 border-b border-slate-200/80 px-4 dark:border-slate-800">
                <a
                    href="{{ Route::has('dashboard.index') ? route('dashboard.index') : url('/') }}"
                    class="group flex min-w-0 items-center gap-2.5 text-slate-900 transition hover:text-teal-600 dark:text-white dark:hover:text-teal-400"
                >
                    <span
                        class="inline-flex size-9 shrink-0 items-center justify-center rounded-xl bg-teal-500 text-white shadow-sm shadow-teal-500/25 transition duration-500 group-hover:rotate-12 group-hover:shadow-teal-500/40"
                        aria-hidden="true"
                    >
                        <span class="size-3 rotate-45 rounded-[3px] bg-white"></span>
                    </span>
                    <span class="truncate font-display text-sm font-semibold tracking-tight">
                        {{ config('app.name') }}
                    </span>
                </a>
            </div>

            <nav class="dash-nav-scroll flex-1 overflow-y-auto px-3 py-5">
                <div>
                    <span class="mb-2 block px-2 text-[11px] font-semibold uppercase tracking-[0.16em] text-teal-600 dark:text-teal-400">
                        Administration
                    </span>
                    <div class="space-y-0.5">
                        {{ menu('admin', 'admin') }}
                    </div>
                </div>

                <div class="mt-7">
                    <span class="mb-2 block px-2 text-[11px] font-semibold uppercase tracking-[0.16em] text-slate-400 dark:text-slate-500">
                        Konto
                    </span>
                    <div class="space-y-0.5">
                        {{ menu('auth', 'admin') }}
                    </div>
                </div>
            </nav>

            @if (Auth::user())
                <div class="border-t border-slate-200/80 p-3 dark:border-slate-800">
                    <div class="flex items-center gap-3 rounded-xl bg-slate-50 px-3 py-2.5 dark:bg-slate-800/70">
                        @php
                            $storagePath = storage_path('app/' . Auth::user()->profile_photo_url);
                            $photoUrl =
                                ! empty(Auth::user()->profile_photo_url) &&
                                file_exists($storagePath) &&
                                Route::has('package.users.manager.profile-photo')
                                    ? route('package.users.manager.profile-photo')
                                    : null;
                        @endphp
                        @if ($photoUrl)
                            <img class="h-8 w-8 rounded-full object-cover" src="{{ $photoUrl }}" alt="{{ Auth::user()->name }}" />
                        @else
                            <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-teal-500 text-xs font-semibold text-white">
                                {{ mb_substr(Auth::user()->name ?? 'U', 0, 1) }}
                            </span>
                        @endif
                        <div class="min-w-0">
                            <p class="truncate text-sm font-medium text-slate-900 dark:text-white">{{ Auth::user()->name }}</p>
                            <p class="truncate text-xs text-slate-500 dark:text-slate-400">{{ Auth::user()->email }}</p>
                        </div>
                    </div>
                </div>
            @endif
        </aside>

        <div class="flex min-w-0 flex-1 flex-col">
            <header
                class="sticky top-0 z-30 flex h-16 shrink-0 items-center justify-between gap-3 border-b border-slate-200/80 bg-white/80 px-4 backdrop-blur-md dark:border-slate-800 dark:bg-slate-900/75 sm:px-6"
            >
                <div class="flex min-w-0 items-center gap-3">
                    <button
                        type="button"
                        x-on:click="toggleSidebar()"
                        class="inline-flex h-9 w-9 cursor-pointer items-center justify-center rounded-xl text-slate-600 transition duration-200 hover:bg-slate-100 hover:text-teal-600 focus:outline-none focus:ring-2 focus:ring-teal-500 dark:text-slate-300 dark:hover:bg-slate-800 dark:hover:text-teal-400"
                        aria-label="Menü umschalten"
                    >
                        <x:component::icon.hamburger class="h-5 w-5" />
                    </button>

                    @if (isset($header))
                        <div class="min-w-0 truncate font-display text-sm font-semibold text-slate-800 dark:text-white">
                            {{ $header }}
                        </div>
                    @endif
                </div>

                @if (Auth::user())
                    <div class="flex items-center gap-1 sm:gap-2">
                        <button
                            type="button"
                            x-on:click="toggleDark()"
                            class="inline-flex h-9 w-9 cursor-pointer items-center justify-center rounded-xl text-slate-600 transition duration-200 hover:bg-slate-100 hover:text-teal-600 focus:outline-none focus:ring-2 focus:ring-teal-500 dark:text-slate-300 dark:hover:bg-slate-800 dark:hover:text-teal-400"
                            aria-label="Darstellung umschalten"
                        >
                            <span x-show="!dark">
                                <x:component::icon.moon class="h-5 w-5" />
                            </span>
                            <span x-show="dark" x-cloak>
                                <x:component::icon.sun class="h-5 w-5" />
                            </span>
                        </button>

                        <a
                            href="{{ route('componist.core.notification') }}"
                            class="inline-flex h-9 w-9 cursor-pointer items-center justify-center rounded-xl text-slate-600 transition duration-200 hover:bg-slate-100 hover:text-teal-600 focus:outline-none focus:ring-2 focus:ring-teal-500 dark:text-slate-300 dark:hover:bg-slate-800 dark:hover:text-teal-400"
                        >
                            @livewire('notification.componist-core-notification-bell')
                        </a>

                        <div class="relative" x-data="{ open: false }" @click.away="open = false" @close.stop="open = false">
                            <button
                                type="button"
                                @click.prevent="open = ! open"
                                class="inline-flex cursor-pointer items-center gap-2 rounded-xl px-2 py-1.5 text-sm font-medium text-slate-700 transition duration-200 hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-teal-500 dark:text-slate-200 dark:hover:bg-slate-800"
                            >
                                @php
                                    $storagePath = storage_path('app/' . Auth::user()->profile_photo_url);
                                    $photoUrl =
                                        ! empty(Auth::user()->profile_photo_url) &&
                                        file_exists($storagePath) &&
                                        Route::has('package.users.manager.profile-photo')
                                            ? route('package.users.manager.profile-photo')
                                            : null;
                                @endphp
                                @if ($photoUrl)
                                    <img class="h-7 w-7 rounded-full object-cover" src="{{ $photoUrl }}" alt="{{ Auth::user()->name }}" />
                                @else
                                    <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-teal-500 text-xs font-semibold text-white">
                                        {{ mb_substr(Auth::user()->name ?? 'U', 0, 1) }}
                                    </span>
                                @endif
                                <span class="hidden max-w-[10rem] truncate sm:inline">{{ Auth::user()->name }}</span>
                            </button>

                            <div
                                x-cloak
                                x-show="open"
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="transform opacity-0 scale-95 translate-y-1"
                                x-transition:enter-end="transform opacity-100 scale-100 translate-y-0"
                                x-transition:leave="transition ease-in duration-100"
                                x-transition:leave-start="transform opacity-100 scale-100"
                                x-transition:leave-end="transform opacity-0 scale-95"
                                class="absolute right-0 z-50 mt-2 w-56 origin-top-right overflow-hidden rounded-xl border border-slate-200 bg-white py-1 shadow-xl shadow-slate-900/10 dark:border-slate-700 dark:bg-slate-900 dark:shadow-black/40"
                            >
                                <div class="px-3 py-2 text-[11px] font-semibold uppercase tracking-[0.14em] text-slate-400 dark:text-slate-500">
                                    Konto
                                </div>

                                {{ menu('account-manager', 'account') }}

                                <x-componist-auth::logout-form
                                    button-class="flex w-full cursor-pointer items-center gap-2 px-3 py-2 text-left text-sm text-slate-700 transition-colors duration-200 hover:bg-slate-100 focus:outline-none dark:text-slate-200 dark:hover:bg-slate-800"
                                >
                                    Abmelden
                                    <x:component::icon.logout class="h-4 w-4 text-red-500" />
                                </x-componist-auth::logout-form>
                            </div>
                        </div>
                    </div>
                @endif
            </header>

            <main class="dash-canvas relative flex-1 overflow-y-auto">
                {{ $slot }}
            </main>
        </div>
    </div>

    @livewireScripts

</body>

</html>
