import requests
import re
import urllib.parse
link = "https://maps.app.goo.gl/WeXaHokTBKrQKPYL6"
r = requests.get(link, allow_redirects=False)
print("Status:", r.status_code)
print("Headers:", r.headers)
location = r.headers.get("Location")
print("Location:", location)
name_match = re.search(r'/place/([^/]+)', location) if location else None
print("Name Match:", name_match.group(1) if name_match else None)
