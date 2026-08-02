
const http = require('http');

async function getRoute(lon1, lat1, lon2, lat2) {
    const url = 'http://router.project-osrm.org/route/v1/driving/' + lon1 + ',' + lat1 + ';' + lon2 + ',' + lat2 + '?geometries=geojson';
    return new Promise((resolve, reject) => {
        http.get(url, (res) => {
            let data = '';
            res.on('data', chunk => data += chunk);
            res.on('end', () => {
                const parsed = JSON.parse(data);
                if (parsed.routes && parsed.routes.length > 0) {
                    resolve(parsed.routes[0].geometry.coordinates.map(c => [c[1], c[0]]));
                } else {
                    reject('No route found');
                }
            });
        }).on('error', reject);
    });
}

(async () => {
    try {
        const origin = [104.7560, -2.9880];
        
        const rsCharitas = await getRoute(origin[0], origin[1], 104.7522, -2.9772);
        console.log('RS Charitas:', JSON.stringify(rsCharitas));

        const pkmDempo = await getRoute(origin[0], origin[1], 104.7630, -2.9865);
        console.log('Puskesmas Dempo:', JSON.stringify(pkmDempo));

    } catch (e) {
        console.error(e);
    }
})();

