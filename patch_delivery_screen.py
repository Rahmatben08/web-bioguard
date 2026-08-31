import re

with open(r"C:\project pkm\bio_guard\lib\ui\screens\delivery_screen.dart", "r", encoding="utf-8") as f:
    content = f.read()

pattern = r"destLat:\s*-2\.973305,.*?destLng:\s*104\.745582,"
replacement = r"destLat: provider.destinationLatitude ?? -2.973305,\n              destLng: provider.destinationLongitude ?? 104.745582,"

content = re.sub(pattern, replacement, content, flags=re.DOTALL)

with open(r"C:\project pkm\bio_guard\lib\ui\screens\delivery_screen.dart", "w", encoding="utf-8") as f:
    f.write(content)
print("Updated delivery_screen.dart")
