import re

with open(r"resources/views/dashboard/fleet.blade.php", "r", encoding="utf-8") as f:
    content = f.read()

# The bug is here: `if (!plannedPaths[route.lokasi_tujuan]) {`
# Because plannedPaths isn't being populated anymore (we stripped OSRM), but this check remains. Actually, wait. 
# If plannedPaths is never populated, it should ALWAYS evaluate to true.
# Let's completely remove the `if (!plannedPaths[route.lokasi_tujuan]) {` condition so the line always updates to the current position.

pattern = r'if \(\!plannedPaths\[route\.lokasi_tujuan\]\) \{([\s\S]*?)\}\n\n        // ----------------------------------------------------'

def repl(match):
    inner = match.group(1)
    return inner + "\n\n        // ----------------------------------------------------"

content = re.sub(pattern, repl, content)

# But wait, we also need to update the straight line dynamically on EVERY move, not just once.
# `const futureRoute = [currentLatLng, [destLat, destLng]];`
# So we just remove the wrapper `if (!plannedPaths...)`

with open(r"resources/views/dashboard/fleet.blade.php", "w", encoding="utf-8") as f:
    f.write(content)
print("Removed plannedPaths check in fleet.blade.php")
