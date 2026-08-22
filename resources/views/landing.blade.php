<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BIO-GUARD | Rantai Dingin Medis Cerdas</title>

    {{-- Inline script to apply theme immediately --}}
    <script>
        localStorage.setItem('theme', 'light');
        document.documentElement.classList.remove('dark');
        document.documentElement.classList.add('light');
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
        @keyframes custom-breathe {
            0%, 100% { transform: scale(1); opacity: 0.8; }
            50% { transform: scale(1.8); opacity: 0.1; }
        }
        .animate-breathe {
            animation: custom-breathe 2s ease-in-out infinite;
        }
    </style>
</head>
<body class="min-h-screen text-on-surface antialiased relative overflow-x-hidden bg-slate-50 ">

    

    {{-- Canvas Partikel Melayang (IoT Constellation) --}}
    <canvas id="canvas-particles" class="fixed inset-0 w-full h-full pointer-events-none z-0 opacity-50"></canvas>

    {{-- Floating Decorative Mesh Blobs --}}
    <div class="fixed top-1/4 left-1/4 w-[500px] h-[500px] rounded-full bg-blue-500/10  blur-[130px] pointer-events-none animate-blob z-0"></div>
    <div class="fixed bottom-1/4 right-1/4 w-[600px] h-[600px] rounded-full bg-blue-400/10  blur-[140px] pointer-events-none animate-blob z-0" style="animation-delay: -5s;"></div>
    <div class="fixed top-1/2 left-2/3 w-[450px] h-[450px] rounded-full bg-indigo-500/10  blur-[110px] pointer-events-none animate-blob z-0" style="animation-delay: -10s;"></div>

    {{-- Floating Header Navbar --}}
    <header class="fixed top-6 left-1/2 -translate-x-1/2 z-50 w-[95%] max-w-7xl bg-white/40  backdrop-blur-xl border border-white/50  rounded-full px-4 md:px-6 py-3 flex items-center justify-between shadow-xl transition-colors">
        <div class="flex items-center justify-between w-full">
            <a href="#" class="flex items-center gap-2.5 select-none hover:opacity-90 transition-opacity">
                <img src="{{ asset('images/logo.png') }}?v=8" alt="BIO-GUARD Logo" class="h-8 md:h-10 w-auto object-contain transition-transform group-hover:scale-105">
                <span class="text-sm font-black tracking-wider text-slate-900 ">BIO-GUARD</span>
            </a>

            <nav class="hidden lg:flex items-center gap-6 text-[13px] font-semibold text-slate-700 ">
                <a href="#about" class="hover:text-blue-500 :text-blue-400 transition-colors">Tentang Kami</a>
                <a href="#logo-meaning" class="hover:text-blue-500 :text-blue-400 transition-colors">Filosofi Logo</a>
                <a href="#mascot" class="hover:text-blue-500 :text-blue-400 transition-colors">Filosofi Maskot</a>
                <a href="#vision-mission" class="hover:text-blue-500 :text-blue-400 transition-colors">Visi & Misi</a>
                <a href="{{ route('simulator.standalone') }}" target="_blank" class="hover:text-blue-500 :text-blue-400 transition-colors flex items-center gap-1">
                    <span class="material-symbols-outlined text-[14px]">devices</span> Simulator
                </a>
            </nav>

            <div class="flex items-center gap-2 md:gap-3">
                {{-- Theme Switcher Button --}}
                <button id="theme-toggle" class="w-8 h-8 rounded-full bg-white/50  hover:bg-white/80 :bg-slate-700/50 border border-white/60  text-slate-700  transition-colors flex items-center justify-center shadow-sm">
                    <span id="theme-toggle-icon" class="material-symbols-outlined text-[16px]">dark_mode</span>
                </button>
                
                {{-- Download APK Button in Header --}}
                <a href="/downloads/bio-guard-driver.apk" download class="hidden sm:flex items-center justify-center px-4 py-2 border border-white/60  bg-white/30  hover:bg-white/60 :bg-slate-700/50 text-slate-700  text-[11px] font-bold rounded-full transition-all shadow-sm">
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
                <img src="{{ asset('images/bg_medical_1.png') }}" class="w-full h-full object-cover opacity-20 " alt="Hero Background">
                <div class="absolute inset-0 bg-slate-50/80  backdrop-blur-[2px]"></div>
                <div class="absolute bottom-0 left-0 w-full h-24 bg-gradient-to-t from-slate-50  to-transparent"></div>
            </div>
            <div class="relative z-10 max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-8 items-center min-h-[70vh]">
            <div class="lg:col-span-7 space-y-6">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-black tracking-tight leading-tight text-slate-900  drop-shadow-sm">
                    Pusat Kendali Distribusi <br>
                    & <span class="text-blue-500 ">Pemantauan Rantai <br> Dingin</span> Cerdas
                </h1>
                <p class="text-base text-slate-700  max-w-2xl leading-relaxed drop-shadow-sm font-medium">
                    Dengan mengintegrasikan IoT Edge Computing dan Machine Learning, Bio-Guard menghadirkan pemantauan real-time terhadap fluktuasi suhu kritis, penyimpangan rute, dan getaran logistik obat termolabil. Sistem ini dirancang khusus untuk menjaga integritas kargo termolabil demi memastikan keselamatan pasien di seluruh Indonesia.
                </p>
                <div class="flex flex-wrap items-center gap-4 pt-2">
                    <a href="{{ route('login') }}" 
                       class="px-6 py-3 rounded-full bg-blue-600/90  hover:bg-blue-600 :bg-blue-500 text-white text-sm font-bold shadow-[0_0_20px_rgba(37,99,235,0.4)] transition-all duration-300 flex items-center gap-2 border border-blue-500/50 backdrop-blur-md hover:-translate-y-1 hover:scale-105">
                        <span class="material-symbols-outlined text-[20px]">login</span> Masuk ke Portal Admin
                    </a>
                    <a href="/downloads/bio-guard-driver.apk" download
                       class="px-6 py-3 rounded-full bg-slate-900/80  hover:bg-slate-900 :bg-slate-700 text-white text-sm font-bold shadow-lg transition-all duration-300 flex items-center gap-2 border border-slate-700/50 backdrop-blur-md hover:-translate-y-1 hover:scale-105">
                        <span class="material-symbols-outlined text-[20px]">download</span> Unduh Aplikasi (APK)
                    </a>
                </div>
            </div>

            {{-- Interactive Parallax Shield Logo --}}
            <div class="lg:col-span-5 flex justify-center items-center lg:justify-end">
                <div class="relative w-72 h-72 md:w-96 md:h-96" data-tilt data-tilt-max="15" data-tilt-speed="400" data-tilt-perspective="1000" data-tilt-scale="1.05">
                    {{-- Soft glow behind shield --}}
                    <div class="absolute inset-0 bg-blue-500/20  rounded-full blur-[60px] transform-gpu"></div>
                    
                    {{-- Abstract SVG Pulse (Decorative) --}}
                    <style>
                        @keyframes dash-pulse {
                            0% { stroke-dashoffset: 400; }
                            50% { stroke-dashoffset: 0; }
                            100% { stroke-dashoffset: -400; }
                        }
                        .animate-dash-pulse { animation: dash-pulse 3s linear infinite; }
                    </style>
                    <div class="absolute inset-0 flex justify-center items-center opacity-40 pointer-events-none">
                        <svg class="w-[120%] h-[120%] animate-[spin_10s_linear_infinite]" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="50" cy="50" r="45" stroke="currentColor" stroke-width="0.5" class="text-blue-400/30 " stroke-dasharray="2 4" />
                            <circle cx="50" cy="50" r="35" stroke="currentColor" stroke-width="0.5" class="text-teal-400/50 " stroke-dasharray="4 8" />
                            <circle cx="50" cy="50" r="25" stroke="currentColor" stroke-width="0.8" class="text-blue-500/60  animate-pulse" />
                        </svg>
                        <svg class="absolute w-[150%] h-[150%] animate-[pulse_4s_ease-in-out_infinite] opacity-50" viewBox="0 0 200 200" fill="none">
                            <path d="M 0 100 Q 25 100 35 70 T 70 100 T 100 50 T 130 100 T 165 130 T 200 100" stroke="url(#pulse-grad)" stroke-width="2" fill="none" class="animate-dash-pulse" stroke-dasharray="400" stroke-dashoffset="400"/>
                            <defs>
                                <linearGradient id="pulse-grad" x1="0%" y1="0%" x2="100%" y2="0%">
                                    <stop offset="0%" stop-color="#0ea5e9" stop-opacity="0" />
                                    <stop offset="50%" stop-color="#14b8a6" stop-opacity="0.8" />
                                    <stop offset="100%" stop-color="#0ea5e9" stop-opacity="0" />
                                </linearGradient>
                            </defs>
                        </svg>
                    </div>
                    
                    {{-- Floating Particles --}}
                    <div class="absolute w-2 h-2 bg-blue-400 rounded-full blur-[1px] animate-[ping_3s_infinite] top-10 left-10"></div>
                    <div class="absolute w-3 h-3 bg-teal-400 rounded-full blur-[2px] animate-[pulse_2s_infinite] bottom-20 right-10"></div>
                    <div class="absolute w-1.5 h-1.5 bg-sky-300 rounded-full animate-[bounce_4s_infinite] top-20 right-20"></div>
                    
                    {{-- Shield Image --}}
                    <img src="{{ asset('images/logo_shield.png') }}?v=6" 
                         alt="BIO-GUARD Shield" 
                         class="relative z-10 w-full h-full object-contain drop-shadow-[0_10px_40px_rgba(33,150,243,0.4)] (76,213,246,0.3)] animate-mascot-float transform-gpu"
                         style="transform: translateZ(50px);">
                </div>
            </div>
        </section>

        {{-- Logo Philosophy Section --}}
        <section id="logo-meaning" class="relative w-full py-24 border-t border-slate-200 ">
            <div class="absolute inset-0 z-0">
                <img src="{{ asset('images/bg_medical_2.png') }}" class="w-full h-full object-cover opacity-[0.08] " alt="Section Background">
                <div class="absolute inset-0 bg-white/90  backdrop-blur-[3px]"></div>
            </div>
            <div class="relative z-10 max-w-7xl mx-auto px-6 space-y-10">
            <div class="text-center space-y-2">
                <span class="text-xs font-black text-primary tracking-widest uppercase">Identitas Visual</span>
                <h2 class="text-3xl font-black text-slate-900 ">Decoding Our Symbols</h2>
                <p class="text-sm text-slate-600  max-w-xl mx-auto">Kisah dan makna ilmiah di balik pembuatan logo resmi Bio-Guard.</p>
            </div>

            {{-- Responsive Image and Cards Split --}}
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
                
                {{-- Left Side: Premium Interactive Emblem --}}
                <div class="lg:col-span-6 flex items-center justify-center p-8 bg-white/60  border border-slate-200/60  rounded-3xl min-h-[400px] relative overflow-hidden shadow-xl group">
                    {{-- Glowing ring behind logo --}}
                    <div class="absolute w-72 h-72 rounded-full border border-primary/20  animate-[spin_20s_linear_infinite] pointer-events-none"></div>
                    <div class="absolute w-80 h-80 rounded-full border border-dashed border-blue-500/20  animate-[spin_30s_linear_infinite] pointer-events-none" style="animation-direction: reverse;"></div>
                    <div class="absolute w-48 h-48 bg-primary/10 rounded-full blur-3xl pointer-events-none"></div>

                    <div class="relative z-10 flex flex-col items-center">
                        <div class="relative w-64 h-64 flex items-center justify-center bg-transparent border-none overflow-visible">
                            <img src="{{ asset('images/logo_shield.png') }}?v=6" alt="BIO-GUARD Logo Shield" 
                                 class="w-full h-full object-contain select-none animate-mascot-float (76,213,246,0.5)]">
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
                    <div class="flex items-start gap-5 p-5 rounded-3xl bg-white/95  border border-blue-500/15  shadow-xl (33,150,243,0.15)] hover:-translate-y-2 transition-all duration-500 group">
                        <div class="w-16 h-16 bg-gradient-to-br from-[#f0f7ff] to-white   rounded-2xl flex items-center justify-center shrink-0 border border-blue-100  shadow-inner group-hover:scale-110 transition-transform duration-500 relative overflow-hidden">
                            <div class="absolute inset-0 bg-blue-500/10 blur-xl rounded-full scale-150 group-hover:bg-blue-500/20 transition-all"></div>
                            <img src="{{ asset('images/shield_logo.png') }}?v=6" alt="Shield Icon" class="w-10 h-10 object-contain relative z-10 drop-shadow-md (76,213,246,0.6)]">
                        </div>
                        <div class="pt-1">
                            <h4 class="text-base font-black text-blue-600  tracking-tight">The Shield (Perisai)</h4>
                            <p class="text-sm text-slate-600  mt-1.5 leading-relaxed font-medium">Mewakili perlindungan mutlak terhadap integritas jejak audit digital dan keamanan fisik obat termolabil dari risiko kerusakan selama perjalanan.</p>
                        </div>
                    </div>

                    {{-- Card 2 --}}
                    <div class="flex items-start gap-5 p-5 rounded-3xl bg-white/95  border border-blue-500/15  shadow-xl (33,150,243,0.15)] hover:-translate-y-2 transition-all duration-500 group">
                        <div class="w-16 h-16 bg-gradient-to-br from-[#f0f7ff] to-white   rounded-2xl flex items-center justify-center shrink-0 border border-blue-100  shadow-inner group-hover:scale-110 transition-transform duration-500 relative overflow-hidden">
                            <div class="absolute inset-0 bg-cyan-500/10 blur-xl rounded-full scale-150 group-hover:bg-cyan-500/20 transition-all"></div>
                            <img src="{{ asset('images/snowflake.png') }}?v=6" alt="Snowflake Icon" class="w-10 h-10 object-contain relative z-10 drop-shadow-md (76,213,246,0.6)]">
                        </div>
                        <div class="pt-1">
                            <h4 class="text-base font-black text-blue-600  tracking-tight">The Snowflake (Kepingan Salju)</h4>
                            <p class="text-sm text-slate-600  mt-1.5 leading-relaxed font-medium">Menegaskan fokus sistem dalam menjaga ambang batas suhu kritis 2°C - 8°C agar struktur protein obat dan vaksin tetap utuh dan layak pakai.</p>
                        </div>
                    </div>

                    {{-- Card 3 --}}
                    <div class="flex items-start gap-5 p-5 rounded-3xl bg-white/95  border border-blue-500/15  shadow-xl (33,150,243,0.15)] hover:-translate-y-2 transition-all duration-500 group">
                        <div class="w-16 h-16 bg-gradient-to-br from-[#f0f7ff] to-white   rounded-2xl flex items-center justify-center shrink-0 border border-blue-100  shadow-inner group-hover:scale-110 transition-transform duration-500 relative overflow-hidden">
                            <div class="absolute inset-0 bg-indigo-500/10 blur-xl rounded-full scale-150 group-hover:bg-indigo-500/20 transition-all"></div>
                            <img src="{{ asset('images/circuit.png') }}?v=6" alt="Circuit Icon" class="w-10 h-10 object-contain relative z-10 drop-shadow-md (76,213,246,0.6)]">
                        </div>
                        <div class="pt-1">
                            <h4 class="text-base font-black text-blue-600  tracking-tight">Circuit Lines (Jalur Sirkuit)</h4>
                            <p class="text-sm text-slate-600  mt-1.5 leading-relaxed font-medium">Menyimpulkan komputasi cerdas di dalam chip yang mampu memprediksi risiko secara real-time tanpa jeda peladen.</p>
                        </div>
                    </div>

                    {{-- Card 4 --}}
                    <div class="flex items-start gap-5 p-5 rounded-3xl bg-white/95  border border-blue-500/15  shadow-xl (33,150,243,0.15)] hover:-translate-y-2 transition-all duration-500 group">
                        <div class="w-16 h-16 bg-gradient-to-br from-[#f0f7ff] to-white   rounded-2xl flex items-center justify-center shrink-0 border border-blue-100  shadow-inner group-hover:scale-110 transition-transform duration-500 relative overflow-hidden">
                            <div class="absolute inset-0 bg-blue-500/10 blur-xl rounded-full scale-150 group-hover:bg-blue-500/20 transition-all"></div>
                            <img src="{{ asset('images/waves_logo.png') }}?v=6" alt="Waves Icon" class="w-10 h-10 object-contain relative z-10 drop-shadow-md (76,213,246,0.6)]">
                        </div>
                        <div class="pt-1">
                            <h4 class="text-base font-black text-blue-600  tracking-tight">Dynamic Waves (Gelombang Dinamis)</h4>
                            <p class="text-sm text-slate-600  mt-1.5 leading-relaxed font-medium">Visualisasi dari arsitektur Offline-First yang kebal terhadap blank spot jaringan, serta pergerakan dinamis armada kurir di lapangan.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Mascot Philosophy Section --}}
        <section id="mascot" class="relative w-full py-24 border-t border-slate-200 ">
            <div class="absolute inset-0 z-0">
                <img src="https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?q=80&w=2070&auto=format&fit=crop" class="w-full h-full object-cover opacity-[0.08] " alt="Section Background">
                <div class="absolute inset-0 bg-slate-50/90  backdrop-blur-[3px]"></div>
            </div>
            <div class="relative z-10 max-w-7xl mx-auto px-6 space-y-10">
            <div class="text-center space-y-2">
                <span class="text-xs font-black text-primary tracking-widest uppercase">Mascot Resmi</span>
                <h2 class="text-3xl font-black text-slate-900 ">Meet Our Mascot!</h2>
                <p class="text-sm text-slate-600  max-w-xl mx-auto">Kenalkan Peggi, Si Penguin Penjaga Cerdas Rantai Dingin Medis Masa Depan.</p>
               <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-6 items-center relative">
                
                {{-- Left Side: Cards 1 & 2 (order-2 on mobile, order-1 on desktop) --}}
                <div class="lg:col-span-4 space-y-6 order-2 lg:order-1 relative z-10">
                    {{-- Card 1 --}}
                    <div class="flex items-start gap-4 p-5 rounded-3xl bg-white/95  border border-blue-500/15  shadow-xl (33,150,243,0.15)] hover:-translate-y-2 transition-all duration-500 group">
                        <div class="w-14 h-14 bg-gradient-to-br from-[#f0f7ff] to-white   rounded-2xl flex items-center justify-center shrink-0 border border-blue-100  shadow-inner group-hover:scale-110 transition-transform duration-500">
                            <img src="{{ asset('images/penguin_happy.png') }}?v=6" alt="Penguin Icon" class="w-8 h-8 object-contain drop-shadow-md">
                        </div>
                        <div class="pt-0.5">
                            <h4 class="text-sm font-black text-blue-600  tracking-tight">The Penguin (Penguin)</h4>
                            <p class="text-[11px] text-slate-600  mt-1 leading-relaxed font-medium">Simbol ketahanan di kondisi ekstrem, menjaga stabilitas logistik.</p>
                        </div>
                    </div>

                    {{-- Card 2 --}}
                    <div class="flex items-start gap-4 p-5 rounded-3xl bg-white/95  border border-blue-500/15  shadow-xl (33,150,243,0.15)] hover:-translate-y-2 transition-all duration-500 group">
                        <div class="w-14 h-14 bg-gradient-to-br from-[#f0f7ff] to-white   rounded-2xl flex items-center justify-center shrink-0 border border-blue-100  shadow-inner group-hover:scale-110 transition-transform duration-500">
                            <img src="{{ asset('images/glasses.png') }}?v=6" alt="Goggles Icon" class="w-8 h-8 object-contain drop-shadow-md">
                        </div>
                        <div class="pt-0.5">
                            <h4 class="text-sm font-black text-blue-600  tracking-tight">Edge-Vision Goggles</h4>
                            <p class="text-[11px] text-slate-600  mt-1 leading-relaxed font-medium">Komputasi cerdas AI untuk prediksi risiko secara presisi.</p>
                        </div>
                    </div>
                </div>

                {{-- Center: Mascot (order-1 on mobile, order-2 on desktop) --}}
                <div class="lg:col-span-4 flex flex-col items-center justify-center min-h-[400px] relative overflow-visible order-1 lg:order-2 group z-0">
                    {{-- Glowing Backdrops --}}
                    <div class="absolute w-80 h-80 bg-blue-500/20  rounded-full blur-3xl pointer-events-none group-hover:bg-blue-500/30 transition-colors duration-700"></div>
                    <div class="absolute w-64 h-64 border border-dashed border-blue-500/30 rounded-full animate-[spin_20s_linear_infinite]"></div>

                    {{-- Interactive Speech Bubble --}}
                    <div class="mb-4 bg-gradient-to-r from-blue-600 to-blue-500 text-white text-xs font-bold px-5 py-3 rounded-2xl relative shadow-lg select-none animate-bounce max-w-[240px] text-center z-20">
                        Hai! Aku Peggi, Si Penguin Penjaga Rantai Dingin!
                        <div class="absolute bottom-[-6px] left-1/2 -translate-x-1/2 w-3 h-3 bg-blue-500 rotate-45"></div>
                    </div>

                    <div class="relative z-10 flex flex-col items-center mt-4">
                        <div class="relative w-72 h-72 lg:w-80 lg:h-80 flex items-center justify-center bg-transparent border-none overflow-visible">
                            <img src="{{ asset('images/penguin_wink.png') }}?v=2" alt="Peggi Mascot" 
                                 class="w-full h-full object-contain select-none animate-mascot-float drop-shadow-2xl (33,150,243,0.4)] hover:scale-105 transition-transform duration-500">
                        </div>
                    </div>
                </div>

                {{-- Right Side: Cards 3 & 4 (order-3 on mobile, order-3 on desktop) --}}
                <div class="lg:col-span-4 space-y-6 order-3 relative z-10">
                    {{-- Card 3 --}}
                    <div class="flex items-start gap-4 p-5 rounded-3xl bg-white/95  border border-blue-500/15  shadow-xl (33,150,243,0.15)] hover:-translate-y-2 transition-all duration-500 group">
                        <div class="w-14 h-14 bg-gradient-to-br from-[#f0f7ff] to-white   rounded-2xl flex items-center justify-center shrink-0 border border-blue-100  shadow-inner group-hover:scale-110 transition-transform duration-500">
                            <img src="{{ asset('images/vest.png') }}?v=6" alt="Vest Icon" class="w-8 h-8 object-contain drop-shadow-md">
                        </div>
                        <div class="pt-0.5">
                            <h4 class="text-sm font-black text-blue-600  tracking-tight">The Bio-Armor Vest</h4>
                            <p class="text-[11px] text-slate-600  mt-1 leading-relaxed font-medium">Seragam pelindung kepatuhan absolut standar CDOB BPOM RI.</p>
                        </div>
                    </div>

                    {{-- Card 4 --}}
                    <div class="flex items-start gap-4 p-5 rounded-3xl bg-white/95  border border-blue-500/15  shadow-xl (33,150,243,0.15)] hover:-translate-y-2 transition-all duration-500 group">
                        <div class="w-14 h-14 bg-gradient-to-br from-[#f0f7ff] to-white   rounded-2xl flex items-center justify-center shrink-0 border border-blue-100  shadow-inner group-hover:scale-110 transition-transform duration-500">
                            <img src="{{ asset('images/tablet.png') }}?v=6" alt="Tablet Icon" class="w-8 h-8 object-contain drop-shadow-md">
                        </div>
                        <div class="pt-0.5">
                            <h4 class="text-sm font-black text-blue-600  tracking-tight">Nexus Command Pad</h4>
                            <p class="text-[11px] text-slate-600  mt-1 leading-relaxed font-medium">Sinkronisasi mulus dasbor web dan aplikasi kurir di lapangan.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Vision & Mission Section --}}
        <section id="vision-mission" class="relative w-full py-24 border-t border-slate-200 ">
            <div class="absolute inset-0 z-0">
                <img src="{{ asset('images/bg_medical_1.png') }}" class="w-full h-full object-cover opacity-[0.08] " alt="Section Background">
                <div class="absolute inset-0 bg-white/90  backdrop-blur-[3px]"></div>
            </div>
            <div class="relative z-10 max-w-7xl mx-auto px-6 space-y-10">
            <div class="text-center space-y-2">
                <span class="text-xs font-black text-primary tracking-widest uppercase">Tujuan & Nilai</span>
                <h2 class="text-3xl font-black text-slate-900 ">Visi & Misi</h2>
                <p class="text-sm text-slate-600  max-w-xl mx-auto">Landasan arah strategis Bio-Guard dalam menjaga keamanan logistik obat termolabil di Indonesia.</p>
            </div>

            <div class="flex flex-col gap-16 lg:gap-20">
                {{-- Visi: Large Pull-Quote --}}
                <div class="relative w-full max-w-5xl mx-auto text-center px-4 md:px-12 py-10">
                    <div class="absolute top-0 left-0 text-[120px] lg:text-[180px] leading-none text-blue-500/10  font-serif font-black select-none -translate-x-4 lg:-translate-x-8 -translate-y-8 lg:-translate-y-12">"</div>
                    <div class="absolute bottom-0 right-0 text-[120px] lg:text-[180px] leading-none text-blue-500/10  font-serif font-black select-none translate-x-4 lg:translate-x-8 translate-y-8 lg:translate-y-12 rotate-180">"</div>
                    
                    <h3 class="relative z-10 text-xl md:text-2xl lg:text-3xl font-extrabold text-slate-800  leading-relaxed tracking-tight">
                        Menjadi sistem pemantauan rantai dingin <span class="text-blue-600 ">terdistribusi berbasis IoT dan AI</span> yang inovatif dan terdepan di Indonesia, guna menjamin keamanan, mutu, dan efektivitas terapeutik produk farmasi termolabil sepanjang jalur distribusi hulu-hilir, sejalan dengan prinsip <span class="text-blue-600 ">patient safety</span> dan tata kelola logistik farmasi berbasis bukti.
                    </h3>
                    <div class="mt-6">
                        <span class="inline-block px-4 py-1.5 rounded-full bg-blue-50  text-blue-600  text-xs font-bold tracking-widest uppercase border border-blue-100 ">Visi Kami</span>
                    </div>
                </div>

                {{-- Misi: 4 Cards Grid --}}
                <div class="w-full">
                    <div class="text-center mb-8">
                        <h3 class="text-2xl font-black text-slate-900 ">Misi Kami</h3>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Misi 1 --}}
                        <div class="flex gap-5 p-6 rounded-3xl bg-white/95  border border-blue-500/15  shadow-xl (33,150,243,0.15)] hover:-translate-y-2 transition-all duration-500 group">
                            <div class="w-12 h-12 bg-gradient-to-br from-[#f0f7ff] to-white   rounded-xl flex items-center justify-center shrink-0 border border-blue-100  shadow-inner group-hover:scale-110 transition-transform duration-500 relative overflow-hidden">
                                <span class="material-symbols-outlined text-blue-600  text-[24px] relative z-10">router</span>
                            </div>
                            <div class="pt-0.5">
                                <p class="text-[13px] text-slate-700  leading-relaxed font-semibold">Mengembangkan sistem telemetri suhu dan geolokasi berbasis arsitektur IoT dengan pendekatan <span class="text-blue-600  font-bold">edge computing</span>, guna menghasilkan akurasi pemantauan real-time yang andal dan rendah latensi.</p>
                            </div>
                        </div>
                        
                        {{-- Misi 2 --}}
                        <div class="flex gap-5 p-6 rounded-3xl bg-white/95  border border-blue-500/15  shadow-xl (33,150,243,0.15)] hover:-translate-y-2 transition-all duration-500 group">
                            <div class="w-12 h-12 bg-gradient-to-br from-[#f0f7ff] to-white   rounded-xl flex items-center justify-center shrink-0 border border-blue-100  shadow-inner group-hover:scale-110 transition-transform duration-500 relative overflow-hidden">
                                <span class="material-symbols-outlined text-blue-600  text-[24px] relative z-10">psychology</span>
                            </div>
                            <div class="pt-0.5">
                                <p class="text-[13px] text-slate-700  leading-relaxed font-semibold">Merancang dan mengintegrasikan algoritma <span class="text-blue-600  font-bold">predictive analytics</span> berbasis AI untuk deteksi dini anomali suhu dan potensi degradasi mutu produk sebagai mitigasi risiko.</p>
                            </div>
                        </div>

                        {{-- Misi 3 --}}
                        <div class="flex gap-5 p-6 rounded-3xl bg-white/95  border border-blue-500/15  shadow-xl (33,150,243,0.15)] hover:-translate-y-2 transition-all duration-500 group">
                            <div class="w-12 h-12 bg-gradient-to-br from-[#f0f7ff] to-white   rounded-xl flex items-center justify-center shrink-0 border border-blue-100  shadow-inner group-hover:scale-110 transition-transform duration-500 relative overflow-hidden">
                                <span class="material-symbols-outlined text-blue-600  text-[24px] relative z-10">verified_user</span>
                            </div>
                            <div class="pt-0.5">
                                <p class="text-[13px] text-slate-700  leading-relaxed font-semibold">Mendukung transformasi digital regulasi <span class="text-blue-600  font-bold">CDOB BPOM</span> melalui penyediaan sistem pelaporan rantai dingin yang transparan, akuntabel, dan auditable.</p>
                            </div>
                        </div>

                        {{-- Misi 4 --}}
                        <div class="flex gap-5 p-6 rounded-3xl bg-white/95  border border-blue-500/15  shadow-xl (33,150,243,0.15)] hover:-translate-y-2 transition-all duration-500 group">
                            <div class="w-12 h-12 bg-gradient-to-br from-[#f0f7ff] to-white   rounded-xl flex items-center justify-center shrink-0 border border-blue-100  shadow-inner group-hover:scale-110 transition-transform duration-500 relative overflow-hidden">
                                <span class="material-symbols-outlined text-blue-600  text-[24px] relative z-10">school</span>
                            </div>
                            <div class="pt-0.5">
                                <p class="text-[13px] text-slate-700  leading-relaxed font-semibold">Berkontribusi pada <span class="text-blue-600  font-bold">pengembangan keilmuan</span> di bidang IoT dan AI untuk logistik kesehatan melalui publikasi hasil riset dan luaran ilmiah PKM-KC.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </section>

    </main>

    {{-- Footer --}}
    <footer class="relative border-t border-blue-500/10  bg-white/80  backdrop-blur-md">
        {{-- Subtle gradient separator --}}
        <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-blue-500/30 to-transparent"></div>

        <div class="max-w-7xl mx-auto px-6 py-10">
            <div class="flex flex-col md:flex-row items-center md:items-start justify-between gap-8">

                {{-- Left: Logo + Tagline --}}
                <div class="flex flex-col items-center md:items-start gap-3 text-center md:text-left">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('images/logo.png') }}" alt="BIO-GUARD Logo" class="h-8 w-auto drop-shadow-md">
                        <span class="text-base font-black text-slate-800  tracking-tight">BIO-GUARD</span>
                    </div>
                    <p class="text-xs text-slate-500  font-medium max-w-[220px] leading-relaxed">
                        Penjaga Cerdas Rantai Dingin Medis — IoT &amp; AI untuk keamanan farmasi termolabil.
                    </p>
                    <span class="text-[11px] text-slate-400  font-medium">
                        &copy; 2026 BIO-GUARD Enterprise. All rights reserved.
                    </span>
                </div>

                {{-- Right: Navigation Links --}}
                <div class="flex flex-col items-center md:items-end gap-4">
                    <span class="text-[10px] font-black text-blue-600  tracking-widest uppercase">Navigasi</span>
                    <nav class="flex flex-wrap justify-center md:justify-end gap-x-6 gap-y-2">
                        <a href="#about" class="text-xs font-semibold text-slate-500  hover:text-blue-600 :text-[#64b5f6] transition-colors duration-200">Tentang</a>
                        <a href="#logo-meaning" class="text-xs font-semibold text-slate-500  hover:text-blue-600 :text-[#64b5f6] transition-colors duration-200">Logo</a>
                        <a href="#mascot" class="text-xs font-semibold text-slate-500  hover:text-blue-600 :text-[#64b5f6] transition-colors duration-200">Maskot</a>
                        <a href="#vision-mission" class="text-xs font-semibold text-slate-500  hover:text-blue-600 :text-[#64b5f6] transition-colors duration-200">Visi &amp; Misi</a>
                        <a href="{{ route('simulator.standalone') }}" target="_blank" class="text-xs font-semibold text-blue-600  hover:underline transition-colors duration-200 flex items-center gap-1">
                            Simulator Web
                            <span class="material-symbols-outlined text-[12px]">open_in_new</span>
                        </a>
                    </nav>
                </div>
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
        // ─── References ────────────────────────────────────────────────────
        const curTempEl      = document.getElementById('live-current-temp');
        const minTempEl      = document.getElementById('live-min-temp');
        const maxTempEl      = document.getElementById('live-max-temp');
        const lineEl         = document.getElementById('live-chart-line');
                widgetCard.style.transform = '';
                widgetCard.style.transition = 'transform 500ms ease, box-shadow 500ms ease';
            });
        }
    });
    </script>
    
    {{-- VanillaTilt.js for 3D Hover Effects --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-tilt/1.8.0/vanilla-tilt.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            VanillaTilt.init(document.querySelectorAll(".group.hover\\:-translate-y-2"), {
                max: 5,
                speed: 400,
                glare: true,
                "max-glare": 0.15,
            });
        });
    </script>
</body>
</html>
