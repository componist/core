<x:component::page.shell title="Benachrichtigung">
    <x-slot:actions>
        <x:component::button.secondary href="{{ route('componist.core.notification') }}">
            Zurück
        </x:component::button.secondary>
    </x-slot:actions>

    <div class="mb-6">
        <span class="text-2xl text-teal-500">{{ $title }}</span>
    </div>

    <div
        class="overflow-x-auto rounded-lg border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-700 dark:bg-slate-900 md:rounded-lg">
        {!! \Componist\Core\Support\SafeHtml::sanitize($message) !!}
    </div>
</x:component::page.shell>
