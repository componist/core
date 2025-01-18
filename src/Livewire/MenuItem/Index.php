<?php

namespace Reinholdjesse\Core\Livewire\MenuItem;

use Illuminate\Support\Str;
use Illuminate\View\View;
use Livewire\Component;
use Reinholdjesse\Core\Models\Menu;
use Reinholdjesse\Core\Models\MenuItem;
use Reinholdjesse\Core\Traits\addLivewireControlleFunctions;

class Index extends Component
{
    use addLivewireControlleFunctions;

    public array $listOrder = [];

    public $menu;

    public $content;

    public bool $openEdit = false;

    public ?int $editId = null;

    public ?string $title = null;

    public string $type = 'route';

    public ?string $target = null;

    public ?int $parent_id = null;

    public ?string $slug = null;

    public ?int $order = null;

    public ?string $name = null;

    protected $rules = [
        'title' => 'required|min:3',
        'type' => 'required|string|max:255',
        'target' => 'nullable|string|max:10',
        'parent_id' => 'nullable|numeric',
        'order' => 'required|numeric',
        'name' => 'nullable|string|max:255',
        'slug' => 'nullable|string|max:255',
    ];

    public function mount(Menu $id): void
    {
        $this->menu = collect($id)->toArray();
    }

    public function render(): View
    {

        if ($this->slug == null && $this->slug == '' && ! empty($this->title)) {
            $this->slug = Str::slug($this->title);
        }

        $this->content = MenuItem::with('children')
            ->where('menu_id', $this->menu['id'])
            ->whereNull('parent_id')
            ->orderBy('order')->get();

        return view('component::livewire.menu-item.index')->layout(config('core.template.dashboard'));
    }

    public function create(): void
    {
        $this->clearValue();
        $this->openEditWindow();

        $this->order = MenuItem::where('menu_id', $this->menu['id'])->count() + 1;
    }

    public function edit(MenuItem $menuItem): void
    {
        $this->clearValue();

        $this->editId = $menuItem['id'];

        $this->title = $menuItem['title'];
        $this->type = $menuItem['type'];
        $this->target = $menuItem['target'];
        $this->parent_id = $menuItem['parent_id'];
        $this->order = $menuItem['order'];
        $this->name = $menuItem['name'];
        $this->slug = $menuItem['slug'];

        $this->openEditWindow();
    }

    public function update(): void
    {
        $this->validate();

        if (! empty($this->editId)) {
            // update
            $query = MenuItem::find($this->editId);
        } else {
            // create
            $query = new MenuItem;
            $query['menu_id'] = $this->menu['id'];

            if ($this->type == 'page') {
                $this->slug = Str::slug($this->title);
            }
        }

        $query['title'] = $this->title;
        $query['type'] = $this->type;

        if (! empty($this->target)) {
            $query['target'] = $this->target;
        }

        $query['parent_id'] = $this->parent_id;
        $query['order'] = $this->order;
        $query['slug'] = $this->slug;

        $query['name'] = $this->name;

        if ($query->save()) {
            $this->cloasEditWindow();
            $this->clearValue();

            // TODO: flash message
            $this->bannerMessage('success', 'Menu wurde erfolgreich erstellt.');
        } else {
            // TODO: flash message
            $this->bannerMessage('success', 'Menu wurde erfolgreich aktualisiert.');
        }
    }

    public function deleteEntry(MenuItem $menuItem): void
    {
        if ($menuItem->delete()) {
            // TODO: flash message
        }
        // TODO: flash message
    }

    public function reorder($orderedIds): void
    {
        foreach ($orderedIds as $element) {
            MenuItem::where('id', $element['value'])->update([
                'order' => $element['order'],
            ]);
        }
    }

    public function reorderChildes($orderedIds)
    {
        foreach ($orderedIds as $element) {
            if (count($element['items']) > 0) {
                foreach ($element['items'] as $item) {
                    MenuItem::where('id', $item['value'])
                        ->where('parent_id', $element['value'])
                        ->update([
                            'order' => $item['order'],
                        ]);
                }
            }
        }
    }

    private function clearValue(): void
    {
        $this->editId = null;

        $this->title = null;
        $this->type = 'route';
        $this->target = null;
        $this->parent_id = null;
        $this->order = null;
        $this->name = null;
        $this->slug = null;
    }
}
