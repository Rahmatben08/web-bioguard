<?php $__env->startSection('title', 'Manajemen Armada & Pelacakan Kurir'); ?>

<?php $__env->startSection('content'); ?>
<div class="flex-1 w-full h-full flex flex-col md:flex-row overflow-hidden relative bg-background">
    <!-- Sidebar - Active Drivers List -->
    <aside id="fleet-sidebar" class="w-full md:w-96 bg-surface-container border-b md:border-b-0 md:border-r border-outline-variant/30 flex flex-col shrink-0 h-1/3 md:h-full z-20 shadow-2xl overflow-hidden transition-all duration-300">
        <!-- Sidebar Header -->
        <div class="p-lg border-b border-outline-variant/20 bg-surface-container-high/40 shrink-0">
            <nav class="flex justify-between items-center text-label-md text-outline mb-1 gap-2">
                <div>
                    <span>BIO-GUARD</span> / <span class="text-primary font-semibold">Armada Kurir</span>
                </div>
            </nav>
            <h2 class="font-headline-sm text-headline-sm text-on-surface font-bold">Pelacakan Armada Aktif</h2>
            <p class="text-xs text-on-surface-variant mt-1 mb-3">Telemetri GPS & Status Rantai Dingin aktual.</p>
            
            <!-- Search Bar -->
            <div class="relative">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-[16px]">search</span>
                <input type="text" id="searchFleetInput" placeholder="Cari nama, ID box, atau tujuan..." class="w-full bg-background border border-outline-variant/50 rounded-lg pl-9 pr-3 py-1.5 text-xs text-on-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
            </div>
        </div>

        <!-- Drivers List -->
        <div class="flex-1 overflow-y-auto p-4" id="drivers-list-container">
            <?php if (isset($component)) { $__componentOriginal163c8ba6efb795223894d5ffef5034f5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal163c8ba6efb795223894d5ffef5034f5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.table','data' => ['class' => 'w-full text-xs']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-full text-xs']); ?>
            <?php $__empty_1 = true; $__currentLoopData = $perjalananAktif; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $perjalanan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php
                    $log = $perjalanan->latestLog;
                    $excursion = $perjalanan->getExcursionInfo();
                ?>
                <?php
                    $badgeColor = 'neutral';
                    if ($excursion['status'] === 'Aman') $badgeColor = 'success';
                    elseif ($excursion['status'] === 'Peringatan') $badgeColor = 'warning';
                    elseif ($excursion['status'] === 'Tidak Layak Pakai') $badgeColor = 'error';
                ?>
                <tr id="driver-card-<?php echo e($perjalanan->id_rute); ?>" onclick="focusCourier(<?php echo e($perjalanan->id_rute); ?>)" class="hover:bg-surface-container-high transition-colors cursor-pointer group">
                    <td class="p-2 border-b border-outline-variant/30">
                        <div class="font-bold text-on-surface truncate"><?php echo e($perjalanan->kurir->nama_lengkap); ?></div>
                        <div class="text-[10px] text-on-surface-variant font-mono"><?php echo e($perjalanan->kurir->nomor_kendaraan); ?></div>
                    </td>
                    <td class="p-2 border-b border-outline-variant/30 tabular-nums">
                        <?php if($log): ?>
                            <span class="font-bold text-on-surface" id="temp-val-<?php echo e($perjalanan->id_rute); ?>">
                                <?php echo e(number_format($log->suhu_aktual, 1, ',', '.')); ?>°C
                            </span>
                        <?php else: ?>
                            <span class="text-on-surface-variant">-</span>
                        <?php endif; ?>
                    </td>
                    <td class="p-2 border-b border-outline-variant/30 text-right">
                        <span id="status-badge-<?php echo e($perjalanan->id_rute); ?>">
                            <?php if (isset($component)) { $__componentOriginal2ddbc40e602c342e508ac696e52f8719 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2ddbc40e602c342e508ac696e52f8719 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.badge','data' => ['color' => ''.e($badgeColor).'','class' => ''.e($badgeColor !== 'success' ? 'animate-pulse motion-reduce:animate-none' : '').'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['color' => ''.e($badgeColor).'','class' => ''.e($badgeColor !== 'success' ? 'animate-pulse motion-reduce:animate-none' : '').'']); ?>
                                <?php echo e($excursion['status'] === 'Aman' ? 'AMAN' : ($excursion['status'] === 'Peringatan' ? 'PERINGATAN' : 'BAHAYA')); ?>

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
                        </span>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="3" class="p-8 text-center text-slate-500">
                        <span class="material-symbols-outlined text-3xl mb-2">local_shipping</span>
                        <div class="text-sm font-bold">Tidak Ada Armada Aktif</div>
                    </td>
                </tr>
            <?php endif; ?>
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal163c8ba6efb795223894d5ffef5034f5)): ?>
<?php $attributes = $__attributesOriginal163c8ba6efb795223894d5ffef5034f5; ?>
<?php unset($__attributesOriginal163c8ba6efb795223894d5ffef5034f5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal163c8ba6efb795223894d5ffef5034f5)): ?>
<?php $component = $__componentOriginal163c8ba6efb795223894d5ffef5034f5; ?>
<?php unset($__componentOriginal163c8ba6efb795223894d5ffef5034f5); ?>
<?php endif; ?>
        </div>
    </aside>

    <!-- Map Container -->
    <main class="flex-1 h-2/3 md:h-full relative z-10 bg-slate-50 dark:bg-slate-900" id="map-container">
        <!-- Floating Persistent Summary Overlay (z-[1000]) -->
        <div class="absolute top-4 left-4 z-[1000] flex flex-col gap-2 pointer-events-none">
            <div class="pointer-events-auto flex items-center gap-2">
                <button onclick="toggleSidebar()" class="w-10 h-10 rounded-full bg-surface-container-high border border-outline-variant/50 shadow-lg flex items-center justify-center text-on-surface hover:bg-surface-container-highest transition-colors cursor-pointer" title="Toggle Sidebar">
                    <span id="sidebar-icon" class="material-symbols-outlined text-[20px]">menu_open</span>
                </button>
                <?php if (isset($component)) { $__componentOriginal53747ceb358d30c0105769f8471417f6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal53747ceb358d30c0105769f8471417f6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.card','data' => ['noPadding' => 'true','class' => 'shadow-lg backdrop-blur-md bg-surface/90 border border-outline-variant/30 flex items-center p-2 rounded-full px-4 gap-4 transition-all duration-300']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['noPadding' => 'true','class' => 'shadow-lg backdrop-blur-md bg-surface/90 border border-outline-variant/30 flex items-center p-2 rounded-full px-4 gap-4 transition-all duration-300']); ?>
                    <div class="flex items-center gap-1.5 text-xs font-semibold text-on-surface">
                        <span class="w-2 h-2 rounded-full bg-primary"></span>
                        <span id="summary-aktif">-- Aktif</span>
                    </div>
                    <div class="w-px h-4 bg-outline-variant/50"></div>
                    <div class="flex items-center gap-1.5 text-xs font-semibold text-error">
                        <span class="w-2 h-2 rounded-full bg-error animate-pulse motion-reduce:animate-none"></span>
                        <span id="summary-alert">-- Peringatan</span>
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
        </div>

        <div class="w-full h-full overflow-hidden">
            <div id="fleet-map" class="w-full h-full"></div>
        </div>
    </main>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<style>
    .marker-danger-pulse {
        box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7);
        animation: marker-danger-pulse 1.5s infinite cubic-bezier(0.66, 0, 0, 1);
    }
    @keyframes marker-danger-pulse {
        0% {
            box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7);
        }
        70% {
            box-shadow: 0 0 0 10px rgba(239, 68, 68, 0);
        }
        100% {
            box-shadow: 0 0 0 0 rgba(239, 68, 68, 0);
        }
    }
