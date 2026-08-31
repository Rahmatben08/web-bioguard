import json
import re
import uuid
from datetime import datetime

with open("faskes_data.json", "r", encoding="utf-8") as f:
    faskes_list = json.load(f)

with open("db_faskes.json", "r", encoding="utf-8") as f:
    db_faskes = json.load(f)

def clean_name(name):
    name = name.lower()
    name = re.sub(r'\(.*?\)', '', name)
    name = name.replace('rsud', '').replace('rsia', '').replace('rs', '').replace('rumah sakit', '')
    name = name.replace('puskesmas', '').replace('palembang', '')
    name = re.sub(r'[^a-z0-9]', '', name)
    return name

sql_statements = []
for item in faskes_list:
    official_name = item["name"]
    kec = item["kecamatan"]
    lat = item["lat"]
    lng = item["lng"]
    
    clean_official = clean_name(official_name)
    best_match_id = None
    
    for db_f in db_faskes:
        db_id = db_f["id"]
        db_nama = db_f["nama"]
        clean_db = clean_name(db_nama)
        
        if clean_official and clean_db and (clean_official in clean_db or clean_db in clean_official):
            best_match_id = db_id
            break
            
    escaped_name = official_name.replace("'", "''")
    escaped_kec = kec.replace("'", "''")
    
    if best_match_id:
        sql = f"UPDATE inventory_hubs SET latitude = {lat}, longitude = {lng} WHERE id = {best_match_id};"
        sql_statements.append(sql)
    else:
        id_faskes = f"HUB-{uuid.uuid4().hex[:8].upper()}"
        cat = "Rumah Sakit" if "RS" in official_name else "Puskesmas"
        now = datetime.now().strftime('%Y-%m-%d %H:%M:%S')
        sql = f"INSERT INTO inventory_hubs (id_faskes, nama, kategori, kecamatan, kulkas_farmasi, latitude, longitude, created_at, updated_at) VALUES ('{id_faskes}', '{escaped_name}', '{cat}', '{escaped_kec}', 'TCW 3000 AC', {lat}, {lng}, '{now}', '{now}');"
        sql_statements.append(sql)

with open("upsert_faskes.sql", "w", encoding="utf-8") as f:
    f.write("\n".join(sql_statements))
