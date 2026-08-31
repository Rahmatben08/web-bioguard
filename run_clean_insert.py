import subprocess
with open("truncate_and_insert.sql", "r", encoding="utf-8") as f:
    sql = f.read()

cmd = ["ssh", "-o", "ConnectTimeout=10", "-o", "StrictHostKeyChecking=no", "root@bioguard.id", "sudo -u postgres psql -d bioguard_db -f -"]
proc = subprocess.Popen(cmd, stdin=subprocess.PIPE, stdout=subprocess.PIPE, stderr=subprocess.PIPE, text=True)
stdout, stderr = proc.communicate(input=sql)
print("Finished TRUNCATE and INSERT!")
if stderr:
    print("Errors:", stderr[:500])
