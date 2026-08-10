@extends('layouts.app')

@section('title', 'Kelola Akun Kurir')

@section('content')
<div class="flex-1 w-full min-h-full bg-background p-6">
    <div class="max-w-7xl mx-auto space-y-6">
        
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h1 class="font-headline-sm text-headline-sm text-on-surface font-bold">Kelola Akun Kurir</h1>
                <p class="text-sm text-on-surface-variant mt-1">Manajemen akses aplikasi untuk armada kurir BIO-GUARD.</p>
            </div>
            <div class="flex items-center gap-2">
                <button onclick="document.getElementById('modalTambahKurir').classList.remove('hidden')" class="px-3 py-1.5 bg-primary text-on-primary rounded text-xs font-bold hover:bg-primary/90 transition-colors shadow-sm flex items-center gap-1">
                    <span class="material-symbols-outlined text-[16px]">add</span> Tambah Kurir
                </button>
                <a href="{{ route('fleet') }}" class="px-4 py-1.5 bg-surface-container-high text-on-surface rounded hover:bg-surface-container-highest transition-colors shadow-sm text-sm font-semibold flex items-center gap-2 border border-outline-variant/30">
                    <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                    Kembali
                </a>
            </div>
        </div>

        <!-- Search Bar -->
        <div class="relative">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant">search</span>
            <input type="text" id="searchInput" placeholder="Cari berdasarkan ID, Nama, atau No. Kendaraan..." class="w-full bg-surface-container-low border border-outline-variant/50 rounded-xl pl-10 pr-4 py-2.5 text-sm text-on-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
        </div>

        @if(session('success'))
            <div class="bg-green-500/10 border border-green-500/30 text-green-700 dark:text-green-400 p-4 rounded-xl flex items-start gap-3">
                <span class="material-symbols-outlined text-green-600 dark:text-green-500">check_circle</span>
                <p class="text-sm font-medium mt-0.5">{{ session('success') }}</p>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-500/10 border border-red-500/30 text-red-700 dark:text-red-400 p-4 rounded-xl flex items-start gap-3">
                <span class="material-symbols-outlined text-red-600 dark:text-red-500">error</span>
                <p class="text-sm font-medium mt-0.5">{{ session('error') }}</p>
            </div>
        @endif

        @if(session('success_password'))
            <div class="bg-primary/10 border border-primary/30 text-primary p-4 rounded-xl flex items-start gap-3">
                <span class="material-symbols-outlined">key</span>
                <div class="text-sm font-medium mt-0.5 whitespace-pre-line">
                    {{ session('success_password') }}
                </div>
            </div>
        @endif

        <!-- Accounts Table -->
        <x-card noPadding="true" class="overflow-hidden">
            <div class="overflow-x-auto">
                <x-table class="w-full">
                    <thead>
                        <x-table.tr>
                            <x-table.th>ID Kurir</x-table.th>
                            <x-table.th>Nama Kurir</x-table.th>
                            <x-table.th>No. Kendaraan</x-table.th>
                            <x-table.th>Email</x-table.th>
                            <x-table.th>Status Akun</x-table.th>
                            <x-table.th class="text-right">Aksi</x-table.th>
                        </x-table.tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant/20">
                        @forelse($kurirs as $kurir)
                            <x-table.tr class="kurir-row">
                                <x-table.td class="font-mono font-bold text-primary">{{ $kurir->id_kurir }}</x-table.td>
                                <x-table.td class="font-semibold">{{ $kurir->nama_lengkap }}</x-table.td>
                                <x-table.td class="font-mono">{{ $kurir->nomor_kendaraan }}</x-table.td>
                                <x-table.td class="font-medium text-on-surface-variant">{{ $kurir->user ? $kurir->user->email : '-' }}</x-table.td>
                                <x-table.td>
                                    @if(!$kurir->user)
                                        <x-badge color="warning">Belum Punya Akun</x-badge>
                                    @elseif($kurir->user->is_active)
                                        <x-badge color="success">Aktif</x-badge>
                                    @else
                                        <x-badge color="error" class="animate-pulse">Nonaktif</x-badge>
                                    @endif
                                </x-table.td>
                                <x-table.td class="text-right space-x-2">
                                    @if(!$kurir->user)
                                        <form action="{{ route('fleet.accounts.create', $kurir->id_kurir) }}" method="POST" class="inline-block">
                                            @csrf
                                            <button type="submit" class="px-3 py-1.5 bg-primary text-on-primary rounded text-xs font-bold hover:bg-primary/90 transition-colors shadow-sm flex items-center gap-1">
                                                <span class="material-symbols-outlined text-[16px]">person_add</span> Buat Akun
                                            </button>
                                        </form>
                                    @else
                                        <!-- Edit Akun -->
                                        <button type="button" onclick="openEditModal({{ $kurir->id_kurir }}, '{{ $kurir->user->email }}')" class="p-1.5 bg-surface-container-high text-on-surface hover:text-primary rounded transition-colors border border-outline-variant/30" title="Edit Email & Password">
                                            <span class="material-symbols-outlined text-[18px]">edit</span>
                                        </button>
                                        
                                        <!-- Reset Password (Random) -->
                                        <form action="{{ route('fleet.accounts.reset', $kurir->id_kurir) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin mereset password untuk kurir ini secara acak?');">
                                            @csrf
                                            <button type="submit" class="p-1.5 bg-surface-container-high text-on-surface hover:text-primary rounded transition-colors border border-outline-variant/30" title="Reset Password Acak">
                                                <span class="material-symbols-outlined text-[18px]">lock_reset</span>
                                            </button>
                                        </form>
                                        
                                        <!-- Toggle Status -->
                                        <form action="{{ route('fleet.accounts.toggle', $kurir->id_kurir) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin mengubah status akun ini?');">
                                            @csrf
                                            @if($kurir->user->is_active)
                                                <button type="submit" class="p-1.5 bg-red-500/10 text-red-600 hover:bg-red-500/20 rounded transition-colors border border-red-500/30" title="Nonaktifkan Akun">
                                                    <span class="material-symbols-outlined text-[18px]">block</span>
                                                </button>
                                            @else
                                                <button type="submit" class="p-1.5 bg-green-500/10 text-green-600 hover:bg-green-500/20 rounded transition-colors border border-green-500/30" title="Aktifkan Akun">
                                                    <span class="material-symbols-outlined text-[18px]">check_circle</span>
                                                </button>
                                            @endif
                                        </form>
                                    @endif
                                </x-table.td>
                            </x-table.tr>
                        @empty
                            <x-table.tr>
                                <x-table.td colspan="6" class="px-6 py-8 text-center text-on-surface-variant">Belum ada armada kurir terdaftar.</x-table.td>
                            </x-table.tr>
                        @endforelse
                    </tbody>
                </x-table>
            </div>
        </x-card>

    </div>
