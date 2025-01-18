<?php

namespace Componist\Core;

use Illuminate\Support\Str;
use Componist\Core\Models\Menu;
use Componist\Core\Models\MenuItem;
use Componist\Core\Models\Setting;

class Component
{
    protected $models = [
        'Menu' => Menu::class,
        'MenuItem' => MenuItem::class,
    ];

    public function model($name)
    {
        return app($this->models[Str::studly($name)]);
    }

    public function setting(string $key)
    {
        return Setting::where('key', $key)->pluck('value');
    }
}
