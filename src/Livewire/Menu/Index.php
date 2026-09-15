<?php

namespace Componist\Core\Livewire\Menu;

use Componist\Core\Application\MenuService;
use Componist\Core\Domain\MenuRules;
use Componist\Core\Models\Menu;
use Componist\Core\Traits\addLivewireControlleFunctions;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Menus')]
#[Layout(\Componist\Core\View\Components\DashboardLayout::class)]
class Index extends Component
{
    use addLivewireControlleFunctions;

    public ?string $name = null;

    public bool $openEdit = false;

    public ?int $editId = null;

    public function mount(): void
    {
        $this->authorizeManage();
    }

    public function render()
    {
        $content = Menu::all();

        return view('component::livewire.menu.index', compact('content'));
    }

    public function edit(Menu $menu): void
    {
        $this->authorizeManage();
        $this->clearValue();

        $this->editId = $menu['id'];
        $this->name = $menu['name'];

        $this->openEditWindow();
    }

    public function update(): void
    {
        $this->authorizeManage();
        $this->validate(MenuRules::rules());

        $isUpdate = ! empty($this->editId);
        MenuService::save($this->editId, (string) $this->name);

        $this->cloasEditWindow();

        if ($isUpdate) {
            $this->flashMessage('success', 'Menu wurde erfolgreich aktualisiert.');
        } else {
            $this->flashMessage('success', 'Menu wurde erfolgreich erstellt.');
        }
        $this->clearValue();
    }

    public function deleteEntry(Menu $menu): void
    {
        $this->authorizeManage();
        if (MenuService::delete($menu)) {
            $this->flashMessage('success', $menu['name'].' Menu wurde erfolgreich gelöscht.');
        } else {
            $this->flashMessage('danger', $menu['name'].' Menu kann nicht gelöscht werden.');
        }
    }

    private function clearValue(): void
    {
        $this->editId = null;
        $this->name = null;
    }

    private function authorizeManage(): void
    {
        Gate::authorize(config('componist.manage_ability', 'componist.core.manage'));
    }
}
