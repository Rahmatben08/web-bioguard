import requests
import concurrent.futures
import re
import urllib.parse
import json

raw_text = "https://maps.app.goo.gl/WeXaHokTBKrQKPYL6,https://maps.app.goo.gl/u4Vz6Xar7J7VFYkj8,https://maps.app.goo.gl/8v4BiWk9F8RtCXn69,https://maps.app.goo.gl/1GA6czj6T16MyQoV7.https://maps.app.goo.gl/1jrPcZYZeXdsiJBJ8 .https://maps.app.goo.gl/XbLoFNcmQKjJasVF8.https://maps.app.goo.gl/oJixV7vE3tetib3e6.https://maps.app.goo.gl/8wnTpPqmXhQivmqr9.https://maps.app.goo.gl/tTT7dxxuNXbFCTod9.https://maps.app.goo.gl/MhckZ9vTbyD7mUAJA.https://maps.app.goo.gl/jwDc4cFj4tmwX7wR7.https://maps.app.goo.gl/6Nyw1XitniQNeKtx6.https://maps.app.goo.gl/jwQ2Vo7L47BmDqCM8.https://maps.app.goo.gl/9RoHv1TQQFNzfkWo6.https://maps.app.goo.gl/ravNDHFcxknLs16L7.https://maps.app.goo.gl/6QwcpQfFjQzhdKURA.https://maps.app.goo.gl/iwqzoJps87oEZoei6.https://maps.app.goo.gl/GZrRWx3HJ9onke7U7.https://maps.app.goo.gl/rm1f3kng1ncdPpS86.https://maps.app.goo.gl/sakxxGbfVCCvwTqi6.https://maps.app.goo.gl/7PPQfcdzD6GNYXYS8.https://maps.app.goo.gl/6vvRes9pGnJuGFnQ9.https://maps.app.goo.gl/qeeaR5b4hmGunMY36.https://maps.app.goo.gl/y9AE6CEf4Qg2Vo6R9.https://maps.app.goo.gl/p8ewzCY8mwDKDreAA.https://maps.app.goo.gl/hWHTGeibJ2Pi3Atz5.https://maps.app.goo.gl/9wCKyF5rB9vcz7Dc8.https://maps.app.goo.gl/KbEQKaAKqKEdezmJ6.https://maps.app.goo.gl/88XPXwGfEGyJumhb7.https://maps.app.goo.gl/rLHb9HwZC2swgnGv8.https://maps.app.goo.gl/9hpmrL6tGrNAWf2b6.https://maps.app.goo.gl/VvtXnU6pyaxh3QXG7.https://maps.app.goo.gl/GoB3avt1inhn2EnE7.https://maps.app.goo.gl/AAeYsy1Bprv2YoJu7.https://maps.app.goo.gl/osx1ujZppjXCax2s5.https://maps.app.goo.gl/8vCrhXUG1Jw1HWQm7.https://maps.app.goo.gl/9Bt3tdMwBoHBaKNd8.https://maps.app.goo.gl/xa19ZM1DEcVGqBtZ6.https://maps.app.goo.gl/5crxU6uLcUFJNFaHA.https://maps.app.goo.gl/H4Xpuv4ZyLL9uZ4p8.https://maps.app.goo.gl/hYC7yrRxrJ6aGEBi6.https://maps.app.goo.gl/mhU2GQsNdwyK7quQ6.https://maps.app.goo.gl/HE1ADfFrdK6AhAxd9.https://maps.app.goo.gl/d5eNSnAgfUcDoKQj6.https://maps.app.goo.gl/BHTQnysr7NzHmA8N9.https://maps.app.goo.gl/3tqZyCMF6XuEC4iN8.https://maps.app.goo.gl/9r4YVpfvaLVAx8Yq8.https://maps.app.goo.gl/otjb3Zh4wJdLhiWbA.https://maps.app.goo.gl/AzZ2Z2KJd44tS4ai7.https://maps.app.goo.gl/zfWRXqo4dniBgPTj9.https://maps.app.goo.gl/N52LP2J9dvBzDZHM8.https://maps.app.goo.gl/7hMTs1nbn2iKSQs29.https://maps.app.goo.gl/AotGSeWTku6H98LH9.https://maps.app.goo.gl/sByKCp9iusCkfHVr6.https://maps.app.goo.gl/kb4hQdP5S8tVqyew5.https://maps.app.goo.gl/TA22wZHjccjPL6y88.https://maps.app.goo.gl/rzEUGHjewsurP4269.https://maps.app.goo.gl/ZyXLQw9X3gF15JFN7.https://maps.app.goo.gl/1kqkzuACJzgJ7a4k9.https://maps.app.goo.gl/gEhu6yXugrmjkMFz5.https://maps.app.goo.gl/AzrCvNueLRTZSEM59.https://maps.app.goo.gl/i8dy3aYk6HgRWBh86.https://maps.app.goo.gl/q83a3n7wD8EP1KZD7.https://maps.app.goo.gl/gwrfWGYYGf6XVWcdA.https://maps.app.goo.gl/CsQs44dRAtxT5z7TA.https://maps.app.goo.gl/4k1dfKzuk55tj2kaA.https://maps.app.goo.gl/ZK9i8wL86kGTyact6.https://maps.app.goo.gl/miuXkoHqLjdpENqZ8.https://maps.app.goo.gl/P1R3e31jBwCAf6WV7.https://maps.app.goo.gl/CgC71BVhtSugNz1c9.https://maps.app.goo.gl/43q9ETQ5cctaMhJo6.https://maps.app.goo.gl/TL7rLqKXqba5AABo6.https://maps.app.goo.gl/PLTgJ9pLcgKEGs3r6.https://maps.app.goo.gl/HmEKvSWXR291bQBE8.https://maps.app.goo.gl/69X2QnvMotUk5vaF8.https://maps.app.goo.gl/mLFKNDyi4GLFMLWi9.https://maps.app.goo.gl/VRQsht2ERAAs1zct9.https://maps.app.goo.gl/x5raujMLFrPgUPNQ9.https://maps.app.goo.gl/aYZsPMKme8CLY9vf7.https://maps.app.goo.gl/bT3s7uBu1WKwjmqC8.https://maps.app.goo.gl/VWSenf2Le48vaT56A.https://maps.app.goo.gl/PWd3Q7LFthSbdB4V7.https://maps.app.goo.gl/ekrjm8wvzD4meXYB7.https://maps.app.goo.gl/BPfS7TDeNoQKESHL9.https://maps.app.goo.gl/soNuc6B9G6XxFmjBA.https://maps.app.goo.gl/YqKz123hHnJfukux7.https://maps.app.goo.gl/rWLJkEHeqPJwch2M9.https://maps.app.goo.gl/hqQgj63LiAJmgaLK6.https://maps.app.goo.gl/xBaNbNuYzWH6hLdC8.https://maps.app.goo.gl/AvbqYqKNuA6RJJ3M7.https://maps.app.goo.gl/Z9423wv5Nc1mEc3Q8.https://maps.app.goo.gl/JVXsecY2pDxpAwYV9.https://maps.app.goo.gl/s1xepbWmjuVuFjYR6"
links = re.findall(r'https://maps\.app\.goo\.gl/[A-Za-z0-9]+', raw_text)

