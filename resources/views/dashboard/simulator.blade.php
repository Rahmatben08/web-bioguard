@extends('layouts.app')

@section('title', 'Simulator Kurir Telemetri')

@section('content')
<div class="flex-1 w-full min-h-full flex flex-col lg:flex-row p-md lg:p-lg gap-lg overflow-y-auto">
    <!-- LEFT COLUMN: Mobile Mockup Device -->
    <div class="w-full lg:w-1/2 flex justify-center items-center relative py-12">
        <!-- Smartphone Container -->
        <div class="relative w-[360px] h-[720px] rounded-[48px] bg-slate-950 p-[12px] border-[6px] border-slate-800 shadow-[0_25px_60px_-15px_rgba(0,0,0,0.5)] (0,0,0,0.8)] overflow-hidden flex flex-col ring-1 ring-white/10 lg:scale-125 xl:scale-[1.35] origin-center transition-transform duration-500">
            <!-- Screen Notch / Dynamic Island -->
            <div class="absolute top-[18px] left-1/2 -translate-x-1/2 w-[110px] h-[24px] bg-black rounded-full z-50 flex items-center justify-between px-3">
                <div class="w-1.5 h-1.5 rounded-full bg-slate-800/80"></div>
                <div class="w-8 h-1 bg-slate-900/60 rounded-full"></div>
            </div>

            <!-- Phone Screen Content -->
            <div id="phone-screen" class="w-full h-full rounded-[38px] overflow-hidden bg-slate-900 flex flex-col relative text-white select-none transition-colors duration-300">
                <!-- Phone Header Status Bar -->
                <div id="phone-status-bar" class="h-10 bg-slate-950/80 backdrop-blur-md px-6 pt-3 flex justify-between items-center text-[10px] font-bold tracking-wider z-40 select-none transition-colors duration-300">
                    <span id="phone-clock">10:00</span>
                    <div class="flex items-center gap-1.5">
                        <!-- Simulated Light/Dark Theme Switcher (Ergonomic Toggle) -->
                        <button onclick="toggleMockupTheme()" class="text-slate-400 hover:text-white mr-1 flex items-center justify-center cursor-pointer">
                            <span id="mockup-theme-icon" class="material-symbols-outlined text-xs">light_mode</span>
                        </button>
                        <span id="ble-badge" class="px-1.5 py-0.5 rounded-sm bg-red-500/20 text-red-400 border border-red-500/30 text-[8px] font-extrabold uppercase">BLE: OFF</span>
                        <span id="gps-status" class="text-slate-400 material-symbols-outlined text-xs">gps_fixed</span>
                        <span id="phone-wifi-icon" class="material-symbols-outlined text-xs text-teal-400">wifi</span>
                        <span class="material-symbols-outlined text-xs">battery_charging_full</span>
                    </div>
                </div>

                <!-- Simulation Overlay: Full-Screen Red Alert (Core PKM Logic) -->
                <div id="critical-overlay" class="hidden absolute inset-0 bg-red-950/95 z-50 flex flex-col justify-center items-center p-6 text-center select-none animate-pulse transition-colors duration-500">
                    <div id="critical-img-container" class="w-40 h-40 mb-4 animate-bounce relative">
                        <img id="critical-penguin-img" src="{{ asset('images/penguin_hot.png') }}" class="w-full h-full object-contain filter drop-shadow-[0_0_15px_rgba(239,68,68,0.8)]">
                    </div>
                    <h1 id="critical-title" class="text-lg font-bold text-white tracking-wide uppercase leading-tight mb-2">CRITICAL ALERT</h1>
                    <h2 id="critical-sub" class="text-xs font-bold text-red-400 uppercase tracking-widest mb-6 px-4 leading-relaxed">EKSKURSI SUHU - KARANTINA KARGO SEKARANG!</h2>
                    
                    <div id="critical-info-box" class="bg-red-900/30 border border-red-500/40 rounded-2xl p-4 w-full mb-8 transition-colors duration-500">
                        <div id="critical-temp-label" class="text-xs text-red-300 uppercase font-bold tracking-wider mb-1">Suhu Sensor Saat Ini</div>
                        <div id="overlay-temp-display" class="text-3xl font-black text-white">8.6Â&deg;C</div>
                    </div>

                    <button id="critical-reset-btn" onclick="resetSimulation()" class="px-6 py-3 rounded-full bg-white text-red-950 font-black tracking-wider hover:bg-slate-200 transition-transform active:scale-95 text-xs shadow-[0_0_20px_rgba(255,255,255,0.4)] uppercase">
                        Reset Status & Alarm
                    </button>
                </div>

                <!-- ==================== TABS CONTENT ==================== -->

                <!-- TAB 1: NAVIGASI & PETA VIEW -->
                <div id="tab-content-navigasi" class="flex-1 w-full relative z-10 flex flex-col">
                    <div id="map-container" class="flex-1 w-full bg-slate-950 relative">
                        <div id="sim-map" class="w-full h-full"></div>

                        <!-- Floated Header: App Brand -->
                        <div class="absolute top-4 left-4 right-4 z-20 pointer-events-none">
                            <div id="floated-brand-card" class="bg-slate-950/85 backdrop-blur-md border border-white/10 rounded-2xl p-3 flex items-center justify-between shadow-lg transition-colors duration-300">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-lg bg-cyan-500/20 border border-cyan-500 flex items-center justify-center">
                                        <span class="material-symbols-outlined text-cyan-400 text-xs">shield</span>
                                    </div>
                                    <div class="flex flex-col">
                                        <span id="brand-title" class="font-black text-[11px] tracking-wider text-white">BIO-GUARD NAV</span>
                                        <span id="brand-subtitle" class="text-[8px] text-cyan-400 font-bold uppercase tracking-widest">Sistem Rantai Dingin</span>
                                    </div>
                                </div>
                                <div id="route-indicator-badge" class="px-2 py-0.5 rounded-full bg-slate-800 text-[8px] text-slate-300 font-bold uppercase">
                                    DINKES Ã¢â€ â€™ RSUP
                                </div>
                            </div>
                        </div>

                        <!-- Floated Temperature Panel Card (Thumb-Friendly, glassmorphic) -->
                        <div class="absolute top-18 left-4 right-4 z-20">
                            <div id="telemetry-float-card" class="bg-slate-950/85 backdrop-blur-md border-l-4 border-cyan-500 border-t border-b border-r border-white/10 rounded-2xl p-3.5 flex items-center justify-between shadow-xl transition-all duration-300">
                                <div class="flex flex-col">
                                    <span id="telemetry-card-title" class="text-[9px] text-slate-400 font-bold uppercase tracking-wider">Suhu Aktual Boks</span>
                                    <div class="flex items-baseline gap-1.5">
                                        <span id="float-temp" class="text-xl font-bold text-cyan-400">4.5Â&deg;C</span>
                                        <span id="float-mkt-container" class="text-xs text-slate-500 font-bold">MKT: <span id="float-mkt">4.8Â&deg;C</span></span>
                                    </div>
                                </div>
                                <div class="flex flex-col items-end">
                                    <span id="viability-badge" class="px-2.5 py-0.5 rounded-full bg-cyan-500/10 text-cyan-400 border border-cyan-500/20 text-[8px] font-extrabold uppercase tracking-wide">AMAN</span>
                                    <div id="timer-box" class="hidden mt-1.5 flex items-center gap-1 bg-amber-500/20 text-amber-400 border border-amber-500/30 px-2 py-0.5 rounded-md text-[9px] font-extrabold">
                                        <span class="material-symbols-outlined text-[10px] animate-spin">hourglass_empty</span>
                                        <span>EKSKURSI: <span id="countdown-display">30s</span></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Floated Emergency SOS Floating Button (Thumb-Friendly, Bottom Right) -->
                        <div class="absolute bottom-6 right-4 z-30">
                            <button onclick="openSosModal()" class="w-14 h-14 rounded-full bg-red-600 hover:bg-red-700 text-white flex items-center justify-center shadow-[0_0_20px_rgba(239,68,68,0.5)] transition-all duration-300 hover:scale-105 active:scale-95 border border-red-500/30 cursor-pointer">
                                <span class="material-symbols-outlined text-3xl font-bold animate-pulse">sos</span>
                            </button>
                        </div>

                        <!-- Bottom Nav Panel Overlay (SOS Modal popup inside phone screen) -->
                        <div id="sos-modal" class="hidden absolute inset-x-4 bottom-20 z-45 bg-slate-950/95 backdrop-blur-md border border-white/10 rounded-[32px] p-5 shadow-2xl flex-col gap-4 animate-[slideUp_0.3s_ease-out] transition-colors duration-300">
                            <div class="flex justify-between items-center border-b border-white/5 pb-2.5">
                                <div class="flex items-center gap-2 text-red-500">
                                    <span class="material-symbols-outlined">sos</span>
                                    <span class="text-xs font-black tracking-wider uppercase">Pemicu SOS Darurat</span>
                                </div>
                                <button onclick="closeSosModal()" class="text-slate-400 hover:text-white">
                                    <span class="material-symbols-outlined text-sm">close</span>
                                </button>
                            </div>
                            <p id="sos-description" class="text-[10px] text-slate-400 leading-normal mb-1">Pilih jenis insiden darurat untuk dilaporkan ke Web Pusat Kendali secara langsung:</p>
                            
                            <div class="grid grid-cols-2 gap-3">
                                <button onclick="reportSosIncident('Kemacetan Ekstrem')" class="p-3.5 rounded-2xl bg-amber-500/10 border border-amber-500/20 hover:bg-amber-500/20 text-center flex flex-col items-center gap-1.5 transition-all cursor-pointer">
                                    <span class="material-symbols-outlined text-amber-500 text-2xl">traffic</span>
                                    <span class="text-[9px] font-black text-amber-400 uppercase tracking-wider">Macet Total</span>
                                </button>
                                <button onclick="reportSosIncident('Boks Bocor')" class="p-3.5 rounded-2xl bg-red-500/10 border border-red-500/20 hover:bg-red-500/20 text-center flex flex-col items-center gap-1.5 transition-all cursor-pointer">
                                    <span class="material-symbols-outlined text-red-500 text-2xl">error_outline</span>
                                    <span class="text-[9px] font-black text-red-400 uppercase tracking-wider">Boks Bocor</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TAB 2: SCANNER SCREEN VIEW (Fitur Scanner Barcode Kargo) -->
                <div id="tab-content-scanner" class="hidden flex-1 w-full bg-slate-900 relative z-10 flex flex-col p-6 items-center justify-between transition-colors duration-300">
                    <div class="w-full text-center">
                        <h2 id="scanner-title" class="text-sm font-black tracking-widest text-slate-200 uppercase mt-4">Koneksi & Scanner Kargo</h2>
                        <p id="scanner-subtitle" class="text-[9px] text-slate-400 mt-1 uppercase">Arahkan kamera ke QR Code Box IoT</p>
                    </div>

                    <!-- Animated Viewfinder Scanner Overlay -->
                    <div id="viewfinder-box" class="relative w-48 h-48 rounded-3xl border-2 border-white/20 overflow-hidden bg-black/60 shadow-inner flex items-center justify-center">
                        <div class="absolute inset-0 border-2 border-cyan-500/30 m-4 rounded-xl"></div>
                        <!-- Corner Viewfinder Marks -->
                        <div class="absolute top-2 left-2 w-6 h-6 border-t-4 border-l-4 border-cyan-400 rounded-tl-md"></div>
                        <div class="absolute top-2 right-2 w-6 h-6 border-t-4 border-r-4 border-cyan-400 rounded-tr-md"></div>
                        <div class="absolute bottom-2 left-2 w-6 h-6 border-b-4 border-l-4 border-cyan-400 rounded-bl-md"></div>
                        <div class="absolute bottom-2 right-2 w-6 h-6 border-b-4 border-r-4 border-cyan-400 rounded-br-md"></div>
                        
                        <!-- Simulated QR Code Icon -->
                        <span id="viewfinder-qr-icon" class="material-symbols-outlined text-slate-700 text-2xl">qr_code_2</span>

                        <!-- Scanning Green Laser Line Animation -->
                        <div id="laser-line" class="absolute left-0 right-0 h-1 bg-green-400 shadow-[0_0_8px_#4ade80] animate-[laserScan_2s_infinite_linear]"></div>
                    </div>

                    <!-- Viewfinder Scan Button Trigger / Info -->
                    <div class="w-full flex flex-col gap-3">
                        <div id="scanner-info-card" class="bg-slate-950/40 border border-white/5 rounded-2xl p-3 text-center transition-colors duration-300">
                            <span id="scan-status-text" class="text-[9px] text-slate-400 font-bold uppercase tracking-wider">Status Kargo: BELUM DI-SCAN</span>
                            <div id="scan-result-id" class="text-xs font-black text-slate-300 mt-1">Gunakan Tombol Simulasi</div>
                        </div>
                        <button onclick="simulateScanSuccess()" class="w-full py-3.5 rounded-2xl bg-cyan-500 hover:bg-cyan-600 text-slate-950 font-black tracking-wider text-xs shadow-lg uppercase transition-all duration-300 cursor-pointer flex items-center justify-center gap-2">
                            <span class="material-symbols-outlined text-sm font-bold">qr_code_scanner</span>
                            <span>Simulasikan Scan Sukses</span>
                        </button>
                    </div>
                </div>

                <!-- TAB 3: PROFIL KURIR VIEW (Halaman Profil Kurir Editable) -->
                <div id="tab-content-profil" class="hidden flex-1 w-full bg-slate-900 relative z-10 flex flex-col p-6 justify-between overflow-y-auto transition-colors duration-300">
                    <div class="w-full">
                        <!-- Profile Header -->
                        <div class="flex flex-col items-center gap-2 mt-4">
                            <div class="relative">
                                <div class="w-20 h-20 rounded-full bg-cyan-500/20 border-2 border-cyan-500 flex items-center justify-center shadow-lg">
                                    <span class="material-symbols-outlined text-cyan-400 text-2xl">face</span>
                                </div>
                                <div class="absolute bottom-0 right-0 w-6 h-6 rounded-full bg-slate-800 border border-white/20 flex items-center justify-center">
                                    <span class="material-symbols-outlined text-white text-[10px]">edit</span>
                                </div>
                            </div>
                            <h2 id="profile-kurir-title" class="text-sm font-black text-white tracking-wide uppercase mt-1">Ubah Profil Kurir</h2>
                            <span class="text-[8px] text-cyan-400 font-extrabold tracking-widest uppercase">Penyimpanan SharedPreferences</span>
                        </div>

                        <!-- Editable Form -->
                        <div class="flex flex-col gap-4 mt-6">
                            <div class="flex flex-col gap-1.5">
                                <label class="text-[9px] text-slate-400 font-bold uppercase tracking-wider">Nama Lengkap Kurir</label>
                                <input id="profile-name" type="text" class="w-full bg-slate-950/60 border border-white/10 rounded-2xl px-4 py-2.5 text-xs text-white focus:border-cyan-500 focus:outline-none transition-colors duration-300" value="Budi Santoso">
                            </div>
                            <div class="flex flex-col gap-1.5">
                                <label class="text-[9px] text-slate-400 font-bold uppercase tracking-wider">ID Kurir (Nomor Registrasi)</label>
                                <input id="profile-id" type="text" class="w-full bg-slate-950/60 border border-white/10 rounded-2xl px-4 py-2.5 text-xs text-white focus:border-cyan-500 focus:outline-none transition-colors duration-300" value="BG-042">
                            </div>
                            <div class="flex flex-col gap-1.5">
                                <label class="text-[9px] text-slate-400 font-bold uppercase tracking-wider">Nomor Plat Kendaraan</label>
                                <input id="profile-plate" type="text" class="w-full bg-slate-950/60 border border-white/10 rounded-2xl px-4 py-2.5 text-xs text-white focus:border-cyan-500 focus:outline-none transition-colors duration-300" value="BG 1945 PKM">
                            </div>
                        </div>
                    </div>

                    <!-- Save Profile Action -->
                    <div class="w-full mt-6">
                        <button onclick="saveCourierProfile()" class="w-full py-3.5 rounded-2xl bg-cyan-500 hover:bg-cyan-600 text-slate-950 font-black tracking-wider text-xs shadow-lg uppercase transition-all duration-300 cursor-pointer flex items-center justify-center gap-2">
                            <span class="material-symbols-outlined text-sm font-bold">save</span>
                            <span>Simpan Perubahan</span>
                        </button>
                    </div>
                </div>

                <!-- Antigravity Navigation Bottom Bar (Glassmorphism & Floating Nav Bar) -->
                <div id="phone-bottom-nav" class="h-[68px] bg-slate-950/70 backdrop-blur-lg px-4 border-t border-white/10 flex justify-around items-center z-40 relative transition-colors duration-300">
                    <button id="nav-btn-navigasi" onclick="switchMockupTab('navigasi')" class="flex flex-col items-center text-cyan-400 cursor-pointer transition-colors duration-200">
                        <span class="material-symbols-outlined text-lg">explore</span>
                        <span class="text-[8px] font-bold uppercase tracking-wider mt-0.5">Navigasi</span>
                    </button>
                    <button id="nav-btn-scanner" onclick="switchMockupTab('scanner')" class="flex flex-col items-center text-slate-400 hover:text-white cursor-pointer transition-colors duration-200">
                        <span class="material-symbols-outlined text-lg">qr_code_scanner</span>
                        <span class="text-[8px] font-bold uppercase tracking-wider mt-0.5">Scanner</span>
                    </button>
                    <button id="nav-btn-profil" onclick="switchMockupTab('profil')" class="flex flex-col items-center text-slate-400 hover:text-white cursor-pointer transition-colors duration-200">
                        <span class="material-symbols-outlined text-lg">person</span>
                        <span class="text-[8px] font-bold uppercase tracking-wider mt-0.5">Profil</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- RIGHT COLUMN: Simulation Control Panel -->
    <div class="w-full lg:w-1/2 max-w-3xl flex flex-col gap-md">
        <!-- Route / Courier Info Card -->
        <div class="bg-surface-container border border-outline-variant rounded-2xl p-md flex flex-col gap-sm">
            <h3 class="font-headline-sm text-sm uppercase tracking-wider text-primary">Status Perjalanan</h3>
            
            <div class="flex flex-col gap-xs text-xs">
                <div class="flex justify-between py-1 border-b border-outline-variant/60">
                    <span class="text-slate-400">Rute Aktif:</span>
                    <select id="route-selector" class="bg-background text-on-background border border-outline-variant rounded px-1.5 py-0.5 font-mono text-[10px]" onchange="changeRoute(this.value)">
                        @foreach($ruteAktif as $rute)
                            <option value="{{ $rute->id_rute }}" data-box="{{ $rute->id_box }}" data-tujuan="{{ $rute->lokasi_tujuan }}">
                                {{ $rute->id_rute }} - {{ $rute->kurir->nama_lengkap }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="flex justify-between py-1 border-b border-outline-variant/60">
                    <span class="text-slate-400">ID Boks Iot:</span>
                    <span id="ctrl-box-id" class="font-mono text-cyan-500 font-bold">BOX-01</span>
                </div>
                <div class="flex justify-between py-1">
                    <span class="text-slate-400">Tujuan:</span>
                    <span id="ctrl-tujuan" class="font-bold text-white text-right">RSUP Dr. Mohammad Hoesin</span>
                </div>
            </div>
        </div>

        <!-- Temperature Controller Card -->
        <div class="bg-surface-container border border-outline-variant rounded-2xl p-md flex flex-col gap-sm">
            <h3 class="font-headline-sm text-sm uppercase tracking-wider text-primary">Kontrol Suhu Boks</h3>
            
            <!-- Temperature Range Info -->
            <div class="flex justify-between text-[11px] bg-slate-900/50 p-2 rounded-xl border border-outline-variant/30">
                <span class="text-cyan-400">Aman: 2.0Â&deg;C - 8.0Â&deg;C</span>
                <span class="text-amber-500">Warning: 8.1Â&deg;C - 8.5Â&deg;C</span>
                <span class="text-red-500">Kritis: > 8.5Â&deg;C</span>
            </div>

            <!-- Temperature Slider -->
            <div class="flex flex-col gap-xs mt-2">
                <div class="flex justify-between items-baseline">
                    <span class="text-xs text-slate-400">Atur Suhu Aktual:</span>
                    <span id="slider-val" class="text-xl font-black text-cyan-400">4.5Â&deg;C</span>
                </div>
                <input id="temp-slider" type="range" min="0.0" max="15.0" step="0.1" value="4.5" class="w-full h-1.5 bg-slate-800 rounded-lg appearance-none cursor-pointer accent-cyan-500" oninput="updateTempFromSlider(this.value)">
            </div>

            <!-- Preset Buttons -->
            <div class="grid grid-cols-2 gap-2 mt-2">
                <button onclick="setTempPreset(4.5)" class="py-2 rounded-xl bg-cyan-500/10 border border-cyan-500/30 hover:bg-cyan-500/20 text-cyan-400 text-xs font-bold transition-all cursor-pointer">
                    Suhu Aman (4.5Â&deg;C)
                </button>
                <button onclick="setTempPreset(8.3)" class="py-2 rounded-xl bg-amber-500/10 border border-amber-500/30 hover:bg-amber-500/20 text-amber-400 text-xs font-bold transition-all cursor-pointer">
                    Warning (8.3Â&deg;C)
                </button>
                <button onclick="setTempPreset(9.5)" class="py-2 rounded-xl bg-red-500/10 border border-red-500/30 hover:bg-red-500/20 text-red-400 text-xs font-bold transition-all cursor-pointer">
                    Kritis (9.5Â&deg;C)
                </button>
                <button onclick="setTempPreset(1.5)" class="py-2 rounded-xl bg-sky-500/10 border border-sky-500/30 hover:bg-sky-500/20 text-sky-400 text-xs font-bold transition-all cursor-pointer">
                    Beku (1.5Â&deg;C)
                </button>
            </div>
        </div>

        <!-- Shock/Vibration Simulator Control Card -->
        <div class="bg-surface-container border border-outline-variant rounded-2xl p-md flex flex-col gap-sm">
            <div class="flex justify-between items-center">
                <h3 class="font-headline-sm text-sm uppercase tracking-wider text-primary">Simulasi Guncangan Boks</h3>
                <span id="vibration-badge" class="px-2.5 py-0.5 rounded bg-cyan-500/10 text-cyan-400 border border-cyan-500/30 text-[10px] font-mono font-bold">0,05G</span>
            </div>
            
            <div class="grid grid-cols-2 gap-2 mt-2">
                <button onclick="setVibrationPreset(0.05)" class="py-2 rounded-xl bg-cyan-500/10 border border-cyan-500/30 hover:bg-cyan-500/20 text-cyan-400 text-xs font-bold transition-all cursor-pointer">
                    Normal (0.05G)
                </button>
                <button onclick="triggerVibrationSpike()" class="py-2 rounded-xl bg-rose-500/10 border border-rose-500/30 hover:bg-rose-500/20 text-rose-450 text-xs font-bold transition-all cursor-pointer animate-pulse">
                    Guncangan (2.5G)
                </button>
            </div>
        </div>

        <!-- GPS Simulator Control Card -->
        <div class="bg-surface-container border border-outline-variant rounded-2xl p-md flex flex-col gap-sm">
            <h3 class="font-headline-sm text-sm uppercase tracking-wider text-primary">Simulasi GPS & Rute</h3>
            
            <div class="flex flex-col gap-xs text-xs">
                <div class="flex justify-between py-1">
                    <span class="text-slate-400">Koordinat Saat Ini:</span>
                    <span id="gps-coords-display" class="font-mono text-slate-300">-2.973305, 104.755490</span>
                </div>
                <div class="flex justify-between py-1">
                    <span class="text-slate-400">Progres Rute:</span>
                    <span id="route-progress" class="font-bold text-white">0% (Dinas Kesehatan)</span>
                </div>
            </div>

            <!-- Action buttons -->
            <div class="flex gap-2 mt-2">
                <button id="btn-play-pause" onclick="toggleRouteSimulation()" class="flex-1 py-2.5 rounded-xl bg-primary text-white text-xs font-bold hover:bg-primary-container transition-all flex items-center justify-center gap-1 cursor-pointer">
                    <span class="material-symbols-outlined text-sm">play_arrow</span>
                    <span>Mulai Berjalan</span>
                </button>
                <button onclick="resetGpsPosition()" class="py-2.5 px-3 rounded-xl bg-slate-800 border border-outline-variant/60 hover:bg-slate-700 text-slate-300 text-xs font-bold transition-all flex items-center justify-center cursor-pointer">
                    <span class="material-symbols-outlined text-sm">replay</span>
                </button>
            </div>
        </div>

        <!-- Internet Connection Emulator Card -->
        <div class="bg-surface-container border border-outline-variant rounded-2xl p-md flex flex-col gap-sm">
            <div class="flex justify-between items-center">
                <h3 class="font-headline-sm text-sm uppercase tracking-wider text-primary">Koneksi Internet</h3>
                <span id="network-status-badge" class="px-2 py-0.5 rounded-full bg-green-500/10 text-green-400 border border-green-500/20 text-[9px] font-extrabold uppercase">ONLINE</span>
            </div>
            
            <div class="flex flex-col gap-xs text-xs">
                <div class="flex justify-between py-1">
                    <span class="text-slate-400">Offline Buffer Cache:</span>
                    <span id="offline-cache-count" class="font-bold text-slate-300">0 logs cached</span>
                </div>
            </div>

            <!-- Action buttons -->
            <div class="grid grid-cols-2 gap-2 mt-2">
                <button id="btn-net-online" onclick="setNetworkStatus(true)" class="py-2 rounded-xl bg-primary text-white text-xs font-bold transition-all cursor-pointer flex items-center justify-center gap-1 border border-primary">
                    <span class="material-symbols-outlined text-xs">wifi</span> Connect
                </button>
                <button id="btn-net-offline" onclick="setNetworkStatus(false)" class="py-2 rounded-xl bg-slate-800 border border-outline-variant/65 hover:bg-slate-700 text-slate-300 text-xs font-bold transition-all cursor-pointer flex items-center justify-center gap-1">
                    <span class="material-symbols-outlined text-xs">wifi_off</span> Disconnect
                </button>
            </div>
        </div>

        <!-- Sync Logger Monitor -->
        <div class="flex-1 bg-surface-container border border-outline-variant rounded-2xl p-md flex flex-col gap-sm min-h-[160px]">
            <div class="flex justify-between items-center">
                <h3 class="font-headline-sm text-sm uppercase tracking-wider text-primary font-bold">Sync Log API (Live)</h3>
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
            </div>
            
            <div id="sync-console" class="flex-1 bg-slate-950 rounded-xl p-3 font-mono text-[9px] text-emerald-400 overflow-y-auto leading-normal flex flex-col gap-1 border border-outline-variant/30 max-h-[220px]">
                <div class="text-slate-500">// Simulasi diinisialisasi...</div>
                <div class="text-slate-500">// Menunggu sinkronisasi telemetri...</div>
            </div>
        </div>
    </div>
</div>

<!-- Custom Keyframes Style for Viewfinder laser line animation -->
<style>
    @keyframes laserScan {
        0% { top: 0%; }
        50% { top: 100%; }
        100% { top: 0%; }
    }
    
    @keyframes slideUp {
        from { transform: translateY(100px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }

    /* Light Theme Styling for mockup screen */
    .mockup-light-theme {
        background-color: #F9FAFB !important; /* Grey 50 */
        color: #0F172A !important; /* text slate 900 */
    }
    .mockup-light-theme #phone-status-bar {
        background-color: #F3F4F6 !important; /* grey 100 */
        color: #1F2937 !important;
    }
    .mockup-light-theme #phone-bottom-nav {
        background-color: rgba(243, 244, 246, 0.8) !important;
        border-top-color: rgba(0, 0, 0, 0.08) !important;
    }
    .mockup-light-theme #telemetry-float-card,
    .mockup-light-theme #floated-brand-card,
    .mockup-light-theme #sos-modal {
        background-color: rgba(255, 255, 255, 0.85) !important;
        color: #0F172A !important;
        border-color: rgba(0, 0, 0, 0.08) !important;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1) !important;
    }
    .mockup-light-theme #brand-title,
    .mockup-light-theme #profile-kurir-title {
        color: #0F172A !important;
    }
    .mockup-light-theme #profile-name,
    .mockup-light-theme #profile-id,
    .mockup-light-theme #profile-plate {
        background-color: rgba(255, 255, 255, 0.8) !important;
        border-color: rgba(0, 0, 0, 0.15) !important;
        color: #0F172A !important;
    }
    .mockup-light-theme #scanner-title,
    .mockup-light-theme #scanner-info-card {
        color: #0F172A !important;
        border-color: rgba(0, 0, 0, 0.08) !important;
    }
    .mockup-light-theme #scan-result-id {
        color: #1F2937 !important;
    }
    .mockup-light-theme #viewfinder-qr-icon {
        color: #D1D5DB !important;
    }
