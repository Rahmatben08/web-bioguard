import subprocess
cmd = ["ssh", "-o", "ConnectTimeout=10", "-o", "StrictHostKeyChecking=no", "root@bioguard.id", "sudo -u postgres psql -d bioguard_db -c \"SELECT column_name FROM information_schema.columns WHERE table_name = 'inventory_hubs';\""]
proc = subprocess.Popen(cmd, stdout=subprocess.PIPE, stderr=subprocess.PIPE, text=True)
out, err = proc.communicate()
print(out)
