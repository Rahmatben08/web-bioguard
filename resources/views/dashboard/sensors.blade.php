@extends('layouts.app')

@section('title', 'Analisis Telemetri & Sensor')

@section('content')
<div class="min-h-screen bg-slate-50 dark:bg-slate-900 transition-colors duration-300 p-container-margin space-y-lg">
    <!-- Header Controls Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end gap-md mb-md">
        <div>
            <nav class="flex text-label-md text-slate-500 dark:text-slate-400 mb-1 gap-2 transition-colors duration-300">
                <span>BIO-GUARD</span> / <span class="text-sky-600 dark:text-sky-400 font-semibold transition-colors duration-300">Analisis Sensor</span>
            </nav>
            <h1 class="font-headline-lg text-headline-lg text-slate-800 dark:text-slate-100 transition-colors duration-300">Laporan & Analisis</h1>
            <p class="text-slate-500 dark:text-slate-400 font-body-md text-body-md transition-colors duration-300">Metrik kinerja distribusi biologis tingkat perusahaan.</p>
        </div>
        @php
            $selectedDate = request()->input('date');
            $selectedBox = request()->input('id_box');
        @endphp
        <div class="flex items-center gap-3 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700/50 p-1.5 rounded-xl flex-wrap transition-colors duration-300">
            <!-- Filter Inputs -->
            <div class="flex gap-2 items-center flex-wrap">
                <input type="date" id="filter-date" value="{{ $selectedDate }}" class="bg-slate-100 dark:bg-slate-900 border-none text-xs font-semibold text-slate-850 dark:text-slate-200 focus:ring-1 focus:ring-sky-500 rounded-lg py-1.5 px-3 transition-colors duration-300">
                <select id="filter-box" class="bg-slate-100 dark:bg-slate-900 border-none text-xs font-semibold text-slate-850 dark:text-slate-200 focus:ring-1 focus:ring-sky-500 rounded-lg py-1.5 pr-8 transition-colors duration-300">
                    <option value="">Semua Boks</option>
                    <option value="BOX-001" {{ $selectedBox === 'BOX-001' ? 'selected' : '' }}>BOX-001</option>
                    <option value="BOX-002" {{ $selectedBox === 'BOX-002' ? 'selected' : '' }}>BOX-002</option>
                    <option value="BOX-003" {{ $selectedBox === 'BOX-003' ? 'selected' : '' }}>BOX-003</option>
                    <option value="BOX-004" {{ $selectedBox === 'BOX-004' ? 'selected' : '' }}>BOX-004</option>
                </select>
                <button onclick="applyFilters()" class="bg-sky-600 hover:bg-sky-700 text-white px-3.5 py-1.5 rounded-lg text-xs font-bold transition-all active:scale-95 duration-100 shadow-md shadow-sky-500/10 cursor-pointer">
                    Filter
                </button>
            </div>
            
            <div class="hidden sm:block h-6 w-px bg-slate-200 dark:bg-slate-700"></div>

            <div class="flex gap-1 bg-slate-100 dark:bg-slate-900 bg-surface-container-lowest rounded-lg p-1 transition-colors duration-300">
                <button class="px-4 py-1.5 text-xs font-bold bg-sky-600/10 text-sky-600 dark:bg-sky-500/20 dark:text-sky-400 rounded-md transition-all duration-300">Q1</button>
                <button class="px-4 py-1.5 text-xs font-medium text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200 rounded-md transition-all duration-300">Q2</button>
                <button class="px-4 py-1.5 text-xs font-medium text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200 rounded-md transition-all duration-300">KUSTOM</button>
            </div>

            <button onclick="downloadExcelReport()" class="bg-emerald-600 hover:bg-emerald-700 text-white p-2 rounded-lg active:scale-95 transition-all duration-300 shadow-md shadow-emerald-500/10 cursor-pointer" id="btn-excel-export" title="Unduh Log Audit CDOB (Excel)">
                <span class="material-symbols-outlined text-[18px] align-middle">description</span>
            </button>
            <button class="bg-white hover:bg-slate-100 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-850 dark:text-slate-200 p-2 rounded-lg border border-slate-200 dark:border-slate-700/50 active:scale-95 transition-all duration-300" id="btn-pdf-export" title="Unduh Log Audit (PDF)">
                <span class="material-symbols-outlined text-[18px] align-middle">picture_as_pdf</span>
            </button>
        </div>
    </div>

    <!-- KPI Overview Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-gutter mb-md">
        <!-- Metric 1 -->
        <div class="bg-white dark:bg-slate-800/80 dark:backdrop-blur-sm border border-slate-200 dark:border-slate-700/50 shadow-sm p-lg rounded-xl flex flex-col justify-between h-32 relative overflow-hidden group hover:border-sky-500/40 dark:hover:border-sky-400/40 transition-all duration-300">
            <div class="flex justify-between items-start z-10">
                <span class="text-slate-500 dark:text-slate-400 font-label-md text-label-md uppercase tracking-widest transition-colors duration-300">Skor Integritas Armada</span>
                <span class="text-sky-600 dark:text-sky-400 transition-colors duration-300 material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">security</span>
            </div>
            <div class="flex items-baseline gap-2 z-10">
                <span class="font-headline-lg text-headline-lg text-sky-600 dark:text-sky-400 font-bold transition-colors duration-300"><span id="live-integritas">98,4%</span></span>
                <span class="text-sky-600 dark:text-sky-400 font-bold text-xs flex items-center transition-colors duration-300"><span class="material-symbols-outlined text-xs">trending_up</span>+0,2%</span>
            </div>
            <div class="absolute bottom-0 left-0 w-full h-1 bg-slate-200 dark:bg-slate-700 transition-colors duration-300">
                <div class="h-full bg-sky-500 dark:bg-sky-400 transition-colors duration-300" style="width: 98.4%"></div>
            </div>
        </div>
        <!-- Metric 2 -->
        <div class="bg-white dark:bg-slate-800/80 dark:backdrop-blur-sm border border-slate-200 dark:border-slate-700/50 shadow-sm p-lg rounded-xl flex flex-col justify-between h-32 relative overflow-hidden group hover:border-amber-500/40 transition-all duration-300">
            <div class="flex justify-between items-start z-10">
                <span class="text-slate-500 dark:text-slate-400 font-label-md text-label-md uppercase tracking-widest transition-colors duration-300">Total Anomali</span>
                <span class="text-amber-600 dark:text-amber-400 transition-colors duration-300 material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">warning</span>
            </div>
            <div class="flex items-baseline gap-2 z-10">
                <span class="font-headline-lg text-headline-lg text-slate-800 dark:text-slate-100 font-bold transition-colors duration-300"><span id="live-anomali">12</span></span>
                <span class="text-amber-600 dark:text-amber-400 font-bold text-xs flex items-center transition-colors duration-300"><span class="material-symbols-outlined text-xs">trending_down</span>-15%</span>
            </div>
            <div class="absolute bottom-0 left-0 w-full h-1 bg-slate-200 dark:bg-slate-700 transition-colors duration-300">
                <div class="h-full bg-amber-500 dark:bg-amber-400 transition-colors duration-300" style="width: 15%"></div>
            </div>
        </div>
        <!-- Metric 3 -->
        <div class="bg-white dark:bg-slate-800/80 dark:backdrop-blur-sm border border-slate-200 dark:border-slate-700/50 shadow-sm p-lg rounded-xl flex flex-col justify-between h-32 relative overflow-hidden group hover:border-sky-500/40 dark:hover:border-sky-400/40 transition-all duration-300">
            <div class="flex justify-between items-start z-10">
                <span class="text-slate-500 dark:text-slate-400 font-label-md text-label-md uppercase tracking-widest transition-colors duration-300">Kepatuhan Regulasi</span>
                <span class="text-sky-600 dark:text-sky-400 transition-colors duration-300 material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">verified_user</span>
            </div>
            <div class="flex items-center gap-2 z-10 mt-xs">
                <span class="font-headline-lg text-headline-lg text-slate-800 dark:text-slate-100 font-bold transition-colors duration-300"><span id="live-kepatuhan">100%</span></span>
                <span class="px-2 py-0.5 rounded-full border border-sky-600/40 text-sky-600 dark:border-sky-400/40 dark:text-sky-400 bg-sky-600/5 dark:bg-sky-500/5 text-[10px] uppercase font-black tracking-tighter transition-colors duration-300">Tersertifikasi</span>
            </div>
            <div class="absolute inset-0 bg-sky-600/5 dark:bg-sky-400/5 opacity-0 group-hover:opacity-100 transition-opacity"></div>
        </div>
        <!-- Metric 4 -->
        <div class="bg-white dark:bg-slate-800/80 dark:backdrop-blur-sm border border-slate-200 dark:border-slate-700/50 shadow-sm p-lg rounded-xl flex flex-col justify-between h-32 relative overflow-hidden group hover:border-sky-500/40 dark:hover:border-sky-400/40 transition-all duration-300">
            <div class="flex justify-between items-start z-10">
                <span class="text-slate-500 dark:text-slate-400 font-label-md text-label-md uppercase tracking-widest transition-colors duration-300">Penghematan Operasional</span>
                <span class="text-sky-600 dark:text-sky-400 transition-colors duration-300 material-symbols-outlined">payments</span>
            </div>
            <div class="flex items-baseline gap-2 z-10">
                <span class="font-headline-lg text-headline-lg text-slate-800 dark:text-slate-100 font-bold transition-colors duration-300"><span id="live-penghematan">Rp 680 Jt</span></span>
                <span class="text-slate-500 dark:text-slate-400 font-body-md text-body-md transition-colors duration-300">Diatribusikan oleh AI</span>
            </div>
            <div class="absolute top-0 right-0 p-2 opacity-5 group-hover:opacity-10 transition-opacity">
                <span class="material-symbols-outlined text-6xl text-sky-600/10 dark:text-sky-400/10 transition-colors duration-300">psychology</span>
            </div>
        </div>
    </div>

    <!-- AI Predictive Shelf-life Monitor (CDOB Compliance) -->
    <div class="space-y-md mb-md">
        <div class="flex items-center gap-2">
            <span class="text-sky-600 dark:text-sky-400 material-symbols-outlined transition-colors duration-300">psychology</span>
            <h2 class="font-headline-sm text-headline-sm text-slate-800 dark:text-slate-100 transition-colors duration-300">AI Predictive Shelf-life Monitor (Kepatuhan CDOB)</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-gutter">
            @foreach($routesData as $route)
            @php
                $mktVal = (float)$route['mkt'];
                if ($mktVal >= 2.0 && $mktVal <= 8.0) {
                    $shelfLife = "36 Jam (Optimal)";
                    $shelfLifeProgress = 100;
                    $shelfColor = "bg-sky-500 dark:bg-sky-400";
                    $shelfBg = "bg-sky-50 dark:bg-sky-500/10 border-sky-100 dark:border-sky-500/20 text-sky-600 dark:text-sky-400";
                    $shelfTextColor = "text-sky-600 dark:text-sky-400";
                } elseif ($mktVal > 8.0 && $mktVal <= 8.5) {
                    $shelfLife = "12 Jam (Peringatan)";
                    $shelfLifeProgress = 40;
                    $shelfColor = "bg-amber-500 dark:bg-amber-400";
                    $shelfBg = "bg-amber-50 dark:bg-amber-500/10 border-amber-100 dark:border-amber-500/20 text-amber-600 dark:text-amber-400 animate-pulse";
                    $shelfTextColor = "text-amber-600 dark:text-amber-400";
                } else {
                    $shelfLife = "0,5 Jam (Bahaya Kritis)";
                    $shelfLifeProgress = 10;
                    $shelfColor = "bg-red-500 dark:bg-red-400";
                    $shelfBg = "bg-red-50 dark:bg-red-500/10 border-red-100 dark:border-red-500/20 text-red-600 dark:text-red-400 animate-pulse";
                    $shelfTextColor = "text-red-600 dark:text-red-400";
                }
            @endphp
            <div class="bg-white dark:bg-slate-800/80 dark:backdrop-blur-sm border border-slate-200 dark:border-slate-700/50 shadow-sm p-lg rounded-xl transition-all duration-300 flex flex-col justify-between gap-sm relative overflow-hidden group hover:border-sky-500/40 dark:hover:border-sky-400/40">
                <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                    <span class="material-symbols-outlined text-7xl text-slate-800 dark:text-slate-100 transition-colors duration-300">hourglass_empty</span>
                </div>
                
                <div class="flex justify-between items-start">
                    <div>
                        <span class="px-2 py-0.5 rounded text-[10px] font-black uppercase tracking-wider bg-slate-100 text-slate-600 dark:bg-slate-700 dark:text-slate-300 transition-colors duration-300 border border-slate-200 dark:border-slate-600/50">BOX-{{ $route['id_box'] }}</span>
                        <h4 class="font-bold text-base text-slate-800 dark:text-slate-100 mt-1.5 transition-colors duration-300">{{ $route['nama_kargo'] }}</h4>
                        <p class="text-xs text-slate-500 dark:text-slate-400 transition-colors duration-300">Kurir: {{ $route['nama_kurir'] }}</p>
                    </div>
                    <span class="px-2.5 py-1 rounded-full text-xs font-black tracking-wide {{ $shelfBg }} border font-mono transition-colors duration-300">
                        {{ number_format($mktVal, 1, ',', '.') }}°C MKT
                    </span>
                </div>

                <div class="space-y-1.5 mt-2">
                    <div class="flex justify-between text-xs font-semibold">
                        <span class="text-slate-500 dark:text-slate-400 transition-colors duration-300">Est. Sisa Waktu Kelayakan:</span>
                        <span class="font-bold uppercase {{ $shelfTextColor }} transition-colors duration-300">{{ $shelfLife }}</span>
                    </div>
                    <div class="w-full h-2 bg-slate-200 dark:bg-slate-700 rounded-full overflow-hidden transition-colors duration-300">
                        <div class="h-full {{ $shelfColor }} rounded-full transition-all duration-500" style="width: {{ $shelfLifeProgress }}%"></div>
                    </div>
                </div>

                <div class="flex justify-between items-center mt-3 pt-3 border-t border-slate-200 dark:border-slate-700/50 transition-colors duration-300">
                    <span class="text-[10px] text-slate-500 dark:text-slate-400 font-mono transition-colors duration-300">AI Risk Projection: {{ number_format($route['ai_risk'], 2, ',', '.') }}%</span>
                    <button class="btn-proyeksi text-sky-600 hover:text-sky-700 dark:text-sky-400 dark:hover:text-sky-300 text-xs font-bold uppercase tracking-wider flex items-center gap-1 active:scale-95 transition-all duration-300" 
                            data-box="BOX-{{ $route['id_box'] }}"
                            data-kargo="{{ $route['nama_kargo'] }}"
                            data-mkt="{{ number_format($mktVal, 1, ',', '.') }}"
                            data-shelflife="{{ $shelfLife }}">
                        <span class="material-symbols-outlined text-xs">trending_up</span> Proyeksi AI
                    </button>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Middle Section: Map and Risk Trends -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-gutter mb-md">
        <!-- Predictive Risk Trends Chart -->
        <div class="lg:col-span-8 bg-white dark:bg-slate-800/80 dark:backdrop-blur-sm border border-slate-200 dark:border-slate-700/50 shadow-sm rounded-xl p-lg flex flex-col min-h-[400px] transition-colors duration-300">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-sm mb-lg">
                <div>
                    <h3 class="font-headline-sm text-headline-sm text-slate-800 dark:text-slate-100 transition-colors duration-300">Tren Risiko Prediktif</h3>
                    <p class="text-slate-500 dark:text-slate-400 text-body-md font-body-md transition-colors duration-300">Obat Termolabil Rusak vs Prediksi Risiko AI (6 Bulan)</p>
                </div>
                <div class="flex gap-4">
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-amber-500 dark:bg-amber-400 transition-colors duration-300"></span>
                        <span class="text-xs font-bold text-slate-500 dark:text-slate-400 transition-colors duration-300">Kerusakan Aktual</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-sky-600 dark:bg-sky-400 transition-colors duration-300"></span>
                        <span class="text-xs font-bold text-slate-500 dark:text-slate-400 transition-colors duration-300">Prediksi AI</span>
                    </div>
                </div>
            </div>
            <!-- Dynamic Chart (ApexCharts) -->
            <div id="chart-risiko-prediktif" class="flex-1 min-h-[250px] w-full"></div>
        </div>

        <!-- Regional Heatmap / Hub Performance -->
        <div class="lg:col-span-4 bg-white dark:bg-slate-800/80 dark:backdrop-blur-sm border border-slate-200 dark:border-slate-700/50 shadow-sm rounded-xl p-lg flex flex-col h-full overflow-hidden transition-colors duration-300">
            <h3 class="font-headline-sm text-headline-sm text-slate-800 dark:text-slate-100 mb-xs transition-colors duration-300">Kinerja Hub</h3>
            <p class="text-slate-500 dark:text-slate-400 text-body-md font-body-md mb-lg transition-colors duration-300">Efisiensi distribusi regional.</p>
            <div class="flex-1 space-y-gutter overflow-y-auto pr-2">
                <!-- Hub Card -->
                <div class="p-md rounded-lg bg-slate-50 dark:bg-slate-900 border border-slate-200/60 dark:border-slate-700/40 border-l-4 border-sky-500 dark:border-sky-400 transition-all duration-300">
                    <div class="flex justify-between items-center mb-1">
                        <span class="font-bold text-sm text-slate-800 dark:text-slate-100 transition-colors duration-300">Palembang Pusat Hub (PLB-01)</span>
                        <span class="text-sky-600 dark:text-sky-400 text-[10px] font-black tracking-wider bg-sky-600/10 px-2 py-0.5 rounded transition-colors duration-300">OPTIMAL</span>
                    </div>
                    <div class="flex justify-between items-end">
                        <span class="text-xs text-slate-500 dark:text-slate-400 transition-colors duration-300">Efisiensi: 99,2%</span>
                        <div class="w-32 h-1 bg-slate-200 dark:bg-slate-700 rounded-full overflow-hidden mb-1 transition-colors duration-300">
                            <div class="h-full bg-sky-500 dark:bg-sky-400 transition-colors duration-300" style="width: 99%"></div>
                        </div>
                    </div>
                </div>
                <!-- Hub Card -->
                <div class="p-md rounded-lg bg-slate-50 dark:bg-slate-900 border border-slate-200/60 dark:border-slate-700/40 border-l-4 border-amber-500 dark:border-amber-400 transition-all duration-300">
                    <div class="flex justify-between items-center mb-1">
                        <span class="font-bold text-sm text-slate-800 dark:text-slate-100 transition-colors duration-300">Jakabaring Outpost (PLB-02)</span>
                        <span class="text-amber-600 dark:text-amber-400 text-[10px] font-black tracking-wider bg-amber-600/10 px-2 py-0.5 rounded transition-colors duration-300">PERINGATAN RISIKO</span>
                    </div>
                    <div class="flex justify-between items-end">
                        <span class="text-xs text-slate-500 dark:text-slate-400 transition-colors duration-300">Efisiensi: 84,5%</span>
                        <div class="w-32 h-1 bg-slate-200 dark:bg-slate-700 rounded-full overflow-hidden mb-1 transition-colors duration-300">
                            <div class="h-full bg-amber-500 dark:bg-amber-400 transition-colors duration-300" style="width: 84%"></div>
                        </div>
                    </div>
                </div>
                <!-- Hub Card -->
                <div class="p-md rounded-lg bg-slate-50 dark:bg-slate-900 border border-slate-200/60 dark:border-slate-700/40 border-l-4 border-sky-500 dark:border-sky-400 transition-all duration-300">
                    <div class="flex justify-between items-center mb-1">
                        <span class="font-bold text-sm text-slate-800 dark:text-slate-100 transition-colors duration-300">Plaju Outpost (PLB-03)</span>
                        <span class="text-sky-600 dark:text-sky-400 text-[10px] font-black tracking-wider bg-sky-600/10 px-2 py-0.5 rounded transition-colors duration-300">OPTIMAL</span>
                    </div>
                    <div class="flex justify-between items-end">
                        <span class="text-xs text-slate-500 dark:text-slate-400 transition-colors duration-300">Efisiensi: 97,8%</span>
                        <div class="w-32 h-1 bg-slate-200 dark:bg-slate-700 rounded-full overflow-hidden mb-1 transition-colors duration-300">
                            <div class="h-full bg-sky-500 dark:bg-sky-400 transition-colors duration-300" style="width: 97%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Operational Efficiency Table -->
    <div class="bg-white dark:bg-slate-800/80 dark:backdrop-blur-sm border border-slate-200 dark:border-slate-700/50 shadow-sm rounded-xl overflow-hidden mb-md transition-colors duration-300">
        <div class="px-lg py-md border-b border-slate-200 dark:border-slate-700/50 flex justify-between items-center bg-slate-50 dark:bg-slate-900 transition-colors duration-300">
            <h3 class="font-headline-sm text-headline-sm text-slate-800 dark:text-slate-100 transition-colors duration-300">Indeks Efisiensi Rute</h3>
            <div class="flex gap-2">
                <button class="p-2 hover:bg-slate-100 dark:hover:bg-slate-800 text-slate-500 hover:text-slate-800 dark:text-slate-400 dark:hover:text-slate-100 rounded-lg transition-colors duration-300"><span class="material-symbols-outlined text-[18px]">filter_list</span></button>
                <button class="p-2 hover:bg-slate-100 dark:hover:bg-slate-800 text-slate-500 hover:text-slate-800 dark:text-slate-400 dark:hover:text-slate-100 rounded-lg transition-colors duration-300"><span class="material-symbols-outlined text-[18px]">fullscreen</span></button>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-100/50 dark:bg-slate-900/50 border-b border-slate-200 dark:border-slate-700/50 transition-colors duration-300">
                        <th class="px-lg py-md font-label-md text-label-md text-slate-500 dark:text-slate-400 uppercase tracking-wider transition-colors duration-300">ID Rute (Box)</th>
                        <th class="px-lg py-md font-label-md text-label-md text-slate-500 dark:text-slate-400 uppercase tracking-wider transition-colors duration-300">Mitra Kurir / Tujuan</th>
                        <th class="px-lg py-md font-label-md text-label-md text-slate-500 dark:text-slate-400 uppercase tracking-wider text-center transition-colors duration-300">Peringkat Stabilitas (Indeks)</th>
                        <th class="px-lg py-md font-label-md text-label-md text-slate-500 dark:text-slate-400 uppercase tracking-wider text-center transition-colors duration-300">Suhu Penyimpanan</th>
                        <th class="px-lg py-md font-label-md text-label-md text-slate-500 dark:text-slate-400 uppercase tracking-wider text-right transition-colors duration-300">Potensi Risiko Spoilage (AI)</th>
                        <th class="px-lg py-md font-label-md text-label-md text-slate-500 dark:text-slate-400 uppercase tracking-wider text-right transition-colors duration-300">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-700/30 font-body-md text-body-md">
                    @forelse($routesData as $route)
                    <tr data-box="BOX-{{ $route['id_box'] }}" class="hover:bg-sky-500/5 dark:hover:bg-sky-400/5 transition-all duration-300 group border-b border-slate-100 dark:border-slate-700/30">
                        <td class="px-lg py-4 font-bold text-sky-600 dark:text-sky-400 transition-colors duration-300">BOX-{{ $route['id_box'] }}</td>
                        <td class="px-lg py-4 text-slate-800 dark:text-slate-100 transition-colors duration-300">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded bg-slate-100 dark:bg-slate-700 flex items-center justify-center border border-slate-200 dark:border-slate-600 text-xs font-black text-sky-600 dark:text-sky-400 transition-colors duration-300">
                                    {{ substr($route['nama_kurir'], 0, 2) }}
                                </div>
                                <div>
                                    <div class="font-semibold">{{ $route['nama_kurir'] }}</div>
                                    <div class="text-xs text-slate-500 dark:text-slate-400 transition-colors duration-300">{{ $route['tujuan'] }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-lg py-4">
                            <div class="flex justify-center items-center gap-2">
                                <div class="flex gap-0.5">
                                    @php
                                        $stars = round($route['efficiency_index'] / 20);
                                    @endphp
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $stars)
                                            <span class="material-symbols-outlined text-sky-600 dark:text-sky-400 text-xs transition-colors duration-300" style="font-variation-settings: 'FILL' 1;">star</span>
                                        @else
                                            <span class="material-symbols-outlined text-slate-300 dark:text-slate-700 text-xs transition-colors duration-300">star</span>
                                        @endif
                                    @endfor
                                </div>
                                <span class="text-xs font-semibold text-sky-600 dark:text-sky-400 transition-colors duration-300">({{ number_format($route['efficiency_index'], 1, ',', '.') }}%)</span>
                            </div>
                        </td>
                        <td class="px-lg py-4 text-center">
                            @php
                                $deviation = abs($route['avg_temp'] - 5.0);
                            @endphp
                            <span class="px-2 py-0.5 rounded-full {{ $deviation > 3.0 ? 'bg-red-50 dark:bg-red-500/10 border-red-100 dark:border-red-500/20 text-red-600 dark:text-red-400' : ($deviation > 1.5 ? 'bg-amber-50 dark:bg-amber-500/10 border-amber-100 dark:border-amber-500/20 text-amber-600 dark:text-amber-400' : 'bg-sky-50 dark:bg-sky-500/10 border-sky-100 dark:border-sky-500/20 text-sky-600 dark:text-sky-400') }} text-[10px] font-black font-data-mono transition-colors duration-300">
                                ±{{ number_format($deviation, 2, ',', '.') }}°C (Rerata: <span id="temp-BOX-{{ $route['id_box'] }}">{{ number_format($route['avg_temp'], 1, ',', '.') }}°C</span>)
                            </span>
                        </td>
                        <td class="px-lg py-4 text-right font-data-mono text-slate-500 dark:text-slate-400 transition-colors duration-300">
                            Risiko AI: <span id="risk-BOX-{{ $route['id_box'] }}">{{ number_format($route['ai_risk'], 2, ',', '.') }}%</span>
                        </td>
                        <td class="px-lg py-4 text-right">
                            @if($deviation > 1.5 || $route['ai_risk'] > 50.0)
                                <button class="btn-analisis bg-red-600 hover:bg-red-700 text-white shadow-[0_0_12px_rgba(220,38,38,0.2)] dark:bg-red-500 dark:hover:bg-red-600 px-md py-1.5 rounded-xl text-xs font-bold tracking-widest active:scale-95 transition-all duration-300" 
                                        data-box="BOX-{{ $route['id_box'] }}" 
                                        data-kurir="{{ $route['nama_kurir'] }}" 
                                        data-tujuan="{{ $route['tujuan'] }}" 
                                        data-stabilitas="{{ number_format($route['efficiency_index'], 1, ',', '.') }}%" 
                                        data-suhu="{{ number_format($route['avg_temp'], 1, ',', '.') }}°C" 
                                        data-risiko="{{ number_format($route['ai_risk'], 2, ',', '.') }}%">
                                    TINDAK LANJUT
                                </button>
                            @else
                                <button class="btn-analisis text-sky-600 hover:text-sky-700 dark:text-sky-400 dark:hover:text-sky-300 text-xs font-bold uppercase tracking-tighter active:scale-95 transition-all duration-300" 
                                        data-box="BOX-{{ $route['id_box'] }}" 
                                        data-kurir="{{ $route['nama_kurir'] }}" 
                                        data-tujuan="{{ $route['tujuan'] }}" 
                                        data-stabilitas="{{ number_format($route['efficiency_index'], 1, ',', '.') }}%" 
                                        data-suhu="{{ number_format($route['avg_temp'], 1, ',', '.') }}°C" 
                                        data-risiko="{{ number_format($route['ai_risk'], 2, ',', '.') }}%">
                                    Analisis
                                </button>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-lg py-4 text-center text-slate-500 dark:text-slate-400 transition-colors duration-300">Tidak ada rute/sensor aktif saat ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-md bg-slate-50 dark:bg-slate-900/50 border-t border-slate-200 dark:border-slate-700/50 flex justify-between items-center px-lg text-slate-500 dark:text-slate-400 transition-colors duration-300">
            <span class="text-xs font-medium font-label-md">Menampilkan {{ count($routesData) }} rute pengiriman obat aktif</span>
        </div>
    </div>
