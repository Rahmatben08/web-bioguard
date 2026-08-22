<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BIO-GUARD | Pemantauan Rantai Dingin IoT & AI</title>

    {{-- Inline script to apply theme immediately and prevent screen flash --}}
    <script>
        localStorage.setItem('theme', 'light');
        document.documentElement.classList.remove('dark');
        document.documentElement.classList.add('light');
    </script>

    {{-- Tailwind CSS & Plugins from CDN --}}
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>

    {{-- Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">

    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#4cd7f6",
                        "primary-container": "#06b6d4",
                        "surface": "#081425",
                        "surface-container": "#152031",
                        "on-surface": "#d8e3fb",
                        "on-surface-variant": "#bcc9cd",
                        "error": "#ffb4ab",
                        "tertiary": "#ffb95f",
                    },
                    borderRadius: {
                        '3xl': '1.5rem',
                        '4xl': '2rem',
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
            0%, 100% {
                transform: translate(0, 0) scale(1);
            }
            33% {
                transform: translate(30px, -50px) scale(1.1);
            }
            66% {
                transform: translate(-20px, 20px) scale(0.95);
            }
        }
        .animate-blob {
            animation: float-blob 20s infinite ease-in-out;
        }
    </style>
</head>
<body class="min-h-screen text-on-surface antialiased relative overflow-x-hidden flex flex-col justify-between">

    {{-- Canvas Partikel Melayang (IoT Constellation) --}}
    <canvas id="canvas-particles" class="fixed inset-0 w-full h-full pointer-events-none z-0"></canvas>

    {{-- Floating Decorative Mesh Blobs (Professional Medical Palette) --}}
    <div class="absolute top-10 left-10 w-[600px] h-[600px] rounded-full bg-teal-500/10  blur-[120px] pointer-events-none animate-blob z-0"></div>
    <div class="absolute bottom-20 right-10 w-[550px] h-[550px] rounded-full bg-sky-500/10  blur-[130px] pointer-events-none animate-blob z-0" style="animation-delay: -5s;"></div>
    <div class="absolute top-1/2 left-1/3 w-[400px] h-[400px] rounded-full bg-indigo-500/8  blur-[100px] pointer-events-none animate-blob z-0" style="animation-delay: -10s;"></div>

    {{-- Header / Navigation --}}
    <header class="relative z-10 w-full max-w-7xl mx-auto px-6 py-6 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <img src="{{ asset('images/logo.png') }}" alt="BIO-GUARD Logo" class="h-10 w-auto object-contain select-none drop-shadow-[0_0_10px_rgba(76,213,246,0.25)]">
            <div>
                <span class="text-lg font-black tracking-tight text-slate-900 ">BIO-GUARD</span>
                <span class="hidden sm:inline-block ml-1.5 px-2 py-0.5 rounded bg-primary/10 text-primary text-[10px] font-black uppercase tracking-wider">Enterprise v2.0</span>
            </div>
        </div>

        <div class="flex items-center gap-4">
            {{-- Dark/Light Mode Button --}}
            <button id="theme-toggle" class="flex items-center justify-center w-10 h-10 rounded-xl border border-slate-200  bg-white/40  text-slate-700  hover:-translate-y-0.5 hover:shadow-md active:scale-95 transition-all duration-300 ease-out cursor-pointer" title="Ubah Mode Layar">
                <span id="theme-toggle-icon" class="material-symbols-outlined text-[20px]">dark_mode</span>
            </button>

            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="px-5 py-2.5 bg-primary text-on-primary font-bold text-xs rounded-xl shadow-lg shadow-primary/20 hover:-translate-y-0.5 active:scale-95 transition-all cursor-pointer">
                        Portal Admin
                    </a>
                @else
                    <a href="{{ route('login') }}" class="px-5 py-2.5 bg-primary text-on-primary font-bold text-xs rounded-xl shadow-lg shadow-primary/20 hover:-translate-y-0.5 active:scale-95 transition-all cursor-pointer">
                        Masuk Portal
                    </a>
                @endauth
            @endif
        </div>
    </header>

    {{-- Main Content --}}
    <main class="relative z-10 w-full max-w-7xl mx-auto px-6 py-12 flex-1 flex flex-col gap-16 justify-center">
        
        {{-- Section 1: Hero --}}
        <section class="text-center max-w-4xl mx-auto space-y-6">
            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-teal-500/10 border border-teal-500/20 text-teal-600  text-xs font-black uppercase tracking-wider animate-pulse">
                <span class="material-symbols-outlined text-[14px]">cell_tower</span> IoT & AI Cold Chain Monitoring
            </div>
            
            <h1 class="text-4xl sm:text-5xl md:text-6xl font-black tracking-tight text-slate-900  leading-[1.15]">
                Amankan Logistik Medis <br class="hidden sm:inline">
                Dengan <span class="bg-gradient-to-r from-teal-500 to-sky-500   bg-clip-text text-transparent">Pantauan Real-Time</span>
            </h1>

            <p class="text-sm sm:text-base md:text-lg text-slate-650  font-medium max-w-2xl mx-auto leading-relaxed">
                Platform pusat kendali cerdas terintegrasi untuk menjamin kestabilan suhu rantai dingin vaksin dan obat termolabil dari gudang farmasi hingga ke fasilitas pelayanan kesehatan terkecil.
            </p>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-4">
                @auth
                    <a href="{{ url('/dashboard') }}" class="w-full sm:w-auto px-8 py-3.5 bg-primary text-on-primary text-sm font-bold tracking-wide rounded-xl shadow-lg shadow-primary/20 hover:shadow-xl hover:-translate-y-0.5 active:scale-[0.98] transition-all duration-300 cursor-pointer flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined text-[20px]">dashboard</span>
                        Buka Dasbor Monitoring
                    </a>
                @else
                    <a href="{{ route('login') }}" class="w-full sm:w-auto px-8 py-3.5 bg-primary text-on-primary text-sm font-bold tracking-wide rounded-xl shadow-lg shadow-primary/20 hover:shadow-xl hover:-translate-y-0.5 active:scale-[0.98] transition-all duration-300 cursor-pointer flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined text-[20px]">login</span>
                        Masuk Ke Portal Admin
                    </a>
                @endauth
                
                <a href="{{ url('/simulator') }}" class="w-full sm:w-auto px-8 py-3.5 bg-white/60  backdrop-blur-md border border-slate-200  text-slate-700  text-sm font-bold tracking-wide rounded-xl hover:-translate-y-0.5 hover:shadow-md active:scale-[0.98] transition-all duration-300 cursor-pointer flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-[20px]">settings_input_antenna</span>
                    Simulator IoT Perangkat
                </a>
            </div>
        </section>

        {{-- Section 2: Key Stats --}}
        <section class="grid grid-cols-1 sm:grid-cols-3 gap-6 max-w-5xl mx-auto w-full">
            {{-- Stat 1 --}}
            <div class="bg-white/40  backdrop-blur-md rounded-2xl border border-slate-200  p-6 text-center hover:border-primary/40 hover:-translate-y-1 hover:shadow-lg transition-all duration-300">
                <p class="text-3xl sm:text-4xl font-black text-teal-600  tracking-tight">99.8%</p>
                <p class="text-xs font-bold uppercase tracking-wider text-slate-500  mt-2">Akurasi Rantai Dingin</p>
                <p class="text-[10px] text-slate-400 mt-1">Suhu Terjaga Konstan (2°C - 8°C)</p>
            </div>
            {{-- Stat 2 --}}
            <div class="bg-white/40  backdrop-blur-md rounded-2xl border border-slate-200  p-6 text-center hover:border-tertiary/40 hover:-translate-y-1 hover:shadow-lg transition-all duration-300">
                <p class="text-3xl sm:text-4xl font-black text-tertiary tracking-tight">&lt; 2 Detik</p>
                <p class="text-xs font-bold uppercase tracking-wider text-slate-500  mt-2">Latensi Jaringan IoT</p>
                <p class="text-[10px] text-slate-400 mt-1">Sinkronisasi Real-time Global</p>
            </div>
            {{-- Stat 3 --}}
            <div class="bg-white/40  backdrop-blur-md rounded-2xl border border-slate-200  p-6 text-center hover:border-green-500/40 hover:-translate-y-1 hover:shadow-lg transition-all duration-300">
                <p class="text-3xl sm:text-4xl font-black text-green-500 tracking-tight">100%</p>
                <p class="text-xs font-bold uppercase tracking-wider text-slate-500  mt-2">Kepatuhan CDOB</p>
                <p class="text-[10px] text-slate-400 mt-1">Tanda Terima & Geofencing Otomatis</p>
            </div>
        </section>

        {{-- Section 3: Bento Grid Features --}}
        <section class="space-y-6">
            <div class="text-center max-w-xl mx-auto">
                <h2 class="text-2xl font-extrabold text-slate-900  tracking-tight">Teknologi Cerdas & Fitur Utama</h2>
                <p class="text-xs text-slate-500  mt-1 leading-relaxed">
                    Didesain untuk keandalan maksimal guna mencegah kegagalan efikasi vaksin akibat deviasi suhu (eksursi termal).
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                
                {{-- Card 1: IoT Telemetry --}}
                <div class="bg-white/40  backdrop-blur-md rounded-2xl border border-slate-200  p-6 hover:shadow-xl hover:border-primary/30 hover:-translate-y-1.5 transition-all duration-300 flex flex-col gap-4">
                    <div class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center border border-primary/20 shrink-0">
                        <span class="material-symbols-outlined text-primary text-[20px]">sensors</span>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-slate-900 ">IoT Telemetri Presisi</h3>
                        <p class="text-xs text-slate-500  mt-2 leading-relaxed">
                            Pemantauan langsung multi-sensor untuk suhu aktual kargo, tingkat kelembaban, serta gaya guncangan fisik (g-force) yang terdeteksi pada boks.
                        </p>
                    </div>
                </div>

                {{-- Card 2: AI Kinetic Temp --}}
                <div class="bg-white/40  backdrop-blur-md rounded-2xl border border-slate-200  p-6 hover:shadow-xl hover:border-primary/30 hover:-translate-y-1.5 transition-all duration-300 flex flex-col gap-4">
                    <div class="w-10 h-10 rounded-xl bg-tertiary/10 flex items-center justify-center border border-tertiary/20 shrink-0">
                        <span class="material-symbols-outlined text-tertiary text-[20px]">insights</span>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-slate-900 ">Prediksi & Analisis AI</h3>
                        <p class="text-xs text-slate-500  mt-2 leading-relaxed">
                            Algoritma cerdas yang menghitung Mean Kinetic Temperature (MKT) dan memproyeksikan sisa umur zat aktif vaksin berdasarkan riwayat paparan panas.
                        </p>
                    </div>
                </div>

                {{-- Card 3: Geofencing --}}
                <div class="bg-white/40  backdrop-blur-md rounded-2xl border border-slate-200  p-6 hover:shadow-xl hover:border-primary/30 hover:-translate-y-1.5 transition-all duration-300 flex flex-col gap-4">
                    <div class="w-10 h-10 rounded-xl bg-teal-500/10 flex items-center justify-center border border-teal-500/20 shrink-0">
                        <span class="material-symbols-outlined text-teal-650  text-[20px]">location_on</span>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-slate-900 ">Geofencing & Tanda Terima</h3>
                        <p class="text-xs text-slate-500  mt-2 leading-relaxed">
                            Verifikasi kedatangan kurir otomatis dalam radius virtual 50 meter dari faskes tujuan. Otomatis mengunci status perjalanan sebagai 'Selesai'.
                        </p>
                    </div>
                </div>

                {{-- Card 4: WhatsApp & Telegram --}}
                <div class="bg-white/40  backdrop-blur-md rounded-2xl border border-slate-200  p-6 hover:shadow-xl hover:border-primary/30 hover:-translate-y-1.5 transition-all duration-300 flex flex-col gap-4">
                    <div class="w-10 h-10 rounded-xl bg-error/10 flex items-center justify-center border border-error/20 shrink-0">
                        <span class="material-symbols-outlined text-error text-[20px]">campaign</span>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-slate-900 ">Alarm & Notifikasi Instan</h3>
                        <p class="text-xs text-slate-500  mt-2 leading-relaxed">
                            Kirim peringatan otomatis melalui WhatsApp dan bot Telegram kepada dispatcher & kurir begitu terdeteksi anomali suhu rantai dingin.
                        </p>
                    </div>
                </div>

            </div>
        </section>

        {{-- Section 4: How It Works --}}
        <section class="bg-white/30  backdrop-blur-md border border-slate-200/50  rounded-3xl p-8 sm:p-12 space-y-10">
            <div class="text-center max-w-xl mx-auto space-y-2">
                <h2 class="text-2xl font-extrabold text-slate-900  tracking-tight">Bagaimana BIO-GUARD Bekerja</h2>
                <p class="text-xs text-slate-500  leading-relaxed">
                    Alur end-to-end pemantauan logistik medis secara terotomatisasi.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 relative">
                
                {{-- Arrow connector helper (desktop only) --}}
                <div class="hidden md:block absolute top-[40px] left-[15%] right-[15%] h-[2px] bg-slate-200  z-0"></div>

                {{-- Step 1 --}}
                <div class="relative z-10 flex flex-col items-center text-center space-y-3">
                    <div class="w-12 h-12 rounded-full bg-white  border-2 border-primary/50 flex items-center justify-center text-slate-900  font-black text-sm shadow-md">
                        1
                    </div>
                    <h4 class="text-xs font-extrabold uppercase tracking-wider text-slate-800 ">Sensor IoT Aktif</h4>
                    <p class="text-[11px] text-slate-500  leading-relaxed max-w-[200px]">
                        Perangkat mikrokontroler di boks vaksin membaca suhu, kelembaban, dan koordinat GPS.
                    </p>
                </div>

                {{-- Step 2 --}}
                <div class="relative z-10 flex flex-col items-center text-center space-y-3">
                    <div class="w-12 h-12 rounded-full bg-white  border-2 border-primary/50 flex items-center justify-center text-slate-900  font-black text-sm shadow-md">
                        2
                    </div>
                    <h4 class="text-xs font-extrabold uppercase tracking-wider text-slate-800 ">Koneksi Store-Forward</h4>
                    <p class="text-[11px] text-slate-500  leading-relaxed max-w-[200px]">
                        Data dikirim berkala. Jika sinyal putus, data di-buffer lokal dan di-sinkronisasi saat online kembali.
                    </p>
                </div>

                {{-- Step 3 --}}
                <div class="relative z-10 flex flex-col items-center text-center space-y-3">
                    <div class="w-12 h-12 rounded-full bg-white  border-2 border-primary/50 flex items-center justify-center text-slate-900  font-black text-sm shadow-md">
                        3
                    </div>
                    <h4 class="text-xs font-extrabold uppercase tracking-wider text-slate-800 ">Analisis Cloud AI</h4>
                    <p class="text-[11px] text-slate-500  leading-relaxed max-w-[200px]">
                        Backend Laravel mengolah telemetri, menghitung grafik MKT, dan mengevaluasi status kelayakan.
                    </p>
                </div>

                {{-- Step 4 --}}
                <div class="relative z-10 flex flex-col items-center text-center space-y-3">
                    <div class="w-12 h-12 rounded-full bg-white  border-2 border-primary/50 flex items-center justify-center text-slate-900  font-black text-sm shadow-md">
                        4
                    </div>
                    <h4 class="text-xs font-extrabold uppercase tracking-wider text-slate-800 ">Aksi &amp; Resolusi</h4>
                    <p class="text-[11px] text-slate-500  leading-relaxed max-w-[200px]">
                        Peringatan dikirim jika terjadi deviasi, rute dialihkan, dan kedatangan kurir terverifikasi.
                    </p>
                </div>

            </div>
        </section>

    </main>

    {{-- Footer --}}
    <footer class="relative z-10 w-full max-w-7xl mx-auto px-6 py-8 border-t border-slate-200  flex flex-col sm:flex-row items-center justify-between text-xs text-slate-500  gap-4 mt-12 bg-white/10  backdrop-blur-sm sm:backdrop-blur-none">
        <div>
            <span>BIO-GUARD v2.0 Enterprise</span>
            <span class="mx-2">|</span>
            <span>Sistem Kendali Cold Chain Terintegrasi</span>
        </div>
        <div>
            <span>© 2026 Tim BIO-GUARD. Hak Cipta Dilindungi.</span>
        </div>
    </footer>

    {{-- IoT Constellation Particle Background Script --}}
    <script>
        (function() {
            const canvas = document.getElementById('canvas-particles');
            if (!canvas) return;
            const ctx = canvas.getContext('2d');
            
            let particles = [];
            const maxParticles = 80;
            const connectionDist = 120;
            let mouse = { x: null, y: null, radius: 150 };

            function resizeCanvas() {
                canvas.width = window.innerWidth;
                canvas.height = window.innerHeight;
                initParticles();
            }

            class Particle {
                constructor() {
                    this.x = Math.random() * canvas.width;
                    this.y = Math.random() * canvas.height;
                    this.vx = (Math.random() - 0.5) * 0.8;
                    this.vy = (Math.random() - 0.5) * 0.8;
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
                    ctx.fillStyle = isDark ? 'rgba(76, 213, 246, 0.6)' : 'rgba(2, 132, 199, 0.4)';
                    ctx.beginPath();
                    ctx.arc(this.x, this.y, this.radius, 0, Math.PI * 2);
                    ctx.fill();
                }
            }

            function initParticles() {
                particles = [];
                const count = Math.min(maxParticles, Math.floor((canvas.width * canvas.height) / 12000));
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
                            const alpha = (1 - dist / connectionDist) * 0.5;
                            ctx.strokeStyle = isDark ? `rgba(76, 213, 246, ${alpha * 0.3})` : `rgba(2, 132, 199, ${alpha * 0.25})`;
                            ctx.lineWidth = 0.8;
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
                            const mAlpha = (1 - mDist / mouse.radius) * 0.4;
                            ctx.strokeStyle = isDark ? `rgba(76, 213, 246, ${mAlpha * 0.35})` : `rgba(2, 132, 199, ${mAlpha * 0.3})`;
                            ctx.lineWidth = 1;
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

    {{-- Dark/Light Mode Sync Script --}}
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

            // Sync initial state
            updateThemeUI(htmlEl.classList.contains('dark') ? 'dark' : 'light');

            if (themeToggleBtn) {
                themeToggleBtn.addEventListener('click', () => {
                    const currentTheme = htmlEl.classList.contains('dark') ? 'light' : 'dark';
                    applyTheme(currentTheme);
                });
            }
        })();
    </script>
</body>
</html>
