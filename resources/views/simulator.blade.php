<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BIO-GUARD | Web Simulator PKM-KC</title>
    
    <!-- CSRF Token for Laravel Compatibility -->
    <meta name="csrf-token" content="{{ csrf_token() ?? '' }}">

    <!-- Theme Initialization Script (Prevent FOUC) -->
    <script>
        // Force light mode default
        localStorage.setItem('color-theme', 'light');
        document.documentElement.classList.remove('dark');
        document.documentElement.classList.add('light');
    </script>

    <!-- Google Fonts (Plus Jakarta Sans & JetBrains Mono) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS (via CDN) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        mono: ['"JetBrains Mono"', 'monospace'],
                    },
                    animation: {
                        'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                        'flash-red': 'flashRed 0.6s infinite alternate',
                        'ping-slow': 'ping 2s cubic-bezier(0, 0, 0.2, 1) infinite',
                        'radar-ripple': 'radarRipple 2s cubic-bezier(0, 0, 0.2, 1) infinite',
                    },
                    keyframes: {
                        flashRed: {
                            '0%': { backgroundColor: 'rgba(239, 68, 68, 0.45)', boxShadow: 'inset 0 0 40px rgba(220, 38, 38, 0.8)' },
                            '100%': { backgroundColor: 'rgba(153, 27, 27, 0.85)', boxShadow: 'inset 0 0 80px rgba(220, 38, 38, 1)' }
                        },
                        radarRipple: {
                            '0%': { transform: 'scale(0.8)', opacity: '0.8' },
                            '100%': { transform: 'scale(2.5)', opacity: '0' }
                        }
                    }
                }
            }
        }
    </script>

    <!-- Leaflet.js Mapping Library (via CDN) -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <!-- Glassmorphism Styles & Scrollbars Customization -->
    <style>
        :root {
            --body-bg: #f8fafc;
            --body-text: #1e293b;
            --glass-bg: rgba(255, 255, 255, 0.7);
            --glass-border: rgba(0, 0, 0, 0.1);
            --glass-card: rgba(241, 245, 249, 0.6);
            --leaflet-bg: #f1f5f9;
            --leaflet-bar-bg: rgba(255, 255, 255, 0.9);
            --leaflet-bar-border: rgba(0, 0, 0, 0.2);
            --leaflet-bar-text: #334155;
            --scrollbar-track: rgba(0, 0, 0, 0.05);
            --scrollbar-thumb: rgba(0, 0, 0, 0.2);
        }

        .dark {
            --body-bg: #030712;
            --body-text: #f3f4f6;
            --glass-bg: rgba(17, 24, 39, 0.6);
            --glass-border: rgba(255, 255, 255, 0.08);
            --glass-card: rgba(31, 41, 55, 0.45);
            --leaflet-bg: #0d1117;
            --leaflet-bar-bg: rgba(17, 24, 39, 0.8);
            --leaflet-bar-border: rgba(255, 255, 255, 0.1);
            --leaflet-bar-text: #e5e7eb;
            --scrollbar-track: rgba(17, 24, 39, 0.5);
            --scrollbar-thumb: rgba(255, 255, 255, 0.15);
        }

        body {
            background-color: var(--body-bg);
            color: var(--body-text);
            font-family: 'Plus Jakarta Sans', sans-serif;
            overflow-x: hidden;
            transition: background-color 0.3s, color 0.3s;
        }

        /* Glassmorphism custom classes */
        .glass-panel {
            background: var(--glass-bg);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid var(--glass-border);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.15);
        }

        .glass-card {
            background: var(--glass-card);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border: 1px solid var(--glass-border);
        }

        /* Leaflet custom styling */
        .leaflet-container {
            background: var(--leaflet-bg) !important;
            font-family: inherit;
        }
        .leaflet-bar {
            border: 1px solid var(--leaflet-bar-border) !important;
            background: var(--leaflet-bar-bg) !important;
            backdrop-filter: blur(8px);
            box-shadow: none !important;
        }
        .leaflet-bar a {
            background: transparent !important;
            color: var(--leaflet-bar-text) !important;
            border-bottom: 1px solid var(--leaflet-bar-border) !important;
        }
        .leaflet-bar a:hover {
            background: rgba(125, 125, 125, 0.15) !important;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: var(--scrollbar-track);
        }
        ::-webkit-scrollbar-thumb {
            background: var(--scrollbar-thumb);
            border-radius: 3px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: rgba(125, 125, 125, 0.3);
        }

        /* Glow effects */
        .glow-green { box-shadow: 0 0 15px rgba(34, 197, 94, 0.4); }
        .glow-yellow { box-shadow: 0 0 15px rgba(234, 179, 8, 0.4); }
        .glow-red { box-shadow: 0 0 25px rgba(239, 68, 68, 0.7); }
    </style>
