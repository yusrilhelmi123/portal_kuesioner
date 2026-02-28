<?php
require_once 'auth_check.php';
require_once '../config.php';

// Get counts
$total_students = $pdo->query("SELECT COUNT(*) FROM students")->fetchColumn();
$pending_approvals = $pdo->query("SELECT COUNT(*) FROM students WHERE is_approved = 0")->fetchColumn();
$vark_completed = $pdo->query("SELECT COUNT(DISTINCT student_id) FROM responses WHERE tipe_pertanyaan = 'VARK'")->fetchColumn();

// Get settings
$settings = [];
foreach ($pdo->query("SELECT * FROM system_settings") as $row) {
    $settings[$row['setting_key']] = $row['setting_value'];
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin | Kuisioner PM</title>
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

        .sidebar a:hover,
        .sidebar a.active {
            background: #334155;
            color: white;
        }

        .main-content {
            flex: 1;
            padding: 2rem;
            background: #f8fafc;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: 1rem;
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
        }
    </style>
</head>

<body>
    <div class="admin-layout">
        <div class="sidebar">
            <h2 style="color: white; margin-bottom: 2rem; padding: 0 1rem;">Admin PM</h2>
            <a href="index.php" class="active">Dashboard</a>
            <a href="approvals.php">Persetujuan Siswa (
                <?= $pending_approvals ?>)
            </a>
            <a href="questions_vark.php">Manajemen VARK</a>
            <a href="questions_mslq.php">Manajemen MSLQ</a>
            <a href="questions_ams.php">Manajemen AMS</a>
            <a href="settings.php">Konfigurasi Sistem</a>
            <a href="export.php">Ekspor Data JSON</a>
            <hr style="margin: 1rem 0; border: none; border-top: 1px solid #334155;">
            <a href="logout.php" style="color: #ef4444;">Logout</a>
        </div>
        <div class="main-content">
            <h1>Selamat Datang,
                <?= $_SESSION['admin_username'] ?>
            </h1>
            <p style="color: #64748b; margin-bottom: 2rem;">Ikhtisar sistem kuesioner Anda hari ini.</p>

            <div class="stats-grid">
                <div class="stat-card">
                    <p style="font-size: 0.8rem; color: #64748b;">Total Mahasiswa</p>
                    <h2 style="margin: 0; color: var(--primary);">
                        <?= $total_students ?>
                    </h2>
                </div>
                <div class="stat-card">
                    <p style="font-size: 0.8rem; color: #64748b;">Menunggu Approval</p>
                    <h2 style="margin: 0; color: #ef4444;">
                        <?= $pending_approvals ?>
                    </h2>
                </div>
                <div class="stat-card">
                    <p style="font-size: 0.8rem; color: #64748b;">Selesai Kuesioner</p>
                    <h2 style="margin: 0; color: #22c55e;">
                        <?= $vark_completed ?>
                    </h2>
                </div>
            </div>

            <div class="card">
                <h3>Status Kuesioner Saat Ini</h3>
                <div style="display: flex; gap: 1rem;">
                    <div
                        style="padding: 1rem; border-radius: 0.5rem; background: <?= $settings['vark_open'] ? '#dcfce7' : '#fee2e2' ?>; color: <?= $settings['vark_open'] ? '#166534' : '#991b1b' ?>;">
                        VARK:
                        <?= $settings['vark_open'] ? 'Terbuka' : 'Tertutup' ?>
                    </div>
                    <div
                        style="padding: 1rem; border-radius: 0.5rem; background: <?= $settings['mslq_open'] ? '#dcfce7' : '#fee2e2' ?>; color: <?= $settings['mslq_open'] ? '#166534' : '#991b1b' ?>;">
                        MSLQ:
                        <?= $settings['mslq_open'] ? 'Terbuka' : 'Tertutup' ?>
                    </div>
                    <div
                        style="padding: 1rem; border-radius: 0.5rem; background: <?= $settings['ams_open'] ? '#dcfce7' : '#fee2e2' ?>; color: <?= $settings['ams_open'] ? '#166534' : '#991b1b' ?>;">
                        AMS:
                        <?= $settings['ams_open'] ? 'Terbuka' : 'Tertutup' ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>