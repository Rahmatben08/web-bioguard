@extends('layouts.app')

@section('title', 'Manajemen Inventaris Cold Storage Faskes')

@section('content')
<div class="min-h-screen bg-slate-50 dark:bg-slate-900 transition-colors duration-300 p-container-margin space-y-lg">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end gap-md mb-md">
        <div>
            <nav class="flex text-label-md text-slate-500 dark:text-slate-400 mb-1 gap-2 transition-colors duration-300">
                <span>BIO-GUARD</span> / <span class="text-sky-600 dark:text-sky-400 font-semibold transition-colors duration-300">Inventaris Cold Storage</span>
            </nav>
            <h1 class="font-headline-lg text-headline-lg text-slate-800 dark:text-slate-100 transition-colors duration-300">Inventaris & Cold Chain Hub</h1>
            <p class="text-slate-500 dark:text-slate-400 font-body-md text-body-md transition-colors duration-300">Manajemen kapasitas penyimpanan, suhu kulkas farmasi, dan distribusi vaksin di 60 faskes Palembang.</p>
        </div>
    </div>

    <!-- Bento Grid Stats Section -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-gutter">
        <!-- Card 1: Total Hubs -->
        <div class="lg:col-span-3 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700/50 p-6 rounded-2xl flex flex-col justify-between shadow-sm transition-all duration-300 hover:shadow-md hover:border-slate-300 dark:hover:border-slate-600">
            <div class="flex justify-between items-start">
                <div class="p-2.5 bg-sky-50 dark:bg-sky-950/40 rounded-xl text-sky-600 dark:text-sky-400">
                    <span class="material-symbols-outlined text-[24px]">warehouse</span>
                </div>
                <span class="text-[10px] font-bold text-green-500 bg-green-50 dark:bg-green-950/30 px-2 py-0.5 rounded-full flex items-center gap-1">
                    <span class="w-1 h-1 rounded-full bg-green-500 animate-ping"></span> 100% Online
                </span>
            </div>
            <div class="mt-4">
                <span class="text-slate-400 dark:text-slate-400 text-xs font-semibold uppercase tracking-wider">Total Hub Faskes</span>
                <h3 class="text-3xl font-extrabold text-slate-850 dark:text-slate-100 font-mono-data mt-1">{{ $totalHubs }}</h3>
                <p class="text-slate-500 dark:text-slate-400 text-xs mt-1">10 RS & 50 Puskesmas</p>
            </div>
        </div>

        <!-- Card 2: Average Temperature -->
        <div class="lg:col-span-3 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700/50 p-6 rounded-2xl flex flex-col justify-between shadow-sm transition-all duration-300 hover:shadow-md hover:border-slate-300 dark:hover:border-slate-600">
            <div class="flex justify-between items-start">
                <div class="p-2.5 bg-teal-50 dark:bg-teal-950/40 rounded-xl text-teal-600 dark:text-teal-400">
                    <span class="material-symbols-outlined text-[24px]">thermostat</span>
                </div>
                <div class="w-20 h-6" id="sparkline-temp"></div>
            </div>
            <div class="mt-4">
                <span class="text-slate-400 dark:text-slate-400 text-xs font-semibold uppercase tracking-wider">Rata-rata Suhu Kulkas</span>
                <h3 class="text-3xl font-extrabold text-slate-850 dark:text-slate-100 font-mono-data mt-1">{{ number_format($avgTemp, 1, ',', '.') }}°C</h3>
                <p class="text-slate-500 dark:text-slate-400 text-xs mt-1">Standar CDOB: 2,0°C - 8,0°C</p>
            </div>
        </div>

        <!-- Card 3: Cold Chain Excursions -->
        <div class="lg:col-span-3 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700/50 p-6 rounded-2xl flex flex-col justify-between shadow-sm transition-all duration-300 hover:shadow-md hover:border-slate-300 dark:hover:border-slate-600">
            <div class="flex justify-between items-start">
                <div class="p-2.5 bg-rose-50 dark:bg-rose-950/40 rounded-xl text-rose-600 dark:text-rose-400">
                    <span class="material-symbols-outlined text-[24px]">warning_amber</span>
                </div>
                @if($alertCount > 0)
                    <span class="text-[10px] font-bold text-rose-500 bg-rose-50 dark:bg-rose-950/30 px-2 py-0.5 rounded-full animate-pulse">
                        TINDAKAN DIBUTUHKAN
                    </span>
                @else
                    <span class="text-[10px] font-bold text-emerald-500 bg-emerald-50 dark:bg-emerald-950/30 px-2 py-0.5 rounded-full">
                        SISTEM AMAN
                    </span>
                @endif
            </div>
            <div class="mt-4">
                <span class="text-slate-400 dark:text-slate-400 text-xs font-semibold uppercase tracking-wider">Anomali Suhu Cold Chain</span>
                <h3 class="text-3xl font-extrabold @if($alertCount > 0) text-rose-500 dark:text-rose-400 @else text-slate-850 dark:text-slate-100 @endif font-mono-data mt-1">
                    {{ $alertCount }} <span class="text-sm font-semibold text-slate-400 dark:text-slate-500">Hub Terdeteksi</span>
                </h3>
                <p class="text-slate-500 dark:text-slate-400 text-xs mt-1">Suhu di luar ambang batas aman</p>
            </div>
        </div>

        <!-- Card 4: Total Capacity Utilized -->
        <div class="lg:col-span-3 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700/50 p-6 rounded-2xl flex flex-col justify-between shadow-sm transition-all duration-300 hover:shadow-md hover:border-slate-300 dark:hover:border-slate-600">
            <div class="flex justify-between items-start">
                <div class="p-2.5 bg-amber-50 dark:bg-amber-950/40 rounded-xl text-amber-600 dark:text-amber-400">
                    <span class="material-symbols-outlined text-[24px]">donut_large</span>
                </div>
                <span class="text-xs font-bold text-slate-700 dark:text-slate-300 bg-slate-100 dark:bg-slate-700 px-2.5 py-1 rounded-lg">
                    {{ $avgCapacityUtil }}% terisi
                </span>
            </div>
            <div class="mt-4">
                <span class="text-slate-400 dark:text-slate-400 text-xs font-semibold uppercase tracking-wider">Kapasitas Kulkas Total</span>
                <h3 class="text-3xl font-extrabold text-slate-850 dark:text-slate-100 font-mono-data mt-1">
                    {{ number_format($totalVaccines, 0, ',', '.') }}<span class="text-sm font-semibold text-slate-400 dark:text-slate-500"> / {{ number_format($totalCapacity, 0, ',', '.') }} Vial</span>
                </h3>
                <p class="text-slate-500 dark:text-slate-400 text-xs mt-1">Akumulasi vial obat & vaksin</p>
            </div>
        </div>

        <!-- Card 5: Vaccine Breakdown Stocks List -->
        <div class="lg:col-span-12 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700/50 p-6 rounded-2xl shadow-sm transition-colors duration-300">
            <h4 class="text-sm font-bold text-slate-800 dark:text-slate-200 mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-[18px]">inventory</span> Ringkasan Stok Vaksin & Insulin Nasional Terdistribusi (Palembang)
            </h4>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                <!-- Pfizer -->
                <div class="p-4 bg-slate-50 dark:bg-slate-900 rounded-xl border border-slate-200/50 dark:border-slate-700/40">
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-xs font-semibold text-slate-500 dark:text-slate-400">PFIZER VACCINE</span>
                        <span class="text-[9px] font-bold text-sky-600 dark:text-sky-400 bg-sky-50 dark:bg-sky-950/40 px-2 py-0.5 rounded-full">mRNA</span>
                    </div>
                    <div class="text-xl font-black text-slate-850 dark:text-slate-100 font-mono-data">{{ number_format($totalPfizer, 0, ',', '.') }} <span class="text-xs font-medium text-slate-500">Vial</span></div>
                    <div class="w-full bg-slate-200 dark:bg-slate-700 h-1.5 rounded-full mt-2 overflow-hidden">
                        <div class="bg-sky-500 h-1.5 rounded-full" style="width: {{ ($totalPfizer / $totalVaccines) * 100 }}%"></div>
                    </div>
                </div>

                <!-- Polio -->
                <div class="p-4 bg-slate-50 dark:bg-slate-900 rounded-xl border border-slate-200/50 dark:border-slate-700/40">
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-xs font-semibold text-slate-500 dark:text-slate-400">POLIO VACCINE (bOPV)</span>
                        <span class="text-[9px] font-bold text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-950/40 px-2 py-0.5 rounded-full">OPV</span>
                    </div>
                    <div class="text-xl font-black text-slate-850 dark:text-slate-100 font-mono-data">{{ number_format($totalPolio, 0, ',', '.') }} <span class="text-xs font-medium text-slate-500">Vial</span></div>
                    <div class="w-full bg-slate-200 dark:bg-slate-700 h-1.5 rounded-full mt-2 overflow-hidden">
                        <div class="bg-indigo-500 h-1.5 rounded-full" style="width: {{ ($totalPolio / $totalVaccines) * 100 }}%"></div>
                    </div>
                </div>

                <!-- Sinovac -->
                <div class="p-4 bg-slate-50 dark:bg-slate-900 rounded-xl border border-slate-200/50 dark:border-slate-700/40">
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-xs font-semibold text-slate-500 dark:text-slate-400">SINOVAC VACCINE</span>
                        <span class="text-[9px] font-bold text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-950/40 px-2 py-0.5 rounded-full">Killed</span>
                    </div>
                    <div class="text-xl font-black text-slate-850 dark:text-slate-100 font-mono-data">{{ number_format($totalSinovac, 0, ',', '.') }} <span class="text-xs font-medium text-slate-500">Vial</span></div>
                    <div class="w-full bg-slate-200 dark:bg-slate-700 h-1.5 rounded-full mt-2 overflow-hidden">
                        <div class="bg-emerald-500 h-1.5 rounded-full" style="width: {{ ($totalSinovac / $totalVaccines) * 100 }}%"></div>
                    </div>
                </div>

                <!-- Insulin -->
                <div class="p-4 bg-slate-50 dark:bg-slate-900 rounded-xl border border-slate-200/50 dark:border-slate-700/40">
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-xs font-semibold text-slate-500 dark:text-slate-400">INSULIN HORMON</span>
                        <span class="text-[9px] font-bold text-amber-600 dark:text-amber-400 bg-amber-50 dark:bg-amber-950/40 px-2 py-0.5 rounded-full">Thermolabile</span>
                    </div>
                    <div class="text-xl font-black text-slate-850 dark:text-slate-100 font-mono-data">{{ number_format($totalInsulin, 0, ',', '.') }} <span class="text-xs font-medium text-slate-500">Pena/Vial</span></div>
                    <div class="w-full bg-slate-200 dark:bg-slate-700 h-1.5 rounded-full mt-2 overflow-hidden">
                        <div class="bg-amber-500 h-1.5 rounded-full" style="width: {{ ($totalInsulin / $totalVaccines) * 100 }}%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and Table Card -->
    <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700/50 rounded-2xl shadow-sm overflow-hidden transition-colors duration-300">
        <!-- Control Header -->
        <div class="p-6 border-b border-slate-200 dark:border-slate-700/50 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-slate-50/50 dark:bg-slate-800/40">
            <h3 class="font-headline-sm text-headline-sm text-slate-800 dark:text-slate-100 flex items-center gap-2">
                <span class="material-symbols-outlined text-[20px] text-sky-500">list_alt</span> Direktori Kepatuhan Cold Storage
            </h3>
            
            <!-- Filters Controls Block -->
            <form action="{{ route('inventory') }}" method="GET" class="flex flex-wrap items-center gap-3 w-full md:w-auto">
                <!-- Search -->
                <div class="relative w-full sm:w-60">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-[18px] text-slate-400">search</span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama faskes/alat..." 
                           class="w-full pl-9 pr-4 py-1.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl text-xs font-semibold text-slate-700 dark:text-slate-200 placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500 transition-all duration-300">
                </div>

                <!-- Kecamatan Filter -->
                <select name="kecamatan" onchange="this.form.submit()" 
                        class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-xs font-semibold text-slate-700 dark:text-slate-200 rounded-xl py-1.5 pl-3 pr-8 focus:ring-1 focus:ring-sky-500 focus:border-sky-500 transition-all duration-300">
                    <option value="Semua">Semua Wilayah</option>
                    @foreach($allKecamatan as $kec)
                        <option value="{{ $kec }}" {{ request('kecamatan') === $kec ? 'selected' : '' }}>{{ $kec }}</option>
                    @endforeach
                </select>

                <!-- Status Filter -->
                <select name="status" onchange="this.form.submit()" 
                        class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-xs font-semibold text-slate-700 dark:text-slate-200 rounded-xl py-1.5 pl-3 pr-8 focus:ring-1 focus:ring-sky-500 focus:border-sky-500 transition-all duration-300">
                    <option value="Semua">Semua Status</option>
                    <option value="Aman" {{ request('status') === 'Aman' ? 'selected' : '' }}>Aman (2°C - 8°C)</option>
                    <option value="Bahaya" {{ request('status') === 'Bahaya' ? 'selected' : '' }}>Anomali / Bahaya</option>
                </select>

                <!-- Sort option -->
                <select name="sort" onchange="this.form.submit()" 
                        class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-xs font-semibold text-slate-700 dark:text-slate-200 rounded-xl py-1.5 pl-3 pr-8 focus:ring-1 focus:ring-sky-500 focus:border-sky-500 transition-all duration-300">
                    <option value="nama" {{ request('sort') === 'nama' ? 'selected' : '' }}>Urut: Nama Faskes</option>
                    <option value="suhu" {{ request('sort') === 'suhu' ? 'selected' : '' }}>Urut: Suhu Aktual</option>
                    <option value="kapasitas" {{ request('sort') === 'kapasitas' ? 'selected' : '' }}>Urut: Utilitasi Ruang</option>
                    <option value="stok_total" {{ request('sort') === 'stok_total' ? 'selected' : '' }}>Urut: Total Stok</option>
                </select>

                <!-- Reset Button -->
                @if(request()->anyFilled(['search', 'kecamatan', 'status', 'sort']))
                    <a href="{{ route('inventory') }}" class="text-rose-500 hover:text-rose-600 dark:hover:text-rose-400 p-2 hover:bg-rose-500/10 rounded-xl text-xs font-bold transition-all active:scale-95 duration-100 flex items-center gap-1 cursor-pointer">
                        <span class="material-symbols-outlined text-[16px]">close</span> Reset
                    </a>
                @endif
            </form>
        </div>

        <!-- Table Container -->
        <div class="overflow-x-auto">
            <table class="w-full min-w-[1000px] border-collapse text-left">
                <thead>
                    <tr class="border-b border-slate-200 dark:border-slate-700/50 bg-slate-50/50 dark:bg-slate-900/30 text-slate-400 dark:text-slate-400 text-[10px] font-bold uppercase tracking-wider transition-colors duration-300">
                        <th class="py-4 px-6">ID / Nama Hub Faskes</th>
                        <th class="py-4 px-6">Model Kulkas</th>
                        <th class="py-4 px-6 text-center">Suhu Aktual</th>
                        <th class="py-4 px-6 w-[180px]">Kapasitas Terisi</th>
                        <th class="py-4 px-6 text-center">Rincian Stok (Vial)</th>
                        <th class="py-4 px-6">Last Sync</th>
                        <th class="py-4 px-6 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-700/30 text-xs text-slate-700 dark:text-slate-350 transition-all duration-300">
                    @forelse($hubsPaginated as $hub)
                        <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/30 group transition-colors duration-200">
                            <!-- Faskes Name & Region -->
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3">
                                    <div class="p-2.5 @if($hub['jenis'] === 'Rumah Sakit') bg-purple-500/10 text-purple-600 dark:text-purple-400 @else bg-teal-500/10 text-teal-600 dark:text-teal-400 @endif rounded-xl group-hover:scale-105 transition-transform duration-200">
                                        <span class="material-symbols-outlined text-[18px]">
                                            @if($hub['jenis'] === 'Rumah Sakit') local_hospital @else medical_services @endif
                                        </span>
                                    </div>
                                    <div>
                                        <span class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest font-mono">{{ $hub['id'] }}</span>
                                        <h4 class="font-bold text-slate-800 dark:text-slate-200 text-sm group-hover:text-sky-600 dark:group-hover:text-sky-400 transition-colors duration-200 mt-0.5">{{ $hub['nama'] }}</h4>
                                        <span class="text-[10px] text-slate-500 dark:text-slate-400 mt-1 inline-flex items-center gap-1">
                                            <span class="material-symbols-outlined text-[11px]">location_on</span> {{ $hub['kecamatan'] }}
                                        </span>
                                    </div>
                                </div>
                            </td>

                            <!-- Device model -->
                            <td class="py-4 px-6 font-medium">
                                <span class="font-semibold text-slate-850 dark:text-slate-200">{{ $hub['kulkas_farmasi'] }}</span>
                                <div class="text-[10px] text-slate-400 dark:text-slate-500 font-mono mt-0.5">Kapasitas: {{ number_format($hub['kapasitas_total'], 0, ',', '.') }} Vial</div>
                            </td>

                            <!-- Temp Badge -->
                            <td class="py-4 px-6 text-center">
                                @if($hub['status'] === 'Aman')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold text-emerald-600 bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200/50 dark:border-emerald-900/30">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        {{ number_format($hub['suhu_aktual'], 1, ',', '.') }}°C
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold text-rose-600 bg-rose-50 dark:bg-rose-950/40 border border-rose-200/50 dark:border-rose-900/30 animate-pulse">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500 animate-ping"></span>
                                        {{ number_format($hub['suhu_aktual'], 1, ',', '.') }}°C
                                    </span>
                                @endif
                            </td>

                            <!-- Capacity progress -->
                            <td class="py-4 px-6">
                                <div class="flex justify-between items-center text-[10px] font-bold text-slate-500 dark:text-slate-400 mb-1 font-mono">
                                    <span>{{ number_format($hub['stok_total'], 0, ',', '.') }} Vial</span>
                                    <span>{{ $hub['kapasitas_persen'] }}%</span>
                                </div>
                                <div class="w-full bg-slate-100 dark:bg-slate-700/60 h-2 rounded-full overflow-hidden border border-slate-200/30 dark:border-slate-700/30">
                                    <div class="h-full rounded-full transition-all duration-500 @if($hub['kapasitas_persen'] > 90) bg-rose-500 @elseif($hub['kapasitas_persen'] > 75) bg-amber-500 @else bg-sky-500 @endif" style="width: {{ $hub['kapasitas_persen'] }}%"></div>
                                </div>
                            </td>

                            <!-- Stock details -->
                            <td class="py-4 px-6">
                                <div class="flex flex-wrap gap-1.5 justify-center">
                                    <span class="px-2 py-0.5 rounded bg-slate-100 dark:bg-slate-700/60 text-slate-600 dark:text-slate-300 font-semibold font-mono text-[10px]" title="Pfizer">
                                        P: <span class="font-bold text-sky-600 dark:text-sky-400">{{ number_format($hub['stok']['pfizer'], 0, ',', '.') }}</span>
                                    </span>
                                    <span class="px-2 py-0.5 rounded bg-slate-100 dark:bg-slate-700/60 text-slate-600 dark:text-slate-300 font-semibold font-mono text-[10px]" title="Polio">
                                        O: <span class="font-bold text-indigo-600 dark:text-indigo-400">{{ number_format($hub['stok']['polio'], 0, ',', '.') }}</span>
                                    </span>
                                    <span class="px-2 py-0.5 rounded bg-slate-100 dark:bg-slate-700/60 text-slate-600 dark:text-slate-300 font-semibold font-mono text-[10px]" title="Sinovac">
                                        S: <span class="font-bold text-emerald-600 dark:text-emerald-400">{{ number_format($hub['stok']['sinovac'], 0, ',', '.') }}</span>
                                    </span>
                                    <span class="px-2 py-0.5 rounded bg-slate-100 dark:bg-slate-700/60 text-slate-600 dark:text-slate-300 font-semibold font-mono text-[10px]" title="Insulin">
                                        I: <span class="font-bold text-amber-600 dark:text-amber-400">{{ number_format($hub['stok']['insulin'], 0, ',', '.') }}</span>
                                    </span>
                                </div>
                            </td>

                            <!-- Sync time -->
                            <td class="py-4 px-6 text-slate-500 dark:text-slate-400 font-semibold font-mono text-[11px]">
                                {{ $hub['last_sync'] }}
                            </td>

                            <!-- Actions -->
                            <td class="py-4 px-6 text-center">
                                <button type="button" onclick="openDetailsModal({{ json_encode($hub) }})" 
                                        class="bg-sky-600 hover:bg-sky-700 dark:bg-sky-600/90 dark:hover:bg-sky-600 text-white font-bold px-3 py-1.5 rounded-lg active:scale-95 transition-all text-[11px] shadow-sm shadow-sky-500/10 cursor-pointer">
                                    Detail
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-slate-400 dark:text-slate-500">
                                <span class="material-symbols-outlined text-[36px] mb-2 block">database_off</span>
                                Tidak ada data hub faskes yang sesuai dengan filter pencarian.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Footer -->
        <div class="px-6 py-4 border-t border-slate-200 dark:border-slate-700/50 bg-slate-50/50 dark:bg-slate-900/30 flex justify-between items-center transition-colors duration-300">
            <span class="text-xs font-semibold text-slate-500 dark:text-slate-400">
                Menampilkan {{ $hubsPaginated->firstItem() ?? 0 }} - {{ $hubsPaginated->lastItem() ?? 0 }} dari {{ $hubsPaginated->total() }} Hub Faskes
            </span>
            <div class="flex gap-2">
                @if($hubsPaginated->onFirstPage())
                    <button class="px-3.5 py-1.5 bg-slate-100 dark:bg-slate-800 text-slate-400 dark:text-slate-500 rounded-lg text-xs font-bold cursor-not-allowed" disabled>
                        Sebelumnya
                    </button>
                @else
                    <a href="{{ $hubsPaginated->previousPageUrl() }}" class="px-3.5 py-1.5 bg-white dark:bg-slate-700 border border-slate-200 dark:border-slate-600 text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-600/70 rounded-lg text-xs font-bold transition-all duration-200 active:scale-95">
                        Sebelumnya
                    </a>
                @endif

                @if($hubsPaginated->hasMorePages())
                    <a href="{{ $hubsPaginated->nextPageUrl() }}" class="px-3.5 py-1.5 bg-white dark:bg-slate-700 border border-slate-200 dark:border-slate-600 text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-600/70 rounded-lg text-xs font-bold transition-all duration-200 active:scale-95">
                        Berikutnya
                    </a>
                @else
                    <button class="px-3.5 py-1.5 bg-slate-100 dark:bg-slate-800 text-slate-400 dark:text-slate-500 rounded-lg text-xs font-bold cursor-not-allowed" disabled>
                        Berikutnya
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Detailed Analytics Modal (Glassmorphism Modal UI) -->
<div id="details-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/60 backdrop-blur-sm transition-opacity duration-300 opacity-0 hidden">
    <div class="relative w-full max-w-3xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700/80 rounded-2xl shadow-2xl p-6 md:p-8 transform scale-95 opacity-0 transition-all duration-300 ease-out max-h-[90vh] overflow-y-auto">
        <!-- Close button -->
        <button onclick="closeDetailsModal()" class="absolute right-4 top-4 p-2 rounded-xl text-slate-400 hover:text-slate-850 dark:hover:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-700/60 transition-colors duration-200 cursor-pointer">
            <span class="material-symbols-outlined text-[20px]">close</span>
        </button>

        <!-- Modal Header -->
        <div class="flex items-start gap-4 pb-4 border-b border-slate-200 dark:border-slate-700/60">
            <div id="modal-header-icon" class="p-3 text-white rounded-xl">
                <span class="material-symbols-outlined text-[24px]" id="modal-faskes-icon">local_hospital</span>
            </div>
            <div>
                <span class="text-[10px] font-bold text-sky-500 dark:text-sky-400 uppercase tracking-widest font-mono" id="modal-faskes-id">HOSP-001</span>
                <h3 class="text-xl font-bold text-slate-850 dark:text-slate-100 mt-0.5" id="modal-faskes-name">Nama Hub Faskes</h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 flex items-center gap-1 mt-1">
                    <span class="material-symbols-outlined text-[12px]">location_on</span> <span id="modal-faskes-kecamatan">Kecamatan</span>
                </p>
            </div>
        </div>

        <!-- Modal Content Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 py-6">
            <!-- Left panel: Telemetry stats & Device info -->
            <div class="space-y-4">
                <h4 class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Telemetri & Status Kulkas</h4>
                
                <div class="p-4 bg-slate-50 dark:bg-slate-900 border border-slate-200/50 dark:border-slate-700/40 rounded-xl flex items-center justify-between">
                    <div>
                        <span class="text-xs text-slate-500 dark:text-slate-400">Temperatur Terkini</span>
                        <div class="text-3xl font-black text-slate-850 dark:text-slate-100 font-mono-data mt-1" id="modal-suhu-aktual">4,2°C</div>
                    </div>
                    <span class="px-3 py-1.5 rounded-full text-xs font-bold" id="modal-status-badge">Aman</span>
                </div>

                <div class="p-4 bg-slate-50 dark:bg-slate-900 border border-slate-200/50 dark:border-slate-700/40 rounded-xl space-y-2">
                    <div class="flex justify-between items-center text-xs">
                        <span class="text-slate-500 dark:text-slate-400">Alat Pemantau IoT</span>
                        <span class="font-bold text-slate-800 dark:text-slate-200" id="modal-kulkas-model">B Medical TCW 4000</span>
                    </div>
                    <div class="flex justify-between items-center text-xs">
                        <span class="text-slate-500 dark:text-slate-400">Kapasitas Penyimpanan</span>
                        <span class="font-bold text-slate-800 dark:text-slate-200 font-mono" id="modal-kulkas-capacity">15.000 Vial</span>
                    </div>
                    <div class="flex justify-between items-center text-xs">
                        <span class="text-slate-500 dark:text-slate-400">Rata-rata Utilitasi</span>
                        <span class="font-bold text-slate-800 dark:text-slate-200 font-mono" id="modal-kulkas-util">54,5%</span>
                    </div>
                    <div class="flex justify-between items-center text-xs">
                        <span class="text-slate-500 dark:text-slate-400">Pembaruan Terakhir</span>
                        <span class="font-bold text-slate-800 dark:text-slate-200 font-mono" id="modal-last-sync">3 menit lalu</span>
                    </div>
                </div>
            </div>

            <!-- Right panel: Stock allocations -->
            <div class="space-y-4">
                <h4 class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Alokasi Stok Saat Ini</h4>
                
                <div class="space-y-3 p-4 bg-slate-50 dark:bg-slate-900 border border-slate-200/50 dark:border-slate-700/40 rounded-xl">
                    <!-- Pfizer -->
                    <div>
                        <div class="flex justify-between text-xs mb-1">
                            <span class="font-semibold text-slate-700 dark:text-slate-350">Pfizer (mRNA)</span>
                            <span class="font-bold text-slate-850 dark:text-slate-100 font-mono" id="modal-stock-pfizer">1.250 Vial</span>
                        </div>
                        <div class="w-full bg-slate-200 dark:bg-slate-700 h-1.5 rounded-full overflow-hidden">
                            <div class="bg-sky-500 h-1.5 rounded-full" id="modal-progress-pfizer" style="width: 25%"></div>
                        </div>
                    </div>

                    <!-- Polio -->
                    <div>
                        <div class="flex justify-between text-xs mb-1">
                            <span class="font-semibold text-slate-700 dark:text-slate-350">Polio (bOPV)</span>
                            <span class="font-bold text-slate-850 dark:text-slate-100 font-mono" id="modal-stock-polio">2.400 Vial</span>
                        </div>
                        <div class="w-full bg-slate-200 dark:bg-slate-700 h-1.5 rounded-full overflow-hidden">
                            <div class="bg-indigo-500 h-1.5 rounded-full" id="modal-progress-polio" style="width: 40%"></div>
                        </div>
                    </div>

                    <!-- Sinovac -->
                    <div>
                        <div class="flex justify-between text-xs mb-1">
                            <span class="font-semibold text-slate-700 dark:text-slate-350">Sinovac (Killed)</span>
                            <span class="font-bold text-slate-850 dark:text-slate-100 font-mono" id="modal-stock-sinovac">3.800 Vial</span>
                        </div>
                        <div class="w-full bg-slate-200 dark:bg-slate-700 h-1.5 rounded-full overflow-hidden">
                            <div class="bg-emerald-500 h-1.5 rounded-full" id="modal-progress-sinovac" style="width: 50%"></div>
                        </div>
                    </div>

                    <!-- Insulin -->
                    <div>
                        <div class="flex justify-between text-xs mb-1">
                            <span class="font-semibold text-slate-700 dark:text-slate-350">Insulin Hormon</span>
                            <span class="font-bold text-slate-850 dark:text-slate-100 font-mono" id="modal-stock-insulin">650 Vial</span>
                        </div>
                        <div class="w-full bg-slate-200 dark:bg-slate-700 h-1.5 rounded-full overflow-hidden">
                            <div class="bg-amber-500 h-1.5 rounded-full" id="modal-progress-insulin" style="width: 15%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Temperature Logs Chart inside Modal -->
        <div class="border-t border-slate-200 dark:border-slate-700/60 pt-6">
            <h4 class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider mb-4">Grafik Stabilitas Suhu 24 Jam Terakhir</h4>
            <div id="modal-chart-temp" class="w-full min-h-[180px]"></div>
        </div>

        <!-- Modal Footer Actions -->
        <div class="flex justify-end gap-3 pt-6 border-t border-slate-200 dark:border-slate-700/60 mt-6">
            <button onclick="closeDetailsModal()" class="px-4 py-2 border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700/60 rounded-xl text-xs font-bold transition-all duration-200 cursor-pointer">
                Tutup
            </button>
            <button onclick="simulateCalibration()" class="px-4 py-2 bg-sky-600 hover:bg-sky-700 text-white rounded-xl text-xs font-bold transition-all duration-200 active:scale-95 shadow-sm shadow-sky-500/10 cursor-pointer flex items-center gap-1">
                <span class="material-symbols-outlined text-[16px]">tune</span> Kalibrasi IoT
            </button>
        </div>
    </div>
