<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Login API for Kurir and other mobile users.
     */
    public function login(Request $request)
    {
        \Illuminate\Support\Facades\Log::info('LOGIN ATTEMPT: ' . json_encode($request->all()));
        
        $request->validate([
            'id_kurir' => 'required',
            'password' => 'required',
        ]);

        $loginId = $request->id_kurir;
        
        // 1. Coba cari berdasarkan user.id_kurir (angka eksak) atau user.email
        $user = User::where('id_kurir', $loginId)
                    ->orWhere('email', $loginId)
                    ->first();
                    
        // 2. Jika tidak ketemu, coba cari berdasarkan plat kendaraan (nomor_kendaraan) 
        // Mengabaikan spasi dan strip (dash) agar BG-1234 XYZ sama dengan BG 1234 XYZ
        if (!$user) {
            $normalizedInput = str_replace([' ', '-'], '', strtolower($loginId));
            $kurir = \App\Models\Kurir::all()->first(function($k) use ($normalizedInput) {
                return str_replace([' ', '-'], '', strtolower($k->nomor_kendaraan)) === $normalizedInput;
            });
            
            if ($kurir) {
                $user = User::where('id_kurir', $kurir->id_kurir)->first();
            }
        }

        if ($user && Hash::check($request->password, $user->password)) {
            if (!$user->is_active) {
                return response()->json([
                    'success' => false,
                    'message' => 'Akun Anda dinonaktifkan. Silakan hubungi admin.'
                ], 403);
            }

            // Create a plain text token for the user via Sanctum
            $token = $user->createToken('kurir-app')->plainTextToken;

            return response()->json([
                'success' => true,
                'token' => $token,
                'role' => $user->role,
                'id_kurir' => $user->id_kurir,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'ID Kurir atau password salah.',
        ], 401);
    }
}