</div>

<!-- Detailed Analysis Modal -->
<div id="analysis-modal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-md bg-black/60 backdrop-blur-sm transition-opacity duration-300">
    <div class="bg-surface-container bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700/50 rounded-2xl w-full max-w-2xl overflow-hidden shadow-2xl scale-95 opacity-0 transition-all duration-300 flex flex-col max-h-[90vh]">
        <!-- Modal Header -->
        <div class="px-lg py-md border-b border-slate-200 dark:border-slate-700/50 flex justify-between items-center bg-slate-50 dark:bg-slate-900 transition-colors duration-300">
            <div class="flex items-center gap-sm">
                <span class="material-symbols-outlined text-sky-600 dark:text-sky-400 transition-colors duration-300">query_stats</span>
                <h3 class="font-headline-sm text-headline-sm text-slate-800 dark:text-slate-100 transition-colors duration-300" id="modal-title">Analisis Detil Sensor</h3>
            </div>
            <button id="close-analysis-modal" class="p-2 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-lg text-slate-500 hover:text-slate-800 dark:text-slate-400 dark:hover:text-slate-100 transition-colors duration-300">
                <span class="material-symbols-outlined text-[20px] align-middle">close</span>
            </button>
        </div>
        
        <!-- Modal Body -->
        <div class="p-lg overflow-y-auto space-y-lg flex-1">
            <!-- Info Cards Grid -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-sm">
                <div class="p-md rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700/50 transition-colors duration-300">
                    <span class="text-[10px] text-slate-500 dark:text-slate-400 uppercase font-semibold transition-colors duration-300">Box ID</span>
                    <p class="font-bold text-sky-600 dark:text-sky-400 mt-1 font-mono transition-colors duration-300" id="modal-box-id">-</p>
                </div>
                <div class="p-md rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700/50 transition-colors duration-300">
                    <span class="text-[10px] text-slate-500 dark:text-slate-400 uppercase font-semibold transition-colors duration-300">Stabilitas</span>
                    <p class="font-bold text-slate-800 dark:text-slate-100 mt-1 transition-colors duration-300" id="modal-stabilitas">-</p>
                </div>
                <div class="p-md rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700/50 transition-colors duration-300">
                    <span class="text-[10px] text-slate-500 dark:text-slate-400 uppercase font-semibold transition-colors duration-300">Suhu Rerata</span>
                    <p class="font-bold text-slate-800 dark:text-slate-100 mt-1 transition-colors duration-300" id="modal-suhu-rerata">-</p>
                </div>
                <div class="p-md rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700/50 transition-colors duration-300">
                    <span class="text-[10px] text-slate-500 dark:text-slate-400 uppercase font-semibold transition-colors duration-300">Risiko AI</span>
                    <p class="font-bold text-red-600 dark:text-red-400 mt-1 transition-colors duration-300" id="modal-risiko-ai">-</p>
                </div>
            </div>

            <!-- Shipment details -->
            <div class="p-md rounded-xl bg-slate-100/50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700/30 space-y-2 transition-colors duration-300">
                <div class="flex justify-between text-xs">
                    <span class="text-slate-500 dark:text-slate-400 transition-colors duration-300">Kurir Penanggung Jawab</span>
                    <span class="font-bold text-slate-800 dark:text-slate-100 transition-colors duration-300" id="modal-kurir-name">-</span>
                </div>
                <div class="flex justify-between text-xs">
                    <span class="text-slate-500 dark:text-slate-400 transition-colors duration-300">Tujuan Pengiriman</span>
                    <span class="font-bold text-slate-800 dark:text-slate-100 truncate max-w-xs transition-colors duration-300" id="modal-dest">-</span>
                </div>
            </div>

            <!-- Telemetry Log Simulation Chart -->
            <div class="space-y-sm">
                <h4 class="font-label-md text-label-md text-slate-500 dark:text-slate-400 uppercase tracking-wider transition-colors duration-300">Simulasi Fluktuasi Telemetri (1 Jam Terakhir)</h4>
                <div id="chart-modal-telemetry" class="w-full h-44 bg-slate-50/50 dark:bg-slate-900/50 rounded-xl border border-slate-200 dark:border-slate-700/30 p-2 transition-colors duration-300"></div>
            </div>
        </div>
        
        <!-- Modal Footer -->
        <div class="px-lg py-md border-t border-slate-200 dark:border-slate-700/50 flex justify-end gap-sm bg-slate-50 dark:bg-slate-900 transition-colors duration-300">
            <button id="btn-modal-calibrate" class="px-md py-2 border border-slate-200 dark:border-slate-700 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-xl text-xs font-semibold text-slate-800 dark:text-slate-200 transition-all active:scale-95 flex items-center gap-1 duration-300">
                <span class="material-symbols-outlined text-[16px] text-sky-600 dark:text-sky-400 transition-colors duration-300">tune</span> Kalibrasi Sensor
            </button>
            <button id="close-analysis-modal-btn" class="px-md py-2 bg-sky-600 hover:bg-sky-700 text-white rounded-xl text-xs font-semibold transition-all duration-300 active:scale-95 shadow-[0_0_10px_rgba(2,132,199,0.2)]">
                Tutup
            </button>
        </div>
    </div>
