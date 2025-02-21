<?php

namespace Componist\Core\Seeders;

use Componist\Core\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $setting = $this->findSetting('site.title');
        if (! $setting->exists) {
            $setting->fill([
                'display_name' => 'Site Title',
                'key' => 'site.title',
                'value' => 'Your Site Title',
                'type' => 'text',
                'order' => 1,
                'group' => 'Site',
            ])->save();
        }

        $setting = $this->findSetting('site.description');
        if (! $setting->exists) {
            $setting->fill([
                'display_name' => 'Site Description',
                'key' => 'site.description',
                'value' => 'Your Site Description',
                'type' => 'text_area',
                'order' => 2,
                'group' => 'Site',
            ])->save();
        }
    }

    protected function findSetting(string $key): object
    {
        return Setting::firstOrNew(['key' => $key]);
    }
}
