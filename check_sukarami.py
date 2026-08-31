import subprocess
sql = "SELECT nama, latitude, longitude FROM inventory_hubs WHERE nama = 'Puskesmas Sukarami';"
cmd = ["ssh", "-o", "ConnectTimeout=10", "-o", "StrictHostKeyChecking=no", "root@bioguard.id", f"sudo -u postgres psql -d bioguard_db -c \"{sql}\""]
proc = subprocess.Popen(cmd, stdout=subprocess.PIPE, text=True)
out, _ = proc.communicate()
print(out)
