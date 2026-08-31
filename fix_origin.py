import os

files_to_fix = [
    r"resources/views/simulator.blade.php",
    r"resources/views/dashboard/simulator.blade.php"
]

for filepath in files_to_fix:
    if os.path.exists(filepath):
        with open(filepath, "r", encoding="utf-8") as f:
            content = f.read()
        
        # Check if originCoord is missing
        if 'const originCoord' not in content and 'let originCoord' not in content:
            if 'let routeCoords' in content:
                content = content.replace("let routeCoords", "const originCoord = { lat: -2.9880, lng: 104.7560 };\n        let routeCoords")
                with open(filepath, "w", encoding="utf-8") as f:
                    f.write(content)
                print(f"Fixed {filepath}")
            else:
                print(f"Could not find anchor in {filepath}")
        else:
            print(f"{filepath} already has originCoord defined.")