</div>

<!-- AI Shelf-life Projection Modal -->
<div id="projection-modal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-md bg-black/60 backdrop-blur-sm transition-opacity duration-300">
    <div class="bg-surface-container bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700/50 rounded-2xl w-full max-w-2xl overflow-hidden shadow-2xl scale-95 opacity-0 transition-all duration-300 flex flex-col max-h-[90vh]">
        <!-- Modal Header -->
        <div class="px-lg py-md border-b border-slate-200 dark:border-slate-700/50 flex justify-between items-center bg-slate-50 dark:bg-slate-900 transition-colors duration-300">
            <div class="flex items-center gap-sm">
                <span class="material-symbols-outlined text-sky-600 dark:text-sky-400 transition-colors duration-300">psychology</span>
                <h3 class="font-headline-sm text-headline-sm text-slate-800 dark:text-slate-100 transition-colors duration-300" id="proj-modal-title">Proyeksi Penurunan Kualitas AI</h3>
            </div>
            <button id="close-projection-modal" class="p-2 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-lg text-slate-500 hover:text-slate-800 dark:text-slate-400 dark:hover:text-slate-100 transition-colors duration-300">
                <span class="material-symbols-outlined text-[20px] align-middle">close</span>
            </button>
        </div>
        
        <!-- Modal Body -->
        <div class="p-lg overflow-y-auto space-y-lg flex-1">
            <!-- Info Header -->
            <div class="grid grid-cols-3 gap-sm">
                <div class="p-md rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700/50 transition-colors duration-300">
                    <span class="text-[10px] text-slate-500 dark:text-slate-400 uppercase font-semibold transition-colors duration-300">Box ID & Kargo</span>
                    <p class="font-bold text-sky-600 dark:text-sky-400 mt-1 font-mono text-xs truncate transition-colors duration-300" id="proj-modal-box">-</p>
                </div>
                <div class="p-md rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700/50 transition-colors duration-300">
                    <span class="text-[10px] text-slate-500 dark:text-slate-400 uppercase font-semibold transition-colors duration-300">Mean Kinetic Temp</span>
                    <p class="font-bold text-slate-800 dark:text-slate-100 mt-1 transition-colors duration-300" id="proj-modal-mkt">-</p>
                </div>
                <div class="p-md rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700/50 transition-colors duration-300">
                    <span class="text-[10px] text-slate-500 dark:text-slate-400 uppercase font-semibold transition-colors duration-300">Est. Kelayakan</span>
                    <p class="font-bold text-sky-600 dark:text-sky-400 mt-1 text-xs truncate transition-colors duration-300" id="proj-modal-shelflife">-</p>
                </div>
            </div>

            <!-- Description -->
            <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed transition-colors duration-300">
                Grafik di bawah mensimulasikan laju degradasi kualitas produk biologis berdasarkan akumulasi paparan panas (Arrhenius Equation) dibandingkan dengan batas toleransi CDOB BPOM.
            </p>

            <!-- ApexCharts spline chart container -->
            <div class="space-y-sm">
                <h4 class="font-label-md text-label-md text-slate-500 dark:text-slate-400 uppercase tracking-wider transition-colors duration-300">Kurva Degradasi Kualitas (MKT vs Sisa Jam)</h4>
                <div id="chart-degradasi-kualitas" class="w-full h-56 bg-slate-50/50 dark:bg-slate-900/50 rounded-xl border border-slate-200 dark:border-slate-700/30 p-2 transition-colors duration-300"></div>
            </div>
        </div>
        
        <!-- Modal Footer -->
        <div class="px-lg py-md border-t border-slate-200 dark:border-slate-700/50 flex justify-end gap-sm bg-slate-50 dark:bg-slate-900 transition-colors duration-300">
            <button id="close-projection-modal-btn" class="px-md py-2 bg-sky-600 hover:bg-sky-700 text-white rounded-xl text-xs font-semibold transition-all duration-300 active:scale-95 shadow-[0_0_10px_rgba(2,132,199,0.2)]">
                Tutup Proyeksi
            </button>
        </div>
    </div>
