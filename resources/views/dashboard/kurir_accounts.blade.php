@extends('layouts.app')

@section('title', 'Kelola Akun Kurir')

@section('content')
<div class="h-[calc(100vh-4rem)] md:h-screen overflow-y-auto bg-background p-6">
    <div class="max-w-7xl mx-auto space-y-6">
        
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h1 class="font-headline-sm text-headline-sm text-on-surface font-bold">Kelola Akun Kurir</h1>
                <p class="text-sm text-on-surface-variant mt-1">Manajemen akses aplikasi untuk armada kurir BIO-GUARD.</p>
            </div>
            <a href="{{ route('fleet') }}" class="px-4 py-2 bg-surface-container-high text-on-surface rounded-lg hover:bg-surface-container-highest transition-colors shadow-sm text-sm font-semibold flex items-center gap-2 border border-outline-variant/30">
                <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                Kembali ke Pelacakan Armada
            </a>
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
        <div class="bg-surface border border-outline-variant/30 rounded-2xl overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-on-surface">
                    <thead class="bg-surface-container text-on-surface-variant uppercase text-xs font-bold">
                        <tr>
                            <th class="px-6 py-4">ID Kurir</th>
                            <th class="px-6 py-4">Nama Kurir</th>
                            <th class="px-6 py-4">No. Kendaraan</th>
                            <th class="px-6 py-4">Status Akun</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant/20">
                        @forelse($kurirs as $kurir)
                            <tr class="hover:bg-surface-container-low/50 transition-colors">
                                <td class="px-6 py-4 font-mono font-bold text-primary">{{ $kurir->id_kurir }}</td>
                                <td class="px-6 py-4 font-semibold">{{ $kurir->nama_lengkap }}</td>
                                <td class="px-6 py-4 font-mono">{{ $kurir->nomor_kendaraan }}</td>
                                <td class="px-6 py-4">
                                    @if(!$kurir->user)
                                        <span class="px-2.5 py-1 bg-surface-container-high text-on-surface-variant text-[10px] uppercase font-bold rounded-full border border-outline-variant/50">Belum Punya Akun</span>
                                    @elseif($kurir->user->is_active)
                                        <span class="px-2.5 py-1 bg-green-500/10 text-green-700 dark:text-green-400 border border-green-500/20 text-[10px] uppercase font-bold rounded-full">Aktif</span>
                                    @else
                                        <span class="px-2.5 py-1 bg-red-500/10 text-red-700 dark:text-red-400 border border-red-500/20 text-[10px] uppercase font-bold rounded-full animate-pulse">Nonaktif</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right space-x-2">
                                    @if(!$kurir->user)
                                        <form action="{{ route('fleet.accounts.create', $kurir->id_kurir) }}" method="POST" class="inline-block">
                                            @csrf
                                            <button type="submit" class="px-3 py-1.5 bg-primary text-on-primary rounded text-xs font-bold hover:bg-primary/90 transition-colors shadow-sm flex items-center gap-1">
                                                <span class="material-symbols-outlined text-[16px]">person_add</span> Buat Akun
                                            </button>
                                        </form>
                                    @else
                                        <!-- Reset Password -->
                                        <form action="{{ route('fleet.accounts.reset', $kurir->id_kurir) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin mereset password untuk kurir ini?');">
                                            @csrf
                                            <button type="submit" class="p-1.5 bg-surface-container-high text-on-surface hover:text-primary rounded transition-colors border border-outline-variant/30" title="Reset Password">
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
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-on-surface-variant">Belum ada armada kurir terdaftar.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection
