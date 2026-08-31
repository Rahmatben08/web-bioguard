import re

files = [
    r'resources/views/dashboard/simulator.blade.php',
    r'resources/views/simulator.blade.php'
]

osrm_function = """
// --- OSRM DYNAMIC ROUTING ---
let routeCache = {};
async function fetchOsrmRoute(originLat, originLng, destLat, destLng, destinationName, isAlternative = false) {
    const cacheKey = destinationName + (isAlternative ? "_alt" : "");
    if (routeCache[cacheKey]) return routeCache[cacheKey];
    const url = `https://router.project-osrm.org/route/v1/driving/${originLng},${originLat};${destLng},${destLat}?overview=full&geometries=geojson${isAlternative ? '&alternatives=true' : ''}`;
    try {
        const response = await fetch(url);
        const data = await response.json();
        if (data.code === 'Ok' && data.routes.length > 0) {
            const routeIdx = (isAlternative && data.routes.length > 1) ? 1 : 0;
            const coordinates = data.routes[routeIdx].geometry.coordinates.map(c => [c[1], c[0]]);
            routeCache[cacheKey] = coordinates;
            return coordinates;
        }
    } catch (e) {
        console.error("OSRM Fetch Error", e);
    }
    return null;
}
"""

for filepath in files:
    with open(filepath, 'r', encoding='utf-8') as f:
        content = f.read()

    # Find the broken url string
    broken_url = 'const url = https://router.project-osrm.org/route/v1/driving/,;,?overview=full&geometries=geojson;'
    correct_url = 'const url = `https://router.project-osrm.org/route/v1/driving/${originLng},${originLat};${destLng},${destLat}?overview=full&geometries=geojson${isAlternative ? \'&alternatives=true\' : \'\'}`;'
    
    content = content.replace(broken_url, correct_url)
    
    with open(filepath, 'w', encoding='utf-8') as f:
        f.write(content)
        
    print("Fixed OSRM URL in " + filepath)

