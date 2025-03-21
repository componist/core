<?php

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
        'layouts.app' => Componist\Core\View\Components\AppLayout::class,
        //config('core.template.dashboard') => Componist\Core\View\Components\DashboardLayout::class,
        'layouts.dashboard' => Componist\Core\View\Components\DashboardLayout::class,
        'layouts.guest' => Componist\Core\View\Components\GuestLayout::class,

        'element.modal' => Componist\Core\View\Components\Element\Modal::class,
        'element.datepicker' => Componist\Core\View\Components\Element\Datepicker::class,
        'element.drop-file' => Componist\Core\View\Components\Element\DropFile::class,
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

        'setting.index' => Componist\Core\Livewire\Setting\Index::class,
        'setting.test-mail-notification' => Componist\Core\Livewire\Setting\TestMailNotification::class,

        'menu.index' => Componist\Core\Livewire\Menu\Index::class,
        'menu.edit' => Componist\Core\Livewire\Menu\Edit::class,
        'menu-item.index' => Componist\Core\Livewire\MenuItem\Index::class,
        'menu-item.edit' => Componist\Core\Livewire\MenuItem\Edit::class,

        'notification.componist-core-notification-bell' => \Componist\Core\Livewire\Notification\ComponistCoreNotificationBell::class,
        'notification.componist-core-notification' => \Componist\Core\Livewire\Notification\Notification::class,
        'notification.componist-core-notification-show' => \Componist\Core\Livewire\Notification\NotificationShow::class,
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