<?php

namespace Reinholdjesse\Core\Livewire\Element;

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

    public ?int $selected = null;

    public ?string $name = null;

    public ?string $search = null;

    public bool $add_function = false;

    public ?string $key = null;

    public function mount(string $table, string $event, string $column, string $order, ?string $filter = null, ?int $selected = null, bool $add_function = false, $key = null): void
    {
        $this->table = $table;
        $this->event = $event;
        $this->column = $column;
        $this->order = $order;
        $this->filter = $filter;
        $this->selected = $selected;
        $this->add_function = $add_function;
        $this->key = $key;

        $this->getDatabaseList();

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

    public function select(int $id, string $name): void
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
            $this->list = json_decode(json_encode(DB::table($this->table)->where($this->column, 'LIKE', '%'.trim($this->search).'%')->orderBy($this->column, 'asc')->get()->toArray()), true);
        } else {
            $this->getDatabaseList();
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
