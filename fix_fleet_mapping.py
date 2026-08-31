import re

with open(r'resources/views/dashboard/fleet.blade.php', 'r', encoding='utf-8') as f:
    content = f.read()

pattern = r"'dest_longitude' => \[[^\]]+\]\[\->lokasi_tujuan\] \?\? 104\.7630,"
content = re.sub(pattern, r"'dest_longitude' => ->dest_longitude ?? 104.7630,", content, flags=re.DOTALL)

with open(r'resources/views/dashboard/fleet.blade.php', 'w', encoding='utf-8') as f:
    f.write(content)
print('Fixed dest_longitude mapping')
