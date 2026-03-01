# Panduan Penggunaan Git & GitHub

Dokumen ini berisi panduan langkah-demi-langkah untuk mengelola proyek menggunakan Git, mulai dari inisialisasi awal hingga pengiriman perubahan ke GitHub.

## 1. Persiapan Awal (Satu Kali Saja)

Sebelum memulai, pastikan identitas Git Anda sudah terkonfigurasi di komputer:

```bash
git config --global user.name "Nama Anda"
git config --global user.email "email_anda@example.com"
```

## 2. Inisialisasi Proyek Baru ke GitHub

Jika Anda baru saja membuat folder proyek dan ingin menghubungkannya ke repository GitHub yang baru:

1.  **Masuk ke folder proyek:**
    ```bash
    cd "lokasi/folder/proyek"
    ```
2.  **Inisialisasi Git:**
    ```bash
    git init
    ```
3.  **Tambahkan semua file:**
    ```bash
    git add .
    ```
4.  **Lakukan commit pertama:**
    ```bash
    git commit -m "First commit: Inisialisasi proyek"
    ```
5.  **Tentukan branch utama (main):**
    ```bash
    git branch -M main
    ```
6.  **Hubungkan ke repository GitHub:**
    *(Ganti URL dengan alamat repository Anda)*
    ```bash
    git remote add origin https://github.com/yusrilhelmi123/portal_kuesioner.git
    ```
7.  **Push (Unggah) ke GitHub:**
    ```bash
    git push -u origin main
    ```

---

## 3. Melakukan Perubahan dan Commit Selanjutnya

Gunakan langkah-langkah ini setiap kali Anda selesai menambah fitur atau memperbaiki bug:

1.  **Cek status perubahan (Opsional):**
    ```bash
    git status
    ```
2.  **Tambahkan perubahan ke area "Stage":**
    *   Untuk semua perubahan: `git add .`
    *   Untuk file spesifik: `git add nama_file.php`
3.  **Simpan perubahan dengan pesan (Commit):**
    ```bash
    git commit -m "Deskripsi singkat perubahan yang Anda buat"
    ```
4.  **Kirim perubahan ke GitHub:**
    ```bash
    git push origin main
    ```

---

## 4. Perintah Berguna Lainnya

*   **Melihat riwayat commit:**
    ```bash
    git log --oneline
    ```
*   **Membatalkan `git add` (sebelum commit):**
    ```bash
    git reset nama_file.php
    ```
*   **Mengambil pembaruan dari GitHub (jika ada perubahan di web):**
    ```bash
    git pull origin main
    ```

---

> [!TIP]
> Selalu berikan pesan commit yang deskriptif (misal: "Memperbaiki kalkulasi skor" daripada hanya "Update") agar Anda mudah melacak riwayat perubahan proyek di masa depan.
