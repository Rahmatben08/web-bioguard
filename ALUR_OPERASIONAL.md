# Alur Operasional Sistem BIO-GUARD

Dokumen ini mendeskripsikan proses bisnis *end-to-end* dari sisi pengguna, mulai dari persiapan kurir hingga pelacakan telemetri selesai. Dokumen ini juga memperjelas batasan tanggung jawab antartim pengembang.

## 1. Flow Proses Bisnis End-to-End

Berikut adalah urutan kronologis standar operasional prosedur (SOP) pengiriman vaksin BIO-GUARD:

1. **Registrasi Kurir (Admin Web):**
   - Admin *login* ke Dashboard BIO-GUARD.
   - Admin mendaftarkan Kurir Baru melalui menu **Akun Kurir**, menginput Nama, Pelat Kendaraan (wajib berawalan `BG`), dan Email.
   - Sistem secara otomatis membuatkan *password* (atau Admin menggantinya) dan menyimpannya.

2. **Persiapan & Cetak QR Box (Admin Web):**
   - Admin membuat rute penugasan baru di menu **Pengiriman / Armada**.
   - Sistem menghasilkan QR Code unik yang merangkum *pairing data* (ID Rute, ID Box, dan konfigurasi lainnya).
   - Admin mencetak QR Code tersebut dan menempelkannya di fisik Box Pendingin BIO-GUARD.

3. **Persiapan Kurir (Aplikasi Mobile):**
   - Kurir mengunduh dan menginstal APK *BIO-GUARD Vaccine Courier Portal* terbaru.
   - Kurir membuka aplikasi, memastikan internet (Wi-Fi/Paket Data) aktif agar tidak masuk mode *(Offline Mode)*.
   - Kurir *login* menggunakan **Pelat Nomor Kendaraan** (misal: `BG 1234 XYZ` atau `BG-001` sesuai format) dan password yang diberikan Admin.

4. **Pairing Perangkat (Kurir & ESP32):**
   - Box Pendingin BIO-GUARD (dengan modul ESP32 di dalamnya) dinyalakan.
   - Kurir menggunakan aplikasi *mobile* untuk **Scan QR Code** yang tertempel di Box.
   - Setelah scan berhasil, aplikasi *mobile* menghubungkan diri ke ESP32 via **Bluetooth Low Energy (BLE)**.
   - Aplikasi *mobile* mengirimkan perintah *BLE Write* berisi token, `id_kurir`, dan `id_rute` ke ESP32.

5. **Pelacakan Perjalanan (ESP32 & Admin):**
   - ESP32 menyimpan kredensial rute tersebut dan mulai mengumpulkan data dari sensor suhu, baterai, dan modul GPS SIM808.
   - ESP32 mengirim (*BLE Notify*) telemetri ke Aplikasi Mobile.
   - Aplikasi Mobile secara real-time (*HTTP POST*) meneruskan data ini ke `/api/sync/telemetri` di Backend Laravel.
   - Admin yang memantau di Dashboard (menu **Sensor** atau Dasbor) dapat melihat pergerakan titik lokasi (Leaflet.js) dan grafik suhu (Chart.js) kurir tersebut secara aktual.

6. **Penyelesaian Perjalanan:**
   - Setelah sampai di titik akhir, Kurir menekan tombol "Selesaikan Perjalanan" di Aplikasi Mobile, yang mencatat waktu tiba dan memutuskan koneksi BLE.
   - Jika kurir lupa menekan tombol, baterai mati, atau aplikasi *nyangkut* (*stuck*), Admin memiliki tombol **Force-Close (Tandai Selesai)** dari Web Dashboard untuk menghentikan pelacakan rute tersebut secara paksa.

---

## 2. Pembagian Tanggung Jawab & Konsistensi Kontrak Data

Sistem BIO-GUARD terdiri dari tiga *layer* yang terpisah namun wajib berkomunikasi dengan bahasa (struktur JSON) yang sama. Jika ada salah satu tim yang mengubah nama variabel secara sepihak, aliran data akan terputus.

| Layer / Tim Pengembang | Area Tanggung Jawab Utama | Kewajiban Konsistensi (Kontrak Data) |
|---|---|---|
| **Tim Firmware (ESP32 / C++)** | Membaca sensor suhu akurat, mengambil fix GPS SIM808, manajemen daya baterai, dan menjaga koneksi BLE dengan HP Kurir stabil. | Wajib memastikan format *Key JSON* yang dikirimkan ke aplikasi (misal: `"lat"`, `"lng"`, `"suhu_aktual"`) tidak berubah. Jika sensor baterai ditambahkan (misal: `"status_baterai"`), wajib lapor ke tim Mobile & Web. |
| **Tim Mobile App (Flutter / React Native)** | Menyediakan UI untuk Login (API Auth), scanner QR Code, menjembatani BLE dari ESP32 untuk dilempar ke Backend (via HTTP API), dan *Offline Sync*. | Wajib mem-forward data dari ESP32 ke Backend **tanpa merusak strukturnya**. Bertanggung jawab menjaga *base URL* aplikasi menunjuk ke *endpoint live* (`https://bioguard.id`). Jika ada pembaruan *endpoint*, tim Mobile wajib *build & release* APK baru. |
| **Tim Backend & Web (Laravel / Vue/Blade)** | Mengelola database (MySQL), Auth Sanctum, Validasi HTTP Request (`SyncTelemetriRequest`), UI/UX Dashboard Admin, dan kalkulasi MKT. | Berfungsi sebagai pintu gerbang (*Gatekeeper*). Wajib memperbarui logika *mapping* atau `FormRequest` jika Tim Firmware mengubah nama *field*. Tim Backend juga bertanggung jawab menyajikan *API Docs* yang mutakhir bagi Tim Mobile. |

**Prosedur Perubahan Kontrak Data:**
1. Jika Tim A ingin mengubah/menambahkan parameter (contoh: *Tim Firmware ingin mengirim data G-Force/Guncangan*).
2. Tim A wajib menginformasikan Tim C (Backend) terlebih dahulu.
3. Tim C membuat *migration* database dan menyesuaikan aturan validasi di API.
4. Tim B (Mobile) menyesuaikan kode jika mereka perlu membaca field tersebut di UI HP.
5. Baru perubahan di-*deploy* ke *production*.
