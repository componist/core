<div>
    @if ($openEdit)
        <div
            class="fixed inset-0 z-50 items-center justify-center overflow-y-auto bg-slate-900/70 p-3 backdrop-blur-sm lg:flex">
            <div
                class="w-full overflow-hidden rounded-md border border-slate-200 bg-white shadow-sm dark:border-slate-700 dark:bg-slate-900 lg:w-6/12">
                <div class="px-5 pb-5">
                    <div class="py-3">
                        <x:component::form.label value="Name" />
                        <x:component::form.input wire:model.live="name" type="text" name="name" />
                        <x:component::form.input-error :for="$name" />
                    </div>
                </div>
                <div
                    class="grid grid-cols-2 gap-4 bg-slate-100 px-4 py-7 text-right dark:bg-slate-800 sm:px-6">
                    <x:component::button.cancel wire:click="cloasEditWindow" />

                    <button wire:click="update" type="button"
                        class="flex w-full justify-center rounded-md border border-transparent bg-teal-500 px-4 py-2 text-center font-medium text-white shadow-sm hover:bg-teal-600 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 dark:focus:ring-offset-slate-900">
                        Speichern
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
