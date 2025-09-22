<?php

return [

    'features' => [
        // Component Fuatures
    ],

    'routes' => [
        'settings' => true,
        'menu' => true,
        'componentes' => true,
    ],

    'template' => [
        'dashboard' => Componist\Core\View\Components\DashboardLayout::class,
        'app' => Componist\Core\View\Components\GuestLayout::class,
    ],

    'dark_mode' => true,

    'auth' => ['auth'],

];
