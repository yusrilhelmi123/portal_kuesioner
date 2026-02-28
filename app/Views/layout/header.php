<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>POINTMARKET - Motivational Engine</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Custom Style -->
    <link rel="stylesheet" href="/css/style.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="/" class="nav-link">Home</a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/home/logout" role="button">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="/" class="brand-link">
                <span class="brand-text font-weight-light">POINTMARKET Engine</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex align-items-center">
                    <div class="image">
                        <?php if (isset($_SESSION['foto']) && $_SESSION['foto']): ?>
                            <img src="/uploads/profile/<?= $_SESSION['foto'] ?>" class="img-circle elevation-2"
                                style="width: 34px; height: 34px; object-fit: cover;" alt="User Image">
                        <?php else: ?>
                            <div class="bg-primary img-circle elevation-2 d-flex align-items-center justify-content-center"
                                style="width: 34px; height: 34px;">
                                <i class="fas fa-user-graduate text-xs"></i>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="info">
                        <a href="/dashboard/profile"
                            class="d-block text-sm font-weight-bold"><?= htmlspecialchars($_SESSION['nama'] ?? 'Guest') ?></a>
                        <small class="text-muted d-block" style="font-size: 10px;">NPM:
                            <?= htmlspecialchars($_SESSION['npm'] ?? '-') ?></small>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <li class="nav-item">
                            <a href="/dashboard" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Progres Saya</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/dashboard/profile" class="nav-link">
                                <i class="nav-icon fas fa-user-edit"></i>
                                <p>Profil Saya</p>
                            </a>
                        </li>
                        <li class="nav-header">KUESIONER</li>
                        <li class="nav-item">
                            <a href="/vark" class="nav-link">
                                <i class="nav-icon fas fa-book"></i>
                                <p>VARK Assessment</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/mslq" class="nav-link">
                                <i class="nav-icon fas fa-brain"></i>
                                <p>MSLQ Evaluation</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/ams" class="nav-link">
                                <i class="nav-icon fas fa-graduation-cap"></i>
                                <p>AMS Motivation</p>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Main content -->
            <section class="content" style="padding-top: 20px;">
                <div class="container-fluid">
                    <?php include __DIR__ . '/reminders.php'; ?>