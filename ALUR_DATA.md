# Alur Data Telemetri BIO-GUARD

Dokumen ini memetakan bagaimana data telemetri mengalir dari sumber data (ESP32 asli maupun simulator) menuju ke *endpoint* API, disimpan di database, hingga akhirnya ditampilkan di *dashboard* web.

## 1. Diagram Alir Data (Flowchart)

```mermaid
flowchart TD
    %% Entitas Sumber Data
    ESP32[ESP32 Hardware Asli<br/>(Sensor Suhu + GPS SIM808)]
    SimKurir[Simulator Kurir<br/>(Aplikasi Mobile / Offline Mode)]
    SimWeb[Web Simulator HP<br/>(Standalone Web View)]
    
    %% Alur ESP32 Asli
    ESP32 -- "BLE Notify (Bluetooth)" --> SimKurir
    SimKurir -- "HTTP POST (JSON Payload)" --> APIEndpoint
    
    %% Alur Simulator
    SimWeb -- "HTTP POST (Data Dummy/Random)" --> APIEndpoint
    
    %% Backend Layer
    subgraph BACKEND [Laravel Backend]
        APIEndpoint((/api/sync/telemetri))
        Validator[FormRequest Validator<br/>(SyncTelemetriRequest)]
        Controller[SyncController@store]
        DB[(Database MySQL/PostgreSQL)]
        
        APIEndpoint --> Validator
        Validator -- "Mapping & Validasi Field" --> Controller
        Controller -- "Insert/Update Record" --> DB
    end
    
    %% Dashboard Layer
    subgraph DASHBOARD [Web Dashboard (Blade Views)]
        ViewSensor[Halaman Sensor<br/>(resources/views/dashboard/sensors.blade.php)]
        ViewDashboard[Halaman Dasbor Utama<br/>(Widget Suhu & Peta)]
        ViewPengiriman[Halaman Pengiriman<br/>(History Telemetri)]
        
        DB -- "Data JSON/Object" --> ViewSensor
        DB -.-> ViewDashboard
        DB -.-> ViewPengiriman
    end
```

### Keterangan Alur:
1. **ESP32 Asli:** ESP32 tidak langsung menembak ke API (karena mungkin tidak ada modul GSM di versi awal, atau menggunakan HP kurir sebagai gateway). ESP32 mengirim data via BLE ke Aplikasi Kurir di HP.
2. **Aplikasi Kurir:** Bertindak sebagai *gateway*, mengambil data dari ESP32, melengkapinya dengan ID Rute/Kurir (dari status login), lalu menembak ke endpoint `/api/sync/telemetri`.
3. **Simulator (Mobile & Web):** Menggunakan *endpoint* yang sama persis (`/api/sync/telemetri`). Web Simulator menggunakan JavaScript (Fetch API) untuk mengirim payload JSON tiruan dengan struktur yang identik dengan aslinya.
4. **Backend:** Request divalidasi oleh `SyncTelemetriRequest`. Di sini terjadi *mapping* krusial (misal: `lat` menjadi `latitude`) sebelum disimpan ke database.

---

## 2. Pemetaan Penamaan Field (Data Dictionary)

Sering terjadi miskomunikasi antara *layer* perangkat keras (ESP32/Flutter) dengan *backend* (Laravel). Berikut adalah tabel pemetaan yang **wajib** dipatuhi untuk menjaga konsistensi:

| Deskripsi Data | Field dari ESP32 / Mobile App (JSON) | Validator Laravel (`SyncTelemetriRequest`) | Kolom di Database (`log_telemetri`) | Catatan / Widget Terpengaruh |
|---|---|---|---|---|
| **ID Rute Perjalanan** | `id_rute` | `id_rute` | `id_rute` | Referensi ke tabel `perjalanan_rute`. Mengikat data ke Kurir dan Box. |
| **ID Kurir** | `id_kurir` (Opsional/Sering ada di payload) | *Tidak divalidasi langsung* | *Tidak disimpan di telemetri* | Didapatkan secara implisit dari `id_rute`. |
| **ID Box Pendingin** | `id_box` (Opsional) | *Tidak divalidasi langsung* | *Tidak disimpan di telemetri* | Didapatkan secara implisit dari `id_rute`. |
| **Waktu Pencatatan** | `timestamp` / `waktu_pencatatan` | `timestamp` | `timestamp` (DateTime) | Digunakan untuk grafik suhu (Chart.js) di Dashboard. |
| **Suhu Aktual** | `suhu_aktual` | `suhu_aktual` | `suhu_aktual` (Decimal) | Grafik suhu real-time & Indikator Peringatan Suhu. |
| **Suhu MKT** | `nilai_mkt` | `nilai_mkt` | `nilai_mkt` (Decimal) | Analitik kualitas vaksin di akhir perjalanan. |
| **Koordinat Latitude** | `lat` | **`latitude`** *(di-mapping dari `lat`)* | `latitude` (Double) | **Sangat Krusial:** Menentukan posisi di Peta Leaflet.js. |
| **Koordinat Longitude**| `lng` | **`longitude`** *(di-mapping dari `lng`)* | `longitude` (Double) | **Sangat Krusial:** Menentukan posisi di Peta Leaflet.js. |
| **Guncangan (G-Force)**| `gaya_guncangan` | `gaya_guncangan` | `gaya_guncangan` (Decimal) | (Fitur masa depan/Tersedia di DB) |
| **Status Baterai** | `status_baterai` | *Belum divalidasi* | *Tidak ada di tabel saat ini* | Jika dikirim, akan diabaikan oleh backend. Perlu migration baru jika ingin disimpan. |
| **Status Offline** | `is_synced_from_offline` | `is_synced_from_offline` | `is_synced_from_offline` (Boolean) | Menandakan data adalah hasil sinkronisasi *delay* karena HP blank spot/hilang sinyal. |

### ⚠️ Titik Kritis (Rawan Bug)
- **Lat/Lng Mapping:** Di masa lalu, data koordinat terbuang karena ESP32 mengirim kunci `"lat"` & `"lng"`, sedangkan Laravel `->fill()` mengharapkan `"latitude"` & `"longitude"`. Ini telah diperbaiki dengan intersepsi di metode `prepareForValidation()` pada `SyncTelemetriRequest`. Jika struktur JSON dari firmware/Flutter berubah lagi (misal menjadi `gps_lat`), backend harus segera menyesuaikan file Request ini.
- **Timestamp:** Zona waktu harus disepakati (misal mutlak menggunakan UTC atau WIB). Jika format string dari HP/ESP32 tidak standar (ISO 8601), Carbon di Laravel akan gagal melakukan *parsing* tanggal.
- **Relasi Implisit:** Aplikasi (ESP32) mungkin mengirim `id_kurir`, tapi telemetri **hanya** menyimpan `id_rute`. Backend secara otomatis merelasikan `id_rute` dengan kurir/box di tabel `perjalanan_rute` melalui Eloquent ORM. 

Dokumen ini menjadi kontrak data (*Data Contract*) yang sah antara pengembang *Hardware*, *Mobile*, dan *Backend*.