</div>

<!-- Modal Edit Akun Kurir -->
<div id="modalEditAkun" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-[2000] hidden flex items-center justify-center">
    <div class="bg-surface border border-outline-variant/30 rounded-2xl w-full max-w-md overflow-hidden shadow-2xl relative max-h-[90vh] overflow-y-auto">
        <div class="p-4 border-b border-outline-variant/20 bg-surface-container flex justify-between items-center sticky top-0 z-10">
            <h3 class="font-bold text-on-surface">Edit Email & Password Kurir</h3>
            <button type="button" onclick="document.getElementById('modalEditAkun').classList.add('hidden')" class="text-on-surface-variant hover:text-error transition-colors">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <form id="formEditAkun" action="" method="POST" class="p-5 space-y-4">
            @csrf
            
            <p class="text-xs text-on-surface-variant">Update email atau berikan password baru. Kosongkan password jika tidak ingin menggantinya.</p>

            <div>
                <label class="block text-xs font-bold text-on-surface-variant mb-1">Email Saat Ini</label>
                <input type="email" id="edit_email" name="email" required class="w-full bg-background border border-outline-variant/50 rounded-lg px-3 py-2 text-sm text-on-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
            </div>
            <div>
                <label class="block text-xs font-bold text-on-surface-variant mb-1">Password Baru (Opsional)</label>
                <div class="relative">
                    <input type="password" id="edit_password" name="password" minlength="6" placeholder="Ketik password baru jika ingin diubah..." class="w-full bg-background border border-outline-variant/50 rounded-lg px-3 py-2 text-sm text-on-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all pr-10">
                    <button type="button" onclick="togglePasswordVisibility('edit_password', this)" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none">
                        <span class="material-symbols-outlined text-[20px]">visibility_off</span>
                    </button>
                </div>
            </div>
            <div class="pt-2 flex justify-end gap-2">
                <button type="button" onclick="document.getElementById('modalEditAkun').classList.add('hidden')" class="px-4 py-2 rounded-lg border border-outline-variant text-on-surface-variant hover:bg-surface-container text-sm font-semibold transition-colors">Batal</button>
                <button type="submit" class="px-4 py-2 rounded-lg bg-primary text-on-primary hover:bg-primary/90 text-sm font-bold shadow-[0_4px_12px_rgba(6,182,212,0.3)] transition-all active:scale-95">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Tambah Kurir -->
