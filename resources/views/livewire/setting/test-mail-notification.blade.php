<div>

    <div class="bg-white rounded-md shadow-sm p-7">
        <h3 class="ml-2 text-teal-500 uppercase">Test E-Mail senden</h3>
        <div class="mt-3">
            <div class="flex items-center gap-5">
                <div class="relative w-full">
                    <x:component::form.input wire:model.blur=email class="w-full" placeholder="E-Mail-Adresse eingeben" />
                    <x:component::form.input-error :for="$email" />
                </div>
                <button wire:click.prevent="sendTestMail" type="button"
                    class="px-5 py-2 text-white bg-teal-500 rounded-lg hover:bg-teal-600 text-nowrap">
                    Senden
                </button>
            </div>
            <div class="mt-2">
                @error('email')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>
</div>