</style>
<script>
    let map;
    let markers = {};
    let activePolylines = {};
    let activeDeviationCircles = {};
    let initialLoad = true;

    // Active Reroutes state initialized from DB
    const activeReroutes = {
        <?php $__currentLoopData = $perjalananAktif; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            '<?php echo e($p->id_rute); ?>': <?php echo e($p->isRerouted() ? 'true' : 'false'); ?>,
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    };

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

    // Planned Reference Routes (Palembang)
    const plannedPaths = {
        'RSUP Dr. Mohammad Hoesin': [
            [-2.9880, 104.7560], // Dinas Kesehatan Palembang
            [-2.9887, 104.7565], // Air Mancur Masjid Agung Roundabout
            [-2.9868, 104.7561], // Sudirman St near IP
            [-2.9829, 104.7552], // Sudirman St near Pasar Cinde
            [-2.9803, 104.7547], // Sudirman St near Marathon
            [-2.9774, 104.7540], // Sudirman St / Kapten A Rivai intersection (Charitas)
            [-2.9748, 104.7533], // Sudirman St near Kodam II Sriwijaya
            [-2.9723, 104.7528], // Sudirman St near SMA 3
            [-2.9702, 104.7521], // Sudirman St / Veteran intersection
            [-2.9669, 104.7505]  // RSUP Dr. Mohammad Hoesin
        ],
        'RSUD Palembang BARI': [
            [-2.9880, 104.7560], // Dinas Kesehatan Palembang
            [-2.9887, 104.7565], // Air Mancur Masjid Agung
            [-2.9912, 104.7592], // Jembatan Ampera (North Approach)
            [-2.9935, 104.7618], // Jembatan Ampera (Center Span)
            [-2.9961, 104.7628], // Jembatan Ampera (South Approach)
            [-2.9995, 104.7635], // Jl. Ryacudu
            [-3.0068, 104.7625], // Simpang Bastari
            [-3.0125, 104.7615], // Jl. Gubernur Bastari near Lippo
            [-3.0142, 104.7585], // Jl. Panca Usaha entrance
            [-3.0185, 104.7645]  // RSUD Palembang BARI
        ],
        'RS Charitas': [
            [-2.9880, 104.7560], // Dinas Kesehatan Palembang
            [-2.9887, 104.7565], // Air Mancur Masjid Agung
            [-2.9868, 104.7561], // Sudirman St near IP
            [-2.9829, 104.7552], // Sudirman St near Pasar Cinde
            [-2.9803, 104.7547], // Sudirman St near Marathon
            [-2.9772, 104.7522]  // RS Charitas
        ],
        'Puskesmas Dempo': [
            [-2.9880, 104.7560], // Dinas Kesehatan Palembang
            [-2.9887, 104.7565], // Air Mancur Masjid Agung
            [-2.9868, 104.7561], // Sudirman St near IP
            [-2.9865, 104.7630]  // Puskesmas Dempo
        ]
    };

    // Swap planned path dynamically on load if rerouted
    <?php $__currentLoopData = $perjalananAktif; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if($p->isRerouted()): ?>
            if (alternativePaths['<?php echo e($p->lokasi_tujuan); ?>']) {
                plannedPaths['<?php echo e($p->lokasi_tujuan); ?>'] = alternativePaths['<?php echo e($p->lokasi_tujuan); ?>'];
            }
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

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

    <?php
        $activeRoutesData = $perjalananAktif->map(function($p) {
            return [
                'id_rute' => $p->id_rute,
                'nama_kurir' => $p->kurir->nama_lengkap,
                'nomor_kendaraan' => $p->kurir->nomor_kendaraan,
                'no_wa' => $p->kurir->no_wa,
                'nama_kargo' => $p->nama_kargo,
                'id_box' => $p->id_box,
                'lokasi_tujuan' => $p->lokasi_tujuan,
                'latitude' => $p->latestLog ? (float)$p->latestLog->latitude : -2.99,
                'longitude' => $p->latestLog ? (float)$p->latestLog->longitude : 104.75,
                'suhu_aktual' => $p->latestLog ? (float)$p->latestLog->suhu_aktual : 5.0,
                'status' => $p->getExcursionInfo()['status']
            ];
        })->toArray();
    ?>
    let activeRoutes = <?php echo json_encode($activeRoutesData); ?>;

    document.addEventListener("DOMContentLoaded", function () {
        // Initialize Leaflet Map centered on Palembang
        map = L.map('fleet-map', {
            zoomControl: false
        }).setView([-2.99, 104.756], 13);

        L.control.zoom({ position: 'bottomright' }).addTo(map);

        // Dynamic Theme Map Tiles Setup
        let isDarkTheme = document.documentElement.classList.contains('dark');
        let tileUrl = isDarkTheme ? 'https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png' : 'https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png';

        const tileLayer = L.tileLayer(tileUrl, {
            maxZoom: 20,
            attribution: '&copy; CartoDB'
        }).addTo(map);

        window.addEventListener('theme-changed', (e) => {
            isDarkTheme = e.detail.theme === 'dark';
            const newUrl = isDarkTheme ? 'https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png' : 'https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png';
            tileLayer.setUrl(newUrl);
        });

        // Render initial data and center map
        updateMapData(activeRoutes);

        // Start 2-second location polling
        setInterval(pollLiveLocation, 2000);
    });

    function getPolylineColor(status) {
        if (status === 'Peringatan') {
            return '#ffb95f';
        } else if (status === 'Tidak Layak Pakai') {
            return '#ffb4ab';
        }
        return '#06b6d4';
    }

    function createOrUpdateMarker(route) {
        const ruteId = route.id_rute;
        // Dynamically update reroute state if modified on server
        if (route.is_rerouted) {
            activeReroutes[ruteId] = true;
            if (alternativePaths[route.lokasi_tujuan]) {
                plannedPaths[route.lokasi_tujuan] = alternativePaths[route.lokasi_tujuan];
            }
        }

        let currentLatLng = [route.latitude, route.longitude];
        
        // For BOX-002, simulate deviation
        if (route.id_box === 'BOX-002' && !activeReroutes[ruteId]) {
            currentLatLng = [route.latitude - 0.005, route.longitude + 0.009];
        }

        // Deviation check
        const plannedRoute = plannedPaths[route.lokasi_tujuan];
        let isDeviated = false;
        if (plannedRoute) {
            const dist = getDistanceToPolyline(currentLatLng, plannedRoute);
            if (dist > 300) {
                isDeviated = true;
            }
        }

        // 1. Draw/Update Planned Route Polyline
        if (plannedRoute) {
            const polylineColor = isDeviated ? '#ef4444' : getPolylineColor(route.status);
            const weight = isDeviated ? 5 : 4;
            const dashArray = isDeviated ? '8, 8' : (route.status === 'Tidak Layak Pakai' ? '8, 8' : null);

            if (activePolylines[ruteId]) {
                activePolylines[ruteId].setLatLngs(plannedRoute);
                activePolylines[ruteId].setStyle({
                    color: polylineColor,
                    weight: weight,
                    dashArray: dashArray
                });
            } else {
                activePolylines[ruteId] = L.polyline(plannedRoute, {
                    color: polylineColor,
                    weight: weight,
                    opacity: 0.65,
                    dashArray: dashArray
                }).addTo(map);
            }
        }

        // 2. Draw/Update Deviation Radar Circle
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

        // 3. Style and create/update marker icon
        let colorClass = 'bg-primary border-primary shadow-[0_0_10px_rgba(6,182,212,0.6)]';
        let pulseClass = '';

        if (isDeviated) {
            colorClass = 'bg-error border-error shadow-[0_0_10px_rgba(239,68,68,0.8)]';
            pulseClass = 'marker-danger-pulse';
        } else if (route.status === 'Peringatan') {
            colorClass = 'bg-tertiary border-tertiary shadow-[0_0_10px_rgba(255,185,95,0.6)]';
            pulseClass = 'animate-pulse';
        } else if (route.status === 'Tidak Layak Pakai') {
            colorClass = 'bg-error border-error shadow-[0_0_10px_rgba(239,68,68,0.8)]';
            pulseClass = 'marker-danger-pulse';
        }

        let customIcon = L.divIcon({
            html: `<div class="relative flex items-center justify-center w-8 h-8 rounded-full ${colorClass} ${pulseClass} border-2 text-white font-bold text-xs">
                     <span class="material-symbols-outlined text-[16px]">local_shipping</span>
                   </div>`,
            className: 'custom-fleet-marker',
            iconSize: [32, 32],
            iconAnchor: [16, 16]
        });

        let tempColor = 'text-cyan-500 dark:text-primary';
        if (route.status === 'Peringatan') {
            tempColor = 'text-amber-500 dark:text-tertiary';
        } else if (route.status === 'Tidak Layak Pakai') {
            tempColor = 'text-red-500 dark:text-error';
        }

        let popupContent = `
            <div class="p-2 text-xs space-y-2 select-none font-sans">
                <div class="flex items-center justify-between border-b border-white/10 pb-1.5 mb-1.5">
                    <span class="font-bold text-sm text-white truncate">${route.nama_kurir}</span>
                    <span class="text-[9px] px-1.5 py-0.5 rounded bg-primary/10 border border-primary/20 text-primary font-mono font-bold">${route.id_box}</span>
                </div>
                <p class="flex items-center gap-1 text-slate-400">
                    <span class="material-symbols-outlined text-[14px] text-primary">local_shipping</span>
                    Armada: <strong class="text-slate-250 font-semibold">${route.nomor_kendaraan}</strong>
                </p>
                <p class="flex items-center gap-1 text-slate-400">
                    <span class="material-symbols-outlined text-[14px] text-primary">call</span>
                    WhatsApp: <strong class="text-slate-250 font-semibold">${route.no_wa || '-'}</strong>
                </p>
                <p class="flex items-center gap-1 text-slate-400">
                    <span class="material-symbols-outlined text-[14px] text-primary">package_2</span>
                    Kargo: <strong class="text-slate-250 font-semibold">${route.nama_kargo || 'Obat Termolabil'}</strong>
                </p>
                <p class="flex items-center gap-1 text-slate-400">
                    <span class="material-symbols-outlined text-[14px] text-primary">pin_drop</span>
                    Tujuan: <strong class="text-slate-250 font-semibold">${route.lokasi_tujuan}</strong>
                </p>
                <p class="flex items-center gap-1 text-slate-400">
                    <span class="material-symbols-outlined text-[14px] text-primary">thermostat</span>
                    Suhu Aktual: <span class="font-black text-sm ${tempColor}">${route.suhu_aktual.toFixed(1).replace('.', ',')}°C</span>
                </p>
                ${isDeviated ? `
                <div class="p-1 px-2 border border-red-500/30 bg-red-500/10 text-red-500 font-bold text-[9px] rounded uppercase tracking-wider animate-pulse flex items-center gap-1">
                    <span class="material-symbols-outlined text-[12px]">warning</span> Deviasi Rute > 300m
                </div>` : ''}
            </div>
        `;

        if (markers[ruteId]) {
            // Update Marker coordinates smoothly if changed
            const oldLatLng = markers[ruteId].getLatLng();
            if (oldLatLng.lat !== currentLatLng[0] || oldLatLng.lng !== currentLatLng[1]) {
                animateMarker(markers[ruteId], oldLatLng, currentLatLng, 1000);
            }
            markers[ruteId].setIcon(customIcon);
            markers[ruteId].setPopupContent(popupContent);
        } else {
            // Create New Marker
            let marker = L.marker(currentLatLng, { icon: customIcon }).addTo(map);
            marker.bindPopup(popupContent, {
                maxWidth: 280,
                closeButton: false
            });
            
            // Open on hover, close on mouseout
            marker.on('mouseover', function() {
                this.openPopup();
            });
            marker.on('mouseout', function() {
                this.closePopup();
            });

            markers[ruteId] = marker;
        }
    }

    function updateMapData(routesList) {
        let bounds = [];
        routesList.forEach(route => {
            if (route.latitude && route.longitude) {
                let currentLatLng = [route.latitude, route.longitude];
                if (route.id_box === 'BOX-002') {
                    currentLatLng = [route.latitude - 0.005, route.longitude + 0.009];
                }
                bounds.push(currentLatLng);
                createOrUpdateMarker(route);
            }
        });

        if (bounds.length > 0 && initialLoad) {
            map.fitBounds(bounds, { padding: [50, 50], maxZoom: 15 });
            initialLoad = false;
        }
    }

    function pollLiveLocation() {
        fetch('<?php echo e(route("fleet.live")); ?>')
            .then(response => response.json())
            .then(res => {
                if (res.success && res.data) {
                    // Update Map
                    updateMapData(res.data.map(route => {
                        return {
                            id_rute: route.id_rute,
                            nama_kurir: route.nama_kurir,
                            nomor_kendaraan: route.nomor_kendaraan,
                            no_wa: route.no_wa,
                            nama_kargo: route.nama_kargo,
                            id_box: route.id_box,
                            lokasi_tujuan: route.lokasi_tujuan,
                            latitude: parseFloat(route.latitude),
                            longitude: parseFloat(route.longitude),
                            suhu_aktual: parseFloat(route.suhu_aktual),
                            status: route.excursion_status
                        };
                    }));

                    // Update Sidebar values dynamically
                    if (res.stats) {
                        const aktifEl = document.getElementById('summary-aktif');
                        const alertEl = document.getElementById('summary-alert');
                        if (aktifEl) aktifEl.textContent = `${res.stats.total_kurir_aktif} Aktif`;
                        if (alertEl) alertEl.textContent = `${res.stats.alert_count} Peringatan`;
                    }
                    
                    res.data.forEach(route => {
                        const tempEl = document.getElementById(`temp-val-${route.id_rute}`);
                        if (tempEl) {
                            const newText = route.suhu_aktual.toFixed(1).replace('.', ',') + '°C';
                            if (tempEl.textContent.trim() !== newText) {
                                tempEl.textContent = newText;
                                tempEl.classList.add('text-primary', 'transition-colors', 'duration-300');
                                setTimeout(() => tempEl.classList.remove('text-primary'), 500);
                            }
                        }

                        const badgeEl = document.getElementById(`status-badge-${route.id_rute}`);
                        if (badgeEl) {
                            let content = '';
                            if (route.excursion_status === 'Aman') {
                                content = `<span class="w-1.5 h-1.5 rounded-full bg-primary"></span> Rantai Dingin Aman`;
                                badgeEl.className = 'inline-flex items-center gap-1 text-[10px] font-semibold text-primary transition-colors duration-300';
                            } else if (route.excursion_status === 'Peringatan') {
                                content = `<span class="w-1.5 h-1.5 rounded-full bg-tertiary animate-pulse motion-reduce:animate-none"></span> Peringatan Dini`;
                                badgeEl.className = 'inline-flex items-center gap-1 text-[10px] font-semibold text-tertiary transition-colors duration-300';
                            } else {
                                content = `<span class="w-1.5 h-1.5 rounded-full bg-error animate-pulse motion-reduce:animate-none"></span> Bahaya: Ekskursi Suhu`;
                                badgeEl.className = 'inline-flex items-center gap-1 text-[10px] font-semibold text-error transition-colors duration-300';
                            }
                            badgeEl.innerHTML = content;
                        }
                    });
                }
            })
            .catch(err => console.error('Error polling live locations:', err));
    }

    function focusCourier(id_rute) {
        if (markers[id_rute]) {
            let latlng = markers[id_rute].getLatLng();
            map.setView(latlng, 15, { animate: true, duration: 1 });
            markers[id_rute].openPopup();
        }
    }

    document.getElementById('searchFleetInput')?.addEventListener('keyup', function() {
        let filter = this.value.toLowerCase();
        let cards = document.querySelectorAll('.fleet-driver-card');

        cards.forEach(card => {
            let text = card.innerText.toLowerCase();
            card.style.display = text.includes(filter) ? '' : 'none';
        });
    });

    function toggleSidebar() {
        const sidebar = document.getElementById('fleet-sidebar');
        const icon = document.getElementById('sidebar-icon');
        
        if (sidebar.classList.contains('md:w-0')) {
            sidebar.classList.remove('md:w-0', 'w-0', 'h-0', 'opacity-0', 'border-none');
            sidebar.classList.add('md:w-96', 'w-full', 'h-1/3', 'md:h-full');
            icon.textContent = 'menu_open';
        } else {
            sidebar.classList.add('md:w-0', 'w-0', 'h-0', 'opacity-0', 'border-none');
            sidebar.classList.remove('md:w-96', 'w-full', 'h-1/3', 'md:h-full');
            icon.textContent = 'menu';
        }
        
        // Let transition finish before invalidating map size
        setTimeout(() => {
            if (typeof map !== 'undefined' && map) {
                map.invalidateSize();
            }
        }, 300);
    }
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\project pkm\bio_guard_backend\resources\views\dashboard\fleet.blade.php ENDPATH**/ ?>