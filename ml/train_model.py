import pandas as pd
import json
import datetime
from sklearn.linear_model import SGDRegressor
from sklearn.model_selection import train_test_split
from sklearn.metrics import mean_squared_error

def train_and_export():
    # 1. Load data
    try:
        df = pd.DataFrame(pd.read_csv("dataset_sintetis.csv"))
    except FileNotFoundError:
        print("dataset_sintetis.csv tidak ditemukan. Jalankan generate_dataset.py terlebih dahulu.")
        return

    # 2. Pisahkan fitur (X) dan target (y)
    X = df[['sisa_jarak_km', 'durasi_kemacetan_menit', 'fluktuasi_mkt']]
    # Karena kita akan memprediksi 'z' logit (sebelum sigmoid) agar bisa di-inverse mudah oleh PHP
    # Tapi SGDRegressor bisa saja langsung memprediksi probabilitas jika tidak dibatasi, 
    # namun probabilitas_rusak dibangkitkan dari sigmoid. 
    # Agar lebih akurat, lebih baik meregresi terhadap nilai probabilitas rusak langsung 
    # untuk MVP ini (walau secara teoritis lebih cocok Logistic Regression / regresi pada logit).
    # Namun proposal PKM-KC Bio-Guard spesifik menyebut "Stochastic Gradient Descent (SGD)" 
    # memprediksi risiko. Kita regresi langsung.
    y = df['probabilitas_rusak']

    # 3. Train-test split (80/20)
    X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.2, random_state=42)

    # 4. Inisialisasi dan Latih SGDRegressor
    # Menggunakan learning rate yang sangat kecil (eta0=1e-6) untuk mencegah exploding gradient
    # karena fitur sisa_jarak_km dan durasi_kemacetan nilainya cukup besar dan kita tidak menggunakan StandardScaler 
    # agar persamaan regresi di PHP tetap sederhana.
    model = SGDRegressor(max_iter=5000, tol=1e-3, learning_rate='constant', eta0=1e-6, random_state=42)
    model.fit(X_train, y_train)

    # 5. Evaluasi dengan MSE
    y_pred = model.predict(X_test)
    mse = mean_squared_error(y_test, y_pred)
    
    print("=== Hasil Training Model AI (SGDRegressor) ===")
    print(f"Mean Squared Error (MSE): {mse:.6f}")
    
    # 6. Ekspor bobot model ke JSON
    koef = model.coef_
    intercept = model.intercept_[0]
    
    model_data = {
        "koef_sisa_jarak": float(koef[0]),
        "koef_kemacetan": float(koef[1]),
        "koef_fluktuasi_mkt": float(koef[2]),
        "intercept": float(intercept),
        "trained_at": datetime.date.today().isoformat(),
        "training_data": "synthetic_v1",
        "mse": float(mse)
    }
    
    with open("model_weights.json", "w") as f:
        json.dump(model_data, f, indent=4)
        
    print("Berhasil mengekspor bobot model ke ml/model_weights.json")

if __name__ == "__main__":
    train_and_export()
