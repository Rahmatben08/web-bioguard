import re

with open(r"resources/views/dashboard/fleet.blade.php", "r", encoding="utf-8") as f:
    content = f.read()

# 1. Remove fetchOsrmRoute definition
pattern_fetch = r'async function fetchOsrmRoute[\s\S]*?\}'
content = re.sub(pattern_fetch, '', content, count=1)

# 2. Replace updateMapData OSRM logic
pattern_update = r'const destLat = route\.dest_latitude[\s\S]*?if \(route\.path_history && route\.path_history\.length > 0 && !actualPolylines\[ruteId\]\) \{'

replacement = """const destLat = route.dest_latitude || currentLatLng[0];
            const destLng = route.dest_longitude || currentLatLng[1];
            
            // --- DRAW DESTINATION MARKER DIRECTLY ---
            if (!window.activeDestMarkers) window.activeDestMarkers = {};
            if (window.activeDestMarkers[ruteId]) {
                window.activeDestMarkers[ruteId].setLatLng([destLat, destLng]);
            } else {
                const hospitalIcon = L.divIcon({
                    html: `<div class="w-6 h-6 rounded-full bg-cyan-900/80 border border-cyan-400 flex items-center justify-center text-cyan-400 shadow-[0_0_12px_rgba(6,182,212,0.4)]">
                                <span class="material-symbols-outlined text-[14px]">local_hospital</span>
                           </div>`,
                    className: '',
                    iconSize: [24, 24],
                    iconAnchor: [12, 12]
                });
                window.activeDestMarkers[ruteId] = L.marker([destLat, destLng], { icon: hospitalIcon }).addTo(map);
                window.activeDestMarkers[ruteId].bindPopup(`<div class='text-xs font-bold text-slate-800 py-0.5'>${route.lokasi_tujuan} (Tujuan)</div>`, { closeButton: false });
            }

            // Draw a straight dashed line to destination
            const futureRoute = [currentLatLng, [destLat, destLng]];
            if (routeLayer[ruteId]) {
                routeLayer[ruteId].setLatLngs(futureRoute);
            } else {
                routeLayer[ruteId] = L.polyline(futureRoute, { color: '#94a3b8', dashArray: '5, 10', weight: 2, opacity: 0.6 }).addTo(map);
            }
        }

        // ----------------------------------------------------
        // Actual Polyline (Real GPS History)
        // ----------------------------------------------------
        if (route.path_history && route.path_history.length > 0 && !actualPolylines[ruteId]) {"""

content = re.sub(pattern_update, replacement, content)

with open(r"resources/views/dashboard/fleet.blade.php", "w", encoding="utf-8") as f:
    f.write(content)
print("Stripped OSRM from fleet.blade.php")
