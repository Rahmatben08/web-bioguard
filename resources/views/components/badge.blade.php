@props(['color' => 'neutral'])

@php
    $colorClasses = [
        'success' => 'bg-emerald-100 text-emerald-800 border-emerald-200 dark:bg-emerald-500/20 dark:text-emerald-300 dark:border-emerald-500/30',
        'warning' => 'bg-amber-100 text-amber-800 border-amber-200 dark:bg-amber-500/20 dark:text-amber-300 dark:border-amber-500/30',
        'error'   => 'bg-rose-100 text-rose-800 border-rose-200 dark:bg-rose-500/20 dark:text-rose-300 dark:border-rose-500/30',
        'info'    => 'bg-blue-100 text-blue-800 border-blue-200 dark:bg-blue-500/20 dark:text-blue-300 dark:border-blue-500/30',
        'neutral' => 'bg-slate-100 text-slate-800 border-slate-200 dark:bg-slate-800 dark:text-slate-300 dark:border-slate-700',
    ];
    $classes = $colorClasses[$color] ?? $colorClasses['neutral'];
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center justify-center px-2 py-0.5 rounded text-[10px] font-extrabold uppercase tracking-widest border $classes"]) }}>
    {{ $slot }}
</span>
