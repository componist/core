<?php

namespace Reinholdjesse\Core\Seeders;

use Illuminate\Database\Seeder;
use Reinholdjesse\Core\Models\MenuItem;

class MenuItemTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $value = $this->findRoute('dashboard');
        if (! $value->exists) {
            $value->fill([
                'menu_id' => '1',
                'title' => 'Dashboard',
                'type' => 'route',
                'order' => '1',
                'name' => 'dashboard',
                'created_at' => date('Y-m-d H:i:s'),
            ])->save();
        }

        $value = $this->findRoute('package.core.menus');
        if (! $value->exists) {
            $value->fill([
                'menu_id' => '1',
                'title' => 'Menu',
                'type' => 'route',
                'order' => '2',
                'name' => 'package.core.menus',
                'created_at' => date('Y-m-d H:i:s'),
            ])->save();
        }

        $value = $this->findRoute('package.core.settings');
        if (! $value->exists) {
            $value->fill([
                'menu_id' => '1',
                'title' => 'Settings',
                'type' => 'route',
                'order' => '3',
                'name' => 'package.core.settings',
                'created_at' => date('Y-m-d H:i:s'),
            ])->save();
        }

        $value = $this->findRoute('package.core.componentes');
        if (! $value->exists) {
            $value->fill([
                'menu_id' => '1',
                'title' => 'Components overflow',
                'type' => 'route',
                'order' => '4',
                'name' => 'package.core.componentes',
                'created_at' => date('Y-m-d H:i:s'),
            ])->save();
        }
    }

    protected function findRoute($key)
    {
        return MenuItem::firstOrNew(['name' => $key]);
    }
}
