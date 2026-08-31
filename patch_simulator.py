import re

for filepath in [r"resources/views/simulator.blade.php", r"resources/views/dashboard/simulator.blade.php"]:
    with open(filepath, "r", encoding="utf-8") as f:
        content = f.read()

    # We need to remove const routePaths = { ... };
    # And replace the initialization of routeCoords
    
    # 1. Remove routePaths definition
    pattern_paths = r"const routePaths = \{[\s\S]*?^\s*};\n"
    content = re.sub(pattern_paths, "", content, flags=re.MULTILINE)
    
    # 2. Replace routeCoords initialization
    pattern_init = r"let routeCoords = interpolateRoute\(routePaths\['RSUP Dr\. Mohammad Hoesin'\], 10\);"
    replacement_init = r"""let routeCoords = [[-2.9880, 104.7560], [-2.973305, 104.745582]]; // fallback init
        // Will be overwritten by changeRoute() immediately
        setTimeout(() => {
            const selector = document.getElementById('route-selector');
            if (selector && selector.options.length > 0) {
                changeRoute(selector.value);
            }
        }, 100);"""
    content = re.sub(pattern_init, replacement_init, content)

    with open(filepath, "w", encoding="utf-8") as f:
        f.write(content)
print("Removed routePaths from simulators!")
