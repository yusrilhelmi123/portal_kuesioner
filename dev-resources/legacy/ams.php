require_once 'header.php';
require_once 'config.php';

// Check if AMS is open
$ams_status = $pdo->query("SELECT setting_value FROM system_settings WHERE setting_key = 'ams_open'")->fetchColumn();
if (!$ams_status) {
die("Kuisioner AMS saat ini sedang ditutup oleh Admin. <a href='index.php'>Kembali</a>");
}

// Fetch AMS Questions
$stmt = $pdo->query("SELECT * FROM ams_questions");
$questions = $stmt->fetchAll();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
$answers = $_POST['answers'] ?? [];

foreach ($answers as $q_id => $val) {
$stmt = $pdo->prepare("INSERT INTO responses (student_id, tipe_pertanyaan, question_id, nilai_jawaban) VALUES (?, 'AMS',
?, ?)");
$stmt->execute([$_SESSION['student_id'], $q_id, $val]);
}

// Redirect to Results
header('Location: results.php');
exit;
}
?>

<div class="card">
    <div class="progress-bar">
        <div class="progress-fill" style="width: 100%;"></div>
    </div>
    <h2>Bagian 3: AMS (Academic Motivation Scale)</h2>
    <p style="margin-bottom: 2rem; color: #64748b;">Pikirkan tentang alasan Anda kuliah. Sejauh mana pernyataan berikut
        sesuai dengan alasan Anda? <br><strong>1 (Tidak Sesuai Sama Sekali) sampai 7 (Sangat Sesuai).</strong></p>

    <form method="POST">
        <?php foreach ($questions as $index => $q): ?>
            <div class="question-item">
                <p><strong>
                        <?= ($index + 1) ?>.
                        <?= htmlspecialchars($q['teks_pertanyaan']) ?>
                    </strong></p>
                <div
                    style="display: flex; justify-content: space-between; align-items: center; margin-top: 1rem; gap: 0.5rem; flex-wrap: wrap;">
                    <span style="font-size: 0.8rem; color: #64748b;">Tidak Sesuai</span>
                    <?php for ($i = 1; $i <= 7; $i++): ?>
                        <label
                            style="display: flex; flex-direction: column; align-items: center; cursor: pointer; gap: 0.25rem;">
                            <input type="radio" name="answers[<?= $q['id'] ?>]" value="<?= $i ?>" required>
                            <span style="font-size: 0.85rem; font-weight: 500;">
                                <?= $i ?>
                            </span>
                        </label>
                    <?php endfor; ?>
                    <span style="font-size: 0.8rem; color: #64748b;">Sangat Sesuai</span>
                </div>
            </div>
        <?php endforeach; ?>

        <div style="display: flex; justify-content: flex-end; margin-top: 2rem;">
            <button type="submit" class="btn btn-primary" style="background: var(--secondary);">Hitung Hasil
                &rarr;</button>
        </div>
    </form>
</div>

<?php include 'footer.php'; ?>