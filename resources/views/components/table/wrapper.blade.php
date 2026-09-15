<div class="overflow-hidden rounded-lg border border-slate-200 bg-white dark:border-slate-700 dark:bg-slate-900">
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead class="border-b border-slate-200 bg-slate-50 dark:border-slate-700 dark:bg-slate-800/80">
                {{ $head }}
            </thead>
            <tbody {{ $body->attributes->merge(['class' => 'divide-y divide-slate-200 bg-white dark:divide-slate-700 dark:bg-slate-900']) }}>
                {{ $body }}
            </tbody>
            @if (isset($foot))
                <tfoot class="border-t border-slate-200 bg-slate-50 dark:border-slate-700 dark:bg-slate-800/80">
                    {{ $foot }}
                </tfoot>
            @endif
        </table>
    </div>
</div>
