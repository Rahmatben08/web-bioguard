import re

files_to_fix = [
    r"resources/views/simulator.blade.php",
    r"resources/views/dashboard/simulator.blade.php"
]

for filepath in files_to_fix:
    with open(filepath, "r", encoding="utf-8") as f:
        content = f.read()
        
    # Replace the routeCoords assignment inside changeRoute function!
    # Look for the block inside changeRoute that assigns routeCoords
    
    # In dashboard/simulator.blade.php:
    old_block_dashboard = """        // Swap coordinates
        const isRerouted = activeReroutes[activeRouteId];
        routeCoords = isRerouted && alternativePaths[activeDestination]
            ? alternativePaths[activeDestination]
            : (routePaths[activeDestination] || routePaths['RSUP Dr. Mohammad Hoesin']);
        currentStep = 0;"""
    
    new_block_dashboard = """        // Swap coordinates
        const isRerouted = activeReroutes[activeRouteId];
        const destLat = parseFloat(selectedOption.getAttribute('data-lat'));
        const destLng = parseFloat(selectedOption.getAttribute('data-lng'));
        
        let startCoord = [originCoord.lat, originCoord.lng];
        let endCoord = [destLat, destLng];
        
        // Generate straight line interpolation
        let steps = 20;
        routeCoords = [];
        for (let i=0; i<=steps; i++) {
            routeCoords.push([
                startCoord[0] + (endCoord[0] - startCoord[0]) * (i/steps),
                startCoord[1] + (endCoord[1] - startCoord[1]) * (i/steps)
            ]);
        }
        currentStep = 0;"""
        
    if old_block_dashboard in content:
        content = content.replace(old_block_dashboard, new_block_dashboard)
        print(f"Fixed dashboard/simulator.blade.php")
        
    # In simulator.blade.php:
    old_block_public = """            const destLat = parseFloat(selectedOption.getAttribute('data-lat'));
            const destLng = parseFloat(selectedOption.getAttribute('data-lng'));
            let basePoints = [[originCoord.lat, originCoord.lng], [destLat, destLng]];
            routeCoords = interpolateRoute(basePoints, 10);
            currentRouteIndex = 0;"""
            
    new_block_public = """            const destLat = parseFloat(selectedOption.getAttribute('data-lat'));
            const destLng = parseFloat(selectedOption.getAttribute('data-lng'));
            
            let startCoord = [originCoord.lat, originCoord.lng];
            let endCoord = [destLat, destLng];
            
            // Generate straight line interpolation
            let steps = 20;
            routeCoords = [];
            for (let i=0; i<=steps; i++) {
                routeCoords.push([
                    startCoord[0] + (endCoord[0] - startCoord[0]) * (i/steps),
                    startCoord[1] + (endCoord[1] - startCoord[1]) * (i/steps)
                ]);
            }
            currentRouteIndex = 0;"""

    if old_block_public in content:
        content = content.replace(old_block_public, new_block_public)
        print(f"Fixed public simulator.blade.php")
        
    with open(filepath, "w", encoding="utf-8") as f:
        f.write(content)
