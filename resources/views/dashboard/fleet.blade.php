@extends('layouts.app')

@section('title', 'Manajemen Armada & Pelacakan Kurir')

@section('content')
<div class="flex-1 w-full h-full flex flex-col md:flex-row overflow-hidden relative bg-background">
    <!-- Sidebar - Active Drivers List -->
    <aside id="fleet-sidebar" class="w-full md:w-96 bg-surface-container border-b md:border-b-0 md:border-r border-outline-variant/30 flex flex-col shrink-0 h-1/3 md:h-full z-20 shadow-2xl overflow-hidden transition-all duration-300">
        <!-- Sidebar Header -->
        <div class="p-lg border-b border-outline-variant/20 bg-surface-container-high/40 shrink-0">
            <nav class="flex justify-between items-center text-label-md text-outline mb-1 gap-2">
                <div>
                    <span>BIO-GUARD</span> / <span class="text-primary font-semibold">Armada Kurir</span>
                </div>
            </nav>
            <h2 class="font-headline-sm text-headline-sm text-on-surface font-bold">Pelacakan Armada Aktif</h2>
            <p class="text-xs text-on-surface-variant mt-1 mb-3">Telemetri GPS & Status Rantai Dingin aktual.</p>
            
            <!-- Search Bar -->
            <div class="relative">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-[16px]">search</span>
                <input type="text" id="searchFleetInput" placeholder="Cari nama, ID box, atau tujuan..." class="w-full bg-background border border-outline-variant/50 rounded-lg pl-9 pr-3 py-1.5 text-xs text-on-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
            </div>
        </div>

        <!-- Drivers List -->
        <div class="flex-1 overflow-y-auto p-4" id="drivers-list-container">
            <x-table class="w-full text-xs">
            @forelse($perjalananAktif as $perjalanan)
                @php
                    $log = $perjalanan->latestLog;
                    $excursion = $perjalanan->getExcursionInfo();
                @endphp
                @php
                    $badgeColor = 'neutral';
                    if ($excursion['status'] === 'Aman') $badgeColor = 'success';
                    elseif ($excursion['status'] === 'Peringatan') $badgeColor = 'warning';
                    elseif ($excursion['status'] === 'Tidak Layak Pakai') $badgeColor = 'error';
                @endphp
                <tr id="driver-card-{{ $perjalanan->id_rute }}" onclick="focusCourier({{ $perjalanan->id_rute }})" class="hover:bg-surface-container-high transition-colors cursor-pointer group">
                    <td class="p-2 border-b border-outline-variant/30">
                        <div class="font-bold text-on-surface truncate">{{ $perjalanan->kurir->nama_lengkap }}</div>
                        <div class="text-[10px] text-on-surface-variant font-mono">{{ $perjalanan->kurir->nomor_kendaraan }}</div>
                    </td>
                    <td class="p-2 border-b border-outline-variant/30 tabular-nums">
                        @if($log)
                            <span class="font-bold text-on-surface" id="temp-val-{{ $perjalanan->id_rute }}">
                                {{ number_format($log->suhu_aktual, 1, ',', '.') }}&deg;C
                            </span>
                        @else
                            <span class="text-on-surface-variant">-</span>
                        @endif
                    </td>
                    <td class="p-2 border-b border-outline-variant/30 text-right">
                        <span id="status-badge-{{ $perjalanan->id_rute }}">
                            <x-badge color="{{ $badgeColor }}" class="{{ $badgeColor !== 'success' ? 'animate-pulse motion-reduce:animate-none' : '' }}">
                                {{ $excursion['status'] === 'Aman' ? 'AMAN' : ($excursion['status'] === 'Peringatan' ? 'PERINGATAN' : 'BAHAYA') }}
                            </x-badge>
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="p-8 text-center text-slate-500">
                        <span class="material-symbols-outlined text-3xl mb-2">local_shipping</span>
                        <div class="text-sm font-bold">Tidak Ada Armada Aktif</div>
                    </td>
                </tr>
            @endforelse
            </x-table>
        </div>
    </aside>

    <!-- Map Container -->
    <main class="flex-1 h-2/3 md:h-full relative z-10 bg-slate-50 dark:bg-slate-900" id="map-container">
        <!-- Floating Persistent Summary Overlay (z-[1000]) -->
        <div class="absolute top-4 left-4 z-[1000] flex flex-col gap-2 pointer-events-none">
            <div class="pointer-events-auto flex items-center gap-2">
                <button onclick="toggleSidebar()" class="w-10 h-10 rounded-full bg-surface-container-high border border-outline-variant/50 shadow-lg flex items-center justify-center text-on-surface hover:bg-surface-container-highest transition-colors cursor-pointer" title="Toggle Sidebar">
                    <span id="sidebar-icon" class="material-symbols-outlined text-[20px]">menu_open</span>
                </button>
                <x-card noPadding="true" class="shadow-lg backdrop-blur-md bg-surface/90 border border-outline-variant/30 flex items-center p-2 rounded-full px-4 gap-4 transition-all duration-300">
                    <div class="flex items-center gap-1.5 text-xs font-semibold text-on-surface">
                        <span class="w-2 h-2 rounded-full bg-primary"></span>
                        <span id="summary-aktif">-- Aktif</span>
                    </div>
                    <div class="w-px h-4 bg-outline-variant/50"></div>
                    <div class="flex items-center gap-1.5 text-xs font-semibold text-error">
                        <span class="w-2 h-2 rounded-full bg-error animate-pulse motion-reduce:animate-none"></span>
                        <span id="summary-alert">-- Peringatan</span>
                    </div>
                </x-card>
            </div>
        </div>

        <div class="w-full h-full overflow-hidden">
            <div id="fleet-map" class="w-full h-full"></div>
        </div>
    </main>
</div>
@endsection

