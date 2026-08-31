import subprocess

query = """
SELECT 
    pr.id_rute, 
    pr.lokasi_tujuan AS pr_lokasi, 
    ih.nama AS ih_nama, 
    ih.latitude, 
    ih.longitude
FROM perjalanan_rute pr
LEFT JOIN inventory_hubs ih ON ih.nama = pr.lokasi_tujuan;
"""
cmd = ["ssh", "-o", "ConnectTimeout=10", "-o", "StrictHostKeyChecking=no", "root@bioguard.id", f"sudo -u postgres psql -d bioguard_db -c \"{query}\""]
subprocess.run(cmd)
