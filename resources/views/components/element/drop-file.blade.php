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
    }"
        x-on:livewire-upload-start="isUploading = true"{{-- x-on:livewire-upload-finish="isUploading = false" x-on:livewire-upload-error="isUploading = false" --}} x-on:livewire-upload-progress="">

        <label for="{{ $id }}" x-bind:class="dropingFile ? 'bg-dashboard-50 ' : ' bg-gray-100'"
            x-on:drop="dropingFile=false"
            x-on:drop.prevent="
            if (event.dataTransfer.files.length > 0) {
                isUploading= true;

                const files = $event.dataTransfer.files;
                console.log('{{ $name }} {{ $multiple }}');
                if (event.dataTransfer.files.length > 1 && '{{ $multiple }}') {
                    console.log('multi');
                    @this.uploadMultiple('{{ $name }}', files,
                        () => {
                            progress = 0;
                            isUploading= false;

                        }, () => {}, (event) => {
                            progress = event.detail.progress;
                            console.log(progress);
                        })
                } else {
                    console.log('singel');
                    @this.upload('{{ $name }}', files[0], () => {
                        progress = 0;
                        isUploading= false;
                    },
                        () => {}, (event) => {
                            progress = event.detail.progress;
                            console.log(progress);
                        });
                }
            }
        "
            x-on:dragover.prevent="dropingFile=true, console.log('dragover')" x-on:dragleave.prevent="dropingFile=false"
            class="flex flex-col items-center justify-center w-full py-12 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer group hover:bg-dashboard-50 ">
            <div class="flex flex-col items-center justify-center pt-5 pb-6 text-center">
                <svg class="w-10 h-10 mb-3 text-gray-400 group-hover:text-dashboard-500" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                    </path>
                </svg>
                <div wire:loading.remove wire:target="{{ $name }}">
                    <p class="mb-2 text-sm font-semibold text-gray-500 group-hover:text-dashboard-500">Click to upload
                        or
                        drag and drop</p>
                    <p class="text-xs text-gray-500 group-hover:text-dashboard-500">{{ $title }}</p>
                </div>

                <div class="mt-1" wire:loading.flex wire:target="{{ $name }}" class="text-dashboard-500">
                    <div class="text-center">
                        <div class="flex items-center justify-center gap-2 px-5">
                            <svg class="text-dashboard-500 w-7 h-7 animate-spin" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                    stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            <div class="text-dashboard-400 animate-pulse">Processing Files</div>
                        </div>

                        <div class="w-full h-4 mt-2 overflow-hidden bg-white rounded-full" x-show="isUploading">
                            <span class="block h-full bg-dashboard-500 animate-pulse"
                                x-bind:style="`width:${progress}%`"></span>
                        </div>
                    </div>
                </div>
            </div>
            <input id="{{ $id }}" type="file" class="hidden" {{ $attributes->wire('model') }}
                @if ($multiple) multiple @endif />
        </label>
    </div>
</div>
