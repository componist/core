<div>
    <x-slot name="header">
        <div class="flex items-center gap-1">
            <h2 class="font-semibold leading-tight">
                Benachrichtigung
            </h2>
        </div>
    </x-slot>

    <div class="py-12">

        <div class="container px-3 mx-auto pb-14">

            <div class="flex items-center justify-between mb-14">
                <div>
                    <span class="text-2xl text-teal-500">{{ $title }}</span>
                </div>
                <a href="{{ route('componist.core.notification') }}"
                    class="flex items-center justify-center w-56 px-5 py-2 text-white border-0 rounded-md shadow-sm whitespace-nowrap bg-dashboard-500 hover:text-white hover:bg-dashboard-600 default-transition ">zurück</a>
            </div>

            <div class="p-5 overflow-x-auto bg-white shadow md:rounded-lg">
                {!! $message !!}
            </div>

        </div>

    </div>
</div>
