<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class InventoryController extends Controller
{
    /**
     * Menampilkan dashboard manajemen inventaris cold storage faskes se-Palembang.
     */
    public function index(Request $request): View
    {
        $hubs = $this->getMockHubs();

        // Search Filter
        if ($request->filled('search')) {
            $search = strtolower($request->input('search'));
            $hubs = $hubs->filter(function ($item) use ($search) {
                return str_contains(strtolower($item['nama']), $search) || 
                       str_contains(strtolower($item['kulkas_farmasi']), $search);
            });
        }

        // Kecamatan Filter
        if ($request->filled('kecamatan')) {
            $kecamatan = $request->input('kecamatan');
            if ($kecamatan !== 'Semua') {
                $hubs = $hubs->filter(function ($item) use ($kecamatan) {
                    return $item['kecamatan'] === $kecamatan;
                });
            }
        }

        // Status Filter
        if ($request->filled('status')) {
            $status = $request->input('status');
            if ($status !== 'Semua') {
                $hubs = $hubs->filter(function ($item) use ($status) {
                    return $item['status'] === $status;
                });
            }
        }

        // Sorting
        $sort = $request->input('sort', 'nama');
        $order = $request->input('order', 'asc');
        
        $hubs = $hubs->sortBy(function ($item) use ($sort) {
            switch ($sort) {
                case 'suhu':
                    return $item['suhu_aktual'];
                case 'kapasitas':
                    return $item['kapasitas_persen'];
                case 'stok_total':
                    return $item['stok_total'];
                default:
                    return ($item['jenis'] === 'Rumah Sakit' ? '0_' : '1_') . $item['nama'];
            }
        }, SORT_REGULAR, $order === 'desc');

        // Stats calculation before pagination
        $totalHubs = $hubs->count();
        $avgTemp = round($hubs->avg('suhu_aktual'), 2);
        $alertCount = $hubs->where('status', 'Bahaya')->count();
        
        $totalPfizer = $hubs->sum(fn($h) => $h['stok']['pfizer']);
        $totalPolio = $hubs->sum(fn($h) => $h['stok']['polio']);
        $totalSinovac = $hubs->sum(fn($h) => $h['stok']['sinovac']);
        $totalInsulin = $hubs->sum(fn($h) => $h['stok']['insulin']);
        $totalVaccines = $totalPfizer + $totalPolio + $totalSinovac + $totalInsulin;
        
        $totalCapacity = $hubs->sum('kapasitas_total');
        $avgCapacityUtil = $totalCapacity > 0 ? round(($totalVaccines / $totalCapacity) * 100, 1) : 0;

        // Pagination
        $page = $request->input('page', 1);
        $perPage = 10;
        $paginatedItems = $hubs->forPage($page, $perPage)->values();
        
        $hubsPaginated = new LengthAwarePaginator(
            $paginatedItems,
            $hubs->count(),
            $perPage,
            $page,
            [
                'path' => $request->url(),
                'query' => $request->query(),
            ]
        );

        // List of all Kecamatan for dropdown
        $allKecamatan = $this->getKecamatanList();

        return view('dashboard.inventory', compact(
            'hubsPaginated',
            'totalHubs',
            'avgTemp',
            'alertCount',
            'totalPfizer',
            'totalPolio',
            'totalSinovac',
            'totalInsulin',
            'totalVaccines',
            'totalCapacity',
            'avgCapacityUtil',
            'allKecamatan'
        ));
    }

    /**
     * Membangun daftar 60 Faskes Hubs mock di Palembang.
     */
    private function getMockHubs(): Collection
    {
        $hubs = [];
        $kecamatanList = $this->getKecamatanList();
        
        $devices = ['TCW 3000 AC', 'Dometic HT20', 'Vestfrost VLS 024', 'B Medical TCW 80 AC', 'GEA YS-150'];
        
        // Seeders: 10 Hospitals + 50 Puskesmas = 60 total
        $hospitals = [
            'RSUP Dr. Mohammad Hoesin', 'RSUD Palembang BARI', 'RSUD Siti Fatimah', 
            'RS Hermina Palembang', 'RS RK Charitas', 'RS Siloam Sriwijaya', 
            'RS Muhammadiyah Palembang', 'RS Bhayangkara M. Hasan', 'RS AK Gani', 
            'RS Pertamina Plaju'
        ];
        
        $puskesmasNames = [
            'Dempo', 'Merdeka', 'Sekip', 'Kampus', 'Sabokingking', 'Pakjo', '23 Ilir', 
            'Pembina', 'Plaju', '7 Ulu', 'OPI', 'Jakabaring', 'Kertapati', '1 Ulu', 
            '4 Ulu', 'Gandus', 'Karang Anyar', 'Padang Selasa', 'Makrayu', 'Bukit Sangkal', 
            'Kalidoni', 'Sako', 'Kenten', 'Talang Ratu', 'Sukarami', 'Talang Betutu', 
            'Alang-Alang Lebar', 'Sematang Borang', 'Karya Jaya', 'Talang Kelapa',
            '5 Ulu', '11 Ulu', 'Sei Selayur', 'Boom Baru', 'Basuki Rahmat', 'Punti Kayu',
            'Srijaya', 'Talang Jambe', 'Bukit Baru', 'Nag Swidak', 'Taman Bacaan',
            'Multi Wahana', 'Sako Kenten', 'Kebun Bunga', 'Simpang Periuk', 'Tanjung Api-Api',
            'Kenten Laut', 'Komperta Plaju', 'Semarang', 'Duku'
        ];

        // 1. Generate Hospital Hubs (larger capacity)
        foreach ($hospitals as $index => $hospital) {
            $kec = $kecamatanList[$index % count($kecamatanList)];
            
            // Randomize stock values
            $pfizer = rand(800, 2500);
            $polio = rand(1500, 4500);
            $sinovac = rand(2000, 6000);
            $insulin = rand(400, 1200);
            $totalStok = $pfizer + $polio + $sinovac + $insulin;
            $kapasitas = rand(15000, 20000);
            
            // Generate temperature: hospitals usually very stable, let's keep it safe
            $suhu = round(2.5 + ($index * 0.4) % 5.0, 1);
            $status = 'Aman';

            $hubs[] = [
                'id' => 'HOSP-' . str_pad($index + 1, 3, '0', STR_PAD_LEFT),
                'nama' => $hospital,
                'jenis' => 'Rumah Sakit',
                'kecamatan' => $kec,
                'kulkas_farmasi' => 'B Medical TCW 4000 SDD',
                'kapasitas_total' => $kapasitas,
                'kapasitas_persen' => round(($totalStok / $kapasitas) * 100, 1),
                'suhu_aktual' => $suhu,
                'status' => $status,
                'last_sync' => rand(1, 15) . ' menit lalu',
                'stok' => [
                    'pfizer' => $pfizer,
                    'polio' => $polio,
                    'sinovac' => $sinovac,
                    'insulin' => $insulin
                ],
                'stok_total' => $totalStok
            ];
        }

        // 2. Generate Puskesmas Hubs (medium capacity)
        foreach ($puskesmasNames as $index => $name) {
            $kec = $kecamatanList[($index + 3) % count($kecamatanList)];
            $device = $devices[$index % count($devices)];
            
            $pfizer = rand(100, 600);
            $polio = rand(300, 1200);
            $sinovac = rand(500, 2000);
            $insulin = rand(50, 400);
            $totalStok = $pfizer + $polio + $sinovac + $insulin;
            $kapasitas = rand(4500, 6000);
            
            // Introduce occasional warning temperatures (between 2-8 is safe. Let's make index 7 and 23 warning/danger)
            if ($index === 7) {
                $suhu = 8.9; // Excursion too high
                $status = 'Bahaya';
            } elseif ($index === 23) {
                $suhu = 1.4; // Excursion too low
                $status = 'Bahaya';
            } else {
                $suhu = round(3.0 + (sin($index) * 2.0) + 1.5, 1);
                $status = 'Aman';
            }

            $hubs[] = [
                'id' => 'PKM-' . str_pad($index + 1, 3, '0', STR_PAD_LEFT),
                'nama' => 'Puskesmas ' . $name,
                'jenis' => 'Puskesmas',
                'kecamatan' => $kec,
                'kulkas_farmasi' => $device,
                'kapasitas_total' => $kapasitas,
                'kapasitas_persen' => round(($totalStok / $kapasitas) * 100, 1),
                'suhu_aktual' => $suhu,
                'status' => $status,
                'last_sync' => rand(1, 45) . ' menit lalu',
                'stok' => [
                    'pfizer' => $pfizer,
                    'polio' => $polio,
                    'sinovac' => $sinovac,
                    'insulin' => $insulin
                ],
                'stok_total' => $totalStok
            ];
        }

        return collect($hubs);
    }

    /**
     * Daftar Kecamatan di Palembang.
     */
    private function getKecamatanList(): array
    {
        return [
            'Ilir Timur I',
            'Ilir Timur II',
            'Ilir Timur III',
            'Ilir Barat I',
            'Ilir Barat II',
            'Kalidoni',
            'Sukarami',
            'Sako',
            'Plaju',
            'Jakabaring',
            'Kertapati',
            'Gandus',
            'Alang-Alang Lebar',
            'Bukit Kecil',
            'Seberang Ulu I',
            'Seberang Ulu II',
            'Sematang Borang',
            'Kemuning'
        ];
    }
}
