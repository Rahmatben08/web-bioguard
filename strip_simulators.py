import re

files = [
    r'resources/views/dashboard/simulator.blade.php',
    r'resources/views/simulator.blade.php'
]

for filepath in files:
    with open(filepath, 'r', encoding='utf-8') as f:
        content = f.read()

    # Find where changeRoute is
    
    # 1. We remove fetchOsrmRoute definition
    content = re.sub(r'let routeCache = \{\};[\s\S]*?async function fetchOsrmRoute[\s\S]*?return null;\s*\}', '', content)
    
    # 2. In changeRoute, we remove the await fetchOsrmRoute call and just make it a straight line
    pattern_fetch = r'let basePoints = await fetchOsrmRoute\([^;]+\);[\s\S]*?if\(!basePoints \|\| basePoints\.length < 2\) \{[\s\S]*?basePoints = \[\[originCoord\.lat, originCoord\.lng\], \[destLat, destLng\]\];\s*\}'
    
    new_points = "let basePoints = [[originCoord.lat, originCoord.lng], [destLat, destLng]];"
    
    content = re.sub(pattern_fetch, new_points, content)

    # 3. Just in case, if the await is still there
    content = re.sub(r'let basePoints = await fetchOsrmRoute\([^;]+\);', new_points, content)
    
    with open(filepath, 'w', encoding='utf-8') as f:
        f.write(content)
    print("Updated " + filepath)

