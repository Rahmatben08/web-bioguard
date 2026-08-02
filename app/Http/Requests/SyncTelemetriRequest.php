<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Validasi request untuk sinkronisasi data telemetri dari Flutter.
 */
class SyncTelemetriRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // API auth handled by middleware/token
    }

    public function rules(): array
    {
        return [
            'data' => 'required|array|min:1',
            'data.*.id_rute' => 'required|integer|exists:perjalanan_rute,id_rute',
            'data.*.timestamp' => 'required|date',
            'data.*.suhu_aktual' => 'required|numeric|between:-50,100',
            'data.*.nilai_mkt' => 'nullable|numeric|between:-50,100',
            'data.*.latitude' => 'required|numeric|between:-90,90',
            'data.*.longitude' => 'required|numeric|between:-180,180',
            'data.*.is_synced_from_offline' => 'sometimes|boolean',
            'data.*.gaya_guncangan' => 'sometimes|numeric|between:0,20',
        ];
    }

    public function messages(): array
    {
        return [
            'data.required' => 'Payload data telemetri wajib diisi.',
            'data.array' => 'Payload harus berupa array.',
            'data.min' => 'Minimal 1 record telemetri harus dikirim.',
            'data.*.id_rute.required' => 'ID Rute wajib diisi untuk setiap record.',
            'data.*.id_rute.exists' => 'ID Rute :input tidak ditemukan di database.',
            'data.*.timestamp.required' => 'Timestamp wajib diisi.',
            'data.*.suhu_aktual.required' => 'Suhu aktual wajib diisi.',
            'data.*.latitude.required' => 'Latitude wajib diisi.',
            'data.*.longitude.required' => 'Longitude wajib diisi.',
        ];
    }
}
