<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->prefix('dashboard')->name('package.core.')->group(function () {

    if (config('core.routes.componentes')) {
        Route::get('componentes', [Reinholdjesse\Core\Controllers\ComponentesViewController::class, 'index'])->name('componentes');
        Route::get('componente/resources/view', [Reinholdjesse\Core\Controllers\ComponentesViewController::class, 'resources']);
    }

    if (config('core.routes.settings')) {
        Route::get('settings', Reinholdjesse\Core\Livewire\Setting\Index::class)->name('settings');
    }

    if (config('core.routes.menu')) {
        Route::get('menu', Reinholdjesse\Core\Livewire\Menu\Index::class)->name('menus');
        Route::get('menu/items/{id}', Reinholdjesse\Core\Livewire\MenuItem\Index::class)->name('menu.items');
    }
});

Route::view('404', 'component::error.404')->name('404');

// TODO:: funktion ist noch nicht fertig
// stand funktioniert nicht richtig
// Route::get('/{pageslug}', [\Reinholdjesse\Core\Controllers\PageController::class, 'index'])->name('page');

// try {
//     $pages = MenuItem::get();

//     dd($pages);
// } catch (Exception $e) {
//     dd($e);
// }
