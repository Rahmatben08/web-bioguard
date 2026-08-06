<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BIO-GUARD - Cetak QR Code Boks: <?php echo e($id_box); ?></title>
    
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&family=JetBrains+Mono:wght@700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">

    
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #081425;
            color: #d8e3fb;
        }
        
        .print-area {
            background-color: #152031;
            border: 1px dashed #3d494c;
        }

        @media print {
            body {
                background-color: #ffffff !important;
                color: #000000 !important;
            }
            .no-print {
                display: none !important;
            }
            .print-area {
                background-color: #ffffff !important;
                border: none !important;
                box-shadow: none !important;
                margin: 0 !important;
                padding: 0 !important;
            }
            .print-text {
                color: #000000 !important;
            }
            /* Force print backgrounds on QR codes if they contain color */
            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
        }
    </style>
</head>
<body class="min-h-screen flex flex-col items-center justify-center p-md">

    
    <div class="no-print mb-lg flex gap-md">
        <a href="<?php echo e(route('dashboard')); ?>" class="inline-flex items-center gap-xs px-md py-sm bg-surface-container border border-outline-variant text-on-surface-variant rounded-xl hover:bg-surface-variant hover:text-on-surface transition-colors">
            <span class="material-symbols-outlined text-[18px]">arrow_back</span>
            Kembali
        </a>
        <button onclick="window.print()" class="inline-flex items-center gap-xs px-md py-sm bg-cyan-500 text-slate-900 font-semibold rounded-xl hover:bg-cyan-400 transition-colors shadow-[0_0_15px_rgba(6,182,212,0.3)]">
            <span class="material-symbols-outlined text-[18px]">print</span>
            Cetak QR Code
        </button>
    </div>

    
    <div class="print-area p-xl rounded-2xl flex flex-col items-center shadow-2xl transition-all duration-300 max-w-sm w-full text-center">
        
        <div class="mb-lg">
            <div class="flex items-center justify-center gap-xs mb-1">
                <span class="material-symbols-outlined text-cyan-400 print-text">local_shipping</span>
                <span class="font-extrabold text-body-lg tracking-wider text-cyan-400 print-text">BIO-GUARD</span>
            </div>
            <span class="text-xs text-on-surface-variant uppercase tracking-widest print-text">RANTAI DINGIN OBAT TERMOLABIL</span>
        </div>

        
        <div class="p-md bg-white rounded-xl shadow-inner mb-lg">
            <?php echo $qrCode; ?>

        </div>

        
        <div>
            <span class="text-xs text-on-surface-variant uppercase tracking-wider print-text">IDENTIFIKASI BOKS FISIK</span>
            <p class="font-mono text-xl font-bold tracking-widest mt-1 text-cyan-300 print-text" style="font-family: 'JetBrains Mono', monospace;">
                <?php echo e($id_box); ?>

            </p>
        </div>
    </div>

    <div class="no-print mt-lg text-center text-xs text-on-surface-variant">
        <p>Gunakan tombol di atas atau tekan <kbd class="px-1.5 py-0.5 bg-surface-container rounded border border-outline-variant">Ctrl + P</kbd> untuk mencetak label.</p>
    </div>

</body>
</html>
<?php /**PATH C:\project pkm\bio_guard_backend\resources\views\dashboard\qr_print.blade.php ENDPATH**/ ?>