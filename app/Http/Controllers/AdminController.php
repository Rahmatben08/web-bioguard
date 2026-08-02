<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class AdminController extends Controller
{
    /**
     * Tampilkan halaman login admin.
     */
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    /**
     * Proses autentikasi login.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors([
            'email' => 'Email atau kata sandi yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    /**
     * Proses logout admin.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    /**
     * Tampilkan halaman profil admin.
     */
    public function profile()
    {
        $user = Auth::user();
        return view('dashboard.profil', compact('user'));
    }

    /**
     * Update data profil admin.
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'dispatcher_id' => ['nullable', 'string', 'max:50'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'photo' => ['nullable', 'image', 'max:2048'], // Max 2MB
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'password.min' => 'Kata sandi minimal harus 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
            'photo.image' => 'Berkas harus berupa gambar.',
            'photo.max' => 'Ukuran gambar maksimal adalah 2MB.',
        ]);

        $data = [
            'name' => $request->name,
            'dispatcher_id' => $request->dispatcher_id,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        // Handle file upload
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            
            // Simpan langsung di public/uploads agar bisa diakses langsung via asset()
            $file->move(public_path('uploads'), $filename);
            
            // Hapus foto lama jika ada dan bukan default
            if ($user->photo && $user->photo !== 'uploads/default-avatar.png' && file_exists(public_path($user->photo))) {
                @unlink(public_path($user->photo));
            }

            $data['photo'] = 'uploads/' . $filename;
        }

        // Gunakan User model untuk mengupdate database
        User::where('id', $user->id)->update($data);

        return back()->with('success', 'Profil admin berhasil diperbarui.');
    }

    /**
     * Regenerasi IoT API Key untuk dispatcher.
     */
    public function regenerateApiKey()
    {
        $user = Auth::user();
        $newKey = 'bg_api_' . Str::random(32);

        User::where('id', $user->id)->update([
            'iot_api_key' => $newKey
        ]);

        return response()->json([
            'success' => true,
            'api_key' => $newKey
        ]);
    }
}
