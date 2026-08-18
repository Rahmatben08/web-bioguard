from fastapi import FastAPI
from pydantic import BaseModel
import joblib
import numpy as np

app = FastAPI(title="BIO-GUARD Predictive AI", version="1.0")

# Load model and scaler at startup
try:
    model = joblib.load('model_sgd.pkl')
    scaler = joblib.load('scaler.pkl')
except Exception as e:
    print(f"Error loading model/scaler: {e}")
    model, scaler = None, None

class TelemetryData(BaseModel):
    # Fitur Utama (Sesuai Prompt 1 & 2 yang sudah disesuaikan untuk mencegah data leakage)
    jarak_tempuh_km: float
    durasi_kemacetan_menit: float
    suhu_saat_ini: float = None
    nilai_mkt_sejauh_ini: float = None
    
    # Kompatibilitas jika request backend masih pakai nama variabel dari Prompt 2 awal
    suhu_rata_rata_box: float = None
    durasi_ekskursi_menit: float = None 
    nilai_mkt: float = None

@app.post("/predict")
def predict_risk(data: TelemetryData):
    if model is None or scaler is None:
        return {"error": "Model not loaded"}
        
    # Mapping nilai untuk mengakomodasi request lama maupun baru
    suhu = data.suhu_saat_ini if data.suhu_saat_ini is not None else (data.suhu_rata_rata_box or 5.0)
    mkt = data.nilai_mkt_sejauh_ini if data.nilai_mkt_sejauh_ini is not None else (data.nilai_mkt or 5.0)
    
    # Urutan fitur harus sama dengan saat training:
    # ['jarak_tempuh_km', 'durasi_kemacetan_menit', 'suhu_saat_ini', 'nilai_mkt_sejauh_ini']
    features = np.array([[
        data.jarak_tempuh_km,
        data.durasi_kemacetan_menit,
        suhu,
        mkt
    ]])
    
    # Scaling and prediction
    features_scaled = scaler.transform(features)
    prob_rusak = model.predict(features_scaled)[0]
    
    # Memastikan output antara 0 dan 1
    prob_rusak = max(0.0, min(1.0, float(prob_rusak)))
    
    # Aturan Mitigasi (Rule-based, instruksi dari prompt 2)
    if prob_rusak > 0.7:
        mitigasi = "Ganti dry ice/ice pack segera, hubungi dispatcher"
    elif prob_rusak >= 0.3:
        mitigasi = "Pantau ketat, percepat perjalanan jika memungkinkan"
    else:
        mitigasi = "Kondisi aman, lanjutkan perjalanan normal"
        
    return {
        "probabilitas_rusak": round(prob_rusak, 4),
        "instruksi_mitigasi": mitigasi
    }

if __name__ == "__main__":
    import uvicorn
    # Jalankan uvicorn secara terprogram untuk testing mudah
    uvicorn.run(app, host="0.0.0.0", port=8001)
