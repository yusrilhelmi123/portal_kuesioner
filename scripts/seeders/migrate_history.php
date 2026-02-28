<?php
require_once 'app/Core/Database.php';
$db = App\Core\Database::getInstance();

// Buat tabel quiz_history untuk menyimpan riwayat hasil
try {
    $db->exec("CREATE TABLE IF NOT EXISTS quiz_history (
        id INT AUTO_INCREMENT PRIMARY KEY,
        student_id INT NOT NULL,
        quiz_type ENUM('VARK','MSLQ','AMS') NOT NULL,
        result_label VARCHAR(100) NOT NULL COMMENT 'Tipe VARK, Skor MSLQ, atau Kategori AMS',
        result_value FLOAT DEFAULT NULL COMMENT 'Nilai numerik jika ada (skor MSLQ)',
        submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        INDEX idx_student_type (student_id, quiz_type),
        INDEX idx_submitted (submitted_at)
    )");
    echo "Tabel quiz_history berhasil dibuat.\n";

    // Seed data dari hasil yang sudah ada
    $students = $db->query("SELECT id, npm, vark_type, vark_updated_at, mslq_score, mslq_updated_at, ams_type, ams_updated_at FROM students WHERE is_approved=1")->fetchAll();
    foreach ($students as $s) {
        if ($s['vark_type'] && $s['vark_updated_at']) {
            $chk = $db->prepare("SELECT COUNT(*) FROM quiz_history WHERE student_id=? AND quiz_type='VARK' AND DATE(submitted_at)=DATE(?)");
            $chk->execute([$s['id'], $s['vark_updated_at']]);
            if ($chk->fetchColumn() == 0) {
                $db->prepare("INSERT INTO quiz_history (student_id, quiz_type, result_label, result_value, submitted_at) VALUES (?,?,?,NULL,?)")
                    ->execute([$s['id'], 'VARK', $s['vark_type'], $s['vark_updated_at']]);
            }
        }
        if ($s['mslq_score'] && $s['mslq_updated_at']) {
            $chk = $db->prepare("SELECT COUNT(*) FROM quiz_history WHERE student_id=? AND quiz_type='MSLQ' AND DATE(submitted_at)=DATE(?)");
            $chk->execute([$s['id'], $s['mslq_updated_at']]);
            if ($chk->fetchColumn() == 0) {
                $db->prepare("INSERT INTO quiz_history (student_id, quiz_type, result_label, result_value, submitted_at) VALUES (?,?,?,?,?)")
                    ->execute([$s['id'], 'MSLQ', $s['mslq_score'], $s['mslq_score'], $s['mslq_updated_at']]);
            }
        }
        if ($s['ams_type'] && $s['ams_updated_at']) {
            $chk = $db->prepare("SELECT COUNT(*) FROM quiz_history WHERE student_id=? AND quiz_type='AMS' AND DATE(submitted_at)=DATE(?)");
            $chk->execute([$s['id'], $s['ams_updated_at']]);
            if ($chk->fetchColumn() == 0) {
                $db->prepare("INSERT INTO quiz_history (student_id, quiz_type, result_label, result_value, submitted_at) VALUES (?,?,?,NULL,?)")
                    ->execute([$s['id'], 'AMS', $s['ams_type'], $s['ams_updated_at']]);
            }
        }
    }
    echo "Seed data quiz_history selesai.\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
