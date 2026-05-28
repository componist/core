<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Components
    |--------------------------------------------------------------------------
    |
    | Below you reference all components that should be loaded for your app.
    | You can disable or overwrite any component class or alias that you want.
    |
    */
    'components' => [
        'layouts.app' => Componist\Core\View\Components\AppLayout::class,
        // config('core.template.dashboard') => Componist\Core\View\Components\DashboardLayout::class,
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
    | for your app.
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
    | This value will set a prefix for all components.
    |
    */
    'prefix' => '',

    /*
    |--------------------------------------------------------------------------
    | Third Party Asset Libraries
    |--------------------------------------------------------------------------
    */
    'assets' => [],

    'features' => [
        // Component Fuatures
    ],

    'template' => [
        'dashboard' => Componist\Core\View\Components\DashboardLayout::class,
        'app' => Componist\Core\View\Components\GuestLayout::class,
    ],

    'dark_mode' => true,

    'auth' => ['auth'],

    /*
    |--------------------------------------------------------------------------
    | Core authorization
    |--------------------------------------------------------------------------
    |
    | Ability required for managing core admin features. This ability is
    | checked in mutating Livewire actions and can be customized by host apps.
    |
    */
    'manage_ability' => 'componist.core.manage',

    /*
    |--------------------------------------------------------------------------
    | Menu route aliases
    |--------------------------------------------------------------------------
    |
    | Maps legacy or short route names from menu_items to registered routes.
    |
    */
    'menu_route_aliases' => [
        'logout' => 'componist.auth.logout',
        'componist.auth.logout.show' => 'componist.auth.logout',
    ],

    /*
    |--------------------------------------------------------------------------
    | Select2 database allowlist
    |--------------------------------------------------------------------------
    |
    | Restrict dynamic database access in Select2 to known safe tables and
    | columns. Host applications can extend this list in published config.
    |
    */
    'select2' => [
        'allowed_tables' => [
            'menus' => ['id', 'name'],
            'menu_items' => ['id', 'title', 'slug', 'name', 'view_path', 'parent_id', 'menu_id', 'order', 'status', 'type'],
            'settings' => ['id', 'key', 'display_name', 'group', 'type', 'order', 'value'],
            'pages' => ['id', 'slug', 'title'],
        ],
    ],

];
