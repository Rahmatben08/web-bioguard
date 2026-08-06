<?php
$content = file_get_contents('resources/views/dashboard/monitoring.blade.php');
if (preg_match('/const plannedPaths = (\{.*?\});/s', $content, $matches)) {
    // The matched string is valid JS, but might have single quotes for keys
    $jsonString = str_replace("'", '"', $matches[1]);
    file_put_contents('planned_paths.json', $jsonString);
    echo "Saved to planned_paths.json\n";
} else {
    echo "Not found\n";
}
