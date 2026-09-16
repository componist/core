# Componist Core

`componist/core` ist das Basis-Package fuer das Componist-Dashboard in Laravel.
Es liefert:

- Dashboard-Routen unter `/dashboard`
- Livewire-Module fuer Menues, Menu-Items, Settings und Notifications
- Blade-Komponenten und Layouts
- Datenbanktabellen inkl. Seeder fuer einen schnellen Start
- Helper-Funktionen zur Einbindung in eigene Views

---

## Inhalt

- [1) Voraussetzungen](#1-voraussetzungen)
- [2) Installation](#installation)
- [3) Publish-Tags im Ueberblick](#3-publish-tags-im-ueberblick)
- [4) Datenbank: Migrationen und Seeder](#4-datenbank-migrationen-und-seeder)
- [5) Routing und Module](#nutzung)
- [6) Berechtigungen und Sicherheit](#berechtigungen)
- [7) Konfiguration](#konfiguration)
- [8) Blade- und Livewire-Komponenten](#8-blade--und-livewire-komponenten)
- [9) Helper-Funktionen mit Beispielen](#9-helper-funktionen-mit-beispielen)
- [10) Benachrichtigungen erstellen](#10-benachrichtigungen-erstellen)
- [11) Assets (Vite, JS, CSS)](#11-assets-vite-js-css)
- [12) Typische Integrations-Workflows](#12-typische-integrations-workflows)
- [13) Troubleshooting](#hinweise)
- [14) Lizenz](#14-lizenz)

---

## 1) Voraussetzungen

- PHP `8.2+` (im Monorepo aktuell mit Laravel 12 genutzt)
- Laravel `12.x`
- Livewire `4.x`
- Node.js LTS (fuer Vite/Tailwind-Assets)

---

## Installation

### Monorepo (dieses Projekt)

Das Package ist bereits im Monorepo vorhanden. In der Regel reichen:

```bash
composer dump-autoload
php artisan package:discover
```

### Externes Projekt

Wenn du `componist/core` ausserhalb des Monorepos nutzt:

```bash
composer require componist/core
```

Hinweis: Je nach Setup brauchst du ggf. einen VCS- oder Path-Repository-Eintrag in der Host-`composer.json`.

---

## 3) Publish-Tags im Ueberblick

Der `CoreServiceProvider` stellt mehrere Tags bereit.

### Vollinstallation (empfohlen fuer schnellen Start)

```bash
php artisan vendor:publish --tag=componist.core.install
```

Veroeffentlicht:

- CSS/JS nach `resources/css` und `resources/js`
- `config/markdownx.php`
- `config/componist.php`
- `resources/views/dashboard.blade.php`
- `tailwind.config.js`, `vite.config.js`, `package.json` in die Projekt-Root

> Wichtig: Dieser Tag kann vorhandene Build-Dateien in der Root ueberschreiben.

### Weitere Tags

```bash
# Blade-Views + View-Komponenten-Klassen
php artisan vendor:publish --tag=core.publishes

# Core Components (Views)
php artisan vendor:publish --tag=core.components

# Error-Pages (Canonical unter packages/componist/core/resources/views/errors)
php artisan vendor:publish --tag=core.pages.errors

# Dashboard-Layout als anpassbare App-Kopie
php artisan vendor:publish --tag=core.page.dashboard
```

Error-Pages: Locale aus `app()->getLocale()`, Light/Dark, Primary Teal. Nach Änderungen im Package erneut publishen bzw. Root syncen.

---

## 4) Datenbank: Migrationen und Seeder

### Migrationen

Das Package laedt Migrationen automatisch (`loadMigrationsFrom`).

```bash
php artisan migrate
```

Relevante Tabellen:

- `menus`
- `menu_items` (inkl. `icon`, `page_id`, Indizes/FKs je nach Migrationstand)
- `settings`
- `componist_core_notifications`

### Seeder

```bash
php artisan db:seed --class="Componist\Core\Seeders\SettingsTableSeeder"
php artisan db:seed --class="Componist\Core\Seeders\MenuTableSeeder"
php artisan db:seed --class="Componist\Core\Seeders\MenuItemTableSeeder"
```

Der `MenuItemTableSeeder` legt u. a. Standardeintraege fuer folgende Route-Namen an:

- `dashboard.index`
- `componist.core.menus`
- `componist.core.settings`

---

## Nutzung

Das Package registriert seine Routen unter:

- Prefix: `/dashboard`
- Name-Prefix: `componist.core.`
- Middleware: `config('componist.auth')` (Standard: `['auth']`)

### Home-Routen (Auth)

- `dashboard.index` -> `/dashboard` (Middleware: `auth`, `twofactor`, `verify`)
- `profile` -> `/profile` (gleiche Middleware)
- Views: `component::backend.dashboard`, `component::backend.profile`

### Verfuegbare Routen (je nach Modul-Flags)

- `componist.core.settings` -> `/dashboard/settings`
- `componist.core.menus` -> `/dashboard/menu`
- `componist.core.menu.items` -> `/dashboard/menu/items/{id}`
- `componist.core.notification` -> `/dashboard/notification`
- `componist.core.notification.show` -> `/dashboard/notification/{componistCoreNotification}`

Beispiel zum Deaktivieren eines Bereichs:

```php
// config/componist.php
'routes' => [
    'settings' => true,
    'menu' => true,
],
```

---

## Berechtigungen

Standardmaessig wird eine Gate-Ability registriert:

- Ability: `componist.core.manage`
- Default-Logik: erlaubt, wenn `User->is_admin` truthy ist

Mutierende Aktionen in Menue- und Menu-Item-Livewire-Komponenten verwenden:

```php
Gate::authorize(config('componist.manage_ability', 'componist.core.manage'));
```

### Eigene Berechtigungsstrategie

In `config/componist.php`:

```php
'manage_ability' => 'admin.panel.manage',
```

Und in deiner App (z. B. in `AppServiceProvider`):

```php
use Illuminate\Support\Facades\Gate;

Gate::define('admin.panel.manage', function ($user): bool {
    return $user->hasRole('admin');
});
```

---

## Konfiguration

### `config/componist.php`

Wichtige Keys:

- `routes.*`: schaltet Dashboard-Module ein/aus
- `template.*`: Layout-Komponenten
- `dark_mode`: Feature-Flag fuer UI
- `auth`: Middleware-Stack fuer Dashboard-Routen
- `manage_ability`: Gate-Ability fuer Admin-Aktionen
- `select2.allowed_tables`: Allowlist fuer dynamische Select2-Datenquellen

### `config/config.php` (`componistConfig`)

Steuert die automatische Registrierung:

- `components`: Blade-Komponenten-Mapping
- `livewire`: Livewire-Komponenten-Mapping
- `prefix`: globaler Prefix fuer Aliasnamen

Prefix-Beispiel:

```php
// config/config.php
'prefix' => 'core-',
```

Dann lautet z. B. der Alias:

- Blade: `<x-core-layouts-dashboard />`
- Livewire: `@livewire('core-menu.index')`

---

## 8) Blade- und Livewire-Komponenten

### Form- und Button-Primitives (einheitlich)

Alle Form-/Button-Klassen liegen zentral in `Componist\Core\Support\Ui`. Nutze die Blade-Komponenten statt eigener Tailwind-Strings:

```blade
<x:component::form.label value="E-Mail" />
<x:component::form.input type="email" wire:model="email" />
<x:component::form.input-error for="email" />

<x:component::form.textarea wire:model="notes" />
<x:component::form.select wire:model="status">…</x:component::form.select>

<x:component::button.primary wire:click="save">Speichern</x:component::button.primary>
<x:component::button.secondary wire:click="cancel">Abbrechen</x:component::button.secondary>
```

Tokens (Auszug): `Ui::FIELD`, `Ui::TEXTAREA`, `Ui::LABEL`, `Ui::BUTTON_PRIMARY`, `Ui::BUTTON_SECONDARY`, `Ui::SURFACE`. Light/Dark und Teal-Focus sind darin enthalten; Fehlerzustände über `aria-invalid="true"`.

### Blade

```blade
<x-layouts-dashboard>
    <x-element-modal id="example-modal">
        <x-slot name="title">Beispiel</x-slot>
        Inhalt im Modal
    </x-element-modal>
</x-layouts-dashboard>
```

### Livewire

```blade
@livewire('menu.index')
@livewire('menu-item.index', ['id' => $menuId])
@livewire('notification.componist-core-notification-bell')
@livewire('notification.componist-core-notification')
```

---

## 9) Helper-Funktionen mit Beispielen

Das Package autoloaded `src/Helpers/helpers.php`.

### `setting(string $key)`

Liest einen Setting-Wert aus der Tabelle `settings`.

```php
$siteTitle = setting('site_title');
```

### `menu(string $menuName, ?string $type = null)`

Liefert ein Menue als HTML oder als Array.

```blade
{{-- Standard-Template --}}
{!! menu('admin') !!}

{{-- Spezifisches Template --}}
{!! menu('admin', 'vertical') !!}
```

```php
// Als Datenstruktur statt HTML
$items = menu('admin', 'array');
```

### `componist_menu_href($menuItem)`

Resolved den Link fuer einen Menu-Item anhand von Typ und Route-Fallback.

```php
$href = componist_menu_href($menuItem);
```

---

## 10) Benachrichtigungen erstellen

Du kannst programmatisch Eintraege fuer die Core-Notifications anlegen:

```php
use Componist\Core\Models\ComponistCoreNotification;

ComponistCoreNotification::CreateMessage(
    auth()->id(), // alternativ E-Mail als String
    'Deployment erfolgreich',
    'Das neue Release wurde erfolgreich ausgerollt.'
);
```

Die Notification-Livewire-Seiten zeigen anschliessend:

- Liste (`/dashboard/notification`)
- Detailansicht inkl. Read-Markierung (`/dashboard/notification/{id}`)

---

## 11) Assets (Vite, JS, CSS)

Nach `vendor:publish --tag=componist.core.install` stehen die Assets in deinem Host-Projekt bereit.

### Build

```bash
npm install
npm run build
```

### Development

```bash
npm run dev
```

Typische Files:

- `resources/css/dashboard.css`
- `resources/js/dashboard.js`
- `resources/js/tinymce.js`
- ggf. `resources/css/app.css`, `resources/js/app.js`, `resources/js/guest.js`

### Tailwind CSS: Componist-Views scannen

Damit Tailwind v4 Utility-Klassen aus Blade-Views aller installierten Componist-Packages erkennt, muss in den veröffentlichten CSS-Dateien folgende `@source`-Zeile enthalten sein:

```css
@source '../../vendor/componist/**/resources/views/**/*.blade.php';
```

Diese Zeile ist in den Package-CSS-Dateien (`app.css`, `dashboard.css`, `guest.css`) bereits vorkonfiguriert und wird beim Publish mit übernommen.

---

## 12) Typische Integrations-Workflows

### A) Schnellstart fuer internes Admin-Panel

1. Package installieren/autoloaden
2. `vendor:publish --tag=componist.core.install`
3. `php artisan migrate`
4. Seeder laufen lassen
5. `npm run build`
6. `/dashboard/menu` aufrufen und Menue pflegen

### B) Sicherheit zuerst (empfohlen in produktiven Projekten)

1. `manage_ability` auf eigene Ability setzen
2. Eigene `Gate::define(...)`-Regel hinterlegen
3. `componist.auth` um zusaetzliche Middleware erweitern (z. B. `verified`, `2fa`)
4. Optional `routes.*` auf benoetigte Module reduzieren

---

## Hinweise

### Menue-Links erscheinen nicht

- Pruefen, ob `name` oder `view_path` auf existierende Route zeigt.
- Bei `type=route/page` wird auf benannte Routen geprueft.

### Dashboard-Routen geben 403

- User hat keine freigegebene Ability (`manage_ability`).
- Gate-Regel und `is_admin`/Rollenmodell pruefen.

### Styles/Skripte fehlen

- Nach Publish `npm install` + `npm run build` ausfuehren.
- Bei lokaler Entwicklung `npm run dev` starten.

### Ueberschriebene Build-Dateien

- `componist.core.install` schreibt `package.json`, `vite.config.js`, `tailwind.config.js`.
- Vorher bestehende Dateien sichern oder gezielt einzelne Publish-Tags verwenden.

---

## Commands

Keine Artisan-Commands in diesem Package.

## Tests

```bash
php artisan test --compact --testsuite="Componist Core"
```

## 14) Lizenz

MIT