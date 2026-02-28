<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>POINTMARKET - Motivational Engine Admin</title>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-dark navbar-primary border-bottom-0">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a></li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><span class="nav-link">Administrator Access</span></li>
            </ul>
        </nav>

        <!-- Sidebar -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="/admin" class="brand-link bg-primary text-center">
                <span class="brand-text font-weight-bold ml-1">POINTMARKET</span>
            </a>
            <div class="sidebar">
                <nav class="mt-3">
                    <ul class="nav nav-pills nav-sidebar flex-column" role="menu">
                        <li class="nav-item"><a href="/admin" class="nav-link"><i class="nav-icon fas fa-th"></i>
                                <p>Overview Dashboard</p>
                            </a></li>
                        <li class="nav-item"><a href="/admin/approvals" class="nav-link"><i
                                    class="nav-icon fas fa-user-check"></i>
                                <p>Verifikasi Akun</p>
                            </a></li>
                        <li class="nav-item"><a href="/admin/students" class="nav-link"><i
                                    class="nav-icon fas fa-users text-info"></i>
                                <p>Peserta Aktif</p>
                            </a></li>
                        <li class="nav-item"><a href="/admin/classes" class="nav-link"><i
                                    class="nav-icon fas fa-chalkboard text-warning"></i>
                                <p>Kelola Kelas</p>
                            </a></li>
                        <li class="nav-header">LOGISTIK SOAL</li>
                        <li class="nav-item"><a href="/admin/vark" class="nav-link"><i
                                    class="nav-icon fas fa-database"></i>
                                <p>Kelola VARK</p>
                            </a></li>
                        <li class="nav-item"><a href="/admin/mslq" class="nav-link"><i
                                    class="nav-icon fas fa-database"></i>
                                <p>Kelola MSLQ</p>
                            </a></li>
                        <li class="nav-item"><a href="/admin/ams" class="nav-link"><i
                                    class="nav-icon fas fa-database"></i>
                                <p>Kelola AMS</p>
                            </a></li>
                        <li class="nav-header">SISTEM</li>
                        <li class="nav-item"><a href="/admin/settings" class="nav-link"><i
                                    class="nav-icon fas fa-toggle-on"></i>
                                <p>Status Kuisioner</p>
                            </a></li>
                        <li class="nav-item"><a href="/admin/logout" class="nav-link text-danger"><i
                                    class="nav-icon fas fa-power-off"></i>
                                <p>Keluar Admin</p>
                            </a></li>
                    </ul>
                </nav>
            </div>
        </aside>

        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>
                                <?= $title ?? 'Admin Dashboard' ?>
                            </h1>
                        </div>
                    </div>
                </div>
            </section>
            <section class="content">
                <div class="container-fluid">
                    <?php if (isset($_SESSION['success'])): ?>
                        <script>
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: '<?= htmlspecialchars($_SESSION['success']) ?>',
                                timer: 3000,
                                showConfirmButton: false,
                                toast: true,
                                position: 'top-end'
                            });
                        </script>
                        <?php unset($_SESSION['success']); ?>
                    <?php endif; ?>
                    <?php include __DIR__ . '/../layout/reminders.php'; ?>