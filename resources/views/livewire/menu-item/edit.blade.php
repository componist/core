<div>
    @if ($openEdit)
        <div
            class="fixed top-0 bottom-0 left-0 right-0 z-50 items-center justify-center p-3 overflow-y-auto bg-gray-900 lg:flex bg-opacity-70 backdrop-blur-sm">
            <div class="w-full overflow-hidden bg-white rounded-md shadow-sm lg:w-6/12">
                <div class="px-5 py-5">
                    <div class="py-3">
                        <x:component::form.label value="Titel" />
                        <x:component::form.input wire:model.live="title" type="text" name="title" />
                        <x:component::form.input-error :for="$title" />
                    </div>
                    <div class="py-3">
                        <x:component::form.label value="Type" />
                        <x:component::form.select wire:model.live="type">
                            <x:component::form.select-option name="route" value="Route" />
                            <x:component::form.select-option name="url" value="URL" />
                            <x:component::form.select-option name="page" value="Page" />
                            <x:component::form.select-option name="parent" value="Parent" />
                        </x:component::form.select>
                        <x:component::form.input-error :for="$type" />
                    </div>
                    <div class="py-3">
                        <x:component::form.label value="Target" />

                        <x:component::form.select wire:model.live="target" name="target">
                            <x:component::form.select-option name="_self" value="Self" />
                            <x:component::form.select-option name="_blank" value="Blank" />
                        </x:component::form.select>

                        <x:component::form.input-error :for="$target" />
                    </div>
                    <div class="py-3">
                        <x:component::form.label value="Children from" />

                        <x:component::form.select wire:model.live="parent_id" name="parent_id">
                            <x:component::form.select-option name="" value="" />
                            @foreach (Componist\Core\Models\MenuItem::where('menu_id', $menu['id'])->get() as $value)
                                <x:component::form.select-option name="{{ $value->id }}"
                                    value="{{ $value->title }}" />
                            @endforeach
                        </x:component::form.select>

                        <x:component::form.input-error :for="$parent_id" />
                    </div>
                    <div class="py-3">
                        <x:component::form.label value="Order" />
                        <x:component::form.input wire:model.live="order" type="text" name="order" />
                        <x:component::form.input-error :for="$order" />
                    </div>

                    @if ($type != 'parent')
                        <div class="py-3">
                            <x:component::form.label value="Name" />
                            <x:component::form.input wire:model.live="name" type="text" name="name" />
                            <x:component::form.input-error :for="$name" />
                            @if ($type == 'url' && $name == null)
                                <p class="mt-2 text-xs text-red-500">Bitte hier Url eingeben</p>
                            @endif
                        </div>
                    @endif


                    @if ($type == 'url')
                        <div class="py-3">
                            <x:component::form.label value="Slug" />
                            <x:component::form.input wire:model.live="slug" type="text" name="slug" />
                            <x:component::form.input-error :for="$slug" />
                        </div>
                    @endif


                    @if ($type == 'page')
                        <div class="py-3">
                            <x:component::form.label value="Page View Path" />
                            <x:component::form.input wire:model.live="view_path" type="text" name="view_path" />
                            <x:component::form.input-error :for="$view_path" />
                        </div>
                    @endif

                </div>
                <div class="grid grid-cols-2 gap-4 px-4 text-right bg-gray-100 py-7 sm:px-6">
                    <x:component::button.cancel wire:click="cloasEditWindow" class="w-full" />

                    <button wire:click="update" type="button"
                        class="flex justify-center w-full px-4 py-2 font-medium text-center text-white border border-transparent rounded-md shadow-sm bg-dashboard-500 hover:bg-dashboard-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">Speichern</button>
                </div>
            </div>
        </div>
    @endif
</div>
