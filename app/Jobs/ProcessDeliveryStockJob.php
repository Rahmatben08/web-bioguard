<?php

namespace App\Jobs;

use App\Models\InventoryHub;
use App\Models\PerjalananRute;
use App\Models\StockLedger;
use App\Models\ThermolabileDrug;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProcessDeliveryStockJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $ruteId;
    protected $faskesId;

    /**
     * Create a new job instance.
     */
    public function __construct(string $ruteId, string $faskesId)
    {
        $this->ruteId = $ruteId;
        $this->faskesId = $faskesId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info("ProcessDeliveryStockJob started for Rute {$this->ruteId} to Faskes {$this->faskesId}");

        try {
            DB::beginTransaction();

            $rute = PerjalananRute::find($this->ruteId);
            if (!$rute) {
                Log::error("Rute {$this->ruteId} tidak ditemukan.");
                DB::rollBack();
                return;
            }

            $faskes = InventoryHub::where('id_faskes', $this->faskesId)->first();
            if (!$faskes) {
                Log::error("Faskes {$this->faskesId} tidak ditemukan.");
                DB::rollBack();
                return;
            }

            // Estimasi jumlah dari rute. Karena skema awal PerjalananRute tidak memiliki 
            // qty eksplisit, kita asumsikan 1 batch = 50 unit (atau parsing dari nama_kargo jika memungkinkan).
            // Idealnya, tabel rute memiliki kolom `qty_pengiriman` dan `no_batch`.
            $quantity = 50; 
            
            // Mengekstrak no_batch jika memungkinkan (misal dari format "Batch Baru (Vaksin COVID-19)")
            $batchNo = null;
            if (preg_match('/Batch (.*?)(?:\s|\(|$)/i', $rute->nama_kargo, $matches)) {
                $batchNo = trim($matches[1]);
            }

            // Catat Ledger IN untuk Faskes
            StockLedger::create([
                'type' => 'in',
                'quantity' => $quantity,
                'reference_batch' => $batchNo,
                'reference_faskes' => $faskes->id_faskes,
                'route_id' => $rute->id_rute,
                'trigger_by' => 'kurir',
                'trigger_user_id' => $rute->id_kurir, // asumsi id_kurir juga ID user
                'notes' => "Pengantaran selesai dari rute {$rute->id_rute} via BOX {$rute->id_box}. Kargo: {$rute->nama_kargo}",
            ]);

            // Update stok snapshot di Faskes (jika kolom stok tunggal)
            // InventoryHub memiliki kolom json `stok_vaksin` dan decimal `kapasitas_terisi`.
            // Kita tingkatkan kapasitas terisi 5%.
            $faskes->kapasitas_terisi = min(100.00, $faskes->kapasitas_terisi + 5.00);
            
            // Tambahkan ke JSON stok_vaksin
            $stok = $faskes->stok_vaksin ?? [];
            $jenisKargo = $rute->nama_kargo;
            
            $found = false;
            foreach ($stok as &$item) {
                if ($item['jenis'] === $jenisKargo) {
                    $item['jumlah'] += $quantity;
                    $found = true;
                    break;
                }
            }
            if (!$found) {
                $stok[] = ['jenis' => $jenisKargo, 'jumlah' => $quantity];
            }
            
            $faskes->stok_vaksin = $stok;
            $faskes->last_sync = now();
            $faskes->save();

            // Ubah status rute menjadi selesai jika belum (sebagai redundansi)
            if (in_array(strtolower($rute->status_perjalanan), ['aktif', 'sedang berjalan'])) {
                $rute->update(['status_perjalanan' => 'selesai']);
            }

            DB::commit();
            Log::info("ProcessDeliveryStockJob success. Faskes {$faskesId} stock updated.");

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("ProcessDeliveryStockJob failed: " . $e->getMessage());
        }
    }
}
