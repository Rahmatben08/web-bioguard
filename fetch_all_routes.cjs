const fs = require('fs');
const http = require('http');

// Fetch proper OSRM routes for ALL 4 destinations from Dinas Kesehatan Palembang
const origin = { lng: 104.7560, lat: -2.9880 };
const destinations = {
    'RSUP Dr. Mohammad Hoesin': { lng: 104.7505, lat: -2.9666 },
    'RSUD Palembang BARI': { lng: 104.7645, lat: -3.0185 },
    'RS Charitas': { lng: 104.7522, lat: -2.9772 },
    'Puskesmas Dempo': { lng: 104.7630, lat: -2.9865 }
};

function getRoute(lon1, lat1, lon2, lat2) {
    const url = 'http://router.project-osrm.org/route/v1/driving/' + lon1 + ',' + lat1 + ';' + lon2 + ',' + lat2 + '?geometries=geojson&overview=full';
    return new Promise((resolve, reject) => {
        http.get(url, (res) => {
            let data = '';
            res.on('data', chunk => data += chunk);
            res.on('end', () => {
                try {
                    const parsed = JSON.parse(data);
                    if (parsed.routes && parsed.routes.length > 0) {
                        // OSRM returns [lon, lat], Leaflet needs [lat, lon]
                        const coords = parsed.routes[0].geometry.coordinates.map(c => [c[1], c[0]]);
                        resolve(coords);
                    } else {
                        reject('No route found');
                    }
                } catch(e) { reject(e); }
            });
        }).on('error', reject);
    });
}

(async () => {
    const results = {};
    for (const [name, dest] of Object.entries(destinations)) {
        console.log('Fetching route for: ' + name + '...');
        try {
            const coords = await getRoute(origin.lng, origin.lat, dest.lng, dest.lat);
            results[name] = coords;
            console.log('  -> ' + coords.length + ' coordinates');
        } catch(e) {
            console.error('  -> FAILED:', e);
        }
    }
    
    // Write output as JS code
    let output = "const plannedPaths = {\n";
    for (const [name, coords] of Object.entries(results)) {
        output += "    '" + name + "': " + JSON.stringify(coords) + ",\n";
    }
    output += "};\n";
    
    fs.writeFileSync('C:/project pkm/bio_guard_backend/planned_paths_osrm.js', output, 'utf8');
    console.log('\nWritten to planned_paths_osrm.js (' + output.length + ' bytes)');
})();
