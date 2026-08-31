import subprocess

query = "SELECT lokasi_tujuan FROM perjalanan_rute WHERE lokasi_tujuan ILIKE '%Sukarami%';"
cmd = ["ssh", "-o", "ConnectTimeout=10", "-o", "StrictHostKeyChecking=no", "root@bioguard.id", f"sudo -u postgres psql -d bioguard_db -c \"{query}\""]
subprocess.run(cmd)
