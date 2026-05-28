<?php

namespace Componist\Core\Livewire\MenuItem;

use Componist\Core\Models\Menu;
use Componist\Core\Models\MenuItem;
use Componist\Core\Traits\addLivewireControlleFunctions;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Title('Menu Item')]
#[Layout(\Componist\Core\View\Components\DashboardLayout::class)]
class Index extends Component
{
    use addLivewireControlleFunctions;

    protected $listeners = [
        'menuItemIconSelected' => 'menuItemIconSelected',
    ];

    public array $listOrder = [];

    public $menu;

    public $content;

    /**
     * Flat list of MenuItems for the "parent_id" select.
     *
     * @var array<int, array{id:int, title:string}>
     */
    public array $parentOptions = [];

    /**
     * Available icon names from `component::icon.*` anonymous components.
     *
     * @var array<int, string>
     */
    public array $icons = [];

    public bool $openEdit = false;

    public ?int $editId = null;

    public ?string $title = null;

    public ?string $icon = null;

    public string $type = 'route';

    public ?string $target = null;

    public ?int $parent_id = null;

    public ?string $slug = null;

    public ?int $order = null;

    public ?string $name = null;

    public ?string $view_path = null;

    protected $rules = [
        'title' => 'required|min:3',
        'icon' => 'nullable|string|max:255',
        'type' => 'required|string|max:255',
        'target' => 'nullable|string|max:10',
        'parent_id' => 'nullable|numeric',
        'order' => 'required|numeric',
        'name' => 'nullable|string|max:255',
        'slug' => 'nullable|string|max:255',
        'view_path' => ['nullable', 'string', 'max:255', 'regex:/^[a-zA-Z0-9_.-]+$/', 'not_regex:/\.\./'],
    ];

    public function mount(Menu $id): void
    {
        $this->authorizeManage();
        $this->menu = collect($id)->toArray();

        $this->icons = Cache::rememberForever('componist.core.icons', function (): array {
            $iconDir = base_path('packages/componist/core/resources/views/components/icon');
            if (! is_dir($iconDir)) {
                return [];
            }

            return collect(File::files($iconDir))
                ->map(fn ($file) => $file->getFilename())
                ->filter(fn (string $name) => str_ends_with($name, '.blade.php'))
                ->map(fn (string $name) => str_replace('.blade.php', '', $name))
                ->values()
                ->all();
        });

        $this->refreshContent();
        $this->refreshParentOptions();
    }

    public function render()
    {
        if ($this->type == 'url') {
            if ($this->slug == null && $this->slug == '' && ! empty($this->title)) {
                $this->slug = Str::slug($this->title);
            }
        }

        if ($this->type == 'page') {

            if ($this->slug == null && $this->slug == '' && ! empty($this->title)) {

                if ($this->view_path == null && $this->view_path == '') {
                    $this->view_path = 'page.'.Str::slug($this->title);
                }

                if ($this->name == null && $this->name == '') {
                    $this->name = $this->view_path;
                }
            } else {
                $this->view_path = 'page.';
            }
        }

        return view('component::livewire.menu-item.index');
    }

    private function refreshContent(): void
    {
        $this->content = MenuItem::query()
            ->with(['children' => fn ($q) => $q->orderBy('order')])
            ->where('menu_id', $this->menu['id'])
            ->whereNull('parent_id')
            ->orderBy('order')
            ->get();
    }

    private function refreshParentOptions(): void
    {
        $this->parentOptions = MenuItem::query()
            ->where('menu_id', $this->menu['id'])
            ->orderBy('order')
            ->get(['id', 'title'])
            ->map(fn (MenuItem $m) => ['id' => (int) $m->id, 'title' => (string) $m->title])
            ->all();
    }

    public function create(): void
    {
        $this->authorizeManage();
        $this->clearValue();
        $this->openEditWindow();

        $this->order = MenuItem::where('menu_id', $this->menu['id'])->count() + 1;
    }

    public function edit(MenuItem $menuItem): void
    {
        $this->authorizeManage();
        $this->clearValue();

        $this->editId = $menuItem['id'];

        $this->title = $menuItem['title'];
        $this->icon = $menuItem['icon'] ?? null;
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
        $this->authorizeManage();
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
        $query['icon'] = $this->icon;
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

            if ($this->type == 'page') {
                MenuItem::createPageConfigFile();
            }

            $this->cloasEditWindow();
            $this->clearValue();
            $this->refreshContent();
            $this->refreshParentOptions();

            // TODO: flash message
            $this->bannerMessage('success', 'Menu wurde erfolgreich erstellt.');
        } else {
            // TODO: flash message
            $this->bannerMessage('success', 'Menu wurde erfolgreich aktualisiert.');
        }
    }

    public function deleteEntry(MenuItem $menuItem): void
    {
        $this->authorizeManage();
        $type = $menuItem['type'];

        if ($menuItem->delete()) {

            if ($type == 'page') {
                MenuItem::createPageConfigFile();
            }

            // TODO: flash message
        }
        $this->refreshContent();
        $this->refreshParentOptions();
        // TODO: flash message
    }

    public function reorder($orderedIds): void
    {
        $this->authorizeManage();
        $rows = collect($orderedIds)
            ->filter(fn ($e) => isset($e['value'], $e['order']))
            ->map(fn ($e) => ['id' => (int) $e['value'], 'order' => (int) $e['order']])
            ->values();

        if ($rows->isEmpty()) {
            return;
        }

        $ids = $rows->pluck('id')->all();
        $case = $rows->map(fn ($r) => 'WHEN '.$r['id'].' THEN '.$r['order'])->implode(' ');

        MenuItem::whereIn('id', $ids)->update([
            'order' => \Illuminate\Support\Facades\DB::raw('CASE id '.$case.' END'),
        ]);

        $this->refreshContent();
        $this->refreshParentOptions();
    }

    public function reorderChildes($orderedIds)
    {
        $this->authorizeManage();
        $updates = [];
        foreach ((array) $orderedIds as $element) {
            $parentId = isset($element['value']) ? (int) $element['value'] : null;
            $items = $element['items'] ?? [];
            foreach ((array) $items as $item) {
                if (! isset($item['value'], $item['order']) || ! $parentId) {
                    continue;
                }
                $updates[] = ['id' => (int) $item['value'], 'parent_id' => $parentId, 'order' => (int) $item['order']];
            }
        }

        if (empty($updates)) {
            return;
        }

        \Illuminate\Support\Facades\DB::transaction(function () use ($updates): void {
            foreach ($updates as $u) {
                MenuItem::where('id', $u['id'])
                    ->where('parent_id', $u['parent_id'])
                    ->update(['order' => $u['order']]);
            }
        });

        $this->refreshContent();
        $this->refreshParentOptions();
    }

    private function clearValue(): void
    {
        $this->editId = null;

        $this->title = null;
        $this->icon = null;
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
        $this->authorizeManage();
        if (! in_array($field, ['status'], true)) {
            abort(422);
        }

        $temp = MenuItem::findOrFail($id);
        $temp->$field = ! $temp->$field;
        $temp->save();

        if ($temp['type'] == 'page') {
            MenuItem::createPageConfigFile();
        }
        $this->refreshContent();
        $this->refreshParentOptions();
    }

    public function menuItemIconSelected($value = null): void
    {
        $this->icon = ! empty($value) ? (string) $value : null;
    }

    private function authorizeManage(): void
    {
        Gate::authorize(config('componist.manage_ability', 'componist.core.manage'));
    }
}
