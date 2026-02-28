# Dokumentasi Pengaturan & Konfigurasi Port
## POINTMARKET - Motivational Engine

Dokumen ini berisi informasi mengenai konfigurasi teknis untuk menjalankan aplikasi kuesioner psikometrik **POINTMARKET**.

### 1. Konfigurasi Docker (docker-compose)
Untuk menghindari konflik dengan aplikasi lain (seperti aplikasi RL atau database bawaan sistem), port telah dipetakan sebagai berikut:

| Service | Port Internal (Docker) | Port Eksternal (Host/Local) | Keterangan |
| :--- | :---: | :---: | :--- |
| **Aplikasi Web** | 80 | **8085** | Diakses melalui `http://localhost:8085` |
| **Database (MySQL)** | 3306 | **3308** | Host: `localhost`, Port: `3308` |
| **phpMyAdmin** | 80 | **8086** | Diakses melalui `http://localhost:8086` |

### 2. Informasi Database
Konfigurasi koneksi database yang digunakan oleh aplikasi:
- **Host:** `db` (dalam jaringan docker) atau `localhost:3308` (luar docker)
- **Nama Database:** `kuisioner_pm`
- **Username:** `root`
- **Password:** `root_120351`

### 3. Cara Menjalankan Aplikasi
Pastikan Docker Desktop sudah aktif, lalu jalankan perintah berikut di folder root project:

```powershell
# Menjalankan aplikasi di background
docker-compose up -d

# Memberhentikan aplikasi
docker-compose down
```

### 4. Pengelolaan Bank Soal (Seeding)
Jika database dalam keadaan kosong, gunakan script seeder yang berada di folder `scripts/seeders/` untuk mengisi pertanyaan secara otomatis:

```powershell
# Mengisi Soal VARK (12 Pertanyaan)
docker-compose exec app php scripts/seeders/seed_vark_12.php

# Mengisi Soal MSLQ (30 Pertanyaan)
docker-compose exec app php scripts/seeders/seed_mslq_30.php

# Mengisi Soal AMS (12 Pertanyaan)
docker-compose exec app php scripts/seeders/seed_ams_12.php
```

### 5. API & Dokumentasi Swagger
Aplikasi telah dilengkapi dengan endpoint API untuk integrasi data:

- **Dokumentasi Swagger (UI):** `http://localhost:8085/api/docs`
- **Endpoint Data Hasil:** `http://localhost:8085/api/results` (Format JSON)
- **Spesifikasi OpenAPI (YAML):** `http://localhost:8085/api/spec`

Format JSON yang dihasilkan:
```json
 {
    "npm": "24001",
    "nama": "Amin",
    "vark_type": "V",
    "mslq_score": 5.5,
    "ams_type": "achievement"
 }
```

---
**Catatan:** Jika Anda mengalami error "Port is already allocated", pastikan tidak ada aplikasi lain yang menggunakan port 8085, 3308, atau 8086. Anda dapat mengubah angka port di file `docker-compose.yml` pada bagian kolom kiri sebelum tanda titik dua (misal: `"8087:80"`).

---
**Pengembang:** M. Yusril Helmi Setyawan
**Lab:** PM Lab Riset
