<?php $__env->startSection('title', 'Profil Dispatcher Admin'); ?>

<?php $__env->startSection('content'); ?>
<canvas id="canvas-particles" class="fixed inset-0 w-full h-full pointer-events-none z-0"></canvas>

<div class="flex-1 w-full min-h-full p-container-margin space-y-lg relative z-10 max-w-6xl mx-auto">

    
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-md bg-white/40  backdrop-blur-md border border-slate-200  p-6 rounded-2xl shadow-sm hover:shadow-[0_0_25px_rgba(76,213,246,0.12)] hover:border-primary/20 transition-all duration-500 mb-md">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900  font-headline-md">Profil Dispatcher Admin</h1>
            <p class="text-xs font-semibold text-slate-500  mt-1">Kelola identitas operator, foto profil, dan kredensial API IoT Anda.</p>
        </div>
        <div class="text-xs text-slate-400  font-mono">
            ID Sistem: #<?php echo e($user->id); ?>

        </div>
    </div>

    
    <?php if(session('success')): ?>
        <div class="p-4 rounded-xl bg-green-500/10 border border-green-500/20 text-green-600  text-sm font-semibold flex items-center gap-2">
            <span class="material-symbols-outlined">check_circle</span>
            <span><?php echo e(session('success')); ?></span>
        </div>
    <?php endif; ?>

    <?php if($errors->any()): ?>
        <div class="p-4 rounded-xl bg-red-500/10 border border-red-500/20 text-red-600  text-sm font-semibold flex items-start gap-2">
            <span class="material-symbols-outlined shrink-0 mt-0.5">error</span>
            <div>
                <ul class="list-disc pl-3">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-gutter">
        
        
        <div class="lg:col-span-8 space-y-gutter">
            <form action="<?php echo e(route('profile.update')); ?>" method="POST" enctype="multipart/form-data" class="bg-white/40  backdrop-blur-md rounded-2xl border border-slate-200  p-8 shadow-sm hover:shadow-[0_0_30px_rgba(76,213,246,0.15)] hover:border-primary/30 transition-all duration-500 space-y-6">
                <?php echo csrf_field(); ?>
                
                <h3 class="text-lg font-bold text-slate-900  flex items-center gap-sm">
                    <span class="material-symbols-outlined text-primary">person</span>
                    Informasi Akun
                </h3>
                <hr class="border-slate-200 ">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-md">
                    
                    <div class="space-y-2">
                        <label for="name" class="block text-xs font-bold uppercase tracking-wider text-slate-500 ">Nama Lengkap</label>
                        <input type="text" id="name" name="name" value="<?php echo e(old('name', $user->name)); ?>" required
                            class="w-full px-4 py-2.5 bg-white  border border-slate-200  rounded-xl text-slate-900  focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all text-sm font-medium">
                    </div>

                    
                    <div class="space-y-2">
                        <label for="dispatcher_id" class="block text-xs font-bold uppercase tracking-wider text-slate-500 ">ID Dispatcher</label>
                        <input type="text" id="dispatcher_id" name="dispatcher_id" value="<?php echo e(old('dispatcher_id', $user->dispatcher_id)); ?>" placeholder="Contoh: DSP-PLB-2026"
                            class="w-full px-4 py-2.5 bg-white  border border-slate-200  rounded-xl text-slate-900  focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all text-sm font-medium">
                    </div>
                </div>

                
                <div class="space-y-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 ">Alamat Email (Akun Utama)</label>
                    <input type="email" value="<?php echo e($user->email); ?>" readonly
                        class="w-full px-4 py-2.5 bg-slate-100  border border-slate-200  rounded-xl text-slate-400 cursor-not-allowed text-sm font-medium">
                </div>

                
                <div class="space-y-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 ">Ubah Foto Profil</label>
                    <div class="flex items-center gap-md">
                        <div class="w-16 h-16 rounded-xl overflow-hidden bg-slate-100  border border-slate-200  flex items-center justify-center shrink-0">
                            <img id="avatar-preview" 
                                 src="<?php echo e($user->photo && file_exists(public_path($user->photo)) ? asset($user->photo) : 'https://www.gravatar.com/avatar/' . md5($user->email) . '?d=mp&s=150'); ?>" 
                                 alt="Avatar Preview" 
                                 class="w-full h-full object-cover">
                        </div>
                        <div class="min-w-0">
                            <input type="file" id="photo" name="photo" accept="image/*"
                                class="block w-full text-xs text-slate-500  file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20 file:cursor-pointer">
                            <p class="text-[10px] text-slate-400 mt-1">JPEG, PNG, atau WEBP. Maksimal 2MB.</p>
                        </div>
                    </div>
                </div>

                <div class="pt-6">
                    <h3 class="text-lg font-bold text-slate-900  flex items-center gap-sm">
                        <span class="material-symbols-outlined text-primary">lock</span>
                        Ganti Kata Sandi
                    </h3>
                    <hr class="border-slate-200  mt-2 mb-4">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-md">
                    
                    <div class="space-y-2">
                        <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-500 ">Kata Sandi Baru</label>
                        <input type="password" id="password" name="password" placeholder="Kosongkan jika tidak diganti"
                            class="w-full px-4 py-2.5 bg-white  border border-slate-200  rounded-xl text-slate-900  focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all text-sm font-medium">
                    </div>

                    
                    <div class="space-y-2">
                        <label for="password_confirmation" class="block text-xs font-bold uppercase tracking-wider text-slate-500 ">Konfirmasi Kata Sandi Baru</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Ulangi kata sandi baru"
                            class="w-full px-4 py-2.5 bg-white  border border-slate-200  rounded-xl text-slate-900  focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all text-sm font-medium">
                    </div>
                </div>

                <div class="pt-4 flex justify-end">
                    <button type="submit" 
                        class="px-lg py-[10px] bg-primary text-on-primary text-sm font-bold tracking-wide rounded-xl shadow-[0_0_15px_rgba(2,132,199,0.3)] hover:shadow-xl hover:-translate-y-0.5 active:scale-95 transition-all duration-300 ease-out cursor-pointer">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>

        
        <div class="lg:col-span-4 space-y-gutter">
            <div class="bg-white/40  backdrop-blur-md rounded-2xl border border-slate-200  p-8 shadow-sm hover:shadow-[0_0_30px_rgba(76,213,246,0.15)] hover:border-primary/30 transition-all duration-500 flex flex-col gap-6 h-full">
                
                <div>
                    <h3 class="text-lg font-bold text-slate-900  flex items-center gap-sm">
                        <span class="material-symbols-outlined text-primary">key</span>
                        Manajemen Kunci API IoT
                    </h3>
                    <p class="text-xs text-slate-500  mt-1">Gunakan Kunci API ini untuk mengautentikasi pengiriman telemetri sensor ESP32 / Mobile.</p>
                </div>
                <hr class="border-slate-200 ">

                
                <div class="space-y-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 ">IoT API Token</label>
                    <div class="flex gap-2">
                        <div class="relative flex-1">
                            <input type="text" id="api-key-input" value="<?php echo e($user->iot_api_key ?? 'Belum digenerate'); ?>" readonly
                                class="w-full pl-3 pr-10 py-2.5 bg-slate-100  border border-slate-200  rounded-xl text-slate-600  font-mono text-xs select-all">
                            <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 text-[18px]">vpn_key</span>
                        </div>
                        
                        
                        <button type="button" onclick="copyApiKey()" title="Salin Kunci API"
                            class="px-3 rounded-xl border border-slate-200  bg-white  text-slate-700  hover:bg-slate-100 :bg-slate-800 cursor-pointer flex items-center justify-center transition-all duration-300">
                            <span class="material-symbols-outlined text-[20px]" id="copy-icon">content_copy</span>
                        </button>
                    </div>
                    <span id="copy-toast" class="text-[10px] text-green-500 font-bold block h-4 opacity-0 transition-opacity duration-300">Kunci API berhasil disalin ke clipboard!</span>
                </div>

                
                <div class="mt-auto space-y-3">
                    <button type="button" onclick="regenerateApiKey()"
                        class="w-full flex items-center justify-center gap-xs px-md py-[10px] rounded-xl border border-primary/30  bg-primary/5 hover:bg-primary/10 text-primary text-body-sm font-bold active:scale-95 transition-all duration-300 ease-out cursor-pointer">
                        <span class="material-symbols-outlined text-[18px]">autorenew</span>
                        Buat Ulang Kunci API
                    </button>
                    <p class="text-[10px] text-slate-400 leading-relaxed text-center">
                        <strong class="text-amber-500">Peringatan:</strong> Men-generate ulang kunci API akan memutus sambungan simulator pengiriman aktif yang menggunakan token lama sampai token baru dikonfigurasi.
                    </p>
                </div>

            </div>
        </div>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    // Live avatar preview selection
    const photoInput = document.getElementById('photo');
    const avatarPreview = document.getElementById('avatar-preview');

    if (photoInput && avatarPreview) {
        photoInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    avatarPreview.src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });
    }

    // Copy API Key
    function copyApiKey() {
        const input = document.getElementById('api-key-input');
        const icon = document.getElementById('copy-icon');
        const toast = document.getElementById('copy-toast');
        
        if (input && input.value && input.value !== 'Belum digenerate') {
            navigator.clipboard.writeText(input.value).then(() => {
                // Change copy icon to checkmark
                if (icon) icon.textContent = 'check';
                if (toast) toast.classList.remove('opacity-0');

                setTimeout(() => {
                    if (icon) icon.textContent = 'content_copy';
                    if (toast) toast.classList.add('opacity-0');
                }, 2000);
            }).catch(err => {
                console.error('Failed to copy text: ', err);
            });
        }
    }

    // Regenerate API Key via AJAX
    function regenerateApiKey() {
        if (!confirm('Apakah Anda yakin ingin men-generate ulang Kunci API IoT? Token lama Anda tidak akan berfungsi lagi.')) {
            return;
        }

        const input = document.getElementById('api-key-input');
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';

        fetch('<?php echo e(route("profile.regenerate-key")); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(res => {
            if (res.success && res.api_key) {
                if (input) {
                    input.value = res.api_key;
                    
                    // Visual feedback
                    input.classList.add('bg-green-500/10', 'border-green-500');
                    setTimeout(() => {
                        input.classList.remove('bg-green-500/10', 'border-green-500');
                    }, 1000);
                }
                alert('Kunci API IoT berhasil digenerate ulang. Harap update perangkat IoT Anda dengan token baru.');
            } else {
                alert('Gagal meregenerasi kunci API.');
            }
        })
        .catch(err => {
            console.error('Error regenerating API Key:', err);
            alert('Terjadi kesalahan sistem saat menghubungi server.');
        });
    }
</script>


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
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\project pkm\bio_guard_backend\resources\views\dashboard\profil.blade.php ENDPATH**/ ?>