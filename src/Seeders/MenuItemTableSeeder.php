<?php

namespace Componist\Core\Seeders;

use Componist\Core\Models\MenuItem;
use Illuminate\Database\Seeder;

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
                'name' => 'dashboard.index',
                'created_at' => date('Y-m-d H:i:s'),
            ])->save();
        }

        $value = $this->findRoute('componist.core.menus');
        if (! $value->exists) {
            $value->fill([
                'menu_id' => '1',
                'title' => 'Menu',
                'type' => 'route',
                'order' => '2',
                'name' => 'componist.core.menus',
                'created_at' => date('Y-m-d H:i:s'),
            ])->save();
        }

        $value = $this->findRoute('componist.core.settings');
        if (! $value->exists) {
            $value->fill([
                'menu_id' => '1',
                'title' => 'Settings',
                'type' => 'route',
                'order' => '3',
                'name' => 'componist.core.settings',
                'created_at' => date('Y-m-d H:i:s'),
            ])->save();
        }

        $value = $this->findRoute('componist.core.componentes');
        if (! $value->exists) {
            $value->fill([
                'menu_id' => '1',
                'title' => 'Components overflow',
                'type' => 'route',
                'order' => '4',
                'name' => 'componist.core.componentes',
                'created_at' => date('Y-m-d H:i:s'),
            ])->save();
        }
    }

    protected function findRoute($key)
    {
        return MenuItem::firstOrNew(['name' => $key]);
    }
}
