@extends('layouts.app')

@section('title', 'Manajemen Armada & Pelacakan Kurir')

@section('content')
<div class="flex-1 w-full h-full flex flex-col md:flex-row overflow-hidden relative bg-background">
    <!-- Sidebar - Active Drivers List -->
    <aside id="fleet-sidebar" class="w-full md:w-96 bg-surface-container border-b md:border-b-0 md:border-r border-outline-variant/30 flex flex-col shrink-0 h-1/3 md:h-full z-20 shadow-2xl overflow-hidden transition-all duration-300">
        <!-- Sidebar Header -->
        <div class="p-lg border-b border-outline-variant/20 bg-surface-container-high/40 shrink-0">
            <nav class="flex justify-between items-center text-label-md text-outline mb-1 gap-2">
                <div>
                    <span>BIO-GUARD</span> / <span class="text-primary font-semibold">Armada Kurir</span>
                </div>
                <div class="flex gap-2">
                    @if(request()->has('show_demo'))
                        <a href="{{ route('fleet') }}" class="px-2 py-1 bg-primary text-white border border-primary/20 rounded hover:bg-primary/90 transition-colors text-[10px] font-bold flex items-center gap-1" title="Sembunyikan Demo">
                            <span class="material-symbols-outlined text-[14px]">visibility_off</span> Sembunyikan Demo
                        </a>
                    @else
                        <a href="{{ route('fleet', ['show_demo' => 1]) }}" class="px-2 py-1 bg-surface-container-high text-primary border border-primary/30 rounded hover:bg-primary hover:text-white transition-colors text-[10px] font-bold flex items-center gap-1" title="Tampilkan Demo">
                            <span class="material-symbols-outlined text-[14px]">science</span> Tampilkan Demo
                        </a>
                    @endif
                    <button onclick="document.getElementById('modal-qr-box').classList.remove('hidden')" class="px-2 py-1 bg-primary/10 text-primary border border-primary/20 rounded hover:bg-primary/20 transition-colors text-xs flex items-center gap-1" title="Kelola QR Box">
                        <span class="material-symbols-outlined text-[14px]">qr_code_2</span> QR Box
                    </button>
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
            <x-table class="w-full text-xs">
            @forelse($perjalananAktif as $perjalanan)
                @php
                    $log = $perjalanan->latestLog;
                    $excursion = $perjalanan->getExcursionInfo();
                @endphp
                @php
                    $badgeColor = 'neutral';
                    if ($excursion['status'] === 'Aman') $badgeColor = 'success';
                    elseif ($excursion['status'] === 'Peringatan') $badgeColor = 'warning';
                    elseif ($excursion['status'] === 'Tidak Layak Pakai') $badgeColor = 'error';
                @endphp
                <tr id="driver-card-{{ $perjalanan->id_rute }}" onclick="focusCourier({{ $perjalanan->id_rute }})" class="hover:bg-surface-container-high transition-colors cursor-pointer group">
                    <td class="p-2 border-b border-outline-variant/30">
                        <div class="font-bold text-on-surface truncate">{{ $perjalanan->kurir->nama_lengkap }}</div>
                        <div class="text-[10px] text-on-surface-variant font-mono">{{ $perjalanan->kurir->nomor_kendaraan }}</div>
                    </td>
                    <td class="p-2 border-b border-outline-variant/30 tabular-nums">
                        @if($log)
                            <span class="font-bold text-on-surface" id="temp-val-{{ $perjalanan->id_rute }}">
                                {{ number_format($log->suhu_aktual, 1, ',', '.') }}°C
                            </span>
                        @else
                            <span class="text-on-surface-variant">-</span>
                        @endif
                    </td>
                    <td class="p-2 border-b border-outline-variant/30 text-right">
                        <span id="status-badge-{{ $perjalanan->id_rute }}">
                            <x-badge color="{{ $badgeColor }}" class="{{ $badgeColor !== 'success' ? 'animate-pulse motion-reduce:animate-none' : '' }}">
                                {{ $excursion['status'] === 'Aman' ? 'AMAN' : ($excursion['status'] === 'Peringatan' ? 'PERINGATAN' : 'BAHAYA') }}
                            </x-badge>
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="p-8 text-center text-slate-500">
                        <span class="material-symbols-outlined text-3xl mb-2">local_shipping</span>
                        <div class="text-sm font-bold">Tidak Ada Armada Aktif</div>
                    </td>
                </tr>
            @endforelse
            </x-table>
        </div>
    </aside>

    <!-- Map Container -->
    <main class="flex-1 h-2/3 md:h-full relative z-10 bg-slate-50 " id="map-container">
        <!-- Floating Persistent Summary Overlay (z-[1000]) -->
        <div class="absolute top-4 left-4 z-[1000] flex flex-col gap-2 pointer-events-none">
            <div class="pointer-events-auto flex items-center gap-2 flex-wrap">
                <button onclick="toggleSidebar()" class="w-10 h-10 rounded-full bg-surface-container-high border border-outline-variant/50 shadow-lg flex items-center justify-center text-on-surface hover:bg-surface-container-highest transition-colors cursor-pointer shrink-0" title="Toggle Sidebar">
                    <span id="sidebar-icon" class="material-symbols-outlined text-[20px]">menu_open</span>
                </button>
                <x-card noPadding="true" class="shadow-lg backdrop-blur-md bg-surface/90 border border-outline-variant/30 flex items-center p-2 rounded-full px-4 gap-4 transition-all duration-300">
                    <div class="flex items-center gap-1.5 text-xs font-semibold text-on-surface">
                        <span class="w-2 h-2 rounded-full bg-primary"></span>
                        <span id="summary-aktif">-- Aktif</span>
                    </div>
                    <div class="w-px h-4 bg-outline-variant/50"></div>
                    <div class="flex items-center gap-1.5 text-xs font-semibold text-error">
                        <span class="w-2 h-2 rounded-full bg-error animate-pulse motion-reduce:animate-none"></span>
                        <span id="summary-alert">-- Peringatan</span>
                    </div>
                </x-card>
            </div>
        </div>
        <!-- AI SPATIAL-THERMAL Widget -->
        <div class="absolute top-4 right-4 z-[1000] pointer-events-none">
            <x-card class="pointer-events-auto shadow-2xl backdrop-blur-md bg-surface/95 border border-outline-variant/30 w-72 transition-all duration-300">
                <div class="flex items-center gap-2 mb-4 border-b border-outline-variant/20 pb-2">
                    <span class="material-symbols-outlined text-primary text-[20px]">insights</span>
                    <h3 class="text-xs font-extrabold text-on-surface tracking-widest uppercase">AI SPATIAL-THERMAL</h3>
                </div>

                <div class="space-y-3">
                    <div class="flex items-center justify-between p-2 rounded-lg bg-surface-container-highest">
                        <span class="text-xs font-semibold text-on-surface-variant">Satelit & BMKG:</span>
                        <div class="flex items-center gap-1">
                            <span class="text-sm font-bold text-primary">34°C, 80%</span>
                            <span class="material-symbols-outlined text-error text-[14px]">trending_up</span>
                        </div>
                    </div>
                    <div class="flex items-center justify-between p-2 rounded-lg bg-surface-container-highest">
                        <span class="text-xs font-semibold text-on-surface-variant">Lalu Lintas:</span>
                        <span class="text-xs font-bold text-warning flex items-center gap-1">
                            <span class="w-1.5 h-1.5 rounded-full bg-warning animate-pulse"></span>
                            Padat Tinggi
                        </span>
                    </div>

                    <div class="p-3 rounded-lg border border-outline-variant/50 bg-surface-container mt-2">
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-xs font-semibold text-on-surface-variant">Pilih Armada:</span>
                        </div>
                        <input type="text" id="ai-courier-search" placeholder="Cari nama kurir..." class="w-full bg-background border border-outline-variant/50 rounded p-1.5 text-xs text-on-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none mb-2">
                        <select id="ai-courier-select" class="w-full bg-background border border-outline-variant/50 rounded p-1.5 text-xs text-on-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none mb-3">
                            <option value="" data-name="">-- Pilih Kurir --</option>
                            @foreach($perjalananAktif as $p)
                                <option value="{{ $p->id_rute }}" data-name="{{ strtolower($p->kurir->nama_lengkap) }}">{{ $p->kurir->nama_lengkap }} ({{ $p->lokasi_tujuan }})</option>
                            @endforeach
                        </select>

                        <p class="text-[10px] text-on-surface-variant mb-3 truncate" id="ai-lokasi-text">Pilih armada untuk otomasi...</p>
                        
                        <button onclick="triggerReroute()" class="w-full py-1.5 bg-warning/10 text-warning border border-warning/30 rounded-lg hover:bg-warning/20 transition-colors text-xs font-semibold flex items-center justify-center gap-1 active:scale-[0.98]">
                            Rekomendasikan Rute Aman
                        </button>
                    </div>
                </div>
                
                <p class="text-[9px] text-on-surface-variant mt-3 text-center leading-tight">
                    * AI otomasi rute menggunakan data satelit, BMKG, dan kemacetan secara realtime untuk RS/Puskesmas.
                </p>
            </x-card>
        </div>



        <div class="w-full h-full overflow-hidden">
            <div id="fleet-map" class="w-full h-full"></div>
        </div>

        <!-- Modal Kelola QR Box -->
        <div id="modal-qr-box" class="hidden fixed inset-0 z-[2000] flex items-center justify-center pointer-events-auto bg-black/60 backdrop-blur-sm p-4 transition-opacity">
            <div class="bg-surface rounded-2xl border border-outline-variant/30 shadow-2xl w-full max-w-2xl max-h-[85vh] flex flex-col overflow-hidden">
                <div class="p-lg border-b border-outline-variant/20 flex justify-between items-center bg-surface-container-lowest">
                    <div class="flex items-center gap-sm">
                        <span class="material-symbols-outlined text-primary text-2xl">qr_code_scanner</span>
                        <div>
                            <h3 class="font-headline-sm text-headline-sm font-bold text-on-surface">Manajemen QR Smart Box</h3>
                            <p class="text-xs text-on-surface-variant">Cetak identitas boks fisik untuk proses pairing BLE kurir.</p>
                        </div>
                    </div>
                    <button onclick="document.getElementById('modal-qr-box').classList.add('hidden')" class="w-8 h-8 flex justify-center items-center rounded-full hover:bg-surface-variant text-on-surface-variant transition-colors">
                        <span class="material-symbols-outlined text-[20px]">close</span>
                    </button>
                </div>
                
                <div class="p-lg overflow-y-auto flex-1 bg-surface flex flex-col gap-xl">
                    <!-- Section: Input Manual -->
                    <div class="bg-surface-container-lowest border border-outline-variant/40 rounded-xl p-md">
                        <h4 class="font-bold text-sm text-on-surface mb-2">Generate Box Baru (Manual Input)</h4>
                        <p class="text-xs text-on-surface-variant mb-4">Ketik ID Box berformat <code class="bg-surface-variant px-1 rounded">BOX-XXX</code> jika box tersebut benar-benar baru dan belum pernah masuk ke database perjalanan.</p>
                        <div class="flex gap-2">
                            <input type="text" id="manual-box-id" placeholder="Contoh: BOX-NEW01" class="flex-1 bg-background border border-outline-variant/50 rounded-lg px-3 py-2 text-sm text-on-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all uppercase">
                            <button onclick="printManualQr()" class="px-md py-2 bg-primary text-on-primary font-bold text-sm rounded-lg hover:bg-primary/90 transition-colors flex items-center gap-1 shrink-0 shadow-md shadow-primary/20">
                                <span class="material-symbols-outlined text-[16px]">print</span> Cetak
                            </button>
                        </div>
                        <p id="manual-error" class="text-error text-xs mt-2 hidden">ID Box harus diawali dengan "BOX-".</p>
                    </div>

                    <!-- Section: Daftar Box Terdahulu -->
                    <div>
                        <h4 class="font-bold text-sm text-on-surface mb-3 flex justify-between items-center">
                            Daftar Box Terdaftar
                            <span class="text-[10px] font-normal px-2 py-0.5 rounded bg-surface-variant text-on-surface-variant">{{ count($boxes) }} Box Ditemukan</span>
                        </h4>
                        
                        <div class="border border-outline-variant/30 rounded-xl overflow-hidden">
                            <x-table class="w-full text-xs">
                                <thead>
                                    <tr class="bg-surface-container-low border-b border-outline-variant/30 text-left text-on-surface-variant">
                                        <th class="p-3 font-semibold w-1/3">ID Box</th>
                                        <th class="p-3 font-semibold w-1/3">Kurir Terakhir</th>
                                        <th class="p-3 font-semibold text-right">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($boxes as $b)
                                    <tr class="border-b border-outline-variant/10 hover:bg-surface-container-lowest transition-colors">
                                        <td class="p-3 font-mono font-bold text-primary flex items-center gap-2">
                                            {{ $b->id_box }}
                                            @if($b->is_validated)
                                                <span class="material-symbols-outlined text-success text-[16px]" title="Validated">verified</span>
                                            @endif
                                        </td>
                                        <td class="p-3 text-on-surface">{{ $b->last_kurir ?? '-' }}</td>
                                        <td class="p-3 text-right">
                                            <a href="{{ route('dashboard.qr', $b->id_box) }}" target="_blank" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-surface-variant hover:bg-primary hover:text-on-primary text-on-surface transition-all">
                                                <span class="material-symbols-outlined text-[16px]">print</span>
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3" class="p-6 text-center text-on-surface-variant italic">Belum ada data perjalanan/box.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </x-table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            function printManualQr() {
                const input = document.getElementById('manual-box-id');
                const error = document.getElementById('manual-error');
                let val = input.value.trim().toUpperCase();
                
                if (!val.startsWith('BOX-')) {
                    error.classList.remove('hidden');
                    input.classList.add('border-error');
                    return;
                }
                
                error.classList.add('hidden');
                input.classList.remove('border-error');
                window.open('/dashboard/qr/' + encodeURIComponent(val), '_blank');
            }
        </script>
    </main>