</head>
<body class="h-full relative select-none">

    <!-- Ambient background glowing blobs -->
    <div class="absolute top-[10%] left-[20%] w-[350px] h-[350px] bg-violet-600/15 rounded-full blur-[100px] pointer-events-none animate-pulse-slow"></div>
    <div class="absolute bottom-[20%] right-[15%] w-[450px] h-[450px] bg-emerald-600/10 rounded-full blur-[130px] pointer-events-none"></div>
    <div class="absolute top-[60%] left-[5%] w-[300px] h-[300px] bg-rose-600/10 rounded-full blur-[100px] pointer-events-none animate-pulse-slow"></div>

    <!-- Main Container -->
    <div class="min-h-screen flex flex-col">
        
        <!-- Header -->
        <header class="w-full py-4 px-6 border-b border-slate-200  bg-white/40  backdrop-blur-md flex justify-between items-center z-50">
            <div class="flex items-center space-x-3">
                <!-- Glowing Logo -->
                <div class="w-8 h-8 rounded-lg bg-gradient-to-tr from-emerald-400 to-teal-600 flex items-center justify-center shadow-lg shadow-teal-500/20">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5 text-slate-950">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-lg font-bold tracking-tight bg-gradient-to-r from-slate-800 to-slate-500    bg-clip-text text-transparent">
                        BIO-GUARD <span class="text-xs px-2 py-0.5 ml-1.5 rounded-full bg-emerald-500/10 text-emerald-600  border border-emerald-500/20 font-semibold tracking-normal">PKM-KC 2026</span>
                    </h1>
                    <p class="text-[10px] text-slate-500  font-mono">Sistem Pemantauan Logistik Obat Termolabil</p>
                </div>
            </div>
            <div class="hidden sm:flex items-center space-x-4">
                <div class="flex items-center space-x-2 text-xs font-mono text-slate-600 ">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span>Server Status: <span class="text-emerald-600  font-bold">ACTIVE</span></span>
                </div>
                <!-- Theme Toggle Button -->
                <button id="theme-toggle" type="button" class="text-slate-500  hover:bg-slate-100 :bg-slate-700 focus:outline-none focus:ring-4 focus:ring-slate-200 :ring-slate-700 rounded-lg text-sm p-2.5">
                    <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
                    <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path></svg>
                </button>
            </div>
        </header>

        <!-- Main Workspace -->
        <div class="flex-1 w-full max-w-7xl mx-auto px-4 py-6 grid grid-cols-12 gap-6 items-center">
            
            <!-- LEFT COLUMN: Mobile Mockup Frame (SmartPhone Screen) -->
            <div class="col-span-12 lg:col-span-7 xl:col-span-8 flex justify-center items-center py-2 h-full">
                
                <!-- Phone Wrapper (Mockup borders only visible on Desktop) -->
                <div class="relative w-full max-w-[375px] h-[812px] lg:h-[800px] xl:h-[812px] glass-panel rounded-[50px] border-[10px] border-slate-300  shadow-2xl overflow-hidden transition-all duration-300 ring-4 ring-slate-100/50  scale-[0.98] xl:scale-100 flex flex-col
                            max-lg:fixed max-lg:inset-0 max-lg:max-w-none max-lg:h-full max-lg:rounded-none max-lg:border-0 max-lg:ring-0">
                    
                    <!-- Phone Notch & Status Bar (Hidden on actual mobile edge-to-edge if layout permits, but fits nicely as top overlay) -->
                    <div class="w-full bg-slate-200  px-6 pt-3 pb-2 flex justify-between items-center text-xs font-semibold text-slate-700  z-50 shrink-0">
                        <div class="font-mono" id="phone-clock">10:20</div>
                        
                        <!-- Screen Notch (Centered) -->
                        <div class="w-28 h-4 bg-slate-200  rounded-b-xl absolute top-0 left-1/2 -translate-x-1/2 flex items-center justify-center max-lg:hidden">
                            <span class="w-3 h-3 bg-slate-300  rounded-full border border-slate-400 "></span>
                        </div>

                        <div class="flex items-center space-x-2">
                            <!-- Signal Strength -->
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-3.5 h-3.5" viewBox="0 0 24 24">
                                <path d="M12 3c-1.2 0-2.4.3-3.6.9L3.1 7.2C1.9 8.1 1 9.4 1 11c0 2.2 1.8 4 4 4h14c2.2 0 4-1.8 4-4 0-1.6-.9-2.9-2.1-3.8l-5.3-3.3c-1.2-.6-2.4-.9-3.6-.9z"/>
                            </svg>
                            <!-- Wifi -->
                            <span id="wifi-icon" class="text-teal-400">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3.5 h-3.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.288 15.038a5.25 5.25 0 0 1 7.424 0M5.106 11.856c3.807-3.808 9.98-3.808 13.788 0M1.924 8.674c5.565-5.565 14.587-5.565 20.152 0M12.53 18.22l-.53.53-.53-.53a.75.75 0 0 1 1.06 0Z" />
                                </svg>
                            </span>
                            <!-- Battery -->
                            <div class="flex items-center space-x-0.5">
                                <span id="esp32-battery-text" class="text-[10px] text-slate-400 font-mono">85%</span>
                                <div class="w-5 h-2.5 rounded-[3px] border border-slate-500 p-[1px] flex items-center">
                                    <div id="esp32-battery-bar" class="h-full w-[85%] bg-teal-400 rounded-[1px]"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Main Phone Content Frame -->
                    <div class="flex-1 w-full relative flex flex-col bg-white  overflow-hidden">
                        
                        <!-- TAB 1: Route Map View (Default) -->
                        <div id="tab-map-content" class="absolute inset-0 z-10 flex flex-col">
                            <!-- Leaflet Map Container -->
                            <div id="map" class="w-full h-full z-0"></div>
                            
                            <!-- Floating Top Telemetry Card -->
                            <div class="absolute top-4 left-4 right-4 z-40">
                                <div id="telemetry-card" class="glass-panel backdrop-blur-xl rounded-2xl p-4 flex flex-col justify-between shadow-xl transition-all duration-300 border-teal-500/30 glow-green">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-2">
                                            <span class="relative flex h-3.5 w-3.5">
                                                <span id="telemetry-indicator-ping" class="animate-ping-slow absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                                <span id="telemetry-indicator-dot" class="relative inline-flex rounded-full h-3.5 w-3.5 bg-emerald-500"></span>
                                            </span>
                                            <span class="text-xs font-bold uppercase tracking-wider text-slate-400">TELEMETRI ESP32</span>
                                        </div>
                                        <span id="telemetry-status-badge" class="px-2.5 py-0.5 rounded-full text-[10px] font-bold tracking-wide bg-emerald-500/15 text-emerald-400 border border-emerald-500/20">AMAN</span>
                                    </div>
                                    <div class="mt-2.5 flex items-baseline justify-between">
                                        <div>
                                            <span class="text-slate-500 text-[10px] uppercase font-semibold">Suhu Logistik</span>
                                            <div class="flex items-baseline space-x-1">
                                                <span id="telemetry-temp" class="text-3xl font-extrabold text-white tracking-tight">5.2</span>
                                                <span class="text-lg font-bold text-slate-400">°C</span>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <span class="text-slate-500 text-[10px] uppercase font-semibold">Keamanan Kargo</span>
                                            <div id="telemetry-desc" class="text-xs font-bold text-emerald-400 mt-1">2°C s.d. 8°C (Normal)</div>
                                        </div>
                                    </div>
                                    <div id="warning-timer-container" class="mt-2.5 py-1.5 px-3 rounded-lg bg-amber-500/10 border border-amber-500/20 items-center justify-between hidden">
                                        <div class="flex items-center space-x-2 text-xs text-amber-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4 animate-bounce">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                                            </svg>
                                            <span class="font-bold tracking-tight">Ekskursi Suhu Terdeteksi!</span>
                                        </div>
                                        <div class="text-xs font-mono font-bold text-amber-300">
                                            Karantina: <span id="warning-timer-counter" class="text-sm text-white">30</span>s
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- SOS floating button (Bottom right of map) -->
                            <button id="sos-button" class="absolute bottom-20 right-4 z-40 w-14 h-14 bg-gradient-to-tr from-rose-500 to-red-700 hover:from-rose-600 hover:to-red-800 rounded-full flex items-center justify-center shadow-lg shadow-red-500/30 border border-rose-400/20 active:scale-95 transition-all focus:outline-none">
                                <span class="absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-20 animate-ping"></span>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-7 h-7 text-white">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                                </svg>
                            </button>
                        </div>

                        <!-- TAB 2: BLE Scan & Connect Screen -->
                        <div id="tab-ble-content" class="absolute inset-0 z-10 flex flex-col bg-slate-950 p-6 hidden overflow-y-auto">
                            <div class="mt-8">
                                <h3 class="text-base font-bold text-white tracking-wide">BLE Hardware Scanner</h3>
                                <p class="text-[11px] text-slate-400 mt-0.5">Membaca telemetry sensor boks obat via Bluetooth</p>
                            </div>
                            
                            <!-- Radar Scanning Animation -->
                            <div class="flex flex-col items-center justify-center my-10 relative py-12">
                                <div class="w-32 h-32 rounded-full border border-teal-500/20 flex items-center justify-center relative">
                                    <div class="absolute w-24 h-24 rounded-full border border-teal-500/40 animate-radar-ripple"></div>
                                    <div class="absolute w-16 h-16 rounded-full border border-teal-500/60 animate-ping"></div>
                                    <div class="w-12 h-12 rounded-full bg-gradient-to-tr from-teal-400 to-emerald-500 shadow-md shadow-teal-500/30 flex items-center justify-center z-10">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6 text-slate-950">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.375 9a3.75 3.75 0 1 1 7.5 0 3.75 3.75 0 0 1-7.5 0ZM2.25 21a9.75 9.75 0 0 1 17.75-5.25L21.75 18M18 10.5h.008v.008H18V10.5Z" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="text-xs text-slate-400 font-medium tracking-wide mt-4">Memindai Perangkat ESP32...</div>
                            </div>

                            <!-- BLE Device Lists -->
                            <div class="space-y-3">
                                <div class="text-xs uppercase font-bold tracking-wider text-slate-500">Perangkat Terkoneksi</div>
                                <div class="glass-card rounded-xl p-3.5 flex items-center justify-between border border-teal-500/20">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-8 h-8 rounded-lg bg-teal-500/10 text-teal-400 flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 3v1.5M4.5 8.25H3m18 0h-1.5M4.5 12H3m18 0h-1.5m-15 3.75H3m18 0h-1.5M8.25 19.5V21M12 3v1.5m0 15V21m3.75-18v1.5m0 15V21m-10-14.25h12.5A2.25 2.25 0 0 1 20.25 9v6A2.25 2.25 0 0 1 18 17.25H5.25A2.25 2.25 0 0 1 3 15V9a2.25 2.25 0 0 1 2.25-2.25Z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="text-xs font-bold text-white font-mono">ESP32_BIOGUARD_01</div>
                                            <div class="text-[10px] text-teal-400 font-mono">MAC: 24:0A:C4:8B:58:A2</div>
                                        </div>
                                    </div>
                                    <span class="px-2 py-0.5 rounded-full text-[9px] font-bold text-teal-400 bg-teal-500/10 border border-teal-500/20">CONNECTED</span>
                                </div>

                                <div class="text-xs uppercase font-bold tracking-wider text-slate-500 pt-3">Perangkat Lain Ditemukan</div>
                                <div class="glass-card rounded-xl p-3.5 flex items-center justify-between opacity-50">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-8 h-8 rounded-lg bg-slate-800 text-slate-400 flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.375 9a3.75 3.75 0 1 1 7.5 0 3.75 3.75 0 0 1-7.5 0Z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="text-xs font-bold text-slate-300 font-mono">SmartBox_Thermo_X2</div>
                                            <div class="text-[10px] text-slate-500 font-mono">MAC: B4:E6:2D:6F:AA:C1</div>
                                        </div>
                                    </div>
                                    <button class="px-2.5 py-1 rounded bg-slate-800 text-[10px] font-semibold text-slate-300 hover:bg-slate-700 cursor-not-allowed">Hubungkan</button>
                                </div>
                            </div>
                        </div>

                        <!-- TAB 3: Courier Profile Screen -->
                        <div id="tab-profile-content" class="absolute inset-0 z-10 flex flex-col bg-slate-950 p-6 hidden overflow-y-auto">
                            <div class="mt-8 text-center flex flex-col items-center">
                                <!-- Avatar -->
                                <div class="w-20 h-20 rounded-full bg-gradient-to-tr from-indigo-500 via-purple-500 to-teal-400 p-0.5 shadow-lg relative">
                                    <div class="w-full h-full rounded-full bg-slate-950 flex items-center justify-center">
                                        <span class="text-2xl font-bold tracking-tight text-white">RH</span>
                                    </div>
                                    <span class="absolute bottom-1 right-1 w-4 h-4 rounded-full bg-teal-400 border-2 border-slate-950"></span>
                                </div>
                                <h3 class="text-base font-bold text-white mt-3">Rian Hidayat</h3>
                                <p class="text-xs text-slate-400">Kurir Pengantar Logistik Medis</p>
                                <span class="mt-2.5 px-3 py-1 rounded-full text-[10px] font-bold text-indigo-400 bg-indigo-500/10 border border-indigo-500/20 uppercase tracking-wider">Rayon Palembang</span>
                            </div>

                            <!-- Courier Details list -->
                            <div class="mt-6 space-y-3.5">
                                <div class="glass-card rounded-xl p-4 border border-white/5">
                                    <div class="text-[10px] text-slate-500 font-bold uppercase tracking-wider">Tugas Aktif</div>
                                    <div class="text-xs text-white font-semibold mt-1">Distribusi Vaksin Polio (Termolabil)</div>
                                    <div class="text-[10px] text-slate-400 font-mono mt-1">ID Pengiriman: #TRX-948271</div>
                                </div>
                                <div class="glass-card rounded-xl p-4 border border-white/5 space-y-3">
                                    <div>
                                        <div class="text-[10px] text-slate-500 font-bold uppercase tracking-wider">Asal Pengiriman</div>
                                        <div class="text-xs text-slate-300 mt-0.5">Pusat Distribusi Logistik Palembang</div>
                                    </div>
                                    <hr class="border-white/5">
                                    <div>
                                        <div class="text-[10px] text-slate-500 font-bold uppercase tracking-wider">Tujuan Pengiriman</div>
                                        <div class="text-xs text-slate-300 mt-0.5">RSUP Dr. Mohammad Hoesin Palembang</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Floating Bottom Navigation Bar (Phone Menu) -->
                        <div class="absolute bottom-4 left-4 right-4 z-40">
                            <div class="glass-panel backdrop-blur-xl rounded-2xl px-6 py-3 flex justify-around items-center shadow-2xl border border-white/10">
                                
                                <!-- Tab Map Button -->
                                <button id="btn-tab-map" class="flex flex-col items-center space-y-1 text-teal-400 focus:outline-none transition-colors duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                                    </svg>
                                    <span class="text-[9px] font-bold tracking-tight">Peta Rute</span>
                                </button>

                                <!-- Tab BLE Button -->
                                <button id="btn-tab-ble" class="flex flex-col items-center space-y-1 text-slate-400 hover:text-slate-200 focus:outline-none transition-colors duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12c0-1.232-.046-2.453-.138-3.662a4.006 4.006 0 0 0-3.7-3.7 48.656 48.656 0 0 0-7.324 0 4.006 4.006 0 0 0-3.7 3.7C4.547 9.547 4.5 10.768 4.5 12s.047 2.453.138 3.662a4.006 4.006 0 0 0 3.7 3.7 48.656 48.656 0 0 0 7.324 0 4.006 4.006 0 0 0 3.7-3.7c.092-1.209.138-2.43.138-3.662Z" />
                                    </svg>
                                    <span class="text-[9px] font-bold tracking-tight">Scanner Boks</span>
                                </button>

                                <!-- Tab Profile Button -->
                                <button id="btn-tab-profile" class="flex flex-col items-center space-y-1 text-slate-400 hover:text-slate-200 focus:outline-none transition-colors duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                    </svg>
                                    <span class="text-[9px] font-bold tracking-tight">Profil</span>
                                </button>

                            </div>
                        </div>

                        <!-- Full-Screen Excursion Red Alert Overlay (CRITICAL ALARM) -->
                        <div id="red-alert-overlay" class="absolute inset-0 z-50 animate-flash-red flex flex-col items-center justify-center p-6 hidden">
                            <!-- Backdrop blur layer -->
                            <div class="absolute inset-0 backdrop-blur-sm pointer-events-none bg-red-900/10"></div>
                            
                            <div class="relative z-10 flex flex-col items-center text-center space-y-6">
                                <!-- Warning Sign -->
                                <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center shadow-2xl animate-bounce">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-12 h-12 text-red-600">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m0-10.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.75c0 5.592 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.57-.598-3.75h-.152c-3.196 0-6.1-1.249-8.25-3.286Zm0 13.036h.008v.008H12v-.008Z" />
                                    </svg>
                                </div>
                                <div class="space-y-2">
                                    <h2 class="text-2xl font-black tracking-tight text-white uppercase">CRITICAL SYSTEM</h2>
                                    <p class="text-sm font-bold text-red-100 uppercase tracking-widest bg-red-950/70 py-1.5 px-4 rounded-xl border border-red-500/20">
                                        EKSKURSI SUHU EXTREME
                                    </p>
                                    <div class="text-[11px] font-mono text-red-200 mt-2 bg-black/40 p-3 rounded-lg border border-red-500/10 leading-relaxed max-w-[280px] mx-auto">
                                        Rantai dingin terputus! Segera pindahkan kargo ke cold-storage cadangan.
                                    </div>
                                </div>
                                <div class="pt-4 flex flex-col space-y-2 w-full min-w-[200px]">
                                    <!-- Dismiss Alert / Reset Slider to Normal -->
                                    <button id="btn-dismiss-alert" class="px-5 py-2.5 bg-white text-red-700 font-extrabold text-xs tracking-wider rounded-xl shadow-lg active:scale-95 transition-all hover:bg-slate-100 uppercase focus:outline-none">
                                        Karantina Kargo & Reset
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

            <!-- RIGHT COLUMN: Interactive Control Panel (Visible on Desktop only) -->
            <div class="col-span-12 lg:col-span-5 xl:col-span-4 flex flex-col gap-6 max-lg:hidden h-full py-6">
                
                <!-- Controller Box -->
                <div class="glass-panel rounded-3xl p-6 border border-white/10 flex flex-col space-y-6">
                    <div>
                        <h2 class="text-sm font-extrabold text-white uppercase tracking-wider flex items-center space-x-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-teal-500 animate-pulse"></span>
                            <span>PANEL KENDALI SIMULATOR</span>
                        </h2>
                        <p class="text-xs text-slate-400 mt-1">Manipulasi sensor boks IoT & parameter pengiriman secara real-time.</p>
                    </div>

                    <hr class="border-white/5">

                    <!-- Section: Rute Perjalanan -->
                    <div class="space-y-3.5">
                        <label class="text-xs font-bold text-slate-300 uppercase tracking-wider block">Status Perjalanan</label>
                        <div class="flex flex-col gap-2 text-xs">
                            <div class="flex justify-between items-center py-1 border-b border-white/5">
                                <span class="text-slate-400">Rute Aktif:</span>
                                <select id="route-selector" class="bg-slate-900 text-slate-200 border border-white/10 rounded px-1.5 py-1 font-mono text-[11px] focus:outline-none focus:border-teal-500" onchange="changeRoute(this.value)">
                                    @foreach($ruteAktif as $rute)
                                        @php
                                $faskes = \App\Models\InventoryHub::where('nama', $rute->lokasi_tujuan)->first();
                                $lat = $faskes && $faskes->latitude ? $faskes->latitude : -2.973305;
                                $lng = $faskes && $faskes->longitude ? $faskes->longitude : 104.745582;
                            @endphp
                            <option value="{{ $rute->id_rute }}" data-lat="{{ $lat }}" data-lng="{{ $lng }}"  data-box="{{ $rute->id_box }}" data-tujuan="{{ $rute->lokasi_tujuan }}" data-kurir="{{ $rute->kurir->nama_lengkap }}">
                                            {{ $rute->id_rute }} - {{ $rute->kurir->nama_lengkap }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex justify-between py-1 border-b border-white/5">
                                <span class="text-slate-400">ID Boks IoT:</span>
                                <span id="ctrl-box-id" class="font-mono text-teal-400 font-bold">BOX-01</span>
                            </div>
                            <div class="flex justify-between py-1">
                                <span class="text-slate-400">Tujuan:</span>
                                <span id="ctrl-tujuan" class="font-bold text-white text-right">RSUP Dr. Mohammad Hoesin</span>
                            </div>
                        </div>
                    </div>

                    <hr class="border-white/5">

                    <!-- Section: IoT Temperature Simulation -->
                    <div class="space-y-3.5">
                        <div class="flex justify-between items-center">
                            <label class="text-xs font-bold text-slate-300 uppercase tracking-wider">Simulasi Suhu Boks (°C)</label>
                            <span id="slider-temp-badge" class="px-3 py-1 text-sm font-mono font-bold rounded-lg bg-teal-500/10 text-teal-400 border border-teal-500/20">5.2°C</span>
                        </div>
                        <input id="temp-slider" type="range" min="0" max="15" step="0.1" value="5.2" 
                               class="w-full h-2 bg-slate-800 rounded-lg appearance-none cursor-pointer accent-teal-400">
                        
                        <div class="grid grid-cols-3 gap-2 text-[10px] font-semibold text-center mt-1">
                            <button onclick="setTemperature(4.5)" class="py-1 rounded bg-slate-800/80 border border-white/5 hover:bg-slate-800 hover:text-white transition text-emerald-400">4.5°C (Aman)</button>
                            <button onclick="setTemperature(8.3)" class="py-1 rounded bg-slate-800/80 border border-white/5 hover:bg-slate-800 hover:text-white transition text-amber-400">8.3°C (Warning)</button>
                            <button onclick="setTemperature(10.5)" class="py-1 rounded bg-slate-800/80 border border-white/5 hover:bg-slate-800 hover:text-white transition text-rose-500">10.5°C (Kritis)</button>
                        </div>
                    </div>

                    <hr class="border-white/5">

                    <!-- Section: IoT Vibration/Shock Simulation -->
                    <div class="space-y-3.5">
                        <div class="flex justify-between items-center">
                            <label class="text-xs font-bold text-slate-300 uppercase tracking-wider">Simulasi Guncangan Boks</label>
                            <span id="vibration-badge" class="px-3 py-1 text-sm font-mono font-bold rounded-lg bg-teal-500/10 text-teal-400 border border-teal-500/20">0,05G</span>
                        </div>
                        <div class="flex space-x-2">
                            <button id="btn-vibe-normal" onclick="setVibrationPreset(0.05)" class="flex-1 py-1.5 bg-teal-500/15 border border-teal-500/30 text-teal-400 font-bold text-xs rounded-lg active:scale-95 transition">Normal (0.05G)</button>
                            <button id="btn-vibe-shock" onclick="triggerVibrationSpike()" class="flex-1 py-1.5 bg-rose-500/20 border border-rose-500/30 text-rose-450 font-bold text-xs rounded-lg active:scale-95 transition animate-pulse cursor-pointer">Guncangan (2.5G)</button>
                        </div>
                    </div>

                    <hr class="border-white/5">

                    <!-- Section: Route Simulation -->
                    <div class="space-y-3.5">
                        <label class="text-xs font-bold text-slate-300 uppercase tracking-wider block">Simulasi Rute & Gerakan GPS</label>
                        <div class="flex items-center justify-between space-x-3">
                            <button id="btn-move" class="flex-1 py-2.5 px-4 bg-teal-500 hover:bg-teal-600 text-slate-950 font-extrabold text-xs tracking-wider rounded-xl shadow-lg active:scale-95 transition-all flex items-center justify-center space-x-1.5 focus:outline-none">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.347a1.125 1.125 0 0 1 0 1.972l-11.54 6.347a1.125 1.125 0 0 1-1.667-.986V5.653Z" />
                                </svg>
                                <span>MULAI BERGERAK</span>
                            </button>
                            
                            <button id="btn-reset-route" class="py-2.5 px-3 bg-slate-800 hover:bg-slate-700 text-slate-300 font-bold text-xs rounded-xl border border-white/5 active:scale-95 transition-all focus:outline-none">
                                RESET
                            </button>
                        </div>
                        <div class="flex items-center justify-between text-[10px] font-mono text-slate-400 bg-slate-950/50 p-2.5 rounded-lg border border-white/5">
                            <div>Posisi Marker: <span id="pos-latlng" class="text-slate-200">-2.9908, 104.7567</span></div>
                            <div>Index: <span id="pos-index" class="text-slate-200">0 / 110</span></div>
                        </div>
                    </div>

                    <hr class="border-white/5">

                    <!-- Section: Connectivity simulation (Blank spot) -->
                    <div class="space-y-3.5">
                        <div class="flex justify-between items-center">
                            <label class="text-xs font-bold text-slate-300 uppercase tracking-wider">Simulasi Konektivitas Internet</label>
                            <span id="conn-badge" class="px-2.5 py-0.5 text-[10px] font-bold rounded bg-teal-500/10 text-teal-400 border border-teal-500/20 uppercase">Online</span>
                        </div>
                        <div class="flex space-x-2">
                            <button id="btn-net-online" class="flex-1 py-1.5 bg-teal-500/15 border border-teal-500/30 text-teal-400 font-bold text-xs rounded-lg active:scale-95 transition">Online (Normal)</button>
                            <button id="btn-net-offline" class="flex-1 py-1.5 bg-slate-800 border border-white/5 text-slate-400 font-semibold text-xs rounded-lg active:scale-95 transition">Offline (Blank Spot)</button>
                        </div>
                        <div class="flex justify-between items-center text-[10px] font-mono text-slate-500">
                            <div>SQLite Offline Cache: <span id="local-cache-counter" class="text-slate-300 font-bold">0</span> telemetry</div>
                            <button onclick="clearLocalStorageCache()" class="hover:text-red-400 underline">Kosongkan</button>
                        </div>
                    </div>
                </div>

                <!-- Logger Console -->
                <div class="glass-panel rounded-3xl p-6 border border-white/10 flex-1 flex flex-col min-h-[220px]">
                    <div class="flex justify-between items-center mb-3">
                        <div class="text-xs font-extrabold tracking-wider text-slate-300 uppercase flex items-center space-x-1.5">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4 text-emerald-400">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 6.75 22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3-4.5 16.5" />
                            </svg>
                            <span>LOG SIMULASI SINKRONISASI API</span>
                        </div>
                        <button onclick="clearLogs()" class="text-[10px] text-slate-500 hover:text-slate-300 font-bold font-mono">CLEAR</button>
                    </div>
                    <!-- Terminal Console UI -->
                    <div id="log-console" class="flex-1 bg-black/40 font-mono text-[10px] p-3.5 rounded-xl border border-white/5 overflow-y-auto space-y-1.5 text-slate-400 select-text">
                        <div class="text-slate-500">[10:20:00] BIO-GUARD Simulator diinisialisasi.</div>
                        <div class="text-slate-500">[10:20:00] SQLite Database siap (Offline-first helper).</div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="mt-sm text-center">
                    <p class="text-[9px] text-slate-500 font-medium leading-relaxed">
                        BIO-GUARD Project &copy; 2026. PKM-KC Program. Politeknik Negeri Sriwijaya.
                    </p>
                </div>

            </div>
        </div>
    </div>

    <!-- Leaflet & Simulator Logic JavaScript -->
    <script>
        // --- 1. ROUTE WAYPOINTS GENERATION & SETUP ---
        const routePaths = {
            'RSUP Dr. Mohammad Hoesin': [
                [-2.9880, 104.7560], // Dinas Kesehatan Palembang
                [-2.9887, 104.7565], // Air Mancur Masjid Agung Roundabout
                [-2.9868, 104.7561], // Sudirman St near IP
                [-2.9829, 104.7552], // Sudirman St near Cinde
                [-2.9803, 104.7547], // Sudirman St near Marathon
                [-2.9774, 104.7540], // Simpang Charitas
                [-2.9748, 104.7533], // Sudirman St near Kodam
                [-2.9723, 104.7528], // Sudirman St SMA 3
                [-2.9702, 104.7521], // Sudirman St / Veteran
                [-2.9669, 104.7505]  // RSUP Dr. Mohammad Hoesin
            ],
            'RSUD Palembang BARI': [
                [-2.9880, 104.7560], // Dinas Kesehatan Palembang
                [-2.9887, 104.7565], // Air Mancur Masjid Agung
                [-2.9912, 104.7592], // Jembatan Ampera (North)
                [-2.9935, 104.7618], // Jembatan Ampera (Center)
                [-2.9961, 104.7628], // Jembatan Ampera (South)
                [-2.9995, 104.7635], // Jl. Ryacudu
                [-3.0068, 104.7625], // Simpang Bastari
                [-3.0125, 104.7615], // Jl. Gubernur Bastari near Lippo
                [-3.0142, 104.7585], // Jl. Panca Usaha entrance
                [-3.0185, 104.7645]  // RSUD Palembang BARI
            ],
            'RS Charitas': [
                [-2.9880, 104.7560], // Dinas Kesehatan Palembang
                [-2.9887, 104.7565], // Air Mancur
                [-2.9868, 104.7561], // IP
                [-2.9829, 104.7552], // Cinde
                [-2.9803, 104.7547], // Marathon
                [-2.9772, 104.7522]  // RS Charitas
            ],
            'Puskesmas Dempo': [
                [-2.9880, 104.7560], // Dinas Kesehatan Palembang
                [-2.9887, 104.7565], // Air Mancur
                [-2.9868, 104.7561], // IP
                [-2.9865, 104.7630]  // Puskesmas Dempo
            ]
        };

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

        // Smooth interpolator between raw points to show incremental movement
        function interpolateRoute(points, pointsPerSegment) {
            const path = [];
            for (let i = 0; i < points.length - 1; i++) {
                const start = points[i];
                const end = points[i+1];
                for (let j = 0; j < pointsPerSegment; j++) {
                    const ratio = j / pointsPerSegment;
                    const lat = start[0] + (end[0] - start[0]) * ratio;
                    const lng = start[1] + (end[1] - start[1]) * ratio;
                    path.push([lat, lng]);
                }
            }
            path.push(points[points.length - 1]);
            return path;
        }

        let routeCoords = interpolateRoute(routePaths['RSUP Dr. Mohammad Hoesin'], 10);
        let currentRouteIndex = 0;
        let isMoving = false;
        let moveInterval = null;
        let vibrationLevel = 0.05;

        // --- 2. LEAFLET MAP CONFIGURATION ---
        // Setup map centered at Palembang Center
        const map = L.map('map', {
            zoomControl: false,
            attributionControl: false
        }).setView([-2.9782, 104.7523], 14);

        // Dark elegant mapping tile theme
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 20
        }).addTo(map);

        // Draw Route Line
        let polyline = L.polyline(routeCoords, {
            color: '#14b8a6', // Teal 500
            weight: 4,
            opacity: 0.8,
            dashArray: '5, 8'
        }).addTo(map);

        // Marker for Courier
        // Custom neon circular marker
        const courierIcon = L.divIcon({
            className: 'custom-courier-icon',
            html: `
                <div class="relative w-6 h-6 flex items-center justify-center">
                    <span class="absolute inline-flex h-full w-full rounded-full bg-teal-400 opacity-40 animate-ping"></span>
                    <div class="w-3.5 h-3.5 bg-teal-300 border-2 border-slate-950 rounded-full shadow-lg"></div>
                </div>
            `,
            iconSize: [24, 24],
            iconAnchor: [12, 12]
        });

        let courierMarker = L.marker(routeCoords[0], { icon: courierIcon }).addTo(map);
        
        // Add Destination Marker (Red pin with glow)
        const destIcon = L.divIcon({
            className: 'custom-dest-icon',
            html: `
                <div class="relative w-8 h-8 flex items-center justify-center">
                    <div class="w-4 h-4 bg-indigo-500 border-2 border-white rounded-full shadow-xl glow-indigo"></div>
                </div>
            `,
            iconSize: [32, 32],
            iconAnchor: [16, 16]
        });
        let destMarker = L.marker(routeCoords[routeCoords.length - 1], { icon: destIcon }).addTo(map);
        destMarker.bindPopup("<div class='text-xs font-bold text-slate-800 py-0.5'>RSUP Dr. Mohammad Hoesin (Tujuan)</div>", { closeButton: false });

        // --- 3. STATE AND VARIABLE CONFIGURATION ---
        let temperature = 5.2;
        let safetyStatus = "Aman"; // Aman, Warning, Kritis
        let warningTimer = null;
        let countdownSeconds = 30;
        let isOnline = true;
        let localCache = JSON.parse(localStorage.getItem('bioguard_offline_cache')) || [];

        // Database/Route state
        let activeRouteId = '';
        let activeBoxId = '';
        let activeDestination = '';
        let activeCourierName = '';

        // Save telemetry count to local storage initially on startup
        updateOfflineCacheBadge();

        // Handle Route Selection
        function changeRoute(routeId) {
            activeRouteId = routeId;
            const selector = document.getElementById('route-selector');
            if (!selector) return;
            const selectedOption = selector.options[selector.selectedIndex];
            if (!selectedOption) return;
            
            activeBoxId = selectedOption.getAttribute('data-box') || 'BOX-01';
            activeDestination = selectedOption.getAttribute('data-tujuan') || 'RSUP Dr. Mohammad Hoesin';
            activeCourierName = selectedOption.getAttribute('data-kurir') || 'Budi Santoso';

            const ctrlBoxId = document.getElementById('ctrl-box-id');
            const ctrlTujuan = document.getElementById('ctrl-tujuan');
            if (ctrlBoxId) ctrlBoxId.textContent = activeBoxId;
            if (ctrlTujuan) ctrlTujuan.textContent = activeDestination;
            
            // Swap coordinates and interpolate
            const isRerouted = activeReroutes[activeRouteId];
            const basePoints = isRerouted && alternativePaths[activeDestination]
                ? alternativePaths[activeDestination]
                : (routePaths[activeDestination] || routePaths['RSUP Dr. Mohammad Hoesin']);
            routeCoords = interpolateRoute(basePoints, 10);
            currentRouteIndex = 0;

            // Update map features if initialized
            if (typeof polyline !== 'undefined' && typeof courierMarker !== 'undefined' && typeof destMarker !== 'undefined') {
                polyline.setLatLngs(routeCoords);
                courierMarker.setLatLng(routeCoords[0]);
                destMarker.setLatLng(routeCoords[routeCoords.length - 1]);
                destMarker.bindPopup("<div class='text-xs font-bold text-slate-800 py-0.5'>" + activeDestination + " (Tujuan)</div>", { closeButton: false });
                map.setView(routeCoords[0], 14);
            }

            // Update info on phone profile/scanner tab dynamically
            const activeDutyText = document.querySelector('#tab-profile-content .glass-card:first-child div:nth-child(2)');
            if (activeDutyText) activeDutyText.textContent = `Distribusi Vaksin (${activeBoxId})`;
            const deliveryIdText = document.querySelector('#tab-profile-content .glass-card:first-child div:nth-child(3)');
            if (deliveryIdText) deliveryIdText.textContent = `ID Rute: #${activeRouteId}`;
            const destText = document.querySelector('#tab-profile-content .glass-card:nth-child(2) div:nth-child(3) div');
            if (destText) destText.textContent = activeDestination;
            
            const courierNameText = document.querySelector('#tab-profile-content h3');
            if (courierNameText) courierNameText.textContent = activeCourierName;
            
            const initials = activeCourierName.split(' ').map(n => n[0]).join('').substring(0, 2).toUpperCase();
            const avatarText = document.querySelector('#tab-profile-content .w-20.h-20.rounded-full span');
            if (avatarText) avatarText.textContent = initials;

            writeConsoleLog(`Rute aktif diubah ke: ID ${activeRouteId} (${activeCourierName} -> ${activeDestination})`);
        }

        // Initialize first route on load
        document.addEventListener("DOMContentLoaded", () => {
            const selector = document.getElementById('route-selector');
            if (selector) {
                changeRoute(selector.value);
            }
            
            // Auto-trigger BLE scanner connection & cargo scan confirmation for seamless tracking
            setTimeout(() => {
                writeConsoleLog(`ESP32_BIOGUARD_01 Terhubung via BLE.`, "success");
                writeConsoleLog(`Kargo #${activeBoxId} Terverifikasi Sukses!`, "success");
            }, 800);
        });

        // --- 4. EXCURSION CONTROL CORE LOGIC (PKM-KC SPEC) ---
        function evaluateTemperature(tempVal) {
            temperature = tempVal;
            
            // Suhu Safe Range: 2°C s.d 8°C
            if (temperature >= 2.0 && temperature <= 8.0) {
                setSafetyState("Aman");
                clearWarningCountdown();
                dismissRedAlertOverlay();
            } 
            // Warning Range: 8.1°C s.d 8.5°C
            else if (temperature > 8.0 && temperature <= 8.5) {
                if (safetyStatus !== "Warning" && safetyStatus !== "Kritis") {
                    setSafetyState("Warning");
                    startWarningCountdown();
                }
            } 
            // Extreme Excursion: > 8.5°C (or if timer expired)
            else if (temperature > 8.5) {
                setSafetyState("Kritis");
                clearWarningCountdown();
                triggerRedAlertOverlay();
            }
        }

        function setSafetyState(state) {
            safetyStatus = state;
            const badge = document.getElementById('telemetry-status-badge');
            const card = document.getElementById('telemetry-card');
            const desc = document.getElementById('telemetry-desc');
            const dot = document.getElementById('telemetry-indicator-dot');
            const ping = document.getElementById('telemetry-indicator-ping');

            badge.className = "px-2.5 py-0.5 rounded-full text-[10px] font-bold tracking-wide border";
            card.className = "glass-panel backdrop-blur-xl rounded-2xl p-4 flex flex-col justify-between shadow-xl transition-all duration-300";

            if (state === "Aman") {
                badge.innerText = "AMAN";
                badge.classList.add("bg-emerald-500/15", "text-emerald-400", "border-emerald-500/20");
                card.classList.add("border-teal-500/30", "glow-green");
                dot.className = "relative inline-flex rounded-full h-3.5 w-3.5 bg-emerald-500";
                ping.className = "animate-ping-slow absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75";
                desc.innerText = "2°C s.d. 8°C (Normal)";
                desc.className = "text-xs font-bold text-emerald-400 mt-1";
            } 
            else if (state === "Warning") {
                badge.innerText = "WARNING";
                badge.classList.add("bg-amber-500/15", "text-amber-400", "border-amber-500/20");
                card.classList.add("border-amber-500/30", "glow-yellow");
                dot.className = "relative inline-flex rounded-full h-3.5 w-3.5 bg-amber-500";
                ping.className = "animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75";
                desc.innerText = "EXCURSION DETECTED";
                desc.className = "text-xs font-bold text-amber-400 mt-1";
            } 
            else if (state === "Kritis") {
                badge.innerText = "KRITIS";
                badge.classList.add("bg-red-500/15", "text-red-400", "border-red-500/20");
                card.classList.add("border-red-500/40", "glow-red");
                dot.className = "relative inline-flex rounded-full h-3.5 w-3.5 bg-red-600";
                ping.className = "animate-ping-slow absolute inline-flex h-full w-full rounded-full bg-red-500 opacity-75";
                desc.innerText = "KARANTINA KARGO!";
                desc.className = "text-xs font-bold text-red-500 mt-1";
            }
        }

        // 30s Countdown timer logic for warning zone (8.1°C - 8.5°C)
        function startWarningCountdown() {
            clearWarningCountdown();
            countdownSeconds = 30;
            
            const timerContainer = document.getElementById('warning-timer-container');
            const timerCounter = document.getElementById('warning-timer-counter');
            
            timerContainer.style.display = 'flex';
            timerCounter.innerText = countdownSeconds;
            
            writeConsoleLog("Ekskursi Suhu Ringan (" + temperature + "°C) Terdeteksi! Memulai timer 30 detik sebelum Karantina Kargo.", "warn");

            warningTimer = setInterval(() => {
                countdownSeconds--;
                timerCounter.innerText = countdownSeconds;
                
                if (countdownSeconds <= 0) {
                    clearWarningCountdown();
                    setSafetyState("Kritis");
                    triggerRedAlertOverlay();
                    writeConsoleLog("Timer Ekskursi Suhu Habis! Memicu sistem Karantina Kargo.", "error");
                }
            }, 1000);
        }

        function clearWarningCountdown() {
            if (warningTimer) {
                clearInterval(warningTimer);
                warningTimer = null;
            }
            document.getElementById('warning-timer-container').style.display = 'none';
        }

        // --- WEB AUDIO API SIREN GENERATOR ---
        let audioCtx = null;
        let sirenOscillator = null;
        let sirenGain = null;
        let sirenInterval = null;

        function startSirenSound() {
            try {
                if (!audioCtx) {
                    audioCtx = new (window.AudioContext || window.webkitAudioContext)();
                }
                if (audioCtx.state === 'suspended') {
                    audioCtx.resume();
                }
                if (sirenOscillator) return; 

                sirenOscillator = audioCtx.createOscillator();
                sirenGain = audioCtx.createGain();

                sirenOscillator.type = 'sawtooth';
                sirenOscillator.frequency.setValueAtTime(800, audioCtx.currentTime);

                sirenGain.gain.setValueAtTime(0.2, audioCtx.currentTime);

                sirenOscillator.connect(sirenGain);
                sirenGain.connect(audioCtx.destination);

                sirenOscillator.start();

                let highTone = true;
                sirenInterval = setInterval(() => {
                    if (sirenOscillator && audioCtx) {
                        const targetFreq = highTone ? 1100 : 750;
                        sirenOscillator.frequency.exponentialRampToValueAtTime(targetFreq, audioCtx.currentTime + 0.35);
                        highTone = !highTone;
                    }
                }, 400);
            } catch (e) {
                console.error("Audio API error: ", e);
            }
        }

        function stopSirenSound() {
            if (sirenInterval) {
                clearInterval(sirenInterval);
                sirenInterval = null;
            }
            if (sirenOscillator) {
                try {
                    sirenOscillator.stop();
                } catch (e) {}
                sirenOscillator.disconnect();
                sirenOscillator = null;
            }
            if (sirenGain) {
                sirenGain.disconnect();
                sirenGain = null;
            }
        }

        // Red Alert overlay handling
        let vibrationInterval = null;
        function triggerRedAlertOverlay() {
            const overlay = document.getElementById('red-alert-overlay');
            overlay.classList.remove('hidden');

            startSirenSound();

            // Trigger physical haptics (navigator.vibrate)
            if (navigator.vibrate) {
                // Vibrate patterns: [Vibrate, Sleep, Vibrate...]
                navigator.vibrate([400, 200, 400, 200, 400]);
                
                // Keep vibrating every 2 seconds
                if (!vibrationInterval) {
                    vibrationInterval = setInterval(() => {
                        navigator.vibrate([400, 200, 400]);
                    }, 2000);
                }
            }
            writeConsoleLog("ALARM: Red Alert Aktif! Getaran & Siren simulator diaktifkan.", "error");
        }

        function dismissRedAlertOverlay() {
            const overlay = document.getElementById('red-alert-overlay');
            overlay.classList.add('hidden');
            
            stopSirenSound();
            
            if (vibrationInterval) {
                clearInterval(vibrationInterval);
                vibrationInterval = null;
            }
            if (navigator.vibrate) {
                navigator.vibrate(0); // Cancel all vibrations
            }
        }

        // --- 5. STORE-AND-FORWARD OFFLINE SYNCING ---
        // Every 5 seconds, sync telemetry data
        setInterval(() => {
            const latlng = courierMarker.getLatLng();
            const telemetryRecord = {
                id_rute: parseInt(activeRouteId),
                timestamp: new Date().toISOString(),
                suhu_aktual: parseFloat(temperature),
                nilai_mkt: parseFloat((temperature * 1.05 + 0.1).toFixed(1)),
                latitude: parseFloat(latlng.lat),
                longitude: parseFloat(latlng.lng),
                is_synced_from_offline: !isOnline,
                gaya_guncangan: vibrationLevel
            };

            if (isOnline) {
                // Device is online: upload data directly
                uploadTelemetry(telemetryRecord);
                
                // If there are accumulated items in local DB cache, batch upload them
                if (localCache.length > 0) {
                    batchUploadOfflineCache();
                }
            } else {
                // Device is offline: save payload to SQLite simulation (localStorage)
                saveToLocalCache(telemetryRecord);
            }
        }, 5000);

        function uploadTelemetry(record) {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const payload = {
                data: [record]
            };

            // Perform simulated network post via AJAX Fetch
            fetch('/api/demo/sync-telemetri', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify(payload)
            })
            .then(async response => {
                const text = await response.text();
                // Check if page responds with valid JSON
                let data = {};
                try { data = JSON.parse(text); } catch(e) {}
                
                if (response.ok && data.success) {
                    // Check if route was rerouted by admin
                    if (data.is_rerouted && !activeReroutes[activeRouteId]) {
                        activeReroutes[activeRouteId] = true;
                        writeConsoleLog(`Pemberitahuan: Rute dialihkan oleh Admin via Musi IV Bypass.`, "info");
                        
                        const basePoints = alternativePaths[activeDestination];
                        if (basePoints) {
                            routeCoords = interpolateRoute(basePoints, 10);
                            if (currentRouteIndex >= routeCoords.length) {
                                currentRouteIndex = routeCoords.length - 1;
                            }
                            if (typeof polyline !== 'undefined' && typeof courierMarker !== 'undefined' && typeof destMarker !== 'undefined') {
                                polyline.setLatLngs(routeCoords);
                                courierMarker.setLatLng(routeCoords[currentRouteIndex]);
                                destMarker.setLatLng(routeCoords[routeCoords.length - 1]);
                                destMarker.bindPopup("<div class='text-xs font-bold text-slate-800 py-0.5'>" + activeDestination + " (Tujuan)</div>", { closeButton: false });
                            }
                        }
                    }
                    writeConsoleLog(`POST /api/telemetry/sync - HTTP ${response.status} SUCCESS | Temp: ${record.suhu_aktual}°C, Getaran: ${vibrationLevel}G, Lat: ${record.latitude.toFixed(5)}, Lng: ${record.longitude.toFixed(5)}`, "success");
                    if (vibrationLevel > 1.0) {
                        vibrationLevel = 0.05;
                        document.getElementById('vibration-badge').textContent = '0,05G';
                    }
                } else {
                    // Endpoint routes failed or response returned error
                    throw new Error(data.message || `HTTP Status ${response.status}`);
                }
            })
            .catch(error => {
                // Fallback to storing locally (offline mode emulation because endpoint is unreachable)
                writeConsoleLog(`Sync ke server gagal (${error.message}). Menyimpan data ke SQLite lokal...`, "warn");
                saveToLocalCache(record);
            });
        }

        function saveToLocalCache(record) {
            localCache.push(record);
            localStorage.setItem('bioguard_offline_cache', JSON.stringify(localCache));
            updateOfflineCacheBadge();
            writeConsoleLog(`Offline Cache: Telemetry disimpan di SQLite Lokal. Cache Count: ${localCache.length}`, "offline");
        }

        function batchUploadOfflineCache() {
            const cachedItems = [...localCache];
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            writeConsoleLog(`Jaringan Terhubung! Memulai Sinkronisasi Batch ${cachedItems.length} data telemetri dari SQLite Lokal...`, "info");
            
            const payload = {
                data: cachedItems
            };

            fetch('/api/demo/sync-telemetri', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify(payload)
            })
            .then(result => {
                if (result.success) {
                    // Check if route was rerouted by admin
                    if (result.is_rerouted && !activeReroutes[activeRouteId]) {
                        activeReroutes[activeRouteId] = true;
                        writeConsoleLog(`Pemberitahuan: Rute dialihkan oleh Admin via Musi IV Bypass.`, "info");
                        
                        const basePoints = alternativePaths[activeDestination];
                        if (basePoints) {
                            routeCoords = interpolateRoute(basePoints, 10);
                            if (currentRouteIndex >= routeCoords.length) {
                                currentRouteIndex = routeCoords.length - 1;
                            }
                            if (typeof polyline !== 'undefined' && typeof courierMarker !== 'undefined' && typeof destMarker !== 'undefined') {
                                polyline.setLatLngs(routeCoords);
                                courierMarker.setLatLng(routeCoords[currentRouteIndex]);
                                destMarker.setLatLng(routeCoords[routeCoords.length - 1]);
                                destMarker.bindPopup("<div class='text-xs font-bold text-slate-800 py-0.5'>" + activeDestination + " (Tujuan)</div>", { closeButton: false });
                            }
                        }
                    }
                    localCache = [];
                    localStorage.removeItem('bioguard_offline_cache');
                    updateOfflineCacheBadge();
                    writeConsoleLog(`Sinkronisasi Batch Sukses! Database SQLite Lokal dikosongkan.`, "success");
                } else {
                    throw new Error(result.message || "Server rejected batch sync request.");
                }
            })
            .catch(error => {
                writeConsoleLog(`Sinkronisasi batch gagal: ${error.message}. Data tetap disimpan di cache.`, "warn");
            });
        }

        function updateOfflineCacheBadge() {
            document.getElementById('local-cache-counter').innerText = localCache.length;
        }

        function clearLocalStorageCache() {
            localCache = [];
            localStorage.removeItem('bioguard_offline_cache');
            updateOfflineCacheBadge();
            writeConsoleLog("SQLite local database dikosongkan secara manual.", "info");
        }

        // --- 6. INTERACTIVE ROUTE MOVEMENT CONTROLS ---
        const moveBtn = document.getElementById('btn-move');
        
        moveBtn.addEventListener('click', () => {
            if (isMoving) {
                stopMovement();
            } else {
                startMovement();
            }
        });

        document.getElementById('btn-reset-route').addEventListener('click', () => {
            stopMovement();
            currentRouteIndex = 0;
            updateCourierPosition();
            writeConsoleLog("Posisi kurir di-reset ke Titik Awal (Jembatan Ampera).", "info");
        });

        function startMovement() {
            isMoving = true;
            moveBtn.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4 text-slate-950">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25v13.5m-7.5-13.5v13.5" />
                </svg>
                <span>HENTIKAN PERJALANAN</span>
            `;
            moveBtn.classList.replace('bg-teal-500', 'bg-amber-500');
            moveBtn.classList.replace('hover:bg-teal-600', 'hover:bg-amber-600');
            writeConsoleLog("Kurir mulai bergerak menuju RSUP Mohammad Hoesin...", "info");

            moveInterval = setInterval(() => {
                if (currentRouteIndex < routeCoords.length - 1) {
                    currentRouteIndex++;
                    updateCourierPosition();
                } else {
                    stopMovement();
                    writeConsoleLog("Kurir telah sampai di faskes tujuan!", "success");
                    checkGeofencingArrival();
                }
            }, 1000); // Progress position once per second
        }

        function stopMovement() {
            isMoving = false;
            if (moveInterval) {
                clearInterval(moveInterval);
                moveInterval = null;
            }
            moveBtn.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.347a1.125 1.125 0 0 1 0 1.972l-11.54 6.347a1.125 1.125 0 0 1-1.667-.986V5.653Z" />
                </svg>
                <span>MULAI BERGERAK</span>
            `;
            moveBtn.classList.replace('bg-amber-500', 'bg-teal-500');
            moveBtn.classList.replace('hover:bg-amber-600', 'hover:bg-teal-600');
            writeConsoleLog("Perjalanan kurir dihentikan sementara.", "info");
        }

        function updateCourierPosition() {
            const coord = routeCoords[currentRouteIndex];
            courierMarker.setLatLng(coord);
            map.panTo(coord);

            // Update details
            document.getElementById('pos-latlng').innerText = `${coord[0].toFixed(5)}, ${coord[1].toFixed(5)}`;
            document.getElementById('pos-index').innerText = `${currentRouteIndex} / ${routeCoords.length - 1}`;
        }

        function checkGeofencingArrival() {
            writeConsoleLog(`[GEOFENCING] Verifikasi radius lokasi: Kurir berada di faskes tujuan ${activeDestination}.`, 'info');
            
            fetch(`/api/route/${activeRouteId}/complete`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(result => {
                if (result.success) {
                    writeConsoleLog(`[GEOFENCING] Kargo Tiba Otomatis! Tanda terima digital dikirim. Status: Selesai.`, 'success');
                    alert(`[GEOFENCING DETECTED]\n\nKargo Boks ${activeBoxId} telah memasuki wilayah faskes ${activeDestination}.\nStatus perjalanan diperbarui ke SELESAI secara otomatis. Data log dikunci.`);
                } else {
                    writeConsoleLog(`[GEOFENCING] Gagal menyelesaikan rute: ${result.message}`, 'warn');
                }
            })
            .catch(err => {
                console.error('Error completing route via geofencing:', err);
            });
        }

        // --- 7. CONTROLLER PANEL INPUTS INTERFACE ---
        const tempSlider = document.getElementById('temp-slider');
        const tempBadge = document.getElementById('slider-temp-badge');
        const phoneTempDisplay = document.getElementById('telemetry-temp');

        tempSlider.addEventListener('input', (e) => {
            const val = parseFloat(e.target.value);
            setTemperatureValue(val);
        });

        function setTemperature(val) {
            tempSlider.value = val;
            setTemperatureValue(val);
        }

        function setTemperatureValue(val) {
            tempBadge.innerText = `${val.toFixed(1)}°C`;
            phoneTempDisplay.innerText = val.toFixed(1);
            evaluateTemperature(val);
        }

        function setVibrationPreset(val) {
            vibrationLevel = parseFloat(val);
            document.getElementById('vibration-badge').textContent = `${vibrationLevel.toFixed(2).replace('.', ',')}G`;
            writeConsoleLog(`Getaran disetel ke level normal: ${vibrationLevel}G`, 'info');
        }

        function triggerVibrationSpike() {
            vibrationLevel = parseFloat((1.5 + Math.random() * 1.2).toFixed(2));
            document.getElementById('vibration-badge').textContent = `${vibrationLevel.toFixed(2).replace('.', ',')}G`;
            writeConsoleLog(`Simulasi GUNCANGAN EKSTREM terdeteksi: ${vibrationLevel}G!`, "error");
            
            if (navigator.vibrate) {
                navigator.vibrate([200, 100, 200]);
            }
            
            const screen = document.getElementById('phone-screen');
            if (screen) {
                screen.classList.add('animate-shake');
                setTimeout(() => {
                    screen.classList.remove('animate-shake');
                }, 600);
            }
            
            // Sync immediately
            const latlng = courierMarker.getLatLng();
            uploadTelemetry({
                id_rute: parseInt(activeRouteId),
                timestamp: new Date().toISOString(),
                suhu_aktual: parseFloat(temperature),
                nilai_mkt: parseFloat((temperature * 1.05 + 0.1).toFixed(1)),
                latitude: parseFloat(latlng.lat),
                longitude: parseFloat(latlng.lng),
                is_synced_from_offline: !isOnline,
                gaya_guncangan: vibrationLevel
            });
        }

        // Network simulator configuration
        const netOnlineBtn = document.getElementById('btn-net-online');
        const netOfflineBtn = document.getElementById('btn-net-offline');
        const connBadge = document.getElementById('conn-badge');
        const wifiIcon = document.getElementById('wifi-icon');

        netOnlineBtn.addEventListener('click', () => {
            isOnline = true;
            netOnlineBtn.className = "flex-1 py-1.5 bg-teal-500/15 border border-teal-500/30 text-teal-400 font-bold text-xs rounded-lg active:scale-95 transition";
            netOfflineBtn.className = "flex-1 py-1.5 bg-slate-800 border border-white/5 text-slate-400 font-semibold text-xs rounded-lg active:scale-95 transition";
            connBadge.innerText = "Online";
            connBadge.className = "px-2.5 py-0.5 text-[10px] font-bold rounded bg-teal-500/10 text-teal-400 border border-teal-500/20 uppercase";
            wifiIcon.className = "text-teal-400";
            writeConsoleLog("Koneksi Internet Dipulihkan (Status: ONLINE).", "info");
            
            if (localCache.length > 0) {
                batchUploadOfflineCache();
            }
        });

        netOfflineBtn.addEventListener('click', () => {
            isOnline = false;
            netOfflineBtn.className = "flex-1 py-1.5 bg-rose-500/15 border border-rose-500/30 text-rose-400 font-bold text-xs rounded-lg active:scale-95 transition";
            netOnlineBtn.className = "flex-1 py-1.5 bg-slate-800 border border-white/5 text-slate-400 font-semibold text-xs rounded-lg active:scale-95 transition";
            connBadge.innerText = "Offline";
            connBadge.className = "px-2.5 py-0.5 text-[10px] font-bold rounded bg-rose-500/10 text-rose-400 border border-rose-500/20 uppercase";
            wifiIcon.className = "text-slate-500";
            writeConsoleLog("Koneksi Internet Terputus (Status: OFFLINE / Blank Spot).", "warn");
        });

        // Dismiss Red Alert button handler
        document.getElementById('btn-dismiss-alert').addEventListener('click', () => {
            setTemperature(4.5); // Reset back to a safe range
            writeConsoleLog("Kargo dikarantina secara manual, alarm dinonaktifkan.", "info");
        });

        // SOS Button triggers Laravel route POST
        document.getElementById('sos-button').addEventListener('click', () => {
            const latlng = courierMarker.getLatLng();
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            const incidentType = confirm("Laporkan SOS Darurat? klik OK untuk 'Boks Bocor', Cancel untuk 'Kemacetan Ekstrem'") 
                ? 'Boks Bocor' 
                : 'Kemacetan Ekstrem';

            writeConsoleLog(`TOMBOL SOS DITEKAN! Mengirim sinyal darurat: ${incidentType}...`, "error");
            
            fetch('/api/simulasi/sos', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    id_rute: activeRouteId,
                    jenis_insiden: incidentType,
                    deskripsi: `Kurir melaporkan kejadian ${incidentType} di koordinat ${latlng.lat.toFixed(5)}, ${latlng.lng.toFixed(5)}`,
                    suhu_tercatat: temperature
                })
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    writeConsoleLog(`POST /api/simulasi/sos - SOS Berhasil Dikirim ke Web Admin!`, "success");
                    alert(`SOS Dikirim! Sinyal darurat ${incidentType} didaftarkan pada sistem admin.`);
                } else {
                    throw new Error(result.message || `HTTP ${response.status}`);
                }
            })
            .catch(error => {
                writeConsoleLog(`POST /api/simulasi/sos - Sinyal dikirim via HTTP (Gagal: ${error.message}). Simulator memproses SOS secara lokal.`, "warn");
                alert("SOS Dipicu secara lokal. Sistem darurat mencatat log kemacetan.");
            });
        });

        // --- 8. SMARTPHONE TABS NAVIGATION MANAGEMENT ---
        const btnTabMap = document.getElementById('btn-tab-map');
        const btnTabBle = document.getElementById('btn-tab-ble');
        const btnTabProfile = document.getElementById('btn-tab-profile');

        const tabMapContent = document.getElementById('tab-map-content');
        const tabBleContent = document.getElementById('tab-ble-content');
        const tabProfileContent = document.getElementById('tab-profile-content');

        function selectTab(selectedBtn, contentShow) {
            // Reset colors
            [btnTabMap, btnTabBle, btnTabProfile].forEach(btn => {
                btn.className = "flex flex-col items-center space-y-1 text-slate-400 hover:text-slate-200 focus:outline-none transition-colors duration-200";
            });
            // Highlight selected
            selectedBtn.className = "flex flex-col items-center space-y-1 text-teal-400 focus:outline-none transition-colors duration-200";

            // Toggle screens
            [tabMapContent, tabBleContent, tabProfileContent].forEach(content => {
                content.classList.add('hidden');
            });
            contentShow.classList.remove('hidden');

            // Force map update if switching to map tab
            if (contentShow === tabMapContent) {
                setTimeout(() => {
                    map.invalidateSize();
                }, 50);
            }
        }

        btnTabMap.addEventListener('click', () => selectTab(btnTabMap, tabMapContent));
        btnTabBle.addEventListener('click', () => selectTab(btnTabBle, tabBleContent));
        btnTabProfile.addEventListener('click', () => selectTab(btnTabProfile, tabProfileContent));

        // --- 9. THEME TOGGLE MANAGEMENT ---
        const themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
        const themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');
        const themeToggleBtn = document.getElementById('theme-toggle');

        // Initial icon state
        if (document.documentElement.classList.contains('dark')) {
            themeToggleLightIcon.classList.remove('hidden');
        } else {
            themeToggleDarkIcon.classList.remove('hidden');
        }

        themeToggleBtn.addEventListener('click', function() {
            // toggle icons
            themeToggleDarkIcon.classList.toggle('hidden');
            themeToggleLightIcon.classList.toggle('hidden');

            // if is dark mode
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('color-theme', 'light');
            } else {
                document.documentElement.classList.add('dark');
                localStorage.setItem('color-theme', 'dark');
            }
        });

        // --- 9. TERMINAL CONSOLE LOG HELPER ---
        const consoleEl = document.getElementById('log-console');
        
        function writeConsoleLog(message, type = "info") {
            const timeStr = new Date().toLocaleTimeString();
            let textClass = "text-slate-400";
            
            if (type === "success") textClass = "text-emerald-400 font-semibold";
            else if (type === "warn") textClass = "text-amber-400";
            else if (type === "error") textClass = "text-rose-500 font-bold";
            else if (type === "offline") textClass = "text-indigo-400";
            
            consoleEl.innerHTML += `<div class="${textClass}">[${timeStr}] ${message}</div>`;
            consoleEl.scrollTop = consoleEl.scrollHeight;
        }

        function clearLogs() {
            consoleEl.innerHTML = `<div class="text-slate-500">[${new Date().toLocaleTimeString()}] Log console dibersihkan.</div>`;
        }

        // Live Clock overlay on phone top bar
        function updateClock() {
            const now = new Date();
            const hh = String(now.getHours()).padStart(2, '0');
            const mm = String(now.getMinutes()).padStart(2, '0');
            document.getElementById('phone-clock').innerText = `${hh}:${mm}`;
        }
        setInterval(updateClock, 1000);
        updateClock();

        // Battery oscillation simulation
        setInterval(() => {
            let batt = parseInt(document.getElementById('esp32-battery-text').innerText);
            if (batt > 20) {
                batt -= Math.floor(Math.random() * 2) === 0 ? 1 : 0;
            } else {
                batt = 98; // Recharge cycle simulation
            }
            document.getElementById('esp32-battery-text').innerText = `${batt}%`;
            document.getElementById('esp32-battery-bar').style.width = `${batt}%`;
        }, 12000);

    </script>
</body>
</html>
