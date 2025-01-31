<?php

use Componist\Core\View\Components\AppLayout;
use Componist\Core\View\Components\DashboardLayout;
use Componist\Core\View\Components\Element\Datepicker;
use Componist\Core\View\Components\Element\DropFile;
use Componist\Core\View\Components\Element\Modal;
use Componist\Core\View\Components\GuestLayout;

return [

    /*
    |--------------------------------------------------------------------------
    | Components
    |--------------------------------------------------------------------------
    |
    | Below you reference all components that should be loaded for your app.
    | By default all components from Blade UI Kit are loaded in. You can
    | disable or overwrite any component class or alias that you want.
    |
     */

    'components' => [
        'component::layouts.app' => AppLayout::class,
        config('core.template.dashboard') => DashboardLayout::class,
        'component::layouts.guest' => GuestLayout::class,

        'component::element.modal' => Modal::class,
        'component::element.datepicker' => Datepicker::class,
        'component::element.drop-file' => DropFile::class,
    ],
    /*
    |--------------------------------------------------------------------------
    | Livewire Components
    |--------------------------------------------------------------------------
    |
    | Below you reference all the Livewire components that should be loaded
    | for your app. By default all components from Blade UI Kit are loaded in.
    |
     */

    'livewire' => [
        'markdown-x' => Componist\Core\Livewire\Element\MarkdownX::class,
        'select2' => Componist\Core\Livewire\Element\Select2::class,
        'element.hex-colors' => Componist\Core\Livewire\Element\HexColors::class,

        'component::setting.index', Componist\Core\Livewire\Setting\Index::class,
        'component::menu.index', Componist\Core\Livewire\Menu\Index::class,
        'component::menu.edit', Componist\Core\Livewire\Menu\Edit::class,
        'component::menu-item.index', Componist\Core\Livewire\MenuItem\Index::class,
        'component::menu-item.edit', Componist\Core\Livewire\MenuItem\Edit::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Components Prefix
    |--------------------------------------------------------------------------
    |
    | This value will set a prefix for all Blade UI Kit components.
    | By default it's empty. This is useful if you want to avoid
    | collision with components from other libraries.
    |
    | If set with "buk", for example, you can reference components like:
    |
    | <x-buk-easy-mde />
    |
     */

    'prefix' => '',

    /*
    |--------------------------------------------------------------------------
    | Third Party Asset Libraries
    |--------------------------------------------------------------------------
    |
    | These settings hold reference to all third party libraries and their
    | asset files served through a CDN. Individual components can require
    | these asset files through their static `$assets` property.
    |
     */

    'assets' => [],

];
