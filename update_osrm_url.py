import re

files = [
    r'resources/views/dashboard/monitoring.blade.php',
    r'resources/views/dashboard/simulator.blade.php',
    r'resources/views/simulator.blade.php'
]

old_url1 = "const url = `https://router.project-osrm.org/route/v1/driving/${originLng},${originLat};${destLng},${destLat}?overview=full&geometries=geojson${isAlternative ? '&alternatives=true' : ''}`;"
old_url2 = "const url = `https://router.project-osrm.org/route/v1/driving/${originLng},${originLat};${destLng},${destLat}?overview=full&geometries=geojson${isAlternative ? '\\'&alternatives=true\\'' : \\'\\'}`;"

new_url = "const url = `/api/osrm-proxy?origin=${originLng},${originLat}&dest=${destLng},${destLat}${isAlternative ? '&alt=true' : ''}`;"

for filepath in files:
    with open(filepath, 'r', encoding='utf-8') as f:
        content = f.read()

    # We will use regex to catch any variation of the osrm URL
    pattern = r"const url = `https://router\.project-osrm\.org/route/v1/driving/[^`]+`;"
    content = re.sub(pattern, new_url, content)
    
    with open(filepath, 'w', encoding='utf-8') as f:
        f.write(content)
        
    print("Updated OSRM URL in " + filepath)

