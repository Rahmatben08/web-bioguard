import json
import subprocess

try:
    with open("palembang_medical.json", "r") as f:
        medical_data = json.load(f)
except Exception as e:
    print("Could not read palembang_medical.json", e)
    medical_data = {}

# User provided for Sukarami
medical_data["Puskesmas Sukarami"] = {"lat": -2.920429, "lon": 104.7170234}
medical_data["Puskesmas Alang-Alang Lebar"] = {"lat": -2.939221, "lon": 104.700142}
medical_data["RSUD Palembang Bari"] = {"lat": -3.0185, "lon": 104.7645}
medical_data["Puskesmas Sekip"] = {"lat": -2.9525, "lon": 104.7570}

sql_statements = []
for name, coords in medical_data.items():
    lat = coords["lat"]
    lng = coords["lon"]
    sql = f"UPDATE inventory_hubs SET latitude = {lat}, longitude = {lng} WHERE nama LIKE '%{name}%';"
    sql_statements.append(sql)

# Also fix the `Puskesmas 7 Ulu` and others if needed.
sql_script = "\n".join(sql_statements)
with open("update_real_coords.sql", "w") as f:
    f.write(sql_script)

cmd = ["ssh", "-o", "ConnectTimeout=10", "-o", "StrictHostKeyChecking=no", "root@bioguard.id", "sudo -u postgres psql -d bioguard_db -f -"]
proc = subprocess.Popen(cmd, stdin=subprocess.PIPE, stdout=subprocess.PIPE, stderr=subprocess.PIPE, text=True)
stdout, stderr = proc.communicate(input=sql_script)

print("DB Update applied. Output:", stdout)
