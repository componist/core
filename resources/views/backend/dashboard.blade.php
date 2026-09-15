@php
    use Illuminate\Support\Carbon;

    $user = Auth::user();
    $firstName = $user?->name ? explode(' ', trim($user->name))[0] : null;
    $hour = (int) now()->format('G');
    $greeting = match (true) {
        $hour < 11 => 'Guten Morgen',
        $hour < 18 => 'Guten Tag',
        default => 'Guten Abend',
    };
    $today = Carbon::now()->locale(app()->getLocale());

    $shortcutCandidates = [
        [
            'route' => 'package.todo.liste',
            'title' => 'To-Dos',
            'description' => 'Aufgaben und Listen',
            'icon' => 'list',
        ],
        [
            'route' => 'package.invoice.manager.index',
            'title' => 'Rechnungen',
            'description' => 'Erstellen und verwalten',
            'icon' => 'file',
        ],
        [
            'route' => 'package.customer.index',
            'title' => 'Kunden',
            'description' => 'Kontakte und Adressen',
            'icon' => 'user',
        ],
        [
            'route' => 'package.expense.manager.index',
            'title' => 'Ausgaben',
            'description' => 'Belege und Kosten',
            'icon' => 'database',
        ],
        [
            'route' => 'package.bookmark.index',
            'title' => 'Bookmarks',
            'description' => 'Links und Favoriten',
            'icon' => 'turned-in',
        ],
        [
            'route' => 'package.blog.index',
            'title' => 'Blog',
            'description' => 'Beiträge schreiben',
            'icon' => 'edit',
        ],
        [
            'route' => 'componist.core.notification',
            'title' => 'Mitteilungen',
            'description' => 'Benachrichtigungen',
            'icon' => 'notification',
        ],
        [
            'route' => 'profile',
            'title' => 'Profil',
            'description' => 'Kontoeinstellungen',
            'icon' => 'setting',
        ],
    ];

    $shortcuts = collect($shortcutCandidates)
        ->filter(fn (array $item): bool => Route::has($item['route']))
        ->values()
        ->take(6);

    $availableCount = $shortcuts->count();
@endphp

