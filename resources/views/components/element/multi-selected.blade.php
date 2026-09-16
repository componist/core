@php
    use Componist\Core\Support\Ui;
@endphp

<div x-data="{
    open: false,
    search: '',
    categorys: {{ json_encode($liste) }},
    selected: @entangle($selected),
    filtered() {
        return this.categorys.filter(
            category => category.name.toLowerCase().includes(this.search.toLowerCase())
        );
    },
    add(element) {
        if (!this.selected.includes(element)) {
            this.selected.push(element);
            this.pullSelected();
            this.search = '';
        }
    },
    deleted(arrayIndex) {
        this.selected.splice(arrayIndex, 1);
        this.pullSelected();
    },
    pullSelected() {
        @this.set('{{ $selected }}', this.selected);
    }
}" class="relative space-y-3">
    <x:component::element.search @click.prevent="open = ! open" x-model="search" placeholder="Suchen…" />

    <div x-cloak x-show="open" @click.outside="open = false"
        class="{{ Ui::DROPDOWN }} absolute left-0 top-12 z-20 w-full max-w-sm overflow-hidden">
        <ul class="max-h-56 divide-y divide-slate-200 overflow-auto dark:divide-slate-700">
            <template x-for="(category, index) in filtered()">
                <li class="cursor-pointer px-4 py-2.5 text-sm text-slate-900 hover:bg-slate-50 dark:text-slate-100 dark:hover:bg-slate-700/80"
                    x-text="category.name" @click.prevent="add(category), open = false">
                </li>
            </template>
        </ul>
    </div>

    <div class="flex flex-wrap gap-2">
        <template x-for="(category, index) in selected">
            <div class="{{ Ui::CHIP }}">
                <span x-text="category.name"></span>
                <button type="button" @click.prevent="deleted(index)"
                    class="inline-flex h-5 w-5 items-center justify-center rounded-full hover:bg-teal-600"
                    aria-label="Entfernen">
                    <x:component::icon.close class="h-3.5 w-3.5" />
                </button>
            </div>
        </template>
    </div>
</div>
