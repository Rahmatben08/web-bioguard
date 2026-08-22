<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['color' => 'neutral']));

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

foreach (array_filter((['color' => 'neutral']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $colorClasses = [
        'success' => 'bg-emerald-100 text-emerald-800 border-emerald-200   ',
        'warning' => 'bg-amber-100 text-amber-800 border-amber-200   ',
        'error'   => 'bg-rose-100 text-rose-800 border-rose-200   ',
        'info'    => 'bg-blue-100 text-blue-800 border-blue-200   ',
        'neutral' => 'bg-slate-100 text-slate-800 border-slate-200   ',
    ];
    $classes = $colorClasses[$color] ?? $colorClasses['neutral'];
?>

<span <?php echo e($attributes->merge(['class' => "inline-flex items-center justify-center px-2 py-0.5 rounded text-[10px] font-extrabold uppercase tracking-widest border $classes"])); ?>>
    <?php echo e($slot); ?>

</span>
<?php /**PATH C:\project pkm\bio_guard_backend\resources\views/components/badge.blade.php ENDPATH**/ ?>