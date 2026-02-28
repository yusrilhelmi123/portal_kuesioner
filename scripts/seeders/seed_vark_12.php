<?php
require 'app/Core/Database.php';
use App\Core\Database;

$db = Database::getInstance();

// Clear existing questions and reset auto-increment
$db->query("TRUNCATE TABLE vark_questions");

$questions = [
    [
        'teks' => 'Anda ingin mempelajari cara menggunakan aplikasi smartphone baru. Anda akan:',
        'v' => 'Melihat diagram alir atau screenshot tampilan aplikasi.',
        'a' => 'Mendengarkan penjelasan teman tentang cara pakainya.',
        'r' => 'Membaca petunjuk penggunaan tertulis di menu bantuan.',
        'k' => 'Langsung mencoba-coba tombol dan fitur aplikasinya.'
    ],
    [
        'teks' => 'Anda sedang merencanakan perjalanan liburan ke tempat yang belum pernah dikunjungi. Anda akan:',
        'v' => 'Melihat peta rute perjalanan dan foto-foto lokasinya.',
        'a' => 'Menanyakan rekomendasi tempat kepada orang lain.',
        'r' => 'Membaca ulasan tertulis dan panduan wisata.',
        'k' => 'Pergi saja dan mencari tahu sendiri saat sudah sampai.'
    ],
    [
        'teks' => 'Anda diminta untuk merakit lemari meja DIY yang baru dibeli. Anda akan:',
        'v' => 'Melihat gambar petunjuk perakitan di dalam kotak.',
        'a' => 'Mendengarkan instruksi video tutorial di internet.',
        'r' => 'Membaca instruksi teks langkah demi langkah yang teliti.',
        'k' => 'Mulai merakit bagian-bagiannya secara langsung.'
    ],
    [
        'teks' => 'Anda sedang mempertimbangkan untuk membeli gadget (HP/Laptop) baru. Anda akan:',
        'v' => 'Memperhatikan desain dan keindahan tampilan luarnya.',
        'a' => 'Berdiskusi dengan penjual atau teman tentang spesifikasinya.',
        'r' => 'Membaca tabel spesifikasi dan perbandingan teknis.',
        'k' => 'Mencoba langsung (hands-on) unit yang ada di toko.'
    ],
    [
        'teks' => 'Seorang teman memberikan resep masakan baru kepada Anda. Anda akan:',
        'v' => 'Melihat foto hasil akhir masakan tersebut untuk inspirasi.',
        'a' => 'Mendengarkan teman menjelaskan cara memasaknya.',
        'r' => 'Membaca daftar bahan dan instruksi masaknya dengan seksama.',
        'k' => 'Langsung praktik memasak bersama teman tersebut.'
    ],
    [
        'teks' => 'Anda ingin mengetahui berita atau informasi terbaru hari ini. Anda akan:',
        'v' => 'Menonton video berita atau melihat infografis di media sosial.',
        'a' => 'Mendengarkan siaran berita di radio atau podcast.',
        'r' => 'Membaca artikel berita di situs web atau aplikasi portal berita.',
        'k' => 'Berdiskusi dengan orang di sekitar tentang kejadian terbaru.'
    ],
    [
        'teks' => 'Anda sedang menjelaskan ide proyek baru kepada rekan kerja. Anda akan:',
        'v' => 'Menggambar bagan atau sketsa ide di papan tulis / kertas.',
        'a' => 'Menjelaskan ide tersebut secara lisan melalui pembicaraan.',
        'r' => 'Menuliskan ringkasan poin-poin ide dalam dokumen teks.',
        'k' => 'Melakukan demonstrasi atau simulasi cara kerja ide tersebut.'
    ],
    [
        'teks' => 'Anda sedang mencoba mengingat kembali materi pelajaran yang lalu. Anda akan:',
        'v' => 'Mengingat gambar, letak tulisan, atau warna stabilo di catatan.',
        'a' => 'Mengingat suara penjelasan guru atau diskusi di kelas.',
        'r' => 'Mengingat kalimat-kalimat atau teks yang pernah dibaca.',
        'k' => 'Mengingat pengalaman saat melakukan praktik atau tugas.'
    ],
    [
        'teks' => 'Anda ingin mempelajari tarian atau gerakan senam baru. Anda akan:',
        'v' => 'Menonton instruktur memberikan contoh gerakannya.',
        'a' => 'Mendengarkan hitungan irama musik dan arahan suara.',
        'r' => 'Membaca keterangan tertulis tentang urutan langkahnya.',
        'k' => 'Langsung ikut bergerak mengikuti gerakan instruktur.'
    ],
    [
        'teks' => 'Anda sedang mencari buku untuk dibaca di toko buku. Anda akan:',
        'v' => 'Melihat ilustrasi, foto, atau tata letak desain di dalam buku.',
        'a' => 'Mendengarkan saran atau ulasan lisan dari pembeli lain.',
        'r' => 'Membaca sinopsis di sampul belakang dan daftar isinya.',
        'k' => 'Membuka-buka halaman dan merasakan fisik serta berat buku.'
    ],
    [
        'teks' => 'Anda sedang berlatih untuk melakukan presentasi penting. Anda akan:',
        'v' => 'Melihat rekaman video orang lain saat melakukan presentasi.',
        'a' => 'Merekam suara latihan Anda sendiri dan mendengarkannya kembali.',
        'r' => 'Membaca outline atau naskah presentasi berulang-ulang.',
        'k' => 'Berlatih di depan cermin sambil melakukan gerakan tubuh.'
    ],
    [
        'teks' => 'Anda diminta menjelaskan rute jalan ke suatu tempat. Anda akan:',
        'v' => 'Menggambar sketsa peta sederhana di selembar kertas.',
        'a' => 'Memberikan petunjuk arah secara lisan dengan detail.',
        'r' => 'Menuliskan daftar nama jalan dan instruksi belokan.',
        'k' => 'Mengajak orang tersebut pergi bersama Anda ke lokasi.'
    ]
];

$stmt = $db->prepare("INSERT INTO vark_questions (teks_pertanyaan, opt_v, opt_a, opt_r, opt_k) VALUES (?, ?, ?, ?, ?)");
foreach ($questions as $q) {
    $stmt->execute([$q['teks'], $q['v'], $q['a'], $q['r'], $q['k']]);
}

echo "Berhasil memasukkan 12 pertanyaan VARK.";
