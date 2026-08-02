<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BIO-GUARD | Rantai Dingin Medis Cerdas</title>

    {{-- Inline script to apply theme immediately --}}
    <script>
        const savedTheme = localStorage.getItem('theme') || 'dark';
        if (savedTheme === 'dark') {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    {{-- Tailwind CSS & Plugins from CDN --}}
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>

    {{-- Fonts & Icons --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;850&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">

    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#3b82f6",
                        "primary-container": "#2563eb",
                        "surface": "#081425",
                        "surface-container": "#152031",
                        "on-surface": "#d8e3fb",
                        "on-surface-variant": "#bcc9cd",
                        "error": "#ffb4ab",
                    }
                }
            }
        }
    </script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: radial-gradient(circle at top right, #f8fafc, #e2e8f0);
            color: #0f172a;
            transition: background 0.3s ease, color 0.3s ease;
        }
        .dark body {
            background: radial-gradient(circle at top right, #0d1e36, #040e1f);
            color: #e2e8f0;
        }
        @keyframes float-blob {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.95); }
        }
        .animate-blob {
            animation: float-blob 25s infinite ease-in-out;
        }
        @keyframes custom-float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        .animate-mascot-float {
            animation: custom-float 4s infinite ease-in-out;
        }
    </style>
</head>
<body class="min-h-screen text-on-surface antialiased relative overflow-x-hidden bg-slate-50 dark:bg-slate-950">

    

    {{-- Canvas Partikel Melayang (IoT Constellation) --}}
    <canvas id="canvas-particles" class="fixed inset-0 w-full h-full pointer-events-none z-0 opacity-50"></canvas>

    {{-- Floating Decorative Mesh Blobs --}}
    <div class="fixed top-1/4 left-1/4 w-[500px] h-[500px] rounded-full bg-blue-500/10 dark:bg-blue-500/5 blur-[130px] pointer-events-none animate-blob z-0"></div>
    <div class="fixed bottom-1/4 right-1/4 w-[600px] h-[600px] rounded-full bg-blue-400/10 dark:bg-blue-400/5 blur-[140px] pointer-events-none animate-blob z-0" style="animation-delay: -5s;"></div>
    <div class="fixed top-1/2 left-2/3 w-[450px] h-[450px] rounded-full bg-indigo-500/10 dark:bg-indigo-500/5 blur-[110px] pointer-events-none animate-blob z-0" style="animation-delay: -10s;"></div>

    {{-- Floating Header Navbar --}}
    <header class="fixed top-6 left-1/2 -translate-x-1/2 z-50 w-[95%] max-w-7xl bg-white/40 dark:bg-slate-900/40 backdrop-blur-xl border border-white/50 dark:border-white/10 rounded-full px-4 md:px-6 py-3 flex items-center justify-between shadow-xl transition-colors">
        <div class="flex items-center justify-between w-full">
            <a href="#" class="flex items-center gap-2.5 select-none hover:opacity-90 transition-opacity">
                <img src="{{ asset('images/logo.png') }}?v=8" alt="BIO-GUARD Logo" class="h-8 md:h-10 w-auto object-contain transition-transform group-hover:scale-105">
                <span class="text-sm font-black tracking-wider text-slate-900 dark:text-white">BIO-GUARD</span>
            </a>

            <nav class="hidden lg:flex items-center gap-6 text-[13px] font-semibold text-slate-700 dark:text-slate-300">
                <a href="#about" class="hover:text-blue-500 dark:hover:text-blue-400 transition-colors">Tentang Kami</a>
                <a href="#logo-meaning" class="hover:text-blue-500 dark:hover:text-blue-400 transition-colors">Filosofi Logo</a>
                <a href="#mascot" class="hover:text-blue-500 dark:hover:text-blue-400 transition-colors">Filosofi Maskot</a>
                <a href="#vision-mission" class="hover:text-blue-500 dark:hover:text-blue-400 transition-colors">Visi & Misi</a>
                <a href="{{ route('simulator.standalone') }}" target="_blank" class="hover:text-blue-500 dark:hover:text-blue-400 transition-colors flex items-center gap-1">
                    <span class="material-symbols-outlined text-[14px]">devices</span> Simulator
                </a>
            </nav>

            <div class="flex items-center gap-2 md:gap-3">
                {{-- Theme Switcher Button --}}
                <button id="theme-toggle" class="w-8 h-8 rounded-full bg-white/50 dark:bg-slate-800/50 hover:bg-white/80 dark:hover:bg-slate-700/50 border border-white/60 dark:border-white/10 text-slate-700 dark:text-slate-300 transition-colors flex items-center justify-center shadow-sm">
                    <span id="theme-toggle-icon" class="material-symbols-outlined text-[16px]">dark_mode</span>
                </button>
                
                {{-- Download APK Button in Header --}}
                <a href="/bio-guard.apk" download class="hidden sm:flex items-center justify-center px-4 py-2 border border-white/60 dark:border-white/10 bg-white/30 dark:bg-slate-800/30 hover:bg-white/60 dark:hover:bg-slate-700/50 text-slate-700 dark:text-slate-200 text-[11px] font-bold rounded-full transition-all shadow-sm">
                    Unduh APK
                </a>

                {{-- Portal Login Button --}}
                <a href="{{ route('login') }}" 
                   class="px-4 md:px-5 py-2 bg-gradient-to-r from-blue-600/90 to-blue-500/90 hover:from-blue-600 hover:to-blue-500 text-white text-[10px] md:text-[11px] font-black tracking-wider uppercase rounded-full shadow-md hover:shadow-lg active:scale-[0.98] transition-all border border-white/20">
                    Masuk Portal
                </a>
            </div>
        </div>
    </header>

    {{-- Main Content --}}
    <main class="relative z-10 w-full flex flex-col pt-24 md:pt-32">

        {{-- Hero Section --}}
        <section id="about" class="relative w-full py-20 lg:py-32">
            <div class="absolute inset-0 z-0">
                <img src="{{ asset('images/bg_medical_1.png') }}" class="w-full h-full object-cover opacity-20 dark:opacity-[0.15]" alt="Hero Background">
                <div class="absolute inset-0 bg-slate-50/80 dark:bg-slate-950/85 backdrop-blur-[2px]"></div>
                <div class="absolute bottom-0 left-0 w-full h-24 bg-gradient-to-t from-slate-50 dark:from-slate-950 to-transparent"></div>
            </div>
            <div class="relative z-10 max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-8 items-center min-h-[70vh]">
            <div class="lg:col-span-7 space-y-6">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-black tracking-tight leading-tight text-slate-900 dark:text-white drop-shadow-sm">
                    Pusat Kendali Distribusi <br>
                    & <span class="text-blue-500 dark:text-blue-400">Pemantauan Rantai <br> Dingin</span> Cerdas
                </h1>
                <p class="text-base text-slate-700 dark:text-slate-300 max-w-2xl leading-relaxed drop-shadow-sm font-medium">
                    Dengan mengintegrasikan IoT Edge Computing dan Machine Learning, Bio-Guard menghadirkan pemantauan real-time terhadap fluktuasi suhu kritis, penyimpangan rute, dan getaran logistik obat termolabil. Sistem ini dirancang khusus untuk menjaga integritas kargo termolabil demi memastikan keselamatan pasien di seluruh Indonesia.
                </p>
                <div class="flex flex-wrap items-center gap-4 pt-2">
                    <a href="{{ route('login') }}" 
                       class="px-6 py-3 rounded-full bg-blue-600/90 dark:bg-blue-500/90 hover:bg-blue-600 dark:hover:bg-blue-500 text-white text-sm font-bold shadow-[0_0_20px_rgba(37,99,235,0.4)] transition-all flex items-center gap-2 border border-blue-500/50 backdrop-blur-md hover:-translate-y-0.5">
                        <span class="material-symbols-outlined text-[20px]">login</span> Masuk ke Portal Admin
                    </a>
                    <a href="/bio-guard.apk" download
                       class="px-6 py-3 rounded-full bg-slate-900/80 dark:bg-slate-800/80 hover:bg-slate-900 dark:hover:bg-slate-700 text-white text-sm font-bold shadow-lg transition-all flex items-center gap-2 border border-slate-700/50 backdrop-blur-md hover:-translate-y-0.5">
                        <span class="material-symbols-outlined text-[20px]">download</span> Unduh Aplikasi (APK)
                    </a>
                </div>
            </div>

            {{-- Feature Showcase Glass Card (The Masterpiece) --}}
            <div class="lg:col-span-5 flex justify-center lg:justify-end">
                <div class="relative w-full max-w-md bg-white/95 dark:bg-[#0d1b2e] rounded-3xl border border-blue-500/15 dark:border-blue-500/20 shadow-xl dark:shadow-[0_0_30px_rgba(33,150,243,0.15)] overflow-hidden flex flex-col group transition-all duration-500 hover:-translate-y-2">
                    
                    {{-- Top Header (Gradient) --}}
                    <div class="px-5 py-4 bg-gradient-to-r from-[#1565c0] to-[#0288d1] dark:from-[#0a2a5e] dark:to-[#0d3a70] border-b border-transparent dark:border-blue-500/30 flex justify-between items-center z-20 shadow-sm">
                        <div class="flex items-center gap-2.5">
                            <img src="{{ asset('images/logo_shield.png') }}?v=6" alt="BIO-GUARD Shield" class="w-7 h-7 object-contain drop-shadow-[0_0_8px_rgba(255,255,255,0.8)] dark:drop-shadow-[0_0_10px_rgba(76,213,246,0.8)]">
                            <div class="flex flex-col">
                                <span class="text-white font-extrabold text-[13px] tracking-widest leading-none">BIO-GUARD</span>
                                <span class="text-white/80 dark:text-cyan-400/80 font-semibold text-[8px] tracking-[0.15em] leading-tight mt-0.5">SISTEM MONITORING</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-white/20 dark:bg-white/10 backdrop-blur-md border border-white/30 dark:border-white/10 shadow-sm">
                            <span class="w-1.5 h-1.5 rounded-full bg-[#69f0ae] animate-pulse shadow-[0_0_8px_#69f0ae]"></span>
                            <span class="text-white font-bold text-[9px] tracking-wider">LIVE</span>
                        </div>
                    </div>

                    {{-- Card Body --}}
                    <div class="p-5 flex flex-col flex-grow relative z-10">
                        
                        {{-- Title & Subtitle --}}
                        <div class="mb-4">
                            <h3 class="text-[#1565c0] dark:text-[#64b5f6] text-lg font-black tracking-tight">Monitoring Suhu Real-Time</h3>
                            <p class="text-slate-500 dark:text-slate-400 text-xs font-semibold">Rantai dingin obat termolabil â€” sensor aktif</p>
                        </div>

                        {{-- Legend Row --}}
                        <div class="flex items-center gap-4 mb-4 text-[9px] font-bold text-slate-600 dark:text-slate-300">
                            <div class="flex items-center gap-1.5"><div class="w-3 h-[2px] bg-[#1e88e5]"></div> Suhu Aktual</div>
                            <div class="flex items-center gap-1.5"><div class="w-3 h-[2px] bg-[#ef5350] border-t border-dashed border-[#ef5350]"></div> Batas Atas 8°C</div>
                            <div class="flex items-center gap-1.5"><div class="w-3 h-[2px] border-t border-dashed border-blue-400 dark:border-cyan-400"></div> Batas Bawah 2°C</div>
                        </div>

                        {{-- Main Graphic Chart Area --}}
                        <div class="relative w-full h-32 mb-4 bg-slate-50/50 dark:bg-transparent rounded-xl border border-slate-100 dark:border-transparent overflow-hidden">
                            {{-- Chart Grid --}}
                            <div class="absolute inset-0 flex flex-col justify-between py-2 px-1">
                                <div class="flex items-center gap-2 w-full"><span class="text-[8px] text-slate-400 dark:text-slate-500 font-mono w-5 text-right">10°</span><div class="flex-1 h-[1px] bg-slate-200 dark:bg-slate-700/50"></div></div>
                                <div class="flex items-center gap-2 w-full"><span class="text-[8px] text-[#ef5350] font-bold font-mono w-5 text-right">8°</span><div class="flex-1 h-[1px] border-t border-dashed border-[#ef5350]/60"></div></div>
                                <div class="flex items-center gap-2 w-full"><span class="text-[8px] text-slate-400 dark:text-slate-500 font-mono w-5 text-right">5°</span><div class="flex-1 h-[1px] bg-slate-200 dark:bg-slate-700/50"></div></div>
                                <div class="flex items-center gap-2 w-full"><span class="text-[8px] text-blue-500 dark:text-cyan-500 font-bold font-mono w-5 text-right">2°</span><div class="flex-1 h-[1px] border-t border-dashed border-blue-400/60 dark:border-cyan-400/60"></div></div>
                                <div class="flex items-center gap-2 w-full"><span class="text-[8px] text-slate-400 dark:text-slate-500 font-mono w-5 text-right">0°</span><div class="flex-1 h-[1px] bg-slate-200 dark:bg-slate-700/50"></div></div>
                            </div>
                            
                            {{-- SVG Line Graph with Area Fill --}}
                            <svg class="absolute inset-0 w-full h-full drop-shadow-[0_0_8px_rgba(30,136,229,0.5)] dark:drop-shadow-[0_0_10px_rgba(30,136,229,0.8)] pl-6" preserveAspectRatio="none" viewBox="0 0 100 100">
                                <defs>
                                    <linearGradient id="chartGlow" x1="0" y1="0" x2="0" y2="1">
                                        <stop offset="0%" stop-color="#1e88e5" stop-opacity="0.3" />
                                        <stop offset="100%" stop-color="#1e88e5" stop-opacity="0.01" />
                                    </linearGradient>
                                </defs>
                                <!-- Area Fill -->
                                <path d="M0,80 Q10,60 20,70 T40,40 T60,65 T75,25 T90,15 T100,5 L100,100 L0,100 Z" fill="url(#chartGlow)" />
                                
                                <!-- Main Blue Line -->
                                <path id="live-chart-line" d="M0,58 Q15,75 30,75 T60,41 T75,23 T85,50 T100,55" fill="none" stroke="#1e88e5" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                                
                                <!-- Highlight the red segment (temp > 8C, which is roughly Y < 33 on this scale) -->
                                <path d="M71,28 Q75,23 79,28" fill="none" stroke="#ef5350" stroke-width="2.5" stroke-linecap="round" />
                                
                                <!-- Data points -->
                                <circle cx="30" cy="75" r="2.5" fill="#1e88e5" stroke="white" stroke-width="1.5" />
                                <circle cx="75" cy="23" r="3.5" fill="#ef5350" stroke="white" stroke-width="1.5" class="animate-pulse shadow-[0_0_10px_#ef5350]" />
                                <circle cx="100" cy="55" r="2.5" fill="#1e88e5" stroke="white" stroke-width="1.5" />
                            </svg>
                        </div>

                        {{-- Below Chart: 3 Stat Tiles --}}
                        <div class="grid grid-cols-3 gap-2 mb-4">
                            <div class="bg-[#f0f7ff] dark:bg-[#0a1e38] rounded-xl p-2.5 flex flex-col items-center justify-center border border-blue-100 dark:border-blue-900/30">
                                <span class="text-[9px] text-slate-500 dark:text-slate-400 font-bold uppercase tracking-wider mb-0.5">Saat Ini</span>
                                <span id="live-current-temp" class="text-base font-black text-[#1565c0] dark:text-[#42a5f5]">5.4°C</span>
                            </div>
                            <div class="bg-[#f0f7ff] dark:bg-[#0a1e38] rounded-xl p-2.5 flex flex-col items-center justify-center border border-blue-100 dark:border-blue-900/30">
                                <span class="text-[9px] text-slate-500 dark:text-slate-400 font-bold uppercase tracking-wider mb-0.5">Min</span>
                                <span id="live-min-temp" class="text-base font-black text-[#1565c0] dark:text-[#42a5f5]">2.3°C</span>
                            </div>
                            <div class="bg-[#fff3f3] dark:bg-[#2c1318] rounded-xl p-2.5 flex flex-col items-center justify-center border border-red-100 dark:border-red-900/30">
                                <span class="text-[9px] text-red-500 dark:text-red-400 font-bold uppercase tracking-wider mb-0.5">Max</span>
                                <span class="text-base font-black text-[#ef5350] dark:text-[#ef5350] flex items-center gap-0.5">
                                    <span id="live-max-temp">9.2°C</span> <span class="material-symbols-outlined text-[12px] text-[#ef5350]">warning</span>
                                </span>
                            </div>
                        </div>
                        
                        {{-- Bottom Row: 3 Badges --}}
                        <div class="flex justify-between items-center pt-2 mt-auto">
                            <div class="flex gap-1.5">
                                <div class="px-2 py-1 rounded-lg bg-[#e8f5e9] dark:bg-[#0d2a1c] border border-green-200 dark:border-green-800/50 flex items-center gap-1 shadow-sm dark:shadow-[0_0_8px_rgba(105,240,174,0.15)]">
                                    <span class="material-symbols-outlined text-[11px] text-[#2e7d32] dark:text-[#69f0ae]">wifi</span>
                                    <span class="text-[8px] font-bold text-[#2e7d32] dark:text-[#69f0ae] tracking-wide">IoT Online</span>
                                </div>
                                <div class="px-2 py-1 rounded-lg bg-[#e8f5e9] dark:bg-[#0d2a1c] border border-green-200 dark:border-green-800/50 flex items-center gap-1 shadow-sm dark:shadow-[0_0_8px_rgba(105,240,174,0.15)]">
                                    <span class="material-symbols-outlined text-[11px] text-[#2e7d32] dark:text-[#69f0ae]">memory</span>
                                    <span class="text-[8px] font-bold text-[#2e7d32] dark:text-[#69f0ae] tracking-wide">AI Prediction</span>
                                </div>
                            </div>
                            <div class="px-2 py-1 rounded-lg bg-[#e3f2fd] dark:bg-[#0a2342] border border-blue-200 dark:border-blue-800/50 flex items-center gap-1 shadow-sm dark:shadow-[0_0_8px_rgba(66,165,245,0.15)]">
                                <span class="material-symbols-outlined text-[11px] text-[#1565c0] dark:text-[#42a5f5]">verified</span>
                                <span class="text-[8px] font-bold text-[#1565c0] dark:text-[#42a5f5] tracking-wide">CDOB Certified</span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>

        {{-- Logo Philosophy Section --}}
        <section id="logo-meaning" class="relative w-full py-24 border-t border-slate-200 dark:border-slate-800/50">
            <div class="absolute inset-0 z-0">
                <img src="{{ asset('images/bg_medical_2.png') }}" class="w-full h-full object-cover opacity-[0.08] dark:opacity-10" alt="Section Background">
                <div class="absolute inset-0 bg-white/90 dark:bg-slate-900/90 backdrop-blur-[3px]"></div>
            </div>
            <div class="relative z-10 max-w-7xl mx-auto px-6 space-y-10">
            <div class="text-center space-y-2">
                <span class="text-xs font-black text-primary tracking-widest uppercase">Identitas Visual</span>
                <h2 class="text-3xl font-black text-slate-900 dark:text-white">Decoding Our Symbols</h2>
                <p class="text-sm text-slate-600 dark:text-slate-350 max-w-xl mx-auto">Kisah dan makna ilmiah di balik pembuatan logo resmi Bio-Guard.</p>
            </div>

            {{-- Responsive Image and Cards Split --}}
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
                
                {{-- Left Side: Premium Interactive Emblem --}}
                <div class="lg:col-span-6 flex items-center justify-center p-8 bg-white/60 dark:bg-slate-900/30 border border-slate-200/60 dark:border-slate-800/80 rounded-3xl min-h-[400px] relative overflow-hidden shadow-xl group">
                    {{-- Glowing ring behind logo --}}
                    <div class="absolute w-72 h-72 rounded-full border border-primary/20 dark:border-primary/10 animate-[spin_20s_linear_infinite] pointer-events-none"></div>
                    <div class="absolute w-80 h-80 rounded-full border border-dashed border-blue-500/20 dark:border-blue-500/10 animate-[spin_30s_linear_infinite] pointer-events-none" style="animation-direction: reverse;"></div>
                    <div class="absolute w-48 h-48 bg-primary/10 rounded-full blur-3xl pointer-events-none"></div>

                    <div class="relative z-10 flex flex-col items-center">
                        <div class="relative w-64 h-64 flex items-center justify-center bg-transparent border-none overflow-visible">
                            <img src="{{ asset('images/logo_shield.png') }}?v=6" alt="BIO-GUARD Logo Shield" 
                                 class="w-full h-full object-contain select-none animate-mascot-float dark:drop-shadow-[0_0_25px_rgba(76,213,246,0.5)]">
                        </div>
                        
                        {{-- Subtle logo badge --}}
                        <div class="mt-6 px-4 py-1.5 rounded-full bg-primary/10 border border-primary/20 text-primary text-xs font-bold uppercase tracking-wider select-none shadow-sm">
                            Identitas Visual Bio-Guard
                        </div>
                    </div>
                </div>

                {{-- Right Side: Card Explanations --}}
                <div class="lg:col-span-6 space-y-4">
                    {{-- Card 1 --}}
                    <div class="flex items-start gap-4 p-4 rounded-2xl bg-white/60 dark:bg-slate-900/30 border border-slate-200/60 dark:border-slate-800/80 hover:border-primary/40 transition-all duration-300 group">
                        <div class="w-16 h-16 bg-transparent flex items-center justify-center shrink-0 mt-0.5 group-hover:scale-110 transition-transform overflow-visible">
                            <img src="{{ asset('images/shield_logo.png') }}?v=6" alt="Shield Icon" class="w-full h-full object-contain dark:drop-shadow-[0_0_12px_rgba(76,213,246,0.6)]">
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-slate-900 dark:text-white">The Shield (Perisai)</h4>
                            <p class="text-xs text-slate-600 dark:text-slate-350 mt-1 leading-relaxed">Mewakili perlindungan mutlak terhadap integritas jejak audit digital dan keamanan fisik obat termolabil dari risiko kerusakan selama perjalanan.</p>
                        </div>
                    </div>

                    {{-- Card 2 --}}
                    <div class="flex items-start gap-4 p-4 rounded-2xl bg-white/60 dark:bg-slate-900/30 border border-slate-200/60 dark:border-slate-800/80 hover:border-primary/40 transition-all duration-300 group">
                        <div class="w-16 h-16 bg-transparent flex items-center justify-center shrink-0 mt-0.5 group-hover:scale-110 transition-transform overflow-visible">
                            <img src="{{ asset('images/snowflake.png') }}?v=6" alt="Snowflake Icon" class="w-full h-full object-contain dark:drop-shadow-[0_0_12px_rgba(76,213,246,0.6)]">
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-slate-900 dark:text-white">The Snowflake (Kepingan Salju)</h4>
                            <p class="text-xs text-slate-600 dark:text-slate-350 mt-1 leading-relaxed">Menegaskan fokus sistem dalam menjaga ambang batas suhu kritis 2°C - 8°C agar struktur protein obat dan vaksin tetap utuh dan layak pakai.</p>
                        </div>
                    </div>

                    {{-- Card 3 --}}
                    <div class="flex items-start gap-4 p-4 rounded-2xl bg-white/60 dark:bg-slate-900/30 border border-slate-200/60 dark:border-slate-800/80 hover:border-primary/40 transition-all duration-300 group">
                        <div class="w-16 h-16 bg-transparent flex items-center justify-center shrink-0 mt-0.5 group-hover:scale-110 transition-transform overflow-visible">
                            <img src="{{ asset('images/circuit.png') }}?v=6" alt="Circuit Icon" class="w-full h-full object-contain dark:drop-shadow-[0_0_12px_rgba(76,213,246,0.6)]">
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-slate-900 dark:text-white">Circuit Lines (Jalur Sirkuit)</h4>
                            <p class="text-xs text-slate-600 dark:text-slate-350 mt-1 leading-relaxed">Menyimpulkan komputasi cerdas di dalam chip yang mampu memprediksi risiko secara real-time tanpa jeda peladen.</p>
                        </div>
                    </div>

                    {{-- Card 4 --}}
                    <div class="flex items-start gap-4 p-4 rounded-2xl bg-white/60 dark:bg-slate-900/30 border border-slate-200/60 dark:border-slate-800/80 hover:border-primary/40 transition-all duration-300 group">
                        <div class="w-16 h-16 bg-transparent flex items-center justify-center shrink-0 mt-0.5 group-hover:scale-110 transition-transform overflow-visible">
                            <img src="{{ asset('images/waves_logo.png') }}?v=6" alt="Waves Icon" class="w-full h-full object-contain dark:drop-shadow-[0_0_12px_rgba(76,213,246,0.6)]">
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-slate-900 dark:text-white">Dynamic Waves (Gelombang Dinamis)</h4>
                            <p class="text-xs text-slate-600 dark:text-slate-350 mt-1 leading-relaxed">Visualisasi dari arsitektur Offline-First yang kebal terhadap blank spot jaringan, serta pergerakan dinamis armada kurir di lapangan.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Mascot Philosophy Section --}}
        <section id="mascot" class="relative w-full py-24 border-t border-slate-200 dark:border-slate-800/50">
            <div class="absolute inset-0 z-0">
                <img src="https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?q=80&w=2070&auto=format&fit=crop" class="w-full h-full object-cover opacity-[0.08] dark:opacity-10" alt="Section Background">
                <div class="absolute inset-0 bg-slate-50/90 dark:bg-slate-950/90 backdrop-blur-[3px]"></div>
            </div>
            <div class="relative z-10 max-w-7xl mx-auto px-6 space-y-10">
            <div class="text-center space-y-2">
                <span class="text-xs font-black text-primary tracking-widest uppercase">Mascot Resmi</span>
                <h2 class="text-3xl font-black text-slate-900 dark:text-white">Meet Our Mascot!</h2>
                <p class="text-sm text-slate-600 dark:text-slate-350 max-w-xl mx-auto">Kenalkan Peggi, Si Penguin Penjaga Cerdas Rantai Dingin Medis Masa Depan.</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
                
                {{-- Left Side: Card Explanations --}}
                <div class="lg:col-span-6 space-y-4 order-2 lg:order-1">
                    {{-- Card 1 --}}
                    <div class="flex items-start gap-4 p-4 rounded-2xl bg-white/60 dark:bg-slate-900/30 border border-slate-200/60 dark:border-slate-800/80 hover:border-primary/40 transition-all duration-300 group">
                        <div class="w-16 h-16 bg-transparent flex items-center justify-center shrink-0 mt-0.5 group-hover:scale-110 transition-transform overflow-visible">
                            <img src="{{ asset('images/penguin_happy.png') }}?v=6" alt="Penguin Icon" class="w-full h-full object-contain dark:drop-shadow-[0_0_15px_rgba(255,255,255,0.4)]">
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-slate-900 dark:text-white">The Penguin (Penguin)</h4>
                            <p class="text-xs text-slate-600 dark:text-slate-350 mt-1 leading-relaxed">Simbol ketahanan luar biasa di kondisi dingin ekstrem. Merepresentasikan komitmen Bio-Guard dalam menjaga stabilitas kargo logistik.</p>
                        </div>
                    </div>

                    {{-- Card 2 --}}
                    <div class="flex items-start gap-4 p-4 rounded-2xl bg-white/60 dark:bg-slate-900/30 border border-slate-200/60 dark:border-slate-800/80 hover:border-primary/40 transition-all duration-300 group">
                        <div class="w-16 h-16 bg-transparent flex items-center justify-center shrink-0 mt-0.5 group-hover:scale-110 transition-transform overflow-visible">
                            <img src="{{ asset('images/glasses.png') }}?v=6" alt="Goggles Icon" class="w-full h-full object-contain dark:drop-shadow-[0_0_15px_rgba(255,255,255,0.4)]">
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-slate-900 dark:text-white">The Edge-Vision Goggles</h4>
                            <p class="text-xs text-slate-600 dark:text-slate-350 mt-1 leading-relaxed">Melambangkan komputasi cerdas Edge Computing dan AI yang mampu menganalisis data serta memprediksi risiko anomali suhu sebelum kerusakan terjadi.</p>
                        </div>
                    </div>

                    {{-- Card 3 --}}
                    <div class="flex items-start gap-4 p-4 rounded-2xl bg-white/60 dark:bg-slate-900/30 border border-slate-200/60 dark:border-slate-800/80 hover:border-primary/40 transition-all duration-300 group">
                        <div class="w-16 h-16 bg-transparent flex items-center justify-center shrink-0 mt-0.5 group-hover:scale-110 transition-transform overflow-visible">
                            <img src="{{ asset('images/vest.png') }}?v=6" alt="Vest Icon" class="w-full h-full object-contain dark:drop-shadow-[0_0_15px_rgba(255,255,255,0.4)]">
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-slate-900 dark:text-white">The Bio-Armor Vest</h4>
                            <p class="text-xs text-slate-600 dark:text-slate-350 mt-1 leading-relaxed">Seragam pelindung andalan yang menyimbolkan jaminan mutu dan kepatuhan absolut terhadap standar ketat CDOB BPOM RI.</p>
                        </div>
                    </div>

                    {{-- Card 4 --}}
                    <div class="flex items-start gap-4 p-4 rounded-2xl bg-white/60 dark:bg-slate-900/30 border border-slate-200/60 dark:border-slate-800/80 hover:border-primary/40 transition-all duration-300 group">
                        <div class="w-16 h-16 bg-transparent flex items-center justify-center shrink-0 mt-0.5 group-hover:scale-110 transition-transform overflow-visible">
                            <img src="{{ asset('images/tablet.png') }}?v=6" alt="Tablet Icon" class="w-full h-full object-contain dark:drop-shadow-[0_0_15px_rgba(255,255,255,0.4)]">
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-slate-900 dark:text-white">The Nexus Command Pad</h4>
                            <p class="text-xs text-slate-600 dark:text-slate-350 mt-1 leading-relaxed">Mewakili integrasi dasbor web dan aplikasi mobile cerdas yang memastikan sinkronisasi data telemetri tetap berjalan mulus.</p>
                        </div>
                    </div>
                </div>

                {{-- Right Side: Premium Interactive Mascot with Speech Bubble --}}
                <div class="lg:col-span-6 flex flex-col items-center justify-center p-8 bg-white/60 dark:bg-slate-900/30 border border-slate-200/60 dark:border-slate-800/80 rounded-3xl min-h-[400px] relative overflow-hidden shadow-xl order-1 lg:order-2 group">
                    {{-- Tech mesh backgrounds --}}
                    <div class="absolute w-72 h-72 bg-blue-500/10 rounded-full blur-3xl pointer-events-none"></div>

                    {{-- Interactive Speech Bubble --}}
                    <div class="mb-6 bg-blue-50 dark:bg-[#182c47] border border-blue-200 dark:border-blue-800/60 text-blue-900 dark:text-primary text-xs font-bold px-4 py-2.5 rounded-2xl relative shadow-md select-none animate-pulse max-w-[280px] text-center">
                        Hai Sobat BIO-GUARD! Kenalin, aku Peggi, Si Penguin IoT ðŸ§
                        {{-- Speech Bubble Tail --}}
                        <div class="absolute bottom-[-5px] left-1/2 -translate-x-1/2 w-2.5 h-2.5 bg-blue-50 dark:bg-[#182c47] border-r border-b border-blue-200 dark:border-blue-800/60 rotate-45"></div>
                    </div>

                    <div class="relative z-10 flex flex-col items-center">
                        <div class="relative w-64 h-64 flex items-center justify-center bg-transparent border-none overflow-visible">
                            <img src="{{ asset('images/penguin_wink.png') }}?v=2" alt="Peggi Mascot" 
                                 class="w-full h-full object-contain select-none animate-mascot-float dark:drop-shadow-[0_0_20px_rgba(255,255,255,0.6)]">
                        </div>
                        
                        {{-- Badge --}}
                        <div class="mt-4 px-4 py-1.5 rounded-full bg-primary/10 border border-primary/20 text-primary text-[10px] font-black uppercase tracking-widest select-none shadow-sm">
                            Penjaga Cerdas Rantai Dingin
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Vision & Mission Section --}}
        <section id="vision-mission" class="relative w-full py-24 border-t border-slate-200 dark:border-slate-800/50">
            <div class="absolute inset-0 z-0">
                <img src="{{ asset('images/bg_medical_1.png') }}" class="w-full h-full object-cover opacity-[0.08] dark:opacity-10" alt="Section Background">
                <div class="absolute inset-0 bg-white/90 dark:bg-slate-900/90 backdrop-blur-[3px]"></div>
            </div>
            <div class="relative z-10 max-w-7xl mx-auto px-6 space-y-10">
            <div class="text-center space-y-2">
                <span class="text-xs font-black text-primary tracking-widest uppercase">Tujuan & Nilai</span>
                <h2 class="text-3xl font-black text-slate-900 dark:text-white">Visi & Misi</h2>
                <p class="text-sm text-slate-600 dark:text-slate-350 max-w-xl mx-auto">Landasan arah strategis Bio-Guard dalam menjaga keamanan logistik obat termolabil di Indonesia.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-stretch">
                {{-- Visi Card (col-5) --}}
                <div class="md:col-span-5 bg-white/60 dark:bg-slate-900/30 border border-slate-200 dark:border-slate-800/80 rounded-3xl p-8 flex flex-col justify-between shadow-lg relative overflow-hidden">
                    <div class="absolute -top-10 -right-10 w-40 h-40 bg-blue-500/10 rounded-full blur-2xl"></div>
                    <div class="space-y-4 relative z-10">
                        <span class="material-symbols-outlined text-primary text-[36px]">visibility</span>
                        <h3 class="text-xl font-extrabold text-slate-900 dark:text-white">Visi Kami</h3>
                        <p class="text-sm text-slate-700 dark:text-slate-300 leading-relaxed font-semibold">
                            "Menjadi sistem pemantauan rantai dingin (cold chain monitoring) terdistribusi berbasis Internet of Things (IoT) dan Artificial Intelligence (AI) yang inovatif dan terdepan di Indonesia, guna menjamin keamanan, mutu, dan efektivitas terapeutik produk farmasi termolabil (obat dan vaksin) sepanjang jalur distribusi hulu-hilir, sejalan dengan prinsip patient safety dan tata kelola logistik farmasi berbasis bukti (evidence-based)."
                        </p>
                    </div>
                </div>

                {{-- Misi Card (col-7) --}}
                <div class="md:col-span-7 bg-white/60 dark:bg-slate-900/30 border border-slate-200 dark:border-slate-800/80 rounded-3xl p-8 space-y-6 shadow-lg relative overflow-hidden">
                    <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-blue-400/10 rounded-full blur-2xl"></div>
                    <div class="space-y-2 relative z-10">
                        <span class="material-symbols-outlined text-primary text-[36px]">assignment</span>
                        <h3 class="text-xl font-extrabold text-slate-900 dark:text-white">Misi Kami</h3>
                    </div>
                    <ol class="space-y-4 text-sm text-slate-700 dark:text-slate-300 relative z-10 font-medium list-none pl-0">
                        <li class="flex gap-3">
                            <span class="flex items-center justify-center w-6 h-6 rounded-full bg-primary/20 text-primary font-bold text-xs shrink-0 mt-0.5">1</span>
                            <span>Mengembangkan sistem telemetri suhu dan geolokasi berbasis arsitektur IoT dengan pendekatan edge computing, guna menghasilkan akurasi pemantauan real-time yang andal, rendah latensi, dan tahan gangguan konektivitas di lapangan.</span>
                        </li>
                        <li class="flex gap-3">
                            <span class="flex items-center justify-center w-6 h-6 rounded-full bg-primary/20 text-primary font-bold text-xs shrink-0 mt-0.5">2</span>
                            <span>Merancang dan mengintegrasikan algoritma predictive analytics berbasis Artificial Intelligence untuk deteksi dini anomali suhu dan potensi degradasi mutu produk termolabil, sebagai upaya mitigasi risiko sebelum produk tersebut sampai ke tangan pasien.</span>
                        </li>
                        <li class="flex gap-3">
                            <span class="flex items-center justify-center w-6 h-6 rounded-full bg-primary/20 text-primary font-bold text-xs shrink-0 mt-0.5">3</span>
                            <span>Mendukung transformasi digital regulasi CDOB (Cara Distribusi Obat yang Baik) yang ditetapkan oleh BPOM, melalui penyediaan sistem pelaporan dan pendokumentasian rantai dingin yang transparan, akuntabel, dan dapat diaudit (auditable).</span>
                        </li>
                        <li class="flex gap-3">
                            <span class="flex items-center justify-center w-6 h-6 rounded-full bg-primary/20 text-primary font-bold text-xs shrink-0 mt-0.5">4</span>
                            <span>Berkontribusi pada pengembangan keilmuan di bidang IoT dan AI untuk logistik kesehatan, melalui publikasi hasil riset dan penyusunan luaran ilmiah yang relevan dengan capaian PKM-KC.</span>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
        </section>

    </main>

    {{-- Footer --}}
    <footer class="mt-20 border-t border-slate-200 dark:border-slate-900 bg-white/60 dark:bg-slate-950/20 backdrop-blur-md py-8">
        <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row items-center justify-between gap-4 text-xs font-semibold text-slate-500 dark:text-slate-350">
            <div class="flex items-center gap-2">
                <img src="{{ asset('images/logo.png') }}" alt="BIO-GUARD Logo Small" class="h-6 w-auto">
                <span>Â© 2026 BIO-GUARD Enterprise. All rights reserved.</span>
            </div>
            <div class="flex items-center gap-6">
                <a href="#about" class="hover:text-primary transition-colors">Tentang</a>
                <a href="#logo-meaning" class="hover:text-primary transition-colors">Logo</a>
                <a href="#mascot" class="hover:text-primary transition-colors">Maskot</a>
                <a href="#vision-mission" class="hover:text-primary transition-colors">Visi & Misi</a>
                <a href="{{ route('simulator.standalone') }}" target="_blank" class="hover:text-primary transition-colors">Simulator Web</a>
            </div>
        </div>
    </footer>

    {{-- Dark Mode Toggle Script --}}
    <script>
        (function() {
            const themeToggleBtn = document.getElementById('theme-toggle');
            const htmlEl = document.documentElement;

            function applyTheme(theme) {
                if (theme === 'light') {
                    htmlEl.classList.remove('dark');
                    localStorage.setItem('theme', 'light');
                    updateThemeUI('light');
                } else {
                    htmlEl.classList.add('dark');
                    localStorage.setItem('theme', 'dark');
                    updateThemeUI('dark');
                }
            }

            function updateThemeUI(theme) {
                const icon = document.getElementById('theme-toggle-icon');
                if (theme === 'light') {
                    if (icon) icon.textContent = 'light_mode';
                } else {
                    if (icon) icon.textContent = 'dark_mode';
                }
            }

            // Sync UI state awal
            updateThemeUI(htmlEl.classList.contains('dark') ? 'dark' : 'light');

            if (themeToggleBtn) {
                themeToggleBtn.addEventListener('click', () => {
                    const currentTheme = htmlEl.classList.contains('dark') ? 'light' : 'dark';
                    applyTheme(currentTheme);
                });
            }
        })();
    </script>

    {{-- IoT Constellation Particle Background Script --}}
    <script>
        (function() {
            const canvas = document.getElementById('canvas-particles');
            if (!canvas) return;
            const ctx = canvas.getContext('2d');
            
            let particles = [];
            const maxParticles = 60;
            const connectionDist = 125;
            let mouse = { x: null, y: null, radius: 160 };

            function resizeCanvas() {
                canvas.width = window.innerWidth;
                canvas.height = window.innerHeight;
                initParticles();
            }

            class Particle {
                constructor() {
                    this.x = Math.random() * canvas.width;
                    this.y = Math.random() * canvas.height;
                    this.vx = (Math.random() - 0.5) * 0.7;
                    this.vy = (Math.random() - 0.5) * 0.7;
                    this.radius = Math.random() * 2.5 + 1;
                }
                update() {
                    this.x += this.vx;
                    this.y += this.vy;

                    // Bounce off boundaries
                    if (this.x < 0 || this.x > canvas.width) this.vx = -this.vx;
                    if (this.y < 0 || this.y > canvas.height) this.vy = -this.vy;
                }
                draw() {
                    const isDark = document.documentElement.classList.contains('dark');
                    ctx.fillStyle = isDark ? 'rgba(59, 130, 246, 0.5)' : 'rgba(37, 99, 235, 0.35)';
                    ctx.beginPath();
                    ctx.arc(this.x, this.y, this.radius, 0, Math.PI * 2);
                    ctx.fill();
                }
            }

            function initParticles() {
                particles = [];
                const count = Math.min(maxParticles, Math.floor((canvas.width * canvas.height) / 14000));
                for (let i = 0; i < count; i++) {
                    particles.push(new Particle());
                }
            }

            function drawConnections() {
                const isDark = document.documentElement.classList.contains('dark');
                
                for (let i = 0; i < particles.length; i++) {
                    for (let j = i + 1; j < particles.length; j++) {
                        const dist = Math.hypot(particles[i].x - particles[j].x, particles[i].y - particles[j].y);
                        if (dist < connectionDist) {
                            const alpha = (1 - dist / connectionDist) * 0.45;
                            ctx.strokeStyle = isDark ? `rgba(59, 130, 246, ${alpha * 0.25})` : `rgba(37, 99, 235, ${alpha * 0.2})`;
                            ctx.lineWidth = 0.7;
                            ctx.beginPath();
                            ctx.moveTo(particles[i].x, particles[i].y);
                            ctx.lineTo(particles[j].x, particles[j].y);
                            ctx.stroke();
                        }
                    }
                    
                    // Connection to mouse
                    if (mouse.x !== null && mouse.y !== null) {
                        const mDist = Math.hypot(particles[i].x - mouse.x, particles[i].y - mouse.y);
                        if (mDist < mouse.radius) {
                            const mAlpha = (1 - mDist / mouse.radius) * 0.35;
                            ctx.strokeStyle = isDark ? `rgba(59, 130, 246, ${mAlpha * 0.3})` : `rgba(37, 99, 235, ${mAlpha * 0.25})`;
                            ctx.lineWidth = 0.9;
                            ctx.beginPath();
                            ctx.moveTo(particles[i].x, particles[i].y);
                            ctx.lineTo(mouse.x, mouse.y);
                            ctx.stroke();
                        }
                    }
                }
            }

            function animate() {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                
                particles.forEach(p => {
                    p.update();
                    p.draw();
                });
                
                drawConnections();
                requestAnimationFrame(animate);
            }

            window.addEventListener('resize', resizeCanvas);
            window.addEventListener('mousemove', (e) => {
                mouse.x = e.clientX;
                mouse.y = e.clientY;
            });
            window.addEventListener('mouseleave', () => {
                mouse.x = null;
                mouse.y = null;
            });

            resizeCanvas();
            animate();
        })();
    </script>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const curTempEl = document.getElementById('live-current-temp');
        const minTempEl = document.getElementById('live-min-temp');
        const maxTempEl = document.getElementById('live-max-temp');
        const lineEl = document.getElementById('live-chart-line');
        if(curTempEl && lineEl) {
            setInterval(() => {
                let current = (4.0 + Math.random() * 3.5).toFixed(1);
                curTempEl.textContent = current + '°C';
                
                // slightly wiggle the path end
                let yEnd = 40 + Math.random() * 30;
                lineEl.setAttribute('d', `M0,58 Q15,75 30,75 T60,41 T75,23 T85,50 T100,${yEnd}`);
            }, 2000);
        }
    });
    </script>
</body>
</html>


