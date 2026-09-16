<div>
    <div class="flex items-center justify-center w-full mt-5" x-data="{
        dropingFile: false,
        isUploading: false,
        progress: 0,
        init() {
            dropingFile = false;
            isUploading = false;
            progress = 0;
        }
    }" x-on:livewire-upload-start="isUploading = true" {{-- x-on:livewire-upload-finish="isUploading = false"
        x-on:livewire-upload-error="isUploading = false" --}} x-on:livewire-upload-progress="">

        <label for="{{ $id }}"
            x-bind:class="dropingFile ? 'bg-teal-50 dark:bg-teal-950/40' : 'bg-slate-100 dark:bg-slate-800'"
            x-on:drop="dropingFile=false" x-on:drop.prevent="
            if (event.dataTransfer.files.length > 0) {
                isUploading= true;

                const files = $event.dataTransfer.files;
                if (event.dataTransfer.files.length > 1 && '{{ isset($multiple) ? $multiple : null }}') {
                    @this.uploadMultiple('{{ $name }}', files,
                        () => {
                            progress = 0;
                            isUploading= false;

                        }, () => {}, (event) => {
                            progress = event.detail.progress;
                        })
                } else {
                    @this.upload('{{ $name }}', files[0], () => {
                        progress = 0;
                        isUploading= false;
                    },
                        () => {}, (event) => {
                            progress = event.detail.progress;
                        });
                }
            }
        " x-on:dragover.prevent="dropingFile=true" x-on:dragleave.prevent="dropingFile=false"
            class="group flex w-full cursor-pointer flex-col items-center justify-center rounded-md border-2 border-dashed border-slate-300 py-12 transition-colors duration-200 hover:border-teal-400 hover:bg-teal-50 dark:border-slate-600 dark:hover:border-teal-500 dark:hover:bg-teal-950/40">
            <div class="flex flex-col items-center justify-center pb-6 pt-5 text-center">
                <svg class="mb-3 h-10 w-10 text-slate-400 group-hover:text-teal-500 dark:text-slate-400" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                    </path>
                </svg>
                <div wire:loading.remove wire:target="{{ $name }}">
                    <p class="mb-2 text-sm font-semibold text-slate-500 group-hover:text-teal-500 dark:text-slate-300">
                        Klicken zum Hochladen oder Datei hierher ziehen</p>
                    <p class="text-xs text-slate-500 group-hover:text-teal-500 dark:text-slate-400">{{ $title }}</p>
                </div>

                <div class="mt-1 text-teal-500" wire:loading.flex wire:target="{{ $name }}">
                    <div class="text-center">
                        <div class="flex items-center justify-center gap-2 px-5">
                            <svg class="h-7 w-7 animate-spin text-teal-500" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            <div class="animate-pulse text-teal-400">Dateien werden verarbeitet…</div>
                        </div>

                        <div class="mt-2 h-4 w-full overflow-hidden rounded-full bg-white dark:bg-slate-900"
                            x-show="isUploading">
                            <span class="block h-full animate-pulse bg-teal-500"
                                x-bind:style="`width:${progress}%`"></span>
                        </div>
                    </div>
                </div>
            </div>
            <input id="{{ $id }}" type="file" class="hidden" {{ $attributes->wire('model') }} @if (isset($multiple) && $multiple) multiple @endif />
        </label>
    </div>
</div>
