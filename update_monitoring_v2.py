with open(r"resources/views/dashboard/monitoring.blade.php", "r", encoding="utf-8") as f:
    lines = f.readlines()

new_lines = []
skip = False
for line in lines:
    if "// Route Polyline (Planned Road Network OSRM)" in line:
        skip = True
        new_lines.append("""            // ----------------------------------------------------
            // Destination Marker & Straight Line (As per request)
            // ----------------------------------------------------
            const destLat = c.dest_latitude;
            const destLng = c.dest_longitude;
            
            if (destLat && destLng) {
                if (!window.activeDestMarkers) window.activeDestMarkers = {};
                
                if (window.activeDestMarkers[ruteId]) {
                    window.activeDestMarkers[ruteId].setLatLng([destLat, destLng]);
                } else {
                    window.activeDestMarkers[ruteId] = L.marker([destLat, destLng], {
                        icon: L.divIcon({
                            className: '',
                            html: `<div style="background-color:#0ea5e9; width:16px; height:16px; border-radius:50%; border:3px solid white; box-shadow:0 0 5px rgba(0,0,0,0.5);"></div>`,
                            iconSize: [16, 16],
                            iconAnchor: [8, 8]
                        })
                    }).bindPopup(`<b>Tujuan:</b> <br> ${c.lokasi_tujuan}`).addTo(map);
                }

                // Draw a simple straight line from courier to destination (NO OSRM)
                const routeCoords = [currentLatLng, [destLat, destLng]];
                if (activePolylines[ruteId]) {
                    activePolylines[ruteId].setLatLngs(routeCoords);
                    activePolylines[ruteId].setStyle({ color: '#94a3b8', dashArray: '5, 10', weight: 2, opacity: 0.8 });
                } else {
                    activePolylines[ruteId] = L.polyline(routeCoords, { color: '#94a3b8', weight: 2, dashArray: '5, 10', opacity: 0.8 }).addTo(map);
                }
            }\n""")
        continue
    
    if skip:
        # Stop skipping when we reach the end of the if-else block for polyline
        if "}).addTo(map);" in line:
            skip = False
        continue
        
    new_lines.append(line)

with open(r"resources/views/dashboard/monitoring.blade.php", "w", encoding="utf-8") as f:
    f.writelines(new_lines)

print("Injected Destination Marker")
