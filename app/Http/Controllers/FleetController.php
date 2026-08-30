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
        $query = PerjalananRute::with(['kurir', 'device', 'latestLog'])->aktif();

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
            ->leftJoin('devices', 'perjalanan_rute.id_box', '=', 'devices.id_box')
            ->select(
                'perjalanan_rute.id_box', 
                \Illuminate\Support\Facades\DB::raw('MAX(perjalanan_rute.created_at) as last_used'), 
                \Illuminate\Support\Facades\DB::raw('MAX(kurir.nama_lengkap) as last_kurir'),
                \Illuminate\Support\Facades\DB::raw('MAX(CAST(devices.is_validated AS INTEGER)) as is_validated')
            )
            ->groupBy('perjalanan_rute.id_box')
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
        
        $with = ['kurir', 'device', 'latestLog' => function($q) use ($date) {
            if ($date) {
                $q->whereDate('timestamp', $date);
            }
        }];

        if ($initialLoad) {
            $with['logTelemetri'] = function($q) use ($date) {
                $q->select('id_log', 'id_rute', 'latitude', 'longitude', 'timestamp')
                  ->where('is_outlier', false)
                  ->orderBy('timestamp', 'asc');
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

        // Pisahkan Data Demo dan Asli secara eksklusif untuk API
        if ($request->has('show_demo')) {
            $query->where('is_demo', true);
        } else {
            $query->where('is_demo', false);
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
                    $faskes = \App\Models\InventoryHub::where('nama', $perjalanan->lokasi_tujuan)->first();
                      $faskes = \App\Models\InventoryHub::where('nama', $perjalanan->lokasi_tujuan)->first();
                    'is_validated' => $perjalanan->device ? $perjalanan->device->is_validated : false,
                    'validation_expiration' => $perjalanan->device && $perjalanan->device->validation_expiration ? \Carbon\Carbon::parse($perjalanan->device->validation_expiration)->format('Y-m-d') : null,
                    
                    'latitude' => $log ? $log->latitude : -2.9880,
                    'longitude' => $log ? $log->longitude : 104.7560,
                    'origin_latitude' => -2.9880, // Dinas Kesehatan Palembang
                    'origin_longitude' => 104.7560,
                    'dest_latitude' => $faskes && $faskes->latitude ? (float) $faskes->latitude : -2.9865,
                    'dest_longitude' => $faskes && $faskes->longitude ? (float) $faskes->longitude : 104.7522,
                    
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
                    'is_demo' => (bool)$perjalanan->is_demo,
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


