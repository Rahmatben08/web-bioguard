import json
import uuid
from datetime import datetime

with open("faskes_data.json", "r", encoding="utf-8") as f:
    faskes_list = json.load(f)

sql_statements = []
sql_statements.append("TRUNCATE TABLE inventory_hubs;")

for item in faskes_list:
    official_name = item["name"]
    kec = item["kecamatan"]
    lat = item["lat"]
    lng = item["lng"]
    
    escaped_name = official_name.replace("'", "''")
    escaped_kec = kec.replace("'", "''")
    
    id_faskes = f"HUB-{uuid.uuid4().hex[:8].upper()}"
    cat = "Rumah Sakit" if "RS" in official_name else "Puskesmas"
    now = datetime.now().strftime('%Y-%m-%d %H:%M:%S')
    
    # We set default values for kulkas_farmasi, suhu_aktual, kapasitas_terisi to avoid NOT NULL errors
    sql = f"INSERT INTO inventory_hubs (id_faskes, nama, kategori, kecamatan, kulkas_farmasi, suhu_aktual, kapasitas_terisi, latitude, longitude, created_at, updated_at) VALUES ('{id_faskes}', '{escaped_name}', '{cat}', '{escaped_kec}', 'TCW 3000 AC', 4.5, 0.00, {lat}, {lng}, '{now}', '{now}');"
    sql_statements.append(sql)

# Update existing rute
sql_statements.append("UPDATE perjalanan_rute SET lokasi_tujuan = 'RSUD Palembang (BARI)' WHERE lokasi_tujuan = 'RSUD Palembang Bari';")
sql_statements.append("UPDATE perjalanan_rute SET lokasi_tujuan = 'RS RK Charitas' WHERE lokasi_tujuan = 'RS Charitas';")

with open("truncate_and_insert.sql", "w", encoding="utf-8") as f:
    f.write("\n".join(sql_statements))
