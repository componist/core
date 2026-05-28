<?php

namespace Componist\Core\Livewire\Element;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
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

        if (! empty($this->table)) {
            $this->guardDatabaseConfiguration();
        }

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

        $this->guardDatabaseConfiguration();

        $query = DB::table($this->table);

        if ($this->filter) {
            $filter = explode(',', $this->filter);
            $filter_row = $filter[0];
            $allowedColumns = config('componist.select2.allowed_tables.'.$this->table, []);
            if (! in_array($filter_row, $allowedColumns, true) || ! Schema::hasColumn($this->table, $filter_row)) {
                abort(422);
            }

            if ($filter[1] === 'NULL') {
                $filter_val = null;
            } else {
                $filter_val = $filter[1];
            }

            $query = $query->where($filter_row, $filter_val);
        }

        $this->list = $query
            ->orderBy($this->order, 'asc')
            ->limit(50)
            ->get()
            ->map(fn ($row) => (array) $row)
            ->all();
    }

    public function updatedSearch(?string $value): void
    {
        $this->search = is_string($value) ? trim($value) : null;

        if (empty($this->search)) {
            if (! empty($this->table)) {
                $this->getDatabaseList();
            }
            return;
        }

        if (empty($this->table)) {
            $search = mb_strtolower($this->search);
            $this->list = array_values(array_filter($this->list, function (array $row) use ($search) {
                $value = (string) ($row['name'] ?? '');
                return str_contains(mb_strtolower($value), $search);
            }));
            return;
        }

        $this->guardDatabaseConfiguration();

        $query = DB::table($this->table)->where($this->column, 'LIKE', '%'.$this->search.'%');

        if ($this->filter) {
            $filter = explode(',', $this->filter);
            $filter_row = $filter[0];
            $allowedColumns = config('componist.select2.allowed_tables.'.$this->table, []);
            if (! in_array($filter_row, $allowedColumns, true) || ! Schema::hasColumn($this->table, $filter_row)) {
                abort(422);
            }
            $filter_val = ($filter[1] ?? null) === 'NULL' ? null : ($filter[1] ?? null);
            $query->where($filter_row, $filter_val);
        }

        $this->list = $query
            ->orderBy($this->column, 'asc')
            ->limit(50)
            ->get()
            ->map(fn ($row) => (array) $row)
            ->all();
    }

    private function clearSearch(): void
    {
        $this->search = '';
    }

    private function emitEvent(): void
    {
        $this->dispatch($this->event, $this->selected, $this->key);
    }

    private function guardDatabaseConfiguration(): void
    {
        if (! preg_match('/^[a-zA-Z0-9_]+$/', $this->table)) {
            abort(422);
        }

        if (! preg_match('/^[a-zA-Z0-9_]+$/', $this->column) || ! preg_match('/^[a-zA-Z0-9_]+$/', $this->order)) {
            abort(422);
        }

        $allowedTables = config('componist.select2.allowed_tables', []);
        $allowedColumns = $allowedTables[$this->table] ?? null;
        if (! is_array($allowedColumns)) {
            abort(403);
        }

        if (! in_array($this->column, $allowedColumns, true) || ! in_array($this->order, $allowedColumns, true)) {
            abort(403);
        }

        if (! Schema::hasTable($this->table) || ! Schema::hasColumn($this->table, $this->column) || ! Schema::hasColumn($this->table, $this->order)) {
            abort(422);
        }
    }
}
