<?php

namespace App\Exports;

use App\Models\LogTelemetri;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TelemetryExport implements FromQuery, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $date;
    protected $id_box;

    public function __construct($date = null, $id_box = null)
    {
        $this->date = $date;
        $this->id_box = $id_box;
    }

    /**
     * Query data untuk ekspor.
     */
    public function query()
    {
        $query = LogTelemetri::with(['perjalananRute.kurir', 'prediksiAi'])->orderBy('timestamp', 'desc');

        if ($this->date) {
            $query->whereDate('timestamp', $this->date);
        }

        if ($this->id_box) {
            $query->whereHas('perjalananRute', function($q) {
                $q->where('id_box', $this->id_box);
            });
        }

        return $query;
    }

    /**
     * Heading / header kolom.
     */
    public function headings(): array
    {
        return [
            'ID Log',
            'Waktu Pencatatan',
            'Nama Kurir',
            'Nomor Kendaraan',
            'ID Box',
            'Lokasi Tujuan',
            'Suhu Aktual (°C)',
            'Nilai MKT (°C)',
            'Latitude',
            'Longitude',
            'Durasi Anomali (detik)',
            'Probabilitas Rusak (AI) (%)',
            'Rekomendasi Tindakan',
            'Status Kelayakan',
            'Status Sinkronisasi',
        ];
    }

    /**
     * Map data untuk setiap baris.
     */
    public function map($row): array
    {
        $rute = $row->perjalananRute;
        $kurir = $rute ? $rute->kurir : null;
        $prediksi = $row->prediksiAi;

        // Eval excursion
        $excursionDuration = 0;
        $statusLabel = 'AMAN';
        
        if ($rute) {
            $exInfo = $rute->getExcursionInfo();
            // Since getExcursionInfo evaluates the CURRENT state of the journey, we can adapt:
            // If the temperature in this specific row is out of bounds, let's show status
            $temp = (float) $row->suhu_aktual;
            if ($temp < 2.0 || $temp > 8.0) {
                // Approximate excursion duration for audit log: we find the duration relative to this row's timestamp
                // But for audit export simplicity, let's output the journey's current excursion duration or simple flags
                $excursionDuration = $exInfo['duration'];
                $statusLabel = $exInfo['status_label'];
            }
        }

        return [
            $row->id_log,
            $row->timestamp->format('Y-m-d H:i:s'),
            $kurir ? $kurir->nama_lengkap : '-',
            $kurir ? $kurir->nomor_kendaraan : '-',
            $rute ? $rute->id_box : '-',
            $rute ? $rute->lokasi_tujuan : '-',
            number_format($row->suhu_aktual, 2, ',', '.'),
            $row->nilai_mkt ? number_format($row->nilai_mkt, 2, ',', '.') : '-',
            $row->latitude,
            $row->longitude,
            $excursionDuration > 0 ? $excursionDuration . ' detik' : '0 detik (Normal)',
            $prediksi ? number_format($prediksi->probabilitas_rusak, 2, ',', '.') . '%' : '0,00%',
            $prediksi ? $prediksi->rekomendasi_tindakan : 'Suhu optimal. Pertahankan kondisi.',
            $statusLabel,
            $row->is_synced_from_offline ? 'Sinkronisasi Offline' : 'Waktu Nyata',
        ];
    }

    /**
     * Gaya stylesheet untuk Excel.
     */
    public function styles(Worksheet $sheet)
    {
        return [
            // Gaya baris header pertama (Bold & Background Blue)
            1 => [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF']
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '003640'] // match brand primary-dark
                ]
            ],
        ];
    }
}


