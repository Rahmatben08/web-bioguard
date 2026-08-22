<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['status']));

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

foreach (array_filter((['status']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    \ = "";
    \ = "";
    \ = false;
    
    switch (strtolower(\)) {
        case "aman":
        case "optimal":
            \ = "bg-emerald-100 text-emerald-700   border border-emerald-200 ";
            \ = "check_circle";
            break;
        case "peringatan":
        case "peringatan risiko":
            \ = "bg-amber-100 text-amber-700   border border-amber-200 ";
            \ = "warning";
            \ = true;
            break;
        case "bahaya":
        case "kritis":
        case "tidak layak pakai":
            \ = "bg-rose-100 text-rose-700   border border-rose-200 ";
            \ = "error";
            \ = true;
            break;
        default:
            \ = "bg-slate-100 text-slate-700   border border-slate-200 ";
            \ = "info";
    }
?>

<span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-black uppercase tracking-wider <?php echo e(\); ?>">
    <span class="material-symbols-outlined text-[12px] <?php echo e(\ ? 'animate-pulse' : ''); ?>"><?php echo e(\); ?></span>
    <?php echo e(\); ?>

</span>
<?php /**PATH C:\project pkm\bio_guard_backend\resources\views\components\status-badge.blade.php ENDPATH**/ ?>