<?php
require 'app/Core/Database.php';
use App\Core\Database;

$db = Database::getInstance();

// Clear existing AMS questions and reset auto-increment
$db->query("TRUNCATE TABLE ams_questions");

$questions = [
    // 1. Intrinsic Motivation
    ['teks' => 'Karena saya mendapatkan kesenangan dan kepuasan saat mempelajari hal-hal baru.', 'kategori' => 'intrinsic'],
    ['teks' => 'Karena belajar memungkinkan saya untuk merasakan kesenangan yang mendalam dalam memahami subjek yang menarik bagi saya.', 'kategori' => 'intrinsic'],
    ['teks' => 'Untuk kepuasan yang saya rasakan ketika saya mengatasi kesulitan dalam memahami materi yang kompleks.', 'kategori' => 'intrinsic'],

    // 2. Extrinsic Motivation
    ['teks' => 'Karena saya pikir pendidikan tinggi akan mempersiapkan saya lebih baik untuk karier yang saya pilih.', 'kategori' => 'extrinsic'],
    ['teks' => 'Karena memiliki gelar sarjana akan membantu saya mendapatkan pekerjaan dengan gaji yang lebih baik.', 'kategori' => 'extrinsic'],
    ['teks' => 'Karena saya ingin memiliki kehidupan yang nyaman dan status sosial yang lebih baik di masa depan.', 'kategori' => 'extrinsic'],

    // 3. Achievement Motivation
    ['teks' => 'Karena saya ingin membuktikan kepada diri sendiri bahwa saya bisa sukses dalam studi saya.', 'kategori' => 'achievement'],
    ['teks' => 'Untuk kepuasan yang saya rasakan ketika saya melampaui diri saya sendiri dalam pencapaian akademik.', 'kategori' => 'achievement'],
    ['teks' => 'Karena saya ingin merasa penting dan dihargai melalui keberhasilan saya di kampus.', 'kategori' => 'achievement'],

    // 4. Amotivation
    ['teks' => 'Saya tidak tahu; saya merasa bahwa saya tidak mampu sukses dalam belajar.', 'kategori' => 'amotivation'],
    ['teks' => 'Jujur saya tidak tahu; saya merasa seolah-olah saya membuang waktu saja di kampus.', 'kategori' => 'amotivation'],
    ['teks' => 'Dulu saya tahu mengapa saya kuliah, tapi sekarang saya mulai bertanya-tanya apakah saya harus melanjutkannya.', 'kategori' => 'amotivation']
];

$stmt = $db->prepare("INSERT INTO ams_questions (teks_pertanyaan, kategori) VALUES (?, ?)");
foreach ($questions as $q) {
    $stmt->execute([$q['teks'], $q['kategori']]);
}

echo "Berhasil memasukkan 12 pertanyaan AMS (3 per kategori).";
