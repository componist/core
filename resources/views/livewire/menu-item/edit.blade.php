<div>
    @if ($openEdit)
        <div
            x-data
            x-on:keydown.escape.window="$wire.cloasEditWindow()"
            class="fixed inset-0 z-50 flex items-end justify-center overflow-y-auto p-3 sm:items-center sm:p-6"
            role="presentation">
            {{-- Backdrop --}}
            <div
                wire:click="cloasEditWindow"
                class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm dark:bg-black/70"
                aria-hidden="true"></div>

            {{-- Panel --}}
            <div
                role="dialog"
                aria-modal="true"
                aria-labelledby="menu-item-dialog-title"
                aria-describedby="menu-item-dialog-desc"
                class="relative flex w-full max-w-xl max-h-[min(90vh,720px)] flex-col overflow-hidden rounded-xl border border-slate-200 bg-white shadow-2xl shadow-slate-900/20 dark:border-slate-700 dark:bg-slate-900 dark:shadow-black/40">

                {{-- Header --}}
                <div class="flex shrink-0 items-start gap-3 border-b border-slate-200 px-5 py-4 dark:border-slate-700">
                    <div class="min-w-0 flex-1">
                        <h2 id="menu-item-dialog-title"
                            class="text-base font-semibold tracking-tight text-slate-900 dark:text-white">
                            {{ $editId ? 'Menüpunkt bearbeiten' : 'Menüpunkt erstellen' }}
                        </h2>
                        <p id="menu-item-dialog-desc"
                            class="mt-1 text-sm leading-relaxed text-slate-500 dark:text-slate-400">
                            Sichtbarkeit, Ziel und Position in der Navigation festlegen.
                        </p>
                    </div>
                    <button
                        type="button"
                        wire:click="cloasEditWindow"
                        aria-label="Dialog schließen"
                        class="grid h-8 w-8 shrink-0 place-items-center rounded-lg text-slate-400 transition-colors hover:bg-slate-100 hover:text-slate-700 focus:outline-none focus:ring-2 focus:ring-teal-500 dark:text-slate-500 dark:hover:bg-slate-800 dark:hover:text-slate-200">
                        <svg class="h-4 w-4" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                            <path d="M4 4l8 8M12 4l-8 8" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" />
                        </svg>
                    </button>
                </div>

                {{-- Body --}}
                <div class="min-h-0 flex-1 space-y-6 overflow-y-auto overscroll-contain px-5 py-5">

                    {{-- Darstellung --}}
                    <fieldset class="space-y-4">
                        <legend class="text-xs font-semibold uppercase tracking-wide text-teal-600 dark:text-teal-400">
                            Darstellung
                        </legend>

                        <div>
                            <x:component::form.label value="Titel" />
                            <p class="mb-1.5 text-xs text-slate-500 dark:text-slate-400">
                                Label in der Sidebar oder Navigation.
                            </p>
                            <x:component::form.input wire:model.live="title" type="text" name="title"
                                placeholder="z. B. Inspiration Portfolio" />
                            <x:component::form.input-error :for="$title" />
                        </div>

                        <div>
                            <x:component::form.label value="Icon" />
                            <p class="mb-1.5 text-xs text-slate-500 dark:text-slate-400">
                                Optional – erscheint neben dem Titel.
                            </p>
                            @livewire('select2', [
                                'table' => '',
                                'event' => 'menuItemIconSelected',
                                'column' => 'name',
                                'order' => 'name',
                                'filter' => '',
                                'selected' => $icon,
                                'add_function' => true,
                                'key' => 'menu-item-icon',
                                'items' => $icons,
                            ])

                            @php
                                $isLocalIcon = ! empty($icon) && ! str_contains($icon, ':') && ! str_starts_with($icon, 'heroicon-');
                                $localIconView = $isLocalIcon ? 'component::components.icon.' . $icon : null;
                            @endphp
                            @if ($isLocalIcon && $localIconView && \Illuminate\Support\Facades\View::exists($localIconView))
                                <div
                                    class="mt-2 inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-slate-50 px-3 py-2 text-slate-600 dark:border-slate-700 dark:bg-slate-800/60 dark:text-slate-300">
                                    <x-dynamic-component :component="'component::icon.' . $icon" class="h-5 w-5 text-teal-500" />
                                    <span class="font-mono text-xs">{{ $icon }}</span>
                                </div>
                            @elseif (! empty($icon))
                                <div
                                    class="mt-2 inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-slate-50 px-3 py-2 text-slate-600 dark:border-slate-700 dark:bg-slate-800/60 dark:text-slate-300">
                                    <x-dynamic-component :component="$icon" class="h-5 w-5 text-teal-500" />
                                    <span class="font-mono text-xs">{{ $icon }}</span>
                                </div>
                            @endif
                        </div>
                    </fieldset>

                    {{-- Verhalten --}}
                    <fieldset class="space-y-4">
                        <legend class="text-xs font-semibold uppercase tracking-wide text-teal-600 dark:text-teal-400">
                            Verhalten
                        </legend>

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div>
                                <x:component::form.label value="Typ" />
                                <p class="mb-1.5 text-xs text-slate-500 dark:text-slate-400">
                                    Art des Menüeintrags.
                                </p>
                                <x:component::form.select wire:model.live="type">
                                    <x:component::form.select-option name="route" value="Route" />
                                    <x:component::form.select-option name="url" value="Externe URL" />
                                    <x:component::form.select-option name="page" value="Seite" />
                                    <x:component::form.select-option name="parent" value="Gruppe (ohne Link)" />
                                </x:component::form.select>
                                <x:component::form.input-error :for="$type" />
                            </div>

                            <div>
                                <x:component::form.label value="Ziel" />
                                <p class="mb-1.5 text-xs text-slate-500 dark:text-slate-400">
                                    Wo der Link geöffnet wird.
                                </p>
                                <x:component::form.select wire:model.live="target" name="target">
                                    <x:component::form.select-option name="_self" value="Gleicher Tab" />
                                    <x:component::form.select-option name="_blank" value="Neuer Tab" />
                                </x:component::form.select>
                                <x:component::form.input-error :for="$target" />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div>
                                <x:component::form.label value="Unterpunkt von" />
                                <p class="mb-1.5 text-xs text-slate-500 dark:text-slate-400">
                                    Leer = Eintrag auf oberster Ebene.
                                </p>
                                <x:component::form.select wire:model.live="parent_id" name="parent_id">
                                    <x:component::form.select-option name="" value="— Kein übergeordneter Eintrag —" />
                                    @foreach ($parentOptions as $value)
                                        <x:component::form.select-option name="{{ $value['id'] }}"
                                            value="{{ $value['title'] }}" />
                                    @endforeach
                                </x:component::form.select>
                                <x:component::form.input-error :for="$parent_id" />
                            </div>

                            <div>
                                <x:component::form.label value="Reihenfolge" />
                                <p class="mb-1.5 text-xs text-slate-500 dark:text-slate-400">
                                    Niedrigere Zahl = weiter oben.
                                </p>
                                <x:component::form.input wire:model.live="order" type="number" min="0" name="order" />
                                <x:component::form.input-error :for="$order" />
                            </div>
                        </div>
                    </fieldset>

                    {{-- Verknüpfung (typabhängig) --}}
                    @if ($type != 'parent')
                        <fieldset class="space-y-4">
                            <legend class="text-xs font-semibold uppercase tracking-wide text-teal-600 dark:text-teal-400">
                                Verknüpfung
                            </legend>

                            <div>
                                @if ($type === 'route')
                                    <x:component::form.label value="Routenname" />
                                    <p class="mb-1.5 text-xs text-slate-500 dark:text-slate-400">
                                        Laravel-Routenname, z. B. <span class="font-mono">package.inspiration.portfolio</span>
                                    </p>
                                    <x:component::form.input wire:model.live="name" type="text" name="name"
                                        class="font-mono" placeholder="package.beispiel.index" />
                                @elseif ($type === 'url')
                                    <x:component::form.label value="URL" />
                                    <p class="mb-1.5 text-xs text-slate-500 dark:text-slate-400">
                                        Vollständige Adresse inkl. https://
                                    </p>
                                    <x:component::form.input wire:model.live="name" type="url" name="name"
                                        placeholder="https://beispiel.de" />
                                    @if ($name == null)
                                        <p class="mt-1.5 text-xs text-red-500 dark:text-red-400">Bitte eine URL eingeben.</p>
                                    @endif
                                @else
                                    <x:component::form.label value="Name" />
                                    <p class="mb-1.5 text-xs text-slate-500 dark:text-slate-400">
                                        Interner Bezeichner für diesen Eintrag.
                                    </p>
                                    <x:component::form.input wire:model.live="name" type="text" name="name" />
                                @endif
                                <x:component::form.input-error :for="$name" />
                            </div>

                            @if ($type == 'url')
                                <div>
                                    <x:component::form.label value="Slug" />
                                    <p class="mb-1.5 text-xs text-slate-500 dark:text-slate-400">
                                        Kurzform für interne Referenzen (wird oft aus dem Titel erzeugt).
                                    </p>
                                    <x:component::form.input wire:model.live="slug" type="text" name="slug"
                                        class="font-mono" />
                                    <x:component::form.input-error :for="$slug" />
                                </div>
                            @endif

                            @if ($type == 'page')
                                <div>
                                    <x:component::form.label value="View-Pfad" />
                                    <p class="mb-1.5 text-xs text-slate-500 dark:text-slate-400">
                                        Blade-View-Pfad. Fehlt die Seite, wird ein Stub angelegt.
                                    </p>
                                    <x:component::form.input wire:model.live="view_path" type="text" name="view_path"
                                        class="font-mono" placeholder="page.beispiel" />
                                    <x:component::form.input-error :for="$view_path" />
                                </div>
                            @endif
                        </fieldset>
                    @else
                        <div
                            class="rounded-lg border border-teal-200/80 bg-teal-50 px-4 py-3 text-sm text-teal-800 dark:border-teal-800 dark:bg-teal-950/40 dark:text-teal-200">
                            Gruppen-Einträge haben keinen eigenen Link – sie dienen nur als Überschrift für Unterpunkte.
                        </div>
                    @endif
                </div>

                {{-- Footer --}}
                <div
                    class="flex shrink-0 flex-col-reverse gap-2 border-t border-slate-200 bg-slate-50 px-5 py-4 sm:flex-row sm:justify-end dark:border-slate-700 dark:bg-slate-800/60">
                    <x:component::button.secondary wire:click="cloasEditWindow" class="w-full sm:w-auto">
                        Abbrechen
                    </x:component::button.secondary>
                    <x:component::button.primary wire:click="update" class="w-full sm:w-auto">
                        Speichern
                    </x:component::button.primary>
                </div>
            </div>
        </div>
    @endif
</div>
