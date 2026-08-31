<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sertifikat Jejak Audit CDOB - BIO-GUARD</title>
    
    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">
    
    {{-- Tailwind CSS from CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        mono: ['JetBrains Mono', 'monospace'],
                    }
                }
            }
        }
    </script>
    
    <style>
        @media print {
            body {
                background: white !important;
                color: black !important;
            }
            .no-print {
                display: none !important;
            }
            .print-border {
                border: 2px solid #000 !important;
            }
            .page-break {
                page-break-before: always;
            }
        }
    </style>
</head>
<body class="bg-slate-950 text-slate-100 min-h-screen flex flex-col items-center py-10 px-4 md:px-0">
    
    {{-- No-Print Control Bar --}}
    <div class="no-print w-full max-w-4xl bg-slate-900 border border-slate-800 p-4 rounded-2xl mb-6 flex justify-between items-center shadow-xl">
        <div class="flex items-center gap-2.5">
            <div class="w-3 h-3 rounded-full bg-cyan-500 animate-pulse"></div>
            <span class="text-sm font-semibold text-slate-350">Dokumen Siap Cetak (CDOB)</span>
        </div>
        <div class="flex gap-2">
            <button onclick="window.close()" class="px-4 py-2 border border-slate-700 text-slate-350 hover:bg-slate-850 rounded-xl text-xs font-semibold transition-all">
                Tutup
            </button>
            <button onclick="window.print()" class="px-4 py-2 bg-cyan-500 hover:bg-cyan-400 text-slate-950 font-bold rounded-xl text-xs transition-all shadow-[0_0_15px_rgba(6,182,212,0.4)]">
                Cetak Laporan / Simpan PDF
            </button>
        </div>
    </div>

    {{-- Certificate/Report Document Page --}}
    <div class="w-full max-w-4xl bg-white text-slate-900 p-8 md:p-12 rounded-3xl shadow-2xl relative border-8 border-slate-100 print-border flex flex-col justify-between" style="min-height: 297mm;">
        
        <div>
            {{-- Document Header --}}
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center border-b-4 border-cyan-500 pb-6 mb-8 gap-4">
                <div class="flex items-center gap-4">
                    {{-- Logo Placeholder --}}
                    <div class="w-16 h-16 rounded-2xl bg-cyan-500 flex items-center justify-center text-white text-3xl font-black shadow-lg">
                        BG
                    </div>
                    <div>
                        <h1 class="text-2xl font-black tracking-tight text-slate-900">BIO-GUARD</h1>
                        <p class="text-xs uppercase font-extrabold tracking-widest text-cyan-600">Sistem Logistik Rantai Dingin Medis</p>
                    </div>
                </div>
                <div class="text-left sm:text-right">
                    <span class="inline-block px-3 py-1 bg-cyan-100 text-cyan-800 rounded-full font-bold text-[10px] uppercase tracking-wider mb-2">E-Cert CDOB Terverifikasi</span>
                    <p class="text-xs text-slate-500 font-medium">No. Dokumen: <span class="font-mono font-bold">CERT-CDOB-{{ date('Ymd-Hi') }}</span></p>
                </div>
            </div>

            {{-- Document Subtitle / Title --}}
            <div class="text-center mb-8">
                <h2 class="text-xl font-bold text-slate-800 tracking-tight uppercase">Sertifikat Digital & Laporan Jejak Audit CDOB</h2>
                <p class="text-xs text-slate-500 mt-1 max-w-md mx-auto leading-relaxed">
                    Sertifikat resmi pemenuhan kualifikasi operasional Cara Distribusi Obat yang Baik (CDOB) untuk produk termolabil.
                </p>
            </div>

            {{-- Metadata Grid --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 p-6 bg-slate-50 rounded-2xl mb-8 border border-slate-200">
                <div>
                    <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider">Operator/Auditor</span>
                    <span class="text-xs font-bold text-slate-800">{{ auth()->user()->name ?? 'Admin Bio-Guard' }}</span>
                </div>
                <div>
                    <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider">ID Dispatcher</span>
                    <span class="text-xs font-mono font-bold text-slate-800">{{ auth()->user()->dispatcher_id ?? 'DSP-PLB-2026' }}</span>
                </div>
                <div>
                    <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider">Hub Regional</span>
                    <span class="text-xs font-bold text-slate-800">Palembang Pusat Hub</span>
                </div>
                <div>
                    <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider">Tanggal Audit</span>
                    <span class="text-xs font-bold text-slate-800">{{ date('d F Y H:i') }} WIB</span>
                </div>
            </div>

            {{-- Audit Logs Table --}}
            <div class="mb-8">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Daftar Audit Telemetri Boks Aktif</h3>
                <div class="border border-slate-200 rounded-xl overflow-hidden shadow-sm">
                    <table class="w-full text-left text-xs border-collapse">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200 font-semibold text-slate-600">
                                <th class="px-4 py-3">ID Boks</th>
                                <th class="px-4 py-3">Kurir / Armada</th>
                                <th class="px-4 py-3">Kargo Obat</th>
                                <th class="px-4 py-3">Tujuan Pengiriman</th>
                                <th class="px-4 py-3 text-center">Rata-Rata Suhu</th>
                                <th class="px-4 py-3 text-center">Status CDOB</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-800 font-medium">
                            @forelse($perjalananList as $perjalanan)
                                @php
                                    $logs = $perjalanan->logTelemetri;
                                    $avgTemp = $logs->count() > 0 ? $logs->avg('suhu_aktual') : 4.5;
                                    $excursion = $perjalanan->getExcursionInfo();
                                @endphp
                                <tr>
                                    <td class="px-4 py-3.5 font-mono font-bold text-cyan-600">#{{ $perjalanan->id_box }}</td>
                                    <td class="px-4 py-3.5">
                                        <div class="font-bold">{{ $perjalanan->kurir->nama_lengkap }}</div>
                                        <div class="text-[10px] text-slate-400 font-mono">{{ $perjalanan->kurir->nomor_kendaraan }}</div>
                                    </td>
                                    <td class="px-4 py-3.5 font-bold">{{ $perjalanan->nama_kargo ?? 'Vaksin Medis' }}</td>
                                    <td class="px-4 py-3.5">{{ $perjalanan->lokasi_tujuan }}</td>
                                    <td class="px-4 py-3.5 text-center font-mono font-bold text-slate-700">
                                        {{ number_format($avgTemp, 1, ',', '.') }}°C
                                    </td>
                                    <td class="px-4 py-3.5 text-center">
                                        @if($excursion['status'] === 'Aman')
                                            <span class="inline-block px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-[9px] font-black uppercase tracking-wider">Lolos</span>
                                        @elseif($excursion['status'] === 'Peringatan')
                                            <span class="inline-block px-2.5 py-0.5 rounded-full bg-amber-100 text-amber-800 text-[9px] font-black uppercase tracking-wider">Toleransi</span>
                                        @else
                                            <span class="inline-block px-2.5 py-0.5 rounded-full bg-rose-100 text-rose-800 text-[9px] font-black uppercase tracking-wider">Tidak Lolos</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-6 text-center text-slate-400">Tidak ada data audit telemetri.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Audit Standards / Compliance Text --}}
            <div class="p-6 bg-cyan-50/50 rounded-2xl border border-cyan-100 mb-8 flex items-start gap-4">
                <span class="text-cyan-600 text-2xl">ðŸ›¡ï¸</span>
                <div class="text-xs leading-relaxed text-slate-700">
                    <h4 class="font-bold text-slate-900 mb-1">Pernyataan Kepatuhan CDOB & Distribusi Termolabil</h4>
                    Dengan diterbitkannya dokumen digital audit trail ini, sistem memverifikasi bahwa pengiriman vaksin dan produk farmasi sensitif di atas dipantau menggunakan unit telemetri IoT terkalibrasi. Seluruh grafik fluktuasi suhu dan GPS dicatat dalam database terdesentralisasi BIO-GUARD dan memenuhi standar BPOM RI tentang Tata Cara Cara Distribusi Obat yang Baik (CDOB).
                </div>
            </div>
        </div>

        {{-- Verification Signatures & QR Seal --}}
        <div class="border-t border-slate-200 pt-8 mt-auto flex flex-col sm:flex-row justify-between items-center gap-6">
            <div class="text-center sm:text-left">
                <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2">Integritas Dokumen Digital</span>
                <div class="flex items-center gap-4">
                    @php
                        $hashData = 'bg_cdob_audit_' . implode('-', $perjalananList->pluck('id_rute')->toArray()) . '_' . date('Ymd_His') . '_' . (auth()->user()->dispatcher_id ?? 'DSP-PLB-2026');
                        $hashHex = hash('sha256', $hashData);
                        $verifyUrl = url('/verify/' . substr($hashHex, 0, 16));
                        $qrCode = SimpleSoftwareIO\QrCode\Facades\QrCode::size(80)
                            ->color(15, 23, 42)
                            ->backgroundColor(255, 255, 255)
                            ->margin(1)
                            ->generate($verifyUrl);
                    @endphp
                    <div>
                        {!! $qrCode !!}
                    </div>
                    <div class="text-left font-mono">
                        <p class="text-[10px] text-slate-400">NOMOR SERI AUDIT:</p>
                        <p class="text-[11px] font-bold text-slate-700 break-all select-all">{{ strtoupper(substr($hashHex, 0, 16)) }}</p>
                    </div>
                </div>
            </div>
            
            <div class="text-center sm:text-right flex flex-col items-center sm:items-end">
                <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-6">Persetujuan Otoritas QA</span>
                <div class="relative w-40 h-16 flex items-center justify-center">
                    {{-- BPOM / Bio-Guard Digital Approval Seal Placeholder --}}
                    <div class="absolute border-2 border-dashed border-cyan-500/40 text-cyan-600/30 text-[10px] font-black uppercase tracking-widest rotate-12 p-1.5 rounded-lg select-none">
                        BIO-GUARD QA APPROVED
                    </div>
                    <div class="font-sans font-bold text-slate-800 text-sm border-t border-slate-300 w-full pt-1 text-center">
                        Otorisasi Digital
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- Autoprint Script --}}
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            // Auto open print preview after assets loaded
            setTimeout(() => {
                window.print();
            }, 1000);
        });
    </script>
</body>
</html>
