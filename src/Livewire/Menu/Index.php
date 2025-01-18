<?php

namespace Reinholdjesse\Core\Livewire\Menu;

use Illuminate\View\View;
use Livewire\Component;
use Reinholdjesse\Core\Models\Menu;
use Reinholdjesse\Core\Traits\addLivewireControlleFunctions;

class Index extends Component
{
    use addLivewireControlleFunctions;

    public ?string $name = null;

    public $content;

    public bool $openEdit = false;

    public ?int $editId = null;

    public function render(): View
    {
        $this->content = Menu::all();

        return view('component::livewire.menu.index')->layout(config('core.template.dashboard'));
    }

    public function edit(Menu $menu): void
    {
        $this->clearValue();

        $this->editId = $menu['id'];
        $this->name = $menu['name'];

        $this->openEditWindow();
    }

    public function update(): void
    {
        $this->validate([
            'name' => 'required|string|min:3',
        ]);

        if (! empty($this->editId)) {
            // update
            $query = Menu::find($this->editId);
        } else {
            // create
            $query = new Menu;
        }

        $query['name'] = $this->name;

        $this->cloasEditWindow();

        $query->save();

        if ($this->editId) {
            $this->bannerMessage('success', 'Menu wurde erfolgreich aktualisiert.');
        } else {
            $this->bannerMessage('success', 'Menu wurde erfolgreich erstellt.');
        }
        $this->clearValue();
    }

    public function deleteEntry(Menu $menu): void
    {
        if ($menu['name'] !== 'admin' && $menu->delete()) {
            // TODO: flash message
            // TODO: flesh message admin menu kann nicht gelöscht werden
            $this->bannerMessage('success', $menu['name'].' Menu wurde erfolgreich gelöscht.');
        } else {
            // TODO: flash message
            $this->bannerMessage('danger', $menu['name'].' Menu kann nicht gelöscht werden.');
        }
    }

    private function clearValue(): void
    {
        $this->editId = null;
        $this->name = null;
    }
}
