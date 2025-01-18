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
}" class="relative">
    <x:component::element.search @click.prevent="open = ! open" x-model="search" />

    <div x-cloak x-show="open" @click.outside="open = false"
        class="absolute left-0 bg-white border rounded shadow-sm top-14 w-96">
        <ul class="divide-y divide-gray-200">
            <template x-for="(category, index) in filtered()">
                <li class="p-3 cursor-pointer hover:bg-gray-50" x-text="category.name"
                    @click.prevent="add(category), open = false">
                </li>
            </template>
        </ul>
    </div>

    <div class="flex flex-wrap gap-2 px-2">

        <template x-for="(category, index) in selected">
            <div
                class="flex gap-2 px-5 py-2 mt-5 text-white rounded-full shadow-sm bg-dashboard-500 hover:bg-dashboard-600">
                <span x-text="category.name"></span>
                <button type="button" @click.prevent="deleted(index)">
                    <x:component::icon.close />
                </button>
            </div>
        </template>

    </div>
</div>
