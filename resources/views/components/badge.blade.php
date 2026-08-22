@props(['color' => 'neutral'])

@php
    $colorClasses = [
        'success' => 'bg-emerald-100 text-emerald-800 border-emerald-200   ',
        'warning' => 'bg-amber-100 text-amber-800 border-amber-200   ',
        'error'   => 'bg-rose-100 text-rose-800 border-rose-200   ',
        'info'    => 'bg-blue-100 text-blue-800 border-blue-200   ',
        'neutral' => 'bg-slate-100 text-slate-800 border-slate-200   ',
    ];
    $classes = $colorClasses[$color] ?? $colorClasses['neutral'];
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center justify-center px-2 py-0.5 rounded text-[10px] font-extrabold uppercase tracking-widest border $classes"]) }}>
    {{ $slot }}
</span>
