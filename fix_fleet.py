with open('resources/views/dashboard/fleet.blade.php', 'r', encoding='utf-8') as f:
    lines = f.readlines()

out = []
skip = False
for line in lines:
    if "'dest_latitude' => [" in line:
        skip = True
        out.append("                  'dest_latitude' => \\App\\Models\\InventoryHub::where('nama', ->lokasi_tujuan)->value('latitude') ?? -2.9865,\n")
    elif "'dest_longitude' => [" in line:
        skip = True
        out.append("                  'dest_longitude' => \\App\\Models\\InventoryHub::where('nama', ->lokasi_tujuan)->value('longitude') ?? 104.7630,\n")
    elif skip and "][->lokasi_tujuan]" in line:
        skip = False
    elif not skip:
        out.append(line)

with open('resources/views/dashboard/fleet.blade.php', 'w', encoding='utf-8') as f:
    f.writelines(out)
