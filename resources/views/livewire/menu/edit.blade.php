<div>
    @if ($openEdit)
        <div
            class="fixed top-0 bottom-0 left-0 right-0 z-50 items-center justify-center p-3 overflow-y-auto bg-gray-900 lg:flex bg-opacity-70 backdrop-blur-sm">
            <div class="w-full overflow-hidden bg-white rounded-md shadow-sm lg:w-6/12">
                <div class="px-5 pb-5">
                    <div class="py-3">
                        <x:component::form.label value="Name" />
                        <x:component::form.input wire:model.live="name" type="text" name="name" />
                        <x:component::form.input-error :for="$name" />
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4 px-4 text-right bg-gray-100 py-7 sm:px-6">
                    <x:component::button.cancel wire:click="cloasEditWindow" />

                    <button wire:click="update" type="button"
                        class="flex justify-center w-full px-4 py-2 font-medium text-center text-white border border-transparent rounded-md shadow-sm bg-dashboard-500 hover:bg-dashboard-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">Speichern</button>
                </div>
            </div>
        </div>
    @endif
</div>
