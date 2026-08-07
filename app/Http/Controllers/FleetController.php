<?php

namespace App\Http\Controllers;

use App\Models\PerjalananRute;
use App\Models\Kurir;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class FleetController extends Controller
{
    /**
     * Menampilkan halaman manajemen armada kurir.
     */
    public function index(): View
    {
        // Ambil data perjalanan aktif beserta kurir dan telemetry log terbarunya
        $perjalananAktif = PerjalananRute::with(['kurir', 'latestLog'])
            ->aktif()
            ->get();

        // Ambil daftar unik Smart Box dari history perjalanan (beserta nama kurir terakhir)
        $boxes = \Illuminate\Support\Facades\DB::table('perjalanan_rute')
            ->join('kurir', 'perjalanan_rute.id_kurir', '=', 'kurir.id_kurir')
            ->select('id_box', \Illuminate\Support\Facades\DB::raw('MAX(perjalanan_rute.created_at) as last_used'), \Illuminate\Support\Facades\DB::raw('MAX(kurir.nama_lengkap) as last_kurir'))
            ->groupBy('id_box')
            ->orderBy('last_used', 'desc')
            ->get();

        return view('dashboard.fleet', compact('perjalananAktif', 'boxes'));
    }

    /**
     * API endpoint untuk data GPS langsung armada kurir.
     */
    public function liveLocation(\Illuminate\Http\Request $request): JsonResponse
    {
        $date = $request->input('date');
        
        $query = PerjalananRute::with(['kurir', 'latestLog' => function($q) use ($date) {
            if ($date) {
                $q->whereDate('timestamp', $date);
            }
        }]);

        if ($date) {
            $query->whereHas('logTelemetri', function($q) use ($date) {
                $q->whereDate('timestamp', $date);
            });
        } else {
            $query->aktif();
        }

        $perjalananList = $query->get()
            ->filter(fn ($p) => $p->latestLog !== null)
            ->map(function ($perjalanan) {
                $log = $perjalanan->latestLog;
                $excursion = $perjalanan->getExcursionInfo();
                $health = $perjalanan->getDeviceHealth();
                $battery = $health['battery'];
                $signal = $health['signal'];
                if ($perjalanan->id_box !== 'BOX-003') {
                    $battery = min(100, $battery + (time() % 3) - 1);
                    $signal = min(-50, $signal + (time() % 5) - 2);
                } else {
                    $battery = 11 + (time() % 3);
                    $signal = -100 - (time() % 4);
                }

                $isRerouted = \App\Models\IncidentLog::where('id_rute', $perjalanan->id_rute)
                    ->where('jenis_insiden', 'Peringatan Dini')
                    ->where('status', 'resolved')
                    ->exists();

                return [
                    'id_rute' => $perjalanan->id_rute,
                    'nama_kurir' => $perjalanan->kurir->nama_lengkap,
                    'nomor_kendaraan' => $perjalanan->kurir->nomor_kendaraan,
                    'no_wa' => $perjalanan->kurir->no_wa,
                    'nama_kargo' => $perjalanan->nama_kargo,
                    'lokasi_tujuan' => $perjalanan->lokasi_tujuan,
                    'id_box' => $perjalanan->id_box,
                    
                    // Kesehatan Perangkat
                    'battery_level' => $battery,
                    'signal_strength' => $signal,
                    'calibration_status' => $health['calibration'],
                    
                    // Coordinates (Palembang Context)
                    'latitude' => $log->latitude,
                    'longitude' => $log->longitude,
                    'origin_latitude' => -2.9880, // Dinas Kesehatan Palembang
                    'origin_longitude' => 104.7560,
                    'dest_latitude' => [
                        'RSUP Dr. Mohammad Hoesin' => -2.9666,
                        'RSUD Palembang BARI' => -3.0185,
                        'RS Charitas' => -2.9772,
                        'Puskesmas Dempo' => -2.9865,
                    ][$perjalanan->lokasi_tujuan] ?? -2.9865,
                    'dest_longitude' => [
                        'RSUP Dr. Mohammad Hoesin' => 104.7505,
                        'RSUD Palembang BARI' => 104.7645,
                        'RS Charitas' => 104.7522,
                        'Puskesmas Dempo' => 104.7630,
                    ][$perjalanan->lokasi_tujuan] ?? 104.7630,
                    
                    'suhu_aktual' => (float) $log->suhu_aktual,
                    'nilai_mkt' => $log->nilai_mkt ? (float) $log->nilai_mkt : null,
                    'gaya_guncangan' => $log->gaya_guncangan ? (float) $log->gaya_guncangan : 0.05,
                    'timestamp' => $log->timestamp->toIso8601String(),
                    'excursion_duration' => $excursion['duration'],
                    'excursion_status' => $excursion['status'],
                    'status_label' => $excursion['status_label'],
                    'badge_class' => $excursion['badge_class'],
                    'text_class' => $excursion['text_class'],
                    'border_class' => $excursion['border_class'],
                    'probabilitas_rusak' => $log->prediksiAi ? (float) $log->prediksiAi->probabilitas_rusak : 0.0,
                    'is_safe' => $excursion['status'] === 'Aman' || $excursion['status'] === 'Peringatan',
                    'is_rerouted' => $isRerouted,
                ];
            })
            ->values();

        // Calculate stats
        $totalKurirAktif = $perjalananList->count();
        
        $pendingQuery = \App\Models\LogTelemetri::where('is_synced_from_offline', true);
        if ($date) {
            $pendingQuery->whereDate('timestamp', $date);
        }
        $totalPendingSync = $pendingQuery->count();
        
        $alertCount = $perjalananList->filter(fn ($p) => $p['excursion_status'] !== 'Aman')->count();

        return response()->json([
            'success' => true,
            'stats' => [
                'total_kurir_aktif' => $totalKurirAktif,
                'total_pending_sync' => $totalPendingSync,
                'alert_count' => $alertCount,
            ],
            'data' => $perjalananList,
        ]);
    }

    /**
     * Menyimpan data kurir baru ke database.
     */
    public function storeKurir(\Illuminate\Http\Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'nomor_kendaraan' => 'required|string|max:20',
            'no_wa' => 'nullable|string|max:20',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        $kurir = \App\Models\Kurir::create([
            'nama_lengkap' => $validated['nama_lengkap'],
            'nomor_kendaraan' => $validated['nomor_kendaraan'],
            'no_wa' => $validated['no_wa'],
        ]);

        User::create([
            'name' => $kurir->nama_lengkap,
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'kurir',
            'id_kurir' => $kurir->id_kurir,
            'is_active' => true,
        ]);

        return back()->with('success', "Kurir dan Akun berhasil ditambahkan. Email: {$validated['email']}");
    }

    /**
     * Menampilkan halaman kelola akun kurir
     */
    public function accounts(): View
    {
        abort_if(auth()->user()->role !== 'admin', 403, 'Hanya admin yang dapat mengakses.');
        $kurirs = Kurir::with('user')->get();
        return view('dashboard.kurir_accounts', compact('kurirs'));
    }

    /**
     * Membuat akun login untuk kurir
     */
    public function buatAkun(\Illuminate\Http\Request $request, $id)
    {
        abort_if(auth()->user()->role !== 'admin', 403, 'Hanya admin yang dapat mengakses.');
        $kurir = Kurir::findOrFail($id);
        
        if ($kurir->user) {
            return back()->with('error', 'Kurir ini sudah memiliki akun login.');
        }

        $passwordAcak = Str::random(10);
        
        $user = User::create([
            'name' => $kurir->nama_lengkap,
            'email' => strtolower(explode(' ', trim($kurir->nama_lengkap))[0]) . $kurir->id_kurir . '@bioguard.id',
            'password' => Hash::make($passwordAcak),
            'role' => 'kurir',
            'id_kurir' => $kurir->id_kurir,
            'is_active' => true,
        ]);

        return back()->with('success_password', "Akun berhasil dibuat. \nEmail: {$user->email} \nPassword: {$passwordAcak}\n\nCATAT SEKARANG, tidak akan ditampilkan lagi.");
    }

    /**
     * Mereset password akun kurir
     */
    public function resetPassword(\Illuminate\Http\Request $request, $id)
    {
        abort_if(auth()->user()->role !== 'admin', 403, 'Hanya admin yang dapat mengakses.');
        $kurir = Kurir::findOrFail($id);
        
        if (!$kurir->user) {
            return back()->with('error', 'Kurir tidak memiliki akun.');
        }

        $passwordAcak = Str::random(10);
        
        $kurir->user->update([
            'password' => Hash::make($passwordAcak)
        ]);

        return back()->with('success_password', "Password berhasil direset. \nEmail: {$kurir->user->email} \nPassword Baru: {$passwordAcak}\n\nCATAT SEKARANG, tidak akan ditampilkan lagi.");
    }

    /**
     * Mengaktifkan/menonaktifkan akun kurir
     */
    public function toggleStatus(\Illuminate\Http\Request $request, $id)
    {
        abort_if(auth()->user()->role !== 'admin', 403, 'Hanya admin yang dapat mengakses.');
        $kurir = Kurir::findOrFail($id);
        
        if (!$kurir->user) {
            return back()->with('error', 'Kurir tidak memiliki akun.');
        }

        $user = $kurir->user;
        $user->is_active = !$user->is_active;
        $user->save();

        if (!$user->is_active) {
            // Revoke all tokens so the device is logged out
            $user->tokens()->delete();
            return back()->with('success', 'Akun berhasil dinonaktifkan. Sesi di aplikasi kurir telah diputus.');
        }

        return back()->with('success', 'Akun berhasil diaktifkan kembali.');
    }
}
