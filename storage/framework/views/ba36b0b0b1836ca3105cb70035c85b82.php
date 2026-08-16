<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['icon' => null, 'title', 'value', 'color' => 'primary', 'trend' => null, 'trendUp' => true, 'valueId' => null, 'valueClass' => '']));

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

foreach (array_filter((['icon' => null, 'title', 'value', 'color' => 'primary', 'trend' => null, 'trendUp' => true, 'valueId' => null, 'valueClass' => '']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php if (isset($component)) { $__componentOriginal53747ceb358d30c0105769f8471417f6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal53747ceb358d30c0105769f8471417f6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.card','data' => ['class' => 'relative flex flex-col justify-between transition-all duration-300 ease-out hover:-translate-y-1 hover:shadow-md hover:border-'.e($color).'/50']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'relative flex flex-col justify-between transition-all duration-300 ease-out hover:-translate-y-1 hover:shadow-md hover:border-'.e($color).'/50']); ?>
    <div class="flex justify-between items-start mb-2">
        <span class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider"><?php echo e($title); ?></span>
        <?php if($icon): ?>
            <div class="p-2 rounded-xl bg-<?php echo e($color); ?>/10 text-<?php echo e($color); ?> border border-<?php echo e($color); ?>/20">
                <span class="material-symbols-outlined text-[24px]"><?php echo e($icon); ?></span>
            </div>
        <?php endif; ?>
    </div>
    
    <div class="flex items-end gap-3 mt-1">
        <span <?php echo e($valueId ? 'id='.$valueId : ''); ?> class="text-4xl font-extrabold tracking-tight text-slate-900 dark:text-white tabular-nums <?php echo e($valueClass); ?>"><?php echo e($value); ?></span>
        
        <?php if($trend): ?>
            <div class="flex items-center gap-0.5 mb-1 text-[11px] font-bold <?php echo e($trendUp ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400'); ?>">
                <span class="material-symbols-outlined text-[14px]">
                    <?php echo e($trendUp ? 'trending_up' : 'trending_down'); ?>

                </span>
                <span><?php echo e($trend); ?></span>
            </div>
        <?php endif; ?>
    </div>
    
    <?php if(isset($slot) && $slot->isNotEmpty()): ?>
        <div class="mt-3 pt-3 border-t border-slate-100 dark:border-slate-800/60">
            <?php echo e($slot); ?>

        </div>
    <?php endif; ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal53747ceb358d30c0105769f8471417f6)): ?>
<?php $attributes = $__attributesOriginal53747ceb358d30c0105769f8471417f6; ?>
<?php unset($__attributesOriginal53747ceb358d30c0105769f8471417f6); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal53747ceb358d30c0105769f8471417f6)): ?>
<?php $component = $__componentOriginal53747ceb358d30c0105769f8471417f6; ?>
<?php unset($__componentOriginal53747ceb358d30c0105769f8471417f6); ?>
<?php endif; ?>
<?php /**PATH C:\project pkm\bio_guard_backend\resources\views\components\metric-card.blade.php ENDPATH**/ ?>