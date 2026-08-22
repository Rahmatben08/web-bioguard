<div class="overflow-x-auto">
    <table {{ $attributes->merge(['class' => 'w-full text-left border-collapse text-sm whitespace-nowrap tabular-nums']) }}>
        @if(isset($head))
            <thead class="bg-slate-50  border-y border-slate-200  text-xs font-semibold text-slate-500 uppercase tracking-wider">
                <tr>
                    {{ $head }}
                </tr>
            </thead>
        @endif
        <tbody class="divide-y divide-slate-200  bg-white ">
            {{ $slot }}
        </tbody>
    </table>
</div>
