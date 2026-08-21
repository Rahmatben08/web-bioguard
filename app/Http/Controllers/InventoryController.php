<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\InventoryHub;

class InventoryController extends Controller
{
    /**
     * Menampilkan dashboard manajemen inventaris cold storage faskes se-Palembang.
     */
    public function index(Request $request): View
    {
        $query = InventoryHub::query();

        // Search Filter
        if ($request->filled('search')) {
            $search = strtolower($request->input('search'));
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'LIKE', "%{$search}%")
                  ->orWhere('kulkas_farmasi', 'LIKE', "%{$search}%")
                  ->orWhere('id_faskes', 'LIKE', "%{$search}%");
            });
        }

        // Kecamatan Filter
        if ($request->filled('kecamatan')) {
            $kecamatan = $request->input('kecamatan');
            if ($kecamatan !== 'Semua') {
                $query->where('kecamatan', $kecamatan);
            }
        }

        // Status Filter
        if ($request->filled('status')) {
            $status = $request->input('status');
            if ($status === 'Aman') {
                $query->whereBetween('suhu_aktual', [2.0, 8.0]);
            } elseif ($status === 'Bahaya') {
                $query->whereNotBetween('suhu_aktual', [2.0, 8.0]);
            }
        }

        // Sorting
        $sort = $request->input('sort');
        if ($sort === 'status') {
            // Urutkan berdasarkan suhu yang keluar batas (Bahaya) ke atas
            $query->orderByRaw('CASE WHEN suhu_aktual < 2.0 OR suhu_aktual > 8.0 THEN 0 ELSE 1 END, suhu_aktual DESC');
        } elseif ($sort === 'suhu_tinggi') {
            $query->orderBy('suhu_aktual', 'desc');
        } elseif ($sort === 'suhu_rendah') {
            $query->orderBy('suhu_aktual', 'asc');
        } else {
            // Default sort: Nama Faskes asc
            $query->orderBy('nama', 'asc');
        }

        $allRecords = InventoryHub::all(); // for KPIs
        $hubsPaginatedDb = $query->paginate(15)->withQueryString();

        // Transform DB models to match view's expected array format
        $hubsPaginated = [];
        foreach ($hubsPaginatedDb as $hub) {
            $stok = $hub->stok_vaksin ?? [];
            if (is_string($stok)) $stok = json_decode($stok, true) ?? [];
            $suhu = (float) $hub->suhu_aktual;
            $status = ($suhu < 2.0 || $suhu > 8.0) ? 'Bahaya' : 'Aman';
            $stok_total = $stok['totalStok'] ?? 0;
            $kapasitas = $stok['kapasitas_total'] ?? 10000;

            $hubsPaginated[] = [
                'id' => $hub->id_faskes,
                'nama' => $hub->nama,
                'jenis' => $hub->kategori,
                'kecamatan' => $hub->kecamatan,
                'kulkas_farmasi' => $hub->kulkas_farmasi,
                'kapasitas_total' => $kapasitas,
                'kapasitas_persen' => $hub->kapasitas_terisi,
                'suhu_aktual' => $suhu,
                'status' => $status,
                'last_sync' => $hub->last_sync ? \Carbon\Carbon::parse($hub->last_sync)->diffForHumans() : 'Baru saja',
                'stok' => $stok,
                'stok_total' => $stok_total
            ];
        }

        // Paginator needs to be replaced with a LengthAwarePaginator wrapper if we transform, 
        // or we can just transform the items on the paginator itself
        $hubsPaginatedDb->getCollection()->transform(function ($hub) {
            $stok = $hub->stok_vaksin ?? [];
            if (is_string($stok)) $stok = json_decode($stok, true) ?? [];
            $suhu = (float) $hub->suhu_aktual;
            $status = ($suhu < 2.0 || $suhu > 8.0) ? 'Bahaya' : 'Aman';
            $stok_total = $stok['totalStok'] ?? 0;
            $kapasitas = $stok['kapasitas_total'] ?? 10000;

            return [
                'id' => $hub->id_faskes,
                'nama' => $hub->nama,
                'jenis' => $hub->kategori,
                'kecamatan' => $hub->kecamatan,
                'kulkas_farmasi' => $hub->kulkas_farmasi,
                'kapasitas_total' => $kapasitas,
                'kapasitas_persen' => $hub->kapasitas_terisi,
                'suhu_aktual' => $suhu,
                'status' => $status,
                'last_sync' => $hub->last_sync ? \Carbon\Carbon::parse($hub->last_sync)->diffForHumans() : 'Baru saja',
                'stok' => $stok,
                'stok_total' => $stok_total
            ];
        });

        $hubsPaginated = $hubsPaginatedDb;

        // Calculate KPIs from all DB records
        $totalHubs = $allRecords->count();
        $avgTemp = $totalHubs > 0 ? $allRecords->avg('suhu_aktual') : 0;
        
        $alertCount = $allRecords->filter(function($h) {
            return $h->suhu_aktual < 2.0 || $h->suhu_aktual > 8.0;
        })->count();

        $totalCapacity = 0;
        $totalVaccines = 0;
        
        $totalPfizer = 0;
        $totalPolio = 0;
        $totalSinovac = 0;
        $totalInsulin = 0;

        foreach ($allRecords as $hub) {
            $stok = $hub->stok_vaksin ?? [];
            if (is_string($stok)) $stok = json_decode($stok, true) ?? [];
            $totalCapacity += $stok['kapasitas_total'] ?? 10000;
            $totalVaccines += $stok['totalStok'] ?? 0;
            $totalPfizer += $stok['pfizer'] ?? 0;
            $totalPolio += $stok['polio'] ?? 0;
            $totalSinovac += $stok['sinovac'] ?? 0;
            $totalInsulin += $stok['insulin'] ?? 0;
        }

        $avgCapacityUtil = $totalCapacity > 0 ? ($totalVaccines / $totalCapacity) * 100 : 0;

        // List of all Kecamatan for dropdown
        $allKecamatan = $this->getKecamatanList();

        return view('dashboard.inventory', compact(
            'hubsPaginated',
            'totalHubs',
            'avgTemp',
            'alertCount',
            'avgCapacityUtil',
            'totalVaccines',
            'totalCapacity',
            'totalPfizer',
            'totalPolio',
            'totalSinovac',
            'totalInsulin',
            'allKecamatan'
        ));
    }

    private function getKecamatanList(): array
    {
        return [
            'Ilir Timur I', 'Ilir Timur II', 'Ilir Timur III', 'Ilir Barat I', 'Ilir Barat II',
            'Seberang Ulu I', 'Seberang Ulu II', 'Plaju', 'Kertapati', 'Kemuning', 
            'Sako', 'Sukarami', 'Kalidoni', 'Alang-Alang Lebar', 'Bukit Kecil', 
            'Gandus', 'Jakabaring', 'Sematang Borang'
        ];
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'kecamatan' => 'required|string|max:100',
            'kulkas_farmasi' => 'required|string|max:100',
            'kapasitas_total' => 'required|numeric|min:1',
            'totalStok' => 'required|numeric|min:0',
            'pfizer' => 'nullable|numeric|min:0',
            'polio' => 'nullable|numeric|min:0',
            'sinovac' => 'nullable|numeric|min:0',
            'insulin' => 'nullable|numeric|min:0',
            'suhu_aktual' => 'required|numeric',
        ]);

        $stok_vaksin = [
            'kapasitas_total' => (int) $validated['kapasitas_total'],
            'totalStok' => (int) $validated['totalStok'],
            'pfizer' => (int) ($validated['pfizer'] ?? 0),
            'polio' => (int) ($validated['polio'] ?? 0),
            'sinovac' => (int) ($validated['sinovac'] ?? 0),
            'insulin' => (int) ($validated['insulin'] ?? 0),
        ];

        InventoryHub::create([
            'id_faskes' => 'F-' . strtoupper(substr(uniqid(), -5)),
            'nama' => $validated['nama'],
            'kategori' => $validated['kategori'],
            'kecamatan' => $validated['kecamatan'],
            'kulkas_farmasi' => $validated['kulkas_farmasi'],
            'stok_vaksin' => json_encode($stok_vaksin),
            'kapasitas_terisi' => round(($stok_vaksin['totalStok'] / $stok_vaksin['kapasitas_total']) * 100),
            'suhu_aktual' => $validated['suhu_aktual'],
            'last_sync' => now(),
        ]);

        return redirect()->route('inventory')->with('success', 'Data stok faskes berhasil ditambahkan secara manual.');
    }
}
