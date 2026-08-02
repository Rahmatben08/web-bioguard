<?php

namespace App\Http\Controllers;

use App\Models\IncidentLog;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class AlertController extends Controller
{
    /**
     * Menampilkan daftar peringatan anomali suhu rantai dingin.
     */
    public function index(): View
    {
        // Ambil semua log insiden diurutkan dari yang aktif terlebih dahulu
        $incidents = IncidentLog::with('perjalananRute.kurir')
            ->orderBy('status', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('dashboard.alerts', compact('incidents'));
    }

    /**
     * Konfirmasi insiden secara AJAX agar statusnya menjadi 'resolved'.
     */
    public function resolve(int $id): JsonResponse
    {
        $incident = IncidentLog::find($id);

        if (!$incident) {
            return response()->json([
                'success' => false,
                'message' => 'Data insiden tidak ditemukan.'
            ], 404);
        }

        $incident->update(['status' => 'resolved']);

        return response()->json([
            'success' => true,
            'message' => 'Insiden berhasil dikonfirmasi dan ditandai selesai.'
        ]);
    }

    /**
     * API endpoint untuk polling data peringatan secara real-time.
     */
    public function liveData(): JsonResponse
    {
        $incidents = IncidentLog::with('perjalananRute.kurir')
            ->orderBy('status', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();

        $activeCount = $incidents->where('status', 'aktif')->count();
        $health = $activeCount > 0 ? max(50, 100 - ($activeCount * 12.5)) : 100;

        $data = $incidents->map(function ($inc) {
            return [
                'id' => $inc->id,
                'jenis_insiden' => $inc->jenis_insiden,
                'deskripsi' => $inc->deskripsi,
                'suhu_tercatat' => $inc->suhu_tercatat,
                'durasi_anomali' => $inc->durasi_anomali,
                'status' => $inc->status,
                'created_at' => $inc->created_at->format('H:i:s'),
                'created_at_full' => $inc->created_at->format('Y-m-d H:i:s'),
                'id_box' => $inc->perjalananRute ? $inc->perjalananRute->id_box : null,
                'kurir' => $inc->perjalananRute && $inc->perjalananRute->kurir ? $inc->perjalananRute->kurir->nama_lengkap : null,
            ];
        });

        return response()->json([
            'success' => true,
            'timestamp' => now()->toIso8601String(),
            'stats' => [
                'activeCount' => $activeCount,
                'health' => $health,
            ],
            'incidents' => $data,
        ]);
    }
}
