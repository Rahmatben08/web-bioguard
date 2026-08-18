import pandas as pd
from sklearn.model_selection import train_test_split
from sklearn.preprocessing import StandardScaler
from sklearn.linear_model import SGDRegressor
from sklearn.metrics import mean_squared_error
import joblib

# 1. Load data
print("Memuat training_data.csv...")
df = pd.read_csv('training_data.csv')

# Menggunakan fitur dari Langkah 1 untuk mencegah DATA LEAKAGE.
# Sesuai perbaikan di Prompt 1, durasi final dan mkt final HANYA untuk label.
# Fitur yang dipakai adalah kondisi sejauh ini.
features = ['jarak_tempuh_km', 'durasi_kemacetan_menit', 'suhu_saat_ini', 'nilai_mkt_sejauh_ini']
X = df[features]
y = df['probabilitas_rusak']

# 2. Split train/test (80/20)
X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.2, random_state=42)

# 3. Standardisasi fitur (Penting untuk SGD)
scaler = StandardScaler()
X_train_scaled = scaler.fit_transform(X_train)
X_test_scaled = scaler.transform(X_test)

# Latih Model SGD
print("Melatih SGDRegressor...")
model = SGDRegressor(max_iter=1000, tol=1e-3, random_state=42)
model.fit(X_train_scaled, y_train)

# 4. Evaluasi pakai MSE
y_pred = model.predict(X_test_scaled)
mse = mean_squared_error(y_test, y_pred)
print(f"\n[OK] Mean Squared Error (MSE) di test set: {mse:.6f}")

# 5. Simpan model dan scaler ke file
joblib.dump(model, 'model_sgd.pkl')
joblib.dump(scaler, 'scaler.pkl')
print("[OK] Model (model_sgd.pkl) dan scaler (scaler.pkl) berhasil disimpan.")
