import re

files = [
    r'resources/views/dashboard/fleet.blade.php',
    r'resources/views/dashboard/simulator.blade.php',
    r'resources/views/simulator.blade.php'
]

for filepath in files:
    with open(filepath, 'r', encoding='utf-8') as f:
        content = f.read()
    
    # regex pattern to match any object assignment like: const varName = { 'Key': [[...]], ... };
    # We use a broad match for any of the 3 variable names
    
    pattern1 = r'const plannedPaths\s*=\s*\{.*?\};'
    pattern2 = r'const alternativePaths\s*=\s*\{.*?\};'
    pattern3 = r'const routePaths\s*=\s*\{.*?\};'
    
    # We must be careful not to delete too much if they contain other code.
    # But we know they only contain coordinate arrays.
    # Let's replace them specifically.
    
    content = re.sub(r'const plannedPaths\s*=\s*\{.*?\]\]\s*\n\s*\};', 'const plannedPaths = {};', content, flags=re.DOTALL)
    content = re.sub(r'const alternativePaths\s*=\s*\{.*?\]\]\s*\n\s*\};', 'const alternativePaths = {};', content, flags=re.DOTALL)
    content = re.sub(r'const routePaths\s*=\s*\{.*?\]\]\s*\n\s*\};', 'const routePaths = {};', content, flags=re.DOTALL)
    
    # Fallback for simpler patterns
    content = re.sub(r'const plannedPaths = \{[^{}]*?\[\[.*?\]\].*?\};', 'const plannedPaths = {};', content, flags=re.DOTALL)
    content = re.sub(r'const alternativePaths = \{[^{}]*?\[\[.*?\]\].*?\};', 'const alternativePaths = {};', content, flags=re.DOTALL)
    content = re.sub(r'const routePaths = \{[^{}]*?\[\[.*?\]\].*?\};', 'const routePaths = {};', content, flags=re.DOTALL)

    with open(filepath, 'w', encoding='utf-8') as f:
        f.write(content)
    
    print('Cleaned ' + filepath)

