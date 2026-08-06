@props(['icon' => null, 'title', 'value', 'color' => 'primary', 'trend' => null, 'trendUp' => true, 'valueId' => null, 'valueClass' => ''])

<x-card class="relative flex flex-col justify-between transition-all duration-300 ease-out hover:-translate-y-1 hover:shadow-md hover:border-{{ $color }}/50">
    <div class="flex justify-between items-start mb-2">
        <span class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">{{ $title }}</span>
        @if($icon)
            <div class="p-2 rounded-xl bg-{{ $color }}/10 text-{{ $color }} border border-{{ $color }}/20">
                <span class="material-symbols-outlined text-[24px]">{{ $icon }}</span>
            </div>
        @endif
    </div>
    
    <div class="flex items-end gap-3 mt-1">
        <span {{ $valueId ? 'id='.$valueId : '' }} class="text-4xl font-extrabold tracking-tight text-slate-900 dark:text-white tabular-nums {{ $valueClass }}">{{ $value }}</span>
        
        @if($trend)
            <div class="flex items-center gap-0.5 mb-1 text-[11px] font-bold {{ $trendUp ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                <span class="material-symbols-outlined text-[14px]">
                    {{ $trendUp ? 'trending_up' : 'trending_down' }}
                </span>
                <span>{{ $trend }}</span>
            </div>
        @endif
    </div>
    
    @if(isset($slot) && $slot->isNotEmpty())
        <div class="mt-3 pt-3 border-t border-slate-100 dark:border-slate-800/60">
            {{ $slot }}
        </div>
    @endif
</x-card>