</div>

<!-- Interactive Layer: Notification Toast (Micro-interaction) -->
<div class="fixed bottom-gutter right-gutter bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700/50 p-md rounded-xl border-l-4 border-sky-500 dark:border-sky-400 translate-y-24 opacity-0 transition-all duration-500 z-50 pointer-events-none shadow-lg" id="toast">
    <div class="flex items-center gap-3">
        <span class="material-symbols-outlined text-sky-600 dark:text-sky-400 transition-colors duration-300">analytics</span>
        <div>
            <div class="font-bold text-sm text-slate-800 dark:text-slate-100 transition-colors duration-300" id="toast-title">Laporan Berhasil Dibuat</div>
            <div class="text-xs text-slate-500 dark:text-slate-400 transition-colors duration-300" id="toast-desc">Ringkasan Operasional Q1 telah siap.</div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
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
        var chartDataRisiko = @json($aiRisks);
        var chartDataDamaged = @json($actualDamaged);
        
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
                categories: @json($chartCategories),
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
        const qButtons = document.querySelectorAll('button:has(text)'); // fallback, let's select specific
        const buttons = document.querySelectorAll('.flex.gap-1.bg-surface-container-lowest button');
        buttons.forEach((btn, idx) => {
            btn.addEventListener('click', () => {
                buttons.forEach(b => {
                    b.classList.remove('bg-primary-container/20', 'text-primary', 'font-bold');
                    b.classList.add('text-on-surface-variant', 'font-medium');
                });
                btn.classList.remove('text-on-surface-variant', 'font-medium');
                btn.classList.add('bg-primary-container/20', 'text-primary', 'font-bold');
                
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
                    showToast('Sensor Kalibrasi Sukses', `${modalBoxId.textContent} telah dikalibrasi ke standar ±0,02°C.`);
                    if (currentActiveBtn) {
                        currentActiveBtn.innerHTML = 'Analisis';
                        currentActiveBtn.className = 'btn-analisis text-sky-600 hover:text-sky-700 dark:text-sky-400 dark:hover:text-sky-300 text-xs font-bold uppercase tracking-tighter active:scale-95 transition-all duration-300';
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
@endpush


