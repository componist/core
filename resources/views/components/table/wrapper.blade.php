<table class="min-w-full">
    <thead class="bg-gray-50">
        {{ $head }}
    </thead>
    <tbody {{ $body->attributes->merge(['class' => 'bg-white divide-y divide-gray-200']) }}>
        {{ $body }}
    </tbody>
    @if (isset($foot))
    <tfoot>
        {{ $foot }}
    </tfoot>
    @endif

</table>