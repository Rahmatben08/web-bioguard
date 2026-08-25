@extends('layouts.app')

@section('title', 'Pengiriman & Inventaris')

@section('content')
<div class="flex-1 w-full min-h-full p-container-margin space-y-lg">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-md mb-md">
        <div>
            <nav class="flex text-label-md text-outline mb-1 gap-2">
                <span>BIO-GUARD</span> / <span class="text-primary font-semibold">Pengiriman & Inventaris</span>
            </nav>
            <h1 class="font-headline-lg text-headline-lg text-on-surface tracking-tight">Pengiriman & Inventaris</h1>
        </div>
        <div class="flex gap-2">
            <button onclick="document.getElementById('modalBuatPengiriman').classList.remove('hidden')" class="inline-flex items-center gap-2 px-lg py-md rounded-xl font-label-md text-label-md bg-tertiary text-white font-medium hover:-translate-y-0.5 hover:shadow-lg active:scale-95 transition-all duration-300 ease-out shadow-[0_0_15px_rgba(234,88,12,0.3)]">
                <span class="material-symbols-outlined text-[18px]">local_shipping</span>
                Buat Pengiriman
            </button>
            <button onclick="openQrScannerModal()" class="inline-flex items-center gap-2 px-lg py-md rounded-xl font-label-md text-label-md bg-sky-500 text-white font-medium hover:-translate-y-0.5 hover:shadow-lg active:scale-95 transition-all duration-300 ease-out shadow-[0_0_15px_rgba(14,165,233,0.3)]">
                <span class="material-symbols-outlined text-[18px]">qr_code_scanner</span>
                Scan QR Faskes
            </button>
            <button onclick="openQuickModal('terima')" class="inline-flex items-center gap-2 px-lg py-md rounded-xl font-label-md text-label-md bg-primary text-on-primary font-medium hover:-translate-y-0.5 hover:shadow-lg active:scale-95 transition-all duration-300 ease-out shadow-[0_0_15px_rgba(2,132,199,0.3)]">
                <span class="material-symbols-outlined text-[18px]">add_box</span>
                Input Manual
            </button>
        </div>
    </div>

    <!-- Quick Stats Bento Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-gutter mb-md">
        {{-- Card 1 --}}
        <x-card class="hover:border-primary/30 transition-colors">
            <div class="flex justify-between items-start mb-4">
                <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Total Stok</span>
                <span class="material-symbols-outlined text-[20px] text-primary">inventory_2</span>
            </div>
            <div class="text-3xl font-extrabold tabular-nums"><span id="live-total-stok">{{ number_format($totalStok, 0, ',', '.') }}</span> <span class="text-xs text-slate-500 font-semibold">vial</span></div>
            <div class="mt-4 flex items-center gap-2 text-primary">
                <span class="material-symbols-outlined text-[14px]">trending_up</span>
                <span class="text-[10px] font-bold uppercase tracking-wider">+4,2% dari bulan lalu</span>
            </div>
        </x-card>

        {{-- Card 2 --}}
        <x-card class="hover:border-tertiary/30 transition-colors">
            <div class="flex justify-between items-start mb-4">
                <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Segera Kedaluwarsa</span>
                <span class="material-symbols-outlined text-[20px] text-tertiary">event_busy</span>
            </div>
            <div class="text-3xl font-extrabold tabular-nums"><span id="live-segera-kadaluwarsa">{{ number_format($segeraKadaluwarsa, 0, ',', '.') }}</span> <span class="text-xs text-slate-500 font-semibold">vial</span></div>
            <div class="mt-4 flex items-center gap-2 text-tertiary">
                <span class="material-symbols-outlined text-[14px]">warning</span>
                <span class="text-[10px] font-bold uppercase tracking-wider">Rotasi stok segera</span>
            </div>
        </x-card>

        {{-- Card 3 --}}
        <x-card class="hover:border-error/30 transition-colors">
            <div class="flex justify-between items-start mb-4">
                <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Aset Dikarantina</span>
                <span class="material-symbols-outlined text-[20px] text-error">lock_reset</span>
            </div>
            <div class="text-3xl font-extrabold tabular-nums"><span id="live-aset-karantina">{{ number_format($asetKarantina, 0, ',', '.') }}</span> <span class="text-xs text-slate-500 font-semibold">batch</span></div>
            <div class="mt-4 flex items-center gap-2 text-error">
                <span class="material-symbols-outlined text-[14px]">verified_user</span>
                <span class="text-[10px] font-bold uppercase tracking-wider">Menunggu persetujuan QA</span>
            </div>
        </x-card>

        {{-- Card 4 --}}
        <x-card class="hover:border-primary/30 transition-colors">
            <div class="flex justify-between items-start mb-4">
                <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Kapasitas Tersedia</span>
                <span class="material-symbols-outlined text-[20px] text-primary">database</span>
            </div>
            <div class="text-3xl font-extrabold tabular-nums"><span id="live-kapasitas">{{ $kapasitasUtilisasi }}%</span> <span class="text-xs text-slate-500 font-semibold">utilisasi</span></div>
            <div class="mt-4 flex items-center gap-2">
                <div class="w-full bg-slate-200  h-1 rounded-full overflow-hidden">
                    <div class="bg-primary h-full" style="width: {{ $kapasitasUtilisasi }}%"></div>
                </div>
            </div>
        </x-card>
    </div>

    <!-- Table Filters & Search Form -->
    <form method="GET" action="{{ route('shipments') }}" class="bg-surface-container border border-outline-variant/30 border-b-0 rounded-t-xl px-lg py-md flex flex-wrap items-center justify-between gap-4">
        <div class="relative w-full max-w-md">
            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline">search</span>
            <input name="search" value="{{ request('search') }}" class="w-full bg-surface-container-lowest border border-outline-variant/50 rounded-lg pl-12 pr-4 py-2 text-body-md focus:border-primary focus:ring-1 focus:ring-primary transition-all text-on-surface" placeholder="Cari ID batch, nama produk, atau jenis..." type="text"/>
        </div>
        <div class="flex items-center gap-2 w-full sm:w-auto justify-end">
            <select name="status" onchange="this.form.submit()" class="bg-surface-container-lowest border border-outline-variant/50 rounded-lg px-md py-2 text-label-md text-on-surface focus:border-primary focus:ring-1 focus:ring-primary transition-all">
                <option value="Semua" {{ request('status') === 'Semua' ? 'selected' : '' }}>Semua Status</option>
                <option value="Aman" {{ request('status') === 'Aman' ? 'selected' : '' }}>Aman</option>
                <option value="Peringatan Dini" {{ request('status') === 'Peringatan Dini' ? 'selected' : '' }}>Peringatan Dini</option>
                <option value="Karantina" {{ request('status') === 'Karantina' ? 'selected' : '' }}>Karantina</option>
            </select>
            <select name="sort" onchange="this.form.submit()" class="bg-surface-container-lowest border border-outline-variant/50 rounded-lg px-md py-2 text-label-md text-on-surface focus:border-primary focus:ring-1 focus:ring-primary transition-all">
                <option value="no_batch" {{ request('sort') === 'no_batch' ? 'selected' : '' }}>Urutkan ID Batch</option>
                <option value="stok_desc" {{ request('sort') === 'stok_desc' ? 'selected' : '' }}>Stok Terbanyak</option>
                <option value="stok_asc" {{ request('sort') === 'stok_asc' ? 'selected' : '' }}>Stok Tersedikit</option>
                <option value="kadaluwarsa_asc" {{ request('sort') === 'kadaluwarsa_asc' ? 'selected' : '' }}>Kedaluwarsa Terdekat</option>
            </select>
            <button type="submit" class="flex items-center gap-2 px-md py-2 bg-primary text-on-primary rounded-lg hover:-translate-y-0.5 hover:shadow-lg active:scale-95 transition-all duration-300 ease-out shadow-[0_0_12px_rgba(2,132,199,0.3)] font-label-md">
                <span class="material-symbols-outlined text-[18px]">filter_alt</span>
                <span class="text-label-md">Terapkan</span>
            </button>
        </div>
    </form>

    <!-- Primary Inventory Table -->
    <x-card noPadding="true" class="mb-md">
        <div class="overflow-x-auto">
            <x-table>
                <thead>
                    <tr>
                        <th>Nama Produk</th>
                        <th>ID Batch</th>
                        <th>Suhu Penyimpanan</th>
                        <th>Jumlah Stok</th>
                        <th>Tgl. Kedaluwarsa</th>
                        <th>Status</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($drugs as $drug)
                    <tr data-batch="{{ $drug->no_batch }}">
                        <td>
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded bg-slate-100  flex items-center justify-center text-slate-500">
                                    <span class="material-symbols-outlined">
                                        {{ $drug->jenis === 'Vaksin' ? 'vaccines' : ($drug->jenis === 'Insulin' ? 'medical_services' : 'bloodtype') }}
                                    </span>
                                </div>
                                <div>
                                    <div class="font-bold text-slate-900 ">{{ $drug->nama_produk }}</div>
                                    <div class="text-[10px] text-slate-500 font-mono">{{ $drug->jenis }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="tabular-nums font-mono text-slate-700 ">
                            <div class="flex items-center gap-2">
                                <span>#{{ $drug->no_batch }}</span>
                                <a href="{{ route('dashboard.qr_batch', $drug->no_batch) }}" target="_blank" class="inline-flex items-center text-primary hover:text-primary/80 transition-colors" title="Cetak QR Batch">
                                    <span class="material-symbols-outlined text-[16px]">qr_code_2</span>
                                </a>
                            </div>
                        </td>
                        <td>
                            @php
                                $suhu = (float) $drug->suhu_penyimpanan;
                                $rangeText = '2&deg;C s/d 8&deg;C';
                                $rangeLabel = 'Chilled';
                                $colorClass = 'text-teal-600 ';
                                $icon = 'thermostat';
                                
                                if ($suhu <= -70.0) {
                                    $rangeText = '-80&deg;C s/d -60&deg;C';
                                    $rangeLabel = 'Ultra-Cold';
                                    $colorClass = 'text-cyan-500 ';
                                    $icon = 'severe_cold';
                                } elseif ($suhu <= -20.0) {
                                    $rangeText = '-25&deg;C s/d -15&deg;C';
                                    $rangeLabel = 'Frozen';
                                    $colorClass = 'text-blue-500 ';
                                    $icon = 'kitchen';
                                }
                            @endphp
                            <div class="flex flex-col">
                                <div class="flex items-center gap-1.5 {{ $colorClass }}">
                                    <span class="material-symbols-outlined text-[16px]">{{ $icon }}</span>
                                    <span class="font-bold text-xs">{{ $rangeLabel }}</span>
                                </div>
                                <div class="text-[11px] text-slate-500  font-semibold font-mono mt-0.5 tabular-nums">
                                    {{ $rangeText }} (target: {{ number_format($suhu, 1, ',', '.') }}&deg;C)
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="flex flex-col gap-1">
                                <div class="flex justify-between text-[11px] font-bold">
                                    <span id="stok-{{ $drug->no_batch }}" class="text-slate-900  tabular-nums">{{ number_format($drug->stok, 0, ',', '.') }}</span>
                                    <span class="text-slate-500">Min: 5rb</span>
                                </div>
                                <div class="w-32 h-1.5 bg-slate-200  rounded-full overflow-hidden">
                                    <div class="bg-primary h-full" style="width: {{ min(100, ($drug->stok / 30000) * 100) }}%"></div>
                                </div>
                            </div>
                        </td>
                        <td class="tabular-nums font-mono text-slate-700 ">{{ $drug->tanggal_kadaluwarsa->format('Y-m-d') }}</td>
                        <td>
                            @php
                                $badgeColor = 'neutral';
                                if ($drug->status === 'Aman') $badgeColor = 'success';
                                elseif ($drug->status === 'Peringatan Dini') $badgeColor = 'warning';
                                else $badgeColor = 'error';
                            @endphp
                            <x-badge color="{{ $badgeColor }}">
                                {{ $drug->status }}
                            </x-badge>
                        </td>
                        <td>
                            <div class="flex justify-end gap-2">
                                <button onclick="openColdChainModal('{{ $drug->no_batch }}', '{{ $drug->nama_produk }}', '{{ $drug->suhu_penyimpanan }}')" class="p-1.5 hover:bg-slate-100 :bg-slate-800 rounded text-slate-500 hover:text-primary transition-colors coldchain-trigger" data-batch="{{ $drug->no_batch }}" data-name="{{ $drug->nama_produk }}" data-temp="{{ $drug->suhu_penyimpanan }}" title="Analisis Rantai Dingin">
                                    <span class="material-symbols-outlined text-[18px]">timeline</span>
                                </button>
                                <button onclick="openHistoryModal('{{ $drug->no_batch }}', '{{ $drug->nama_produk }}')" class="p-1.5 hover:bg-slate-100 :bg-slate-800 rounded text-slate-500 hover:text-primary transition-colors" title="Riwayat Transaksi Stok">
                                    <span class="material-symbols-outlined text-[18px]">history</span>
                                </button>
                                <button onclick="openQuickModal('transfer')" class="p-1.5 hover:bg-slate-100 :bg-slate-800 rounded text-slate-500 hover:text-primary transition-colors" title="Keluarkan Stok">
                                    <span class="material-symbols-outlined text-[18px]">outbound</span>
                                </button>
                                <a href="{{ route('dashboard.qr_batch', $drug->no_batch) }}" target="_blank" class="p-1.5 hover:bg-slate-100 :bg-slate-800 rounded text-slate-500 hover:text-primary transition-colors" title="Cetak QR Batch">
                                    <span class="material-symbols-outlined text-[18px]">qr_code_2</span>
                                </a>
                                <button onclick="showToast('Mencetak Label', 'Label barcode sedang diproses ke printer...')" class="p-1.5 hover:bg-slate-100 :bg-slate-800 rounded text-slate-500 hover:text-primary transition-colors" title="Cetak Label">
                                    <span class="material-symbols-outlined text-[18px]">print</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-12 text-center text-slate-500">
                            <div class="flex flex-col items-center justify-center max-w-sm mx-auto">
                                <div class="w-16 h-16 bg-slate-100  rounded-full flex items-center justify-center mb-4">
                                    <span class="material-symbols-outlined text-[32px] text-slate-400">inventory_2</span>
                                </div>
                                <h3 class="text-lg font-bold text-slate-800  mb-2">Belum Ada Data Pengiriman / Inventaris</h3>
                                <p class="text-sm text-slate-500  mb-6">Data batch obat termolabil masih kosong. Tambahkan batch baru secara manual untuk memulai pelacakan stok dan kedaluwarsa.</p>
                                <button onclick="openQuickModal('terima')" class="px-5 py-2.5 bg-sky-600 hover:bg-sky-700 text-white rounded-xl text-sm font-bold transition-all duration-200 active:scale-95 shadow-md shadow-sky-500/20 flex items-center gap-2">
                                    <span class="material-symbols-outlined text-[18px]">add_box</span> Terima Batch Baru
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </x-table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 flex items-center justify-between border-t border-slate-200  bg-slate-50 ">
            <span class="text-xs text-slate-500 font-semibold uppercase tracking-wider">Menampilkan {{ $drugs->firstItem() ?? 0 }}-{{ $drugs->lastItem() ?? 0 }} dari {{ $drugs->total() }} data</span>
            <div class="flex gap-2">
                @if($drugs->onFirstPage())
                    <button class="p-1.5 bg-slate-100  rounded text-slate-400 cursor-not-allowed" disabled>
                        <span class="material-symbols-outlined text-[18px]">chevron_left</span>
                    </button>
                @else
                    <a href="{{ $drugs->previousPageUrl() }}" class="p-1.5 hover:bg-slate-100 :bg-slate-800 rounded text-slate-700  transition-colors">
                        <span class="material-symbols-outlined text-[18px]">chevron_left</span>
                    </a>
                @endif

                <span class="px-3 py-1.5 text-xs font-bold bg-primary text-on-primary rounded shadow-sm">{{ $drugs->currentPage() }}</span>

                @if($drugs->hasMorePages())
                    <a href="{{ $drugs->nextPageUrl() }}" class="p-1.5 hover:bg-slate-100 :bg-slate-800 rounded text-slate-700  transition-colors">
                        <span class="material-symbols-outlined text-[18px]">chevron_right</span>
                    </a>
                @else
                    <button class="p-1.5 bg-slate-100  rounded text-slate-400 cursor-not-allowed" disabled>
                        <span class="material-symbols-outlined text-[18px]">chevron_right</span>
                    </button>
                @endif
            </div>
        </div>
    </x-card>

    <!-- Inventory Movement Chart & Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-gutter pb-xl">
        <div class="bg-surface-container border border-outline-variant/30 p-lg rounded-xl">
            <div class="flex justify-between items-center mb-6">
                <h3 class="font-headline-sm text-headline-sm text-on-surface">Tren Tingkat Stok</h3>
                <select class="bg-surface-container-highest border-none text-label-md rounded-lg text-on-surface py-1 pr-8">
                    <option>30 Hari Terakhir</option>
                    <option>90 Hari Terakhir</option>
                </select>
            </div>
            <!-- Dynamic Chart Area (ApexCharts) -->
            <div id="chart-stok" class="h-48 w-full"></div>
        </div>

        <div class="bg-surface-container border border-outline-variant/30 p-lg rounded-xl flex flex-col">
            <h3 class="font-headline-sm text-headline-sm text-on-surface mb-6">Aksi Cepat</h3>
            <div class="grid grid-cols-2 gap-gutter flex-1">
                <button id="btn-quick-audit" class="flex flex-col items-center justify-center gap-3 p-gutter bg-surface-container-low hover:bg-surface-container-high border border-outline-variant/30 rounded-xl transition-all group active:scale-95">
                    <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center text-primary group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined">inventory</span>
                    </div>
                    <span class="text-label-md text-on-surface">Audit Stok</span>
                </button>
                <button id="btn-quick-transfer" class="flex flex-col items-center justify-center gap-3 p-gutter bg-surface-container-low hover:bg-surface-container-high border border-outline-variant/30 rounded-xl transition-all group active:scale-95">
                    <div class="w-12 h-12 rounded-full bg-tertiary/10 flex items-center justify-center text-tertiary group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined">sync_alt</span>
                    </div>
                    <span class="text-label-md text-on-surface">Transfer Batch</span>
                </button>
                <button id="btn-quick-report" class="flex flex-col items-center justify-center gap-3 p-gutter bg-surface-container-low hover:bg-surface-container-high border border-outline-variant/30 rounded-xl transition-all group active:scale-95">
                    <div class="w-12 h-12 rounded-full bg-error/10 flex items-center justify-center text-error group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined">assignment_late</span>
                    </div>
                    <span class="text-label-md text-on-surface">Laporkan Selisih</span>
                </button>
                <button id="btn-quick-restok" class="flex flex-col items-center justify-center gap-3 p-gutter bg-surface-container-low hover:bg-surface-container-high border border-outline-variant/30 rounded-xl transition-all group active:scale-95">
                    <div class="w-12 h-12 rounded-full bg-outline/10 flex items-center justify-center text-outline group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined">settings_backup_restore</span>
                    </div>
                    <span class="text-label-md text-on-surface">Aturan Restok</span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Reusable Quick Action Form Modal -->
<div id="quick-action-modal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-md bg-black/60 backdrop-blur-sm transition-opacity duration-300">
    <div class="bg-surface-container border border-outline-variant/30 rounded-2xl w-full max-w-md overflow-hidden shadow-2xl scale-95 opacity-0 transition-all duration-300 flex flex-col">
        <!-- Modal Header -->
        <div class="px-lg py-md border-b border-outline-variant/20 flex justify-between items-center bg-surface-container-high/50">
            <div class="flex items-center gap-sm">
                <span class="material-symbols-outlined text-primary">bolt</span>
                <h3 class="font-headline-sm text-headline-sm text-on-surface" id="quick-modal-title">Aksi Cepat</h3>
            </div>
            <button id="close-quick-modal" class="p-2 hover:bg-surface-container rounded-lg text-on-surface-variant hover:text-on-surface transition-colors">
                <span class="material-symbols-outlined text-[20px] align-middle">close</span>
            </button>
        </div>
        
        <!-- Modal Form -->
        <form id="quick-action-form" method="POST" onsubmit="return handleFormSubmit(this)">
            @csrf
            <div class="p-lg space-y-md" id="quick-modal-body">
                <!-- Dynamic form fields injected here -->
            </div>
            
            <!-- Modal Footer -->
            <div class="px-lg py-md border-t border-outline-variant/20 flex justify-end gap-sm bg-surface-container-low">
                <button type="button" id="close-quick-modal-btn" class="px-md py-2 border border-outline-variant/50 hover:bg-surface-container-high rounded-xl text-xs font-semibold text-on-surface transition-all active:scale-95">
                    Batal
                </button>
                <button type="submit" id="btn-quick-submit" class="px-md py-2 bg-primary text-on-primary hover:-translate-y-0.5 hover:shadow-lg rounded-xl text-xs font-semibold transition-all duration-300 ease-out active:scale-95 shadow-[0_0_12px_rgba(2,132,199,0.3)]">
                    Terapkan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Notification Toast Layer -->
<div class="fixed bottom-gutter right-gutter bg-surface-container border border-outline-variant/30 p-md rounded-xl border-l-4 border-primary translate-y-24 opacity-0 transition-all duration-500 z-50 pointer-events-none" id="toast">
    <div class="flex items-center gap-3">
        <span class="material-symbols-outlined text-primary">check_circle</span>
        <div>
            <div class="font-bold text-sm text-on-surface" id="toast-title">Aksi Berhasil</div>
            <div class="text-xs text-on-surface-variant" id="toast-desc">Transaksi database telah tercatat.</div>
        </div>
    </div>
</div>

<!-- Modal Buat Pengiriman -->
<div id="modalBuatPengiriman" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-[2000] hidden flex items-center justify-center">
    <div class="bg-surface border border-outline-variant/30 rounded-2xl w-full max-w-md overflow-hidden shadow-2xl relative">
        <div class="p-4 border-b border-outline-variant/20 bg-surface-container flex justify-between items-center">
            <h3 class="font-bold text-on-surface">Buat Rute Pengiriman Baru</h3>
            <button type="button" onclick="document.getElementById('modalBuatPengiriman').classList.add('hidden')" class="text-on-surface-variant hover:text-error transition-colors">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <form action="{{ route('shipments.store') }}" method="POST" class="p-5 space-y-4" onsubmit="return handleFormSubmit(this)">
            @csrf
            <div>
                <label class="block text-xs font-bold text-on-surface-variant mb-1">Kurir</label>
                <select name="id_kurir" required class="w-full bg-background border border-outline-variant/50 rounded-lg px-3 py-2 text-sm text-on-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                    <option value="">Pilih Kurir...</option>
                    @foreach($kurirs ?? [] as $kurir)
                        <option value="{{ $kurir->id_kurir }}">{{ $kurir->nama_lengkap }} ({{ $kurir->nomor_kendaraan }})</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-on-surface-variant mb-1">ID Boks (Kargo)</label>
                <input type="text" name="id_box" required placeholder="Contoh: BOX-001" class="w-full bg-background border border-outline-variant/50 rounded-lg px-3 py-2 text-sm text-on-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
            </div>
            <div>
                <label class="block text-xs font-bold text-on-surface-variant mb-1">Nama Kargo</label>
                <input type="text" name="nama_kargo" required placeholder="Contoh: Vaksin Sinovac 1000 Vial" class="w-full bg-background border border-outline-variant/50 rounded-lg px-3 py-2 text-sm text-on-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
            </div>
            <div>
                <label class="block text-xs font-bold text-on-surface-variant mb-1">Lokasi Tujuan</label>
                <select name="lokasi_tujuan" id="buat-pengiriman-tujuan" required class="w-full bg-background border border-outline-variant/50 rounded-lg px-3 py-2 text-sm text-on-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                    <option value="">Ketik untuk mencari faskes tujuan...</option>
                    <optgroup label="Rumah Sakit (RS)">
                        <option value="RSUP Dr. Mohammad Hoesin">RSUP Dr. Mohammad Hoesin (RSMH)</option>
                        <option value="RSUD Palembang BARI">RSUD Palembang BARI</option>
                        <option value="RSUD Siti Fatimah">RSUD Siti Fatimah</option>
                        <option value="RS Charitas">RS Charitas</option>
                        <option value="RS Muhammadiyah Palembang">RS Muhammadiyah Palembang</option>
                        <option value="RS Hermina Palembang">RS Hermina Palembang</option>
                        <option value="RS Bhayangkara">RS Bhayangkara</option>
                    </optgroup>
                    <optgroup label="Puskesmas">
                        <option value="Puskesmas Dempo">Puskesmas Dempo</option>
                        <option value="Puskesmas Sekip">Puskesmas Sekip</option>
                        <option value="Puskesmas Plaju">Puskesmas Plaju</option>
                        <option value="Puskesmas Kertapati">Puskesmas Kertapati</option>
                        <option value="Puskesmas Alang-Alang Lebar">Puskesmas Alang-Alang Lebar</option>
                        <option value="Puskesmas Gandus">Puskesmas Gandus</option>
                    </optgroup>
                </select>
            </div>
            <div class="pt-2 flex justify-end gap-2">
                <button type="button" onclick="document.getElementById('modalBuatPengiriman').classList.add('hidden')" class="px-4 py-2 rounded-lg border border-outline-variant text-on-surface-variant hover:bg-surface-container text-sm font-semibold transition-colors">Batal</button>
                <button type="submit" class="px-4 py-2 rounded-lg bg-primary text-on-primary hover:bg-primary/90 text-sm font-bold shadow-[0_4px_12px_rgba(6,182,212,0.3)] transition-all active:scale-95">Buat Pengiriman</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Scan QR Batch -->
<div id="modalQrScanner" class="fixed inset-0 bg-black/80 backdrop-blur-sm z-[2500] hidden flex items-center justify-center">
    <div class="bg-surface border border-outline-variant/30 rounded-2xl w-full max-w-md overflow-hidden shadow-2xl relative">
        <div class="p-4 border-b border-outline-variant/20 bg-surface-container flex justify-between items-center">
            <h3 class="font-bold text-on-surface flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">qr_code_scanner</span>
                Scan QR Konfirmasi Terima
            </h3>
            <button type="button" onclick="closeQrScannerModal()" class="text-on-surface-variant hover:text-error transition-colors">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <div class="p-4 bg-surface-container-lowest">
            <!-- Container for html5-qrcode -->
            <div id="qr-reader" class="w-full bg-black rounded-lg overflow-hidden border border-outline-variant/50"></div>
            
            <div id="qr-reader-results" class="hidden mt-4 p-4 rounded-xl border">
                <h4 class="text-sm font-bold text-on-surface mb-2" id="qr-batch-title">Detail Batch</h4>
                <div class="space-y-1 mb-4 text-sm text-on-surface-variant">
                    <p>Produk: <span id="qr-batch-product" class="font-mono text-primary font-bold"></span></p>
                    <p>Stok Tersedia: <span id="qr-batch-qty" class="font-bold"></span> vial</p>
                    <p>Suhu Rekomendasi: <span id="qr-batch-temp" class="font-bold"></span>&deg;C</p>
                    <p>Status: <span id="qr-batch-status" class="font-bold"></span></p>
                </div>
                <div class="flex gap-2">
                    <button id="btn-konfirmasi-qr" onclick="konfirmasiTerimaBatch()" class="flex-1 py-2 rounded-lg bg-green-500 text-white font-bold hover:bg-green-600 transition-colors">Konfirmasi Terima</button>
                    <button onclick="resetQrScanner()" class="px-4 py-2 rounded-lg border border-outline-variant hover:bg-surface-container transition-colors">Scan Ulang</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var options = {
            series: [{
                name: "Total Vial Obat",
                data: @json($stockTrend)
            }],
            xaxis: {
                categories: @json($stockTrendDates)
            },
            chart: {
                height: 180,
                type: 'area',
                toolbar: { show: false },
                sparkline: { enabled: true }
            },
            stroke: {
                curve: 'smooth',
                width: 3,
                colors: ['#06b6d4']
            },
            colors: ['#06b6d4'],
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.45,
                    opacityTo: 0.05,
                    stops: [50, 100, 100]
                }
            },
            tooltip: {
                theme: 'dark',
                x: { show: false }
            }
        };

        var chart = new ApexCharts(document.querySelector("#chart-stok"), options);
        chart.render();

        // --- Aksi Cepat Modals Interactivity ---
        const quickModal = document.getElementById('quick-action-modal');
        const modalBodyContent = document.getElementById('quick-modal-body');
        const modalFormTitle = document.getElementById('quick-modal-title');
        const closeQuickBtn = document.getElementById('close-quick-modal');
        const closeQuickBtn2 = document.getElementById('close-quick-modal-btn');
        const quickForm = document.getElementById('quick-action-form');
        const submitQuickBtn = document.getElementById('btn-quick-submit');

        const toast = document.getElementById('toast');
        const toastTitle = document.getElementById('toast-title');
        const toastDesc = document.getElementById('toast-desc');

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

        window.openQuickModal = openQuickModal;
        window.showToast = showToast;
        function openQuickModal(actionType) {
            submitQuickBtn.classList.remove('hidden');
            let html = '';
            let title = '';
            
            if (actionType === 'audit') {
                title = 'Audit Stok Fisik';
                quickForm.action = "{{ route('shipments.audit') }}";
                html = `
                    <div class="space-y-md">
                        <div>
                            <label class="block text-xs font-semibold text-outline uppercase tracking-wider mb-sm">Pilih Batch Obat</label>
                            <select name="no_batch" id="audit-batch" class="w-full bg-surface-container-lowest border border-outline-variant/50 rounded-lg px-md py-2.5 text-body-md text-on-surface focus:border-primary focus:ring-1 focus:ring-primary focus:outline-none">
                                @foreach($drugs as $drug)
                                    <option value="{{ $drug->no_batch }}">{{ $drug->no_batch }} ({{ $drug->nama_produk }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-outline uppercase tracking-wider mb-sm">Jumlah Riil di Gudang (Vial)</label>
                            <input type="number" name="qty_fisik" id="audit-count" class="w-full bg-surface-container-lowest border border-outline-variant/50 rounded-lg px-md py-2.5 text-body-md text-on-surface focus:border-primary focus:ring-1 focus:ring-primary focus:outline-none" placeholder="Masukkan jumlah fisik..." required>
                        </div>
                    </div>
                `;
            } else if (actionType === 'terima') {
                title = 'Terima Pengiriman';
                quickForm.action = "{{ route('shipments.terima') }}";
                html = `
                    <div class="space-y-md">
                        <div>
                            <label class="block text-xs font-semibold text-outline uppercase tracking-wider mb-sm">Scan / Input ID Batch Baru</label>
                            <input type="text" name="no_batch" id="terima-batch" class="w-full bg-surface-container-lowest border border-outline-variant/50 rounded-lg px-md py-2.5 text-body-md text-on-surface focus:border-primary focus:ring-1 focus:ring-primary focus:outline-none" placeholder="Contoh: BTCH-NEW01" required>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-outline uppercase tracking-wider mb-sm">Jenis Produk</label>
                            <select name="jenis" id="terima-type" class="w-full bg-surface-container-lowest border border-outline-variant/50 rounded-lg px-md py-2.5 text-body-md text-on-surface focus:border-primary focus:ring-1 focus:ring-primary focus:outline-none">
                                <option value="Vaksin">Vaksin</option>
                                <option value="Insulin">Insulin</option>
                                <option value="Serum Darah">Serum Darah</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-outline uppercase tracking-wider mb-sm">Suhu Penyimpanan (&deg;C)</label>
                            <input type="number" step="0.1" name="suhu" value="5.0" class="w-full bg-surface-container-lowest border border-outline-variant/50 rounded-lg px-md py-2.5 text-body-md text-on-surface focus:border-primary focus:ring-1 focus:ring-primary focus:outline-none" required>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-outline uppercase tracking-wider mb-sm">Jumlah Diterima (Vial)</label>
                            <input type="number" name="qty" id="terima-qty" class="w-full bg-surface-container-lowest border border-outline-variant/50 rounded-lg px-md py-2.5 text-body-md text-on-surface focus:border-primary focus:ring-1 focus:ring-primary focus:outline-none" placeholder="Masukkan jumlah vial..." required>
                        </div>
                    </div>
                `;
            } else if (actionType === 'transfer') {
                title = 'Transfer Batch Rute';
                quickForm.action = "{{ route('shipments.transfer') }}";
                html = `
                    <div class="space-y-md">
                        <div>
                            <label class="block text-xs font-semibold text-outline uppercase tracking-wider mb-sm">Pilih Batch Obat</label>
                            <select name="no_batch" id="transfer-batch" class="w-full bg-surface-container-lowest border border-outline-variant/50 rounded-lg px-md py-2.5 text-body-md text-on-surface focus:border-primary focus:ring-1 focus:ring-primary focus:outline-none">
                                @foreach($drugs as $drug)
                                    <option value="{{ $drug->no_batch }}">{{ $drug->no_batch }} ({{ $drug->nama_produk }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-outline uppercase tracking-wider mb-sm">Fasilitas Kesehatan Tujuan</label>
                            <select name="lokasi_tujuan" id="transfer-dest" class="w-full bg-surface-container-lowest border border-outline-variant/50 rounded-lg px-md py-2.5 text-body-md text-on-surface focus:border-primary focus:ring-1 focus:ring-primary focus:outline-none">
                                <option value="">Ketik untuk mencari faskes tujuan...</option>
                                <optgroup label="Rumah Sakit (RS)" class="bg-surface-container font-semibold text-primary">
                                    <option value="RSUP Dr. Mohammad Hoesin">RSUP Dr. Mohammad Hoesin (RSMH)</option>
                                    <option value="RSUD Palembang BARI">RSUD Palembang BARI</option>
                                    <option value="RSUD Siti Fatimah">RSUD Siti Fatimah</option>
                                    <option value="RS Charitas">RS Charitas</option>
                                    <option value="RS Muhammadiyah Palembang">RS Muhammadiyah Palembang</option>
                                    <option value="RS Hermina Palembang">RS Hermina Palembang</option>
                                    <option value="RS Bhayangkara">RS Bhayangkara</option>
                                </optgroup>
                                <optgroup label="Puskesmas" class="bg-surface-container font-semibold text-tertiary">
                                    <option value="Puskesmas Dempo">Puskesmas Dempo</option>
                                    <option value="Puskesmas Sekip">Puskesmas Sekip</option>
                                    <option value="Puskesmas Plaju">Puskesmas Plaju</option>
                                    <option value="Puskesmas Kertapati">Puskesmas Kertapati</option>
                                    <option value="Puskesmas Alang-Alang Lebar">Puskesmas Alang-Alang Lebar</option>
                                    <option value="Puskesmas Gandus">Puskesmas Gandus</option>
                                </optgroup>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-outline uppercase tracking-wider mb-sm">Jumlah Vial</label>
                            <input type="number" name="qty" id="transfer-qty" class="w-full bg-surface-container-lowest border border-outline-variant/50 rounded-lg px-md py-2.5 text-body-md text-on-surface focus:border-primary focus:ring-1 focus:ring-primary focus:outline-none" placeholder="Masukkan jumlah transfer..." required>
                        </div>
                    </div>
                `;
            } else if (actionType === 'report') {
                title = 'Laporkan Selisih';
                quickForm.action = "{{ route('shipments.lapor') }}";
                html = `
                    <div class="space-y-md">
                        <div>
                            <label class="block text-xs font-semibold text-outline uppercase tracking-wider mb-sm">Pilih Batch Terkait</label>
                            <select name="no_batch" id="report-batch" class="w-full bg-surface-container-lowest border border-outline-variant/50 rounded-lg px-md py-2.5 text-body-md text-on-surface focus:border-primary focus:ring-1 focus:ring-primary focus:outline-none">
                                @foreach($drugs as $drug)
                                    <option value="{{ $drug->no_batch }}">{{ $drug->no_batch }} ({{ $drug->nama_produk }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-outline uppercase tracking-wider mb-sm">Jenis Selisih</label>
                            <select name="jenis_selisih" id="report-type" class="w-full bg-surface-container-lowest border border-outline-variant/50 rounded-lg px-md py-2.5 text-body-md text-on-surface focus:border-primary focus:ring-1 focus:ring-primary focus:outline-none">
                                <option value="Hilang / Rusak Fisik">Hilang / Rusak Fisik</option>
                                <option value="Selisih Perhitungan Sistem">Selisih Perhitungan Sistem</option>
                                <option value="Karantina karena Fluktuasi">Karantina karena Fluktuasi</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-outline uppercase tracking-wider mb-sm">Keterangan / Catatan</label>
                            <textarea name="catatan" id="report-notes" rows="3" class="w-full bg-surface-container-lowest border border-outline-variant/50 rounded-lg px-md py-2.5 text-body-md text-on-surface focus:border-primary focus:ring-1 focus:ring-primary focus:outline-none" placeholder="Masukkan catatan tambahan..." required></textarea>
                        </div>
                    </div>
                `;
            } else if (actionType === 'restok') {
                title = 'Aturan Restok Otomatis';
                quickForm.action = "{{ route('shipments.restok') }}";
                html = `
                    <div class="space-y-md">
                        <div>
                            <label class="block text-xs font-semibold text-outline uppercase tracking-wider mb-sm">Jenis Produk</label>
                            <select name="jenis_obat" id="restok-type" class="w-full bg-surface-container-lowest border border-outline-variant/50 rounded-lg px-md py-2.5 text-body-md text-on-surface focus:border-primary focus:ring-1 focus:ring-primary focus:outline-none">
                                <option value="Semua Kategori">Semua Kategori</option>
                                <option value="Vaksin">Vaksin</option>
                                <option value="Insulin">Insulin</option>
                                <option value="Serum Darah">Serum Darah</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-outline uppercase tracking-wider mb-sm">Batas Minimum Stok Alert (Vial)</label>
                            <input type="number" name="ambang_minimum" id="restok-min" value="5000" class="w-full bg-surface-container-lowest border border-outline-variant/50 rounded-lg px-md py-2.5 text-body-md text-on-surface focus:border-primary focus:ring-1 focus:ring-primary focus:outline-none" required>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-outline uppercase tracking-wider mb-sm">Jumlah Pemesanan Otomatis (Vial)</label>
                            <input type="number" name="jumlah_restok" id="restok-qty" value="20000" class="w-full bg-surface-container-lowest border border-outline-variant/50 rounded-lg px-md py-2.5 text-body-md text-on-surface focus:border-primary focus:ring-1 focus:ring-primary focus:outline-none" required>
                        </div>
                    </div>
                `;
            }

            modalFormTitle.textContent = title;
            modalBodyContent.innerHTML = html;
            
            if (actionType === 'transfer' && typeof TomSelect !== 'undefined') {
                if (window.tsBatch) window.tsBatch.destroy();
                if (window.tsDest) window.tsDest.destroy();
                setTimeout(() => {
                    window.tsBatch = new TomSelect('#transfer-batch', { create: false, sortField: { field: "text", direction: "asc" } });
                    window.tsDest = new TomSelect('#transfer-dest', { create: false, sortField: { field: "text", direction: "asc" } });
                }, 50);
            }
            quickModal.classList.remove('hidden');
            setTimeout(() => {
                quickModal.classList.remove('opacity-0');
                quickModal.querySelector('.bg-surface-container').classList.remove('scale-95', 'opacity-0');
            }, 50);
        }

        function openColdChainModal(batch, name, temp) {
            const tempNum = parseFloat(temp);
            const rangeText = tempNum <= -70 ? '-80&deg;C s/d -60&deg;C' : (tempNum <= -20 ? '-25&deg;C s/d -15&deg;C' : '2&deg;C s/d 8&deg;C');
            const rangeLabel = tempNum <= -70 ? 'Ultra-Cold' : (tempNum <= -20 ? 'Frozen' : 'Chilled');
            const colorClass = tempNum <= -70 ? 'text-cyan-500' : (tempNum <= -20 ? 'text-blue-500' : 'text-teal-600 ');
            const icon = tempNum <= -70 ? 'severe_cold' : (tempNum <= -20 ? 'kitchen' : 'thermostat');

            modalFormTitle.textContent = 'Analisis Stabilitas Rantai Dingin';
            submitQuickBtn.classList.add('hidden'); // Hide submit for read-only modal
            
            modalBodyContent.innerHTML = `
                <div class="space-y-md text-left select-none">
                    <div class="p-4 bg-slate-100/50  rounded-xl border border-slate-200/50  flex flex-col gap-1">
                        <div class="flex justify-between items-center text-xs">
                            <span class="font-bold text-slate-900 ">${name}</span>
                            <span class="font-mono text-primary font-bold">#${batch}</span>
                        </div>
                        <div class="flex items-center gap-1.5 mt-2 ${colorClass}">
                            <span class="material-symbols-outlined text-[16px]">${icon}</span>
                            <span class="font-bold text-xs">${rangeLabel} (${rangeText})</span>
                        </div>
                        <div class="text-[10px] text-slate-500  mt-1">
                            Target Suhu Penyimpanan: <strong class="text-on-surface font-mono">${tempNum.toFixed(1)}&deg;C</strong>
                        </div>
                    </div>
                    
                    <div class="p-4 bg-slate-100/30  rounded-xl border border-slate-200/30 ">
                        <label class="block text-[10px] font-bold text-slate-500  uppercase tracking-wider mb-sm">Log Sensor Stabilitas Termal (24 Jam Terakhir)</label>
                        <div class="space-y-2 text-[11px] font-medium text-slate-700  font-mono">
                            <div class="flex justify-between border-b border-slate-200  pb-1">
                                <span>10:00 (Sekarang)</span>
                                <span class="text-green-500 font-bold">${tempNum.toFixed(1)}&deg;C [Aman]</span>
                            </div>
                            <div class="flex justify-between border-b border-slate-200  pb-1">
                                <span>08:00 (2 Jam lalu)</span>
                                <span class="text-green-500 font-bold">${(tempNum + 0.2).toFixed(1)}&deg;C [Aman]</span>
                            </div>
                            <div class="flex justify-between border-b border-slate-200  pb-1">
                                <span>04:00 (6 Jam lalu)</span>
                                <span class="text-green-500 font-bold">${(tempNum - 0.1).toFixed(1)}&deg;C [Aman]</span>
                            </div>
                            <div class="flex justify-between border-b border-slate-200  pb-1">
                                <span>22:00 (12 Jam lalu)</span>
                                <span class="text-green-500 font-bold">${(tempNum + 0.1).toFixed(1)}&deg;C [Aman]</span>
                            </div>
                            <div class="flex justify-between">
                                <span>14:00 (20 Jam lalu)</span>
                                <span class="text-green-500 font-bold">${tempNum.toFixed(1)}&deg;C [Aman]</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-3 border border-green-500/20 bg-green-500/10 rounded-xl flex items-center gap-2">
                        <span class="material-symbols-outlined text-green-500 text-[20px]">verified</span>
                        <div class="text-[10px] text-green-600  leading-relaxed font-semibold">
                            Suhu boks penyimpanan terpantau stabil. Standar CDOB dan Cold Chain terpenuhi sepenuhnya.
                        </div>
                    </div>
                </div>
            `;
            
            quickModal.classList.remove('hidden');
            setTimeout(() => {
                quickModal.classList.remove('opacity-0');
                quickModal.querySelector('.bg-surface-container').classList.remove('scale-95', 'opacity-0');
            }, 50);
        }
        window.openColdChainModal = openColdChainModal;

        function closeQuickModal() {
            quickModal.classList.add('opacity-0');
            quickModal.querySelector('.bg-surface-container').classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                quickModal.classList.add('hidden');
            }, 300);
        }

        document.getElementById('btn-quick-audit').addEventListener('click', () => openQuickModal('audit'));
        document.getElementById('btn-quick-transfer').addEventListener('click', () => openQuickModal('transfer'));
        document.getElementById('btn-quick-report').addEventListener('click', () => openQuickModal('report'));
        document.getElementById('btn-quick-restok').addEventListener('click', () => openQuickModal('restok'));

        if (closeQuickBtn) closeQuickBtn.addEventListener('click', closeQuickModal);
        if (closeQuickBtn2) closeQuickBtn2.addEventListener('click', closeQuickModal);

        // No longer intercepting form submission with preventDefault! Let it naturally post to backend.

        // ========================================
        // REAL-TIME LIVE POLLING - Inventaris
        // ========================================
        function formatNumber(n) {
            return new Intl.NumberFormat('id-ID').format(n);
        }

        function pollShipmentData() {
            fetch('/api/shipments/live', {
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                }
            })
            .then(res => res.json())
            .then(data => {
                if (!data.success) return;
                const s = data.stats;

                // Update stat cards with animation
                const updates = [
                    { id: 'live-total-stok', value: formatNumber(s.totalStok) },
                    { id: 'live-segera-kadaluwarsa', value: formatNumber(s.segeraKadaluwarsa) },
                    { id: 'live-aset-karantina', value: formatNumber(s.asetKarantina) },
                    { id: 'live-kapasitas', value: s.kapasitasUtilisasi + '%' },
                ];

                updates.forEach(u => {
                    const el = document.getElementById(u.id);
                    if (el && el.textContent.trim() !== u.value) {
                        el.style.transition = 'all 0.3s ease';
                        el.style.opacity = '0.5';
                        el.style.transform = 'scale(0.95)';
                        setTimeout(() => {
                            el.textContent = u.value;
                            el.style.opacity = '1';
                            el.style.transform = 'scale(1)';
                        }, 150);
                    }
                });

                // Update table stock values
                if (data.drugs && Array.isArray(data.drugs)) {
                    data.drugs.forEach(drug => {
                        const stokEl = document.getElementById('stok-' + drug.no_batch);
                        if (stokEl) {
                            const newVal = formatNumber(drug.stok);
                            if (stokEl.textContent.trim() !== newVal) {
                                stokEl.style.color = '#0ea5e9';
                                stokEl.textContent = newVal;
                                setTimeout(() => { stokEl.style.color = ''; }, 1000);
                            }
                        }
                        const statusEl = document.getElementById('status-' + drug.no_batch);
                        if (statusEl && statusEl.textContent.trim() !== drug.status) {
                            statusEl.textContent = drug.status;
                        }
                    });
                }
            })
            .catch(err => console.warn('[BIO-GUARD Shipments] Poll error:', err));
        }

        // Poll every 3 seconds
        setInterval(pollShipmentData, 3000);
        console.log('[BIO-GUARD] Shipments real-time polling started (3s interval)');
        // Initialize TomSelect for "Buat Pengiriman" modal
        if (typeof TomSelect !== 'undefined') {
            new TomSelect('#buat-pengiriman-tujuan', {
                create: false,
                sortField: { field: "text", direction: "asc" },
                placeholder: 'Ketik untuk mencari faskes tujuan...'
            });
        }
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
<style>
.ts-control {
    background-color: var(--color-surface-container-lowest, #ffffff) !important;
    border-color: rgba(var(--color-outline-variant, 0,0,0), 0.5) !important;
    border-radius: 0.5rem !important;
    padding: 0.625rem 1rem !important;
    font-size: 0.875rem !important;
    color: var(--color-on-surface, #000000) !important;
}
.dark .ts-control {
    background-color: #0f172a !important;
    border-color: #334155 !important;
    color: #f8fafc !important;
}
.ts-dropdown {
    border-radius: 0.5rem !important;
    overflow: hidden;
    font-size: 0.875rem !important;
    z-index: 9999 !important;
}
.dark .ts-dropdown {
    background-color: #0f172a !important;
    border-color: #334155 !important;
    color: #f8fafc !important;
}
.ts-dropdown .option {
    padding: 0.5rem 1rem;
}
.dark .ts-dropdown .option {
    color: #e2e8f0 !important;
}
.ts-dropdown .active {
    background-color: #0ea5e9 !important;
    color: #ffffff !important;
}
</style>
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

<script>
    let html5QrCode = null;
    let currentScannedBatch = null;

    function openQrScannerModal() {
        document.getElementById('modalQrScanner').classList.remove('hidden');
        resetQrScanner();
    }

    function closeQrScannerModal() {
        document.getElementById('modalQrScanner').classList.add('hidden');
        if (html5QrCode) {
            html5QrCode.stop().then(() => {
                html5QrCode.clear();
                html5QrCode = null;
            }).catch(error => {
                console.error("Failed to stop html5QrCode. ", error);
                html5QrCode = null;
            });
        }
    }

    function resetQrScanner() {
        document.getElementById('qr-reader').classList.remove('hidden');
        document.getElementById('qr-reader-results').classList.add('hidden');
        currentScannedBatch = null;
        
        if (html5QrCode) {
            html5QrCode.stop().then(() => {
                startScanner();
            }).catch(error => {
                console.error("Failed to stop html5QrCode. ", error);
                startScanner();
            });
        } else {
            startScanner();
        }
    }

    function startScanner() {
        if (!html5QrCode) {
            html5QrCode = new Html5Qrcode("qr-reader");
        }
        html5QrCode.start(
            { facingMode: "environment" },
            {
                fps: 10,
                qrbox: { width: 300, height: 300 },
                aspectRatio: 1.0
            },
            onScanSuccess,
            onScanFailure
        ).catch((err) => {
            console.error("Gagal memulai kamera", err);
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: 'Gagal mengakses kamera. Pastikan browser memiliki izin kamera.',
                confirmButtonColor: '#0ea5e9'
            });
        });
    }

    function onScanSuccess(decodedText, decodedResult) {
        // Allow all scanned text, or you can add specific logic here if needed.
        if (!decodedText || decodedText.trim() === '') {
            return; 
        }

        // Stop scanner to prevent multiple requests
        if (html5QrCode) {
            html5QrCode.stop().then(() => {
                document.getElementById('qr-reader').classList.add('hidden');
                fetchBatchDetail(decodedText);
            }).catch(error => {
                console.error("Failed to stop scanner.", error);
            });
        }
    }

    function onScanFailure(error) {
        // Handle scan failure, usually better to ignore and keep scanning
    }

    function handleFormSubmit(form) {
        const btn = form.querySelector('button[type="submit"]');
        if (btn) {
            btn.disabled = true;
            btn.innerHTML = '<span class="material-symbols-outlined animate-spin text-[18px]">progress_activity</span> Memproses...';
        }
        return true;
    }

    async function fetchBatchDetail(batchId) {
        try {
            const response = await fetch(`/pengiriman/batch/${batchId}`);
            const result = await response.json();
            
            if (result.success) {
                currentScannedBatch = result.data.no_batch;
                document.getElementById('qr-batch-title').innerText = `Batch: ${result.data.no_batch}`;
                document.getElementById('qr-batch-product').innerText = result.data.nama_produk;
                document.getElementById('qr-batch-qty').innerText = result.data.stok;
                document.getElementById('qr-batch-temp').innerText = result.data.suhu_penyimpanan;
                document.getElementById('qr-batch-status').innerText = result.data.status;
                
                if (result.data.diterima_oleh !== null) {
                    document.getElementById('qr-batch-status').innerText = 'SUDAH DITERIMA';
                    document.getElementById('qr-batch-status').className = 'text-error font-bold';
                    document.getElementById('btn-konfirmasi-qr').classList.add('hidden');
                } else {
                    document.getElementById('qr-batch-status').className = 'text-success font-bold';
                    document.getElementById('btn-konfirmasi-qr').classList.remove('hidden');
                }
                
                document.getElementById('qr-reader-results').classList.remove('hidden');
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: result.message || 'Batch tidak ditemukan.',
                    confirmButtonColor: '#0ea5e9'
                });
                resetQrScanner();
            }
        } catch (error) {
            console.error('Error fetching batch detail:', error);
            Swal.fire({
                icon: 'error',
                title: 'Koneksi Gagal',
                text: 'Terjadi kesalahan saat mengambil data batch.',
                confirmButtonColor: '#0ea5e9'
            });
            resetQrScanner();
        }
    }

    async function konfirmasiTerimaBatch() {
        if (!currentScannedBatch) return;
        
        const btn = document.getElementById('btn-konfirmasi-qr');
        btn.disabled = true;
        btn.innerHTML = '<span class="material-symbols-outlined animate-spin text-[18px]">progress_activity</span> Memproses...';
        
        try {
            const response = await fetch(`/pengiriman/batch/${currentScannedBatch}/konfirmasi`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });
            const result = await response.json();
            
            if (result.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: result.message,
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    closeQrScannerModal();
                    window.location.reload();
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: result.message || 'Gagal mengonfirmasi batch.',
                    confirmButtonColor: '#0ea5e9'
                });
                btn.disabled = false;
                btn.innerText = 'Konfirmasi Terima';
            }
        } catch (error) {
            console.error('Error confirming batch:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Terjadi kesalahan jaringan saat memproses konfirmasi.',
                confirmButtonColor: '#0ea5e9'
            });
            btn.disabled = false;
            btn.innerText = 'Konfirmasi Terima';
        }
    }
    
    function openHistoryModal(batchId, productName) {
        // Build and append modal if it doesn't exist yet
        let modal = document.getElementById('modalHistory');
        if (!modal) {
            document.body.insertAdjacentHTML('beforeend', `
            <div id="modalHistory" class="fixed inset-0 bg-black/80 backdrop-blur-sm z-[2500] hidden flex items-center justify-center">
                <div class="bg-surface border border-outline-variant/30 rounded-2xl w-full max-w-2xl overflow-hidden shadow-2xl relative">
                    <div class="p-4 border-b border-outline-variant/20 bg-surface-container flex justify-between items-center">
                        <h3 class="font-bold text-on-surface flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary">history</span>
                            Riwayat Transaksi Stok: <span id="history-batch-name" class="text-primary ml-1"></span>
                        </h3>
                        <button type="button" onclick="document.getElementById('modalHistory').classList.add('hidden')" class="text-on-surface-variant hover:text-error transition-colors">
                            <span class="material-symbols-outlined">close</span>
                        </button>
                    </div>
                    <div class="p-4 bg-surface-container-lowest max-h-[60vh] overflow-y-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="text-xs uppercase text-slate-500 border-b border-outline-variant/50">
                                    <th class="py-2 pr-2">Waktu</th>
                                    <th class="py-2 px-2">Tipe</th>
                                    <th class="py-2 px-2">Jumlah</th>
                                    <th class="py-2 px-2">Sumber</th>
                                    <th class="py-2 pl-2">Dilakukan Oleh</th>
                                </tr>
                            </thead>
                            <tbody id="history-tbody" class="text-sm text-slate-700">
                            </tbody>
                        </table>
                        <div id="history-loading" class="text-center py-8 text-slate-500 hidden">
                            <span class="material-symbols-outlined animate-spin text-[32px]">progress_activity</span>
                            <p class="mt-2 text-xs">Memuat data riwayat...</p>
                        </div>
                        <div id="history-empty" class="text-center py-8 text-slate-500 hidden">
                            <span class="material-symbols-outlined text-[32px]">history_toggle_off</span>
                            <p class="mt-2 text-xs">Belum ada transaksi untuk batch ini.</p>
                        </div>
                    </div>
                </div>
            </div>
            `);
            modal = document.getElementById('modalHistory');
        }

        document.getElementById('history-batch-name').innerText = productName + ' (#' + batchId + ')';
        document.getElementById('history-tbody').innerHTML = '';
        document.getElementById('history-loading').classList.remove('hidden');
        document.getElementById('history-empty').classList.add('hidden');
        modal.classList.remove('hidden');

        fetch('/pengiriman/batch/' + batchId + '/history')
            .then(res => res.json())
            .then(data => {
                document.getElementById('history-loading').classList.add('hidden');
                if (data.success && data.data.length > 0) {
                    let html = '';
                    data.data.forEach(tx => {
                        let typeColor = tx.tipe === 'masuk' ? 'text-green-600 bg-green-100' : 'text-red-600 bg-red-100';
                        let date = new Date(tx.waktu_transaksi).toLocaleString('id-ID');
                        let user = tx.user ? tx.user.name : 'Sistem';
                        let src = tx.sumber_transaksi.replace(/_/g, ' ').toUpperCase();
                        
                        html += `
                        <tr class="border-b border-outline-variant/30 hover:bg-slate-50">
                            <td class="py-3 pr-2 text-xs font-mono">${date}</td>
                            <td class="py-3 px-2">
                                <span class="px-2 py-0.5 rounded text-xs font-bold ${typeColor}">${tx.tipe.toUpperCase()}</span>
                            </td>
                            <td class="py-3 px-2 font-bold tabular-nums">${tx.jumlah}</td>
                            <td class="py-3 px-2 text-xs">${src} ${tx.id_referensi ? ' (Rute: '+tx.id_referensi+')' : ''}</td>
                            <td class="py-3 pl-2 text-xs font-semibold">${user}</td>
                        </tr>
                        `;
                    });
                    document.getElementById('history-tbody').innerHTML = html;
                } else {
                    document.getElementById('history-empty').classList.remove('hidden');
                }
            })
            .catch(err => {
                console.error(err);
                document.getElementById('history-loading').classList.add('hidden');
                document.getElementById('history-empty').classList.remove('hidden');
                document.getElementById('history-empty').querySelector('p').innerText = 'Gagal memuat data riwayat.';
            });
    }
</script>

@endpush


