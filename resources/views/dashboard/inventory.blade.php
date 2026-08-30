@extends('layouts.app')

@section('title', 'Manajemen Inventaris Cold Storage Faskes')

@section('content')
<div class="flex-1 w-full min-h-full transition-colors duration-300 p-container-margin space-y-lg">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end gap-md mb-md">
        <div>
            <nav class="flex text-label-md text-slate-500  mb-1 gap-2 transition-colors duration-300">
                <span>BIO-GUARD</span> / <span class="text-sky-600  font-semibold transition-colors duration-300">Inventaris Cold Storage</span>
            </nav>
            <h1 class="font-headline-lg text-headline-lg text-slate-800  transition-colors duration-300">Inventaris & Cold Chain Hub</h1>
            <p class="text-slate-500  font-body-md text-body-md transition-colors duration-300">Manajemen kapasitas penyimpanan, suhu kulkas farmasi, dan distribusi vaksin di faskes Palembang.</p>
        </div>
        <div>
            <button onclick="document.getElementById('add-hub-modal').classList.remove('hidden')" class="px-4 py-2 bg-sky-600 hover:bg-sky-700 text-white rounded-xl text-xs font-bold transition-all duration-200 active:scale-95 shadow-sm shadow-sky-500/10 flex items-center gap-1">
                <span class="material-symbols-outlined text-[16px]">add</span> Tambah Faskes Manual
            </button>
        </div>
    </div>

    <!-- Bento Grid Stats Section -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-gutter">
        <!-- Card 1: Total Hubs -->
        <x-card class="lg:col-span-3 flex flex-col justify-between transition-all duration-300 ease-out hover:-translate-y-1 hover:shadow-md hover:border-sky-500/50">
            <div class="flex justify-between items-start">
                <div class="p-2.5 bg-sky-50  rounded-xl text-sky-600 ">
                    <span class="material-symbols-outlined text-[24px]">warehouse</span>
                </div>
                <span class="text-[10px] font-bold text-green-500 bg-green-50  px-2 py-0.5 rounded-full flex items-center gap-1">
                    <span class="w-1 h-1 rounded-full bg-green-500 animate-ping"></span> 100% Online
                </span>
            </div>
            <div class="mt-4">
                <span class="text-slate-500 text-xs font-semibold uppercase tracking-wider">Total Hub Faskes</span>
                <h3 class="text-3xl font-extrabold text-slate-900  tabular-nums mt-1">{{ $totalHubs }}</h3>
                <p class="text-slate-500 text-[10px] mt-1 font-semibold">25 RS & 42 Puskesmas</p>
            </div>
        </x-card>

        <!-- Card 2: Average Temperature -->
        <x-card class="lg:col-span-3 flex flex-col justify-between transition-all duration-300 ease-out hover:-translate-y-1 hover:shadow-md hover:border-teal-500/50">
            <div class="flex justify-between items-start">
                <div class="p-2.5 bg-teal-50  rounded-xl text-teal-600 ">
                    <span class="material-symbols-outlined text-[24px]">thermostat</span>
                </div>
                <div class="w-20 h-6" id="sparkline-temp"></div>
            </div>
            <div class="mt-4">
                <span class="text-slate-500 text-xs font-semibold uppercase tracking-wider">Rata-rata Suhu Kulkas</span>
                <h3 class="text-3xl font-extrabold text-slate-900  tabular-nums mt-1">{{ number_format($avgTemp, 1, ',', '.') }}°C</h3>
                <p class="text-slate-500 text-[10px] mt-1 font-semibold">Standar CDOB: 2,0°C - 8,0°C</p>
            </div>
        </x-card>

        <!-- Card 3: Cold Chain Excursions -->
        <x-card class="lg:col-span-3 flex flex-col justify-between transition-all duration-300 ease-out hover:-translate-y-1 hover:shadow-md hover:border-rose-500/50">
            <div class="flex justify-between items-start">
                <div class="p-2.5 bg-rose-50  rounded-xl text-rose-600 ">
                    <span class="material-symbols-outlined text-[24px]">warning_amber</span>
                </div>
                @if($alertCount > 0)
                    <span class="text-[10px] font-bold text-rose-500 bg-rose-50  px-2 py-0.5 rounded-full animate-pulse">
                        TINDAKAN DIBUTUHKAN
                    </span>
                @else
                    <span class="text-[10px] font-bold text-emerald-500 bg-emerald-50  px-2 py-0.5 rounded-full">
                        SISTEM AMAN
                    </span>
                @endif
            </div>
            <div class="mt-4">
                <span class="text-slate-500 text-xs font-semibold uppercase tracking-wider">Anomali Suhu Cold Chain</span>
                <h3 class="text-3xl font-extrabold tabular-nums mt-1 @if($alertCount > 0) text-rose-500  @else text-slate-900  @endif">
                    {{ $alertCount }} <span class="text-[11px] font-semibold text-slate-400 ">Hub Terdeteksi</span>
                </h3>
                <p class="text-slate-500 text-[10px] mt-1 font-semibold">Suhu di luar ambang batas aman</p>
            </div>
        </x-card>

        <!-- Card 4: Total Capacity Utilized -->
        <x-card class="lg:col-span-3 flex flex-col justify-between transition-all duration-300 ease-out hover:-translate-y-1 hover:shadow-md hover:border-amber-500/50">
            <div class="flex justify-between items-start">
                <div class="p-2.5 bg-amber-50  rounded-xl text-amber-600 ">
                    <span class="material-symbols-outlined text-[24px]">donut_large</span>
                </div>
                <span class="text-xs font-bold text-slate-700  bg-slate-100  px-2.5 py-1 rounded-lg">
                    {{ number_format($avgCapacityUtil, 1, ',', '.') }}% terisi
                </span>
            </div>
            <div class="mt-4">
                <span class="text-slate-500 text-xs font-semibold uppercase tracking-wider">Kapasitas Kulkas Total</span>
                <h3 class="text-3xl font-extrabold text-slate-900  tabular-nums mt-1">
                    {{ number_format($totalVaccines, 0, ',', '.') }}<span class="text-[11px] font-semibold text-slate-400 "> / {{ number_format($totalCapacity, 0, ',', '.') }} Vial</span>
                </h3>
                <p class="text-slate-500 text-[10px] mt-1 font-semibold">Akumulasi vial obat & vaksin</p>
            </div>
        </x-card>

        <!-- Card 5: Vaccine Breakdown Stocks List -->
        <x-card class="lg:col-span-12">
            <h4 class="text-sm font-bold text-slate-900  mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-[18px]">inventory</span> Ringkasan Stok Vaksin & Insulin Nasional Terdistribusi (Palembang)
            </h4>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                <!-- Pfizer -->
                <div class="p-4 bg-slate-50  rounded border border-slate-200 ">
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">VAKSIN PFIZER</span>
                        <span class="text-[9px] font-bold text-sky-600  bg-sky-50  px-2 py-0.5 rounded-full">mRNA</span>
                    </div>
                    <div class="text-xl font-black text-slate-900  tabular-nums">{{ number_format($totalPfizer, 0, ',', '.') }} <span class="text-xs font-medium text-slate-500">Vial</span></div>
                    <div class="w-full bg-slate-200  h-1.5 rounded-full mt-2 overflow-hidden">
                        <div class="bg-sky-500 h-1.5 rounded-full" style="width: {{ ($totalPfizer / $totalVaccines) * 100 }}%"></div>
                    </div>
                </div>

                <!-- Polio -->
                <div class="p-4 bg-slate-50  rounded border border-slate-200 ">
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">VAKSIN POLIO (bOPV)</span>
                        <span class="text-[9px] font-bold text-indigo-600  bg-indigo-50  px-2 py-0.5 rounded-full">OPV</span>
                    </div>
                    <div class="text-xl font-black text-slate-900  tabular-nums">{{ number_format($totalPolio, 0, ',', '.') }} <span class="text-xs font-medium text-slate-500">Vial</span></div>
                    <div class="w-full bg-slate-200  h-1.5 rounded-full mt-2 overflow-hidden">
                        <div class="bg-indigo-500 h-1.5 rounded-full" style="width: {{ ($totalPolio / $totalVaccines) * 100 }}%"></div>
                    </div>
                </div>

                <!-- Sinovac -->
                <div class="p-4 bg-slate-50  rounded border border-slate-200 ">
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">VAKSIN SINOVAC</span>
                        <span class="text-[9px] font-bold text-emerald-600  bg-emerald-50  px-2 py-0.5 rounded-full">Killed</span>
                    </div>
                    <div class="text-xl font-black text-slate-900  tabular-nums">{{ number_format($totalSinovac, 0, ',', '.') }} <span class="text-xs font-medium text-slate-500">Vial</span></div>
                    <div class="w-full bg-slate-200  h-1.5 rounded-full mt-2 overflow-hidden">
                        <div class="bg-emerald-500 h-1.5 rounded-full" style="width: {{ ($totalSinovac / $totalVaccines) * 100 }}%"></div>
                    </div>
                </div>

                <!-- Insulin -->
                <div class="p-4 bg-slate-50  rounded border border-slate-200 ">
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">HORMON INSULIN</span>
                        <span class="text-[9px] font-bold text-amber-600  bg-amber-50  px-2 py-0.5 rounded-full">Thermolabile</span>
                    </div>
                    <div class="text-xl font-black text-slate-900  tabular-nums">{{ number_format($totalInsulin, 0, ',', '.') }} <span class="text-xs font-medium text-slate-500">Pena/Vial</span></div>
                    <div class="w-full bg-slate-200  h-1.5 rounded-full mt-2 overflow-hidden">
                        <div class="bg-amber-500 h-1.5 rounded-full" style="width: {{ ($totalInsulin / $totalVaccines) * 100 }}%"></div>
                    </div>
                </div>
            </div>
        </x-card>
    </div>

    <!-- Filters and Table Card -->
    <x-card noPadding="true" class="overflow-hidden transition-colors duration-300">
        <!-- Control Header -->
        <div class="p-4 border-b border-slate-200  flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-slate-50/50 ">
            <h3 class="font-bold text-slate-900  flex items-center gap-2">
                <span class="material-symbols-outlined text-[20px] text-primary">list_alt</span> Direktori Kepatuhan Cold Storage
            </h3>
            
            <!-- Filters Controls Block -->
            <form action="{{ route('inventory') }}" method="GET" class="flex flex-wrap items-center gap-3 w-full md:w-auto">
                <!-- Search -->
                <div class="relative w-full sm:w-60">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-[18px] text-slate-400">search</span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama faskes/alat..." 
                           class="w-full pl-9 pr-4 py-1.5 bg-white  border border-slate-200  rounded-xl text-xs font-semibold text-slate-700  placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500 transition-all duration-300">
                </div>

                <!-- Kecamatan Filter -->
                <select name="kecamatan" onchange="this.form.submit()" 
                        class="bg-white  border border-slate-200  text-xs font-semibold text-slate-700  rounded-xl py-1.5 pl-3 pr-8 focus:ring-1 focus:ring-sky-500 focus:border-sky-500 transition-all duration-300">
                    <option value="Semua">Semua Wilayah</option>
                    @foreach($allKecamatan as $kec)
                        <option value="{{ $kec }}" {{ request('kecamatan') === $kec ? 'selected' : '' }}>{{ $kec }}</option>
                    @endforeach
                </select>

                <!-- Status Filter -->
                <select name="status" onchange="this.form.submit()" 
                        class="bg-white  border border-slate-200  text-xs font-semibold text-slate-700  rounded-xl py-1.5 pl-3 pr-8 focus:ring-1 focus:ring-sky-500 focus:border-sky-500 transition-all duration-300">
                    <option value="Semua">Semua Status</option>
                    <option value="Aman" {{ request('status') === 'Aman' ? 'selected' : '' }}>Aman (2°C - 8°C)</option>
                    <option value="Bahaya" {{ request('status') === 'Bahaya' ? 'selected' : '' }}>Anomali / Bahaya</option>
                </select>

                <!-- Sort option -->
                <select name="sort" onchange="this.form.submit()" 
                        class="bg-white  border border-slate-200  text-xs font-semibold text-slate-700  rounded-xl py-1.5 pl-3 pr-8 focus:ring-1 focus:ring-sky-500 focus:border-sky-500 transition-all duration-300">
                    <option value="nama" {{ request('sort') === 'nama' ? 'selected' : '' }}>Urut: Nama Faskes</option>
                    <option value="suhu" {{ request('sort') === 'suhu' ? 'selected' : '' }}>Urut: Suhu Aktual</option>
                    <option value="kapasitas" {{ request('sort') === 'kapasitas' ? 'selected' : '' }}>Urut: Utilitasi Ruang</option>
                    <option value="stok_total" {{ request('sort') === 'stok_total' ? 'selected' : '' }}>Urut: Total Stok</option>
                </select>

                <!-- Reset Button -->
                @if(request()->anyFilled(['search', 'kecamatan', 'status', 'sort']))
                    <a href="{{ route('inventory') }}" class="text-rose-500 hover:text-rose-600 :text-rose-400 p-2 hover:bg-rose-500/10 rounded-xl text-xs font-bold transition-all active:scale-95 duration-100 flex items-center gap-1 cursor-pointer">
                        <span class="material-symbols-outlined text-[16px]">close</span> Reset
                    </a>
                @endif
            </form>
        </div>

        <!-- Table Container -->
        <div class="overflow-x-auto">
            <x-table class="w-full min-w-[1000px]">
                <thead>
                    <x-table.tr>
                        <x-table.th>ID / Nama Hub Faskes</x-table.th>
                        <x-table.th>Model Kulkas</x-table.th>
                        <x-table.th class="text-center">Suhu Aktual</x-table.th>
                        <x-table.th class="w-[180px]">Kapasitas Terisi</x-table.th>
                        <x-table.th class="text-center">Rincian Stok (Vial)</x-table.th>
                        <x-table.th>Last Sync</x-table.th>
                        <x-table.th class="text-center">Aksi</x-table.th>
                    </x-table.tr>
                </thead>
                <tbody class="divide-y divide-slate-200  transition-all duration-300">
                    @forelse($hubsPaginated as $hub)
                        <x-table.tr>
                            <!-- Faskes Name & Region -->
                            <x-table.td>
                                <div class="flex items-center gap-3">
                                    <div class="p-2.5 @if($hub['jenis'] === 'Rumah Sakit') bg-purple-100 text-purple-600   @else bg-teal-100 text-teal-600   @endif rounded-xl">
                                        <span class="material-symbols-outlined text-[18px]">
                                            @if($hub['jenis'] === 'Rumah Sakit') local_hospital @else medical_services @endif
                                        </span>
                                    </div>
                                    <div>
                                        <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest font-mono">{{ $hub['id'] }}</span>
                                        <h4 class="font-bold text-slate-900  text-sm mt-0.5">{{ $hub['nama'] }}</h4>
                                        <span class="text-[10px] text-slate-500 mt-1 inline-flex items-center gap-1 font-semibold">
                                            <span class="material-symbols-outlined text-[11px]">location_on</span> {{ $hub['kecamatan'] }}
                                        </span>
                                    </div>
                                </div>
                            </x-table.td>

                            <!-- Device model -->
                            <x-table.td class="font-medium">
                                <span class="font-semibold text-slate-900 ">{{ $hub['kulkas_farmasi'] }}</span>
                                <div class="text-[10px] text-slate-500 font-mono mt-0.5 font-bold">Kapasitas: {{ number_format($hub['kapasitas_total'], 0, ',', '.') }} Vial</div>
                            </x-table.td>

                            <!-- Temp Badge -->
                            <x-table.td class="text-center">
                                @if($hub['status'] === 'Aman')
                                    <x-badge color="success">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        {{ number_format($hub['suhu_aktual'], 1, ',', '.') }}°C
                                    </x-badge>
                                @else
                                    <x-badge color="error" class="animate-pulse">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500 animate-ping"></span>
                                        {{ number_format($hub['suhu_aktual'], 1, ',', '.') }}°C
                                    </x-badge>
                                @endif
                            </x-table.td>

                            <!-- Capacity progress -->
                            <x-table.td>
                                <div class="flex justify-between items-center text-[10px] font-bold text-slate-500 mb-1 font-mono">
                                    <span>{{ number_format($hub['stok_total'], 0, ',', '.') }} Vial</span>
                                    <span>{{ $hub['kapasitas_persen'] }}%</span>
                                </div>
                                <div class="w-full bg-slate-200  h-2 rounded-full overflow-hidden">
                                    <div class="h-full rounded-full transition-all duration-500 @if($hub['kapasitas_persen'] > 90) bg-rose-500 @elseif($hub['kapasitas_persen'] > 75) bg-amber-500 @else bg-sky-500 @endif" style="width: {{ $hub['kapasitas_persen'] }}%"></div>
                                </div>
                            </x-table.td>

                            <!-- Stock details -->
                            <x-table.td>
                                <div class="flex flex-wrap gap-1.5 justify-center">
                                    <span class="px-2 py-0.5 rounded bg-slate-100  border border-slate-200  text-slate-600  font-bold font-mono text-[10px]" title="Pfizer">
                                        P: <span class="text-sky-600 ">{{ number_format($hub['stok']['pfizer'], 0, ',', '.') }}</span>
                                    </span>
                                    <span class="px-2 py-0.5 rounded bg-slate-100  border border-slate-200  text-slate-600  font-bold font-mono text-[10px]" title="Polio">
                                        O: <span class="text-indigo-600 ">{{ number_format($hub['stok']['polio'], 0, ',', '.') }}</span>
                                    </span>
                                    <span class="px-2 py-0.5 rounded bg-slate-100  border border-slate-200  text-slate-600  font-bold font-mono text-[10px]" title="Sinovac">
                                        S: <span class="text-emerald-600 ">{{ number_format($hub['stok']['sinovac'], 0, ',', '.') }}</span>
                                    </span>
                                    <span class="px-2 py-0.5 rounded bg-slate-100  border border-slate-200  text-slate-600  font-bold font-mono text-[10px]" title="Insulin">
                                        I: <span class="text-amber-600 ">{{ number_format($hub['stok']['insulin'], 0, ',', '.') }}</span>
                                    </span>
                                </div>
                            </x-table.td>

                            <!-- Sync time -->
                            <x-table.td class="text-slate-500 font-bold font-mono text-[11px]">
                                {{ $hub['last_sync'] }}
                            </x-table.td>

                            <!-- Actions -->
                            <x-table.td class="text-center">
                                <button type="button" onclick="openDetailsModal({{ json_encode($hub) }})" 
                                        class="bg-primary hover:bg-primary/90 text-on-primary font-bold px-3 py-1.5 rounded-lg active:scale-95 transition-all text-[11px] shadow-sm shadow-primary/20 cursor-pointer">
                                    Detail
                                </button>
                            </x-table.td>
                        </x-table.tr>
                    @empty
                        <x-table.tr>
                            <x-table.td colspan="7" class="py-12 text-center">
                                <div class="flex flex-col items-center justify-center max-w-sm mx-auto">
                                    <div class="w-16 h-16 bg-slate-100  rounded-full flex items-center justify-center mb-4">
                                        <span class="material-symbols-outlined text-[32px] text-slate-400">inventory_2</span>
                                    </div>
                                    <h3 class="text-lg font-bold text-slate-800  mb-2">Belum Ada Data Faskes</h3>
                                    <p class="text-sm text-slate-500  mb-6">Data inventaris cold storage faskes masih kosong. Tambahkan faskes secara manual untuk memulai pemantauan.</p>
                                    <button onclick="document.getElementById('add-hub-modal').classList.remove('hidden')" class="px-5 py-2.5 bg-sky-600 hover:bg-sky-700 text-white rounded-xl text-sm font-bold transition-all duration-200 active:scale-95 shadow-md shadow-sky-500/20 flex items-center gap-2">
                                        <span class="material-symbols-outlined text-[18px]">add_circle</span> Tambah Faskes Pertama
                                    </button>
                                </div>
                            </x-table.td>
                        </x-table.tr>
                    @endforelse
                </tbody>
            </x-table>
        </div>

        <!-- Pagination Footer -->
        <div class="px-4 py-3 border-t border-slate-200  bg-slate-50/50  flex justify-between items-center transition-colors duration-300">
            <span class="text-xs font-semibold text-slate-500">
                Menampilkan {{ $hubsPaginated->firstItem() ?? 0 }} - {{ $hubsPaginated->lastItem() ?? 0 }} dari {{ $hubsPaginated->total() }} Hub Faskes
            </span>
            <div class="flex gap-2">
                @if($hubsPaginated->onFirstPage())
                    <button class="px-3.5 py-1.5 bg-slate-100  text-slate-400  rounded-lg text-xs font-bold cursor-not-allowed" disabled>
                        Sebelumnya
                    </button>
                @else
                    <a href="{{ $hubsPaginated->previousPageUrl() }}" class="px-3.5 py-1.5 bg-white  border border-slate-200  text-slate-700  hover:bg-slate-100 :bg-slate-600/70 rounded-lg text-xs font-bold transition-all duration-200 active:scale-95">
                        Sebelumnya
                    </a>
                @endif

                @if($hubsPaginated->hasMorePages())
                    <a href="{{ $hubsPaginated->nextPageUrl() }}" class="px-3.5 py-1.5 bg-white  border border-slate-200  text-slate-700  hover:bg-slate-100 :bg-slate-600/70 rounded-lg text-xs font-bold transition-all duration-200 active:scale-95">
                        Berikutnya
                    </a>
                @else
                    <button class="px-3.5 py-1.5 bg-slate-100  text-slate-400  rounded-lg text-xs font-bold cursor-not-allowed" disabled>
                        Berikutnya
                    </button>
                @endif
            </div>
        </div>
    </x-card>
