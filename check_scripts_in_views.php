<?php

$views = ['alerts.blade.php', 'fleet.blade.php', 'sensors.blade.php', 'shipments.blade.php'];
foreach ($views as $view) {
    $path = __DIR__ . '/resources/views/dashboard/' . $view;
    if (!file_exists($path)) continue;
    $content = file_get_contents($path);
    echo "=== $view ===\n";
    if (preg_match_all('/<script\b[^>]*>(.*?)<\/script>/is', $content, $matches)) {
        foreach ($matches[0] as $match) {
            echo substr($match, 0, 300) . "...\n";
        }
    }
    
    // Also check for @push('scripts') ... @endpush
    if (preg_match_all('/@push\(\'scripts\'\)(.*?)@endpush/is', $content, $matches)) {
        foreach ($matches[0] as $match) {
            echo substr($match, 0, 300) . "...\n";
        }
    }
    echo "\n";
}
