<?php
require 'app/Core/Database.php';
use App\Core\Database;

$db = Database::getInstance();

// Clear existing MSLQ questions and reset auto-increment
$db->query("TRUNCATE TABLE mslq_questions");

$questions = [
    // 1. Intrinsic Goal Orientation
    ['teks' => 'Dalam kelas seperti ini, saya lebih suka materi yang benar-benar menantang sehingga saya bisa mempelajari hal-hal baru.', 'dimensi' => 'Intrinsic Goal Orientation'],
    ['teks' => 'Dalam kursus ini, saya lebih suka materi yang membangkitkan rasa ingin tahu saya, bahkan jika itu sulit dipahami.', 'dimensi' => 'Intrinsic Goal Orientation'],

    // 2. Extrinsic Goal Orientation
    ['teks' => 'Mendapatkan nilai bagus dalam kursus ini adalah hal yang paling memuaskan bagi saya saat ini.', 'dimensi' => 'Extrinsic Goal Orientation'],
    ['teks' => 'Saya ingin mendapatkan nilai yang lebih tinggi dari mahasiswa lainnya di kelas ini.', 'dimensi' => 'Extrinsic Goal Orientation'],

    // 3. Task Value
    ['teks' => 'Sangat penting bagi saya untuk mempelajari materi pelajaran dalam kursus ini.', 'dimensi' => 'Task Value'],
    ['teks' => 'Saya rasa saya akan bisa menggunakan apa yang saya pelajari dari kursus ini dalam kursus lain.', 'dimensi' => 'Task Value'],

    // 4. Control of Learning Beliefs
    ['teks' => 'Jika saya belajar dengan cara yang benar, saya akan mampu mempelajari materi dalam kursus ini.', 'dimensi' => 'Control of Learning Beliefs'],
    ['teks' => 'Ini adalah kesalahan saya sendiri jika saya tidak mempelajari materi dalam kursus ini.', 'dimensi' => 'Control of Learning Beliefs'],

    // 5. Self-Efficacy for Learning
    ['teks' => 'Saya yakin saya bisa memahami materi yang paling sulit yang disajikan dalam bacaan untuk kursus ini.', 'dimensi' => 'Self-Efficacy for Learning'],
    ['teks' => 'Saya yakin saya bisa melakukan pekerjaan yang sangat baik pada tugas dan tes dalam kursus ini.', 'dimensi' => 'Self-Efficacy for Learning'],

    // 6. Test Anxiety
    ['teks' => 'Saya merasa jantung saya berdetak kencang saat mengerjakan ujian.', 'dimensi' => 'Test Anxiety'],
    ['teks' => 'Ketika saya mengikuti tes, saya memikirkan konsekuensi jika saya gagal.', 'dimensi' => 'Test Anxiety'],

    // 7. Rehearsal
    ['teks' => 'Ketika saya belajar untuk kursus ini, saya sering membaca kembali catatan saya dan materi bacaan lainnya.', 'dimensi' => 'Rehearsal'],
    ['teks' => 'Saya menghafal daftar kata kunci untuk kursus ini agar bisa menjawab soal dengan benar.', 'dimensi' => 'Rehearsal'],

    // 8. Elaboration
    ['teks' => 'Ketika saya membaca materi untuk kursus ini, saya mencoba menghubungkan informasi tersebut dengan apa yang sudah saya ketahui.', 'dimensi' => 'Elaboration'],
    ['teks' => 'Saya mencoba menghubungkan ide-ide dalam kursus ini dengan hal-hal yang saya pelajari dalam kursus lain.', 'dimensi' => 'Elaboration'],

    // 9. Organization
    ['teks' => 'Saya membuat garis besar (outline) untuk membantu saya mengatur ide-ide saya saat belajar.', 'dimensi' => 'Organization'],
    ['teks' => 'Ketika saya belajar untuk kursus ini, saya membaca kembali materi dan membuat ringkasan sendiri.', 'dimensi' => 'Organization'],

    // 10. Critical Thinking
    ['teks' => 'Saya sering mendapati diri saya mempertanyakan hal-hal yang saya dengar atau baca dalam kursus ini untuk memutuskan apakah saya menganggapnya meyakinkan.', 'dimensi' => 'Critical Thinking'],
    ['teks' => 'Setiap kali saya membaca atau mendengar suatu kesimpulan dalam kursus ini, saya memikirkan kemungkinan alternatif.', 'dimensi' => 'Critical Thinking'],

    // 11. Metacognitive Self-Regulation
    ['teks' => 'Saya sering bertanya pada diri sendiri apakah saya telah memahami apa yang baru saja saya baca.', 'dimensi' => 'Metacognitive Self-Regulation'],
    ['teks' => 'Jika saya menjadi bingung saat membaca materi untuk kursus ini, saya akan kembali dan mencoba memahaminya.', 'dimensi' => 'Metacognitive Self-Regulation'],

    // 12. Time and Study Environment
    ['teks' => 'Saya memiliki tempat khusus untuk belajar yang tenang dan bebas gangguan.', 'dimensi' => 'Time and Study Environment'],
    ['teks' => 'Saya biasanya belajar di tempat yang bisa membantu saya berkonsentrasi.', 'dimensi' => 'Time and Study Environment'],

    // 13. Effort Regulation
    ['teks' => 'Bahkan ketika materi kursus membosankan atau tidak menarik, saya tetap bekerja sampai saya selesai.', 'dimensi' => 'Effort Regulation'],
    ['teks' => 'Meskipun tugas yang diberikan cukup sulit, saya tidak menyerah dan berusaha menyelesaikannya.', 'dimensi' => 'Effort Regulation'],

    // 14. Peer Learning
    ['teks' => 'Saat belajar untuk kursus ini, saya sering mencoba menjelaskan materi kepada teman sekelas.', 'dimensi' => 'Peer Learning'],
    ['teks' => 'Saya sering belajar bersama dengan teman mahasiswa lainnya agar bisa saling membantu.', 'dimensi' => 'Peer Learning'],

    // 15. Help Seeking
    ['teks' => 'Jika saya tidak mengerti materi dalam kursus ini, saya akan mencari bantuan dari mahasiswa lain.', 'dimensi' => 'Help Seeking'],
    ['teks' => 'Saya mencoba mengidentifikasi mahasiswa di kelas ini yang bisa saya mintai bantuan jika diperlukan.', 'dimensi' => 'Help Seeking']
];

$stmt = $db->prepare("INSERT INTO mslq_questions (teks_pertanyaan, dimensi) VALUES (?, ?)");
foreach ($questions as $q) {
    $stmt->execute([$q['teks'], $q['dimensi']]);
}

echo "Berhasil memasukkan 30 pertanyaan MSLQ (2 per dimensi).";
