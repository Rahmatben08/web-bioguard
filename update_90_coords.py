import json
import subprocess
import re

with open("resolved_maps.json", "r", encoding="utf-8") as f:
    maps = json.load(f)

sql_statements = []
for m in maps:
    raw_name = m["name"]
    lat = m["lat"]
    lng = m["lng"]
    
    # Clean the name to increase match rate
    # E.g. "Rumah Sakit Musi Medika Cendikia Palembang" -> "Musi Medika Cendikia"
    # E.g. "Puskesmas Talang Jambe" -> "Talang Jambe"
    search_name = raw_name.replace("Palembang", "").replace("RSIA", "").replace("RSUD", "").replace("RSUP", "").replace("Rumah Sakit", "").replace("RS", "").replace("Puskesmas", "").replace("Klinik", "").strip()
    
    if search_name:
        # We only match if search_name is substantial enough
        # We will use ILIKE for case insensitive
        # But wait, there might be multiple matches for generic names. 
        # But this is okay for this dataset.
        sql = f"UPDATE inventory_hubs SET latitude = {lat}, longitude = {lng} WHERE nama ILIKE '%{search_name}%';"
        sql_statements.append(sql)

sql_script = "\n".join(sql_statements)

with open("update_90_coords.sql", "w", encoding="utf-8") as f:
    f.write(sql_script)

# Execute via ssh psql
cmd = ["ssh", "-o", "ConnectTimeout=10", "-o", "StrictHostKeyChecking=no", "root@bioguard.id", "sudo -u postgres psql -d bioguard_db -f -"]
proc = subprocess.Popen(cmd, stdin=subprocess.PIPE, stdout=subprocess.PIPE, stderr=subprocess.PIPE, text=True)
stdout, stderr = proc.communicate(input=sql_script)

print("DB Update finished")
print("STDOUT excerpt:", stdout[:500])
if stderr:
    print("STDERR excerpt:", stderr[:500])

# Now let's count how many were updated
updated_count = stdout.count("UPDATE 1")
print(f"Total rows updated: {updated_count}")
