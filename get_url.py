import requests

url = "https://maps.app.goo.gl/Tv4jpmzVGDYUW9URA"
r = requests.get(url, allow_redirects=False)
print("Location:", r.headers.get("Location"))
