<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>BIO-GUARD - <?php echo $__env->yieldContent('title', 'Pusat Kendali Logistik Medis'); ?></title>

    <script>
        // Tema selalu light
        document.documentElement.classList.remove('dark');
        localStorage.setItem('theme', 'light');
    </script>

    
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>

    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>

    
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=IBM+Plex+Sans:wght@400;500;600;700&family=IBM+Plex+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">

    
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "on-primary": "var(--color-on-primary)",
                        "tertiary": "var(--color-tertiary)",
                        "surface": "var(--color-surface)",
                        "on-tertiary-container": "var(--color-on-tertiary-container)",
                        "on-tertiary-fixed-variant": "var(--color-on-tertiary-fixed-variant)",
                        "surface-container-low": "var(--color-surface-container-low)",
                        "error": "var(--color-error)",
                        "inverse-primary": "var(--color-inverse-primary)",
                        "on-tertiary": "var(--color-on-tertiary)",
                        "surface-container-lowest": "var(--color-surface-container-lowest)",
                        "on-error-container": "var(--color-on-error-container)",
                        "primary-fixed": "var(--color-primary-fixed)",
                        "surface-container-highest": "var(--color-surface-container-highest)",
                        "primary-container": "var(--color-primary-container)",
                        "secondary-fixed": "var(--color-secondary-fixed)",
                        "outline-variant": "var(--color-outline-variant)",
                        "on-primary-container": "var(--color-on-primary-container)",
                        "on-secondary-fixed-variant": "var(--color-on-secondary-fixed-variant)",
                        "on-error": "var(--color-on-error)",
                        "surface-variant": "var(--color-surface-variant)",
                        "error-container": "var(--color-error-container)",
                        "surface-tint": "var(--color-surface-tint)",
                        "surface-container": "var(--color-surface-container)",
                        "primary": "var(--color-primary)",
                        "on-surface-variant": "var(--color-on-surface-variant)",
                        "tertiary-fixed": "var(--color-tertiary-fixed)",
                        "outline": "var(--color-outline)",
                        "surface-dim": "var(--color-surface-dim)",
                        "tertiary-fixed-dim": "var(--color-tertiary-fixed-dim)",
                        "surface-container-high": "var(--color-surface-container-high)",
                        "on-secondary-fixed": "var(--color-on-secondary-fixed)",
                        "on-secondary-container": "var(--color-on-secondary-container)",
                        "inverse-on-surface": "var(--color-inverse-on-surface)",
                        "background": "var(--color-background)",
                        "on-surface": "var(--color-on-surface)",
                        "inverse-surface": "var(--color-inverse-surface)",
                        "secondary-fixed-dim": "var(--color-secondary-fixed-dim)",
                        "secondary-container": "var(--color-secondary-container)",
                        "on-primary-fixed-variant": "var(--color-on-primary-fixed-variant)",
                        "on-tertiary-fixed": "var(--color-on-tertiary-fixed)",
                        "on-primary-fixed": "var(--color-on-primary-fixed)",
                        "tertiary-container": "var(--color-tertiary-container)",
                        "secondary": "var(--color-secondary)",
                        "on-secondary": "var(--color-on-secondary)",
                        "on-background": "var(--color-on-background)",
                        "primary-fixed-dim": "var(--color-primary-fixed-dim)",
                        "surface-bright": "var(--color-surface-bright)"
                    },
                    borderRadius: {
                        "DEFAULT": "0.125rem",
                        "lg": "0.25rem",
                        "xl": "0.5rem",
                        "full": "0.75rem"
                    },
                    spacing: {
                        "md": "16px",
                        "lg": "24px",
                        "gutter": "16px",
                        "sm": "8px",
                        "xl": "40px",
                        "container-margin": "24px",
                        "xs": "4px",
                        "unit": "4px"
                    },
                    fontFamily: {
                        "display-lg": ["Inter"],
                        "headline-sm": ["Inter"],
                        "body-sm": ["Inter"],
                        "body-lg": ["Inter"],
                        "headline-md": ["Inter"],
                        "mono-data": ["Inter"],
                        "body-md": ["Inter"],
                        "label-md": ["Inter"],
                        "headline-lg": ["Inter"]
                    },
                    fontSize: {
                        "display-lg": ["48px", {"lineHeight": "56px", "letterSpacing": "-0.02em", "fontWeight": "700"}],
                        "headline-sm": ["20px", {"lineHeight": "28px", "fontWeight": "600"}],
                        "body-sm": ["14px", {"lineHeight": "20px", "fontWeight": "400"}],
                        "body-lg": ["18px", {"lineHeight": "28px", "fontWeight": "400"}],
                        "headline-md": ["24px", {"lineHeight": "32px", "fontWeight": "600"}],
                        "mono-data": ["14px", {"lineHeight": "20px", "letterSpacing": "-0.01em", "fontWeight": "500"}],
                        "body-md": ["16px", {"lineHeight": "24px", "fontWeight": "400"}],
                        "label-md": ["12px", {"lineHeight": "16px", "letterSpacing": "0.05em", "fontWeight": "600"}],
                        "headline-lg": ["32px", {"lineHeight": "40px", "letterSpacing": "-0.01em", "fontWeight": "600"}]
                    }
                },
            },
        }
    </script>

    <style>
        :root {
            /* Light Mode CSS Variables */
            --color-background: #f1f5f9;
            --color-on-background: #0f172a;
            --color-surface: #ffffff;
            --color-on-surface: #0f172a;
            --color-surface-container: #ffffff;
            --color-surface-container-low: #f8fafc;
            --color-surface-container-lowest: #e2e8f0;
            --color-surface-container-high: #cbd5e1;
            --color-surface-container-highest: #94a3b8;
            --color-surface-variant: #e2e8f0;
            --color-on-surface-variant: #334155;
            --color-outline: #475569;
            --color-outline-variant: #cbd5e1;
            --color-primary: #0284c7;
            --color-primary-container: #bae6fd;
            --color-on-primary: #ffffff;
            --color-on-primary-container: #0369a1;
            --color-tertiary: #ea580c;
            --color-tertiary-container: #ffedd5;
            --color-on-tertiary: #ffffff;
            --color-on-tertiary-container: #c2410c;
            --color-error: #dc2626;
            --color-error-container: #fee2e2;
            --color-on-error: #ffffff;
            --color-on-error-container: #b91c1c;
            --color-surface-bright: #ffffff;
            --color-surface-dim: #e2e8f0;
            
            --color-inverse-primary: #0284c7;
            --color-inverse-surface: #0f172a;
            --color-inverse-on-surface: #f8fafc;
            
            --color-primary-fixed: #bae6fd;
            --color-primary-fixed-dim: #38bdf8;
            --color-on-primary-fixed: #0369a1;
            --color-on-primary-fixed-variant: #0284c7;
            
            --color-secondary: #475569;
            --color-secondary-container: #cbd5e1;
            --color-on-secondary: #ffffff;
            --color-on-secondary-container: #334155;
            --color-secondary-fixed: #e2e8f0;
            --color-secondary-fixed-dim: #cbd5e1;
            --color-on-secondary-fixed: #334155;
            --color-on-secondary-fixed-variant: #475569;
            
            --color-tertiary-fixed: #ffedd5;
            --color-tertiary-fixed-dim: #fdba74;
            --color-on-tertiary-fixed: #c2410c;
            --color-on-tertiary-fixed-variant: #ea580c;
            
            --color-surface-tint: #0284c7;
        }

        .dark {
            /* Dark Mode CSS Variables (Advanced Ergonomic Dark Mode) */
            --color-background: #0f1419;
            --color-on-background: #e2e8f0;
            --color-surface: #0f1419;
            --color-on-surface: #f8fafc;
            --color-surface-container: #1e293b;
            --color-surface-container-low: #151c24;
            --color-surface-container-lowest: #0b0f13;
            --color-surface-container-high: #243249;
            --color-surface-container-highest: #334155;
            --color-surface-variant: #1e293b;
            --color-on-surface-variant: #94a3b8;
            --color-outline: #64748b;
            --color-outline-variant: #334155;
            --color-primary: #2dd4bf; /* Soft Cyan/Teal (Aman) */
            --color-primary-container: #0f766e;
            --color-on-primary: #0f1419;
            --color-on-primary-container: #ccfbf1;
            --color-tertiary: #fbbf24; /* Muted Amber (Warning) */
            --color-tertiary-container: #78350f;
            --color-on-tertiary: #0f1419;
            --color-on-tertiary-container: #fef3c7;
            --color-error: #fb7185; /* Soft Crimson/Rose (Kritis) */
            --color-error-container: #881337;
            --color-on-error: #0f1419;
            --color-on-error-container: #ffe4e6;
            --color-surface-bright: #243249;
            --color-surface-dim: #0f1419;
            
            --color-inverse-primary: #00687a;
            --color-inverse-surface: #d8e3fb;
            --color-inverse-on-surface: #263143;
            
            --color-primary-fixed: #acedff;
            --color-primary-fixed-dim: #4cd7f6;
            --color-on-primary-fixed: #001f26;
            --color-on-primary-fixed-variant: #004e5c;
            
            --color-secondary: #ffb3ad;
            --color-secondary-container: #a40217;
            --color-on-secondary: #68000a;
            --color-on-secondary-container: #ffaea8;
            --color-secondary-fixed: #ffdad7;
            --color-secondary-fixed-dim: #ffb3ad;
            --color-on-secondary-fixed: #410004;
            --color-on-secondary-fixed-variant: #930013;
            
            --color-tertiary-fixed: #ffddb8;
            --color-tertiary-fixed-dim: #ffb95f;
            --color-on-tertiary-fixed: #2a1700;
            --color-on-tertiary-fixed-variant: #653e00;
            
            --color-surface-tint: #4cd7f6;
        }

        /* Pulse Animation for active connections (cyan) */
        @keyframes pulse-cyan {
            0% { box-shadow: 0 0 0 0 rgba(6, 182, 212, 0.4); }
            70% { box-shadow: 0 0 0 6px rgba(6, 182, 212, 0); }
            100% { box-shadow: 0 0 0 0 rgba(6, 182, 212, 0); }
        }
        .animate-bio-pulse {
            animation: pulse-cyan 2s infinite;
        }

        /* Pulse Animation for danger state (red) */
        @keyframes pulse-danger {
            0% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.5); }
            70% { box-shadow: 0 0 0 8px rgba(239, 68, 68, 0); }
            100% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0); }
        }
        .marker-danger-pulse {
            animation: pulse-danger 1.5s infinite;
        }

        /* Sparkline backgrounds */
        .sparkline-safe {
            background: linear-gradient(to right, transparent, rgba(6, 182, 212, 0.1) 50%, rgba(6, 182, 212, 0.3) 100%);
            border-bottom: 2px solid #06b6d4;
        }
        .sparkline-danger {
            background: linear-gradient(to right, transparent, rgba(239, 68, 68, 0.1) 50%, rgba(239, 68, 68, 0.3) 100%);
            border-bottom: 2px solid #ef4444;
        }
        .sparkline-cyan {
            background: linear-gradient(to right, transparent, rgba(76, 213, 246, 0.1) 50%, rgba(76, 213, 246, 0.3) 100%);
            border-bottom: 2px solid #4cd7f6;
        }

        /* Glow Active utilities */
        .glow-active {
            box-shadow: 0 0 8px rgba(6, 182, 212, 0.3);
            border-color: #4cd7f6;
        }

        /* Custom Scrollbar for theme */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: var(--color-surface-container-low);
        }
        ::-webkit-scrollbar-thumb {
            background: var(--color-surface-container-highest);
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: var(--color-outline);
        }

        /* Responsive Leaflet Popup Styling - Premium Glassmorphism */
        .leaflet-popup-content-wrapper {
            background: rgba(21, 32, 49, 0.8) !important;
            backdrop-filter: blur(16px) !important;
            -webkit-backdrop-filter: blur(16px) !important;
            color: #d8e3fb !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            border-radius: 16px !important;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5) !important;
        }
        .light .leaflet-popup-content-wrapper {
            background: rgba(255, 255, 255, 0.85) !important;
            color: #1e293b !important;
            border: 1px solid rgba(0, 0, 0, 0.08) !important;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1) !important;
        }
        .leaflet-popup-tip {
            background: rgba(21, 32, 49, 0.8) !important;
            backdrop-filter: blur(16px) !important;
            -webkit-backdrop-filter: blur(16px) !important;
            border-left: 1px solid rgba(255, 255, 255, 0.1) !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1) !important;
        }
        .light .leaflet-popup-tip {
            background: rgba(255, 255, 255, 0.85) !important;
            border-left: 1px solid rgba(0, 0, 0, 0.08) !important;
            border-bottom: 1px solid rgba(0, 0, 0, 0.08) !important;
        }
        .leaflet-popup-close-button {
            color: var(--color-on-surface-variant) !important;
            font-size: 14px !important;
            padding: 8px !important;
        }
        .leaflet-container {
            background: var(--color-background) !important;
        }
        .dark .leaflet-container .leaflet-tile-container img {
            filter: invert(100%) hue-rotate(180deg) brightness(95%) contrast(90%) !important;
        }
        .dark .leaflet-bar a,
        .dark .leaflet-control-zoom-in,
        .dark .leaflet-control-zoom-out {
            background-color: rgba(21, 32, 49, 0.8) !important;
            backdrop-filter: blur(8px) !important;
            color: var(--color-on-surface) !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
        }
        .dark .leaflet-bar a:hover {
            background-color: var(--color-surface-container-high) !important;
            color: var(--color-primary) !important;
        }

        /* Page transition animations */
        @keyframes page-slide-in {
            from {
                opacity: 0;
                transform: translateX(30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        @keyframes page-slide-out {
            from {
                opacity: 1;
                transform: translateX(0);
            }
            to {
                opacity: 0;
                transform: translateX(-30px);
            }
        }
        .animate-page-slide-in {
            animation: page-slide-in 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
        .animate-page-slide-out {
            animation: page-slide-out 0.3s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        /* Shimmer Loading Animation */
        @keyframes shimmer {
            0% {
                background-position: -200% 0;
            }
            100% {
                background-position: 200% 0;
            }
        }
        .shimmer-loader {
            background: linear-gradient(90deg, 
                var(--color-surface-container-low) 25%, 
                var(--color-surface-container-high) 37%, 
                var(--color-surface-container-low) 63%);
            background-size: 200% 100%;
            animation: shimmer 1.4s ease-infinite;
        }

        /* Glassmorphic variables refinement */
        .backdrop-blur-xl {
            backdrop-filter: blur(24px) saturate(110%);
            -webkit-backdrop-filter: blur(24px) saturate(110%);
        }

        /* Sparkline Pulse Animations */
        @keyframes sparkline-pulse {
            0%, 100% {
                opacity: 0.95;
                box-shadow: 0 0 4px rgba(6, 182, 212, 0.4);
            }
            50% {
                opacity: 0.75;
                box-shadow: 0 0 10px rgba(6, 182, 212, 0.7);
            }
        }
        .animate-sparkline-pulse {
            animation: sparkline-pulse 2s infinite ease-in-out;
        }

        @keyframes sparkline-pulse-danger {
            0%, 100% {
                opacity: 0.95;
                box-shadow: 0 0 4px rgba(239, 68, 68, 0.4);
            }
            50% {
                opacity: 0.75;
                box-shadow: 0 0 12px rgba(239, 68, 68, 0.8);
            }
        }
        .animate-sparkline-pulse-danger {
            animation: sparkline-pulse-danger 1.5s infinite ease-in-out;
        }
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-4px); }
            20%, 40%, 60%, 80% { transform: translateX(4px); }
        }
        .animate-shake {
            animation: shake 0.6s ease-in-out;
        }
        .animate-shake-infinite {
            animation: shake 0.8s infinite ease-in-out;
        }

        /* 1. Telemetry Card Hover Glow Transitions */
        .telemetry-card {
            transition: all 0.35s cubic-bezier(0.25, 0.8, 0.25, 1) !important;
        }
        .telemetry-card:hover {
            transform: translateY(-4px) scale(1.02);
        }
        /* Safe Glow (Cyan) */
        .telemetry-card-glow-safe:hover {
            box-shadow: 0 12px 24px -10px rgba(6, 182, 212, 0.35), 0 8px 16px -8px rgba(6, 182, 212, 0.2) !important;
            border-color: rgba(6, 182, 212, 0.4) !important;
        }
        /* Warning Glow (Amber) */
        .telemetry-card-glow-warning:hover {
            box-shadow: 0 12px 24px -10px rgba(245, 158, 11, 0.35), 0 8px 16px -8px rgba(245, 158, 11, 0.2) !important;
            border-color: rgba(245, 158, 11, 0.4) !important;
        }
        /* Danger Glow (Red) */
        .telemetry-card-glow-danger:hover {
            box-shadow: 0 12px 24px -10px rgba(239, 68, 68, 0.4), 0 8px 16px -8px rgba(239, 68, 68, 0.25) !important;
            border-color: rgba(239, 68, 68, 0.45) !important;
        }

        /* 3. ApexCharts Custom Tooltip Glassmorphism */
        .apexcharts-tooltip {
            background: rgba(21, 32, 49, 0.75) !important;
            backdrop-filter: blur(12px) !important;
            -webkit-backdrop-filter: blur(12px) !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            color: #d8e3fb !important;
            border-radius: 12px !important;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.45) !important;
        }
        .light .apexcharts-tooltip {
            background: rgba(255, 255, 255, 0.85) !important;
            border: 1px solid rgba(0, 0, 0, 0.08) !important;
            color: #1e293b !important;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08) !important;
        }
        .apexcharts-tooltip-title {
            background: rgba(255, 255, 255, 0.05) !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1) !important;
            font-weight: 700 !important;
        }
        .light .apexcharts-tooltip-title {
            background: rgba(0, 0, 0, 0.03) !important;
            border-bottom: 1px solid rgba(0, 0, 0, 0.06) !important;
        }

        /* 4. Sidebar Nav Link Hover & Active Indicator Animations */
        nav a, aside a {
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1) !important;
            position: relative;
        }
        nav a:not([class*="bg-primary/10"]):hover, aside a:not([class*="bg-primary/10"]):hover {
            transform: translateX(6px) scale(1.01);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
        }
        .dark nav a:not([class*="bg-primary/10"]):hover, .dark aside a:not([class*="bg-primary/10"]):hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        /* Smooth Transitions for Light/Dark Theme Switching */
        body,
        aside,
        main,
        header,
        footer,
        .bg-white,
        .bg-slate-50,
        .bg-slate-100,
        .bg-slate-900,
        .border,
        .border-slate-200,
        .border-slate-800,
        .text-slate-900,
        .text-slate-700,
        .text-slate-500,
        .text-on-surface,
        .text-on-surface-variant,
        .telemetry-card,
        .bg-surface-container,
        .bg-surface-container-low,
        .bg-surface-container-high,
        .bg-surface-container-highest {
            transition: background-color 0.4s ease, border-color 0.4s ease, color 0.4s ease, box-shadow 0.4s ease !important;
        }
    </style>
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        /* Custom SweetAlert2 Dark/Light Mode adaptions */
        .swal2-popup.swal2-toast {
            border-radius: 12px !important;
            padding: 12px 16px !important;
        }
        .dark .swal2-popup {
            background-color: #1e293b !important;
            color: #f8fafc !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
        }
        .dark .swal2-title, .dark .swal2-content, .dark .swal2-html-container {
            color: #f8fafc !important;
        }
        .dark .swal2-icon.swal2-success [class^=swal2-success-line] {
            background-color: #22c55e !important;
        }
        .dark .swal2-icon.swal2-success .swal2-success-ring {
            border-color: rgba(34, 197, 94, 0.3) !important;
        }
    </style>
