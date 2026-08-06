<?php $__env->startSection('title', 'Pusat Kendali Logistik Medis'); ?>

<?php $__env->startSection('content'); ?>
<div class="flex-1 w-full min-h-full p-container-margin space-y-lg">

    
    
    
    
    
    
    <!-- STITCH_AI_HEADER: Ganti dengan gaya header enterprise -->
    <div class="mb-md z-40 relative border-b border-outline-variant/30 pb-4">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-md">
            
            <div>
                <nav class="flex text-label-md text-outline mb-1 gap-2">
                    <span>BIO-GUARD</span> / <span class="text-primary font-semibold">Pusat Kendali</span>
                </nav>
                <h1 class="font-headline-sm text-headline-sm text-on-surface font-bold tracking-tight">Dasbor Utama</h1>
            <div class="flex items-center gap-3 mt-xs text-xs font-semibold text-slate-500 dark:text-on-surface-variant">
                <div class="flex items-center gap-1 hover:bg-slate-100 dark:hover:bg-slate-800/50 cursor-pointer rounded-xl p-1.5 transition-all duration-300 ease-out active:scale-95 relative" id="datepicker-container" title="Filter Tanggal Historis">
                    <span class="material-symbols-outlined text-[16px] align-middle text-primary">calendar_month</span>
                    <input type="text" id="datepicker" class="bg-transparent border-none p-0 text-xs font-semibold text-slate-600 dark:text-on-surface-variant focus:ring-0 cursor-pointer w-44 hover:text-primary transition-colors" placeholder="Pilih Tanggal..." readonly>
                </div>
                <span class="text-slate-300 dark:text-slate-700">|</span>
                <p id="live-clock" class="flex items-center">
                    <span class="material-symbols-outlined text-[14px] align-middle mr-1 text-primary">schedule</span>
                    <span id="clock-value">Memuat...</span>
                </p>
            </div>
        </div>

        
        <div class="flex items-center gap-sm relative">
            
            <div class="relative z-50" id="notification-hub-container">
                <button id="notification-bell-btn" class="inline-flex items-center justify-center w-10 h-10 rounded-xl border border-outline-variant/30 bg-white dark:bg-slate-800/40 text-slate-700 dark:text-on-surface-variant hover:-translate-y-0.5 hover:shadow-md active:scale-95 transition-all duration-300 ease-out relative cursor-pointer" title="Lonceng Notifikasi Real-time">
                    <span class="material-symbols-outlined text-[20px]">notifications</span>
                    <span id="notification-count-badge" class="absolute -top-1.5 -right-1.5 inline-flex items-center justify-center min-w-[18px] h-[18px] px-1 rounded-full bg-red-500 text-white text-[9px] font-black leading-none border-2 border-white dark:border-slate-900 animate-pulse hidden">0</span>
                </button>
                
                <!-- Dropdown panel -->
                <div id="notification-dropdown" class="absolute right-0 mt-2 w-80 bg-white/95 dark:bg-slate-900/95 backdrop-blur-md border border-slate-200 dark:border-slate-850 rounded-2xl shadow-2xl p-4 hidden z-[1050] transition-all duration-200 origin-top-right">
                    <div class="flex items-center justify-between border-b border-outline-variant/30 pb-2 mb-2">
                        <span class="text-xs font-extrabold text-on-surface flex items-center gap-1.5 uppercase tracking-wider">
                            <span class="material-symbols-outlined text-[18px] text-primary">campaign</span> Log Notifikasi Real-time
                        </span>
                        <button id="clear-notifications-btn" class="text-[9px] font-extrabold text-slate-500 hover:text-primary transition-colors uppercase tracking-widest cursor-pointer">Bersihkan</button>
                    </div>
                    
                    <!-- Scroll container -->
                    <div id="notification-list" class="max-h-64 overflow-y-auto divide-y divide-slate-150 dark:divide-slate-800/50 space-y-1.5 pr-1 text-left">
                        <!-- Empty state -->
                        <div class="py-6 text-center text-slate-400 text-[11px]" id="notifications-empty-state">
                            <span class="material-symbols-outlined text-[24px] text-slate-300 dark:text-slate-700 block mb-1">notifications_off</span>
                            Tidak ada notifikasi baru
                        </div>
                    </div>
                </div>
            </div>

            <div class="relative inline-block" id="filter-dashboard-container">
                <button id="btn-filter-dashboard" class="inline-flex items-center gap-xs px-md py-[10px] rounded-xl border border-outline-variant/30 bg-white dark:bg-slate-800/40 text-slate-700 dark:text-on-surface-variant text-body-sm font-medium hover:-translate-y-0.5 hover:shadow-md active:scale-95 transition-all duration-300 ease-out cursor-pointer">
                    <span class="material-symbols-outlined text-[18px]">filter_list</span>
                    Filter
                </button>
                
                <!-- Floating Dashboard Filter Panel -->
                <div id="filter-dashboard-dropdown" class="absolute right-0 mt-2 w-72 bg-white/95 dark:bg-slate-900/95 backdrop-blur-md border border-slate-250 dark:border-slate-800 rounded-2xl shadow-2xl p-4 hidden z-[1050] transition-all duration-200 origin-top-right">
                    <div class="flex items-center justify-between border-b border-outline-variant/30 pb-2 mb-3">
                        <span class="text-xs font-extrabold text-on-surface flex items-center gap-1.5 uppercase tracking-wider select-none">
                            <span class="material-symbols-outlined text-[18px] text-primary">tune</span> Penyaringan Dasbor
                        </span>
                        <button id="btn-reset-dashboard-filter" class="text-[9px] font-extrabold text-slate-500 hover:text-primary transition-colors uppercase tracking-widest cursor-pointer">Reset</button>
                    </div>
                    
                    <div class="space-y-3 text-xs text-left">
                        
                        <div class="space-y-1">
                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider select-none">Status Rantai Dingin</label>
                            <select id="filter-status-select" class="w-full bg-slate-50 dark:bg-slate-950/40 border border-slate-250 dark:border-slate-800 rounded-xl text-on-surface px-3 py-2 focus:ring-primary/50 text-xs">
                                <option value="all">Semua Status</option>
                                <option value="Aman">Aman</option>
                                <option value="Peringatan">Peringatan Dini</option>
                                <option value="Tidak Layak Pakai">Bahaya (Ekskursi)</option>
                            </select>
                        </div>
                        
                        
                        <div class="space-y-1">
                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider select-none">Kategori Suhu Kargo</label>
                            <select id="filter-cargo-select" class="w-full bg-slate-50 dark:bg-slate-950/40 border border-slate-250 dark:border-slate-800 rounded-xl text-on-surface px-3 py-2 focus:ring-primary/50 text-xs">
                                <option value="all">Semua Kategori</option>
                                <option value="BOX-001">Chilled (BOX-001)</option>
                                <option value="BOX-002">Frozen (BOX-002)</option>
                                <option value="BOX-003">Ultra-Cold (BOX-003)</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <a href="<?php echo e(route('dashboard.export')); ?>" class="inline-flex items-center gap-xs px-md py-[10px] rounded-xl bg-primary text-on-primary text-body-sm font-semibold hover:-translate-y-0.5 hover:shadow-lg active:scale-95 transition-all duration-300 ease-out shadow-[0_0_15px_rgba(2,132,199,0.3)]">
                <span class="material-symbols-outlined text-[18px]">download</span>
                Ekspor Laporan Excel
            </a>
        </div>
    </div>

    
    <div id="desktop-notification-banner" class="hidden flex items-center justify-between px-6 py-4 bg-primary/10 border border-primary/20 rounded-2xl text-slate-700 dark:text-on-surface text-xs font-semibold gap-md animate-pulse">
        <div class="flex items-center gap-xs">
            <span class="material-symbols-outlined text-primary text-[20px] shrink-0">notifications_active</span>
            <span>Aktifkan notifikasi desktop agar Anda tetap mendapat alarm real-time ketika membuka tab lain atau meminimalkan browser.</span>
        </div>
        <button onclick="requestNotificationPermission()" class="px-4 py-2 bg-primary hover:bg-primary/80 text-on-primary font-bold rounded-xl hover:-translate-y-0.5 active:scale-95 transition-all cursor-pointer shrink-0 shadow-lg shadow-primary/20">
            Aktifkan Notifikasi
        </button>
    </div>

    
    
    
    <!-- STITCH_AI_STATS_CARD: Ganti dengan gaya card statistik enterprise -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-gutter">

        
        <?php if (isset($component)) { $__componentOriginal6d74059c34730cb2c742dae13948a701 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6d74059c34730cb2c742dae13948a701 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.metric-card','data' => ['title' => 'Kurir Aktif','value' => ''.e($totalKurirAktif ?? 0).'','valueId' => 'stat-active-couriers','icon' => 'local_shipping','color' => 'primary','valueClass' => 'text-xl']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('metric-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Kurir Aktif','value' => ''.e($totalKurirAktif ?? 0).'','valueId' => 'stat-active-couriers','icon' => 'local_shipping','color' => 'primary','valueClass' => 'text-xl']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6d74059c34730cb2c742dae13948a701)): ?>
<?php $attributes = $__attributesOriginal6d74059c34730cb2c742dae13948a701; ?>
<?php unset($__attributesOriginal6d74059c34730cb2c742dae13948a701); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6d74059c34730cb2c742dae13948a701)): ?>
<?php $component = $__componentOriginal6d74059c34730cb2c742dae13948a701; ?>
<?php unset($__componentOriginal6d74059c34730cb2c742dae13948a701); ?>
<?php endif; ?>

        
        <?php if (isset($component)) { $__componentOriginal6d74059c34730cb2c742dae13948a701 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6d74059c34730cb2c742dae13948a701 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.metric-card','data' => ['title' => 'Sinkronisasi Tertunda','value' => ''.e($totalPendingSync ?? 0).'','valueId' => 'stat-pending-sync','icon' => 'sync','color' => 'tertiary','valueClass' => 'text-xl']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('metric-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Sinkronisasi Tertunda','value' => ''.e($totalPendingSync ?? 0).'','valueId' => 'stat-pending-sync','icon' => 'sync','color' => 'tertiary','valueClass' => 'text-xl']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6d74059c34730cb2c742dae13948a701)): ?>
<?php $attributes = $__attributesOriginal6d74059c34730cb2c742dae13948a701; ?>
<?php unset($__attributesOriginal6d74059c34730cb2c742dae13948a701); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6d74059c34730cb2c742dae13948a701)): ?>
<?php $component = $__componentOriginal6d74059c34730cb2c742dae13948a701; ?>
<?php unset($__componentOriginal6d74059c34730cb2c742dae13948a701); ?>
<?php endif; ?>

        
        <?php if (isset($component)) { $__componentOriginal6d74059c34730cb2c742dae13948a701 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6d74059c34730cb2c742dae13948a701 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.metric-card','data' => ['title' => 'Status Sistem','value' => 'TERHUBUNG','icon' => 'cell_tower','color' => 'green-500','valueClass' => 'text-2xl truncate']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('metric-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Status Sistem','value' => 'TERHUBUNG','icon' => 'cell_tower','color' => 'green-500','valueClass' => 'text-2xl truncate']); ?>
            <div class="flex items-center gap-xs mt-1 absolute right-6 top-8">
                <div class="shrink-0" id="stat-alerts-container">
                    <span id="stat-alerts-value" class="inline-flex items-center justify-center min-w-[24px] h-6 px-2 rounded-full bg-error-container text-on-error-container text-[10px] font-black uppercase tracking-wider <?php echo e(($alertCount ?? 0) > 0 ? 'animate-pulse' : 'hidden'); ?>">
                        <?php echo e($alertCount ?? 0); ?> Alarm
                    </span>
                </div>
            </div>
            <div class="absolute top-6 right-6 w-2.5 h-2.5 rounded-full bg-green-500 animate-bio-pulse"></div>
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6d74059c34730cb2c742dae13948a701)): ?>
<?php $attributes = $__attributesOriginal6d74059c34730cb2c742dae13948a701; ?>
<?php unset($__attributesOriginal6d74059c34730cb2c742dae13948a701); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6d74059c34730cb2c742dae13948a701)): ?>
<?php $component = $__componentOriginal6d74059c34730cb2c742dae13948a701; ?>
<?php unset($__componentOriginal6d74059c34730cb2c742dae13948a701); ?>
<?php endif; ?>
    </div>

    
    
    
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-gutter">

        
        
        
        <!-- STITCH_AI_MAP_CARD: Ganti dengan gaya card peta enterprise -->
        <div class="lg:col-span-8">
            <?php if (isset($component)) { $__componentOriginal53747ceb358d30c0105769f8471417f6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal53747ceb358d30c0105769f8471417f6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.card','data' => ['noPadding' => 'true','class' => 'relative z-10']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['noPadding' => 'true','class' => 'relative z-10']); ?>
                
                <div class="flex items-center justify-between px-6 py-4 border-b border-outline-variant/30/60 bg-surface-container-high">
                    <div class="flex items-center gap-sm">
                        <span class="material-symbols-outlined text-primary text-[20px]">map</span>
                        <h2 class="text-lg font-bold text-on-surface">Pelacakan Armada Langsung</h2>
                    </div>
                    <div class="flex items-center gap-xs text-xs font-semibold text-slate-500">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-primary"></span>
                        </span>
                        <span class="uppercase tracking-widest text-[10px] text-primary">LANGSUNG</span>
                    </div>
                </div>

                
                <div id="map" class="w-full" style="min-height: 440px; height: 58vh;"></div>

                
                <div class="absolute top-4 right-4 z-[1000] w-52 bg-white/95 dark:bg-slate-900/95 border border-outline-variant/30 p-3 rounded-xl shadow-sm backdrop-blur-sm transition-all duration-300 group">
                    <div class="flex items-center justify-between mb-3 border-b border-outline-variant/30 pb-2">
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-teal-600 dark:text-teal-400 text-[20px] animate-pulse">insights</span>
                            <h3 class="text-xs font-extrabold text-on-surface tracking-widest uppercase">AI SPATIAL-THERMAL</h3>
                        </div>
                        <button id="btn-toggle-layers" class="text-slate-400 hover:text-teal-500 transition-colors cursor-pointer" title="Pengaturan Lapisan Peta">
                            <span class="material-symbols-outlined text-[16px] align-middle">layers</span>
                        </button>
                    </div>

                    <!-- Floating Layer Options -->
                    <div id="layers-options-panel" class="hidden mt-2 p-3 bg-slate-100/90 dark:bg-slate-950/90 rounded-xl border border-slate-250 dark:border-slate-800/50 space-y-2 mb-3 text-[11px] text-left select-none">
                        <div>
                            <span class="font-bold text-slate-700 dark:text-on-surface-variant block mb-1 uppercase tracking-wider text-[9px]">Gaya Peta</span>
                            <div class="grid grid-cols-2 gap-1">
                                <button type="button" id="btn-map-vector" class="px-2 py-1 rounded bg-primary text-on-primary font-bold text-[10px] active:scale-95 transition-all">VEKTOR</button>
                                <button type="button" id="btn-map-sat" class="px-2 py-1 rounded bg-slate-200 dark:bg-slate-800 text-slate-600 dark:text-on-surface-variant text-[10px] font-bold active:scale-95 transition-all">SATELIT</button>
                            </div>
                        </div>
                        <div class="pt-1 border-t border-outline-variant/30/60">
                            <span class="font-bold text-slate-700 dark:text-on-surface-variant block mb-1 uppercase tracking-wider text-[9px]">Overlay Spasial</span>
                            <label class="flex items-center gap-2 cursor-pointer select-none">
                                <input type="checkbox" id="chk-risk-heatmap" class="rounded border-slate-350 dark:border-slate-800 text-primary focus:ring-primary/50 h-3.5 w-3.5">
                                <span class="font-semibold text-slate-600 dark:text-on-surface-variant">Peta Panas Risiko (AI)</span>
                            </label>
                        </div>
                    </div>
                    <div class="space-y-2 text-[11px]">
                        
                        <div class="flex justify-between items-center bg-slate-100/50 dark:bg-slate-800/50 p-2 rounded-xl border border-slate-200/50 dark:border-slate-700/30">
                            <span class="font-semibold text-on-surface-variant">Suhu Luar:</span>
                            <div class="flex items-center gap-1 font-mono text-teal-600 dark:text-teal-400 font-extrabold text-[12px]">
                                <span>34&deg;C</span>
                                <span class="material-symbols-outlined text-[12px] text-red-500 font-bold animate-bounce" title="Suhu meningkat">trending_up</span>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-center bg-slate-100/50 dark:bg-slate-800/50 p-2 rounded-xl border border-slate-200/50 dark:border-slate-700/30">
                            <span class="font-semibold text-on-surface-variant">Kelembaban:</span>
                            <span class="font-mono text-teal-600 dark:text-teal-400 font-extrabold text-[12px]">80%</span>
                        </div>
                        
                        <div class="flex flex-col gap-2 bg-slate-100/50 dark:bg-slate-800/50 p-2 rounded-xl border border-slate-200/50 dark:border-slate-700/30">
                            <div class="flex justify-between items-start">
                                <span class="font-semibold text-on-surface-variant">Lalu Lintas:</span>
                                <span class="text-amber-600 dark:text-amber-400 font-extrabold flex items-center gap-1 text-[11px]">
                                    <span class="h-2 w-2 rounded-full bg-amber-500 dark:bg-amber-400 animate-pulse shrink-0"></span>
                                    Padat Tinggi
                                </span>
                            </div>
                            <p class="text-[10px] text-on-surface-variant font-medium">Jl. Jend. Sudirman</p>
                            <button onclick="alert('Mencari rute alternatif tercepat untuk menghindari kemacetan Jl. Jend. Sudirman...')" 
                                    class="w-full mt-1 py-1 rounded-lg bg-amber-500/10 hover:bg-amber-500 hover:text-white border border-amber-500/30 text-amber-600 dark:text-amber-400 text-[10px] font-bold transition-all active:scale-[0.98]">
                                Rekomendasikan Rute Baru
                            </button>
                        </div>
                    </div>
                    <p class="text-[9px] text-on-surface-variant mt-3 leading-relaxed border-t border-outline-variant/30 pt-2">
                        * Data cuaca & kemacetan Palembang dianalisis oleh AI untuk memproyeksikan risiko kerusakan kargo secara prediktif.
                    </p>
                </div>

                
                <div class="flex items-center flex-wrap gap-md px-6 py-4 border-t border-outline-variant/30/60 text-xs font-semibold text-slate-500">
                    <div class="flex items-center gap-xs">
                        <span class="w-2.5 h-2.5 rounded-full bg-primary"></span>
                        <span>Aman (2&deg;C - 8&deg;C)</span>
                    </div>
                    <div class="flex items-center gap-xs">
                        <span class="w-2.5 h-2.5 rounded-full bg-tertiary animate-pulse"></span>
                        <span>Peringatan Dini (&le; 30s)</span>
                    </div>
                    <div class="flex items-center gap-xs">
                        <span class="w-2.5 h-2.5 rounded-full bg-error animate-bio-pulse"></span>
                        <span>Tidak Layak Pakai (> 30s)</span>
                    </div>
                    <span class="ml-auto text-[10px] text-slate-400 font-mono" id="map-last-update">Pembaruan Otomatis: 2 detik</span>
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

        
        
        
        <div class="lg:col-span-4">
            <div class="bg-surface-container-low backdrop-blur-md rounded-2xl border border-outline-variant/30 overflow-hidden shadow-sm">
                
                <div class="flex items-center justify-between px-6 py-4 border-b border-outline-variant/30/60 bg-surface-container-high">
                    <div class="flex items-center gap-sm">
                        <span class="material-symbols-outlined text-primary text-[20px]">device_thermostat</span>
                        <h2 class="text-lg font-bold text-on-surface">Telemetri & Prediksi AI</h2>
                    </div>
                    <span class="text-xs font-semibold text-slate-500 uppercase tracking-widest"><?php echo e(count($perjalananAktif ?? [])); ?> aktif</span>
                </div>

                
                <!-- STITCH_AI_TELEMETRY_CARD: Ganti dengan gaya card telemetri enterprise -->
                <?php if (isset($component)) { $__componentOriginal53747ceb358d30c0105769f8471417f6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal53747ceb358d30c0105769f8471417f6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.card','data' => ['noPadding' => 'true','class' => 'h-full max-h-[60vh] overflow-y-auto']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['noPadding' => 'true','class' => 'h-full max-h-[60vh] overflow-y-auto']); ?>
                    <div id="telemetry-cards-container" class="divide-y divide-slate-200 dark:divide-slate-800">
                    <?php $__empty_1 = true; $__currentLoopData = $perjalananAktif ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $perjalanan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php
                            $log = $perjalanan->latestLog;
                            $temp = $log ? (float) $log->suhu_aktual : null;
                            $mkt = $log && $log->nilai_mkt ? (float) $log->nilai_mkt : '-';
                            $prediksi = $log ? $log->prediksiAi : null;
                            $probabilitas = $prediksi ? $prediksi->probabilitas_rusak : 0.0;
                            
                            $exInfo = $perjalanan->getExcursionInfo();
                            $status = $exInfo['status'];
                            $statusLabel = $exInfo['status_label'];
                            $textClass = $exInfo['text_class'];
                            $duration = $exInfo['duration'] ?? 0;
                            
                            $badgeColor = 'neutral';
                            if ($status === 'Aman') $badgeColor = 'success';
                            elseif ($status === 'Peringatan') $badgeColor = 'warning';
                            elseif ($status === 'Tidak Layak Pakai') $badgeColor = 'error';

                            // Vibration evaluations
                            $vibration = $log ? (float) $log->gaya_guncangan : 0.05;
                            $shakeClass = $vibration > 1.50 ? 'animate-shake-infinite' : '';

                            // Fluid styling
                            $bgClass = 'bg-white dark:bg-slate-900';
                            $accentBorderClass = 'border-l-4 border-l-primary';
                            
                            if ($status === 'Peringatan') {
                                $bgClass = 'bg-amber-50 dark:bg-amber-900/10';
                                $accentBorderClass = 'border-l-4 border-l-warning';
                            } elseif ($status === 'Tidak Layak Pakai') {
                                $bgClass = 'bg-rose-50 dark:bg-rose-900/10';
                                $accentBorderClass = 'border-l-4 border-l-error';
                            }
                        ?>

                        
                        <!-- STITCH_AI_TABLE_ROW: Ganti dengan gaya baris tabel enterprise -->
                        <div class="telemetry-card cursor-pointer p-4 <?php echo e($bgClass); ?> <?php echo e($accentBorderClass); ?> <?php echo e($shakeClass); ?> hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors group" data-rute-id="<?php echo e($perjalanan->id_rute); ?>">
                            
                            <div class="flex items-start justify-between gap-sm">
                                <div class="flex items-center gap-3 min-w-0">
                                    <div class="w-8 h-8 rounded bg-slate-200 dark:bg-slate-700 flex items-center justify-center text-slate-800 dark:text-slate-200 font-bold text-xs uppercase tracking-wider shrink-0 select-none">
                                        <?php echo e(collect(explode(' ', $perjalanan->kurir->nama_lengkap))->map(fn($n) => $n[0])->take(2)->implode('')); ?>

                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-body-sm font-bold text-on-surface truncate">
                                            <?php echo e($perjalanan->kurir->nama_lengkap); ?>

                                        </p>
                                        <p class="text-label-md text-slate-500 mt-0.5 flex flex-wrap items-center gap-x-1 gap-y-0.5">
                                            <?php echo e($perjalanan->kurir->nomor_kendaraan); ?> &bull; 
                                            <span class="font-mono-data text-[10px]"><?php echo e($perjalanan->id_box); ?></span> &bull;
                                            <span class="font-mono-data text-[10px]" title="WhatsApp Kurir"><?php echo e($perjalanan->kurir->no_wa ?? '-'); ?></span>
                                            <a href="<?php echo e(route('dashboard.qr', $perjalanan->id_box)); ?>" target="_blank" class="inline-flex items-center text-primary hover:text-primary/80 transition-all active:scale-90 ml-1" title="Cetak QR Code Boks">
                                                <span class="material-symbols-outlined text-[14px]">qr_code_2</span>
                                            </a>
                                        </p>
                                    </div>
                                </div>

                                
                                <!-- STITCH_AI_STATUS_BADGE: Ganti dengan gaya badge status enterprise -->
                                <?php if (isset($component)) { $__componentOriginal2ddbc40e602c342e508ac696e52f8719 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2ddbc40e602c342e508ac696e52f8719 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.badge','data' => ['color' => ''.e($badgeColor).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['color' => ''.e($badgeColor).'']); ?>
                                    <?php if($status === 'Aman'): ?>
                                        <span class="material-symbols-outlined text-[12px] mr-1">check_circle</span>
                                    <?php elseif($status === 'Peringatan'): ?>
                                        <span class="material-symbols-outlined text-[12px] mr-1">info</span>
                                    <?php else: ?>
                                        <span class="material-symbols-outlined text-[12px] mr-1">warning</span>
                                    <?php endif; ?>
                                    <?php echo e($statusLabel); ?>

                                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2ddbc40e602c342e508ac696e52f8719)): ?>
<?php $attributes = $__attributesOriginal2ddbc40e602c342e508ac696e52f8719; ?>
<?php unset($__attributesOriginal2ddbc40e602c342e508ac696e52f8719); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2ddbc40e602c342e508ac696e52f8719)): ?>
<?php $component = $__componentOriginal2ddbc40e602c342e508ac696e52f8719; ?>
<?php unset($__componentOriginal2ddbc40e602c342e508ac696e52f8719); ?>
<?php endif; ?>
                            </div>

                            
                            <p class="text-xs font-semibold text-slate-500 uppercase tracking-widest mt-sm truncate">
                                <span class="material-symbols-outlined text-[12px] align-middle mr-0.5 text-primary">pin_drop</span>
                                <?php echo e($perjalanan->lokasi_tujuan); ?>

                            </p>

                            
                            <div class="flex items-end justify-between mt-sm">
                                <div>
                                    <p class="uppercase tracking-widest text-[9px] font-bold text-slate-500">Suhu Aktual</p>
                                    <p class="text-2xl font-extrabold tracking-tight <?php echo e($textClass); ?> tabular-nums">
                                        <?php if($status !== 'Aman'): ?>
                                            <span class="material-symbols-outlined text-[16px] align-middle mr-0.5">thermostat</span>
                                        <?php endif; ?>
                                        <?php echo e($temp !== null ? number_format($temp, 1, ',', '.') . '&deg;C' : '-'); ?>

                                    </p>
                                </div>
                                <div class="text-right">
                                    <p class="uppercase tracking-widest text-[9px] font-bold text-slate-500">Nilai MKT</p>
                                    <p class="text-base font-bold text-on-surface-variant tabular-nums">
                                        <?php echo e(is_numeric($mkt) ? number_format($mkt, 1, ',', '.') . '&deg;C' : $mkt); ?>

                                    </p>
                                </div>
                            </div>

                            
                            <div class="grid grid-cols-3 gap-sm mt-sm pt-sm border-t border-outline-variant/30/60 text-[10px] font-semibold text-slate-500">
                                <div>
                                    <span class="block">Durasi Anomali</span>
                                    <span class="font-mono-data font-bold block mt-0.5 <?php echo e($status !== 'Aman' ? $textClass : 'text-slate-700 dark:text-on-surface-variant'); ?>">
                                        <?php if($status === 'Aman'): ?>
                                            0s (Normal)
                                        <?php else: ?>
                                            <?php echo e($duration); ?>s
                                        <?php endif; ?>
                                    </span>
                                </div>
                                <div class="text-center">
                                    <span class="block">Guncangan</span>
                                    <?php
                                        $vibeStatusClass = 'text-green-500';
                                        if ($vibration > 1.50) {
                                            $vibeStatusClass = 'text-red-500 font-bold';
                                        } elseif ($vibration > 1.00) {
                                            $vibeStatusClass = 'text-amber-500';
                                        }
                                    ?>
                                    <span class="font-mono-data font-bold block mt-0.5 <?php echo e($vibeStatusClass); ?>">
                                        <?php echo e(number_format($vibration, 2, ',', '.')); ?>G
                                    </span>
                                </div>
                                <div class="text-right" title="<?php echo e($prediksi ? $prediksi->instruksi_mitigasi : ''); ?>">
                                    <span class="block">Risiko (AI)</span>
                                    <span class="font-mono-data font-bold block mt-0.5 <?php echo e($probabilitas > 70 ? 'text-red-500' : ($probabilitas >= 30 ? 'text-amber-500' : 'text-green-500')); ?>">
                                        <?php echo e(number_format($probabilitas, 1, ',', '.')); ?>%
                                    </span>
                                </div>
                            </div>

                            
                            <div class="mt-sm h-1.5 rounded-full overflow-hidden bg-slate-200 dark:bg-slate-800">
                                <div class="h-full rounded-full transition-all duration-1000 <?php echo e($status === 'Aman' ? 'sparkline-cyan animate-sparkline-pulse' : ($status === 'Peringatan' ? 'sparkline-cyan border-tertiary bg-tertiary animate-sparkline-pulse' : 'sparkline-red animate-sparkline-pulse-danger')); ?>"
                                     style="width: <?php echo e($temp !== null ? min(max(($temp / 12) * 100, 8), 100) : 0); ?>%;">
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        
                        <div class="p-xl text-center text-slate-500">
                            <span class="material-symbols-outlined text-[40px] text-outline">sensors_off</span>
                            <p class="text-body-sm text-on-surface-variant mt-sm">Tidak ada pengiriman aktif</p>
                        </div>
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

                
                <div class="mt-4">
                    <a href="<?php echo e(route('shipments')); ?>"
                       class="flex items-center justify-center gap-xs w-full px-md py-[10px] rounded-xl border border-outline-variant/30 bg-white dark:bg-slate-800/40 text-slate-700 dark:text-on-surface-variant text-body-sm font-semibold hover:-translate-y-0.5 hover:shadow-md active:scale-95 transition-all duration-300 ease-out">
                        <span class="material-symbols-outlined text-[18px]">timeline</span>
                        Lihat Log Telemetri Lengkap
                    </a>
                </div>
            </div>
        </div>

    </div>

    
    
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-gutter mt-lg">
        
        
        <?php if (isset($component)) { $__componentOriginal53747ceb358d30c0105769f8471417f6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal53747ceb358d30c0105769f8471417f6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.card','data' => ['class' => 'flex flex-col min-h-[340px]']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'flex flex-col min-h-[340px]']); ?>
            <div class="flex justify-between items-center mb-4">
                <div>
                    <h3 class="text-sm font-bold text-on-surface flex items-center gap-xs">
                        <span class="material-symbols-outlined text-primary text-[20px]">query_stats</span>
                        Suhu Aktual vs MKT
                    </h3>
                    <p class="text-[10px] font-semibold text-slate-500 dark:text-on-surface-variant mt-0.5">Analisis stabilitas kinetik termal box kargo</p>
                </div>
            </div>
            <div id="chart-mkt" class="w-full flex-1"></div>
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

        
        <?php if (isset($component)) { $__componentOriginal53747ceb358d30c0105769f8471417f6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal53747ceb358d30c0105769f8471417f6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.card','data' => ['class' => 'flex flex-col min-h-[340px]']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'flex flex-col min-h-[340px]']); ?>
            <div class="flex justify-between items-center mb-4">
                <div>
                    <h3 class="text-sm font-bold text-on-surface flex items-center gap-xs">
                        <span class="material-symbols-outlined text-primary text-[20px]">insights</span>
                        Proyeksi Risiko Prediktif AI
                    </h3>
                    <p class="text-[10px] font-semibold text-slate-500 dark:text-on-surface-variant mt-0.5">Prediksi spoilage berdasarkan sisa jarak rute</p>
                </div>
            </div>
            <div id="chart-risiko" class="w-full flex-1"></div>
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

        
        <?php if (isset($component)) { $__componentOriginal53747ceb358d30c0105769f8471417f6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal53747ceb358d30c0105769f8471417f6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.card','data' => ['class' => 'flex flex-col min-h-[340px]']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'flex flex-col min-h-[340px]']); ?>
            <div class="flex justify-between items-center mb-4">
                <div>
                    <h3 class="text-sm font-bold text-on-surface flex items-center gap-xs">
                        <span class="material-symbols-outlined text-primary text-[20px]">sync_saved_locally</span>
                        Log Sinkronisasi Store-and-Forward
                    </h3>
                    <p class="text-[10px] font-semibold text-slate-500 dark:text-on-surface-variant mt-0.5">Data terkirim (online) vs ter-cache (offline)</p>
                </div>
            </div>
            <div id="chart-sync" class="w-full flex-1"></div>
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

    
    
    
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-gutter mt-lg">

        
        <?php if (isset($component)) { $__componentOriginal53747ceb358d30c0105769f8471417f6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal53747ceb358d30c0105769f8471417f6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.card','data' => ['noPadding' => 'true','class' => 'lg:col-span-8 flex flex-col justify-between overflow-hidden']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['noPadding' => 'true','class' => 'lg:col-span-8 flex flex-col justify-between overflow-hidden']); ?>
            <div>
                
                <div class="flex items-center justify-between px-6 py-4 border-b border-outline-variant/30/60 bg-surface-container-high">
                    <div class="flex items-center gap-sm">
                        <span class="material-symbols-outlined text-error text-[22px]" style="font-variation-settings: 'FILL' 1;">gavel</span>
                        <h2 class="text-sm font-bold text-on-surface">Panel Manajemen "Karantina Kargo"</h2>
                    </div>
                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-error-container text-on-error-container text-[10px] font-black uppercase tracking-wider animate-pulse">
                        Kritis
                    </span>
                </div>

                
                <div class="p-6">
                    <p class="text-xs text-slate-500 dark:text-on-surface-variant mb-4 leading-relaxed">
                        Kargo obat termolabil yang terdeteksi melanggar batas toleransi suhu dingin (anomali suhu &gt; 8&deg;C selama &gt; 30 detik) secara otomatis dialihkan ke status Karantina untuk pengujian laboratorium lanjutan sebelum pembuangan.
                    </p>

                    
                    <div class="overflow-x-auto rounded-xl border border-outline-variant/30/60">
                        <table class="w-full text-left border-collapse text-xs">
                            <thead>
                                <tr class="bg-slate-900/10 dark:bg-slate-100/5 border-b border-outline-variant/30/60">
                                    <th class="px-4 py-3 font-bold text-slate-700 dark:text-on-surface-variant uppercase tracking-wider">ID Boks</th>
                                    <th class="px-4 py-3 font-bold text-slate-700 dark:text-on-surface-variant uppercase tracking-wider">Nama Kurir</th>
                                    <th class="px-4 py-3 font-bold text-slate-700 dark:text-on-surface-variant uppercase tracking-wider">Titik Kerusakan</th>
                                    <th class="px-4 py-3 font-bold text-slate-700 dark:text-on-surface-variant uppercase tracking-wider text-center">Suhu Puncak</th>
                                    <th class="px-4 py-3 font-bold text-slate-700 dark:text-on-surface-variant uppercase tracking-wider text-right">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200 dark:divide-slate-800/60">
                                
                                <tr class="hover:bg-slate-100/50 dark:hover:bg-slate-800/20 transition-colors">
                                    <td class="px-4 py-3 font-mono font-bold text-primary">BOX-003</td>
                                    <td class="px-4 py-3 font-medium text-on-surface">Citra Dewi</td>
                                    <td class="px-4 py-3 text-slate-500 dark:text-on-surface-variant flex items-center gap-1">
                                        <span class="material-symbols-outlined text-red-400 text-xs">location_on</span>
                                        Jembatan Ampera
                                    </td>
                                    <td class="px-4 py-3 text-center text-error font-bold font-mono">10,2&deg;C</td>
                                    <td class="px-4 py-3 text-right">
                                        <?php if (isset($component)) { $__componentOriginal2ddbc40e602c342e508ac696e52f8719 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2ddbc40e602c342e508ac696e52f8719 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.badge','data' => ['color' => 'error','class' => 'animate-pulse']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['color' => 'error','class' => 'animate-pulse']); ?>
                                            Tidak Layak Pakai
                                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2ddbc40e602c342e508ac696e52f8719)): ?>
<?php $attributes = $__attributesOriginal2ddbc40e602c342e508ac696e52f8719; ?>
<?php unset($__attributesOriginal2ddbc40e602c342e508ac696e52f8719); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2ddbc40e602c342e508ac696e52f8719)): ?>
<?php $component = $__componentOriginal2ddbc40e602c342e508ac696e52f8719; ?>
<?php unset($__componentOriginal2ddbc40e602c342e508ac696e52f8719); ?>
<?php endif; ?>
                                    </td>
                                </tr>
                                
                                <tr class="hover:bg-slate-100/50 dark:hover:bg-slate-800/20 transition-colors">
                                    <td class="px-4 py-3 font-mono font-bold text-primary">BOX-002</td>
                                    <td class="px-4 py-3 font-medium text-on-surface">Budi Santoso</td>
                                    <td class="px-4 py-3 text-slate-500 dark:text-on-surface-variant flex items-center gap-1">
                                        <span class="material-symbols-outlined text-red-400 text-xs">location_on</span>
                                        Jl. Jend. Sudirman
                                    </td>
                                    <td class="px-4 py-3 text-center text-error font-bold font-mono">9,5&deg;C</td>
                                    <td class="px-4 py-3 text-right">
                                        <?php if (isset($component)) { $__componentOriginal2ddbc40e602c342e508ac696e52f8719 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2ddbc40e602c342e508ac696e52f8719 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.badge','data' => ['color' => 'error','class' => 'animate-pulse']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['color' => 'error','class' => 'animate-pulse']); ?>
                                            Tidak Layak Pakai
                                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2ddbc40e602c342e508ac696e52f8719)): ?>
