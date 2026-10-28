<?php

namespace Componist\Core;

use Componist\Core\Models\Menu;
use Componist\Core\Models\MenuItem;
use Componist\Core\Models\Setting;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class Component
{
    /** @var array<string, class-string<Model>> */
    protected array $models = [
        'Menu' => Menu::class,
        'MenuItem' => MenuItem::class,
    ];

    public function model(string $name): Model
    {
        return app($this->models[Str::studly($name)]);
    }

    /**
     * @return Collection<int, mixed>
     */
    public function setting(string $key): Collection
    {
        return Setting::where('key', $key)->pluck('value');
    }
}
