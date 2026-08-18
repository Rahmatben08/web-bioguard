<?php

namespace App\Http\Controllers;

use App\Services\TelegramService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Log;

class NotificationController extends Controller
{
    /**
     * Handle incoming notification request from frontend and forward to Telegram.
     */
    public function sendTelegramAlert(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'message' => 'required|string',
            'type' => 'required|string|in:TG,WA',
            'category' => 'required|string',
        ]);

        // Only process TG (Telegram) for now
        if ($validated['type'] !== 'TG') {
            return response()->json([
                'success' => false,
                'message' => 'Tipe notifikasi tidak didukung atau belum diimplementasikan.'
            ]);
        }

        // Simple rate limiting: max 10 alerts per minute per IP
        $executed = RateLimiter::attempt(
            'send-telegram-alert:' . $request->ip(),
            $perMinute = 10,
            function() {
                return true; // Mark as executed, actual send below
            }
        );

        if (!$executed) {
            Log::warning('Telegram alert rate limited for IP: ' . $request->ip());
            return response()->json([
                'success' => false,
                'message' => 'Terlalu banyak request (Rate Limited).'
            ], 429);
        }

        try {
            $sent = TelegramService::sendMessage($validated['message']);
        } catch (\Exception $e) {
            Log::error('Telegram send exception: ' . $e->getMessage());
            $sent = false;
        }

        return response()->json([
            'success' => $sent,
            'message' => $sent ? 'Pesan Telegram berhasil diproses.' : 'Pengiriman Telegram gagal, cek konfigurasi bot.'
        ]);
    }
}