</div>

<!-- Add Hub Modal -->
<div id="add-hub-modal" class="fixed inset-0 z-[60] flex items-center justify-center p-4 bg-slate-950/60 backdrop-blur-sm hidden">
    <div class="relative w-full max-w-2xl bg-white  border border-slate-200  rounded-2xl shadow-2xl p-6 md:p-8 max-h-[90vh] overflow-y-auto">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold text-slate-800 ">Tambah Faskes Manual</h3>
            <button onclick="document.getElementById('add-hub-modal').classList.add('hidden')" class="p-2 rounded-xl text-slate-400 hover:text-slate-800 :text-slate-200 hover:bg-slate-100 :bg-slate-700">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <form action="{{ route('inventory.store') }}" method="POST" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700  mb-1">Nama Faskes</label>
                    <input type="text" name="nama" required class="w-full bg-slate-50  border border-slate-200  rounded-lg px-3 py-2 text-sm text-slate-800 ">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700  mb-1">Kategori</label>
                    <select name="kategori" required class="w-full bg-slate-50  border border-slate-200  rounded-lg px-3 py-2 text-sm text-slate-800 ">
                        <option value="Rumah Sakit">Rumah Sakit</option>
                        <option value="Puskesmas">Puskesmas</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700  mb-1">Kecamatan</label>
                    <select name="kecamatan" required class="w-full bg-slate-50  border border-slate-200  rounded-lg px-3 py-2 text-sm text-slate-800 ">
                        @foreach($allKecamatan as $kec)
                            <option value="{{ $kec }}">{{ $kec }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700  mb-1">Model Kulkas Farmasi</label>
                    <input type="text" name="kulkas_farmasi" required placeholder="Contoh: B Medical TCW 4000" class="w-full bg-slate-50  border border-slate-200  rounded-lg px-3 py-2 text-sm text-slate-800 ">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700  mb-1">Kapasitas Total (Vial)</label>
                    <input type="number" name="kapasitas_total" required min="1" value="10000" class="w-full bg-slate-50  border border-slate-200  rounded-lg px-3 py-2 text-sm text-slate-800 ">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700  mb-1">Suhu Aktual (°C)</label>
                    <input type="number" step="0.1" name="suhu_aktual" required value="4.5" class="w-full bg-slate-50  border border-slate-200  rounded-lg px-3 py-2 text-sm text-slate-800 ">
                </div>
            </div>
            <hr class="border-slate-200  my-4">
            <h4 class="text-sm font-bold text-slate-800 ">Alokasi Stok Saat Ini (Vial)</h4>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-xs text-slate-500 mb-1">Pfizer</label>
                    <input type="number" name="pfizer" min="0" value="0" class="w-full bg-slate-50  border border-slate-200  rounded-lg px-3 py-2 text-sm">
                </div>
                <div>
                    <label class="block text-xs text-slate-500 mb-1">Polio</label>
                    <input type="number" name="polio" min="0" value="0" class="w-full bg-slate-50  border border-slate-200  rounded-lg px-3 py-2 text-sm">
                </div>
                <div>
                    <label class="block text-xs text-slate-500 mb-1">Sinovac</label>
                    <input type="number" name="sinovac" min="0" value="0" class="w-full bg-slate-50  border border-slate-200  rounded-lg px-3 py-2 text-sm">
                </div>
                <div>
                    <label class="block text-xs text-slate-500 mb-1">Insulin</label>
                    <input type="number" name="insulin" min="0" value="0" class="w-full bg-slate-50  border border-slate-200  rounded-lg px-3 py-2 text-sm">
                </div>
            </div>
            <div class="pt-2">
                <label class="block text-xs font-bold text-slate-700  mb-1">Total Stok (Wajib diisi total dari atas)</label>
                <input type="number" name="totalStok" required min="0" value="0" class="w-full bg-slate-50  border border-slate-200  rounded-lg px-3 py-2 text-sm text-slate-800 ">
            </div>
            
            <div class="flex justify-end pt-4">
                <button type="submit" class="px-6 py-2.5 bg-sky-600 hover:bg-sky-700 text-white rounded-xl text-sm font-bold transition-all duration-200 shadow-md">
                    Simpan Faskes
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Detailed Analytics Modal (Glassmorphism Modal UI) -->
<div id="details-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/60 backdrop-blur-sm transition-opacity duration-300 opacity-0 hidden">
    <div class="relative w-full max-w-3xl bg-white  border border-slate-200  rounded-2xl shadow-2xl p-6 md:p-8 transform scale-95 opacity-0 transition-all duration-300 ease-out max-h-[90vh] overflow-y-auto">
        <!-- Close button -->
        <button onclick="closeDetailsModal()" class="absolute right-4 top-4 p-2 rounded-xl text-slate-400 hover:text-slate-850 :text-slate-200 hover:bg-slate-100 :bg-slate-700/60 transition-colors duration-200 cursor-pointer">
            <span class="material-symbols-outlined text-[20px]">close</span>
        </button>

        <!-- Modal Header -->
        <div class="flex items-start gap-4 pb-4 border-b border-slate-200 ">
            <div id="modal-header-icon" class="p-3 text-white rounded-xl">
                <span class="material-symbols-outlined text-[24px]" id="modal-faskes-icon">local_hospital</span>
            </div>
            <div>
                <span class="text-[10px] font-bold text-sky-500  uppercase tracking-widest font-mono" id="modal-faskes-id">HOSP-001</span>
                <h3 class="text-xl font-bold text-slate-850  mt-0.5" id="modal-faskes-name">Nama Hub Faskes</h3>
                <p class="text-xs text-slate-500  flex items-center gap-1 mt-1">
                    <span class="material-symbols-outlined text-[12px]">location_on</span> <span id="modal-faskes-kecamatan">Kecamatan</span>
                </p>
            </div>
        </div>

        <!-- Modal Content Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 py-6">
            <!-- Left panel: Telemetry stats & Device info -->
            <div class="space-y-4">
                <h4 class="text-xs font-bold text-slate-400  uppercase tracking-wider">Telemetri & Status Kulkas</h4>
                
                <div class="p-4 bg-slate-50  border border-slate-200/50  rounded-xl flex items-center justify-between">
                    <div>
                        <span class="text-xs text-slate-500 ">Temperatur Terkini</span>
                        <div class="text-3xl font-black text-slate-850  font-mono-data mt-1" id="modal-suhu-aktual">4,2°C</div>
                    </div>
                    <span class="px-3 py-1.5 rounded-full text-xs font-bold" id="modal-status-badge">Aman</span>
                </div>

                <div class="p-4 bg-slate-50  border border-slate-200/50  rounded-xl space-y-2">
                    <div class="flex justify-between items-center text-xs">
                        <span class="text-slate-500 ">Alat Pemantau IoT</span>
                        <span class="font-bold text-slate-800 " id="modal-kulkas-model">B Medical TCW 4000</span>
                    </div>
                    <div class="flex justify-between items-center text-xs">
                        <span class="text-slate-500 ">Kapasitas Penyimpanan</span>
                        <span class="font-bold text-slate-800  font-mono" id="modal-kulkas-capacity">15.000 Vial</span>
                    </div>
                    <div class="flex justify-between items-center text-xs">
                        <span class="text-slate-500 ">Rata-rata Utilitasi</span>
                        <span class="font-bold text-slate-800  font-mono" id="modal-kulkas-util">54,5%</span>
                    </div>
                    <div class="flex justify-between items-center text-xs">
                        <span class="text-slate-500 ">Pembaruan Terakhir</span>
                        <span class="font-bold text-slate-800  font-mono" id="modal-last-sync">3 menit lalu</span>
                    </div>
                </div>
            </div>

            <!-- Right panel: Stock allocations -->
            <div class="space-y-4">
                <h4 class="text-xs font-bold text-slate-400  uppercase tracking-wider">Alokasi Stok Saat Ini</h4>
                
                <div class="space-y-3 p-4 bg-slate-50  border border-slate-200/50  rounded-xl">
                    <!-- Pfizer -->
                    <div>
                        <div class="flex justify-between text-xs mb-1">
                            <span class="font-semibold text-slate-700 ">Pfizer (mRNA)</span>
                            <span class="font-bold text-slate-850  font-mono" id="modal-stock-pfizer">1.250 Vial</span>
                        </div>
                        <div class="w-full bg-slate-200  h-1.5 rounded-full overflow-hidden">
                            <div class="bg-sky-500 h-1.5 rounded-full" id="modal-progress-pfizer" style="width: 25%"></div>
                        </div>
                    </div>

                    <!-- Polio -->
                    <div>
                        <div class="flex justify-between text-xs mb-1">
                            <span class="font-semibold text-slate-700 ">Polio (bOPV)</span>
                            <span class="font-bold text-slate-850  font-mono" id="modal-stock-polio">2.400 Vial</span>
                        </div>
                        <div class="w-full bg-slate-200  h-1.5 rounded-full overflow-hidden">
                            <div class="bg-indigo-500 h-1.5 rounded-full" id="modal-progress-polio" style="width: 40%"></div>
                        </div>
                    </div>

                    <!-- Sinovac -->
                    <div>
                        <div class="flex justify-between text-xs mb-1">
                            <span class="font-semibold text-slate-700 ">Sinovac (Killed)</span>
                            <span class="font-bold text-slate-850  font-mono" id="modal-stock-sinovac">3.800 Vial</span>
                        </div>
                        <div class="w-full bg-slate-200  h-1.5 rounded-full overflow-hidden">
                            <div class="bg-emerald-500 h-1.5 rounded-full" id="modal-progress-sinovac" style="width: 50%"></div>
                        </div>
                    </div>

                    <!-- Insulin -->
                    <div>
                        <div class="flex justify-between text-xs mb-1">
                            <span class="font-semibold text-slate-700 ">Hormon Insulin</span>
                            <span class="font-bold text-slate-850  font-mono" id="modal-stock-insulin">650 Vial</span>
                        </div>
                        <div class="w-full bg-slate-200  h-1.5 rounded-full overflow-hidden">
                            <div class="bg-amber-500 h-1.5 rounded-full" id="modal-progress-insulin" style="width: 15%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Temperature Logs Chart inside Modal -->
        <div class="border-t border-slate-200  pt-6">
            <h4 class="text-xs font-bold text-slate-400  uppercase tracking-wider mb-4">Grafik Stabilitas Suhu 24 Jam Terakhir</h4>
            <div id="modal-chart-temp" class="w-full min-h-[180px]"></div>
        </div>

        <!-- Modal Footer Actions -->
        <div class="flex justify-end gap-3 pt-6 border-t border-slate-200  mt-6">
            <button onclick="closeDetailsModal()" class="px-4 py-2 border border-slate-200  text-slate-700  hover:bg-slate-100 :bg-slate-700/60 rounded-xl text-xs font-bold transition-all duration-200 cursor-pointer">
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
        document.getElementById('modal-suhu-aktual').innerHTML = parseFloat(hub.suhu_aktual).toFixed(1).replace('.', ',') + '°C';
        
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
            statusBadge.className = 'px-3 py-1 bg-emerald-50  text-emerald-600  border border-emerald-200/50  text-xs font-bold rounded-full';
            statusBadge.textContent = 'Aman (CDOB)';
        } else {
            statusBadge.className = 'px-3 py-1 bg-rose-50  text-rose-600  border border-rose-200/50  text-xs font-bold rounded-full animate-pulse';
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
            document.getElementById('modal-suhu-aktual').innerHTML = '4,5°C';
            
            const badge = document.getElementById('modal-status-badge');
            badge.className = 'px-3 py-1 bg-emerald-50  text-emerald-600  border border-emerald-200/50  text-xs font-bold rounded-full';
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
