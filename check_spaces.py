import subprocess
import json

query = "SELECT lokasi_tujuan FROM perjalanan_rute WHERE lokasi_tujuan LIKE '%Sukarami%';"
cmd = ["ssh", "-o", "ConnectTimeout=10", "-o", "StrictHostKeyChecking=no", "root@bioguard.id", f"sudo -u postgres psql -t -A -d bioguard_db -c \"{query}\""]
res = subprocess.run(cmd, capture_output=True, text=True)
print("Route:", repr(res.stdout.strip()))

query2 = "SELECT nama FROM inventory_hubs WHERE nama LIKE '%Sukarami%';"
cmd2 = ["ssh", "-o", "ConnectTimeout=10", "-o", "StrictHostKeyChecking=no", "root@bioguard.id", f"sudo -u postgres psql -t -A -d bioguard_db -c \"{query2}\""]
res2 = subprocess.run(cmd2, capture_output=True, text=True)
print("Faskes:", repr(res2.stdout.strip()))
