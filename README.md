# Portal Kuesioner PM

Sistem informasi berbasis web yang dirancang untuk mengelola kuesioner penelitian, khususnya untuk pemetaan profil belajar atau data responden secara terstruktur. Aplikasi ini dikembangkan sebagai bagian dari Riset Fundamental 2025-2026 pada Lab Riset PM.

## Fitur Utama

1.  **Dashboard Monitoring**: Visualisasi data hasil kuesioner yang masuk secara real-time.
2.  **Manajemen Kuesioner**: Sistem pengelolaan kuesioner yang mendukung berbagai model evaluasi (termasuk modul VARK dan AMS).
3.  **Pengolahan Hasil**: Fitur pemrosesan data otomatis untuk menghasilkan laporan profil responden.
4.  **Integrasi Data**: Kemampuan untuk sinkronisasi data dari berbagai sumber data riset terkait.
5.  **Panel Admin**: Pengaturan parameter penelitian, manajemen pengguna, dan kontrol penuh terhadap konten kuesioner.

## Struktur Proyek

Proyek ini menggunakan pola arsitektur MVC (Model-View-Controller) untuk memisahkan logika bisnis dengan tampilan:

*   **app/Controllers**: Menangani logika aplikasi dan aliran data.
*   **app/Models**: Interaksi dengan database dan skema data.
*   **app/Views**: Antarmuka pengguna dan tampilan dashboard.
*   **config**: Pengaturan konfigurasi sistem dan database.
*   **public**: File statis seperti CSS, JavaScript, dan assets gambar.

## Teknologi yang Digunakan

*   **Bahasa Pemrograman**: PHP
*   **Database**: MySQL
*   **Frontend**: HTML, CSS, JavaScript (Vanilla/Custom UI)
*   **Containerization**: Docker (tersedia berkas Dockerfile dan docker-compose)

## Penggunaan Terbatas

Aplikasi ini merupakan bagian dari kegiatan riset internal. Penggunaan dan distribusi materi di dalamnya harus mengikuti protokol legal dan etika riset yang berlaku di Lab Riset PM.
