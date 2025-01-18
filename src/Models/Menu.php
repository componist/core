<?php

namespace Reinholdjesse\Core\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\View;
use Illuminate\Support\HtmlString;

class Menu extends Model
{
    use HasFactory;

    /**
     * Generate menu.
     */
    public function display(string $menuName, ?string $type = null): mixed
    {
        $menu = Menu::where('name', $menuName)->with(['parent_items.children' => function ($query) {
            $query->orderBy('order');
        },
        ])->first();

        if ($menu != null) {
            $items = $menu->parent_items->sortBy('order');

            // dd($items);

            if (isset($type) && ! empty($type)) {
                return new HtmlString(View::make('component::template.menu.'.$type, ['items' => $items])->render());
            }

            return new HtmlString(View::make('component::template.menu.default', ['items' => $items])->render());
        }

        return null;
    }

    /**
     * @return HasMany<MenuItem>
     */
    public function parent_items(): HasMany
    {
        return $this->hasMany(MenuItem::class)
            ->whereNull('parent_id');
    }
}
