@extends('layouts.app')

@section('title', 'Pusat Peringatan Sistem')

@section('content')
<div class="flex-1 w-full min-h-full p-container-margin space-y-lg">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-end gap-md mb-md">
        <div>
            <nav class="flex text-label-md text-outline mb-1 gap-2">
                <span>BIO-GUARD</span> / <span class="text-primary font-semibold">Pusat Peringatan</span>
            </nav>
            <h1 class="font-headline-lg text-headline-lg text-on-background">Peringatan Sistem Global</h1>
            <p class="text-on-surface-variant mt-1 text-body-sm">Sistem pemantauan waktu nyata dan pusat kendali respon cepat.</p>
        </div>
        <div class="px-lg py-sm bg-surface-container-low border border-outline-variant/30 rounded-xl text-right">
            <p class="font-label-md text-label-md text-on-surface-variant uppercase tracking-tighter">Status Saat Ini</p>
            @php
                $activeCount = $incidents->where('status', 'aktif')->count();
            @endphp
            @if($activeCount > 0)
                <p class="font-headline-sm text-headline-sm text-error flex items-center justify-end gap-2 font-semibold animate-pulse">
                    <span class="w-2.5 h-2.5 rounded-full bg-error animate-ping"></span>
                    ANOMALI AKTIF (<span id="live-active-count">{{ $activeCount }}</span>)
                </p>
            @else
                <p class="font-headline-sm text-headline-sm text-green-400 flex items-center justify-end gap-2 font-semibold">
                    <span class="w-2.5 h-2.5 rounded-full bg-green-400"></span>
                    SISTEM KONDISI AMAN
                </p>
            @endif
        </div>
    </div>

    <!-- Command Center Bento Grid -->
    <div class="grid grid-cols-12 gap-gutter mb-md">
        <!-- Hero Stats -->
        <div class="col-span-12 lg:col-span-8 grid grid-cols-1 sm:grid-cols-3 gap-gutter">
            <div class="bg-surface-container border border-outline-variant/30 p-lg rounded-xl flex flex-col justify-between relative overflow-hidden group hover:border-error/40 transition-colors">
                <p class="font-label-md text-label-md text-on-surface-variant uppercase">Peringatan Kritis Aktif</p>
                <h3 class="font-display-lg text-display-lg text-error mt-xs font-bold shadow-[0_0_15px_rgba(255,180,171,0.2)]" id="hero-critical-count">
                    {{ $incidents->where('status', 'aktif')->where('jenis_insiden', 'Tidak Layak Pakai')->count() }}
                </h3>
                <p class="font-label-md text-label-md text-error-container mt-xs flex items-center gap-1">
                    <span class="material-symbols-outlined text-[14px]">warning</span>
                    Butuh penanganan segera
                </p>
            </div>
            <div class="bg-surface-container border border-outline-variant/30 p-lg rounded-xl flex flex-col justify-between hover:border-primary/40 transition-colors">
                <p class="font-label-md text-label-md text-on-surface-variant uppercase">Kesehatan Rantai Dingin</p>
                @php
                    $health = $activeCount > 0 ? max(50, 100 - ($activeCount * 12.5)) : 100;
                @endphp
                <h3 class="font-display-lg text-display-lg text-primary mt-xs font-bold" id="live-health">{{ number_format($health, 1, ',', '.') }}%</h3>
                <div class="w-full h-1 bg-surface-variant rounded-full mt-md overflow-hidden">
                    <div class="h-full bg-primary shadow-[0_0_8px_rgba(76,215,246,0.4)]" style="width: {{ $health }}%" id="health-bar"></div>
                </div>
            </div>
            <div class="bg-surface-container border border-outline-variant/30 p-lg rounded-xl flex flex-col justify-between hover:border-primary/40 transition-colors">
                <p class="font-label-md text-label-md text-on-surface-variant uppercase">MTTR Respon Rata-rata</p>
                <h3 class="font-display-lg text-display-lg text-on-surface mt-xs font-bold">14<span class="text-headline-md ml-1 opacity-60 font-normal text-outline">menit</span></h3>
                <p class="font-label-md text-label-md text-on-surface-variant mt-xs">Kepatuhan standar audit faskes</p>
            </div>
        </div>
        <!-- Small Map -->
        <div class="col-span-12 lg:col-span-4 bg-surface-container border border-outline-variant/30 rounded-xl overflow-hidden relative group min-h-[160px]">
            <div class="absolute inset-0 bg-surface-container-highest z-0">
                <img class="w-full h-full object-cover opacity-60  mix-blend-luminosity grayscale border border-outline-variant/30" alt="Hazard map" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDIMLx22L1e9xIYjaVBhIsxryBUkBKqSdXb3o60Oxn9oKoL1wkFkEGePIuzPzLt7Q9tgHIwnNsC7FI5EG_Vs22GsouzHEoWcJI4_FniQfn4iNcL9klzpTqTZi6l4n40xxdW4Xr57ZDw6U4g9yLARLru7Omyl4PeEcuhJ3bVcNz_e7x52pNj8N10zjPX2VTwJKv2DVk0KVxZhA90F92pCYthDxkf87uI2hGbU3Zz-dkutBGxfBXWCvV2Mx8d3UaqWyclaXqbnMd2cA"/>
            </div>
            <div class="absolute inset-0 bg-gradient-to-t from-background via-transparent to-transparent"></div>
            <div class="relative z-10 p-md flex flex-col h-full justify-between">
                <div class="flex justify-between items-start">
                    <span class="bg-surface-container-high/80 backdrop-blur-sm border border-outline-variant/40 px-sm py-xs rounded text-[10px] font-bold text-on-surface tracking-wider">DISTRIBUSI SPASIAL</span>
                </div>
                <div class="space-y-2">
                    <div class="flex items-center justify-between bg-background/75 backdrop-blur-sm p-2 rounded border border-outline-variant/20">
                        <span class="text-error font-bold text-xs">LOGISTIK PALEMBANG</span>
                        <span class="text-on-surface-variant text-[10px] font-semibold" id="active-incident-badge">{{ $activeCount }} INSIDEN AKTIF</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Area: Alert Feed & Config -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-gutter">
        <!-- Real-time Alert Feed -->
        <div class="lg:col-span-8 space-y-md">
            <div class="flex items-center justify-between">
                <h4 class="font-headline-sm text-headline-sm text-on-surface">Aliran Insiden Aktif</h4>
                <span class="text-xs text-outline font-semibold">Real-Time Telemetri Terhubung</span>
            </div>
            
            <div class="space-y-sm" id="live-alert-feed">
                @forelse($incidents->where('status', 'aktif') as $incident)
                <div id="incident-card-{{ $incident->id }}" class="bg-surface-container/60 backdrop-blur-md p-md rounded-lg flex items-center gap-md border border-outline-variant/30 {{ $incident->jenis_insiden === 'Tidak Layak Pakai' ? 'border-l-4 border-l-error hover:border-error/50 ring-1 ring-error/20' : 'border-l-4 border-l-tertiary hover:border-tertiary/50' }} transition-all duration-300">
                    <div class="w-10 h-10 rounded flex items-center justify-center shrink-0 {{ $incident->jenis_insiden === 'Tidak Layak Pakai' ? 'bg-error/10 text-error shadow-[0_0_8px_rgba(239,68,68,0.3)] animate-pulse' : 'bg-tertiary/10 text-tertiary shadow-[0_0_8px_rgba(255,185,95,0.2)]' }}">
                        <span class="material-symbols-outlined text-[20px]">
                            {{ $incident->jenis_insiden === 'Tidak Layak Pakai' ? 'error' : 'warning' }}
                        </span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex justify-between items-start">
                            <h5 class="font-body-md text-body-md font-bold {{ $incident->jenis_insiden === 'Tidak Layak Pakai' ? 'text-error' : 'text-tertiary' }}">
                                {{ $incident->jenis_insiden }} (BOX-{{ $incident->perjalananRute->id_box ?? 'N/A' }})
                            </h5>
                            <span class="text-on-surface-variant font-data-mono text-data-mono text-xs">{{ $incident->created_at->format('H:i:s') }}</span>
                        </div>
                        <p class="text-on-surface text-xs mt-1">{{ $incident->deskripsi }}</p>
                        <div class="flex items-center gap-4 mt-2 text-[10px] text-outline">
                            <span>Suhu Tercatat: <span class="font-data-mono font-bold text-on-surface">{{ number_format($incident->suhu_tercatat, 1, ',', '.') }}Â&deg;C</span></span>
                            <span>Durasi Ekskursi: <span class="font-data-mono font-bold text-on-surface">{{ $incident->durasi_anomali }} detik</span></span>
                        </div>
                    </div>
                    <div class="flex gap-xs">
                        <button class="btn-view-log px-md py-sm bg-slate-100 hover:bg-slate-200  :bg-slate-700 text-on-surface rounded border border-outline-variant/30 transition-all font-label-md text-[10px] font-bold"
                                data-id="#BG-{{ $incident->id }}"
                                data-type="{{ $incident->jenis_insiden }}"
                                data-level="{{ $incident->jenis_insiden === 'Tidak Layak Pakai' ? 'KRITIS' : 'PERINGATAN' }}"
                                data-duration="{{ $incident->durasi_anomali }} detik"
                                data-temp="{{ number_format($incident->suhu_tercatat, 1, ',', '.') }}Â&deg;C"
                                data-desc="{{ $incident->deskripsi }}"
                                data-time="{{ $incident->created_at->format('Y-m-d H:i:s') }}"
                                data-status="aktif">
                            DETAIL
                        </button>
                        <button onclick="resolveIncident({{ $incident->id }})" class="px-md py-sm bg-primary/10 text-primary hover:bg-primary/20 rounded border border-primary/20 transition-all font-label-md text-[10px] font-bold">
                            KONFIRMASI
                        </button>
                    </div>
                </div>
                @empty
                <div class="bg-surface-container/30 p-lg rounded-lg border border-outline-variant/20 text-center text-outline" id="no-incidents-view">
                    <span class="material-symbols-outlined text-green-400 text-3xl mb-2">check_circle</span>
                    <div class="text-sm font-semibold text-on-surface">Semua Kondisi Aman</div>
                    <div class="text-xs">Tidak ada insiden aktif terdeteksi saat ini.</div>
                </div>
                @endforelse
            </div>
        </div>

        <!-- System Configuration / Alert Rules -->
        <div class="lg:col-span-4 bg-surface-container border border-outline-variant/30 p-lg rounded-xl flex flex-col h-fit">
            <h4 class="font-headline-sm text-headline-sm text-on-surface mb-xs">Aturan Alarm Rantai Dingin</h4>
            <p class="text-on-surface-variant text-body-md font-body-md mb-lg">Konfigurasi batas anomali suhu biologis.</p>
            <div class="space-y-md">
                <div class="p-md bg-surface-container-high/60 border border-outline-variant/20 rounded-lg flex items-center justify-between">
                    <div>
                        <div class="font-bold text-sm text-on-surface">Batas Atas Suhu (Warning)</div>
                        <div class="text-xs text-outline">Suhu kritis > 8.0Â&deg;C</div>
                    </div>
                    <span class="text-primary font-semibold text-sm font-data-mono">8,0Â&deg;C</span>
                </div>
                <div class="p-md bg-surface-container-high/60 border border-outline-variant/20 rounded-lg flex items-center justify-between">
                    <div>
                        <div class="font-bold text-sm text-on-surface">Batas Bawah Suhu (Warning)</div>
                        <div class="text-xs text-outline">Suhu pembekuan < 2.0Â&deg;C</div>
                    </div>
                    <span class="text-primary font-semibold text-sm font-data-mono">2,0Â&deg;C</span>
                </div>
                <div class="p-md bg-surface-container-high/60 border border-outline-variant/20 rounded-lg flex items-center justify-between">
                    <div>
                        <div class="font-bold text-sm text-on-surface">Durasi Ekskursi Maksimal</div>
                        <div class="text-xs text-outline">Aturan 30 detik deviasi</div>
                    </div>
                    <span class="text-primary font-semibold text-sm font-data-mono">30 detik</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Incident History Log -->
    <div class="bg-surface-container border border-outline-variant/30 rounded-xl overflow-hidden shadow-xl mt-lg">
        <div class="px-lg py-md border-b border-outline-variant/20 flex justify-between items-center bg-surface-container-high/50">
            <h3 class="font-headline-sm text-headline-sm text-on-surface">Riwayat Insiden Terkonfirmasi</h3>
            <span class="text-xs text-outline font-label-md">Audit Log Kepatuhan</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-surface-container-high/50 text-on-surface-variant font-label-md text-label-md uppercase">
                    <tr class="border-b border-outline-variant/10">
                        <th class="px-lg py-md">ID Insiden</th>
                        <th class="px-lg py-md">Tipe Insiden</th>
                        <th class="px-lg py-md">Tingkat Peringatan</th>
                        <th class="px-lg py-md">Durasi Anomali</th>
                        <th class="px-lg py-md">Suhu Maks</th>
                        <th class="px-lg py-md">Status</th>
                        <th class="px-lg py-md text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-outline-variant/10" id="resolved-incidents-table">
                    @forelse($incidents->where('status', 'resolved') as $incident)
                    <tr class="hover:bg-primary/5 transition-colors group">
                        <td class="px-lg py-md font-data-mono text-on-surface">#BG-{{ $incident->id }}</td>
                        <td class="px-lg py-md font-bold text-on-surface">{{ $incident->jenis_insiden }}</td>
                        <td class="px-lg py-md">
                            @if($incident->jenis_insiden === 'Tidak Layak Pakai')
                                <span class="text-[10px] font-black bg-error/10 text-error px-2 py-0.5 rounded border border-error/20">KRITIS</span>
                            @else
                                <span class="text-[10px] font-black bg-tertiary/10 text-tertiary px-2 py-0.5 rounded border border-tertiary/20">PERINGATAN</span>
                            @endif
                        </td>
                        <td class="px-lg py-md font-data-mono text-on-surface-variant">{{ $incident->durasi_anomali }} detik</td>
                        <td class="px-lg py-md font-data-mono text-on-surface-variant">{{ number_format($incident->suhu_tercatat, 1, ',', '.') }}Â&deg;C</td>
                        <td class="px-lg py-md">
                            <div class="flex items-center gap-2 text-on-surface">
                                <span class="w-1.5 h-1.5 rounded-full bg-primary/60 border border-primary shadow-[0_0_8px_rgba(76,215,246,0.5)]"></span>
                                Selesai
                            </div>
                        </td>
                        <td class="px-lg py-md text-right">
                            <button class="btn-view-log text-primary hover:underline text-xs font-bold active:scale-95 transition-transform"
                                    data-id="#BG-{{ $incident->id }}"
                                    data-type="{{ $incident->jenis_insiden }}"
                                    data-level="{{ $incident->jenis_insiden === 'Tidak Layak Pakai' ? 'KRITIS' : 'PERINGATAN' }}"
                                    data-duration="{{ $incident->durasi_anomali }} detik"
                                    data-temp="{{ number_format($incident->suhu_tercatat, 1, ',', '.') }}Â&deg;C"
                                    data-desc="{{ $incident->deskripsi }}"
                                    data-time="{{ $incident->created_at->format('Y-m-d H:i:s') }}"
                                    data-status="resolved">
                                Lihat Log
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr id="empty-history-row">
                        <td colspan="7" class="px-lg py-md text-center text-outline">Belum ada riwayat insiden terkonfirmasi.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Detailed Log Audit Modal -->
