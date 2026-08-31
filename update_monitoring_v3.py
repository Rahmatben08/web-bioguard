with open(r"resources/views/dashboard/monitoring.blade.php", "r", encoding="utf-8") as f:
    content = f.read()

old_block = """            // ----------------------------------------------------
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
                const polyline = L.polyline(routeCoords, {
                    color: polylineColor,
                    dashArray: polylineDashArray,
                    weight: polylineWeight,
                    opacity: polylineOpacity
                }).addTo(map);
                activePolylines[ruteId] = polyline;
            }"""

new_block = """            // ----------------------------------------------------
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
            }"""

content = content.replace(old_block, new_block)

with open(r"resources/views/dashboard/monitoring.blade.php", "w", encoding="utf-8") as f:
    f.write(content)
print("Replaced safely")
