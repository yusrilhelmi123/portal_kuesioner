<?php
require_once 'auth_check.php';
require_once '../config.php';

// Handle Delete
if (isset($_GET['delete'])) {
    $pdo->prepare("DELETE FROM vark_questions WHERE id = ?")->execute([$_GET['delete']]);
    header('Location: questions_vark.php');
    exit;
}

// Handle Add/Edit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'] ?? '';
    $teks = $_POST['teks_pertanyaan'] ?? '';
    $v = $_POST['opt_v'] ?? '';
    $a = $_POST['opt_a'] ?? '';
    $r = $_POST['opt_r'] ?? '';
    $k = $_POST['opt_k'] ?? '';

    if ($id) {
        $stmt = $pdo->prepare("UPDATE vark_questions SET teks_pertanyaan=?, opt_v=?, opt_a=?, opt_r=?, opt_k=? WHERE id=?");
        $stmt->execute([$teks, $v, $a, $r, $k, $id]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO vark_questions (teks_pertanyaan, opt_v, opt_a, opt_r, opt_k) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$teks, $v, $a, $r, $k]);
    }
    header('Location: questions_vark.php');
    exit;
}

$questions = $pdo->query("SELECT * FROM vark_questions")->fetchAll();
$edit_q = null;
if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare("SELECT * FROM vark_questions WHERE id = ?");
    $stmt->execute([$_GET['edit']]);
    $edit_q = $stmt->fetch();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manajemen VARK | Admin</title>
    <link rel="stylesheet" href="../style.css">
    <style>
        .admin-layout { display: flex; min-height: 100vh; }
        .sidebar { width: 250px; background: #1e293b; color: white; padding: 2rem 1rem; }
        .sidebar a { color: #cbd5e1; text-decoration: none; display: block; padding: 0.75rem 1rem; border-radius: 0.5rem; margin-bottom: 0.5rem; }
        .sidebar a:hover { background: #334155; color: white; }
        .main-content { flex: 1; padding: 2rem; background: #f8fafc; }
        table { width: 100%; border-collapse: collapse; background: white; margin-top: 1.5rem; }
        th, td { padding: 0.75rem; border-bottom: 1px solid #e2e8f0; font-size: 0.9rem; }
        form input, form textarea { margin-bottom: 1rem; }
    </style>
</head>
<body>
    <div class="admin-layout">
        <div class="sidebar">
            <h2>Admin PM</h2>
            <a href="index.php">Dashboard</a>
            <a href="approvals.php">Persetujuan Siswa</a>
            <a href="questions_vark.php" style="background: #334155; color: white;">Manajemen VARK</a>
            <a href="questions_mslq.php">Manajemen MSLQ</a>
            <a href="questions_ams.php">Manajemen AMS</a>
            <a href="settings.php">Konfigurasi Sistem</a>
            <a href="export.php">Ekspor Data JSON</a>
            <hr style="margin: 1rem 0; border: none; border-top: 1px solid #334155;">
            <a href="logout.php" style="color: #ef4444;">Logout</a>
        </div>
        <div class="main-content">
            <h1>Manajemen Soal VARK</h1>
            
            <div class="card" style="margin-top: 1.5rem;">
                <h3><?= $edit_q ? 'Edit Pertanyaan' : 'Tambah Pertanyaan Baru' ?></h3>
                <form method="POST">
                    <input type="hidden" name="id" value="<?= $edit_q['id'] ?? '' ?>">
                    <div class="form-group">
                        <label>Teks Pertanyaan</label>
                        <textarea name="teks_pertanyaan" class="form-control" required rows="2"><?= $edit_q['teks_pertanyaan'] ?? '' ?></textarea>
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <div class="form-group"><label>Opsi Visual (V)</label><input type="text" name="opt_v" class="form-control" value="<?= $edit_q['opt_v'] ?? '' ?>" required></div>
                        <div class="form-group"><label>Opsi Auditory (A)</label><input type="text" name="opt_a" class="form-control" value="<?= $edit_q['opt_a'] ?? '' ?>" required></div>
                        <div class="form-group"><label>Opsi Read/Write (R)</label><input type="text" name="opt_r" class="form-control" value="<?= $edit_q['opt_r'] ?? '' ?>" required></div>
                        <div class="form-group"><label>Opsi Kinesthetic (K)</label><input type="text" name="opt_k" class="form-control" value="<?= $edit_q['opt_k'] ?? '' ?>" required></div>
                    </div>
                    <button type="submit" class="btn btn-primary"><?= $edit_q ? 'Simpan Perubahan' : 'Tambah Pertanyaan' ?></button>
                    <?php if($edit_q): ?> <a href="questions_vark.php" class="btn" style="background: #ccc;">Batal</a> <?php endif; ?>
                </form>
            </div>

            <table>
                <thead>
                    <tr>
                        <th width="50%">Pertanyaan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($questions as $q): ?>
                        <tr>
                            <td><?= htmlspecialchars($q['teks_pertanyaan']) ?></td>
                            <td>
                                <a href="?edit=<?= $q['id'] ?>" style="color: var(--primary); font-size: 0.8rem; margin-right: 10px;">Edit</a>
                                <a href="?delete=<?= $q['id'] ?>" style="color: #ef4444; font-size: 0.8rem;" onclick="return confirm('Hapus soal ini?')">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
