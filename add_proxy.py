import re

content = ""
with open("routes/api.php", "r", encoding="utf-8") as f:
    content = f.read()

route_code = """
Route::get('/osrm-proxy', function(\\Illuminate\\Http\\Request $request) {
    $origin = $request->query('origin');
    $dest = $request->query('dest');
    $alt = $request->query('alt') == 'true' ? '&alternatives=true' : '';
    
    if (!$origin || !$dest) return response()->json(['code' => 'Error']);
    
    $url = "https://router.project-osrm.org/route/v1/driving/{$origin};{$dest}?overview=full&geometries=geojson{$alt}";
    
    try {
        $response = \\Illuminate\\Support\\Facades\\Http::timeout(5)->get($url);
        return $response->json();
    } catch (\\Exception $e) {
        return response()->json(['code' => 'Error', 'message' => $e->getMessage()]);
    }
});
"""

if "/osrm-proxy" not in content:
    with open("routes/api.php", "a", encoding="utf-8") as f:
        f.write("\n" + route_code + "\n")
    print("Added proxy to api.php")

