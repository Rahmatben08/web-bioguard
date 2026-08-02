<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class DeviceController extends Controller
{
    /**
     * Menampilkan halaman daftar sensor ESP32 BLE MAC Addresses dan pairing.
     */
    public function index(): View
    {
        return view('dashboard.sensors');
    }
}
