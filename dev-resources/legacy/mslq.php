require_once 'header.php';
require_once 'config.php';

// Check if MSLQ is open
$mslq_status = $pdo->query("SELECT setting_value FROM system_settings WHERE setting_key = 'mslq_open'")->fetchColumn();
if (!$mslq_status) {
die("Kuisioner MSLQ saat ini sedang ditutup oleh Admin. <a href='index.php'>Kembali</a>");
}

// Fetch MSLQ Questions
$stmt = $pdo->query("SELECT * FROM mslq_questions");
$questions = $stmt->fetchAll();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
$answers = $_POST['answers'] ?? [];

foreach ($answers as $q_id => $val) {
$stmt = $pdo->prepare("INSERT INTO responses (student_id, tipe_pertanyaan, question_id, nilai_jawaban) VALUES (?,
'MSLQ', ?, ?)");
$stmt->execute([$_SESSION['student_id'], $q_id, $val]);
}

// Redirect to AMS
header('Location: ams.php');
exit;
}
?>

<div class="card">
    <div class="progress-bar">
        <div class="progress-fill" style="width: 66%;"></div>
    </div>
    <h2>Bagian 2: MSLQ (Motivated Strategies for Learning Questionnaire)</h2>
    <p style="margin-bottom: 2rem; color: #64748b;">Berikan penilaian terhadap pernyataan berikut berdasarkan kebiasaan
        belajar Anda. <br><strong>1 (Sangat Tidak Setuju) sampai 7 (Sangat Setuju).</strong></p>

    <form method="POST">
        <?php foreach ($questions as $index => $q): ?>
            <div class="question-item">
                <p><strong>
                        <?= ($index + 1) ?>.
                        <?= htmlspecialchars($q['teks_pertanyaan']) ?>
                    </strong></p>
                <div
                    style="display: flex; justify-content: space-between; align-items: center; margin-top: 1rem; gap: 0.5rem; flex-wrap: wrap;">
                    <span style="font-size: 0.8rem; color: #64748b;">Sangat Tidak Setuju</span>
                    <?php for ($i = 1; $i <= 7; $i++): ?>
                        <label
                            style="display: flex; flex-direction: column; align-items: center; cursor: pointer; gap: 0.25rem;">
                            <input type="radio" name="answers[<?= $q['id'] ?>]" value="<?= $i ?>" required>
                            <span style="font-size: 0.85rem; font-weight: 500;">
                                <?= $i ?>
                            </span>
                        </label>
                    <?php endfor; ?>
                    <span style="font-size: 0.8rem; color: #64748b;">Sangat Setuju</span>
                </div>
            </div>
        <?php endforeach; ?>

        <div style="display: flex; justify-content: flex-end; margin-top: 2rem;">
            <button type="submit" class="btn btn-primary">Lanjut ke AMS &rarr;</button>
        </div>
    </form>
</div>

<?php include 'footer.php'; ?>