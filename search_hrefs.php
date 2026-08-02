<?php

function scanDirRecursive($dir, &$results = []) {
    $files = scandir($dir);
    foreach ($files as $key => $value) {
        $path = realpath($dir . DIRECTORY_SEPARATOR . $value);
        if (!is_dir($path)) {
            if (preg_match('/\.(php|html|js)$/', $path)) {
                $results[] = $path;
            }
        } else if ($value != "." && $value != ".." && $value != "vendor" && $value != "node_modules" && $value != ".git" && $value != "storage") {
            scanDirRecursive($path, $results);
        }
    }
    return $results;
}

$files = scanDirRecursive(__DIR__);
$occurrences = [];

foreach ($files as $file) {
    if (basename($file) === 'search_hrefs.php') continue;
    $content = file_get_contents($file);
    if (preg_match('/href=[\'"]\/?(shipments|sensors|alerts|fleet)/', $content)) {
        $lines = explode("\n", $content);
        foreach ($lines as $num => $line) {
            if (preg_match('/href=[\'"]\/?(shipments|sensors|alerts|fleet)/', $line)) {
                $occurrences[] = [
                    'file' => str_replace(__DIR__, '', $file),
                    'line' => $num + 1,
                    'content' => trim($line)
                ];
            }
        }
    }
}

echo json_encode($occurrences, JSON_PRETTY_PRINT);
