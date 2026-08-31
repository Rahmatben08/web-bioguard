import re

files = [
    r'resources/views/dashboard/simulator.blade.php',
    r'resources/views/simulator.blade.php'
]

osrm_function = '''
// --- OSRM DYNAMIC ROUTING ---
let routeCache = {};
async function fetchOsrmRoute(originLat, originLng, destLat, destLng, destinationName, isAlternative = false) {
    const cacheKey = destinationName + (isAlternative ? "_alt" : "");
    if (routeCache[cacheKey]) return routeCache[cacheKey];
    const url = https://router.project-osrm.org/route/v1/driving/,;,?overview=full&geometries=geojson;
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
'''

for filepath in files:
    with open(filepath, 'r', encoding='utf-8') as f:
        content = f.read()

    # Inject osrm_function right before function changeRoute
    if 'fetchOsrmRoute' not in content:
        content = content.replace('function changeRoute(routeId)', osrm_function + '\nasync function changeRoute(routeId)')
    else:
        content = content.replace('function changeRoute(routeId)', 'async function changeRoute(routeId)')

    # In simulator.blade.php (standalone):
    pattern1 = '''const isRerouted = activeReroutes[activeRouteId];
            const basePoints = isRerouted && alternativePaths[activeDestination]
                ? alternativePaths[activeDestination]
                : (routePaths[activeDestination] || routePaths['RSUP Dr. Mohammad Hoesin']);'''
    
    replace1 = '''const isRerouted = activeReroutes[activeRouteId];
            const destLat = parseFloat(selectedOption.getAttribute('data-lat'));
            const destLng = parseFloat(selectedOption.getAttribute('data-lng'));
            let basePoints = await fetchOsrmRoute(originCoord.lat, originCoord.lng, destLat, destLng, activeDestination, isRerouted);
            if(!basePoints || basePoints.length < 2) {
                basePoints = [[originCoord.lat, originCoord.lng], [destLat, destLng]];
            }'''
            
    # In dashboard/simulator.blade.php:
    pattern2 = '''const isRerouted = activeReroutes[activeRouteId];
    routeCoords = isRerouted && alternativePaths[activeDestination]
        ? alternativePaths[activeDestination]
        : (routePaths[activeDestination] || routePaths['RSUP Dr. Mohammad Hoesin']);'''
        
    replace2 = '''const isRerouted = activeReroutes[activeRouteId];
    const destLat = parseFloat(selectedOption.getAttribute('data-lat'));
    const destLng = parseFloat(selectedOption.getAttribute('data-lng'));
    let basePoints = await fetchOsrmRoute(originCoord.lat, originCoord.lng, destLat, destLng, activeDestination, isRerouted);
    if(!basePoints || basePoints.length < 2) {
        basePoints = [[originCoord.lat, originCoord.lng], [destLat, destLng]];
    }
    routeCoords = interpolateRoute(basePoints, 10);'''
    
    # Try replacing both variants
    content = content.replace(pattern1, replace1)
    content = content.replace(pattern2, replace2)
    
    # Also in dashboard/simulator, it calls changeRoute(...) which is now async, so it doesn't block unless awaited.
    # It's fine for it to run async.

    with open(filepath, 'w', encoding='utf-8') as f:
        f.write(content)
        
    print("Injected into " + filepath)

