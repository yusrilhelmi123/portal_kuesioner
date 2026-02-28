<?php
require_once 'auth_check.php';
require_once '../config.php';

if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = $_GET['id'];
    if ($_GET['action'] == 'approve') {
        $pdo->prepare("UPDATE students SET is_approved = 1 WHERE id = ?")->execute([$id]);
    } elseif ($_GET['action'] == 'reject') {
        $pdo->prepare("DELETE FROM students WHERE id = ?")->execute([$id]);
    }
    header('Location: approvals.php');
    exit;
}

$students = $pdo->query("SELECT * FROM students WHERE is_approved = 0 ORDER BY created_at DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Persetujuan Siswa | Admin</title>
    <link rel="stylesheet" href="../style.css">
    <style>
        .admin-layout {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 250px;
            background: #1e293b;
            color: white;
            padding: 2rem 1rem;
        }

        .sidebar a {
            color: #cbd5e1;
            text-decoration: none;
            display: block;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            margin-bottom: 0.5rem;
        }

        .sidebar a:hover {
            background: #334155;
            color: white;
        }

        .main-content {
            flex: 1;
            padding: 2rem;
            background: #f8fafc;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 0.5rem;
            overflow: hidden;
            margin-top: 1rem;
        }

        th,
        td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }

        th {
            background: #f1f5f9;
        }
    </style>
</head>

<body>
    <div class="admin-layout">
        <div class="sidebar">
            <h2>Admin PM</h2>
            <a href="index.php">Dashboard</a>
            <a href="approvals.php" style="background: #334155; color: white;">Persetujuan Siswa</a>
            <a href="questions_vark.php">Manajemen VARK</a>
            <a href="questions_mslq.php">Manajemen MSLQ</a>
            <a href="questions_ams.php">Manajemen AMS</a>
            <a href="settings.php">Konfigurasi Sistem</a>
            <a href="export.php">Ekspor Data JSON</a>
            <hr style="margin: 1rem 0; border: none; border-top: 1px solid #334155;">
            <a href="logout.php" style="color: #ef4444;">Logout</a>
        </div>
        <div class="main-content">
            <h1>Persetujuan Pendaftaran</h1>
            <p>Daftar mahasiswa yang baru mendaftar dan menunggu persetujuan Anda.</p>

            <table>
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>NPM</th>
                        <th>Tanggal Daftar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($students)): ?>
                        <tr>
                            <td colspan="4" style="text-align: center;">Tidak ada pendaftaran pending.</td>
                        </tr>
                    <?php endif; ?>
                    <?php foreach ($students as $s): ?>
                        <tr>
                            <td>
                                <?= htmlspecialchars($s['nama']) ?>
                            </td>
                            <td>
                                <?= htmlspecialchars($s['npm']) ?>
                            </td>
                            <td>
                                <?= $s['created_at'] ?>
                            </td>
                            <td>
                                <a href="?action=approve&id=<?= $s['id'] ?>" class="btn btn-primary"
                                    style="padding: 0.4rem 1rem; font-size: 0.8rem; background: #22c55e;">Approve</a>
                                <a href="?action=reject&id=<?= $s['id'] ?>" class="btn"
                                    style="padding: 0.4rem 1rem; font-size: 0.8rem; background: #ef4444; color: white;"
                                    onclick="return confirm('Hapus pendaftaran ini?')">Reject</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>