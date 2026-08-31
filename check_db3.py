import subprocess

query = "SELECT id, nama, latitude, longitude FROM inventory_hubs WHERE nama ILIKE '%Sukarami%';"
cmd = ["ssh", "-o", "ConnectTimeout=10", "-o", "StrictHostKeyChecking=no", "root@bioguard.id", f"sudo -u postgres psql -d bioguard_db -c \"{query}\""]
subprocess.run(cmd)
