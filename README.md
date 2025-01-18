## Install

### Require Packages

```bash
composer require laravel/jetstream
```

### Install Packages

```bash

composer require reinholdjesse/core
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
 php artisan db:seed --class="Reinholdjesse\Core\Seeders\SettingsTableSeeder"

# Menu
 php artisan db:seed --class="Reinholdjesse\Core\Seeders\MenuTableSeeder"

# Menu Item
php artisan db:seed --class="Reinholdjesse\Core\Seeders\MenuItemTableSeeder"

```

### Run NPM runner

```bash
npm run build
```

---

## Componentes

### Componenten list

```url
http://127.0.0.1:8000/dashboard/componentes
```

### get all components from App/resources folder as list.

http:your-url/**componente/resources/view**

### Componenten include

```php
# Input Label
 <x:component::form.label value="Package" />

# Controlle elements
<div class="flex gap-5">
    <x:component::button.show />

    <x:component::button.edit />

    <x:component::button.delete />

</div>

# Search Componente
<x:component::icon.search class="h-16" />
```

### Modal

```php
<x:component::element.modal>
    <x-slot:trigger>

        <x:component::button.delete @click.prevent="modal=true" />

    </x-slot:trigger>

    <x-slot:content>
        <div class="flex justify-center ">
            <div
                class="flex items-center justify-center text-red-500 bg-red-200 rounded-full shadow-sm w-28 h-28">
                <x:component::icon.delete class="h-16" />
            </div>
        </div>
        <div class="flex justify-center mt-7">
            <h3 class="text-lg font-bold text-center text-gray-700">unwiderruflich löschen?</h3>
        </div>
    </x-slot:content>

    <x-slot:controller>
        <button @click.prevent="modal=false" type="button"
            class="flex justify-center w-full px-4 py-2 mr-2 font-medium text-center text-white bg-gray-300 border border-transparent rounded-md shadow-sm hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">Abbrechen</button>

        <button @click.prevent="modal=false" type="button"
            class="flex justify-center w-full px-4 py-2 font-medium text-center text-white bg-red-500 border border-transparent rounded-md shadow-sm hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">löschen</button>
    </x-slot:controller>
</x:component::element.modal>
```

### Components Datepicker / Drop-File

```php
<x:component::datepicker model="date" />

<x-component::drop-file wire:model.live='temp_files' name="temp_files" title="jpg, png, pdf, docx (MAX. 10Mb)" />

```

---

## Livewire Komponente übersicht / einbinden

```php
# Markdown Editor include livewire componente
@livewire('markdown-x', ['content' => $content])

# controller livewire
protected $listeners = [
    'markdown-x:update' => 'updateBody',
];

# add Methode
public function updateBody($value)
{
    $this->content = $value;
}

------------------------------------

# select 2 include
@livewire('select2', [
    'table' => 'users',
    'event' => 'userId',
    'order' => 'name',
    'filter' => 'deleted_at,NULL',
    'selected' => $user_id,
    'add_function' => true,
])

# controller livewire
 protected $listeners = [
    'userId' => 'updateUserId',
];
# add methode
public function updateUserId(int $id = null)
{
    $this->user_id = $id;
}

```

## Layouts

```php
<x:component::layouts.guest>
    Dashboard Guest
</x:component::layouts.guest>


<x:component::layouts.app>
    Dashboard App
</x:component::layouts.app>


<x:component::layouts.dashboard>
    Dashboard Layout
</x:component::layouts.dashboard>
```

## Copy all packages components in your App (app/resources/views/components) (optional)

Dann kann die Komponente ganz normal aufgerufen werden.

```php
<x-form.label value="Package" />
```
