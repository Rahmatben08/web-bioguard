<?php $__env->startSection('title', 'Analisis Telemetri & Sensor'); ?>

<?php $__env->startSection('content'); ?>
<div class="flex-1 w-full min-h-full transition-colors duration-300 p-container-margin space-y-lg">
    <!-- Header Controls Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end gap-md mb-md">
        <div>
            <nav class="flex text-label-md text-on-surface-variant mb-1 gap-2 transition-colors duration-300">
                <span>BIO-GUARD</span> / <span class="text-primary font-semibold transition-colors duration-300">Analisis Sensor</span>
            </nav>
            <h1 class="font-headline-lg text-headline-lg text-on-surface transition-colors duration-300">Laporan & Analisis</h1>
            <p class="text-on-surface-variant font-body-md text-body-md transition-colors duration-300">Metrik kinerja distribusi biologis tingkat perusahaan.</p>
        </div>
        <?php
            $selectedDate = request()->input('date');
            $selectedBox = request()->input('id_box');
        ?>
        <form method="GET" action="<?php echo e(route('sensors')); ?>" class="relative z-50 pointer-events-auto flex items-center gap-3 bg-surface-container-low border border-outline-variant/30 p-1.5 rounded-xl flex-wrap transition-colors duration-300">
            <!-- Filter Inputs -->
            <div class="flex gap-2 items-center flex-wrap">
                <input type="date" name="date" id="filter-date" value="<?php echo e($selectedDate); ?>" class="bg-surface-container border-none text-xs font-semibold text-on-surface focus:ring-1 focus:ring-primary rounded-lg py-1.5 px-3 transition-colors duration-300">
                <select name="id_box" id="filter-box" class="bg-surface-container border-none text-xs font-semibold text-on-surface focus:ring-1 focus:ring-primary rounded-lg py-1.5 pr-8 transition-colors duration-300">
                    <option value="">Semua Boks</option>
                    <option value="BOX-001" <?php echo e($selectedBox === 'BOX-001' ? 'selected' : ''); ?>>BOX-001</option>
                    <option value="BOX-002" <?php echo e($selectedBox === 'BOX-002' ? 'selected' : ''); ?>>BOX-002</option>
                    <option value="BOX-003" <?php echo e($selectedBox === 'BOX-003' ? 'selected' : ''); ?>>BOX-003</option>
                    <option value="BOX-004" <?php echo e($selectedBox === 'BOX-004' ? 'selected' : ''); ?>>BOX-004</option>
                </select>
                <?php if(request()->has('show_demo')): ?>
                    <a href="<?php echo e(url()->current()); ?>" class="text-[11px] font-bold px-3 py-1.5 rounded-xl bg-primary text-white hover:bg-primary/90 transition-all shadow-md shadow-primary/20 flex items-center gap-1"><span class="material-symbols-outlined text-[14px]">visibility_off</span> Sembunyikan Data Demo</a>
                <?php else: ?>
                    <a href="<?php echo e(url()->current() . '?show_demo=1'); ?>" class="text-[11px] font-bold px-3 py-1.5 rounded-xl border-2 border-primary/30 text-primary hover:bg-primary hover:text-white transition-all hover:shadow-md hover:shadow-primary/20 flex items-center gap-1"><span class="material-symbols-outlined text-[14px]">science</span> Tampilkan Data Demo</a>
                <?php endif; ?>
                <button type="submit" class="bg-primary hover:bg-primary/90 text-white px-3.5 py-1.5 rounded-lg text-xs font-bold transition-all active:scale-95 duration-100 shadow-md shadow-primary/20 cursor-pointer">
                    Filter
                </button>
            </div>
            
            <div class="hidden sm:block h-6 w-px bg-slate-200 "></div>

            <div class="flex gap-1 bg-surface-container rounded-lg p-1 transition-colors duration-300" id="time-filter-buttons">
                <button type="button" class="q-btn px-4 py-1.5 text-xs font-bold bg-primary/10 text-sky-600   rounded-md transition-all duration-300">Q1</button>
                <button type="button" class="q-btn px-4 py-1.5 text-xs font-medium text-on-surface-variant hover:text-slate-800 :text-slate-200 rounded-md transition-all duration-300">Q2</button>
                <button type="button" class="q-btn px-4 py-1.5 text-xs font-medium text-on-surface-variant hover:text-slate-800 :text-slate-200 rounded-md transition-all duration-300">KUSTOM</button>
            </div>

            <button onclick="downloadExcelReport()" class="bg-emerald-600 hover:bg-emerald-700 text-white p-2 rounded-lg active:scale-95 transition-all duration-300 shadow-md shadow-emerald-500/10 cursor-pointer" id="btn-excel-export" title="Unduh Log Audit CDOB (Excel)">
                <span class="material-symbols-outlined text-[18px] align-middle">description</span>
            </button>
            <button type="button" onclick="window.open('/dashboard/audit-pdf', '_blank')" class="bg-white hover:bg-surface-container-high :bg-slate-700 text-on-surface p-2 rounded-lg border border-outline-variant/30 active:scale-95 transition-all duration-300" id="btn-pdf-export" title="Unduh Log Audit (PDF)">
                <span class="material-symbols-outlined text-[18px] align-middle">picture_as_pdf</span>
            </button>
        </form>
    </div>

    <!-- KPI Overview Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-gutter mb-md">
        <!-- Metric 1 -->
        <?php if (isset($component)) { $__componentOriginal53747ceb358d30c0105769f8471417f6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal53747ceb358d30c0105769f8471417f6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.card','data' => ['class' => 'h-32 flex flex-col justify-between overflow-hidden group hover:border-primary/40 transition-all duration-300']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'h-32 flex flex-col justify-between overflow-hidden group hover:border-primary/40 transition-all duration-300']); ?>
            <div class="flex justify-between items-start z-10">
                <span class="text-slate-500 text-[10px] uppercase font-bold tracking-widest">Skor Integritas Armada</span>
                <span class="text-primary material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">security</span>
            </div>
            <div class="flex items-baseline gap-2 z-10">
                <span class="text-3xl text-primary font-black tabular-nums"><span id="live-integritas">98,4%</span></span>
                <span class="text-primary font-bold text-[10px] flex items-center"><span class="material-symbols-outlined text-[10px]">trending_up</span>+0,2%</span>
            </div>
            <div class="absolute bottom-0 left-0 w-full h-1 bg-surface-container-highest">
                <div class="h-full bg-primary" style="width: 98.4%"></div>
            </div>
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
        <!-- Metric 2 -->
        <?php if (isset($component)) { $__componentOriginal53747ceb358d30c0105769f8471417f6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal53747ceb358d30c0105769f8471417f6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.card','data' => ['class' => 'h-32 flex flex-col justify-between overflow-hidden group hover:border-amber-500/40 transition-all duration-300']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'h-32 flex flex-col justify-between overflow-hidden group hover:border-amber-500/40 transition-all duration-300']); ?>
            <div class="flex justify-between items-start z-10">
                <span class="text-slate-500 text-[10px] uppercase font-bold tracking-widest">Total Anomali</span>
                <span class="text-amber-500 material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">warning</span>
            </div>
            <div class="flex items-baseline gap-2 z-10">
                <span class="text-3xl text-on-surface font-black tabular-nums"><span id="live-anomali">12</span></span>
                <span class="text-amber-500 font-bold text-[10px] flex items-center"><span class="material-symbols-outlined text-[10px]">trending_down</span>-15%</span>
            </div>
            <div class="absolute bottom-0 left-0 w-full h-1 bg-surface-container-highest">
                <div class="h-full bg-amber-500" style="width: 15%"></div>
            </div>
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
        <!-- Metric 3 -->
        <?php if (isset($component)) { $__componentOriginal53747ceb358d30c0105769f8471417f6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal53747ceb358d30c0105769f8471417f6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.card','data' => ['class' => 'h-32 flex flex-col justify-between overflow-hidden group hover:border-primary/40 transition-all duration-300']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'h-32 flex flex-col justify-between overflow-hidden group hover:border-primary/40 transition-all duration-300']); ?>
            <div class="flex justify-between items-start z-10">
                <span class="text-slate-500 text-[10px] uppercase font-bold tracking-widest">Kepatuhan Regulasi</span>
                <span class="text-primary material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">verified_user</span>
            </div>
            <div class="flex items-center gap-2 z-10 mt-1">
                <span class="text-3xl text-on-surface font-black tabular-nums"><span id="live-kepatuhan">100%</span></span>
                <span class="px-2 py-0.5 rounded-full border border-primary/40 text-primary bg-primary/5 text-[10px] uppercase font-black tracking-tighter">Tersertifikasi</span>
            </div>
            <div class="absolute inset-0 bg-primary/5 opacity-0 group-hover:opacity-100 transition-opacity"></div>
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
        <!-- Metric 4 -->
        <div class="bg-surface-container-low border border-outline-variant/30 shadow-sm p-lg rounded-xl flex flex-col justify-between h-32 relative overflow-hidden group hover:border-sky-500/40 :border-sky-400/40 transition-all duration-300">
            <div class="flex justify-between items-start z-10">
                <span class="text-on-surface-variant font-label-md text-label-md uppercase tracking-widest transition-colors duration-300">Penghematan Operasional (Estimasi)</span>
                <span class="text-primary transition-colors duration-300 material-symbols-outlined">payments</span>
            </div>
            <div class="flex items-baseline gap-2 z-10">
                <?php
                    $safeRoutes = collect($routesData)->filter(fn($r) => $r['is_safe'])->count();
                    $savings = $safeRoutes * 8.5; // in Juta
                ?>
                <span class="font-headline-lg text-headline-lg text-on-surface font-bold transition-colors duration-300"><span id="live-penghematan">Rp <?php echo e(number_format($savings, 1, ',', '.')); ?> Jt</span></span>
                <span class="text-on-surface-variant font-body-md text-body-md transition-colors duration-300 tooltip" title="Diasumsikan rata-rata nilai kargo vaksin per boks mencapai Rp 8,5 Juta. Nilai ini dikalikan dengan rute tanpa insiden suhu (<?php echo e($safeRoutes); ?> rute aman).">Est. Rp 8,5Jt/Boks Terselamatkan</span>
            </div>
            <div class="absolute top-0 right-0 p-2 opacity-5 group-hover:opacity-10 transition-opacity">
                <span class="material-symbols-outlined text-6xl text-sky-600/10  transition-colors duration-300">psychology</span>
            </div>
        </div>
    </div>

    <!-- AI Predictive Shelf-life Monitor (CDOB Compliance) -->
    <div class="space-y-md mb-md">
        <div class="flex items-center gap-2">
            <span class="text-primary material-symbols-outlined transition-colors duration-300">psychology</span>
            <h2 class="font-headline-sm text-headline-sm text-on-surface transition-colors duration-300">AI Predictive Shelf-life Monitor (Kepatuhan CDOB)</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-gutter">
            <?php $__currentLoopData = $routesData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $route): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $mktVal = (float)$route['mkt'];
                if ($mktVal >= 2.0 && $mktVal <= 8.0) {
                    $shelfLife = "36 Jam (Optimal)";
                    $shelfLifeProgress = 100;
                    $shelfColor = "bg-sky-500 ";
                    $shelfBg = "bg-primary/10 border-primary/20 text-primary";
                    $shelfTextColor = "text-primary";
                } elseif ($mktVal > 8.0 && $mktVal <= 8.5) {
                    $shelfLife = "12 Jam (Peringatan)";
                    $shelfLifeProgress = 40;
                    $shelfColor = "bg-amber-500 ";
                    $shelfBg = "bg-amber-50  border-amber-100  text-amber-600  animate-pulse";
                    $shelfTextColor = "text-amber-600 ";
                } else {
                    $shelfLife = "0,5 Jam (Bahaya Kritis)";
                    $shelfLifeProgress = 10;
                    $shelfColor = "bg-red-500 ";
                    $shelfBg = "bg-red-50  border-red-100  text-red-600  animate-pulse";
                    $shelfTextColor = "text-red-600 ";
                }
            ?>
            <?php if (isset($component)) { $__componentOriginal53747ceb358d30c0105769f8471417f6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal53747ceb358d30c0105769f8471417f6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.card','data' => ['class' => 'transition-all duration-300 flex flex-col justify-between gap-sm relative overflow-hidden group hover:border-primary/40']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'transition-all duration-300 flex flex-col justify-between gap-sm relative overflow-hidden group hover:border-primary/40']); ?>
                <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                    <span class="material-symbols-outlined text-7xl text-on-surface">hourglass_empty</span>
                </div>
                
                <div class="flex justify-between items-start">
                    <div>
                        <div class="flex items-center gap-1">
                            <span class="px-2 py-0.5 rounded text-[10px] font-black uppercase tracking-wider bg-slate-100 text-slate-600   border border-outline-variant/40">BOX-<?php echo e($route['id_box']); ?></span>
                            <?php if(isset($route['is_demo']) && $route['is_demo']): ?>
                            <span class="px-2 py-0.5 rounded text-[10px] font-black uppercase tracking-wider bg-amber-100 text-amber-700   border border-amber-200 ">DEMO</span>
                            <?php endif; ?>
                        </div>
                        <h4 class="font-bold text-base text-on-surface mt-1.5"><?php echo e($route['nama_kargo']); ?></h4>
                        <p class="text-xs text-slate-500 font-semibold mt-0.5">Kurir: <?php echo e($route['nama_kurir']); ?></p>
                    </div>
                    <span class="px-2.5 py-1 rounded-full text-xs font-black tracking-wide <?php echo e($shelfBg); ?> border font-mono">
                        <?php echo e(number_format($mktVal, 1, ',', '.')); ?>°C MKT
                    </span>
                </div>

                <div class="space-y-1.5 mt-2">
                    <div class="flex justify-between text-xs font-semibold">
                        <span class="text-slate-500">Est. Sisa Waktu Kelayakan:</span>
                        <span class="font-bold uppercase <?php echo e($shelfTextColor); ?>"><?php echo e($shelfLife); ?></span>
                    </div>
                    <div class="w-full h-2 bg-surface-container-highest rounded-full overflow-hidden">
                        <div class="h-full <?php echo e($shelfColor); ?> rounded-full transition-all duration-500" style="width: <?php echo e($shelfLifeProgress); ?>%"></div>
                    </div>
                </div>

                <div class="flex justify-between items-center mt-3 pt-3 border-t border-outline-variant/20">
                    <span class="text-[10px] text-slate-500 font-mono font-bold">AI Risk Projection: <?php echo e(number_format($route['ai_risk'], 2, ',', '.')); ?>%</span>
                    <button class="btn-proyeksi text-primary hover:text-primary/80 text-xs font-bold uppercase tracking-wider flex items-center gap-1 active:scale-95 transition-all duration-300 cursor-pointer" 
                            data-box="BOX-<?php echo e($route['id_box']); ?>"
                            data-kargo="<?php echo e($route['nama_kargo']); ?>"
                            data-mkt="<?php echo e(number_format($mktVal, 1, ',', '.')); ?>"
                            data-shelflife="<?php echo e($shelfLife); ?>">
                        <span class="material-symbols-outlined text-xs">trending_up</span> Proyeksi AI
                    </button>
                </div>
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
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>

    <!-- Middle Section: Main Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-gutter mb-md">
        <!-- Chart 1: Prediksi Risiko -->
        <?php if (isset($component)) { $__componentOriginal53747ceb358d30c0105769f8471417f6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal53747ceb358d30c0105769f8471417f6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.card','data' => ['class' => 'lg:col-span-8 flex flex-col min-h-[400px] overflow-hidden min-w-0']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'lg:col-span-8 flex flex-col min-h-[400px] overflow-hidden min-w-0']); ?>
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
                <div>
                    <h3 class="font-bold text-on-surface">Tren Risiko Prediktif</h3>
                    <p class="text-slate-500 text-xs mt-0.5">Obat Termolabil Rusak vs Prediksi Risiko AI (6 Bulan)</p>
                </div>
                <div class="flex gap-4">
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-amber-500"></span>
                        <span class="text-xs font-bold text-slate-500">Kerusakan Aktual</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-primary"></span>
                        <span class="text-xs font-bold text-slate-500">Prediksi AI</span>
                    </div>
                </div>
            </div>
            <!-- Dynamic Chart (ApexCharts) -->
            <div id="chart-risiko-prediktif" class="flex-1 min-h-[250px] w-full"></div>
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

        <!-- Regional Heatmap / Hub Performance -->
        <?php if (isset($component)) { $__componentOriginal53747ceb358d30c0105769f8471417f6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal53747ceb358d30c0105769f8471417f6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.card','data' => ['class' => 'lg:col-span-4 flex flex-col h-full overflow-hidden']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'lg:col-span-4 flex flex-col h-full overflow-hidden']); ?>
            <h3 class="font-bold text-on-surface mb-1">Kinerja Hub</h3>
            <p class="text-slate-500 text-xs mb-4">Efisiensi distribusi tujuan rute.</p>
            <div class="flex-1 space-y-3 overflow-y-auto pr-2">
                <?php if($topHubs->isEmpty()): ?>
                    <div class="flex flex-col items-center justify-center h-40 text-center space-y-2">
                        <span class="material-symbols-outlined text-4xl text-slate-300 ">route</span>
                        <p class="text-sm text-slate-500  font-medium">Belum ada rute nyata</p>
                        <p class="text-xs text-slate-400 ">Mulai pengiriman pertama untuk melihat analitik tujuan.</p>
                    </div>
                <?php else: ?>
                    <?php $__currentLoopData = $topHubs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $hub): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <!-- Hub Card -->
                    <div class="p-4 rounded border border-outline-variant/20 border-l-4 border-l-<?php echo e($hub['color']); ?> bg-slate-50 ">
                        <div class="flex justify-between items-center mb-1">
                            <span class="font-bold text-sm text-on-surface"><?php echo e($hub['nama']); ?></span>
                            <span class="text-<?php echo e($hub['color']); ?> text-[10px] font-black tracking-wider bg-<?php echo e($hub['color']); ?>/10 px-2 py-0.5 rounded"><?php echo e($hub['status']); ?></span>
                        </div>
                        <div class="flex justify-between items-end">
                            <span class="text-xs text-slate-500 font-bold">Efisiensi: <?php echo e(number_format($hub['efisiensi'], 1, ',', '.')); ?>%</span>
                            <div class="w-32 h-1 bg-surface-container-highest rounded-full overflow-hidden mb-1">
                                <div class="h-full bg-<?php echo e($hub['color']); ?>" style="width: <?php echo e($hub['efisiensi']); ?>%"></div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            </div>
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
    </div>

    <!-- Live Tracking Map Section -->
    <?php if (isset($component)) { $__componentOriginal53747ceb358d30c0105769f8471417f6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal53747ceb358d30c0105769f8471417f6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.card','data' => ['noPadding' => 'true','class' => 'mb-md overflow-hidden relative border border-outline-variant/30 shadow-sm']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['noPadding' => 'true','class' => 'mb-md overflow-hidden relative border border-outline-variant/30 shadow-sm']); ?>
        <div class="p-4 border-b border-outline-variant/20 flex justify-between items-center bg-surface-container transition-colors duration-300">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">map</span>
                <h3 class="font-bold text-on-surface">Peta Pemantauan Armada (Real-time)</h3>
            </div>
            <div class="flex items-center gap-2">
                <span id="map-status-badge" class="px-2 py-1 rounded-lg text-xs font-bold bg-green-500/10 text-green-600  border border-green-500/20 flex items-center gap-1 transition-colors duration-300">
                    <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span> Live
                </span>
            </div>
        </div>
        <div id="live-map" class="w-full h-[450px] z-10 bg-slate-100 "></div>
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

    <!-- Operational Efficiency Table -->
    <?php if (isset($component)) { $__componentOriginal53747ceb358d30c0105769f8471417f6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal53747ceb358d30c0105769f8471417f6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.card','data' => ['noPadding' => 'true','class' => 'mb-6 overflow-hidden']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['noPadding' => 'true','class' => 'mb-6 overflow-hidden']); ?>
        <div class="p-4 border-b border-outline-variant/20 flex justify-between items-center bg-surface-container">
            <h3 class="font-bold text-on-surface">Indeks Efisiensi Rute</h3>
            <div class="flex gap-2">
                <button class="p-2 hover:bg-slate-100 :bg-slate-800 text-slate-500 hover:text-slate-800 :text-slate-100 rounded-lg transition-colors duration-300 cursor-pointer"><span class="material-symbols-outlined text-[18px]">filter_list</span></button>
                <button class="p-2 hover:bg-slate-100 :bg-slate-800 text-slate-500 hover:text-slate-800 :text-slate-100 rounded-lg transition-colors duration-300 cursor-pointer"><span class="material-symbols-outlined text-[18px]">fullscreen</span></button>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr>
                        <th scope="col">ID Rute (Box)</th>
                        <th scope="col">Mitra Kurir / Tujuan</th>
                        <th scope="col" class="text-center">Peringkat Stabilitas (Indeks)</th>
                        <th scope="col" class="text-center">Suhu Penyimpanan</th>
                        <th scope="col" class="text-right">Potensi Risiko Spoilage (AI)</th>
                        <th scope="col" class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/30">
                    <?php $__empty_1 = true; $__currentLoopData = $routesData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $route): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr data-box="BOX-<?php echo e($route['id_box']); ?>">
                        <td class="font-bold text-primary">BOX-<?php echo e($route['id_box']); ?></td>
                        <td class="px-lg py-4 text-on-surface transition-colors duration-300">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded bg-surface-container-highest flex items-center justify-center border border-outline-variant/40 text-xs font-black text-primary transition-colors duration-300">
                                    <?php echo e(substr($route['nama_kurir'], 0, 2)); ?>

                                </div>
                                <div>
                                    <div class="font-semibold"><?php echo e($route['nama_kurir']); ?></div>
                                    <div class="text-xs text-on-surface-variant transition-colors duration-300"><?php echo e($route['tujuan']); ?></div>
                                </div>
                            </div>
                        </td>
                        <td class="px-lg py-4">
                            <div class="flex justify-center items-center gap-2">
                                <div class="flex gap-0.5">
                                    <?php
                                        $stars = round($route['efficiency_index'] / 20);
                                    ?>
                                    <?php for($i = 1; $i <= 5; $i++): ?>
                                        <?php if($i <= $stars): ?>
                                            <span class="material-symbols-outlined text-primary text-xs transition-colors duration-300" style="font-variation-settings: 'FILL' 1;">star</span>
                                        <?php else: ?>
                                            <span class="material-symbols-outlined text-slate-300  text-xs transition-colors duration-300">star</span>
                                        <?php endif; ?>
                                    <?php endfor; ?>
                                </div>
                                <span class="text-xs font-semibold text-primary transition-colors duration-300">(<?php echo e(number_format($route['efficiency_index'], 1, ',', '.')); ?>%)</span>
                            </div>
                        </td>
                        <td class="px-lg py-4 text-center">
                            <?php
                                $deviation = abs($route['avg_temp'] - 5.0);
                            ?>
                            <span class="px-2 py-0.5 rounded-full <?php echo e($deviation > 3.0 ? 'bg-red-50  border-red-100  text-red-600 ' : ($deviation > 1.5 ? 'bg-amber-50  border-amber-100  text-amber-600 ' : 'bg-primary/10 border-primary/20 text-primary')); ?> text-[10px] font-black font-data-mono transition-colors duration-300">
                                &plusmn;<?php echo e(number_format($deviation, 2, ',', '.')); ?>°C (Rerata: <span id="temp-BOX-<?php echo e($route['id_box']); ?>"><?php echo e(number_format($route['avg_temp'], 1, ',', '.')); ?>°C</span>)
                            </span>
                        </td>
                        <td class="px-lg py-4 text-right font-data-mono text-on-surface-variant transition-colors duration-300">
                            Risiko AI: <span id="risk-BOX-<?php echo e($route['id_box']); ?>"><?php echo e(number_format($route['ai_risk'], 2, ',', '.')); ?>%</span>
                        </td>
                        <td class="px-lg py-4 text-right">
                            <?php if($deviation > 1.5 || $route['ai_risk'] > 50.0): ?>
                                <button class="btn-analisis bg-red-600 hover:bg-red-700 text-white shadow-[0_0_12px_rgba(220,38,38,0.2)]  :bg-red-600 px-md py-1.5 rounded-xl text-xs font-bold tracking-widest active:scale-95 transition-all duration-300" 
                                        data-box="BOX-<?php echo e($route['id_box']); ?>" 
                                        data-kurir="<?php echo e($route['nama_kurir']); ?>" 
                                        data-tujuan="<?php echo e($route['tujuan']); ?>" 
                                        data-stabilitas="<?php echo e(number_format($route['efficiency_index'], 1, ',', '.')); ?>%" 
                                        data-suhu="<?php echo e(number_format($route['avg_temp'], 1, ',', '.')); ?>°C" 
                                        data-risiko="<?php echo e(number_format($route['ai_risk'], 2, ',', '.')); ?>%">
                                    TINDAK LANJUT
                                </button>
                            <?php else: ?>
                                <button class="btn-analisis text-sky-600 hover:text-sky-700  :text-sky-300 text-xs font-bold uppercase tracking-tighter active:scale-95 transition-all duration-300" 
                                        data-box="BOX-<?php echo e($route['id_box']); ?>" 
                                        data-kurir="<?php echo e($route['nama_kurir']); ?>" 
                                        data-tujuan="<?php echo e($route['tujuan']); ?>" 
                                        data-stabilitas="<?php echo e(number_format($route['efficiency_index'], 1, ',', '.')); ?>%" 
                                        data-suhu="<?php echo e(number_format($route['avg_temp'], 1, ',', '.')); ?>°C" 
                                        data-risiko="<?php echo e(number_format($route['ai_risk'], 2, ',', '.')); ?>%">
                                    Analisis
                                </button>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" class="px-lg py-4 text-center text-on-surface-variant transition-colors duration-300">Tidak ada rute/sensor aktif saat ini.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="p-md bg-slate-50  border-t border-outline-variant/30 flex justify-between items-center px-lg text-on-surface-variant transition-colors duration-300">
            <span class="text-xs font-medium font-label-md">Menampilkan <?php echo e(count($routesData)); ?> rute pengiriman obat aktif</span>
        </div>
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
</div>

<!-- Detailed Analysis Modal -->
<div id="analysis-modal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-md bg-black/60 backdrop-blur-sm transition-opacity duration-300">
    <div class="bg-surface-container bg-surface-container-low border border-outline-variant/30 rounded-2xl w-full max-w-2xl overflow-hidden shadow-2xl scale-95 opacity-0 transition-all duration-300 flex flex-col max-h-[90vh]">
        <!-- Modal Header -->
        <div class="px-lg py-md border-b border-outline-variant/30 flex justify-between items-center bg-slate-50  transition-colors duration-300">
            <div class="flex items-center gap-sm">
                <span class="material-symbols-outlined text-primary transition-colors duration-300">query_stats</span>
                <h3 class="font-headline-sm text-headline-sm text-on-surface transition-colors duration-300" id="modal-title">Analisis Detil Sensor</h3>
            </div>
            <button id="close-analysis-modal" class="p-2 hover:bg-slate-100 :bg-slate-700 rounded-lg text-slate-500 hover:text-slate-800  :text-slate-100 transition-colors duration-300">
                <span class="material-symbols-outlined text-[20px] align-middle">close</span>
            </button>
        </div>
        
        <!-- Modal Body -->
        <div class="p-lg overflow-y-auto space-y-lg flex-1">
            <!-- Info Cards Grid -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-sm">
                <div class="p-md rounded-xl bg-slate-50  border border-outline-variant/30 transition-colors duration-300">
                    <span class="text-[10px] text-on-surface-variant uppercase font-semibold transition-colors duration-300">Box ID</span>
                    <p class="font-bold text-primary mt-1 font-mono transition-colors duration-300" id="modal-box-id">-</p>
                </div>
                <div class="p-md rounded-xl bg-slate-50  border border-outline-variant/30 transition-colors duration-300">
                    <span class="text-[10px] text-on-surface-variant uppercase font-semibold transition-colors duration-300">Stabilitas</span>
                    <p class="font-bold text-on-surface mt-1 transition-colors duration-300" id="modal-stabilitas">-</p>
                </div>
                <div class="p-md rounded-xl bg-slate-50  border border-outline-variant/30 transition-colors duration-300">
                    <span class="text-[10px] text-on-surface-variant uppercase font-semibold transition-colors duration-300">Suhu Rerata</span>
                    <p class="font-bold text-on-surface mt-1 transition-colors duration-300" id="modal-suhu-rerata">-</p>
                </div>
                <div class="p-md rounded-xl bg-slate-50  border border-outline-variant/30 transition-colors duration-300">
                    <span class="text-[10px] text-on-surface-variant uppercase font-semibold transition-colors duration-300">Risiko AI</span>
                    <p class="font-bold text-red-600  mt-1 transition-colors duration-300" id="modal-risiko-ai">-</p>
                </div>
            </div>

            <!-- Shipment details -->
            <div class="p-md rounded-xl bg-slate-100/50  border border-outline-variant/50/30 space-y-2 transition-colors duration-300">
                <div class="flex justify-between text-xs">
                    <span class="text-on-surface-variant transition-colors duration-300">Kurir Penanggung Jawab</span>
                    <span class="font-bold text-on-surface transition-colors duration-300" id="modal-kurir-name">-</span>
                </div>
                <div class="flex justify-between text-xs">
                    <span class="text-on-surface-variant transition-colors duration-300">Tujuan Pengiriman</span>
                    <span class="font-bold text-on-surface truncate max-w-xs transition-colors duration-300" id="modal-dest">-</span>
                </div>
            </div>

            <!-- Telemetry Log Simulation Chart -->
            <div class="space-y-sm">
                <h4 class="font-label-md text-label-md text-on-surface-variant uppercase tracking-wider transition-colors duration-300">Simulasi Fluktuasi Telemetri (1 Jam Terakhir)</h4>
                <div id="chart-modal-telemetry" class="w-full h-44 bg-slate-50/50  rounded-xl border border-outline-variant/50/30 p-2 transition-colors duration-300"></div>
            </div>
        </div>
        
        <!-- Modal Footer -->
        <div class="px-lg py-md border-t border-outline-variant/30 flex justify-end gap-sm bg-slate-50  transition-colors duration-300">
            <button id="btn-modal-calibrate" class="px-md py-2 border border-outline-variant/50 hover:bg-slate-100 :bg-slate-800 rounded-xl text-xs font-semibold text-slate-800  transition-all active:scale-95 flex items-center gap-1 duration-300">
                <span class="material-symbols-outlined text-[16px] text-primary transition-colors duration-300">tune</span> Kalibrasi Sensor
            </button>
            <button id="close-analysis-modal-btn" class="px-md py-2 bg-primary hover:bg-primary/90 text-white rounded-xl text-xs font-semibold transition-all duration-300 active:scale-95 shadow-[0_0_10px_rgba(2,132,199,0.2)]">
                Tutup
            </button>
        </div>
    </div>
</div>

<!-- AI Shelf-life Projection Modal -->
<div id="projection-modal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-md bg-black/60 backdrop-blur-sm transition-opacity duration-300">
    <div class="bg-surface-container bg-surface-container-low border border-outline-variant/30 rounded-2xl w-full max-w-2xl overflow-hidden shadow-2xl scale-95 opacity-0 transition-all duration-300 flex flex-col max-h-[90vh]">
        <!-- Modal Header -->
        <div class="px-lg py-md border-b border-outline-variant/30 flex justify-between items-center bg-slate-50  transition-colors duration-300">
            <div class="flex items-center gap-sm">
                <span class="material-symbols-outlined text-primary transition-colors duration-300">psychology</span>
                <h3 class="font-headline-sm text-headline-sm text-on-surface transition-colors duration-300" id="proj-modal-title">Proyeksi Penurunan Kualitas AI</h3>
            </div>
            <button id="close-projection-modal" class="p-2 hover:bg-slate-100 :bg-slate-700 rounded-lg text-slate-500 hover:text-slate-800  :text-slate-100 transition-colors duration-300">
                <span class="material-symbols-outlined text-[20px] align-middle">close</span>
            </button>
        </div>
        
        <!-- Modal Body -->
        <div class="p-lg overflow-y-auto space-y-lg flex-1">
            <!-- Info Header -->
            <div class="grid grid-cols-3 gap-sm">
                <div class="p-md rounded-xl bg-slate-50  border border-outline-variant/30 transition-colors duration-300">
                    <span class="text-[10px] text-on-surface-variant uppercase font-semibold transition-colors duration-300">Box ID & Kargo</span>
                    <p class="font-bold text-primary mt-1 font-mono text-xs truncate transition-colors duration-300" id="proj-modal-box">-</p>
                </div>
                <div class="p-md rounded-xl bg-slate-50  border border-outline-variant/30 transition-colors duration-300">
                    <span class="text-[10px] text-on-surface-variant uppercase font-semibold transition-colors duration-300">Mean Kinetic Temp</span>
                    <p class="font-bold text-on-surface mt-1 transition-colors duration-300" id="proj-modal-mkt">-</p>
                </div>
                <div class="p-md rounded-xl bg-slate-50  border border-outline-variant/30 transition-colors duration-300">
                    <span class="text-[10px] text-on-surface-variant uppercase font-semibold transition-colors duration-300">Est. Kelayakan</span>
                    <p class="font-bold text-primary mt-1 text-xs truncate transition-colors duration-300" id="proj-modal-shelflife">-</p>
                </div>
            </div>

            <!-- Description -->
            <p class="text-xs text-on-surface-variant leading-relaxed transition-colors duration-300">
                Grafik di bawah mensimulasikan laju degradasi kualitas produk biologis berdasarkan akumulasi paparan panas (Arrhenius Equation) dibandingkan dengan batas toleransi CDOB BPOM.
            </p>

            <!-- ApexCharts spline chart container -->
            <div class="space-y-sm">
                <h4 class="font-label-md text-label-md text-on-surface-variant uppercase tracking-wider transition-colors duration-300">Kurva Degradasi Kualitas (MKT vs Sisa Jam)</h4>
                <div id="chart-degradasi-kualitas" class="w-full h-56 bg-slate-50/50  rounded-xl border border-outline-variant/50/30 p-2 transition-colors duration-300"></div>
            </div>
        </div>
        
        <!-- Modal Footer -->
        <div class="px-lg py-md border-t border-outline-variant/30 flex justify-end gap-sm bg-slate-50  transition-colors duration-300">
            <button id="close-projection-modal-btn" class="px-md py-2 bg-primary hover:bg-primary/90 text-white rounded-xl text-xs font-semibold transition-all duration-300 active:scale-95 shadow-[0_0_10px_rgba(2,132,199,0.2)]">
                Tutup Proyeksi
            </button>
        </div>
    </div>
</div>

<!-- Interactive Layer: Notification Toast (Micro-interaction) -->
<div class="fixed bottom-gutter right-gutter bg-surface-container-low border border-outline-variant/30 p-md rounded-xl border-l-4 border-sky-500  translate-y-24 opacity-0 transition-all duration-500 z-50 pointer-events-none shadow-lg" id="toast">
    <div class="flex items-center gap-3">
        <span class="material-symbols-outlined text-primary transition-colors duration-300">analytics</span>
        <div>
            <div class="font-bold text-sm text-on-surface transition-colors duration-300" id="toast-title">Laporan Berhasil Dibuat</div>
            <div class="text-xs text-on-surface-variant transition-colors duration-300" id="toast-desc">Ringkasan Operasional Q1 telah siap.</div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<!-- Leaflet CSS & JS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
<style>
    /* Customizing TomSelect for Tailwind dark mode compatibility */
    .ts-wrapper .ts-control {
        border: none;
        background: transparent;
        padding: 6px 12px;
        min-height: auto;
        font-size: 0.75rem;
        font-weight: 600;
        cursor: pointer;
    }
    .dark .ts-wrapper .ts-control {
        color: #e2e8f0;
    }
    .ts-wrapper.single .ts-control:after {
        border-color: #64748b transparent transparent transparent;
    }
    .ts-dropdown {
        border-radius: 0.5rem;
        font-size: 0.875rem;
        z-index: 50;
    }
    .dark .ts-dropdown {
        background: #1e293b;
        color: #e2e8f0;
        border: 1px solid #334155;
    }
    .dark .ts-dropdown .active {
        background: #334155;
        color: #fff;
    }
</style>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // --- Leaflet Map Implementation ---
        let map = L.map('live-map').setView([-2.9761, 104.7754], 12); // Default to Palembang
        
        L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>',
            subdomains: 'abcd',
            maxZoom: 20
        }).addTo(map);

        let markers = {};

        function fetchLivePositions() {
            fetch('<?php echo e(route("sensors.posisiArmada")); ?>')
                .then(res => res.json())
                .then(data => {
                    if(data.success && data.data) {
                        updateMapMarkers(data.data);
                    }
                })
                .catch(err => console.error("Error fetching armada positions:", err));
        }

        function updateMapMarkers(armadaList) {
            let activeRouteIds = new Set();
            
            armadaList.forEach(armada => {
                activeRouteIds.add(armada.id_rute);
                
                // Cek jika GPS belum fix
                if(armada.lat === 0 || armada.lng === 0 || (armada.lat === 0.0 && armada.lng === 0.0)) {
                    // Jika marker ada tapi GPS tiba-tiba 0 (hilang sinyal), hapus dari map
                    if(markers[armada.id_rute]) {
                        map.removeLayer(markers[armada.id_rute]);
                        delete markers[armada.id_rute];
                    }
                    
                    // Update UI list di tabel jika perlu (opsional, tabel sudah punya list sendiri)
                    return; 
                }

                let latLng = [armada.lat, armada.lng];
                let popupContent = `
                    <div class="p-1">
                        <div class="font-bold text-sm mb-1 text-slate-800">${armada.nama_kurir}</div>
                        <div class="text-xs text-slate-600 font-mono mb-2 bg-slate-100 px-1.5 py-0.5 rounded inline-block">${armada.nomor_kendaraan} | BOX-${armada.id_box}</div>
                        <div class="text-xs flex justify-between items-center border-t pt-1.5 mt-1 border-slate-200">
                            <span class="text-slate-500">Suhu:</span>
                            <span class="font-bold ${armada.suhu_aktual < 2 || armada.suhu_aktual > 8 ? 'text-red-500' : 'text-sky-600'}">${armada.suhu_aktual} &deg;C</span>
                        </div>
                        <div class="text-[10px] text-slate-400 mt-1 text-right">
                            Update: ${new Date(armada.terakhir_update).toLocaleTimeString('id-ID')}
                        </div>
                    </div>
                `;

                if(markers[armada.id_rute]) {
                    // Update posisi marker yang sudah ada
                    markers[armada.id_rute].setLatLng(latLng);
                    markers[armada.id_rute].getPopup().setContent(popupContent);
                } else {
                    // Buat marker baru
                    let markerIcon = L.divIcon({
                        className: 'custom-div-icon',
                        html: `<div style="background-color: #0ea5e9; width: 14px; height: 14px; border-radius: 50%; border: 2px solid white; box-shadow: 0 0 5px rgba(0,0,0,0.5);"></div>`,
                        iconSize: [14, 14],
                        iconAnchor: [7, 7]
                    });

                    let marker = L.marker(latLng, {icon: markerIcon}).addTo(map);
                    marker.bindPopup(popupContent);
                    markers[armada.id_rute] = marker;
                }
            });

            // Hapus marker yang rutenya sudah tidak aktif
            Object.keys(markers).forEach(id_rute => {
                if(!activeRouteIds.has(parseInt(id_rute))) {
                    map.removeLayer(markers[id_rute]);
                    delete markers[id_rute];
                }
            });
        }

        // Jalankan polling setiap 10 detik
        fetchLivePositions();
        setInterval(fetchLivePositions, 10000);

        if (document.getElementById('filter-box')) {
            new TomSelect('#filter-box',{
                create: false,
                sortField: {
                    field: "text",
                    direction: "asc"
                }
            });
        }

        window.applyFilters = function() {
            const date = document.getElementById('filter-date').value;
            const box = document.getElementById('filter-box').value;
            window.location.href = window.location.pathname + '?date=' + encodeURIComponent(date) + '&id_box=' + encodeURIComponent(box);
        };
        window.downloadExcelReport = function() {
            const date = document.getElementById('filter-date').value;
            const box = document.getElementById('filter-box').value;
            window.location.href = '/dashboard/export?date=' + encodeURIComponent(date) + '&id_box=' + encodeURIComponent(box);
        };

        // Render Predictive Risk Trend Chart
        var chartDataRisiko = <?php echo json_encode($aiRisks, 15, 512) ?>;
        var chartDataDamaged = <?php echo json_encode($actualDamaged, 15, 512) ?>;
        
        var options = {
            series: [{
                name: "Prediksi Risiko AI (%)",
                data: chartDataRisiko
            }, {
                name: "Kerusakan Aktual (%)",
                data: chartDataDamaged
            }],
            chart: {
                height: 280,
                type: 'area',
                toolbar: { show: false }
            },
            colors: ['#4cd7f6', '#ffb95f'],
            stroke: {
                curve: 'smooth',
                width: 3
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.35,
                    opacityTo: 0.05,
                    stops: [50, 100, 100]
                }
            },
            xaxis: {
                categories: <?php echo json_encode($chartCategories, 15, 512) ?>,
                labels: {
                    style: {
                        colors: '#bcc9cd'
                    }
                }
            },
            yaxis: {
                labels: {
                    style: {
                        colors: '#bcc9cd'
                    }
                }
            },
            tooltip: {
                theme: 'dark'
            }
        };

        var chart = new ApexCharts(document.querySelector("#chart-risiko-prediktif"), options);
        chart.render();

        // Q1/Q2/Kustom Time Filter Micro-interactions
        const buttons = document.querySelectorAll('#time-filter-buttons button');
        buttons.forEach((btn, idx) => {
            btn.addEventListener('click', () => {
                buttons.forEach(b => {
                    b.className = 'q-btn px-4 py-1.5 text-xs font-medium text-on-surface-variant hover:text-slate-800 :text-slate-200 rounded-md transition-all duration-300';
                });
                btn.className = 'q-btn px-4 py-1.5 text-xs font-bold bg-primary/10 text-sky-600   rounded-md transition-all duration-300';
                
                // Trigger chart updates with randomized dummy trends based on quarter selected
                let mult = (idx === 0) ? 1.0 : ((idx === 1) ? 1.4 : 0.8);
                let newRisiko = chartDataRisiko.map(x => Math.min(100, Math.round(x * mult * 10) / 10));
                let newDamaged = chartDataDamaged.map(x => Math.min(100, Math.round(x * mult * 0.9 * 10) / 10));
                
                chart.updateSeries([{
                    name: "Prediksi Risiko AI (%)",
                    data: newRisiko
                }, {
                    name: "Kerusakan Aktual (%)",
                    data: newDamaged
                }]);
            });
        });

        // Report Type Dropdown interaction
        const selectReport = document.querySelector('select');
        if (selectReport) {
            selectReport.addEventListener('change', (e) => {
                showToast('Kategori Laporan Diubah', `Memuat data ${e.target.value}...`);
                // Randomize values to make it feel alive
                let randRisiko = chartDataRisiko.map(() => Math.round(Math.random() * 80 + 5));
                let randDamaged = chartDataDamaged.map(() => Math.round(Math.random() * 60));
                setTimeout(() => {
                    chart.updateSeries([{
                        name: "Prediksi Risiko AI (%)",
                        data: randRisiko
                    }, {
                        name: "Kerusakan Aktual (%)",
                        data: randDamaged
                    }]);
                }, 500);
            });
        }

        // Export PDF Micro-interaction
        const toast = document.getElementById('toast');
        const toastTitle = document.getElementById('toast-title');
        const toastDesc = document.getElementById('toast-desc');
        const pdfBtn = document.getElementById('btn-pdf-export');
        
        function showToast(title, desc) {
            toastTitle.textContent = title;
            toastDesc.textContent = desc;
            toast.classList.remove('translate-y-24', 'opacity-0');
            toast.classList.add('translate-y-0');
            
            setTimeout(() => {
                toast.classList.remove('translate-y-0');
                toast.classList.add('translate-y-24', 'opacity-0');
            }, 4000);
        }

        if (pdfBtn) {
            pdfBtn.addEventListener('click', () => {
                pdfBtn.innerHTML = '<span class="material-symbols-outlined text-[18px] align-middle animate-spin">sync</span>';
                
                setTimeout(() => {
                    pdfBtn.innerHTML = '<span class="material-symbols-outlined text-[18px] align-middle text-green-400">check_circle</span>';
                    showToast('Laporan PDF Dibuat', 'Ringkasan Kepatuhan & Telemetri siap diunduh.');
                    
                    setTimeout(() => {
                        pdfBtn.innerHTML = '<span class="material-symbols-outlined text-[18px] align-middle">picture_as_pdf</span>';
                    }, 4000);
                }, 1200);
            });
        }

        // --- Analysis Modal Interactivity ---
        const modal = document.getElementById('analysis-modal');
        const modalTitle = document.getElementById('modal-title');
        const modalBoxId = document.getElementById('modal-box-id');
        const modalStabilitas = document.getElementById('modal-stabilitas');
        const modalSuhuRerata = document.getElementById('modal-suhu-rerata');
        const modalRisikoAi = document.getElementById('modal-risiko-ai');
        const modalKurirName = document.getElementById('modal-kurir-name');
        const modalDest = document.getElementById('modal-dest');
        const closeBtn = document.getElementById('close-analysis-modal');
        const closeBtn2 = document.getElementById('close-analysis-modal-btn');
        const calibrateBtn = document.getElementById('btn-modal-calibrate');
        
        let modalChart = null;

        function openModal(data) {
            modalBoxId.textContent = data.box;
            modalStabilitas.textContent = data.stabilitas;
            modalSuhuRerata.textContent = data.suhu;
            modalRisikoAi.textContent = data.risiko;
            modalKurirName.textContent = data.kurir;
            modalDest.textContent = data.tujuan;
            
            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                modal.querySelector('.bg-surface-container').classList.remove('scale-95', 'opacity-0');
            }, 50);

            // Generate mock historical telemetry data for chart
            let baseTemp = parseFloat(data.suhu.replace(',', '.'));
            let mockTemps = [];
            for (let i = 0; i < 12; i++) {
                mockTemps.push(parseFloat((baseTemp + (Math.random() * 1.6 - 0.8)).toFixed(2)));
            }

            if (modalChart) {
                modalChart.destroy();
            }

            var modalChartOpts = {
                series: [{
                    name: "Suhu Sensor (°C)",
                    data: mockTemps
                }],
                chart: {
                    height: 140,
                    type: 'line',
                    toolbar: { show: false },
                    sparkline: { enabled: false }
                },
                colors: ['#06b6d4'],
                stroke: {
                    curve: 'straight',
                    width: 2.5
                },
                markers: {
                    size: 4,
                    colors: ['#06b6d4']
                },
                xaxis: {
                    categories: ['10m', '15m', '20m', '25m', '30m', '35m', '40m', '45m', '50m', '55m', '60m', 'skrg'],
                    labels: { style: { colors: '#bcc9cd', fontSize: '9px' } }
                },
                yaxis: {
                    labels: { style: { colors: '#bcc9cd', fontSize: '9px' } }
                },
                tooltip: { theme: 'dark' }
            };

            modalChart = new ApexCharts(document.querySelector("#chart-modal-telemetry"), modalChartOpts);
            modalChart.render();
        }

        function closeModal() {
            modal.classList.add('opacity-0');
            modal.querySelector('.bg-surface-container').classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }

        let currentActiveBtn = null;
        document.querySelectorAll('.btn-analisis').forEach(btn => {
            btn.addEventListener('click', () => {
                currentActiveBtn = btn;
                openModal({
                    box: btn.getAttribute('data-box'),
                    kurir: btn.getAttribute('data-kurir'),
                    tujuan: btn.getAttribute('data-tujuan'),
                    stabilitas: btn.getAttribute('data-stabilitas'),
                    suhu: btn.getAttribute('data-suhu'),
                    risiko: btn.getAttribute('data-risiko')
                });
            });
        });

        if (closeBtn) closeBtn.addEventListener('click', closeModal);
        if (closeBtn2) closeBtn2.addEventListener('click', closeModal);
        
        // Calibration action
        if (calibrateBtn) {
            calibrateBtn.addEventListener('click', () => {
                calibrateBtn.innerHTML = '<span class="material-symbols-outlined text-[16px] align-middle animate-spin text-primary">sync</span> Mengkalibrasi..';
                calibrateBtn.disabled = true;
                setTimeout(() => {
                    calibrateBtn.innerHTML = '<span class="material-symbols-outlined text-[16px] align-middle text-green-400">check_circle</span> Terkalibrasi';
                    showToast('Sensor Kalibrasi Sukses', `${modalBoxId.textContent} telah dikalibrasi ke standar &plusmn;0,02°C.`);
                    if (currentActiveBtn) {
                        currentActiveBtn.innerHTML = 'Analisis';
                        currentActiveBtn.className = 'btn-analisis text-sky-600 hover:text-sky-700  :text-sky-300 text-xs font-bold uppercase tracking-tighter active:scale-95 transition-all duration-300';
                    }
                    setTimeout(() => {
                        calibrateBtn.innerHTML = '<span class="material-symbols-outlined text-[16px] text-primary">tune</span> Kalibrasi Sensor';
                        calibrateBtn.disabled = false;
                        closeModal();
                    }, 2000);
                }, 1500);
            });
        }

        // --- AI Shelf-life Projection Modal Interactivity ---
        const projModal = document.getElementById('projection-modal');
        const projBox = document.getElementById('proj-modal-box');
        const projMkt = document.getElementById('proj-modal-mkt');
        const projShelfLife = document.getElementById('proj-modal-shelflife');
        const closeProjBtn = document.getElementById('close-projection-modal');
        const closeProjBtn2 = document.getElementById('close-projection-modal-btn');
        
        let projChart = null;

        function openProjModal(data) {
            projBox.textContent = `${data.box} - ${data.kargo}`;
            projMkt.textContent = `${data.mkt}°C`;
            projShelfLife.textContent = data.shelflife;
            
            projModal.classList.remove('hidden');
            setTimeout(() => {
                projModal.classList.remove('opacity-0');
                projModal.querySelector('.bg-surface-container').classList.remove('scale-95', 'opacity-0');
            }, 50);

            // Generate decay curve based on MKT
            let mktVal = parseFloat(data.mkt.replace(',', '.'));
            let qualityIndex = 100;
            let decayData = [];
            let hours = [];

            // Simple decay simulation: higher temperature decays faster
            let decayRate = 0.02 * Math.exp(0.15 * mktVal); // Arrhenius-like decay rate simulation

            for (let h = 0; h <= 36; h += 3) {
                hours.push(`${h}j`);
                let quality = Math.max(0, Math.round(qualityIndex * Math.exp(-decayRate * h)));
                decayData.push(quality);
            }

            if (projChart) {
                projChart.destroy();
            }

            var projChartOpts = {
                series: [{
                    name: "Indeks Kualitas (%)",
                    data: decayData
                }],
                chart: {
                    height: 200,
                    type: 'area',
                    toolbar: { show: false }
                },
                colors: [mktVal > 8.5 ? '#ffb4ab' : (mktVal > 8.0 ? '#ffb95f' : '#4cd7f6')],
                stroke: {
                    curve: 'smooth',
                    width: 3
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.45,
                        opacityTo: 0.05
                    }
                },
                xaxis: {
                    categories: hours,
                    labels: { style: { colors: '#bcc9cd', fontSize: '9px' } }
                },
                yaxis: {
                    max: 100,
                    min: 0,
                    labels: { style: { colors: '#bcc9cd', fontSize: '9px' } }
                },
                tooltip: { theme: 'dark' }
            };

            projChart = new ApexCharts(document.querySelector("#chart-degradasi-kualitas"), projChartOpts);
            projChart.render();
        }

        function closeProjModal() {
            projModal.classList.add('opacity-0');
            projModal.querySelector('.bg-surface-container').classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                projModal.classList.add('hidden');
            }, 300);
        }

        document.querySelectorAll('.btn-proyeksi').forEach(btn => {
            btn.addEventListener('click', () => {
                openProjModal({
                    box: btn.getAttribute('data-box'),
                    kargo: btn.getAttribute('data-kargo'),
                    mkt: btn.getAttribute('data-mkt'),
                    shelflife: btn.getAttribute('data-shelflife')
                });
            });
        });

        if (closeProjBtn) closeProjBtn.addEventListener('click', closeProjModal);
        if (closeProjBtn2) closeProjBtn2.addEventListener('click', closeProjModal);
    });

    // ========================================
    // REAL-TIME LIVE POLLING - Sensor Analytics
    // ========================================
    function pollSensorData() {
        fetch('/api/sensors/live', {
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            }
        })
        .then(res => res.json())
        .then(data => {
            if (!data.success) return;

            // Update KPI cards
            const integritasEl = document.getElementById('live-integritas');
            if (integritasEl) integritasEl.textContent = data.kpi.integritas.toFixed(1).replace('.', ',') + '%';

            const anomaliEl = document.getElementById('live-anomali');
            if (anomaliEl) anomaliEl.textContent = data.kpi.totalAnomali;

            const kepatuhanEl = document.getElementById('live-kepatuhan');
            if (kepatuhanEl && data.kpi.kepatuhan !== undefined) {
                kepatuhanEl.textContent = data.kpi.kepatuhan.toFixed(1).replace('.', ',') + '%';
            }

            const penghematanEl = document.getElementById('live-penghematan');
            if (penghematanEl && data.kpi.penghematan !== undefined) {
                penghematanEl.textContent = 'Rp ' + data.kpi.penghematan + ' Jt';
            }

            // Update table rows
            if (data.routes) {
                data.routes.forEach(route => {
                    const boxId = 'BOX-' + route.id_box;
                    const tempEl = document.getElementById('temp-' + boxId);
                    if (tempEl) {
                        tempEl.textContent = route.avg_temp.toFixed(1).replace('.', ',') + '°C';
                    }
                    const riskEl = document.getElementById('risk-' + boxId);
                    if (riskEl) {
                        riskEl.textContent = route.ai_risk.toFixed(2).replace('.', ',') + '%';
                    }
                });
            }
        })
        .catch(err => console.warn('[BIO-GUARD Sensors] Poll error:', err));
    }

    setInterval(pollSensorData, 3000);
    console.log('[BIO-GUARD] Sensors real-time polling started (3s interval)');
</script>
<?php $__env->stopPush(); ?>




<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\project pkm\bio_guard_backend\resources\views\dashboard\sensors.blade.php ENDPATH**/ ?>