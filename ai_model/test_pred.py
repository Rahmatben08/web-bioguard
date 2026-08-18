import joblib
import numpy as np

model = joblib.load('model_sgd.pkl')
scaler = joblib.load('scaler.pkl')

def test(jarak, macet, suhu, mkt):
    X = scaler.transform([[jarak, macet, suhu, mkt]])
    prob = model.predict(X)[0]
    return np.clip(prob, 0, 1)

print("Aman (5C, lancar, mkt 5):", test(2, 0, 5.0, 5.0))
print("Kritis (9C, macet parah, mkt 8.5):", test(20, 60, 9.0, 8.5))
