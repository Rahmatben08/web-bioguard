<div <?php echo e($attributes->merge(['class' => 'bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-md shadow-sm overflow-hidden'])); ?>>
    <?php if(isset($header)): ?>
        <div class="px-4 py-3 border-b border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-800/50">
            <?php echo e($header); ?>

        </div>
    <?php endif; ?>
    
    <div class="<?php echo e($noPadding ?? false ? '' : 'p-4'); ?>">
        <?php echo e($slot); ?>

    </div>

    <?php if(isset($footer)): ?>
        <div class="px-4 py-3 border-t border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-800/50">
            <?php echo e($footer); ?>

        </div>
    <?php endif; ?>
</div>
<?php /**PATH C:\project pkm\bio_guard_backend\resources\views\components\card.blade.php ENDPATH**/ ?>