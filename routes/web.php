<?php

use Componist\Core\Models\MenuItem;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->prefix('dashboard')->name('componist.core.')->group(function () {

    if (config('core.routes.componentes')) {
        Route::get('componentes', [Componist\Core\Controllers\ComponentesViewController::class, 'index'])->name('componentes');
        Route::get('componente/resources/view', [Componist\Core\Controllers\ComponentesViewController::class, 'resources']);
    }

    if (config('core.routes.settings')) {
        Route::get('settings', Componist\Core\Livewire\Setting\Index::class)->name('settings');
    }

    if (config('core.routes.menu')) {
        Route::get('menu', Componist\Core\Livewire\Menu\Index::class)->name('menus');
        Route::get('menu/items/{id}', Componist\Core\Livewire\MenuItem\Index::class)->name('menu.items');
    }

    Route::get('notification', Componist\Core\Livewire\Notification\Notification::class)->name('notification');
    Route::get('notification/{componistCoreNotification}', Componist\Core\Livewire\Notification\NotificationShow::class)->name('notification.show');
});

Route::view('404', 'component::error.404')->name('404');

// TODO:: funktion ist noch nicht fertig
// stand funktioniert nicht richtig
// Route::get('/{pageslug}', [\Componist\Core\Controllers\PageController::class, 'index'])->name('page');

// dd(config('pages'));
if (config()->has('pages')) {
    foreach (config('pages') as $url => $viewPath) {
        Route::view($url, $viewPath)->name($viewPath);
    }
}

// $test = MenuItem::where('type','page')->get()->toArray();

// dd($test);

// try {
//     $pages = MenuItem::get();

//     dd($pages);
// } catch (Exception $e) {
//     dd($e);
// }