# AGENTS – Componist Core

## Zweck

Basis-Package für Dashboard-Layouts, Menüs, Settings, Notifications und gemeinsame Blade-/Livewire-Komponenten.

## Grenzen & Abhängigkeiten

- Gehört rein: Layouts, **gemeinsame UI-Primitives** (Form, Button, Page, Table, Element, …), Menü/Settings/Notifications, Home-Routen `dashboard.index` / `profile`
- Gehört nicht: Feature-Domänen (Invoice, Bookmarks, …), Auth-Flows (→ `componist/auth`), Local-Dev-Endpoints (→ `componist/developer-tools`)
- Abhängigkeit: Livewire, `componist/reminder-notifications`
- **Host-Regel:** Jedes Feature-Package muss `componist/core` require-n und **nur** Core-UI nutzen. Fehlt eine Komponente → hier in Core anlegen (`resources/views/components/…` + `Support\Ui`), nicht im Feature-Package (Cursor-Rule `componist-core-ui.mdc`)

## Struktur

```
routes/web.php          # dashboard.index, profile, settings/menu/notification
resources/views/backend/{dashboard,profile}.blade.php
resources/views/errors/ # Canonical Error-Pages (Publish: core.pages.errors)
src/Domain/MenuRules.php
src/Application/MenuService.php
src/Livewire/{Menu,MenuItem,Setting,Notification,Element}
src/View/Components/
src/Support/{PublicRemoteHost,SafeHtml,SvgSanitizer,SecretToken}.php
src/Models/Concerns/BelongsToUser.php
src/Http/Middleware/SetSecurityHeaders.php
```

## Einbindung

- Provider: `Componist\Core\CoreServiceProvider`
- Config: `config('componist')` (Host oft published)
- Views: `component::…`
- Auth-Home: `config('componist_auth.home')` → `dashboard.index`
- **Lokal im Monorepo:** Path-Symlink Pflicht (`packages/componist/core` ↔ `vendor/componist/core`). Host: `composer run componist-link`. Siehe `packages/componist/AGENTS.md` und `.cursor/rules/componist-local-path-packages.mdc`.

## Konventionen

- UI-Texte: Deutsch
- Light + Dark (`dark:`) — `class="dark"` auf `<html>`, Toggle in der Topbar
- Primary: Teal
- **Form-/Button-Styles:** zentral in `Componist\Core\Support\Ui` (`FIELD`, `TEXTAREA`, `LABEL`, `BUTTON_*`, `BUTTON_FAB`, `TAB_*`, `SURFACE`, …). Blade-Primitives unter `components/form/*`, `components/button/*`, `element/search|password|datepicker|…` müssen diese Tokens nutzen – keine abweichenden Radii (`rounded-md`), Focus-Ringe (`ring-teal-500/30`) oder Padding-Werte
- Resource-UI: `page.shell` / `page.form` / `button.primary` / `element.confirm-delete`
- Menüpunkt-Dialog (`livewire/menu-item/edit`): Header + Beschreibung, Fieldsets mit Hilfetexten, typabhängige Verknüpfungsfelder, Sticky-Footer (`button.secondary` / `button.primary`), Escape/Backdrop schließen
- Dashboard-Home: Bento-Übersicht (`backend/dashboard`) mit Greeting, echten Route-Shortcuts, Light/Dark und `dash-enter`-Motion (`prefers-reduced-motion` beachten)
- Dashboard-Chrome: Teal-Marke, Glas-Topbar, Sidebar-Userfuß, Canvas-Glow; Display-Font Sora via `font-display`
- Flash: Trait `addLivewireControlleFunctions` / `flashMessage()`

## Tests

```bash
php artisan test --compact --testsuite="Componist Core"
```

## Security

- Home-Routen: `auth` (Verify + 2FA über Persist-Middleware / Auth-Alias)
- Settings/Menus: Ability `componist.core.manage` für Mutationen
- Select2 nur allowlistete Tabellen/Spalten
- SSRF: `PublicRemoteHost` (http/https, IP-Coercion, DNS-Resolve, keine Redirects)
- HTML/SVG: `SafeHtml` / `SvgSanitizer`
- Tokens: `SecretToken` (SHA-256 + `hash_equals`)
- Security-Headers via `SetSecurityHeaders` (nosniff, SAMEORIGIN, Referrer-Policy, CSP `frame-ancestors`)
- `BelongsToUser`: `scopeForUser` / Route-Binding für Invoice, Expense, Customer, ToDo

## Do / Don’t

- Do: Dashboard/Profil-Views im Package halten (`component::backend.*`)
- Do: Neue wiederverwendbare UI (Input-Varianten, Badges, Filter-Bars, …) **hier** als `x:component::…` + `Ui`-Token bauen
- Do: Error-Views zuerst in Core ändern, dann nach Root syncen (`php artisan vendor:publish --tag=core.pages.errors`)
- Don’t: Feature-Packages eigene parallele Form-/Button-/Table-Komponenten erlauben
- Don’t: Root `routes/web.php` wieder mit Dashboard-Routen füllen
- Don’t: Error-Layouts nur in Root anpassen (Publish überschreibt)
