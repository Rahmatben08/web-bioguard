import re

with open(r"resources/views/dashboard/fleet.blade.php", "r", encoding="utf-8") as f:
    content = f.read()

pattern = r'// routeCache for OSRM fetch deduplication[\s\S]*?document\.addEventListener\("DOMContentLoaded", function \(\) \{'
replacement = r'document.addEventListener("DOMContentLoaded", function () {'
content = re.sub(pattern, replacement, content)

with open(r"resources/views/dashboard/fleet.blade.php", "w", encoding="utf-8") as f:
    f.write(content)
print("Removed broken chunk!")
