import subprocess
import json

cmd = ["ssh", "-o", "ConnectTimeout=10", "-o", "StrictHostKeyChecking=no", "root@bioguard.id", "sudo -u postgres psql -d bioguard_db -t -c \"SELECT id, nama FROM inventory_hubs;\""]
proc = subprocess.Popen(cmd, stdout=subprocess.PIPE, stderr=subprocess.PIPE, text=True)
out, err = proc.communicate()

db_faskes = []
for line in out.split("\n"):
    if "|" in line:
        parts = line.split("|")
        db_faskes.append({"id": parts[0].strip(), "nama": parts[1].strip()})

with open("db_faskes.json", "w", encoding="utf-8") as f:
    json.dump(db_faskes, f, indent=4)
print(f"Loaded {len(db_faskes)} faskes from DB.")
