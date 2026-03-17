<?php

namespace Componist\Core\Livewire\Element;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Select2 extends Component
{
    public string $table = '';

    public string $event = '';

    public string $column = '';

    public string $filter = '';

    public string $order = '';

    public array $list = [];

    /** @var int|string|null */
    public $selected = null;

    public ?string $name = null;

    public ?string $search = null;

    public bool $add_function = false;

    public ?string $key = null;

    /**
     * @param  array<int, string>|null  $items
     */
    public function mount(string $table, string $event, string $column, string $order, ?string $filter = null, $selected = null, bool $add_function = false, $key = null, ?array $items = null): void
    {
        $this->table = $table;
        $this->event = $event;
        $this->column = $column;
        $this->order = $order;
        $this->filter = $filter;
        $this->selected = $selected;
        $this->add_function = $add_function;
        $this->key = $key;

        if (is_array($items)) {
            $this->list = array_values(array_map(function (string $value) {
                return ['id' => $value, 'name' => $value];
            }, $items));
        } else {
            $this->getDatabaseList();
        }

        if (isset($selected) && ! empty($selected)) {
            $tempList = [];
            foreach ($this->list as $value) {
                $tempList[] = $value;

                if ($value['id'] === $selected) {
                    $this->name = $value[$this->column];
                }
            }

            $this->list = $tempList;
        }
    }

    public function render()
    {
        $this->search();

        return view('component::livewire.element.select2');
    }

    /**
     * @param  int|string  $id
     */
    public function select($id, string $name): void
    {
        if ($this->selected === $id) {
            $this->selected = null;
            $this->name = null;
        } else {
            $this->selected = $id;
            $this->name = $name;
        }

        $this->clearSearch();
        $this->emitEvent();
    }

    public function add(): void
    {
        $this->search = trim($this->search);
        if (empty($this->table)) {
            if (! empty($this->search)) {
                $this->selected = $this->search;
                $this->name = $this->search;
                $this->clearSearch();
                $this->emitEvent();
            } else {
                $this->clearSearch();
            }
            return;
        }

        if ($this->add_function === true && ! DB::table($this->table)->where($this->column, $this->search)->exists() && ! empty($this->search)) {
            $this->selected = DB::table($this->table)->insertGetId([
                $this->column => $this->search,
            ]);

            $this->name = $this->search;
            $this->clearSearch();
            $this->emitEvent();
        } else {
            $this->selected = DB::table($this->table)->where($this->column, $this->search)->value('id');

            if ($this->selected) {
                $this->name = $this->search;
                $this->clearSearch();
                $this->emitEvent();
            } else {
                $this->clearSearch();
            }
        }
    }

    public function clear(): void
    {
        $this->selected = null;
        $this->name = null;
        $this->emitEvent();
    }

    private function getDatabaseList(): void
    {
        if (empty($this->table)) {
            return;
        }

        $query = DB::table($this->table);

        if ($this->filter) {
            $filter = explode(',', $this->filter);
            $filter_row = $filter[0];

            if ($filter[1] === 'NULL') {
                $filter_val = null;
            } else {
                $filter_val = $filter[1];
            }

            $query = $query->where($filter_row, $filter_val);
        }

        $this->list = json_decode(json_encode($query->orderBy($this->order, 'asc')->get()->toArray()), true);
    }

    private function search(): void
    {
        if (! empty($this->search)) {
            if (empty($this->table)) {
                $search = mb_strtolower(trim($this->search));
                $this->list = array_values(array_filter($this->list, function (array $row) use ($search) {
                    $value = (string) ($row['name'] ?? '');
                    return str_contains(mb_strtolower($value), $search);
                }));
            } else {
                $this->list = json_decode(json_encode(DB::table($this->table)->where($this->column, 'LIKE', '%'.trim($this->search).'%')->orderBy($this->column, 'asc')->get()->toArray()), true);
            }
        } else {
            if (! empty($this->table)) {
                $this->getDatabaseList();
            }
        }
    }

    private function clearSearch(): void
    {
        $this->search = '';
    }

    private function emitEvent(): void
    {
        $this->dispatch($this->event, $this->selected, $this->key);
    }
}
