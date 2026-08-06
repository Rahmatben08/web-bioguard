<?php

$files = [
    'resources/views/dashboard/monitoring.blade.php',
    'resources/views/dashboard/fleet.blade.php'
];

foreach ($files as $file) {
    if (!file_exists($file)) continue;
    
    $content = file_get_contents($file);
    
    if (strpos($file, 'monitoring.blade.php') !== false) {
        // Find the L.divIcon block in monitoring
        $search = <<<EOT
        return L.divIcon({
            className: 'custom-marker',
            html: `
                <div style="
                    width: 28px; height: 28px;
EOT;
        $replace = <<<EOT
        return L.divIcon({
            className: '',
            html: `
                <div style="
                    position: absolute;
                    top: 50%; left: 50%;
                    transform: translate(-50%, -50%);
                    width: 32px; height: 32px;
EOT;
        $content = str_replace($search, $replace, $content);
        
        $searchIconAnchor = <<<EOT
            iconSize: [28, 28],
            iconAnchor: [14, 14],
            popupAnchor: [0, -18]
EOT;
        $replaceIconAnchor = <<<EOT
            iconSize: [0, 0],
            iconAnchor: [0, 0],
            popupAnchor: [0, -16]
EOT;
        $content = str_replace($searchIconAnchor, $replaceIconAnchor, $content);
    }
    
    if (strpos($file, 'fleet.blade.php') !== false) {
        $searchFleet = <<<EOT
        let customIcon = L.divIcon({
            html: `<div class="relative flex items-center justify-center w-8 h-8 rounded-full \${colorClass} \${pulseClass} border-2 text-white font-bold text-xs">
                     <span class="material-symbols-outlined text-[16px]">local_shipping</span>
                   </div>`,
            className: 'custom-fleet-marker',
            iconSize: [32, 32],
            iconAnchor: [16, 16]
        });
EOT;
        $replaceFleet = <<<EOT
        let customIcon = L.divIcon({
            html: `<div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 flex items-center justify-center w-8 h-8 rounded-full \${colorClass} \${pulseClass} border-2 text-white font-bold text-xs">
                     <span class="material-symbols-outlined text-[16px]">local_shipping</span>
                   </div>`,
            className: '',
            iconSize: [0, 0],
            iconAnchor: [0, 0]
        });
EOT;
        $content = str_replace($searchFleet, $replaceFleet, $content);
    }
    
    file_put_contents($file, $content);
}
echo "Marker centering fixed in both blade files.\n";