<div id="log-detail-modal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-md bg-black/60 backdrop-blur-sm transition-opacity duration-300">
    <div class="bg-surface-container border border-outline-variant/30 rounded-2xl w-full max-w-md overflow-hidden shadow-2xl scale-95 opacity-0 transition-all duration-300 flex flex-col">
        <!-- Modal Header -->
        <div class="px-lg py-md border-b border-outline-variant/20 flex justify-between items-center bg-surface-container-high/50">
            <div class="flex items-center gap-sm">
                <span class="material-symbols-outlined text-primary">receipt_long</span>
                <h3 class="font-headline-sm text-headline-sm text-on-surface">Detil Audit Log Insiden</h3>
            </div>
            <button id="close-log-modal" class="p-2 hover:bg-surface-container rounded-lg text-on-surface-variant hover:text-on-surface transition-colors">
                <span class="material-symbols-outlined text-[20px] align-middle">close</span>
            </button>
        </div>
        
        <!-- Modal Body -->
        <div class="p-lg space-y-md">
            <div class="grid grid-cols-2 gap-sm">
                <div class="p-sm rounded bg-surface-container-high/40 border border-outline-variant/10">
                    <div class="text-[10px] text-outline uppercase font-semibold">ID Insiden</div>
                    <div class="font-bold text-on-surface mt-1 text-sm font-mono" id="log-modal-id">-</div>
                </div>
                <div class="p-sm rounded bg-surface-container-high/40 border border-outline-variant/10">
                    <div class="text-[10px] text-outline uppercase font-semibold">Tingkat Risiko</div>
                    <div class="font-bold mt-1 text-sm" id="log-modal-level">-</div>
                </div>
            </div>
            
            <div class="space-y-xs text-xs">
                <div class="flex justify-between border-b border-outline-variant/10 py-1">
                    <span class="text-outline">Tipe Insiden:</span>
                    <span class="font-bold text-on-surface" id="log-modal-type">-</span>
                </div>
                <div class="flex justify-between border-b border-outline-variant/10 py-1">
                    <span class="text-outline">Suhu Maksimum:</span>
                    <span class="font-bold text-on-surface font-mono" id="log-modal-temp">-</span>
                </div>
                <div class="flex justify-between border-b border-outline-variant/10 py-1">
                    <span class="text-outline">Durasi Deviasi:</span>
                    <span class="font-bold text-on-surface font-mono" id="log-modal-duration">-</span>
                </div>
                <div class="flex justify-between border-b border-outline-variant/10 py-1">
                    <span class="text-outline">Waktu Kejadian:</span>
                    <span class="font-bold text-on-surface font-mono" id="log-modal-time">-</span>
                </div>
                <div class="flex justify-between border-b border-outline-variant/10 py-1">
                    <span class="text-outline">Status Insiden:</span>
                    <span class="font-bold text-green-500" id="log-modal-status">Selesai (Resolved)</span>
                </div>
            </div>
            
            <div class="p-md rounded-xl bg-surface-container-low border border-outline-variant/20">
                <div class="text-[10px] text-outline uppercase font-semibold mb-1">Deskripsi Insiden</div>
                <p class="text-xs text-on-surface" id="log-modal-desc">-</p>
                <div class="mt-2 text-[10px] text-primary font-bold">
                    Catatan: Insiden telah dikonfirmasi dan diselesaikan oleh Operator QA.
                </div>
            </div>
        </div>
        
        <!-- Modal Footer -->
        <div class="px-lg py-md border-t border-outline-variant/20 flex justify-end bg-surface-container-low">
            <button id="close-log-modal-btn" class="px-md py-2 bg-primary text-on-primary hover:-translate-y-0.5 hover:shadow-md rounded-xl text-xs font-semibold transition-all duration-300 ease-out active:scale-95 shadow-[0_0_10px_rgba(2,132,199,0.2)]">
                Tutup
            </button>
        </div>
    </div>