<x:component::layouts.dashboard>
    <div class="mx-auto w-full max-w-7xl px-4 py-6 sm:px-6 sm:py-8 lg:px-8">
        <header class="dash-enter dash-enter-1 mb-8 max-w-2xl">
            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-teal-600 dark:text-teal-400">
                Arbeitsbereich
            </p>
            <h1 class="mt-2 font-display text-3xl font-semibold tracking-tight text-slate-900 sm:text-4xl dark:text-white">
                {{ $greeting }}{{ $firstName ? ', '.$firstName : '' }}
            </h1>
            <p class="mt-3 text-sm leading-relaxed text-slate-600 sm:text-base dark:text-slate-300">
                Du bist angemeldet. Wähle einen Einstieg unten oder nutze die Navigation links.
            </p>
        </header>

        <div class="dash-enter dash-enter-2 overflow-hidden rounded-lg border border-slate-200 bg-slate-200 dark:border-slate-800 dark:bg-slate-800">
            <div class="grid grid-cols-1 gap-px sm:grid-cols-2 lg:grid-cols-6">
            {{-- Hero --}}
            <section
                class="group relative col-span-1 flex min-h-[220px] flex-col justify-between overflow-hidden bg-gradient-to-br from-teal-500 via-teal-600 to-teal-800 p-6 text-white sm:col-span-2 sm:min-h-[260px] sm:p-8 lg:col-span-4 lg:row-span-2"
            >
                <div class="pointer-events-none absolute -right-16 -top-20 size-56 rounded-full bg-white/10 blur-3xl transition duration-700 group-hover:translate-x-4 group-hover:translate-y-2" aria-hidden="true"></div>
                <div class="pointer-events-none absolute -bottom-20 -left-10 size-48 rounded-full bg-teal-950/40 blur-3xl" aria-hidden="true"></div>
                <div class="dash-trace absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-white/40 to-transparent" aria-hidden="true"></div>

                <div class="relative flex items-center gap-3">
                    <span class="inline-flex size-10 items-center justify-center rounded-lg bg-white/15 ring-1 ring-white/25" aria-hidden="true">
                        <span class="dash-mark-spin size-3.5 rotate-45 rounded-[3px] bg-white"></span>
                    </span>
                    <div>
                        <p class="text-sm font-semibold tracking-tight">{{ config('app.name') }}</p>
                        <p class="text-xs text-white/75">Package-Monorepo</p>
                    </div>
                </div>

                <div class="relative mt-10 space-y-3 sm:mt-auto">
                    <h2 class="max-w-[18ch] font-display text-2xl font-semibold leading-tight tracking-tight sm:text-3xl">
                        Alles an einem Ort – klar und ruhig.
                    </h2>
                    <p class="max-w-md text-sm leading-relaxed text-white/85">
                        Rechnungen, Aufgaben, Kunden und Tools liegen in Packages. Dieser Überblick führt dich dorthin, ohne Lärm.
                    </p>
                </div>
            </section>

            {{-- Datum --}}
            <section class="col-span-1 flex flex-col justify-between bg-white p-6 sm:col-span-1 lg:col-span-2 dark:bg-slate-900">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Heute</p>
                    <p class="mt-3 font-display text-3xl font-semibold tracking-tight text-slate-900 tabular-nums dark:text-white">
                        {{ $today->isoFormat('D. MMM') }}
                    </p>
                    <p class="mt-1 text-sm capitalize text-slate-600 dark:text-slate-300">
                        {{ $today->isoFormat('dddd') }}
                    </p>
                </div>
                <p class="mt-6 text-xs text-slate-500 dark:text-slate-400">
                    {{ $today->isoFormat('HH:mm') }} Uhr · {{ config('app.timezone') }}
                </p>
            </section>

            {{-- Status --}}
            <section class="col-span-1 flex flex-col justify-between bg-white p-6 sm:col-span-1 lg:col-span-2 dark:bg-slate-900">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Schnellzugriff</p>
                    <p class="mt-3 font-display text-3xl font-semibold tracking-tight text-slate-900 tabular-nums dark:text-white">
                        {{ $availableCount }}
                    </p>
                    <p class="mt-1 text-sm text-slate-600 dark:text-slate-300">
                        {{ $availableCount === 1 ? 'Bereich bereit' : 'Bereiche bereit' }}
                    </p>
                </div>
                <div class="mt-6 flex items-center gap-2 text-xs text-teal-700 dark:text-teal-300">
                    <span class="relative flex size-2">
                        <span class="absolute inline-flex size-full animate-ping rounded-full bg-teal-400 opacity-60"></span>
                        <span class="relative inline-flex size-2 rounded-full bg-teal-500"></span>
                    </span>
                    Session aktiv
                </div>
            </section>

            {{-- Shortcuts --}}
            <section class="col-span-1 bg-white p-6 sm:col-span-2 lg:col-span-4 dark:bg-slate-900">
                <div class="mb-4 flex items-end justify-between gap-3">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Einstiege</p>
                        <h3 class="mt-1 text-lg font-semibold tracking-tight text-slate-900 dark:text-white">Häufig genutzt</h3>
                    </div>
                </div>

                @if ($shortcuts->isEmpty())
                    <p class="text-sm text-slate-600 dark:text-slate-300">
                        Noch keine Feature-Routen gefunden. Öffne ein Package über die linke Navigation.
                    </p>
                @else
                    <ul class="grid grid-cols-1 gap-1 sm:grid-cols-2">
                        @foreach ($shortcuts as $index => $item)
                            <li class="dash-enter dash-enter-{{ min($index + 3, 8) }}">
                                <a
                                    href="{{ route($item['route']) }}"
                                    class="group flex items-start gap-3 rounded-lg p-3 transition duration-200 hover:bg-slate-50 dark:hover:bg-slate-800/80"
                                >
                                    <span
                                        class="inline-flex size-9 shrink-0 items-center justify-center rounded-md bg-teal-50 text-teal-600 transition duration-200 group-hover:bg-teal-500 group-hover:text-white dark:bg-teal-950/50 dark:text-teal-300 dark:group-hover:bg-teal-500 dark:group-hover:text-white"
                                        aria-hidden="true"
                                    >
                                        @switch($item['icon'])
                                            @case('list')
                                                <x:component::icon.list class="h-4 w-4" />
                                                @break
                                            @case('file')
                                                <x:component::icon.file class="h-4 w-4" />
                                                @break
                                            @case('user')
                                                <x:component::icon.user class="h-4 w-4" />
                                                @break
                                            @case('database')
                                                <x:component::icon.database class="h-4 w-4" />
                                                @break
                                            @case('turned-in')
                                                <x:component::icon.turned-in class="h-4 w-4" />
                                                @break
                                            @case('edit')
                                                <x:component::icon.edit class="h-4 w-4" />
                                                @break
                                            @case('notification')
                                                <x:component::icon.notification class="h-4 w-4" />
                                                @break
                                            @default
                                                <x:component::icon.setting class="h-4 w-4" />
                                        @endswitch
                                    </span>
                                    <span class="min-w-0 flex-1">
                                        <span class="flex items-center justify-between gap-2">
                                            <span class="truncate text-sm font-semibold text-slate-900 dark:text-white">{{ $item['title'] }}</span>
                                            <span class="text-slate-400 transition duration-200 group-hover:translate-x-0.5 group-hover:text-teal-500 dark:text-slate-500 dark:group-hover:text-teal-400" aria-hidden="true">→</span>
                                        </span>
                                        <span class="mt-0.5 block text-xs text-slate-500 dark:text-slate-400">{{ $item['description'] }}</span>
                                    </span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </section>

            {{-- Hinweis --}}
            <section class="col-span-1 flex flex-col justify-between bg-slate-950 p-6 text-white sm:col-span-2 lg:col-span-2">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-teal-300/90">Hinweis</p>
                    <h3 class="mt-2 text-lg font-semibold tracking-tight">Navigation bleibt die Quelle der Wahrheit</h3>
                    <p class="mt-2 text-sm leading-relaxed text-slate-300">
                        Menüpunkte und Rechte kommen aus Core. Dieser Überblick zeigt nur verfügbare Einstiege.
                    </p>
                </div>
                @if (Route::has('componist.core.menus'))
                    <a
                        href="{{ route('componist.core.menus') }}"
                        class="mt-6 inline-flex items-center gap-2 text-sm font-medium text-teal-300 transition hover:gap-3 hover:text-teal-200"
                    >
                        Menüs verwalten
                        <span aria-hidden="true">→</span>
                    </a>
                @endif
            </section>
            </div>
        </div>
    </div>
</x:component::layouts.dashboard>
