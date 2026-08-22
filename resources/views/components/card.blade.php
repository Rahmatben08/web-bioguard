<div {{ $attributes->merge(['class' => 'bg-white  border border-slate-200  rounded-md shadow-sm overflow-hidden']) }}>
    @if(isset($header))
        <div class="px-4 py-3 border-b border-slate-200  bg-slate-50 ">
            {{ $header }}
        </div>
    @endif
    
    <div class="{{ $noPadding ?? false ? '' : 'p-4' }}">
        {{ $slot }}
    </div>

    @if(isset($footer))
        <div class="px-4 py-3 border-t border-slate-200  bg-slate-50 ">
            {{ $footer }}
        </div>
    @endif
</div>
