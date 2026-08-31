import subprocess

tinker_cmd = """
$request = request();
$request->merge(['show_demo' => 1]);
$response = app()->call('App\Http\Controllers\FleetController@liveLocation', ['request' => $request]);
echo json_encode($response->getData(true));
"""

with open("tinker.php", "w") as f:
    f.write(tinker_cmd)

subprocess.run(["ssh", "-o", "ConnectTimeout=10", "-o", "StrictHostKeyChecking=no", "root@bioguard.id", "cd /var/www/bioguard && php artisan tinker < /dev/null --execute=\"$(cat /root/tinker.php)\""])
