import subprocess

cmd = ["ssh", "-o", "ConnectTimeout=10", "-o", "StrictHostKeyChecking=no", "root@bioguard.id", "cat /var/www/bioguard/app/Http/Controllers/DashboardController.php"]
result = subprocess.run(cmd, capture_output=True, text=True)

start_printing = False
for line in result.stdout.split('\n'):
    if 'function liveData' in line:
        start_printing = True
    if start_printing:
        print(line)
        if 'return response()->json' in line:
            break
