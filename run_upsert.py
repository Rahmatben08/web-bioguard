import subprocess
with open("upsert_faskes.sql", "r", encoding="utf-8") as f:
    sql = f.read()

cmd = ["ssh", "-o", "ConnectTimeout=10", "-o", "StrictHostKeyChecking=no", "root@bioguard.id", "sudo -u postgres psql -d bioguard_db -f -"]
proc = subprocess.Popen(cmd, stdin=subprocess.PIPE, stdout=subprocess.PIPE, stderr=subprocess.PIPE, text=True)
stdout, stderr = proc.communicate(input=sql)
print("Finished!")
print(stdout[:500])
if stderr:
    print("Errors:", stderr[:500])
