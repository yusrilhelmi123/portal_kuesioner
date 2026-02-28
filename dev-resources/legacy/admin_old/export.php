<?php
require_once 'auth_check.php';
require_once '../config.php';

// Handle Full JSON Export (Bulk)
if (isset($_GET['type']) && $_GET['type'] == 'bulk') {
    $students = $pdo->query("SELECT npm, vark_type, mslq_score, ams_type FROM students WHERE vark_type IS NOT NULL AND is_approved = 1")->fetchAll();

    header('Content-Type: application/json');
    header('Content-Disposition: attachment; filename="pointmarket_bulk_export.json"');
    echo json_encode($students, JSON_PRETTY_PRINT);
    exit;
}

$students = $pdo->query("SELECT * FROM students WHERE is_approved = 1 AND vark_type IS NOT NULL ORDER BY npm ASC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Ekspor Data | Admin</title>
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
            <a href="approvals.php">Persetujuan Siswa</a>
            <a href="questions_vark.php">Manajemen VARK</a>
            <a href="questions_mslq.php">Manajemen MSLQ</a>
            <a href="questions_ams.php">Manajemen AMS</a>
            <a href="settings.php">Konfigurasi Sistem</a>
            <a href="export.php" style="background: #334155; color: white;">Ekspor Data JSON</a>
            <hr style="margin: 1rem 0; border: none; border-top: 1px solid #334155;">
            <a href="logout.php" style="color: #ef4444;">Logout</a>
        </div>
        <div class="main-content">
            <h1>Ekspor Hasil Kuisioner</h1>
            <p>Data berikut siap untuk diimpor ke sistem POINTMARKET.</p>

            <div style="margin: 1.5rem 0;">
                <a href="?type=bulk" class="btn btn-primary" style="background: var(--accent);">Download Bulk JSON
                    (Semua Siswa)</a>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>NPM</th>
                        <th>Nama</th>
                        <th>VARK</th>
                        <th>MSLQ</th>
                        <th>AMS</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($students as $s): ?>
                        <tr>
                            <td>
                                <?= htmlspecialchars($s['npm']) ?>
                            </td>
                            <td>
                                <?= htmlspecialchars($s['nama']) ?>
                            </td>
                            <td><span style="font-weight: bold; color: var(--primary);">
                                    <?= $s['vark_type'] ?>
                                </span></td>
                            <td>
                                <?= $s['mslq_score'] ?>
                            </td>
                            <td><span style="text-transform: capitalize; color: var(--secondary);">
                                    <?= $s['ams_type'] ?>
                                </span></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>