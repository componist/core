<?php

return [

    'features' => [
        // Component Fuatures
    ],

    'routes' => [
        'settings' => true,
        'menu' => true,
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
