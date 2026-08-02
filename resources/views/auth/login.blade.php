<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BIO-GUARD | Masuk Portal Admin</title>

    {{-- Inline script to apply theme immediately and prevent screen flash --}}
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

    {{-- Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
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
            animation: float-blob 25s infinite ease-in-out;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-6 text-on-surface antialiased relative overflow-hidden">

    {{-- Canvas Partikel Melayang (IoT Constellation) --}}
    <canvas id="canvas-particles" class="fixed inset-0 w-full h-full pointer-events-none z-0"></canvas>

    {{-- Floating Decorative Mesh Blobs (Professional Medical Palette) --}}
    <div class="absolute top-1/4 left-1/4 w-[500px] h-[500px] rounded-full bg-blue-500/10 dark:bg-blue-500/5 blur-[130px] pointer-events-none animate-blob z-0"></div>
    <div class="absolute bottom-1/4 right-1/4 w-[600px] h-[600px] rounded-full bg-blue-400/10 dark:bg-blue-400/5 blur-[140px] pointer-events-none animate-blob z-0" style="animation-delay: -5s;"></div>
    <div class="absolute top-1/2 left-2/3 w-[450px] h-[450px] rounded-full bg-indigo-500/10 dark:bg-indigo-500/5 blur-[110px] pointer-events-none animate-blob z-0" style="animation-delay: -10s;"></div>

    {{-- Floating Glassmorphism Login Card --}}
    <div class="relative z-10 w-full max-w-md bg-white/80 dark:bg-slate-900/40 backdrop-blur-xl rounded-3xl border border-white/30 dark:border-slate-800/80 p-8 shadow-[0_20px_50px_rgba(0,0,0,0.15)] dark:shadow-[0_20px_50px_rgba(0,0,0,0.4)] transition-all duration-500 hover:shadow-[0_20px_60px_rgba(76,213,246,0.15)] hover:border-primary/30 overflow-hidden">
        {{-- Premium top gradient strip (Medical Teal to Sky) --}}
        <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-blue-600 to-blue-500 dark:from-blue-500 dark:to-blue-400"></div>
        
        {{-- Back to Landing Link --}}
        <div class="flex justify-start mb-4">
            <a href="/" class="flex items-center gap-1 text-slate-500 hover:text-primary dark:text-slate-400 dark:hover:text-primary transition-colors text-xs font-bold">
                <span class="material-symbols-outlined text-[16px]">arrow_back</span>
                Kembali ke Beranda
            </a>
        </div>

        {{-- Brand Logo & Header --}}
        <div class="flex flex-col items-center text-center mb-6">
            <a href="/" class="hover:opacity-90 transition-opacity">
                <img src="{{ asset('images/logo.png') }}?v=7" alt="BIO-GUARD Logo" class="h-20 w-auto object-contain mb-4 select-none dark:drop-shadow-[0_0_15px_rgba(59,130,246,0.6)]">
            </a>
            <h1 class="text-2xl font-extrabold tracking-tight text-slate-900 dark:text-white">BIO-GUARD</h1>
            <p class="text-sm text-slate-600 dark:text-slate-350 mt-1 font-semibold">Pusat Kendali Logistik Medis</p>
        </div>

        {{-- Validation Errors --}}
        @if ($errors->any())
            <div class="mb-5 p-4 rounded-2xl bg-red-500/10 border border-red-500/20 text-red-600 dark:text-error text-xs font-semibold flex items-start gap-2 animate-pulse">
                <span class="material-symbols-outlined text-[16px] shrink-0 mt-0.5">error</span>
                <div>
                    <ul class="list-disc pl-3 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        {{-- Login Form --}}
        <form action="{{ url('/login') }}" method="POST" class="space-y-4">
            @csrf

            {{-- Email Input --}}
            <div class="space-y-1.5">
                <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-350">Alamat Email</label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 dark:text-slate-400 text-[20px]">mail</span>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                        class="w-full pl-12 pr-4 py-3 bg-white/90 dark:bg-slate-950/40 border border-slate-300 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all text-sm font-medium"
                        placeholder="nama@bioguard.id">
                </div>
            </div>

            {{-- Password Input --}}
            <div class="space-y-1.5">
                <div class="flex justify-between items-center">
                    <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-350">Kata Sandi</label>
                </div>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 dark:text-slate-400 text-[20px]">lock</span>
                    <input type="password" id="password" name="password" required
                        class="w-full pl-12 pr-12 py-3 bg-white/90 dark:bg-slate-950/40 border border-slate-300 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all text-sm font-medium"
                        placeholder="••••••••">
                    <button type="button" id="password-toggle" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-500 dark:text-slate-400 hover:text-primary transition-colors focus:outline-none flex items-center justify-center">
                        <span id="password-toggle-icon" class="material-symbols-outlined text-[20px]">visibility</span>
                    </button>
                </div>
            </div>

            {{-- Remember Me --}}
            <div class="flex items-center justify-between pt-1">
                <label class="flex items-center cursor-pointer select-none">
                    <input type="checkbox" name="remember" class="rounded border-slate-300 dark:border-slate-800 bg-white dark:bg-slate-950/40 text-primary focus:ring-primary/50 focus:ring-offset-0 transition-all h-4 w-4">
                    <span class="ml-2 text-xs font-semibold text-slate-700 dark:text-slate-300">Ingat saya di perangkat ini</span>
                </label>
            </div>

            {{-- Submit Button --}}
            <button type="submit" 
                class="w-full py-3 bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 dark:from-blue-500 dark:to-blue-400 dark:hover:from-blue-600 dark:hover:to-blue-500 text-white text-sm font-bold tracking-wide rounded-xl shadow-md hover:shadow-lg hover:-translate-y-0.5 active:scale-[0.98] transition-all duration-300 ease-out cursor-pointer text-center block">
                Masuk Ke Portal
            </button>

        </form>

        {{-- Theme Switcher on Footer --}}
        <div class="mt-6 pt-5 border-t border-slate-300 dark:border-slate-800/60 flex justify-between items-center text-xs text-slate-500 dark:text-slate-350">
            <span>BIO-GUARD v2.0 Enterprise</span>
            <button id="theme-toggle" class="flex items-center gap-1 hover:text-primary transition-colors text-slate-600 dark:text-slate-200">
                <span id="theme-toggle-icon" class="material-symbols-outlined text-[16px]">dark_mode</span>
                <span id="theme-toggle-text">Mode Gelap</span>
            </button>
        </div>
    </div>

    {{-- Scripts --}}
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
                const text = document.getElementById('theme-toggle-text');
                
                if (theme === 'light') {
                    if (icon) icon.textContent = 'light_mode';
                    if (text) text.textContent = 'Mode Terang';
                } else {
                    if (icon) icon.textContent = 'dark_mode';
                    if (text) text.textContent = 'Mode Gelap';
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

            // Password Visibility Toggle
            const passwordInput = document.getElementById('password');
            const passwordToggleBtn = document.getElementById('password-toggle');
            const passwordToggleIcon = document.getElementById('password-toggle-icon');

            if (passwordToggleBtn && passwordInput) {
                passwordToggleBtn.addEventListener('click', () => {
                    if (passwordInput.type === 'password') {
                        passwordInput.type = 'text';
                        passwordToggleIcon.textContent = 'visibility_off';
                    } else {
                        passwordInput.type = 'password';
                        passwordToggleIcon.textContent = 'visibility';
                    }
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
            const maxParticles = 100;
            const connectionDist = 155;
            let mouse = { x: null, y: null, radius: 170 };

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
                    ctx.fillStyle = isDark ? 'rgba(59, 130, 246, 0.6)' : 'rgba(37, 99, 235, 0.4)';
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
                            const alpha = (1 - dist / connectionDist) * 0.55;
                            ctx.strokeStyle = isDark ? `rgba(59, 130, 246, ${alpha * 0.45})` : `rgba(37, 99, 235, ${alpha * 0.4})`;
                            ctx.lineWidth = 0.9;
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
                            const mAlpha = (1 - mDist / mouse.radius) * 0.45;
                            ctx.strokeStyle = isDark ? `rgba(59, 130, 246, ${mAlpha * 0.45})` : `rgba(37, 99, 235, ${mAlpha * 0.4})`;
                            ctx.lineWidth = 1.1;
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
</body>
</html>
