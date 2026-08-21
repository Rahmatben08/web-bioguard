@props(['status'])

@php
    \ = "";
    \ = "";
    \ = false;
    
    switch (strtolower(\)) {
        case "aman":
        case "optimal":
            \ = "bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-700/50";
            \ = "check_circle";
            break;
        case "peringatan":
        case "peringatan risiko":
            \ = "bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400 border border-amber-200 dark:border-amber-700/50";
            \ = "warning";
            \ = true;
            break;
        case "bahaya":
        case "kritis":
        case "tidak layak pakai":
            \ = "bg-rose-100 text-rose-700 dark:bg-rose-900/30 dark:text-rose-400 border border-rose-200 dark:border-rose-700/50";
            \ = "error";
            \ = true;
            break;
        default:
            \ = "bg-slate-100 text-slate-700 dark:bg-slate-900/30 dark:text-slate-400 border border-slate-200 dark:border-slate-700/50";
            \ = "info";
    }
@endphp

<span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-black uppercase tracking-wider {{ \ }}">
    <span class="material-symbols-outlined text-[12px] {{ \ ? 'animate-pulse' : '' }}">{{ \ }}</span>
    {{ \ }}
</span>