@push('scripts')
<style>
    .marker-danger-pulse {
        box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7);
        animation: marker-danger-pulse 1.5s infinite cubic-bezier(0.66, 0, 0, 1);
    }
    @keyframes marker-danger-pulse {
        0% {
            box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7);
        }
        70% {
            box-shadow: 0 0 0 10px rgba(239, 68, 68, 0);
        }
        100% {
            box-shadow: 0 0 0 0 rgba(239, 68, 68, 0);
        }
    }
</style>
<script>
    let map;
    let markers = {};
    let activePolylines = {};
    let activeDeviationCircles = {};
    let initialLoad = true;

    // Active Reroutes state initialized from DB
    const activeReroutes = {
        @foreach($perjalananAktif as $p)
            '{{ $p->id_rute }}': {{ $p->isRerouted() ? 'true' : 'false' }},
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

    // Planned Reference Routes (Palembang)
    const plannedPaths = {
    "RS Charitas": [[-2.987967,104.756141],[-2.987799,104.756102],[-2.987812,104.756055],[-2.987852,104.755856],[-2.987904,104.755531],[-2.987959,104.755231],[-2.987991,104.755036],[-2.98803,104.754939],[-2.988083,104.754851],[-2.988408,104.754464],[-2.98843,104.754414],[-2.988441,104.754394],[-2.98852,104.754212],[-2.988521,104.75418],[-2.988531,104.753979],[-2.988499,104.753494],[-2.988016,104.753531],[-2.987885,104.753542],[-2.987635,104.753564],[-2.987549,104.753575],[-2.987418,104.753564],[-2.987337,104.753546],[-2.98728,104.753516],[-2.987182,104.753465],[-2.987068,104.753394],[-2.986826,104.753227],[-2.986606,104.753069],[-2.986393,104.752946],[-2.98599,104.752673],[-2.985838,104.75259],[-2.985683,104.752479],[-2.985541,104.752358],[-2.985345,104.752167],[-2.98512,104.751969],[-2.985086,104.751904],[-2.98504,104.751859],[-2.984812,104.751645],[-2.984722,104.751568],[-2.984533,104.751362],[-2.984268,104.751074],[-2.984064,104.750884],[-2.984011,104.750829],[-2.98374,104.750548],[-2.983447,104.750252],[-2.983403,104.750197],[-2.98338,104.750177],[-2.983366,104.750166],[-2.983347,104.750148],[-2.983171,104.749961],[-2.982973,104.749712],[-2.982918,104.749645],[-2.982842,104.74956],[-2.982702,104.749402],[-2.98253,104.749218],[-2.982401,104.749069],[-2.982193,104.748836],[-2.982078,104.748718],[-2.982065,104.748705],[-2.981975,104.748611],[-2.981837,104.748468],[-2.981516,104.748139],[-2.981483,104.748098],[-2.981324,104.747909],[-2.981178,104.74772],[-2.980916,104.74734],[-2.98088,104.747288],[-2.980852,104.747249],[-2.980731,104.747089],[-2.980715,104.747075],[-2.980591,104.746899],[-2.980423,104.746686],[-2.980386,104.74663],[-2.98027,104.746454],[-2.980155,104.746286],[-2.98013,104.746226],[-2.980097,104.746146],[-2.980057,104.746206],[-2.980019,104.746265],[-2.979936,104.74641],[-2.979826,104.746601],[-2.979584,104.747024],[-2.979567,104.747054],[-2.979527,104.747126],[-2.979516,104.747144],[-2.979477,104.747189],[-2.97943,104.747297],[-2.979332,104.747453],[-2.979178,104.747721],[-2.979154,104.747761],[-2.979078,104.74791],[-2.978979,104.748073],[-2.978955,104.74811],[-2.978911,104.748186],[-2.978872,104.74825],[-2.978785,104.748382],[-2.978688,104.748546],[-2.978481,104.748895],[-2.9784,104.749033],[-2.978257,104.749288],[-2.978133,104.749501],[-2.9781,104.749556],[-2.977977,104.749763],[-2.97791,104.749911],[-2.977857,104.750079],[-2.977758,104.750416],[-2.977631,104.750964],[-2.977576,104.751244],[-2.977535,104.751414],[-2.977362,104.752244],[-2.977262,104.752223],[-2.977198,104.752209]],
    "Puskesmas Dempo": [[-2.987967,104.756141],[-2.987799,104.756102],[-2.987812,104.756055],[-2.987852,104.755856],[-2.987904,104.755531],[-2.987959,104.755231],[-2.987991,104.755036],[-2.98803,104.754939],[-2.988083,104.754851],[-2.988408,104.754464],[-2.98843,104.754414],[-2.988441,104.754394],[-2.98852,104.754212],[-2.988521,104.75418],[-2.988531,104.753979],[-2.988499,104.753494],[-2.988016,104.753531],[-2.987885,104.753542],[-2.987635,104.753564],[-2.987549,104.753575],[-2.987418,104.753564],[-2.987337,104.753546],[-2.98728,104.753516],[-2.987182,104.753465],[-2.987068,104.753394],[-2.986826,104.753227],[-2.986606,104.753069],[-2.986393,104.752946],[-2.98599,104.752673],[-2.985838,104.75259],[-2.985683,104.752479],[-2.985541,104.752358],[-2.985345,104.752167],[-2.98512,104.751969],[-2.985086,104.751904],[-2.98504,104.751859],[-2.985001,104.751907],[-2.984972,104.751941],[-2.98497,104.751943],[-2.984837,104.752077],[-2.98483,104.752086],[-2.984634,104.752357],[-2.984591,104.752417],[-2.984569,104.752448],[-2.984443,104.752722],[-2.984425,104.752769],[-2.984205,104.753401],[-2.984092,104.753725],[-2.983942,104.754311],[-2.983934,104.754351],[-2.983913,104.754483],[-2.983895,104.754588],[-2.983726,104.755628],[-2.983634,104.756262],[-2.983576,104.756644],[-2.983438,104.757534],[-2.983429,104.757602],[-2.983418,104.757698],[-2.983399,104.757872],[-2.983398,104.757882],[-2.982986,104.757629],[-2.982557,104.757349],[-2.981433,104.756602],[-2.981198,104.75644],[-2.980765,104.756142],[-2.980619,104.756034],[-2.980509,104.755951],[-2.98031,104.755823],[-2.980011,104.755652],[-2.97986,104.755672],[-2.979825,104.755699],[-2.979796,104.755739],[-2.979782,104.755811],[-2.979891,104.755974],[-2.979939,104.756103],[-2.980221,104.756571],[-2.980322,104.756712],[-2.980649,104.7571],[-2.980661,104.75712],[-2.980692,104.75717],[-2.980714,104.757193],[-2.981031,104.757586],[-2.981193,104.757785],[-2.981631,104.758352],[-2.981867,104.758657],[-2.982039,104.758859],[-2.982104,104.758932],[-2.982486,104.759349],[-2.982624,104.75949],[-2.982725,104.759564],[-2.983072,104.759878],[-2.98335,104.760131],[-2.983727,104.760422],[-2.983766,104.76045],[-2.984114,104.760715],[-2.98492,104.761338],[-2.985144,104.761502],[-2.98538,104.761676],[-2.985512,104.761773],[-2.986008,104.762095],[-2.986881,104.762883],[-2.986677,104.763141]],
    "RSUP Dr. Mohammad Hoesin": [[-2.987967,104.756141],[-2.987799,104.756102],[-2.987812,104.756055],[-2.987852,104.755856],[-2.987904,104.755531],[-2.987959,104.755231],[-2.987991,104.755036],[-2.98803,104.754939],[-2.988083,104.754851],[-2.988408,104.754464],[-2.98843,104.754414],[-2.988441,104.754394],[-2.98852,104.754212],[-2.988521,104.75418],[-2.988531,104.753979],[-2.988499,104.753494],[-2.988016,104.753531],[-2.987885,104.753542],[-2.987635,104.753564],[-2.987549,104.753575],[-2.987418,104.753564],[-2.987337,104.753546],[-2.98728,104.753516],[-2.987182,104.753465],[-2.987068,104.753394],[-2.986826,104.753227],[-2.986606,104.753069],[-2.986393,104.752946],[-2.98599,104.752673],[-2.985838,104.75259],[-2.985683,104.752479],[-2.985541,104.752358],[-2.985345,104.752167],[-2.98512,104.751969],[-2.985086,104.751904],[-2.98504,104.751859],[-2.985001,104.751907],[-2.984972,104.751941],[-2.98497,104.751943],[-2.984837,104.752077],[-2.98483,104.752086],[-2.984634,104.752357],[-2.984591,104.752417],[-2.984569,104.752448],[-2.984443,104.752722],[-2.984425,104.752769],[-2.984205,104.753401],[-2.984092,104.753725],[-2.983942,104.754311],[-2.983934,104.754351],[-2.983913,104.754483],[-2.983895,104.754588],[-2.983726,104.755628],[-2.983634,104.756262],[-2.983576,104.756644],[-2.983438,104.757534],[-2.983429,104.757602],[-2.983418,104.757698],[-2.983399,104.757872],[-2.983398,104.757882],[-2.982986,104.757629],[-2.982557,104.757349],[-2.981433,104.756602],[-2.981198,104.75644],[-2.980765,104.756142],[-2.980619,104.756034],[-2.980509,104.755951],[-2.98031,104.755823],[-2.980011,104.755652],[-2.979782,104.755497],[-2.979558,104.755339],[-2.979147,104.755049],[-2.978864,104.754874],[-2.978652,104.754737],[-2.978549,104.754677],[-2.978421,104.754608],[-2.978129,104.754472],[-2.977832,104.754364],[-2.977673,104.754318],[-2.977235,104.754189],[-2.97705,104.754148],[-2.97693,104.754124],[-2.976906,104.754119],[-2.976792,104.754098],[-2.97676,104.754091],[-2.976549,104.754054],[-2.976424,104.754029],[-2.976225,104.753978],[-2.975961,104.753906],[-2.975738,104.753828],[-2.975526,104.753736],[-2.975357,104.753643],[-2.975219,104.753559],[-2.975069,104.753467],[-2.974865,104.753328],[-2.974581,104.753139],[-2.97452,104.753099],[-2.974432,104.753041],[-2.974089,104.752802],[-2.97386,104.752642],[-2.973783,104.752586],[-2.973492,104.752374],[-2.973308,104.752237],[-2.972952,104.751987],[-2.972905,104.751957],[-2.972894,104.751949],[-2.972604,104.751762],[-2.972198,104.751538],[-2.972045,104.751458],[-2.971957,104.751411],[-2.971941,104.751403],[-2.971811,104.751342],[-2.971801,104.751337],[-2.971585,104.751226],[-2.971387,104.751127],[-2.970637,104.750783],[-2.970304,104.750622],[-2.969967,104.75046],[-2.969617,104.75029],[-2.969315,104.750143],[-2.969053,104.750024],[-2.968981,104.749991],[-2.968813,104.749914],[-2.968619,104.749816],[-2.968583,104.749794],[-2.968437,104.749724],[-2.968041,104.749539],[-2.967621,104.749289],[-2.967558,104.74924],[-2.967537,104.749225],[-2.967441,104.749144],[-2.967316,104.749042],[-2.967258,104.748992],[-2.96721,104.74895],[-2.967154,104.748906],[-2.967038,104.748805],[-2.966976,104.748751],[-2.966899,104.748662],[-2.966752,104.74849],[-2.966705,104.748429],[-2.966518,104.748176],[-2.966322,104.747891],[-2.966216,104.747705],[-2.965985,104.747257],[-2.965793,104.746864],[-2.965634,104.746556],[-2.965545,104.746393],[-2.96547,104.746237],[-2.965192,104.745674],[-2.965164,104.74562],[-2.965068,104.745432],[-2.964883,104.74507],[-2.964748,104.744826],[-2.964704,104.744747],[-2.964575,104.744489],[-2.964451,104.744242],[-2.964389,104.744117],[-2.964246,104.743828],[-2.964124,104.743584],[-2.964047,104.743426],[-2.963965,104.74326],[-2.963819,104.742963],[-2.963696,104.742714],[-2.963547,104.742396],[-2.96351,104.742309],[-2.963407,104.742069],[-2.963209,104.741701],[-2.96315,104.741596],[-2.962951,104.741209],[-2.962923,104.74116],[-2.962886,104.74109],[-2.962781,104.740878],[-2.962769,104.740852],[-2.962538,104.740471],[-2.962368,104.740203],[-2.962348,104.740173],[-2.962244,104.740045],[-2.96222,104.740016],[-2.962204,104.739953],[-2.962163,104.739867],[-2.961882,104.739483],[-2.961656,104.739201],[-2.961646,104.73919],[-2.961455,104.73897],[-2.961268,104.738754],[-2.961206,104.738736],[-2.961176,104.738733],[-2.961149,104.738738],[-2.961123,104.738752],[-2.961087,104.738784],[-2.961071,104.738806],[-2.961067,104.738828],[-2.961067,104.738855],[-2.961085,104.738928],[-2.96127,104.739138],[-2.961312,104.739181],[-2.961587,104.73949],[-2.961822,104.739797],[-2.961991,104.740007],[-2.962061,104.740078],[-2.962147,104.740143],[-2.962495,104.740621],[-2.96263,104.74084],[-2.962824,104.741186],[-2.962861,104.741256],[-2.962899,104.741328],[-2.962978,104.741471],[-2.963013,104.741534],[-2.963066,104.741636],[-2.963146,104.741804],[-2.963311,104.742121],[-2.963463,104.742443],[-2.963544,104.742601],[-2.96362,104.742772],[-2.963774,104.743078],[-2.96389,104.743307],[-2.963967,104.743471],[-2.964164,104.743894],[-2.964292,104.744159],[-2.964412,104.74439],[-2.964519,104.744599],[-2.964893,104.745326],[-2.965132,104.745811],[-2.96517,104.745876],[-2.965379,104.746277],[-2.965449,104.746422],[-2.965702,104.746907],[-2.965842,104.747174],[-2.966023,104.747514],[-2.966226,104.747892],[-2.966116,104.747974],[-2.965419,104.748484],[-2.965339,104.748544],[-2.965293,104.748579],[-2.965335,104.748631],[-2.965339,104.748638],[-2.965387,104.748703],[-2.965657,104.749047],[-2.965973,104.749442],[-2.966216,104.749443],[-2.966468,104.749444],[-2.966462,104.75022],[-2.966456,104.751087],[-2.966754,104.751092],[-2.966774,104.7511],[-2.966786,104.751111],[-2.966799,104.751081],[-2.966804,104.751066],[-2.966806,104.751053],[-2.966808,104.751044],[-2.966809,104.751036],[-2.966809,104.751017],[-2.966811,104.7505]],
    "RSUD Palembang BARI": [[-2.987967,104.756141],[-2.987799,104.756102],[-2.987812,104.756055],[-2.987852,104.755856],[-2.987904,104.755531],[-2.987959,104.755231],[-2.987991,104.755036],[-2.98803,104.754939],[-2.988083,104.754851],[-2.988408,104.754464],[-2.98843,104.754414],[-2.988441,104.754394],[-2.98852,104.754212],[-2.988521,104.75418],[-2.988531,104.753979],[-2.988499,104.753494],[-2.988016,104.753531],[-2.987885,104.753542],[-2.987635,104.753564],[-2.987549,104.753575],[-2.987418,104.753564],[-2.987337,104.753546],[-2.98728,104.753516],[-2.987182,104.753465],[-2.987068,104.753394],[-2.986826,104.753227],[-2.986606,104.753069],[-2.986393,104.752946],[-2.98599,104.752673],[-2.985838,104.75259],[-2.985683,104.752479],[-2.985541,104.752358],[-2.985345,104.752167],[-2.98512,104.751969],[-2.985086,104.751904],[-2.98504,104.751859],[-2.985001,104.751907],[-2.984972,104.751941],[-2.98497,104.751943],[-2.984837,104.752077],[-2.98483,104.752086],[-2.984634,104.752357],[-2.984591,104.752417],[-2.984569,104.752448],[-2.984443,104.752722],[-2.984425,104.752769],[-2.984205,104.753401],[-2.984092,104.753725],[-2.983942,104.754311],[-2.983934,104.754351],[-2.983913,104.754483],[-2.983895,104.754588],[-2.983726,104.755628],[-2.983634,104.756262],[-2.983576,104.756644],[-2.983438,104.757534],[-2.983429,104.757602],[-2.983418,104.757698],[-2.983399,104.757872],[-2.983398,104.757882],[-2.982986,104.757629],[-2.982557,104.757349],[-2.981433,104.756602],[-2.981198,104.75644],[-2.980765,104.756142],[-2.980619,104.756034],[-2.980509,104.755951],[-2.98031,104.755823],[-2.980011,104.755652],[-2.97986,104.755672],[-2.979825,104.755699],[-2.979796,104.755739],[-2.979782,104.755811],[-2.979891,104.755974],[-2.979987,104.755985],[-2.980131,104.755999],[-2.980277,104.756027],[-2.980419,104.756077],[-2.980904,104.756373],[-2.980933,104.756392],[-2.98172,104.756924],[-2.982047,104.757157],[-2.982566,104.757487],[-2.983352,104.758026],[-2.983451,104.758095],[-2.983874,104.758364],[-2.984167,104.758551],[-2.985115,104.759192],[-2.986093,104.759852],[-2.986551,104.760161],[-2.986877,104.760381],[-2.98721,104.760592],[-2.987564,104.760817],[-2.987621,104.760877],[-2.987656,104.760913],[-2.987698,104.760961],[-2.987733,104.760998],[-2.987755,104.761023],[-2.987773,104.761055],[-2.987807,104.761108],[-2.987815,104.761141],[-2.987826,104.761169],[-2.987837,104.761191],[-2.987859,104.761232],[-2.987894,104.761264],[-2.987929,104.761286],[-2.987968,104.761307],[-2.988011,104.761321],[-2.988055,104.761327],[-2.988126,104.761323],[-2.988177,104.761329],[-2.988241,104.761333],[-2.988298,104.761339],[-2.988352,104.761346],[-2.988397,104.761356],[-2.988443,104.761375],[-2.988476,104.761391],[-2.988527,104.76142],[-2.989124,104.761814],[-2.991408,104.763342],[-2.994889,104.765671],[-2.996376,104.766695],[-2.996417,104.76683],[-2.996582,104.766938],[-2.996874,104.767135],[-2.996974,104.767205],[-2.997505,104.767573],[-2.997593,104.767627],[-2.997629,104.767651],[-2.99769,104.767692],[-2.997789,104.767757],[-2.997908,104.76784],[-2.997993,104.767898],[-2.998187,104.768053],[-2.998462,104.768248],[-2.998813,104.768484],[-2.999229,104.768763],[-2.999312,104.768819],[-2.999406,104.768881],[-2.999598,104.769012],[-2.999727,104.769101],[-2.999821,104.769161],[-2.999855,104.769094],[-2.999968,104.768884],[-3.000149,104.768515],[-3.000158,104.768497],[-3.000778,104.767261],[-3.001209,104.766395],[-3.001334,104.766176],[-3.001464,104.765997],[-3.001616,104.765834],[-3.001872,104.765581],[-3.002227,104.765235],[-3.002438,104.765032],[-3.00264,104.764836],[-3.002701,104.764778],[-3.003018,104.764503],[-3.003138,104.764409],[-3.003306,104.764361],[-3.003614,104.764285],[-3.003833,104.76422],[-3.003919,104.764196],[-3.003963,104.76418],[-3.004295,104.764056],[-3.004383,104.764021],[-3.004548,104.763949],[-3.004701,104.763864],[-3.004829,104.763793],[-3.00512,104.763611],[-3.005388,104.763434],[-3.005634,104.763255],[-3.005803,104.763132],[-3.005859,104.763091],[-3.00614,104.762838],[-3.006316,104.762679],[-3.006421,104.762941],[-3.00645,104.763002],[-3.006494,104.763072],[-3.006619,104.763201],[-3.006764,104.763334],[-3.00692,104.763487],[-3.007097,104.763658],[-3.007127,104.763695],[-3.007135,104.763705],[-3.007174,104.763764],[-3.007216,104.763853],[-3.007236,104.763911],[-3.007267,104.764015],[-3.007299,104.764158],[-3.00734,104.764338],[-3.007386,104.764524],[-3.007405,104.764583],[-3.007414,104.764811],[-3.007416,104.764895],[-3.007421,104.765068],[-3.007424,104.765153],[-3.007429,104.765293],[-3.007435,104.765422],[-3.007416,104.765604],[-3.007395,104.765761],[-3.007377,104.765837],[-3.007384,104.765892],[-3.007518,104.765993],[-3.007968,104.766285],[-3.008197,104.766443],[-3.008408,104.766583],[-3.008534,104.766665],[-3.008566,104.766695],[-3.009079,104.767049],[-3.009124,104.76708],[-3.009293,104.767183],[-3.009506,104.767321],[-3.009575,104.767364],[-3.009677,104.767429],[-3.009702,104.767445],[-3.009956,104.767587],[-3.010101,104.767669],[-3.010186,104.767715],[-3.010479,104.767879],[-3.010569,104.76793],[-3.010592,104.767943],[-3.010845,104.768089],[-3.010898,104.768118],[-3.011034,104.768201],[-3.011112,104.768246],[-3.011157,104.768272],[-3.011218,104.768309],[-3.011374,104.768401],[-3.011563,104.768526],[-3.011861,104.76872],[-3.011901,104.768748],[-3.011932,104.768775],[-3.011961,104.768805],[-3.01213,104.768776],[-3.012144,104.768772],[-3.012395,104.768717],[-3.012765,104.768623],[-3.012922,104.768583],[-3.013116,104.768533],[-3.013279,104.768492],[-3.013486,104.768439],[-3.013533,104.768418],[-3.01358,104.768385],[-3.013628,104.768343],[-3.013666,104.768297],[-3.01371,104.768205],[-3.013815,104.767916],[-3.013868,104.767776],[-3.014113,104.767928],[-3.014592,104.768282],[-3.014662,104.768333],[-3.014725,104.768367],[-3.014783,104.768391],[-3.014847,104.768409],[-3.014918,104.768415],[-3.015034,104.768421],[-3.015148,104.768417],[-3.01566,104.768382],[-3.015741,104.768378],[-3.015829,104.768381],[-3.015889,104.76839],[-3.01595,104.768409],[-3.016022,104.768437],[-3.016178,104.768505],[-3.017818,104.76941],[-3.01784,104.769414],[-3.017866,104.769415],[-3.01789,104.769407],[-3.017904,104.769395],[-3.018082,104.768982],[-3.018673,104.76757],[-3.019153,104.766518],[-3.019303,104.766165],[-3.019522,104.765688],[-3.019588,104.765476],[-3.019488,104.765443],[-3.019123,104.765241],[-3.018759,104.765132],[-3.018373,104.765043],[-3.018312,104.765021]],
};

    // Swap planned path dynamically on load if rerouted
    @foreach($perjalananAktif as $p)
        @if($p->isRerouted())
            if (alternativePaths['{{ $p->lokasi_tujuan }}']) {
                plannedPaths['{{ $p->lokasi_tujuan }}'] = alternativePaths['{{ $p->lokasi_tujuan }}'];
            }
        @endif
    @endforeach

    function getDistanceMeters(p1, p2) {
        const R = 6371e3;
        const phi1 = p1[0] * Math.PI / 180;
        const phi2 = p2[0] * Math.PI / 180;
        const deltaPhi = (p2[0] - p1[0]) * Math.PI / 180;
        const deltaLambda = (p2[1] - p1[1]) * Math.PI / 180;

        const a = Math.sin(deltaPhi / 2) * Math.sin(deltaPhi / 2) +
                  Math.cos(phi1) * Math.cos(phi2) *
                  Math.sin(deltaLambda / 2) * Math.sin(deltaLambda / 2);
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
        return R * c;
    }

    function getDistanceToSegment(p, a, b) {
        const x = p[0], y = p[1];
        const x1 = a[0], y1 = a[1];
        const x2 = b[0], y2 = b[1];

        const A = x - x1;
        const B = y - y1;
        const C = x2 - x1;
        const D = y2 - y1;

        const dot = A * C + B * D;
        const lenSq = C * C + D * D;
        let param = -1;
        if (lenSq !== 0) {
            param = dot / lenSq;
        }

        let xx, yy;
        if (param < 0) {
            xx = x1;
            yy = y1;
        } else if (param > 1) {
            xx = x2;
            yy = y2;
        } else {
            xx = x1 + param * C;
            yy = y1 + param * D;
        }
        return getDistanceMeters(p, [xx, yy]);
    }

    function getDistanceToPolyline(p, polyline) {
        let minDistance = Infinity;
        for (let i = 0; i < polyline.length - 1; i++) {
            const dist = getDistanceToSegment(p, polyline[i], polyline[i+1]);
            if (dist < minDistance) {
                minDistance = dist;
            }
        }
        return minDistance;
    }

    // Smooth position interpolation for Leaflet markers
    function animateMarker(marker, startLatLng, endLatLng, durationMs) {
        const start = performance.now();
        const startLat = startLatLng.lat;
        const startLng = startLatLng.lng;
        const endLat = endLatLng[0];
        const endLng = endLatLng[1];

        function step(now) {
            const elapsed = now - start;
            const progress = Math.min(elapsed / durationMs, 1);
            const currentLat = startLat + (endLat - startLat) * progress;
            const currentLng = startLng + (endLng - startLng) * progress;
            marker.setLatLng([currentLat, currentLng]);

            if (progress < 1) {
                requestAnimationFrame(step);
            }
        }
        requestAnimationFrame(step);
    }

    @php
        $activeRoutesData = $perjalananAktif->map(function($p) {
            return [
                'id_rute' => $p->id_rute,
                'nama_kurir' => $p->kurir->nama_lengkap,
                'nomor_kendaraan' => $p->kurir->nomor_kendaraan,
                'no_wa' => $p->kurir->no_wa,
                'nama_kargo' => $p->nama_kargo,
                'id_box' => $p->id_box,
                'lokasi_tujuan' => $p->lokasi_tujuan,
                'latitude' => $p->latestLog ? (float)$p->latestLog->latitude : -2.99,
                'longitude' => $p->latestLog ? (float)$p->latestLog->longitude : 104.75,
                'suhu_aktual' => $p->latestLog ? (float)$p->latestLog->suhu_aktual : 5.0,
                'status' => $p->getExcursionInfo()['status']
            ];
        })->toArray();
    @endphp
    let activeRoutes = {!! json_encode($activeRoutesData) !!};

    document.addEventListener("DOMContentLoaded", function () {
        // Initialize Leaflet Map centered on Palembang
        map = L.map('fleet-map', {
            zoomControl: false
        }).setView([-2.99, 104.756], 13);

        L.control.zoom({ position: 'bottomright' }).addTo(map);

        // Dynamic Theme Map Tiles Setup
        let isDarkTheme = document.documentElement.classList.contains('dark');
        let tileUrl = isDarkTheme ? 'https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png' : 'https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png';

        const tileLayer = L.tileLayer(tileUrl, {
            maxZoom: 20,
            attribution: '&copy; CartoDB'
        }).addTo(map);

        window.addEventListener('theme-changed', (e) => {
            isDarkTheme = e.detail.theme === 'dark';
            const newUrl = isDarkTheme ? 'https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png' : 'https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png';
            tileLayer.setUrl(newUrl);
        });

        // Render initial data and center map
        updateMapData(activeRoutes);

        // Start 2-second location polling
        setInterval(pollLiveLocation, 2000);
    });

    function getPolylineColor(status) {
        if (status === 'Peringatan') {
            return '#ffb95f';
        } else if (status === 'Tidak Layak Pakai') {
            return '#ffb4ab';
        }
        return '#06b6d4';
    }

    function createOrUpdateMarker(route) {
        const ruteId = route.id_rute;
        // Dynamically update reroute state if modified on server
        if (route.is_rerouted) {
            activeReroutes[ruteId] = true;
            if (alternativePaths[route.lokasi_tujuan]) {
                plannedPaths[route.lokasi_tujuan] = alternativePaths[route.lokasi_tujuan];
            }
        }

        let currentLatLng = [route.latitude, route.longitude];
        
        // For BOX-002, simulate deviation
        if (route.id_box === 'BOX-002' && !activeReroutes[ruteId]) {
            currentLatLng = [route.latitude - 0.005, route.longitude + 0.009];
        }

        // Deviation check
        const plannedRoute = plannedPaths[route.lokasi_tujuan];
        let isDeviated = false;
        if (plannedRoute) {
            const dist = getDistanceToPolyline(currentLatLng, plannedRoute);
            if (dist > 300) {
                isDeviated = true;
            }
        }

        // 1. Draw/Update Planned Route Polyline
        if (plannedRoute) {
            const polylineColor = isDeviated ? '#ef4444' : getPolylineColor(route.status);
            const weight = isDeviated ? 5 : 4;
            const dashArray = isDeviated ? '8, 8' : (route.status === 'Tidak Layak Pakai' ? '8, 8' : null);

            if (activePolylines[ruteId]) {
                activePolylines[ruteId].setLatLngs(plannedRoute);
                activePolylines[ruteId].setStyle({
                    color: polylineColor,
                    weight: weight,
                    dashArray: dashArray
                });
            } else {
                activePolylines[ruteId] = L.polyline(plannedRoute, {
                    color: polylineColor,
                    weight: weight,
                    opacity: 0.65,
                    dashArray: dashArray
                }).addTo(map);
            }
        }

        // 2. Draw/Update Deviation Radar Circle
        if (isDeviated) {
            if (activeDeviationCircles[ruteId]) {
                activeDeviationCircles[ruteId].setLatLng(currentLatLng);
            } else {
                const circle = L.circle(currentLatLng, {
                    radius: 120,
                    color: '#ef4444',
                    fillColor: '#ef4444',
                    fillOpacity: 0.15,
                    weight: 1.5
                }).addTo(map);
                
                let growing = true;
                const intervalId = setInterval(() => {
                    if (!circle || !map.hasLayer(circle)) {
                        clearInterval(intervalId);
                        return;
                    }
                    let r = circle.getRadius();
                    if (growing) {
                        r += 5;
                        if (r > 160) growing = false;
                    } else {
                        r -= 5;
                        if (r < 100) growing = true;
                    }
                    circle.setRadius(r);
                }, 80);
                
                activeDeviationCircles[ruteId] = circle;
            }
        } else {
            if (activeDeviationCircles[ruteId]) {
                map.removeLayer(activeDeviationCircles[ruteId]);
                delete activeDeviationCircles[ruteId];
            }
        }

        // 3. Style and create/update marker icon
        let colorClass = 'bg-primary border-primary shadow-[0_0_10px_rgba(6,182,212,0.6)]';
        let pulseClass = '';

        if (isDeviated) {
            colorClass = 'bg-error border-error shadow-[0_0_10px_rgba(239,68,68,0.8)]';
            pulseClass = 'marker-danger-pulse';
        } else if (route.status === 'Peringatan') {
            colorClass = 'bg-tertiary border-tertiary shadow-[0_0_10px_rgba(255,185,95,0.6)]';
            pulseClass = 'animate-pulse';
        } else if (route.status === 'Tidak Layak Pakai') {
            colorClass = 'bg-error border-error shadow-[0_0_10px_rgba(239,68,68,0.8)]';
            pulseClass = 'marker-danger-pulse';
        }

        let customIcon = L.divIcon({
            html: `<div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 flex items-center justify-center w-8 h-8 rounded-full ${colorClass} ${pulseClass} border-2 text-white font-bold text-xs">
                     <span class="material-symbols-outlined text-[16px]">local_shipping</span>
                   </div>`,
            className: '',
            iconSize: [0, 0],
            iconAnchor: [0, 0]
        });

        let tempColor = 'text-cyan-500 dark:text-primary';
        if (route.status === 'Peringatan') {
            tempColor = 'text-amber-500 dark:text-tertiary';
        } else if (route.status === 'Tidak Layak Pakai') {
            tempColor = 'text-red-500 dark:text-error';
        }

        let popupContent = `
            <div class="p-2 text-xs space-y-2 select-none font-sans">
                <div class="flex items-center justify-between border-b border-white/10 pb-1.5 mb-1.5">
                    <span class="font-bold text-sm text-white truncate">${route.nama_kurir}</span>
                    <span class="text-[9px] px-1.5 py-0.5 rounded bg-primary/10 border border-primary/20 text-primary font-mono font-bold">${route.id_box}</span>
                </div>
                <p class="flex items-center gap-1 text-slate-400">
                    <span class="material-symbols-outlined text-[14px] text-primary">local_shipping</span>
                    Armada: <strong class="text-slate-250 font-semibold">${route.nomor_kendaraan}</strong>
                </p>
                <p class="flex items-center gap-1 text-slate-400">
                    <span class="material-symbols-outlined text-[14px] text-primary">call</span>
                    WhatsApp: <strong class="text-slate-250 font-semibold">${route.no_wa || '-'}</strong>
                </p>
                <p class="flex items-center gap-1 text-slate-400">
                    <span class="material-symbols-outlined text-[14px] text-primary">package_2</span>
                    Kargo: <strong class="text-slate-250 font-semibold">${route.nama_kargo || 'Obat Termolabil'}</strong>
                </p>
                <p class="flex items-center gap-1 text-slate-400">
                    <span class="material-symbols-outlined text-[14px] text-primary">pin_drop</span>
                    Tujuan: <strong class="text-slate-250 font-semibold">${route.lokasi_tujuan}</strong>
                </p>
                <p class="flex items-center gap-1 text-slate-400">
                    <span class="material-symbols-outlined text-[14px] text-primary">thermostat</span>
                    Suhu Aktual: <span class="font-black text-sm ${tempColor}">${route.suhu_aktual.toFixed(1).replace('.', ',')}&deg;C</span>
                </p>
                ${isDeviated ? `
                <div class="p-1 px-2 border border-red-500/30 bg-red-500/10 text-red-500 font-bold text-[9px] rounded uppercase tracking-wider animate-pulse flex items-center gap-1">
                    <span class="material-symbols-outlined text-[12px]">warning</span> Deviasi Rute > 300m
                </div>` : ''}
            </div>
        `;

        if (markers[ruteId]) {
            // Update Marker coordinates smoothly if changed
            const oldLatLng = markers[ruteId].getLatLng();
            if (oldLatLng.lat !== currentLatLng[0] || oldLatLng.lng !== currentLatLng[1]) {
                animateMarker(markers[ruteId], oldLatLng, currentLatLng, 1000);
            }
            markers[ruteId].setIcon(customIcon);
            markers[ruteId].setPopupContent(popupContent);
        } else {
            // Create New Marker
            let marker = L.marker(currentLatLng, { icon: customIcon }).addTo(map);
            marker.bindPopup(popupContent, {
                maxWidth: 280,
                closeButton: false
            });
            
            // Open on hover, close on mouseout
            marker.on('mouseover', function() {
                this.openPopup();
            });
            marker.on('mouseout', function() {
                this.closePopup();
            });

            markers[ruteId] = marker;
        }
    }

    function updateMapData(routesList) {
        let bounds = [];
        routesList.forEach(route => {
            if (route.latitude && route.longitude) {
                let currentLatLng = [route.latitude, route.longitude];
                if (route.id_box === 'BOX-002') {
                    currentLatLng = [route.latitude - 0.005, route.longitude + 0.009];
                }
                bounds.push(currentLatLng);
                createOrUpdateMarker(route);
            }
        });

        if (bounds.length > 0 && initialLoad) {
            map.fitBounds(bounds, { padding: [50, 50], maxZoom: 15 });
            initialLoad = false;
        }
    }

    function pollLiveLocation() {
        fetch('{{ route("fleet.live") }}')
            .then(response => response.json())
            .then(res => {
                if (res.success && res.data) {
                    // Update Map
                    updateMapData(res.data.map(route => {
                        return {
                            id_rute: route.id_rute,
                            nama_kurir: route.nama_kurir,
                            nomor_kendaraan: route.nomor_kendaraan,
                            no_wa: route.no_wa,
                            nama_kargo: route.nama_kargo,
                            id_box: route.id_box,
                            lokasi_tujuan: route.lokasi_tujuan,
                            latitude: parseFloat(route.latitude),
                            longitude: parseFloat(route.longitude),
                            suhu_aktual: parseFloat(route.suhu_aktual),
                            status: route.excursion_status
                        };
                    }));

                    // Update Sidebar values dynamically
                    if (res.stats) {
                        const aktifEl = document.getElementById('summary-aktif');
                        const alertEl = document.getElementById('summary-alert');
                        if (aktifEl) aktifEl.textContent = `${res.stats.total_kurir_aktif} Aktif`;
                        if (alertEl) alertEl.textContent = `${res.stats.alert_count} Peringatan`;
                    }
                    
                    res.data.forEach(route => {
                        const tempEl = document.getElementById(`temp-val-${route.id_rute}`);
                        if (tempEl) {
                            const newText = route.suhu_aktual.toFixed(1).replace('.', ',') + '&deg;C';
                            if (tempEl.textContent.trim() !== newText) {
                                tempEl.textContent = newText;
                                tempEl.classList.add('text-primary', 'transition-colors', 'duration-300');
                                setTimeout(() => tempEl.classList.remove('text-primary'), 500);
                            }
                        }

                        const badgeEl = document.getElementById(`status-badge-${route.id_rute}`);
                        if (badgeEl) {
                            let content = '';
                            if (route.excursion_status === 'Aman') {
                                content = `<span class="w-1.5 h-1.5 rounded-full bg-primary"></span> Rantai Dingin Aman`;
                                badgeEl.className = 'inline-flex items-center gap-1 text-[10px] font-semibold text-primary transition-colors duration-300';
                            } else if (route.excursion_status === 'Peringatan') {
                                content = `<span class="w-1.5 h-1.5 rounded-full bg-tertiary animate-pulse motion-reduce:animate-none"></span> Peringatan Dini`;
                                badgeEl.className = 'inline-flex items-center gap-1 text-[10px] font-semibold text-tertiary transition-colors duration-300';
                            } else {
                                content = `<span class="w-1.5 h-1.5 rounded-full bg-error animate-pulse motion-reduce:animate-none"></span> Bahaya: Ekskursi Suhu`;
                                badgeEl.className = 'inline-flex items-center gap-1 text-[10px] font-semibold text-error transition-colors duration-300';
                            }
                            badgeEl.innerHTML = content;
                        }
                    });
                }
            })
            .catch(err => console.error('Error polling live locations:', err));
    }

    function focusCourier(id_rute) {
        if (markers[id_rute]) {
            let latlng = markers[id_rute].getLatLng();
            map.setView(latlng, 15, { animate: true, duration: 1 });
            markers[id_rute].openPopup();
        }
    }

    document.getElementById('searchFleetInput')?.addEventListener('keyup', function() {
        let filter = this.value.toLowerCase();
        let cards = document.querySelectorAll('.fleet-driver-card');

        cards.forEach(card => {
            let text = card.innerText.toLowerCase();
            card.style.display = text.includes(filter) ? '' : 'none';
        });
    });

    function toggleSidebar() {
        const sidebar = document.getElementById('fleet-sidebar');
        const icon = document.getElementById('sidebar-icon');
        
        if (sidebar.classList.contains('md:w-0')) {
            sidebar.classList.remove('md:w-0', 'w-0', 'h-0', 'opacity-0', 'border-none');
            sidebar.classList.add('md:w-96', 'w-full', 'h-1/3', 'md:h-full');
            icon.textContent = 'menu_open';
        } else {
            sidebar.classList.add('md:w-0', 'w-0', 'h-0', 'opacity-0', 'border-none');
            sidebar.classList.remove('md:w-96', 'w-full', 'h-1/3', 'md:h-full');
            icon.textContent = 'menu';
        }
        
        // Let transition finish before invalidating map size
        setTimeout(() => {
            if (typeof map !== 'undefined' && map) {
                map.invalidateSize();
            }
        }, 300);
    }
</script>
@endpush