<div id="modalTambahKurir" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-[2000] {{ $errors->any() ? '' : 'hidden' }} flex items-center justify-center">
    <div class="bg-surface border border-outline-variant/30 rounded-2xl w-full max-w-md overflow-hidden shadow-2xl relative max-h-[90vh] overflow-y-auto">
        <div class="p-4 border-b border-outline-variant/20 bg-surface-container flex justify-between items-center sticky top-0 z-10">
            <h3 class="font-bold text-on-surface">Tambah Kurir & Akun Baru</h3>
            <button type="button" onclick="document.getElementById('modalTambahKurir').classList.add('hidden')" class="text-on-surface-variant hover:text-error transition-colors">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <form action="{{ route('fleet.storeKurir') }}" method="POST" class="p-5 space-y-4">
            @csrf

            @if($errors->any())
                <div class="bg-red-500/10 border border-red-500/30 text-red-700 dark:text-red-400 p-3 rounded-lg text-xs font-medium">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div>
                <label class="block text-xs font-bold text-on-surface-variant mb-1">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required class="w-full bg-background border border-outline-variant/50 rounded-lg px-3 py-2 text-sm text-on-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
            </div>
            <div>
                <label class="block text-xs font-bold text-on-surface-variant mb-1">Nomor Kendaraan</label>
                <input type="text" name="nomor_kendaraan" value="{{ old('nomor_kendaraan') }}" required placeholder="Contoh: BG 1234 XY" class="w-full bg-background border border-outline-variant/50 rounded-lg px-3 py-2 text-sm text-on-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
            </div>
            <div>
                <label class="block text-xs font-bold text-on-surface-variant mb-1">Nomor WhatsApp (Opsional)</label>
                <input type="text" name="no_wa" value="{{ old('no_wa') }}" placeholder="Contoh: 08123456789" class="w-full bg-background border border-outline-variant/50 rounded-lg px-3 py-2 text-sm text-on-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
            </div>
            <hr class="border-outline-variant/30">
            <h4 class="font-bold text-sm text-primary mb-2">Informasi Akun (Untuk Login)</h4>
            <div>
                <label class="block text-xs font-bold text-on-surface-variant mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required placeholder="Contoh: kurir@bioguard.id" class="w-full bg-background border border-outline-variant/50 rounded-lg px-3 py-2 text-sm text-on-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
            </div>
            <div>
                <label class="block text-xs font-bold text-on-surface-variant mb-1">Password</label>
                <input type="password" name="password" required placeholder="Minimal 6 karakter" minlength="6" class="w-full bg-background border border-outline-variant/50 rounded-lg px-3 py-2 text-sm text-on-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
            </div>
            <div class="pt-2 flex justify-end gap-2">
                <button type="button" onclick="document.getElementById('modalTambahKurir').classList.add('hidden')" class="px-4 py-2 rounded-lg border border-outline-variant text-on-surface-variant hover:bg-surface-container text-sm font-semibold transition-colors">Batal</button>
                <button type="submit" class="px-4 py-2 rounded-lg bg-primary text-on-primary hover:bg-primary/90 text-sm font-bold shadow-[0_4px_12px_rgba(6,182,212,0.3)] transition-all active:scale-95">Simpan & Buat Akun</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openEditModal(id, currentEmail) {
        let form = document.getElementById('formEditAkun');
        let emailInput = document.getElementById('edit_email');
        
        form.action = `/armada/akun/${id}/update-akun`;
        emailInput.value = currentEmail;
        
        document.getElementById('modalEditAkun').classList.remove('hidden');
    }

    document.getElementById('searchInput').addEventListener('keyup', function() {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll('.kurir-row');

        rows.forEach(row => {
            let text = row.innerText.toLowerCase();
            row.style.display = text.includes(filter) ? '' : 'none';
        });
    });

    function togglePasswordVisibility(inputId, btn) {
        const input = document.getElementById(inputId);
        const icon = btn.querySelector('.material-symbols-outlined');
        if (input.type === 'password') {
            input.type = 'text';
            icon.textContent = 'visibility';
        } else {
            input.type = 'password';
            icon.textContent = 'visibility_off';
        }
    }
</script>
@endsection