results = []

def resolve_link(link):
    try:
        r = requests.get(link, allow_redirects=False, timeout=10)
        location = r.headers.get("Location")
        if not location:
            return None
        
        name = ""
        lat = None
        lng = None
        
        name_match = re.search(r'/place/([^/]+)', location)
        if name_match:
            name = urllib.parse.unquote_plus(name_match.group(1))
            
        exact_match = re.search(r'!3d(-?\d+\.\d+)!4d(-?\d+\.\d+)', location)
        if exact_match:
            lat = float(exact_match.group(1))
            lng = float(exact_match.group(2))
        else:
            at_match = re.search(r'@(-?\d+\.\d+),(-?\d+\.\d+)', location)
            if at_match:
                lat = float(at_match.group(1))
                lng = float(at_match.group(2))
                
        if lat and lng and name:
            return {"name": name, "lat": lat, "lng": lng, "url": link}
        return None
    except Exception as e:
        return None

with concurrent.futures.ThreadPoolExecutor(max_workers=15) as executor:
    futures = {executor.submit(resolve_link, link): link for link in set(links)}
    for future in concurrent.futures.as_completed(futures):
        res = future.result()
        if res:
            results.append(res)

with open("resolved_maps.json", "w", encoding="utf-8") as f:
    json.dump(results, f, indent=4)
print(f"Resolved {len(results)} out of {len(set(links))} unique links")
