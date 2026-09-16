@php
    use Componist\Core\Support\Ui;
@endphp

@if ($errors->any())
    <div {{ $attributes->merge(['class' => 'rounded-md border border-red-200 bg-red-50 p-4 dark:border-red-900/60 dark:bg-red-950/40']) }} role="alert">
        <div class="text-sm font-medium text-red-700 dark:text-red-300">Es ist ein Fehler aufgetreten.</div>

        <ul class="mt-2 list-inside list-disc text-sm text-red-600 dark:text-red-400">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
