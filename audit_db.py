import subprocess
import json

queries = {
    "total_rows": "SELECT COUNT(*) FROM inventory_hubs;",
    "null_coords": "SELECT nama, latitude, longitude FROM inventory_hubs WHERE latitude IS NULL OR longitude IS NULL;",
    "dupes_check": "SELECT id, nama, latitude, longitude FROM inventory_hubs WHERE nama ILIKE '%Puskesmas 5 Ilir%' OR nama ILIKE '%Lima Ilir%' OR nama ILIKE '%Satu Ulu%' OR nama ILIKE '%KIP Unit 1%' OR nama ILIKE '%Empat Ulu%' OR nama ILIKE '%4 Ulu%' OR nama ILIKE '%23 Ilir%' OR nama ILIKE '%Dua Puluh Tiga Ilir%' OR nama ILIKE '%11 Ilir%' OR nama ILIKE '%Sebelas Ilir%' OR nama ILIKE '%Charitas Hospital Kenten%' OR nama ILIKE '%Karya Asih Charitas%' OR nama ILIKE '%RS Mata Binar%' OR nama ILIKE '%Masyarakat Sumatera Selatan%' OR nama ILIKE '%Sukarami%';",
    "sukarami_specific": "SELECT id, nama, latitude, longitude FROM inventory_hubs WHERE nama ILIKE '%Puskesmas Sukarami%';"
}

for key, sql in queries.items():
    print(f"\n--- {key} ---")
    cmd = ["ssh", "-o", "ConnectTimeout=10", "-o", "StrictHostKeyChecking=no", "root@bioguard.id", f"sudo -u postgres psql -d bioguard_db -c \"{sql}\""]
    proc = subprocess.Popen(cmd, stdout=subprocess.PIPE, stderr=subprocess.PIPE, text=True)
    out, err = proc.communicate()
    print(out)
    if err:
        print("ERR:", err)
