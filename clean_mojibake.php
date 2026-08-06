<?php
// Replace mojibake and random encodings of degree Celsius with &deg;C
$files = [
    'resources/views/dashboard/simulator.blade.php',
    'resources/views/dashboard/monitoring.blade.php',
    'resources/views/dashboard/fleet.blade.php',
    'resources/views/dashboard/sensors.blade.php',
    'resources/views/dashboard/inventory.blade.php',
    'resources/views/dashboard/shipments.blade.php',
    'resources/views/dashboard/audit_pdf.blade.php'
];

foreach ($files as $file) {
    if (file_exists($file)) {
        $content = file_get_contents($file);
        
        // Use regex to match ALL forms of corrupt degrees: Ã,Â°C , Ã‚Â°C , °C , Â°C, etc.
        // Basically match any sequence of non-alphanumeric weird characters followed by C (where C is preceded by degree-like characters)
        // Or simply replace "°C", "Â°C", "Ã,Â°C", "Ã‚Â°C", "ÃƒÆ’Ã‚Â°C"
        
        $content = preg_replace('/[ÃÂÄƒâ€š,‚]+°C/u', '&deg;C', $content);
        $content = preg_replace('/[ÃÂÄƒâ€š,‚]*°C/u', '&deg;C', $content);
        $content = preg_replace('/Â°C/u', '&deg;C', $content);
        
        // Just in case it's literal string
        $content = str_replace('Ã,Â°C', '&deg;C', $content);
        $content = str_replace('Ã‚Â°C', '&deg;C', $content);
        $content = str_replace('Â°C', '&deg;C', $content);
        $content = str_replace('°C', '&deg;C', $content);

        // Also fix the weird emojis in monitoring
        $content = str_replace('ÃƒÆ’Ã‚Â°Ãƒâ€¦Ã‚Â¸Ãƒâ€¦Ã‚Â¡Ãƒâ€šÃ‚Â¨', '🚨', $content);
        $content = str_replace('ÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â¢ÃƒÆ’Ã¢â‚¬Â¦Ãƒâ€šÃ‚Â¡ÃƒÆ’Ã¢â‚¬Å¡Ãƒâ€šÃ‚ÂÃƒÆ’Ã¢â‚¬Å¡Ãƒâ€šÃ‚Â ', '⚠️', $content);
        
        file_put_contents($file, $content);
    }
}
echo "Cleaned all files.\n";
