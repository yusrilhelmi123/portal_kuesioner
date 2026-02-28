<?php
require_once 'auth_check.php';
require_once '../config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_settings'])) {
    foreach (['vark_open', 'mslq_open', 'ams_open'] as $key) {
        $val = isset($_POST[$key]) ? 1 : 0;
        $stmt = $pdo->prepare("UPDATE system_settings SET setting_value = ? WHERE setting_key = ?");
        $stmt->execute([$val, $key]);
    }
    header('Location: settings.php?success=1');
    exit;
}

$settings = [];
foreach ($pdo->query("SELECT * FROM system_settings") as $row) {
    $settings[$row['setting_key']] = $row['setting_value'];
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Konfigurasi Sistem | Admin</title>
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

        .toggle-item {
            background: white;
            padding: 1.5rem;
            border-radius: 1rem;
            margin-bottom: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 1px solid #e2e8f0;
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
            <a href="settings.php" style="background: #334155; color: white;">Konfigurasi Sistem</a>
            <a href="export.php">Ekspor Data JSON</a>
            <hr style="margin: 1rem 0; border: none; border-top: 1px solid #334155;">
            <a href="logout.php" style="color: #ef4444;">Logout</a>
        </div>
        <div class="main-content">
            <h1>Konfigurasi Pintu Kuisioner</h1>
            <p>Buka atau tutup akses kuesioner secara terpisah untuk mahasiswa.</p>

            <?php if (isset($_GET['success'])): ?>
                <div
                    style="background: #dcfce7; color: #166534; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
                    Pengaturan berhasil disimpan!
                </div>
            <?php endif; ?>

            <form method="POST">
                <input type="hidden" name="update_settings" value="1">

                <div class="toggle-item">
                    <div>
                        <h3 style="margin: 0;">Kontrol VARK</h3>
                        <p style="font-size: 0.8rem; color: #64748b; margin: 0;">Izinkan mahasiswa mengisi kuesioner
                            VARK</p>
                    </div>
                    <div>
                        <input type="checkbox" name="vark_open" <?= $settings['vark_open'] ? 'checked' : '' ?>
                        style="width: 25px; height: 25px; cursor: pointer;">
                    </div>
                </div>

                <div class="toggle-item">
                    <div>
                        <h3 style="margin: 0;">Kontrol MSLQ</h3>
                        <p style="font-size: 0.8rem; color: #64748b; margin: 0;">Izinkan mahasiswa mengisi kuesioner
                            MSLQ</p>
                    </div>
                    <div>
                        <input type="checkbox" name="mslq_open" <?= $settings['mslq_open'] ? 'checked' : '' ?>
                        style="width: 25px; height: 25px; cursor: pointer;">
                    </div>
                </div>

                <div class="toggle-item">
                    <div>
                        <h3 style="margin: 0;">Kontrol AMS</h3>
                        <p style="font-size: 0.8rem; color: #64748b; margin: 0;">Izinkan mahasiswa mengisi kuesioner AMS
                        </p>
                    </div>
                    <div>
                        <input type="checkbox" name="ams_open" <?= $settings['ams_open'] ? 'checked' : '' ?>
                        style="width: 25px; height: 25px; cursor: pointer;">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary" style="margin-top: 1rem; width: 200px;">Simpan
                    Perubahan</button>
            </form>
        </div>
    </div>
</body>

</html>