</div>

<!-- Notification Toast for AJAX -->
<div class="fixed bottom-gutter right-gutter bg-surface-container border border-outline-variant/30 p-md rounded-xl border-l-4 border-primary translate-y-24 opacity-0 transition-all duration-500 z-50 pointer-events-none" id="ajax-toast">
    <div class="flex items-center gap-3">
        <span class="material-symbols-outlined text-primary">done_all</span>
        <div>
            <div class="font-bold text-sm text-on-surface" id="ajax-toast-title">Insiden Dikonfirmasi</div>
            <div class="text-xs text-on-surface-variant" id="ajax-toast-desc">Status insiden berhasil diperbarui di database.</div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function resolveIncident(id) {
        // Post Request using Fetch API
        fetch(`/peringatan/${id}/resolve`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show AJAX Toast
                const toast = document.getElementById('ajax-toast');
                if (toast) {
                    toast.classList.remove('translate-y-24', 'opacity-0');
                    setTimeout(() => {
                        toast.classList.add('translate-y-24', 'opacity-0');
                    }, 3000);
                }

                // Animate out the active incident card
                const card = document.getElementById(`incident-card-${id}`);
                if (card) {
                    card.style.opacity = '0';
                    card.style.transform = 'translateX(100px)';
                    setTimeout(() => {
                        card.remove();
                        
                        // Check if active incidents is empty
                        const container = document.getElementById('live-alert-feed');
                        if (container.children.length === 0) {
                            container.innerHTML = `
                                <div class="bg-surface-container/30 p-lg rounded-lg border border-outline-variant/20 text-center text-outline" id="no-incidents-view">
                                    <span class="material-symbols-outlined text-green-400 text-3xl mb-2">check_circle</span>
                                    <div class="text-sm font-semibold text-on-surface">Semua Kondisi Aman</div>
                                    <div class="text-xs">Tidak ada insiden aktif terdeteksi saat ini.</div>
                                </div>
                            `;
                        }
                    }, 3000);
                }
                
                // Reload window after animation to refresh tables and stats
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            }
        })
        .catch(error => {
            console.error('Error resolving incident:', error);
        });
    }

    // --- Log Modal Interactivity ---
    document.addEventListener("DOMContentLoaded", function () {
        const modal = document.getElementById('log-detail-modal');
        const closeBtn = document.getElementById('close-log-modal');
        const closeBtn2 = document.getElementById('close-log-modal-btn');
        
        const mId = document.getElementById('log-modal-id');
        const mLevel = document.getElementById('log-modal-level');
        const mType = document.getElementById('log-modal-type');
        const mTemp = document.getElementById('log-modal-temp');
        const mDuration = document.getElementById('log-modal-duration');
        const mTime = document.getElementById('log-modal-time');
        const mDesc = document.getElementById('log-modal-desc');

        function openLogModal(data) {
            mId.textContent = data.id;
            mLevel.textContent = data.level;
            mType.textContent = data.type;
            mTemp.textContent = data.temp;
            mDuration.textContent = data.duration;
            mTime.textContent = data.time;
            mDesc.textContent = data.desc;

            // Style level badge
            if (data.level === 'KRITIS') {
                mLevel.className = 'font-bold mt-1 text-sm text-error';
            } else {
                mLevel.className = 'font-bold mt-1 text-sm text-tertiary';
            }

            const mStatus = document.getElementById('log-modal-status');
            if (mStatus) {
                if (data.status === 'aktif') {
                    mStatus.textContent = 'Aktif (Sedang Berjalan)';
                    mStatus.className = 'font-bold text-error animate-pulse';
                } else {
                    mStatus.textContent = 'Selesai (Resolved)';
                    mStatus.className = 'font-bold text-green-500';
                }
            }

            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                modal.querySelector('.bg-surface-container').classList.remove('scale-95', 'opacity-0');
            }, 50);
        }

        function closeLogModal() {
            modal.classList.add('opacity-0');
            modal.querySelector('.bg-surface-container').classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }

        document.querySelectorAll('.btn-view-log').forEach(btn => {
            btn.addEventListener('click', () => {
                openLogModal({
                    id: btn.getAttribute('data-id'),
                    level: btn.getAttribute('data-level'),
                    type: btn.getAttribute('data-type'),
                    temp: btn.getAttribute('data-temp'),
                    duration: btn.getAttribute('data-duration'),
                    time: btn.getAttribute('data-time'),
                    desc: btn.getAttribute('data-desc'),
                    status: btn.getAttribute('data-status')
                });
            });
        });

        if (closeBtn) closeBtn.addEventListener('click', closeLogModal);
        if (closeBtn2) closeBtn2.addEventListener('click', closeLogModal);
    });

    // ========================================
    // REAL-TIME LIVE POLLING - Peringatan
    // ========================================
    function pollAlertData() {
        fetch('/api/alerts/live', {
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            }
        })
        .then(res => res.json())
        .then(data => {
            if (!data.success) return;

            // Update stats
            const countEl = document.getElementById('live-active-count');
            if (countEl) countEl.textContent = data.stats.activeCount;

            const healthEl = document.getElementById('live-health');
            if (healthEl) healthEl.textContent = data.stats.health.toFixed(1).replace('.', ',') + '%';
        })
        .catch(err => console.warn('[BIO-GUARD Alerts] Poll error:', err));
    }

    setInterval(pollAlertData, 3000);
    console.log('[BIO-GUARD] Alerts real-time polling started (3s interval)');
</script>
@endpush
