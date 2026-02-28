<?php
require_once 'header.php';
require_once 'config.php';

// Check if VARK is open
$vark_status = $pdo->query("SELECT setting_value FROM system_settings WHERE setting_key = 'vark_open'")->fetchColumn();
if (!$vark_status) {
    die("<div class='container'><div class='card'><h2>Mohon Maaf</h2><p>Kuisioner VARK saat ini sedang ditutup oleh Admin.</p><br><a href='index.php' class='btn btn-primary'>Kembali</a></div></div>");
}

// Fetch VARK Questions
$stmt = $pdo->query("SELECT * FROM vark_questions");
$questions = $stmt->fetchAll();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $answers = $_POST['answers'] ?? [];

    foreach ($answers as $q_id => $val) {
        $stmt = $pdo->prepare("INSERT INTO responses (student_id, tipe_pertanyaan, question_id, nilai_jawaban) VALUES (?, 'VARK', ?, ?)");
        $stmt->execute([$_SESSION['student_id'], $q_id, $val]);
    }

    // Redirect to MSLQ
    header('Location: mslq.php');
    exit;
}
?>

<div class="card">
    <div class="progress-bar">
        <div class="progress-fill" style="width: 33%;"></div>
    </div>
    <h2>Bagian 1: VARK Questionnaire</h2>
    <p style="margin-bottom: 2rem; color: #64748b;">Kuesioner ini membantu menentukan gaya belajar Anda (Visual,
        Auditory, Read/Write, atau Kinesthetic). Silakan pilih satu jawaban yang paling sesuai untuk setiap situasi.</p>

    <form method="POST">
        <?php foreach ($questions as $index => $q): ?>
            <div class="question-item">
                <p><strong>
                        <?= ($index + 1) ?>.
                        <?= htmlspecialchars($q['teks_pertanyaan']) ?>
                    </strong></p>
                <div class="options-grid">
                    <label class="option-card">
                        <input type="radio" name="answers[<?= $q['id'] ?>]" value="V" required>
                        <span>
                            <?= htmlspecialchars($q['opt_v']) ?>
                        </span>
                    </label>
                    <label class="option-card">
                        <input type="radio" name="answers[<?= $q['id'] ?>]" value="A" required>
                        <span>
                            <?= htmlspecialchars($q['opt_a']) ?>
                        </span>
                    </label>
                    <label class="option-card">
                        <input type="radio" name="answers[<?= $q['id'] ?>]" value="R" required>
                        <span>
                            <?= htmlspecialchars($q['opt_r']) ?>
                        </span>
                    </label>
                    <label class="option-card">
                        <input type="radio" name="answers[<?= $q['id'] ?>]" value="K" required>
                        <span>
                            <?= htmlspecialchars($q['opt_k']) ?>
                        </span>
                    </label>
                </div>
            </div>
        <?php endforeach; ?>

        <div style="display: flex; justify-content: flex-end; margin-top: 2rem;">
            <button type="submit" class="btn btn-primary">Lanjut ke MSLQ &rarr;</button>
        </div>
    </form>
</div>

<?php include 'footer.php'; ?>