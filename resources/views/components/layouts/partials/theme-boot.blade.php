{{--
    Theme: Alpine.store('theme') steuert Dark/Light vollständig.
    Das kurze Blocking-Script verhindert nur FOUC, bis Alpine startet.
    Nach Livewire wire:navigate wird die Klasse über den Store erneut gesetzt.
--}}
<script>
    (function () {
        try {
            var theme = localStorage.getItem('theme');
            var prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            var isDark = theme === 'dark' || (!theme && prefersDark);
            document.documentElement.classList.toggle('dark', isDark);
        } catch (e) {}
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
                try {
                    var theme = localStorage.getItem('theme');

                    if (theme === 'dark') {
                        this.dark = true;
                    } else if (theme === 'light') {
                        this.dark = false;
                    } else {
                        this.dark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                    }
                } catch (e) {
                    this.dark = false;
                }
            },

            apply() {
                document.documentElement.classList.toggle('dark', this.dark);
            },

            toggle() {
                this.dark = ! this.dark;
                localStorage.setItem('theme', this.dark ? 'dark' : 'light');
                this.apply();
                window.dispatchEvent(new CustomEvent('theme-changed', { detail: { dark: this.dark } }));
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
                    if (! store) {
                        return;
                    }
                    store.syncFromStorage();
                    store.apply();
                });
            },
        });
    });
</script>
<style>[x-cloak]{display:none!important}</style>
