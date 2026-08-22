@props(['title', 'value', 'icon', 'color' => 'sky', 'subtitle' => '', 'loading' => false])

<div class="p-6 rounded-2xl bg-white  border border-slate-200  shadow-sm relative overflow-hidden group hover:border-{{ \ }}-300 :border-{{ \ }}-700 transition-colors duration-300">
    <div class="flex justify-between items-start relative z-10">
        <div>
            <h3 class="text-xs font-bold text-slate-500  uppercase tracking-wider mb-2 font-sans">{{ \ }}</h3>
            @if(\)
                <div class="h-8 w-24 bg-slate-200  animate-pulse rounded mt-1"></div>
            @else
                <p class="text-3xl font-black text-slate-800  font-mono">{{ \ }}</p>
            @endif
            @if(\)
                <p class="text-[11px] text-slate-500 font-semibold mt-2">{{ \ }}</p>
            @endif
        </div>
        <div class="w-12 h-12 rounded-xl bg-{{ \ }}-50 {{ \ }}-900/30 flex items-center justify-center text-{{ \ }}-600 {{ \ }}-400 group-hover:scale-110 transition-transform duration-300">
            <span class="material-symbols-outlined text-[28px]">{{ \ }}</span>
        </div>
    </div>
    
    <!-- Decorative background glow -->
    <div class="absolute -bottom-6 -right-6 w-32 h-32 bg-{{ \ }}-400/10 {{ \ }}-400/5 rounded-full blur-2xl group-hover:bg-{{ \ }}-400/20 transition-colors duration-500"></div>
</div>
