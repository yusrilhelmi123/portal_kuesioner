<?php
session_start();
require_once 'config.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'] ?? '';
    $npm = $_POST['npm'] ?? '';
    $nama = $_POST['nama'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($action == 'register') {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        try {
            $stmt = $pdo->prepare("INSERT INTO students (npm, nama, password) VALUES (?, ?, ?)");
            $stmt->execute([$npm, $nama, $hashed_password]);
            $_SESSION['student_id'] = $pdo->lastInsertId();
            $_SESSION['npm'] = $npm;
            $_SESSION['nama'] = $nama;
            header('Location: vark.php');
            exit;
        } catch (PDOException $e) {
            $error = "Registrasi gagal atau NPM sudah terdaftar.";
        }
    } elseif ($action == 'login') {
        $stmt = $pdo->prepare("SELECT * FROM students WHERE npm = ?");
        $stmt->execute([$npm]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            if ($user['is_approved'] == 0) {
                $error = "Akun Anda sedang menunggu persetujuan Admin. Silakan hubungi Dosen/Admin.";
            } else {
                $_SESSION['student_id'] = $user['id'];
                $_SESSION['npm'] = $user['npm'];
                $_SESSION['nama'] = $user['nama'];

                if (!$user['vark_type']) {
                    header('Location: vark.php');
                } elseif (!$user['mslq_score']) {
                    header('Location: mslq.php');
                } elseif (!$user['ams_type']) {
                    header('Location: ams.php');
                } else {
                    header('Location: results.php');
                }
                exit;
            }
        } else {
            $error = "NPM atau Password salah.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kuisioner PM | Selamat Datang</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="navbar">
        <div class="logo">POINTMARKET</div>
    </div>

    <div class="container" style="max-width: 500px;">
        <div class="card">
            <h1>Platform Kuisioner</h1>
            <p style="margin-bottom: 2rem; color: #64748b;">Silakan login atau daftar untuk memulai penilaian VARK,
                MSLQ, dan AMS Anda.</p>

            <?php if ($error): ?>
                <div
                    style="background: #fee2e2; color: #ef4444; padding: 1rem; border-radius: 0.75rem; margin-bottom: 1.5rem; font-size: 0.9rem;">
                    <?= $error ?>
                </div>
            <?php endif; ?>

            <div id="login-form">
                <form method="POST">
                    <input type="hidden" name="action" value="login">
                    <div class="form-group">
                        <label>NPM</label>
                        <input type="text" name="npm" class="form-control" required placeholder="Contoh: 2024001">
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required
                            placeholder="Masukkan password">
                    </div>
                    <button type="submit" class="btn btn-primary" style="width: 100%;">Masuk</button>
                    <p style="margin-top: 1.5rem; text-align: center; font-size: 0.9rem;">
                        Belum punya akun? <a href="#" onclick="toggleForm('register')"
                            style="color: var(--primary); font-weight: 600; text-decoration: none;">Daftar Sekarang</a>
                    </p>
                </form>
            </div>

            <div id="register-form" style="display: none;">
                <form method="POST">
                    <input type="hidden" name="action" value="register">
                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control" required placeholder="Nama lengkap Anda">
                    </div>
                    <div class="form-group">
                        <label>NPM</label>
                        <input type="text" name="npm" class="form-control" required placeholder="Contoh: 2024001">
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required
                            placeholder="Buat password">
                    </div>
                    <button type="submit" class="btn btn-primary" style="width: 100%;">Daftar</button>
                    <p style="margin-top: 1.5rem; text-align: center; font-size: 0.9rem;">
                        Sudah punya akun? <a href="#" onclick="toggleForm('login')"
                            style="color: var(--primary); font-weight: 600; text-decoration: none;">Login Disini</a>
                    </p>
                </form>
            </div>
        </div>
    </div>

    <footer>
        &copy; 2026 PM Lab Riset. Powered by Advanced AI Research.
    </footer>

    <script>
        function toggleForm(type) {
            const loginForm = document.getElementById('login-form');
            const registerForm = document.getElementById('register-form');
            if (type === 'register') {
                loginForm.style.display = 'none';
                registerForm.style.display = 'block';
            } else {
                loginForm.style.display = 'block';
                registerForm.style.display = 'none';
            }
        }
    </script>
</body>

</html>