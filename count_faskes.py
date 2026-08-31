import subprocess
import json

sql = """
SELECT 
    SUM(CASE WHEN nama ILIKE '%Puskesmas%' THEN 1 ELSE 0 END) as total_puskesmas,
    SUM(CASE WHEN nama ILIKE '%RS%' OR nama ILIKE '%Rumah Sakit%' THEN 1 ELSE 0 END) as total_rs,
    SUM(CASE WHEN nama ILIKE '%Klinik%' THEN 1 ELSE 0 END) as total_klinik,
    COUNT(*) as total_faskes
FROM inventory_hubs;
"""

cmd = ["ssh", "-o", "ConnectTimeout=10", "-o", "StrictHostKeyChecking=no", "root@bioguard.id", f"sudo -u postgres psql -d bioguard_db -t -c \"{sql}\""]
proc = subprocess.Popen(cmd, stdout=subprocess.PIPE, stderr=subprocess.PIPE, text=True)
stdout, _ = proc.communicate()
print("DB Data:", stdout)
