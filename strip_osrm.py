import re

with open(r"resources/views/dashboard/monitoring.blade.php", "r", encoding="utf-8") as f:
    content = f.read()

# 1. Remove fetchOsrmRoute completely
content = re.sub(r'let routeCache = \{\};[\s\S]*?async function fetchOsrmRoute[\s\S]*?return null;\s*\}', '', content)

# 2. Inside processLiveData, remove the fetch calls
remove_fetch_calls = """            // Fetch OSRM if not loaded
            if (!plannedPaths[c.lokasi_tujuan]) {
                const originLat = c.origin_latitude || -2.9880;
                const originLng = c.origin_longitude || 104.7560;
                const destLat = c.dest_latitude || currentLatLng[0];
                const destLng = c.dest_longitude || currentLatLng[1];
                
                await fetchOsrmRoute(originLat, originLng, destLat, destLng, c.lokasi_tujuan, false);
                fetchOsrmRoute(originLat, originLng, destLat, destLng, c.lokasi_tujuan, true);
            }"""
content = content.replace(remove_fetch_calls, "")

# 3. Replace the polyline drawing and add DESTINATION MARKER
old_drawing = """            // ----------------------------------------------------
            // Route Polyline (Planned Road Network OSRM)
            // ----------------------------------------------------
            const routeCoords = plannedRoute || [
                [c.origin_latitude, c.origin_longitude],
                currentLatLng
            ];

            let polylineColor = '#94a3b8'; // Faded gray for planned route
            let polylineDashArray = '5, 10';
            let polylineWeight = 3;
            let polylineOpacity = 0.5;

            if (activePolylines[ruteId]) {
                activePolylines[ruteId].setLatLngs(routeCoords);
                activePolylines[ruteId].setStyle({ 
                    color: polylineColor,
                    dashArray: polylineDashArray,
                    weight: polylineWeight,
                    opacity: polylineOpacity
                });
            } else {
                activePolylines[ruteId] = L.polyline(routeCoords, {
                    color: polylineColor,
                    weight: polylineWeight,
                    opacity: polylineOpacity,
                    dashArray: polylineDashArray
                }).addTo(map);
            }"""

new_drawing = """            // ----------------------------------------------------
            // Destination Marker & Straight Line
            // ----------------------------------------------------
            const destLat = c.dest_latitude;
            const destLng = c.dest_longitude;
            
            if (destLat && destLng) {
                // Draw or update destination marker
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

                // Draw straight dashed line to destination
                const routeCoords = [currentLatLng, [destLat, destLng]];
                if (activePolylines[ruteId]) {
                    activePolylines[ruteId].setLatLngs(routeCoords);
                    activePolylines[ruteId].setStyle({ color: '#94a3b8', dashArray: '5, 10', weight: 2, opacity: 0.8 });
                } else {
                    activePolylines[ruteId] = L.polyline(routeCoords, { color: '#94a3b8', weight: 2, dashArray: '5, 10', opacity: 0.8 }).addTo(map);
                }
            }"""
            
content = content.replace(old_drawing, new_drawing)

with open(r"resources/views/dashboard/monitoring.blade.php", "w", encoding="utf-8") as f:
    f.write(content)
print("Removed OSRM and added Destination Marker to monitoring.blade.php")
