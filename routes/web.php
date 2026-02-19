<?php

use Illuminate\Support\Facades\Route;

Route::middleware(config('componist.auth'))->prefix('dashboard')->name('componist.core.')->group(function () {

    if (config('componist.routes.componentes')) {
        Route::get('componentes', [Componist\Core\Controllers\ComponentesViewController::class, 'index'])->name('componentes');
        Route::get('componente/resources/view', [Componist\Core\Controllers\ComponentesViewController::class, 'resources']);
    }

    if (config('componist.routes.settings')) {
        Route::livewire('settings', Componist\Core\Livewire\Setting\Index::class)->name('settings');
    }

    if (config('componist.routes.menu')) {
        Route::livewire('menu', Componist\Core\Livewire\Menu\Index::class)->name('menus');
        Route::livewire('menu/items/{id}', Componist\Core\Livewire\MenuItem\Index::class)->name('menu.items');
    }

    Route::livewire('notification', Componist\Core\Livewire\Notification\Notification::class)->name('notification');
    Route::livewire('notification/{componistCoreNotification}', Componist\Core\Livewire\Notification\NotificationShow::class)->name('notification.show');
});

Route::view('404', 'component::error.404')->name('404');

// TODO:: funktion ist noch nicht fertig
// stand funktioniert nicht richtig
// Route::get('/{pageslug}', [\Componist\Core\Controllers\PageController::class, 'index'])->name('page');

// dd(config('pages'));
// if (config()->has('pages')) {
//     foreach (config('pages') as $url => $viewPath) {
//         Route::view($url, $viewPath)->name($viewPath);
//     }
// }
