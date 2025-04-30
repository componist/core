# Starter Kit Componist Core
folgende Komponente sind am Board

- [x] Menü Block und Menü Items
- [x] Benachrichtigung im Benutzer Account
- - [ ] Benachrichtigung per API URL erstellen

## Install



### Require Packages

```bash
composer require laravel/jetstream
```

### Install Packages

```bash

composer require componist/core
```

### Delete default Files

```bash
# Tailwind config file
del ./tailwind.config.js

# Vite config file
del ./vite.config.js

# Default Dashboard view
del ./resources/views/dashboard.blade.php

# Delete default app.css
del ./resources/css/app.css

#Delete default app.js
del ./resources/js/app.js

#Delete default package.json
del ./package.json
```

### Publish config file

```bash
#Configuration Install
php artisan vendor:publish --tag=core.install

# Blade Componentes Publishe (optional)
php artisan vendor:publish --tag=core.publishes

#Layout (optional)
# php artisan vendor:publish --tag=core.publishes.layouts // wurde auskommentiert

#Core Components (optional)
php artisan vendor:publish --tag=core.components

#Core ERRORS pages (optional)
php artisan vendor:publish --tag=core.pages.errors

#Core Dashboard pages (optional)
php artisan vendor:publish --tag=core.page.dashboard
```

### Core Seeder

run seed with

```bash
# Settings
 php artisan db:seed --class="Componist\Core\Seeders\SettingsTableSeeder"

# Menu
 php artisan db:seed --class="Componist\Core\Seeders\MenuTableSeeder"

# Menu Item
php artisan db:seed --class="Componist\Core\Seeders\MenuItemTableSeeder"

```

### Run NPM runner

```bash
npm run build
```

---


## Open
- [ ] Login System
- - login erst die email eingeben (email zwischen speichern) mal schauen wer alles versuch sich einzulogen
- - im account settings hast du die wahl wie du dich einlogen willst mit password oder email token
- - standart ist passwort