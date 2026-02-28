<?php
session_start();
require_once '../config.php';

// Automasi pembuatan akun admin jika belum ada
$checkAdmin = $pdo->query("SELECT COUNT(*) FROM admins")->fetchColumn();
if ($checkAdmin == 0) {
    $hashed = password_hash('120355', PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO admins (username, password) VALUES ('admin', ?)");
    $stmt->execute([$hashed]);
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM admins WHERE username = ?");
    $stmt->execute([$username]);
    $admin = $stmt->fetch();

    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_username'] = $admin['username'];
        header('Location: index.php');
        exit;
    } else {
        $error = "Username atau Password Admin salah.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Admin Login | Kuisioner PM</title>
    <link rel="stylesheet" href="../style.css">
</head>

<body style="display: flex; align-items: center; justify-content: center; min-height: 100vh;">
    <div class="card" style="width: 100%; max-width: 400px;">
        <h2 style="text-align: center;">Admin Control Panel</h2>
        <?php if ($error): ?>
            <div
                style="background: #fee2e2; color: #ef4444; padding: 0.75rem; border-radius: 0.5rem; margin-bottom: 1rem; font-size: 0.9rem;">
                <?= $error ?>
            </div>
        <?php endif; ?>
        <form method="POST">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary" style="width: 100%;">Login Admin</button>
        </form>
    </div>
</body>

</html>