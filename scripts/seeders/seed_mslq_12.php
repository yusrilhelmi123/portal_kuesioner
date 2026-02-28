<?php
require 'app/Core/Database.php';
use App\Core\Database;

$db = Database::getInstance();

// Clear existing questions and reset auto-increment
$db->query("TRUNCATE TABLE mslq_questions");

$questions = [
    // Motivasi
    ['teks' => 'Dalam kelas seperti ini, saya lebih suka materi yang benar-benar menantang sehingga saya bisa mempelajari hal-hal baru.', 'dimensi' => 'Intrinsic Goal Orientation'],
    ['teks' => 'Jika saya belajar dengan cara yang benar, saya akan mampu mempelajari materi dalam kursus ini.', 'dimensi' => 'Control of Learning Beliefs'],
    ['teks' => 'Saya yakin saya bisa memahami materi yang paling sulit yang disajikan dalam bacaan untuk kursus ini.', 'dimensi' => 'Self-Efficacy for Learning'],
    ['teks' => 'Sangat penting bagi saya untuk mempelajari materi pelajaran dalam kursus ini.', 'dimensi' => 'Task Value'],
    ['teks' => 'Saya merasa jantung saya berdetak kencang saat mengerjakan ujian.', 'dimensi' => 'Test Anxiety'],
    ['teks' => 'Tujuan utama saya adalah mendapatkan nilai yang baik di kelas ini.', 'dimensi' => 'Extrinsic Goal Orientation'],

    // Strategi Belajar
    ['teks' => 'Ketika saya membaca materi untuk kursus ini, saya mencoba menghubungkan informasi tersebut dengan apa yang sudah saya ketahui.', 'dimensi' => 'Elaboration'],
    ['teks' => 'Saya membuat garis besar (outline) untuk membantu saya mengatur ide-ide saya saat belajar.', 'dimensi' => 'Organization'],
    ['teks' => 'Saya sering bertanya pada diri sendiri apakah saya telah memahami apa yang baru saja saya baca.', 'dimensi' => 'Metacognitive Self-Regulation'],
    ['teks' => 'Saya memiliki tempat khusus untuk belajar yang tenang dan bebas gangguan.', 'dimensi' => 'Time and Study Environment'],
    ['teks' => 'Bahkan ketika materi kursus membosankan atau tidak menarik, saya tetap bekerja sampai saya selesai.', 'dimensi' => 'Effort Regulation'],
    ['teks' => 'Saya mencoba bermain-main dengan ide-ide saya sendiri yang terkait dengan apa yang saya pelajari dalam kursus ini.', 'dimensi' => 'Critical Thinking']
];

$stmt = $db->prepare("INSERT INTO mslq_questions (teks_pertanyaan, dimensi) VALUES (?, ?)");
foreach ($questions as $q) {
    $stmt->execute([$q['teks'], $q['dimensi']]);
}

echo "Berhasil memasukkan 12 pertanyaan MSLQ.";