</div>

@endsection

@push('scripts')
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
    let activeRoutes = [];
    let routeLayer = {};
    let pastRouteLayer = {};
    let actualPolylines = {}; // New layer for real GPS history

    // Active Reroutes state initialized from DB
    const activeReroutes = {
        @foreach($perjalananAktif as $p)
            '{{ $p->id_rute }}': {{ $p->isRerouted() ? 'true' : 'false' }},
        @endforeach
    };

    // Alternative Optimized Routes
    const alternativePaths = {};

    // Planned Reference Routes (Palembang)
    const plannedPaths = {};

    // Swap planned path dynamically on load if rerouted
    @foreach($perjalananAktif as $p)
        @if($p->isRerouted())
            if (alternativePaths['{{ $p->lokasi_tujuan }}']) {
                plannedPaths['{{ $p->lokasi_tujuan }}'] = alternativePaths['{{ $p->lokasi_tujuan }}'];
            }
        @endif
    @endforeach

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

    @php
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
                'origin_latitude' => -2.9880,
                'origin_longitude' => 104.7560,
                'dest_latitude' => $p->dest_latitude ?? -2.9865,
                'dest_longitude' => $p->dest_longitude ?? 104.7522,
                'suhu_aktual' => $p->latestLog ? (float)$p->latestLog->suhu_aktual : 5.0,
                'status' => $p->getExcursionInfo()['status']
            ];
        })->toArray();
    @endphp

    activeRoutes = {!! json_encode($activeRoutesData) !!};

    document.addEventListener("DOMContentLoaded", function () {
        map = L.map('fleet-map', {
            zoomControl: false
        }).setView([-2.99, 104.756], 13);

        L.control.zoom({ position: 'bottomright' }).addTo(map);

        let isDarkTheme = document.documentElement.classList.contains('dark');
        let tileUrl = isDarkTheme ? 'https://tile.openstreetmap.org/{z}/{x}/{y}.png' : 'https://tile.openstreetmap.org/{z}/{x}/{y}.png';

        const tileLayer = L.tileLayer(tileUrl, {
            maxZoom: 20,
            attribution: '&copy; CartoDB'
        }).addTo(map);

        window.addEventListener('theme-changed', (e) => {
            isDarkTheme = e.detail.theme === 'dark';
            const newUrl = isDarkTheme ? 'https://tile.openstreetmap.org/{z}/{x}/{y}.png' : 'https://tile.openstreetmap.org/{z}/{x}/{y}.png';
            tileLayer.setUrl(newUrl);
        });

        updateMapData(activeRoutes);
        setInterval(pollLiveLocation, 2000);
    });

    function getPolylineColor(status) {
        if (status === 'Peringatan') return '#ffb95f';
        if (status === 'Tidak Layak Pakai') return '#ffb4ab';
        return '#06b6d4';
    }

    
    async function drawOsrmFutureRoute(ruteId, originLat, originLng, destLat, destLng) {
        try {
            const url = `https://router.project-osrm.org/route/v1/driving/${originLng},${originLat};${destLng},${destLat}?overview=full&geometries=geojson`;
            const response = await fetch(url);
            const data = await response.json();
            if (data.code === 'Ok' && data.routes.length > 0) {
                const coordinates = data.routes[0].geometry.coordinates.map(c => [c[1], c[0]]); // GeoJSON is lng,lat
                if (routeLayer[ruteId]) {
                    routeLayer[ruteId].setLatLngs(coordinates);
                } else {
                    routeLayer[ruteId] = L.polyline(coordinates, { color: '#94a3b8', dashArray: '5, 10', weight: 2, opacity: 0.8 }).addTo(map);
                }
            }
        } catch (e) {
            console.error('OSRM fetch failed', e);
        }
    }
    
    async function createOrUpdateMarker(route) {

        const ruteId = route.id_rute;
        const currentLatLng = [parseFloat(route.latitude), parseFloat(route.longitude)];
        
        // Auto-reroute if temp is abnormal
        if (route.suhu_aktual < 2 || route.suhu_aktual > 8) {
            activeReroutes[ruteId] = true;
        }

        if (route.is_rerouted) {
            activeReroutes[ruteId] = true;
        }

        // Fetch OSRM if not loaded
        
            const originLat = route.origin_latitude || -2.9880;
            const originLng = route.origin_longitude || 104.7560;
            const destLat = route.dest_latitude || currentLatLng[0];
            const destLng = route.dest_longitude || currentLatLng[1];
            
            // --- DRAW DESTINATION MARKER DIRECTLY ---
            if (!window.activeDestMarkers) window.activeDestMarkers = {};
            if (window.activeDestMarkers[ruteId]) {
                window.activeDestMarkers[ruteId].setLatLng([destLat, destLng]);
            } else {
                const hospitalIcon = L.divIcon({
                    html: `<div class="w-6 h-6 rounded-full bg-cyan-900/80 border border-cyan-400 flex items-center justify-center text-cyan-400 shadow-[0_0_12px_rgba(6,182,212,0.4)]">
                                <span class="material-symbols-outlined text-[14px]">local_hospital</span>
                           </div>`,
                    className: '',
                    iconSize: [24, 24],
                    iconAnchor: [12, 12]
                });
                window.activeDestMarkers[ruteId] = L.marker([destLat, destLng], { icon: hospitalIcon }).addTo(map);
                window.activeDestMarkers[ruteId].bindPopup(`<div class='text-xs font-bold text-slate-800 py-0.5'>${route.lokasi_tujuan} (Tujuan)</div>`, { closeButton: false });
            }

            drawOsrmFutureRoute(ruteId, currentLatLng[0], currentLatLng[1], destLat, destLng);
        

        // ----------------------------------------------------
        // Actual Polyline (Real GPS History)
        // ----------------------------------------------------
        if (route.path_history && route.path_history.length > 0 && !actualPolylines[ruteId]) {
            actualPolylines[ruteId] = L.polyline(route.path_history, {
                color: '#3b82f6', // Solid bright blue
                weight: 4.5,
                opacity: 0.9,
                dashArray: null
            }).addTo(map);
        } else if (actualPolylines[ruteId]) {
            actualPolylines[ruteId].addLatLng(currentLatLng);
        }

        let iconColor = 'text-primary';
        let bgRing = 'bg-primary/20';
        let tempColor = 'text-primary';
        
        if (route.status === 'Peringatan') {
            iconColor = 'text-warning';
            bgRing = 'bg-warning/20';
            tempColor = 'text-warning';
        } else if (route.status === 'Tidak Layak Pakai') {
            iconColor = 'text-error';
            bgRing = 'bg-error/20';
            tempColor = 'text-error';
        }

        const customIcon = L.divIcon({
            className: 'custom-fleet-marker',
            html: `
                <div class="relative flex items-center justify-center">
                    <div class="absolute w-12 h-12 rounded-full ${bgRing} animate-ping"></div>
                    <div class="absolute w-8 h-8 rounded-full bg-surface shadow-lg border-2 border-surface flex items-center justify-center">
                        <span class="material-symbols-outlined ${iconColor} text-[18px]">local_shipping</span>
                    </div>
                </div>
            `,
            iconSize: [32, 32],
            iconAnchor: [16, 16]
        });

        const popupContent = `
            <div class="p-1 min-w-[200px]">
                <div class="flex items-center gap-2 mb-2 border-b border-outline-variant/30 pb-2">
                    <span class="material-symbols-outlined ${iconColor} text-[20px]">package</span>
                    <div>
                        <div class="font-extrabold text-xs text-on-surface tracking-wider">${route.id_box}</div>
                        <div class="text-[10px] font-mono text-on-surface-variant">${route.nama_kargo}</div>
                    </div>
                </div>
                <p class="flex items-center gap-1 text-slate-400">
                    <span class="material-symbols-outlined text-[14px] text-primary">person</span>
                    Kurir: <strong class="text-slate-250 font-semibold">${route.nama_kurir}</strong>
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
                <div class="p-1 px-2 border border-red-500/30 bg-red-500/10 text-red-500 font-bold text-[9px] rounded uppercase tracking-wider animate-pulse flex items-center gap-1 mt-2">
                    <span class="material-symbols-outlined text-[12px]">warning</span> Deviasi Rute > 300m
                </div>` : ''}
            </div>
        `;

        if (markers[ruteId]) {
            const oldLatLng = markers[ruteId].getLatLng();
            if (oldLatLng.lat !== currentLatLng[0] || oldLatLng.lng !== currentLatLng[1]) {
                animateMarker(markers[ruteId], oldLatLng, currentLatLng, 1000);
            }
            markers[ruteId].setIcon(customIcon);
            markers[ruteId].setPopupContent(popupContent);
        } else {
            let marker = L.marker(currentLatLng, { icon: customIcon }).addTo(map);
            marker.bindPopup(popupContent, { maxWidth: 280, closeButton: false });
            marker.on('mouseover', function() { this.openPopup(); });
            marker.on('mouseout', function() { this.closePopup(); });
            markers[ruteId] = marker;
        }
    }

    function updateMapData(routesList) {
        let bounds = [];
        // Important: Update activeRoutes globally so search/widget can use the latest array!
        activeRoutes = routesList;
        
        const currentActiveIds = new Set();

        routesList.forEach(route => {
            currentActiveIds.add(route.id_rute);
            if (route.latitude && route.longitude) {
                let currentLatLng = [route.latitude, route.longitude];
                bounds.push(currentLatLng);
                createOrUpdateMarker(route); // Will asynchronously fetch OSRM and draw
            }
        });

        // Cleanup Inactive Markers/Polylines
        Object.keys(markers).forEach(ruteId => {
            const id = parseInt(ruteId);
            if (!currentActiveIds.has(id)) {
                if (markers[ruteId]) {
                    map.removeLayer(markers[ruteId]);
                    delete markers[ruteId];
                }
                if (routeLayer[ruteId]) {
                    map.removeLayer(routeLayer[ruteId]);
                    delete routeLayer[ruteId];
                }
                if (pastRouteLayer[ruteId]) {
                    map.removeLayer(pastRouteLayer[ruteId]);
                    delete pastRouteLayer[ruteId];
                }
                if (actualPolylines[ruteId]) {
                    if (actualPolylines[ruteId] !== 'loading') {
                        map.removeLayer(actualPolylines[ruteId]);
                    }
                    delete actualPolylines[ruteId];
                }
            }
        });

        // Update the dropdown selector to remove inactive routes
        const courierSelect = document.getElementById('ai-courier-select');
        if (courierSelect) {
            Array.from(courierSelect.options).forEach(option => {
                if (option.value !== "") {
                    const id = parseInt(option.value);
                    if (!currentActiveIds.has(id)) {
                        option.style.display = 'none';
                        if (courierSelect.value === option.value) {
                            courierSelect.value = "";
                            document.getElementById('ai-lokasi-text').textContent = 'Pilih armada untuk otomasi...';
                        }
                    } else {
                        option.style.display = '';
                    }
                }
            });
        }

        if (bounds.length > 0 && initialLoad) {
            map.fitBounds(bounds, { padding: [50, 50], maxZoom: 15 });
            initialLoad = false;
        }
    }

    let isInitialFetch = true;

    function pollLiveLocation() {
        let url = '{{ route("fleet.live") }}';
        if (isInitialFetch) {
            url += '?initial_load=true';
            isInitialFetch = false;
        }

        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('show_demo')) {
            url += (url.includes('?') ? '&' : '?') + 'show_demo=1';
        }

        fetch(url)
            .then(response => response.json())
            .then(res => {
                if (res.success && res.data) {
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
                            origin_latitude: parseFloat(route.origin_latitude),
                            origin_longitude: parseFloat(route.origin_longitude),
                            dest_latitude: parseFloat(route.dest_latitude),
                            dest_longitude: parseFloat(route.dest_longitude),
                            suhu_aktual: parseFloat(route.suhu_aktual),
                            status: route.excursion_status,
                            is_rerouted: route.is_rerouted
                        };
                    }));

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
        // Target all driver rows in the sidebar table
        let rows = document.querySelectorAll('#drivers-list-container tr[id^="driver-card-"]');

        rows.forEach(row => {
            let text = row.innerText.toLowerCase();
            row.style.display = text.includes(filter) ? '' : 'none';
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
@endpush
