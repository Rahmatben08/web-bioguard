<?php
$files = glob('resources/views/dashboard/*.blade.php');
$search = ['Ã‚Â°C', 'Ãƒâ€šÃ‚Â°C', 'Â°C', 'Ãƒâ€šÃ‚Â±', 'Ã‚Â±', 'Â±', 'ÃƒÆ’Ã‚Â¢Ãƒâ€¦Ã‚Â¡Ãƒâ€šÃ‚Â Ãƒâ€šÃ‚Â '];
$replace = ['°C', '°C', '°C', '±', '±', '±', '⚠️ '];
foreach ($files as $file) {
    $content = file_get_contents($file);
    $newContent = str_replace($search, $replace, $content);
    if ($content !== $newContent) {
        file_put_contents($file, $newContent);
        echo "Fixed encoding for $file\n";
    }
}
echo "Done.";