<?php $attributes = $__attributesOriginal2ddbc40e602c342e508ac696e52f8719; ?>
<?php unset($__attributesOriginal2ddbc40e602c342e508ac696e52f8719); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2ddbc40e602c342e508ac696e52f8719)): ?>
<?php $component = $__componentOriginal2ddbc40e602c342e508ac696e52f8719; ?>
<?php unset($__componentOriginal2ddbc40e602c342e508ac696e52f8719); ?>
<?php endif; ?>
                                    </td>
                                </tr>
                                
                                <tr class="hover:bg-slate-100/50 dark:hover:bg-slate-800/20 transition-colors">
                                    <td class="px-4 py-3 font-mono font-bold text-primary">BOX-005</td>
                                    <td class="px-4 py-3 font-medium text-on-surface">Ahmad Fadillah</td>
                                    <td class="px-4 py-3 text-slate-500 dark:text-on-surface-variant flex items-center gap-1">
                                        <span class="material-symbols-outlined text-red-400 text-xs">location_on</span>
                                        Jakabaring Sport City
                                    </td>
                                    <td class="px-4 py-3 text-center text-error font-bold font-mono">8,9&deg;C</td>
                                    <td class="px-4 py-3 text-right">
                                        <?php if (isset($component)) { $__componentOriginal2ddbc40e602c342e508ac696e52f8719 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2ddbc40e602c342e508ac696e52f8719 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.badge','data' => ['color' => 'error','class' => 'animate-pulse']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['color' => 'error','class' => 'animate-pulse']); ?>
                                            Tidak Layak Pakai
                                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2ddbc40e602c342e508ac696e52f8719)): ?>