</head>
<body class="bg-background text-on-background min-h-screen flex h-screen overflow-hidden font-body-md antialiased selection:bg-primary/30 selection:text-primary">

    <!-- Mobile Drawer Backdrop -->
    <div id="mobile-drawer-backdrop" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[1000] hidden opacity-0 transition-opacity duration-300 pointer-events-none"></div>

    <!-- Mobile Navigation Drawer -->
    <aside id="mobile-drawer" class="fixed top-0 left-0 h-full w-72 bg-white/95  backdrop-blur-xl border-r border-slate-200  z-[1001] transform -translate-x-full transition-transform duration-300 ease-out flex flex-col py-lg gap-md">
        
        <div class="px-lg pb-md mb-md border-b border-slate-200  flex justify-between items-center">
            <div class="flex items-center gap-sm mb-2 bg-slate-900/5  p-2 rounded-2xl border border-slate-200 ">
                <img src="<?php echo e(asset('images/logo.png')); ?>?v=7" alt="BIO-GUARD Logo" class="h-10 w-auto object-contain (255,255,255,0.7)]">
                <div class="flex flex-col">
                    <span class="font-extrabold text-slate-950  tracking-wide text-sm">BIO-GUARD</span>
                    <span class="text-[9px] text-primary font-bold uppercase tracking-widest">SISTEM MONITORING</span>
                </div>
            </div>
            <button id="close-drawer-btn" class="p-sm text-on-surface-variant hover:text-primary transition-colors cursor-pointer" title="Tutup Menu">
                <span class="material-symbols-outlined text-[24px] align-middle">close</span>
            </button>
        </div>

        
        <div class="flex-1 flex flex-col gap-sm px-md overflow-y-auto pb-4">
            <a class="flex items-center gap-md px-md py-3 rounded-xl <?php echo e((request()->is('/') || request()->is('dashboard*')) ? 'text-primary bg-primary/15 border-l-4 border-primary font-bold shadow-sm group' : 'text-slate-900  hover:bg-slate-100 :bg-slate-800/50 hover:text-slate-900 :text-white'); ?> transition-all duration-300 ease-out active:scale-95" href="<?php echo e(route('dashboard')); ?>">
                <span class="material-symbols-outlined" style="<?php echo e((request()->is('/') || request()->is('dashboard*')) ? "font-variation-settings: 'FILL' 1;" : ''); ?>">dashboard</span>
                <span class="font-label-md">Dasbor</span>
            </a>
            <a class="flex items-center gap-md px-md py-3 rounded-xl <?php echo e(request()->is('pengiriman*') ? 'text-primary bg-primary/15 border-l-4 border-primary font-bold shadow-sm group' : 'text-slate-900  hover:bg-slate-100 :bg-slate-800/50 hover:text-slate-900 :text-white'); ?> transition-all duration-300 ease-out active:scale-95" href="<?php echo e(route('shipments')); ?>">
                <span class="material-symbols-outlined" style="<?php echo e(request()->is('pengiriman*') ? "font-variation-settings: 'FILL' 1;" : ''); ?>">inventory_2</span>
                <span class="font-label-md">Pengiriman</span>
            </a>
            <a class="flex items-center gap-md px-md py-3 rounded-xl <?php echo e(request()->is('sensor*') ? 'text-primary bg-primary/15 border-l-4 border-primary font-bold shadow-sm group' : 'text-slate-900  hover:bg-slate-100 :bg-slate-800/50 hover:text-slate-900 :text-white'); ?> transition-all duration-300 ease-out active:scale-95" href="<?php echo e(route('sensors')); ?>">
                <span class="material-symbols-outlined" style="<?php echo e(request()->is('sensor*') ? "font-variation-settings: 'FILL' 1;" : ''); ?>">sensors</span>
                <span class="font-label-md">Sensor</span>
            </a>
            <a class="flex items-center gap-md px-md py-3 rounded-xl <?php echo e(request()->is('inventaris*') ? 'text-primary bg-primary/15 border-l-4 border-primary font-bold shadow-sm group' : 'text-slate-900  hover:bg-slate-100 :bg-slate-800/50 hover:text-slate-900 :text-white'); ?> transition-all duration-300 ease-out active:scale-95" href="<?php echo e(route('inventory')); ?>">
                <span class="material-symbols-outlined" style="<?php echo e(request()->is('inventaris*') ? "font-variation-settings: 'FILL' 1;" : ''); ?>">ac_unit</span>
                <span class="font-label-md">Inventaris Hub</span>
            </a>
            <a class="flex items-center gap-md px-md py-3 rounded-xl <?php echo e(request()->is('peringatan*') ? 'text-primary bg-primary/15 border-l-4 border-primary font-bold shadow-sm group' : 'text-slate-900  hover:bg-slate-100 :bg-slate-800/50 hover:text-slate-900 :text-white'); ?> transition-all duration-300 ease-out active:scale-95" href="<?php echo e(route('alerts')); ?>">
                <span class="material-symbols-outlined" style="<?php echo e(request()->is('peringatan*') ? "font-variation-settings: 'FILL' 1;" : ''); ?>">warning</span>
                <span class="font-label-md">Peringatan</span>
            </a>
            <a class="flex items-center gap-md px-md py-3 rounded-xl <?php echo e(request()->is('armada') ? 'text-primary bg-primary/15 border-l-4 border-primary font-bold shadow-sm group' : 'text-slate-900  hover:bg-slate-100 :bg-slate-800/50 hover:text-slate-900 :text-white'); ?> transition-all duration-300 ease-out active:scale-95" href="<?php echo e(route('fleet')); ?>">
                <span class="material-symbols-outlined" style="<?php echo e(request()->is('armada') ? "font-variation-settings: 'FILL' 1;" : ''); ?>">local_shipping</span>
                <span class="font-label-md">Armada</span>
            </a>
            <?php if(auth()->check() && auth()->user()->role === 'admin'): ?>
            <a class="flex items-center gap-md px-md py-3 rounded-xl <?php echo e(request()->is('armada/akun*') ? 'text-primary bg-primary/15 border-l-4 border-primary font-bold shadow-sm group' : 'text-slate-900  hover:bg-slate-100 :bg-slate-800/50 hover:text-slate-900 :text-white'); ?> transition-all duration-300 ease-out active:scale-95" href="<?php echo e(route('fleet.accounts')); ?>">
                <span class="material-symbols-outlined" style="<?php echo e(request()->is('armada/akun*') ? "font-variation-settings: 'FILL' 1;" : ''); ?>">manage_accounts</span>
                <span class="font-label-md">Akun Kurir</span>
            </a>
            <?php endif; ?>
            <a class="flex items-center gap-md px-md py-3 rounded-xl <?php echo e(request()->is('simulasi-kurir*') ? 'text-primary bg-primary/15 border-l-4 border-primary font-bold shadow-sm group' : 'text-slate-900  hover:bg-slate-100 :bg-slate-800/50 hover:text-slate-900 :text-white'); ?> transition-all duration-300 ease-out active:scale-95" href="<?php echo e(route('simulator.integrated')); ?>">
                <span class="material-symbols-outlined" style="<?php echo e(request()->is('simulasi-kurir*') ? "font-variation-settings: 'FILL' 1;" : ''); ?>">devices</span>
                <span class="font-label-md">Simulator Kurir</span>
            </a>
            <a class="flex items-center gap-md px-md py-3 rounded-xl <?php echo e(request()->is('simulator*') ? 'text-primary bg-primary/15 border-l-4 border-primary font-bold shadow-sm group' : 'text-slate-900  hover:bg-slate-100 :bg-slate-800/50 hover:text-slate-900 :text-white'); ?> transition-all duration-300 ease-out active:scale-95" href="<?php echo e(route('simulator.standalone')); ?>">
                <span class="material-symbols-outlined" style="<?php echo e(request()->is('simulator*') ? "font-variation-settings: 'FILL' 1;" : ''); ?>">phone_iphone</span>
                <span class="font-label-md">Web Simulator HP</span>
            </a>
            <a class="flex items-center gap-md px-md py-3 rounded-xl <?php echo e(request()->is('profil*') ? 'text-primary bg-primary/15 border-l-4 border-primary font-bold shadow-sm group' : 'text-slate-900  hover:bg-slate-100 :bg-slate-800/50 hover:text-slate-900 :text-white'); ?> transition-all duration-300 ease-out active:scale-95" href="<?php echo e(route('profile')); ?>">
                <span class="material-symbols-outlined" style="<?php echo e(request()->is('profil*') ? "font-variation-settings: 'FILL' 1;" : ''); ?>">account_circle</span>
                <span class="font-label-md">Profil Admin</span>
            </a>
        </div>

        
        <?php if(auth()->guard()->check()): ?>
        <div class="px-md border-t border-slate-200  pt-md mt-auto flex flex-col gap-sm">
            <div class="flex items-center gap-md bg-slate-100/50  border border-slate-200  rounded-xl p-md">
                <img src="<?php echo e(auth()->user()->photo && file_exists(public_path(auth()->user()->photo)) ? asset(auth()->user()->photo) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=0ea5e9&color=fff&rounded=true&bold=true'); ?>" alt="Avatar" class="w-10 h-10 rounded-full object-cover border border-primary/30 shrink-0 shadow-sm">
                <div class="min-w-0 flex-1">
                    <p class="text-xs font-bold text-slate-900  truncate"><?php echo e(auth()->user()->name); ?></p>
                    <p class="text-[9px] text-slate-500 font-mono font-bold mt-0.5 truncate"><?php echo e(auth()->user()->dispatcher_id); ?></p>
                </div>
            </div>
            
            <form action="<?php echo e(route('logout')); ?>" method="POST" class="w-full">
                <?php echo csrf_field(); ?>
                <button type="submit" class="w-full flex items-center justify-center gap-xs px-md py-2 bg-rose-500/10 hover:bg-rose-500 hover:text-white border border-rose-500/20 text-rose-500 text-xs font-bold rounded-xl transition-all duration-300 ease-out active:scale-95 cursor-pointer">
                     <span class="material-symbols-outlined text-[16px] align-middle">logout</span>
                     Keluar Sesi
                </button>
            </form>
        </div>
        <?php endif; ?>

        
        <div class="px-md mt-sm mb-2 text-center shrink-0 <?php echo e(auth()->check() ? '' : 'mt-auto'); ?>">
            <p class="text-[9px] text-slate-500 font-medium leading-relaxed">
                BIO-GUARD Project &copy; 2026<br>
                PKM-KC Program<br>
                Politeknik Negeri Sriwijaya
            </p>
        </div>
    </aside>

    
    <!-- STITCH_AI_SIDEBAR: Ganti dengan gaya sidebar enterprise -->
    <nav class="hidden md:flex flex-col h-screen py-lg gap-md bg-white/80  backdrop-blur-md text-primary font-label-md w-64 border-r border-slate-200  flex-shrink-0">
        
        <div class="px-lg pb-md mb-md border-b border-slate-200  flex flex-col gap-xs">
            <div class="flex items-center gap-sm mb-2 bg-slate-900/5  p-2 rounded-2xl border border-slate-200 ">
                <img src="<?php echo e(asset('images/logo.png')); ?>?v=7" alt="BIO-GUARD Logo" class="h-10 w-auto object-contain (255,255,255,0.7)]">
                <div class="flex flex-col">
                    <span class="font-extrabold text-slate-950  tracking-wide text-sm">BIO-GUARD</span>
                    <span class="text-[9px] text-primary font-bold uppercase tracking-widest">SISTEM MONITORING</span>
                </div>
            </div>
            <span class="uppercase tracking-widest text-[10px] font-semibold text-slate-500">Pusat Logistik Medis</span>
        </div>

        
        <div class="flex-1 flex flex-col gap-sm px-md overflow-y-auto pb-4">
            <a class="flex items-center gap-md px-md py-3 rounded-xl <?php echo e((request()->is('/') || request()->is('dashboard*')) ? 'text-primary bg-primary/15 border-l-4 border-primary font-bold shadow-sm group' : 'text-slate-900  hover:bg-slate-100 :bg-slate-800/50 hover:text-slate-900 :text-white'); ?> transition-all duration-300 ease-out active:scale-95" href="<?php echo e(route('dashboard')); ?>">
                <span class="material-symbols-outlined" style="<?php echo e((request()->is('/') || request()->is('dashboard*')) ? "font-variation-settings: 'FILL' 1;" : ''); ?>">dashboard</span>
                <span class="font-label-md">Dasbor</span>
            </a>
            <a class="flex items-center gap-md px-md py-3 rounded-xl <?php echo e(request()->is('pengiriman*') ? 'text-primary bg-primary/15 border-l-4 border-primary font-bold shadow-sm group' : 'text-slate-900  hover:bg-slate-100 :bg-slate-800/50 hover:text-slate-900 :text-white'); ?> transition-all duration-300 ease-out active:scale-95" href="<?php echo e(route('shipments')); ?>">
                <span class="material-symbols-outlined" style="<?php echo e(request()->is('pengiriman*') ? "font-variation-settings: 'FILL' 1;" : ''); ?>">inventory_2</span>
                <span class="font-label-md">Pengiriman</span>
            </a>
            <a class="flex items-center gap-md px-md py-3 rounded-xl <?php echo e(request()->is('sensor*') ? 'text-primary bg-primary/15 border-l-4 border-primary font-bold shadow-sm group' : 'text-slate-900  hover:bg-slate-100 :bg-slate-800/50 hover:text-slate-900 :text-white'); ?> transition-all duration-300 ease-out active:scale-95" href="<?php echo e(route('sensors')); ?>">
                <span class="material-symbols-outlined" style="<?php echo e(request()->is('sensor*') ? "font-variation-settings: 'FILL' 1;" : ''); ?>">sensors</span>
                <span class="font-label-md">Sensor</span>
            </a>
            <a class="flex items-center gap-md px-md py-3 rounded-xl <?php echo e(request()->is('inventaris*') ? 'text-primary bg-primary/15 border-l-4 border-primary font-bold shadow-sm group' : 'text-slate-900  hover:bg-slate-100 :bg-slate-800/50 hover:text-slate-900 :text-white'); ?> transition-all duration-300 ease-out active:scale-95" href="<?php echo e(route('inventory')); ?>">
                <span class="material-symbols-outlined" style="<?php echo e(request()->is('inventaris*') ? "font-variation-settings: 'FILL' 1;" : ''); ?>">ac_unit</span>
                <span class="font-label-md">Inventaris Hub</span>
            </a>
            <a class="flex items-center gap-md px-md py-3 rounded-xl <?php echo e(request()->is('peringatan*') ? 'text-primary bg-primary/15 border-l-4 border-primary font-bold shadow-sm group' : 'text-slate-900  hover:bg-slate-100 :bg-slate-800/50 hover:text-slate-900 :text-white'); ?> transition-all duration-300 ease-out active:scale-95" href="<?php echo e(route('alerts')); ?>">
                <span class="material-symbols-outlined" style="<?php echo e(request()->is('peringatan*') ? "font-variation-settings: 'FILL' 1;" : ''); ?>">warning</span>
                <span class="font-label-md">Peringatan</span>
            </a>
            <a class="flex items-center gap-md px-md py-3 rounded-xl <?php echo e(request()->is('armada') ? 'text-primary bg-primary/15 border-l-4 border-primary font-bold shadow-sm group' : 'text-slate-900  hover:bg-slate-100 :bg-slate-800/50 hover:text-slate-900 :text-white'); ?> transition-all duration-300 ease-out active:scale-95" href="<?php echo e(route('fleet')); ?>">
                <span class="material-symbols-outlined" style="<?php echo e(request()->is('armada') ? "font-variation-settings: 'FILL' 1;" : ''); ?>">local_shipping</span>
                <span class="font-label-md">Armada</span>
            </a>
            <?php if(auth()->check() && auth()->user()->role === 'admin'): ?>
            <a class="flex items-center gap-md px-md py-3 rounded-xl <?php echo e(request()->is('armada/akun*') ? 'text-primary bg-primary/15 border-l-4 border-primary font-bold shadow-sm group' : 'text-slate-900  hover:bg-slate-100 :bg-slate-800/50 hover:text-slate-900 :text-white'); ?> transition-all duration-300 ease-out active:scale-95" href="<?php echo e(route('fleet.accounts')); ?>">
                <span class="material-symbols-outlined" style="<?php echo e(request()->is('armada/akun*') ? "font-variation-settings: 'FILL' 1;" : ''); ?>">manage_accounts</span>
                <span class="font-label-md">Akun Kurir</span>
            </a>
            <?php endif; ?>
            <a class="flex items-center gap-md px-md py-3 rounded-xl <?php echo e(request()->is('simulasi-kurir*') ? 'text-primary bg-primary/15 border-l-4 border-primary font-bold shadow-sm group' : 'text-slate-900  hover:bg-slate-100 :bg-slate-800/50 hover:text-slate-900 :text-white'); ?> transition-all duration-300 ease-out active:scale-95" href="<?php echo e(route('simulator.integrated')); ?>">
                <span class="material-symbols-outlined" style="<?php echo e(request()->is('simulasi-kurir*') ? "font-variation-settings: 'FILL' 1;" : ''); ?>">devices</span>
                <span class="font-label-md">Simulator Kurir</span>
            </a>
            <a class="flex items-center gap-md px-md py-3 rounded-xl <?php echo e(request()->is('simulator*') ? 'text-primary bg-primary/15 border-l-4 border-primary font-bold shadow-sm group' : 'text-slate-900  hover:bg-slate-100 :bg-slate-800/50 hover:text-slate-900 :text-white'); ?> transition-all duration-300 ease-out active:scale-95" href="<?php echo e(route('simulator.standalone')); ?>">
                <span class="material-symbols-outlined" style="<?php echo e(request()->is('simulator*') ? "font-variation-settings: 'FILL' 1;" : ''); ?>">phone_iphone</span>
                <span class="font-label-md">Web Simulator HP</span>
            </a>
            <a class="flex items-center gap-md px-md py-3 rounded-xl <?php echo e(request()->is('profil*') ? 'text-primary bg-primary/15 border-l-4 border-primary font-bold shadow-sm group' : 'text-slate-900  hover:bg-slate-100 :bg-slate-800/50 hover:text-slate-900 :text-white'); ?> transition-all duration-300 ease-out active:scale-95" href="<?php echo e(route('profile')); ?>">
                <span class="material-symbols-outlined" style="<?php echo e(request()->is('profil*') ? "font-variation-settings: 'FILL' 1;" : ''); ?>">account_circle</span>
                <span class="font-label-md">Profil Admin</span>
            </a>
        </div>

        
        <div class="mt-auto flex flex-col w-full">
            
            <?php if(auth()->guard()->check()): ?>
            <div class="px-md py-4 border-t border-slate-200  bg-slate-50/50 ">
                <div class="flex items-center gap-3 mb-3">
                    <div class="relative shrink-0">
                        <img src="<?php echo e(auth()->user()->photo && file_exists(public_path(auth()->user()->photo)) ? asset(auth()->user()->photo) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=0ea5e9&color=fff&rounded=true&bold=true'); ?>" alt="Avatar" class="w-10 h-10 rounded-full object-cover border border-primary/20 shadow-sm">
                        <div class="absolute bottom-0 right-0 w-2.5 h-2.5 rounded-full bg-green-500 border-2 border-white "></div>
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-xs font-bold text-slate-900  truncate"><?php echo e(auth()->user()->name); ?></p>
                        <p class="text-[9px] text-slate-500 font-mono font-medium truncate"><?php echo e(auth()->user()->dispatcher_id); ?></p>
                    </div>
                    <button id="theme-toggle" class="p-2 text-slate-400 hover:text-primary hover:bg-primary/10 :bg-slate-800 rounded-lg transition-colors cursor-pointer" title="Ubah Tema">
                        <span id="theme-toggle-icon" class="material-symbols-outlined text-[18px]">dark_mode</span>
                    </button>
                </div>
                <form action="<?php echo e(route('logout')); ?>" method="POST" class="w-full">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="w-full flex items-center justify-center gap-2 py-2 text-xs font-semibold text-rose-500 bg-rose-50  hover:bg-rose-500 hover:text-white rounded-lg transition-colors cursor-pointer">
                        <span class="material-symbols-outlined text-[16px]">logout</span>
                        Keluar Sesi
                    </button>
                </form>
            </div>
            <?php else: ?>
            <div class="px-md py-4 border-t border-slate-200 ">
                <button id="theme-toggle" class="w-full flex items-center justify-center gap-2 py-2 rounded-lg bg-slate-100  hover:bg-slate-200 :bg-slate-700 text-slate-700  transition-colors cursor-pointer">
                    <span id="theme-toggle-icon" class="material-symbols-outlined text-[18px]">dark_mode</span>
                    <span class="text-xs font-semibold">Ubah Tema</span>
                </button>
            </div>
            <?php endif; ?>
            
            
            <div class="px-md pb-4 pt-1 text-center bg-slate-50/50 ">
                <p class="text-[9px] text-slate-400 font-medium leading-relaxed">
                    BIO-GUARD Project &copy; 2026
                </p>
            </div>
        </div>
    </nav>

    
    <main class="flex-1 flex flex-col min-w-0 overflow-hidden bg-background">
        
        <header class="md:hidden flex justify-between items-center h-16 px-lg w-full bg-surface-container/80 backdrop-blur-md text-primary font-bold border-b border-outline-variant shadow-sm z-50 flex-shrink-0">
            <div class="flex items-center gap-md">
                <span class="font-headline-sm tracking-tight text-primary">BIO-GUARD</span>
            </div>
            <div class="flex items-center gap-sm">
                <button id="theme-toggle-mobile" class="text-on-surface-variant hover:text-primary transition-colors p-sm rounded-full">
                    <span id="theme-toggle-icon-mobile" class="material-symbols-outlined">dark_mode</span>
                </button>
                <button id="open-drawer-btn" class="text-on-surface-variant hover:text-primary transition-colors p-sm rounded-full cursor-pointer" title="Buka Menu">
                    <span class="material-symbols-outlined">menu</span>
                </button>
            </div>
        </header>

        
        <div id="page-content-wrapper" class="flex-1 flex flex-col overflow-y-auto overflow-x-hidden animate-page-slide-in relative">
            <?php echo $__env->yieldContent('content'); ?>
        </div>
    </main>

    
    <script>
        (function() {
            const themeToggleBtn = document.getElementById('theme-toggle');
            const themeToggleBtnMobile = document.getElementById('theme-toggle-mobile');
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
                // Dispatch event untuk update map tiles dll
                window.dispatchEvent(new CustomEvent('theme-changed', { detail: { theme } }));
            }

            function updateThemeUI(theme) {
                const desktopIcon = document.getElementById('theme-toggle-icon');
                const desktopText = document.getElementById('theme-toggle-text');
                const mobileIcon = document.getElementById('theme-toggle-icon-mobile');
                
                if (theme === 'light') {
                    if (desktopIcon) desktopIcon.textContent = 'light_mode';
                    if (desktopText) desktopText.textContent = 'Mode Terang';
                    if (mobileIcon) mobileIcon.textContent = 'light_mode';
                } else {
                    if (desktopIcon) desktopIcon.textContent = 'dark_mode';
                    if (desktopText) desktopText.textContent = 'Mode Gelap';
                    if (mobileIcon) mobileIcon.textContent = 'dark_mode';
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
            if (themeToggleBtnMobile) {
                themeToggleBtnMobile.addEventListener('click', () => {
                    const currentTheme = htmlEl.classList.contains('dark') ? 'light' : 'dark';
                    applyTheme(currentTheme);
                });
            }
        })();
    </script>

    
    <script>
        (function() {
            const openDrawerBtn = document.getElementById('open-drawer-btn');
            const closeDrawerBtn = document.getElementById('close-drawer-btn');
            const mobileDrawer = document.getElementById('mobile-drawer');
            const mobileDrawerBackdrop = document.getElementById('mobile-drawer-backdrop');

            function openMobileDrawer() {
                mobileDrawerBackdrop.classList.remove('hidden');
                setTimeout(() => {
                    mobileDrawerBackdrop.classList.remove('opacity-0', 'pointer-events-none');
                    mobileDrawerBackdrop.classList.add('opacity-100');
                    mobileDrawer.classList.remove('-translate-x-full');
                }, 50);
            }

            function closeMobileDrawer() {
                mobileDrawer.classList.add('-translate-x-full');
                mobileDrawerBackdrop.classList.remove('opacity-100');
                mobileDrawerBackdrop.classList.add('opacity-0', 'pointer-events-none');
                setTimeout(() => {
                    mobileDrawerBackdrop.classList.add('hidden');
                }, 300);
            }

            if (openDrawerBtn) openDrawerBtn.addEventListener('click', openMobileDrawer);
            if (closeDrawerBtn) closeDrawerBtn.addEventListener('click', closeMobileDrawer);
            if (mobileDrawerBackdrop) mobileDrawerBackdrop.addEventListener('click', closeMobileDrawer);
        })();
    </script>

    
    <script>
        (function() {
            document.addEventListener('DOMContentLoaded', () => {
                const wrapper = document.getElementById('page-content-wrapper');
                if (!wrapper) return;
                
                // Cari semua link navigasi internal
                document.querySelectorAll('nav a, aside a').forEach(link => {
                    link.addEventListener('click', function(e) {
                        // Skip if it is external, target blank, logout form submit, or anchor hash
                        if (
                            this.hostname !== window.location.hostname || 
                            this.getAttribute('target') === '_blank' || 
                            this.href.includes('#') ||
                            this.closest('form')
                        ) {
                            return;
                        }
                        
                        e.preventDefault();
                        const targetUrl = this.href;
                        
                        // Jalankan animasi exit slide-out ke kiri
                        wrapper.classList.remove('animate-page-slide-in');
                        wrapper.classList.add('animate-page-slide-out');
                        
                        // Tunggu animasi selesai (300ms) sebelum pindah URL
                        setTimeout(() => {
                            window.location.href = targetUrl;
                        }, 280);
                    });
                });
            });
        })();
    </script>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\project pkm\bio_guard_backend\resources\views\layouts\app.blade.php ENDPATH**/ ?>