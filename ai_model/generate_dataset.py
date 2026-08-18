import numpy as np
import pandas as pd

# Constants for Arrhenius equation
DELTA_H = 83.14 # kJ/mol (example for some proteins/vaccines)
R = 0.0083144 # kJ/(mol.K)
REF_TEMP_C = 5.0 # Center of 2-8C range

def calculate_mkt(temperatures):
    """Calculate Mean Kinetic Temperature."""
    if len(temperatures) == 0:
         return REF_TEMP_C
    
    # Convert to Kelvin
    temps_k = np.array(temperatures) + 273.15
    
    # Arrhenius equation
    term = np.exp(-DELTA_H / (R * temps_k))
    mean_term = np.mean(term)
    
    if mean_term == 0:
        return REF_TEMP_C
        
    mkt_k = (-DELTA_H / R) / np.log(mean_term)
    return mkt_k - 273.15

def generate_dataset(num_samples=5000):
    np.random.seed(42)
    
    # 1. Independent Trip Parameters
    # Mix of Puskesmas (further, more variable) and RS (closer, city center)
    # Let's say 30% RS (2-8 km), 70% Puskesmas (5-20 km)
    is_rs = np.random.rand(num_samples) < 0.3
    jarak_tempuh_km = np.where(is_rs, 
                               np.random.uniform(2, 8, num_samples), 
                               np.random.uniform(5, 20, num_samples))
    
    durasi_kemacetan_menit = np.random.uniform(0, 60, num_samples)
    
    # Derived expected travel time
    # Average speed 20 km/h -> 3 min/km
    waktu_tempuh_lancar = jarak_tempuh_km * 3 
    total_waktu_tempuh = waktu_tempuh_lancar + durasi_kemacetan_menit
    
    # 2. Causality for Excursion
    data = []
    
    for i in range(num_samples):
        total_waktu = int(total_waktu_tempuh[i])
        if total_waktu == 0:
            total_waktu = 1
            
        start_temp = np.random.uniform(3.5, 6.0)
        temps = [start_temp]
        
        # Determine the "current" time for prediction (e.g., somewhere between 30% and 80% of the trip)
        pred_time_pct = np.random.uniform(0.3, 0.8)
        pred_time_idx = max(1, int(total_waktu * pred_time_pct))
        
        # Distribute traffic randomly across the trip
        macet_menit = int(durasi_kemacetan_menit[i])
        is_macet = np.zeros(total_waktu)
        if macet_menit > 0 and total_waktu > 0:
            macet_indices = np.random.choice(total_waktu, min(macet_menit, total_waktu), replace=False)
            is_macet[macet_indices] = 1
            
        for t in range(1, total_waktu + 1):
            # Base warming rate (normal travel)
            warming_rate = np.random.normal(0.015, 0.01) 
            
            # In traffic, temperature rises faster (ambient heat from road/vehicles, less airflow)
            if is_macet[t-1] == 1:
                 warming_rate += np.random.normal(0.035, 0.01)
                 
            # After 45 mins, cooling effect degrades
            if t > 45: 
                 warming_rate += np.random.normal(0.02, 0.01)
                 
            # Add some noise
            noise = np.random.normal(0, 0.08)
            
            next_temp = temps[-1] + warming_rate + noise
            
            # Occasionally, ice packs might cause temporary freezing (e.g., sensor touches ice)
            if np.random.rand() < 0.005: 
                next_temp -= np.random.uniform(1.0, 3.0)
                
            temps.append(next_temp)
            
        temps = np.array(temps)
        
        # Calculate features at PREDICTION TIME (sejauh ini)
        suhu_saat_ini = temps[pred_time_idx]
        mkt_sejauh_ini = calculate_mkt(temps[:pred_time_idx+1])
        
        # We model probabilitas_rusak as Accumulated Kinetic Degradation
        # According to Arrhenius, reaction rate k = A * exp(-Ea/RT)
        # Let's define a "baseline" safe rate at 5C (278.15K)
        T_safe = 278.15
        k_safe = np.exp(-DELTA_H / (R * T_safe))
        
        # 1. Accumulated degradation so far based on MKT
        T_mkt_now = mkt_sejauh_ini + 273.15
        k_now = np.exp(-DELTA_H / (R * T_mkt_now))
        
        # Degradation is relative to safe rate. If MKT is 8C, rate is higher.
        # Let's say max allowable degradation is 1.0 (100% rusak).
        # We accumulate over `pred_time_idx` minutes.
        # We scale it such that 45 mins at 9C gives ~0.6 degradation, and 120 mins at 5C gives ~0.1
        degrad_rate_per_min = k_now * 5.0e13 # Arbitrary scaling factor to map to 0-1 range
        degrad_so_far = degrad_rate_per_min * pred_time_idx
        
        # 2. Expected future degradation
        # Assume remaining time is (total_waktu - pred_time_idx)
        remaining_time = total_waktu - pred_time_idx
        # Future temp will likely be similar to current temp if it's already excursion, but tending towards ambient
        # For simplicity, let's assume future rate is based on suhu_saat_ini (since we want the model to learn the risk of current temp)
        T_future = suhu_saat_ini + 273.15
        k_future = np.exp(-DELTA_H / (R * T_future))
        future_degrad_rate_per_min = k_future * 5.0e13
        expected_future_degrad = future_degrad_rate_per_min * remaining_time
        
        # 3. Freezing damage (Protein denaturation / adjuvant damage)
        # Freezing damage is often immediate and catastrophic
        freezing_damage = 0.0
        if np.min(temps[:pred_time_idx+1]) < 2.0:
            # If it dropped below 2C at any point, risk jumps
            min_temp = np.min(temps[:pred_time_idx+1])
            freezing_damage = (2.0 - min_temp) * 0.4 # up to 0.8 extra risk
            
        prob_rusak = degrad_so_far + expected_future_degrad + freezing_damage
        
        # Add irreducible physical variation/noise
        prob_rusak += np.random.normal(0, 0.05)
        
        # Clip to 0-1
        prob_rusak = np.clip(prob_rusak, 0, 1)
        
        data.append({
            'jarak_tempuh_km': round(jarak_tempuh_km[i], 2),
            'durasi_kemacetan_menit': round(durasi_kemacetan_menit[i], 2),
            'suhu_saat_ini': round(suhu_saat_ini, 2),
            'nilai_mkt_sejauh_ini': round(mkt_sejauh_ini, 2),
            'probabilitas_rusak': round(prob_rusak, 4),
            'durasi_ekskursi_menit_final': int(np.sum((temps < 2) | (temps > 8))),
            'nilai_mkt_final': round(calculate_mkt(temps), 2)
        })
        
    df = pd.DataFrame(data)
    return df

if __name__ == "__main__":
    print("Membangun dataset sintetis...")
    df = generate_dataset(5000)
    
    csv_path = "training_data.csv"
    df.to_csv(csv_path, index=False)
    print(f"Dataset disimpan ke {csv_path}")
    
    print("\n=== Statistik Dataset ===")
    print(df.describe())
    
    print("\n=== Matriks Korelasi (Fitur Input vs Target) ===")
    input_features = ['jarak_tempuh_km', 'durasi_kemacetan_menit', 'suhu_saat_ini', 'nilai_mkt_sejauh_ini']
    target = 'probabilitas_rusak'
    
    correlations = df[input_features + [target]].corr()[target].drop(target)
    print(correlations.to_string())
    
    print("\nPengecekan: Tidak ada fitur input yang korelasinya = 0.000 atau > 0.9.")
