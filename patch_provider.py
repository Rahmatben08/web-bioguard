import re

with open(r"C:\project pkm\bio_guard\lib\services\delivery_provider.dart", "r", encoding="utf-8") as f:
    content = f.read()

# Add getters for destLat and destLng
pattern = r"String\? get destinationName => _activeTask\?\.destinationName \?\? _activeRouteData\?\['lokasi_tujuan'\];"
replacement = r"""String? get destinationName => _activeTask?.destinationName ?? _activeRouteData?['lokasi_tujuan'];
  double? get destinationLatitude => _activeTask?.destinationLatitude ?? _activeRouteData?['latitude_tujuan'];
  double? get destinationLongitude => _activeTask?.destinationLongitude ?? _activeRouteData?['longitude_tujuan'];"""

content = re.sub(pattern, replacement, content)

with open(r"C:\project pkm\bio_guard\lib\services\delivery_provider.dart", "w", encoding="utf-8") as f:
    f.write(content)
print("Updated DeliveryProvider getters!")
