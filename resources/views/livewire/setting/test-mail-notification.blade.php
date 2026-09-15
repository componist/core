<div>
    <div
        class="rounded-md border border-slate-200 bg-white p-7 shadow-sm dark:border-slate-700 dark:bg-slate-900">
        <h3 class="ml-2 uppercase text-teal-500">Test E-Mail senden</h3>
        <div class="mt-3">
            <div class="flex items-center gap-5">
                <div class="relative w-full">
                    <x:component::form.input wire:model.blur="email" class="w-full"
                        placeholder="E-Mail-Adresse eingeben" />
                    <x:component::form.input-error :for="$email" />
                </div>
                <button wire:click.prevent="sendTestMail" type="button"
                    class="text-nowrap rounded-lg bg-teal-500 px-5 py-2 text-white hover:bg-teal-600">
                    Senden
                </button>
            </div>
            <div class="mt-2">
                @error('email')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>
</div>
