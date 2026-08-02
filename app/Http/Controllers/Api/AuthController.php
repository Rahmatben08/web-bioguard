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
        $request->validate([
            'id_kurir' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('id_kurir', $request->id_kurir)->first();

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
