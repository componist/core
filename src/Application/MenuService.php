<?php

declare(strict_types=1);

namespace Componist\Core\Application;

use Componist\Core\Domain\MenuRules;
use Componist\Core\Models\Menu;

final class MenuService
{
    public static function save(?int $id, string $name): Menu
    {
        if ($id !== null) {
            $menu = Menu::query()->findOrFail($id);
        } else {
            $menu = new Menu;
        }

        $menu->name = $name;
        $menu->save();

        return $menu;
    }

    public static function delete(Menu $menu): bool
    {
        if (! MenuRules::canDelete((string) $menu->name)) {
            return false;
        }

        return (bool) $menu->delete();
    }
}
