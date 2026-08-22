<div class="overflow-x-auto">
    <table <?php echo e($attributes->merge(['class' => 'w-full text-left border-collapse text-sm whitespace-nowrap tabular-nums'])); ?>>
        <?php if(isset($head)): ?>
            <thead class="bg-slate-50  border-y border-slate-200  text-xs font-semibold text-slate-500 uppercase tracking-wider">
                <tr>
                    <?php echo e($head); ?>

                </tr>
            </thead>
        <?php endif; ?>
        <tbody class="divide-y divide-slate-200  bg-white ">
            <?php echo e($slot); ?>

        </tbody>
    </table>
</div>
<?php /**PATH C:\project pkm\bio_guard_backend\resources\views\components\table.blade.php ENDPATH**/ ?>