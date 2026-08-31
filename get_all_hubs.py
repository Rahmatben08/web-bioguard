import subprocess

cmd = ["ssh", "-o", "ConnectTimeout=10", "-o", "StrictHostKeyChecking=no", "root@bioguard.id", "sudo -u postgres psql -d bioguard_db -c \"SELECT id, nama, latitude, longitude FROM inventory_hubs;\""]
proc = subprocess.Popen(cmd, stdout=subprocess.PIPE, text=True)
out, err = proc.communicate()
print(out)
