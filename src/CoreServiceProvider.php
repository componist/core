<?php

namespace Componist\Core;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class CoreServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

        $this->app->singleton('component', function () {
            return new Component;
        });

        
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'coreConfig');

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadSeedsFrom(__DIR__.'/../database/seeders');

        Route::group(['middleware' => ['web']], function () {
            $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        });

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'component');

        $this->loadHelpers();

        
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../resources/views/components' => resource_path('/views/components'),
            __DIR__.'/View/Components/Element' => app_path('View/Components/Element'),
        ], 'core.publishes');

        // $this->publishes([
        //     __DIR__ . '/../resources/views/layouts' => resource_path('/views/layouts'),
        //     __DIR__ . '/View/Components/AppLayout.php' => app_path('View/Components/AppLayout.php'),
        //     __DIR__ . '/View/Components/DashboardLayout.php' => app_path('View/Components/DashboardLayout.php'),
        //     __DIR__ . '/View/Components/GuestLayout.php' => app_path('View/Components/GuestLayout.php')], 'components.publishes.layouts');

        $this->publishes([
            // CSS & Javascript
            __DIR__.'/../resources/css/' => resource_path('css/'),
            __DIR__.'/../resources/js/' => resource_path('js/'),
            __DIR__.'/../tailwind.config.js' => base_path('tailwind.config.js'),
            __DIR__.'/../vite.config.js' => base_path('vite.config.js'),
            __DIR__.'/../package.json' => base_path('package.json'),
            // view
            __DIR__.'/../resources/views/backend/dashboard.blade.php' => resource_path('views/dashboard.blade.php'),
            // configs
            __DIR__.'/../config/markdownx.php' => config_path('markdownx.php'),
            __DIR__.'/../config/core.php' => config_path('core.php'),
        ], 'core.install');

        $this->publishes([
            // core components
            __DIR__.'/../resources/views/components' => resource_path('views/components'),
        ], 'core.components');

        $this->publishes([
            // errors pages
            __DIR__.'/../resources/views/errors' => resource_path('views/errors'),
        ], 'core.pages.errors');

        $this->publishes([
            // core dashboard publish in app
            __DIR__.'/../stubs/copy/DashboardLayout.php' => app_path('View/Components/DashboardLayout.php'),
            __DIR__.'/../resources/views/layouts/dashboard.blade.php' => resource_path('views/layouts/dashboard.blade.php'),
        ], 'core.page.dashboard');

        // blade componente
        $this->bootBladeComponents();

        // livewire componente
        $this->bootLivewireComponents();
    }

    /**
     * Load helpers.
     */
    protected function loadHelpers()
    {
        foreach (glob(__DIR__.'/Helpers/*.php') as $filename) {
            require_once $filename;
        }
    }

    private function bootBladeComponents()
    {
        foreach (config('coreConfig.components', []) as $alias => $component) {
            Blade::component(config('coreConfig.prefix').$alias, $component);
        }
    }

    private function bootLivewireComponents()
    {
        foreach (config('coreConfig.livewire', []) as $alias => $component) {
            Livewire::component(config('coreConfig.prefix').$alias, $component);
        }
    }
}