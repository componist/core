<?php

namespace Reinholdjesse\Core;

use Illuminate\Support\Str;
use Reinholdjesse\Core\Models\Menu;
use Reinholdjesse\Core\Models\MenuItem;
use Reinholdjesse\Core\Models\Setting;

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
