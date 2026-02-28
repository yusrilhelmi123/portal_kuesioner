<?php
require_once 'header.php';
require_once 'config.php';

$student_id = $_SESSION['student_id'];

// 1. Calculate VARK
$stmt = $pdo->prepare("SELECT nilai_jawaban, COUNT(*) as count FROM responses WHERE student_id = ? AND tipe_pertanyaan = 'VARK' GROUP BY nilai_jawaban ORDER BY count DESC LIMIT 1");
$stmt->execute([$student_id]);
$vark_res = $stmt->fetch();
$vark_type = $vark_res['nilai_jawaban'] ?? 'Unknown';

// 2. Calculate MSLQ (Average)
$stmt = $pdo->prepare("SELECT AVG(CAST(nilai_jawaban AS FLOAT)) as avg_score FROM responses WHERE student_id = ? AND tipe_pertanyaan = 'MSLQ'");
$stmt->execute([$student_id]);
$mslq_res = $stmt->fetch();
$mslq_score = round($mslq_res['avg_score'] ?? 0, 2);

// 3. Calculate AMS (Categorical Dominance)
$stmt = $pdo->prepare("
    SELECT q.kategori, AVG(CAST(r.nilai_jawaban AS FLOAT)) as avg_cat 
    FROM responses r 
    JOIN ams_questions q ON r.question_id = q.id 
    WHERE r.student_id = ? AND r.tipe_pertanyaan = 'AMS' 
    GROUP BY q.kategori 
    ORDER BY avg_cat DESC LIMIT 1
");
$stmt->execute([$student_id]);
$ams_res = $stmt->fetch();
$ams_type = $ams_res['kategori'] ?? 'Unknown';

// Update Student Profile
$stmt = $pdo->prepare("UPDATE students SET vark_type = ?, mslq_score = ?, ams_type = ? WHERE id = ?");
$stmt->execute([$vark_type, $mslq_score, $ams_type, $student_id]);

// Prepare JSON for export
$export_data = [
    "npm" => $_SESSION['npm'],
    "vark_type" => $vark_type,
    "mslq_score" => $mslq_score,
    "ams_type" => $ams_type
];
$json_data = json_encode($export_data, JSON_PRETTY_PRINT);
?>

<div class="card">
    <div style="text-align: center; margin-bottom: 2rem;">
        <div
            style="width: 80px; height: 80px; background: #22c55e; color: white; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-size: 2rem; margin-bottom: 1rem;">
            &check;
        </div>
        <h2>Penilaian Selesai!</h2>
        <p style="color: #64748b;">Terima kasih <?= htmlspecialchars($_SESSION['nama']) ?>, profil Anda telah berhasil
            dianalisis.</p>
    </div>

    <div class="results-grid"
        style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; margin-bottom: 3rem;">
        <div class="result-card"
            style="background: white; padding: 1.5rem; border-radius: 1rem; border: 1px solid #e2e8f0; text-align: center;">
            <p style="font-size: 0.8rem; text-transform: uppercase; color: #64748b; margin-bottom: 0.5rem;">Tipe VARK
            </p>
            <h3 style="font-size: 2.5rem; color: var(--primary); margin: 0;"><?= $vark_type ?></h3>
            <p style="font-size: 0.85rem; margin-top: 0.5rem; color: #1e293b;">
                <?php
                if ($vark_type == 'V')
                    echo 'Visual';
                elseif ($vark_type == 'A')
                    echo 'Auditory';
                elseif ($vark_type == 'R')
                    echo 'Read/Write';
                elseif ($vark_type == 'K')
                    echo 'Kinesthetic';
                ?>
            </p>
        </div>
        <div class="result-card"
            style="background: white; padding: 1.5rem; border-radius: 1rem; border: 1px solid #e2e8f0; text-align: center;">
            <p style="font-size: 0.8rem; text-transform: uppercase; color: #64748b; margin-bottom: 0.5rem;">Skor MSLQ
            </p>
            <h3 style="font-size: 2.5rem; color: var(--secondary); margin: 0;"><?= $mslq_score ?></h3>
            <p style="font-size: 0.85rem; margin-top: 0.5rem; color: #1e293b;">Skala 1.0 - 7.0</p>
        </div>
        <div class="result-card"
            style="background: white; padding: 1.5rem; border-radius: 1rem; border: 1px solid #e2e8f0; text-align: center;">
            <p style="font-size: 0.8rem; text-transform: uppercase; color: #64748b; margin-bottom: 0.5rem;">Tipe AMS</p>
            <h3 style="font-size: 1.5rem; color: var(--accent); margin: 0; text-transform: capitalize;"><?= $ams_type ?>
            </h3>
            <p style="font-size: 0.85rem; margin-top: 0.5rem; color: #1e293b;">Motivasi Dominan</p>
        </div>
    </div>

    <div style="background: #f1f5f9; padding: 1.5rem; border-radius: 1rem; margin-bottom: 2rem;">
        <h4 style="margin-bottom: 1rem; font-size: 0.9rem; color: #475569;">Data JSON untuk POINTMARKET:</h4>
        <pre
            style="background: #1e293b; color: #cbd5e1; padding: 1rem; border-radius: 0.5rem; font-size: 0.85rem; overflow-x: auto;"><?= htmlspecialchars($json_data) ?></pre>
    </div>

    <div style="display: flex; gap: 1rem; justify-content: center;">
        <button onclick="downloadJSON()" class="btn btn-primary">Unduh JSON</button>
        <a href="index.php" class="btn" style="background: #e2e8f0; color: #475569;">Keluar</a>
    </div>
</div>

<script>
    function downloadJSON() {
        const data = <?= json_encode($json_data) ?>;
        const blob = new Blob([data], { type: 'application/json' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'kuisioner_<?= $_SESSION['npm'] ?>.json';
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        URL.revokeObjectURL(url);
    }
</script>

<?php include 'footer.php'; ?>