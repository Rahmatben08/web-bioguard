import pandas as pd
import numpy as np

# CATATAN PENTING: INI ADALAH DATA SINTETIS UNTUK BOOTSTRAP MODEL (MVP).
# Dataset ini menggunakan logika domain untuk mensimulasikan korelasi antara 
# jarak, kemacetan, fluktuasi MKT, dan risiko kerusakan vaksin. 
# Jika data riil lapangan sudah terkumpul, model harus dilatih ulang menggunakan data tersebut.

def generate_synthetic_data(n_samples=2000):
    np.random.seed(42)
    
    # 1. sisa_jarak_km: 0 hingga 500 km
    sisa_jarak_km = np.random.uniform(0, 500, n_samples)
    
    # 2. durasi_kemacetan_menit: 0 hingga 120 menit
    durasi_kemacetan_menit = np.random.uniform(0, 120, n_samples)
    
    # 3. fluktuasi_mkt: selisih MKT dari ambang batas 8.0 (bisa negatif)
    # Umumnya MKT berkisar antara 2 hingga 10, jadi fluktuasi = MKT - 8
    mkt = np.random.normal(6.5, 2.5, n_samples)
    fluktuasi_mkt = mkt - 8.0
    
    # Formula domain masuk akal untuk probabilitas:
    # Semakin jauh sisa jarak + macet lama + MKT sudah dekat/lewat ambang -> risiko naik
    # Kita berikan bias negatif (misal -4.5) agar pada kondisi ideal probabilitas mendekati 0
    noise = np.random.normal(0, 0.5, n_samples)
    z = (0.008 * sisa_jarak_km + 
         0.015 * durasi_kemacetan_menit + 
         0.6 * np.maximum(0, fluktuasi_mkt) + 
         noise - 4.5)
         
    # 4. probabilitas_rusak: Sigmoid function untuk merubah Z ke rentang 0-1
    probabilitas_rusak = 1 / (1 + np.exp(-z))
    
    df = pd.DataFrame({
        'sisa_jarak_km': np.round(sisa_jarak_km, 2),
        'durasi_kemacetan_menit': np.round(durasi_kemacetan_menit, 1),
        'fluktuasi_mkt': np.round(fluktuasi_mkt, 2),
        'probabilitas_rusak': np.round(probabilitas_rusak, 4)
    })
    
    return df

if __name__ == "__main__":
    print("Generating synthetic dataset...")
    df = generate_synthetic_data(2000)
    df.to_csv("dataset_sintetis.csv", index=False)
    print("Berhasil membuat ml/dataset_sintetis.csv dengan 2000 baris data.")
