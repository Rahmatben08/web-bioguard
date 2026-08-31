import re

# Read SQL
with open("update_90_coords.sql", "r", encoding="utf-8") as f:
    sql_lines = f.readlines()

# Instead of fetching STDOUT which was lost, let's just query the DB directly to see which ones from resolved_maps.json matched!
# Wait, I can just generate a python script to run a SELECT query for each resolved map to see if it exists.
import json
with open("resolved_maps.json", "r", encoding="utf-8") as f:
    maps = json.load(f)

# Build queries
queries = []
for m in maps:
    search_name = m["name"].replace("Palembang", "").replace("RSIA", "").replace("RSUD", "").replace("RSUP", "").replace("Rumah Sakit", "").replace("RS", "").replace("Puskesmas", "").replace("Klinik", "").strip()
    if search_name:
        queries.append(f"SELECT nama, '{m['name']}' as source FROM inventory_hubs WHERE nama ILIKE '%{search_name}%';")

full_query = " ".join(queries)

import subprocess
cmd = ["ssh", "-o", "ConnectTimeout=10", "-o", "StrictHostKeyChecking=no", "root@bioguard.id", "sudo -u postgres psql -d bioguard_db -t -c \"{}\"".format(full_query)]
proc = subprocess.Popen(cmd, stdout=subprocess.PIPE, stderr=subprocess.PIPE, text=True)
stdout, _ = proc.communicate()

# Analyze output
matched_db_names = []
for line in stdout.split('\n'):
    if '|' in line:
        parts = line.split('|')
        db_name = parts[0].strip()
        matched_db_names.append(db_name)

matched_db_names = list(set(matched_db_names))

puskesmas_count = sum(1 for name in matched_db_names if "Puskesmas" in name)
rs_count = sum(1 for name in matched_db_names if "RS" in name or "Rumah Sakit" in name)
other_count = len(matched_db_names) - puskesmas_count - rs_count

print(f"Matched Total: {len(matched_db_names)}")
print(f"Puskesmas: {puskesmas_count}")
print(f"RS: {rs_count}")