</div>

<!-- ApexCharts Script stack -->
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Sparkline for overall Palembang temperature stability
        var sparklineOpts = {
            series: [{
                data: [4.2, 4.5, 4.1, 4.3, 4.6, 4.4, 4.5, 4.3, 4.2, 4.5]
            }],
            chart: {
                type: 'area',
                height: 24,
                sparkline: { enabled: true }
            },
            stroke: { curve: 'smooth', width: 2 },
            colors: ['#06b6d4'],
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.3,
                    opacityTo: 0
                }
            },
            tooltip: { enabled: false }
        };
        var sparkChart = new ApexCharts(document.querySelector("#sparkline-temp"), sparklineOpts);
        sparkChart.render();
    });

    // Details Modal handlers
    const modalEl = document.getElementById('details-modal');
    const modalContainer = modalEl.querySelector('.relative');
    let modalChart = null;

    window.openDetailsModal = function (hub) {
        // Set basic details
        document.getElementById('modal-faskes-id').textContent = hub.id;
        document.getElementById('modal-faskes-name').textContent = hub.nama;
        document.getElementById('modal-faskes-kecamatan').textContent = hub.kecamatan;
        document.getElementById('modal-suhu-aktual').textContent = parseFloat(hub.suhu_aktual).toFixed(1).replace('.', ',') + '°C';
        
        // Icon handling
        const iconDiv = document.getElementById('modal-header-icon');
        const iconSpan = document.getElementById('modal-faskes-icon');
        if (hub.jenis === 'Rumah Sakit') {
            iconDiv.className = 'p-3 bg-purple-500/20 text-purple-500 rounded-xl';
            iconSpan.textContent = 'local_hospital';
        } else {
            iconDiv.className = 'p-3 bg-teal-500/20 text-teal-500 rounded-xl';
            iconSpan.textContent = 'medical_services';
        }

        // Status Badge styling
        const statusBadge = document.getElementById('modal-status-badge');
        if (hub.status === 'Aman') {
            statusBadge.className = 'px-3 py-1 bg-emerald-50 dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-450 border border-emerald-200/50 dark:border-emerald-900/30 text-xs font-bold rounded-full';
            statusBadge.textContent = 'Aman (CDOB)';
        } else {
            statusBadge.className = 'px-3 py-1 bg-rose-50 dark:bg-rose-950/40 text-rose-600 dark:text-rose-450 border border-rose-200/50 dark:border-rose-900/30 text-xs font-bold rounded-full animate-pulse';
            statusBadge.textContent = 'Luar Batas / Bahaya';
        }

        // Additional information
        document.getElementById('modal-kulkas-model').textContent = hub.kulkas_farmasi;
        document.getElementById('modal-kulkas-capacity').textContent = parseInt(hub.kapasitas_total).toLocaleString('id-ID') + ' Vial';
        document.getElementById('modal-kulkas-util').textContent = hub.kapasitas_persen + '%';
        document.getElementById('modal-last-sync').textContent = hub.last_sync;

        // Vaccine breakdown
        document.getElementById('modal-stock-pfizer').textContent = parseInt(hub.stok.pfizer).toLocaleString('id-ID') + ' Vial';
        document.getElementById('modal-stock-polio').textContent = parseInt(hub.stok.polio).toLocaleString('id-ID') + ' Vial';
        document.getElementById('modal-stock-sinovac').textContent = parseInt(hub.stok.sinovac).toLocaleString('id-ID') + ' Vial';
        document.getElementById('modal-stock-insulin').textContent = parseInt(hub.stok.insulin).toLocaleString('id-ID') + ' Vial';

        // Progress bar percentages
        const total = hub.stok_total;
        document.getElementById('modal-progress-pfizer').style.width = (hub.stok.pfizer / total * 100) + '%';
        document.getElementById('modal-progress-polio').style.width = (hub.stok.polio / total * 100) + '%';
        document.getElementById('modal-progress-sinovac').style.width = (hub.stok.sinovac / total * 100) + '%';
        document.getElementById('modal-progress-insulin').style.width = (hub.stok.insulin / total * 100) + '%';

        // Reveal modal
        modalEl.classList.remove('hidden');
        setTimeout(() => {
            modalEl.classList.remove('opacity-0');
            modalContainer.classList.remove('scale-95', 'opacity-0');
        }, 50);

        // Generate 24 hour historical temperature chart
        let baseTemp = parseFloat(hub.suhu_aktual);
        let chartData = [];
        let labels = [];
        for (let i = 24; i >= 0; i -= 2) {
            let hour = new Date();
            hour.setHours(hour.getHours() - i);
            labels.push(hour.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' }));
            
            // Generate stable fluctuated data around actual temp
            let dev = Math.sin(i / 2) * 0.3 + (Math.random() - 0.5) * 0.15;
            chartData.push(parseFloat((baseTemp + dev).toFixed(1)));
        }

        if (modalChart) {
            modalChart.destroy();
        }

        let isDanger = hub.status !== 'Aman';
        var chartOptions = {
            series: [{
                name: "Suhu Kulkas (°C)",
                data: chartData
            }],
            chart: {
                height: 180,
                type: 'area',
                toolbar: { show: false }
            },
            colors: [isDanger ? '#ffb4ab' : '#4cd7f6'],
            stroke: { curve: 'smooth', width: 3 },
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.4,
                    opacityTo: 0.02
                }
            },
            xaxis: {
                categories: labels,
                labels: { style: { colors: '#bcc9cd', fontSize: '9px' } }
            },
            yaxis: {
                min: 0,
                max: 10,
                tickAmount: 5,
                labels: { style: { colors: '#bcc9cd', fontSize: '9px' } }
            },
            grid: {
                borderColor: '#3d494c/20',
                strokeDashArray: 2
            },
            annotations: {
                yaxis: [
                    {
                        y: 2,
                        borderColor: '#06b6d4',
                        label: {
                            borderColor: '#06b6d4',
                            style: { color: '#fff', background: '#06b6d4', fontSize: '9px' },
                            text: 'Batas Bawah (2°C)'
                        }
                    },
                    {
                        y: 8,
                        borderColor: '#f43f5e',
                        label: {
                            borderColor: '#f43f5e',
                            style: { color: '#fff', background: '#f43f5e', fontSize: '9px' },
                            text: 'Batas Atas (8°C)'
                        }
                    }
                ]
            },
            tooltip: { theme: 'dark' }
        };

        modalChart = new ApexCharts(document.querySelector("#modal-chart-temp"), chartOptions);
        modalChart.render();
    };

    window.closeDetailsModal = function () {
        modalEl.classList.add('opacity-0');
        modalContainer.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modalEl.classList.add('hidden');
        }, 300);
    };

    window.simulateCalibration = function () {
        const btn = document.querySelector('button[onclick="simulateCalibration()"]');
        const origContent = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '<span class="material-symbols-outlined text-[16px] animate-spin">sync</span> Mengalibrasi...';

        setTimeout(() => {
            btn.innerHTML = '<span class="material-symbols-outlined text-[16px] text-green-400">check_circle</span> Sukses!';
            
            // Force temperature back to safe ranges in UI
            document.getElementById('modal-suhu-aktual').textContent = '4,5°C';
            
            const badge = document.getElementById('modal-status-badge');
            badge.className = 'px-3 py-1 bg-emerald-50 dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-450 border border-emerald-200/50 dark:border-emerald-900/30 text-xs font-bold rounded-full';
            badge.textContent = 'Aman (CDOB)';

            // Re-render chart showing stabilizing temperature
            if (modalChart) {
                let currentData = modalChart.w.config.series[0].data;
                currentData[currentData.length - 1] = 4.5;
                currentData[currentData.length - 2] = 4.7;
                modalChart.updateSeries([{ data: currentData }]);
            }

            setTimeout(() => {
                btn.disabled = false;
                btn.innerHTML = origContent;
                alert('Kalibrasi sensor IoT dan penstabilan kulkas berhasil. Suhu dikompresi kembali ke batas aman 4,5°C.');
            }, 1000);
        }, 1500);
    };
</script>
@endpush
@endsection
