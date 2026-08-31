import subprocess
cmd = ["ssh", "-o", "ConnectTimeout=10", "-o", "StrictHostKeyChecking=no", "root@bioguard.id", 'sudo -u postgres psql -d bioguard_db -c "SELECT nama, latitude, longitude FROM inventory_hubs WHERE nama ILIKE \'%Sukarami%\';"']
proc = subprocess.Popen(cmd, stdout=subprocess.PIPE, stderr=subprocess.PIPE, text=True)
stdout, stderr = proc.communicate()
print("STDOUT:", stdout)
