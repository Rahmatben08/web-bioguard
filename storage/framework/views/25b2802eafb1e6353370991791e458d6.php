<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['title', 'value', 'icon', 'color' => 'sky', 'subtitle' => '', 'loading' => false]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['title', 'value', 'icon', 'color' => 'sky', 'subtitle' => '', 'loading' => false]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div class="p-6 rounded-2xl bg-white  border border-slate-200  shadow-sm relative overflow-hidden group hover:border-<?php echo e($color); ?>-300 :border-<?php echo e($color); ?>-700 transition-colors duration-300">
    <div class="flex justify-between items-start relative z-10">
        <div>
            <h3 class="text-xs font-bold text-slate-500  uppercase tracking-wider mb-2 font-sans"><?php echo e($title); ?></h3>
            <?php if($loading): ?>
                <div class="h-8 w-24 bg-slate-200  animate-pulse rounded mt-1"></div>
            <?php else: ?>
                <p class="text-3xl font-black text-slate-800  font-mono"><?php echo e($value); ?></p>
            <?php endif; ?>
            <?php if($subtitle): ?>
                <p class="text-[11px] text-slate-500 font-semibold mt-2"><?php echo e($subtitle); ?></p>
            <?php endif; ?>
        </div>
        <div class="w-12 h-12 rounded-xl bg-<?php echo e($color); ?>-50 <?php echo e($color); ?>-900/30 flex items-center justify-center text-<?php echo e($color); ?>-600 <?php echo e($color); ?>-400 group-hover:scale-110 transition-transform duration-300">
            <span class="material-symbols-outlined text-[28px]"><?php echo e($icon); ?></span>
        </div>
    </div>
    
    <!-- Decorative background glow -->
    <div class="absolute -bottom-6 -right-6 w-32 h-32 bg-<?php echo e($color); ?>-400/10 <?php echo e($color); ?>-400/5 rounded-full blur-2xl group-hover:bg-<?php echo e($color); ?>-400/20 transition-colors duration-500"></div>
</div>

<?php /**PATH C:\project pkm\bio_guard_backend\resources\views\components\kpi-card.blade.php ENDPATH**/ ?>