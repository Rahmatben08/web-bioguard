<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Models\LogTelemetri;
use App\Models\PrediksiAi;
use App\Services\PredictionService;
use Illuminate\Support\Facades\Log;

class ProcessAiPrediction implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3; // Retry up to 3 times
    
    protected $logId;
    protected $sisaJarak;
    protected $suhu;
    protected $mkt;

    /**
     * Create a new job instance.
     */
    public function __construct($logId, $sisaJarak, $suhu, $mkt)
    {
        $this->logId = $logId;
        $this->sisaJarak = $sisaJarak;
        $this->suhu = $suhu;
        $this->mkt = $mkt;
    }

    /**
     * Calculate the number of seconds to wait before retrying the job.
     */
    public function backoff(): array
    {
        return [10, 30, 60]; // 10s, then 30s, then 60s
    }

    /**
     * Execute the job.
     */
    public function handle(PredictionService $predictionService): void
    {
        $log = LogTelemetri::find($this->logId);
        if (!$log) return;

        $macetMenit = $log->perjalanan->total_macet_menit ?? 0;
        
        $prediksi = $predictionService->predictRisk(
            $this->sisaJarak, 
            $macetMenit, 
            $this->suhu, 
            $this->mkt
        );

        PrediksiAi::updateOrCreate(
            ['id_log' => $this->logId],
            [
                'sisa_jarak_km' => $this->sisaJarak,
                'probabilitas_rusak' => $prediksi['probabilitas_rusak'],
                'instruksi_mitigasi' => $prediksi['instruksi_mitigasi']
            ]
        );
    }
}
