import subprocess

cmd = ["ssh", "-o", "ConnectTimeout=10", "-o", "StrictHostKeyChecking=no", "root@bioguard.id", "cat /var/www/bioguard/app/Http/Controllers/DashboardController.php"]
result = subprocess.run(cmd, capture_output=True, text=True)

for i, line in enumerate(result.stdout.split('\n')):
    if 'destCoord' in line:
        print(f"{i+1}: {line}")
