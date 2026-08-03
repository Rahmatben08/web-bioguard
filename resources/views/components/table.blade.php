<div class="overflow-x-auto">
    <table {{ $attributes->merge(['class' => 'w-full text-left border-collapse text-sm whitespace-nowrap tabular-nums']) }}>
        @if(isset($head))
            <thead class="bg-slate-50 dark:bg-slate-800/80 border-y border-slate-200 dark:border-slate-700 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                <tr>
                    {{ $head }}
                </tr>
            </thead>
        @endif
        <tbody class="divide-y divide-slate-200 dark:divide-slate-800 bg-white dark:bg-slate-900">
            {{ $slot }}
        </tbody>
    </table>
</div>
