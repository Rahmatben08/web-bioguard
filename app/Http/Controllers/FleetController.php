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
    public function index(\Illuminate\Http\Request $request): View
    {
        // Ambil data perjalanan aktif beserta kurir dan telemetry log terbarunya
        $query = PerjalananRute::with(['kurir', 'latestLog'])->aktif();

        // Pisahkan Data Demo dan Asli secara eksklusif
        if ($request->has('show_demo')) {
            $query->where('is_demo', true);
        } else {
            $query->where('is_demo', false);
        }

        $perjalananAktif = $query->get();

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
        $initialLoad = $request->input('initial_load') === 'true';
        
        $with = ['kurir', 'latestLog' => function($q) use ($date) {
            if ($date) {
                $q->whereDate('timestamp', $date);
            }
        }];

        if ($initialLoad) {
            $with['logTelemetri'] = function($q) use ($date) {
                $q->select('id', 'id_rute', 'latitude', 'longitude', 'timestamp')->orderBy('timestamp', 'asc');
                if ($date) {
                    $q->whereDate('timestamp', $date);
                }
            };
        }

        $query = PerjalananRute::with($with);

        if ($date) {
            $query->whereHas('logTelemetri', function($q) use ($date) {
                $q->whereDate('timestamp', $date);
            });
        } else {
            $query->aktif();
        }

        $perjalananList = $query->get()
            ->map(function ($perjalanan) use ($initialLoad) {
                $log = $perjalanan->latestLog;
                $excursion = $perjalanan->getExcursionInfo();
                $health = $perjalanan->getDeviceHealth();
                $battery = $health['battery'];
                $signal = $health['signal'];
                $battery = $health['battery'];
                $signal = $health['signal'];

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
                    
                    'latitude' => $log ? $log->latitude : -2.9880,
                    'longitude' => $log ? $log->longitude : 104.7560,
                    'origin_latitude' => -2.9880, // Dinas Kesehatan Palembang
                    'origin_longitude' => 104.7560,
                    'dest_latitude' => [
                        'RSUP Dr. Mohammad Hoesin' => -2.9662628,
                        'RSUD Palembang BARI' => -3.0185,
                        'RS Charitas' => -2.9772,
                        'RS RK Charitas' => -2.9759693,
                        'Puskesmas Dempo' => -2.9818201,
                        'RSUD Siti Fatimah' => -2.9482931,
                        'RS Hermina' => -2.9559237,
                        'RS Siloam Sriwijaya' => -2.9776129,
                        'RS Bhayangkara' => -2.9587303,
                        'RS Muhammadiyah' => -3.0003649,
                        'RS Myria' => -2.9398741,
                        'RS Ernaldi Bahar' => -2.922228,
                        'RS Pelabuhan' => -2.978579,
                        'Puskesmas Merdeka' => -2.9904511,
                        'Puskesmas Plaju' => -2.9957835,
                        'Puskesmas 7 Ulu' => -2.9967184,
                        'Puskesmas 11 Ilir' => -2.9811521,
                        'Puskesmas Kalidoni' => -2.9404873,
                        'Puskesmas Kenten' => -2.9404873,
                        'Puskesmas Boom Baru' => -2.9754512,
                        'Puskesmas Kampus' => -2.9754956,
                        'Puskesmas Alang-Alang Lebar' => -2.9394118,
                        'Dinas Kesehatan Kota Palembang' => -2.9901778,
                    ][$perjalanan->lokasi_tujuan] ?? -2.9865,
                    'dest_longitude' => [
                        'RSUP Dr. Mohammad Hoesin' => 104.7498217,
                        'RSUD Palembang BARI' => 104.7645,
                        'RS Charitas' => 104.7522,
                        'RS RK Charitas' => 104.7528599,
                        'Puskesmas Dempo' => 104.7589042,
                        'RSUD Siti Fatimah' => 104.7345504,
                        'RS Hermina' => 104.74846,
                        'RS Siloam Sriwijaya' => 104.7422702,
                        'RS Bhayangkara' => 104.7374268,
                        'RS Muhammadiyah' => 104.8163221,
                        'RS Myria' => 104.7269887,
                        'RS Ernaldi Bahar' => 104.6846093,
                        'RS Pelabuhan' => 104.7766276,
                        'Puskesmas Merdeka' => 104.7528331,
                        'Puskesmas Plaju' => 104.8136447,
                        'Puskesmas 7 Ulu' => 104.7639636,
                        'Puskesmas 11 Ilir' => 104.7673696,
                        'Puskesmas Kalidoni' => 104.7674479,
                        'Puskesmas Kenten' => 104.7674479,
                        'Puskesmas Boom Baru' => 104.7824651,
                        'Puskesmas Kampus' => 104.7382453,
                        'Puskesmas Alang-Alang Lebar' => 104.7000131,
                        'Dinas Kesehatan Kota Palembang' => 104.7573614,
                    ][$perjalanan->lokasi_tujuan] ?? 104.7630,
                    
                    'suhu_aktual' => $log ? (float) $log->suhu_aktual : 5.0,
                    'nilai_mkt' => ($log && $log->nilai_mkt) ? (float) $log->nilai_mkt : null,
                    'gaya_guncangan' => ($log && $log->gaya_guncangan) ? (float) $log->gaya_guncangan : 0.05,
                    'timestamp' => $log ? $log->timestamp->toIso8601String() : now()->toIso8601String(),
                    'excursion_duration' => $excursion['duration'],
                    'excursion_status' => $excursion['status'],
                    'status_label' => $excursion['status_label'],
                    'badge_class' => $excursion['badge_class'],
                    'text_class' => $excursion['text_class'],
                    'border_class' => $excursion['border_class'],
                    'probabilitas_rusak' => ($log && $log->prediksiAi) ? (float) $log->prediksiAi->probabilitas_rusak : 0.0,
                    'is_safe' => $excursion['status'] === 'Aman' || $excursion['status'] === 'Peringatan',
                    'is_rerouted' => $isRerouted,
                    'path_history' => $initialLoad && $perjalanan->relationLoaded('logTelemetri')
                        ? $perjalanan->logTelemetri->map(fn($l) => [(float)$l->latitude, (float)$l->longitude])->toArray()
                        : null,
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
            'nomor_kendaraan' => ['required', 'string', 'max:20', 'regex:/^BG/i'],
            'no_wa' => 'nullable|string|max:20',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ], [
            'nomor_kendaraan.regex' => 'Nomor kendaraan harus diawali dengan BG.',
        ]);

        try {
            \Illuminate\Support\Facades\DB::beginTransaction();

            $kurir = \App\Models\Kurir::create([
                'nama_lengkap' => $validated['nama_lengkap'],
                'nomor_kendaraan' => $validated['nomor_kendaraan'],
                'no_wa' => $validated['no_wa'],
            ]);

            \App\Models\User::create([
                'name' => $kurir->nama_lengkap,
                'email' => $validated['email'],
                'password' => \Illuminate\Support\Facades\Hash::make($validated['password']),
                'role' => 'kurir',
                'id_kurir' => $kurir->id_kurir,
                'is_active' => true,
            ]);

            \Illuminate\Support\Facades\DB::commit();

            return back()->with('success', "Kurir dan Akun berhasil ditambahkan. Email: {$validated['email']}");
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return back()->withInput()->with('error', "Gagal menambahkan kurir: " . $e->getMessage());
        }
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

    public function updateAkun(\Illuminate\Http\Request $request, $id)
    {
        abort_if(auth()->user()->role !== 'admin', 403, 'Hanya admin yang dapat mengakses.');
        $kurir = Kurir::findOrFail($id);
        
        if (!$kurir->user) {
            return back()->with('error', 'Kurir tidak memiliki akun.');
        }

        $validated = $request->validate([
            'email' => 'required|email|unique:users,email,' . $kurir->user->id,
            'password' => 'nullable|string|min:6',
        ]);

        $updateData = ['email' => $validated['email']];
        if (!empty($validated['password'])) {
            $updateData['password'] = \Illuminate\Support\Facades\Hash::make($validated['password']);
        }

        $kurir->user->update($updateData);

        return back()->with('success', 'Email/Password akun kurir berhasil diperbarui.');
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
