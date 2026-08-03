<?php
$content = file_get_contents('C:\project pkm\bio_guard_backend\storage\framework\views\a347e921d68b3ce02fe94e96309f2eff.php');
$lines = explode(PHP_EOL, $content);
$stack = [];
foreach ($lines as $i => $line) {
    if (preg_match('/<\?php if.*?:\s*\?>/', $line)) {
        $stack[] = $i + 1;
    } elseif (preg_match('/<\?php endif;\s*\?>/', $line)) {
        array_pop($stack);
    }
}
print_r($stack);
