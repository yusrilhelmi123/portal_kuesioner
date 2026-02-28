<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>POINTMARKET - Motivational Engine</title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Outfit:300,400,600,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        :root {
            --primary: #004e92;
            --accent: #00a8cc;
            --dark: #1a1a1a;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background: #f8f9fa;
        }

        .hero-section {
            background: linear-gradient(135deg, rgba(0, 78, 146, 0.9), rgba(0, 168, 204, 0.8)), url('/landing_hero_bg_1772175948437.png');
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            align-items: center;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.2);
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .portal-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            transition: all 0.3s ease;
            cursor: pointer;
            height: 100%;
        }

        .portal-card:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-10px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
        }

        .icon-box {
            width: 80px;
            height: 80px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 2.5rem;
            color: var(--primary);
        }

        .btn-custom {
            border-radius: 50px;
            padding: 12px 35px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s;
        }

        .nav-glass {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .feature-icon {
            font-size: 2rem;
            margin-bottom: 1rem;
            color: var(--accent);
        }

        .footer {
            background: var(--dark);
            color: #888;
            padding: 40px 0;
        }

        .letter-spacing-2 {
            letter-spacing: 3px;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top nav-glass">
        <div class="container">
            <a class="navbar-brand font-weight-bold text-uppercase" href="#">
                <i class="fas fa-rocket mr-2 text-warning"></i> POINTMARKET
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#beranda">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#tentang">Tentang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-outline-light btn-sm ml-lg-3 px-4" href="/home/login_page">Masuk <i
                                class="fas fa-sign-in-alt ml-1"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section" id="beranda">
        <div class="hero-overlay"></div>
        <div class="container hero-content text-center">
            <h1 class="display-3 font-weight-bold mb-1 text-uppercase" data-aos="fade-up">POINTMARKET<br><small class="text-white-50" style="font-size: 0.5em;">Motivational Engine</small></h1>
            <h6 class="font-weight-light mb-5 text-uppercase letter-spacing-2" data-aos="fade-up" data-aos-delay="100">Psychometric Profiling & Assessment Gateway</h6>

            <div class="row justify-content-center mt-5">
                <div class="col-md-5 col-lg-4 mb-4" data-aos="zoom-in" data-aos-delay="200">
                    <div class="portal-card p-5" onclick="location.href='/home/login_page'">
                        <div class="icon-box">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                        <h3>Portal Mahasiswa</h3>
                        <p class="text-light mb-4 opacity-75">Akses pengisian kuesioner dan lihat profil belajar Anda
                            secara langsung.</p>
                        <span class="btn btn-light btn-custom">Mulai Sekarang</span>
                    </div>
                </div>

                <div class="col-md-5 col-lg-4 mb-4" data-aos="zoom-in" data-aos-delay="300">
                    <div class="portal-card p-5" onclick="location.href='/admin/login'">
                        <div class="icon-box">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <h3>Portal Admin/Dosen</h3>
                        <p class="text-light mb-4 opacity-75">Kelola data kelas, monitoring progres mahasiswa, dan
                            ekspor hasil riset.</p>
                        <span class="btn btn-outline-light btn-custom">Login Admin</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="py-5" id="tentang">
        <div class="container py-5">
            <div class="row align-items-center">
                <div class="col-lg-6" data-aos="fade-right">
                    <h2 class="font-weight-bold mb-4">Mengenali Potensi Mahasiswa Melalui Data Psikometrik</h2>
                    <p class="text-muted lead">Platform ini dirancang untuk membantu pengajar mengidentifikasi
                        karakteristik belajar mahasiswa secara ilmiah, mencakup gaya belajar, strategi kognitif, dan
                        motivasi akademik.</p>
                    <div class="row mt-4">
                        <div class="col-md-4 text-center">
                            <i class="fas fa-eye feature-icon"></i>
                            <h5 class="font-weight-bold">VARK</h5>
                            <p class="small text-muted">Gaya belajar Visual, Aural, Read, & Kinesthetic.</p>
                        </div>
                        <div class="col-md-4 text-center">
                            <i class="fas fa-brain feature-icon"></i>
                            <h5 class="font-weight-bold">MSLQ</h5>
                            <p class="small text-muted">Strategi serta motivasi belajar mandiri mahasiswa.</p>
                        </div>
                        <div class="col-md-4 text-center">
                            <i class="fas fa-graduation-cap feature-icon"></i>
                            <h5 class="font-weight-bold">AMS</h5>
                            <p class="small text-muted">Klasifikasi motivasi akademik secara spesifik.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mt-5 mt-lg-0 text-center" data-aos="fade-left">
                    <img src="https://img.freepik.com/free-vector/digital-lifestyle-concept-illustration_114360-7327.jpg"
                        alt="Illustration" class="img-fluid rounded" style="max-height: 400px;">
                </div>
            </div>
        </div>
    </section>

    <footer class="footer text-center">
        <div class="container">
            <p class="mb-1">&copy; 2026 Riset Fundamental - Lab Riset PM.</p>
            <p class="mb-2 font-weight-bold text-light">M. Yusril Helmi Setyawan</p>
            <div class="mt-3">
                <a href="#" class="text-muted mx-2"><i class="fab fa-facebook"></i></a>
                <a href="#" class="text-muted mx-2"><i class="fab fa-twitter"></i></a>
                <a href="#" class="text-muted mx-2"><i class="fab fa-instagram"></i></a>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 1000,
            once: true
        });

        // Custom smooth scrolling
        $(document).on('click', 'a[href^="#"]', function (event) {
            event.preventDefault();
            $('html, body').animate({
                scrollTop: $($.attr(this, 'href')).offset().top - 70
            }, 800);
        });
    </script>
</body>

</html>