<?php

namespace Componist\Core\Livewire\Setting;

use Componist\Core\Models\Setting;
use Componist\Core\Traits\addLivewireControlleFunctions;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Settings')]
#[Layout(\Componist\Core\View\Components\DashboardLayout::class)]
class Index extends Component
{
    use addLivewireControlleFunctions;

    /** @var string|null */
    public $display_name = null;

    /** @var string|null */
    public $key = null;

    /** @var string|null */
    public $type = null;

    /** @var string|null */
    public $group = null;

    public $content;

    protected $rules = [
        'display_name' => 'required|unique:settings|string|max:50',
        'key' => 'required|unique:settings|string|max:50',
        'type' => 'required|string|max:25',
        'group' => 'required|string|max:25',
    ];

    protected $validationAttributes = [
        'display_name' => 'Name',
        'key' => 'Key',
        'type' => 'Type',
        'group' => 'Gruppe',
    ];

    public function mount(): void
    {
        $this->authorizeManage();
        $this->refreshContent();
    }

    public function render()
    {
        return view('component::livewire.setting.index');
    }

    private function refreshContent(): void
    {
        $collection = Setting::query()
            ->orderBy('group', 'asc')
            ->orderBy('order', 'asc')
            ->get();

        $this->content = $collection->groupBy('group')->toArray();
    }

    public function createNewSettingEntry(): void
    {
        $this->authorizeManage();
        $this->validate();

        $setting = new Setting;

        $setting['key'] = $this->key;
        $setting['display_name'] = $this->display_name;
        $setting['value'] = null;
        $setting['type'] = $this->type;
        $setting['order'] = Setting::count() + 1;
        $setting['group'] = $this->group;
        $setting['created_at'] = date('Y-m-d H:i:s');

        if ($setting->save()) {
            $this->bannerMessage('success', 'Eintrag wurde erfolgreich gespeichert');
            $this->clearValue();
            $this->refreshContent();
        }
    }

    public function input(string $value, int $id): void
    {
        $this->authorizeManage();
        Setting::where('id', $id)->update([
            'value' => $value,
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        $this->dispatch('saved'.$id);
    }

    public function deleteEntry(Setting $setting): void
    {
        $this->authorizeManage();
        if ($setting->delete()) {
            $this->bannerMessage('success', 'Eintrag wurde erfolgreich gelöscht');
            $this->refreshContent();
        }
    }

    private function clearValue(): void
    {
        $this->display_name = null;
        $this->key = null;
        $this->type = null;
        $this->group = null;
    }

    private function authorizeManage(): void
    {
        Gate::authorize(config('componist.manage_ability', 'componist.core.manage'));
    }
}