<?php $attributes = $__attributesOriginal2ddbc40e602c342e508ac696e52f8719; ?>
<?php unset($__attributesOriginal2ddbc40e602c342e508ac696e52f8719); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2ddbc40e602c342e508ac696e52f8719)): ?>
<?php $component = $__componentOriginal2ddbc40e602c342e508ac696e52f8719; ?>
<?php unset($__componentOriginal2ddbc40e602c342e508ac696e52f8719); ?>
<?php endif; ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
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

        
        <div class="lg:col-span-4 flex flex-col gap-gutter">

            
            <?php if (isset($component)) { $__componentOriginal53747ceb358d30c0105769f8471417f6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal53747ceb358d30c0105769f8471417f6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.card','data' => ['class' => 'flex flex-col justify-between']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'flex flex-col justify-between']); ?>
                <div>
                    <h3 class="text-sm font-bold text-on-surface flex items-center gap-xs">
                        <span class="material-symbols-outlined text-primary text-[22px]">construction</span>
                        Simulator Hub Dasbor
                    </h3>
                    <p class="text-[10px] font-semibold text-slate-500 dark:text-on-surface-variant mt-0.5">Kontrol simulasi telemetri IoT langsung dari dasbor</p>
                </div>
                
                <div class="mt-4 space-y-3">
                    <div class="flex flex-col gap-1">
                        <label class="text-[9px] text-slate-500 font-bold uppercase tracking-wider">Pilih Target Boks IoT</label>
                        <select id="sim-target-box" class="w-full bg-slate-100/80 dark:bg-slate-800/60 border border-outline-variant/30 rounded-xl px-3 py-2 text-xs text-on-surface focus:border-primary focus:outline-none transition-all duration-300">
                            <?php $__currentLoopData = $perjalananAktif ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $perjalanan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($perjalanan->id_rute); ?>" data-box="<?php echo e($perjalanan->id_box); ?>">
                                    <?php echo e($perjalanan->id_box); ?> (<?php echo e($perjalanan->kurir->nama_lengkap); ?>)
                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-2">
                        <button onclick="triggerDashboardSimulation('suhu')" class="flex items-center justify-center gap-1 py-2 px-3 rounded-xl bg-amber-500 hover:bg-amber-600 text-white text-[11px] font-bold transition-all duration-300 active:scale-95 shadow-md shadow-amber-500/10 cursor-pointer">
                            <span class="material-symbols-outlined text-xs">thermostat</span>
                            Suhu Kritis
                        </button>
                        <button onclick="triggerDashboardSimulation('deviasi')" class="flex items-center justify-center gap-1 py-2 px-3 rounded-xl bg-rose-500 hover:bg-rose-600 text-white text-[11px] font-bold transition-all duration-300 active:scale-95 shadow-md shadow-rose-500/10 cursor-pointer">
                            <span class="material-symbols-outlined text-xs">navigation</span>
                            Deviasi GPS
                        </button>
                    </div>

                    <button onclick="triggerDashboardSimulation('reset')" class="w-full flex items-center justify-center gap-1 py-2 px-3 rounded-xl bg-green-500 hover:bg-green-600 text-white text-[11px] font-bold transition-all duration-300 active:scale-95 shadow-md shadow-green-500/10 cursor-pointer">
                        <span class="material-symbols-outlined text-xs">refresh</span>
                        Reset ke Kondisi Normal
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

            
            <?php if (isset($component)) { $__componentOriginal53747ceb358d30c0105769f8471417f6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal53747ceb358d30c0105769f8471417f6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.card','data' => ['noPadding' => 'true','class' => 'flex flex-col justify-between overflow-hidden']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['noPadding' => 'true','class' => 'flex flex-col justify-between overflow-hidden']); ?>
                
                <div class="flex items-center justify-between px-6 py-4 border-b border-outline-variant/30/60 bg-surface-container-high">
                    <div class="flex items-center gap-sm">
                        <span class="material-symbols-outlined text-tertiary text-[22px] animate-bounce">campaign</span>
                        <h2 class="text-sm font-bold text-on-surface">Log Intervensi Darurat (SOS)</h2>
                    </div>
                    <span class="inline-flex items-center justify-center w-auto h-5 px-2.5 rounded-full bg-error text-on-error text-[9px] font-bold">2 Peringatan</span>
                </div>

                
                <div class="p-6 space-y-4">
                    
                    <div class="p-4 rounded-xl border border-red-500/30 bg-red-500/10 flex flex-col gap-2">
                        <div class="flex items-start justify-between">
                            <div class="flex items-center gap-xs">
                                <span class="material-symbols-outlined text-red-500 text-[18px]">emergency</span>
                                <span class="font-bold text-on-surface text-xs">BOX-003: Boks Bocor</span>
                            </div>
                            <span class="text-[9px] font-mono text-slate-400">Baru saja</span>
                        </div>
                        <p class="text-[11px] text-slate-600 dark:text-on-surface-variant leading-relaxed">
                            Kurir Citra Dewi melaporkan insulasi penutup boks lepas di Jembatan Ampera. Suhu terancam melonjak.
                        </p>
                        <div class="flex justify-end mt-1">
                            <button onclick="alert('Instruksi mitigasi SOS dikirim: Segera ganti boks cadangan atau tambahkan cooling gel pack')" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-error hover:bg-error/80 text-white text-[10px] font-bold transition-all active:scale-95 shadow-md">
                                <span class="material-symbols-outlined text-[14px]">send</span>
                                Tindak Lanjuti
                            </button>
                        </div>
                    </div>

                    
                    <div class="p-4 rounded-xl border border-amber-500/30 bg-amber-500/10 flex flex-col gap-2">
                        <div class="flex items-start justify-between">
                            <div class="flex items-center gap-xs">
                                <span class="material-symbols-outlined text-amber-500 text-[18px]">traffic</span>
                                <span class="font-bold text-on-surface text-xs">BOX-002: Kemacetan Ekstrem</span>
                            </div>
                            <span class="text-[9px] font-mono text-slate-400">5 mnt lalu</span>
                        </div>
                        <p class="text-[11px] text-slate-600 dark:text-on-surface-variant leading-relaxed">
                            Budi Santoso terjebak kemacetan total di Jl. Jend. Sudirman. Estimasi terlambat mencapai 20 menit.
                        </p>
                        <div class="flex justify-end mt-1">
                            <button onclick="triggerReroutingModal(2, 'RSUD Palembang BARI')" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-tertiary hover:bg-tertiary/80 text-on-tertiary text-[10px] font-bold transition-all active:scale-95 shadow-md">
                                <span class="material-symbols-outlined text-[14px]">directions_alt</span>
                                Tindak Lanjuti
                            </button>
                        </div>
                    </div>
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

            
            <?php if (isset($component)) { $__componentOriginal53747ceb358d30c0105769f8471417f6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal53747ceb358d30c0105769f8471417f6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.card','data' => ['class' => 'flex flex-col justify-between min-h-[160px]']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'flex flex-col justify-between min-h-[160px]']); ?>
                <div>
                    <h3 class="text-sm font-bold text-on-surface flex items-center gap-xs">
                        <span class="material-symbols-outlined text-primary text-[22px]">verified_user</span>
                        Cetak Jejak Audit CDOB
                    </h3>
                    <p class="text-[10px] font-semibold text-slate-500 dark:text-on-surface-variant mt-0.5">E-Certificate otomatis pemenuhan standar logistik medis</p>
                </div>
                <div class="mt-4">
                    <button onclick="openAuditPreviewModal()" class="w-full inline-flex items-center justify-center gap-xs px-md py-[10px] rounded-xl bg-primary text-on-primary text-body-sm font-semibold hover:-translate-y-0.5 hover:shadow-lg active:scale-95 transition-all duration-300 ease-out shadow-[0_0_15px_rgba(2,132,199,0.3)] cursor-pointer">
                        <span class="material-symbols-outlined text-[18px]">picture_as_pdf</span>
                        Unduh Laporan Audit CDOB (PDF)
                    </button>
                    <p class="text-[9px] text-slate-400 mt-2 text-center leading-relaxed">
                        Dokumen mencakup seluruh grafik suhu sepanjang rute, status MKT akhir, dan stempel validasi BPOM.
                    </p>
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

            
            <?php if (isset($component)) { $__componentOriginal53747ceb358d30c0105769f8471417f6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal53747ceb358d30c0105769f8471417f6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.card','data' => ['class' => 'flex flex-col justify-between mt-sm']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'flex flex-col justify-between mt-sm']); ?>
                <div>
                    <h3 class="text-sm font-bold text-on-surface flex items-center gap-xs">
                        <span class="material-symbols-outlined text-primary text-[22px]">developer_board</span>
                        Kesehatan Perangkat Boks IoT
                    </h3>
                    <p class="text-[10px] font-semibold text-slate-500 dark:text-on-surface-variant mt-0.5">Metrik daya, sinyal telemetri, dan kalibrasi boks aktif</p>
                </div>
                
                <div class="mt-4 space-y-3" id="device-health-list">
                    <?php $__currentLoopData = $perjalananAktif ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $perjalanan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $health = $perjalanan->getDeviceHealth();
                            $battery = $health['battery'];
                            $signal = $health['signal'];
                            $calib = $health['calibration'];
                            
                            // Styling classes based on values
                            $batColor = 'bg-green-500';
                            if ($battery < 20) {
                                $batColor = 'bg-red-500 animate-pulse';
                            } elseif ($battery < 50) {
                                $batColor = 'bg-amber-500';
                            }
                            
                            $sigIcon = 'signal_cellular_alt';
                            if ($signal < -100) {
                                $sigIcon = 'signal_cellular_0_bar';
                            } elseif ($signal < -85) {
                                $sigIcon = 'signal_cellular_1_bar';
                            }
                            
                            $calibDot = 'bg-green-500';
                            $calibText = 'text-green-500';
                            if ($calib !== 'Terkalibrasi') {
                                $calibDot = 'bg-red-500 animate-pulse';
                                $calibText = 'text-red-500';
                            }
                        ?>
                        
                        <div class="p-3 bg-slate-100/50 dark:bg-slate-800/40 rounded-xl border border-slate-200/50 dark:border-slate-700/30 flex flex-col gap-2 transition-all hover:border-primary/30" id="device-health-<?php echo e($perjalanan->id_box); ?>">
                            <!-- Box ID & Courier -->
                            <div class="flex justify-between items-center text-xs">
                                <span class="font-bold text-on-surface font-mono"><?php echo e($perjalanan->id_box); ?></span>
                                <span class="text-on-surface-variant font-semibold"><?php echo e($perjalanan->kurir->nama_lengkap); ?></span>
                            </div>
                            
                            <!-- Battery & Signal Row -->
                            <div class="grid grid-cols-2 gap-2 text-[10px]">
                                <!-- Battery Column -->
                                <div class="flex flex-col gap-1">
                                    <div class="flex items-center justify-between font-semibold">
                                        <span class="flex items-center gap-0.5 text-slate-500">
                                            <span class="material-symbols-outlined text-[13px]">battery_charging_full</span> Daya Baterai
                                        </span>
                                        <span class="text-on-surface font-mono" id="device-battery-val-<?php echo e($perjalanan->id_box); ?>"><?php echo e($battery); ?>%</span>
                                    </div>
                                    <div class="w-full bg-slate-200 dark:bg-slate-700 h-1.5 rounded-full overflow-hidden">
                                        <div class="h-full <?php echo e($batColor); ?> rounded-full transition-all duration-500" id="device-battery-bar-<?php echo e($perjalanan->id_box); ?>" style="width: <?php echo e($battery); ?>%"></div>
                                    </div>
                                </div>
                                
                                <!-- Signal Column -->
                                <div class="flex flex-col justify-between">
                                    <div class="flex items-center justify-between font-semibold">
                                        <span class="flex items-center gap-0.5 text-slate-500">
                                            <span class="material-symbols-outlined text-[13px]" id="device-signal-icon-<?php echo e($perjalanan->id_box); ?>"><?php echo e($sigIcon); ?></span> GSM Sinyal
                                        </span>
                                        <span class="text-on-surface font-mono" id="device-signal-val-<?php echo e($perjalanan->id_box); ?>"><?php echo e($signal); ?> dBm</span>
                                    </div>
                                    <!-- Calibration status row -->
                                    <div class="flex items-center justify-between font-semibold mt-1">
                                        <span class="text-slate-500">Sensor:</span>
                                        <span class="flex items-center gap-1 font-bold text-[9px] uppercase tracking-wider <?php echo e($calibText); ?>" id="device-calibration-val-<?php echo e($perjalanan->id_box); ?>">
                                            <span class="h-1.5 w-1.5 rounded-full <?php echo e($calibDot); ?> inline-block" id="device-calibration-dot-<?php echo e($perjalanan->id_box); ?>"></span>
                                            <?php echo e($calib === 'Terkalibrasi' ? 'CAL' : 'ERR'); ?>

                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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

            
            <div class="bg-surface-container-low backdrop-blur-md rounded-2xl border border-outline-variant/30 p-6 shadow-sm hover:border-slate-350 dark:hover:border-slate-700 transition-all duration-300 hover:-translate-y-2 hover:shadow-xl flex flex-col justify-between mt-sm">
                <div>
                    <h3 class="text-sm font-bold text-on-surface flex items-center gap-xs">
                        <span class="material-symbols-outlined text-primary text-[22px]">hub</span>
                        BIO-GUARD Gateway Hub
                    </h3>
                    <p class="text-[10px] font-semibold text-slate-500 dark:text-on-surface-variant mt-0.5">Log simulasi notifikasi otomatis Bot Telegram & WhatsApp Gateway</p>
                </div>
                
                <div class="mt-4 flex flex-col gap-2">
                    <div id="gateway-log-console" class="h-44 bg-slate-950/80 dark:bg-slate-950/90 rounded-xl p-3 font-mono text-[10px] text-slate-400 overflow-y-auto flex flex-col gap-1.5 border border-slate-200 dark:border-slate-850">
                        <div class="text-slate-500">// Menunggu transmisi gateway...</div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>

<!-- AI Rerouting Modal -->
<div id="rerouting-modal" class="fixed inset-0 z-[2000] hidden flex items-center justify-center p-md bg-black/60 backdrop-blur-sm transition-opacity duration-300">
    <div class="bg-white dark:bg-slate-900 border border-outline-variant/30 rounded-2xl w-full max-w-md overflow-hidden shadow-2xl scale-95 opacity-0 transition-all duration-300 flex flex-col">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-outline-variant/30/60 bg-slate-50 dark:bg-slate-800/50 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">directions_alt</span>
                <h3 class="text-sm font-bold text-on-surface">AI Dynamic Rerouting</h3>
            </div>
            <button onclick="closeReroutingModal()" class="text-slate-500 hover:text-slate-850 dark:text-slate-400 dark:hover:text-white transition-colors">
                <span class="material-symbols-outlined text-[20px] align-middle">close</span>
            </button>
        </div>
        <!-- Body -->
        <div class="p-6 space-y-4">
            <div class="p-4 rounded-xl border border-teal-500/30 bg-teal-500/10 flex flex-col gap-2">
                <div class="flex items-center gap-xs">
                    <span class="material-symbols-outlined text-teal-500 text-[18px]">psychology</span>
                    <span class="font-bold text-on-surface text-xs">Rekomendasi Rute Alternatif (Musi IV Bypass)</span>
                </div>
                <p class="text-[11px] text-slate-600 dark:text-slate-400 leading-relaxed">
                    Sistem mendeteksi hambatan parah di Jembatan Ampera. Rute alternatif disarankan melewati **Jembatan Musi IV**.
                </p>
                <div class="grid grid-cols-2 gap-sm mt-1 text-[10px] font-mono text-on-surface-variant">
                    <div>Jarak: <span class="text-on-surface font-bold">-0.4 km</span></div>
                    <div>Waktu: <span class="text-on-surface font-bold">Hemat ~8 mnt</span></div>
                </div>
            </div>
            <p class="text-[11px] text-slate-500 leading-relaxed">
                Menyetujui rute ini akan langsung memplot koordinat baru di peta Leaflet dan memperbarui instruksi pada boks IoT kurir.
            </p>
        </div>
        <!-- Footer -->
        <div class="px-6 py-4 border-t border-outline-variant/30/60 bg-slate-50 dark:bg-slate-850 flex justify-end gap-sm">
            <button onclick="closeReroutingModal()" class="px-4 py-2 border border-outline-variant/30 rounded-xl text-xs font-semibold text-slate-800 dark:text-slate-200 transition-all active:scale-95 duration-100 hover:bg-slate-100 dark:hover:bg-slate-800">
                Batal
            </button>
            <button onclick="applyRerouting()" class="px-4 py-2 bg-primary text-on-primary hover:-translate-y-0.5 hover:shadow-md rounded-xl text-xs font-semibold transition-all duration-300 ease-out active:scale-95 shadow-[0_0_10px_rgba(2,132,199,0.2)]">
                Terapkan Rute
            </button>
        </div>
    </div>
</div>

<!-- CDOB Audit Preview Modal -->
<div id="audit-preview-modal" class="fixed inset-0 z-[2000] hidden flex items-center justify-center p-md bg-black/60 backdrop-blur-sm transition-opacity duration-300 animate-opacity">
    <div class="bg-white dark:bg-slate-900 border border-outline-variant/30 rounded-3xl w-full max-w-xl overflow-hidden shadow-2xl scale-95 opacity-0 transition-all duration-300 flex flex-col">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-slate-200 dark:border-slate-850 bg-slate-50 dark:bg-slate-800/50 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-primary text-[20px] font-bold">verified_user</span>
                <h3 class="text-xs font-black text-on-surface uppercase tracking-wider">Pratinjau Jejak Audit CDOB</h3>
            </div>
            <button onclick="closeAuditPreviewModal()" class="text-slate-500 hover:text-slate-800 dark:text-slate-400 dark:hover:text-white transition-colors cursor-pointer">
                <span class="material-symbols-outlined text-[20px] align-middle">close</span>
            </button>
        </div>
        <!-- Body -->
        <div class="p-6 space-y-6 overflow-y-auto max-h-[70vh]">
            <div class="relative border-2 border-dashed border-primary/20 dark:border-primary/10 rounded-2xl p-6 bg-slate-50/50 dark:bg-slate-950/20 backdrop-blur-sm overflow-hidden select-none">
                
                <div class="absolute -right-10 -bottom-10 opacity-5 dark:opacity-10 pointer-events-none text-[120px] material-symbols-outlined text-primary font-black">
                    workspace_premium
                </div>

                
                <div class="flex justify-between items-start border-b border-outline-variant/30/60 pb-4 mb-4">
                    <div>
                        <h4 class="text-xs font-black uppercase text-slate-800 dark:text-slate-200 tracking-widest">SERTIFIKAT KEPATUHAN COLD CHAIN</h4>
                        <p class="text-[9px] text-slate-450 mt-0.5">Badan Pengawas Obat dan Makanan (BPOM) RI</p>
                    </div>
                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-green-500/10 text-green-500 text-[10px] font-black uppercase tracking-wider border border-green-500/20">
                        <span class="material-symbols-outlined text-[12px] font-bold">verified</span> TERVERIFIKASI
                    </span>
                </div>

                
                <div class="grid grid-cols-2 gap-4 text-xs">
                    <div>
                        <span class="block text-[9px] font-bold text-slate-400 uppercase tracking-wider">Sistem Verifikator</span>
                        <span class="font-extrabold text-slate-700 dark:text-slate-350">BIO-GUARD Enterprise v2.0</span>
                    </div>
                    <div>
                        <span class="block text-[9px] font-bold text-slate-400 uppercase tracking-wider">ID Operator Dispatcher</span>
                        <span class="font-extrabold text-slate-700 dark:text-slate-350"><?php echo e(Auth::user()->dispatcher_id ?? 'DSP-PLB-2026'); ?></span>
                    </div>
                    <div class="col-span-2">
                        <span class="block text-[9px] font-bold text-slate-400 uppercase tracking-wider">Metrik Stabilitas Suhu</span>
                        <p class="text-[11px] text-slate-650 dark:text-on-surface-variant leading-relaxed font-semibold mt-0.5">
                            Semua boks penyimpanan aktif terpantau berada dalam standar rantai dingin (2,0&deg;C - 8,0&deg;C) dengan fluktuasi rata-rata <span class="text-primary font-bold">4,8&deg;C</span> tanpa kerusakan zat aktif terdeteksi.
                        </p>
                    </div>
                    <div class="col-span-2">
                        <span class="block text-[9px] font-bold text-slate-400 uppercase tracking-wider">Hash Integritas Kriptografis (SHA-256)</span>
                        <div class="mt-1 flex items-center gap-2">
                            <span id="audit-sha-hash" class="font-mono text-[10px] text-primary bg-primary/5 border border-primary/20 rounded-lg px-2.5 py-1.5 break-all flex-1 font-bold">
                                bg_sha256_e82711019a77fcf39a3f2b604085f112e5bb27d42cf38a0a256bd4d9f1092e01
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <p class="text-[10px] text-slate-500 leading-relaxed text-center font-medium">
                * Dokumen PDF resmi akan secara otomatis ditandatangani secara kriptografis menggunakan sertifikat elektronik BIO-GUARD begitu file diunduh.
            </p>
        </div>
        <!-- Footer -->
        <div class="px-6 py-4 border-t border-outline-variant/30/60 bg-slate-50 dark:bg-slate-850 flex justify-end gap-sm">
            <button onclick="closeAuditPreviewModal()" class="px-4 py-2 border border-outline-variant/30 rounded-xl text-xs font-semibold text-slate-800 dark:text-slate-200 transition-all active:scale-95 duration-100 hover:bg-slate-100 dark:hover:bg-slate-800 cursor-pointer">
                Batal
            </button>
            <a href="<?php echo e(route('dashboard.audit-pdf')); ?>" target="_blank" onclick="closeAuditPreviewModal()" class="px-4 py-2 bg-primary text-on-primary hover:-translate-y-0.5 hover:shadow-lg rounded-xl text-xs font-semibold transition-all duration-300 ease-out active:scale-95 shadow-[0_0_10px_rgba(2,132,199,0.2)] cursor-pointer flex items-center gap-1">
                <span class="material-symbols-outlined text-[16px]">picture_as_pdf</span>
                Unduh PDF Resmi
            </a>
        </div>
    </div>
</div>

<!-- STITCH_AI_FOOTER: Ganti dengan gaya footer enterprise -->
<?php $__env->stopSection(); ?>





<?php $__env->startPush('scripts'); ?>
<script>
(function () {
    'use strict';

    // 1. Map state variables
    const activeMarkers = {};
    const activePolylines = {};
    const activeDeviationCircles = {};
    const previousStatuses = {}; // id_rute -> excursion_status
    const previousDeviations = {}; // id_rute -> isDeviated
    const previousVibrations = {}; // id_rute -> gaya_guncangan
    const completedRouteIds = new Set();
    let initialLoad = true;
    let pollIntervalId = null;
    let isHistoricalMode = false;
    let routeTrails = {};
    const activeReroutes = {
        <?php $__currentLoopData = $perjalananAktif; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            '<?php echo e($p->id_rute); ?>': <?php echo e($p->isRerouted() ? 'true' : 'false'); ?>,
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    };
    const alternativePolylines = {};
    let targetRerouteRouteId = null;
    let targetRerouteDestination = null;
    let latestCourierData = [];
    let currentFilterStatus = 'all';
    let currentFilterCargo = 'all';

    // Alternative Optimized Routes
    const alternativePaths = {
        'RSUD Palembang BARI': [
            [-2.9880, 104.7560], // Dinas Kesehatan Palembang
            [-2.9887, 104.7565], // Air Mancur Masjid Agung
            [-2.9860, 104.7620], // Jl. Veteran
            [-2.9875, 104.7680], // Jl. Slamet Riyadi
            [-2.9920, 104.7695], // Jembatan Musi IV
            [-2.9985, 104.7700], // Jl. KH Azhari
            [-3.0070, 104.7670], // Jl. Gubernur Bastari approach
            [-3.0185, 104.7645]  // RSUD Palembang BARI
        ],
        'RSUP Dr. Mohammad Hoesin': [
            [-2.9880, 104.7560], // Dinas Kesehatan Palembang
            [-2.9887, 104.7565], // Air Mancur Masjid Agung
            [-2.9855, 104.7615], // Jl. Veteran
            [-2.9780, 104.7650], // Simpang Veteran/Rajawali
            [-2.9710, 104.7610], // Jl. Mayor Ruslan
            [-2.9702, 104.7521], // Simpang Sekip
            [-2.9669, 104.7505]  // RSUP Dr. Mohammad Hoesin
        ]
    };

    // Planned Reference Routes
const plannedPaths = {
    'RS Charitas': [[-2.987967,104.756141],[-2.987799,104.756102],[-2.987812,104.756055],[-2.987852,104.755856],[-2.987904,104.755531],[-2.987959,104.755231],[-2.987991,104.755036],[-2.98803,104.754939],[-2.988083,104.754851],[-2.988408,104.754464],[-2.98843,104.754414],[-2.988441,104.754394],[-2.98852,104.754212],[-2.988521,104.75418],[-2.988531,104.753979],[-2.988499,104.753494],[-2.988016,104.753531],[-2.987885,104.753542],[-2.987635,104.753564],[-2.987549,104.753575],[-2.987418,104.753564],[-2.987337,104.753546],[-2.98728,104.753516],[-2.987182,104.753465],[-2.987068,104.753394],[-2.986826,104.753227],[-2.986606,104.753069],[-2.986393,104.752946],[-2.98599,104.752673],[-2.985838,104.75259],[-2.985683,104.752479],[-2.985541,104.752358],[-2.985345,104.752167],[-2.98512,104.751969],[-2.985086,104.751904],[-2.98504,104.751859],[-2.984812,104.751645],[-2.984722,104.751568],[-2.984533,104.751362],[-2.984268,104.751074],[-2.984064,104.750884],[-2.984011,104.750829],[-2.98374,104.750548],[-2.983447,104.750252],[-2.983403,104.750197],[-2.98338,104.750177],[-2.983366,104.750166],[-2.983347,104.750148],[-2.983171,104.749961],[-2.982973,104.749712],[-2.982918,104.749645],[-2.982842,104.74956],[-2.982702,104.749402],[-2.98253,104.749218],[-2.982401,104.749069],[-2.982193,104.748836],[-2.982078,104.748718],[-2.982065,104.748705],[-2.981975,104.748611],[-2.981837,104.748468],[-2.981516,104.748139],[-2.981483,104.748098],[-2.981324,104.747909],[-2.981178,104.74772],[-2.980916,104.74734],[-2.98088,104.747288],[-2.980852,104.747249],[-2.980731,104.747089],[-2.980715,104.747075],[-2.980591,104.746899],[-2.980423,104.746686],[-2.980386,104.74663],[-2.98027,104.746454],[-2.980155,104.746286],[-2.98013,104.746226],[-2.980097,104.746146],[-2.980057,104.746206],[-2.980019,104.746265],[-2.979936,104.74641],[-2.979826,104.746601],[-2.979584,104.747024],[-2.979567,104.747054],[-2.979527,104.747126],[-2.979516,104.747144],[-2.979477,104.747189],[-2.97943,104.747297],[-2.979332,104.747453],[-2.979178,104.747721],[-2.979154,104.747761],[-2.979078,104.74791],[-2.978979,104.748073],[-2.978955,104.74811],[-2.978911,104.748186],[-2.978872,104.74825],[-2.978785,104.748382],[-2.978688,104.748546],[-2.978481,104.748895],[-2.9784,104.749033],[-2.978257,104.749288],[-2.978133,104.749501],[-2.9781,104.749556],[-2.977977,104.749763],[-2.97791,104.749911],[-2.977857,104.750079],[-2.977758,104.750416],[-2.977631,104.750964],[-2.977576,104.751244],[-2.977535,104.751414],[-2.977362,104.752244],[-2.977262,104.752223],[-2.977198,104.752209]],
    'Puskesmas Dempo': [[-2.987967,104.756141],[-2.987799,104.756102],[-2.987812,104.756055],[-2.987852,104.755856],[-2.987904,104.755531],[-2.987959,104.755231],[-2.987991,104.755036],[-2.98803,104.754939],[-2.988083,104.754851],[-2.988408,104.754464],[-2.98843,104.754414],[-2.988441,104.754394],[-2.98852,104.754212],[-2.988521,104.75418],[-2.988531,104.753979],[-2.988499,104.753494],[-2.988016,104.753531],[-2.987885,104.753542],[-2.987635,104.753564],[-2.987549,104.753575],[-2.987418,104.753564],[-2.987337,104.753546],[-2.98728,104.753516],[-2.987182,104.753465],[-2.987068,104.753394],[-2.986826,104.753227],[-2.986606,104.753069],[-2.986393,104.752946],[-2.98599,104.752673],[-2.985838,104.75259],[-2.985683,104.752479],[-2.985541,104.752358],[-2.985345,104.752167],[-2.98512,104.751969],[-2.985086,104.751904],[-2.98504,104.751859],[-2.985001,104.751907],[-2.984972,104.751941],[-2.98497,104.751943],[-2.984837,104.752077],[-2.98483,104.752086],[-2.984634,104.752357],[-2.984591,104.752417],[-2.984569,104.752448],[-2.984443,104.752722],[-2.984425,104.752769],[-2.984205,104.753401],[-2.984092,104.753725],[-2.983942,104.754311],[-2.983934,104.754351],[-2.983913,104.754483],[-2.983895,104.754588],[-2.983726,104.755628],[-2.983634,104.756262],[-2.983576,104.756644],[-2.983438,104.757534],[-2.983429,104.757602],[-2.983418,104.757698],[-2.983399,104.757872],[-2.983398,104.757882],[-2.982986,104.757629],[-2.982557,104.757349],[-2.981433,104.756602],[-2.981198,104.75644],[-2.980765,104.756142],[-2.980619,104.756034],[-2.980509,104.755951],[-2.98031,104.755823],[-2.980011,104.755652],[-2.97986,104.755672],[-2.979825,104.755699],[-2.979796,104.755739],[-2.979782,104.755811],[-2.979891,104.755974],[-2.979939,104.756103],[-2.980221,104.756571],[-2.980322,104.756712],[-2.980649,104.7571],[-2.980661,104.75712],[-2.980692,104.75717],[-2.980714,104.757193],[-2.981031,104.757586],[-2.981193,104.757785],[-2.981631,104.758352],[-2.981867,104.758657],[-2.982039,104.758859],[-2.982104,104.758932],[-2.982486,104.759349],[-2.982624,104.75949],[-2.982725,104.759564],[-2.983072,104.759878],[-2.98335,104.760131],[-2.983727,104.760422],[-2.983766,104.76045],[-2.984114,104.760715],[-2.98492,104.761338],[-2.985144,104.761502],[-2.98538,104.761676],[-2.985512,104.761773],[-2.986008,104.762095],[-2.986881,104.762883],[-2.986677,104.763141]],
    'RSUP Dr. Mohammad Hoesin': [[-2.987967,104.756141],[-2.987799,104.756102],[-2.987812,104.756055],[-2.987852,104.755856],[-2.987904,104.755531],[-2.987959,104.755231],[-2.987991,104.755036],[-2.98803,104.754939],[-2.988083,104.754851],[-2.988408,104.754464],[-2.98843,104.754414],[-2.988441,104.754394],[-2.98852,104.754212],[-2.988521,104.75418],[-2.988531,104.753979],[-2.988499,104.753494],[-2.988016,104.753531],[-2.987885,104.753542],[-2.987635,104.753564],[-2.987549,104.753575],[-2.987418,104.753564],[-2.987337,104.753546],[-2.98728,104.753516],[-2.987182,104.753465],[-2.987068,104.753394],[-2.986826,104.753227],[-2.986606,104.753069],[-2.986393,104.752946],[-2.98599,104.752673],[-2.985838,104.75259],[-2.985683,104.752479],[-2.985541,104.752358],[-2.985345,104.752167],[-2.98512,104.751969],[-2.985086,104.751904],[-2.98504,104.751859],[-2.985001,104.751907],[-2.984972,104.751941],[-2.98497,104.751943],[-2.984837,104.752077],[-2.98483,104.752086],[-2.984634,104.752357],[-2.984591,104.752417],[-2.984569,104.752448],[-2.984443,104.752722],[-2.984425,104.752769],[-2.984205,104.753401],[-2.984092,104.753725],[-2.983942,104.754311],[-2.983934,104.754351],[-2.983913,104.754483],[-2.983895,104.754588],[-2.983726,104.755628],[-2.983634,104.756262],[-2.983576,104.756644],[-2.983438,104.757534],[-2.983429,104.757602],[-2.983418,104.757698],[-2.983399,104.757872],[-2.983398,104.757882],[-2.982986,104.757629],[-2.982557,104.757349],[-2.981433,104.756602],[-2.981198,104.75644],[-2.980765,104.756142],[-2.980619,104.756034],[-2.980509,104.755951],[-2.98031,104.755823],[-2.980011,104.755652],[-2.979782,104.755497],[-2.979558,104.755339],[-2.979147,104.755049],[-2.978864,104.754874],[-2.978652,104.754737],[-2.978549,104.754677],[-2.978421,104.754608],[-2.978129,104.754472],[-2.977832,104.754364],[-2.977673,104.754318],[-2.977235,104.754189],[-2.97705,104.754148],[-2.97693,104.754124],[-2.976906,104.754119],[-2.976792,104.754098],[-2.97676,104.754091],[-2.976549,104.754054],[-2.976424,104.754029],[-2.976225,104.753978],[-2.975961,104.753906],[-2.975738,104.753828],[-2.975526,104.753736],[-2.975357,104.753643],[-2.975219,104.753559],[-2.975069,104.753467],[-2.974865,104.753328],[-2.974581,104.753139],[-2.97452,104.753099],[-2.974432,104.753041],[-2.974089,104.752802],[-2.97386,104.752642],[-2.973783,104.752586],[-2.973492,104.752374],[-2.973308,104.752237],[-2.972952,104.751987],[-2.972905,104.751957],[-2.972894,104.751949],[-2.972604,104.751762],[-2.972198,104.751538],[-2.972045,104.751458],[-2.971957,104.751411],[-2.971941,104.751403],[-2.971811,104.751342],[-2.971801,104.751337],[-2.971585,104.751226],[-2.971387,104.751127],[-2.970637,104.750783],[-2.970304,104.750622],[-2.969967,104.75046],[-2.969617,104.75029],[-2.969315,104.750143],[-2.969053,104.750024],[-2.968981,104.749991],[-2.968813,104.749914],[-2.968619,104.749816],[-2.968583,104.749794],[-2.968437,104.749724],[-2.968041,104.749539],[-2.967621,104.749289],[-2.967558,104.74924],[-2.967537,104.749225],[-2.967441,104.749144],[-2.967316,104.749042],[-2.967258,104.748992],[-2.96721,104.74895],[-2.967154,104.748906],[-2.967038,104.748805],[-2.966976,104.748751],[-2.966899,104.748662],[-2.966752,104.74849],[-2.966705,104.748429],[-2.966518,104.748176],[-2.966322,104.747891],[-2.966216,104.747705],[-2.965985,104.747257],[-2.965793,104.746864],[-2.965634,104.746556],[-2.965545,104.746393],[-2.96547,104.746237],[-2.965192,104.745674],[-2.965164,104.74562],[-2.965068,104.745432],[-2.964883,104.74507],[-2.964748,104.744826],[-2.964704,104.744747],[-2.964575,104.744489],[-2.964451,104.744242],[-2.964389,104.744117],[-2.964246,104.743828],[-2.964124,104.743584],[-2.964047,104.743426],[-2.963965,104.74326],[-2.963819,104.742963],[-2.963696,104.742714],[-2.963547,104.742396],[-2.96351,104.742309],[-2.963407,104.742069],[-2.963209,104.741701],[-2.96315,104.741596],[-2.962951,104.741209],[-2.962923,104.74116],[-2.962886,104.74109],[-2.962781,104.740878],[-2.962769,104.740852],[-2.962538,104.740471],[-2.962368,104.740203],[-2.962348,104.740173],[-2.962244,104.740045],[-2.96222,104.740016],[-2.962204,104.739953],[-2.962163,104.739867],[-2.961882,104.739483],[-2.961656,104.739201],[-2.961646,104.73919],[-2.961455,104.73897],[-2.961268,104.738754],[-2.961206,104.738736],[-2.961176,104.738733],[-2.961149,104.738738],[-2.961123,104.738752],[-2.961087,104.738784],[-2.961071,104.738806],[-2.961067,104.738828],[-2.961067,104.738855],[-2.961085,104.738928],[-2.96127,104.739138],[-2.961312,104.739181],[-2.961587,104.73949],[-2.961822,104.739797],[-2.961991,104.740007],[-2.962061,104.740078],[-2.962147,104.740143],[-2.962495,104.740621],[-2.96263,104.74084],[-2.962824,104.741186],[-2.962861,104.741256],[-2.962899,104.741328],[-2.962978,104.741471],[-2.963013,104.741534],[-2.963066,104.741636],[-2.963146,104.741804],[-2.963311,104.742121],[-2.963463,104.742443],[-2.963544,104.742601],[-2.96362,104.742772],[-2.963774,104.743078],[-2.96389,104.743307],[-2.963967,104.743471],[-2.964164,104.743894],[-2.964292,104.744159],[-2.964412,104.74439],[-2.964519,104.744599],[-2.964893,104.745326],[-2.965132,104.745811],[-2.96517,104.745876],[-2.965379,104.746277],[-2.965449,104.746422],[-2.965702,104.746907],[-2.965842,104.747174],[-2.966023,104.747514],[-2.966226,104.747892],[-2.966116,104.747974],[-2.965419,104.748484],[-2.965339,104.748544],[-2.965293,104.748579],[-2.965335,104.748631],[-2.965339,104.748638],[-2.965387,104.748703],[-2.965657,104.749047],[-2.965973,104.749442],[-2.966216,104.749443],[-2.966468,104.749444],[-2.966462,104.75022],[-2.966456,104.751087],[-2.966754,104.751092],[-2.966774,104.7511],[-2.966786,104.751111],[-2.966799,104.751081],[-2.966804,104.751066],[-2.966806,104.751053],[-2.966808,104.751044],[-2.966809,104.751036],[-2.966809,104.751017],[-2.966811,104.7505]],
    'RSUD Palembang BARI': [[-2.987967,104.756141],[-2.987799,104.756102],[-2.987812,104.756055],[-2.987852,104.755856],[-2.987904,104.755531],[-2.987959,104.755231],[-2.987991,104.755036],[-2.98803,104.754939],[-2.988083,104.754851],[-2.988408,104.754464],[-2.98843,104.754414],[-2.988441,104.754394],[-2.98852,104.754212],[-2.988521,104.75418],[-2.988531,104.753979],[-2.988499,104.753494],[-2.988016,104.753531],[-2.987885,104.753542],[-2.987635,104.753564],[-2.987549,104.753575],[-2.987418,104.753564],[-2.987337,104.753546],[-2.98728,104.753516],[-2.987182,104.753465],[-2.987068,104.753394],[-2.986826,104.753227],[-2.986606,104.753069],[-2.986393,104.752946],[-2.98599,104.752673],[-2.985838,104.75259],[-2.985683,104.752479],[-2.985541,104.752358],[-2.985345,104.752167],[-2.98512,104.751969],[-2.985086,104.751904],[-2.98504,104.751859],[-2.985001,104.751907],[-2.984972,104.751941],[-2.98497,104.751943],[-2.984837,104.752077],[-2.98483,104.752086],[-2.984634,104.752357],[-2.984591,104.752417],[-2.984569,104.752448],[-2.984443,104.752722],[-2.984425,104.752769],[-2.984205,104.753401],[-2.984092,104.753725],[-2.983942,104.754311],[-2.983934,104.754351],[-2.983913,104.754483],[-2.983895,104.754588],[-2.983726,104.755628],[-2.983634,104.756262],[-2.983576,104.756644],[-2.983438,104.757534],[-2.983429,104.757602],[-2.983418,104.757698],[-2.983399,104.757872],[-2.983398,104.757882],[-2.982986,104.757629],[-2.982557,104.757349],[-2.981433,104.756602],[-2.981198,104.75644],[-2.980765,104.756142],[-2.980619,104.756034],[-2.980509,104.755951],[-2.98031,104.755823],[-2.980011,104.755652],[-2.97986,104.755672],[-2.979825,104.755699],[-2.979796,104.755739],[-2.979782,104.755811],[-2.979891,104.755974],[-2.979987,104.755985],[-2.980131,104.755999],[-2.980277,104.756027],[-2.980419,104.756077],[-2.980904,104.756373],[-2.980933,104.756392],[-2.98172,104.756924],[-2.982047,104.757157],[-2.982566,104.757487],[-2.983352,104.758026],[-2.983451,104.758095],[-2.983874,104.758364],[-2.984167,104.758551],[-2.985115,104.759192],[-2.986093,104.759852],[-2.986551,104.760161],[-2.986877,104.760381],[-2.98721,104.760592],[-2.987564,104.760817],[-2.987621,104.760877],[-2.987656,104.760913],[-2.987698,104.760961],[-2.987733,104.760998],[-2.987755,104.761023],[-2.987773,104.761055],[-2.987807,104.761108],[-2.987815,104.761141],[-2.987826,104.761169],[-2.987837,104.761191],[-2.987859,104.761232],[-2.987894,104.761264],[-2.987929,104.761286],[-2.987968,104.761307],[-2.988011,104.761321],[-2.988055,104.761327],[-2.988126,104.761323],[-2.988177,104.761329],[-2.988241,104.761333],[-2.988298,104.761339],[-2.988352,104.761346],[-2.988397,104.761356],[-2.988443,104.761375],[-2.988476,104.761391],[-2.988527,104.76142],[-2.989124,104.761814],[-2.991408,104.763342],[-2.994889,104.765671],[-2.996376,104.766695],[-2.996417,104.76683],[-2.996582,104.766938],[-2.996874,104.767135],[-2.996974,104.767205],[-2.997505,104.767573],[-2.997593,104.767627],[-2.997629,104.767651],[-2.99769,104.767692],[-2.997789,104.767757],[-2.997908,104.76784],[-2.997993,104.767898],[-2.998187,104.768053],[-2.998462,104.768248],[-2.998813,104.768484],[-2.999229,104.768763],[-2.999312,104.768819],[-2.999406,104.768881],[-2.999598,104.769012],[-2.999727,104.769101],[-2.999821,104.769161],[-2.999855,104.769094],[-2.999968,104.768884],[-3.000149,104.768515],[-3.000158,104.768497],[-3.000778,104.767261],[-3.001209,104.766395],[-3.001334,104.766176],[-3.001464,104.765997],[-3.001616,104.765834],[-3.001872,104.765581],[-3.002227,104.765235],[-3.002438,104.765032],[-3.00264,104.764836],[-3.002701,104.764778],[-3.003018,104.764503],[-3.003138,104.764409],[-3.003306,104.764361],[-3.003614,104.764285],[-3.003833,104.76422],[-3.003919,104.764196],[-3.003963,104.76418],[-3.004295,104.764056],[-3.004383,104.764021],[-3.004548,104.763949],[-3.004701,104.763864],[-3.004829,104.763793],[-3.00512,104.763611],[-3.005388,104.763434],[-3.005634,104.763255],[-3.005803,104.763132],[-3.005859,104.763091],[-3.00614,104.762838],[-3.006316,104.762679],[-3.006421,104.762941],[-3.00645,104.763002],[-3.006494,104.763072],[-3.006619,104.763201],[-3.006764,104.763334],[-3.00692,104.763487],[-3.007097,104.763658],[-3.007127,104.763695],[-3.007135,104.763705],[-3.007174,104.763764],[-3.007216,104.763853],[-3.007236,104.763911],[-3.007267,104.764015],[-3.007299,104.764158],[-3.00734,104.764338],[-3.007386,104.764524],[-3.007405,104.764583],[-3.007414,104.764811],[-3.007416,104.764895],[-3.007421,104.765068],[-3.007424,104.765153],[-3.007429,104.765293],[-3.007435,104.765422],[-3.007416,104.765604],[-3.007395,104.765761],[-3.007377,104.765837],[-3.007384,104.765892],[-3.007518,104.765993],[-3.007968,104.766285],[-3.008197,104.766443],[-3.008408,104.766583],[-3.008534,104.766665],[-3.008566,104.766695],[-3.009079,104.767049],[-3.009124,104.76708],[-3.009293,104.767183],[-3.009506,104.767321],[-3.009575,104.767364],[-3.009677,104.767429],[-3.009702,104.767445],[-3.009956,104.767587],[-3.010101,104.767669],[-3.010186,104.767715],[-3.010479,104.767879],[-3.010569,104.76793],[-3.010592,104.767943],[-3.010845,104.768089],[-3.010898,104.768118],[-3.011034,104.768201],[-3.011112,104.768246],[-3.011157,104.768272],[-3.011218,104.768309],[-3.011374,104.768401],[-3.011563,104.768526],[-3.011861,104.76872],[-3.011901,104.768748],[-3.011932,104.768775],[-3.011961,104.768805],[-3.01213,104.768776],[-3.012144,104.768772],[-3.012395,104.768717],[-3.012765,104.768623],[-3.012922,104.768583],[-3.013116,104.768533],[-3.013279,104.768492],[-3.013486,104.768439],[-3.013533,104.768418],[-3.01358,104.768385],[-3.013628,104.768343],[-3.013666,104.768297],[-3.01371,104.768205],[-3.013815,104.767916],[-3.013868,104.767776],[-3.014113,104.767928],[-3.014592,104.768282],[-3.014662,104.768333],[-3.014725,104.768367],[-3.014783,104.768391],[-3.014847,104.768409],[-3.014918,104.768415],[-3.015034,104.768421],[-3.015148,104.768417],[-3.01566,104.768382],[-3.015741,104.768378],[-3.015829,104.768381],[-3.015889,104.76839],[-3.01595,104.768409],[-3.016022,104.768437],[-3.016178,104.768505],[-3.017818,104.76941],[-3.01784,104.769414],[-3.017866,104.769415],[-3.01789,104.769407],[-3.017904,104.769395],[-3.018082,104.768982],[-3.018673,104.76757],[-3.019153,104.766518],[-3.019303,104.766165],[-3.019522,104.765688],[-3.019588,104.765476],[-3.019488,104.765443],[-3.019123,104.765241],[-3.018759,104.765132],[-3.018373,104.765043],[-3.018312,104.765021]],
};


    // Swap planned path dynamically on load if rerouted
    <?php $__currentLoopData = $perjalananAktif; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if($p->isRerouted()): ?>
            if (alternativePaths['<?php echo e($p->lokasi_tujuan); ?>']) {
                plannedPaths['<?php echo e($p->lokasi_tujuan); ?>'] = alternativePaths['<?php echo e($p->lokasi_tujuan); ?>'];
            }
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    // Helper functions for Route Deviation Calculation
    function getDistanceMeters(p1, p2) {
        const R = 6371e3;
        const phi1 = p1[0] * Math.PI / 180;
        const phi2 = p2[0] * Math.PI / 180;
        const deltaPhi = (p2[0] - p1[0]) * Math.PI / 180;
        const deltaLambda = (p2[1] - p1[1]) * Math.PI / 180;

        const a = Math.sin(deltaPhi / 2) * Math.sin(deltaPhi / 2) +
                  Math.cos(phi1) * Math.cos(phi2) *
                  Math.sin(deltaLambda / 2) * Math.sin(deltaLambda / 2);
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
        return R * c;
    }

    function getDistanceToSegment(p, a, b) {
        const x = p[0], y = p[1];
        const x1 = a[0], y1 = a[1];
        const x2 = b[0], y2 = b[1];

        const A = x - x1;
        const B = y - y1;
        const C = x2 - x1;
        const D = y2 - y1;

        const dot = A * C + B * D;
        const lenSq = C * C + D * D;
        let param = -1;
        if (lenSq !== 0) {
            param = dot / lenSq;
        }

        let xx, yy;
        if (param < 0) {
            xx = x1;
            yy = y1;
        } else if (param > 1) {
            xx = x2;
            yy = y2;
        } else {
            xx = x1 + param * C;
            yy = y1 + param * D;
        }
        return getDistanceMeters(p, [xx, yy]);
    }

    function getDistanceToPolyline(p, polyline) {
        let minDistance = Infinity;
        for (let i = 0; i < polyline.length - 1; i++) {
            const dist = getDistanceToSegment(p, polyline[i], polyline[i+1]);
            if (dist < minDistance) {
                minDistance = dist;
            }
        }
        return minDistance;
    }
    // Request permission for push notifications
    if (window.Notification && Notification.permission !== 'granted' && Notification.permission !== 'denied') {
        Notification.requestPermission();
    }

    // 2. Initialize Leaflet map with dark CartoDB tiles
    const map = L.map('map', {
        center: [-2.99, 104.75],
        zoom: 13,
        zoomControl: true,
        attributionControl: false
    });

    let isDarkTheme = document.documentElement.classList.contains('dark');
    let tileUrl = isDarkTheme ? 'https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png' : 'https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png';

    const tileLayer = L.tileLayer(tileUrl, {
        maxZoom: 19,
        attribution: '&copy; CartoDB'
    }).addTo(map);

    window.addEventListener('theme-changed', (e) => {
        isDarkTheme = e.detail.theme === 'dark';
        const newUrl = isDarkTheme ? 'https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png' : 'https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png';
        tileLayer.setUrl(newUrl);
    });

    L.control.attribution({ prefix: false }).addTo(map);

    // --- Interactive Map Settings & AI Risk Heatmap (Opsi 3) ---
    const btnToggleLayers = document.getElementById('btn-toggle-layers');
    const layersPanel = document.getElementById('layers-options-panel');
    const btnMapVector = document.getElementById('btn-map-vector');
    const btnMapSat = document.getElementById('btn-map-sat');
    const chkRiskHeatmap = document.getElementById('chk-risk-heatmap');

    // Create Satellite Tile Layer using Esri World Imagery
    const satTileLayer = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
        maxZoom: 19,
        attribution: 'Tiles &copy; Esri'
    });

    // Create AI Risk Heatmap Layer Group (translucent overlay circles around critical points in Palembang)
    const heatmapGroup = L.layerGroup();
    const heatspotsData = [
        { lat: -2.9904, lng: 104.7622, desc: 'Risiko Fluktuasi Tinggi: Macet Jembatan Ampera', r: 300, level: 'Tinggi' },
        { lat: -2.9666, lng: 104.7505, desc: 'Risiko Suhu: Area RSMH Padat Bongkar Muat', r: 220, level: 'Sedang' },
        { lat: -3.0185, lng: 104.7645, desc: 'Risiko Termal: Paparan RSUD BARI Tinggi', r: 260, level: 'Sedang' },
        { lat: -2.9800, lng: 104.7550, desc: 'Risiko Deviasi: Rute Padat Sudirman', r: 240, level: 'Tinggi' }
    ];

    heatspotsData.forEach(spot => {
        L.circle([spot.lat, spot.lng], {
            color: '#ef4444',
            fillColor: '#f87171',
            fillOpacity: spot.level === 'Tinggi' ? 0.35 : 0.2,
            radius: spot.r,
            weight: 1
        }).bindPopup(`
            <div class="text-[11px] select-none text-left p-1">
                <span class="font-bold text-error uppercase tracking-wider block mb-1">ÃƒÆ’Ã‚Â°Ãƒâ€¦Ã‚Â¸Ãƒâ€¦Ã‚Â¡Ãƒâ€šÃ‚Â¨ AI RISK HEATSPOT</span>
                <p class="text-on-surface font-semibold">${spot.desc}</p>
                <p class="text-slate-500 font-bold mt-1 text-[10px]">Tingkat Risiko: <span class="text-error font-black">${spot.level}</span></p>
            </div>
        `).addTo(heatmapGroup);
    });

    if (btnToggleLayers) {
        btnToggleLayers.addEventListener('click', () => {
            layersPanel.classList.toggle('hidden');
        });
    }

    if (btnMapVector && btnMapSat) {
        btnMapSat.addEventListener('click', () => {
            if (map.hasLayer(tileLayer)) {
                map.removeLayer(tileLayer);
            }
            satTileLayer.addTo(map);
            btnMapSat.className = "px-2 py-1 rounded bg-primary text-on-primary font-bold text-[10px] active:scale-95 transition-all shadow-md";
            btnMapVector.className = "px-2 py-1 rounded bg-slate-200 dark:bg-slate-800 text-slate-600 dark:text-on-surface-variant text-[10px] font-bold active:scale-95 transition-all";
        });

        btnMapVector.addEventListener('click', () => {
            if (map.hasLayer(satTileLayer)) {
                map.removeLayer(satTileLayer);
            }
            tileLayer.addTo(map);
            btnMapVector.className = "px-2 py-1 rounded bg-primary text-on-primary font-bold text-[10px] active:scale-95 transition-all shadow-md";
            btnMapSat.className = "px-2 py-1 rounded bg-slate-200 dark:bg-slate-800 text-slate-600 dark:text-on-surface-variant text-[10px] font-bold active:scale-95 transition-all";
        });
    }

    if (chkRiskHeatmap) {
        chkRiskHeatmap.addEventListener('change', (e) => {
            if (e.target.checked) {
                map.addLayer(heatmapGroup);
            } else {
                map.removeLayer(heatmapGroup);
            }
        });
    }

    /**
     * Build a custom DivIcon for a courier marker based on status.
     */
    function createMarkerIcon(status) {
        let color = 'var(--color-primary)';
        let bgColor = 'var(--color-primary-container)';
        let pulseClass = '';

        if (status === 'Peringatan') {
            color = 'var(--color-tertiary)'; // tertiary
            bgColor = 'var(--color-tertiary-container)';
            pulseClass = 'animate-pulse';
        } else if (status === 'Tidak Layak Pakai') {
            color = 'var(--color-error)'; // error
            bgColor = 'var(--color-error-container)';
            pulseClass = 'marker-danger-pulse'; // custom red pulse
        }

        return L.divIcon({
            className: 'custom-marker',
            html: `
                <div style="
                    width: 28px; height: 28px;
                    background: ${bgColor};
                    border: 2px solid ${color};
                    border-radius: 50%;
                    display: flex; align-items: center; justify-content: center;
                    box-shadow: 0 0 8px ${color};
                    cursor: pointer;
                " class="${pulseClass}">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="${color}">
                        <path d="M18 18.5a1.5 1.5 0 0 1-1.5-1.5 1.5 1.5 0 0 1 1.5-1.5 1.5 1.5 0 0 1 1.5 1.5 1.5 1.5 0 0 1-1.5 1.5m1.5-9L21.46 12H17V9.5M6 18.5A1.5 1.5 0 0 1 4.5 17 1.5 1.5 0 0 1 6 15.5 1.5 1.5 0 0 1 7.5 17 1.5 1.5 0 0 1 6 18.5M20 8h-3V4H3c-1.11 0-2 .89-2 2v11h2a3 3 0 0 0 3 3 3 3 0 0 0 3-3h6a3 3 0 0 0 3 3 3 3 0 0 0 3-3h2v-5l-3-4Z"/>
                    </svg>
                </div>
            `,
            iconSize: [28, 28],
            iconAnchor: [14, 14],
            popupAnchor: [0, -18]
        });
    }

    /**
     * Get route polyline color matching excursion status.
     */
    function getPolylineColor(status) {
        if (status === 'Peringatan') {
            return '#ffb95f'; // amber/warning
        } else if (status === 'Tidak Layak Pakai') {
            return '#ffb4ab'; // error/red
        }
        return '#06b6d4'; // safe/cyan
    }

    /**
     * Build popup HTML for a courier containing duration and AI prediction.
     */
    function createPopupContent(c) {
        const name = c.nama_kurir;
        const plate = c.nomor_kendaraan;
        const dest = c.lokasi_tujuan;
        const cargo = c.nama_kargo || 'Obat Termolabil';
        const idBox = c.id_box;
        const temp = c.suhu_aktual;
        const status = c.excursion_status;
        const statusLabel = c.status_label;
        const duration = c.excursion_duration;
        const prob = c.probabilitas_rusak;

        let statusColor = 'text-cyan-500 dark:text-primary';
        if (status === 'Peringatan') {
            statusColor = 'text-amber-500 dark:text-tertiary';
        } else if (status === 'Tidak Layak Pakai') {
            statusColor = 'text-red-500 dark:text-error';
        }

        const tempDisplay = temp !== null ? temp.toFixed(1).replace('.', ',') + '&deg;C' : '-';

        return `
            <div class="p-2 text-xs space-y-2 select-none font-sans">
                <div class="flex items-center justify-between border-b border-white/10 pb-1.5 mb-1.5">
                    <span class="font-extrabold text-sm text-white truncate">${name}</span>
                    <span class="text-[9px] px-1.5 py-0.5 rounded bg-primary/10 border border-primary/20 text-primary font-mono font-bold">${idBox}</span>
                </div>
                <p class="flex items-center gap-1 text-slate-400">
                    <span class="material-symbols-outlined text-[14px] text-primary">local_shipping</span>
                    Armada: <strong class="text-slate-200 font-semibold">${plate}</strong>
                </p>
                <p class="flex items-center gap-1 text-slate-400">
                    <span class="material-symbols-outlined text-[14px] text-primary">call</span>
                    WhatsApp: <strong class="text-slate-200 font-semibold">${c.no_wa || '-'}</strong>
                </p>
                <p class="flex items-center gap-1 text-slate-400">
                    <span class="material-symbols-outlined text-[14px] text-primary">package_2</span>
                    Kargo: <strong class="text-slate-200 font-semibold">${cargo}</strong>
                </p>
                <p class="flex items-center gap-1 text-slate-400">
                    <span class="material-symbols-outlined text-[14px] text-primary">pin_drop</span>
                    Tujuan: <strong class="text-slate-200 font-semibold">${dest}</strong>
                </p>
                <p class="flex items-center gap-1 text-slate-400">
                    <span class="material-symbols-outlined text-[14px] text-primary">thermostat</span>
                    Suhu Aktual: <span class="font-black text-sm ${statusColor}">${tempDisplay}</span>
                </p>
                <div class="border-t border-white/10 pt-1.5 mt-1.5 flex justify-between items-center text-[10px]">
                    <span class="font-semibold text-slate-400">Risiko Kerusakan:</span>
                    <span class="font-bold ${prob > 50 ? 'text-red-400 animate-pulse' : 'text-primary'}">${prob.toFixed(1).replace('.', ',')}%</span>
                </div>
            </div>
        `;
    }

    // Smooth position interpolation for Leaflet markers
    function animateMarker(marker, startLatLng, endLatLng, durationMs) {
        const start = performance.now();
        const startLat = startLatLng.lat;
        const startLng = startLatLng.lng;
        const endLat = endLatLng[0];
        const endLng = endLatLng[1];

        function step(now) {
            const elapsed = now - start;
            const progress = Math.min(elapsed / durationMs, 1);
            const currentLat = startLat + (endLat - startLat) * progress;
            const currentLng = startLng + (endLng - startLng) * progress;
            marker.setLatLng([currentLat, currentLng]);

            if (progress < 1) {
                requestAnimationFrame(step);
            }
        }
        requestAnimationFrame(step);
    }

    function showTelemetryShimmer() {
        const container = document.getElementById('telemetry-cards-container');
        if (!container) return;
        
        container.innerHTML = Array(3).fill(0).map(() => `
            <div class="p-6 border-b border-outline-variant/30/60 animate-pulse space-y-4">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full bg-slate-250 dark:bg-slate-800"></div>
                    <div class="flex-1 space-y-2">
                        <div class="h-3 bg-slate-250 dark:bg-slate-800 rounded w-1/2"></div>
                        <div class="h-2.5 bg-slate-250 dark:bg-slate-800 rounded w-1/3"></div>
                    </div>
                </div>
                <div class="h-2.5 bg-slate-250 dark:bg-slate-800 rounded w-2/3"></div>
                <div class="flex justify-between items-end">
                    <div class="space-y-2 w-1/3">
                        <div class="h-2 bg-slate-250 dark:bg-slate-800 rounded"></div>
                        <div class="h-6 bg-slate-250 dark:bg-slate-800 rounded"></div>
                    </div>
                    <div class="space-y-2 w-1/4">
                        <div class="h-2 bg-slate-250 dark:bg-slate-800 rounded"></div>
                        <div class="h-4 bg-slate-250 dark:bg-slate-800 rounded"></div>
                    </div>
                </div>
                <div class="h-1 bg-slate-250 dark:bg-slate-800 rounded-full w-full"></div>
            </div>
        `).join('');
    }

    // Telemetry list rendering
    function renderTelemetryCards(list) {
        const container = document.getElementById('telemetry-cards-container');
        if (!container) return;

        if (list.length === 0) {
            container.innerHTML = `
                <div class="p-8 text-center text-slate-500">
                    <span class="material-symbols-outlined text-[40px] text-slate-400">sensors_off</span>
                    <p class="text-body-sm text-slate-400 mt-sm">Tidak ada pengiriman aktif</p>
                </div>
            `;
            return;
        }

        let html = '';
        list.forEach(c => {
            const status = c.excursion_status;
            const statusLabel = c.status_label;
            const badgeClass = c.badge_class;
            const textClass = c.text_class;
            const duration = c.excursion_duration;
            const temp = c.suhu_aktual;
            const mkt = c.nilai_mkt !== null ? c.nilai_mkt.toFixed(1).replace('.', ',') + '&deg;C' : '-';
            const prob = c.probabilitas_rusak;
            
            // Vibration evaluations
            const vibration = c.gaya_guncangan !== undefined ? parseFloat(c.gaya_guncangan) : 0.05;
            let vibeStatusClass = 'text-green-500';
            if (vibration > 1.50) {
                vibeStatusClass = 'text-red-500 font-bold';
            } else if (vibration > 1.00) {
                vibeStatusClass = 'text-amber-500';
            }
            const shakeClass = vibration > 1.50 ? 'animate-shake-infinite' : '';

            const statusIcon = status === 'Aman' ? 'check_circle' : (status === 'Peringatan' ? 'info' : 'warning');
            const tempDisplay = temp !== null ? temp.toFixed(1).replace('.', ',') + '&deg;C' : '-';
            const durationDisplay = status === 'Aman' ? '0s (Normal)' : duration + 's';
            
            let sparklineClass = 'sparkline-cyan';
            if (status === 'Peringatan') {
                sparklineClass = 'sparkline-cyan border-tertiary bg-tertiary';
            } else if (status === 'Tidak Layak Pakai') {
                sparklineClass = 'sparkline-red';
            }
            const sparklineWidth = temp !== null ? Math.min(Math.max((temp / 12) * 100, 8), 100) : 0;
            const tempIcon = status !== 'Aman' ? `<span class="material-symbols-outlined text-[18px] align-middle mr-0.5">thermostat</span>` : '';

            let probColor = 'text-primary';
            if (prob > 50) {
                probColor = 'text-error font-bold';
            } else if (prob > 10) {
                probColor = 'text-tertiary';
            }

            const qrRoute = `/dashboard/qr/${encodeURIComponent(c.id_box)}`;

            let bgClass = 'bg-surface-container-low';
            let cardBorderClass = 'border-outline-variant/30/60';
            let accentBorderClass = 'border-l-4 border-l-primary';
            let pulseRing = '';
            
            if (status === 'Peringatan') {
                bgClass = 'bg-amber-500/5 dark:bg-amber-500/10';
                accentBorderClass = 'border-l-4 border-l-tertiary';
                cardBorderClass = 'border-tertiary/40 dark:border-tertiary/20';
            } else if (status === 'Tidak Layak Pakai') {
                bgClass = 'bg-red-500/5 dark:bg-red-500/10';
                accentBorderClass = 'border-l-4 border-l-error';
                cardBorderClass = 'border-error/40 dark:border-error/20';
                pulseRing = 'ring-1 ring-error/30 animate-pulse';
            }

            const names = c.nama_kurir.split(' ');
            const initials = ((names[0] ? names[0][0] : '') + (names[1] ? names[1][0] : '')).toUpperCase();

            let glowClass = 'telemetry-card-glow-safe';
            if (status === 'Peringatan') {
                glowClass = 'telemetry-card-glow-warning';
            } else if (status === 'Tidak Layak Pakai') {
                glowClass = 'telemetry-card-glow-danger';
            }

            html += `
                <div class="telemetry-card ${glowClass} cursor-pointer p-6 ${bgClass} ${accentBorderClass} ${cardBorderClass} ${pulseRing} ${shakeClass} hover:bg-slate-100/50 dark:hover:bg-slate-800/30 active:scale-[0.99] border transition-all duration-300 ease-out group" data-rute-id="${c.id_rute}">
                    <div class="flex items-start justify-between gap-sm">
                        <div class="flex items-center gap-3 min-w-0">
                            <!-- Micro-Avatar dengan Inisial & Gradasi Neon -->
                            <div class="w-9 h-9 rounded-full bg-gradient-to-tr from-cyan-400 to-indigo-500 dark:from-primary dark:to-indigo-500 flex items-center justify-center text-slate-950 dark:text-white font-black text-xs uppercase tracking-wider shadow-[0_0_10px_rgba(76,213,246,0.3)] shrink-0 select-none">
                                ${initials}
                            </div>
                            <div class="min-w-0">
                                <p class="text-body-sm font-bold text-on-surface truncate">
                                    ${c.nama_kurir}
                                </p>
                                <p class="text-label-md text-slate-500 mt-0.5 flex flex-wrap items-center gap-x-1 gap-y-0.5">
                                    ${c.nomor_kendaraan} &bull; 
                                    <span class="font-mono-data text-[10px]">${c.id_box}</span> &bull; 
                                    <span class="font-mono-data text-[10px]" title="WhatsApp Kurir">${c.no_wa || '-'}</span>
                                    <a href="${qrRoute}" target="_blank" class="inline-flex items-center text-primary hover:text-primary/80 transition-all active:scale-90 ml-1" title="Cetak QR Code Boks">
                                        <span class="material-symbols-outlined text-[14px]">qr_code_2</span>
                                    </a>
                                </p>
                            </div>
                        </div>
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full ${badgeClass} text-[10px] font-black uppercase tracking-wider shrink-0">
                            <span class="material-symbols-outlined text-[12px]">${statusIcon}</span>
                            ${status.toUpperCase()}
                        </span>
                    </div>

                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-widest mt-sm truncate">
                        <span class="material-symbols-outlined text-[12px] align-middle mr-0.5 text-primary">pin_drop</span>
                        ${c.lokasi_tujuan}
                    </p>

                    <div class="flex items-end justify-between mt-sm">
                        <div>
                            <p class="uppercase tracking-widest text-[10px] font-semibold text-slate-400">Suhu Aktual</p>
                            <p class="text-2xl font-extrabold tracking-tight ${textClass}">
                                ${tempIcon}${tempDisplay}
                            </p>
                        </div>
                        <div class="text-right">
                            <p class="uppercase tracking-widest text-[10px] font-semibold text-slate-400">Nilai MKT</p>
                            <p class="text-lg font-bold text-slate-600 dark:text-on-surface-variant font-mono">
                                ${mkt}
                            </p>
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-sm mt-sm pt-sm border-t border-outline-variant/30/60 text-[10px] font-semibold text-slate-500">
                        <div>
                            <span class="block">Durasi Anomali</span>
                            <span class="font-mono-data font-bold block mt-0.5 ${status !== 'Aman' ? textClass : 'text-slate-700 dark:text-on-surface-variant'}">
                                ${durationDisplay}
                            </span>
                        </div>
                        <div class="text-center">
                            <span class="block">Guncangan</span>
                            <span class="font-mono-data font-bold block mt-0.5 ${vibeStatusClass}">
                                ${vibration.toFixed(2).replace('.', ',')}G
                            </span>
                        </div>
                        <div class="text-right">
                            <span class="block">Risiko (AI)</span>
                            <span class="font-mono-data font-bold block mt-0.5 ${probColor}">
                                ${prob.toFixed(1).replace('.', ',')}%
                            </span>
                        </div>
                    </div>

                    <div class="mt-sm h-1 rounded-full overflow-hidden bg-slate-200 dark:bg-slate-800">
                        <div class="h-full rounded-full ${sparklineClass}"
                             style="width: ${sparklineWidth}%;">
                        </div>
                    </div>
                </div>
            `;
        });

        container.innerHTML = html;
    }

    function triggerPushNotification(c) {
        if (window.Notification && Notification.permission === 'granted') {
            try {
                new Notification('ÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â¢ÃƒÆ’Ã¢â‚¬Â¦Ãƒâ€šÃ‚Â¡ÃƒÆ’Ã¢â‚¬Å¡Ãƒâ€šÃ‚Â ÃƒÆ’Ã¢â‚¬Å¡Ãƒâ€šÃ‚Â ALARM SUHU KRITIS BIO-GUARD', {
                    body: `Kondisi kritis pada Kurir ${c.nama_kurir} (${c.id_box})! Suhu saat ini: ${c.suhu_aktual.toFixed(1).replace('.', ',')}&deg;C.`,
                    icon: '/favicon.ico'
                });
            } catch (e) {
                console.warn('Push notification failed:', e);
            }
        }
    }

    function processLiveData(list, stats) {
        if (list && list !== latestCourierData) {
            latestCourierData = list;
        }

        // Apply filters
        const filteredList = list ? list.filter(c => {
            const matchStatus = (currentFilterStatus === 'all' || c.excursion_status === currentFilterStatus);
            const matchCargo = (currentFilterCargo === 'all' || c.id_box === currentFilterCargo);
            return matchStatus && matchCargo;
        }) : [];

        const activeStat = document.getElementById('stat-active-couriers');
        const pendingStat = document.getElementById('stat-pending-sync');
        const alertsValue = document.getElementById('stat-alerts-value');
        
        if (activeStat && stats) activeStat.textContent = stats.total_kurir_aktif;
        if (pendingStat && stats) pendingStat.textContent = stats.total_pending_sync;
        if (alertsValue && stats) {
            alertsValue.textContent = stats.alert_count + ' Alarm';
            if (stats.alert_count > 0) {
                alertsValue.classList.remove('hidden');
                alertsValue.classList.add('animate-pulse');
            } else {
                alertsValue.classList.add('hidden');
                alertsValue.classList.remove('animate-pulse');
            }
        }

        renderTelemetryCards(filteredList);

        // Update Device Health panel
        if (list) {
            list.forEach(c => {
                const boxId = c.id_box;
                const batteryValEl = document.getElementById(`device-battery-val-${boxId}`);
                const batteryBarEl = document.getElementById(`device-battery-bar-${boxId}`);
                const signalValEl = document.getElementById(`device-signal-val-${boxId}`);
                const signalIconEl = document.getElementById(`device-signal-icon-${boxId}`);
                const calibValEl = document.getElementById(`device-calibration-val-${boxId}`);
                const calibDotEl = document.getElementById(`device-calibration-dot-${boxId}`);
                
                if (batteryValEl) batteryValEl.textContent = `${c.battery_level}%`;
                if (batteryBarEl) {
                    batteryBarEl.style.width = `${c.battery_level}%`;
                    batteryBarEl.className = 'h-full rounded-full transition-all duration-500';
                    if (c.battery_level < 20) {
                        batteryBarEl.classList.add('bg-red-500', 'animate-pulse');
                    } else if (c.battery_level < 50) {
                        batteryBarEl.classList.add('bg-amber-500');
                    } else {
                        batteryBarEl.classList.add('bg-green-500');
                    }
                }
                if (signalValEl) signalValEl.textContent = `${c.signal_strength} dBm`;
                if (signalIconEl) {
                    let sigIcon = 'signal_cellular_alt';
                    if (c.signal_strength < -100) {
                        sigIcon = 'signal_cellular_0_bar';
                    } else if (c.signal_strength < -85) {
                        sigIcon = 'signal_cellular_1_bar';
                    }
                    signalIconEl.textContent = sigIcon;
                }
                if (calibValEl) {
                    const isCalib = c.calibration_status === 'Terkalibrasi';
                    calibValEl.textContent = isCalib ? 'CAL' : 'ERR';
                    calibValEl.className = `flex items-center gap-1 font-bold text-[9px] uppercase tracking-wider ${isCalib ? 'text-green-500' : 'text-red-500'}`;
                }
                if (calibDotEl) {
                    const isCalib = c.calibration_status === 'Terkalibrasi';
                    calibDotEl.className = `h-1.5 w-1.5 rounded-full inline-block ${isCalib ? 'bg-green-500' : 'bg-red-500 animate-pulse'}`;
                }
            });
        }

        const currentActiveIds = new Set();
        const bounds = [];

        filteredList.forEach(c => {
            const ruteId = c.id_rute;
            currentActiveIds.add(ruteId);

            if (c.is_rerouted) {
                activeReroutes[ruteId] = true;
                if (alternativePaths[c.lokasi_tujuan]) {
                    plannedPaths[c.lokasi_tujuan] = alternativePaths[c.lokasi_tujuan];
                }
            }

            const lat = c.latitude;
            const lng = c.longitude;
            if (lat === null || lng === null) return;

            // Route Deviation Calculation
            const plannedRoute = plannedPaths[c.lokasi_tujuan];
            let isDeviated = false;
            let currentLatLng = [lat, lng];

            if (plannedRoute) {
                const distanceToPlanned = getDistanceToPolyline(currentLatLng, plannedRoute);
                if (distanceToPlanned > 300) {
                    isDeviated = true;
                }
            }

            // Dynamic Deviation Radar Overlays on Map
            if (isDeviated) {
                if (activeDeviationCircles[ruteId]) {
                    activeDeviationCircles[ruteId].setLatLng(currentLatLng);
                } else {
                    const circle = L.circle(currentLatLng, {
                        radius: 120,
                        color: '#ef4444',
                        fillColor: '#ef4444',
                        fillOpacity: 0.15,
                        weight: 1.5
                    }).addTo(map);
                    
                    let growing = true;
                    const intervalId = setInterval(() => {
                        if (!circle || !map.hasLayer(circle)) {
                            clearInterval(intervalId);
                            return;
                        }
                        let r = circle.getRadius();
                        if (growing) {
                            r += 5;
                            if (r > 160) growing = false;
                        } else {
                            r -= 5;
                            if (r < 100) growing = true;
                        }
                        circle.setRadius(r);
                    }, 80);
                    
                    activeDeviationCircles[ruteId] = circle;
                }
            } else {
                if (activeDeviationCircles[ruteId]) {
                    map.removeLayer(activeDeviationCircles[ruteId]);
                    delete activeDeviationCircles[ruteId];
                }
            }

            // Set bounds using simulated current coordinates
            bounds.push(currentLatLng);

            // Marker Management with Smooth Sliding Animation
            if (activeMarkers[ruteId]) {
                const oldLatLng = activeMarkers[ruteId].getLatLng();
                if (oldLatLng.lat !== currentLatLng[0] || oldLatLng.lng !== currentLatLng[1]) {
                    animateMarker(activeMarkers[ruteId], oldLatLng, currentLatLng, 1000);
                }
                activeMarkers[ruteId].setIcon(createMarkerIcon(c.excursion_status));
                activeMarkers[ruteId].setPopupContent(createPopupContent(c));
            } else {
                const marker = L.marker(currentLatLng, {
                    icon: createMarkerIcon(c.excursion_status)
                }).bindPopup(createPopupContent(c), {
                    maxWidth: 280,
                    closeButton: false
                }).addTo(map);

                // Open on hover, close on mouseout
                marker.on('mouseover', function() {
                    this.openPopup();
                });
                marker.on('mouseout', function() {
                    this.closePopup();
                });

                activeMarkers[ruteId] = marker;
            }

            // Route Polyline (following planned road network)
            const routeCoords = plannedPaths[c.lokasi_tujuan] || [
                [c.origin_latitude, c.origin_longitude],
                currentLatLng
            ];

            let polylineColor = getPolylineColor(c.excursion_status);
            let polylineDashArray = null;
            let polylineWeight = 3.5;
            
            if (isDeviated) {
                polylineColor = '#ef4444';
                polylineDashArray = '5, 10';
                polylineWeight = 4.5;
            }

            if (activePolylines[ruteId]) {
                activePolylines[ruteId].setLatLngs(routeCoords);
                activePolylines[ruteId].setStyle({ 
                    color: polylineColor,
                    dashArray: polylineDashArray,
                    weight: polylineWeight
                });
            } else {
                const polyline = L.polyline(routeCoords, {
                    color: polylineColor,
                    dashArray: polylineDashArray,
                    weight: polylineWeight,
                    opacity: 0.85
                }).addTo(map);
                activePolylines[ruteId] = polyline;
            }

            // Excursion Alarm Triggers
            if (c.excursion_status === 'Tidak Layak Pakai') {
                if (previousStatuses[ruteId] !== 'Tidak Layak Pakai') {
                    new Audio('/alarm.mp3').play().catch(e => console.warn('Audio play blocked/failed:', e));
                    triggerPushNotification(c);
                }
            }

            // Geofencing radius arrival check
            if (c.dest_latitude && c.dest_longitude && !completedRouteIds.has(ruteId)) {
                const distanceToDestination = getDistanceMeters(currentLatLng, [c.dest_latitude, c.dest_longitude]);
                if (distanceToDestination <= 50) {
                    completedRouteIds.add(ruteId);
                    triggerGeofencingCompletion(ruteId, c.id_box, c.lokasi_tujuan, c.nama_kurir, c.suhu_aktual, c.no_wa);
                }
            }

            // Gateway Alert Triggers
            
            // 1. Temperature Alert Gateway Logs
            if (c.excursion_status !== previousStatuses[ruteId]) {
                if (c.excursion_status === 'Tidak Layak Pakai') {
                    logGatewayActivity('TG', 'Suhu', `Bot Telegram: Alert dikirim ke Dispatcher. Kargo BOX-${c.id_box} (${c.nama_kurir}) SUHU KRITIS ${c.suhu_aktual.toFixed(1).replace('.', ',')}&deg;C!`, 'danger');
                    logGatewayActivity('WA', 'Suhu', `WhatsApp Gateway (${c.no_wa}): Peringatan dikirim ke Kurir ${c.nama_kurir}. Boks ${c.id_box} melebihi batas aman: ${c.suhu_aktual.toFixed(1).replace('.', ',')}&deg;C. Pindahkan kargo segera!`, 'danger');
                } else if (c.excursion_status === 'Peringatan') {
                    logGatewayActivity('TG', 'Suhu', `Bot Telegram: Peringatan dini dikirim ke Dispatcher. Boks ${c.id_box} mendeteksi anomali suhu ${c.suhu_aktual.toFixed(1).replace('.', ',')}&deg;C.`, 'warning');
                    logGatewayActivity('WA', 'Suhu', `WhatsApp Gateway (${c.no_wa}): Notifikasi dikirim ke Kurir ${c.nama_kurir}. Harap periksa kerapatan penutup Boks ${c.id_box}.`, 'warning');
                }
            }

            // 2. Deviation Alert Gateway Logs
            if (isDeviated !== previousDeviations[ruteId]) {
                if (isDeviated) {
                    logGatewayActivity('TG', 'Deviasi', `Bot Telegram: Alert deviasi dikirim ke Dispatcher. Kurir ${c.nama_kurir} keluar dari rute ${c.lokasi_tujuan}.`, 'danger');
                    logGatewayActivity('WA', 'Deviasi', `WhatsApp Gateway (${c.no_wa}): Re-routing otomatis dikirim ke Kurir ${c.nama_kurir}. Ikuti petunjuk alternatif menuju ${c.lokasi_tujuan}.`, 'warning');
                }
                previousDeviations[ruteId] = isDeviated;
            }

            // 3. Vibration Alert Gateway Logs
            const vibeVal = c.gaya_guncangan !== undefined ? parseFloat(c.gaya_guncangan) : 0.05;
            if (vibeVal > 1.50 && (!previousVibrations[ruteId] || previousVibrations[ruteId] <= 1.50)) {
                logGatewayActivity('TG', 'Guncangan', `Bot Telegram: Alert guncangan ekstrem ${vibeVal.toFixed(2).replace('.', ',')}G pada Boks ${c.id_box} dikirim ke Dispatcher.`, 'danger');
                logGatewayActivity('WA', 'Guncangan', `WhatsApp Gateway (${c.no_wa}): Peringatan dikirim ke Kurir ${c.nama_kurir}. Guncangan terdeteksi ${vibeVal.toFixed(2).replace('.', ',')}G. Harap berkendara lebih perlahan.`, 'warning');
            }
            previousVibrations[ruteId] = vibeVal;

            previousStatuses[ruteId] = c.excursion_status;

            // Notification Center Triggers
            if (c.excursion_status === 'Tidak Layak Pakai') {
                addNotification(`${c.id_box}-temp-danger`, `SUHU KRITIS: ${c.id_box}`, `Suhu kargo kurir ${c.nama_kurir} terdeteksi ${c.suhu_aktual.toFixed(1).replace('.', ',')}&deg;C melebihi batas cold chain!`, 'danger');
            } else if (c.excursion_status === 'Peringatan') {
                addNotification(`${c.id_box}-temp-warning`, `Peringatan: ${c.id_box}`, `Terdeteksi anomali suhu jangka pendek ${c.suhu_aktual.toFixed(1).replace('.', ',')}&deg;C.`, 'warning');
            }

            if (c.battery_level < 20) {
                addNotification(`${c.id_box}-battery-low`, `BATERAI LEMAH: ${c.id_box}`, `Daya baterai boks kurir ${c.nama_kurir} tersisa ${c.battery_level}%. Segera isi ulang!`, 'warning');
            }

            if (c.calibration_status !== 'Terkalibrasi') {
                addNotification(`${c.id_box}-calibration-err`, `DEVIASI SENSOR: ${c.id_box}`, `Sensor suhu boks ${c.id_box} terdeteksi mengalami deviasi (perlu kalibrasi).`, 'warning');
            }

            if (isDeviated) {
                addNotification(`${c.id_box}-deviation`, `DEVIASI RUTE: ${c.id_box}`, `Kurir ${c.nama_kurir} keluar dari jalur rute ${c.lokasi_tujuan}. Disarankan re-routing taktis segera!`, 'danger');
            }
        });

        // Cleanup Inactive Markers/Polylines
        Object.keys(activeMarkers).forEach(ruteId => {
            const id = parseInt(ruteId);
            if (!currentActiveIds.has(id)) {
                map.removeLayer(activeMarkers[id]);
                delete activeMarkers[id];

                if (activePolylines[id]) {
                    map.removeLayer(activePolylines[id]);
                    delete activePolylines[id];
                }
                
                if (activeDeviationCircles[id]) {
                    map.removeLayer(activeDeviationCircles[id]);
                    delete activeDeviationCircles[id];
                }
                
                delete routeTrails[id];
                delete previousStatuses[id];
            }
        });

        if (initialLoad && bounds.length > 0) {
            map.fitBounds(bounds, { padding: [40, 40], maxZoom: 13 });
            initialLoad = false;
        }
    }

    /**
     * Poll GET /api/fleet/live-location every 2 seconds.
     */
    function pollLiveData() {
        const datepickerEl = document.getElementById('datepicker');
        const selectedDate = datepickerEl ? datepickerEl.value : '';
        
        let url = '/dashboard/fleet/live-location';
        if (isHistoricalMode && selectedDate) {
            url += `?date=${selectedDate}`;
        }

        fetch(url, {
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            }
        })
        .then(res => res.json())
        .then(res => {
            if (res.success && Array.isArray(res.data)) {
                processLiveData(res.data, res.stats);
                const ts = document.getElementById('map-last-update');
                if (ts) {
                    if (isHistoricalMode) {
                        ts.textContent = `Arsip Data: ${selectedDate} (Jeda Polling)`;
                    } else {
                        ts.textContent = 'Pembaruan Otomatis: 2 detik &bull; Diperbarui: ' + new Date().toLocaleTimeString('id-ID');
                    }
                }
            }
        })
        .catch(err => {
            console.warn('[BIO-GUARD] 2s Live polling failed:', err);
        });
    }

    // Notification Hub State Management
    const bellBtn = document.getElementById('notification-bell-btn');
    const dropdown = document.getElementById('notification-dropdown');
    const countBadge = document.getElementById('notification-count-badge');
    const notificationList = document.getElementById('notification-list');
    const clearBtn = document.getElementById('clear-notifications-btn');
    let notificationCount = 0;
    const activeNotificationKeys = new Set();

    if (bellBtn && dropdown) {
        bellBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            dropdown.classList.toggle('hidden');
        });
        
        document.addEventListener('click', (e) => {
            if (!dropdown.classList.contains('hidden') && !dropdown.contains(e.target) && e.target !== bellBtn) {
                dropdown.classList.add('hidden');
            }
        });
    }

    if (clearBtn && notificationList) {
        clearBtn.addEventListener('click', () => {
            notificationList.innerHTML = `
                <div class="py-6 text-center text-slate-400 text-[11px]" id="notifications-empty-state">
                    <span class="material-symbols-outlined text-[24px] text-slate-300 dark:text-slate-700 block mb-1">notifications_off</span>
                    Tidak ada notifikasi baru
                </div>
            `;
            notificationCount = 0;
            if (countBadge) {
                countBadge.textContent = '0';
                countBadge.classList.add('hidden');
            }
            activeNotificationKeys.clear();
        });
    }

    function addNotification(key, title, body, severity = 'info') {
        if (activeNotificationKeys.has(key)) return;
        activeNotificationKeys.add(key);

        const list = document.getElementById('notification-list');
        const empty = document.getElementById('notifications-empty-state');
        if (!list) return;

        if (empty) empty.remove();

        notificationCount++;
        if (countBadge) {
            countBadge.textContent = notificationCount;
            countBadge.classList.remove('hidden');
        }

        let severityClass = 'border-l-primary text-primary bg-primary/5';
        let icon = 'info';
        if (severity === 'warning') {
            severityClass = 'border-l-tertiary text-tertiary bg-tertiary/5';
            icon = 'warning';
        } else if (severity === 'danger') {
            severityClass = 'border-l-error text-error bg-error/5 animate-pulse';
            icon = 'emergency';
        }

        const timeStr = new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });

        const item = document.createElement('div');
        item.className = `p-3 rounded-xl border-l-4 ${severityClass} border border-slate-205 dark:border-slate-800/50 flex flex-col gap-1 transition-all duration-300 hover:scale-[0.98] mt-1.5`;
        item.innerHTML = `
            <div class="flex items-start justify-between">
                <span class="font-bold text-[11px] flex items-center gap-1">
                    <span class="material-symbols-outlined text-[15px]">${icon}</span>
                    ${title}
                </span>
                <span class="text-[9px] font-mono text-slate-400">${timeStr}</span>
            </div>
            <p class="text-[10px] text-slate-600 dark:text-on-surface-variant leading-relaxed">${body}</p>
        `;

        list.insertBefore(item, list.firstChild);

        // Trigger browser native push notification if permitted
        if (typeof Notification !== 'undefined' && Notification.permission === 'granted') {
            try {
                new Notification(title, {
                    body: body,
                    icon: '/images/logo.png',
                    tag: key // deduplication key
                });
            } catch (e) {
                console.warn('[BIO-GUARD] Failed to trigger native notification:', e);
            }
        }
    }

    function logGatewayActivity(platform, type, text, severity) {
        const consoleEl = document.getElementById('gateway-log-console');
        if (!consoleEl) return;
        
        const emptyMsg = consoleEl.querySelector('.text-slate-500');
        if (emptyMsg && emptyMsg.textContent.includes('Menunggu')) {
            emptyMsg.remove();
        }

        const timeStr = new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
        
        let platformBadge = '';
        if (platform === 'WA') {
            platformBadge = `<span class="bg-green-500/10 text-green-400 border border-green-500/20 px-1 py-0.5 rounded text-[8px] font-black mr-1 uppercase">WhatsApp</span>`;
        } else if (platform === 'TG') {
            platformBadge = `<span class="bg-sky-500/10 text-sky-400 border border-primary/20 px-1 py-0.5 rounded text-[8px] font-black mr-1 uppercase">Telegram</span>`;
        }
        
        let typeBadge = '';
        if (type === 'Suhu') {
            typeBadge = `<span class="bg-red-500/10 text-red-400 border border-red-500/20 px-1 py-0.5 rounded text-[8px] font-black mr-1 uppercase">Temp</span>`;
        } else if (type === 'Deviasi') {
            typeBadge = `<span class="bg-orange-500/10 text-orange-400 border border-orange-500/20 px-1 py-0.5 rounded text-[8px] font-black mr-1 uppercase">GPS</span>`;
        } else if (type === 'Guncangan') {
            typeBadge = `<span class="bg-rose-500/10 text-rose-400 border border-rose-500/20 px-1 py-0.5 rounded text-[8px] font-black mr-1 uppercase">Vibe</span>`;
        } else if (type === 'Kedatangan') {
            typeBadge = `<span class="bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 px-1 py-0.5 rounded text-[8px] font-black mr-1 uppercase">Geofence</span>`;
        }

        let textColor = 'text-slate-400';
        if (severity === 'danger') {
            textColor = 'text-red-400 font-bold';
        } else if (severity === 'warning') {
            textColor = 'text-amber-400';
        } else if (severity === 'success') {
            textColor = 'text-emerald-400 font-semibold';
        }

        const logItem = document.createElement('div');
        logItem.className = `flex flex-col gap-0.5 border-b border-slate-200/5 dark:border-slate-800/10 pb-1`;
        logItem.innerHTML = `
            <div class="flex items-center text-[8px] text-slate-500">
                <span class="font-mono">${timeStr}</span>
                <span class="mx-1">&bull;</span>
                ${platformBadge}
                ${typeBadge}
            </div>
            <div class="${textColor} mt-0.5 pl-1">${text}</div>
        `;

        consoleEl.appendChild(logItem);
        consoleEl.scrollTop = consoleEl.scrollHeight;

        while (consoleEl.children.length > 50) {
            consoleEl.removeChild(consoleEl.firstChild);
        }
    }

    function showArrivalModal(courierName, boxId, destination, temp) {
        const modalId = `arrival-modal-${Date.now()}`;
        const modalDiv = document.createElement('div');
        modalDiv.id = modalId;
        modalDiv.className = "fixed inset-0 z-[3000] flex items-center justify-center p-md bg-black/60 backdrop-blur-sm transition-opacity duration-300";
        modalDiv.innerHTML = `
            <div class="bg-white dark:bg-slate-900 border border-outline-variant/30 rounded-2xl w-full max-w-md overflow-hidden shadow-2xl scale-95 opacity-0 transition-all duration-300 flex flex-col animate-fade-slide-in">
                <div class="px-6 py-4 border-b border-outline-variant/30/60 bg-emerald-500/10 dark:bg-emerald-500/5 flex justify-between items-center">
                    <div class="flex items-center gap-2 text-green-500">
                        <span class="material-symbols-outlined font-bold">verified</span>
                        <h3 class="text-sm font-bold text-on-surface">Kedatangan Terverifikasi (Geofencing)</h3>
                    </div>
                </div>
                <div class="p-6 space-y-4">
                    <div class="p-4 rounded-xl border border-green-500/30 bg-green-500/10 flex flex-col gap-2">
                        <div class="flex items-center gap-xs">
                            <span class="material-symbols-outlined text-green-500 text-[18px]">local_shipping</span>
                            <span class="font-bold text-on-surface text-xs">${courierName} (${boxId})</span>
                        </div>
                        <p class="text-[11px] text-slate-600 dark:text-slate-400 leading-relaxed">
                            Boks telah memasuki radius 50m dari **${destination}**. Rantai dingin terkunci dan terverifikasi aman.
                        </p>
                        <div class="grid grid-cols-2 gap-sm mt-1 text-[10px] font-mono text-on-surface-variant">
                            <div>Suhu Tiba: <span class="text-green-500 font-bold">${temp !== null ? temp.toFixed(1).replace('.', ',') + '&deg;C' : '-'}</span></div>
                            <div>Status: <span class="text-green-500 font-bold">Selesai</span></div>
                        </div>
                    </div>
                    <p class="text-[11px] text-slate-500 leading-relaxed text-center">
                        Tanda terima digital terkirim ke faskes penerima. Data perjalanan telah dikunci untuk kepatuhan CDOB.
                    </p>
                </div>
                <div class="px-6 py-4 border-t border-outline-variant/30/60 bg-slate-50 dark:bg-slate-850 flex justify-end">
                    <button onclick="document.getElementById('${modalId}').remove()" class="px-5 py-2.5 bg-primary text-on-primary hover:-translate-y-0.5 hover:shadow-md rounded-xl text-xs font-semibold transition-all duration-300 ease-out active:scale-95 shadow-[0_0_10px_rgba(2,132,199,0.2)]">
                        Selesai
                    </button>
                </div>
            </div>
        `;
        document.body.appendChild(modalDiv);
        setTimeout(() => {
            modalDiv.querySelector('.scale-95').classList.remove('scale-95', 'opacity-0');
        }, 50);
    }

    function triggerGeofencingCompletion(routeId, boxId, destination, courierName, temp, noWa) {
        console.log(`[Geofencing] Completing route ${routeId} for box ${boxId} at ${destination}`);
        logGatewayActivity('TG', 'Kedatangan', `Mengirim status selesai ke server untuk Rute ${routeId} (${destination}).`, 'info');
        
        fetch(`/api/route/${routeId}/complete`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(result => {
            if (result.success) {
                showArrivalModal(courierName, boxId, destination, temp);
                new Audio('/alarm.mp3').play().catch(e => console.warn(e));

                logGatewayActivity('TG', 'Kedatangan', `Bot Telegram: Notifikasi pengiriman BOX-${boxId} selesai dikirim ke Dispatcher.`, 'success');
                logGatewayActivity('WA', 'Kedatangan', `WhatsApp Gateway (${noWa}): Tanda terima digital BOX-${boxId} dikirim ke ${courierName} & ${destination}.`, 'success');
                
                pollLiveData();
            } else {
                console.error('[Geofencing] Failed to complete route:', result.message);
                logGatewayActivity('TG', 'Kedatangan', `Gagal meresolusi status selesai: ${result.message}`, 'danger');
            }
        })
        .catch(err => {
            console.error('[Geofencing] Network error completing route:', err);
            logGatewayActivity('TG', 'Kedatangan', `Kesalahan koneksi saat menyelesaikan rute: ${err.message}`, 'danger');
        });
    }

    // Bootstrapped Initial Data
    const initialList = <?php echo json_encode($perjalananAktif ?? [], 15, 512) ?>;
    const bootstrapData = initialList.map(p => {
        const log = p.latest_log;
        if (!log) return null;
        
        const coordinatesLookup = {
            'RSUP Dr. Mohammad Hoesin': {lat: -2.9666, lng: 104.7505},
            'RSUD Palembang BARI': {lat: -3.0185, lng: 104.7645},
            'RS Charitas': {lat: -2.9772, lng: 104.7522},
            'Puskesmas Dempo': {lat: -2.9865, lng: 104.7630}
        };
        const originCoord = {lat: -2.9880, lng: 104.7560};
        const destCoord = coordinatesLookup[p.lokasi_tujuan] || {lat: -6.2000, lng: 106.8400};

        let status = 'Aman';
        let statusLabel = 'Aman (Sesuai Standar 2&deg;C - 8&deg;C)';
        let badgeClass = 'bg-primary/10 text-primary border border-primary/30';
        let textClass = 'text-cyan-500 font-bold';
        let duration = 0;
        let temp = parseFloat(log.suhu_aktual || 0);

        if (temp < 2.0 || temp > 8.0) {
            const logs = p.log_telemetri || [];
            let firstOut = new Date(log.timestamp);
            for (let i = logs.length - 1; i >= 0; i--) {
                let t = parseFloat(logs[i].suhu_aktual || 0);
                if (t < 2.0 || t > 8.0) {
                    firstOut = new Date(logs[i].timestamp);
                } else {
                    break;
                }
            }
            duration = Math.max(0, Math.round((new Date(log.timestamp) - firstOut) / 1000));
            if (duration <= 30) {
                status = 'Peringatan';
                statusLabel = 'Peringatan Dini (Anomali <= 30 detik)';
                badgeClass = 'bg-tertiary/20 text-tertiary border border-tertiary/50 animate-pulse';
                textClass = 'text-amber-500 font-bold';
            } else {
                status = 'Tidak Layak Pakai';
                statusLabel = 'Tidak Layak Pakai (> 30 detik)';
                badgeClass = 'bg-error/20 text-error border border-error/50 animate-pulse';
                textClass = 'text-red-500 font-bold';
            }
        }

        let battery = 92;
        let signal = -65;
        let calib = 'Terkalibrasi';
        if (p.id_box === 'BOX-002') {
            battery = 85;
            signal = -78;
        } else if (p.id_box === 'BOX-003') {
            battery = 12;
            signal = -102;
            calib = 'Deviasi (Butuh Kalibrasi)';
        }

        return {
            id_rute: p.id_rute,
            nama_kurir: p.kurir ? p.kurir.nama_lengkap : 'Kurir Tidak Dikenal',
            nomor_kendaraan: p.kurir ? p.kurir.nomor_kendaraan : '-',
            no_wa: p.kurir ? p.kurir.no_wa : '-',
            lokasi_tujuan: p.lokasi_tujuan,
            nama_kargo: p.nama_kargo || 'Obat Termolabil',
            id_box: p.id_box,
            
            // Kesehatan Perangkat
            battery_level: battery,
            signal_strength: signal,
            calibration_status: calib,
            
            latitude: parseFloat(log.latitude || 0),
            longitude: parseFloat(log.longitude || 0),
            origin_latitude: originCoord.lat,
            origin_longitude: originCoord.lng,
            dest_latitude: destCoord.lat,
            dest_longitude: destCoord.lng,
            suhu_aktual: temp,
            nilai_mkt: log.nilai_mkt ? parseFloat(log.nilai_mkt) : null,
            timestamp: log.timestamp,
            excursion_duration: duration,
            excursion_status: status,
            status_label: statusLabel,
            badge_class: badgeClass,
            text_class: textClass,
            probabilitas_rusak: (p.latest_log && p.latest_log.prediksi_ai) ? parseFloat(p.latest_log.prediksi_ai.probabilitas_rusak || 0.0) : 0.0,
            is_safe: status === 'Aman' || status === 'Peringatan'
        };
    }).filter(x => x !== null);

    const initialStats = {
        total_kurir_aktif: <?php echo e($totalKurirAktif ?? 0); ?>,
        total_pending_sync: <?php echo e($totalPendingSync ?? 0); ?>,
        alert_count: <?php echo e($alertCount ?? 0); ?>

    };

    if (typeof L !== 'undefined' && map) {
        processLiveData(bootstrapData, initialStats);
    }

    // Start 2-second live polling interval
    pollIntervalId = setInterval(pollLiveData, 2000);

    // AJAX Calendar Filtering trigger
    function filterDashboardByDate(dateStr) {
        if (pollIntervalId) {
            clearInterval(pollIntervalId);
            pollIntervalId = null;
        }

        const todayStr = new Date().toISOString().split('T')[0];
        const updateIndicator = document.getElementById('map-last-update');
        if (updateIndicator) updateIndicator.textContent = 'Menyaring data tanggal ' + dateStr + '...';

        showTelemetryShimmer();

        fetch(`/dashboard/fleet/live-location?date=${dateStr}`, {
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            }
        })
        .then(res => res.json())
        .then(res => {
            if (res.success && Array.isArray(res.data)) {
                routeTrails = {};
                // Clear map layers if L is defined
                if (typeof L !== 'undefined' && map) {
                    Object.keys(activeMarkers).forEach(id => {
                        map.removeLayer(activeMarkers[id]);
                        delete activeMarkers[id];
                    });
                    Object.keys(activePolylines).forEach(id => {
                        map.removeLayer(activePolylines[id]);
                        delete activePolylines[id];
                    });
                }

                initialLoad = true;
                processLiveData(res.data, res.stats);
                
                if (dateStr === todayStr) {
                    isHistoricalMode = false;
                    pollIntervalId = setInterval(pollLiveData, 2000);
                    if (updateIndicator) updateIndicator.textContent = 'Pembaruan Otomatis: 2 detik';
                } else {
                    isHistoricalMode = true;
                    if (updateIndicator) updateIndicator.textContent = `Arsip Data: ${dateStr} (Polling Dijeda)`;
                }
            }
        })
        .catch(err => {
            console.error('[BIO-GUARD] Date filter failed:', err);
            if (updateIndicator) updateIndicator.textContent = 'Gagal menyaring data.';
        });
    }

    // Flatpickr initialization
    if (typeof flatpickr !== 'undefined') {
        const fpLocale = (flatpickr.l10ns && flatpickr.l10ns.id) ? 'id' : {
            firstDayOfWeek: 1,
            weekdays: {
                shorthand: ["Min", "Sen", "Sel", "Rab", "Kam", "Jum", "Sab"],
                longhand: ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"]
            },
            months: {
                shorthand: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agt", "Sep", "Okt", "Nov", "Des"],
                longhand: ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"]
            }
        };
        flatpickr("#datepicker", {
            locale: fpLocale,
            altInput: true,
            altFormat: "l, d F Y",
            dateFormat: "Y-m-d",
            defaultDate: "today",
            onChange: function(selectedDates, dateStr, instance) {
                filterDashboardByDate(dateStr);
            }
        });
    }

    // Request notification permissions
    if (window.Notification && Notification.permission === 'default') {
        Notification.requestPermission();
    }

    // Live clock
    function updateClock() {
        const now = new Date();
        const el = document.getElementById('clock-value');
        if (!el) return;
        try {
            const opts = {
                weekday: 'long', year: 'numeric', month: 'long', day: 'numeric',
                hour: '2-digit', minute: '2-digit', second: '2-digit',
                timeZone: 'Asia/Jakarta'
            };
            el.textContent = now.toLocaleDateString('id-ID', opts);
        } catch (e) {
            el.textContent = now.toLocaleString('id-ID');
        }
    }
    updateClock();
    setInterval(updateClock, 1000);

    // Event delegation on telemetry container to center map and open popup
    const cardsContainer = document.getElementById('telemetry-cards-container');
    if (cardsContainer) {
        cardsContainer.addEventListener('click', (e) => {
            const card = e.target.closest('.telemetry-card');
            if (card) {
                const ruteId = card.getAttribute('data-rute-id');
                if (ruteId && activeMarkers[ruteId]) {
                    const marker = activeMarkers[ruteId];
                    map.setView(marker.getLatLng(), 14);
                    marker.openPopup();
                }
            }
        });
    }

    window.addEventListener('resize', function () {
        map.invalidateSize();
    });

    // -------------------------------------------------------------
    // Dashboard Simulator Hub Embedded Control Panel Logic
    // -------------------------------------------------------------
    window.triggerDashboardSimulation = function(type) {
        const selectEl = document.getElementById('sim-target-box');
        if (!selectEl) return;
        
        const activeRouteId = parseInt(selectEl.value);
        const activeBoxId = selectEl.options[selectEl.selectedIndex].getAttribute('data-box');
        
        let temp = 4.5;
        let lat = -2.9880;
        let lng = 104.7560;
        
        if (routeTrails[activeRouteId] && routeTrails[activeRouteId].length > 0) {
            const lastLoc = routeTrails[activeRouteId][routeTrails[activeRouteId].length - 1];
            lat = lastLoc[0];
            lng = lastLoc[1];
        } else {
            const destCoords = {
                'RSUP Dr. Mohammad Hoesin': [-2.9666, 104.7505],
                'RSUD Palembang BARI': [-3.0185, 104.7645],
                'RS Charitas': [-2.9772, 104.7522],
                'Puskesmas Dempo': [-2.9865, 104.7630]
            };
            const currentRouteData = activeMarkers[activeRouteId]?.options?.courierData;
            if (currentRouteData && destCoords[currentRouteData.lokasi_tujuan]) {
                lat = destCoords[currentRouteData.lokasi_tujuan][0];
                lng = destCoords[currentRouteData.lokasi_tujuan][1];
            }
        }

        let message = '';
        if (type === 'suhu') {
            temp = 9.8;
            message = `Simulasi lonjakan suhu kritis (${temp.toFixed(1).replace('.', ',')}&deg;C) dikirim untuk Boks ${activeBoxId}`;
        } else if (type === 'deviasi') {
            lat = lat - 0.008; 
            lng = lng + 0.012;
            message = `Simulasi deviasi koordinat rute dikirim untuk Boks ${activeBoxId}`;
        } else if (type === 'reset') {
            temp = 4.2;
            message = `Simulasi reset kondisi normal (suhu ${temp.toFixed(1).replace('.', ',')}&deg;C) dikirim untuk Boks ${activeBoxId}`;
        }

        const payload = {
            data: [{
                id_rute: activeRouteId,
                timestamp: new Date().toISOString(),
                suhu_aktual: temp,
                nilai_mkt: 4.8,
                latitude: lat,
                longitude: lng,
                is_synced_from_offline: false
            }]
        };

        fetch('/api/telemetry/sync', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify(payload)
        })
        .then(res => res.json())
        .then(res => {
            if (res.success) {
                addNotification(`sim-${activeBoxId}-${type}`, `Simulasi Berhasil`, message, type === 'reset' ? 'info' : 'warning');
                pollLiveData();
            } else {
                console.error('[Simulator Hub] Failed to trigger simulation:', res.message);
                alert('Gagal mengirim simulasi: ' + res.message);
            }
        })
        .catch(err => {
            console.error('[Simulator Hub] Error sending simulation:', err);
            alert('Kesalahan jaringan saat mengirim simulasi.');
        });
    };

    // -------------------------------------------------------------
    // Desktop Notification Permission Management
    // -------------------------------------------------------------
    const notificationBanner = document.getElementById('desktop-notification-banner');
    
    function checkNotificationPermission() {
        if (typeof Notification !== 'undefined') {
            if (Notification.permission === 'default') {
                if (notificationBanner) {
                    notificationBanner.classList.remove('hidden');
                }
            } else if (Notification.permission === 'denied') {
                console.info('[BIO-GUARD] Desktop notifications are blocked by user.');
            }
        }
    }

    window.requestNotificationPermission = function() {
        if (typeof Notification !== 'undefined') {
            Notification.requestPermission().then(permission => {
                if (permission === 'granted') {
                    if (notificationBanner) {
                        notificationBanner.classList.add('hidden');
                    }
                    new Notification('Notifikasi Aktif', {
                        body: 'Anda akan menerima alarm pemantauan rantai dingin di sini.',
                        icon: '/images/logo.png'
                    });
                } else {
                    alert('Izin notifikasi ditolak. Anda tidak akan menerima push notification.');
                    if (notificationBanner) {
                        notificationBanner.classList.add('hidden');
                    }
                }
            });
        }
    };

    // CDOB Audit Preview Controls
    window.openAuditPreviewModal = function () {
        const randomHex = Array.from({length: 40}, () => Math.floor(Math.random()*16).toString(16)).join('');
        const hashEl = document.getElementById('audit-sha-hash');
        if (hashEl) {
            hashEl.textContent = `bg_sha256_${randomHex}`;
        }
        
        const modal = document.getElementById('audit-preview-modal');
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.querySelector('.rounded-3xl').classList.remove('scale-95', 'opacity-0');
        }, 50);
    };

    window.closeAuditPreviewModal = function () {
        const modal = document.getElementById('audit-preview-modal');
        if (modal) {
            modal.querySelector('.rounded-3xl').classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }
    };

    window.downloadOfficialPdf = function () {
        window.open('<?php echo e(route("dashboard.audit-pdf")); ?>', '_blank');
        closeAuditPreviewModal();
    };

    // Expose Rerouting Controls
    window.triggerReroutingModal = function (routeId, destination) {
        targetRerouteRouteId = routeId;
        targetRerouteDestination = destination;
        
        // Show alternative path on map in green
        const altPath = alternativePaths[destination];
        if (altPath) {
            // Draw alternative polyline on map
            if (alternativePolylines[routeId]) {
                map.removeLayer(alternativePolylines[routeId]);
            }
            alternativePolylines[routeId] = L.polyline(altPath, {
                color: '#10b981', // green-500
                dashArray: '5, 10',
                weight: 4.5,
                opacity: 0.95
            }).addTo(map);
            
            // Pan/zoom map to fit alt path
            map.fitBounds(alternativePolylines[routeId].getBounds());
        }

        const modal = document.getElementById('rerouting-modal');
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.querySelector('.rounded-2xl').classList.remove('scale-95', 'opacity-0');
        }, 50);
    };

    window.closeReroutingModal = function () {
        const modal = document.getElementById('rerouting-modal');
        if (modal) {
            modal.querySelector('.rounded-2xl').classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                modal.classList.add('hidden');
                // Remove alternative path line if not confirmed
                if (targetRerouteRouteId && alternativePolylines[targetRerouteRouteId] && !activeReroutes[targetRerouteRouteId]) {
                    map.removeLayer(alternativePolylines[targetRerouteRouteId]);
                    delete alternativePolylines[targetRerouteRouteId];
                }
            }, 300);
        }
    };

    window.applyRerouting = function () {
        if (targetRerouteRouteId) {
            activeReroutes[targetRerouteRouteId] = true;
            
            // Update planned path coordinates to match alternative path
            const dest = targetRerouteDestination;
            if (alternativePaths[dest]) {
                plannedPaths[dest] = alternativePaths[dest];
            }
            
            // Swap alternative green line into routeTrails
            routeTrails[targetRerouteRouteId] = alternativePaths[dest];
            
            // Redraw active polyline to be normal/green
            if (activePolylines[targetRerouteRouteId]) {
                activePolylines[targetRerouteRouteId].setLatLngs(alternativePaths[dest]);
                activePolylines[targetRerouteRouteId].setStyle({
                    color: '#10b981', // Green for rerouted path
                    dashArray: null,
                    weight: 3.5
                });
            }
            
            // Remove alternative helper line
            if (alternativePolylines[targetRerouteRouteId]) {
                map.removeLayer(alternativePolylines[targetRerouteRouteId]);
                delete alternativePolylines[targetRerouteRouteId];
            }
            
            // Clean up visual deviation overlays
            if (activeDeviationCircles[targetRerouteRouteId]) {
                map.removeLayer(activeDeviationCircles[targetRerouteRouteId]);
                delete activeDeviationCircles[targetRerouteRouteId];
            }

            // Mock visual resolution in DOM sidebar (remove Kemacetan Ekstrem alert)
            const alertCard = document.querySelector('[class*="bg-amber-500/10"]'); // Kemacetan Ekstrem card
            if (alertCard) {
                alertCard.style.transition = 'all 0.5s ease';
                alertCard.style.opacity = '0';
                alertCard.style.transform = 'translateY(10px)';
                setTimeout(() => {
                    alertCard.remove();
                    // Update Peringatan badge header count
                    const headerBadge = document.querySelector('.inline-flex.items-center.justify-center.w-auto.h-5');
                    if (headerBadge) {
                        headerBadge.textContent = '1 Peringatan';
                    }
                }, 500);
            }

            // Show Toast notification
            showToast('Rute Dialihkan', `Boks BOX-002 berhasil dialihkan melalui Musi IV Bypass.`, 'success');
            
            // AJAX to resolve incident in DB (mocked for target route 2)
            fetch(`/peringatan/2/resolve`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            }).then(r => r.json())
              .then(data => {
                  console.log('Incident resolved status:', data);
              }).catch(e => console.warn(e));
        }
        closeReroutingModal();
    };

    function showToast(title, desc, type) {
        const toast = document.getElementById('toast');
        if (toast) {
            document.getElementById('toast-title').textContent = title;
            document.getElementById('toast-desc').textContent = desc;
            toast.classList.remove('translate-y-24', 'opacity-0');
            setTimeout(() => {
                toast.classList.add('translate-y-24', 'opacity-0');
            }, 4000);
        }
    }

    // -------------------------------------------------------------
    // Dashboard Live Filter Panel Interaction
    // -------------------------------------------------------------
    const btnFilterDashboard = document.getElementById('btn-filter-dashboard');
    const filterDropdown = document.getElementById('filter-dashboard-dropdown');
    const btnResetFilter = document.getElementById('btn-reset-dashboard-filter');
    const selectStatus = document.getElementById('filter-status-select');
    const selectCargo = document.getElementById('filter-cargo-select');

    if (btnFilterDashboard && filterDropdown) {
        btnFilterDashboard.addEventListener('click', (e) => {
            e.stopPropagation();
            filterDropdown.classList.toggle('hidden');
        });
        
        // Hide if click outside
        document.addEventListener('click', (e) => {
            if (filterDropdown && !filterDropdown.classList.contains('hidden') && !e.target.closest('#filter-dashboard-container')) {
                filterDropdown.classList.add('hidden');
            }
        });
    }

    function triggerFiltering() {
        currentFilterStatus = selectStatus ? selectStatus.value : 'all';
        currentFilterCargo = selectCargo ? selectCargo.value : 'all';
        
        // Trigger UI refresh
        processLiveData(latestCourierData, null);
    }

    if (selectStatus) selectStatus.addEventListener('change', triggerFiltering);
    if (selectCargo) selectCargo.addEventListener('change', triggerFiltering);

    if (btnResetFilter) {
        btnResetFilter.addEventListener('click', () => {
            if (selectStatus) selectStatus.value = 'all';
            if (selectCargo) selectCargo.value = 'all';
            currentFilterStatus = 'all';
            currentFilterCargo = 'all';
            processLiveData(latestCourierData, null);
            if (filterDropdown) filterDropdown.classList.add('hidden');
        });
    }

    // Run permission check on startup
    checkNotificationPermission();

})();
</script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    // Shared options helper for dark mode support
    function getChartThemeColors() {
        const isDark = document.documentElement.classList.contains('dark');
        return {
            textColor: isDark ? '#bfc7d4' : '#475569',
            gridColor: isDark ? 'rgba(64,71,82,0.2)' : 'rgba(203,213,225,0.4)',
            tooltipBg: isDark ? '#1b2025' : '#ffffff',
            tooltipBorder: isDark ? '#404752' : '#cbd5e1',
        };
    }

    let themeColors = getChartThemeColors();

    // 1. Chart MKT vs Suhu Aktual (Line Chart)
    const mktOptions = {
        series: [
            {
                name: "Suhu Aktual",
                data: [4.2, 4.8, 5.5, 7.8, 6.2, 4.5, 4.1, 4.3, 4.5]
            },
            {
                name: "Mean Kinetic Temp (MKT)",
                data: [4.5, 4.5, 4.6, 4.9, 5.1, 5.0, 4.9, 4.8, 4.8]
            }
        ],
        chart: {
            height: 240,
            type: 'line',
            toolbar: { show: false },
            zoom: { enabled: false },
            background: 'transparent'
        },
        stroke: {
            curve: 'smooth',
            width: [3, 2],
            dashArray: [0, 5]
        },
        colors: ['#4cd7f6', '#ffb95f'],
        xaxis: {
            categories: ['08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00'],
            labels: {
                style: {
                    colors: themeColors.textColor,
                    fontSize: '10px',
                    fontFamily: 'Inter, sans-serif'
                }
            },
            axisBorder: { show: false },
            axisTicks: { show: false }
        },
        yaxis: {
            labels: {
                formatter: function (val) {
                    return val.toFixed(1).replace('.', ',') + '&deg;C';
                },
                style: {
                    colors: themeColors.textColor,
                    fontSize: '10px',
                    fontFamily: 'Inter, sans-serif'
                }
            }
        },
        grid: {
            borderColor: themeColors.gridColor,
            strokeDashArray: 4,
            xaxis: { lines: { show: true } }
        },
        annotations: {
            yAxis: [
                {
                    y: 8,
                    borderColor: '#ef4444',
                    strokeDashArray: 4,
                    label: {
                        borderColor: '#ef4444',
                        style: { color: '#fff', background: '#ef4444', fontSize: '9px', fontWeight: 'bold' },
                        text: 'Max (8&deg;C)',
                        offsetY: -3
                    }
                },
                {
                    y: 2,
                    borderColor: '#3b82f6',
                    strokeDashArray: 4,
                    label: {
                        borderColor: '#3b82f6',
                        style: { color: '#fff', background: '#3b82f6', fontSize: '9px', fontWeight: 'bold' },
                        text: 'Min (2&deg;C)',
                        offsetY: 0
                    }
                }
            ]
        },
        legend: {
            show: true,
            position: 'top',
            horizontalAlign: 'right',
            labels: { colors: themeColors.textColor },
            fontSize: '10px',
            fontFamily: 'Inter, sans-serif'
        },
        theme: {
            mode: document.documentElement.classList.contains('dark') ? 'dark' : 'light'
        },
        tooltip: {
            theme: document.documentElement.classList.contains('dark') ? 'dark' : 'light',
            x: { show: true }
        }
    };

    const mktChart = new ApexCharts(document.querySelector("#chart-mkt"), mktOptions);
    mktChart.render();


    // 2. Proyeksi Risiko Prediktif AI (Gradient Area Chart)
    const riskOptions = {
        series: [{
            name: "Probabilitas Kerusakan",
            data: [2.5, 4.8, 12.4, 25.1, 48.8, 85.3, 91.5]
        }],
        chart: {
            height: 240,
            type: 'area',
            toolbar: { show: false },
            zoom: { enabled: false },
            background: 'transparent'
        },
        stroke: {
            curve: 'smooth',
            width: 3
        },
        colors: ['#ffb4ab'], // Red (kritis)
        fill: {
            type: 'gradient',
            gradient: {
                shade: 'dark',
                type: "vertical",
                shadeIntensity: 0.5,
                gradientToColors: ['#22c55e'], // Green (aman)
                inverseColors: false,
                opacityFrom: 0.8,
                opacityTo: 0.1,
                stops: [0, 100]
            }
        },
        xaxis: {
            categories: ['15 km', '12 km', '9 km', '6 km', '4 km', '2 km', '0 km'],
            labels: {
                style: {
                    colors: themeColors.textColor,
                    fontSize: '10px',
                    fontFamily: 'Inter, sans-serif'
                }
            },
            axisBorder: { show: false },
            axisTicks: { show: false }
        },
        yaxis: {
            max: 100,
            labels: {
                formatter: function (val) {
                    return val.toFixed(0) + '%';
                },
                style: {
                    colors: themeColors.textColor,
                    fontSize: '10px',
                    fontFamily: 'Inter, sans-serif'
                }
            }
        },
        grid: {
            borderColor: themeColors.gridColor,
            strokeDashArray: 4
        },
        theme: {
            mode: document.documentElement.classList.contains('dark') ? 'dark' : 'light'
        },
        tooltip: {
            theme: document.documentElement.classList.contains('dark') ? 'dark' : 'light'
        }
    };

    const riskChart = new ApexCharts(document.querySelector("#chart-risiko"), riskOptions);
    riskChart.render();


    // 3. Log Sinkronisasi Store-and-Forward (Stacked Bar Chart)
    const syncOptions = {
        series: [
            {
                name: "Terkirim (Online)",
                data: [120, 140, 100, 0, 0, 80, 180, 210]
            },
            {
                name: "Di-cache Lokal (Offline)",
                data: [0, 0, 40, 150, 180, 80, 0, 0]
            }
        ],
        chart: {
            type: 'bar',
            height: 240,
            stacked: true,
            toolbar: { show: false },
            background: 'transparent'
        },
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: '55%',
                borderRadius: 4
            },
        },
        colors: ['#4cd7f6', '#ffb95f'],
        xaxis: {
            categories: ['08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00'],
            labels: {
                style: {
                    colors: themeColors.textColor,
                    fontSize: '10px',
                    fontFamily: 'Inter, sans-serif'
                }
            },
            axisBorder: { show: false },
            axisTicks: { show: false }
        },
        yaxis: {
            labels: {
                style: {
                    colors: themeColors.textColor,
                    fontSize: '10px',
                    fontFamily: 'Inter, sans-serif'
                }
            }
        },
        grid: {
            borderColor: themeColors.gridColor,
            strokeDashArray: 4
        },
        legend: {
            show: true,
            position: 'top',
            horizontalAlign: 'right',
            labels: { colors: themeColors.textColor },
            fontSize: '10px',
            fontFamily: 'Inter, sans-serif'
        },
        theme: {
            mode: document.documentElement.classList.contains('dark') ? 'dark' : 'light'
        },
        tooltip: {
            theme: document.documentElement.classList.contains('dark') ? 'dark' : 'light'
        }
    };

    const syncChart = new ApexCharts(document.querySelector("#chart-sync"), syncOptions);
    syncChart.render();

    // LIVE SIMULATION UPDATE FOR CHARTS
    setInterval(() => {
        // Update MKT Chart
        let mktData1 = mktOptions.series[0].data;
        let mktData2 = mktOptions.series[1].data;
        
        mktData1.shift();
        mktData1.push(parseFloat((4.0 + Math.random() * 3.5).toFixed(1)));
        
        mktData2.shift();
        mktData2.push(parseFloat((4.5 + Math.random() * 0.5).toFixed(1)));
        
        mktChart.updateSeries([{ data: mktData1 }, { data: mktData2 }]);

        // Update Risk Chart
        let riskData = riskOptions.series[0].data;
        riskData.shift();
        riskData.push(parseFloat((85 + Math.random() * 10).toFixed(1)));
        riskChart.updateSeries([{ data: riskData }]);

        // Update Sync Chart
        let syncData1 = syncOptions.series[0].data;
        let syncData2 = syncOptions.series[1].data;
        syncData1.shift();
        syncData1.push(Math.floor(Math.random() * 200));
        syncData2.shift();
        syncData2.push(Math.floor(Math.random() * 50));
        syncChart.updateSeries([{ data: syncData1 }, { data: syncData2 }]);
    }, 3000);

    // Redraw charts on theme change to adjust labels/grid colors
    window.addEventListener('theme-changed', (e) => {
        const theme = e.detail.theme;
        const colors = getChartThemeColors();
        
        const updateOptions = {
            theme: { mode: theme },
            xaxis: { labels: { style: { colors: colors.textColor } } },
            yaxis: { labels: { style: { colors: colors.textColor } } },
            grid: { borderColor: colors.gridColor },
            legend: { labels: { colors: colors.textColor } },
            tooltip: { theme: theme }
        };

        mktChart.updateOptions(updateOptions);
        riskChart.updateOptions(updateOptions);
        syncChart.updateOptions(updateOptions);
    });
});
</script>
<?php $__env->stopPush(); ?>




<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\project pkm\bio_guard_backend\resources\views\dashboard\monitoring.blade.php ENDPATH**/ ?>