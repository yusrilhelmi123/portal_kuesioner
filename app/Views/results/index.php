<?php include '../app/Views/layout/header.php'; ?>

<div class="row">
    <div class="col-lg-4 col-6">
        <div class="small-box bg-primary shadow">
            <div class="inner">
                <h3><?= $vark ?></h3>
                <p>Gaya Belajar (VARK)</p>
            </div>
            <div class="icon"><i class="fas fa-eye"></i></div>
        </div>
    </div>
    <div class="col-lg-4 col-6">
        <div class="small-box bg-info shadow">
            <div class="inner">
                <h3><?= $mslq ?></h3>
                <p>Skor MSLQ</p>
            </div>
            <div class="icon"><i class="fas fa-brain"></i></div>
        </div>
    </div>
    <div class="col-lg-4 col-12">
        <div class="small-box bg-success shadow">
            <div class="inner">
                <h3 style="text-transform: capitalize;"><?= $ams ?></h3>
                <p>Kategori Motivasi (AMS)</p>
            </div>
            <div class="icon"><i class="fas fa-flag"></i></div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card card-dark card-outline">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-code mr-1"></i> Data Profil Mahasiswa (Format JSON)</h3>
            </div>
            <div class="card-body">
                <p class="text-muted">Data ini siap diintegrasikan dengan sistem riset POINTMARKET.</p>
                <div class="bg-dark p-3 rounded shadow-sm">
                    <code class="text-success"><pre class="mb-0" style="color: #a9ffaf;"><?= $json ?></pre></code>
                </div>
            </div>
            <div class="card-footer text-right">
                <a href="/dashboard" class="btn btn-primary mr-1"><i class="fas fa-tachometer-alt mr-1"></i> Dashboard
                    Saya</a>
                <a href="/home/logout" class="btn btn-danger"><i class="fas fa-sign-out-alt mr-1"></i> Keluar</a>
            </div>
        </div>
</div>

<?php if (isset($_SESSION['quiz_success'])): ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            title: 'Terima Kasih!',
            html: 'Terima kasih telah berkontribusi dalam riset ini.<br>Data Anda akan digunakan untuk membantu mengoptimalkan proses pembelajaran mahasiswa.',
            icon: 'success',
            confirmButtonText: 'Lihat Hasil Saya',
            confirmButtonColor: '#007bff'
        });
    });
</script>
<?php unset($_SESSION['quiz_success']); endif; ?>

<?php include '../app/Views/layout/footer.php'; ?>