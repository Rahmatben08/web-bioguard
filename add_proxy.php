use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

$routeCode = """
Route::get('/osrm-proxy', function(Request \$request) {
    \$origin = \$request->query('origin');
    \$dest = \$request->query('dest');
    \$alt = \$request->query('alt') == 'true' ? '&alternatives=true' : '';
    
    if (!\$origin || !\$dest) return response()->json(['code' => 'Error']);
    
    \$url = \"https://router.project-osrm.org/route/v1/driving/{\$origin};{\$dest}?overview=full&geometries=geojson{\$alt}\";
    
    try {
        \$response = Http::timeout(5)->get(\$url);
        return \$response->json();
    } catch (\\Exception \$e) {
        return response()->json(['code' => 'Error', 'message' => \$e->getMessage()]);
    }
});
""";

$content = file_get_contents("routes/api.php");
if (strpos($content, "/osrm-proxy") === false) {
    $content .= "\n" . $routeCode . "\n";
    file_put_contents("routes/api.php", $content);
}
echo "Added proxy to api.php\n";
