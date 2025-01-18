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
        'dashboard' => 'component::layouts.dashboard', // config('core.template.dashboard')
        'app' => 'component::layouts.app', // config('core.template.app')
    ],

    'dark_mode' => true,

];
