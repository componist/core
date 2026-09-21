{{--
    Theme: Alpine.store('theme') steuert Dark/Light vollständig.
    Das kurze Blocking-Script verhindert nur FOUC, bis Alpine startet.
    Nach Livewire wire:navigate wird die Klasse über den Store erneut gesetzt.
    Mobile: localStorage kann werfen (Safari privat, blockierte Site-Daten) — Toggle muss trotzdem greifen.
    bfcache (pageshow) stellt Seiten mit altem Zustand wieder her — daher Re-Sync.
--}}
<meta name="color-scheme" content="light dark">
<script>
    (function () {
        var isDark = false;

        try {
            var theme = localStorage.getItem('theme');
            var prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            isDark = theme === 'dark' || (!theme && prefersDark);
        } catch (e) {
            try {
                isDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            } catch (e2) {}
        }

        document.documentElement.classList.toggle('dark', isDark);
    })();
</script>
<script>
    document.addEventListener('alpine:init', function () {
        if (window.Alpine.store('theme')) {
            return;
        }

        window.Alpine.store('theme', {
            dark: false,

            init() {
                this.syncFromStorage();
                this.apply();
                this.bindNavigate();
            },

            syncFromStorage() {
                var theme = null;

                try {
                    theme = localStorage.getItem('theme');
                } catch (e) {}

                if (theme === 'dark') {
                    this.dark = true;
                } else if (theme === 'light') {
                    this.dark = false;
                } else {
                    this.dark = document.documentElement.classList.contains('dark');
                }
            },

            apply() {
                document.documentElement.classList.toggle('dark', this.dark);
            },

            persist() {
                try {
                    localStorage.setItem('theme', this.dark ? 'dark' : 'light');
                } catch (e) {}
            },

            toggle() {
                this.dark = ! this.dark;
                this.apply();
                this.persist();
                window.dispatchEvent(new CustomEvent('theme-changed', { detail: { dark: this.dark } }));
                window.dispatchEvent(new CustomEvent('auth-theme-change', { detail: { dark: this.dark } }));
            },

            resync() {
                this.syncFromStorage();
                this.apply();
                window.dispatchEvent(new CustomEvent('auth-theme-change', { detail: { dark: this.dark } }));
            },

            bindNavigate() {
                if (window.__componistThemeNavigateBound) {
                    return;
                }

                window.__componistThemeNavigateBound = true;

                document.addEventListener('livewire:navigating', function (event) {
                    if (event.detail && typeof event.detail.onSwap === 'function') {
                        event.detail.onSwap(function () {
                            var store = window.Alpine.store('theme');
                            if (store) {
                                store.apply();
                            }
                        });
                    }
                });

                document.addEventListener('livewire:navigated', function () {
                    var store = window.Alpine.store('theme');
                    if (store) {
                        store.resync();
                    }
                });

                window.addEventListener('pageshow', function (event) {
                    var store = window.Alpine.store('theme');
                    if (event.persisted && store) {
                        store.resync();
                    }
                });

                window.addEventListener('storage', function (event) {
                    var store = window.Alpine.store('theme');
                    if (event.key === 'theme' && store) {
                        store.resync();
                    }
                });
            },
        });
    });
</script>
<style>[x-cloak]{display:none!important}</style>