</style>
@endsection

@push('scripts')
<script>
    // Status awal jam HP
    function updateClock() {
        const now = new Date();
        const hrs = String(now.getHours()).padStart(2, '0');
        const mins = String(now.getMinutes()).padStart(2, '0');
        document.getElementById('phone-clock').textContent = `${hrs}:${mins}`;
    }
    setInterval(updateClock, 1000);
    updateClock();

    // Planned Reference Routes (Palembang)
    const routePaths = {
        'RSUP Dr. Mohammad Hoesin': [
            [-2.9880, 104.7560], // Dinas Kesehatan Palembang
            [-2.9887, 104.7565], // Air Mancur Masjid Agung Roundabout
            [-2.9868, 104.7561], // Sudirman St near IP
            [-2.9829, 104.7552], // Sudirman St near Pasar Cinde
            [-2.9803, 104.7547], // Sudirman St near Marathon
            [-2.9774, 104.7540], // Sudirman St / Kapten A Rivai intersection (Charitas)
            [-2.9748, 104.7533], // Sudirman St near Kodam II Sriwijaya
            [-2.9723, 104.7528], // Sudirman St SMA 3
            [-2.9702, 104.7521], // Sudirman St / Veteran intersection
            [-2.9669, 104.7505]  // RSUP Dr. Mohammad Hoesin
        ],
        'RSUD Palembang BARI': [
            [-2.9880, 104.7560], // Dinas Kesehatan Palembang
            [-2.9887, 104.7565], // Air Mancur Masjid Agung
            [-2.9912, 104.7592], // Jembatan Ampera (North Approach)
            [-2.9935, 104.7618], // Jembatan Ampera (Center Span)
            [-2.9961, 104.7628], // Jembatan Ampera (South Approach)
            [-2.9995, 104.7635], // Jl. Ryacudu
            [-3.0068, 104.7625], // Simpang Bastari
            [-3.0125, 104.7615], // Jl. Gubernur Bastari near Lippo
            [-3.0142, 104.7585], // Jl. Panca Usaha entrance
            [-3.0185, 104.7645]  // RSUD Palembang BARI
        ],
        'RS Charitas': [
            [-2.9880, 104.7560], // Dinas Kesehatan Palembang
            [-2.9887, 104.7565], // Air Mancur Masjid Agung
            [-2.9868, 104.7561], // Sudirman St near IP
            [-2.9829, 104.7552], // Sudirman St near Pasar Cinde
            [-2.9803, 104.7547], // Sudirman St near Marathon
            [-2.9772, 104.7522]  // RS Charitas
        ],
        'Puskesmas Dempo': [
            [-2.9880, 104.7560], // Dinas Kesehatan Palembang
            [-2.9887, 104.7565], // Air Mancur Masjid Agung
            [-2.9868, 104.7561], // Sudirman St near IP
            [-2.9865, 104.7630]  // Puskesmas Dempo
        ]
    };

    let routeCoords = routePaths['RSUP Dr. Mohammad Hoesin'];

    // Active Reroutes state initialized from DB
    const activeReroutes = {
        @foreach($ruteAktif as $rute)
            '{{ $rute->id_rute }}': {{ $rute->isRerouted() ? 'true' : 'false' }},
        @endforeach
    };

    // Alternative Optimized Routes
    const alternativePaths = {
        'RSUD Palembang BARI': [
            [-2.9880, 104.7560], // Dinas Kesehatan Palembang
            [-2.9887, 104.7565], // Air Mancur Masjid Agung
            [-2.9860, 104.7620], // Jl. Veteran
            [-2.9875, 104.7680], // Jl. Slamet Riyadi
            [-2.9920, 104.7695], // Jembatan Musi IV
            [-2.9985, 104.7700], // Jl. KH Azhari
            [-3.0070, 104.7670], // Jl. Gubernur Bastari approach
            [-3.0185, 104.7645]  // RSUD Palembang BARI
        ],
        'RSUP Dr. Mohammad Hoesin': [
            [-2.9880, 104.7560], // Dinas Kesehatan Palembang
            [-2.9887, 104.7565], // Air Mancur Masjid Agung
            [-2.9855, 104.7615], // Jl. Veteran
            [-2.9780, 104.7650], // Simpang Veteran/Rajawali
            [-2.9710, 104.7610], // Jl. Mayor Ruslan
            [-2.9702, 104.7521], // Simpang Sekip
            [-2.9669, 104.7505]  // RSUP Dr. Mohammad Hoesin
        ]
    };

    let currentStep = 0;
    let isMoving = false;
    let moveInterval = null;

    // Data Telemetri & Logic Timer
    let currentTemp = 4.5;
    let mktTemp = 4.8;
    let vibrationLevel = 0.05;
    let anomalyTimer = null;
    let anomalySeconds = 30;
    let isWarning = false;
    let isCritical = false;

    class HospitalAlarm {
        constructor() {
            this.ctx = null;
            this.isPlaying = false;
            this.interval = null;
        }
        play() {
            if (!this.ctx) this.ctx = new (window.AudioContext || window.webkitAudioContext)();
            this.isPlaying = true;
            if(this.ctx.state === 'suspended') this.ctx.resume();
            this.beepSequence();
            this.interval = setInterval(() => {
                if (this.isPlaying) this.beepSequence();
            }, 2000);
        }
        stop() {
            this.isPlaying = false;
            if(this.interval) clearInterval(this.interval);
        }
        beepSequence() {
            if(!this.ctx) return;
            const time = this.ctx.currentTime;
            [0, 0.15, 0.3, 0.7, 0.85].forEach((offset) => {
                this.beep(time + offset);
            });
        }
        beep(time) {
            const osc = this.ctx.createOscillator();
            const gain = this.ctx.createGain();
            osc.type = 'sine';
            osc.frequency.value = 900;
            osc.connect(gain);
            gain.connect(this.ctx.destination);
            gain.gain.setValueAtTime(0, time);
            gain.gain.linearRampToValueAtTime(1, time + 0.02);
            gain.gain.setValueAtTime(1, time + 0.08);
            gain.gain.linearRampToValueAtTime(0, time + 0.1);
            osc.start(time);
            osc.stop(time + 0.1);
        }
    }
    let criticalAlarmAudio = new HospitalAlarm();

    // Database state
    let activeRouteId = '';
    let activeBoxId = '';
    let activeDestination = '';
    
    // Cargo Scanning State
    let isCargoScanned = false;

    // Network Emulation state (Offline buffering)
    let isNetworkOnline = true;
    let offlineBuffer = [];

    // Initialize Leaflet Map
    let map;
    let courierMarker;
    let routePolyline;
    let destMarker;

    // Mockup Dark/Light Theme state
    let isMockupDark = true;

    document.addEventListener("DOMContentLoaded", function() {
        // Load data kurir dari localstorage jika ada
        loadCourierDataFromStorage();

        // Dropdown setup awal
        const selector = document.getElementById('route-selector');
        changeRoute(selector.value);

        // Center map di titik awal
        map = L.map('sim-map', {
            zoomControl: false,
            attributionControl: false
        }).setView(routeCoords[0], 15);

        // Custom Dark / Light tile based on theme
        const isDark = document.documentElement.classList.contains('dark');
        const tileUrl = isDark 
            ? 'https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png'
            : 'https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png';

        L.tileLayer(tileUrl, {
            maxZoom: 19
        }).addTo(map);

        // Tambah marker tujuan (RSUP Dr. Mohammad Hoesin)
        const hospitalIcon = L.divIcon({
            html: `<div class="w-8 h-8 rounded-full bg-cyan-900/80 border border-cyan-400 flex items-center justify-center text-cyan-400 shadow-[0_0_12px_rgba(6,182,212,0.4)]">
                     <span class="material-symbols-outlined text-sm">local_hospital</span>
                   </div>`,
            className: 'custom-div-icon',
            iconSize: [32, 32],
            iconAnchor: [16, 16]
        });

        destMarker = L.marker(routeCoords[routeCoords.length - 1], { icon: hospitalIcon }).addTo(map);

        // Tambah marker kurir
        const courierIcon = L.divIcon({
            html: `<div id="map-courier-icon" class="w-8 h-8 rounded-full bg-red-500 border-2 border-white flex items-center justify-center text-white shadow-lg animate-pulse">
                     <span class="material-symbols-outlined text-sm">local_shipping</span>
                   </div>`,
            className: 'custom-div-icon',
            iconSize: [32, 32],
            iconAnchor: [16, 16]
        });

        courierMarker = L.marker(routeCoords[0], { icon: courierIcon }).addTo(map);

        // Gambar garis rute Polyline Tebal Cyan
        routePolyline = L.polyline(routeCoords, {
            color: '#06b6d4', // Cyan Cerah
            weight: 5,        // Tebal
            opacity: 0.85
        }).addTo(map);

        // Listen theme change event to update map styles
        window.addEventListener('theme-changed', function(e) {
            const isDark = e.detail.theme === 'dark';
            const newTileUrl = isDark 
                ? 'https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png'
                : 'https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png';
            
            map.eachLayer(function(layer) {
                if (layer instanceof L.TileLayer) {
                    map.removeLayer(layer);
                }
            });
            L.tileLayer(newTileUrl, { maxZoom: 19 }).addTo(map);
        });

        // Loop Sinkronisasi berkala (Hanya jika Kargo/BLE Aktif)
        setInterval(syncTelemetryWithServer, 5000);

        // Auto-scan cargo on initialization for seamless experience
        setTimeout(simulateScanSuccess, 800);
    });

    // Handle Route Selection
    function changeRoute(routeId) {
        activeRouteId = routeId;
        const selector = document.getElementById('route-selector');
        const selectedOption = selector.options[selector.selectedIndex];
        
        activeBoxId = selectedOption.getAttribute('data-box');
        activeDestination = selectedOption.getAttribute('data-tujuan');

        document.getElementById('ctrl-box-id').textContent = activeBoxId;
        document.getElementById('ctrl-tujuan').textContent = activeDestination;

        // Dynamic badge indicator
        const destAbbr = activeDestination.includes('Mohammad Hoesin') ? 'RSMH' :
                         (activeDestination.includes('BARI') ? 'RSUD BARI' :
                         (activeDestination.includes('Charitas') ? 'CHARITAS' : 'DEMPO'));
        document.getElementById('route-indicator-badge').textContent = `DINKES Ã¢â€ â€™ ${destAbbr}`;

        // Swap coordinates
        const isRerouted = activeReroutes[activeRouteId];
        routeCoords = isRerouted && alternativePaths[activeDestination]
            ? alternativePaths[activeDestination]
            : (routePaths[activeDestination] || routePaths['RSUP Dr. Mohammad Hoesin']);
        currentStep = 0;

        // Update map features if initialized
        if (map && routePolyline && courierMarker && destMarker) {
            routePolyline.setLatLngs(routeCoords);
            courierMarker.setLatLng(routeCoords[0]);
            destMarker.setLatLng(routeCoords[routeCoords.length - 1]);
            
            // Adjust markers custom popups or content if needed
            destMarker.bindPopup(`<div class='text-xs font-bold text-slate-800  py-0.5'>${activeDestination} (Tujuan)</div>`, { closeButton: false });
            
            // Refit map view
            map.setView(routeCoords[0], 15);
        }

        if (isCargoScanned) {
            // Update scanned info dynamically
            document.getElementById('scan-result-id').textContent = `Kargo #${activeBoxId} Terverifikasi`;
        }

        logConsole(`Rute aktif diubah ke: ${activeRouteId} (${activeDestination})`);
    }

    // Tab Switching Logic inside Phone mockup
    function switchMockupTab(tabId) {
        // Hide all contents
        document.getElementById('tab-content-navigasi').classList.add('hidden');
        document.getElementById('tab-content-scanner').classList.add('hidden');
        document.getElementById('tab-content-profil').classList.add('hidden');

        // Reset nav button text colors
        document.getElementById('nav-btn-navigasi').className = 'flex flex-col items-center text-slate-400 hover:text-white cursor-pointer';
        document.getElementById('nav-btn-scanner').className = 'flex flex-col items-center text-slate-400 hover:text-white cursor-pointer';
        document.getElementById('nav-btn-profil').className = 'flex flex-col items-center text-slate-400 hover:text-white cursor-pointer';

        // Show selected content
        document.getElementById(`tab-content-${tabId}`).classList.remove('hidden');

        // Style active button
        const activeBtn = document.getElementById(`nav-btn-${tabId}`);
        if (isMockupDark) {
            activeBtn.className = 'flex flex-col items-center text-cyan-400 cursor-pointer';
        } else {
            activeBtn.className = 'flex flex-col items-center text-cyan-600 cursor-pointer';
        }

        logConsole(`Buka tab mockup: ${tabId.toUpperCase()}`);
    }

    // Toggle Mockup Light / Dark Theme (Fitur Mode Terang)
    function toggleMockupTheme() {
        const phoneScreen = document.getElementById('phone-screen');
        const iconEl = document.getElementById('mockup-theme-icon');
        isMockupDark = !isMockupDark;

        if (isMockupDark) {
            phoneScreen.classList.remove('mockup-light-theme');
            iconEl.textContent = 'light_mode';
            logConsole("Ubah tema mockup: DARK MODE");
        } else {
            phoneScreen.classList.add('mockup-light-theme');
            iconEl.textContent = 'dark_mode';
            logConsole("Ubah tema mockup: LIGHT MODE (Colors.grey[50])");
        }

        // Re-apply active tab button colors
        const activeTab = document.querySelector('[id^="tab-content-"]:not(.hidden)').id.replace('tab-content-', '');
        switchMockupTab(activeTab);
    }

    // Fitur Scanner Barcode Kargo
    function simulateScanSuccess() {
        isCargoScanned = true;
        
        // Update status di UI Scanner
        document.getElementById('scan-status-text').textContent = 'Status Kargo: TERVERIFIKASI Ã¢Å“â€œ';
        document.getElementById('scan-status-text').className = 'text-[9px] text-green-400 font-extrabold uppercase tracking-wider';
        document.getElementById('scan-result-id').textContent = `Kargo #${activeBoxId} Terverifikasi`;
        document.getElementById('scan-result-id').className = 'text-xs font-black text-green-400 mt-1';

        // Update status BLE badge di Header mockup HP
        const bleBadge = document.getElementById('ble-badge');
        bleBadge.textContent = 'BLE: CONNECTED';
        bleBadge.className = 'px-1.5 py-0.5 rounded-sm bg-cyan-500/20 text-cyan-400 border border-cyan-500/30 animate-pulse text-[8px] font-extrabold uppercase';

        // Ganti marker kurir di peta menjadi warna Cyan
        const mapCourier = document.getElementById('map-courier-icon');
        if (mapCourier) {
            mapCourier.className = mapCourier.className.replace('bg-red-500', 'bg-cyan-500 animate-bio-pulse');
        }

        // Jalankan evaluasi awal
        evaluateTemperatureConstraints();

        // Tampilkan SnackBar sukses di web admin (Non-blocking log console)
        logConsole(`Kargo #${activeBoxId} Terverifikasi Sukses! BLE Terhubung.`, 'success');
        
        // Kembalikan ke tab navigasi peta
        setTimeout(() => {
            switchMockupTab('navigasi');
        }, 1200);
    }

    // Halaman Profil Kurir (Save / Load SharedPreferences)
    function saveCourierProfile() {
        const name = document.getElementById('profile-name').value;
        const id = document.getElementById('profile-id').value;
        const plate = document.getElementById('profile-plate').value;

        // Simpan data di localstorage browser (sebagai ganti SharedPreferences lokal)
        localStorage.setItem('courier_name', name);
        localStorage.setItem('courier_id', id);
        localStorage.setItem('courier_plate', plate);

        // Update display data dropdown / log
        logConsole(`[Profil Disimpan] Nama: ${name}, Plat: ${plate}`, 'success');
        alert('Profil kurir berhasil diperbarui dan disimpan!');

        // Kembalikan ke tab navigasi
        switchMockupTab('navigasi');
    }

    function loadCourierDataFromStorage() {
        const name = localStorage.getItem('courier_name') || 'Budi Santoso';
        const id = localStorage.getItem('courier_id') || 'BG-042';
        const plate = localStorage.getItem('courier_plate') || 'BG 1945 PKM';

        document.getElementById('profile-name').value = name;
        document.getElementById('profile-id').value = id;
        document.getElementById('profile-plate').value = plate;
    }

    // Live Logger Console
    function logConsole(msg, type = 'info') {
        const consoleEl = document.getElementById('sync-console');
        const now = new Date();
        const timeStr = now.toTimeString().split(' ')[0];
        
        let colorClass = 'text-slate-400';
        if (type === 'success') colorClass = 'text-emerald-400 font-bold';
        if (type === 'warning') colorClass = 'text-amber-500 font-bold';
        if (type === 'danger') colorClass = 'text-red-500 font-bold';

        const line = document.createElement('div');
        line.innerHTML = `<span class="text-slate-600">[${timeStr}]</span> <span class="${colorClass}">${msg}</span>`;
        consoleEl.appendChild(line);
        consoleEl.scrollTop = consoleEl.scrollHeight;
    }

    // Kontrol Suhu dari Slider & Preset (Core PKM Logic)
    function updateTempFromSlider(val) {
        currentTemp = parseFloat(val);
        mktTemp = parseFloat((currentTemp * 1.05 + 0.1).toFixed(1));
        
        document.getElementById('slider-val').textContent = `${currentTemp.toFixed(1)}Â&deg;C`;
        document.getElementById('float-temp').textContent = `${currentTemp.toFixed(1)}Â&deg;C`;
        document.getElementById('float-mkt').textContent = `${mktTemp.toFixed(1)}Â&deg;C`;

        evaluateTemperatureConstraints();
    }

    function setTempPreset(val) {
        document.getElementById('temp-slider').value = val;
        updateTempFromSlider(val);
    }

    // Kontrol Getaran/Vibrasi (PKM Lanjutan)
    function setVibrationPreset(val) {
        vibrationLevel = parseFloat(val);
        document.getElementById('vibration-badge').textContent = `${vibrationLevel.toFixed(2).replace('.', ',')}G`;
        logConsole(`Getaran disetel ke level normal: ${vibrationLevel}G`, 'info');
    }

    function triggerVibrationSpike() {
        vibrationLevel = parseFloat((1.5 + Math.random() * 1.2).toFixed(2));
        document.getElementById('vibration-badge').textContent = `${vibrationLevel.toFixed(2).replace('.', ',')}G`;
        logConsole(`Simulasi GUNCANGAN EKSTREM terdeteksi: ${vibrationLevel}G!`, 'danger');
        
        // Haptic feedback if supported
        if (navigator.vibrate) {
            navigator.vibrate([200, 100, 200]);
        }
        
        // Visual shake feedback on smartphone screen mockup
        const screenMockup = document.querySelector('.w-72.h-\\[570px\\]');
        if (screenMockup) {
            screenMockup.classList.add('animate-shake');
            setTimeout(() => {
                screenMockup.classList.remove('animate-shake');
            }, 600);
        }

        // Trigger telemetry sync immediately to capture vibration shock
        syncTelemetryWithServer();
    }

    // Core Logic Evaluasi Suhu (PKM)
    function evaluateTemperatureConstraints() {
        if (!isCargoScanned) return; // Hanya mengevaluasi jika kargo sudah dipasang

        const floatCard = document.getElementById('telemetry-float-card');
        const tempText = document.getElementById('float-temp');
        const viabilityBadge = document.getElementById('viability-badge');
        const timerBox = document.getElementById('timer-box');
        const mapCourier = document.getElementById('map-courier-icon');

        // Reset styling awal
        floatCard.className = floatCard.className.replace(/border-(cyan|amber|red)-500/g, '').trim();
        tempText.className = tempText.className.replace(/text-(cyan|amber|red)-400/g, '').trim();
        viabilityBadge.className = viabilityBadge.className.replace(/(bg|text|border)-(cyan|amber|red)-500.*/g, '').trim();
        
        if (mapCourier) {
            mapCourier.className = mapCourier.className.replace(/(bg|animate)-(cyan|amber|red|bio-pulse).*/g, '').trim();
            mapCourier.classList.add('border-2', 'border-white', 'flex', 'items-center', 'justify-center', 'text-white', 'shadow-lg');
        }

        // Batas instan kritis (> 8.5Â&deg;C atau < 2.0Â&deg;C)
        if (currentTemp > 8.5 || currentTemp < 2.0) {
            triggerCriticalAlert();
            return;
        }

        // Batas fluktuasi / warning (8.1Â&deg;C s.d. 8.5Â&deg;C)
        if (currentTemp > 8.0 && currentTemp <= 8.5) {
            isWarning = true;
            isCritical = false;

            floatCard.classList.add('border-amber-500');
            tempText.classList.add('text-amber-400');
            viabilityBadge.classList.add('bg-amber-500/10', 'text-amber-400', 'border', 'border-amber-500/20');
            viabilityBadge.textContent = 'PERINGATAN';
            timerBox.classList.remove('hidden');

            if (mapCourier) {
                mapCourier.classList.add('bg-amber-500', 'animate-pulse');
            }

            if (!anomalyTimer) {
                anomalySeconds = 30;
                document.getElementById('countdown-display').textContent = `${anomalySeconds}s`;
                logConsole(`Peringatan: Suhu naik menjadi ${currentTemp}Â&deg;C. Memulai timer toleransi 30 detik!`, 'warning');
                
                anomalyTimer = setInterval(function() {
                    if (anomalySeconds > 0) {
                        anomalySeconds--;
                        document.getElementById('countdown-display').textContent = `${anomalySeconds}s`;
                        
                        if (anomalySeconds % 2 === 0 && navigator.vibrate) {
                            navigator.vibrate(200);
                        }
                    } else {
                        clearInterval(anomalyTimer);
                        anomalyTimer = null;
                        triggerCriticalAlert();
                    }
                }, 1000);
            }
        } else {
            // Suhu AMAN (2Â&deg;C s.d. 8Â&deg;C)
            isWarning = false;
            isCritical = false;
            
            if (anomalyTimer) {
                clearInterval(anomalyTimer);
                anomalyTimer = null;
                logConsole(`Suhu kembali stabil ke ${currentTemp}Â&deg;C. Timer toleransi di-reset.`, 'success');
            }

            floatCard.classList.add('border-cyan-500');
            tempText.classList.add('text-cyan-400');
            viabilityBadge.classList.add('bg-cyan-500/10', 'text-cyan-400', 'border', 'border-cyan-500/20');
            viabilityBadge.textContent = 'AMAN';
            timerBox.classList.add('hidden');

            if (mapCourier) {
                mapCourier.classList.add('bg-cyan-500', 'animate-bio-pulse');
            }
        }
    }

    // Pemicu Layar Merah Kritis Penuh (Core PKM)
    function triggerCriticalAlert() {
        isCritical = true;
        isWarning = false;
        
        if (anomalyTimer) {
            clearInterval(anomalyTimer);
            anomalyTimer = null;
        }

        const floatCard = document.getElementById('telemetry-float-card');
        const tempText = document.getElementById('float-temp');
        const viabilityBadge = document.getElementById('viability-badge');
        const timerBox = document.getElementById('timer-box');
        const mapCourier = document.getElementById('map-courier-icon');

        floatCard.className = floatCard.className.replace(/border-(cyan|amber|red)-500/g, '').trim();
        tempText.className = tempText.className.replace(/text-(cyan|amber|red)-400/g, '').trim();
        viabilityBadge.className = viabilityBadge.className.replace(/(bg|text|border)-(cyan|amber|red)-500.*/g, '').trim();

        floatCard.classList.add('border-red-500');
        tempText.classList.add('text-red-400');
        viabilityBadge.classList.add('bg-red-500/10', 'text-red-400', 'border', 'border-red-500/20');
        viabilityBadge.textContent = 'RUSAK';
        timerBox.classList.add('hidden');

        if (mapCourier) {
            mapCourier.className = mapCourier.className.replace(/(bg|animate)-(cyan|amber|red|bio-pulse).*/g, '').trim();
            mapCourier.classList.add('bg-red-600', 'animate-ping');
        }

        // Tampilkan layar merah penuh di mockup HP
        const overlay = document.getElementById('critical-overlay');
        const title = document.getElementById('critical-title');
        const sub = document.getElementById('critical-sub');
        const img = document.getElementById('critical-penguin-img');
        const imgContainer = document.getElementById('critical-img-container');
        const infoBox = document.getElementById('critical-info-box');
        const tempLabel = document.getElementById('critical-temp-label');
        const resetBtn = document.getElementById('critical-reset-btn');

        // Reset theme classes
        overlay.className = overlay.className.replace(/(bg-cyan-950|bg-red-950)/g, '').trim();
        imgContainer.className = imgContainer.className.replace(/(drop-shadow-\[0_0_15px_rgba\(6,182,212,0\.8\)\]|drop-shadow-\[0_0_15px_rgba\(239,68,68,0\.8\)\])/g, '').trim();
        sub.className = sub.className.replace(/(text-cyan-400|text-red-400)/g, '').trim();
        infoBox.className = infoBox.className.replace(/(bg-cyan-900|bg-red-900|border-cyan-500|border-red-500)/g, '').trim();
        tempLabel.className = tempLabel.className.replace(/(text-cyan-300|text-red-300)/g, '').trim();
        resetBtn.className = resetBtn.className.replace(/(text-cyan-950|text-red-950)/g, '').trim();

        if (currentTemp < 2.0) {
            // BEKU
            title.textContent = 'CRITICAL ALERT: BEKU!';
            title.className = 'text-xl font-black text-cyan-100 tracking-wider uppercase leading-tight mb-2 drop-shadow-[0_0_10px_rgba(6,182,212,0.8)]';
            sub.textContent = 'SUHU TERLALU DINGIN - VAKSIN TERANCAM BEKU!';
            sub.classList.add('text-cyan-400');
            img.src = "{{ asset('images/penguin_cold.png') }}";
            img.className = 'w-full h-full object-contain filter drop-shadow-[0_0_15px_rgba(6,182,212,0.8)]';
            overlay.classList.add('bg-cyan-950/95');
            infoBox.classList.add('bg-cyan-900/30', 'border-cyan-500/40');
            tempLabel.classList.add('text-cyan-300');
            resetBtn.classList.add('text-cyan-950');
        } else {
            // PANAS
            title.textContent = 'CRITICAL ALERT: PANAS!';
            title.className = 'text-xl font-black text-white tracking-wider uppercase leading-tight mb-2 drop-shadow-[0_0_10px_rgba(239,68,68,0.8)]';
            sub.textContent = 'EKSKURSI SUHU - KARANTINA KARGO SEKARANG!';
            sub.classList.add('text-red-400');
            img.src = "{{ asset('images/penguin_hot.png') }}";
            img.className = 'w-full h-full object-contain filter drop-shadow-[0_0_15px_rgba(239,68,68,0.8)]';
            overlay.classList.add('bg-red-950/95');
            infoBox.classList.add('bg-red-900/30', 'border-red-500/40');
            tempLabel.classList.add('text-red-300');
            resetBtn.classList.add('text-red-950');
        }

        document.getElementById('overlay-temp-display').textContent = `${currentTemp.toFixed(1)}Â&deg;C`;
        overlay.classList.remove('hidden');
        
        // Mainkan alarm audio keras (Siren Medis)
        try { criticalAlarmAudio.play(); } catch(e) { console.warn('Audio play failed:', e); }

        // Mainkan getar
        if (navigator.vibrate) {
            navigator.vibrate([800, 400, 800, 400, 800]);
        }

        logConsole(`BAHAYA: Vaksin dinyatakan RUSAK akibat ekskursi suhu berkelanjutan! (${currentTemp}Â&deg;C)`, 'danger');
    }

    // Reset Simulasi
    function resetSimulation() {
        document.getElementById('critical-overlay').classList.add('hidden');
        criticalAlarmAudio.stop();
        setTempPreset(4.5);
        logConsole(`Simulasi status kelayakan di-reset ke kondisi normal.`, 'info');
    }

    // GPS & Route Movement Simulation
    function toggleRouteSimulation() {
        const btn = document.getElementById('btn-play-pause');
        
        if (isMoving) {
            isMoving = false;
            clearInterval(moveInterval);
            moveInterval = null;
            btn.innerHTML = `<span class="material-symbols-outlined text-sm">play_arrow</span><span>Mulai Berjalan</span>`;
            btn.className = btn.className.replace('bg-amber-600 hover:bg-amber-500', 'bg-primary hover:bg-primary-container');
            logConsole(`Pergerakan kurir di-pause pada koordinat: ${routeCoords[currentStep].join(', ')}`);
        } else {
            isMoving = true;
            btn.innerHTML = `<span class="material-symbols-outlined text-sm">pause</span><span>Pause Perjalanan</span>`;
            btn.className = btn.className.replace('bg-primary hover:bg-primary-container', 'bg-amber-600 hover:bg-amber-500');
            logConsole(`Memulai simulasi pergerakan kurir menuju ${activeDestination}...`);

            moveInterval = setInterval(function() {
                if (currentStep < routeCoords.length - 1) {
                    currentStep++;
                    updateCourierPosition(currentStep);
                } else {
                    isMoving = false;
                    clearInterval(moveInterval);
                    moveInterval = null;
                    btn.innerHTML = `<span class="material-symbols-outlined text-sm">play_arrow</span><span>Mulai Berjalan</span>`;
                    btn.className = btn.className.replace('bg-amber-600 hover:bg-amber-500', 'bg-primary hover:bg-primary-container');
                    logConsole(`Kurir telah sampai di faskes tujuan: ${activeDestination}!`, 'success');
                    checkGeofencingArrival();
                }
            }, 3000);
        }
    }

    function updateCourierPosition(step) {
        const coords = routeCoords[step];
        courierMarker.setLatLng(coords);
        map.panTo(coords);

        const progress = Math.round((step / (routeCoords.length - 1)) * 100);
        document.getElementById('gps-coords-display').textContent = `${coords[0].toFixed(6)}, ${coords[1].toFixed(6)}`;
        document.getElementById('route-progress').textContent = `${progress}% (${progress === 100 ? 'Sampai' : 'Perjalanan'})`;
        document.getElementById('gps-status').className = 'text-emerald-400 material-symbols-outlined text-xs';
    }

    function checkGeofencingArrival() {
        logConsole(`[GEOFENCING] Verifikasi radius lokasi: Kurir berada di faskes tujuan ${activeDestination}.`, 'info');
        
        fetch(`/api/route/${activeRouteId}/complete`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(result => {
            if (result.success) {
                logConsole(`[GEOFENCING] Kargo Tiba Otomatis! Tanda terima digital dikirim. Status: Selesai.`, 'success');
                alert(`[GEOFENCING DETECTED]\n\nKargo Boks ${activeBoxId} telah memasuki wilayah faskes ${activeDestination}.\nStatus perjalanan diperbarui ke SELESAI secara otomatis. Data log dikunci.`);
            } else {
                logConsole(`[GEOFENCING] Gagal menyelesaikan rute: ${result.message}`, 'warning');
            }
        })
        .catch(err => {
            console.error('Error completing route via geofencing:', err);
        });
    }

    // Reset GPS Position
    function resetGpsPosition() {
        if (isMoving) {
            toggleRouteSimulation();
        }
        currentStep = 0;
        updateCourierPosition(currentStep);
        logConsole(`Posisi GPS kurir di-reset ke titik asal.`);
    }

    // PENTING: Sinkronisasi AJAX Live Telemetri ke Laravel Server
    function syncTelemetryWithServer() {
        if (!isCargoScanned) return; // Hanya kirim sync jika kargo terverifikasi

        const coords = routeCoords[currentStep];
        
        const telemetryRecord = {
            id_rute: activeRouteId,
            timestamp: new Date().toISOString(),
            suhu_aktual: currentTemp,
            nilai_mkt: mktTemp,
            latitude: coords[0],
            longitude: coords[1],
            is_synced_from_offline: !isNetworkOnline,
            gaya_guncangan: vibrationLevel
        };

        if (!isNetworkOnline) {
            // Buffer offline
            offlineBuffer.push(telemetryRecord);
            updateOfflineCacheCount();
            logConsole(`[Offline Cache] Telemetri disimpan lokal: ${currentTemp}Â&deg;C, Cache: ${offlineBuffer.length} log`, 'warning');
            return;
        }

        const payload = {
            data: [telemetryRecord]
        };

        fetch('/api/telemetry/sync', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'Authorization': `Bearer {{ $apiToken ?? '' }}`
            },
            body: JSON.stringify(payload)
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                // Check if route was rerouted by admin
                if (result.is_rerouted && !activeReroutes[activeRouteId]) {
                    activeReroutes[activeRouteId] = true;
                    logConsole(`Pemberitahuan: Rute dialihkan oleh Admin via Musi IV Bypass.`, 'info');
                    
                    const basePoints = alternativePaths[activeDestination];
                    if (basePoints) {
                        routeCoords = basePoints;
                        if (currentStep >= routeCoords.length) {
                            currentStep = routeCoords.length - 1;
                        }
                        if (map && routePolyline && courierMarker && destMarker) {
                            routePolyline.setLatLngs(routeCoords);
                            courierMarker.setLatLng(routeCoords[currentStep]);
                            destMarker.setLatLng(routeCoords[routeCoords.length - 1]);
                            destMarker.bindPopup(`<div class='text-xs font-bold text-slate-800  py-0.5'>${activeDestination} (Tujuan)</div>`, { closeButton: false });
                        }
                    }
                }
                logConsole(`Sync Telemetri Sukses: Suhu ${currentTemp}Â&deg;C, Getaran ${vibrationLevel}G, Koordinat ${coords[0].toFixed(4)}, ${coords[1].toFixed(4)}`, 'success');
                if (vibrationLevel > 1.0) {
                    vibrationLevel = 0.05;
                    document.getElementById('vibration-badge').textContent = '0,05G';
                }
            } else {
                logConsole(`Sync Telemetri Gagal: ${result.message}`, 'warning');
            }
        })
        .catch(err => {
            // Fallback buffer if API call fails
            offlineBuffer.push(telemetryRecord);
            updateOfflineCacheCount();
            logConsole(`Gagal Hubungi API (Mode Offline Aktif). Telemetri disimpan lokal.`, 'warning');
        });
    }

    // -------------------------------------------------------------
    // Desktop Notification/Network Status Management
    // -------------------------------------------------------------
    window.setNetworkStatus = function(status) {
        isNetworkOnline = status;
        
        const badge = document.getElementById('network-status-badge');
        const phoneWifi = document.getElementById('phone-wifi-icon');
        const btnOnline = document.getElementById('btn-net-online');
        const btnOffline = document.getElementById('btn-net-offline');
        
        if (isNetworkOnline) {
            if (badge) {
                badge.textContent = 'ONLINE';
                badge.className = 'px-2 py-0.5 rounded-full bg-green-500/10 text-green-400 border border-green-500/20 text-[9px] font-extrabold uppercase';
            }
            if (phoneWifi) {
                phoneWifi.textContent = 'wifi';
                phoneWifi.className = 'material-symbols-outlined text-xs text-teal-400';
            }
            if (btnOnline) {
                btnOnline.className = 'py-2 rounded-xl bg-primary text-white text-xs font-bold transition-all cursor-pointer flex items-center justify-center gap-1 border border-primary';
            }
            if (btnOffline) {
                btnOffline.className = 'py-2 rounded-xl bg-slate-800 border border-outline-variant/65 hover:bg-slate-700 text-slate-300 text-xs font-bold transition-all cursor-pointer flex items-center justify-center gap-1';
            }
            
            logConsole('Simulasi Koneksi Internet Terhubung (ONLINE).', 'success');
            triggerOfflineRecoverySync();
        } else {
            if (badge) {
                badge.textContent = 'OFFLINE';
                badge.className = 'px-2 py-0.5 rounded-full bg-red-500/10 text-red-400 border border-red-500/20 text-[9px] font-extrabold uppercase';
            }
            if (phoneWifi) {
                phoneWifi.textContent = 'wifi_off';
                phoneWifi.className = 'material-symbols-outlined text-xs text-red-500 animate-pulse';
            }
            if (btnOnline) {
                btnOnline.className = 'py-2 rounded-xl bg-slate-800 border border-outline-variant/65 hover:bg-slate-700 text-slate-300 text-xs font-bold transition-all cursor-pointer flex items-center justify-center gap-1';
            }
            if (btnOffline) {
                btnOffline.className = 'py-2 rounded-xl bg-red-500 text-white text-xs font-bold transition-all cursor-pointer flex items-center justify-center gap-1 border border-red-500';
            }
            
            logConsole('Simulasi Koneksi Internet Terputus (OFFLINE). Telemetri akan dicache secara lokal.', 'warning');
        }
    };
    
    function triggerOfflineRecoverySync() {
        if (offlineBuffer.length === 0) return;
        
        const count = offlineBuffer.length;
        logConsole(`[Offline Recovery] Memulai sinkronisasi massal ${count} log telemetri tertunda...`, 'info');
        
        const payload = {
            data: offlineBuffer
        };
        
        fetch('/api/telemetry/sync', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'Authorization': `Bearer {{ $apiToken ?? '' }}`
            },
            body: JSON.stringify(payload)
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                logConsole(`[Offline Recovery] Sinkronisasi Massal Sukses! ${count} log berhasil disimpan di cloud server.`, 'success');
                offlineBuffer = [];
                updateOfflineCacheCount();
            } else {
                logConsole(`[Offline Recovery] Gagal sinkronisasi massal: ${result.message}`, 'warning');
            }
        })
        .catch(err => {
            logConsole(`[Offline Recovery] Gagal menghubungkan ke server API. ${count} log tetap di-cache.`, 'warning');
        });
    }
    
    function updateOfflineCacheCount() {
        const countEl = document.getElementById('offline-cache-count');
        if (countEl) {
            countEl.textContent = `${offlineBuffer.length} logs cached`;
        }
    }

    // Laporan Darurat SOS (Thumb-Friendly floating options)
    function openSosModal() {
        document.getElementById('sos-modal').classList.remove('hidden');
        document.getElementById('sos-modal').classList.add('flex');
    }

    // Close SOS Modal
    function closeSosModal() {
        document.getElementById('sos-modal').classList.remove('flex');
        document.getElementById('sos-modal').classList.add('hidden');
    }

    function reportSosIncident(jenisInsiden) {
        closeSosModal();
        const coords = routeCoords[currentStep];

        const payload = {
            id_rute: activeRouteId,
            jenis_insiden: jenisInsiden,
            deskripsi: `Kurir melaporkan kejadian ${jenisInsiden} di koordinat ${coords[0].toFixed(5)}, ${coords[1].toFixed(5)}`,
            suhu_tercatat: currentTemp
        };

        fetch('/api/simulasi/sos', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify(payload)
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                logConsole(`[SOS TERKIRIM] Laporan '${jenisInsiden}' berhasil masuk ke Pusat Kendali!`, 'danger');
                alert(`SOS Berhasil Dikirim: ${jenisInsiden} telah masuk ke dalam menu Peringatan Pusat Kendali.`);
            } else {
                logConsole(`[SOS GAGAL] Error: ${result.message}`, 'warning');
            }
        })
        .catch(err => {
            logConsole(`[SOS GAGAL] Koneksi gagal ke server. SOS tidak dapat disimpan.`, 'danger');
        });
    }
</script>
@endpush
