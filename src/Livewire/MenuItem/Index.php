<?php

namespace Componist\Core\Livewire\MenuItem;

use Livewire\Component;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Livewire\Attributes\Title;
use Componist\Core\Models\Menu;
use Componist\Core\Models\MenuItem;
use Illuminate\Support\Facades\Artisan;
use Componist\Core\Traits\addLivewireControlleFunctions;

#[Title('Menu Item')] 
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

    public ?string $view_path = null;

    protected $rules = [
        'title' => 'required|min:3',
        'type' => 'required|string|max:255',
        'target' => 'nullable|string|max:10',
        'parent_id' => 'nullable|numeric',
        'order' => 'required|numeric',
        'name' => 'nullable|string|max:255',
        'slug' => 'nullable|string|max:255',
        'view_path' => 'nullable|string|max:255',
    ];

    public function mount(Menu $id): void
    {
        $this->menu = collect($id)->toArray();
    }

    public function render(): View
    {
        if($this->type == 'url'){
            if ($this->slug == null && $this->slug == '' && ! empty($this->title)) {
                $this->slug = Str::slug($this->title);
            }
        }

        if($this->type == 'page'){

            if($this->slug == null && $this->slug == '' && ! empty($this->title)){

                if($this->view_path == null && $this->view_path == ''){
                    $this->view_path = 'page.'.Str::slug($this->title);
                }
                
                if($this->name == null && $this->name == ''){
                    $this->name = $this->view_path;
                }
            }else{
                $this->view_path = 'page.';
            }
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
        $this->view_path = $menuItem['view_path'];

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

                MenuItem::createStubPage($this->view_path);
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
        $query['view_path'] = $this->view_path;

        

        if ($query->save()) {
            
            if($this->type == 'page'){
                MenuItem::createPageConfigFile();
            }

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
        $type = $menuItem['type'];
        
        if ($menuItem->delete()) {

            if($type == 'page'){
                MenuItem::createPageConfigFile();
            }
            
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
        $this->view_path = null;
    }

    public function toggle(int $id, string $field): void
    {
        $temp = MenuItem::findOrFail($id);
        $temp->$field = ! $temp->$field;
        $temp->save();

        if($temp['type'] == 'page'){
            MenuItem::createPageConfigFile();
        }
    }
}