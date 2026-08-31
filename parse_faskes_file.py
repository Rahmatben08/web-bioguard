# -*- coding: utf-8 -*-
import json
import re

markdown_text = """
| 1 | RSUD Palembang (BARI) | RSUD, Tipe B | Seberang Ulu I | -3.0106777 | 104.7685973 | |
| 2 | RSUD Sumatera Selatan | RSUD, Tipe B | Sukarami | -2.9482346 | 104.7345504 | |
| 3 | RS Ar-Rasyid | RS, Tipe C | Sukarami | -2.9361687 | 104.7218342 | |
| 4 | RS Bhayangkara Palembang | RS, Tipe C | Kemuning | -2.9590320 | 104.7372230 | |
| 5 | RS Bunda Palembang | RS, Tipe C | Ilir Barat I | -2.9679351 | 104.7344397 | |
| 6 | RS Dr. AK. Gani | RS, Tipe C | Bukit Kecil | -2.9903282 | 104.7601422 | |
| 7 | RS Ernaldi Bahar | RS Jiwa, Tipe A | Alang-Alang Lebar | -2.9233850 | 104.6828728 | |
| 8 | RS Graha Mandiri | RS, Tipe D | Ilir Barat I | -2.9685214 | 104.7262687 | |
| 9 | RS Hermina Palembang | RS, Tipe C | Kemuning | -2.9558049 | 104.7483075 | |
| 10 | RS Islam Siti Khadijah | RS, Tipe B | Ilir Barat I | -2.9716501 | 104.7314097 | |
| 11 | RS Karya Asih Charitas | RS, Tipe D | Sematang Borang | -2.9372750 | 104.7947840 | Google Maps: "Charitas Hospital Kenten" |
| 12 | RS Masyarakat Sumatera Selatan | RS Mata, Tipe B | Sukarami | -2.9499828 | 104.7340764 | Google Maps: "RS Mata Binar" |
| 13 | RS Muhammadiyah Palembang | RS, Tipe C | Seberang Ulu II | -2.9963630 | 104.7766891 | |
| 14 | RS Musi Medika Cendikia | RS, Tipe C | Ilir Barat I | -2.9799306 | 104.7239792 | |
| 15 | RS Myria Palembang | RS, Tipe C | Sukarami | -2.9406970 | 104.7266987 | koordinat dari titik alamat umum, akurasi sedikit lebih rendah dari entri lain |
| 16 | RS Paru Palembang | RS Paru, Tipe B | Bukit Kecil | -2.9902166 | 104.7504980 | |
| 17 | RS Pelabuhan Palembang | RS, Tipe C | Ilir Timur II | -2.9790070 | 104.7768160 | |
| 18 | RS Pertamina Plaju | RS, Tipe C | Plaju | -2.9945037 | 104.8246858 | |
| 19 | RS Pusri Palembang | RS, Tipe C | Kalidoni | -2.9702776 | 104.8013607 | |
| 20 | RS RK Charitas | RS, Tipe B | Ilir Timur I | -2.9750631 | 104.7526774 | |
| 21 | RS Siloam Sriwijaya | RS, Tipe C | Ilir Barat I | -2.9777701 | 104.7423333 | |
| 22 | RS Sriwijaya Palembang | RS, Tipe C | Ilir Timur I | -2.9596308 | 104.7370085 | |
| 23 | RSIA Az-Zahra Palembang | RSIA, Tipe C | Kalidoni | -2.9422846 | 104.7841096 | |
| 24 | RSIA Bunda Noni | RSIA, Tipe C | Ilir Barat I | -2.9929434 | 104.7264614 | |
| 25 | RSIA Kader Bangsa | RSIA, Tipe C | Kertapati | -3.0337280 | 104.7519596 | |
| 26 | RSIA Mama Palembang | RSIA, Tipe B | Ilir Barat I | -2.9754852 | 104.7407355 | |
| 27 | RSIA Marissa Palembang | RSIA, Tipe C | Plaju | -3.0057493 | 104.8180779 | |
| 28 | RSIA Rika Amelia | RSIA, Tipe C | Sukarami | -2.9139307 | 104.6955885 | |
| 29 | RSIA Tiara Fatrin | RSIA, Tipe C | Ilir Timur II | -2.9689946 | 104.7636227 | |
| 30 | RSIA Trinanda Palembang | RSIA, Tipe C | Ilir Timur II | -2.9701634 | 104.7850769 | |
| 31 | RSIA Widiyanti Palembang | RSIA, Tipe C | Ilir Timur II | -2.9432126 | 104.7666101 | |
| 32 | RSIA YK Madira | RSIA, Tipe C | Ilir Timur I | -2.9727996 | 104.7523186 | |
| 33 | RSUP Dr. Mohammad Hoesin | RSU, Tipe A | Kemuning | -2.9664071 | 104.7502143 | |
| 34 | RS Hermina OPI Jakabaring | RS | Rambutan | -3.0338819 | 104.7909939 |  |
| 1 | Puskesmas Padang Selasa | Ilir Barat I | -2.9901710 | 104.7342989 | |
| 2 | Puskesmas Multiwahana | Sako | -2.9287047 | 104.7805291 |  |
| 3 | Puskesmas Sako | Sako | -2.9211968 | 104.7920894 | |
| 4 | Puskesmas Pembina | Jakabaring / Seberang Ulu I | -2.9968695 | 104.7753158 | |
| 5 | Puskesmas Sekip | Kemuning | -2.9576051 | 104.7541237 | |
| 6 | Puskesmas Plaju | Plaju | -2.9957301 | 104.8136895 | |
| 7 | Puskesmas Sosial | Sukarami | -2.9463340 | 104.7414677 | |
| 8 | Puskesmas Taman Bacaan | Seberang Ulu II | -2.9864446 | 104.7835277 | |
| 9 | Puskesmas Bukitsangkal | Kalidoni | -2.9376611 | 104.7805515 |  |
| 10 | Puskesmas Dempo | Ilir Timur I | -2.9818086 | 104.7588960 | |
| 11 | Puskesmas Keramasan | Kertapati | -3.0277125 | 104.7458236 | |
| 12 | Puskesmas Karya Jaya | Kertapati | -3.0408287 | 104.7261197 | |
| 13 | Puskesmas Lima Ilir | Ilir Timur II | -2.9650818 | 104.7727007 |  |
| 14 | Puskesmas Sematang Borang | Sako | -2.9340660 | 104.7904911 | |
| 15 | Puskesmas Tegal Binangun | Plaju | -3.0139275 | 104.8116080 | |
| 16 | Puskesmas Nagaswidak | Seberang Ulu II | -2.9915610 | 104.7826947 | |
| 17 | Puskesmas Merdeka | Bukit Kecil | -2.9904458 | 104.7528697 | |
| 18 | Puskesmas Kalidoni | Kalidoni | -2.9606647 | 104.7992580 | |
| 19 | Puskesmas Kertapati | Kertapati | -3.0256252 | 104.7470242 | |
| 20 | Puskesmas Sei Selincah | Kalidoni | -2.9683017 | 104.8216824 | |
| 21 | Puskesmas Dua Puluh Tiga Ilir | Bukit Kecil | -2.9878927 | 104.7548896 |  |
| 22 | Puskesmas Talang Ratu | Ilir Timur I | -2.9540110 | 104.7320921 | |
| 23 | Puskesmas Talangjambe | Sukarami | -2.8897521 | 104.7180794 | |
| 24 | Puskesmas Alang-Alang Lebar | Alang-Alang Lebar | -2.9315420 | 104.6907320 | |
| 25 | Puskesmas Kenten | Kalidoni | -2.9404925 | 104.7673936 | |
| 26 | Puskesmas Satu Ulu | Seberang Ulu I | -3.0114460 | 104.7519710 |  |
| 27 | Puskesmas Sukarami | Sukarami | -2.9204290 | 104.7170234 | |
| 28 | Puskesmas Tujuh Ulu | Seberang Ulu I | -2.9967252 | 104.7639443 | |
| 29 | Puskesmas Punti Kayu | Alang-Alang Lebar | -2.9498302 | 104.7264372 | |
| 30 | Puskesmas Makrayu | Ilir Barat II | -3.0000319 | 104.7442954 | |
| 31 | Puskesmas Sabokingking | Ilir Timur II | -2.9737381 | 104.7915577 | |
| 32 | Puskesmas Sei Baung | Ilir Barat I | -2.9732933 | 104.7431163 | |
| 33 | Puskesmas Boom Baru | Ilir Timur II | -2.9752592 | 104.7824175 | |
| 34 | Puskesmas Gandus | Gandus | -3.0189920 | 104.6792898 | |
| 35 | Puskesmas Talang Betutu | Sukarami | -2.8888931 | 104.6868828 | |
| 36 | Puskesmas OPI | Rambutan | -3.0485100 | 104.7848420 |  |
| 37 | Puskesmas Kampus | Ilir Barat I | -2.9755074 | 104.7383431 | |
| 38 | Puskesmas Pakjo | Ilir Barat I | -2.9635811 | 104.7344444 | |
| 39 | Puskesmas Ariodillah | Ilir Timur I | -2.9640104 | 104.7426207 |  |
| 40 | Puskesmas Sebelas Ilir | Ilir Timur II | -2.9811092 | 104.7673902 |  |
| 41 | Puskesmas Basuki Rahmat | Kemuning | -2.9481851 | 104.7490356 | |
| 42 | Puskesmas Empat Ulu | Seberang Ulu I | -3.0069681 | 104.7609593 |  |
"""

data = []
for line in markdown_text.strip().split('\n'):
    parts = [p.strip() for p in line.split('|')]
    if len(parts) >= 7 and parts[1].isdigit():
        name = parts[2]
        
        lat_match = re.search(r'-?\d+\.\d+', line)
        if lat_match:
            lat = lat_match.group(0)
            lng_match = re.search(r'-?\d+\.\d+', line[lat_match.end():])
            if lng_match:
                lng = lng_match.group(0)
            else:
                continue
        else:
            continue
                 
        data.append({
            "name": name,
            "lat": lat,
            "lng": lng
        })

print(f"Parsed {len(data)} entries.")

with open("faskes_data.json", "w", encoding="utf-8") as f:
    json.dump(data, f, indent=4)
