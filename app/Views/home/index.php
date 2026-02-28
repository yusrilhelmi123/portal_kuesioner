<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>POINTMARKET - Motivational Engine</title>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
</head>

<body class="hold-transition login-page bg-light">
    <div class="login-box" style="width: 450px;">
        <div class="login-logo">
            <a href="/"><b>POINT</b>MARKET</a>
        </div>
        <!-- /.login-logo -->
        <div class="card card-outline card-primary shadow-lg">
            <div class="card-body login-card-body rounded">
                <p class="login-box-msg text-bold">Sistem Kuisioner Riset PM</p>

                <?php if (isset($error)): ?>
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <i class="icon fas fa-ban"></i> <?= $error ?>
                    </div>
                <?php endif; ?>

                <?php if (isset($success)): ?>
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <i class="icon fas fa-check"></i> <?= $success ?>
                    </div>
                <?php endif; ?>

                <div id="login-form">
                    <form action="/home/login" method="post">
                        <div class="input-group mb-3">
                            <input type="text" name="npm" class="form-control" placeholder="NPM" required>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-id-card"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" name="password" class="form-control" placeholder="Password" required>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-block">Masuk ke Sistem</button>
                            </div>
                        </div>
                    </form>
                    <p class="mb-0 mt-3 text-center">
                        Belum punya akun? <a href="#" onclick="toggleForm('register')" class="text-center">Daftar
                            Mahasiswa Baru</a>
                    </p>
                </div>

                <div id="register-form" style="display: none;">
                    <form action="/home/register" method="post">
                        <div class="input-group mb-3">
                            <input type="text" name="nama" class="form-control" placeholder="Nama Lengkap" required>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-user"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input type="text" name="npm" class="form-control" placeholder="NPM" required>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-id-card"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" name="password" class="form-control" placeholder="Password" required>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-success btn-block">Daftar Akun</button>
                            </div>
                        </div>
                    </form>
                    <p class="mb-0 mt-3 text-center">
                        Sudah terdaftar? <a href="#" onclick="toggleForm('login')" class="text-center">Kembali ke
                            Login</a>
                    </p>
                </div>

                <div class="mt-4 text-center">
                    <a href="/" class="text-muted small"><i class="fas fa-arrow-left mr-1"></i> Kembali ke Beranda</a>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleForm(type) {
            if (type === 'register') {
                $('#login-form').hide();
                $('#register-form').fadeIn();
            } else {
                $('#register-form').hide();
                $('#login-form').fadeIn();
            }
        }
    </script>
</body>

</html>