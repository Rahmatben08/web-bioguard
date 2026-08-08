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

        // Simple rate limiting: max 5 alerts per minute per IP to prevent spam if sensors go crazy
        $executed = RateLimiter::attempt(
            'send-telegram-alert:' . $request->ip(),
            $perMinute = 5,
            function() use ($validated) {
                // Send to telegram
                return TelegramService::sendMessage($validated['message']);
            }
        );

        if (!$executed) {
            Log::warning('Telegram alert rate limited for IP: ' . $request->ip());
            return response()->json([
                'success' => false,
                'message' => 'Terlalu banyak request (Rate Limited).'
            ], 429);
        }

        return response()->json([
            'success' => true,
            'message' => 'Pesan Telegram berhasil diproses.'
        ]);
    }
}
